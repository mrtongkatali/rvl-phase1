<?php 
class Address_List {

	public static function findById($params) {

		$id = (int) $params['id'];

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_ADDRESS_LIST . "
			WHERE 
				id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . RVL_ADDRESS_LIST . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActive($fields = "", $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . RVL_ADDRESS_LIST . "
			WHERE
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findByAddressCode($params) {
		$address_code = $params['address_code'];
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_ADDRESS_LIST . "
			WHERE 
				address_code = " . Mapper::safeSql($address_code) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAllActiveAddress($params) {
		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);
		

		$address_code = $params['address_code'];

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_ADDRESS_LIST . "
			
			{$order}
			{$limit}
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . RVL_ADDRESS_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_ADDRESS_LIST . " SET ";
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
			DELETE FROM " . RVL_ADDRESS_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>