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
		$this->load->model('room_type_model');
		
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
		
		$room_options = '';
		foreach($room->result() as $row){
				$room_options[$row->ID_ROOM_TYPE] = $row->JENIS_KAMAR;
		}
			
		$data['group_options'] = $group_options;
		$data['program_options'] = $program_options;
		$data['room_options'] = $room_options;
		$data['content'] = $this->load->view('form_check_availability',$data,true);
		$this->load->view('front',$data);
	}
	
	function do_check(){
		if ($this->cek_validasi() == FALSE){
			//$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
			$this->front();
		}
		else{
			$this->load->model('group_departure_model');
			$this->load->model('program_class_model');
			
			$group = $this->input->post('group');
            $kelas_program = $this->input->post('program');
            $jml_adult = $this->input->post('jml_adult');
            $with_bed = $this->input->post('with_bed')=='' ? 0:$this->input->post('with_bed');
            $no_bed = $this->input->post('no_bed')=='' ? 0:$this->input->post('no_bed');
			$infant = $this->input->post('infant')=='' ? 0:$this->input->post('infant');			
									
			$group_info = $this->group_departure_model->get_group($group);
			$kode_group = $group_info->row()->KODE_GROUP;
			$pagu_sv = $group_info->row()->PAGU_SV;
			$pagu_ga = $group_info->row()->PAGU_GA;
			$depart_jd = $group_info->row()->TANGGAL_KEBERANGKATAN_JD;
			$depart_mk = $group_info->row()->TANGGAL_KEBERANGKATAN_MK;
			
			$program_info = $this->program_class_model->get_program($kelas_program);
			$nama_program = $program_info->row()->NAMA_PROGRAM;
			
			$total_candidate = $jml_adult + $with_bed + $no_bed + $infant;	
			
			// check pagu pesawat
			$flag = FALSE; $plane_flag = FALSE;
			if ($pagu_sv > $total_candidate){
				$message = "Seat Pesawat tersedia. Keberangkatan menggunakan pesawat Saudi Airlines";
				$flag = TRUE; $plane_flag = TRUE;
			} 
			if ($pagu_ga > $total_candidate){
				if ($flag) $message .= " atau Garuda Indonesia Airlines. ";
				else $message = "Seat Pesawat tersedia. Keberangkatan menggunakan pesawat Garuda Indonesia Airlines.";
				$plane_flag = TRUE;
			}
			else if (($pagu_sv+$pagu_ga) > $total_candidate){
				$kursi_sisa = $total_candidate-$pagu_sv;
				$message = "Seat Pesawat tersedia. Keberangkatan menggunakan pesawat Saudi Airlines sejumlah $pagu_sv kursi dan Garuda Indonesia Airlines sejumlah $kursi_sisa kursi";
				$plane_flag = TRUE;
			}else
				$message = "Paket yang anda inginkan saat ini sedang tak tersedia.";
			
			// check room avilability
			$this->load->model('room_model');
			$this->load->model('room_type_model');
		
			$kamar = $this->input->post('kamar');
			$jml_kamar = $this->input->post('jml_kamar');
			$total_candidate -= ($no_bed + $infant);
			$total_room = 0;			
			$room_capacity = 0;
			
			for($i=0; $i<count($kamar); $i++){				
				if($kamar[$i]!='0'  && $kamar[$i] != ''){
					$room_type = $this->room_type_model->get_roomType($kamar[$i]);
					$room_choice[$i] = "<pre>".$room_type->row()->JENIS_KAMAR." jumlah ".$jml_kamar[$i]." Kamar</pre>";
					$room_capacity += $room_type->row()->CAPACITY * $jml_kamar[$i];
				}
			}
			
			if ($room_capacity >= $total_candidate){
				for($i=0; $i<count($kamar); $i++){
					if($kamar[$i]!='0'  && $kamar[$i] != ''){		
						$room_type = $this->room_type_model->get_roomType($kamar[$i]);
						if ($room_capacity % $total_candidate > 0){
							$counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], 0)->num_rows();
						} else if ($room_capacity % $total_candidate == 0){
							$counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], $room_type->row()->CAPACITY)->num_rows();							
						}
						
						if ($counter >= $jml_kamar[$i]){
						} else{
							
						}
					}
				}	
				
			} else {
				$message .= "<br>Maaf, Jumlah pilihan kamar tidak mencukupi pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";
			}
			
			$data['waiting'] = FALSE;
			if ($total_room < $total_candidate && $total_room != 0){
				$message .= "<br>Maaf, Jumlah kamar yang tersedia tidak mencukupi pilihan paket anda !!!";
				$data['available_room'] = $this->room_model->count_available_room($group);				
			}
			else if ($total_room == 0){
				$data['waiting'] = TRUE;
			}
			
			if ($plane_flag && !$data['waiting']){
				$data['depart_jd'] = date_format(date_create($depart_jd), "d M Y");
				$data['depart_mk'] = date_format(date_create($depart_mk), "d M Y");
			}
			
			$data['jml_adult'] = $jml_adult;
			$data['with_bed'] = $with_bed;
			$data['no_bed'] = $no_bed;
			$data['infant'] = $infant;
			$data['kode_group'] = $kode_group;
			$data['nama_program'] = $nama_program;
			$data['room_choice'] = $room_choice;
			$data['plane_flag'] = $plane_flag;
			$data['message'] = $message;
			
			$data['content'] = $this->load->view('result_page',$data,true);
			$this->load->view('front',$data);
		}
	}
	
	function cek_validasi() {
		$adult = $this->input->post('jml_adult');
		$with_bed = $this->input->post('with_bed')=='' ? 0:$this->input->post('with_bed');
		$no_bed = $this->input->post('no_bed')=='' ? 0:$this->input->post('no_bed');
		$infant = $this->input->post('infant')=='' ? 0:$this->input->post('infant');
		$total = $adult + $with_bed + $no_bed + $infant;
			
		//setting rules
		$config = array(
				array('field'=>'group','label'=>'Group', 'rules'=>'callback_cek_dropdown|callback_check_departure'),
				array('field'=>'program','label'=>'Kelas Program', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_adult','label'=>'Jumlah Adult', 'rules'=>"required|integer|callback_check_jml[$total]"),
				array('field'=>'with_bed','label'=>'Child With Bed', 'rules'=>"integer"),
				array('field'=>'no_bed','label'=>'Child No Bed', 'rules'=>"integer"),
				array('field'=>'infant','label'=>'Infant', 'rules'=>"integer|callback_check_jml[$adult]"),
				array('field'=>'kamar[]','label'=>'Kamar', 'rules'=>'callback_cek_dropdown'),
				//array('field'=>'jml_kamar','label'=>'Jumlah', 'rules'=>'callback_cek_dropdown'),
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
	
	function check_departure($id_group){
		$this->load->model('group_departure_model');
		$val = $this->group_departure_model->get_group($id_group);
		
		if ($val->num_rows() > 0){
			$exp_date = strtotime($val->row()->JATUH_TEMPO_UANG_MUKA);
			$today = strtotime(date("Y-m-d"));
			
			if ($exp_date >= $today)
				return TRUE;
			else{
				$this->form_validation->set_message('check_departure', 'Sorry registration for this group has closed');
				return FALSE;
			}
		}
	}
	
	//cek jumlah
    function check_jml($value, $max){
		if ($max > 20) {
			$this->form_validation->set_message('check_jml', "Maximum number of canddidate are 20 for each unit");
			return FALSE;
		}else{
			if($value > $max){
				$this->form_validation->set_message('check_jml', "The maximum number of %s are $max !");
				return FALSE;
			}else
				return TRUE;
		}
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
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/Check_availability.php */