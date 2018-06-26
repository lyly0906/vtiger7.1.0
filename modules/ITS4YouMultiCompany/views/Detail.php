<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Detail_View extends Vtiger_Detail_View
{
    function __construct() {
        parent::__construct();
        $this->exposeMethod('showCompanyNumbering');
    }

    function showCompanyNumbering (Vtiger_Request $request) {
        $qualified_module = $request->getModule();
        $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getAllowedModules();

        $sourceModule = $request->get('sourceModule');
        if ($sourceModule) {
            $defaultModuleModel = $supportedModules[getTabid($sourceModule)];
        } else {
            $defaultModuleModel = reset($supportedModules);
        }

        $viewer = $this->getViewer($request);
        $viewer->assign('SUPPORTED_MODULES', $supportedModules);
        $viewer->assign('SUPPORTED_MODULES_COUNT', count($supportedModules));
        $viewer->assign('DEFAULT_MODULE_MODEL', $defaultModuleModel);
        $viewer->assign('TAB_LABEL', $request->get('tab_label'));

        $viewer->assign("QUALIFIED_MODULE", $qualified_module);
        $viewer->view('CompanyRecordNumberingListView.tpl', $qualified_module);
    }

    /**
     * Function to get activities
     * @param Vtiger_Request $request
     * @return <List of activity models>
     */
    public function getActivities(Vtiger_Request $request) {
        $moduleName = 'Calendar';
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if($currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
            $moduleName = $request->getModule();

            $viewer = $this->getViewer($request);
            $recordId = $request->get('record');

            $pageNumber = $request->get('page');
            if(empty ($pageNumber)) {
                $pageNumber = 1;
            }
            $pagingModel = new Vtiger_Paging_Model();
            $pagingModel->set('page', $pageNumber);
            $pagingModel->set('limit', 10);

            if(!$this->record) {
                $this->record = Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
            }

            $recordModel = $this->record->getRecord();
            $moduleModel = $recordModel->getModule();

            $relatedActivities = $moduleModel->getCalendarActivities('', $pagingModel, 'all', $recordId);
            $viewer->assign('RECORD', $recordModel);
            $viewer->assign('MODULE_NAME', $moduleName);
            $viewer->assign('PAGING_MODEL', $pagingModel);
            $viewer->assign('PAGE_NUMBER', $pageNumber);
            $viewer->assign('ACTIVITIES', $relatedActivities);

            return $viewer->view('RelatedActivities.tpl', $moduleName, true);
        }
    }

    public function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            'modules.ITS4YouMultiCompany.resources.Field',
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}
