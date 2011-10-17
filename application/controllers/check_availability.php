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
		$data['content'] = $this->load->view('form_check_availability',null,true);
		$this->load->view('front',$data);
	}
	
	function do_check(){
		if ($this->cek_validasi() == FALSE){
			$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
			$this->input($id_kajiUlang);
		}
		else{
		}
	}
	
	//load default data dari database untuk form
    function load_data_from_db() {
            $this->load->model('kaji_ulang_model','mKaji');
            $this->load->model('pegawai_model', 'mPegawai');

            $kondisi = array('STATUS'=>'1');

            $kaji_ulang = $this->mKaji->get_kaji_ulang($id_kajiUlang);
            $pegawai = $this->mPegawai->get_pegawai_where($kondisi);

            $options_petugas['0'] = '-- Pilih Petugas --';
            foreach($pegawai->result() as $row){
                    $options_petugas[$row->ID_PEGAWAI] = $row->NAMA_PEGAWAI;
            }

            $options_keputusan = array('-- Pilih Keputusan --','Direkomendasi',
                                        'Tidak Direkomendasikan');

            $this->data_base['options_petugas'] = $options_petugas;
            $this->data_base['options_keputusan'] = $options_keputusan;
            $this->data_base['id_kaji_ulang'] = $id_kajiUlang;
            $this->data_base['no_lab'] = $kaji_ulang->row()->NO_LAB;
            $this->data_base['analis'] = $kaji_ulang->row()->PETUGAS_UJI_KADAR_AIR;
            
            $this->jenis_uji['uji_ka'] = $kaji_ulang->row()->UJI_KADAR_AIR;
            $this->jenis_uji['uji_kg'] = $kaji_ulang->row()->UJI_KEMURNIAN_GENETIK;
            $this->jenis_uji['uji_kf'] = $kaji_ulang->row()->UJI_KEMURNIAN_FISIK;
            $this->jenis_uji['uji_dt'] = $kaji_ulang->row()->UJI_DAYA_TUMBUH;
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
				array('field'=>'kelas_program','label'=>'Kelas Program', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_adult','label'=>'Jumlah Adult', 'rules'=>'required|numeric'),
				array('field'=>'with_bed','label'=>'Child With Bed', 'rules'=>'numeric'),
				array('field'=>'no_bed','label'=>'Child No Bed', 'rules'=>'numeric'),
				array('field'=>'kamar','label'=>'Kamar', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_kamar','label'=>'Jumlah', 'rules'=>'callback_cek_dropdown'),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }

    //cek pilihan sdh bener ap blm
    function cek_dropdown($value){
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Choose one option of %s');
				return FALSE;
		}else
				return TRUE;
    }
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/Check_availability.php */