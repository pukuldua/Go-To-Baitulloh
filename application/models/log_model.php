<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function log($id_acc = NULL, $kode_reg, $id_user2 = NULL, $log)
	{
		$datestring = "Y-m-d h:i:s";
		$time = time();
		$ip_addr = $this->input->ip_address();
		
		$data = array(
		   'ID_ACCOUNT' => $id_acc,
		   'KODE_REGISTRASI' => $kode_reg,
		   'ID_USER' => $id_user2,
		   'IP_KOMPUTER' => $ip_addr,
		   'CATATAN' => $log, 
		   'TANGGAL_LOG' => date($datestring,$time)
		);	
		$this->db->insert('log', $data);
	}
}

?>