<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_type_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_roomType()
	{
		$this->db->select("*");
		$this->db->from("room_type");
		
		return $this->db->get();
	}
}

?>
