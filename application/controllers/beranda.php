<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->cekSession();
	}

	function index()
	{
		$this->front();
	}
	
	function front(){		
                $this->load->model('packet_model');

                $id_user = $this->session->userdata("id_account");
                $kode_reg = $this->session->userdata("kode_registrasi");

                $packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);

                if ($packet->num_rows() > 0){
                    $this->load->model('room_packet_model');
                    
                    foreach ($packet->result() as $row){
                        $id_group = $row->ID_GROUP;
                        $data['group'] = $row->KODE_GROUP;
                        $data['keterangan_group'] = $row->KETERANGAN;
                        $data['program'] = $row->NAMA_PROGRAM;
                        $data['adult'] = $row->JUMLAH_ADULT;
                        $data['with_bed'] = $row->CHILD_WITH_BED;
                        $data['no_bed'] = $row->CHILD_NO_BED;
                        $data['infant'] = $row->INFANT;
                        $data['tgl_pesan'] = $row->TANGGAL_PESAN;
                        $id_packet = $row->ID_PACKET;
                    }

                    // get data room
                    $room = $this->room_packet_model->get_room_packet_byIDpack($id_packet);
                    $data['room'] = $room->result();
                    $data['is_order'] = TRUE;

                    //get group info
                    $this->load->model('group_departure_model');
                    $data_group	= $this->group_departure_model->get_group_berdasarkan_id($id_group);
                    foreach ($data_group->result() as $row){
                        $data['jd'] = $this->konversi_tanggal($row->TANGGAL_KEBERANGKATAN_JD);
                        $data['mk'] = $this->konversi_tanggal($row->TANGGAL_KEBERANGKATAN_MK);
                        $data['paspor'] = $this->konversi_tanggal($row->JATUH_TEMPO_PASPOR);
                        $data['lunas'] = $this->konversi_tanggal($row->JATUH_TEMPO_PELUNASAN);
                        $data['dp'] = $this->konversi_tanggal($row->JATUH_TEMPO_UANG_MUKA);
                        $data['berkas']  = $this->konversi_tanggal($row->JATUH_TEMPO_BERKAS );
                    }

                    $data['content'] = $this->load->view('home_ordered',$data,true);
                }else{
                    $this->load->library('form_validation');
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

                    $room_options['0'] = '-- Pilih Jenis Kamar --';
                    foreach($room->result() as $row){
                                    $room_options[$row->ID_ROOM_TYPE] = $row->JENIS_KAMAR;
                    }

                    $data['group_options'] = $group_options;
                    $data['program_options'] = $program_options;
                    $data['room_options'] = $room_options;
                    $data['is_order'] = FALSE;
                    $data['content'] = $this->load->view('home',$data,true);
                }
		
		$this->load->view('front',$data);
	}

        function choose_packet(){
            if ($this->check_validasi() == FALSE){
                // //$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
                $this->front();
            }
            else{
                $group = $this->input->post('group');
                $kelas_program = $this->input->post('program');
                $jml_adult = $this->input->post('jml_adult');
                $with_bed = $this->input->post('with_bed')=='' ? 0:$this->input->post('with_bed');
                $no_bed = $this->input->post('no_bed')=='' ? 0:$this->input->post('no_bed');
                $infant = $this->input->post('infant')=='' ? 0:$this->input->post('infant');

                $id_user = $this->session->userdata("id_account");
                $kode_reg = $this->session->userdata("kode_registrasi");

                // insert into packet
                $data = array(
                    'ID_GROUP'=>$group, 'ID_ACCOUNT'=>$id_user, 'KODE_REGISTRASI' =>$kode_reg, 'ID_PROGRAM'=>$kelas_program,
                    'JUMLAH_ADULT'=>$jml_adult, 'CHILD_WITH_BED'=>$with_bed, 'CHILD_NO_BED'=>$no_bed, 'INFANT'=>$infant,
                    'TANGGAL_PESAN'=>date("Y-m-d h:i:s"), 'STATUS_PESANAN'=>1
                );

                $this->load->model('packet_model');
                $this->packet_model->insert_packet($data);

                // insert into room packet
                $id_pack = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
                if ($id_pack->num_rows() > 0){
                    $this->load->model('room_packet_model');
                    $kamar = $this->input->post('kamar');
                    $jml_kamar = $this->input->post('jml_kamar');

                    for($i=0; $i<count($kamar); $i++){
                        $this->room_packet_model->insert_room_packet(array('ID_ROOM_TYPE'=>$kamar[$i],
                            'ID_PACKET'=>$id_pack->row()->ID_PACKET, 'JUMLAH'=>$jml_kamar[$i]));
                    }
                }

                redirect('biodata');
            }
        }
        
	function check_availability(){
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
                $message = "";

                // check pagu pesawat
                $plane_flag = FALSE;
                if ($pagu_sv > $total_candidate){
                        $plane_flag = TRUE;
                }
                if ($pagu_ga > $total_candidate){
                        $plane_flag = TRUE;
                }
                else if (($pagu_sv+$pagu_ga) > $total_candidate){
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

                for($i=0; $i<count($kamar); $i++){
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

                $this->load->library('form_validation');
                if ($room_capacity >= $total_candidate && $available_beds >= $total_candidate){
                        if ($flag_room && $plane_flag){
                                return TRUE;
                        }else if ($plane_flag && $flag_room==FALSE){
                                $message .= "Maaf, Jumlah kamar tidak tersedia untuk pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";
                                $this->form_validation->set_message('check_availability', $message);
                                return FALSE;
                        }else if ($plane_flag==FALSE && $flag_room){
                                $this->form_validation->set_message('check_availability', $message);
                                return FALSE;
                        }else if ($plane_flag==FALSE && $flag_room==FALSE){
                                $message .= "Maaf, Jumlah kamar tidak tersedia untuk pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";
                                $this->form_validation->set_message('check_availability', $message);
                                return FALSE;
                        }
                } else {
                        $message = "Maaf, Jumlah pilihan kamar tidak mencukupi pilihan paket anda !!! Silahkan memilih konfigurasi yang lain.";
                        $this->form_validation->set_message('check_availability', $message);
                        return FALSE;
                }
                
	}
	
	function check_validasi() {
		$this->load->library('form_validation');
		//setting rules
		$config = array(
                    array('field'=>'avilability','label'=>'avilability', 'rules'=>'callback_check_availability'),
                    array('field'=>'group','label'=>'Group', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'program','label'=>'Kelas Program', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_adult','label'=>'Jumlah Adult', 'rules'=>'required|numeric'),
				array('field'=>'with_bed','label'=>'Child With Bed', 'rules'=>'numeric'),
				array('field'=>'no_bed','label'=>'Child No Bed', 'rules'=>'numeric'),
				array('field'=>'infant','label'=>'Infant', 'rules'=>'numeric'),
				array('field'=>'kamar','label'=>'Kamar', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'jml_kamar','label'=>'Jumlah', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'cek_setuju','label'=>'Persetujuan', 'rules'=>'required'),
		);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');
		$this->form_validation->set_message('valid_email', 'Penulisan kolom <strong>%s</strong> tidak benar!');
		$this->form_validation->set_message('numeric', '<strong>Kolom %s</strong> harus berupa angka !');

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

    //cek apakah user sudah login kedalam sistem
    function cekSession(){
            if(!$this->session->userdata('id_account'))
                    redirect('login');
    }
	
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/beranda.php */