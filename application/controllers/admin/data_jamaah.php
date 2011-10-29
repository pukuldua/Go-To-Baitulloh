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
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$total_data 	= $this->jamaah_candidate_model->get_total_data();
		$total_data		= ''.$total_data ;
		
		$colModel['no'] 					= array('No',40,TRUE,'center',0);
		$colModel['KODE_REGISTRASI'] 		= array('Kode Registrasi',100,TRUE,'center',1);
		$colModel['NAMA_LENGKAP'] 			= array('Nama Lengkap',100,TRUE,'center',1);
		$colModel['GENDER'] 				= array('Gender',100,TRUE,'center',1);
		$colModel['KOTA'] 					= array('Kota',100,TRUE,'center',1);
		$colModel['ALAMAT'] 				= array('Alamat',100,TRUE,'center',1);
		$colModel['TELP'] 					= array('Telepon',100,TRUE,'center',1);
		$colModel['MOBILE'] 				= array('Handphone',100,TRUE,'center',1);
		$colModel['TANGGAL_ENTRI']			= array('Tanggal Entri',100,TRUE,'center',1);
		$colModel['STATUS_KANDIDAT']		= array('Status',100,TRUE,'center',1);
		
		$gridParams = array(
		'width' => 'auto',
		'height' => 300,
		'rp' => 10,
		'rpOptions' => '[5,10,15,20,25,30,'.$total_data.']',
		'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} hasil.',
		'blockOpacity' => 0.5,
		'title' => 'Data calon jamaah yang tercatat dalam sistem',
		'showTableToggleBtn' => false
		);
		
		$grid_js = build_grid_js('flex1',site_url("/admin/data_jamaah/grid_calon_jamaah/"),$colModel,'no','asc',$gridParams,null);
		$data['js_grid'] = $grid_js;
		
		$data['added_js'] = "";

		$data['content'] = $this->load->view('admin/data_jamaah',$data,true);
		$this->load->view('admin/front',$data);		
	}

	function grid_calon_jamaah() 
	{
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('jamaah_candidate_model');
		
		$valid_fields = array('KODE_REGISTRASI','NAMA_LENGKAP','GENDER','KOTA','ALAMAT','TELP','MOBILE','TANGGAL_ENTRI','STATUS_KANDIDAT');
		$this->flexigrid->validate_post('ID_ACCOUNT','desc',$valid_fields);
		
		$records = $this->jamaah_candidate_model->get_grid_allover_jamaah();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
                
		foreach ($records['records']->result() as $row)
		{
			if($row->GENDER == 1) $gender = "Laki-Laki";
			elseif($row->GENDER == 2) $gender = "Perempuan";
			
			if($row->STATUS_KANDIDAT == 1) $status = "Registered";
			elseif($row->STATUS_KANDIDAT == 2) $status = "Booked";
			elseif($row->STATUS_KANDIDAT == 3) $status = "Lunas";
			
			$record_items[] = array(
				$row->ID_CANDIDATE,
				$no = $no+1,
				$row->KODE_REGISTRASI,	
				$row->NAMA_LENGKAP,
				$gender,
				$row->KOTA,
				$row->ALAMAT,
				$row->TELP,
				$row->MOBILE,
				$row->TANGGAL_ENTRI,
				$status
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}
}//end class

/* End of file /admin/data_jamaah.php */
/* Location: ./application/controllers/admin/data_jamaah.php */