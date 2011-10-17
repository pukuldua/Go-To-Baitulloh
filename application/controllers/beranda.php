<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->cek_session();
	}

	function index()
	{
		$this->form();
	}
	
	
	function form()
	{
		$data['content'] = $this->load->view('home', '', true);
		$this->load->view('front', $data);
	}
	
	
	function cek_session()
	{
		if($this->session->userdata('email') == NULL)
			redirect('login/form');
  	}
	
}