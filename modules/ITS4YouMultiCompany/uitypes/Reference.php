<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Reference_UIType extends Vtiger_Reference_UIType {

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getReferenceModule($value) {
		$fieldModel = $this->get('field');
		$referenceModuleList = $fieldModel->getReferenceList();
        if (in_array("ITS4YouMultiCompany", $referenceModuleList))
        {
            return Settings_Roles_Record_Model::getInstanceById($value);
        }
		return null;
	}

	/**
	 * Function to get the display value in detail view
	 * @param <Integer> crmid of record
	 * @return <String>
	 */
	public function getDisplayValue($value) {
		$roleModule = $this->getReferenceModule($value);
        if ($roleModule && !empty($value)) {
            $roleName = $roleModule->get('rolename');
//            $linkValue = "<a title='" . $roleName . "' "
//                . "data-original-title='" . $roleName . "'>$roleName</a>";
            $linkValue = $roleName;
            return $linkValue;
        }
		return '';
	}

    /**
     * Function to get the display value in edit view
     * @param reference record id
     * @return link
     */
    public function getEditViewDisplayValue($value) {
        $roleModule = $this->getReferenceModule($value);
        if($roleModule) {
            $roleName = $roleModule->get('rolename');
            return $roleName;
        }
        return '';
    }
}