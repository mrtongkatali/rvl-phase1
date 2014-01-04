<?php 
class Rate_Honda {

	function computeTotalBillable() {
		self::findHaulingCharges();
	}

	function findHaulingCharges($params) {
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . RVL_RATE_HONDA . "
			WHERE
				pick_up_point 	= " . Mapper::safeSql($params['pick_up_point']) . " AND
				destination 	= " . Mapper::safeSql($params['destination']) . " AND
				load_unit 		= " . Mapper::safeSql($params['load_unit']) . " AND
				delivery_type	= " . Mapper::safeSql($params['delivery_type']) . " AND
				status 		= " . Mapper::safeSql(ACTIVE) . "
			LIMIT 1
		";
		
		return Mapper::runActive($sql);
	}

}

?>