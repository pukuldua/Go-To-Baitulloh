<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_jamaah()
	{
		$this->db->select("*");
		$this->db->from("payment");
		
		return $this->db->get();
	}
	
	
	function insert_payment($data){
		$this->db->trans_begin();
		$this->db->insert('payment', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
	
}

?>
