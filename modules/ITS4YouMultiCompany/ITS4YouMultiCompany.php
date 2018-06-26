<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/
 
include_once 'modules/Vtiger/CRMEntity.php';

class ITS4YouMultiCompany extends Vtiger_CRMEntity {

	var $table_name = 'its4you_multicompany4you';
	var $table_index= 'companyid';
	var $TAB_MODULE_NAME = "ITS4YouMultiCompany";

    private $LBL_MULTICOMPANY = 'Multi Company';
    
    /**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('its4you_multicompany4youcf', 'companyid');
    
    /**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'its4you_multicompany4you', 'its4you_multicompany4youcf');
	
	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'its4you_multicompany4you' => 'companyid',
		'its4you_multicompany4youcf'=>'companyid'
	);
	
	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (

	);
	var $list_fields_name = Array (

	);

	// Make the field link to detail view
	var $list_link_field = 'companyid';

	// For Popup listview and UI type support
	var $search_fields = Array(

	);
	var $search_fields_name = Array (

	);

	// For Popup window record selection
	var $popup_fields = Array ('company_no');

	// For Alphabetical search
	var $def_basicsearch_col = 'company_no';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'company_no';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('company_no','assigned_user_id');

	var $default_order_by = 'company_no';
	var $default_sort_order='ASC';
	
	function ITS4YouMultiCompany() {
		$this->log =LoggerManager::getLogger($this->TAB_MODULE_NAME);
		$this->db = PearDatabase::getInstance();
		$this->column_fields = getColumnFields($this->TAB_MODULE_NAME);
	}

    function vtlib_handler($moduleName, $eventType) {
        //require_once('include/utils/utils.php');
        $adb = PearDatabase::getInstance();


        if ($eventType == 'module.postinstall') {
        	static::enableModTracker($moduleName);
            $this->updateSettings();
        } else if ($eventType == 'module.disabled') {
            
        } else if ($eventType == 'module.enabled') {
            
        } else if ($eventType == 'module.preuninstall') {
            $this->handleCalendarRelatedToReferenceList(false);
        } else if ($eventType == 'module.preupdate') {
            // TODO Handle actions before this module is updated.
        } else if ($eventType == 'module.postupdate') {
            $this->updateSettings();
        }
    }

    private function updateSettings() {
        $adb = PEARDatabase::getInstance();

        $fieldid = $adb->getUniqueID('vtiger_settings_field');
        $blockid = getSettingsBlockId('LBL_OTHER_SETTINGS');
        $seq_res = $adb->pquery("SELECT max(sequence) AS max_seq FROM vtiger_settings_field WHERE blockid = ?", array($blockid));
        if ($adb->num_rows($seq_res) > 0) {
            $cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
            if ($cur_seq != null)
                $seq = $cur_seq + 1;
        }

        $result = $adb->pquery('SELECT 1 FROM vtiger_settings_field WHERE name=?', array($this->LBL_MULTICOMPANY));
        if (!$adb->num_rows($result)) {
            $adb->pquery('INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence)
		VALUES (?,?,?,?,?,?,?)', array($fieldid, $blockid, $this->LBL_MULTICOMPANY, 'modules/ITS4YouMultiCompany/img/multicompany4you.gif', 'Specify businness address for multiple companies', 'index.php?parent=Settings&module=ITS4YouMultiCompany&view=List', $seq));
        }

        //applying private rules for module
        $sharingRulesModuleModel = Settings_SharingAccess_Module_Model::getInstance(getTabid('ITS4YouMultiCompany'));
        $sharingRulesModuleModel->set('permission', Settings_SharingAccess_Module_Model::SHARING_ACCESS_PRIVATE);
        try {
            $sharingRulesModuleModel->save();
        } catch (AppException $e) {

        }

        Settings_SharingAccess_Module_Model::recalculateSharingRules();

        //Insert module name into Calendar Task Related to field
        $this->handleCalendarRelatedToReferenceList(true);

        //enable Comments widget in deail view
        $fieldModel = Vtiger_Field_Model::getInstance('related_to', Vtiger_Module_Model::getInstance('ModComments'));
        $params = array($fieldModel->getId(), 'ModComments', 'ITS4YouMultiCompany');
        $result = $adb->pquery("SELECT 1 FROM vtiger_fieldmodulerel WHERE fieldid=? AND module=? AND relmodule=?", $params);
        if ($adb->num_rows($result) == 0) {
            $adb->pquery('INSERT INTO vtiger_fieldmodulerel (fieldid, module, relmodule) VALUES (?,?,?)',
                array($fieldModel->getId(), 'ModComments', 'ITS4YouMultiCompany'));
        }

        //set fields as header fields
        $moduleModel = Vtiger_Module_Model::getInstance('ITS4YouMultiCompany');

        $fieldNames = array('city', 'street', 'country');
        foreach ($fieldNames as $fieldName) {
            $fieldModel = Vtiger_Field_Model::getInstance($fieldName, $moduleModel);
            if (!$fieldModel->isHeaderField()) {
                $fieldModel->set('headerfield', 1);
                $fieldModel->save();
            }
        }
    }

    private function handleCalendarRelatedToReferenceList($install = true) {
        $adb = PEARDatabase::getInstance();
        $calendarModuleModel = Vtiger_Module_Model::getInstance('Calendar');
        $fieldModel = Vtiger_Field_Model::getInstance('parent_id', $calendarModuleModel);
        $result = $adb->pquery('SELECT fieldtypeid FROM vtiger_ws_fieldtype WHERE uitype=?', array($fieldModel->get('uitype')));
        $fieldType = $adb->query_result($result, 0, 'fieldtypeid');

        $result = $adb->pquery('SELECT 1 FROM vtiger_ws_referencetype WHERE fieldtypeid=? and type=?', array($fieldType, 'ITS4YouMultiCompany'));
        if ($install) {
            if (!$adb->num_rows($result)) {
                $adb->pquery('INSERT INTO vtiger_ws_referencetype(fieldtypeid,type) VALUES(?, ?)', array($fieldType, 'ITS4YouMultiCompany'));

                $sql = "SELECT 1 FROM vtiger_relatedlists WHERE tabid=? AND related_tabid=? AND name=? AND relationfieldid=?";
                $result = $adb->pquery($sql, array(getTabid('ITS4YouMultiCompany'), getTabid('Calendar'), 'get_activities', $fieldModel->getId()));

                if ($adb->num_rows($result) == 0) {
                    $module = Vtiger_Module::getInstance('ITS4YouMultiCompany');
                    $relModule = Vtiger_Module::getInstance('Calendar');
                    $module->setRelatedList($relModule, 'Activities', array('ADD'), 'get_activities', $fieldModel->getId());
                }
            }
        } else {
            if ($adb->num_rows($result) > 0)
                $adb->pquery('DELETE FROM vtiger_ws_referencetype  WHERE fieldtypeid =? AND type =?', array($fieldType, 'ITS4YouMultiCompany'));
        }
    }

    static function checkAdminAccess($user) {
        return;
        if (is_admin($user))
            return;

        echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
        echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src= " . vtiger_imageurl('denied.gif', $theme) . " ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>" . vtranslate('LBL_PERMISSION') . "</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>" . vtranslate('LBL_GO_BACK') . "</a><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
        echo "</td></tr></table>";
        exit;
    }
    
    /**
	 * Enable ModTracker for the module
	 */
	public static function enableModTracker($moduleName)
	{
		include_once 'vtlib/Vtiger/Module.php';
		include_once 'modules/ModTracker/ModTracker.php';
			
		//Enable ModTracker for the module
		$moduleInstance = Vtiger_Module::getInstance($moduleName);
		ModTracker::enableTrackingForModule($moduleInstance->getId());
	}

