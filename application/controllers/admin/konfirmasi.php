<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {

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
		
		$colModel['no'] 					= array('No',40,TRUE,'center',0);
		$colModel['KODE_REGISTRASI'] 		= array('Kode Registrasi',110,TRUE,'center',0);
		$colModel['ATAS_NAMA'] 				= array('Rek . Atas Nama',110,TRUE,'center',1);
		$colModel['BANK_PENGIRIM'] 			= array('Bank Pengirim',100,TRUE,'center',1);
		$colModel['JUMLAH_KAMAR'] 			= array('Jumlah Transfer',100,TRUE,'center',1);
		$colModel['TANGGAL_TRANSFER'] 		= array('Tanggal Transfer',100,FALSE,'center',0);
		$colModel['BUKTI TRANSFER'] 		= array('Scan Bukti',70,FALSE,'center',0);
		$colModel['CATATAN'] 				= array('Catatan',150,FALSE,'center',1);
		$colModel['TIPE_PEMBAYARAN'] 		= array('Jenis Pembayaran',100,TRUE,'center',1);
		$colModel['TANGGAL_ENTRI']		 	= array('Tgl. Entri',100,FALSE,'center',0);
		$colModel['TIPE_STATUS']			= array('Status',80,FALSE,'center',1);
		
		$gridParams = array(
		'width' => '1190',
		'height' => 300,
		'rp' => 10,
		'rpOptions' => '[5,10,15,20,25,30,'.$total_data.']',
		'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} hasil.',
		'blockOpacity' => 0.5,
		'title' => 'Data Konfirmasi Pembayaran',
		'showTableToggleBtn' => false
		);
		
		$grid_js = build_grid_js('flex1',site_url("/admin/konfirmasi/grid_payment/"),$colModel,'no','asc',$gridParams,null);
		$data['js_grid'] = $grid_js;
		
		$data['added_js'] = "";

		$data['content'] = $this->load->view('admin/data_pembayaran',$data,true);
		$this->load->view('admin/front',$data);		
	}

	function grid_payment() 
	{
		
		//call library or helper
		$this->load->library('flexigrid');	
		$this->load->helper('flexigrid');
		$this->load->library('form_validation');		
		
		//call model here	
		$this->load->model('payment_model');
		
		$valid_fields = array('ATAS_NAMA','BANK_PENGIRIM','JUMLAH_KAMAR', 'CATATAN','TIPE_PEMBAYARAN','TIPE_STATUS');
		$this->flexigrid->validate_post('ID_PAYMENT','desc',$valid_fields);
		
		$records = $this->payment_model->get_grid_all_payment();
		$this->output->set_header($this->config->item('json_header'));
		
		$no = 0;
                
		foreach ($records['records']->result() as $row)
		{
			// filter status
			if($row->STATUS == 0) 
			{
				$status = "<a style='cursor:pointer;' onclick=javascript:show_confirm('".site_url()."/admin/konfirmasi/cek_status/".$row->ID_PAYMENT."/".$row->JENIS_PEMBAYARAN."')><font color=\"red\">".$row->TIPE_STATUS."</a></font>";
			}
			elseif($row->STATUS == 1) $status = "<font color=\"green\">".$row->TIPE_STATUS."</font>";
			
			
			// view bukti transfer
			$file = './images/upload/bukti_transfer/'.$row->BUKTI_TRANSFER;
			if(is_file($file)) 
			{ 
				$gambar = '<a href="'.base_url().'/images/upload/bukti_transfer/'.$row->BUKTI_TRANSFER.'"><img src="'.base_url().'/images/flexigrid/book.png"></a>'; 
			
			} else { $gambar = "-"; }
			
			
			// filter catatan
			if($row->CATATAN == 0) { $catatan = "-"; }
			  else { $catatan = $row->CATATAN; }
			  
			
			// cek format jumlah dolar
			$jumlah = $this->cek_ribuan($row->JUMLAH_KAMAR)." $";
			
		
			// list grid payment
			$record_items[] = array(
				$row->ID_PAYMENT,
				$no = $no+1,
				$row->KODE_REGISTRASI,	
				$row->ATAS_NAMA,
				$row->BANK_PENGIRIM,
				$jumlah,
				date("d M Y", strtotime($row->TANGGAL_TRANSFER)),
				$gambar,
				$catatan,
				$row->TIPE_PEMBAYARAN,
				date("d M Y", strtotime($row->TANGGAL_ENTRI)),
				$status
			);
		}
		
		if(isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');			
	}
	
	
	function cek_status($id_payment, $jenis_pembayaran)
	{
		$this->load->model('payment_model');
		$this->load->model('jamaah_candidate_model');
		
		$data_payment = $this->payment_model->get_all_payment_ByID($id_payment, $jenis_pembayaran);
		
		if($data_payment != NULL)
		{
			foreach($data_payment->result() as $row)
			{
				$id_user_a = $row->ID_ACCOUNT;
				$kode_reg_a = $row->KODE_REGISTRASI;
				
				// UPDATE STATUS PAYMENT MENJADI APPROVED
				$data_pay = array('STATUS' => 1); 
				$this->payment_model->update_payment($data_pay, $row->ID_PAYMENT);
				
				
				$data_candidate = $this->jamaah_candidate_model->get_total_jamaah($id_user_a, $kode_reg_a);
				foreach($data_candidate->result() as $rows)
				{
					// UPDATE STATUS JAMAAH CANDIDATE
					if($jenis_pembayaran == 1) { $tipe_status = 2; }
					 elseif($jenis_pembayaran == 2) { $tipe_status = 3; }
					
					$data_update = array('STATUS_KANDIDAT' => $tipe_status ); 
					$this->jamaah_candidate_model->update_jamaah($data_update, $rows->ID_CANDIDATE);
				}
			}
			
			redirect(site_url()."/admin/konfirmasi");
			
		} else {
				echo "<script>alert('Data Tidak Valid');window.location='".site_url()."/admin/konfirmasi';</script>";
			}
	}
	
	
	function cek_ribuan($txt)
	{
		$pecah = number_format($txt);
		$ubah = str_replace(",", ".", $pecah);
		
		return $ubah;
	}
}//end class

/* End of file /admin/konfirmasi.php */
/* Location: ./application/controllers/admin/konfirmasi.php */