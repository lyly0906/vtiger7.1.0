<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Books_ListView_Model extends Vtiger_ListView_Model {

	/**
	 * Static Function to get the Instance of Vtiger ListView model for a given module and custom view
	 * @param <String> $moduleName - Module Name
	 * @param <Number> $viewId - Custom View Id
	 * @return Vtiger_ListView_Model instance
	 */
	public static function getInstance($moduleName, $sourceModule) {
		$db = PearDatabase::getInstance();
		$currentUser = vglobal('current_user');

		$modelClassName = Vtiger_Loader::getComponentClassName('Model', 'ListView', $moduleName);
		$instance = new $modelClassName();
		$sourceModuleModel = Vtiger_Module_Model::getInstance($sourceModule);
		$queryGenerator = new EnhancedQueryGenerator($sourceModuleModel->get('name'), $currentUser);

        $customView = new CustomView();
        if (!empty($viewId) && $viewId != "0") {
            $queryGenerator->initForCustomViewById($viewId);

            //Used to set the viewid into the session which will be used to load the same filter when you refresh the page
            $viewId = $customView->getViewId($sourceModule);
        } else {
            $viewId = $customView->getViewId($sourceModule);
            if(!empty($viewId) && $viewId != 0) {
                $queryGenerator->initForDefaultCustomView();
            } else {
                $entityInstance = CRMEntity::getInstance($sourceModule);
                $listFields = $entityInstance->list_fields_name;
                $listFields[] = 'id';
                $queryGenerator->setFields($listFields);
            }
        }

        $fieldsList = $queryGenerator->getFields();

        if(!empty($listHeaders) && is_array($listHeaders) && count($listHeaders) > 0) {
            $fieldsList = $listHeaders;
            $fieldsList[] = 'id';
        }
        //to show starred field in list view
        $fieldsList[] = 'starred';

        $queryGenerator->setFields($fieldsList);
        $moduleSpecificControllerPath = 'modules/'.$sourceModule.'/controllers/ListViewController.php';
        if(file_exists($moduleSpecificControllerPath)) {
            include_once $moduleSpecificControllerPath;
            $moduleSpecificControllerClassName = $sourceModule.'ListViewController';
            $controller = new $moduleSpecificControllerClassName($db, $currentUser, $queryGenerator);
        } else {
            $controller = new ListViewController($db, $currentUser, $queryGenerator);
        }
		return $instance->set('module', $sourceModuleModel)->set('query_generator', $queryGenerator)->set('listview_controller', $controller);

	}



	/**
	 * Function to get the list view entries
	 * @param Vtiger_Paging_Model $pagingModel
	 * @return <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
	 */
	public function getListViewEntries($pagingModel) {
		$db = PearDatabase::getInstance();
		$moduleName = $this->getModule()->get('name');

		$moduleFocus = CRMEntity::getInstance($moduleName);
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$queryGenerator = $this->get('query_generator');
		$listViewContoller = $this->get('listview_controller');

		$orderBy = $this->get('orderby');
		$sortOrder = $this->get('sortorder');

		$searchParams = $this->get('search_params');

		if(empty($searchParams)) {
			$searchParams = array();
		}
		$glue = "";
		if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
			$glue = QueryGenerator::$AND;
		}

		$queryGenerator->parseAdvFilterList($searchParams, $glue);

		if(!empty($orderBy)){
			$queryGenerator = $this->get('query_generator');
			$fieldModels = $queryGenerator->getModuleFields();
			$orderByFieldModel = $fieldModels[$orderBy];
			if($orderByFieldModel && ($orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::REFERENCE_TYPE ||
					$orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::OWNER_TYPE)){
				$queryGenerator->addWhereField($orderBy);
			}
		}
		if($moduleName == 'Documents'){
			//Document source required in list view for managing delete 
			$listViewFields = $queryGenerator->getFields(); 
			if(!in_array('document_source', $listViewFields)){ 
				$listViewFields[] = 'document_source'; 
			}
			$queryGenerator->setFields($listViewFields);
		}

		$listQuery = $this->getQuery();

		$currentUsersModel = Users_Record_Model::getCurrentUserModel();
		$currentUserModelId = $currentUsersModel->getRole();
		if($currentUserModelId != 'H2'){
			$subModelArr = getRoleSubordinates($currentUserModelId);
			array_unshift($subModelArr,$currentUserModelId);
			$roleStr = "'".implode("','", $subModelArr)."'";
			$listQuery = str_replace(array("FROM vtiger_users", "WHERE vtiger_users.status='Active'"),array("FROM vtiger_users left join vtiger_user2role vu ON vtiger_users.id = vu.userid", "WHERE vu.roleid in (".$roleStr.") and vtiger_users.status='Active'"), $listQuery);
		}

		//file_put_contents("log.txt", "------$listQuery-----------" . var_export($listQuery, true), FILE_APPEND);
		$listQuery = preg_replace("/vtiger_crmentity.deleted\s*=\s*0/i", 'vtiger_crmentity.deleted = 1', $listQuery);

		$startIndex = $pagingModel->getStartIndex();
		$pageLimit = $pagingModel->getPageLimit();

		if(!empty($orderBy) && $orderByFieldModel) {
			$listQuery .= ' ORDER BY '.$queryGenerator->getOrderByColumn($orderBy).' '.$sortOrder;
		} else if(empty($orderBy) && empty($sortOrder)){
			//List view will be displayed on recently created/modified records
			$listQuery .= ' ORDER BY id DESC';
		}
		$listQuery .= " LIMIT $startIndex,".($pageLimit+1);

		$listResult = $db->pquery($listQuery, array());

		$listViewRecordModels = array();

		$listViewEntries =  $listViewContoller->getListViewRecords($moduleFocus,$moduleName, $listResult);
		$pagingModel->calculatePageRange($listViewEntries);

		if($db->num_rows($listResult) > $pageLimit){
			array_pop($listViewEntries);
			$pagingModel->set('nextPageExists', true);
		}else{
			$pagingModel->set('nextPageExists', false);
		}

		$index = 0;
		foreach($listViewEntries as $recordId => $record) {
			$rawData = $db->query_result_rowdata($listResult, $index++);
			$record['id'] = $recordId;
			$listViewRecordModels[$recordId] = $moduleModel->getRecordFromArray($record, $rawData);
		}

		return $listViewRecordModels;
	}

	/**
	 * Function to get the list view entries
	 * @param Vtiger_Paging_Model $pagingModel
	 * @return <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
	 */
	public function getListViewCount() {
		$db = PearDatabase::getInstance();

		$queryGenerator = $this->get('query_generator');

		$searchParams = $this->get('search_params');
		if(empty($searchParams)) {
			$searchParams = array();
		}

		$glue = "";
		if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
			$glue = QueryGenerator::$AND;
		}
		$queryGenerator->parseAdvFilterList($searchParams, $glue);

		$listQuery = $queryGenerator->getQuery();
		$listQuery = preg_replace("/vtiger_crmentity.deleted\s*=\s*0/i", 'vtiger_crmentity.deleted = 1', $listQuery);

		$position = stripos($listQuery, ' from ');
		if ($position) {
			$split = spliti(' from ', $listQuery);
			$splitCount = count($split);
			$listQuery = 'SELECT count(*) AS count ';
			for ($i=1; $i<$splitCount; $i++) {
				$listQuery = $listQuery. ' FROM ' .$split[$i];
			}
		}

		if($this->getModule()->get('name') == 'Calendar'){
			$listQuery .= ' AND activitytype <> "Emails"';
		}

		$listResult = $db->pquery($listQuery, array());
		$listViewCount = $db->query_result($listResult, 0, 'count');
		return $listViewCount;
	}

}