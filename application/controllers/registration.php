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
		$this->load->model('province_model');
		$province = $this->province_model->get_all_province();

		$province_options['0'] = '-- Pilih Propinsi --';
		foreach($province->result() as $row){
				$province_options[$row->ID_PROPINSI] = $row->NAMA_PROPINSI;
		}
			
		$data['province_options'] = $province_options;
		$data['content'] = $this->load->view('form_registration',$data,true);
		$this->load->view('front',$data);
	}
}

/* End of file registration.php */
/* Location: ./application/controllers/registration.php */