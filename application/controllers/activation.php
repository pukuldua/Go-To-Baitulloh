<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function activate($keycode){
		$this->load->model('accounts_model');
		$this->load->model('log_model');
		
		$kode_reg = $this->decode($keycode);
		$account = $this->accounts_model->get_account_byKode($kode_reg);
		
		if ($account->num_rows() < 1)
			show_404();
		else{			
			if ($account->row()->STATUS == 0){
				// update account status
				$this->accounts_model->update_account(array('STATUS'=>1), $kode_reg);
				
				// redirect to login
				$newdata = array(
					'id_account'		=> $account->row()->ID_ACCOUNT,
					'email' 			=> $account->row()->EMAIL,
					'nama'				=> $account->row()->NAMA_USER,
					'kode_registrasi' 	=> $account->row()->KODE_REGISTRASI
				);	
				
				$this->session->set_userdata($newdata);
				
				$log = "LOGIN kedalam sistem";
				$id_user = $this->session->userdata("id_account");
				$kode_reg = $this->session->userdata("kode_registrasi");
				
				$this->log_model->log($id_user, $kode_reg, NULL, $log);
				redirect('beranda');
			}
			else 
				show_404();
		}
	}

	function index($kode_reg)
	{
		show_404();
	}
	
	function decode($keycode){
		$textlen = strlen($keycode);
		$key = substr($keycode, $textlen-2,1);
		$split = substr($keycode, $textlen-1,1);
		
		if (is_numeric($key) && is_numeric($split)){
			if ($split > $key) $count = $split-$key; else $count = 1;
			
			$decrypted = "";
			for($i = 0; $i < $textlen; $i ++){
				$decrypted .= substr($keycode, $i, $split);
				$i += $split+$count-1;
			}
		
			return substr($decrypted, 0, 15);
		}else echo show_404();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */