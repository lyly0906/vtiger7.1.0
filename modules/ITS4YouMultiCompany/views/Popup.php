<?php
/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

class ITS4YouMultiCompany_Popup_View extends Vtiger_Footer_View {
    function checkPermission(Vtiger_Request $request) {
        return true;
    }

    function process (Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $moduleName = $request->getModule();
        $qualifiedModuleName = $request->getModule(false);

        $sourceRecord = $request->get('src_record');

        $companyDetails = Vtiger_CompanyDetails_Model::getInstanceById();
        $companyLogo = $companyDetails->getLogo();

        $sourceRole = Settings_Roles_Record_Model::getInstanceById($sourceRecord);
        $rootRole = Settings_Roles_Record_Model::getBaseRole();
        $allRoles = Settings_Roles_Record_Model::getAll();

        $viewer->assign('SOURCE_ROLE', $sourceRole);
        $viewer->assign('ROOT_ROLE', $rootRole);
        $viewer->assign('ROLES', $allRoles);

        $viewer->assign("USED_ROLES", ITS4YouMultiCompany_CustomRecordNumbering_Model::getUsedRoles());

        $viewer->assign('MODULE_NAME',$moduleName);
        $viewer->assign('COMPANY_LOGO',$companyLogo);
        $viewer->assign("MODULE_NAME", $moduleName);

        $viewer->view('Popup.tpl', $qualifiedModuleName);
    }

    /**
     * Function to get the list of Script models to be included
     * @param Vtiger_Request $request
     * @return <Array> - List of Vtiger_JsScript_Model instances
     */
    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            'modules.Settings.Vtiger.resources.Popup'
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}