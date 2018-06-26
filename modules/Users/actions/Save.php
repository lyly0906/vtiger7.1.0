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
class Users_Save_Action extends Vtiger_Save_Action {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if(!Users_Privileges_Model::isPermitted($moduleName, 'Save', $record) || ($recordModel->isAccountOwner() && 
							$currentUserModel->get('id') != $recordModel->getId() && !$currentUserModel->isAdminUser())) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param Vtiger_Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	public function getRecordModelFromRequest(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$currentUserModel = Users_Record_Model::getCurrentUserModel();

		if(!empty($recordId)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('id', $recordId);
			$sharedType = $request->get('sharedtype');
			if(!empty($sharedType))
				$recordModel->set('calendarsharedtype', $request->get('sharedtype'));
			$recordModel->set('mode', 'edit');
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('mode', '');
		}

		foreach ($modelData as $fieldName => $value) {
			$requestFieldExists = $request->has($fieldName);
			if(!$requestFieldExists){
				continue;
			}
			$fieldValue = $request->get($fieldName, null);
			if ($fieldName === 'is_admin' && (!$currentUserModel->isAdminUser() || !$fieldValue)) {
				$fieldValue = 'off';
			}
			//to not update is_owner from ui
			if ($fieldName == 'is_owner') {
				$fieldValue = null;
			}
			if($fieldValue !== null) {
				if(!is_array($fieldValue)) {
					$fieldValue = trim($fieldValue);
				}
				$recordModel->set($fieldName, $fieldValue);
			}
		}
		$homePageComponents = $recordModel->getHomePageComponents();
		$selectedHomePageComponents = $request->get('homepage_components', array());
		foreach ($homePageComponents as $key => $value) {
			if(in_array($key, $selectedHomePageComponents)) {
				$request->setGlobal($key, $key);
			} else {
				$request->setGlobal($key, '');
			}
		}
		if($request->has('tagcloudview')) {
			// Tag cloud save
			$tagCloud = $request->get('tagcloudview');
			if($tagCloud == "on") {
				$recordModel->set('tagcloud', 0);
			} else {
				$recordModel->set('tagcloud', 1);
			}
		}
		return $recordModel;
	}

	public function process(Vtiger_Request $request) {
		global $chat_URL;
		$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
		$_FILES = $result['imagename'];
		$userdepartment = $request->get("department");

		$recordId = $request->get('record');




		if (!$recordId) {
			$module = $request->getModule();
			$userName = $request->get('user_name');
			$phone = $request->get('phone_mobile');
			$email = $request->get('email1');
			$userModuleModel = Users_Module_Model::getCleanInstance($module);
			$status = $userModuleModel->checkDuplicateUser($userName);
			if ($status == true) {
				throw new AppException(vtranslate('LBL_DUPLICATE_USER_EXISTS', $module));
			}
			$status = $userModuleModel->checkDuplicateUserPhone($phone);
			if ($status == true) {
				throw new AppException(vtranslate('LBL_DUPLICATE_PHONE_EXISTS', $module));
			}
			$status = $userModuleModel->checkDuplicateUserEmail($email);
			if ($status == true) {
				throw new AppException(vtranslate('LBL_DUPLICATE_EMAIL_EXISTS', $module));
			}
		}
		$its4you_company = 0;
		$roleid = $request->get('roleid');
		if($roleid != 'H2'){
			$roleInfo = getRoleInformation($request->get('roleid'));
			$parentRole = explode('::',$roleInfo[$request->get('roleid')][1])[2];
			$its4you_company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($parentRole)->getId();
			$its4you_company_name = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($parentRole)->getName();
			$outRelaId = 'vtiger_com_'.$its4you_company;
		}else{
			$outRelaId = 'vtiger_com';
			$its4you_company_name = '总公司';
		}

		$tempmode = new Users_Record_Model();
		$userdepartmentid = $tempmode->getDepartmentIdByDepartmentName($userdepartment, $its4you_company);
		$request->set('department', $userdepartmentid);

		if ($recordId) {
			$tempmode->set('id', $recordId);
			$userinfo = $tempmode->getUserInfo();
			$olddepartment = Settings_Departments_Record_Model::getInstanceById($userinfo["department"])->get("departmentname");
		}

		$recordModel = $this->saveRecord($request);

		if ($request->get('relationOperation')) {
			$parentRecordModel = Vtiger_Record_Model::getInstanceById($request->get('sourceRecord'), $request->get('sourceModule'));
			$loadUrl = $parentRecordModel->getDetailViewUrl();
		} else if ($request->get('isPreference')) {
			$loadUrl =  $recordModel->getPreferenceDetailViewUrl();
		} else if ($request->get('returnmodule') && $request->get('returnview')){
			$loadUrl = 'index.php?'.$request->getReturnURL();
		} else if($request->get('mode') == 'Calendar'){
			$loadUrl = $recordModel->getCalendarSettingsDetailViewUrl();
		}else {
			$loadUrl = $recordModel->getDetailViewUrl();
		}


		//视酷聊天同步用户
		if(!$recordId){
			//用户注册
			$url = $chat_URL.'user/register';
			$str = $request->get('last_name').$request->get('first_name');
			if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$str)) {
				$nickname =  $str;
			} else {
				$nickname =  $request->get('first_name').' '.$request->get('last_name');
			}
			$telephone = $request->get("phone_mobile");

