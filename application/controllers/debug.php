<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends CI_Controller {
	
	function __construct() {
		 parent::__construct();
		 Engine::class_loader();
 		 //$this->load->database();
	}

	public function index()
	{
		#$this->load->view('header');
		$this->load->view('welcome_message');
		#$this->load->view('footer');
	}

	public function using_templates() {
		$this->load->view('debug/index');
	}
	
	public function using_xss_clean() {

		$xss_array = array(
			'index.php?name=<script>window.onload = function() {var link=document.getElementsByTagName("a");link[0].href="http://not-real-xssattackexamples.com/";}</script>',
			'index.php?name=%3c%73%63%72%69%70%74%3e%77%69%6e%64%6f%77%2e%6f%6e%6c%6f%61%64%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%20%7b%76%61%72%20%6c%69%6e%6b%3d%64%6f%63%75%6d%65%6e%74%2e%67%65%74%45%6c%65%6d%65%6e%74%73%42%79%54%61%67%4e%61%6d%65%28%22%61%22%29%3b%6c%69%6e%6b%5b%30%5d%2e%68%72%65%66%3d%22%68%74%74%70%3a%2f%2f%61%74%74%61%63%6b%65%72%2d%73%69%74%65%2e%63%6f%6d%2f%22%3b%7d%3c%2f%73%63%72%69%70%74%3e'
		);
		
		foreach($xss_array as $xss):
			$safe_string =  $this->security->xss_clean($xss);
			echo $safe_string . '<br/>';
		endforeach;
	}
	
	public function using_sanitize_filename() {

		$xss_array = array(
			'index.php?name=<script>window.onload = function() {var link=document.getElementsByTagName("a");link[0].href="http://not-real-xssattackexamples.com/";}</script>',
			'index.php?name=%3c%73%63%72%69%70%74%3e%77%69%6e%64%6f%77%2e%6f%6e%6c%6f%61%64%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%20%7b%76%61%72%20%6c%69%6e%6b%3d%64%6f%63%75%6d%65%6e%74%2e%67%65%74%45%6c%65%6d%65%6e%74%73%42%79%54%61%67%4e%61%6d%65%28%22%61%22%29%3b%6c%69%6e%6b%5b%30%5d%2e%68%72%65%66%3d%22%68%74%74%70%3a%2f%2f%61%74%74%61%63%6b%65%72%2d%73%69%74%65%2e%63%6f%6d%2f%22%3b%7d%3c%2f%73%63%72%69%70%74%3e'
		);
		
		foreach($xss_array as $xss):
			$safe_string =  $this->security->sanitize_filename($xss);
			echo $safe_string . '<br/>';
		endforeach;
	}
	
	
	public function using_encrypt() {
		$string 	= "abc123!xyz";	
		
		$e_string 	= $this->encrypt->encode($string);
		$decode		= $this->encrypt->decode($e_string);
		echo $e_string . '<br/>';
		echo $decode;
	}

	public function using_decrypt() {
		$e_string = "JfmwuSk1FIJn5PxhxAjT4sZP8XG6X490aIPRJiLvjYUt/tphwDiLHBNHgwRlIjBEcjRcbbVD0nHgD8QVM0dKHw==";
		echo $this->encrypt->decode($e_string);
	}
	
	public function using_uri_segment() {
		$segment = $this->uri->segment(3);
		echo $segment;
	}
	
	function using_base_url() {
		$this->load->helper('url');
		echo base_url();
	}
	
	function using_site_url() {
		$this->load->helper('url');
		echo site_url();
	}
	
	function using_current_url() {
		$this->load->helper('url');
		echo current_url();
	}

	function create_password_hash() {
		echo Password_Hash::create_hash('abc123!xyz');
	}

	function decrypt_using_password_hash() {
		$password 	= 'abc123!xyz';
		$hash 		= 'sha256:1000:Og2tSvUL9yTiyT26GCHUQIk/9Ygv+y78:c2FDJQZzi/dv+SPChFM5AXPbxIJiMBwI';

		echo Password_Hash::validate_password($password,$hash);
	}

	function non_salted_hash() {
		echo md5("leodiaz");
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */