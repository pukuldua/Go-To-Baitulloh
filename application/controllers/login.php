<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('accounts_model');
		$this->load->model('log_model');
		$this->cek_session();
	}

	function index()
	{
		$this->form();
	}
	
	function cek_login()
	{
		$this->session->sess_destroy(); // menghapus semua session yang ada dalam aplikasi		
		$valid 		= false; // kondisi awal parameter login
		$data_user	= $this->accounts_model->get_all_login(); // menampilkan semua data di table accounts
		
		// load library validasi
		$this->load->library('form_validation');
		
		//cek validasi input
		$this->form_validation->set_rules('email', 'Email ', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password ', 'required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> tidak boleh kosong!');
		$this->form_validation->set_message('valid_email', 'penulisan <strong>%s</strong> tidak benar!');
		
		if($this->form_validation->run() == TRUE)
		{
			$email 	= $this->input->post('email');
			$password 	= $this->input->post('password');
		
			//kondisi pengecekan apakah username dan password yang dimasukkan telah sesuai dengan benar atau tidak
			foreach ($data_user->result() as $row){	
				if($email == $row->EMAIL && md5($password) == $row->PASSWORD){
					$valid = true;
					
					//setting session terhadap data user
					$newdata = array(
						'id_account'		=> $row->ID_ACCOUNT,
						'email' 			=> $row->EMAIL,
						'nama'				=> $row->NAMA_USER,
						'kode_registrasi' 	=> $row->KODE_REGISTRASI
					);	
					
					$this->session->set_userdata($newdata);
					break;
				}			
			}//end foreach
		
			//apabila login telah sesuai dengan email dan password maka user akan masuk halaman utama
			if($valid){ 
				$log = "LOGIN kedalam sistem";
				$id_user = $this->session->userdata("id_account");
				$kode_reg = $this->session->userdata("kode_registrasi");
				
				$this->log_model->log($id_user, $kode_reg, NULL, $log);
				redirect('beranda');
			}
			//apabila login tidak sesuai dengan email dan password maka user akan masuk halaman login
			else{
				$data['cek_form'] = 1;
				$data['cek_error'] = "-error";
				$data['content'] = $this->load->view('form_login', $data, true);
				$this->load->view('front', $data);
			}
		
		} 
		else 
		{
		
			$this->form(1);
		
		} // end foreach		
		
	}//end cek_login	
	
	
	
	function form($cek_form = NULL)
	{
		if($cek_form == NULL) 
		{
			$data['cek_error'] = NULL;
			
		}else{
			
			$data['cek_error'] = "-error";
		}
		
		$data['content'] = $this->load->view('form_login',$data, true);
		$this->load->view('front', $data);
	}
	
	
	function cek_session()
	{
		if($this->session->userdata('email') != NULL)
			redirect('beranda');
  	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */