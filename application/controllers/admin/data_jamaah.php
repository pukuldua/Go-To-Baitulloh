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
		
		$total_data 	= $this->jamaah_candidate_model->get_total_data_aktif();
		$total_data		= ''.$total_data ;
		
		$colModel['no'] 					= array('No',40,TRUE,'center',0);
		$colModel['KODE_REGISTRASI'] 		= array('Kode Registrasi',100,TRUE,'center',0);
		$colModel['NAMA_USER'] 				= array('Nama Registrasi',100,TRUE,'center',1);
		$colModel['GROUP'] 					= array('Group',60,FALSE,'center',0);
		$colModel['NAMA_LENGKAP'] 			= array('Nama Calon',100,TRUE,'center',1);
		$colModel['JENIS_KELAMIN'] 			= array('Gender',80,TRUE,'center',1);
		$colModel['KOTA'] 					= array('Kota',80,TRUE,'center',1);
		$colModel['ALAMAT'] 				= array('Alamat',110,TRUE,'center',1);
		$colModel['TELP'] 					= array('Telepon',90,TRUE,'center',1);
		$colModel['MOBILE'] 				= array('Handphone',90,TRUE,'center',1);
		$colModel['TANGGAL_ENTRI']			= array('Tanggal Entri',75,TRUE,'center',0);
		$colModel['STATUS_JAMAAH']			= array('Status',75,TRUE,'center',1);
		$colModel['DATA_PASPOR']			= array('Paspor',40,FALSE,'center',0);
		
		$gridParams = array(
		'width' => '1190',
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
		$this->load->model('packet_model');
		$this->load->model('group_departure_model');
		
		$valid_fields = array('KODE_REGISTRASI','NAMA_USER','NAMA_LENGKAP','JENIS_KELAMIN','KOTA','ALAMAT','TELP','MOBILE','TANGGAL_ENTRI','STATUS_JAMAAH');
		$this->flexigrid->validate_post('ID_ACCOUNT','desc',$valid_fields);
		
		$records = $this->jamaah_candidate_model->get_grid_allover_jamaah2();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
                
		foreach ($records['records']->result() as $row)
		{
			$data_packet = $this->packet_model->get_packet_byAccAll($row->ID_ACCOUNT, $row->KODE_REGISTRASI);
			if($data_packet->result() != NULL)
			{
				foreach($data_packet->result() as $rows)
				{
					$id_group = $rows->ID_GROUP;
				}
			}else{
				$id_group = NULL;
			}
			
			$data_group = $this->group_departure_model->get_group_berdasarkan_id($id_group);
			if($data_packet->result() != NULL)
			{
				foreach($data_group->result() as $rows)
				{
					$kode_group = $rows->KODE_GROUP;
				}
			}else{
				$kode_group = "";
			}		
			
			$url_paspor = '<a style="cursor:pointer" onClick="window.open(\''.site_url().'/admin/data_jamaah/paspor_view/'.$row->ID_CANDIDATE.'/'.$row->KODE_REGISTRASI.'\',\'paspor\',\'width=600,height=210,left=400,top=100,screenX=400,screenY=100\')"><img src="'.base_url().'/images/flexigrid/book.png"></a>';
			
			$record_items[] = array(
				$row->ID_CANDIDATE,
				$no = $no+1,
				$row->KODE_REGISTRASI,
				$row->NAMA_USER,	
				$kode_group,
				$row->NAMA_LENGKAP,
				$row->JENIS_KELAMIN,
				$row->KOTA,
				$row->ALAMAT,
				$row->TELP,
				$row->MOBILE,
				date("d M Y", strtotime($row->TANGGAL_ENTRI)),
				$row->STATUS_JAMAAH,
				$url_paspor
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}
	
	function paspor_view($id_candidate, $kode_reg)
	{
		$this->load->model('jamaah_candidate_model');
		$this->load->model('packet_model');
		$this->load->model('group_departure_model');
		
		$data_jamaah = $this->jamaah_candidate_model->get_profile_view($id_candidate, $kode_reg);
		if($data_jamaah->result() != NULL)
		{
			foreach($data_jamaah->result() as $row)
			{
				$data_packet = $this->packet_model->get_packet_byAccAll($row->ID_ACCOUNT, $row->KODE_REGISTRASI);
				if($data_packet->result() != NULL)
				{
					foreach($data_packet->result() as $rows)
					{
						$id_group = $rows->ID_GROUP;
					}
				}else{
					$id_group = NULL;
				}
				
				$data_group = $this->group_departure_model->get_group_berdasarkan_id($id_group);
				if($data_packet->result() != NULL)
				{
					foreach($data_group->result() as $rows)
					{
						$data['kode_group'] = $rows->KODE_GROUP;
					}
				}else{
					$data['kode_group'] = NULL;
				}	
				
				$data['nama_jamaah'] = $row->NAMA_LENGKAP;
				$data['tempat_lahir'] = $row->TEMPAT_LAHIR;
				$data['tgl_lahir'] = $row->TANGGAL_LAHIR;
				$data['jenkel'] = $row->JENIS_KELAMIN;
				$data['no_paspor'] = $row->NO_PASPOR;
				$data['tgl_dikeluarkan'] = $row->TANGGAL_DIKELUARKAN;
				$data['tgl_habis'] = $row->TANGGAL_HABIS;
				$data['kantor'] = $row->KANTOR_PEMBUATAN;
				$data['scan_paspor'] = $row->SCAN_PASPOR;
			}
		}
		
		$this->load->view('window_paspor', $data, '');
	}
}//end class

/* End of file /admin/data_jamaah.php */
/* Location: ./application/controllers/admin/data_jamaah.php */