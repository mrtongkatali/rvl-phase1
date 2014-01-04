<?php 
class User_Roles {

	public static function verifyUserAccess($account_type, $page, $exception) {
		

		if($account_type == SUPER_ADMIN) {
			return true;
		} else if($account_type == COORDINATOR) {
			$array = array(
				"billing_management" => array(
					"view" => false,
				),
				"delivery_management" => array(
					"view" => true,
				),
				"employee_management" => array(
					"view" => false,
				),
				"payroll" => array(
					"view" => false,
				),
			);
		} else if($account_type == CENTRAL_DISPATCHER) {
			$array = array(
				"billing_management" => array(
					"view" => false,
				),
				"delivery_management" => array(
					"view" => true,
				),
				"employee_management" => array(
					"view" => false,
				),
				"payroll" => array(
					"view" => false,
				),
				"scan_receipt_form" => array(
					"view" => false,
				),
			);
		} else if($account_type == GUARD) {
			$array = array(
				"billing_management" => array(
					"view" => false,
				),
				"delivery_management" => array(
					"view" => true,
				),
				"employee_management" => array(
					"view" => false,
				),
				"payroll" => array(
					"view" => false,
				),
				"scan_delivery_plan" => array(
					"view" => true,
				),
			);
		} else if($account_type == BILLING) {
			$array = array(
				"billing_management" => array(
					"view" => true,
				),
				"delivery_management" => array(
					"view" => false,
				),
				"employee_management" => array(
					"view" => false,
				),
				"payroll" => array(
					"view" => false,
				),
				"scan_receipt_form" => array(
					"view" => false,
				),
			);
		} else if($account_type == PAYROLL) {
			$array = array(
				"billing_management" => array(
					"view" => false,
				),
				"delivery_management" => array(
					"view" => false,
				),
				"employee_management" => array(
					"view" => false,
				),
				"payroll" => array(
					"view" => true,
				),
				"scan_receipt_form" => array(
					"view" => false,
				),
			);
		}

		if($array[$page]['view'] == true) {
			return true;
		} else {
			die(show_error("Oops! You don't have permission to access this page. Please contact web administrator!",404));
		}

	}

}

?>