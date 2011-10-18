<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_availability extends CI_Controller {

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
		$this->load->model('group_departure_model');
		$this->load->model('program_class_model');
		
		$group = $this->group_departure_model->get_all_group();
		$program = $this->program_class_model->get_all_program();

		$group_options['0'] = '-- Pilih Group --';
		foreach($group->result() as $row){
				$group_options[$row->ID_GROUP] = $row->KODE_GROUP;
		}
		
		$program_options['0'] = '-- Pilih Program --';
		foreach($program->result() as $row){
				$program_options[$row->ID_PROGRAM] = $row->NAMA_PROGRAM;
		}
			
		$data['group_options'] = $group_options;
		$data['program_options'] = $program_options;
		$data['content'] = $this->load->view('form_check_availability',$data,true);
		$this->load->view('front',$data);
	}
	
	function do_check(){
		if ($this->cek_validasi() == FALSE){
			//$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
			$this->front();
		}
		else{
		}
	}

    function load_data_form($id_kajiUlang) {
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
		);

		$this->form_validation->set_rules($config);
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }

    //cek pilihan sdh bener ap blm
    function cek_dropdown($value){
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Please choose one %s from the list !');
				return FALSE;
		}else
				return TRUE;
    }
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/Check_availability.php */