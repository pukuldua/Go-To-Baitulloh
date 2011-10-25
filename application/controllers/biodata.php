<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Biodata extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('email') == NULL)
			redirect(site_url()."/login");
		
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
	
	
	// HALAMAN LIST CALON JAMAAH
	
	function list_jamaah(){
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$total_data 	= $this->jamaah_candidate_model->get_total_data();
		$total_data		= ''.$total_data ;
		$this->lihat_data_calon_jamaah($total_data);
	}
	
	function lihat_data_calon_jamaah($total_data){
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$colModel['no'] = array('No',40,TRUE,'center',0);
		$colModel['edit'] = array('Edit',40,FALSE,'center',0);
		$colModel['KODE_REGISTRASI'] = array('Kode Reg.',80,TRUE,'center',0);
		$colModel['NAMA_LENGKAP'] = array('Nama Lengkap',200,TRUE,'center',1);
		$colModel['NAMA_PANGGILAN'] = array('Nama Panggilan',150,TRUE,'center',1);
		$colModel['AYAH_KANDUNG'] = array('Ayah Kandung',150,TRUE,'center',1);
		$colModel['UKURAN_BAJU'] = array('Ukuran Baju',80,FALSE,'center',0);
		$colModel['GENDER'] = array('Jenis Kelamin',80,FALSE,'center',0);
		$colModel['MAHRAM'] = array('Hubungan Mahram',100,TRUE,'center',0);
		$colModel['MOBILE'] = array('Handphone',100,TRUE,'center',1);
		
		$gridParams = array(
		'width' => 'auto',
		'height' => 300,
		'rp' => 10,
		'rpOptions' => '[5,10,15,20,25,30,'.$total_data.']',
		'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} hasil.',
		'blockOpacity' => 0.5,
		'title' => 'Biodata Calon Jamaah',
		'showTableToggleBtn' => false
		);
		
		$buttons[] = array('separator');
		$buttons[] = array('Tambah','add','spt_js');
		$buttons[] = array('Hapus','delete','spt_js');
		$buttons[] = array('separator');
		
		$grid_js = build_grid_js('flex1',site_url("/biodata/grid_calon_jamaah/"),$colModel,'no','asc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			if (com=='Tambah'){
				location.href='".site_url()."/biodata/input'; 
			}
			if (com=='Hapus'){
			   if($('.trSelected',grid).length>0){
				   if(confirm('Anda yakin ingin menghapus ' + $('.trSelected',grid).length + ' buah data?')){
						var items = $('.trSelected',grid);
						var itemlist ='';
						for(i=0;i<items.length;i++){
							itemlist+= items[i].id.substr(3)+',';
						}
						$.ajax({
						   type: 'POST',
						   url: '".site_url('/biodata/hapus_data_calon_jamaah')."',
						   data: 'items='+itemlist,
						   success: function(data){
							$('#flex1').flexReload();
							alert(data);
						   }
						});
					}
				} else {
					return false;
				} 
			}
		} 
		</script>
		";

                
		$data['content'] = $this->load->view('biodata_list',$data,true);
		$this->load->view('front',$data);		
	}
	
	
	function grid_calon_jamaah() {
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$valid_fields = array('UKURAN_BAJU','KODE_REGISTRASI','NAMA_LENGKAP','NAMA_PANGGILAN','GENDER','AYAH_KANDUNG','MOBILE','MAHRAM');
		$this->flexigrid->validate_post('ID_ACCOUNT','desc',$valid_fields);
		
		$records = $this->jamaah_candidate_model->get_grid_all_jamaah($this->session->userdata('kode_registrasi'), $this->session->userdata('id_account'));
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
                
		foreach ($records['records']->result() as $row)
		{
			if($row->GENDER == 1) $gender = "Laki-Laki";
			elseif($row->GENDER == 2) $gender = "Perempuan";
			
			if($row->MAHRAM == 0) $mahram = "Ada";
			elseif($row->MAHRAM == 1) $mahram = "Tidak Ada";
			
			$record_items[] = array(
			
				$row->ID_CANDIDATE,
				$no = $no+1,
				'<a href=\''.site_url().'/biodata/edit/'.$row->ID_CANDIDATE.'/'.$row->ID_ACCOUNT.'/\'><img border=\'0\' src=\''.base_url().'images/flexigrid/book.png\'></a> ',
				$row->KODE_REGISTRASI,	
				$row->NAMA_LENGKAP,
				$row->NAMA_PANGGILAN,
				$row->AYAH_KANDUNG,
				$row->UKURAN_BAJU,
				$gender,
				$mahram,
				$row->MOBILE
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}
	
	
	function hapus_data_calon_jamaah()
	{
		$this->load->model('jamaah_candidate_model');
		
		$pecah_id = split(',' , $this->input->post('items'));
		
		foreach($pecah_id as $index => $id_candidate)
			if (is_numeric($id_candidate) && $id_candidate > 1) 
				$this->jamaah_candidate_model->hapus_data_calon_jamaah($id_candidate);
						
			
		$error = "Data Calon Jamaah ( ID : ".$this->input->post('items').") berhasil dihapus";

		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}
	
	
	
	// HALAMAN TAMBAH CALON JAMAAH
	
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
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['max_size']	= '5000';
			$config['encrypt_name']	= TRUE;
			
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
			
			redirect('/biodata/list_jamaah/');
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
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');
		$this->form_validation->set_message('valid_email', 'Penulisan kolom <strong>%s</strong> tidak benar!');
		$this->form_validation->set_message('numeric', '<strong>Kolom %s</strong> harus berupa angka !');
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
	
	
	
	// HALAMAN EDIT CALON JAMAAH
	
	function edit($id_candidate = NULL, $id_account = NULL)
	{
		
		$this->load->library('form_validation');
		$this->load->model('jamaah_candidate_model');
		
		$data_jamaah = $this->jamaah_candidate_model->get_jamaah_berdasarkan_id_accaount_candidate($id_candidate, $id_account);
			
		if($data_jamaah->result() != NULL)
		{
			foreach($data_jamaah->result() as $row)
			{
				$data['e_id_candidate'] = $row->ID_CANDIDATE;
				$data['e_id_account'] = $row->ID_ACCOUNT;
				$data['e_nama_lengkap'] = $row->NAMA_LENGKAP;
				$data['e_nama_panggilan'] = $row->NAMA_PANGGILAN;
				$data['e_gender'] = $row->GENDER;
				$data['e_ayah_kandung'] = $row->AYAH_KANDUNG;
				$data['e_warga_negara'] = $row->WARGA_NEGARA;
				$data['e_tempat_lahir'] = $row->TEMPAT_LAHIR;
				$data['e_tgl_lahir'] = $row->TANGGAL_LAHIR;
				$data['e_id_propinsi'] = $row->ID_PROPINSI;
				$data['e_kota'] = $row->KOTA;
				$data['e_alamat'] = $row->ALAMAT;
				$data['e_mahram'] = $row->MAHRAM;
				$data['e_telp'] = $row->TELP;
				$data['e_hp'] = $row->MOBILE;
				$data['e_id_relation'] = $row->ID_RELATION;
				$data['e_id_size'] = $row->ID_SIZE;
				$data['e_layanan_khusus'] = $row->LAYANAN_KHUSUS;
				$data['e_perihal_pribadi'] = $row->PERIHAL_PRIBADI;
				$data['e_pas_foto'] = $row->FOTO;
				$data['e_jasa_tambahan'] = $row->JASA_TAMBAHAN;
				$data['e_request_nama'] = $row->REQUESTED_NAMA;
				
				// PECAH TANGGAL LAHIR
				$pecah_tgl = explode("-", $data['e_tgl_lahir']);
				$data['e_thn_lahir'] = $pecah_tgl[0];
				$data['e_bln_lahir'] = $pecah_tgl[1];
				$data['e_tgl_lahir'] = $pecah_tgl[2];
				
				// PECAH PELAYANAN KHUSUS
				$pecah_khusus = explode(";", $data['e_layanan_khusus']);
				$data['e_khusus_kursi'] = $pecah_khusus[0];
				$data['e_khusus_asisten'] = $pecah_khusus[1];
				
				// PECAH PERIHAL PRIBADI
				$pecah_pribadi = explode(";", $data['e_perihal_pribadi']);
				$data['e_perihal_darah'] = $pecah_pribadi[0];
				$data['e_perihal_tinggi'] = $pecah_pribadi[1];
				$data['e_perihal_smooking'] = $pecah_pribadi[2];
				$data['e_perihal_jantung'] = $pecah_pribadi[3];
				$data['e_perihal_asma'] = $pecah_pribadi[4];
				$data['e_perihal_mendengkur'] = $pecah_pribadi[5];
				
				
				// LOAD DATA DROPDOWN
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
				
				
				$data['content'] = $this->load->view('biodata_edit', $data, true);
				$this->load->view('front', $data);
			
			}
		
		} else {
			
			redirect(site_url()."/biodata/list_jamaah");
		}
		
	}
	
	function do_edit(){
		
		$this->load->library('form_validation');
		$this->load->model('jamaah_candidate_model');
		
		if ($this->cek_validasi() == FALSE){
			$this->input();
		}
		else{
			
			// ID CANDIDATE 
			$id_candidate = $this->input->post('id_candidate');
			$id_account = $this->input->post('id_account');
			
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
			
			
			// cek requuest jasa nama paspor
			if($this->input->post('jasa_paspor_nama_edit') != NULL)
			{
				if($this->input->post('jasa_paspor_nama') != NULL)
				{
					$request_nama = $this->input->post('jasa_paspor_nama');
				
				} else {
					
					$request_nama = $this->input->post('jasa_paspor_nama_edit');
				}
			
			} else {
				
				$request_nama = $this->input->post('jasa_paspor_nama_edit');
			}
			
			
			// cek foto
			$cek_foto = $_FILES['foto']['name'];
			if($cek_foto != "")
			{
				// Upload Foto
				$config['upload_path'] = './images/upload/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('foto'))
				{
					$error = $this->upload->display_errors();
					echo "<script>alert('".$this->input->post('foto')."');window.location='javascript:history.back()';</script>";
					exit;
				
				}else{
					
					$data_file = $this->upload->data();
				}
				
				$valid = TRUE;
			
			} else {
				
				$valid = FALSE;
			}
			
			
			// update table
			$data = array(
				'ID_RELATION' => $this->input->post('relasi'),
				'ID_SIZE' => $this->input->post('baju'),
				'ID_PROPINSI' => $this->input->post('province'),
				'NAMA_LENGKAP' => $this->input->post('nama_lengkap'),
				'NAMA_PANGGILAN' => $this->input->post('panggilan'),
				'GENDER' => $this->input->post('gender'),
				'WARGA_NEGARA' => $this->input->post('warga_negara'),
				'TEMPAT_LAHIR' => $this->input->post('tempat_lahir'),
				'TANGGAL_LAHIR' => $dates,
				'AYAH_KANDUNG' => $this->input->post('ayah_kandung'),
				'KOTA' => $this->input->post('kota'),
				'ALAMAT' => $this->input->post('alamat'),
				'TELP' => $this->input->post('telp'),
				'MOBILE' => $this->input->post('hp'),
				'LAYANAN_KHUSUS' => $pelayanan_khusus,
				'PERIHAL_PRIBADI' => $perihal_pribadi,
				'JASA_TAMBAHAN' => $this->input->post('jasa_maningtis'),
				'REQUESTED_NAMA' => $request_nama,
				'MAHRAM' => $this->input->post('mahram'),
				'TANGGAL_UPDATE' => date("Y-m-d H:i:s")
				);
			
			if($valid)
			{
				$foto = array('FOTO' => $data_file['file_name']);
				$this->jamaah_candidate_model->update_jamaah($foto, $id_candidate);
				
				$file_gambar = $data_file['file_path'].$this->input->post('foto_edit');
				if(is_file($file_gambar))
				{
					unlink($file_gambar);
				}
			}
			
			$update = $this->jamaah_candidate_model->update_jamaah($data, $id_candidate);
			
			redirect('/biodata/edit/'.$id_candidate.'/'.$id_account);
		}
	}
					

}