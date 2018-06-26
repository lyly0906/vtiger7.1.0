<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/
require_once 'include/events/VTEventHandler.inc';

class ITS4YouMultiCompany_ITS4YouUploadAttachment_Handler extends VTEventHandler {
    /**
     * @param $eventName
     * @param $entityData   VTEntityData
     */
    function handleEvent($eventName, $entityData) {
        global $adb;
        $moduleName = $entityData->getModuleName();


        if ('ITS4YouMultiCompany' == $moduleName) {
            $sql = "SELECT vtiger_field.fieldname, vtiger_field.columnname, vtiger_field.tablename FROM vtiger_field 
                        INNER JOIN  vtiger_tab ON  vtiger_tab.tabid = vtiger_field.tabid
                        WHERE vtiger_tab.name = ? AND vtiger_field.uitype = ?";
            $result = $adb->pquery($sql, array($moduleName, "69"));
            $num_rows = $adb->num_rows($result);

            // added to support files transformation for file upload fields like uitype 69,
            if(count($_FILES)) {
                $_FILES = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
            }

            $uploadedFileNames = array();
            if ($num_rows > 0) {
                while($row = $adb->fetchByAssoc($result)) {
                    $fieldName = $row["fieldname"];
                    if (isset($_FILES[$fieldName])) {
                        $IMG_FILES = $_FILES[$fieldName];

                        if (count($IMG_FILES)) {
                            foreach($IMG_FILES as $fileIndex => $file) {

                                if($file['error'] == 0 && $file['name'] != '' && $file['size'] > 0) {

                                    $file['original_name'] = stripslashes($file['name']);
                                    $file['original_name'] = str_replace('"','',$file['original_name']);
                                    $attachmentId = $this->uploadAndSaveFile($entityData, $entityData->focus->id,$moduleName,$file,'Image');

                                    if ($attachmentId) {
                                        $sql = "UPDATE its4you_multicompany4you SET " . $fieldName . " = ? WHERE companyid = ?";
                                        $adb->pquery($sql, array($attachmentId, $entityData->focus->id));
//                                        unset($_FILES[$fieldName]);
                                        $entityData->set($fieldName, $attachmentId);
                                        $uploadedFileNames[] = $file['name'];

                                        $adb->pquery('INSERT INTO its4you_multicompany4you_tempattachmentid (attachmentsid, fieldname) VALUES (?, ?)', array($attachmentId, $fieldName));
                                    }

                                }
                            }
                        }
                        // ak bola funkcia unset ->CRMENITY ukladalo do tabulky ist4youmc zle hodnoty a nefungovalo zobrazenie obrazkov
                        // kvoli tomu, aby v crmentity neupdatovalo tabulku its4you_mc zlymi hodnotami, je treba naplnit pole aj ked nie je
                        // ziaden file prilozeny,
                        // nasledujucimi hodnotami sa v crmentity nevykona nic, dobre pre multicompany
                        $newFileArray = array();
                        $newFileArray[0]['name'] = '';
                        $newFileArray[0]['type'] = '';
                        $newFileArray[0]['tmp_name'] = '';
                        $newFileArray[0]['error'] = 4;
                        $newFileArray[0]['size'] = 0;
                        $_FILES[$fieldName] = $newFileArray;
                    }
                }
            }
            $_REQUEST['imgDeleted'] = false;
        } else {
            return;
        }
    }

    function uploadAndSaveFile($entityData, $id, $module, $file_details, $attachmentType='Attachment') {
        global $log;
        $log->debug("Entering into uploadAndSaveFile($id,$module,$file_details) method.");

        global $adb, $current_user;
        global $upload_badext;

        $date_var = date("Y-m-d H:i:s");

        $ownerid = $entityData->focus->column_fields['assigned_user_id'];
        if (!isset($ownerid) || $ownerid == '')
            $ownerid = $current_user->id;

        if (isset($file_details['original_name']) && $file_details['original_name'] != null) {
            $file_name = $file_details['original_name'];
        } else {
            $file_name = $file_details['name'];
        }

        // Check 1
        $save_file = 'true';
        //only images are allowed for Image Attachmenttype
        $mimeType = vtlib_mime_content_type($file_details['tmp_name']);
        $mimeTypeContents = explode('/', $mimeType);
        // For contacts and products we are sending attachmentType as value
        if ($attachmentType == 'Image' || ($file_details['size'] && $mimeTypeContents[0] == 'image')) {
            $save_file = validateImageFile($file_details);
        }
        if ($save_file == 'false') {
            return false;
        }

        $binFile = sanitizeUploadFileName($file_name, $upload_badext);

        $current_id = $adb->getUniqueID("vtiger_crmentity");

        $filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
        $filetype = $file_details['type'];
        $filetmp_name = $file_details['tmp_name'];

        //get the file path inwhich folder we want to upload the file
        $upload_file_path = decideFilePath();

        // upload the file in server
        $upload_status = copy($filetmp_name, $upload_file_path . $current_id . "_" . $binFile);

        if ($save_file == 'true' && $upload_status == 'true') {
            //Add entry to crmentity
            $sql1 = "INSERT INTO vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params1 = array($current_id, $current_user->id, $ownerid, $module." ".$attachmentType, $entityData->focus->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
            $adb->pquery($sql1, $params1);
            //Add entry to attachments
            $sql2 = "INSERT INTO vtiger_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
            $params2 = array($current_id, $filename, $entityData->focus->column_fields['description'], $filetype, $upload_file_path);
            $adb->pquery($sql2, $params2);
            //Add relation
            $sql3 = 'INSERT INTO vtiger_seattachmentsrel VALUES(?,?)';
            $params3 = array($id, $current_id);
            $adb->pquery($sql3, $params3);

            return $current_id;
        } else {
            return false;
        }        
    }
}