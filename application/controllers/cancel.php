<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cancel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('email') == NULL)
			redirect(site_url()."/login");
		
	}
	function index()
	{
		$this->front();
	}
	
	function front()	
	{
		$this->load->library('form_validation');
		$this->load->model('canceled_candidate_model');
		
		// LOAD SESSION
		$id_account = $this->session->userdata('id_account');
		$kode_reg = $this->session->userdata('kode_registrasi');
		
		// LOAD DATABASE
		$canceled_jamaah = $this->canceled_candidate_model->get_data_canceled($id_account, $kode_reg);
		
		if($canceled_jamaah->result() == NULL)
		{
			$data['cek_valid'] = TRUE;
		}else{
			$data['cek_valid'] = FALSE;
		}			
		
		$data['content'] = $this->load->view('cancel_page', $data, TRUE);
		$this->load->view('front', $data);
	}
	
	function do_send()
	{
		// LOAD MODEL DAN LIBRARY
		$this->load->library('form_validation');
		$this->load->model('canceled_candidate_model');
		$this->load->model('jamaah_candidate_model');
		
		// LOAD SESSION
		$id_account = $this->session->userdata('id_account');
		$kode_reg = $this->session->userdata('kode_registrasi');
		
		// LOAD DATABASE
		$data_jamaah = $this->jamaah_candidate_model->get_jamaah_notBooked_room($id_account, $kode_reg);
		
		if($data_jamaah->result() != NULL)
		{
			// INSERT DATABASE
			foreach($data_jamaah->result() as $row)
			{
				$keterangan_cancel = "Testing";
			
				$data = array(
						'ID_CANDIDATE' => $row->ID_CANDIDATE,
						'ID_ACCOUNT' => $this->session->userdata('id_account'),
						'KODE_REGISTRASI' => $this->session->userdata('kode_registrasi'),
						'TANGGAL_PEMBATALAN' => date("Y-m-d H:i:s"),
						'KETERANGAN' => $keterangan_cancel,
						); 
				
				$this->canceled_candidate_model->insert_canceled($data);
			}
			
			// KIRIM EMAIL PEMBERITAHUAN
			//
			
			redirect(site_url()."/cancel");
		
		} else { 
			
			redirect(site_url()."/cancel");
		}
	} // end function
	
}

?>