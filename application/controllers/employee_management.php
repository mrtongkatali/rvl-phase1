<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_Management extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		date_default_timezone_set("Asia/Manila");

 		$data['ac'] = $ac = $_SESSION['rvl']['login']['account_type'];
		User_Roles::verifyUserAccess($ac,"employee_management");
	}

	function index() {
		$this->welcome();
		#redirect('coming_soon');
	}

	function welcome() {
		$this->authenticate_user();
		
		Bootstrap::datetimepicker();
		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('employee_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Employee Management";

		$data['employee_management'] 	= "active";

		$this->load->view('employee_management/index',$data);
	}

	function employee_list() {
		Engine::XmlHttpRequestOnly();
		#$fields = array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,status,date_created");
		#$data['delivery_receipt'] = $delivery_receipt = Delivery_Receipt::findAll($fields);
		$this->load->view('employee_management/employee_list',$data);
	}

	function get_employee_list() {
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();

		if($get) {
			$sorting 	= (int) $get['iSortCol_0'];
			$query   	= $get['sSearch'];
			$order_type	= strtoupper($get['sSortDir_0']);

			$display_start 	= (int) $get['iDisplayStart'];

			$rows = array(
				0 => "id",
				1 => "employee_code",
				2 => "full_name",
				3 => "gender",
				4 => "status",
			);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$fields = array("id,employee_code,full_name,gender,employee_status");
			$params = array(
				"query"		=> $query,
				"fields" 	=> $fields,
				"status"	=> ACTIVE,
				"order" 	=> $order_by,
				"limit"  	=> $limit
			);

			$employees 		= Employee::fetchRecords($params);
			$total_records 	= Employee::countFetchedRecords($params);

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			foreach($employees as $key=>$value):

				$action_link = '
					<a href="javascript:void(0);" class="edit_employee table_icon" original-title="Edit" onclick="javascript:edit_employee_form('.$value['id'].');"><i class="icon-edit"></i></a>
				';

				$row = array(
					'0' => "<div class='ss_table_icons'>{$action_link}</div>",
					'1' => $value['employee_code'],
					'2' => $value['full_name'],
					'3' => $value['gender'],
					'4' => $value['employee_status'],
				);
			$output['aaData'][] = $row;
			endforeach;
		} else {
			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => 0,
				"iTotalDisplayRecords" => 0,
				"aaData" => array()
			);
		}
		
		echo json_encode($output);
	}

	function add_employee_form() {
		if($this->validate_ajax_request()) {
			$data['clients'] 	= $clients = Client_List::findAllActive();
			$data['truck_list'] = $truck_list = Truck_List::findAllActive();

			$this->load->view('employee_management/form/add_employee',$data);
		}
	}

	function edit_employee_form() {
		if($this->validate_ajax_post()) {

			$post 		= $this->input->post();
			$post_id 	= (int) $post['id'];

			$params = array(
				"id" 		=> $post_id,
			);

			$data['e'] = $employee = Employee::findById($params);

			if($employee) {

				$data['clients'] 	= $clients = Client_List::findAllActive();
				$data['user'] 		= $user = User::findByEmployeeId(array("employee_id"=>$employee['id']));
				$data['truck_list'] = $truck_list = Truck_List::findAllActive();

				if($user['account_type'] == DRIVER) {
					$data['driver'] = $driver = Driver_List::findByEmployeeId(array("employee_id" => $employee['id']));
				}

				$this->load->view('employee_management/form/edit_employee',$data);
			}
			
		}
	}

	function save_employee() {
		if($this->validate_ajax_post()) {
			$post = $this->input->post();

			$session = $_SESSION['rvl']['login'];
			$user_id = (int) $this->encrypt->decode($session['user_id']);

			if($post['id']) {
				$post_id = (int) $post['id'];
			
				$record = array( 
					"employee_code" 	=> $post['employee_code'],
					"firstname" 		=> $post['firstname'],
					"middlename" 		=> $post['middlename'],
					"lastname" 			=> $post['lastname'],
					"full_name" 		=> $post['firstname'] . " " . $post['middlename'] . " " . $post['lastname'] . " " . $post['suffix'],
					"suffix" 			=> $post['suffix'],
					"gender" 			=> $post['gender'],
					"birthdate"			=> $post['birthdate'],
					"email_address" 	=> $post['email_address'],
					"employee_status" 	=> ACTIVE,
					"is_archive" 		=> NO,
					"date_created" 		=> Tool::getCurrentDateTime(),
					"last_update_by" 	=> $user_id,
				);

				if($post['account_type'] == GUARD) {
					$arr = array(
						"client_id" => (int) $post['client_id']
					);

					$record = array_merge($record,$arr);
				}

				Employee::save($record,$post_id);


				$driver = Driver_List::findByEmployeeId(array("employee_id" => $post_id));

				if($post['account_type'] == DRIVER) {

					$driver_array = array(
						"employee_id" 		=> (int) $post_id,
						"assigned_truck_id" => (int) $post['truck_id'],
						"assigned_type" 	=> $post['assigned_type'],
						"firstname" 		=> $post['firstname'],
						"middlename" 		=> $post['middlename'],
						"lastname" 			=> $post['lastname'],
						"full_name" 		=> $post['firstname'] . " " . $post['middlename'] . " " . $post['lastname'] . " " . $post['suffix'],
						"driver_license" 	=> $post['driver_license'],
						"status" 			=> ACTIVE,
						"is_archive" 		=> NO,
						"date_created" 		=> Tool::getCurrentDateTime(),
						"last_update_by" 	=> $user_id,

					);

					Driver_List::save($driver_array,$driver['id']);
				} else {
					Driver_List::delete($driver['id']);
					// if not driver delete entry
				}

				$user = User::findByEmployeeId(array("employee_id" => $post_id));

				$record2 = array( 
					"account_type" 		=> $post['account_type'],
				);

				User::save($record2,$user['id']);
			} else {
				
				$record = array( 
					"employee_code" 	=> $post['employee_code'],
					"firstname" 		=> $post['firstname'],
					"middlename" 		=> $post['middlename'],
					"lastname" 			=> $post['lastname'],
					"full_name" 		=> $post['firstname'] . " " . $post['middlename'] . " " . $post['lastname'] . " " . $post['suffix'],
					"suffix" 			=> $post['suffix'],
					"gender" 			=> $post['gender'],
					"birthdate"			=> $post['birthdate'],
					"email_address" 	=> $post['email_address'],
					"employee_status" 	=> ACTIVE,
					"is_archive" 		=> NO,
					"date_created" 		=> Tool::getCurrentDateTime(),
					"last_update_by" 	=> $user_id,
				);

				if($post['account_type'] == GUARD) {
					$arr = array(
						"client_id" => (int) $post['client_id']
					);

					$record = array_merge($record,$arr);
				}

				$employee_id = Employee::save($record);

				if($post['account_type'] == DRIVER) {
					$driver_array = array(
						"employee_id" 		=> (int) $employee_id,
						"assigned_truck_id" => (int) $post['truck_id'],
						"assigned_type" 	=> $post['assigned_type'],
						"firstname" 		=> $post['firstname'],
						"middlename" 		=> $post['middlename'],
						"lastname" 			=> $post['lastname'],
						"full_name" 		=> $post['firstname'] . " " . $post['middlename'] . " " . $post['lastname'] . " " . $post['suffix'],
						"driver_license" 	=> $post['driver_license'],
						"status" 			=> ACTIVE,
						"is_archive" 		=> NO,
						"date_created" 		=> Tool::getCurrentDateTime(),
						"last_update_by" 	=> $user_id,

					);

					Driver_List::save($driver_array);
				}

				$password 		= $this->encrypt->encode($post['password']);
				$hash 			= Password_Hash::create_hash($post['password']);

				$record2 = array( 
					"employee_id" 		=> $employee_id,
					"employee_code" 	=> $post['employee_code'],
					"email_address" 	=> $post['email_address'],
					"username" 			=> $post['username'],
					"password" 			=> $password,
					"hash" 				=> $hash,
					"account_type" 		=> $post['account_type'],
					"account_status"	=> ACTIVE,
					"date_created" 		=> Tool::getCurrentDateTime(),
				);

				User::save($record2);

			}

			$json['is_successful'] 	= true;
			$json['message'] 		= "Added Successully!";

		} else { 
			$json['is_successful'] 	= false;
			$json['message'] 		= "Ooops! Error occured. Please contact web administrator!";
		}

		echo json_encode($json);
	}

	function validate_ajax_post() {
		Engine::XmlHttpRequestOnly();
		$this->authenticate_user();

		$post 		= $this->input->post();
		$session 	= $_SESSION['rvl']['login'];

		if($post && $session) {
			return true;
		} else {
			die("Ooops! Error occured. Please contact web administrator!");
		}
	}

	function validate_ajax_request() {
		Engine::XmlHttpRequestOnly();
		$this->authenticate_user();
		$session = $_SESSION['rvl']['login'];
		if($session) {
			return true;
		} else {
			die("Ooops! Error occured. Please contact web administrator!");
		}
	}

	function update_delivery_plan_form() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$dr_id = (int) $post['dr_id'];

		$data['dr'] = $dr = Delivery_Receipt::findById($dr_id, $fields);

		if($post && $dr) {
			$data['client_list'] 		= Client_List::findAllActive(array("id, client_name"));
			#$data['warehouse_list'] 	= Warehouse_List::findAllActive(array("id, warehouse_name"));
			$data['driver_list']  		= Driver_List::findAllActive(array("id, firstname, middlename, lastname"));
			#$data['vehicle_color_list']	= Vehicle_Color_List::findAllActive(array("id, color"));
			#$data['vehicle_model_list']	= Vehicle_Model_List::findAllActive(array("id, model_name"));
			$data['truck_list']			= Truck_List::findAllActive(array("id, truck_model, plate_number"));

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr_id, $fields);
			
			$this->load->view('delivery_management/form/update_dr',$data);
		}
	}

	function update_delivery_plan() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$post_id = (int) $post['id'];

		$fields = array("id,client_id,driver_id,other_driver_id,plate_no,delivery_date");
		$dr 	= Delivery_Receipt::findById($post_id, $fields);

		if($post && $dr) {
			$client 	= Client_List::findById($post['client_name'], array("id,client_name,billing_address"));
			$driver 	= Driver_List::findById($post['driver'], array("id, firstname, middlename, lastname"));
			$driver2 	= Driver_List::findById($post['driver2'], array("id, firstname, middlename, lastname"));
			$truck 		= Truck_List::findById($post['truck_plate_no'], array("id, truck_model, plate_number"));

			$record = array(
				"driver_id" 			=> $driver['id'],
				"driver_name" 			=> $driver['firstname'] . " " . $driver['middlename'] . " " . $driver['lastname'],
				"other_driver_id"		=> $driver2['id'],
				"other_driver_name"		=> $driver2['firstname'] . " " . $driver2['middlename'] . " " . $driver2['lastname'],
				"truck_id" 				=> $truck['id'],
				"plate_no" 				=> $truck['plate_number'],
				"delivery_date"			=> $post['delivery_date'],
				"status" 				=> FORAPPROVAL,
				"last_update_by" 		=> 1,
			);

			Delivery_Receipt::save($record, $post_id);

			$json['is_successful'] = true;
		} else {
			$json['is_successful'] = false;
		}

		echo json_encode($json);
	}

	function edit_delivery_formtemp() {
		Engine::XmlHttpRequestOnly();

		$data['client_list'] 		= Client_List::findAllActive(array("id, client_name"));
		$data['warehouse_list'] 	= Warehouse_List::findAllActive(array("id, warehouse_name"));
		$data['driver_list']  		= Driver_List::findAllActive(array("id, firstname, middlename, lastname"));
		$data['vehicle_color_list']	= Vehicle_Color_List::findAllActive(array("id, color"));
		$data['vehicle_model_list']	= Vehicle_Model_List::findAllActive(array("id, model_name"));
		$data['truck_list']			= Truck_List::findAllActive(array("id, truck_model, plate_number"));

		$this->load->view('delivery_management/form/add_delivery',$data);
	}

	function save_delivery_plan() {
		$post = $this->input->post();

		if($post) {

			if($_FILES['vn_excel']['error'] == 0) {
				$this->load->library('php_excel/PHPExcel');
				$excel = $_FILES['vn_excel']['tmp_name'];
				Vn_List::create_delivery_plan($excel);

				$delivery_plan = $_SESSION['tmp']['delivery_plan'];
				
				$row_counter = 1;
				$is_new_dr	 = true;
				foreach($delivery_plan as $key=>$value):

					if($is_new_dr) {
						$delivery_no 	= str_pad(date("mYd").Delivery_Receipt::getNextIncrementId(), 12, "0", STR_PAD_LEFT);

						$client = Client_List::findById($post['client_name'], array("id,client_name,billing_address"));

						$record = array(
							"user_id" 			=> 1,
							"delivery_no" 		=> $delivery_no,
							"client_id" 		=> $client['id'],
							"client_name" 		=> $client['client_name'],
							"delivery_address" 	=> $value['delivery_address'],
							"pickup_point" 		=> $value['pickup_point'],
							"delivery_point" 	=> $value['delivery_point'],
							"status" 			=> PENDING,
							"remarks" 			=> DELIVER_PLAN_INC,
							"is_archive" 		=> NO,
							"date_created" 		=> Tool::getCurrentDateTime(),
							"last_update_by" 	=> 1,
						);

						$delivery_receipt_id = Delivery_Receipt::save($record);

						$is_new_dr = false;
					}

					$record = array(
						"user_id" 				=> 1,
						"delivery_receipt_id"	=> $delivery_receipt_id,
						"vin_no" 				=> $value['vin_no'],
						"conduction_sticker_no" => $value['conduction_sticker_no'],
						"model" 				=> $value['model'],
						"color" 				=> $value['color'],
						"qty" 					=> $value['qty'],
						"settings" 				=> $value['settings'],
						"date_created" 			=> Tool::getCurrentDateTime(),
						"last_update_by" 		=> 1,
					);

					Vn_List::save($record);

					if($row_counter == 6) {
						$is_new_dr = true;
						$row_counter = 0;
					}

					$row_counter++;
				endforeach;

				unset($_SESSION['tmp']);
				$json['is_successful'] = true;
			} else {
				$json['is_successful'] = false;
			}
		}

		echo json_encode($json);
	}

	function save_delivery() {
		//Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		if($post) {

			$client 	= Client_List::findById($post['client_name'], array("id,client_name,billing_address"));
			$warehouse 	= Warehouse_List::findById($post['warehouse'], array("id,warehouse_name"));
			$driver 	= Driver_List::findById($post['driver'], array("id, firstname, middlename, lastname"));
			$driver2 	= Driver_List::findById($post['driver2'], array("id, firstname, middlename, lastname"));
			$truck 		= Truck_List::findById($post['truck_plate_no'], array("id, truck_model, plate_number"));

			$delivery_no = str_pad(date("mYd").Delivery_Receipt::getNextIncrementId(), 12, "0", STR_PAD_LEFT);

			$record = array(
				"user_id" 				=> 1,
				"delivery_no" 			=> $delivery_no,
				"client_id" 			=> $client['id'],
				"client_name" 			=> $client['client_name'],
				"warehouse_id" 			=> $warehouse['id'],
				"warehouse_name"		=> $warehouse['warehouse_name'],
				"driver_id" 			=> $driver['id'],
				"driver_name" 			=> $driver['firstname'] . " " . $driver['middlename'] . " " . $driver['lastname'],
				"other_driver_id"		=> $driver2['id'],
				"other_driver_name"		=> $driver2['firstname'] . " " . $driver2['middlename'] . " " . $driver2['lastname'],
				"plate_no" 				=> $truck['plate_number'],
				"delivery_date"			=> $post['delivery_date'],
				"delivery_address"		=> $client['billing_address'],
				"status" 				=> PENDING,
				"is_archive" 			=> NO,
				"date_created" 			=> Tool::getCurrentDateTime(),
				"last_update_by" 		=> 1,
			);

			$delivery_receipt_id = Delivery_Receipt::save($record);

			$_SESSION['tmp']['user_id'] = 1;
			$_SESSION['tmp']['delivery_receipt_id'] = $delivery_receipt_id;

			if($_FILES['vn_excel']['error'] == 0) {
				$this->load->library('php_excel/PHPExcel');
				$excel = $_FILES['vn_excel']['tmp_name'];
				Vn_List::import_vn_excel($excel);
				
			}

			unset($_SESSION['tmp']);

			/*		
			foreach($post['item'] as $key=>$value):
				$record = array(
					"user_id" 				=> 1,
					"delivery_receipt_id"	=> $delivery_receipt_id,
					"vin_no" 				=> $value['vin_no'],
					"conduction_sticker_no" => $value['conduction_sticker_no'],
					"model" 				=> $value['model'],
					"color" 				=> $value['color'],
					"qty" 					=> $value['qty'],
					"settings" 				=> $value['settings'],
					"date_created" 			=> Tool::getCurrentDateTime(),
					"last_update_by" 		=> 1,
				);

				Vn_List::save($record);
			endforeach;
			*/
			$json['is_successful'] = true;
		} else {
			$json['is_successful'] = false;
		}

		echo json_encode($json);
	}


	function print_pdf() {
		$get = $this->input->get();
		
		if($get) {

			$this->load->library('tcpdf/tcpdf');
			$data['receipt'] 	= $receipt = Delivery_Receipt::findById($get['id']);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($get['id'], $fields);
			$this->load->view('delivery_management/delivery_receipt_pdf',$data);
		}
		
	}

	function search_available_porter() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();
		if($post) {
			$driver_id 	= (int) $post['driver'];
			$q 			= $post['q'];

			$fields 			= array("id,firstname,middlename,lastname");
			$available_porter 	= Driver_List::findAllAvailablePorterByName($q, $driver_id, $fields);

			foreach($available_porter as $key=>$value):
				$results[] = array(
					'id' 	=> $value['id'],
					'text' 	=> $value['firstname'] . " " . $value['lastname'],
				);
			endforeach;

			echo json_encode($results);
		}
	}

	function get_available_porter() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();
		if($post) {
			$driver_id 	= (int) $post['driver'];

			$fields 			= array("id,firstname,middlename,lastname");
			$available_porter 	= Driver_List::findAllDriversExcept($driver_id, $fields);

			foreach($available_porter as $key=>$value):
				$results[] = array(
					'id' 	=> $value['id'],
					'text' 	=> $value['firstname'] . " " . $value['lastname'],
				);
			endforeach;

			echo json_encode($results);
		}
	}

	function approve_receipt() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		if($post) {
			$id = (int) $post['id'];
			$record = array(
				"status" => APPROVED,
			);

			Delivery_Receipt::save($record,$id);

			$json['message']		= "Updated successfully!";
			$json['is_successful'] 	= true;
		} else {
			$json['message']		= "Oops! Please contact web administrator";
			$json['is_successful'] 	= false;
		}
		
		echo json_encode($json);
	}

	function reject_receipt() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		if($post) {
			$id = (int) $post['id'];
			$record = array(
				"status" => REJECTED,
			);

			Delivery_Receipt::save($record,$id);

			$json['message']		= "Updated successfully!";
			$json['is_successful'] 	= true;
		} else {
			$json['message']		= "Oops! Please contact web administrator";
			$json['is_successful'] 	= false;
		}
		
		echo json_encode($json);
	}

	function get_default_driver() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$driver1 = Driver_List::findAssignedPorter($post['truck_id'], array("id, firstname, middlename, lastname"));
		$driver2 = Driver_List::findAssignedJockey($post['truck_id'], array("id, firstname, middlename, lastname"));

		if($post) {
			$json['driver1'] 		= $driver1['id'];
			$json['driver2'] 		= $driver2['id'];
			$json['driver2_name'] 	= $driver2['firstname'] . " " . $driver2['middlename'] . " " . $driver2['lastname'];
			
			$json['message']		= "Updated successfully!";
			$json['is_successful'] 	= true;
		} else {
			$json['message']		= "Oops! Please contact web administrator";
			$json['is_successful'] 	= false;
		}

		echo json_encode($json);
	}

	function scan_receipt_form() {
		Engine::XmlHttpRequestOnly();
		$this->load->view('delivery_management/scan_dr_details',$data);
	}

	function show_dr_details() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		if($post) {
			$delivery_no = (int) $post['delivery_no'];
			$fields 	= array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,delivery_address,pickup_point,delivery_point,status,date_created");
			$data['dr'] = $dr = Delivery_Receipt::findByDeliveryNo($delivery_no,$fields);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr['id'], $fields);
			
			$this->load->view('delivery_management/show_dr_details',$data);
		}	
	}





}