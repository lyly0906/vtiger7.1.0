<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Departments Record Model Class
 */
class Settings_Departments_Record_Model extends Settings_Vtiger_Record_Model {

	/**
	 * Function to get the Id
	 * @return <Number> Role Id
	 */
	public function getId() {
		return $this->get('departmentid');
	}

	/**
	 * Function to get the Role Name
	 * @return <String>
	 */
	public function getName() {
		return $this->get('departmentname');
	}

	/**
	 * Function to get the depth of the department
	 * @return <Number>
	 */
	public function getDepth() {
		return $this->get('depth');
	}
    /**
     * Function to get the synlhc of the group
     * @return <String>
     */
    public function getSynlhc() {
        return $this->get('synlhc');
    }

	public function getCompanyId() {
		return $this->get('companyId');
	}

	/**
	 * Function to get Parent Role hierarchy as a string
	 * @return <String>
	 */
	public function getParentDepartmentstring() {
		return $this->get('parentdepartment');
	}

	/**
	 * Function to set the immediate parent department
	 * @return <Settings_Departments_Record_Model> instance
	 */
	public function setParent($parentRole) {
		$this->parent = $parentRole;
		return $this;
	}

	/**
	 * Function to get the immediate parent department
	 * @return <Settings_Departments_Record_Model> instance
	 */
	public function getParent() {
		if(!$this->parent) {
			$parentDepartmentstring = $this->getParentDepartmentstring();
			$parentComponents = explode('::', $parentDepartmentstring);
			$noOfDepartments = count($parentComponents);
			// $currentRole = $parentComponents[$noOfDepartments-1];
			if($noOfDepartments > 1) {
				$this->parent = self::getInstanceById($parentComponents[$noOfDepartments-2]);
			} else {
				$this->parent = null;
			}
		}
		return $this->parent;
	}

	/**
	 * Function to get the immediate children Departments
	 * @return <Array> - List of Settings_Departments_Record_Model instances
	 */
	public function getChildren() {
		$db = PearDatabase::getInstance();
		if(!$this->children) {
			$parentDepartmentstring = $this->getParentDepartmentstring();
			$currentRoleDepth = $this->getDepth();

			$currentUsersModel = Users_Record_Model::getCurrentUserModel();
			$currentUserId = $currentUsersModel->getId();
			$its4you_company = 0;


			if($currentUserId != 1){
				$its4you_company = ITS4YouMultiCompany_Record_Model::getCompanyByUserId($currentUserId)->getId();

				if($its4you_company && $currentRoleDepth == 0)
					$currentRoleDepth = 1;
				$sql = 'SELECT * FROM vtiger_department WHERE parentdepartment LIKE ? AND depth = ? AND its4you_company = ?';
				$params = array($parentDepartmentstring.'::%', $currentRoleDepth+1, $its4you_company);
			}else{
				$sql = 'SELECT * FROM vtiger_department WHERE parentdepartment LIKE ? AND depth = ?';
				$params = array($parentDepartmentstring.'::%', $currentRoleDepth+1);
			}

			$result = $db->pquery($sql, $params);

			$noOfDepartments = $db->num_rows($result);
			$Departments = array();
			for ($i=0; $i<$noOfDepartments; ++$i) {
				$department = self::getInstanceFromQResult($result, $i);
				$Departments[$department->getId()] = $department;
			}
			$this->children = $Departments;
		}
		return $this->children;
	}
	
