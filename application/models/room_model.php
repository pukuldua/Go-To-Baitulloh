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
	
	function check_available_room($group, $program, $room_type){
		$this->db->select("*");
		$this->db->from("room"); 	 	
		$this->db->where("ID_GROUP", $group);
		$this->db->where("ID_PROGRAM", $program);
		$this->db->where("ID_ROOM_TYPE", $room_type);
		$this->db->where("AVAILABILITY", 1);
		
		return $this->db->get();
	}
	
	function count_available_room($group, $program, $room_type){
		$this->db->select("room.*, room_type.JENIS_KAMAR, count(*) as JML");
		$this->db->from("room"); 	 	
		$this->db->where("ID_GROUP", $group);
		$this->db->where("ID_PROGRAM", $program);
		$this->db->where("ID_ROOM_TYPE", $room_type);
		$this->db->where("AVAILABILITY", 1);
		$this->db->join("room_type", "room_type.ID_ROOM_TYPE=room.ID_ROOM_TYPE");
		
		return $this->db->get();
	}
}

?>
