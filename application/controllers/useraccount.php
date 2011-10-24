<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Useraccount extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('libkamilah');
	}

	function index()
	{
		$this->changedata();
	}
	
	function changedata()
	{
		$this->libkamilah->cek_session_login(); //cek login session
		$id_account = $this->session->userdata['id_account']; //ambil info id account dari session
		
		//ambil data user yang bersangkutan
		$this->load->model('accounts_model');
		$data_account = $this->accounts_model->get_data_account($id_account);
		
		//Fetching data user
		foreach($data_account->result() as $account){
			$data['no_registrasi']	= $account->KODE_REGISTRASI;
			$data['nama']			= $account->NAMA_USER;
			$data['email']			= $account->EMAIL;
			$data['telepon']		= $account->TELP;
			$data['handphone']		= $account->MOBILE;
			$data['propinsi']		= $account->ID_PROPINSI;
			$data['kota']			= $account->KOTA;
			$data['alamat']			= $account->ALAMAT;
		}//end foreach
		
		//Prepare Data Propinsi
		$this->load->model('province_model');
		$province = $this->province_model->get_all_province();
		$province_options['0'] = '-- Pilih Propinsi --';
		foreach($province->result() as $row){
				$province_options[$row->ID_PROPINSI] = $row->NAMA_PROPINSI;
		}	
		$data['province_options'] = $province_options;


		//load view akhir
		$data['content'] = $this->load->view('useraccount/form_changedata',$data,true);
		$this->load->view('front',$data);
		
	}//end changedata
	
	function updatedata()
	{
		
	}//end updatedata
	
}

/* End of file useraccount.php */
/* Location: ./application/controllers/useraccount.php */