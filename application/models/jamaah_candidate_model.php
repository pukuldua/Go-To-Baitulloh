<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jamaah_candidate_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->CI = get_instance();
	}
	
	function get_all_jamaah()
	{
		$this->db->select("*");
		$this->db->from("jamaah_candidate");
		
		return $this->db->get();
	}
	
	function get_grid_all_jamaah($kode_reg, $id_account)
	{
		$this->db->select('*');
		$this->db->from('jamaah_candidate');
		$this->db->where('KODE_REGISTRASI', $kode_reg );
		$this->db->where('ID_ACCOUNT', $id_account);
		
		$this->CI->flexigrid->build_query();
		
		$return['records'] = $this->db->get();
		$this->db->select('count(ID_CANDIDATE) as record_count')->from('jamaah_candidate');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		$return['record_count'] = $row->record_count;
	
		return $return;
	}
	
	function get_total_data(){
		$query = $this->db->count_all('jamaah_candidate');
		return $query;			
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