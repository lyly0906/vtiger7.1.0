<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_CustomNumberingAjax_Action extends Vtiger_BasicAjax_Action
{
    public function __construct() {
        parent::__construct();
        $this->exposeMethod('saveModuleCustomNumberingData');
        $this->exposeMethod('updateRecordsWithSequenceNumber');
    }

    function checkPermission(Vtiger_Request $request) {
        return;
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->getMode();
        if (!empty($mode)) {
            echo $this->invokeExposedMethod($mode, $request);
            return;
        }
    }

    public function saveModuleCustomNumberingData(Vtiger_Request $request) {
        $qualifiedModuleName = $request->getModule(false);
        $sourceModule = $request->get('sourceModule');

        $moduleModel = ITS4YouMultiCompany_CustomRecordNumbering_Model::getInstance($sourceModule);
        $moduleModel->set('prefix', $request->get('prefix'));
        $moduleModel->set('sequenceNumber', $request->get('sequenceNumber'));

        $result = $moduleModel->setModuleSequence($request->get('companyid'));

        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        if ($result['success']) {
            $response->setResult(vtranslate('LBL_SUCCESSFULLY_UPDATED', $qualifiedModuleName));
        } else {
            $message = vtranslate('LBL_PREFIX_IN_USE', $qualifiedModuleName);
            $response->setError($message);
        }

        $response->emit();
    }

    /**
     * Function to update record with sequence number
     * @param Vtiger_Request $request
     */
    public function updateRecordsWithSequenceNumber(Vtiger_Request $request) {
        $sourceModule = $request->get('sourceModule');

        $moduleModel = ITS4YouMultiCompany_CustomRecordNumbering_Model::getInstance($sourceModule);
        $result = $moduleModel->updateRecordsWithSequence($request->get('companyid'));

        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        $response->setResult($result);
        $response->emit();
    }
}