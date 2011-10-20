<?php 
class Province_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function get_all_province(){
		$this->db->select('*');
		$this->db->from('province');
		
		return $this->db->get();
	}
	
	function get_province($id){
		$this->db->select('*');
		$this->db->from('province');
		$this->db->where('ID_PROPINSI', $id);
		
		return $this->db->get();
	}
}

?>