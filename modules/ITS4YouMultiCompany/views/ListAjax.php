<?php
/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

class ITS4YouMultiCompany_ListAjax_View extends Vtiger_List_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('customNumberingSettingsContent');
        $this->exposeMethod('editCompanyRecordNumbering');
        $this->exposeMethod('step4Content');
    }

    function checkPermission(Vtiger_Request $request) {
        //Return true as WebUI.php is already checking for module permission
        return true;
    }

    function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }
    }

    public function customNumberingSettingsContent(Vtiger_Request $request) {
        $qualifiedModule = $request->getModule();
        $viewer = $this->getViewer($request);

        $recordId = $request->get('record');

        $module = Vtiger_Module_Model::getInstance(getTabid("ITS4YouMultiCompany"));

        $recordInstance = Vtiger_Record_Model::getInstanceById($recordId, $module);
        $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getSupportedModules();

        $viewer->assign("RECORD_INSTANCE", $recordInstance);
        $viewer->assign("SUPPORTED_MODULES", $supportedModules);
        $viewer->assign('QUALIFIED_MODULE', $qualifiedModule);

        $viewer->view("CustomNumberingSettings.tpl", $qualifiedModule);
    }

    public function editCompanyRecordNumbering(Vtiger_Request $request) {
        $qualifiedModule = $request->getModule();
        $viewer = $this->getViewer($request);

        $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getAllowedModules();

        $sourceModule = $request->get('sourceModule');
        if ($sourceModule) {
            $defaultModuleModel = $supportedModules[getTabid($sourceModule)];
        } else {
            $defaultModuleModel = reset($supportedModules);
        }
        $viewer->assign('DEFAULT_MODULE_MODEL', $defaultModuleModel);

        $viewer->assign("QUALIFIED_MODULE", $request->getModule());
        $viewer->view("CompanyRecordNumbering.tpl", $qualifiedModule);
    }

    public function step4Content(Vtiger_Request $request) {
        $qualifiedModule = $request->getModule();
        $viewer = $this->getViewer($request);

        $success = $request->get('success');
        $recordId = $request->get('recordId');

        if (!empty($recordId)) {
            $record = ITS4YouMultiCompany_Record_Model::getInstanceById($recordId);
            $viewer->assign("RECORD", $record);
        }

        $viewer->assign("SUCCESS", $success);

        $viewer->assign("QUALIFIED_MODULE", $request->getModule());
        $viewer->view("Step4.tpl", $qualifiedModule);
    }
}