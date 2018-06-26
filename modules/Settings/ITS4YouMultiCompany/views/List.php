<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_ITS4YouMultiCompany_List_View extends Settings_Vtiger_Index_View
{
    public function process(Vtiger_Request $request)
    {
        $qualifiedModule = $request->getModule(false);
        $viewer = $this->getViewer($request);

        $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getSupportedModules();

        $viewer->assign("SUPPORTED_MODULES", $supportedModules);
        $viewer->assign('QUALIFIED_MODULE', $qualifiedModule);

        $viewer->view('List.tpl', $qualifiedModule);
    }

    public function getHeaderScripts(Vtiger_Request $request)
    {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            "layouts.v7.modules.Settings.Vtiger.resources.List",
            "layouts.v7.modules.Settings.$moduleName.resources.List",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}