<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){}

	function show($kode_reg)
	{
		$this->load->model('accounts_model');
		$this->load->model('province_model');
		$account = $this->accounts_model->get_notification_info($kode_reg);
		
		if ($account->num_rows() < 1)
			show_404();
		else{			
				$data['account'] = $account->row_array();
				$data['content'] = $this->load->view('notification',$data,true);
				$this->load->view('front',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */