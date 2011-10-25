<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooming extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$this->load->model('room_model');
                $this->load->model('room_type_model');
		$this->load->model('packet_model');
		$this->load->model('room_packet_model');
                $this->load->model('jamaah_candidate_model');
		
		$id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");
		$room_options['0'] = '-- Pilih Kamar --';
		
		$data_packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
                $candidate = $this->jamaah_candidate_model->get_jamaah_notBooked_room($id_user, $kode_reg);
		
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
		
		$data['room_options'] = $room_options;

                if($candidate->num_rows() > 0){
                    foreach($candidate->result() as $row){
                        $list_candidate[$row->ID_CANDIDATE] = $row->NAMA_LENGKAP;
                    }
                    $data['list_candidate'] = $list_candidate;
                }
		
		$data['content'] = $this->load->view('form_rooming',$data,true);
		//$this->load->view('form_rooming',null,false);
		$this->load->view('front',$data);
	}

	function book_room()
	{
		$data = $this->input->post('fourthSelect');
		print_r($data);
	}

        function getJamaah(){
            if ($_POST['id_room']!=''){
		$this->load->model('booked_room_model');

                $id_room = $_POST['id_room'];
                $id_acc = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");
                
		$list = '<ul class="greyarrow">';
		$room = $this->booked_room_model->get_booked_candidate($id_acc, $kode_reg, $id_room);
		if ($room->num_rows() > 0){
                    foreach ($room->result() as $rs){
                            $list.= '<li>'.$rs->NAMA_LENGKAP." - ".$rs->KOTA.'</li>';
                    }
                    echo $list.'</ul>';
                } else echo "";
            } else echo '';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */