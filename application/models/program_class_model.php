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
	
	function get_program($id){
		$this->db->select("*");
		$this->db->from("program_class");
		$this->db->where("ID_PROGRAM", $id);
		
		return $this->db->get();
	}
}

?>
