<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_ITS4YouMultiCompany_Member_Model extends Settings_Groups_Member_Model
{
    const MEMBER_TYPE_COMPANIES = 'Companies';

    public static function getAll($onlyActive=true) {
        $members = parent::getAll($onlyActive);

        $allCompanies = ITS4YouMultiCompany_Record_Model::getAll();
        foreach ($allCompanies as $companyId => $companyModel) {
            $qualifiedId = self::getQualifiedId(self::MEMBER_TYPE_COMPANIES, $companyId);
            $member = new self();
            $members[vtranslate('LBL_COMPANIES_MEMBERS', 'ITS4YouMultiCompany')][$qualifiedId] = $member->set('id', $qualifiedId)->set('name', $companyModel->getName());
        }


        return $members;
    }
}