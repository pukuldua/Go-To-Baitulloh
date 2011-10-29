<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('id_user') == NULL)
			redirect(site_url()."/login");
	}

	function index()
	{
		redirect('admin/data_jamaah');
	}

}//end class

/* End of file /admin/beranda.php */
/* Location: ./application/controllers/admin/beranda.php */