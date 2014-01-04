<?php 
class Payroll_Register {

	public static function findAllPayslipByDate($params) {

		$order = ($params['order'] == "" ? "" : " ORDER BY " . $params['order']);
		$limit = ($params['limit'] == "" ? "" : " LIMIT " . $params['limit']);

		$sql = " 
			SELECT " . field_injector($params['fields']) . " FROM " . RVL_PAYROLL_REGISTER . "
			WHERE 
				driver_id = " . Mapper::safeSql($params['driver_id']) . " AND
				delivery_date BETWEEN " . Mapper::safeSql($params['from']) . " AND " . Mapper::safeSql($params['to']) . " AND
				is_generated = " . Mapper::safeSql(NO) . "

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
			$sqlstart 	= " UPDATE " . RVL_PAYROLL_REGISTER . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . RVL_PAYROLL_REGISTER . " SET ";
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
			DELETE FROM " . RVL_PAYROLL_REGISTER . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}

}

?>