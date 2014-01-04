<?php 
class Truck_List  {

	const SINGLE 	= "Single";
	const STRAIGHT 	= "Sraight";
	const TRAILER 	= "TRAILER";

	function findById($id, $fields = "") {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . TRUCK_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";

		return Mapper::runActive($sql);
	}

	function findAll() {
		$sql = " 
			SELECT * FROM " . TRUCK_LIST . "
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function findAllActive($fields = "", $order = "", $limit = "") {
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");

		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . TRUCK_LIST . "
			WHERE
				status = " . Mapper::safeSql(AVAILABLE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function findAllAvailable($params) {
		$order = ($order == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($limit == "" ? "" : " LIMIT " . $params['limit']);

		if($params['delivery_type'] == SPECIAL) {

			$sql = " 
				SELECT " . field_injector($params['fields']) . " FROM " . TRUCK_LIST . "
				WHERE
					remaining 	>= " . Mapper::safeSql($params['total_load']) . " AND
					status 		= " . Mapper::safeSql(AVAILABLE) . " AND
					truck_type	= " . Mapper::safeSql(self::SINGLE) . " AND
					is_archive 	= " . Mapper::safeSql(NO) . "

				{$order}
				{$limit}
			";

		} else {

			$sql = " 
				SELECT " . field_injector($params['fields']) . " FROM " . TRUCK_LIST . "
				WHERE
					remaining 	>= " . Mapper::safeSql($params['total_load']) . " AND
					status 		= " . Mapper::safeSql(AVAILABLE) . " AND
					is_archive 	= " . Mapper::safeSql(NO) . "

				{$order}
				{$limit}
			";

		}
		
		return Mapper::runActive($sql, TRUE);
	}

	function findAllAvailablePorterByName($q, $driver_id, $fields = "", $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");

		$fields = field_injector($fields);

		$q = mysql_real_escape_string($q);

		$sql = " 
			SELECT {$fields} FROM " . TRUCK_LIST . "
			WHERE 
				id != " . Mapper::safeSql($driver_id) . " AND
				status = " . Mapper::safeSql(ACTIVE) . " AND
				(
					firstname LIKE  '%" . $q . "%' OR 
					middlename LIKE  '%" . $q . "%' OR 
					lastname LIKE  '%" . $q . "%'
				)

			{$order}
			{$limit}
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function findByPlateNo($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . TRUCK_LIST . "
			WHERE 
				plate_number = " . Mapper::safeSql($params['plate_no']) . "
			LIMIT 1
		";

		return Mapper::runActive($sql);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . TRUCK_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . TRUCK_LIST . " SET ";
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
			DELETE FROM " . TRUCK_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

	function update_truck_load($params, $revert = FALSE) {

		$id 	= $params['truck_id'];
		$truck 	= self::findById($id);

		if(!$revert) {
			$remaining 	= $truck['remaining'] - $params['total_load'];
		} else {
			$remaining 	= $truck['remaining'] + $params['total_load'];
		}
		
		$status = ($remaining > 0 ? AVAILABLE : NOTAVAILABLE);
		$record = array(
			"status" 	=> $status,
			"remaining" => $remaining,
		);

		self::save($record,$truck['id']);
	}

}

?>