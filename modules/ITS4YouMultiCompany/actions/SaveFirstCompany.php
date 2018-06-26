<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_SaveFirstCompany_Action extends Vtiger_Action_Controller
{
    function checkPermission(Vtiger_Request $request) {
        return;
    }

    function process(Vtiger_Request $request) {
        $companyDetails = Vtiger_CompanyDetails_Model::getInstanceById();

        $adb = PearDatabase::getInstance();
        $companyResult = $adb->pquery("SELECT * FROM its4you_multicompany4you INNER JOIN vtiger_crmentity 
                ON its4you_multicompany4you.companyid = vtiger_crmentity.crmid WHERE vtiger_crmentity.deleted = ?",array('0'));

        $result = array();
        $success = false;

        if ($adb->getRowCount($companyResult) == 0) {

            $mcRecordModel = ITS4YouMultiCompany_Record_Model::getCleanInstance('ITS4YouMultiCompany');
            $mcRecordModel->set('companyname', $companyDetails->get('organizationname'));
            $mcRecordModel->set('street', $companyDetails->get('address'));
            $mcRecordModel->set('city', $companyDetails->get('city'));
            $mcRecordModel->set('state', $companyDetails->get('state'));
            $mcRecordModel->set('country', $companyDetails->get('country'));
            $mcRecordModel->set('code', $companyDetails->get('code'));
            $mcRecordModel->set('phone', $companyDetails->get('phone'));
            $mcRecordModel->set('fax', $companyDetails->get('fax'));
            $mcRecordModel->set('website', $companyDetails->get('website'));
            $mcRecordModel->set('vatno', $companyDetails->get('vatid'));
            $mcRecordModel->set('mc_role', 'NULL');

            $mcRecordModel->save();

            $sql = "UPDATE its4you_multicompany4you SET mc_role=? WHERE companyid=?";
            $adb->pquery($sql, array(NULL, $mcRecordModel->getId()));

            $result['recordId'] = $mcRecordModel->getId();
            $result['inserted'] = true;
            $success = true;
        }

        $result['success'] = $success;
        
        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        $response->setResult($result);   
        $response->emit();
    }
}