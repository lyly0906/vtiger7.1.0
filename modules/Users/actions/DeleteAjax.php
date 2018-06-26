<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
vimport('~~/include/Webservices/Custom/DeleteUser.php');
vimport('~~/vtlib/Vtiger/Net/Client.php');
class Users_DeleteAjax_Action extends Vtiger_Delete_Action {

	public function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		 $ownerId = $request->get('userid');
		if(!$currentUser->isAdminUser()) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
		} else if($currentUser->isAdminUser() && ($currentUser->getId() == $ownerId)) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
		}
	}
	
	public function process(Vtiger_Request $request) {
        global $chat_URL;
		$moduleName = $request->getModule();
        $ownerId = $request->get('userid');
        $newOwnerId = $request->get('transfer_user_id');
        
        $mode = $request->get('mode');
        $response = new Vtiger_Response();
        $result['message'] = vtranslate('LBL_USER_DELETED_SUCCESSFULLY', $moduleName);

		if($mode == 'permanent'){
            Users_Record_Model::deleteUserPermanently($ownerId, $newOwnerId);
        } else {
            $userId = vtws_getWebserviceEntityId($moduleName, $ownerId);
            $transformUserId = vtws_getWebserviceEntityId($moduleName, $newOwnerId);

            $userModel = Users_Record_Model::getCurrentUserModel();

            vtws_deleteUser($userId, $transformUserId, $userModel);

            if($request->get('permanent') == '1') {
                /*********增加同步删除chat的账户******/
                $userModel->set('id', $ownerId);
                $userinfo = $userModel->getUserInfo();

                if($userinfo['roleid'] != 'H2'){
                    $roleInfo = getRoleInformation($userinfo['roleid']);
                    $parentRole = explode('::',$roleInfo[$userinfo['roleid']][1])[2];
                    $its4you_company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($parentRole)->getId();
                    $outRelaId = 'vtiger_com_'.$its4you_company;
                }else{
                    $outRelaId = 'vtiger_com';
                }

                /*********增加同步删除chat的账户******/
                $phone_mobile = $userinfo['phone_mobile'];

                $originUrl = $chat_URL.'user/queryByPhone';
                $post = array('phone' => $phone_mobile);
                $client = new Vtiger_Net_Client($originUrl);
                $clientresut = $client->doPost($post);
                $clientresut = json_decode($clientresut,true);
                $userId = $clientresut['data']['userId'];
                file_put_contents("log.txt", "-----user-get--".var_export($userinfo, true), FILE_APPEND);
                if($clientresut['data']['userId']){
                    // 删除员工及所在room的成员
                    $url = $chat_URL.'user/deleteUserByTB';
                    $post = array('userId' => $clientresut['data']['userId'], 'pageIndex' => 1);
                    $client = new Vtiger_Net_Client($url);
                    $clientresut = $client->doGet($post);
                    file_put_contents("log.txt", "-----user-del--".var_export($post, true), FILE_APPEND);
                    // 删除所在部门的员工信息
                    $post = array('departmentName' => $userinfo['department'], 'outRelaId' => $outRelaId);//参数
                    $searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
                    $client = new Vtiger_Net_Client($searchUrl);
                    $clientresut = $client->doPost($post);
                    $createtresut = json_decode($clientresut, true);
                    file_put_contents("log.txt", "-----user-del-department-".var_export($createtresut, true), FILE_APPEND);
                    $departmentId = $createtresut['data']['departments'][0]['departmentId'];

                    if($departmentId){
                        $delUrl = $chat_URL . "org/employee/delete";
                        $post = 'userIds='.$userId.'&departmentId='.$departmentId;
                        $client = new Vtiger_Net_Client($delUrl);
                        $clientresut = $client->doPost($post);
                        file_put_contents("log.txt", "-----user-del-department-".var_export($post, true), FILE_APPEND);
                    }
                }
                /*********增加同步删除chat的账户******/
                Users_Record_Model::deleteUserPermanently($ownerId, $newOwnerId);


            }    
        }
        
        if($request->get('mode') == 'deleteUserFromDetailView'){
            $usersModuleModel = Users_Module_Model::getInstance($moduleName);
            $listViewUrl = $usersModuleModel->getListViewUrl();
            $result['listViewUrl'] = $listViewUrl;
        }
		
		$response->setResult($result);
		$response->emit();
	}
}
