<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waiting_list_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_waiting()
	{
		$this->db->select("*");
		$this->db->from("waiting_list");
		
		return $this->db->get();
	}
	
	function get_waiting($id){
		$this->db->select("*");
		$this->db->from("waiting_list");
		$this->db->where("ID_WAITING_LIST", $id);
		
		return $this->db->get();
	}

        function get_waiting_byKode($kode){
		$this->db->select("*");
		$this->db->from("waiting_list");
		$this->db->where("KODE_REGISTRASI", $kode);

		return $this->db->get();
	}
	
	function insert_waiting_list($data){
		$this->db->trans_begin();
		$this->db->insert('waiting_list', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
}

?>
