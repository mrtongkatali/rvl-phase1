<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_Management extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		date_default_timezone_set("Asia/Manila");
	}

	function index() {
		$this->welcome();
		#redirect('coming_soon');
	}

	function welcome() {
		#$this->authenticate_user();

		unset($_SESSION['tmp']);

		$data['ac'] = $ac = $_SESSION['rvl']['login']['account_type'];
		User_Roles::verifyUserAccess($ac,"delivery_management");
		
		Bootstrap::datetimepicker();
		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');
		Engine::appScript('confirmation.js');
		Engine::appScript('delivery_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Delivery Management";

		$data['delivery_management'] 	= "active";
		$data['delivery_plans'] 		= "active";

		$this->load->view('delivery_management/index',$data);
	}

	function delivery_receipt_list() {
		Engine::XmlHttpRequestOnly();

		$import_error 	= $_SESSION['tmp']['import_error']['vn'];
		$import_success = $_SESSION['tmp']['delivery_plan'];

		if ($import_error && !$import_success) {

			$total_error = count($import_error);

			$data['alert_type'] 	= "alert-error";
			$data['import_message'] = "There are {$total_error} error/s while importing. <a target='_blank' href=' " . url('delivery_management/download_import_error_log') . "'>Download error log</a>";
		} else if (!$import_error && $import_success) {

			$total_success = count($import_success);

			$data['alert_type'] 	= "alert-success";
			$data['import_message'] = "Import Successful!";
		}

		unset($_SESSION['tmp']['import_error']['vn']);
		unset($_SESSION['tmp']['delivery_plan']);

		$fields = array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,status,date_created");
		$data['delivery_receipt'] = $delivery_receipt = Delivery_Receipt::findAll($fields);
		$this->load->view('delivery_management/delivery_receipt_list',$data);
	}

	function download_import_error_log() {
		$this->authenticate_user();

		$data['import_error'] = $import_error = $_SESSION['tmp']['import_error'];

		if($import_error) {
			$this->load->view('delivery_management/import_error_log',$data);
		}
	}

	function get_delivery_receipt_list() {
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();

		$ac = $_SESSION['rvl']['login']['account_type'];

		if($get) {
			$sorting 	= (int) $get['iSortCol_0'];
			$query   	= $get['sSearch'];
			$order_type	= strtoupper($get['sSortDir_0']);

			$display_start 	= (int) $get['iDisplayStart'];

			$rows = array(
				0 => "id",
				1 => "delivery_no",
				2 => "client_name",
				3 => "plate_no",
				4 => "driver_name",
				5 => "other_driver_name",
				6 => "delivery_date",
			);

			$status = strtolower($get['delivery_status']);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$fields = array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,status,date_created");

			if(!$query && $status == "all") {
				$delivery_receipt 	= Delivery_Receipt::findAllNotBilled($fields, $order_by, $limit);
				$total_records 		= Delivery_Receipt::countAllNotBilled();
			} else {
				$delivery_receipt 	= Delivery_Receipt::searchByStatus($query,$status, $fields, $order_by, $limit);
				$total_records 		= Delivery_Receipt::countByStatus($query,$status);
			}

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			$total_deducted_row = 0;
			foreach($delivery_receipt as $key=>$value):

				if(
					$ac == SUPER_ADMIN ||
					(
						$ac == COORDINATOR && ( $value['status'] == PENDING || $value['status'] == REJECTED )
					) ||

					(
						$ac == CENTRAL_DISPATCHER && ( $value['status'] == FORAPPROVAL || $value['status'] == APPROVED || $value['status'] == REJECTED )
					)
				) {

					if($value['status'] == FORAPPROVAL) {
						if($value['driver_name'] && $value['other_driver_name'] && $value['plate_no'] && $value['delivery_date']) {
							$action_link = '
								<a href="javascript:void(0);" class="approve table_icon" original-title="Approve" onclick="javascript:approve_receipt('.$value['id'].');"><i class="icon-check"></i></a>
								<a href="javascript:void(0);" class="reject table_icon" original-title="Revise" onclick="javascript:reject_receipt('.$value['id'].');"><i class="icon-remove-circle"></i></a>
							';
						} else {
							$action_link = "";
						}

						$row_class = "warning";

					} else if($value['status'] == APPROVED || $value['status'] == PRINTED) {
						#$action_link = '
						#	<a href="javascript:void(0);" class="cleared table_icon" original-title="Cleared" onclick="javascript:cleared_receipt('.$value['id'].');"><i class="icon-ok-circle"></i></a>
						#';
						$action_link = "";
						if($ac == SUPER_ADMIN || $ac == CENTRAL_DISPATCHER) {
							$action_link .= '
								<a target="_blank" href="'.url('delivery_management/print_pdf?id='.$value['id']).'" onclick="javascript:print_delivery_plan('.$value['id'].');" class="print_receipt table_icon" original-title="Print DR"><i class="icon-print"></i></a>
							';
						}

						$row_class = "success";
					} else if($value['status'] == REJECTED) {
						$row_class = "error";
						$action_link = "";
					} else if($value['status'] == CLEARED) {
						$row_class = "success";
					}  else {
						$action_link = "";
					}

					$view_details_link = '
							<a href="javascript:void(0);" class="view_details table_icon" title="View Details" onclick="javascript:update_dr_form('.$value['id'].');"><i class="icon-search"></i></a>
						';

					$dn_row	 	= '<a href="javascript:void(0);" onclick="javascript:update_dr_form('.$value['id'].');">' . str_pad($value['delivery_no'], 11, "0", STR_PAD_LEFT) . '</a>';
					$client_row = '<a href="javascript:void(0);" onclick="javascript:update_dr_form('.$value['id'].');">' . $value['client_name'] . '</a>';

					$row = array(
						'DT_RowClass' => $row_class,

						'0' => "<div class='ss_table_icons'>{$view_details_link}{$action_link}</div>",
						'1' => $value['delivery_no'],
						'2' => $value['client_name'],
						'3' => $value['plate_no'],
						'4' => $value['driver_name'],
						'5' => $value['other_driver_name'],
						'6' => ($value['delivery_date'] ? date("M d, Y",strtotime($value['delivery_date'])) : ""),
						'7' => "<small>".$value['status']."</small>",
					);

					$output['aaData'][] = $row;

					$row_class = "";
				} else {
					$total_deducted_row++;
				}
			endforeach;

			$output["iTotalRecords"] 		= ($total_records - $total_deducted_row);
			$output["iTotalDisplayRecords"] = ($total_records - $total_deducted_row);

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

	function add_delivery_form() {
		Engine::XmlHttpRequestOnly();

		$data['client_list'] 		= Client_List::findAllActive(array("id, client_name"), "client_name ASC");
		$this->load->view('delivery_management/form/add_delivery',$data);
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

			$data['address_list'] = $address_list = Address_List::findAllAddressByClientId(array("client_id"=>$dr['client_id'], "fields"=>array("id,address_code,address")));

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty,settings");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr_id, $fields);

			$data['truck_list']	= Truck_List::findAllAvailable( array("delivery_type" => $dr['delivery_type'], "total_load" => count($vn)) );
			
			$this->load->view('delivery_management/form/update_dr',$data);
		}
	}

	function update_delivery_plan() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$post_id = (int) $post['id'];

		$fields = array("id,client_id,driver_id,other_driver_id,plate_no,delivery_date,delivery_type");
		$dr 	= Delivery_Receipt::findById($post_id, $fields);

		if($post && $dr) {
			$client 	= Client_List::findById($post['client_name'], array("id,client_name"));
			$driver 	= Driver_List::findById($post['driver'], array("id, firstname, middlename, lastname"));
			$driver2 	= Driver_List::findById($post['driver2'], array("id, firstname, middlename, lastname"));
			$truck 		= Truck_List::findById($post['truck_plate_no'], array("id, truck_model, plate_number"));

			$delivery 	= Address_List::findById( array("fields"=>array("id,address_code,address"), "id"=>(int) $post['delivery_address']) );
			$pickup 	= Address_List::findById( array("fields"=>array("id,address_code,address"), "id"=>(int) $post['pickup_point']) );

			$record = array(
				"driver_id" 			=> $driver['id'],
				"driver_name" 			=> $driver['firstname'] . " " . $driver['middlename'] . " " . $driver['lastname'],
				"other_driver_id"		=> $driver2['id'],
				"other_driver_name"		=> $driver2['firstname'] . " " . $driver2['middlename'] . " " . $driver2['lastname'],
				"truck_id" 				=> $truck['id'],
				"plate_no" 				=> $truck['plate_number'],
				"pick_up_point_code" 	=> $pickup['address_code'],
				"pickup_point" 			=> $pickup['address'],
				"delivery_date"			=> $post['delivery_date'],
				"status" 				=> FORAPPROVAL,
				"last_update_by" 		=> 1,
			);

			if($dr['delivery_type'] == SPECIAL) {
				$array_fields = array(
					"delivery_address_code" => $delivery['address_code'],
					"delivery_address" 		=> $delivery['address'],
				);

				$record = array_merge($record,$array_fields);
			}

			Delivery_Receipt::save($record, $post_id);

			/*
			foreach($post['settings'] as $key=>$value):
				$record = array(
					"settings" => $value
				);

				Vn_List::save($record, $key);
			endforeach;
			*/

			//Update car load

			$total_vn = VN_List::countAllByDrId($post_id);
			$params = array("truck_id"=>$post['truck_plate_no'], "total_load"=>$total_vn);
			Truck_List::update_truck_load($params);

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
		sleep(1);
		unset($_SESSION['tmp']);

		if($post) {

			if($_FILES['vn_excel']['error'] == 0) {
				$this->load->library('php_excel/PHPExcel');
				$excel = $_FILES['vn_excel']['tmp_name'];
				$delivery_plan = Vn_List::create_delivery_plan($excel);

				#debug_array($delivery_plan);

				$row_counter = 1;
				$is_new_dr	 = true;

				foreach($delivery_plan as $key=>$value):

					$delivery_no 	= str_pad(date("mYd").Delivery_Receipt::getNextIncrementId(), 12, "0", STR_PAD_LEFT);

					if($value['delivery_type'] == "INBOUND" || $value['delivery_type'] == "OUTBOUND") {

						$pick_up_point 	= Address_List::findByAddressCode(array("fields"=>array("id,address"),"address_code"=>$value['pickup_point']));
						$delivery_point = Address_List::findByAddressCode(array("fields"=>array("id,address"),"address_code"=>$value['delivery_point']));

						$delivery_point_code 	= $value['delivery_point'];

						// Pull address from the client list table
						$client 	= Client_List::findById($post['client_name'], array("id,delivery_address_code"));
						$delivery 	= Address_List::findByAddressCode(array("fields"=>array("id,address_code,address"),"address_code"=>$client['delivery_address_code']));

						$delivery_address_code 	= $delivery['address_code'];

					} else {

						//Pull address from excel template
						$delivery = Address_List::findByAddressCode(array("fields"=>array("id,address_code,address"),"address_code"=>$value['delivery_address']));
						$delivery_address_code 	= $delivery['address_code'];

						$pick_up_point 	= "";
						$delivery_point = "";

						$delivery_point_code 	= "";
					}

					if($is_new_dr || $value['delivery_type'] == SPECIAL) {

						$client = Client_List::findById($post['client_name'], array("id,client_name"));

						$record = array(
							"user_id" 				=> 1,
							"delivery_no" 			=> $delivery_no,
							"client_id" 			=> $client['id'],
							"client_name" 			=> $client['client_name'],
							"delivery_address_code" => $delivery_address_code,
							"delivery_address" 		=> $delivery['address'],
							"pickup_point" 			=> $pick_up_point['address'],
							"delivery_point_code" 	=> $delivery_point_code,
							"delivery_point" 		=> $delivery_point['address'],
							"delivery_type" 		=> $value['delivery_type'],
							"status" 				=> PENDING,
							"billing_status" 		=> PENDING,
							"is_archive" 			=> NO,
							"date_created" 			=> Tool::getCurrentDateTime(),
							"last_update_by" 		=> 1,
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
						"delivery_type" 		=> $value['delivery_type'],
						"date_created" 			=> Tool::getCurrentDateTime(),
						"last_update_by" 		=> 1,
					);

					Vn_List::save($record);

					if($row_counter == 6 || $value['delivery_type'] == SPECIAL) {
						$is_new_dr 		= true;
						$row_counter 	= 0;
					}

					$row_counter++;
				endforeach;

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

			$client 	= Client_List::findById($post['client_name'], array("id,client_name"));
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
		$this->authenticate_user();
		$get = $this->input->get();
		
		if($get) {

			$this->load->library('tcpdf/tcpdf');
			$data['receipt'] 	= $receipt = Delivery_Receipt::findById($get['id']);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty,settings");
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

			$dr 		= Delivery_Receipt::findById($id);
			$truck 		= Truck_List::findById($dr['truck_id']);
			$vn 		= Vn_List::findAllByDeliveryReceipt($dr['id']);

			$params = array("truck_id" => $dr['truck_id'], "total_load" => count($vn));
			Truck_List::update_truck_load($params,true);

			$record = array(
				"driver_id" 			=> "",
				"driver_name" 			=> "",
				"other_driver_id" 		=> "",
				"other_driver_name" 	=> "",
				"truck_id" 				=> "",
				"plate_no" 				=> "",
				"delivery_date" 		=> "",
				"delivery_address_code" => "",
				"delivery_address" 		=> "",
				"status" 				=> REJECTED,
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

	function cleared_receipt() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();

		$session = $_SESSION['rvl']['login'];

		if($post) {
			$id = (int) $post['id'];
			$record = array(
				"status" => CLEARED,
			);

			$dr = Delivery_Receipt::findById($id);

			$array = array($dr['driver_id'], $dr['other_driver_id']);

			foreach($array as $key=>$value):
				$record2 = array(
					"delivery_receipt_id" => $dr['id'],
					"driver_id" => $value,
					"delivery_date" => $dr['delivery_date'],
					"date_created" 	=> Tool::getCurrentDateTime('Y-m-d H:i:s','Asia/Manila'),
					"last_update_by" => (int) $this->encrypt->decode($session['user_id']),
				);

				Payroll_Register::save($record2);
			
			endforeach;

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

	function scan_delivery_plan() {
		$this->authenticate_user();

		$data['ac'] = $ac = $_SESSION['rvl']['login']['account_type'];
		User_Roles::verifyUserAccess($ac,"scan_delivery_plan");

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('delivery_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Delivery Management";

		$data['delivery_management'] 	= "active";
		$data['scan_receipt_form'] 		= "active";

		$this->load->view('delivery_management/scan_delivery_plan',$data);
	}

	function show_dr_details() {
		
		$post = $this->validate_ajax_post();

		$session = $_SESSION['rvl']['login'];

		if($post) {

			$user_id 	= (int) $this->encrypt->decode($session['user_id']);

			$user 		= User::findById($user_id);
			$employee 	= Employee::findById( array("id"=>$user['employee_id']) );

			$delivery_no 	= (int) $post['delivery_no'];
			$fields 		= array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,delivery_address,pickup_point,delivery_point,status,date_created");
			$params = array(
				"delivery_no" 	=> $delivery_no,
				"client_id" 	=> $employee['client_id'],
				"account_type"  => $session['account_type']
			);

			$data['dr'] = $dr = Delivery_Receipt::scanDeliveryDetails($params);

			$params2 = array(
				"dr_id" 				=> $dr['id'],
				"client_id" 			=> $employee['client_id'],
				"user_id" 				=> $user_id,
			);

			$data['dpt'] = $dpt = Delivery_Plan_Tracking::findExistingConfirmation($params2);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty,settings");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr['id'], $fields);
			
			$this->load->view('delivery_management/show_dr_details',$data);
		}
		
	}

	function received_delivery_plan() {
		$post = $this->input->post();

		$session = $_SESSION['rvl']['login'];

		$user_id = $this->encrypt->decode($session['user_id']);

		$params = array(
			"dr_id" 				=> $post['dr_id'],
			"client_id" 			=> $post['client_id'],
			"user_id" 				=> $user_id,
		);

		#$dpt = Delivery_Plan_Tracking::findExistingConfirmation($params);

		#if(!$dpt) {

			$datetime = date("Y-m-d H:i:s",time());

			$dr = Delivery_Receipt::findById($post['dr_id']);

			if($dr['warehouse_datetime_in'] == "") {
				$confirmed_type = "Warehouse In";
				$arr = array("warehouse_datetime_in" => $datetime);
			} else if($dr['warehouse_datetime_out'] == "") {
				$confirmed_type = "Warehouse Out";
				$arr = array("warehouse_datetime_out" => $datetime);
			} else if($dr['dealer_datetime_in'] == "") {
				$confirmed_type = "Dealer In";
				$arr = array("dealer_datetime_in" => $datetime);
			} else if($dr['dealer_datetime_out'] == "") {
				$confirmed_type = "Dealer Out";
				$arr = array("dealer_datetime_out" => $datetime);
			}

			Delivery_Receipt::save($arr, $dr['id']);

			$params = array(
				"dr_id" 				=> $post['dr_id'],
				"client_id" 			=> $post['client_id'],
				"user_id" 				=> $user_id,
				"datetime_confirmed" 	=> $datetime,
				"confirmed_type" 		=> $confirmed_type,
				"date_created" 			=> $datetime,
				"last_update_by" 		=> $user_id,

			);

			Delivery_Plan_Tracking::save($params);



			#$json['is_confirmed'] = true;
		#} else {
		#	$json['is_conirmed'] = false;
		#}

		echo json_encode($json);
	
	}

	function set_print() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();

		if($post) {
			$post_id = (int) $post['id'];

			$record = array(
				"status" => PRINTED,
			);

			Delivery_Receipt::save($record, $post_id);

			$json['is_successful'] = true;
		}

		echo json_encode($json);
	}

	function validate_ajax_post() {
		Engine::XmlHttpRequestOnly();
		$post = $this->input->post();
		if($post) {
			return $post;
		} else {
			die("Ooops! Error occured. Please contact web administrator!");
		}
	}

	function clear_delivery_plans() {
		$this->authenticate_user();

		Bootstrap::datetimepicker();
		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');
		Engine::appScript('confirmation.js');
		Engine::appScript('delivery_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Clear Delivery Plans";

		$data['delivery_management'] 	= "active";
		$data['clear_dr'] 				= "active";

		$this->load->view('delivery_management/clear_dr/index',$data);
	}

	function show_printed_delivery_plan() {
		$post = $this->validate_ajax_post();

		$session = $_SESSION['rvl']['login'];

		if($post) {

			$delivery_no = (int) $post['delivery_no'];
			$params = array(
				"delivery_no" 	=> $delivery_no,
				"client_id" 	=> $employee['client_id'],
			);

			$data['dr'] = $dr = Delivery_Receipt::findPrintedByDeliveryNo($params);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty,settings");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr['id'], $fields);
			
			$this->load->view('delivery_management/clear_dr/show_dr_details',$data);
		}
	}

	function verify_delivery_plan() {
		$post = $this->validate_ajax_post();
		
		if($post) {
			$dr_id = (int) $post['dr_id'];

			$params = array(
				"status" 	=> CLEARED,
			);
			Delivery_Receipt::save($params,$dr_id);

			$dr 	= Delivery_Receipt::findById($dr_id);
			$array 	= array($dr['driver_id'], $dr['other_driver_id']);

			foreach($array as $key=>$value):

				$basic_pay = 0;

				if(strtolower($dr['client_name']) == "honda") {

					$truck 		= Truck_List::findByPlateNo( array("plate_no" => $dr['plate_no'] ) );
					$truck_type = $truck['truck_type'];

					$params = array(
						"pick_up_point" => $dr['pick_up_point_code'],
						"destination" 	=> $dr['delivery_address_code'],
						"load_unit" 	=> 5,
						"delivery_type" => $dr['delivery_type'],
					);

					$rh = Rate_Honda::findHaulingCharges($params);
					$basic_pay = $rh[strtolower($truck_type)];
				}

				$record2 = array(
					"delivery_receipt_id" 	=> $dr['id'],
					"driver_id" 			=> $value,
					"delivery_date" 		=> $dr['delivery_date'],
					"basic_pay" 			=> $basic_pay,
					"date_created" 			=> Tool::getCurrentDateTime('Y-m-d H:i:s','Asia/Manila'),
					"last_update_by"	 	=> (int) $this->encrypt->decode($session['user_id']),
				);

				Payroll_Register::save($record2);
			
			endforeach;

			$params = "";
			foreach($post['settings'] as $key=>$value):
				$params = array(
					"settings" 	=> $value,
				);
				Vn_List::save($params, $key);
			endforeach;

		}
	}

	function search() {
		$this->authenticate_user();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('delivery_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Delivery Management";

		$data['delivery_management'] 	= "active";
		$data['search_all_dr'] 			= "active";

		$this->load->view('delivery_management/search/search_all_dr',$data);
	}

	function show_all_dr() {
		
		$post = $this->validate_ajax_post();
		if($post) {
			$delivery_no 	= (int) $post['delivery_no'];
			
			#$fields 		= array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,delivery_address,pickup_point,delivery_point,status,date_created");

			$data['dr'] = $dr = Delivery_Receipt::findByDeliveryNo($delivery_no);
			
			$params2 = array(
				"dr_id" 		=> $dr['id'],
				"client_id" 	=> $employee['client_id'],
				"user_id" 		=> $user_id,
			);

			$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty,settings");
			$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($dr['id'], $fields);
			
			$this->load->view('delivery_management/search/show_dr_details',$data);
		}
		
	}

}