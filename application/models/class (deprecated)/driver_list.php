<?php 
class Driver_List {

	public static function findById($id, $fields = "") {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DRIVER_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findByEmployeeId($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DRIVER_LIST . "
			WHERE employee_id = " . Mapper::safeSql($params['employee_id']) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . DRIVER_LIST . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActive($fields = "", $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DRIVER_LIST . "
			WHERE
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAssignedPorter($truck_id, $fields = "") {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DRIVER_LIST . "
			WHERE
				assigned_truck_id = " . Mapper::safeSql($truck_id) . " AND
				assigned_type = " . Mapper::safeSql(PORTER) . " AND
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
				LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAssignedJockey($truck_id, $fields = "") {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DRIVER_LIST . "
			WHERE
				assigned_truck_id = " . Mapper::safeSql($truck_id) . " AND
				assigned_type = " . Mapper::safeSql(JOCKEY) . " AND
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
				LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllDriversExcept($driver_id, $fields = "", $order = "", $limit = "") {
		
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DRIVER_LIST . "
			WHERE 
				id != " . Mapper::safeSql($driver_id) . " AND
				status = " . Mapper::safeSql(ACTIVE) . "
			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllAvailablePorterByName($q, $driver_id, $fields = "", $order = "", $limit = "") {
		
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$fields = field_injector($fields);

		$q = mysql_real_escape_string($q);

		$sql = " 
			SELECT {$fields} FROM " . DRIVER_LIST . "
			WHERE 
				id != " . Mapper::safeSql($driver_id) . " AND
				status = " . Mapper::safeSql(ACTIVE) . " AND
				(
					firstname LIKE  '%" . $q . "%' OR 
					middlename LIKE  '%" . $q . "%' OR 
					lastname LIKE  '%" . $q . "%'
				)

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function generateDriverListDatatable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					firstname LIKE  '%" . $q . "%' OR
					middlename LIKE  '%" . $q . "%' OR
					lastname LIKE  '%" . $q . "%' OR
					full_name LIKE  '%" . $q . "%' OR
					driver_license LIKE  '%" . $q . "%' OR
					status LIKE  '%" . $q . "%'
				)

				AND

			";
		}

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['field_injector']) . " FROM " . DRIVER_LIST . "
			WHERE
				{$search}
				status 		= " . Mapper::safeSql(ACTIVE) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}

		";

		return Mapper::runSql($sql,true,true);
	}

	public static function countDriverListDatatable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					firstname LIKE  '%" . $q . "%' OR
					middlename LIKE  '%" . $q . "%' OR
					lastname LIKE  '%" . $q . "%' OR
					full_name LIKE  '%" . $q . "%' OR
					driver_license LIKE  '%" . $q . "%' OR
					status LIKE  '%" . $q . "%'
				)

				AND

			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . DRIVER_LIST . "
			WHERE
				{$search}
				status 		= " . Mapper::safeSql(ACTIVE) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . DRIVER_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . DRIVER_LIST . " SET ";
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

	public static function delete($id) {
		$sql = "
			DELETE FROM " . DRIVER_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>