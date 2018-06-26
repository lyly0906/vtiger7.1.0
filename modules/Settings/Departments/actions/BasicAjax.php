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
class Settings_Departments_BasicAjax_Action extends Vtiger_Action_Controller {

	public function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		global $chat_URL;
		$moduleName = $request->get('module');
		$rolename = $request->get('rolename');
		$roleAtt = Settings_Roles_Record_Model::getInstanceByName($rolename);
		$roleid = $roleAtt->getId();

		$its4you_company = 0;
		if($roleid != 'H2'){
			$roleInfo = getRoleInformation($roleid);
			$parentRole = explode('::',$roleInfo[$roleid][1])[2];
			$its4you_company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($parentRole)->getId();
			$outRelaId = 'vtiger_com_'.$its4you_company;
		}else{
			$outRelaId = 'vtiger_com';
		}

		$post = array('outRelaId' => $outRelaId);//参数

		$searchUrl = $chat_URL . "org/company/getout";//查找公司是否存在的url
		$client = new Vtiger_Net_Client($searchUrl);
		$clientresut = $client->doPost($post);
		$searchresult = json_decode($clientresut, true);
		$chatDepartments = $searchresult['data']['departments'];

        $departmentResult = Settings_Departments_Record_Model::getAll();

        $departments = array();
		foreach ($departmentResult as $key=>$val){
			if($val->get("its4you_company") == $its4you_company){
				$department['name'] = $val->get("departmentname");
				$department['depth'] = $val->get("depth");
				$department['company'] = $val->get("its4you_company");
				$department['isshow'] = 0;
				foreach($chatDepartments as $r){
					if($department['name'] == $r['departmentName']){
						$department['isshow'] = 1;
					}
				}
				$departments[] =$department;
			}

		}
		$response = new Vtiger_Response();
        //$departments = json_encode($departments);
		$response->setResult($departments);
		$response->emit();
	}
}

?>
