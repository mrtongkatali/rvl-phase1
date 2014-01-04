<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payroll extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();
 		date_default_timezone_set("Asia/Manila");

 		$data['ac'] = $ac = $_SESSION['rvl']['login']['account_type'];
		User_Roles::verifyUserAccess($ac,"payroll");

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

		Engine::appScript('payroll.js');

		Bootstrap::datetimepicker();

		Jquery::form();
		Jquery::tipsy();
		Jquery::datatable();

		$data['page_title'] 		= "IDRS :: Payroll";
		$data['payroll_management']	= "active";
		$data['payroll_register'] 	= "active";

		$this->load->view('payroll/index',$data);
	}

	function driver_list() {
		Engine::XmlHttpRequestOnly();
		$this->load->view('payroll/driver_list',$data);
	}

	function get_driver_list() {
		Engine::XmlHttpRequestOnly();
		$get = $this->input->get();

		if($get) {
			$sorting 	= (int) $get['iSortCol_0'];
			$query   	= $get['sSearch'];
			$order_type	= strtoupper($get['sSortDir_0']);

			$display_start 	= (int) $get['iDisplayStart'];

			$rows = array(
				0 => "id",
				1 => "full_name",
				2 => "driver_license",
				3 => "full_name",
				4 => "full_name",
				5 => "status",
			);

			$order_by 	= $rows[$sorting] . " {$order_type}";
			$limit  	= $display_start . ", 10";

			$params = array(
				"search" => $query,
				#"fields" => array("id,firstname,middlename,delivery_address,contact_person,status"),
				"order"  => $order_by,
				"limit"  => $limit,
			);

			$driver_list = Driver_List::generateDriverListDatatable($params);
			
			$total_records = Driver_List::countDriverListDatatable($params);

			$output = array(
				"sEcho" => $get['sEcho'],
				"iTotalRecords" => $total_records,
				"iTotalDisplayRecords" => $total_records,
				"aaData" => array()
			);

			foreach($driver_list as $key=>$value):

				$total_trips	= 0;
				$params 		= array("driver_id" => $value['id']);
				$total_trips 	= Delivery_Receipt::countTotalTripByDriver($params);
				$weekly_trips	= Delivery_Receipt::countWeeklyTripByDriver($params);

				$action_link = '
					<a href="'.url("payroll/generate_payslip?driver_id=".$value['id']).'" class="generate_payslip  table_icon" title="Generate Payslip"><i class="icon-list-alt"></i></a>
				';

				$row = array(
					'DT_RowClass' => "",

					'0' => "<div class='ss_table_icons'>{$action_link}</div>",
					'1' => $value['full_name'],
					'2' => $value['driver_license'],
					'3' => $total_trips,
					'4' => $weekly_trips,
					'5' => $value['status'],
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

	function day_week() {
		$start_sat 	= date("Y-m-d", strtotime('last Saturday'));
		$start_sun 	= date("Y-m-d", strtotime('last Sunday'));

		$end_sat	= date("Y-m-d", strtotime('next Saturday'));
		$end_sun	= date("Y-m-d", strtotime('next Sunday'));

		$date_today = date("D");

		if($date_today == "Sun") {
			$start_sat = date("Y-m-d", strtotime("-1 day") );
			$start_sun = date("Y-m-d");
		}

		echo "{$start_sat} : {$start_sun} <br/> {$end_sat} : {$end_sun}";

	}

	function generate_payslip() {
		$this->authenticate_user();

		$get = $this->input->get();

		if($get) {

			Bootstrap::datetimepicker();
			Bootstrap::modal();

			Engine::appStyle('bootstrap.min.css');
			Engine::appStyle('application.css');
			Engine::appStyle('general.css');

			Engine::appScript('payroll.js');

			Jquery::form();
			Jquery::datatable();
			Jquery::inline_validation();
			Jquery::tipsy();
			Jquery::select2();

			$data['page_title'] = "IDRS :: Payroll";
			$data['payroll'] 	= "active";

			$start_sun 	= date("Y-m-d", strtotime('last Sunday'));
			$end_sun	= date("Y-m-d", strtotime('next Sunday'));
			$date_today = date("D");

			if($date_today == "Sun") {
				$start_sat = date("Y-m-d", strtotime("-1 day") );
				$start_sun = date("Y-m-d");
			}

			$data['start_date'] = $start_sun;
			$data['end_date'] 	= $end_sun;
			
			$get_id = (int) $get['driver_id'];

			$data['driver'] = $driver = Driver_List::findById($get_id);

			$this->load->view('payroll/generate_payslip',$data);
		} else {
			die(DEFAULT_ERROR);
		}
	}

	function filter_payroll_register() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();

		if($post) {
			$params = array(
				"driver_id" => (int) $post['driver_id'],
				"from" 		=> $post['from_date'],
				"to" 		=> $post['to_date'],
			);

			$from_date 	= date("M d, Y",strtotime($post['from_date']));
			$to_date 	= date("M d, Y",strtotime($post['to_date']));

			$data['pay_period'] = $pay_period = $from_date . " - " . $to_date;

			$data['payslip'] = $payslip = Payroll_Register::findAllPayslipByDate($params);

			$this->session->set_userdata('payslip_data', $payslip);
			$this->session->set_userdata('payslip_pay_period', $pay_period);

			$this->load->view('payroll/work_summary_history_list',$data);
		}
	}

	function download_payslip() {

		$payslip_data 		= $this->session->userdata('payslip_data', $payslip);
		$payslip_pay_period = $this->session->userdata('payslip_pay_period', $payslip);

		if($payslip_data) {

			foreach($payslip_data as $key=>$value):
				$driver_id = $value['driver_id'];
				$gross_pay += $value['basic_pay'];
			endforeach;

			$driver 	= Driver_List::findById($driver_id);
			$tax 		= Settings_Rate::findActiveRate();

			$data['gross_pay'] 			= $gross_pay;
		    $data['witholding'] 		= $witholding = $gross_pay * ($tax['witholding_tax'] / 100);
		    $data['philhealth'] 		= $philhealth = $gross_pay * ($tax['philhealth'] / 100);
		    $data['pagibig'] 			= $pagibig = $gross_pay * ($tax['pagibig'] / 100);
		    $data['total_deduction'] 	= $total_deduction = $witholding + $philhealth + $pagibig;
		    $data['net_pay'] 			= $net_pay = $gross_pay - ($witholding + $philhealth + $pagibig);
		    $data['driver'] 			= $driver['full_name'];
		    $data['pay_period'] 		= $payslip_pay_period;

			$this->session->unset_userdata('payslip_data');
		    $this->session->unset_userdata('payslip_pay_period');

			$this->load->library('tcpdf/tcpdf');
			$this->load->view('payroll/download_payslip_pdf',$data);

		} else {
			die(DEFAULT_ERROR);
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

	function computation_settings() {
		$this->authenticate_user();
		
		Bootstrap::datetimepicker();
		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('confirmation.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: Computation Settings";

		$data['payroll_management'] 	= "active";
		$data['computation_settings'] = "active";

		$data['rate'] = $rate = Settings_Rate::findActiveRate();

		$this->load->view('payroll/computation_settings/index',$data);
	}

	function update_tax_computation() {
		$this->authenticate_user();

		$post = $this->validate_ajax_post();
		$rate = Settings_Rate::findById( (int) $post['id'] );
		if($post && $rate) {
			$record = array(
				"witholding_tax" 	=> $post['witholding_tax'],
				"philhealth" 		=> $post['philhealth'],
				"sss" 				=> $post['sss'],
			);

			Settings_Rate::save($record, (int) $post['id']);

			$json['is_successful'] 	= TRUE;
			$json['message'] 		= "Computation has been updated successfully!";
		} else {
			$json['is_successful'] 	= FALSE;
		}

		echo json_encode($json);
	}

	function generate_payslip_bulk_form() {
		Engine::XmlHttpRequestOnly();

		$start_sun 	= date("Y-m-d", strtotime('last Sunday'));
		$end_sun	= date("Y-m-d", strtotime('next Sunday'));
		$date_today = date("D");

		if($date_today == "Sun") {
			$start_sat = date("Y-m-d", strtotime("-1 day") );
			$start_sun = date("Y-m-d");
		}

		$data['start_date'] = $start_sun;
		$data['end_date'] 	= $end_sun;

		$this->load->view('payroll/form/generate_payslip_bulk',$data);
	}

	function url_enco() {
		$url = "id=1&from_date=1&to_date=1";
		echo urlencode($url);
	}

	function generate_payslip_bulk() {
		$this->authenticate_user();
		$get = $this->input->get();

		if($get) {
			$params = array(
				"from" 		=> $get['from_date'],
				"to" 		=> $get['to_date'],
			);

			$bulk_ps = Payroll_Register::findAllDriverPayslipByDate($params);

			foreach($bulk_ps as $key=>$value):

				$payslip[$value['driver_id']][] = array(
					"delivery_receipt_id" 	=> $value['delivery_receipt_id'],
					"driver_id" 			=> $value['driver_id'],
					"basic_pay"				=> $value['basic_pay'],
					"from"					=> $get['from_date'],
					"to"					=> $get['to_date'],
				);

			endforeach;

			$tax = Settings_Rate::findActiveRate();

			foreach($payslip as $key=>$value):

				$gross_pay 			= "";
				$witholding 		= "";
				$philhealth			= "";
				$pagibig 			= "";
				$total_deduction 	= "";
				$net_pay 			= "";

				foreach($value as $a=>$b):

					$driver 	= Driver_List::findById($b['driver_id']);
					$pay_period = date("M d, Y",strtotime($b['from'])) . " - " . date("M d, Y",strtotime($b['to']));

					$gross_pay 			+= $b['basic_pay'];
				    $witholding 		= $gross_pay * ($tax['witholding_tax'] / 100);
				   	$philhealth 		= $gross_pay * ($tax['philhealth'] / 100);
				   	$pagibig 			= $gross_pay * ($tax['pagibig'] / 100);
				    $total_deduction 	= $witholding + $philhealth + $pagibig;
				    $net_pay 			= $gross_pay - ($witholding + $philhealth + $pagibig);

				endforeach;

				$employee_payslip[] = array(
					"driver" 			=> $driver['full_name'],
					"pay_period" 		=> $pay_period,
					"gross_pay" 		=> $gross_pay,
					"witholding" 		=> $witholding,
					"philhealth" 		=> $philhealth,
					"pagibig" 			=> $pagibig,
					"total_deduction" 	=> $total_deduction,
					"net_pay" 			=> $net_pay,
				);

			endforeach;

			$data['employee_payslip'] = $employee_payslip;

			$this->load->library('tcpdf/tcpdf');
			$this->load->view('payroll/download_payslip_group_pdf',$data);

		}
	}
	

}