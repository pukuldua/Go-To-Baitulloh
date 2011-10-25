<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packet_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_packet()
	{
		$this->db->select("*");
		$this->db->from("packet");
		
		return $this->db->get();
	}
	
	function get_packet($id){
		$this->db->select("*");
		$this->db->from("packet");
		$this->db->where("ID_PACKET", $id);
		
		return $this->db->get();
	}
	
	function get_packet_byAcc($id_acc, $kode_reg){
		$this->db->select("packet.*, g.KODE_GROUP, p.NAMA_PROGRAM");
		$this->db->from("packet");
                $this->db->join("group_departure g","g.ID_GROUP = packet.ID_GROUP");
                $this->db->join("program_class p", "p.ID_PROGRAM = packet.ID_PROGRAM");
		$this->db->where("ID_ACCOUNT", $id_acc);
		$this->db->where("KODE_REGISTRASI", $kode_reg);
		$this->db->where("STATUS_PESANAN ", 1);
		
		return $this->db->get();
	}
	
	function insert_packet($data){
		$this->db->trans_begin();
		$this->db->insert('packet', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
}

?>
