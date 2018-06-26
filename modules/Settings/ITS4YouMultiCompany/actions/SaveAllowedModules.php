<?php
/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

class Settings_ITS4YouMultiCompany_SaveAllowedModules_Action extends Vtiger_Action_Controller
{
    function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request)
    {
        require_once('include/utils/utils.php');
        $adb = PearDatabase::getInstance();
        $qualifiedModuleName = $request->getModule(false);

        $adb->query("DELETE FROM its4you_multicompany4you_cn_modules");
        $req = $request->get('formData');

        $modulesWithoutAssignedToField = Settings_ITS4YouMultiCompany_Module_Model::getModulesWithoutAssignedToField();

        $multiCompanyTabId = getTabid(ITS4YouMultiCompany);
        $multiCompanyModule = Vtiger_Module::getInstance($multiCompanyTabId);
//        $mcModuleModel = Vtiger_Module_Model::getInstance($multiCompanyTabId);
        $mcModuleModel = ITS4YouMultiCompany_Module_Model::getInstance();
        $mcModuleModel->deleteRelations();
//        $relatedModules = $mcModuleModel->getRelations();
        foreach ($req as $key => $value) {
            if (substr($key, 0, 8) == 'allowed_') {
                $tabId = substr($key, 8);
                $adb->pquery("INSERT INTO its4you_multicompany4you_cn_modules VALUES (?)", array($tabId));
                $moduleModel = Settings_ITS4YouMultiCompany_Module_Model::getInstance($tabId);

                $moduleModel->createCompanyFieldInEntityModule();

                if (in_array($tabId, $modulesWithoutAssignedToField)){
                    $moduleModel->createAssignedToFieldIntoModule();
                    $moduleModel->allowSharingModule();
                }

                Settings_ITS4YouMultiCompany_Module_Model::applyNewModuleSharingRules($tabId);

//                if (!$this->isBetweenRelationModules($tabId, $relatedModules)) {
                    $moduleInstance = Vtiger_Module::getInstance($tabId);
                    $actions = array('ADD');
                    $fieldModel = Vtiger_Field_Model::getInstance('its4you_company', Vtiger_Module_Model::getInstance($tabId));
                    if ($fieldModel && $moduleModel->getName() != 'Documents') {
                        $multiCompanyModule->setRelatedList($moduleInstance, $moduleModel->getName(), $actions, 'get_related_list', $fieldModel->getId());
                    }
//                }
            }
        }

        $result = $adb->query("SELECT * FROM its4you_multicompany4you_cn_modules");

        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);

        if ($adb->num_rows($result) > 0)
        {
            $message = vtranslate("LBL_ALLOWED_MODULES_SAVED", $qualifiedModuleName);
            $response->setResult(array("inserted" => true, 'message' => $message));
        } else {
            $message = vtranslate('LBL_NO_ALLOWED_MODULES_SAVED', $qualifiedModuleName);
            $response->setResult(array("inserted" => false, 'message' => $message));
        }

        $response->emit();
    }

//    private function isBetweenRelationModules($tabId, $relationModules)
//    {
//        /**
//         * @var $relationModule Vtiger_Relation_Model
//         */
//        foreach ($relationModules as $relationModule) {
//            $moduleModel = $relationModule->getRelationModuleModel();
//            if ($tabId == $moduleModel->getId()) {
//                return true;
//            }
//        }
//
//        return false;
//    }
}