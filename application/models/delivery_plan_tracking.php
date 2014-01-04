<?php 
class Delivery_Plan_Tracking {

	function findById($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_DELIVERY_PLAN_TRACKING . "
			WHERE 
				id = " . Mapper::safeSql($params['id']) . "
			LIMIT 1
		";
	
		return Mapper::runActive($sql);
	}

	function findAll($params) {

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_DELIVERY_PLAN_TRACKING . "

			{$order}
			{$limit}
		";

		return Mapper::runActive($sql, TRUE);
	}

	function findExistingConfirmation($params) {
		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_DELIVERY_PLAN_TRACKING . "
			WHERE 
				dr_id 		= " . Mapper::safeSql($params['dr_id']) . " AND
				client_id 	= " . Mapper::safeSql($params['client_id']) . " AND
				user_id 	= " . Mapper::safeSql($params['user_id']) . "
			LIMIT 1
		";

		return Mapper::runActive($sql);
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . RVL_DELIVERY_PLAN_TRACKING . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_DELIVERY_PLAN_TRACKING . " SET ";
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
			DELETE FROM " . RVL_DELIVERY_PLAN_TRACKING . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>