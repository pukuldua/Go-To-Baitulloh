<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->CI = get_instance();
	}
	
	function get_all_payment()
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
	
	
	function get_grid_all_payment()
	{
		$this->db->select('*');
		$this->db->from('payment_view');	
		$this->CI->flexigrid->build_query();
		$return['records'] = $this->db->get();
		
		$this->db->select('count(ID_PAYMENT) as record_count')->from('payment_view');
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		$return['record_count'] = $row->record_count;
	
		return $return;
	}
	
	function get_total_data(){
		$query = $this->db->count_all('payment');
		return $query;			
	}
	
	function get_all_payment_ByID($id_payment, $jenis_pembayaran)
	{
		$this->db->select("*");
		$this->db->from("payment");
		$this->db->where("ID_PAYMENT", $id_payment);
		$this->db->where("JENIS_PEMBAYARAN", $jenis_pembayaran);
		
		return $this->db->get();
	}
	
	
	function update_payment($data, $id_payment){
		$this->db->trans_begin();
		$this->db->where('ID_PAYMENT', $id_payment);
		$this->db->update('payment', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
	
	
	function query_payment($data)
	{
		return $this->db->query($data);
	}
	
	function get_payment_byAcc_complete($id_acc, $kode_reg){
        $status = array(1);
        $this->db->select("*");
		$this->db->from("payment");
		$this->db->where("ID_ACCOUNT", $id_acc);
		$this->db->where("KODE_REGISTRASI", $kode_reg);
		$this->db->where_in("STATUS", $status);

		return $this->db->get();
	}
	
}

?>
