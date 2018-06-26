<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_ITS4YouMultiCompany_Module_Model extends Vtiger_Module_Model
{
    /**
     * Return first Vtiger_Block object from module
     * @return Vtiger_Block
     */
    function getFirstBlock() {
        $firstBlock = reset($this->getBlocks());
        return $firstBlock;
    }

    public static function getInstance($value) {
        $moduleInstance = Vtiger_Module_Model::getInstance($value);
        $objectProperties = get_object_vars($moduleInstance);
        $selfInstance = new self();
        foreach($objectProperties as $properName=>$propertyValue){
            $selfInstance->$properName = $propertyValue;
        }
        return $selfInstance;
    }

    public function createCompanyFieldInEntityModule() {
        /**
         * @var $firstBlock     Vtiger_Block
         */
        $firstBlock = $this->getFirstBlock();

        $fieldInstance = Vtiger_Field_Model::getInstance("its4you_company", $this);
        if (!$fieldInstance) {
            $fieldInstance = new Vtiger_Field_Model();
            $fieldInstance->name = "its4you_company";
            $fieldInstance->table = $this->basetable;
            $fieldInstance->label = "Company";
            $fieldInstance->column = 'its4you_company';
            $fieldInstance->columntype = 'VARCHAR(100)';
            $fieldInstance->uitype = 10;
            $fieldInstance->quickcreate = 3;
            $fieldInstance->info_type = 'BAS';
            $fieldInstance->typeofdata = 'V~O';
            $fieldInstance->displaytype = 2;
            $fieldInstance->readonly = 1;
            $fieldInstance->setRelatedModules(array("ITS4YouMultiCompany"));

            $firstBlock->addField($fieldInstance);
        }

        if (empty($fieldInstance->getReferenceList())) {
            $fieldInstance->setRelatedModules(array("ITS4YouMultiCompany"));
            $fieldInstance->save();
        }
    }

    public function allowSharingModule() {
        require_once('include/utils/utils.php');

        $adb = PearDatabase::getInstance();

        $sharingRulesModuleModel = Settings_SharingAccess_Module_Model::getInstance($this->getId());

        if (!$sharingRulesModuleModel) {
            $adb->pquery("SELECT @tabid:=tabid FROM `vtiger_tab` WHERE `name` = ?", array($this->getName()));
            $adb->query("SELECT @ruleid:=(id+1) FROM vtiger_def_org_share_seq");
            $adb->query("UPDATE vtiger_def_org_share_seq SET id = @ruleid");
            $adb->query("INSERT INTO vtiger_def_org_share (ruleid, tabid, permission, editstatus) VALUES (@ruleid, @tabid, '2', '0')");
            $adb->query("INSERT INTO vtiger_org_share_action2tab SELECT share_action_id, @tabid FROM vtiger_org_share_action_mapping WHERE share_action_id<4");
            $adb->query("UPDATE `vtiger_tab` SET `ownedby` = '0' WHERE `vtiger_tab`.`tabid` =@tabid");

            @create_tab_data_file();
            @create_parenttab_data_file();
        }
    }

    public function createAssignedToFieldIntoModule() {
        /**
         * @var $firstBlock     Vtiger_Block
         */
        $firstBlock = $this->getFirstBlock();

        $fieldInstance = Vtiger_Field::getInstance("smownerid", $this);
        if (!$fieldInstance) {
            $fieldInstance = new Vtiger_Field();
            $fieldInstance->name = "assigned_user_id";
            $fieldInstance->table = "vtiger_crmentity";
            $fieldInstance->label = "Assigned To";
            $fieldInstance->column = 'smownerid';
            $fieldInstance->generatedtype = 1;
            $fieldInstance->columntype = 'VARCHAR(100)';
            $fieldInstance->uitype = 53;
            $fieldInstance->quickcreate = 0;
            $fieldInstance->info_type = 'BAS';
            $fieldInstance->typeofdata = 'V~M';
            $fieldInstance->displaytype = 1;
            $fieldInstance->readonly = 1;
            $fieldInstance->presence = 0;
            $fieldInstance->masseditable = 1;

            $firstBlock->addField($fieldInstance);
        }
    }

    public static function  getModulesWithoutAssignedToField() {
        $adb = PearDatabase::getInstance();

        $sql = "SELECT vtiger_tab.tabid FROM vtiger_field inner join vtiger_tab on vtiger_field.tabid = vtiger_tab.tabid where vtiger_tab.isentitytype = ? and vtiger_tab.tabid not in(SELECT vtiger_tab.tabid FROM vtiger_field inner join vtiger_tab on vtiger_field.tabid = vtiger_tab.tabid where columnname = 'smownerid') group by tabid";
        $result = $adb->pquery($sql, array(1));

        $modules = array();
        while ($row = $adb->fetchByAssoc($result)) {
            array_push($modules, $row['tabid']);
        }

        return $modules;
    }

    public static function applyNewModuleSharingRules($moduleId) {
        $sharingRulesModuleModel = Settings_SharingAccess_Module_Model::getInstance($moduleId);

        if (!$sharingRulesModuleModel->isPrivate()) {
            //applying private rules for module
            $sharingRulesModuleModel->set('permission', Settings_SharingAccess_Module_Model::SHARING_ACCESS_PRIVATE);
            if ($sharingRulesModuleModel->getId() == 6) {
                $dependentModules = Settings_SharingAccess_Module_Model::getDependentModules();
                $dependentModules = reset($dependentModules);
                foreach ($dependentModules as $dependentModule) {
                    $dependentModuleModel = Settings_SharingAccess_Module_Model::getInstance($dependentModule);
                    $dependentModuleModel->set('permission', Settings_SharingAccess_Module_Model::SHARING_ACCESS_PRIVATE);
                    $dependentModuleModel->save();
                }
            }

            try {
                $sharingRulesModuleModel->save();
            } catch (AppException $e) {

            }

            Settings_SharingAccess_Module_Model::recalculateSharingRules();
        }
    }  
}