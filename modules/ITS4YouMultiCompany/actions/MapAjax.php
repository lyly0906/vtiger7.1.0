<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_MapAjax_Action extends Google_MapAjax_Action
{
    public function process(Vtiger_Request $request) {
        switch ($request->get("mode")) {
            case 'getLocation'	:	$result = $this->getLocation($request);
                break;
        }
        echo json_encode($result);
    }
    /**
     * get address for the record, based on the module type.
     * @param Vtiger_Request $request
     * @return type
     */
    function getLocation(Vtiger_Request $request) {
        $result = ITS4YouMultiCompany_Map_Helper::getLocation($request);
        return $result;
    }
}