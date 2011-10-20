<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {
	var $data_field;
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
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
	
	//insert data inputan ke database
    function do_register() {		
		if ($this->check_validasi() == FALSE){
				// //$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
				$this->front();
				//echo 'error ikki';
		}
		else{
			$this->load_data_form();
			
			if (empty($this->data_field))
				//$this->front();
				echo 'kosong neng kne lho';
			else{
				$this->load->model('accounts_model');
				$this->load->model('log_model');
				
				$this->accounts_model->insert_new_account($this->data_field);						
				$this->log_model->log(null, $this->data_field['KODE_REGISTRASI'], null, 'REGISTER new account, EMAIL = '.$this->data_field['EMAIL'].', KODE_REGISTRASI = '.$this->data_field['KODE_REGISTRASI']);
				
				$keycode = $this->secure($this->data_field['KODE_REGISTRASI']);
				$this->send_email($keycode);
				//$this->show_notification();
				//set session notifikasi
				//$this->session->set_userdata('notification','Data Pengujian Kadar Air Telah Dimasukkan !!!');
				//redirect('notification/'.$this->data_field['KODE_REGISTRASI']);
			}
		}
    }
	
	function secure($data){
		$textlen = strlen($data);
		$key = rand(2,9);
		$split = round($textlen/$key);
		
		if ($split > $key) $count = $split-$key; else $count = 1;
		$newstr = "";
		
		for($i = 0; $i < strlen($data); $i ++){
			$part = substr($data, $i, $split);
			$newstr .= $part.substr(md5(rand(1*$key, $textlen*$key)), 1, $count);
			$i += $split-1;
		}
		return $newstr.$key.$split;
	}
	
	function load_data_form() {
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$telp = $this->input->post('telp');
		$mobile = $this->input->post('mobile');
		$province = $this->input->post('province');
		$kota = $this->input->post('kota');
		$alamat = $this->input->post('alamat');
		$id_card = $this->input->post('id_card');
		$kode = $this->input->post('recaptcha_challenge_field');
		
		$kode_reg = substr(md5('koderegistrasi-'.$nama.'-'.$email.'-'.date("Y j d H:i:s")), 0, 15);
		$pwd = substr(md5('password-'.$nama.'-'.$email.'-'.date("Y j d H:i:s")), 0, 15);

		$this->data_field = array('KODE_REGISTRASI' => $kode_reg, 'ID_PROPINSI' => $province, 'NAMA_USER' => $nama, 
								'EMAIL' => $email, 'PASSWORD' =>$pwd, 'NO_ID_CARD' => $id_card, 'TELP' => $telp, 
								'MOBILE' => $mobile, 'KOTA' => $kota, 'ALAMAT' => $alamat, 'TANGGAL_REGISTRASI' =>date("Y-m-d"), 'STATUS' => 0);
		
		//return $data_field;
    }
	
	function check_validasi() {
		//setting rules
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('telp', 'Telp', '');
		$this->form_validation->set_rules('mobile', 'Mobile', '');
		$this->form_validation->set_rules('province', 'Propinsi', 'callback_check_dropdown');
		$this->form_validation->set_rules('kota', 'Kota', '');
		$this->form_validation->set_rules('alamat', 'Alamat', '');
		$this->form_validation->set_rules('id_card', 'No ID Card', 'required');
		$this->form_validation->set_rules('recaptcha_response_field', 'Captcha Code', 'callback_check_captcha['.$this->input->post('recaptcha_challenge_field').']');
		
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');
		return $this->form_validation->run();
    }
	
	function check_captcha($response, $challenge){
		require_once('recaptchalib.php');
		
		$privatekey = '6LcqPskSAAAAAKxPuiPKr6XH4qnIUWQfAG9-R9qq';
		$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $challenge, $response);
		
		if ($resp->is_valid) {
                return TRUE;
        } else {
                # set the error code so that we can display it
				$this->form_validation->set_message('check_captcha', $resp->error);
				return FALSE;
        }
	}

    //cek pilihan sdh bener ap blm
    function check_dropdown($value){
		if($value==0){
			$this->form_validation->set_message('check_dropdown', 'Please choose one %s from the list !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function send_email($key){
		// $this->load->library('email');
		// $config['smtp_host'] = 'smtp.gmail.com';
		// $config['smtp_port'] = 587;
		// $config['protocol'] = 'smtp';
		// $config['mailtype'] = 'html';

		// $this->email->initialize($config);
		
		$data['key'] = $key;
		$data['subject'] = 'Account Activation';
		$data['NAMA_USER'] = $this->data_field['NAMA_USER'];
		$data['PASSWORD'] = $this->data_field['PASSWORD'];
		$data['KODE_REGISTRASI'] = $this->data_field['KODE_REGISTRASI'];
		$this->load->view('email_activation',$data);
		//$this->load->view('front',$data);
		
		// $this->email->from('wahyu.andy@smarti.web.id', 'Your Name');
		// $this->email->to('wanprabu@gmail.com');

		// $this->email->subject('Email Test');
		// $this->email->message('Testing the email class.');

		// $this->email->send();

		// echo $this->email->print_debugger();
	}
}

/* End of file registration.php */
/* Location: ./application/controllers/registration.php */