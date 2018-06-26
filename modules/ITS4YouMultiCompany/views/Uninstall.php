<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Uninstall_View extends Vtiger_Index_View {
    function checkPermission(Vtiger_Request $request) {
        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        if(!$currentUserModel->isAdminUser()) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
        }
    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        Vtiger_Basic_View::preProcess($request, false);

        if ($display) {
            $this->preProcessDisplay($request);
        }
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $moduleName = $request->getModule();

        $viewer->view('Uninstall.tpl', $moduleName);
    }

    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            'modules.Vtiger.resources.Vtiger',
            "layouts.v7.modules.ITS4YouMultiCompany.resources.Uninstall",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}