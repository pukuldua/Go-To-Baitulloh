<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waiting_list_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
                $this->CI = get_instance();
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

        function get_grid_waiting_list(){
            $this->db->select('*');
            $this->db->from('accounts a');
            $this->db->join('waiting_list w','w.ID_ACCOUNT = a.ID_ACCOUNT AND w.KODE_REGISTRASI = a.KODE_REGISTRASI');
            $this->db->join('packet p','p.ID_ACCOUNT = a.ID_ACCOUNT AND p.KODE_REGISTRASI = a.KODE_REGISTRASI');
            $this->db->join('group_departure g','g.ID_GROUP = p.ID_GROUP');
            $this->db->join('program_class c','c.ID_PROGRAM = p.ID_PROGRAM');
            $this->db->where('STATUS_PESANAN', 2);

            $this->CI->flexigrid->build_query();
            $return['records'] = $this->db->get();

            $this->db->select('*');
            $this->db->from('accounts a');
            $this->db->join('waiting_list w','w.ID_ACCOUNT = a.ID_ACCOUNT AND w.KODE_REGISTRASI = a.KODE_REGISTRASI');
            $this->db->join('packet p','p.ID_ACCOUNT = a.ID_ACCOUNT AND p.KODE_REGISTRASI = a.KODE_REGISTRASI');
            $this->db->join('group_departure g','g.ID_GROUP = p.ID_GROUP');
            $this->db->join('program_class c','c.ID_PROGRAM = p.ID_PROGRAM');
            $this->db->where('STATUS_PESANAN', 2);
            $this->CI->flexigrid->build_query(FALSE);
            $return['record_count'] = $this->db->count_all_results();

            return $return;
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
