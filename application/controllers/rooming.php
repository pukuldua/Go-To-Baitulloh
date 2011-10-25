<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooming extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$data['content'] = $this->load->view('form_rooming',null,true);
		//$this->load->view('form_rooming',null,false);
		$this->load->view('front',$data);
	}

	function book_room()
	{
		$this->input->post('accounts_model');
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