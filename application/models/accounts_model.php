<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_login()
	{
		$this->db->select("ID_ACCOUNT, KODE_REGISTRASI, NAMA_USER, EMAIL, PASSWORD");
		$this->db->from("accounts");
		
		return $this->db->get();
	}
	
	function get_account_byKode($kode){
		$this->db->select("*");
		$this->db->from("accounts");
		$this->db->where("KODE_REGISTRASI", $kode);
		
		return $this->db->get();
	}
	
	function get_notification_info($kode){
		$this->db->select("*");
		$this->db->from("accounts");
		$this->db->join("province","province.ID_PROPINSI=accounts.ID_PROPINSI");
		$this->db->where("KODE_REGISTRASI", $kode);
		$this->db->where("STATUS", 0);
		
		return $this->db->get();
	}
	
	function insert_new_account($data){
		$this->db->trans_begin();
		$this->db->insert('accounts', $data);
		
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}
	
	function cek_forgot($email)
	{
		$this->db->select('KODE_REGISTRASI, NAMA_USER, EMAIL, PASSWORD');
		$this->db->from('accounts');
		$this->db->where('EMAIL', $email);
		
		return $this->db->get();
	}

	function get_data_account($id_account){
		$this->db->select('*');
		$this->db->from('accounts');
		$this->db->where('id_account',$id_account);
		
		return $this->db->get();

	function update_password($data,$email) 
	{                
		$this->db->where('EMAIL', $email);
		$this->db->update('accounts' , $data);
	}
}

?>
