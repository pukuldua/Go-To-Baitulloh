<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_availability extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
                ini_set('date.timezone', "Asia/Jakarta");
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
			$flag_room = TRUE;
			$room_capacity = 0;
			$tmp_candidate = $total_candidate;
			$available_beds = $this->room_model->count_available_beds($group)->row()->JML_BEDS;
			$data['waiting'] = FALSE;
			
			for($i=0; $i<count($kamar); $i++){				
				if($kamar[$i]!='0'  && $kamar[$i] != ''){
					$room_type = $this->room_type_model->get_roomType($kamar[$i]);
					$room_choice[$i] = "<pre>".$room_type->row()->JENIS_KAMAR." jumlah ".$jml_kamar[$i]." Kamar</pre>";
					$tmp_capacity = $room_type->row()->CAPACITY * $jml_kamar[$i];
					$room_capacity += $tmp_capacity;
					
					$tmp_candidate -= $tmp_capacity;
					if ($tmp_candidate >= 0){
						$counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], $room_type->row()->CAPACITY)->num_rows();
					}else {
						$counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], 0)->num_rows();
					}
					
					if ($counter < $jml_kamar[$i]){						
						$flag_room = FALSE;
					}
				}
			}

                        //reverse order
                        if (! $flag_room){
                            $tmp_candidate = $total_candidate;
                            $room_capacity = 0;
                            $flag_room = TRUE;
                            for($i=count($kamar)-1; $i >= 0; $i--){
                                    if($kamar[$i]!='0'  && $kamar[$i] != ''){
                                            $room_type = $this->room_type_model->get_roomType($kamar[$i]);
                                            $tmp_capacity = $room_type->row()->CAPACITY * $jml_kamar[$i];
                                            $room_capacity += $tmp_capacity;

                                            $tmp_candidate -= $tmp_capacity;
                                            if ($tmp_candidate >= 0){
                                                    $counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], $room_type->row()->CAPACITY)->num_rows();
                                            }else {
                                                    $counter = $this->room_model->check_available_room($group, $kelas_program, $kamar[$i], 0)->num_rows();
                                            }

                                            if ($counter < $jml_kamar[$i]){
                                                    $flag_room = FALSE;
                                            }
                                    }
                            }
                        }
			
			if ($room_capacity >= $total_candidate && $available_beds >= $total_candidate){
				if ($flag_room){
					$message .= "<br>Jumlah kamar tersedia untuk paket pilihan anda";
				}else{
					$data['waiting'] = TRUE;
					$message .= "<br>Maaf, Jumlah kamar tidak tersedia untuk pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";					
					$data['available_room'] = $this->room_model->count_available_room($group);
				}
			} else {
				$message .= "<br>Maaf, Jumlah pilihan kamar tidak mencukupi pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";
				
				if ($available_beds >= $total_candidate)
					$data['available_room'] = $this->room_model->count_available_room($group);
			}
			
			if ($plane_flag){
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
				array('field'=>'jml_adult','label'=>'Jumlah Dewasa', 'rules'=>"required|integer|callback_check_jml[$total]"),
				array('field'=>'with_bed','label'=>'Anak Dengan Ranjang', 'rules'=>"integer"),
				array('field'=>'no_bed','label'=>'Anak Tanpa Ranjang', 'rules'=>"integer"),
				array('field'=>'infant','label'=>'Bayi', 'rules'=>"integer|callback_check_jml[$adult]"),
				array('field'=>'kamar[]','label'=>'Kamar', 'rules'=>'callback_cek_dropdown'),
				//array('field'=>'jml_kamar','label'=>'Jumlah', 'rules'=>'callback_cek_dropdown'),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', '%s wajib diisi !');
		$this->form_validation->set_message('integer', '%s harus berisi bilangan bulat !');
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }

    //cek pilihan sdh bener ap blm
    function cek_dropdown($value){
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Harap memilih salah satu %s !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function check_departure($id_group){
		$this->load->model('group_departure_model');
		$val = $this->group_departure_model->get_group($id_group);
		
		if ($val->num_rows() > 0){
                        date_default_timezone_set("Asia/Jakarta");
			$exp_date = strtotime($val->row()->JATUH_TEMPO_UANG_MUKA);
			$today = strtotime(date("Y-m-d"));
			
			if ($exp_date >= $today)
				return TRUE;
			else{
				$this->form_validation->set_message('check_departure', 'Maaf, pendaftaran untuk grup ini sudah ditutup');
				return FALSE;
			}
		}
	}
	
	//cek jumlah
    function check_jml($value, $max){
		if ($max > 20) {
			$this->form_validation->set_message('check_jml', "Jumlah maksimum calon jamaah 20 orang tiap unit");
			return FALSE;
		}else{
			if($value > $max){
				$this->form_validation->set_message('check_jml', "Jumlah maksimum untuk %s adalah $max !");
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
	  $bulan = ""; $strHari = "";
      $tahun    = substr($tgl,0,4);
              $hari = date("N", mktime(0, 0, 0, $bln, $tanggal, $tahun));

              switch ($hari){
                  case 1:
                      $strHari = "Senin";
                      break;
                  case 2:
                      $strHari = "Selasa";
                      break;
                  case 3:
                      $strHari = "Rabu";
                      break;
                  case 4:
                      $strHari = "Kamis";
                      break;
                  case 5:
                      $strHari = "Jumat";
                      break;
                  case 6:
                      $strHari = "Sabtu";
                      break;
                  case 7:
                      $strHari = "Minggu";
                      break;
              }

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
	   return $strHari.", ".$tanggal.' '.$bulan.' '.$tahun;
    }
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/Check_availability.php */