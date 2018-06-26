<?php
/*+**********************************************************************************
 The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 ************************************************************************************/

class ITS4YouMultiCompany_ListView_Model extends Vtiger_ListView_Model {

//    public function getBasicLinks() {
//        // disable create Quick Reminder from List View
//    }


    public function getListViewEntries($pagingModel) {
        $db = PearDatabase::getInstance();

        $moduleName = $this->getModule()->get('name');
        $moduleFocus = CRMEntity::getInstance($moduleName);
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $queryGenerator = $this->get('query_generator');
        $listViewContoller = $this->get('listview_controller');

        $searchParams = $this->get('search_params');
        if(empty($searchParams)) {
            $searchParams = array();
        }
        $glue = "";
        if(count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
            $glue = QueryGenerator::$AND;
        }
        $queryGenerator->parseAdvFilterList($searchParams, $glue);

        $searchKey = $this->get('search_key');
        $searchValue = $this->get('search_value');
        $operator = $this->get('operator');
        if(!empty($searchKey)) {
            $queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
        }

        $orderBy = $this->get('orderby');
        $sortOrder = $this->get('sortorder');

        if(!empty($orderBy)){
            $queryGenerator = $this->get('query_generator');
            $fieldModels = $queryGenerator->getModuleFields();
            $orderByFieldModel = $fieldModels[$orderBy];
            if($orderByFieldModel && ($orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::REFERENCE_TYPE ||
                    $orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::OWNER_TYPE)){
                $queryGenerator->addWhereField($orderBy);
            }
        }
        $listQuery = $this->getQuery();

        $sourceModule = $this->get('src_module');
        if(!empty($sourceModule)) {
            if(method_exists($moduleModel, 'getQueryByModuleField')) {
                $overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery,$this->get('relationId'));
                if(!empty($overrideQuery)) {
                    $listQuery = $overrideQuery;
                }
            }
        }

        $startIndex = $pagingModel->getStartIndex();
        $pageLimit = $pagingModel->getPageLimit();

        if(!empty($orderBy) && $orderByFieldModel) {
            if($orderBy == 'roleid' && $moduleName == 'Users'){
                $listQuery .= ' ORDER BY vtiger_role.rolename '.' '. $sortOrder;
            } else {
                $listQuery .= ' ORDER BY '.$queryGenerator->getOrderByColumn($orderBy).' '.$sortOrder;
            }

            if ($orderBy == 'first_name' && $moduleName == 'Users') {
                $listQuery .= ' , last_name '.' '. $sortOrder .' ,  email1 '. ' '. $sortOrder;
            }
        } else if(empty($orderBy) && empty($sortOrder) && $moduleName != "Users"){
            //List view will be displayed on recently created/modified records
            $listQuery .= ' ORDER BY vtiger_crmentity.modifiedtime DESC';
        }

        $viewid = ListViewSession::getCurrentView($moduleName);
        if(empty($viewid)) {
            $viewid = $pagingModel->get('viewid');
        }
        $_SESSION['lvs'][$moduleName][$viewid]['start'] = $pagingModel->get('page');

        ListViewSession::setSessionQuery($moduleName, $listQuery, $viewid);

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
            if (isset($record['mc_role'])) {
                $rModel = ITS4YouMultiCompany_Record_Model::getInstanceById($recordId);
                $fieldModel = Vtiger_Field_Model::getInstance('mc_role', $rModel->getModule());
                if ($rawData['mc_role'] != '') {
                    $record['mc_role'] = $fieldModel->getDisplayValue($rawData['mc_role']);
                } else {
                    $record['mc_role'] = '--';
                }
            }
            $listViewRecordModels[$recordId] = $moduleModel->getRecordFromArray($record, $rawData);
        }
        return $listViewRecordModels;
    }
}
