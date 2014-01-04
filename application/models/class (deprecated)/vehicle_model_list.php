<?php 
class Vehicle_Model_List {

	public static function findById($id) {
		$sql = " 
			SELECT * FROM " . VECHICLE_MODEL_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runSql($sql,true,false);
	}

	public static function findAll() {
		$sql = " 
			SELECT * FROM " . VECHICLE_MODEL_LIST . "
		";
		return Mapper::runSql($sql,true,true);
	}

	public static function findAllActive($fields = "", $order = "", $limit = "") {
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . VECHICLE_MODEL_LIST . "
			WHERE is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$sort}
		";
		return Mapper::runSql($sql,true,true);
	}
	
	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . VECHICLE_MODEL_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . VECHICLE_MODEL_LIST . " SET ";
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
			DELETE FROM " . VECHICLE_MODEL_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>