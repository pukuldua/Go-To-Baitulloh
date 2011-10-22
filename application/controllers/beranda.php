<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->front();
	}
	
	function front(){
		$this->load->model('group_departure_model');
		$this->load->model('program_class_model');
		$this->load->model('room_type_model');
		$this->load->library('form_validation');
		
		$group = $this->group_departure_model->get_all_group();
		$program = $this->program_class_model->get_all_program();
		$room = $this->room_type_model->get_all_roomType();

		$group_options['0'] = '-- Pilih Group --';
		foreach($group->result() as $row){
				$group_options[$row->ID_GROUP] = $row->KODE_GROUP;
		}
		
		$program_options['0'] = '-- Pilih Program --';
		foreach($program->result() as $row){
				$program_options[$row->ID_PROGRAM] = $row->NAMA_PROGRAM;
		}
		
		$room_options['0'] = '-- Pilih Jenis Kamar --';
		foreach($room->result() as $row){
				$room_options[$row->ID_ROOM_TYPE] = $row->JENIS_KAMAR;
		}
			
		$data['group_options'] = $group_options;
		$data['program_options'] = $program_options;
		$data['room_options'] = $room_options;
		$data['content'] = $this->load->view('home',$data,true);
		$this->load->view('front',$data);
	}
	
	function do_check(){
		
		$this->load->library('form_validation');
		
		if ($this->cek_validasi() == FALSE){
			//$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
			$this->front();
		}
		else{
		}
	}

    function load_data_form($id_kajiUlang) {
		
			$this->load->library('form_validation');
			
            $group = ($this->input->post('kadar_air1')=='' ? NULL : $this->input->post('kadar_air1'));
            $kelas_program = ($this->input->post('kadar_air2')=='' ? NULL : $this->input->post('kadar_air2'));
            $jml_adult = $this->input->post('thn_selesai');
            $with_bed = $this->input->post('penyelia');
            $no_bed = $this->input->post('keputusan');
            $kamar = $this->input->post('keterangan');
            $jml_kamar = $this->input->post('rata2penyelia');

            if($penyelia==0) $penyelia = NULL;
            if($tgl=='--') $tgl = NULL;

            $this->data_field = array('ID_PEGAWAI'=>$penyelia,'ID_KAJI_ULANG'=>$id_kajiUlang,
                'KADAR_AIR_ULANGAN1'=>$ka1,'KADAR_AIR_ULANGAN2'=>$ka2,'KETERANGAN_UJI'=>$ket,
                'KEPUTUSAN'=>$keputusan,'TGL_SELESAI_UJI'=>$tgl,'PROSENTASE_KA'=>$rata);
    }
	
	function cek_validasi() {
		$this->load->library('form_validation');
		//setting rules
		$config = array(
				array('field'=>'group','label'=>'Group', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'program','label'=>'Kelas Program', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_adult','label'=>'Jumlah Adult', 'rules'=>'required|numeric'),
				array('field'=>'with_bed','label'=>'Child With Bed', 'rules'=>'numeric'),
				array('field'=>'no_bed','label'=>'Child No Bed', 'rules'=>'numeric'),
				array('field'=>'infant','label'=>'Infant', 'rules'=>'numeric'),
				array('field'=>'kamar','label'=>'Kamar', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_kamar','label'=>'Jumlah', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'cek_setuju','label'=>'Checklist', 'rules'=>'required'),
		);

		$this->form_validation->set_rules($config);
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }

    //cek pilihan sdh bener ap blm
    function cek_dropdown($value){
		$this->load->library('form_validation');
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Please choose one %s from the list !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function getKamar(){
		$this->load->model('room_type_model');
                
		$options = '';
		$room = $this->room_type_model->get_all_roomType();
		foreach ($room->result() as $angkutan){
			$options.= '<option value="'.$angkutan->ID_ROOM_TYPE.'" class="dynamic4">'.$angkutan->JENIS_KAMAR.'</option>';
		}
		echo $options;
	}
	
	function getGroup()
	{
		$this->load->model('group_departure_model');
		
		if ($_POST['id_group']!='' && $_POST['id_group']!= 0) { 
			$parent = $_POST['id_group'];
			
			$data_group	= $this->group_departure_model->get_group_berdasarkan_id($parent);			
			foreach ($data_group->result() as $row){
				
				$kode = $row->KODE_GROUP;
				$ket = $row->KETERANGAN;
				$jd = $this->konversi_tanggal($row->TANGGAL_KEBERANGKATAN_JD);
				$mk = $this->konversi_tanggal($row->TANGGAL_KEBERANGKATAN_MK);
				$paspor = $this->konversi_tanggal($row->JATUH_TEMPO_PASPOR);
				$lunas = $this->konversi_tanggal($row->JATUH_TEMPO_PELUNASAN);
				$dp = $this->konversi_tanggal($row->JATUH_TEMPO_UANG_MUKA);
				$berkas = $this->konversi_tanggal($row->JATUH_TEMPO_BERKAS );
				
				$data = $jd."#".$mk."#".$paspor."#".$lunas."#".$dp."#".$berkas."#".$kode."#".$ket;
			}
			echo $data;
		
		} else {
			
			echo " # # # # # # # ";
		}

	}
	
	function konversi_tanggal($tgl){
      $tanggal = substr($tgl,8,2);
      $bln    = substr($tgl,5,2);
	  $bulan = "";
      $tahun    = substr($tgl,0,4);
              

      switch ($bln){
        case 1:
          $bulan =  "Januari";
          break;
        case 2:
          $bulan =  "Februari";
          break;
        case 3:
          $bulan = "Maret";
          break;
        case 4:
          $bulan =  "April";
          break;
        case 5:
          $bulan =  "Mei";
          break;
        case 6:
          $bulan =  "Juni";
          break;
        case 7:
          $bulan =  "Juli";
          break;
        case 8:
          $bulan =  "Agustus";
          break;
        case 9:
          $bulan =  "September";
          break;
        case 10:
          $bulan =  "Oktober";
          break;
        case 11:
          $bulan =  "November";
          break;
        case 12:
          $bulan =  "Desember";
          break;
	   } 
	   return $tanggal.' '.$bulan.' '.$tahun;
    }
	
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/beranda.php */