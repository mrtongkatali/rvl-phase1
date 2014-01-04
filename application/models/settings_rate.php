<?php 
class Settings_Rate {

	function findById($id,$fields) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . RVL_SETTINGS_RATE . "
			WHERE id = " . Mapper::safeSql($id) . "
			LIMIT 1
		";
		return Mapper::runActive($sql);
	}

	function findAll() {
		$sql = " 
			SELECT * FROM " . RVL_SETTINGS_RATE . "
		";
		return Mapper::runActive($sql, TRUE);
	}

	function findActiveRate() {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . RVL_SETTINGS_RATE . "
			WHERE
				status = " . Mapper::safeSql(ACTIVE) . "

			LIMIT 1
		";
		return Mapper::runActive($sql);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . RVL_SETTINGS_RATE . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_SETTINGS_RATE . " SET ";
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
			DELETE FROM " . RVL_SETTINGS_RATE . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>