<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cancel extends CI_Controller {

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
		$this->load->library('form_validation');
		$this->load->model('canceled_candidate_model');
		$this->load->model('jamaah_candidate_model');
		
		// LOAD SESSION
		$id_account = $this->session->userdata('id_account');
		$kode_reg = $this->session->userdata('kode_registrasi');
		
		// LOAD DATABASE
		$canceled_jamaah = $this->canceled_candidate_model->get_data_canceled($id_account, $kode_reg);
		$candidate_jamaah = $this->jamaah_candidate_model->get_total_jamaah($id_account, $kode_reg);
		
		if($canceled_jamaah->result() != NULL)
		{
			if($candidate_jamaah->result() != NULL)
			{
				$data['cek_valid'] = TRUE;
			}else{
				$data['cek_valid'] = FALSE;
			}
		}else{
			$data['cek_valid'] = TRUE;
		}
		
		$data['notifikasi'] = null;
		if($this->session->userdata('sukses') == 'true'){
			$data['notifikasi'] = '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">Pembatalan Keberangkatan Calon Jamaah berhasil. Informasi detail telah dikirim ke Email <i><strong>'.$this->session->userdata('email').'</strong></i>.</td>
						<td class="green-right"><a class="close-green"><img src="'.base_url().'images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
				</table><br>
			</div>';
			$this->session->unset_userdata('sukses');
		}
		
		$data['content'] = $this->load->view('cancel_page', $data, TRUE);
		$this->load->view('front', $data);
	}
	
	function do_send()
	{
		// LOAD MODEL DAN LIBRARY
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('parser');
		$this->load->model('canceled_candidate_model');
		$this->load->model('jamaah_candidate_model');
		$this->load->model('packet_model');
		$this->load->model('log_model');

		$log = "Melakukan PEMBATALAN Calon Jamaah";
		
		// LOAD SESSION
		$id_account = $this->session->userdata('id_account');
		$kode_reg = $this->session->userdata('kode_registrasi');
		$email_ses = $this->session->userdata('email');
		
		// LOAD DATABASE
		$data_jamaah = $this->jamaah_candidate_model->get_total_jamaah($id_account, $kode_reg);
		$data['list_calon'] = '';
		
		if($data_jamaah->result() != NULL)
		{
			// PROSES CANCEL
			foreach($data_jamaah->result() as $row)
			{
				// INSERT TABLE CANCELED
				$keterangan_cancel = "Testing";
				$data_insert = array(
						'ID_CANDIDATE' => $row->ID_CANDIDATE,
						'ID_ACCOUNT' => $this->session->userdata('id_account'),
						'KODE_REGISTRASI' => $this->session->userdata('kode_registrasi'),
						'TANGGAL_PEMBATALAN' => date("Y-m-d H:i:s"),
						'KETERANGAN' => $keterangan_cancel,
						); 
				$this->canceled_candidate_model->insert_canceled($data_insert);
				

				// UPDATE TABLE JAMAAH CANDIDATE
				$data_update = array(
						'STATUS_KANDIDAT' => 0,
						); 
				$this->jamaah_candidate_model->update_jamaah($data_update, $row->ID_CANDIDATE);
				
				
				// UPDATE TABLE JAMAAH CANDIDATE
				$data_packet = $this->packet_model->get_packet_status($id_account, $kode_reg);
				if($data_packet->result() > 0 )
				{
					foreach($data_packet->result() as $rows)
					{
						$data_update_packet = array(
							'STATUS_PESANAN' => 0,
							); 
						$this->packet_model->update_packet($data_update_packet, $rows->ID_PACKET);
					}
				}
				
				
				// KIRIM EMAIL PEMBERITAHUAN
				$data['subject'] = "Pembatalan Calon Jamaah";
				$data['nama_user'] = $row->NAMA_LENGKAP;
				
				if($row->GENDER == 1)
				{
					$gender = "Laki Laki";
				}else{
					$gender = "Perempuan";
				}
				
				$data['list_calon'] .= "
				  <strong>Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> ".$row->NAMA_LENGKAP."
				  <br />
				  <strong>Tgl Lahir&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>
				  ".$row->TEMPAT_LAHIR.", ".date("d F Y", strtotime($row->TANGGAL_LAHIR))."
				  <br />
				  <strong>Jenis Kelamin&nbsp;&nbsp;&nbsp;:</strong>
				  ".$gender." 
				  <div class=\"borderDashed\"></div>
				";
			
			}
			
	
			// KIRIM EMAIL PEMBERITAHUAN
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
	
			$this->email->initialize($config);
			
			$htmlMessage =  $this->parser->parse('email_cancel', $data, true);
			
			$this->email->from('noreply@umrahkamilah.com', 'Kamilah Wisata Muslim');
			$this->email->to($email_ses);
			$this->email->subject('Pembatalan Calon Jamaah');
			$this->email->message($htmlMessage);
	
			$this->email->send();
			
			
			//buat session sukses
			$this->session->set_userdata('sukses','true');
			
			// catat log
			$this->log_model->log($id_account, $kode_reg, NULL, $log);
			
			redirect(site_url()."/cancel");
		
		} else { 
			
			/*// UPDATE TABLE PAKCET
			$this->load->model('packet_model');
			$id_account = $this->session->userdata('id_account');
		    $kode_reg = $this->session->userdata('kode_registrasi');
			
			$data_packet = $this->packet_model->get_packet_status($id_account, $kode_reg);
			if($data_packet->result() != NULL )
			{
				foreach($data_packet->result() as $rows)
				{
					$datas = $rows->ID_PACKET;
					$data_update_packet = array(
						'STATUS_PESANAN' => 0,
						); 
					$this->packet_model->update_packet($data_update_packet, $row->ID_PACKET);
				}
			}*/
				
			redirect(site_url()."/cancel");
		}
	} // end function

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

?>