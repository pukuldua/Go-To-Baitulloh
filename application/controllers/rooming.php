<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooming extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->cekSession();
                $this->cekOrder();
	}
	
	function index(){            
		$this->load->model('room_model');
                $this->load->model('room_type_model');
		$this->load->model('packet_model');
		$this->load->model('room_packet_model');
                $this->load->model('jamaah_candidate_model');
                $this->load->model('booked_room_model');
		
		$id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");

                $payment = $this->packet_model->get_packet_status($id_user, $kode_reg);

                if ($payment->num_rows() > 0 && ($payment->row()->STATUS_PESANAN == 3)){
                    $data['is_pay'] = TRUE;
                    $room_options['0'] = '-- Pilih Kamar --';

                    $data_packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
                    $booked_candidate = $this->booked_room_model->get_already_booked($id_user, $kode_reg);

                    $data_bc = array('');
                    foreach ($booked_candidate->result() as $row)
                        $data_bc = array_merge($data_bc, array($row->ID_CANDIDATE));

                    $candidate = $this->jamaah_candidate_model->get_jamaah_notBooked_room($id_user, $kode_reg, $data_bc);

                    if ($data_packet->num_rows() > 0){
                            foreach($data_packet->result() as $rows){
                                    $id_pack = $rows->ID_PACKET;
                                    $group = $rows->ID_GROUP;
                                    $program = $rows->ID_PROGRAM;
                                    $nama_program = $rows->NAMA_PROGRAM;
                                    $adult = $rows->JUMLAH_ADULT;
                                    $anak = $rows->CHILD_WITH_BED;
                            }

                            $total_candidate = $adult + $anak;
                            $room_capacity = 0;
                            $room_packet = $this->room_packet_model->get_room_packet_byIDpack($id_pack);

                            foreach ($room_packet->result() as $rs){
                                $room_type = $this->room_type_model->get_roomType($rs->ID_ROOM_TYPE);
                                $tmp_capacity = $room_type->row()->CAPACITY * $rs->JUMLAH;
                                $room_capacity += $tmp_capacity;
                                $jml_room = $rs->JUMLAH;

                                if ($total_candidate > $candidate->num_rows()){
                                    $total_candidate = $candidate->num_rows();
                                    $total_candidate -= $tmp_capacity;
                                    if ($total_candidate >= 0){
                                            $room = $this->room_model->check_available_room($group, $program, $rs->ID_ROOM_TYPE, $room_type->row()->CAPACITY);
                                            foreach($room->result() as $row){
                                                $room_options[$row->ID_ROOM] = $nama_program." - ".$room_type->row()->JENIS_KAMAR." - [".$row->KODE_KAMAR."]";
                                            }
                                    }else {
                                            $room = $this->room_model->check_available_room($group, $program, $rs->ID_ROOM_TYPE, 0);
                                            foreach($room->result() as $row){
                                                $room_options[$row->ID_ROOM] = $nama_program." - ".$room_type->row()->JENIS_KAMAR." - [".$row->KODE_KAMAR."]";
                                            }
                                    }
                                }else{
                                    $total_candidate -= $tmp_capacity;
                                    if ($total_candidate >= 0){
                                            $room = $this->room_model->check_available_room($group, $program, $rs->ID_ROOM_TYPE, $room_type->row()->CAPACITY);
                                            foreach($room->result() as $row){
                                                $room_options[$row->ID_ROOM] = $nama_program." - ".$room_type->row()->JENIS_KAMAR." - [".$row->KODE_KAMAR."]";
                                            }
                                    }else {
                                            $room = $this->room_model->check_available_room($group, $program, $rs->ID_ROOM_TYPE, 0);
                                            foreach($room->result() as $row){
                                                $room_options[$row->ID_ROOM] = $nama_program." - ".$room_type->row()->JENIS_KAMAR." - [".$row->KODE_KAMAR."]";
                                            }
                                    }
                                }
                            }
                    }

                    if($candidate->num_rows() > 0){
                        foreach($candidate->result() as $row){
                            $list_candidate[$row->ID_CANDIDATE] = $row->NAMA_LENGKAP;
                        }
                        $data['list_candidate'] = $list_candidate;
                        $data['room_options'] = $room_options;
                        $data['is_booking'] = FALSE;
                    }else{
                        $candidate_inroom = $this->booked_room_model->get_all_booked_candidate($id_user, $kode_reg);
                        $data['candidate_inroom'] = $candidate_inroom;
                        $data['is_booking'] = TRUE;
                    }
                }else{
                    $data['is_pay'] = FALSE;
                }
		
		$data['content'] = $this->load->view('form_rooming',$data,true);
		//$this->load->view('form_rooming',null,false);
		$this->load->view('front',$data);
	}

        function show_profile($id_candidate){
            $this->load->model('jamaah_candidate_model');

            $key = $this->decode($id_candidate);
            $jamaah = $this->jamaah_candidate_model->get_profile($key, $this->session->userdata("kode_registrasi"));

            if($jamaah->num_rows() > 0){
                $data['jamaah_profile'] = $jamaah;
                $this->load->view('profile',$data,FALSE);
            }else
                show_404();
        }

        function secure($data){
            $front = substr(sha1($data * rand(0, 1000)), 0, 10);
            $rear = substr(sha1(rand(0, 1000) / $data), 0, 25);

            return $front.$data.$rear;
	}

        function decode($data){
            $front = substr($data, 10, strlen($data));
            $resolved = substr($front, 0, strlen($front)-25);

            return $resolved;
	}

	function book_room()
	{
            if ($this->check_validasi() == FALSE){
			// //$this->session->set_userdata('failed_form','Kegagalan Menyimpan Data, Kesalahan Pengisian Form!');
			$this->index();
            }else{
                $this->load->model('room_model');
                $this->load->model('booked_room_model');
                $this->load->model('log_model');
                
		$room = $this->input->post('room');
                $cadidate = $this->input->post('candidate');
                
                $id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");

                for ($i=0; $i < count($cadidate); $i++){
                    $data = array('ID_ROOM' => $room, 'ID_CANDIDATE' => $cadidate[$i], 'TANGGAL_BOOKING' => date("Y-m-d h:i:s"));
                    $log = "INSERT data untuk BOOKED_ROOM dengan ID_ROOM = $room dan ID_CANDIDATE = $cadidate[$i]";

                    $this->booked_room_model->insert_booked_room($data);
                    $this->log_model->log($id_user, $kode_reg, NULL, $log);

                    $data_room = $this->room_model->get_room($room);
                    if ($data_room->num_rows() > 0){
                        if ($data_room->row()->AVAILABILITY == 1){
                            $bed = $data_room->row()->BEDS;

                            if ($bed-1 > 0){
                                $this->room_model->update_room($room, array('BEDS' => $bed-1));
                                
                                $log = "UPDATE data ROOM dengan ID_ROOM = $room set BEDS = ".($bed-1);
                                $this->log_model->log($id_user, $kode_reg, NULL, $log);
                            }
                            else{
                                $this->room_model->update_room($room, array('BEDS' => $bed-1, 'AVAILABILITY' => 0));
                                
                                $log = "UPDATE data ROOM dengan ID_ROOM = $room set BEDS = ".($bed-1)." dan AVAILABILITY = 0";
                                $this->log_model->log($id_user, $kode_reg, NULL, $log);
                            }
                        }
                    }
                    
                }
		redirect('rooming');
            }
	}

        function check_validasi() {
            $this->load->library('form_validation');
            
		//setting rules
		$this->form_validation->set_rules('room', 'Kamar', 'callback_check_dropdown');
                return $this->form_validation->run();
        }

        //cek pilihan sdh bener ap blm
    function check_dropdown($value){
		if($value==0){
			$this->form_validation->set_message('check_dropdown', 'Harap memilih salah satu %s !');
				return FALSE;
		}else
				return TRUE;
    }
    
        function getJamaah(){
            if ($_POST['id_room']!=''){
		$this->load->model('booked_room_model');

                $id_room = $_POST['id_room'];
                $id_acc = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");

                $atts = array(
                      'width'      => '550',
                      'height'     => '350',
                      'scrollbars' => 'yes',
                      'status'     => 'yes',
                      'resizable'  => 'yes',
                      'screenx'    => '0',
                      'screeny'    => '0'
                    );
                
		$list = '<ul class="greyarrow">';
		$room = $this->booked_room_model->get_booked_candidate($id_acc, $kode_reg, $id_room);
		if ($room->num_rows() > 0){
                    foreach ($room->result() as $rs){
                            $key = $this->secure($rs->ID_CANDIDATE);
                            $list.= '<li>'.anchor_popup('rooming/show_profile/'.$key, $rs->NAMA_LENGKAP." - ".$rs->KOTA, $atts).'</li>';
                    }
                    echo $list.'</ul>';
                } else echo "";
            } else echo '';
	}

        function getMax_room(){
            if ($_POST['id_room']!=''){
		$this->load->model('room_model');

                $id_room = $_POST['id_room'];

		$list = '';
		$room = $this->room_model->get_room($id_room);
		if ($room->num_rows() > 0){
                    foreach ($room->result() as $rs){
                            $list = $rs->BEDS;
                    }
                    echo $list;
                } else echo 0;
            } else echo 0;
	}

        //cek apakah user sudah login kedalam sistem
  	function cekSession(){
            if($this->session->userdata('id_account') == NULL || $this->session->userdata('id_account') == '')
                    redirect('login');
    }

        // cek order packet
        function cekOrder(){
            $this->load->model('packet_model');
            $id_user = $this->session->userdata("id_account");
            $kode_reg = $this->session->userdata("kode_registrasi");

            $packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
            if ($packet->num_rows() < 1)
                    redirect('beranda');
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */