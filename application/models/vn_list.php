<?php 
class Vn_List {

	function findAll() {
		$sql = " 
			SELECT * FROM " . VN_LIST . "
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function findAllByDeliveryReceipt($delivery_receipt_id, $fields, $order = "", $limit = "") {
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		
		$sql = " 
			SELECT " . field_injector($fields) . " FROM " . VN_LIST . "
			WHERE
				delivery_receipt_id = " . Mapper::safeSql($delivery_receipt_id) . "

			{$order}
			{$limit}
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function findAllActive($order = "", $limit = "") {
		$order = ($order == "" ? "" : " ORDER BY {$order}");
		$limit = ($limit == "" ? "" : " LIMIT {$limit}");
		
		$sql = " 
			SELECT * FROM " . VN_LIST . "
			WHERE
				status = " . Mapper::safeSql(ACTIVE) . " AND
				is_archive = " . Mapper::safeSql(NO) . "

			{$order}
			{$limit}
		";
		
		return Mapper::runActive($sql, TRUE);
	}

	function countAllByDrId($delivery_receipt_id) {
		$sql = " 
			SELECT COUNT(id) as total FROM " . VN_LIST . "
			WHERE
				delivery_receipt_id = " . Mapper::safeSql($delivery_receipt_id) . "
		";

		$record = Mapper::runActive($sql);
		return $record['total'];
	}

	public static function save($record,$id) {
		foreach($record as $key=>$value):
			$arr[] = " $key = " . Mapper::safeSql($value);
		endforeach;

		if($id) {
			$sqlstart 	= " UPDATE " . VN_LIST . " SET ";
			$sqlend		= " WHERE id = " . Mapper::safeSql($id);
		} else {
			$sqlstart 	=  " INSERT INTO " . VN_LIST . " SET ";
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
			DELETE FROM " . VN_LIST . "
			WHERE id = " . Mapper::safeSql($id) . "
		";
		Mapper::runSql($sql,false);
	}


	public static function import_vn_excel($excel) {
		$inputFileType = PHPExcel_IOFactory::identify($excel);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType); 				
		$obj_reader = $objReader->load($excel);
		$read_sheet = $obj_reader->getActiveSheet();
		foreach ($read_sheet->getRowIterator() as $row):
			$import_successs = true;
			$cellIterator = $row->getCellIterator();
			$required_fields_counter = 0;
			foreach ($cellIterator as $cell):
				$cell_value = stripslashes(strip_tags($cell_value));
				
				$current_row = $cell->getRow();
				$cell_value = $cell->getFormattedValue();	
				$column = $cell->getColumn();
				$current_column = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
				
				if($current_row == 2) {
					if ($column == 'A') {
						$r['delivery_address'] = $cell_value;
					}

					if ($column == 'B') {
						$r['pickup_point'] = $cell_value;
					}

					if ($column == 'C') {
						$r['delivery_point'] = $cell_value;
					}
				}

				if($current_row >= 5) {
					if ($column == 'A') {
						$r['vin_no'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'B') {
						$r['conduction_sticker_no'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'C') {
						$r['model'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'D') {
						$r['color'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'E') {
						$r['qty'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'F') {
						$r['settings'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'G') {
						$r['description'] = $cell_value;
						$required_fields_counter++;
					}
				}
			endforeach;

			if($required_fields_counter == 5) { 
				$session = $_SESSION['tmp'];
				$record = array(
					"user_id" 				=> $session['user_id'],
					"delivery_receipt_id"	=> $session['delivery_receipt_id'],
					"vin_no" 				=> $r['vin_no'],
					"conduction_sticker_no" => $r['conduction_sticker_no'],
					"model" 				=> $r['model'],
					"color" 				=> $r['color'],
					"qty" 					=> $r['qty'],
					"settings" 				=> $r['settings'],
					"date_created" 			=> Tool::getCurrentDateTime(),
					"last_update_by" 		=> 1,
				);

				Vn_List::save($record);

				$record = array(
					"delivery_address" 	=> $r['delivery_address'],
					"pickup_point" 		=> $r['pickup_point'],
					"delivery_point" 	=> $r['delivery_point'],
				);

				Delivery_Receipt::save($record,$session['delivery_receipt_id']);
			}

			$required_fields_counter = 0;
		endforeach;

		return true;
	}

	public static function create_delivery_plan($excel) {
		$inputFileType = PHPExcel_IOFactory::identify($excel);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType); 				
		$obj_reader = $objReader->load($excel);
		$read_sheet = $obj_reader->getActiveSheet();

		$arr_field = array();

		foreach ($read_sheet->getRowIterator() as $row):
			$import_successs = true;
			$cellIterator = $row->getCellIterator();
			$required_fields_counter = 0;
			foreach ($cellIterator as $cell):
				$cell_value = stripslashes(strip_tags($cell_value));
				
				$current_row = $cell->getRow();
				$cell_value = $cell->getFormattedValue();	
				$column = $cell->getColumn();
				$current_column = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
				
				if($current_row == 2) {
					#echo "{$current_row}-{$cell_value} \n";
					if ($column == 'A') {
						$r['delivery_address'] = $cell_value;
					}

					if ($column == 'B') {
						$r['delivery_point'] = $cell_value;
					}

					/*
					if ($column == 'B') {
						$r['pickup_point'] = $cell_value;
					}
					*/
				}

				if($current_row >= 5) {
					if ($column == 'A') {
						$r['vin_no'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'B') {
						$r['conduction_sticker_no'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'C') {
						$r['model'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'D') {
						$r['color'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'E') {
						$r['qty'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'F') {
						$r['settings'] = $cell_value;
					}

					if ($column == 'G') {
						$r['description'] = $cell_value;
						$required_fields_counter++;
					}

					if ($column == 'H') {
						$r['delivery_type'] = $cell_value;
						$required_fields_counter++;
					}
				}
			endforeach;


			if($required_fields_counter == 7) {
				$arr_field[] = $r;
				$_SESSION['tmp']['delivery_plan'][] = $r;
			} else {

				if($required_fields_counter >= 5) {
					$error_log = array(
						"message" => "Incomplete Field"
					);
					$r = array_merge($error_log, $r);
					$_SESSION['tmp']['import_error']['delivery_address'] = $r['delivery_address'];
					$_SESSION['tmp']['import_error']['delivery_point'] = $r['delivery_point'];
					$_SESSION['tmp']['import_error']['vn'][] = $r;
				}
				
			}

			$required_fields_counter = 0;
		endforeach;

		array_shift($_SESSION['import_error']);

		#debug_array($_SESSION['import_error']);
		#debug_array($_SESSION['tmp']['delivery_plan']);

		return $arr_field;
	}

}

?>