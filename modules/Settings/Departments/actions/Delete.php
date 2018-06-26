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
class Settings_Departments_Delete_Action extends Settings_Vtiger_Basic_Action {

	public function process(Vtiger_Request $request) {
        global $xmpp_URL;

		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$recordId = $request->get('record');
		$transferRecordId = $request->get('transfer_record');

		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$recordModel = Settings_Departments_Record_Model::getInstanceById($recordId);
		$transferToRole = Settings_Departments_Record_Model::getInstanceById($transferRecordId);
		if($recordModel && $transferToRole) {
		    //先把该聊天室的用户转移到目标聊天室
            $listUser = $recordModel->getUsers();
            foreach($listUser as $key=>$val) {
                $data['subdomain'] = "";
                $data['node_api_server'] = "";
                $data['xmpp_host'] = "crm.ulync.cn";
                $data['handler'] = "rpc";
                $data['rpc_server'] = "http://117.34.80.209:4560";
                $data['rpc_account_host'] = "vtiger.club";
                $data['rpc_username'] = "testxmpp";
                $data['rpc_password'] = "397126845";
                $data['user'] = strtolower($val->get("user_name"));
                $data['setchat'] = true;
                $groupid = "dep_".$recordId;
                $data['group'] = strtolower($groupid);
                $togroupid = "dep_".$transferRecordId;
                $data['togroup'] = strtolower($togroupid);
                $data['name'] = $transferToRole->getName();
                $data_string = json_encode($data);
                $ch = curl_init($xmpp_URL);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                $result = curl_exec($ch);
                curl_close($ch);
            }
            $recordModel->updateUsersDepartment($transferToRole->getName(),$recordModel->getName());
			$recordModel->delete($transferToRole);
		}
		$redirectUrl = $moduleModel->getDefaultUrl();
		header("Location: $redirectUrl");
	}
    
    public function validateRequest(Vtiger_Request $request) {
        $request->validateWriteAccess();
    }
}
