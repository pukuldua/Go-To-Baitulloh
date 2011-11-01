<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_room()
	{
		$this->db->select("*");
		$this->db->from("room");
		
		return $this->db->get();
	}
	
	function get_room($id){
		$this->db->select("*");
		$this->db->from("room");
		$this->db->where("ID_ROOM", $id);
		
		return $this->db->get();
	}

        function update_room($id, $data){
		$this->db->trans_begin();
                $this->db->where("ID_ROOM", $id);
		$this->db->update('room', $data);

		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
	
	function check_available_room($group, $program, $room_type, $beds){
		$this->db->select("*");
		$this->db->from("room"); 	 	
		$this->db->where("ID_GROUP", $group);
		$this->db->where("ID_PROGRAM", $program);
		$this->db->where("ID_ROOM_TYPE", $room_type);
		$this->db->where("AVAILABILITY", 1);
		
		if ($beds == 0)
			$this->db->where("BEDS >", $beds);
		else
			$this->db->where("BEDS", $beds);
		
		return $this->db->get();
	}
	
	function count_available_room($group){
		$this->db->select("room.*, g.KODE_GROUP, p.NAMA_PROGRAM, room_type.JENIS_KAMAR, count(*) as JML, sum(BEDS) as JML_BEDS");
		$this->db->from("room"); 	 	
		$this->db->where("room.ID_GROUP", $group);
		//$this->db->where("room.ID_PROGRAM", $program);
		$this->db->where("AVAILABILITY", 1);
		$this->db->join("group_departure g", "g.ID_GROUP=room.ID_GROUP");
		$this->db->join("program_class p", "p.ID_PROGRAM=room.ID_PROGRAM");
		$this->db->join("room_type", "room_type.ID_ROOM_TYPE=room.ID_ROOM_TYPE");
		$this->db->group_by("room.ID_PROGRAM, ID_ROOM_TYPE"); 
		
		return $this->db->get();
	}
	
	function count_available_beds($group){
		$this->db->select("room.*, sum(BEDS) as JML_BEDS");
		$this->db->from("room"); 	 	
		$this->db->where("room.ID_GROUP", $group);
		$this->db->where("AVAILABILITY", 1);
                $this->db->group_by("room.ID_GROUP");
		
		return $this->db->get();
	}
}

?>
