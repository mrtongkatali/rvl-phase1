<?php 
class Client_List {

	function findById($id,$fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CLIENT_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";

		return Mapper::runActive($sql);
	}

	function findAll() {

		$sql = " 
			SELECT * FROM " . CLIENT_LIST . "
		";

		return Mapper::runActive($sql, TRUE);
	}

	function generateBillingListDataTable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					client_name LIKE  '%" . $q . "%' OR
					delivery_address LIKE  '%" . $q . "%' OR
					contact_person LIKE  '%" . $q . "%' OR
					status LIKE  '%" . $q . "%'
				)
				AND
			";
		}

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['field_injector']) . " FROM " . CLIENT_LIST . "
			WHERE
				{$search}
				status 		= " . Mapper::safeSql(ACTIVE) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}

		";

		return Mapper::runActive($sql, TRUE);
	}

	function countBillingListDataTable($params) {

		if($params['search']) {
			$q = $params['search'];
			$search = "
				(
					client_name LIKE  '%" . $q . "%' OR
					delivery_address LIKE  '%" . $q . "%' OR
					contact_person LIKE  '%" . $q . "%' OR
					status LIKE  '%" . $q . "%'
				)

				AND

			";
		}

		$sql = " 
			SELECT COUNT(id) as total FROM " . CLIENT_LIST . "
			WHERE
				{$search}
				status 		= " . Mapper::safeSql(ACTIVE) . " AND
				is_archive 	= " . Mapper::safeSql(NO) . "
		";

		$record = Mapper::runActive($sql);
		return $record['total'];
	}


	function findAllActive($fields = "", $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . CLIENT_LIST . "
			WHERE
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$sort}
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . CLIENT_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . CLIENT_LIST . " SET ";
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
			DELETE FROM " . CLIENT_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>