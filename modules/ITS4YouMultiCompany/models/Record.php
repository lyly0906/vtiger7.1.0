<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_Record_Model extends Vtiger_Record_Model
{
    /**
     * @param $FieldModel Vtiger_Field_Model
     * @return array
     */
    public function getImageDetails($FieldModel) {
        $db = PearDatabase::getInstance();
        $imageDetails = array();
        $recordId = $this->getId();

        $moduleModel = $this->getModule();

        if ($recordId) {
            $sql = "SELECT vtat.*, vtcr.setype, vtcr.crmid, its.companyname, its.logo, its.stamp FROM vtiger_attachments as vtat 
						INNER JOIN vtiger_seattachmentsrel as vtseat ON vtseat.attachmentsid = vtat.attachmentsid
                        INNER JOIN vtiger_crmentity as vtcr ON vtcr.crmid = vtat.attachmentsid
                        INNER JOIN its4you_multicompany4you as its ON its.".$FieldModel->getName()." = vtat.attachmentsid
                        WHERE vtcr.setype = ? and vtseat.crmid = ?";

            $result = $db->pquery($sql, array($this->getModuleName().' Image',$recordId));

            $imageId = $db->query_result($result, 0, 'attachmentsid');
            $imagePath = $db->query_result($result, 0, 'path');
            $imageName = $db->query_result($result, 0, 'name');
            $logo = $db->query_result($result, 0, 'logo');
            $stamp = $db->query_result($result, 0, 'stamp');

            //decode_html - added to handle UTF-8 characters in file names
            $imageOriginalName = urlencode(decode_html($imageName));

            if (!empty($imageName)) {
                $imageDetails[] = array(
                    'id' => $imageId,
                    'orgname' => $imageOriginalName,
                    'path' => $imagePath . $imageId,
                    'name' => $imageName,
                    'logo' => $logo,
                    'stamp' => $stamp
                );
            }
        }

        return $imageDetails;
    }

    /**
     * Function to delete corresponding image
     * @param <type> $imageId
     * @return bool
     */
    public function deleteImage($imageId) {
        $db = PearDatabase::getInstance();

        $checkResult = $db->pquery('SELECT crmid FROM vtiger_seattachmentsrel WHERE attachmentsid = ?', array($imageId));
        $crmId = intval($db->query_result($checkResult, 0, 'crmid'));
        if (intval($this->getId()) === $crmId) {
            $db->pquery('DELETE FROM vtiger_seattachmentsrel WHERE crmid = ? AND attachmentsid = ?', array($crmId,$imageId));
            $db->pquery('DELETE FROM vtiger_attachments WHERE attachmentsid = ?', array($imageId));
            $db->pquery('DELETE FROM vtiger_crmentity WHERE crmid = ?',array($imageId));
            return true;
        }
        return false;
    }

    public static function getAll($onlyActive = true) {
        $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');
        $moduleName = $moduleModel->getName();

        $adb = PearDatabase::getInstance();

        $sql = "SELECT companyid FROM its4you_multicompany4you INNER JOIN vtiger_crmentity ON its4you_multicompany4you.companyid = vtiger_crmentity.crmid";
        if ($onlyActive) {
            $sql .= " WHERE vtiger_crmentity.deleted = ?";
        }

        $result = $adb->pquery($sql, array(0));

        $companies = array();
        while ($row = $adb->fetchByAssoc($result))
        {
            $recordId = $row['companyid'];
            $focus = CRMEntity::getInstance($moduleName);
            $focus->id = $recordId;
            $focus->retrieve_entity_info($recordId, $moduleName);
            $modelClassName = Vtiger_Loader::getComponentClassName('Model', 'Record', $moduleName);
            $instance = new $modelClassName();
            $instance->setData($focus->column_fields)->set('id',$recordId)->setModuleFromInstance($moduleModel)->setEntity($focus);
            $companies[$instance->getId()] = $instance;
        }

        return $companies;
    }

    public static function getInstanceByRoleId($roleId) {
        $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');
        $moduleName = $moduleModel->getName();

        $adb = PearDatabase::getInstance();

        $sql = "SELECT companyid FROM its4you_multicompany4you INNER JOIN vtiger_crmentity ON its4you_multicompany4you.companyid = vtiger_crmentity.crmid WHERE vtiger_crmentity.deleted = ? AND its4you_multicompany4you.mc_role = ?";

        $result = $adb->pquery($sql, array(0, $roleId));

        $recordId = $adb->query_result($result, 0, 'companyid');

        $focus = CRMEntity::getInstance($moduleName);
        $focus->id = $recordId;
        $focus->retrieve_entity_info($recordId, $moduleName);
        $modelClassName = Vtiger_Loader::getComponentClassName('Model', 'Record', $moduleName);
        $instance = new $modelClassName();
        return $instance->setData($focus->column_fields)->set('id',$recordId)->setModuleFromInstance($moduleModel)->setEntity($focus);
    }

    /**
     * Function checks if the role Id belongs to the company
     * @param $companyId    int     Company record id
     * @param $roleId       string  Role id
     * @return bool                 Return true if role is in the company, otherwise return false
     */
    public static function isRoleInCompany($companyId, $roleId) {

        $record = ITS4YouMultiCompany_Record_Model::getInstanceById($companyId);
        $recordRoleId = $record->get('mc_role');

        if ($recordRoleId == $roleId) {
            return true;
        } else {
            $roleModel = Settings_Roles_Record_Model::getInstanceById($roleId);
            $parentRoleString = $roleModel->getParentRoleString();
            $parentRolesIds = explode('::', $parentRoleString);

            $companiesRoles = self::getRolesOfAllCompanies();

            for($i = count($parentRolesIds) - 1; $i >= 0; $i--) {
                $id = $parentRolesIds[$i];
                if (in_array($id, $companiesRoles) && $id != $recordRoleId) {
                    break;
                } else {
                    if ($id == $recordRoleId) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Function returns all ids of roles used by instances of ITS4YouMultiCompany module
     * @return array    return array of role ids used by all companies
     */
    private function getRolesOfAllCompanies() {
        $AllCompanies = ITS4YouMultiCompany_Record_Model::getAll();
        $roleIds = array();
        /**
         * @var $company    ITS4YouMultiCompany_Record_Model
         */
        foreach ($AllCompanies as $companyId => $company) {
            $companyRole = $company->get('mc_role');
            if ($companyRole != '') {
                array_push($roleIds, $company->get('mc_role'));
            }
        }

        return $roleIds;
    }

    /**
     * Function returns instance of MultiCompany or null, if instance by user Id does not exist
     * @param $userId       int     User id
     * @return ITS4YouMultiCompany_Record_Model|null           Return null, or ITS4YouMultiCompany_Record_Model object
     */
    public static function getCompanyByUserId($userId) {

        $userModel = Users_Record_Model::getInstanceByName(getUserName($userId));
        $userRoleId = $userModel->get('roleid');

        $roleModel = Settings_Roles_Record_Model::getInstanceById($userRoleId);
        $parentRoleString = $roleModel->getParentRoleString();
        $parentRolesIds = explode('::', $parentRoleString);

        $companiesRoles = self::getRolesOfAllCompanies();

        $company = null;
        if (in_array($userRoleId, $companiesRoles)) {
            $company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($userRoleId);
            return $company;
        } else {
            for ($i = count($parentRolesIds) - 1; $i >= 0; $i--) {
                $id = $parentRolesIds[$i];
                if (in_array($id, $companiesRoles)) {
                    $company = ITS4YouMultiCompany_Record_Model::getInstanceByRoleId($id);
                    return $company;
                }
            }
        }

        return $company;
    }

    /**
     * Function returns company data for company, where user is assigned or return default company data
     * @param $userId
     * @return array company data
     */
    public static function getCompanyData($userId) {
        $company = self::getCompanyByUserId($userId);

        $data = array();
        if ($company != null) {
            $data = $company->getData();
        } else {
            $focus = CRMEntity::getInstance("ITS4YouMultiCompany");

            $defaultCompany = Settings_Vtiger_CompanyDetails_Model::getInstance();
            $defaultData = $defaultCompany->getData();

            foreach ($focus->column_fields as $fieldName => $value) {
                switch ($fieldName) {
                    case 'companyname':
                        $data[$fieldName] = $defaultData['organizationname'];
                        break;
                    case 'street':
                        $data[$fieldName] = $defaultData['address'];
                        break;
                    case 'logo':
                        $data[$fieldName] = '';
                        break;
                    case 'logoname':
                        $data[$fieldName] = '';
                        break;
                    default:
                        if (isset($defaultData[$fieldName]))
                            $data[$fieldName] = $defaultData[$fieldName];
                        else
                            $data[$fieldName] = '';
                }
            }
        }
        return $data;
    }

    /**
     * @param $userId
     * @return ITS4YouMultiCompany_Record_Model|null|Vtiger_Record_Model
     */
    function getCompanyInstance($userId) {

        $company = ITS4YouMultiCompany_Record_Model::getCompanyByUserId($userId);

        if ($company != null) {
            return $company;
        } else {

            /**
             * @var ITS4YouMultiCompany_Record_Model
             */
            $company = Vtiger_Record_Model::getCleanInstance('ITS4YouMultiCompany');
            $moduleModel = $company->getModule();

            $defaultCompany = Settings_Vtiger_CompanyDetails_Model::getInstance();
            $defaultData = $defaultCompany->getData();

            foreach ($moduleModel->getFields() as $fieldName => $fieldModel) {
                switch ($fieldName) {
                    case 'companyname':
                        $company->set($fieldName, $defaultData['organizationname']);
                        break;
                    case 'street':
                        $company->set($fieldName, $defaultData['address']);
                        break;
                    case 'logo':
                    case 'logoname':
                        $company->set($fieldName, '');
                        break;
                    default:
                        if (isset($defaultData[$fieldName]))
                            $company->set($fieldName, $defaultData[$fieldName]);
                        else
                            $company->set($fieldName, '');
                }
            }
        }
        return $company;
    }
}