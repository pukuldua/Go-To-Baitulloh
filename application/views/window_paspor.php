<link rel="stylesheet" type="text/css" href="<? echo base_url().'css/screen.css';?>" />
<title>Paspor <? if(isset($nama_jamaah)){ echo $nama_jamaah; }?> |  <? if(isset($kode_group)){ echo $kode_group; }?> </title>
<table width="100%" border="0" cellspacing="3" cellpadding="3" bgcolor="#e4edf5">
  <tr>
    <td valign="top" align="center" width="250"><?					   
	   $file_paspor = './images/upload/paspor/'.$scan_paspor;
	   if(is_file($file_paspor))
	   { 
			$url_paspor = base_url().'images/upload/paspor/'.$scan_paspor;
			$url_paspor2 = $url_paspor;
	   }else{
			$url_paspor = base_url().'images/shared/book_x.png'; 
			$url_paspor2 = "#";
	   }
	   
	   ?>
	   <div class="thumb">
		<img src="<? echo $url_paspor; ?>" height="150" width="250" border="2" />
	  </div><br />
      <? if(isset($kode_group)){ echo $kode_group; }?>
	</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="box_info_2" width="120">Nama Calon Jamaah</td>
        <td class="box_info_2"><? if(isset($nama_jamaah)){ echo $nama_jamaah; }?></td>
      </tr>
      <tr>
        <td class="box_info_1">Tempat Tgl Lahir</td>
        <td class="box_info_1"><? if(isset($tgl_lahir)){ echo date('d M Y', strtotime($tgl_lahir)); }?></td>
      </tr>
      <tr>
        <td class="box_info_2">Jenis Kelamin</td>
        <td class="box_info_2"><? if(isset($jenkel)){ echo $jenkel; }?></td>
      </tr>
      <tr>
        <td class="box_info_1" colspan="2"></td>
      </tr>
      <tr>
        <td class="box_info_2">No Paspor</td>
        <td class="box_info_2"><? if(isset($no_paspor)){ echo $no_paspor; }?></td>
      </tr>
      <tr>
        <td class="box_info_1">Tgl. Terbit</td>
        <td class="box_info_1"><? if(isset($tgl_dikeluarkan)){ echo date('d M Y', strtotime($tgl_dikeluarkan)); }?></td>
      </tr>
      <tr>
        <td class="box_info_2">Tgl. Berakhir</td>
        <td class="box_info_2"><? if(isset($tgl_habis)){ echo date('d M Y', strtotime($tgl_habis)); }?></td>
      </tr>
      <tr>
        <td class="box_info_1">Kantor Pembuat</td>
        <td class="box_info_1"><? if(isset($kantor)){ echo $kantor; }?></td>
      </tr>
    </table></td>
  </tr>
</table>

<div class="clear"></div>