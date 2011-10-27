<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		
		$this->load->model('log_model');	

		$log = "LOGOUT keluar dari sistem";
		$id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");
		
		$this->log_model->log($id_user, $kode_reg, NULL, $log); 
		$this->session->sess_destroy();//mengosongkan  nilai session ketika user melakukan logout
		
		redirect('login');
	}
	
}		
?>