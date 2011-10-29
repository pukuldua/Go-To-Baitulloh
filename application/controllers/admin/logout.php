<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		
		$this->load->model('log_model');	
		
		$id_user 	= $this->session->userdata("id_user");
		$username 	= $this->session->userdata("username");
		$log = $username." LOGOUT keluar dari sistem";
		
		$this->log_model->log(null, null, $id_user, $log);
		$this->session->sess_destroy();//mengosongkan  nilai session ketika user melakukan logout
		
		redirect('admin/login');
	}
	
}//end class		
?>