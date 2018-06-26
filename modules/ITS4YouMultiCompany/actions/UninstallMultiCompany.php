<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_UninstallMultiCompany_Action extends Vtiger_Action_Controller
{
    function checkPermission(Vtiger_Request $request) {
        return;
    }

    public function process(Vtiger_Request $request) {
        $Vtiger_Utils_Log = true;
        include_once('vtlib/Vtiger/Module.php');

        $adb = PearDatabase::getInstance();
        $module = Vtiger_Module::getInstance('ITS4YouMultiCompany');
        if ($module) {

            $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');
            $request->set('key', $moduleModel->getLicenseKey());

            $ITS4YouModule_License_Action_Model = new ITS4YouMultiCompany_License_Action();
            $ITS4YouModule_License_Action_Model->deactivateLicense($request);

            $supportedModules = ITS4YouMultiCompany_CustomRecordNumbering_Model::getSupportedModules();

            foreach ($supportedModules as $tabId => $moduleData) {
                $supportedModule = Vtiger_Module_Model::getInstance($tabId);

                $fieldInstance = $supportedModule->getField('its4you_company');
                if ($fieldInstance) {
                    $fieldInstance->unsetRelatedModules(array('ITS4YouMultiCompany'));
                    $fieldInstance->delete();
                }
            }

            $roleFieldInstance = Vtiger_Field_Model::getInstance('mc_role', $module);
            $roleFieldInstance->unsetRelatedModules(array('ITS4YouMultiCompany'));
            $roleFieldInstance->save();


            $adb->pquery("DELETE FROM vtiger_settings_field WHERE name= ?", array("Multi Company"));
            $fieldModel = Vtiger_Field_Model::getInstance('related_to', Vtiger_Module_Model::getInstance('ModComments'));
            $params = array($fieldModel->getId(), 'ModComments', 'ITS4YouMultiCompany');
            $result = $adb->pquery("SELECT 1 FROM vtiger_fieldmodulerel WHERE fieldid=? AND module=? AND relmodule=?", $params);
            if ($adb->num_rows($result) > 0) {
                $adb->pquery('DELETE FROM vtiger_fieldmodulerel WHERE fieldid=? AND module=? AND relmodule=?',
                    array($fieldModel->getId(), 'ModComments', 'ITS4YouMultiCompany'));
            }
            $module->delete();
            @shell_exec('rm -r modules/ITS4YouMultiCompany');
            @shell_exec('rm -r modules/Settings/ITS4YouMultiCompany');
            @shell_exec('rm -r layouts/v7/modules/ITS4YouMultiCompany');
            @shell_exec('rm -r layouts/v7/modules/Settings/ITS4YouMultiCompany');
            @shell_exec('rm -f languages/ar_ae/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/ar_ae/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/cz_cz/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/cz_cz/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/de_de/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/de_de/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/en_gb/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/en_gb/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/en_us/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/en_us/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_co/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_co/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_es/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_es/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_mx/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_mx/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_ve/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/es_ve/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/fi_fi/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/fi_fi/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/fr_fr/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/fr_fr/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/hi_hi/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/hi_hi/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/hu_hu/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/hu_hu/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/it_it/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/it_it/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/nl_nl/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/nl_nl/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/pl_pl/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/pl_pl/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/pt_br/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/pt_br/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/ro_ro/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/ro_ro/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/ru_ru/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/ru_ru/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/sk_sk/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/sk_sk/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/sv_se/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/sv_se/Settings/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/tr_tr/ITS4YouMultiCompany.php');
            @shell_exec('rm -f languages/tr_tr/Settings/ITS4YouMultiCompany.php');

            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4youcf", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you_cn", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you_cn_modules", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you_license", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you_seq", array());
            $adb->pquery("DROP TABLE IF EXISTS its4you_multicompany4you_version", array());
            $adb->pquery("DROP TABLE IF EXISTS vtiger_its4youmulticompany_user_field", array());

            $result = array('success' => true);
        } else {
            $result = array('success' => false);
        }

        ob_clean();
        $response = new Vtiger_Response();
        $response->setResult($result);
        $response->emit();
    }
}
