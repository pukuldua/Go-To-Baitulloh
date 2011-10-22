<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biodata extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
	}
	function index()
	{
		$this->front();
	}
	
	function front()	
	{
		$this->load->library('form_validation');
		$data['content'] = $this->load->view('biodata', '', true);
		$this->load->view('front', $data);
	}
	
	function list_jamaah()
	{
		$data['content'] = $this->load->view('biodata_list', '', true);
		$this->load->view('front', $data);
	}
	
	
	function input()
	{
		$this->load->library('form_validation');
		
		$this->load->model('province_model');
		$this->load->model('clothes_size_model');
		$this->load->model('relation_model');
		
		$province = $this->province_model->get_all_province();
		$relation = $this->relation_model->get_all_relation();
		$chlothes = $this->clothes_size_model->get_all_clothes();

		$province_options['0'] = '-- Pilih Propinsi --';
		foreach($province->result() as $row){
				$province_options[$row->ID_PROPINSI] = $row->NAMA_PROPINSI;
		}
		
		$relasi_options['0'] = '-- Pilih Relasi --';
		foreach($relation->result() as $row){
				$relasi_options[$row->ID_RELATION] = $row->JENIS_RELASI;
		}
		
		$chlothes_options['0'] = '-- Pilih Ukuran Baju --';
		foreach($chlothes->result() as $row){
				$chlothes_options[$row->ID_SIZE] = $row->SIZE;
		}
		
		$data['province_options'] = $province_options;
		$data['relasi_options'] = $relasi_options;
		$data['chlothes_options'] = $chlothes_options;
		$data['content'] = $this->load->view('biodata_input', $data, true);
		$this->load->view('front', $data);
	}
	
	function do_daftar(){
		
		$this->load->library('form_validation');
		$this->load->model('jamaah_candidate_model');
		
		if ($this->cek_validasi() == FALSE){
			$this->input();
		}
		else{
			// tanggal lahir
			$tgl = $this->input->post('tgl_lahir');
			$bln = $this->input->post('bln_lahir');
			$thn = $this->input->post('thn_lahir');
			$dates = $thn."-".$bln."-".$tgl;
			
			// pelayanan khusus
			$kursi = $this->input->post('kursi_roda');
			$asisten = $this->input->post('asisten');
			if(empty($kursi)) $kursi = 0;
			if(empty($asisten)) $asisten = 0;
			$pelayanan_khusus = $kursi.";".$asisten;
			
			// perihal pribadi
			$darah_tinggi = $this->input->post('darah_tinggi');
			$takut_ketinggian = $this->input->post('takut_ketinggian');
			$smooking_room = $this->input->post('smooking_room');
			$jantung = $this->input->post('jantung');
			$asma = $this->input->post('asma');
			$mendengkur = $this->input->post('mendengkur');
			if(empty($darah_tinggi)) $darah_tinggi = 0;
			if(empty($takut_ketinggian)) $takut_ketinggian = 0;
			if(empty($smooking_room)) $smooking_room = 0;
			if(empty($jantung)) $jantung = 0;
			if(empty($asma)) $asma = 0;
			if(empty($mendengkur)) $mendengkur = 0;
			$perihal_pribadi = $darah_tinggi.";".$takut_ketinggian.";".$smooking_room.";".$jantung.";".$asma.";".$mendengkur;
			
			// Upload Foto
			$config['upload_path'] = './images/upload/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '5000';
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('foto'))
			{
				$error = $this->upload->display_errors();
				echo "<script>alert('".$this->input->post('foto')."');window.location='javascript:history.back()';</script>";
				exit;
			
			}else{
				
				$data_file = $this->upload->data();
			}
			
			
			// insert ke database
			$data = array(
				'ID_RELATION' => $this->input->post('relasi'),
				'ID_SIZE' => $this->input->post('baju'),
				'ID_ACCOUNT' => $this->session->userdata('id_account'),
				'KODE_REGISTRASI' => $this->session->userdata('kode_registrasi'),
				'ID_PROPINSI' => $this->input->post('province'),
				'NAMA_LENGKAP' => $this->input->post('nama_lengkap'),
				'NAMA_PANGGILAN' => $this->input->post('panggilan'),
				'GENDER' => $this->input->post('gender'),
				'WARGA_NEGARA' => $this->input->post('warga_negara'),
				'TEMPAT_LAHIR' => $this->input->post('tempat_lahir'),
				'TANGGAL_LAHIR' => $dates,
				'AYAH_KANDUNG' => $this->input->post('ayah_kandung'),
				'NO_PASPOR' => NULL,
				'TANGGAL_DIKELUARKAN' => NULL,
				'TANGGAL_HABIS' => NULL,
				'KANTOR_PEMBUATAN' => NULL,
				'SCAN_PASPOR' => NULL,
				'KOTA' => $this->input->post('kota'),
				'ALAMAT' => $this->input->post('alamat'),
				'TELP' => $this->input->post('telp'),
				'MOBILE' => $this->input->post('hp'),
				'LAYANAN_KHUSUS' => $pelayanan_khusus,
				'PERIHAL_PRIBADI' => $perihal_pribadi,
				'FOTO' => $data_file['file_name'],
				'JASA_TAMBAHAN' => $this->input->post('jasa_maningtis'),
				'REQUESTED_NAMA' => $this->input->post('jasa_paspor_nama'),
				'MAHRAM' => $this->input->post('mahram'),
				'TANGGAL_ENTRI' => date("Y-m-d H:i:s"),
				'TANGGAL_UPDATE' => date("Y-m-d H:i:s"),
				'STATUS_KANDIDAT' => 0);
			
			$insert = $this->jamaah_candidate_model->insert_jamaah($data);
			
			redirect('/biodata/list/');
		}
	}
	
	
	function cek_validasi() {
		$this->load->library('form_validation');
		//setting rules
		$config = array(
				array('field'=>'nama_lengkap','label'=>'Nama Lengkap', 'rules'=>'required'),
				array('field'=>'gender','label'=>'Jenis Kelamin', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'ayah_kandung','label'=>'Ayah Kandung', 'rules'=>'required'),
				array('field'=>'warga_negara','label'=>'Warga Negara', 'rules'=>'required'),
				array('field'=>'tempat_lahir','label'=>'Tempat Lahir', 'rules'=>'required'),
				array('field'=>'tgl_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'bln_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'thn_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'province','label'=>'Provisi', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'kota','label'=>'Kota', 'rules'=>'required'),
				array('field'=>'alamat','label'=>'Alamat', 'rules'=>'required'),
				array('field'=>'email','label'=>'Email', 'rules'=>'valid_email'),
				array('field'=>'telp','label'=>'Telephone', 'rules'=>'required|numeric'),
				array('field'=>'hp','label'=>'Handphone', 'rules'=>'numeric'),
				array('field'=>'relasi','label'=>'Relation', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'baju','label'=>'Baju', 'rules'=>'callback_cek_dropdown'),
			//	array('field'=>'foto','label'=>'Foto', 'rules'=>'required'),
			);
		
		
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '<strong>%s</strong> tidak boleh kosong !');
		$this->form_validation->set_message('valid_email', 'Penulisan <strong>%s</strong> tidak benar!');
		$this->form_validation->set_message('numeric', 'Gunakan Angka !');
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }

    //cek pilihan sdh bener ap blm
    function cek_dropdown($value){
		$this->load->library('form_validation');
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Pilih salah satu <strong>%s</strong> !');
				return FALSE;
		}else
				return TRUE;
    }

}