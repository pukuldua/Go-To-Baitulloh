<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_login()
	{
		$this->db->select("ID_ACCOUNT, NAMA_USER_INTERNAL, EMAIL, PASSWORD");
		$this->db->from("accounts");
		
		return $this->db->get();
	}
}