	public function getSameLevelDepartments() {
		$db = PearDatabase::getInstance();
		if(!$this->children) {
			$parentDepartments = getParentRole($this->getId());
			$currentRoleDepth = $this->getDepth();
			$parentDepartmentstring = '';
			foreach ($parentDepartments as $key => $department) {
				if(empty($parentDepartmentstring)) $parentDepartmentstring = $department;
				else $parentDepartmentstring = $parentDepartmentstring.'::'.$department;
			}
			$sql = 'SELECT * FROM vtiger_department WHERE parentdepartment LIKE ? AND depth = ?';
			$params = array($parentDepartmentstring.'::%', $currentRoleDepth);
			$result = $db->pquery($sql, $params);
			$noOfDepartments = $db->num_rows($result);
			$Departments = array();
			for ($i=0; $i<$noOfDepartments; ++$i) {
				$department = self::getInstanceFromQResult($result, $i);
				$Departments[$department->getId()] = $department;
			}
			$this->children = $Departments;
		}
		return $this->children;
	}

	/**
	 * Function to get all the children Departments
	 * @return <Array> - List of Settings_Departments_Record_Model instances
	 */
	public function getAllChildren() {
		$db = PearDatabase::getInstance();

		$parentDepartmentstring = $this->getParentDepartmentstring();

		$sql = 'SELECT * FROM vtiger_department WHERE parentdepartment LIKE ? ORDER BY depth';
		$params = array($parentDepartmentstring.'::%');
		$result = $db->pquery($sql, $params);
		$noOfDepartments = $db->num_rows($result);
		$Departments = array();
		for ($i=0; $i<$noOfDepartments; ++$i) {
			$department = self::getInstanceFromQResult($result, $i);
			$Departments[$department->getId()] = $department;
		}
		return $Departments;
	}
    
	/**
	 * Function returns profiles related to the current department
	 * @return <Array> - profile ids
	 */
    public function getProfileIdList(){
        
        $db = PearDatabase::getInstance();
        $query = 'SELECT profileid FROM vtiger_department2profile WHERE departmentid=?';
        
        $result = $db->pquery($query,array($this->getId()));
        $num_rows = $db->num_rows($result);
        
        $profilesList = array();
        for($i=0; $i<$num_rows; $i++) {
            $profilesList[] = $db->query_result($result,$i,'profileid');
        }
        return $profilesList;
    }
    
    /**
     * Function to get the profile id if profile is directly related to department
     * @return id
     */
    public function getDirectlyRelatedProfileId() {
        //TODO : see if you need cache the result
        $departmentId = $this->getId();
        if(empty($departmentId)) {
            return false;
        }
        
        $db = PearDatabase::getInstance();
        
        $query = 'SELECT directly_related_to_department, vtiger_profile.profileid FROM vtiger_department2profile 
                  INNER JOIN vtiger_profile ON vtiger_profile.profileid = vtiger_department2profile.profileid 
                  WHERE vtiger_department2profile.departmentid=?';
        $params = array($this->getId());
        
        $result = $db->pquery($query,$params);
        
		if($db->num_rows($result) == 1 && $db->query_result($result,0,'directly_related_to_department') == '1'){
           return $db->query_result($result, 0, 'profileid');
        }
        return false;
    }

	/**
	 * Function to get the Edit View Url for the Role
	 * @return <String>
	 */
	public function getEditViewUrl() {
		return 'index.php?module=Departments&parent=Settings&view=Edit&record='.$this->getId();
	}

//	public function getListViewEditUrl() {
//		return '?module=Departments&parent=Settings&view=Edit&record='.$this->getId();
//	}

	/**
	 * Function to get the Create Child Role Url for the current department
	 * @return <String>
	 */
	public function getCreateChildUrl() {
		return '?module=Departments&parent=Settings&view=Edit&parent_departmentid='.$this->getId();
	}

	/**
	 * Function to get the Delete Action Url for the current department
	 * @return <String>
	 */
	public function getDeleteActionUrl() {
		return '?module=Departments&parent=Settings&view=DeleteAjax&record='.$this->getId();
	}

	/**
	 * Function to get the Popup Window Url for the current department
	 * @return <String>
	 */
	public function getPopupWindowUrl() {
		return 'module=Departments&parent=Settings&view=Popup&src_record='.$this->getId();
	}