			$post = array('telephone' => $telephone, 'password' => md5($request->get("user_password")), 'nickname' =>$nickname, 'sex' => 1, 'cityId' => 0);
			file_put_contents("log.txt", "-----user-add--".var_export($post,true), FILE_APPEND);
			$client = new Vtiger_Net_Client($url);
			$clientresut = $client->doPost($post);
			file_put_contents("log.txt", "-----user-add111--".$clientresut, FILE_APPEND);
			$clientresut = json_decode($clientresut,true);
			file_put_contents("log.txt", "-----user-add222--".var_export($clientresut,true), FILE_APPEND);
			$userId = $clientresut['data']['userId'];
			// 添加用户成功后，还需要增加所在部门有没有添加，没有则先添加部门
			$post = array('departmentName' => $userdepartment, 'outRelaId' => $outRelaId);//参数

			$searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
			$client = new Vtiger_Net_Client($searchUrl);
			$clientresut = $client->doPost($post);

			//file_put_contents("log.txt", "------company-----getout----1--".$clientresut, FILE_APPEND);
			$searchresult = json_decode($clientresut, true);
			if(empty($searchresult['data']['departments'])){
				$parentId = $searchresult['data']['departments'][0]['departmentId'] != '' ? $searchresult['data']['departments'][0]['departmentId'] : $searchresult['data']['rootDpartId'][0];
				$companyId = $searchresult['data']['companyId'];
				//创建部门
				$departmentcreateurl = $chat_URL . "org/department/create";
				$client = new Vtiger_Net_Client($departmentcreateurl);
				$post = array('companyId' => $companyId, 'parentId' => $parentId, 'departName' => $userdepartment, 'createUserId' => '10000', 'userId' => '10000');
				file_put_contents("log.txt", "------post----create--" . var_export($post, true), FILE_APPEND);
				$createtresut = $client->doPost($post);
				$createtresut = json_encode($createtresut, true);
				file_put_contents("log.txt", "------company-----getout----2.2--" . $createtresut, FILE_APPEND);
			}



