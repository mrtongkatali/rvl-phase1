<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();

	}

	function index() {
		$this->user();
	}

	function user() {
		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('login.css');
		Jquery::form();
		Jquery::inline_validation();
		Jquery::tipsy();

		$data['page_title'] = "Login";

		if(!$this->is_user_logged_in()) {
			$login_failed = $this->session->flashdata('login_failed');
			if($login_failed) {
				$data['error_message'] = '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><b><center>Invalid Username or Password!</center></b></div>';
			}
		} else {
			redirect("user_gateway");
		}

		$this->load->view('login/login',$data);
	}

	function is_user_logged_in() {
		$session = $_SESSION['rvl']['login'];
		if($session) {
			$user_id = (int) $this->encrypt->decode($session['user_id']);

			$user = User::findById($user_id, array("id"));

			return ($user ? true : false);

		} else {
			return false;
		}
	}

	function authenticate_account() {
		$posts = $this->input->post();
		if($posts) {
			$username = $posts['username'];
			$password = $posts['password'];

			$user = User::findActiveUserByUsernameOrEmail($username);

			if($user) {

				$verified_password 	= ($this->encrypt->decode($user['password']) == $password ? true : false);
				$verified_hash 		= Password_Hash::validate_password($password,$user['hash']);
				$is_employee_exist	= Employee::isActiveExist($user['employee_id']);

				if($verified_password && $verified_hash && $is_employee_exist) {

					$employee = Employee::findById(array("id"=>$user['employee_id']));

					$credentials = array(
						'user_id' 		=> $this->encrypt->encode($user['id']),
						'firm_id' 		=> $this->encrypt->encode($user['firm_id']),
						'firstname' 	=> $employee['firstname'],
						'middlename' 	=> $employee['middlename'],
						'lastname' 		=> $employee['lastname'],
						'name' 			=> $employee['firstname'] . ' ' . $employee['lastname'],
						'account_type' 	=> $user['account_type'],

					);

					$_SESSION['rvl']['login'] = $credentials;

					redirect("user_gateway");
					
				} else {
					$this->session->set_flashdata('login_failed', true);
					redirect('login');
				}
				
			} else {
				$this->session->set_flashdata('login_failed', true);
				redirect('login');
			}
		}
	}

	function module_gateway() {
		$session = $_SESSION['rvl']['login'];
		if($session) {
			/*
			$firm = Firm::findById($this->encrypt->decode($session['firm_id']));
		
			if($session['account_type'] == SUPER_ADMIN) {
				redirect('super');
			} else if($session['account_type'] == FIRM_ADMIN)  {
				redirect("firms");
			} else if($session['account_type'] == USER_LEVEL)  {
				redirect("cases");
			}
			*/

			redirect("home");
		} else {
			redirect('login');
		}
		
	}

	function user_logout() {
		session_destroy();
		redirect("user_gateway");

	}

}