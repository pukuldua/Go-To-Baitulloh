<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canceled_candidate_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_canceled()
	{
		$this->db->select("*");
		$this->db->from("canceled_candidate");
		
		return $this->db->get();
	}
	
	function insert_canceled($data)
	{
		$this->db->insert('canceled_candidate', $data);
	}
	
	function get_data_canceled($id_account, $kode_reg)
	{
		$this->db->select("*");
		$this->db->from("canceled_candidate");
		$this->db->where('ID_ACCOUNT', $id_account);
		$this->db->where('KODE_REGISTRASI', $kode_reg);
		
		return $this->db->get();
	}
	
}

?>