<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internal_users_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_login()
	{
		$this->db->select("*");
		$this->db->from("internal_users");
		
		return $this->db->get();
	}
}

?>
