<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clothes_size_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_all_clothes()
	{
		$this->db->select("*");
		$this->db->from("clothes_size");
		
		return $this->db->get();
	}

}