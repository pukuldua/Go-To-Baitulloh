<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Useraccount extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('libkamilah');
	}

	function index()
	{
		$this->edit();
	}
	
	function edit()
	{
		//load validation library
		$this->load->library('form_validation'); 
		
		//cek login session
		$this->libkamilah->cek_session_login();
		
		//ambil info id account dari session
		$id_account = $this->session->userdata['id_account']; 
		
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
		
		$data['notifikasi'] = null;
		if($this->session->userdata('sukses') == 'true'){
			$data['notifikasi'] = '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">Data Profil Berhasil diubah.</td>
						<td class="green-right"><a class="close-green"><img src="'.base_url().'images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
				</table>
			</div>';
			$this->session->unset_userdata('sukses');
		}
		
		//load view akhir
		$data['content'] = $this->load->view('useraccount/form_editdata',$data,true);
		$this->load->view('front',$data);
		
	}//end changedata
	
	function do_edit()
	{	
		if ($this->cek_validasi() == FALSE){
			$this->edit();
		}else{
			$no_registrasi = $this->input->post('no_registrasi');
		
			// update table
			$data = array(
				'NAMA_USER' 	=> $this->input->post('nama'),
				'EMAIL' 		=> $this->input->post('email'),
				'TELP' 			=> $this->input->post('telepon'),
				'MOBILE' 		=> $this->input->post('handphone'),
				'ID_PROPINSI' 	=> $this->input->post('province'),
				'KOTA' 			=> $this->input->post('kota'),
				'ALAMAT' 		=> $this->input->post('alamat')
			);
			
			$this->load->model('accounts_model');
			$this->accounts_model->update_account($data,$no_registrasi);
			
			//buat session sukses
			$this->session->set_userdata('sukses','true');
			
			redirect('useraccount');
		}//end if else
	}//end updatedata
	
	function editpassword()
	{
		//load validation library
		$this->load->library('form_validation'); 
		
		//cek login session
		$this->libkamilah->cek_session_login();
		
		$data['notifikasi'] = null;
		if($this->session->userdata('sukses') == 'true'){
			$data['notifikasi'] = '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">Password Berhasil diubah.</td>
						<td class="green-right"><a class="close-green"><img src="'.base_url().'images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
				</table>
			</div>';
			$this->session->unset_userdata('sukses');
		}
		
		//load view akhir
		$data['content'] = $this->load->view('useraccount/form_editpassword',$data,true);
		$this->load->view('front',$data);
	}
	
	function do_editpassword()
	{
		//ambil info id account dari session
		$id_account = $this->session->userdata['id_account']; 
		
		if ($this->cek_validasi_password($id_account) == FALSE){
			$this->editpassword();
		}else{
			// update table
			$data = array(
				'PASSWORD' => md5($this->input->post('password_baru'))
			);
			
			$this->load->model('accounts_model');
			$this->accounts_model->update_with_id_account($data,$id_account);
			
			//buat session sukses
			$this->session->set_userdata('sukses','true');
			
			redirect('useraccount/editpassword');
		}//end if else
	}
	
	function cek_validasi()
	{
		$this->load->library('form_validation');
		//setting rules
		$config = array(
				array('field'=>'nama','label'=>'Nama Lengkap', 'rules'=>'required'),
				array('field'=>'email','label'=>'Email', 'rules'=>'valid_email'),
				array('field'=>'telepon','label'=>'Telepon', 'rules'=>'required|numeric'),
				array('field'=>'handphone','label'=>'Mobile', 'rules'=>'numeric'),
				array('field'=>'province','label'=>'Propinsi', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'kota','label'=>'Kota', 'rules'=>'required'),
				array('field'=>'alamat','label'=>'Alamat', 'rules'=>'required')
			);
		
		
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');
		$this->form_validation->set_message('valid_email', 'Penulisan kolom <strong>%s</strong> tidak benar!');
		$this->form_validation->set_message('numeric', '<strong>Kolom %s</strong> harus berupa angka !');

		return $this->form_validation->run();
	}//end cek_validasi
	
	function cek_validasi_password($id_account)
	{	
		$this->load->library('form_validation');
		//setting rules
		$config = array(
			array('field'=>'password_sekarang','label'=>'Password Sekarang', 'rules'=>'required|callback_cek_validitas['.$id_account.']'),
			array('field'=>'password_baru','label'=>'Password Baru', 'rules'=>'required'),
			array('field'=>'konfirmasi','label'=>'Konfirmasi', 'rules'=>'required|callback_cek_kesamaan['.$this->input->post('password_baru').']'),
		);
		
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');

		return $this->form_validation->run();
	}
	
	function cek_dropdown($value)
	{
		$this->load->library('form_validation');
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Pilih salah satu <strong>%s</strong> !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function cek_validitas($password_sekarang,$id_account)
	{
		$this->load->library('form_validation');
		$this->load->model('accounts_model');
		
		$data_account = $this->accounts_model->get_data_account($id_account);
		$password_db = null;
		foreach($data_account->result() as $account){
			$password_db = $account->PASSWORD;
		}//end foreach
		
		if(md5($password_sekarang) != $password_db){
			$this->form_validation->set_message('cek_validitas', '<strong>%s</strong> anda Tidak Benar !');
			return FALSE;
		}else{
			return TRUE;
		}		
	}//end
	
	function cek_kesamaan($konfirmasi,$password_baru)
	{	
		$this->load->library('form_validation');
		if($konfirmasi != $password_baru){
			$this->form_validation->set_message('cek_kesamaan', '<strong>%s</strong> Tidak sama dengan Password Baru !');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
}//end class

/* End of file useraccount.php */
/* Location: ./application/controllers/useraccount.php */