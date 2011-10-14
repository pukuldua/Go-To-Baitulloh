<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct()
		$this->load->model('accounts_model');
		$this->load->model('log_model');
	}

	function index()
	{
		$this->cek_login();
	}
	
	function cek_login()
	{
		$this->session->sess_destroy(); // menghapus semua session yang ada dalam aplikasi		
		$valid 		= false; // kondisi awal parameter login
		$data_user	= $this->accounts_model->get_all_login();
			
		$email 	= $this->input->post('email');
		$password 	= $this->input->post('password');
		
		//kondisi pengecekan apakah username dan password yang dimasukkan telah sesuai dengan benar atau tidak
		foreach ($data_user->result() as $row){	
			if($email == $row->EMAIL && md5($password) == $row->PASSWORD){
				$valid = true;
				
				//setting session terhadap data user
				$newdata = array(
					'id_accaount'	=> $row->ID_ACCOUNT,
					'email' 		=> $row->EMAIL,
					'nama'			=> $row->NAMA_USER_INTERNAL
				);	
				
				$this->session->set_userdata($newdata);
				break;
			}			
		}//end foreach
		
		//apabila login telah sesuai dengan email dan password maka user akan masuk halaman utama
		if($valid){ 
			$this->log_model->log('<strong>'.$this->session->userdata('nama').'</strong> LOGIN kedalam sistem',);
			redirect('beranda');
		}
		//apabila login tidak sesuai dengan email dan password maka user akan masuk halaman login
		else{ 
			redirect('welcome');
		}
	}//end cek_login	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */