<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->front();
	}
	
	function front(){
		$data['content'] = $this->load->view('form',null,true);
		$this->load->view('front',$data);
	}
}

/* End of file registration.php */
/* Location: ./application/controllers/registration.php */