    /**
     * Function to handle the related list for the module.
     * NOTE: Vtiger_Module::setRelatedList sets reference to this function in vtiger_relatedlists table
     * if function name is not explicitly specified.
     */
    function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions = false) {
        global $currentModule, $app_strings, $singlepane_view;

        $parenttab = getParentTab();

        $related_module = vtlib_getModuleNameById($rel_tab_id);
        $other = CRMEntity::getInstance($related_module);

        // Some standard module class doesn't have required variables
        // that are used in the query, they are defined in this generic API
        vtlib_setup_modulevars($currentModule, $this);
        vtlib_setup_modulevars($related_module, $other);

        $singular_modname = 'SINGLE_' . $related_module;

        $button = '';
        if ($actions) {
            if (is_string($actions))
                $actions = explode(',', strtoupper($actions));
            if (in_array('SELECT', $actions) && isPermitted($related_module, 4, '') == 'yes') {
                $button .= "<input title='" . getTranslatedString('LBL_SELECT') . " " . getTranslatedString($related_module) . "' class='crmbutton small edit' " .
                    " type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\"" .
                    " value='" . getTranslatedString('LBL_SELECT') . " " . getTranslatedString($related_module, $related_module) . "'>&nbsp;";
            }
            if (in_array('ADD', $actions) && isPermitted($related_module, 1, '') == 'yes') {
                $button .= "<input type='hidden' name='createmode' id='createmode' value='link' />" .
                    "<input title='" . getTranslatedString('LBL_ADD_NEW') . " " . getTranslatedString($singular_modname) . "' class='crmbutton small create'" .
                    " onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
                    " value='" . getTranslatedString('LBL_ADD_NEW') . " " . getTranslatedString($singular_modname, $related_module) . "'>&nbsp;";
            }
        }

        // To make the edit or del link actions to return back to same view.
        if ($singlepane_view == 'true') {
            $returnset = "&return_module=$currentModule&return_action=DetailView&return_id=$id";
        } else {
            $returnset = "&return_module=$currentModule&return_action=CallRelatedList&return_id=$id";
        }

        $more_relation = '';
        if (!empty($other->related_tables)) {
            foreach ($other->related_tables as $tname => $relmap) {
                $query .= ", $tname.*";

                // Setup the default JOIN conditions if not specified
                if (empty($relmap[1]))
                    $relmap[1] = $other->table_name;
                if (empty($relmap[2]))
                    $relmap[2] = $relmap[0];
                $more_relation .= " LEFT JOIN ".$tname." ON ".$tname.".".$relmap[0]." = ".$relmap[1].".".$relmap[2]." ";
            }
        }

        $query = "SELECT vtiger_crmentity.*, ".$other->table_name.".*,
				FROM ".$other->table_name."
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = ".$other->table_name.".".$other->table_index." 
				".$more_relation."
				LEFT  JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
				LEFT  JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				WHERE vtiger_crmentity.deleted = 0 AND ".$other->table_name.".its4you_company = '".$id."'";

        $return_value = GetRelatedList($currentModule, $related_module, $other, $query, $button, $returnset);

        if ($return_value == null)
            $return_value = Array();
        $return_value['CUSTOM_BUTTON'] = $button;

        return $return_value;
    }

}
