<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		show_404();
	}

	function show($kode_reg)
	{
		$this->load->model('accounts_model');
		$this->load->model('province_model');
                $this->load->model('waiting_list_model');
                
		$account = $this->accounts_model->get_notification_info($kode_reg);
		if ($account->num_rows() < 1)
			show_404();
		else{
                    $waiting = $this->waiting_list_model->get_waiting_byKode($kode_reg);
                    
				$data['account'] = $account->row_array();
                                if ($waiting->num_rows() > 0)
                                        $data['waiting'] = TRUE;
				$data['content'] = $this->load->view('notification',$data,true);
				$this->load->view('front',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */