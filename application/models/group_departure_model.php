<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_departure_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_group()
	{
		$this->db->select("*");
		$this->db->from("group_departure");
		
		return $this->db->get();
	}
}

?>
