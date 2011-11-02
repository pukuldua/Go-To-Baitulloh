<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_departure_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_group()
	{
		$this->db->select("*");
		$this->db->from("group_departure");
		
		return $this->db->get();
	}
	
	function get_group($id_group){
		$this->db->select("*");
		$this->db->from("group_departure");
		$this->db->where("ID_GROUP", $id_group);
		
		return $this->db->get();
	}
	
	function get_group_berdasarkan_id($id_group)
	{
		$this->db->select("*");
		$this->db->from("group_departure");
		$this->db->where('ID_GROUP', $id_group);
		
		return $this->db->get();
	}
	
	function update_group($id, $data){
		$this->db->trans_begin();
                $this->db->where("ID_GROUP", $id);
		$this->db->update('group_departure', $data);

		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
}

?>