			$adddepartmenturl = $chat_URL.'org/employee/addout';
			//outRelaId=vtiger_com_1&departmentName=研发部&role=1&jid=dep_3&name=研发部&desc=研发部&text=["10000042"]&userId=10000042
			$post = array('outRelaId' => $outRelaId, 'departmentName' => $userdepartment, 'role' =>1, 'jid' => $userdepartmentid, 'name' => $its4you_company_name.'-'.$userdepartment,'desc'=>$its4you_company_name.'-'.$userdepartment,'userId'=>$userId);
			$client = new Vtiger_Net_Client($adddepartmenturl);
			$clientresut = $client->doPost($post);
			$clientresut = json_decode($clientresut,true);
			file_put_contents("log.txt", "-----user-depart--".var_export($clientresut,true), FILE_APPEND);
		}else {
			// 判断修改用户时，chat没有则新增
			if($userinfo['roleid'] != 'H2'){
				$roleInfo = getRoleInformation($userinfo['roleid']);
				$parentRole = explode('::',$roleInfo[$userinfo['roleid']][1])[2];
				$its4you_company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($parentRole)->getId();
				$outRelaId = 'vtiger_com_'.$its4you_company;
			}else{
				$outRelaId = 'vtiger_com';
			}

			$post = array('outRelaId' => $outRelaId, 'departmentName' => $userdepartment);//参数
			$searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
			$client = new Vtiger_Net_Client($searchUrl);
			$clientresut = $client->doPost($post);
			//file_put_contents("log.txt", "------company-----getout----1--".$clientresut, FILE_APPEND);
			$searchresult = json_decode($clientresut, true);
			$companyId = $searchresult['data']['companyId'];
			$newDepartmentId = $searchresult['data']['departments'][0]['departmentId'];

			$phone_mobile = $userinfo['phone_mobile'];

			$originUrl = $chat_URL.'user/queryByPhone';
			$post = array('phone' => $phone_mobile);
			$client = new Vtiger_Net_Client($originUrl);
			$clientresut = $client->doPost($post);
			$clientresut = json_decode($clientresut,true);
			$userId = $clientresut['data']['userId'];
			if(!empty($userId)){
				//为空则增加
				file_put_contents("log.txt", "-----user-get--".$olddepartment.'|'.$userdepartment, FILE_APPEND);
				if($olddepartment != $userdepartment){
					$modifyUrl = $chat_URL . 'org/employee/modifyDpart';
					$post = array('userId' => $userId, 'companyId' => $companyId, 'newDepartmentId' => $newDepartmentId);
					$client = new Vtiger_Net_Client($modifyUrl);
					$clientresut = $client->doPost($post);
					file_put_contents("log.txt", "-----user-get--".var_export($clientresut,true), FILE_APPEND);

					//更换房间
					$modifyUrl = $chat_URL . 'room/list/his';
					$post = array('userId' => $userId);
					$client = new Vtiger_Net_Client($modifyUrl);
					$clientresut = $client->doPost($post);
					$clientresut = json_decode($clientresut,true);
					file_put_contents("log.txt", "-----user-del-room--".var_export($clientresut,true), FILE_APPEND);
					$roomId = $clientresut['data'][0]['id'];
					if($roomId){
						$delMemberUrl = $chat_URL . 'room/member/delete';
						$post = array('roomId' => $roomId, 'userId' => $userId);
						$client = new Vtiger_Net_Client($delMemberUrl);
						$clientresut = $client->doPost($post);
						file_put_contents("log.txt", "-----user-del-room--".var_export($clientresut,true), FILE_APPEND);

						//判断新的房间是否存在，不存在直接创建并加入
						$roomUrl = $chat_URL . 'room/list';
                        $post = array('roomName' => $its4you_company_name.'-'.$userdepartment);
						$client = new Vtiger_Net_Client($roomUrl);
						$clientresut = $client->doPost($post);
						$clientresut = json_decode($clientresut,true);
						file_put_contents("log.txt", "-----user-get-room--".var_export($clientresut,true), FILE_APPEND);
						$create = 1;
						foreach($clientresut['data'] as $r){
							if($r['jid'] == $userdepartmentid){
								// 说明已经存在该房间
								$create = 0;
								$joinRoomUrl = $chat_URL . '/room/member/update';
								$post = array('roomId' => $r['id'], 'userId' => $userId);
								$client = new Vtiger_Net_Client($joinRoomUrl);
								$clientresut = $client->doPost($post);
								file_put_contents("log.txt", "-----user-join-room--".var_export($clientresut,true), FILE_APPEND);
							}
						}
						//需要创建room并直接加入
						if($create){
							$createUrl = $chat_URL . 'room/add';
							$post = array('jid' => $userdepartmentid, 'name' => $its4you_company_name.'-'.$userdepartment, 'desc' => $its4you_company_name.'-'.$userdepartment, 'userId' => $userId, 'isadmin' => 1);
							$client = new Vtiger_Net_Client($createUrl);
							$clientresut = $client->doPost($post);
							file_put_contents("log.txt", "-----user-create-room--".var_export($clientresut,true), FILE_APPEND);
						}
					}
				}
			}
		}


		header("Location: $loadUrl");
	}
}