	/**
	 * Function to get all the profiles associated with the current department
	 * @return <Array> Settings_Profiles_Record_Model instances
	 */
	public function getProfiles() {
		if(!$this->profiles) {
			$this->profiles = Settings_Profiles_Record_Model::getAllByRole($this->getId());
		}
		return $this->profiles;
	}

	/**
	 * Function to add a child department to the current department
	 * @param <Settings_Departments_Record_Model> $department
	 * @return Settings_Departments_Record_Model instance
	 */
	public function addChildRole($department) {
		$department->setParent($this);
		$department->save();
		return $department;
	}

	/**
	 * Function to move the current department and all its children nodes to the new parent department
	 * @param <Settings_Departments_Record_Model> $newParentRole
	 */
	public function moveTo($newParentRole) {
		$currentDepth = $this->getDepth();
		$currentParentDepartmentstring = $this->getParentDepartmentstring();

		$newDepth = $newParentRole->getDepth() + 1;
		$newParentDepartmentstring = $newParentRole->getParentDepartmentstring() .'::'. $this->getId();

		$depthDifference = $newDepth - $currentDepth;
		$allChildren = $this->getAllChildren();

		$this->set('depth', $newDepth);
		$this->set('parentdepartment', $newParentDepartmentstring);
		$this->set('allowassignedrecordsto', $this->get('allowassignedrecordsto'));
		$this->save();

		foreach($allChildren as $departmentId => $departmentModel) {
			$oldChildDepth = $departmentModel->getDepth();
			$newChildDepth = $oldChildDepth + $depthDifference;

			$oldChildParentDepartmentstring = $departmentModel->getParentDepartmentstring();
			$newChildParentDepartmentstring = str_replace($currentParentDepartmentstring, $newParentDepartmentstring, $oldChildParentDepartmentstring);

			$departmentModel->set('depth', $newChildDepth);
			$departmentModel->set('parentdepartment', $newChildParentDepartmentstring);
			$departmentModel->set('allowassignedrecordsto', $departmentModel->get('allowassignedrecordsto'));
			$departmentModel->save();
		}
	}

	/**
	 * Function to save the department
	 */
	public function save() {
		$db = PearDatabase::getInstance();
		$departmentId = $this->getId();
		$mode = 'edit';
		if(empty($departmentId)) {
			$mode = '';
			$departmentIdNumber = $db->getUniqueId('vtiger_department');
			$departmentId = 'D'.$departmentIdNumber;
		}
		$parentRole = $this->getParent();
		if($parentRole != null) {
			$this->set('depth', $parentRole->getDepth()+1);
			$this->set('parentdepartment', $parentRole->getParentDepartmentstring() .'::'. $departmentId);
		}
		if($mode == 'edit') {
			$sql = 'UPDATE vtiger_department SET departmentname=?, parentdepartment=?, depth=?,synlhc=?, allowassignedrecordsto=?,its4you_company=? WHERE departmentid=?';

			$params = array($this->getName(), $this->getParentDepartmentstring(), $this->getDepth(),$this->getSynlhc(), $this->get('allowassignedrecordsto'), $this->getCompanyId(), $departmentId);

			$db->pquery($sql, $params);
		} else {
			$sql = 'INSERT INTO vtiger_department(departmentid, departmentname, parentdepartment, depth, allowassignedrecordsto,synlhc,its4you_company) VALUES (?,?,?,?,?,?,?)';

			$params = array($departmentId, $this->getName(), $this->getParentDepartmentstring(), $this->getDepth(), $this->get('allowassignedrecordsto'),$this->getSynlhc(),$this->getCompanyId());
			file_put_contents("log.txt", "------sql--".var_export($params,true), FILE_APPEND);
			$db->pquery($sql, $params);
            $this->set("departmentid",$departmentId);
		}

	}

