<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('email') == NULL)
			redirect(site_url()."/login");

                $this->cekOrder();
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
		$this->load->model('payment_model');
		$this->load->model('group_departure_model');
		
		$id_user = $this->session->userdata("id_account");
		$kode_reg = $this->session->userdata("kode_registrasi");
		
		
		// PROSES QUERY
		$data_packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
		$data_jamaah = $this->jamaah_candidate_model->query_jamaah("select * from jamaah_candidate where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND REQUESTED_NAMA != '0' AND REQUESTED_NAMA != '' AND STATUS_KANDIDAT != '0'");
		$data_jamaah_maningtis = $this->jamaah_candidate_model->query_jamaah("select * from jamaah_candidate where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND JASA_TAMBAHAN != '0' AND STATUS_KANDIDAT != '0'");
		$data_pay_uangmuka = $this->payment_model->query_payment("select * from payment_view where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND JENIS_PEMBAYARAN = '1'");
		$data_pay_lunas = $this->payment_model->query_payment("select * from payment_view where ID_ACCOUNT = '".$id_user."' AND KODE_REGISTRASI = '".$kode_reg."' AND JENIS_PEMBAYARAN = '2'");
		$data_total_jamaah = $this->jamaah_candidate_model->get_total_jamaah($id_user, $kode_reg);
		
		
		// CARI TOTAL PEMAKAI JASA NAMA PASPOR
		if($data_jamaah->num_rows() > 0)
		{
			$hitung_jasa_nama = $data_jamaah->num_rows();
		}else {
			$hitung_jasa_nama = 0;
		}
		
		$hitung_total = 20 * $hitung_jasa_nama;
		
		
		// CARI TOTAL PENGGUNA JASA MANINGTIS
		if($data_jamaah_maningtis->num_rows() > 0)
		{
			$hitung_jasa_maningtis = $data_jamaah_maningtis->num_rows();
		}else {
			$hitung_jasa_maningtis = 0;
		}
		
		$hitung_total_maningtis = 20 * $hitung_jasa_maningtis;
		
		
		// HITUNG TOTAL CALON JAMAAH
		if($data_total_jamaah->num_rows() > 0)
		{
			$total_calon_jamaah = $data_total_jamaah->num_rows();
		}else {
			$total_calon_jamaah = 0;
		}
		
		
		// CARI DATA UANG MUKA
		if($data_pay_uangmuka->result() != NULL)
		{
			foreach($data_pay_uangmuka->result() as $row)
			{
				$data['status_dp'] = $row->TIPE_STATUS;
				$data['jumlah_dp'] = $this->cek_ribuan($row->JUMLAH_KAMAR);
				$data['jumlah_dp2'] = $row->JUMLAH_KAMAR;
				$data['css_dp'] = "sudah";
			}
		}else{
			$data['status_dp'] = "-";
			$data['jumlah_dp'] = 0;
			$data['jumlah_dp2'] = 0;
			$data['css_dp'] = "belum";
		}
		
		// CARI DATA PELUNASAN
		if($data_pay_lunas->result() != NULL)
		{
			foreach($data_pay_lunas->result() as $row)
			{
				$data['status_lunas_pay'] = $row->STATUS;
				$data['status_lunas'] = $row->TIPE_STATUS;
				$data['jumlah_lunas'] = $this->cek_ribuan($row->JUMLAH_KAMAR);
				$data['jumlah_lunas2'] = $row->JUMLAH_KAMAR;
				$data['css_lunas'] = "sudah";
			}
		}else{
			$data['status_lunas_pay'] = 0;
			$data['status_lunas'] = "-";
			$data['jumlah_lunas'] = 0;
			$data['jumlah_lunas2'] = 0;
			$data['css_lunas'] = "belum";
		}
			
		
		// LOOPING PILIHAN PAKET 
		$data['row_price'] = '';
		$biaya_harga_kamar = 0;
		
		if($data_packet->result() != NULL)
		{
			foreach($data_packet->result() as $row)
			{
				$nama_group = $row->KODE_GROUP;
				$nama_program = $row->NAMA_PROGRAM;
				$cwb = $row->CHILD_WITH_BED;
				$cnb = $row->CHILD_NO_BED;
				$infant = $row->INFANT;
				$id_packet = $row->ID_PACKET;
				$id_program = $row->ID_PROGRAM;
				$id_group = $row->ID_GROUP;
			}
			
			$data_room_packet = $this->room_packet_model->get_room_packet_byIDpack($id_packet);
			foreach($data_room_packet->result() as $rows)
			{
				$id_room_packet = $rows->ID_ROOM_PACKET;
				$jumlah_kamar = $rows->JUMLAH;
				$id_room_type = $rows->ID_ROOM_TYPE;
					
				// CARI TANGGAL JATUH TEMPO DP DAN PELUNASAN
				$data_group = $this->group_departure_model->get_group($id_group);
				foreach($data_group->result() as $brs)
				{
					$data['tgl_dp'] = date('d F Y', strtotime($brs->JATUH_TEMPO_UANG_MUKA));
					$data['tgl_lunas'] = date('d F Y', strtotime($brs->JATUH_TEMPO_PELUNASAN));
				}
				
				// CARI DATA ROOM TYPE
				$data_room_type = $this->room_type_model->get_roomType($id_room_type);
				foreach($data_room_type->result() as $rowss)
				{
					$tipe_kamar = $rowss->JENIS_KAMAR;
				}
				
				
				// CARI HARGA KAMAR
				$data_kamar_siap = $this->room_availability_model->get_price_room($id_room_packet, $id_program, $id_group);
				foreach($data_kamar_siap->result() as $rowss)
				{
					$harga_kamar = $rowss->HARGA_KAMAR;
				}
				
				$total_harga_kamar = $harga_kamar * $jumlah_kamar;
				$biaya_harga_kamar += $total_harga_kamar;
				
				$data['row_price'] .= '	<tr height="30">
											<td align="right" class="front_price_no_border">
											<h4>'.$nama_group.' - '.$nama_program.' - '.$tipe_kamar.'</td>
											<td align="center"><h4>'.$this->cek_ribuan($harga_kamar).' $</h4></td>
											<td align="center">'.$jumlah_kamar.'</td>
											<td align="center"><h4>'.$this->cek_ribuan($total_harga_kamar).' $</h4></td>
										</tr>';
			}
		}
		
		$data['hitung_jasa_nama'] = $hitung_jasa_nama;
		$data['hitung_jasa_maningtis'] = $hitung_jasa_maningtis;
		$data['hitung_total'] = $hitung_total;
		$data['hitung_total_maningtis'] = $hitung_total_maningtis;
		
		$data['total_biaya'] = $hitung_total + $hitung_total_maningtis + $biaya_harga_kamar;
		$data['total_pelunasan'] = $this->cek_ribuan($data['total_biaya'] - 1100);
		$data['total_biaya2'] = $this->cek_ribuan($data['total_biaya']);
		$data['total_pay'] = $data['jumlah_dp2'] + $data['jumlah_lunas2'];
		$data['total_pay_cek'] = $this->cek_ribuan($data['total_pay']);
		
		if(($data['total_pay'] == $data['total_biaya'] || $data['total_pay'] > $data['total_biaya']) && $data['status_lunas_pay'] == 1)
		{
			$data['total_status'] = "Complete";
			$data['css_total'] = "sudah";
		}else{
			$data['total_status'] = "Pending";
			$data['css_total'] = "belum";
		}
					
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
		
		$data['error_file'] = '';
		if($this->session->userdata('upload_file') != '')
		{
			$data['error_file'] = '<div id="message-blue">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="blue-left">'.$this->session->userdata('upload_file').'</td>
								<td class="blue-right"><a class="close-blue"><img src="'.base_url().'images/table/icon_close_blue.gif"   alt="" /></a></td>
							</tr>
						</table><br>
					</div>';
			$this->session->unset_userdata('upload_file');
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
				if(!is_dir('./images/upload/bukti_transfer'))
				{
					mkdir('./images/upload/bukti_transfer',0777);
				}
				
				// Upload Foto
				$config['upload_path'] = './images/upload/bukti_transfer/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('foto'))
				{
					$this->session->set_userdata('upload_file', $this->upload->display_errors("<p>Error Scan Bukti Transfer : ", "</p>"));
					$data_file = NULL;
					$valid_file = FALSE;
				
				}else{
					$data_file = $this->upload->data();
					$valid_file = TRUE;
				}
				
				$bukti = $data_file['file_name'];
			
			} else {
				$bukti = NULL;
				$valid_file = TRUE;
			}

			// update table
			$id_user = $this->session->userdata("id_account");
			$kode_reg = $this->session->userdata("kode_registrasi");
			$email_ses = $this->session->userdata("email");
			
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
			/*$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
	
			$this->email->initialize($config);
			
			$htmlMessage =  $this->parser->parse('email_konfirmasi', $data, true);
			$data['subject'] = "Konfirmasi Pembayaran";
			
			$this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
			$this->email->to($email_ses);
			$this->email->subject('Konfirmasi Pembayaran');
			$this->email->message($htmlMessage);
	
			$this->email->send();*/
			
			if($valid_file)
			{
				//buat session sukses
				$this->session->set_userdata('sukses','true');
				$this->log_model->log($id_user, $kode_reg, NULL, $log);
				$insert = $this->payment_model->insert_payment($data);
				redirect(site_url().'/payment/');
			}else{
				$this->front();
			}
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

        // cek order packet
        function cekOrder(){
            $this->load->model('packet_model');
            $id_user = $this->session->userdata("id_account");
            $kode_reg = $this->session->userdata("kode_registrasi");

            $packet = $this->packet_model->get_packet_byAcc($id_user, $kode_reg);
            if ($packet->num_rows() < 1)
                    redirect('beranda');
        }
		
}

/* End of file Check_availability.php */
/* Location: ./application/controllers/payment.php */