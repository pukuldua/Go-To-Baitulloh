<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_jamaah extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('id_user') == NULL)
			redirect(site_url()."/login");
	}

	function index()
	{
		$this->lihat();
	}
	
	function lihat()
	{
		$data['content'] = null;
		$this->load->view('admin/front',$data);
	}

}//end class

/* End of file /admin/beranda.php */
/* Location: ./application/controllers/admin/beranda.php */