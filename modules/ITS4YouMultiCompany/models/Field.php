<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Field_Model extends Vtiger_Field_Model {
    /**
     * Function returns special validator for fields
     * @return <Array>
     */
    function getValidator() {
        $validator = array();
        $fieldName = $this->getName();

        switch($fieldName) {
            case 'mc_role' : $funcName = array('name'=>'its4you_mc_role_reference_required', 'params' => array(Settings_Roles_Record_Model::getAll()));
                array_push($validator, $funcName);
                break;
            default : $validator = parent::getValidator();
                break;
        }

        return $validator;
    }
}