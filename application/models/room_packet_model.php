<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_packet_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_room_packet()
	{
		$this->db->select("*");
		$this->db->from("room_packet");
		
		return $this->db->get();
	}
	
	function get_room_packet($id){
		$this->db->select("*");
		$this->db->from("room_packet");
		$this->db->where("ID_ROOM_PACKET", $id);
		
		return $this->db->get();
	}
	
	function get_room_packet_byIDpack($id){
		$this->db->select("*");
		$this->db->from("room_packet");
                $this->db->join("room_type rt","rt.ID_ROOM_TYPE = room_packet.ID_ROOM_TYPE");
		$this->db->where("ID_PACKET", $id);
		
		return $this->db->get();
	}
	
	function insert_room_packet($data){
		$this->db->trans_begin();
		$this->db->insert('room_packet', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

        function delete_data_bypacket($id){
            $this->db->where("ID_PACKET", $id);
            $this->db->delete("room_packet");
        }
}

?>
