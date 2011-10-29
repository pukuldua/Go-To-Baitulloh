<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('libkamilah');
	}

	function index()
	{
		$this->form();
	}
	
	function form($data=null)
	{	
		$this->load->view('admin/form_login',$data);
	}
	
	function cek_login()
	{
		$this->load->model('internal_users_model');
		$this->load->model('log_model');
		
		$this->session->sess_destroy(); // menghapus semua session yang ada dalam aplikasi		
		$valid 		= false; // kondisi awal parameter login
		$data_user	= $this->internal_users_model->get_all_login(); // menampilkan semua data di table accounts
		
		// load library validasi
		$this->load->library('form_validation');
		
		//cek validasi input
		$this->form_validation->set_rules('username', 'Usename ', 'required');
		$this->form_validation->set_rules('password', 'Password ', 'required');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> tidak boleh kosong!');
		
		if($this->form_validation->run() == TRUE)
		{
			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');
		
			//kondisi pengecekan apakah username dan password yang dimasukkan telah sesuai dengan benar atau tidak
			foreach ($data_user->result() as $row){	
				if($username == $row->NAMA_USER_INTERNAL && md5($password) == $row->PASSWORD){
					$valid = true;
					
					//setting session terhadap data user
					$newdata = array(
						'id_user'	=> $row->ID_USER,
						'username' 	=> $row->NAMA_USER_INTERNAL,
					);	
					
					$this->session->set_userdata($newdata);
					break;
				}			
			}//end foreach
		
			//apabila login telah sesuai dengan username dan password maka user akan masuk halaman utama
			if($valid){ 
				$id_user = $this->session->userdata("id_user");
				$username = $this->session->userdata("username");
				$log = $username." LOGIN kedalam BACKEND sistem";
				
				$this->log_model->log(null, null, $id_user, $log);
				redirect('admin/beranda');
			}
			//apabila login tidak sesuai dengan email dan password maka user akan masuk halaman login
			else{
				$data['cek_form'] = 1;
				$this->form($data);
			}
		
		} 
		else 
		{
			$data['cek_form'] = 1;
				$this->form($data);
		} // end foreach		
	}
}//end class

/* End of file admin/login.php */
/* Location: ./application/controllers/admin/login.php */