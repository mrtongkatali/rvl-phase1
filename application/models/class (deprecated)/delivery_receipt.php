<?php 
class Delivery_Receipt {

	public static function findById($id, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DELIVERY_RECEIPT . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll($fields, $order = "", $limit = "", $condition) {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DELIVERY_RECEIPT . "

			{$order}
			{$limit}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllByDeliveryNo($params) {
		$limit = ($limit == "" ? "" : " LIMIT " . $params['limit']);
		$order = ($order == "" ? "" : " ORDER BY " . $params['order']);
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
			WHERE
				delivery_no = " . Mapper::safeSql($params['delivery_no']) . "

			{$order}
			{$limit}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllClientDrPlansByDateRange($params) {

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
			WHERE
				client_id = " . Mapper::safeSql($params['client_id']) . " AND
				delivery_date BETWEEN " . Mapper::safeSql($params['from']) . " AND " . Mapper::safeSql($params['to']) . " AND
				billing_status = " . Mapper::safeSql(BILLED) . " AND
				is_already_generated = " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}

		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllNotBilled($fields, $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DELIVERY_RECEIPT . "
			WHERE
				billing_status = " . Mapper::safeSql(PENDING) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}
		";
			
		return Mapper::runSql($sql,true,true);
	}

	public static function countAllNotBilled() {
		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				billing_status = " . Mapper::safeSql(PENDING) . " AND
				is_archive = " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}
	

	public static function searchByStatus($query, $status, $fields, $order = "", $limit = "") {
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");

		if($status != "all") {
			$status = " AND status = " . Mapper::safeSql($status);
		} else {
			$status = "";
		}

		$sql = "

			SELECT " . field_injector($fields) . " FROM " . DELIVERY_RECEIPT . "
			WHERE
			(
				delivery_no LIKE  '%" . $query . "%' OR
				client_name LIKE  '%" . $query . "%' OR
				driver_name LIKE  '%" . $query . "%' OR
				other_driver_name LIKE  '%" . $query . "%' OR
				plate_no LIKE  '%" . $query . "%' OR
				delivery_date LIKE  '%" . date("Y-m-d",strtotime($query)) . "%'
			)

			AND billing_status = " . Mapper::safeSql(PENDING) . "
			{$status}

			{$order}
			{$limit}
		";
		
		return Mapper::runSql($sql,true,true);
	}

	public static function countByStatus($query, $status) {

		if($status != "all") {
			$status = " AND status = " . Mapper::safeSql($status);
		} else {
			$status = "";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
			(
				delivery_no LIKE  '%" . $query . "%' OR
				client_name LIKE  '%" . $query . "%' OR
				driver_name LIKE  '%" . $query . "%' OR
				other_driver_name LIKE  '%" . $query . "%' OR
				plate_no LIKE  '%" . $query . "%' OR
				delivery_date LIKE  '%" . date("Y-m-d",strtotime($query)) . "%'
			)

			AND billing_status = " . Mapper::safeSql(PENDING) . "
			{$status}
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}	

	public static function countTotalRecords() {
		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function getNextIncrementId() {
		$sql = "
			SELECT id FROM " . DELIVERY_RECEIPT . " 
			ORDER BY id DESC
			LIMIT 1
		";

		$record =  Mapper::runSql($sql,true,false);
		return ($record ? (int) $record['id'] + 1 : 1);
	}

	public static function findByDeliveryNo($delivery_no, $fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . DELIVERY_RECEIPT . "
			WHERE delivery_no = " . Mapper::safeSql($delivery_no) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findByDeliveryDetails($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
			WHERE 
				delivery_no 	= " . Mapper::safeSql($params['delivery_no']) . " AND
				client_id 		= " . Mapper::safeSql($params['client_id']) . " AND
				(
					status 			= " . Mapper::safeSql(APPROVED) . " OR 
					status 			= " . Mapper::safeSql(PRINTED) . " 
				)
				AND
				billing_status 	= " . Mapper::safeSql(PENDING) . "

			LIMIT 1
		";

		return Mapper::runSql($sql,true,false);
	}

	public static function scanDeliveryDetails($params) {
		if($params['account_type'] != SUPER_ADMIN) {
			$sql = " 
				SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
				WHERE 
					delivery_no 	= " . Mapper::safeSql($params['delivery_no']) . " AND
					client_id 		= " . Mapper::safeSql($params['client_id']) . " AND
					(
						status 			= " . Mapper::safeSql(PRINTED) . " 
					)
					AND
					billing_status 	= " . Mapper::safeSql(PENDING) . "

				LIMIT 1
			";
		} else {
			$sql = " 
				SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
				WHERE 
					delivery_no 	= " . Mapper::safeSql($params['delivery_no']) . " AND
					(
						status 			= " . Mapper::safeSql(PRINTED) . " 
					)
					AND
					billing_status 	= " . Mapper::safeSql(PENDING) . "

				LIMIT 1
			";
		}

		return Mapper::runSql($sql,true,false);
	}


	public static function findPrintedByDeliveryNo($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
			WHERE 
				delivery_no 	= " . Mapper::safeSql($params['delivery_no']) . " AND
				status 			= " . Mapper::safeSql(PRINTED) . " AND
				billing_status 	= " . Mapper::safeSql(PENDING) . "

			LIMIT 1
		";

		return Mapper::runSql($sql,true,false);
	}

	public static function countTotalClearedDrPlansByClient($params) {
		$client_id = (int) $params['client_id'];
		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				client_id 		= " . Mapper::safeSql($client_id) . " AND
				status 			= " . Mapper::safeSql(CLEARED) . " AND
				billing_status 	= " . Mapper::safeSql(PENDING) . "
		";
	
		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function countTotalBilledDrPlansByClient($params) {
		$client_id = (int) $params['client_id'];
		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				client_id 		= " . Mapper::safeSql($client_id) . " AND
				status 			= " . Mapper::safeSql(CLEARED) . " AND
				billing_status 	= " . Mapper::safeSql(BILLED) . "
		";
	
		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function countTotalTripByDriver($params) {
		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				(
					driver_id = " . Mapper::safeSql($params['driver_id']) . " OR 
					other_driver_id = " . Mapper::safeSql($params['driver_id']) . " 
				)

				AND

				status = " . Mapper::safeSql(CLEARED) . " AND 
				is_archive = " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function countWeeklyTripByDriver($params) {

		#$start_sat 	= date("Y-m-d", strtotime('last Saturday'));
		$start_sun 	= date("Y-m-d", strtotime('last Sunday'));

		#$end_sat	= date("Y-m-d", strtotime('next Saturday'));
		$end_sun	= date("Y-m-d", strtotime('next Sunday'));

		$date_today = date("D");

		if($date_today == "Sun") {
			$start_sat = date("Y-m-d", strtotime("-1 day") );
			$start_sun = date("Y-m-d");
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				(
					driver_id 		= " . Mapper::safeSql($params['driver_id']) . " OR 
					other_driver_id = " . Mapper::safeSql($params['driver_id']) . " 
				)

				AND 
				(
					delivery_date BETWEEN " . Mapper::safeSql($start_sun) . " AND " . Mapper::safeSql($end_sun) . "
				)

				AND

				status = " . Mapper::safeSql(CLEARED) . " AND 
				is_archive = " . Mapper::safeSql(NO) . "
		";
		
		$record = Mapper::runSql($sql,true,false);
		return $record['total'];
	}

	public static function generateClearedPlansDatatable($params) {

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
				)
				AND

			";
		}

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . DELIVERY_RECEIPT . "
			WHERE
				{$search}
				client_id 	= " . Mapper::safeSql($params['client_id']) . " AND
				status 		= " . Mapper::safeSql(CLEARED) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}

		";
		
		return Mapper::runSql($sql,true,true);
	}

	public static function countClearedPlansDatatable($params) {

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
				)
				AND

			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . DELIVERY_RECEIPT . "
			WHERE
				{$search}
				client_id 	= " . Mapper::safeSql($params['client_id']) . " AND
				status 		= " . Mapper::safeSql(CLEARED) . " AND
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
			$sqlstart 	= " UPDATE " . DELIVERY_RECEIPT . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . DELIVERY_RECEIPT . " SET ";
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
			DELETE FROM " . DELIVERY_RECEIPT . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>