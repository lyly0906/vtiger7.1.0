<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
class Documents_ParentList_Action extends Vtiger_Action_Controller {
	public function checkPermission(Vtiger_Request $request) {
		return;
	}
	public function process(Vtiger_Request $request){
		$id = $request->get('id');
		$folderList = Documents_Module_Model::getFoldersByParentid($id);
        foreach($folderList as $k=>$r){
			$listfolder[$k]['foldername'] = $r->get('foldername');
			$listfolder[$k]['folderid'] = $r->get('folderid');
		}
		$response = new Vtiger_Response();
		//$departments = json_encode($departments);
		$response->setResult($listfolder);
		$response->emit();
	}

}