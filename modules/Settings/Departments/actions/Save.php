<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
vimport('~~/vtlib/Vtiger/Net/Client.php');
class Settings_Departments_Save_Action extends Vtiger_Action_Controller {
	
	public function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if(!$currentUser->isAdminUser()) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}

	public function process(Vtiger_Request $request) {
        //file_put_contents("log.txt", "------group--department--".$request->get('companyId'), FILE_APPEND);die;
       // file_put_contents("log.txt", "------group--data_string--".var_export($request,true), FILE_APPEND);
        global $xmppeditgroup_URL,$xmppcreategroup_URL,$chat_URL,$xmpp_host,$rpc_server,$rpc_account_host;
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$recordId = $request->get('record');
		$departmentName = $request->get('rolename');
        $parentRoleId = $request->get('parent_roleid');
        $synlhc = $request->get('synlhc');
        $companyId = $request->get('companyId');
		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
        if($companyId)
            $companyName = ITS4YouMultiCompany_Record_Model::getInstanceById($companyId)->getName();
        else
            $companyName = '总公司';
        //file_put_contents("log.txt", "------group--xmppeditgroup_URL--".$companyName, FILE_APPEND);

		if(!empty($recordId)) {
			$recordModel = Settings_Departments_Record_Model::getInstanceById($recordId);
            $olddepartment = $recordModel->get("departmentname");
            if($departmentName!=$olddepartment){
                $status = $recordModel->checkDuplicateDepartment($departmentName, $companyId);
                if ($status == true) {
                    throw new AppException(vtranslate('LBL_DUPLICATE_USER_EXISTS', $moduleName));
                }
            }
		} else {
			$recordModel = new Settings_Departments_Record_Model();
            $status = $recordModel->checkDuplicateDepartment($departmentName, $companyId);
            if ($status == true) {
                throw new AppException(vtranslate('LBL_DUPLICATE_USER_EXISTS', $moduleName));
            }
		}

		if($recordModel && !empty($parentRoleId)) {
			$recordModel->set('allowassignedrecordsto', 1); // set the value of assigned records to
            $parent = Settings_Departments_Record_Model::getInstanceById($parentRoleId);
            $recordModel->setParent($parent);
            $recordModel->set("departmentname",$departmentName);
            $recordModel->set("synlhc",$synlhc);
            $recordModel->set("companyId",$companyId);
            $recordModel->save();
            //如果部门名称修改了，则修改相应用户的部门名称
            if($olddepartment!=$departmentName){
                $recordModel->updateUsersDepartment($departmentName,$olddepartment);
            }
            //同步到lhc
            if($synlhc==1){
                $resultextend = $recordModel->getAllApply();//获取所有开通应用
                foreach ($resultextend as $key=>$val){

                    if($recordId){
                        $url = $val['appurl'].'/index.php/restapi/editdepartment';
                        $client = new Vtiger_Net_Client($url);
                        $appuserresult = $recordModel->getOutApplyDepartmentId($val['id']);
                        $parameter['id']=$appuserresult[0]['outdepartmentid'];
                        $parameter['Name']=$departmentName;
                        $parameter['product_configuration']=array('products_enabled'=>1,'products_required'=>0);
                    }else{
                        $url = $val['appurl'].'/index.php/restapi/adddepartment';
                        $client = new Vtiger_Net_Client($url);
                        $parameter['Name']=$departmentName;
                        $parameter['product_configuration']=array('products_enabled'=>1,'products_required'=>0);
                    }

                    $hearder = "211111 ". $val['appkey'];
                    $client->setHeaders(array(
                        'Authorization'  => $hearder
                    ));

                    $clientresut = $client->doPost($parameter);

                    if(!$recordId){
                        $ctresult = json_decode($clientresut,true);
                        $recordModel->saveApplyDepartmentId($recordModel->getId(),$ctresult['Departamentid'],$val['id']);
                    }
                }
            }
            //修改聊天室的部门信息
            if($recordId){
                //xmpp
                $data['subdomain'] = "";
                $data['node_api_server'] = "";
                $data['xmpp_host'] = $xmpp_host;
                $data['handler'] = "rpc";
                $data['rpc_server'] = $rpc_server;
                $data['rpc_account_host'] = $rpc_account_host;
                $data['rpc_username'] = "testxmpp";
                $data['rpc_password'] = "397126845";
                $groupid = "dep_".$recordId;
                $data['group'] = strtolower($groupid);
                $togroupid = "dep_".$recordId;
                $data['togroup'] = strtolower($togroupid);
                $data['name'] = $departmentName;
                $data['departs'] = array();
                $data_string = json_encode($data);
                //file_put_contents("log.txt", "------group--data_string--".$data_string, FILE_APPEND);
                $ch = curl_init($xmppeditgroup_URL);
                //file_put_contents("log.txt", "------group--xmppeditgroup_URL--".$xmppeditgroup_URL, FILE_APPEND);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                $result = curl_exec($ch);
                curl_close($ch);
                //file_put_contents("log.txt", "------group--xmppeditgroup_URL--".var_export($result), FILE_APPEND);


            }else{
                //添加聊天室
                //xmpp
                $data['subdomain'] = "";
                $data['node_api_server'] = "";
                $data['xmpp_host'] = $xmpp_host;
                $data['handler'] = "rpc";
                $data['rpc_server'] = $rpc_server;
                $data['rpc_account_host'] = $rpc_account_host;
                $data['rpc_username'] = "testxmpp";
                $data['rpc_password'] = "397126845";
                $groupid = "dep_".$recordModel->getId();
                $data['group'] = strtolower($groupid);
                $data['departs'] =strtolower($groupid);
                $data['name'] = $departmentName;
                $data['chatopen'] = true;
                $data_string = json_encode($data);
                file_put_contents("log.txt", "------group--xmppcreategroup_URL--".$data_string, FILE_APPEND);
                $ch = curl_init($xmppcreategroup_URL);
                //file_put_contents("log.txt", "------group--xmppcreategroup_URL--".$xmppcreategroup_URL, FILE_APPEND);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                $result = curl_exec($ch);
                curl_close($ch);
//                file_put_contents("log.txt", "------company-----getout----3--".var_export($createtresut,true), FILE_APPEND);
            }

            if(empty($olddepartment) || $olddepartment==$departmentName) {
                //获取父节点
                if ($companyId) {
                    $post = array('departmentName' => $departmentName, 'outRelaId' => 'vtiger_com_' . $companyId);//参数
                } else {
                    if ($parent->getDepth() > 1) {
                        $post = array('departmentName' => $parent->getName(), 'outRelaId' => 'vtiger_com');//参数
                    } else {
                        $post = array('departmentName' => $departmentName, 'outRelaId' => 'vtiger_com');//参数
                    }
                }
                file_put_contents("log.txt", "------post----3--" . var_export($post, true), FILE_APPEND);
                $searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
                $client = new Vtiger_Net_Client($searchUrl);
                $clientresut = $client->doPost($post);

                file_put_contents("log.txt", "------department-----getout----3--" . var_export($clientresut, true), FILE_APPEND);
                //file_put_contents("log.txt", "------company-----getout----1--".$clientresut, FILE_APPEND);
                $searchresult = json_decode($clientresut, true);
                $parentId = $searchresult['data']['departments'][0]['departmentId'] != '' ? $searchresult['data']['departments'][0]['departmentId'] : $searchresult['data']['rootDpartId'][0];
                $companyId = $searchresult['data']['companyId'];
                //创建部门
                $departmentcreateurl = $chat_URL . "org/department/create";
                $client = new Vtiger_Net_Client($departmentcreateurl);
                $post = array('companyId' => $companyId, 'parentId' => $parentId, 'departName' => $departmentName, 'createUserId' => '10000', 'userId' => '10000');
                file_put_contents("log.txt", "------post----create--" . var_export($post, true), FILE_APPEND);
                $createtresut = $client->doPost($post);
                $createtresut = json_decode($createtresut, true);
                file_put_contents("log.txt", "------company-----getout----2.2--" . $createtresut, FILE_APPEND);
            }elseif(!empty($olddepartment) && $olddepartment!=$departmentName){
                file_put_contents("log.txt", "------company-----getout----2.2--" . $olddepartment.'|'.$departmentName, FILE_APPEND);
                if ($companyId) {
                    $post = array('departmentName' => $olddepartment, 'outRelaId' => 'vtiger_com_' . $companyId);//参数
                } else {
                    $post = array('departmentName' => $olddepartment, 'outRelaId' => 'vtiger_com');//参数
                }
                $searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
                $client = new Vtiger_Net_Client($searchUrl);
                $clientresut = $client->doPost($post);
                $searchresult = json_decode($clientresut, true);
                if($searchresult['data']['departments'][0]['departmentId']){
                    $modifyUrl = $chat_URL . 'org/department/modify';
                    $post = array('userId' => 10000, 'departmentId' => $searchresult['data']['departments'][0]['departmentId'], 'dpartmentName' => $departmentName);
                    $client = new Vtiger_Net_Client($modifyUrl);
                    $clientresut = $client->doPost($post);
                    file_put_contents("log.txt", "------company-----getout----2.2--" . var_export($clientresut, true), FILE_APPEND);

                    // 如何room存在还需要修改room的名称
                    $roomListUrl = $chat_URL . 'room/list';
                    $post = array('roomName' => $companyName.'-'.$olddepartment);
                    $client = new Vtiger_Net_Client($roomListUrl);
                    $clientresut = $client->doPost($post);
                    $clientresut = json_decode($clientresut, true);
                    file_put_contents("log.txt", "-----user-get-room--".var_export($clientresut,true), FILE_APPEND);
                    foreach($clientresut as $r){
                        if($r['jid'] == $recordId){
                            // 说明已经存在该房间,可以修改名称
                            $modifyRoomUrl = $chat_URL . '/room/update';
                            $post = array('roomId' => $r['id'], 'roomName' => $companyName.'-'.$departmentName, 'desc' => $companyName.'-'.$departmentName);
                            $client = new Vtiger_Net_Client($modifyRoomUrl);
                            $clientresut = $client->doPost($post);
                            file_put_contents("log.txt", "-----user-modify-room--".var_export($clientresut,true), FILE_APPEND);
                        }
                    }
                }
            }
		}

		$redirectUrl = $moduleModel->getDefaultUrl();
		header("Location: $redirectUrl");
	}
    
    public function validateRequest(Vtiger_Request $request) {
        $request->validateWriteAccess();
    }
}
