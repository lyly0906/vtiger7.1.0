<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_License_View extends Vtiger_Index_View {
    function checkPermission(Vtiger_Request $request) {
        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        if(!$currentUserModel->isAdminUser()) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
        }

    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        Vtiger_Basic_View::preProcess($request, false);
        $viewer = $this->getViewer($request);
        $moduleName = $request->getModule();


        $viewer->assign('QUALIFIED_MODULE', $moduleName);


        if ($display) {
            $this->preProcessDisplay($request);
        }
    }

    public function process(Vtiger_Request $request) {
        $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');         
        $viewer = $this->getViewer($request); 
        $mode = $request->get('mode');
        $viewer->assign("MODE", $mode);
        $viewer->assign("LICENSE", $moduleModel->getLicenseKey());
        $viewer->assign("VERSION_TYPE", $moduleModel->getVersionType());
        $company_details = Vtiger_CompanyDetails_Model::getInstanceById();
        $viewer->assign("COMPANY_DETAILS", $company_details);
        $viewer->assign("URL", vglobal("site_URL"));
        $viewer->view('License.tpl', 'ITS4YouMultiCompany');
    }

    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            'modules.Vtiger.resources.Vtiger',
            "modules.$moduleName.resources.License",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}