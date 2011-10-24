<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relation_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_relation()
	{
		$this->db->select("*");
		$this->db->from("relation");
		
		return $this->db->get();
	}

}