<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waiting_list extends CI_Controller {

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
		$this->load->model('payment_model');
		
		$total_data 	= $this->payment_model->get_total_data();
		$total_data		= ''.$total_data ;
		
		$colModel['no'] 					= array('No',30,TRUE,'center',0);
		$colModel['KODE_REGISTRASI'] 		= array('Kode Registrasi',110,TRUE,'center',0);
		$colModel['NAMA_USER'] 			= array('Nama User',100,TRUE,'center',1);
		$colModel['KOTA'] 					= array('Kota',80,TRUE,'center',1);
		$colModel['EMAIL'] 					= array('Email',150,TRUE,'center',1);
                $colModel['TELP'] 					= array('Telepon',80,TRUE,'center',0);
		$colModel['MOBILE'] 				= array('Handphone',80,TRUE,'center',0);
		$colModel['TANGGAL_PESAN']			= array('Tanggal Pesanan',100,TRUE,'center',1);
                $colModel['KODE_GROUP']			= array('Group',50,TRUE,'center',1);
                $colModel['NAMA_PROGRAM']			= array('Program',50,TRUE,'center',1);
                $colModel['JATUH_TEMPO_UANG_MUKA']			= array('Tgl Jatuh Tempo DP',100,TRUE,'center',1);
                $colModel['BATAS_WAITING_LIST']			= array('Tgl Batas WL',100,TRUE,'center',0);
                $colModel['JUMLAH_JAMAAH']			= array('Jumlah Jamaah',80,TRUE,'center',1);
		$colModel['STATUS']		= array('Status',80,TRUE,'center',1);
		
		$gridParams = array(
		'width' => '1190',
		'height' => 300,
		'rp' => 10,
		'rpOptions' => '[5,10,15,20,25,30,'.$total_data.']',
		'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} hasil.',
		'blockOpacity' => 0.5,
		'title' => 'Data Daftar Tunggu',
		'showTableToggleBtn' => false
		);
		
		$grid_js = build_grid_js('flex1',site_url("/admin/waiting_list/grid_tunggu/"),$colModel,'no','asc',$gridParams,null);
		$data['js_grid'] = $grid_js;
		
		$data['added_js'] = "";

		$data['content'] = $this->load->view('admin/data_pembayaran',$data,true);
		$this->load->view('admin/front',$data);		
	}

	function grid_tunggu()
	{
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('waiting_list_model');
		
		$valid_fields = array('a.KODE_REGISTRASI','NAMA_USER','EMAIL','KOTA','ALAMAT','TELP','MOBILE','TANGGAL_PESAN','STATUS',
                    'KODE_GROUP', 'BATAS_WAITING_LIST','JATUH_TEMPO_UANG_MUKA','NAMA_PROGRAM');
		$this->flexigrid->validate_post('a.ID_ACCOUNT','asc',$valid_fields);
		
		$records = $this->waiting_list_model->get_grid_waiting_list();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
                
		foreach ($records['records']->result() as $row)
		{
			// filter status
			if($row->STATUS == 0) 
				$status = "Registered";
			elseif($row->STATUS == 1) $status = "Activated";
                        $jumlah = $row->JUMLAH_ADULT+$row->CHILD_WITH_BED+$row->CHILD_NO_BED+$row->INFANT;
				
			// list grid payment
			$record_items[] = array(
				$row->ID_ACCOUNT,
				$no = $no+1,
				$row->KODE_REGISTRASI,	
				$row->NAMA_USER,
                            $row->KOTA, $row->EMAIL, $row->TELP, $row->MOBILE,
				date("d M Y", strtotime($row->TANGGAL_PESAN)),
                            $row->KODE_GROUP, $row->NAMA_PROGRAM, 
                            date("d M Y", strtotime($row->JATUH_TEMPO_UANG_MUKA)),
				date("d M Y", strtotime($row->BATAS_WAITING_LIST)),
                            $jumlah,
				$status
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}

        function delete_waiting_list($id_acc, $kode_reg){
            // delete room packet
            // delete packet
            // delete waiting list
            // send email
        }

        function send_email ($id_acc, $kode_reg, $jenis){
            $this->load->model('accounts_model');
            $this->load->model('packet_model');
            $this->load->model('room_packet_model');
            $this->load->model('waiting_list_model');

            $this->load->library('email');
            $this->load->library('parser');

            $config['protocol'] = 'mail';
            $config['mailtype'] = 'html';

            $this->email->initialize($config);

            $account = $this->accounts_model->get_account($id_acc, $kode_reg);
            if ($account->num_rows() > 0){
                $data['subject'] = 'Status Daftar Tunggu';
                $data['NAMA_USER'] = $account->row()->NAMA_USER;
                $data['KODE_REGISTRASI'] = $kode_reg;

                $packet = $this->packet_model->get_packet_byAcc_waiting($id_acc, $kode_reg);
                foreach ($packet->result() as $row){
                    $id_packet = $row->ID_PACKET;
                    $data['tanggal'] = date_format(date_create($row->TANGGAL_PESAN), "d M Y");
                    $data['group'] = $row->KODE_GROUP;
                    $data['program'] = $row->NAMA_PROGRAM;
                    $data['adult'] = $row->JUMLAH_ADULT;
                    $data['with_bed'] = $row->CHILD_WITH_BED;
                    $data['no_bed'] = $row->CHILD_NO_BED;
                    $data['infant'] = $row->INFANT;
                }

                $room = $this->room_packet_model->get_room_packet_byIDpack($id_packet);
                $data['room'] = $room->result();

                $jenis == 1 ? $view = "email_waiting_list":$view = "email_waiting_list2";
                $this->load->view($view,$data);
                $htmlMessage =  $this->parser->parse($view, $data, true);

                $this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
                $this->email->to($account->row()->EMAIL);

                $this->email->subject('Status Daftar Tunggu');
                $this->email->message($htmlMessage);

//                $this->email->send();
            }
        }
}//end class

/* End of file /admin/waiting_list.php */
/* Location: ./application/controllers/admin/waiting_list.php */