<?php

/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/


class ITS4YouMultiCompany_Map_Helper extends Google_Map_Helper
{
    /**
     * get the location for the record based on the module type
     * @param type $request
     * @return type
     */
    static function getLocation($request) {
        $result = array();
        $recordId = $request->get('recordid');
        $module = $request->get('source_module');
        $locationFields = self::getLocationFields($module);
        $address = array();
        if (!empty($locationFields)) {
            $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $module);
            foreach ($locationFields as $key => $value) {
                $address[$key] = Vtiger_Util_Helper::getDecodedValue($recordModel->get($value));
            }
            $result['label'] = $recordModel->getName();
        }
        $result['address'] = implode(",", $address);

        return $result;
    }

    /**
     * get location values for:
     * street, city, country
     * @param type $module
     * @return type
     */
    static function getLocationFields($module) {
        $locationFields = Google_Map_Helper::getLocationFields($module);
        switch ($module) {
            case 'ITS4YouMultiCompany'	:	$locationFields = array('street'	=> 'street',
                'city'		=> 'city',
                'state'		=> 'state',
                'zip'		=> 'code',
                'country'	=> 'country');
                break;
        }
        return $locationFields;
    }
}