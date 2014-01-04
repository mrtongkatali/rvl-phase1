<?php 
class Trip_Rates {

	function findById($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_TRIP_RATES . "
			WHERE id = " . Mapper::safeSql($params['id']) . "
			LIMIT 1
		";
	
		return Mapper::runActive($sql);
	}

	function findAll($params) {
		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_TRIP_RATES . "

			{$order}
			{$limit}
		";

		return Mapper::runActive($sql, TRUE);
	}

	function findCorrespondingCost($params) {
		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_TRIP_RATES . "
			WHERE
				client_id 			= " . Mapper::safeSql($params['client_id']) . " AND
				pick_up_point 		= " . Mapper::safeSql($params['pick_up_point']) . " AND
				delivery_address 	= " . Mapper::safeSql($params['delivery_address']) . " AND
				trip_type 			= " . Mapper::safeSql($params['trip_type']) . "
			
			LIMIT 1
		";
		
		return Mapper::runActive($sql);
	}

	function countClearedPlansDatatable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					delivery_no LIKE  '%" . $q . "%' OR
					client_name LIKE  '%" . $q . "%' OR
					driver_name LIKE  '%" . $q . "%' OR
					other_driver_name LIKE  '%" . $q . "%' OR
					plate_no LIKE  '%" . $q . "%' OR
					status LIKE  '%" . $q . "%'
				AND

			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . RVL_TRIP_RATES . "
			WHERE
				{$search}
				client_id 	= " . Mapper::safeSql($params['client_id']) . " AND
				status 		= " . Mapper::safeSql(CLEARED) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runActive($sql);
		return $record['total'];
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . RVL_TRIP_RATES . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_TRIP_RATES . " SET ";
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
			DELETE FROM " . RVL_TRIP_RATES . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>