<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Management extends CI_Controller {
	function __construct() {
		parent::__construct();
 		$this->load->database();
 		Engine::class_loader();

	}

	function index() {
		$this->welcome();
	}

	function welcome() {
		$this->authenticate_user();
		
		Bootstrap::datetimepicker();
		Bootstrap::modal();

		Engine::appStyle('bootstrap.min.css');
		Engine::appStyle('application.css');
		Engine::appStyle('general.css');

		Engine::appScript('user_management.js');

		Jquery::form();
		Jquery::datatable();
		Jquery::inline_validation();
		Jquery::tipsy();
		Jquery::select2();

		$data['page_title'] = "IDRS :: User Management";

		$data['user_management'] 	= "active";

		$this->load->view('user_management/index',$data);
	}

	function add_user_form() {
		$this->authenticate_user();
		Engine::XmlHttpRequestOnly();

		$this->load->view('user_management/form/add_user',$data);
	}

}