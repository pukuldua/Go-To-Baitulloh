<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_class_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_program()
	{
		$this->db->select("*");
		$this->db->from("program_class");
		
		return $this->db->get();
	}
}

?>
