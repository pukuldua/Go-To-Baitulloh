<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_availability_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_room()
	{
		$this->db->select("*");
		$this->db->from("room_availability");
		
		return $this->db->get();
	}
	
	function get_price_room($id_room, $id_program, $id_group){
		$this->db->select("*");
		$this->db->from("room_availability");
		$this->db->where("ID_ROOM_TYPE", $id_room);
		$this->db->where("ID_PROGRAM", $id_program);
		$this->db->where("ID_GROUP", $id_group);
		
		return $this->db->get();
	}

}

?>
