<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_IndexAjax_View extends Vtiger_Index_View
{
    function __construct() {
        parent::__construct();
        $Methods = array('editLicense');
        foreach ($Methods AS $method){
            $this->exposeMethod($method);
        }
    }

    function process(Vtiger_Request $request) {

        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }

        $type = $request->get('type');
    }

    function editLicense(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);     
        $moduleName = $request->getModule();

        $type = $request->get('type');
        $viewer->assign("TYPE", $type);

        $key = $request->get('key');
        $viewer->assign("LICENSEKEY", $key);

        echo $viewer->view('EditLicense.tpl', 'ITS4YouMultiCompany', true);
    }
}