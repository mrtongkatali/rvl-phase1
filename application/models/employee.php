<?php 
class Employee {

	function findById($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_EMPLOYEE . "
			WHERE id = " . Mapper::safeSql($params['id']) . "
			LIMIT 1
		";

		return Mapper::runActive($sql);
	}

	function findByEmployeeId($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_EMPLOYEE . "
			WHERE 
				employee_id = " . Mapper::safeSql($params['employee_id']) . "
			LIMIT 1
		";
		
		return Mapper::runActive($sql);
	}

	function findAll($fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . RVL_EMPLOYEE . "
		";
		return Mapper::runActive($sql, TRUE);
	}

	function isActiveExist($id) {
		$sql = " 
			SELECT id FROM " . RVL_EMPLOYEE . "
			WHERE 
				id = " . Mapper::safeSql($id) . " AND
				employee_status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
			LIMIT 1
		";

		$record = Mapper::runActive($sql);
		return ($record ? true : false);
	}

	function fetchRecords($params) {

		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);
		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);

		if($params['query']) {
			$q = $params['query'];
			$sqlsearchstring = "
				AND 
					employee_code LIKE '%".$q."%' OR
					firstname LIKE '%".$q."%' OR
					middlename LIKE '%".$q."%' OR
					lastname LIKE '%".$q."%' OR
					suffix LIKE '%".$q."%' OR
					full_name LIKE '%".$q."%' OR
					employee_status LIKE '%".$q."%'
			";
		}

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_EMPLOYEE . "
			WHERE
				(
					employee_status = " . Mapper::safeSql($params['status']) . "
				)

				{$sqlsearchstring}

			{$order}
			{$limit}

		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function countFetchedRecords($params) {
		if($params['query']) {
			$q = $params['query'];
			$sqlsearchstring = "
				AND 
					employee_code LIKE '%".$q."%' OR
					firstname LIKE '%".$q."%' OR
					middlename LIKE '%".$q."%' OR
					lastname LIKE '%".$q."%' OR
					suffix LIKE '%".$q."%' OR
					full_name LIKE '%".$q."%' OR
					employee_status LIKE '%".$q."%'
			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . RVL_EMPLOYEE . "
			WHERE
				(
					employee_status = " . Mapper::safeSql($params['status']) . "
				)

				{$sqlsearchstring}
		";
		
		$record = Mapper::runActive($sql);
		return $record['total'];
	}

	function validate_duplicate_email($email_address, $user_id) {
		if($email_address) {

			if($user_id) {
				$sql = " 
					SELECT id FROM " . RVL_EMPLOYEE . "
					WHERE 

					(
						id != " . Mapper::safeSql($user_id) . " AND
						email_address = " . Mapper::safeSql($email_address) . "
					)
					LIMIT 1
				";
			} else {
				$sql = " 
					SELECT id FROM " . RVL_EMPLOYEE . "
					WHERE 
					(
						email_address = " . Mapper::safeSql($email_address) . "
					)
					LIMIT 1
				";
			}

			$record = Mapper::runActive($sql);

			return ($record ? true : false);

		} else {
			return false;
		}
	}

	
	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . RVL_EMPLOYEE . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_EMPLOYEE . " SET ";
			$sqlend		= "";
		}

		$sqlbody 	= implode($arr," , ");
		$sql 		= $sqlstart.$sqlbody.$sqlend;
		
		Mapper::runSql($sql,false);
		if($id) {
			return $id;
		} else {
			return mysql_insert_id();
		}
	}


}

?>