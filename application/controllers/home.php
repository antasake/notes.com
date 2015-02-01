<?php
class Home extends CI_Controller{
	
	function index()
	{
		
		$this->load->view('include/header');
		$this->load->view('home');
		$this->load->view('include/menu');
		$this->load->view('include/footer');
	}
}
?>