	/**
	 * Function to delete the department
	 * @param <Settings_Departments_Record_Model> $transferToRole
	 */
	public function delete($transferToRole) {
		require_once('modules/Users/CreateUserPrivilegeFile.php');
		$db = PearDatabase::getInstance();
		$departmentId = $this->getId();

		$db->pquery('DELETE FROM vtiger_department WHERE departmentid=?', array($departmentId));

		$allChildren = $this->getAllChildren();
		$transferParentDepartmentsequence = $transferToRole->getParentDepartmentstring();
		$currentParentDepartmentsequence = $this->getParentDepartmentstring();

		foreach($allChildren as $departmentId => $departmentModel) {
			$oldChildParentDepartmentstring = $departmentModel->getParentDepartmentstring();
			$newChildParentDepartmentstring = str_replace($currentParentDepartmentsequence, $transferParentDepartmentsequence, $oldChildParentDepartmentstring);
			$newChildDepth = count(explode('::', $newChildParentDepartmentstring))-1;
			$departmentModel->set('depth', $newChildDepth);
			$departmentModel->set('parentdepartment', $newChildParentDepartmentstring);
			$departmentModel->save();
		}

	}

	/**
	 * Function to get the list view actions for the record
	 * @return <Array> - Associate array of Vtiger_Link_Model instances
	 */
	public function getRecordLinks() {

		$links = array();
		if($this->getParent()) {
			$recordLinks = array(
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_EDIT_RECORD',
					'linkurl' => $this->getListViewEditUrl(),
					'linkicon' => 'icon-pencil'
				),
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_DELETE_RECORD',
					'linkurl' => $this->getDeleteActionUrl(),
					'linkicon' => 'icon-trash'
				)
			);
			foreach($recordLinks as $recordLink) {
				$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
			}
		}

		return $links;
	}

	/**
	 * Function to get the instance of Departments record model from query result
	 * @param <Object> $result
	 * @param <Number> $rowNo
	 * @return Settings_Departments_Record_Model instance
	 */
	public static function getInstanceFromQResult($result, $rowNo) {
		$db = PearDatabase::getInstance();
		$row = $db->query_result_rowdata($result, $rowNo);
		$department = new self();
		return $department->setData($row);
	}

	/**
	 * Function to get all the Departments
	 * @param <Boolean> $baseRole
	 * @return <Array> list of Role models <Settings_Departments_Record_Model>
	 */
	public static function getAll($baseRole = false) {
		$db = PearDatabase::getInstance();
		$params = array();

		$sql = 'SELECT * FROM vtiger_department';
		if (!$baseRole) {
			$sql .= ' WHERE depth != ?';
			$params[] = 0;
		}
		$sql .= ' ORDER BY parentdepartment';

		$result = $db->pquery($sql, $params);
		$noOfDepartments = $db->num_rows($result);

		$Departments = array();
		for ($i=0; $i<$noOfDepartments; ++$i) {
			$department = self::getInstanceFromQResult($result, $i);
			$Departments[$department->getId()] = $department;
		}
		return $Departments;
	}

	/**
	 * Function to get the instance of Role model, given department id
	 * @param <Integer> $departmentId
	 * @return Settings_Departments_Record_Model instance, if exists. Null otherwise
	 */
	public static function getInstanceById($departmentId) {
		$db = PearDatabase::getInstance();
        
        $instance = Vtiger_Cache::get('departmentById',$departmentId);
        if($instance){
            return $instance;
        }
        
        $sql = 'SELECT * FROM vtiger_department WHERE departmentid = ?';
        $params = array($departmentId);
        $result = $db->pquery($sql, $params);
        if($db->num_rows($result) > 0) {
            $instance =  self::getInstanceFromQResult($result, 0);
            Vtiger_Cache::set('departmentById',$departmentId,$instance);
            return $instance;
        }
		return null;
	}

	/**
	 * Function to get the instance of Base Role model
	 * @return Settings_Departments_Record_Model instance, if exists. Null otherwise
	 */
	public static function getBaseDepartment() {
		$db = PearDatabase::getInstance();

		$sql = 'SELECT * FROM vtiger_department WHERE depth=0 LIMIT 1';
		$params = array();
		$result = $db->pquery($sql, $params);
		if($db->num_rows($result) > 0) {
			return self::getInstanceFromQResult($result, 0);
		}
		return null;
	}
	
	/* Function to get the instance of the department by Name
    * @param type $name -- name of the department
    * @return null/department instance
    */
   public static function getInstanceByName($name,$excludedRecordId = array(), $companyId = '') {
       $db = PearDatabase::getInstance();
       $sql = 'SELECT * FROM vtiger_department WHERE departmentname=? and its4you_company=?';
       $params = array($name,$companyId);
       if(!empty($excludedRecordId)){
           $sql.= ' AND departmentid NOT IN ('.generateQuestionMarks($excludedRecordId).')';
           $params = array_merge($params,$excludedRecordId);
       }
       $result = $db->pquery($sql, $params);
       if($db->num_rows($result) > 0) {
		   return self::getInstanceFromQResult($result, 0);
	   }
	   return null;
   }

   /**
    * Function to get Users who are from this department
    * @return <Array> User record models list <Users_Record_Model>
    */
   public function getUsers() {
	   $db = PearDatabase::getInstance();
	   $result = $db->pquery('SELECT id FROM vtiger_users WHERE department = ?', array($this->getName()));
	   $numOfRows = $db->num_rows($result);

	   $usersList = array();
	   for($i=0; $i<$numOfRows; $i++) {
		   $userId = $db->query_result($result, $i, 'id');
		   $usersList[$userId] = Users_Record_Model::getInstanceById($userId, 'Users');
	   }
	   return $usersList;
   }

   public function updateUsersDepartment($department,$olddepartment){
       $db = PearDatabase::getInstance();
       $db->pquery("update vtiger_users set department=? where department=?", array($department, $olddepartment));
   }

   public function checkDuplicateDepartment($departmentName, $companyId = ''){
       $status = false;
       // To check username existence in db
       $db = PearDatabase::getInstance();
       	$query = 'SELECT user_name FROM vtiger_department WHERE departmentname = ? and its4you_company = ?';

       file_put_contents("log.txt", "------group--query--".var_export($query,true), FILE_APPEND);
       $result = $db->pquery($query, array($departmentName,$companyId));
       if ($db->num_rows($result) > 0) {
           $status = true;
       }
       return $status;
   }


    //根据部门获取lhc部门对应的id
    public function getOutApplyDepartmentId($appid){
        $db = PearDatabase::getInstance();
        $appudepartment = array();
        $recordId = $this->getId();
        if ($recordId) {
            // Not a good approach to get all the fields if not required(May lead to Performance issue)
            $query = "select  app.id,app.appname,appuse.outdepartmentid,appuse.departmentid  from vtiger_out_app app LEFT JOIN vtiger_outapp_department_relation appuse
                            on app.id = appuse.appid
                            where app.status = 1 and appuse.departmentid = ? AND app.id=?";
            $result = $db->pquery($query, array($recordId,$appid));

            $appId = $db->query_result($result, 0, 'id');
            $appName = $db->query_result($result, 0, 'appname');
            $outdepartmentid = $db->query_result($result, 0, 'outdepartmentid');
            $departmentid = $db->query_result($result, 0, 'departmentid');
            $appudepartment[] = array(
                'id' => $appId,
                'appName' => $appName,
                'outdepartmentid' => $outdepartmentid,
                'departmentid' => $departmentid
            );
        }

        return $appudepartment;
    }

    //把部门添加到vtiger_outapp_department_relation里面
    public function saveApplyDepartmentId($departmentid,$outdepartmentid,$appId){
        $db = PearDatabase::getInstance();
        $query = "insert into vtiger_outapp_department_relation(`outdepartmentid`,`departmentid`,`appid`) VALUES (?,?,?)";
        $db->pquery($query, array($outdepartmentid,$departmentid,$appId));
    }


}