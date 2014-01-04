<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing_Management extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		date_default_timezone_set("Asia/Manila");

 		$data['ac'] = $ac = $_SESSION['rvl']['login']['account_type'];
		User_Roles::verifyUserAccess($ac,"billing_management");

	}

	function index() {
		$this->welcome();
		#redirect('coming_soon');
	}

	function welcome() {
		$this->authenticate_user();
		
		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('billing_management.js');

		Jquery::form();
		Jquery::tipsy();
		Jquery::datatable();

		$data['page_title'] = "IDRS :: Billing Management";
		$data['billing_management'] = "active";

		$this->load->view('billing_management/index',$data);
	}

	function client_list() {
		Engine::XmlHttpRequestOnly();
		$this->load->view('billing_management/client_list',$data);
	}

	function get_client_list() {
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();

		if($get) {
			$sorting 	= (int) $get['iSortCol_0'];
			$query   	= $get['sSearch'];
			$order_type	= strtoupper($get['sSortDir_0']);

			$display_start 	= (int) $get['iDisplayStart'];

			$rows = array(
				0 => "id",
				1 => "client_name",
				2 => "client_name",
				3 => "client_name",
				4 => "status",
			);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$params = array(
				"search" => $query,
				"fields" => array("id,client_name,delivery_address,contact_person,status"),
				"order"  => $order_by,
				"limit"  => $limit,
			);

			$client_list = Client_List::generateBillingListDataTable($params);
			
			$total_records = Client_List::countBillingListDataTable($params);

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			foreach($client_list as $key=>$value):

				/*
				$action_link = '
					<a href="javascript:void(0);" class="generate_invoice table_icon" title="Generate Invoice" onclick="javascript:update_dr_form('.$value['id'].');"><i class="icon-list-alt"></i></a>
				';
				*/

				$action_link = '
					<a href="javascript:void(0);" class="view_dr_plans table_icon" title="View DR Plans"  onclick="javascript:show_client_dr_list('.$value['id'].');"><i class="icon-search"></i></a>
					<a href="'.url("view_client_dr?client_id=".$value['id']).'" class="generate_invoice  table_icon" title="Generate Invoice"><i class="icon-list-alt"></i></a>
				';

				$params = array("client_id" => $value['id']);
				$total_cleared_dr_plans = Delivery_Receipt::countTotalClearedDrPlansByClient($params);

				$params = array("client_id" => $value['id']);
				$total_billed_dr_plans = Delivery_Receipt::countTotalBilledDrPlansByClient($params);


				$row = array(
					'DT_RowClass' => "",

					'0' => "<div class='ss_table_icons'>{$action_link}</div>",
					'1' => $value['client_name'],
					'2' => $total_cleared_dr_plans,
					'3' => $total_billed_dr_plans,
					'4' => "<small>".$value['status']."</small>",
				);

				$output['aaData'][] = $row;

				$row_class = "";
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

	function view_client_dr() {
		$this->authenticate_user();
		$get = $this->input->get();


		$client_id = (int) $get['client_id'];

		$data['client'] = $client = Client_List::findById($client_id,array("id,client_name"));

		if($client) {

			Bootstrap::datetimepicker();
			Bootstrap::modal();

			Engine::appStyle('bootstrap.min.css');
			Engine::appStyle('application.css');
			Engine::appStyle('general.css');

			Engine::appScript('billing_management.js');

			Jquery::form();
			Jquery::datatable();
			Jquery::inline_validation();
			Jquery::tipsy();
			Jquery::select2();

			$data['page_title'] = "IDRS :: Billing Management";
			$data['billing_management'] = "active";

			$this->load->view('billing_management/client_dr_list',$data);
		} else {
			die(DEFAULT_ERROR);
		}
	}

	function search_client_dr_plan_form() {
		$this->authenticate_user();

		if($this->validate_ajax_post()) {

			$post = $this->input->post();

			$client_id 	= (int) $post['client_id'];
			$client 	= Client_List::findById($client_id,array("id,client_name"));

			if($client) {
				$params = array(
					"client_id" => $client_id,
					"from" 		=> $post['from_date'],
					"to" 		=> $post['to_date'],
				);

				$data['dr'] = $dr = Delivery_Receipt::findAllClientDrPlansByDateRange($params);

				$date_arr = array(
					"from" 	=> $post['from_date'],
					"to" 	=> $post['to_date'],
				);

				$_SESSION['tmp']['invoice_dr_list'] = $dr;
				$_SESSION['tmp']['invoice_date_coverage'] = $date_arr;
				
			}

			$this->load->view('billing_management/delivery_plan_list',$data);
		}
	}

	function show_cleared_dr_list() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();

		if($post) {
			$data['client_id'] = $client_id = (int) $post['client_id'];

			$this->load->view('billing_management/cleared_dr_list',$data);
		}
	}

	function get_cleared_list_dt() {
		$this->authenticate_user();
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();

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
				7 => "billing_date",
			);

			$client_id 	= (int) $get['client_id'];

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$fields = array("id,delivery_no,client_name,driver_name,other_driver_name,plate_no,delivery_date,status,billing_status,billing_date,date_created");

			$params = array(
				"client_id" => $client_id,
				"search" 	=> $query,
				"fields" 	=> $fields,
				"order"  	=> $order_by,
				"limit"  	=> $limit,
			);

			// to be continued
			$cleared_dr_list 	= Delivery_Receipt::generateClearedPlansDatatable($params);
			
			$total_records 		= Delivery_Receipt::countClearedPlansDatatable($params);

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);
			
			foreach($cleared_dr_list as $key=>$value):

				$action_link = "";
				if($value['billing_status'] != BILLED) {
					$action_link = '
						<a href="javascript:void(0);" class="view_details table_icon" title="View Details" onclick="javascript:invoice_cleared_dr_from('.$value['id'].');"><i class="icon-search"></i></a>
					';
				}

				$row = array(
					'DT_RowClass' => $row_class,

					'0' => "<div class='ss_table_icons'>{$action_link}</div>",
					'1' => $value['delivery_no'],
					'2' => $value['client_name'],
					'3' => $value['plate_no'],
					'4' => $value['driver_name'],
					'5' => $value['other_driver_name'],
					'6' => ($value['delivery_date'] ? date("M d, Y",strtotime($value['delivery_date'])) : ""),
					'7' => ($value['billing_date'] ? date("M d, Y",strtotime($value['billing_date'])) : ""),
					'8' => "<small>".$value['billing_status']."</small>",
				);

				$output['aaData'][] = $row;

				$row_class = "";
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

	function invoice_cleared_dr_form() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();

		if($post) {

			$post_id = (int) $post['id'];

			$data['dr'] = $dr = Delivery_Receipt::findById($post_id);
			if($dr) {
				
				$fields 			= array("id,vin_no,conduction_sticker_no,model,color,qty");
				$data['vn_list'] 	= $vn = Vn_List::findAllByDeliveryReceipt($post_id, $fields);
				
				$this->load->view('billing_management/form/invoice_cleared_dr',$data);
			}
		}
	}

	function invoice_cleared_dr() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();

		$post_id 	= (int) $post['id'];
		$dr 		= Delivery_Receipt::findById($post_id);

		$session = $_SESSION['rvl']['login'];

		if($dr) {
			$record = array(
				"billing_status" 	=> BILLED,
				"billing_date" 		=> date("Y-m-d H:i:s",time()),
				"last_update_by" 	=> $this->encrypt->decode($session['user_id']),
			);
			Delivery_Receipt::save($record,$post_id);



			$json['is_successful'] = true;
		}

		echo json_encode($json);
	}

	function generate_invoice_receipt() {
		$invoice_dr_list = $_SESSION['tmp']['invoice_dr_list'];

		if($invoice_dr_list) {

			foreach($invoice_dr_list as $key=> $value):
				$params = array(
					"client_id" 		=> $value['client_id'],
					"pick_up_point" 	=> $value['pick_up_point_code'],
					"delivery_address" 	=> $value['delivery_address_code'],
					"trip_type" 		=> $value['delivery_type'],
					//"fields" 			=> array(),
				);

				$rate = Trip_Rates::findCorrespondingCost($params);
			
				$vn_list = Vn_List::findAllByDeliveryReceipt($value['id']);
				foreach($vn_list as $key2=>$val):

					if($value['client_id'] == 11) {
						$params = array(
							"pick_up_point" => $value['pick_up_point_code'],
							"destination" 	=> $value['delivery_address_code'],
							"load_unit" 	=> 5,
							"delivery_type" => $value['delivery_type'],
						);

						$rh = Rate_Honda::findHaulingCharges($params);

						$charges = $rh['hauling_charge'];
					}

					$arr_vn[] = array(
						"dr_no" 			=> $val['vin_no'],
						"invoice_date" 		=> date("M d, Y"),
						"delivery_date" 	=> date("M d, Y",strtotime($value['delivery_date'])),
						"model" 			=> $val['model'],
						"qty" 				=> $val['qty'],
						"pickup_address" 	=> $value['pickup_point'],
						"delivery_address" 	=> $value['delivery_address'],
						"truck_used" 		=> $value['plate_no'],
						"trip_type" 		=> $value['delivery_type'],
						"charges" 			=> $charges,
					);
				endforeach;

				$arr[] = array(
					"bill_to" 			=> $value['client_name'],
					"client_address" 	=> $value['delivery_address'],
					"pick_up_point" 	=> $value['pick_up_point_code'],
					"delivery_address" 	=> $value['delivery_address_code'],
					"from" 				=> $value['from'],
					"to" 				=> $value['to'],
					"date_prepared" 	=> date("M d, Y"),
					"vn_list" 			=> $arr_vn
				);

				unset($arr_vn);

				$dr_id = (int) $value['id'];

				$dr_params = array(
					"is_already_generated" => YES
				);

				Delivery_Receipt::save($dr_params, $dr_id);

			endforeach;

			#debug_array($arr);

			$data['billing_data'] = $arr;
			
			$date_coverage	= $_SESSION['tmp']['invoice_date_coverage'];

			$array_from = array( date("Y",strtotime($date_coverage['from'])), date("M",strtotime($date_coverage['from'])), date("d",strtotime($date_coverage['from'])) );
			list($from_year, $from_month, $from_day) = $array_from;

			$array_to = array( date("Y",strtotime($date_coverage['to'])), date("M",strtotime($date_coverage['to'])), date("d",strtotime($date_coverage['to'])) );
			list($to_year, $to_month, $to_day) = $array_to;

			if($from_year == $to_year) {

				if($from_month == $to_month && $from_day == $to_day) {
					//feb 21, 2013
					$data['date_coverage'] = $aa_date = "{$from_month} {$from_day}, {$from_year}";
				} else if($from_month == $to_month && $from_day != $to_day) {
					//feb 21 - 22, 3013
					$data['date_coverage'] = $aa_date = "{$from_month} {$from_day} - {$to_day}, {$from_year}";
				} else {
					//feb 21 - March 22, 2013
					$data['date_coverage'] = $aa_date = "{$from_month} {$from_day} - {$to_month} {$to_day}, {$from_year}";
				}
			} else {
				$data['date_coverage'] = $aa_date = "{$from_month} {$from_day} {$from_year} - {$to_month} {$to_day}, {$to_year}";
			}

			unset($_SESSION['tmp']['invoice_dr_list']);

			$this->load->library('tcpdf/tcpdf');
			$this->load->view('billing_management/generate_billing_pdf',$data);
			
		} else {
			die(DEFAULT_ERROR);
		}
	}

	function tcpdf_working()
    {
        $this->load->library('tcpdf/tcpdf');
        
        for ($i = 33; $i < 91; $i++) {
            
        $obj = new $this->tcpdf;
        
        // set document information
            $obj->SetSubject('TCPDF Tutorial');
            $obj->SetKeywords('TCPDF, PDF, example, test, guide');
            
            // set font
            $obj->SetFont('times', 'BI', 16);
            
            // add a page
            $obj->AddPage();
            // print a line using Cell()
            $obj->Cell(0, 12, 'Print this number: '.$i, 1, 1, 'C');

            $filename = 'testat_'.$i.'.pdf';    
            $path = $filename;
            //Close and output PDF document
            ob_start();
            $obj->Output($path, 'D');
            ob_end_clean();
        }
               
    } 

	function validate_ajax_post() {
		Engine::XmlHttpRequestOnly();
		
		$post = $this->input->post();

		if($post) {
			return $post;
		} else {
			die(DEFAULT_ERROR);
		}
	}
	

}