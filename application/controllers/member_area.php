<?php
class Member_area extends CI_Controller{
	
	function index()
	{
		$this->load->view('include/header');
		$this->load->view('view_member');
		$this->load->view('include/menu_footer');
		$this->load->view('include/footer');
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('home');
	}
}
?>