<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_edit extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('libkamilah');
	}
	
	function index()
	{
		redirect("/login");
	}
	
	function group_departure_update()
	{
		$this->load->model('group_departure_model');
		$data_group = $this->group_departure_model->get_all_group();
		
		$no = 0;
		foreach($data_group->result() as $row)
		{
			$pecah = explode("-", $row->TANGGAL_KEBERANGKATAN_JD);
			$tgl = $pecah[2];
			$bln = $pecah[1];
			$thn = $pecah[0];
			
			$mk_paspor = mktime(0,0,0,$bln,$tgl-45,$thn);
			$mk_uang_muka = mktime(0,0,0,$bln,$tgl-45,$thn);
			$mk_berkas = mktime(0,0,0,$bln,$tgl-21,$thn);
			$mk_waiting_list = mktime(0,0,0,$bln,$tgl-45,$thn);
			$mk_pelunasan = mktime(0,0,0,$bln,$tgl-14,$thn);
			
			$dk_paspor = date("Y-m-d", $mk_paspor);
			$dk_uang_muka = date("Y-m-d", $mk_uang_muka);
			$dk_berkas = date("Y-m-d", $mk_berkas);
			$dk_pelunasan = date("Y-m-d", $mk_pelunasan);
			$dk_waiting_list = date("Y-m-d", $mk_waiting_list);
			
			$data = array(
						  'TANGGAL_KEBERANGKATAN_MK' => $row->TANGGAL_KEBERANGKATAN_JD,
						  'JATUH_TEMPO_PASPOR' => $dk_paspor,
						  'JATUH_TEMPO_UANG_MUKA' => $dk_uang_muka,
						  'JATUH_TEMPO_PELUNASAN' => $dk_pelunasan,
						  'JATUH_TEMPO_BERKAS' => $dk_berkas,
						  'BATAS_WAITING_LIST' => $dk_waiting_list
						  );
			
			$this->group_departure_model->update_group($row->ID_GROUP, $data);
		}
		
		redirect(site_url()."/login");
	}
}

?>