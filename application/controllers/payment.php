<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('email') == NULL)
			redirect(site_url()."/login");
	}

	function index()
	{
		$this->front();
	}
	
	function front()
	{
		// LOAD LIBRARY, SESSION DAN MODEL
		$this->load->library('form_validation');
		$this->load->model('packet_model');
		$this->load->model('room_packet_model');
		$this->load->model('room_type_model');
		$this->load->model('room_availability_model');
		$this->load->model('jamaah_candidate_model');
		
		$id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");
		
		
		// PROSES QUERY
		$data_packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
		$data_jamaah = $this->jamaah_candidate_model->query_jamaah("select * from jamaah_candidate where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND REQUESTED_NAMA != '0' AND REQUESTED_NAMA != ''");
		$data_jamaah_maningtis = $this->jamaah_candidate_model->query_jamaah("select * from jamaah_candidate where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND JASA_TAMBAHAN != '0'");
		
		
		// CARI TOTAL PEMAKAI JASA NAMA PASPOR
		if($data_jamaah->num_rows() > 0)
		{
			$data['hitung_jasa_nama'] = $data_jamaah->num_rows();
		}else {
			$data['hitung_jasa_nama'] = 0;
		}
		
		$data['hitung_total'] = 20 * $data['hitung_jasa_nama'];
		
		
		// CARI TOTAL PENGGUNA JASA MANINGTIS
		if($data_jamaah_maningtis->num_rows() > 0)
		{
			$data['hitung_jasa_maningtis'] = $data_jamaah_maningtis->num_rows();
		}else {
			$data['hitung_jasa_maningtis'] = 0;
		}
		
		$data['hitung_total_maningtis'] = 20 * $data['hitung_jasa_maningtis'];
		
		
		// LOOPING PILIHAN PAKET 
		$data['row_price'] = '';
		$data['biaya_harga_kamar'] = 0;
		
		if($data_packet->result() != NULL)
		{
			foreach($data_packet->result() as $row)
			{
				$data['nama_group'] = $row->KODE_GROUP;
				$data['nama_program'] = $row->NAMA_PROGRAM;
				$data['cwb'] = $row->CHILD_WITH_BED;
				$data['cnb'] = $row->CHILD_NO_BED;
				$data['infant'] = $row->INFANT;
				$data['id_packet'] = $row->ID_PACKET;
				$id_program = $row->ID_PROGRAM;
				$id_group = $row->ID_GROUP;
				
				// CARI ID ROOM PACKET
				$data_room_packet = $this->room_packet_model->get_room_packet_byIDpack($data['id_packet']);
				foreach($data_room_packet->result() as $rows)
				{
					$id_room_type = $rows->ID_ROOM_PACKET;
					$data['jumlah_kamar'] = $rows->JUMLAH;
				}
				
				// CARI DATA ROOM TYPE
				$data_room_type = $this->room_type_model->get_roomType($id_room_type);
				foreach($data_room_type->result() as $rowss)
				{
					$data['tipe_kamar'] = $rowss->JENIS_KAMAR;
				}
				
				
				// CARI HARGA KAMAR
				$data_kamar_siap = $this->room_availability_model->get_price_room($id_room_type, $id_program, $id_group);
				foreach($data_kamar_siap->result() as $rowss)
				{
					$data['harga_kamar'] = $rowss->HARGA_KAMAR;
				}
				
				$data['total_harga_kamar'] = $data['harga_kamar'] * $data['jumlah_kamar'];
				$data['biaya_harga_kamar'] += $data['total_harga_kamar'];
				
				
				$data['row_price'] .= '	<tr height="30">
											<td align="right" class="front_price_no_border">
											<h4>'.$data['nama_group'].' - '.$data['nama_program'].' - '.$data['tipe_kamar'].'</td>
											<td align="center"><h4>'.$this->cek_ribuan($data['harga_kamar']).' $</h4></td>
											<td align="center">'.$data['jumlah_kamar'].'</td>
											<td align="center"><h4>'.$this->cek_ribuan($data['total_harga_kamar']).' $</h4></td>
										</tr>';
			}
		}
		
		$data['total_biaya'] = $data['hitung_total'] + $data['hitung_total_maningtis'] + $data['biaya_harga_kamar'];
		$data['total_pelunasan'] = $this->cek_ribuan($data['total_biaya'] - 1100);
		$data['total_biaya2'] = $this->cek_ribuan($data['total_biaya']);
					
		$data['notifikasi'] = null;
		
		if($this->session->userdata('sukses') == 'true'){
			$data['notifikasi'] = '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">Konfirmasi pembayaran berhasil. Periksa Email Anda </td>
						<td class="green-right"><a class="close-green"><img src="'.base_url().'images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
				</table><br>
			</div>';
			$this->session->unset_userdata('sukses');
		}
				
		$data['content'] = $this->load->view('form_payment',$data,true);
		$this->load->view('front',$data);
	}
	
	function do_send()
	{
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('parser');
		
		$this->load->model('payment_model');
		$this->load->model('log_model');
		
		$log = "Melakukan Konfirmasi pembayaran";
		
		if ($this->cek_validasi() == FALSE){
			$this->front();
		}
		else{
			
			// cek foto
			$cek_foto = $_FILES['foto']['name'];
			if($cek_foto != "")
			{
				// Upload Foto
				$config['upload_path'] = './images/upload/bukti_transfer/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('foto'))
				{
					$error = $this->upload->display_errors();
					echo "<script>alert('".$this->input->post('foto')."');window.location='javascript:history.back()';</script>";
					exit;
				
				}else{
					$data_file = $this->upload->data();
				}
				
				$bukti = $data_file['file_name'];
			
			} else {
				$bukti = NULL;
			}

			// update table
			$id_user = $this->session->userdata("id_account");
			$kode_reg = $this->session->userdata("kode_registrasi");
			
			$nama_rekening = $this->input->post('nama_rekening');
			$tgl_transfer = $this->input->post('tgl_transfer');
			$bank_pengirim = $this->input->post('bank');
			$jumlah = $this->input->post('nominal');
			$metode = $this->input->post('metode');
			$catatan = $this->input->post('catatan');
			
			// filter tanggal transfer
			$pecah_tanggal = explode("/", $tgl_transfer);
			$tgl_transfer_fix = $pecah_tanggal[2]."-".$pecah_tanggal[1]."-".$pecah_tanggal[0];
			
			$data = array(
				'ID_ACCOUNT' => $id_user,
				'KODE_REGISTRASI' => $kode_reg,
				'JENIS_PEMBAYARAN' => $metode,
				'ATAS_NAMA' => $nama_rekening,
				'BANK_PENGIRIM' => $bank_pengirim,
				'TANGGAL_TRANSFER' => $tgl_transfer_fix,
				'JUMLAH_KAMAR' => $jumlah,
				'BUKTI_TRANSFER' => $bukti,
				'CATATAN' => $catatan,
				'STATUS' => 0,
				'TANGGAL_ENTRI' => date("Y-m-d H:i:s"),
				'TANGGAL_UPDATE' => date("Y-m-d H:i:s")
				);
			
			// KIRIM EMAIL PEMBERITAHUAN
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
	
			$this->email->initialize($config);
			
			$htmlMessage =  $this->parser->parse('email_konfirmasi', $data, true);
			$data['subject'] = "Konfirmasi Pembayaran";
			
			$this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
			$this->email->to('nasrul.hadi@live.com');
			$this->email->subject('Konfirmasi Pembayaran');
			$this->email->message($htmlMessage);
	
			$this->email->send();
			
			
			//buat session sukses
			$this->session->set_userdata('sukses','true');
			
			$this->log_model->log($id_user, $kode_reg, NULL, $log);
			
			$insert = $this->payment_model->insert_payment($data);
			
			redirect(site_url().'/payment/');
		}
	}

	function cek_validasi() 
	{
		$this->load->library('form_validation');
		
		//setting rules
		$config = array(
				array('field'=>'nama_rekening','label'=>'Atas Nama', 'rules'=>'required'),
				array('field'=>'tgl_transfer','label'=>'Tgl. Transfer', 'rules'=>'required'),
				array('field'=>'bank','label'=>'Nama Bank', 'rules'=>'required'),
				array('field'=>'nominal','label'=>'Jumlah', 'rules'=>'required|numeric'),
				array('field'=>'metode','label'=>'Jenis Pembayaran', 'rules'=>'callback_cek_dropdown'),
				array('field'=>'catatan','label'=>'Catatan', 'rules'=>'min_length[3]'),
			);
		
		
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'Kolom <strong>%s</strong> harus diisi !');
		$this->form_validation->set_message('min_length', 'Kolom <strong>%s</strong> minimal 3 karakter!');
		$this->form_validation->set_message('numeric', 'Kolom <strong>%s</strong> harus berupa angka !');
		//$this->form_validation->set_error_delimiters('<li class="error">', '</li>');

		return $this->form_validation->run();
    }
	
	function cek_dropdown($value){
		$this->load->library('form_validation');
		if($value==0){
				$this->form_validation->set_message('cek_dropdown', 'Pilih salah satu <strong>%s</strong> !');
				return FALSE;
		}else
				return TRUE;
    }
	
	function cek_ribuan($txt)
	{
		$pecah = number_format($txt);
		$ubah = str_replace(",", ".", $pecah);
		
		return $ubah;
	}
		
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/payment.php */