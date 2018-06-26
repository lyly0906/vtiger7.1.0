<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

require_once('include/utils/utils.php');

class ITS4YouMultiCompanyHandler extends VTEventHandler {

    public function handleEvent($handlerType, $entityData) {
        $adb = PearDatabase::getInstance();
        if ($entityData->focus->mode != 'edit') {
            $moduleName = $entityData->getModuleName();
            $vcv = vglobal('vtiger_current_version');
            $vcv = "7";
            $result = $adb->pquery("SELECT version FROM its4you_multicompany4you_version WHERE version=?", array($vcv));
            if ($result && $adb->num_rows($result)) {
                $res = $adb->pquery("SELECT tabid FROM vtiger_tab INNER JOIN its4you_multicompany4you_cn_modules ON tabid=tab_id WHERE name=?", array($moduleName));
                if ($adb->num_rows($res) > 0) {
                    // custom numbering allowed for current module
                    $row = $adb->fetchByAssoc($res);
                    $tabid = $row['tabid'];
                    $cn = ITS4YouMultiCompany_CustomRecordNumbering_Model::getInstance($moduleName, $tabid);
                    $userCompanyId = ITS4YouMultiCompany_CustomRecordNumbering_Model::getCompanyForUser($entityData->focus->column_fields['assigned_user_id']);
                    $next = $cn->setModuleSeqNumber("increment", $moduleName, '', '', $userCompanyId);
                    if ($next) {
                        $fieldinfores = $adb->pquery("SELECT columnname FROM vtiger_field WHERE tabid = ? AND uitype = 4", Array($tabid));
                        $fieldinforow = $adb->fetchByAssoc($fieldinfores);
                        $adb->query("UPDATE " . $entityData->focus->table_name . " SET " . $fieldinforow['columnname'] . "='" . $next . "' WHERE " . $entityData->focus->table_index . "=" . $entityData->focus->id);
                        $cn->decrementStandardNumbering($moduleName);
                    }

                    //update reference field in module
                    $adb->pquery("UPDATE ". $entityData->focus->table_name ." SET its4you_company = ? WHERE ". $entityData->focus->table_index ." = ?", array($userCompanyId, $entityData->focus->id));
                }
                if ($moduleName == 'ITS4YouMultiCompany') {
                    $result = $adb->query("SELECT attachmentsid FROM its4you_multicompany4you_tempattachmentid");
                    $AttachmentIds = array();
                    while($row = $adb->fetchByAssoc($result)) {
                        array_push($AttachmentIds, $row['attachmentsid']);
                    }
                    $crmId = max($AttachmentIds) + 1;
                    foreach ($AttachmentIds as $attachmentId) {
                        $sql3 = 'INSERT INTO vtiger_seattachmentsrel VALUES(?,?)';
                        $params3 = array($crmId, $attachmentId);
                        $adb->pquery($sql3, $params3);

                        $adb->pquery("DELETE FROM its4you_multicompany4you_tempattachmentid WHERE attachmentsid = ?", array($attachmentId));
                    }
                }
            }
        }
    }             
}           