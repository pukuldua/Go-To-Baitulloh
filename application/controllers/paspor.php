<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paspor extends CI_Controller {

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
		$colModel['NAMA_LENGKAP'] = array('Nama Lengkap',150,TRUE,'center',1);
		$colModel['REQUESTED_NAMA'] = array('Nama 3 Suku Kata',150,TRUE,'center',1);
		$colModel['GENDER'] = array('Jenis Kelamin',100,FALSE,'center',0);
		$colModel['WARGA_NEGARA'] = array('Warga Negara',130,TRUE,'center',1);
		$colModel['NO_PASPOR'] = array('No Paspor',120,FALSE,'center',1);
		$colModel['TANGGAL_DIKELUARKAN'] = array('Tgl. Dikerluarkan',100,TRUE,'center',0);
		$colModel['TANGGAL_HABIS'] = array('Tgl. Habis Berlaku',100,TRUE,'center',0);
		$colModel['KANTOR_PEMBUATAN'] = array('Kantor',100,TRUE,'center',1);
		
		$gridParams = array(
		'width' => 'auto',
		'height' => 300,
		'rp' => 10,
		'rpOptions' => '[5,10,15,'.$total_data.']',
		'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} hasil.',
		'blockOpacity' => 0.5,
		'title' => 'Dokumen Calon Jamaah',
		'showTableToggleBtn' => false
		);
		
		$buttons[] = array('separator');
		
		$grid_js = build_grid_js('flex1',site_url("/paspor/grid_calon_jamaah/"),$colModel,'no','asc',$gridParams);
		$data['js_grid'] = $grid_js;
		
		$data['added_js'] = 
		"<script type='text/javascript'>
		function spt_js(com,grid){
			
		} 
		</script>
		";

                
		$data['content'] = $this->load->view('paspor_list',$data,true);
		$this->load->view('front',$data);		
	}
	
	
	function grid_calon_jamaah() {
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$valid_fields = array('NAMA_LENGKAP','REQUESTED_NAMA','WARGA_NEGARA','NO_PASPOR','KANTOR_PEMBUATAN');
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
			
			if($row->NO_PASPOR != NULL && $row->TANGGAL_DIKELUARKAN != NULL)
			{
				$gos = 1;
			}else{
				$gos = 0;
			}
			
			$record_items[] = array(
			
				$row->ID_CANDIDATE,
				$no = $no+1,
				'<a href=\''.site_url().'/paspor/edit/'.$row->ID_CANDIDATE.'/'.$row->ID_ACCOUNT.'/'.$gos.'\'><img border=\'0\' src=\''.base_url().'images/flexigrid/book.png\'></a> ',
				$row->NAMA_LENGKAP,	
				$row->REQUESTED_NAMA,
				$gender,
				$row->WARGA_NEGARA,
				$row->NO_PASPOR,
				$row->TANGGAL_DIKELUARKAN,
				$row->TANGGAL_HABIS,
				$row->KANTOR_PEMBUATAN
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}
	
	
	// HALAMAN EDIT DOKUMEN CALON JAMAAH
	function edit($id_candidate = NULL, $id_account = NULL, $tipe)
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
				$data['e_gender'] = $row->GENDER;
				$data['e_warga_negara'] = $row->WARGA_NEGARA;
				$data['e_tempat_lahir'] = $row->TEMPAT_LAHIR;
				$data['e_tgl_lahir'] = $row->TANGGAL_LAHIR;
				$data['e_kota'] = $row->KOTA;
				$data['e_pas_foto'] = $row->FOTO;
				$data['e_request_nama'] = $row->REQUESTED_NAMA;
				
				// DATA PASPOR
				$data['e_no_paspor'] = $row->NO_PASPOR;
				$data['e_tgl_keluar'] = $row->TANGGAL_DIKELUARKAN;
				$data['e_tgl_habis'] = $row->TANGGAL_HABIS;
				$data['e_kantor'] = $row->KANTOR_PEMBUATAN;
				$data['e_scan_paspor'] = $row->SCAN_PASPOR;
				
				// FILTER JENIS KELAMIN
				if($row->GENDER == 1) $data['e_gender'] = "Laki-Laki";
				elseif($row->GENDER == 2) $data['e_gender'] = "Perempuan";
				
				// UBAH TANGGAL LAHIR
				$data['tgl_lahir'] = date("d F Y", strtotime($data['e_tgl_lahir']));
				
				// PECAH TANGGAL PASPOR
				if($data['e_tgl_keluar'] != NULL)
				{
					$k_pecah_tgl = explode("-", $data['e_tgl_keluar']);
					$data['e_k_thn'] = $k_pecah_tgl[0];
					$data['e_k_bln'] = $k_pecah_tgl[1];
					$data['e_k_tgl'] = $k_pecah_tgl[2];
				}
				
				if($data['e_tgl_habis'] != NULL)
				{
					$b_pecah_tgl = explode("-", $data['e_tgl_habis']);
					$data['e_b_thn'] = $b_pecah_tgl[0];
					$data['e_b_bln'] = $b_pecah_tgl[1];
					$data['e_b_tgl'] = $b_pecah_tgl[2];
				}
						
				$data['tipe'] = $tipe;
				
				
				$data['content'] = $this->load->view('paspor_edit', $data, true);
				$this->load->view('front', $data);
			
			}
		
		} else {
			
			redirect(site_url()."/biodata/list_jamaah");
		}
		
	}
	
	function cek_validasi() {
		$this->load->library('form_validation');
		//setting rules
		$config = array(
				array('field'=>'no_paspor','label'=>'Nomor Paspor', 'rules'=>'required'),
				array('field'=>'k_tgl_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'k_bln_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'k_thn_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'b_tgl_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'b_bln_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'b_thn_lahir','label'=>'Tanggal Lahir', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'kantor','label'=>'Kantor', 'rules'=>'required'),
		//		array('field'=>'foto','label'=>'Scan Paspor', 'rules'=>'required'),
			);
		
		
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');
		$this->form_validation->set_message('valid_email', 'Penulisan kolom <strong>%s</strong> tidak benar!');
		$this->form_validation->set_message('numeric', '<strong>Kolom %s</strong> harus berupa angka !');
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }
	
	function cek_dropdown($value){
		$this->load->library('form_validation');
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Pilih salah satu <strong>%s</strong> !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function do_edit(){
		
		$this->load->library('form_validation');
		$this->load->model('jamaah_candidate_model');
		
		// ID CANDIDATE DAN ID ACCOUNT
		$id_candidate = $this->input->post('id_candidate');
		$id_account = $this->input->post('id_account');
		$tipe = $this->input->post('id_tipe');
		
		if ($this->cek_validasi() == FALSE){
			$this->edit($id_candidate, $id_account, $tipe);
		}
		else{

			// tanggal dikerluarkan 
			$k_tgl = $this->input->post('k_tgl_lahir');
			$k_bln = $this->input->post('k_bln_lahir');
			$k_thn = $this->input->post('k_thn_lahir');
			$k_dates = $k_thn."-".$k_bln."-".$k_tgl;
			
			// tanggal berakhir
			$b_tgl = $this->input->post('b_tgl_lahir');
			$b_bln = $this->input->post('b_bln_lahir');
			$b_thn = $this->input->post('b_thn_lahir');
			$b_dates = $b_thn."-".$b_bln."-".$b_tgl;
			
			// cek foto
			$cek_foto = $_FILES['foto']['name'];
			if($cek_foto != "")
			{
				// Upload Foto
				$config['upload_path'] = './images/upload/paspor/';
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
				'NO_PASPOR' => $this->input->post('no_paspor'),
				'TANGGAL_DIKELUARKAN' => $k_dates,
				'TANGGAL_HABIS' => $b_dates,
				'KANTOR_PEMBUATAN' => $this->input->post('kantor'),
				'TANGGAL_UPDATE' => date("Y-m-d H:i:s")
				);
			
			if($valid)
			{
				$foto = array('SCAN_PASPOR' => $data_file['file_name']);
				$this->jamaah_candidate_model->update_jamaah($foto, $id_candidate);
				
				$file_gambar = $data_file['file_path'].$this->input->post('paspor_edit');
				if(is_file($file_gambar))
				{
					unlink($file_gambar);
				}
			}
			$tipe = 1;
			$update = $this->jamaah_candidate_model->update_jamaah($data, $id_candidate);
			
			redirect('/paspor/edit/'.$id_candidate.'/'.$id_account.'/'.$tipe.'/');
		}
	}
}

?>