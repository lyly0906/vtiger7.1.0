<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Module_Model extends Vtiger_Module_Model
{

    private $version_type;
    private $license_key;
    private $version_no;
    
    public function getSettingLinks(){
        if(!$this->isEntityModule() && $this->getName() !== 'Users') {
            return array();
        }

        $settingsLinks = parent::getSettingLinks();

        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        if($currentUserModel->isAdminUser()) {
            $settingsLinks[] =  array(
                'linktype' => 'LISTVIEWSETTING',
                'linklabel' => vtranslate('LBL_LICENSE', $this->getName()),
                'linkurl' => 'index.php?module='.$this->getName().'&view=License',
                'linkicon' => Vtiger_Theme::getImagePath('proxy.gif')
            );

            $settingsLinks[] =  array(
                'linktype' => 'LISTVIEWSETTING',
                'linklabel' => vtranslate('LBL_UPGRADE', $this->getName()),
                'linkurl' => 'index.php?module=ModuleManager&parent=Settings&view=ModuleImport&mode=importUserModuleStep1',
                'linkicon' => ''
            );

            $settingsLinks[] =  array(
                'linktype' => 'LISTVIEWSETTING',
                'linklabel' => vtranslate('LBL_UNINSTALL', $this->getName()),
                'linkurl' => 'index.php?module='.$this->getName().'&view=Uninstall',
                'linkicon' => ''
            );
        }

        return $settingsLinks;
    }

    /**
     * @return bool|Vtiger_Module|Vtiger_Module_Model|ITS4YouMultiCompany_Module_Model
     */
    public static function getInstance() {
        return parent::getInstance('ITS4YouMultiCompany'); // TODO: Change the autogenerated stub
    }

    public function deleteRelations() {
        $relations = $this->getRelations();
        $module = Vtiger_Module::getInstance($this->getId());
        /**
         * @var $relation Vtiger_Relation_Model
         */
        foreach ($relations as $relation) {
            $moduleModel = $relation->getRelationModuleModel();
            $relatedModule = Vtiger_Module::getInstance($moduleModel->getId());
            $module->unsetRelatedList($relatedModule, $moduleModel->getName(), 'get_related_list');
        }
    }
    
    public function getLicenseKey() {
    
        if (empty($this->license_key)) {
            $this->setLicenseInfo();
        }
        
        return $this->license_key;
    }

    public function getVersionType() {
    
        if (empty($this->version_type)) {
            $this->setLicenseInfo();
        }
    
        return $this->version_type;
    }

    private function setLicenseInfo() {
    
        $adb = PearDatabase::getInstance();
    
        $this->version_no = ITS4YouMultiCompany_Version_Helper::$version;

        $result = $adb->query("SELECT version_type, license_key FROM its4you_multicompany4you_license");
        if ($adb->num_rows($result) > 0) {
            $this->version_type = $adb->query_result($result, 0, "version_type");
            $this->license_key = $adb->query_result($result, 0, "license_key");
        } else {
            $this->version_no = '';
            $this->license_key = '';
        }
    }

}