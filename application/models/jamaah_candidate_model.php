<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jamaah_candidate_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_jamaah()
	{
		$this->db->select("*");
		$this->db->from("jamaah_candidate");
		
		return $this->db->get();
	}
	
	
	function insert_jamaah($data){
		$this->db->trans_begin();
		$this->db->insert('jamaah_candidate', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

}