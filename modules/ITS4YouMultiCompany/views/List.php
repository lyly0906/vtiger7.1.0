<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_List_View extends Vtiger_List_View {
    protected $isInstalled;

    public function __construct() {
        parent::__construct();
        $this->isInstalled = $this->checkIfIsInstalled();
    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        parent::preProcess($request, false);
        $viewer = $this->getViewer($request);

        $moduleName = $request->getModule();

        if(!empty($moduleName)) {
            $currentUser = Users_Record_Model::getCurrentUserModel();
            if (!$this->isInstalled) {
                $currentUser->set('leftpanelhide', 1);
                $viewer->assign('CURRENT_USER_MODEL', $currentUser);
                $viewer->assign("MODULE_BASIC_ACTIONS", array());
                $viewer->assign("MODULE_SETTING_ACTIONS", array());
            }
        }
        if($display) {
            $this->preProcessDisplay($request);
        }
    }

    function preProcessTplName(Vtiger_Request $request) {
        return 'ListViewPreProcess.tpl';
    }

    function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);

        $qualifiedModuleName = $request->getModule(false);
        $viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
        $viewer->assign("URL", vglobal("site_URL"));    

        if ($this->isInstalled) {
            parent::process($request);
        } else {
            $step = 1;
            $current_step = 1;
            $total_steps = 4;

            $company_details = Vtiger_CompanyDetails_Model::getInstanceById();
            $viewer->assign("COMPANY_DETAILS", $company_details);

            $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getSupportedModules();

            $viewer->assign("SUPPORTED_MODULES", $supportedModules);

            $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');
            if ($moduleModel->getLicenseKey() != '') {
                $step = 2;
                $viewer->assign("HIDE_SUCCESS_ALERT", true);
            }

            $viewer->assign("STEP", $step);
            $viewer->assign("CURRENT_STEP", $current_step);
            $viewer->assign("TOTAL_STEPS", $total_steps);

            $viewer->view('Install.tpl', 'ITS4YouMultiCompany');
        }
    }

    /**
     * function checks if module is installed and licensed
     * @return bool
     */
    private function checkIfIsInstalled () {
        $adb = PearDatabase::getInstance();

        $result = $adb->pquery("SELECT * FROM its4you_multicompany4you",array());

        $vcv = "7";
        $result1 = $adb->pquery("SELECT version FROM its4you_multicompany4you_version WHERE version=?", array($vcv));
        if (($result && $adb->num_rows($result) > 0) && ($result1 && $adb->num_rows($result1) > 0)) {
            return true;
        }
        return false;
    }
    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            "layouts.v7.modules.ITS4YouMultiCompany.resources.License",
            "layouts.v7.modules.ITS4YouMultiCompany.resources.List"
        );
        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}