<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Booked_room_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_booked_room()
	{
		$this->db->select("*");
		$this->db->from("booked_room");
		
		return $this->db->get();
	}
	
	function get_booked_room($id){
		$this->db->select("*");
		$this->db->from("booked_room");
		$this->db->where("ID_BOOKED", $id);
		
		return $this->db->get();
	}

        function get_all_booked_candidate($id_acc, $kode_reg){
		$this->db->select("br.*, j.*, r.KODE_KAMAR, rt.JENIS_KAMAR");
		$this->db->from("booked_room br");
		$this->db->join("jamaah_candidate j", "j.ID_CANDIDATE = br.ID_CANDIDATE");
                $this->db->join("packet p", "p.ID_ACCOUNT = j.ID_ACCOUNT AND p.KODE_REGISTRASI = j.KODE_REGISTRASI");
		$this->db->join("room r", "r.ID_ROOM = br.ID_ROOM");
                $this->db->join("room_type rt", "rt.ID_ROOM_TYPE = r.ID_ROOM_TYPE");
		$this->db->where("j.ID_ACCOUNT", $id_acc);
		$this->db->where("j.KODE_REGISTRASI", $kode_reg);
		$this->db->where("p.STATUS_PESANAN", 3);

		return $this->db->get();
	}
	
	function get_booked_candidate($id_acc, $kode_reg, $id_room){
		$this->db->select("br.*, j.*, r.KODE_KAMAR");
		$this->db->from("booked_room br");
		$this->db->join("jamaah_candidate j", "j.ID_CANDIDATE = br.ID_CANDIDATE");
                $this->db->join("packet p", "p.ID_ACCOUNT = j.ID_ACCOUNT AND p.KODE_REGISTRASI = j.KODE_REGISTRASI");
		$this->db->join("room r", "r.ID_ROOM = br.ID_ROOM");
		$this->db->where("j.ID_ACCOUNT", $id_acc);
		$this->db->where("j.KODE_REGISTRASI", $kode_reg);
                $this->db->where("br.ID_ROOM", $id_room);
		$this->db->where("p.STATUS_PESANAN", 3);
		
		return $this->db->get();
	}

        function get_already_booked($id_acc, $kode_reg){
		$this->db->select("br.*");
		$this->db->from("booked_room br");
		$this->db->join("jamaah_candidate j", "j.ID_CANDIDATE = br.ID_CANDIDATE");
                $this->db->join("packet p", "p.ID_ACCOUNT = j.ID_ACCOUNT AND p.KODE_REGISTRASI = j.KODE_REGISTRASI");
		$this->db->where("j.ID_ACCOUNT", $id_acc);
		$this->db->where("j.KODE_REGISTRASI", $kode_reg);
		$this->db->where("p.STATUS_PESANAN", 3);

		return $this->db->get();
	}
	
	function insert_booked_room($data){
		$this->db->trans_begin();
		$this->db->insert('booked_room', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
}

?>
