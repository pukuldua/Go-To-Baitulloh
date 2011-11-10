<? 
echo form_open_multipart('/paspor/do_edit');
echo $notifikasi;
echo $error_file;
?>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr height="40">
					<td colspan="2" valign="top">
                    <? if($e_request_nama == "") { $e_jasa_paspor = 0; }
					   else { $e_jasa_paspor = 1;}
					?>
                    <input type="checkbox" name="jasa_paspor" id="jasa_paspor" value="1" <?=($e_jasa_paspor==1)?'checked="checked"':''?>  onchange="jasaPaspor(this)" readonly="readonly"/> &nbsp;&nbsp;<strong>Status Jasa Tambah Nama</strong></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
                    <td colspan="2">
                       <?
					   $file_gambar = './images/upload/foto/'.$e_pas_foto;
					   if(is_file($file_gambar))
                       { 
					   		$url_gambar = base_url().'images/upload/foto/'.$e_pas_foto;
							$url_gambar2 = $url_gambar;
					   }else{
							$url_gambar = base_url().'images/shared/user_x.png'; 
							$url_gambar2 = "#";
					   }
					   
					   ?>
                      <div class="thumb">
                       <a href="<? echo $url_gambar2; ?>" title="Klik untuk memperbesar foto">
                        <img src="<? echo $url_gambar; ?>" height="120" width="100" border="2" />
                       </a>
                       </div>
                       <?					   
					   $file_paspor = './images/upload/paspor/'.$e_scan_paspor;
					   if(is_file($file_paspor))
                       { 
					   		$url_paspor = base_url().'images/upload/paspor/'.$e_scan_paspor;
							$url_paspor2 = $url_paspor;
					   }else{
							$url_paspor = base_url().'images/shared/book_x.png'; 
							$url_paspor2 = "#";
					   }
					   
					   ?>
                       <div class="thumb">
                       <a href="<? echo $url_paspor2; ?>" title="Klik untuk memperbesar paspor">
                        <img src="<? echo $url_paspor; ?>" height="120" width="100" border="2" />
                       </a>
                      </div>
                   <input type="hidden" name="foto_edit" value="<? echo $e_pas_foto; ?>" />
				</tr>
				<tr>
					<th valign="top">Nama Lengkap</th>
					<td>: <?php echo $e_nama_lengkap; ?></td>
					<td></td>
                </tr>
				<tr>
					<th valign="top">Jenis Kelamin</th>
					<td>: <?php echo $e_gender;?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Tanggal Lahir</th>
					<td>: <? echo $e_tempat_lahir.", ".$tgl_lahir; ?> </td>
					<td></td>
                <tr>
                    <td colspan="3"><img src="<?=base_url()?>images/shared/blank.gif" width="480" height="1" alt="blank" /></td>
                </tr>
                <tr height="40">
					<td colspan="2">
                    <div id="" style="border:1px #e0e0e0 solid; background:#f5f5f5; color:#707070; padding:6px 17px 6px 17px;margin-bottom:2px;"><strong>INFORMASI PENGUMPULAN BERKAS FISIK / DOKUMEN ASLI KE KANTOR KAMILAH</strong></div>
                     <div id="" style="border:1px #d8e1e9 solid; background:#e4edf5; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Dokumen Asli harus diserahkan 3 minggu sebelum keberangkatan</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#f5f9fc; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Pasport asli minimal 6 bulan masa berlaku dengan 3 suku kata. (contoh: Toni Budi bin Ahmad)</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#e4edf5; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Buku Nikah asli bagi Suami / Istri</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#f5f9fc; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Kartu Keluarga asli bagi Keluarga dengan Istri dan Anak-Anaknya</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#e4edf5; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Akte Lahir asli bagi yang membawa Anak-Anak</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#f5f9fc; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- KTP/KK/Buku Nikah asli bagi yang sudah berusia 45th ke atas</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#e4edf5; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- copy KTP, copy Akte Lahir, copy Kartu Keluarga</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#f5f9fc; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Akte Lahir Asli, copy KTP, copy KK bagi Wanita yang berangkat tanpa Muhrimnya</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#e4edf5; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Buku Kuning / Buku Maningtis</div> 
                     <div id="" style="border:1px #d8e1e9 solid; background:#f5f9fc; color:#2e74b2; padding:6px 17px 6px 17px;margin-bottom:2px;">- Foto Ukuran 3x4 (10 lembar) , 4x6 (5 lembar)</div> 
                     </td>
                     <td><td>
				</tr>
			</table>
			<!-- end id-form  -->
		</td>
		
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
            	<? if($tipe == 0) { ?>
				<tr>
					<? form_error('no_paspor') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No Paspor (*)</th>
					<td><input type="text" name="no_paspor" value="<?php echo set_value('no_paspor');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('no_paspor') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('no_paspor'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Tgl. Dikeluarkan (*)</th>
					<td><? 
							// list tgl
							$k_tgl_lahirs = 0; if(set_value('k_tgl_lahir')!='') $k_tgl_lahirs = set_value('k_tgl_lahir');
							
							$k_list_tgl['0'] = "Tgl";
							for($i=1;$i<=31;$i++)
							{
								$k_list_tgl[$i] = $i;
							}
							echo form_dropdown('k_tgl_lahir', $k_list_tgl, $k_tgl_lahirs,'id="k_tgl_lahir" class="styledselect-day"'); 
							
							// list bln
							$k_bln_lahirs = 0; if(set_value('k_bln_lahir')!='') $k_bln_lahirs = set_value('k_bln_lahir');
							
							$k_list_bln['0'] = "Bln";
							for($i=01;$i<=12;$i++)
							{
								$k_list_bln[$i] = $i;
							}
							echo form_dropdown('k_bln_lahir', $k_list_bln, $k_bln_lahirs,'id="k_bln_lahir" class="styledselect-day"');
							
							//list tahun
							$k_thn_lahirs = 0; if(set_value('k_thn_lahir')!='') $k_thn_lahirs = set_value('k_thn_lahir');
							
							$k_list_thn['0'] = "Thn";
							for($i=2009;$i<=2017;$i++)
							{
								$k_list_thn[$i] = $i;
							}
							echo form_dropdown('k_thn_lahir', $k_list_thn, $k_thn_lahirs,'id="k_thn_lahir" class="styledselect-day"');?>
                     
                    </td>
					<td>
						<? if(form_error('k_tgl_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_tgl_lahir'); ?></div>
						<? } elseif(form_error('k_bln_lahir') != '') { ?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_bln_lahir'); ?></div>
						<? }elseif(form_error('k_thn_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_thn_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Tgl. Berakhir (*)</th>
					<td><? 
							// list tgl
							$b_tgl_lahirs = 0; if(set_value('b_tgl_lahir')!='') $b_tgl_lahirs = set_value('b_tgl_lahir');
							
							$b_list_tgl['0'] = "Tgl";
							for($i=1;$i<=31;$i++)
							{
								$b_list_tgl[$i] = $i;
							}
							echo form_dropdown('b_tgl_lahir', $b_list_tgl, $b_tgl_lahirs,'id="b_tgl_lahir" class="styledselect-day"'); 
							
							// list bln
							$b_bln_lahirs = 0; if(set_value('b_bln_lahir')!='') $b_bln_lahirs = set_value('b_bln_lahir');
							
							$b_list_bln['0'] = "Bln";
							for($i=01;$i<=12;$i++)
							{
								$b_list_bln[$i] = $i;
							}
							echo form_dropdown('b_bln_lahir', $b_list_bln, $b_bln_lahirs,'id="b_bln_lahir" class="styledselect-day"');
							
							//list tahun
							$b_thn_lahirs = 0; if(set_value('b_thn_lahir')!='') $b_thn_lahirs = set_value('b_thn_lahir');
							
							$b_list_thn['0'] = "Thn";
							for($i=2009;$i<=2017;$i++)
							{
								$b_list_thn[$i] = $i;
							}
							echo form_dropdown('b_thn_lahir', $b_list_thn, $b_thn_lahirs,'id="b_thn_lahir" class="styledselect-day"');?>
                     
                    </td>
					<td>
						<? if(form_error('b_tgl_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_tgl_lahir'); ?></div>
						<? } elseif(form_error('b_bln_lahir') != '') { ?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_bln_lahir'); ?></div>
						<? }elseif(form_error('b_thn_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_thn_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('kantor') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Kantor yg Mengeluarkan</th>
					<td><input type="text" name="kantor" value="<?php echo set_value('kantor');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('kantor') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('kantor'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
                	<? form_error('foto') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th>Scan Paspor (*)</th>
					<td><input type="file" class="file_1" name="foto" value="<? echo set_value('foto') ?>" /></td>
					<td>
						<? if(form_error('foto') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('foto'); ?></div>
						<? } else { ?>
                        <div class="bubble-left"></div>
						<div class="bubble-inner">JPEG, PNG 5MB max per image</div>
						<div class="bubble-right"></div>
                        <? } ?>
					</td>
				</tr>
                
                <? } elseif($tipe == 1) { ?>
                
                <tr>
					<? form_error('no_paspor') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No Paspor (*)</th>
					<td><input type="text" name="no_paspor" value="<?php echo $e_no_paspor; ?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('no_paspor') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('no_paspor'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Tgl. Dikeluarkan (*)</th>
					<td><? 
							// list tgl
							$k_tgl_lahirs = $e_k_tgl; if(set_value('k_tgl_lahir')!='') $k_tgl_lahirs = set_value('k_tgl_lahir');
							
							$k_list_tgl['0'] = "Tgl";
							for($i=1;$i<=31;$i++)
							{
								$k_list_tgl[$i] = $i;
							}
							echo form_dropdown('k_tgl_lahir', $k_list_tgl, $k_tgl_lahirs,'id="k_tgl_lahir" class="styledselect-day"'); 
							
							// list bln
							$k_bln_lahirs = $e_k_bln; if(set_value('k_bln_lahir')!='') $k_bln_lahirs = set_value('k_bln_lahir');
							
							$k_list_bln['0'] = "Bln";
							for($i=01;$i<=12;$i++)
							{
								$k_list_bln[$i] = $i;
							}
							echo form_dropdown('k_bln_lahir', $k_list_bln, $k_bln_lahirs,'id="k_bln_lahir" class="styledselect-day"');
							
							//list tahun
							$k_thn_lahirs = $e_k_thn; if(set_value('k_thn_lahir')!='') $k_thn_lahirs = set_value('k_thn_lahir');
							
							$k_list_thn['0'] = "Thn";
							for($i=2009;$i<=2017;$i++)
							{
								$k_list_thn[$i] = $i;
							}
							echo form_dropdown('k_thn_lahir', $k_list_thn, $k_thn_lahirs,'id="k_thn_lahir" class="styledselect-day"');?>
                     
                    </td>
					<td>
						<? if(form_error('k_tgl_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_tgl_lahir'); ?></div>
						<? } elseif(form_error('k_bln_lahir') != '') { ?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_bln_lahir'); ?></div>
						<? }elseif(form_error('k_thn_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('k_thn_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Tgl. Berakhir (*)</th>
					<td><? 
							// list tgl
							$b_tgl_lahirs = $e_b_tgl; if(set_value('b_tgl_lahir')!='') $b_tgl_lahirs = set_value('b_tgl_lahir');
							
							$b_list_tgl['0'] = "Tgl";
							for($i=1;$i<=31;$i++)
							{
								$b_list_tgl[$i] = $i;
							}
							echo form_dropdown('b_tgl_lahir', $b_list_tgl, $b_tgl_lahirs,'id="b_tgl_lahir" class="styledselect-day"'); 
							
							// list bln
							$b_bln_lahirs = $e_b_bln; if(set_value('b_bln_lahir')!='') $b_bln_lahirs = set_value('b_bln_lahir');
							
							$b_list_bln['0'] = "Bln";
							for($i=01;$i<=12;$i++)
							{
								$b_list_bln[$i] = $i;
							}
							echo form_dropdown('b_bln_lahir', $b_list_bln, $b_bln_lahirs,'id="b_bln_lahir" class="styledselect-day"');
							
							//list tahun
							$b_thn_lahirs = $e_b_thn; if(set_value('b_thn_lahir')!='') $b_thn_lahirs = set_value('b_thn_lahir');
							
							$b_list_thn['0'] = "Thn";
							for($i=2009;$i<=2017;$i++)
							{
								$b_list_thn[$i] = $i;
							}
							echo form_dropdown('b_thn_lahir', $b_list_thn, $b_thn_lahirs,'id="b_thn_lahir" class="styledselect-day"');?>
                     
                    </td>
					<td>
						<? if(form_error('b_tgl_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_tgl_lahir'); ?></div>
						<? } elseif(form_error('b_bln_lahir') != '') { ?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_bln_lahir'); ?></div>
						<? }elseif(form_error('b_thn_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('b_thn_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('kantor') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Kantor yg Mengeluarkan</th>
					<td><input type="text" name="kantor" value="<?php echo $e_kantor; ?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('kantor') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('kantor'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
                	<? form_error('foto') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th>Scan Paspor (*)</th>
					<td>
                      <input type="file" class="file_1" name="foto" value="<? echo set_value('foto') ?>" />
                      <input type="hidden" name="paspor_edit" value="<? echo $e_scan_paspor; ?>" />
                    </td>
					<td>
						<? if(form_error('foto') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('foto'); ?></div>
						<? } else { ?>
                        <div class="bubble-left"></div>
						<div class="bubble-inner">JPEG, PNG 5MB max per image</div>
						<div class="bubble-right"></div>
                        <? } ?>
					</td>
				</tr>
                
                <? } else { redirect(site_url()."/paspor"); } ?>
				<tr height="70">
					<th></th>
					<td valign="bottom">
                    	<input type="hidden" value="<? echo $e_id_candidate ?>" name="id_candidate" />
                    	<input type="hidden" value="<? echo $e_id_account ?>" name="id_account" />
                    	<input type="hidden" value="<? echo $tipe ?>" name="id_tipe" />
						<input type="submit" value="" class="form-submit" />
						<input type="reset" value="" class="form-reset"  />
					</td>
					<td></td>
				</tr>
			</table>
			<!-- end id-form  -->
		</td>
	</tr>
</table>
<? echo form_close(); ?>
<div class="clear"></div>


<script type="text/javascript">

function jasaPaspor(input)
{
	if(input.checked)
	{
		document.getElementById('jasa_paspor_nama').value='';
		document.getElementById('jasa_paspor_nama').disabled=false;
	} else {
		document.getElementById('jasa_paspor_nama').value='';
		document.getElementById('jasa_paspor_nama').disabled=true;
	}
}

</script>