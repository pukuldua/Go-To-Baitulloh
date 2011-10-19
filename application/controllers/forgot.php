<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->form();
	}
	
	
	function send()
	{
		$this->load->model('accounts_model');
		
		$valid 		= false; // kondisi awal parameter login
		
		// load library validasi
		$this->load->library('form_validation');
		
		//cek validasi input
		$this->form_validation->set_rules('email', 'Email ', 'required|valid_email');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> tidak boleh kosong!');
		$this->form_validation->set_message('valid_email', 'penulisan <strong>%s</strong> tidak benar!');
		
		if($this->form_validation->run() == TRUE)
		{
			$email 	= $this->input->post('email');
			
			$data_user	= $this->accounts_model->cek_forgot($email); // menampilkan semua data di table accounts
			
			if ($data_user->result() != NULL)
			{
				//kondisi pengecekan apakah username dan password yang dimasukkan telah sesuai dengan benar atau tidak
				foreach ($data_user->result() as $row){	
					$data['nama_user'] = $row->NAMA_USER;
					$data['password_user'] = $row->PASSWORD;
					$data['email_user'] = $row->EMAIL;
					
					$valid = true;
				}//end foreach
			
			}
			
			//apabila login telah sesuai dengan email dan password maka user akan masuk halaman utama
			if($valid){ 
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				
				$this->email->initialize($config);
				
				$this->email->to($address);
				$this->email->from('your@example.com');
				$this->email->subject('Here is your info '.$name);
				$this->email->message('Hi '.$name.' Here is the info you requested.');
				$this->email->send();
			}
			//apabila login tidak sesuai dengan email dan password maka user akan masuk halaman login
			else{
				$data['cek_form'] = 1;
				$data['cek_error'] = "-error";
				$data['content'] = $this->load->view('form_forgot', $data, true);
				$this->load->view('front', $data);
			}
		
		} 
		else 
		{
		
			$this->form(1);
		
		} // end foreach		
	}
	
	
	function form($cek_form = NULL)
	{
		if($cek_form == NULL) 
		{
			$data['cek_error'] = NULL;
			
		}else{
			
			$data['cek_error'] = "-error";
		}
		
		$data['content'] = $this->load->view('form_forgot',$data, true);
		$this->load->view('front', $data);
	}
}