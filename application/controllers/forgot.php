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
		// kondisi awal parameter login
		$valid = false; 
		
		// load model
		$this->load->model('accounts_model');
		
		// load library validasi
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->library('email');
		$this->load->library('parser');
		
		//cek validasi input
		$this->form_validation->set_rules('email', 'Email ', 'required|valid_email');
		
		$this->form_validation->set_message('required', '<strong>%s</strong> tidak boleh kosong!');
		$this->form_validation->set_message('valid_email', 'penulisan <strong>%s</strong> tidak benar!');
		
		if($this->form_validation->run() == TRUE)
		{
			$email 	= $this->input->post('email');
			
			$data_user	= $this->accounts_model->cek_forgot($email); 
			
			if ($data_user->result() != NULL)
			{
				foreach ($data_user->result() as $row){	
					$data['nama_user'] = $row->NAMA_USER;
					$data['password_user'] = $row->PASSWORD;
					$data['email_user'] = $row->EMAIL;
					
					$valid = true;
				}
			
			} else {
				
				$data['nama_user'] = "-";
				$data['password_user'] = "-";
				$data['email_user'] = $email;
			}
				
			
			if($valid){ 
		
				if($this->session->userdata('forgot') == NULL)
				{

					// update password baru			
					$data_acak = "ABC789";
					$data['generate_pass'] = str_shuffle($data_acak);
					$md5_acak = md5($data['generate_pass']);
					$set_acak = array('PASSWORD' => $md5_acak);
					$this->accounts_model->update_password($set_acak, $data['email_user']);
					
					$this->session->set_userdata('forgot', $data['generate_pass']);
  
				} else {
					
					$data['generate_pass'] = $this->session->userdata('forgot');
				}
				
				
				$data['subject'] = 'Reset Password';
				
				// fungsi kirim email
				$config['protocol'] = 'mail';
				$config['mailtype'] = 'html';
		
				$this->email->initialize($config);
				
				$htmlMessage =  $this->parser->parse('email_reset', $data, true);
				
				$this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
				$this->email->to($data['email_user']);
				$this->email->subject('Reset Password');
				$this->email->message($htmlMessage);
		
				$this->email->send();
				
				// set session sukses, trus redirect ke halaman sukses
				$this->session->set_userdata('sukses','true');
				$email_ubah = str_replace("@", "_at_", $data['email_user']);
				redirect("forgot/success/".$email_ubah);

				
			//	$content = $this->load->view('email_reset',$data);
				
			}
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
	
	
	function reset($key)
	{
		$this->load->model('accounts_model');
		$ubah_key = str_replace("_at_", "@", $key);
		$pecah_key = explode("_", $ubah_key);
		
		$tgl_key = $pecah_key[0];
		$email_key = $pecah_key[1];
		
		$tgl_skrg = md5(date("Ymd"));
		
		$data_user = $this->accounts_model->cek_forgot($email_key);
		
		if($tgl_key == $tgl_skrg)
		{
			if ($data_user->result() != NULL)
			{
				foreach ($data_user->result() as $row){	
					$data['nama_user'] = $row->NAMA_USER;
					$data['password_user'] = $row->PASSWORD;
					$data['email_user'] = $row->EMAIL;
					
				//	$data['msg'] = "Reset Password berhasil, periksa Email Anda. terima kasih";
				//	$data['content'] = $this->load->view('form_reset', $data, true);
				//	$this->load->view('front', $data);
				
					$data_acak = "ABC789";
					$data['generate_pass'] = str_shuffle($data_acak);
					$set_acak = array('PASSWORD' => md5($data['generate_pass']));
					
					// cek session, jika forgot kosong maka email akan dikirim
					if($this->session->userdata('forgot') == NULL)
					{
						// kirim email disini
						
						// update password baru			
						$this->accounts_model->update_password($data['email_user']);
						
						// isi session
						$this->session->set_userdata('forgot2', 1);

					}
					
					// contoh template email
					$data['subject'] = "Layanan Reset Password - Umrah Kamilah -";
					$this->load->view('template_email2', $data);
				} 
			
			} else {
				
				$data['msg'] = "Maaf, data tidak sesuai dengan sistem kami. silahkan ulangi dengan mengklik <a href='".site_url()."/forgot'>link ini</a>";
				$data['content'] = $this->load->view('form_reset', $data, true);
				$this->load->view('front', $data);
			}
		
		} else {
			
			$data['msg'] = "Maaf, masa berlaku reset password telah berakhir. silahkan ulangi lagi dengan mengklik <a href='".site_url()."/forgot'>link ini</a>";
			$data['content'] = $this->load->view('form_reset', $data, true);
			$this->load->view('front', $data);
		}
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
	
	
	function success($email)
	{
		$email = str_replace("_at_", "@", $email);
		if($this->session->set_userdata('sukses') == 'true')
		{ 
			$data['msg'] = "Sistem berhasil mereset password <i><strong><a href='mailto:".$email."'> ".$email."</a></strong></i> . periksa inbox Email Anda";
			
			$this->session->unset_userdata('sukses');
				
			$data['content'] = $this->load->view('form_reset', $data, true);
			$this->load->view('front', $data);
		}else{
			redirect(site_url()."/login");
		}
	}
	
}