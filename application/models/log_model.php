<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function log($log)
	{
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		$ip_addr = $this->input->ip_address();
		
		$data = array(
		   'IP_KOMPUTER' => $ip_addr,
		   'CATATAN' => $log, 
		   'TANGGAL_LOG' => mdate($datestring,$time)
		);	
		$this->db->insert('log', $data);
	}
}

?>