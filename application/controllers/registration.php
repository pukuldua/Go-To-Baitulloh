<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {
	var $data_field;
	var $tmp_pass;
	
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
		$waiting = $this->input->post('waiting');
		
		$this->load->model('province_model');
		$province = $this->province_model->get_all_province();

		$province_options['0'] = '-- Pilih Propinsi --';
		foreach($province->result() as $row){
				$province_options[$row->ID_PROPINSI] = $row->NAMA_PROPINSI;
		}
		
		if ($waiting != '' & $waiting != NULL){
			$data['waiting'] = $waiting;
                        $data['jml_adult'] = $this->input->post('jml_adult');
			$data['with_bed'] = $this->input->post('with_bed');
			$data['no_bed'] = $this->input->post('no_bed');
			$data['infant'] = $this->input->post('infant');
                        $data['group'] = $this->input->post('group');
                        $data['program'] = $this->input->post('program');

                        $kamar = $this->input->post('kamar');
                        $jml_kamar = $this->input->post('jml_kamar');

                        for($i=0; $i<count($kamar); $i++){
                            $room_choice2[$i] = array('ID_ROOM_TYPE'=>$kamar[$i], 'JUMLAH'=>$jml_kamar[$i]);
                        }
                        $data['room_choice2'] = $room_choice2;
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
		}
		else{
			$this->load_data_form();
			
			if (empty($this->data_field))
				$this->front();
			else{
				$this->load->model('accounts_model');
				$this->load->model('log_model');
                                $this->load->model('packet_model');
				
				$this->accounts_model->insert_new_account($this->data_field);						
				$this->log_model->log(null, $this->data_field['KODE_REGISTRASI'], null, 'REGISTER new account, EMAIL = '.$this->data_field['EMAIL'].', KODE_REGISTRASI = '.$this->data_field['KODE_REGISTRASI']);

                                $waiting = 0;
				// if waiting list
				if ($this->input->post('waiting') == 1){
					$this->load->model('waiting_list_model');
                                        $waiting = 1;
					
					$id_acc = $this->accounts_model->get_account_byKode($this->data_field['KODE_REGISTRASI'])->row()->ID_ACCOUNT;
					$data_waiting = array('KODE_REGISTRASI'=>$this->data_field['KODE_REGISTRASI'], 'ID_ACCOUNT'=>$id_acc);
					
					$this->waiting_list_model->insert_waiting_list($data_waiting);
					$this->log_model->log($id_acc, $this->data_field['KODE_REGISTRASI'], null, 'INSERT data WAITING_LIST dengan KODE_REGISTRASI = '.$this->data_field['KODE_REGISTRASI']);

                                        // data packet
                                        $group = $this->input->post('group');
                                        $kelas_program = $this->input->post('program');
                                        $jml_adult = $this->input->post('jml_adult');
                                        $with_bed = $this->input->post('with_bed')=='' ? 0:$this->input->post('with_bed');
                                        $no_bed = $this->input->post('no_bed')=='' ? 0:$this->input->post('no_bed');
                                        $infant = $this->input->post('infant')=='' ? 0:$this->input->post('infant');

                                        $data = array(
                                            'ID_GROUP'=>$group, 'ID_ACCOUNT'=>$id_acc, 'KODE_REGISTRASI' =>$this->data_field['KODE_REGISTRASI'], 'ID_PROGRAM'=>$kelas_program,
                                            'JUMLAH_ADULT'=>$jml_adult, 'CHILD_WITH_BED'=>$with_bed, 'CHILD_NO_BED'=>$no_bed, 'INFANT'=>$infant,
                                            'TANGGAL_PESAN'=>date("Y-m-d h:i:s"), 'STATUS_PESANAN'=>2
                                        );

                                        // insert into packet
                                        $this->packet_model->insert_packet($data);
                                        $this->log_model->log($id_acc, $this->data_field['KODE_REGISTRASI'], null, 'INSERT data PACKET untuk akun dengan KODE_REGISTRASI = '.$this->data_field['KODE_REGISTRASI']);

                                        // insert into room packet
                                        $id_pack = $this->packet_model->get_packet_byAcc_waiting($id_acc, $this->data_field['KODE_REGISTRASI']);
                                        if ($id_pack->num_rows() > 0){
                                            $this->load->model('room_packet_model');
                                            $kamar = $this->input->post('kamar');
                                            $jml_kamar = $this->input->post('jml_kamar');

                                            for($i=0; $i<count($kamar); $i++){
                                                $this->room_packet_model->insert_room_packet(array('ID_ROOM_TYPE'=>$kamar[$i],
                                                    'ID_PACKET'=>$id_pack->row()->ID_PACKET, 'JUMLAH'=>$jml_kamar[$i]));
                                            }

                                            $this->log_model->log($id_acc, $this->data_field['KODE_REGISTRASI'], null, 'INSERT data ROOM_PACKET untuk packet dengan ID_PACKET = '.$id_pack->row()->ID_PACKET);
                                        }
				}
				
				$keycode = $this->secure($this->data_field['KODE_REGISTRASI']);
				$this->send_email($keycode, $waiting);
				//set session notifikasi
				//$this->session->set_userdata('notification','Data Pengujian Kadar Air Telah Dimasukkan !!!');
				redirect('notification/show/'.$this->data_field['KODE_REGISTRASI']);
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
		
		$kode_reg = substr(md5('koderegistrasi-'.$nama.'-'.$email.'-'.date("Y m d H:i:s")), 0, 15);
		$pwd = substr(md5('password-'.$nama.'-'.$email.'-'.date("Y m d")), 0, 5);
		$this->tmp_pass = $pwd;

		$this->data_field = array('KODE_REGISTRASI' => $kode_reg, 'ID_PROPINSI' => $province, 'NAMA_USER' => $nama, 
								'EMAIL' => $email, 'PASSWORD' =>md5($pwd), 'NO_ID_CARD' => $id_card, 'TELP' => $telp, 
								'MOBILE' => $mobile, 'KOTA' => $kota, 'ALAMAT' => $alamat, 'TANGGAL_REGISTRASI' =>date("Y-m-d h:i:s"), 'STATUS' => 0);
		
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
		$this->form_validation->set_rules('id_card', 'No ID Card', 'required|min_length[10]');
		$this->form_validation->set_rules('recaptcha_response_field', 'Captcha Code', 'callback_check_captcha['.$this->input->post('recaptcha_challenge_field').']');
		
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');
		$this->form_validation->set_message('required', '%s wajib diisi !');
		$this->form_validation->set_message('valid_email', '%s wajib berisi alamat email yang benar !');
		$this->form_validation->set_message('min_length', '%s minimum berisi 10 karakter !');
		
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
				$this->form_validation->set_message('check_captcha', "Kode salah, silahkan coba lagi");
				return FALSE;
        }
	}

    //cek pilihan sdh bener ap blm
    function check_dropdown($value){
		if($value==0){
			$this->form_validation->set_message('check_dropdown', 'Harap memilih salah satu %s !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function send_email($key, $waiting){
		$this->load->library('email');
		$this->load->library('parser');
		
		$config['protocol'] = 'mail';
		$config['mailtype'] = 'html';

		$this->email->initialize($config);
		
		$data['key'] = $key;
		$data['subject'] = 'Aktivasi Akun';
                $data['waiting'] = $waiting;
		$data['NAMA_USER'] = $this->data_field['NAMA_USER'];
		$data['PASSWORD'] = $this->tmp_pass;
		$data['KODE_REGISTRASI'] = $this->data_field['KODE_REGISTRASI'];
		
		//$content = $this->load->view('email_activation',$data);
		$htmlMessage =  $this->parser->parse('email_activation', $data, true);
		
		$this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
		$this->email->to($this->data_field['EMAIL']);

		$this->email->subject('Aktivasi Akun');
		$this->email->message($htmlMessage);

		$this->email->send();
                //echo $this->tmp_pass;

		// echo $this->email->print_debugger();
	}
}

/* End of file registration.php */
/* Location: ./application/controllers/registration.php */