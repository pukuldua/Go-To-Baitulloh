<? echo form_open_multipart('/biodata/do_edit'); ?>

<?php echo $notifikasi;?>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('nama_lengkap') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Nama Lengkap (*)</th>
					<td><input type="text" name="nama_lengkap" value="<?php echo $e_nama_lengkap; ?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nama_lengkap') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nama_lengkap'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('panggilan') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Panggilan</th>
					<td><input type="text" name="panggilan" value="<?php echo $e_nama_panggilan;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('panggilan') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('panggilan'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('gender') == '' ? $class = 'inp-form2':$class = 'inp-form-error2'; ?>
					<th valign="top">Jenis Kelamin (*)</th>
					<td><? $gender = $e_gender; if(set_value('gender')!='') $gender = set_value('gender');
							$gender_options = array(
							  '0'  => '-- Jenis Kelamin --',
							  '1'  => 'Laki-Laki',
							  '2'  => 'Perempuan',
							);
							
							echo form_dropdown('gender', $gender_options, $gender,'id="gender" class="styledselect_form_1"'); ?>
                        </td>
					<td>
						<? if(form_error('gender') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('gender'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('ayah_kandung') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Ayah Kandung (*)</th>
					<td><input type="text" name="ayah_kandung" value="<?php echo $e_ayah_kandung;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('ayah_kandung') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('ayah_kandung'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('warga_negara') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Warga Negara (*)</th>
					<td><input type="text" name="warga_negara" value="<?php echo $e_warga_negara;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('warga_negara') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('warga_negara'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('tempat_lahir') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Tempat Lahir (*)</th>
					<td><input type="text" name="tempat_lahir" value="<?php echo $e_tempat_lahir;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('tempat_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('tempat_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Tanggal Lahir (*)</th>
					<td><? 
							// list tgl
							$tgl_lahirs = $e_tgl_lahir; if(set_value('tgl_lahir')!='') $tgl_lahirs = set_value('tgl_lahir');
							
							$list_tgl['0'] = "Tgl";
							for($i=1;$i<=31;$i++)
							{
								$list_tgl[$i] = $i;
							}
							echo form_dropdown('tgl_lahir', $list_tgl, $tgl_lahirs,'id="tgl_lahir" class="styledselect-day"'); 
							
							// list bln
							$bln_lahirs = $e_bln_lahir; if(set_value('bln_lahir')!='') $bln_lahirs = set_value('bln_lahir');
							
							$list_bln['0'] = "Bln";
							for($i=01;$i<=12;$i++)
							{
								$list_bln[$i] = $i;
							}
							echo form_dropdown('bln_lahir', $list_bln, $bln_lahirs,'id="bln_lahir" class="styledselect-day"');
							
							//list tahun
							$thn_lahirs = $e_thn_lahir; if(set_value('thn_lahir')!='') $thn_lahirs = set_value('thn_lahir');
							
							$list_thn['0'] = "Thn";
							for($i=1900;$i<=2010;$i++)
							{
								$list_thn[$i] = $i;
							}
							echo form_dropdown('thn_lahir', $list_thn, $thn_lahirs,'id="thn_lahir" class="styledselect-day"');?>
                     
                    </td>
					<td>
						<? if(form_error('tgl_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('tgl_lahir'); ?></div>
						<? } elseif(form_error('bln_lahir') != '') { ?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('bln_lahir'); ?></div>
						<? }elseif(form_error('thn_lahir') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('thn_lahir'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Propinsi (*)</th>
					<td>	
						<? $province = $e_id_propinsi; if(set_value('province')!='') $province = set_value('province');
							echo form_dropdown('province', $province_options, $province,'id="province" class="styledselect_form_1"'); ?>
					</td>
					<td>
						<? if(form_error('province') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('province'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('kota') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Kota (*)</th>
					<td><input type="text" name="kota" value="<?php echo $e_kota;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('kota') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('kota'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('alamat') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Alamat (*)</th>
					<td><input type="text" name="alamat" value="<?php echo $e_alamat;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('alamat') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('alamat'); ?></div>
						<? }?>
					</td>
				</tr><!--
				<tr>
					<? form_error('email') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Email</th>
					<td><input type="text" name="email" value="<?php echo set_value('email');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('email') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('email'); ?></div>
						<? }?>
					</td>
				</tr>-->
				<tr height="40">
					<? form_error('mahram') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top"></th>
					<td><input type="checkbox" name="mahram" value="1" <?=($e_mahram==1)?'checked="checked"':''?> /> &nbsp;&nbsp;Tidak Ada Mahram</td>
					<td>
						<? if(form_error('mahram') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('mahram'); ?></div>
						<? }?>
					</td>
				</tr>
                <tr>
					<? form_error('telp') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No Telepon (*)</th>
					<td><input type="text" name="telp" value="<?php echo $e_telp;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('telp') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('telp'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('hp') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Handphone</th>
					<td><input type="text" name="hp" value="<?php echo $e_hp;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('hp') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('hp'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('relasi') == '' ? $class = 'inp-form2':$class = 'inp-form-error2'; ?>
					<th valign="top">Relation (*)</th>
					<td><? $relasi = $e_id_relation; if(set_value('relasi')!='') $relasi = set_value('relasi');
							echo form_dropdown('relasi', $relasi_options, $relasi,'id="relasi" class="styledselect_form_1"'); ?>
                        </td>
					<td>
						<? if(form_error('relasi') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('relasi'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('baju') == '' ? $class = 'inp-form2':$class = 'inp-form-error2'; ?>
					<th valign="top">Ukuran Baju (*)</th>
					<td><? $baju = $e_id_size; if(set_value('baju')!='') $baju = set_value('baju');
							echo form_dropdown('baju', $chlothes_options, $baju,'id="baju" class="styledselect_form_1"'); ?>
                        </td>
					<td>
						<? if(form_error('baju') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('baju'); ?></div>
						<? }?>
					</td>
				</tr>
                <tr>
                    <td colspan="3"><img src="<?=base_url()?>images/shared/blank.gif" width="480" height="1" alt="blank" /></td>
                </tr>
			</table>
			<!-- end id-form  -->
		</td>
		
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
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
                        <a href="<? echo $url_gambar2; ?>" title="Klik untuk memperbesar gambar">
                          <img src="<? echo $url_gambar; ?>" height="140" width="105" border="2" />
                        </a>
                        </div>
                    	
                        <input type="hidden" name="foto_edit" value="<? echo $e_pas_foto; ?>" />
				</tr>
				<tr height="70">
                	<? form_error('foto') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th>Ganti Foto</th>
					<td><input type="file" class="file_1" name="foto" value="<? echo set_value('foto') ?>" /></td>
					<td>
						<? if(form_error('foto') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('foto'); ?></div>
						<? } else { ?>
                        <div class="bubble-left"></div>
						<div class="bubble-inner">JPEG, GIF 5MB max per image</div>
						<div class="bubble-right"></div>
                        <? } ?>
					</td>
				</tr>
				<tr>
					<th valign="top" colspan="2">Permintaan Pelayanan Khusus</th>
					<td>
					</td>
				</tr>
				<tr height="40">
					<td>
                    <input type="checkbox" name="kursi_roda" value="1" <?=($e_khusus_kursi==1)?'checked="checked"':''?>/> &nbsp;&nbsp;Kursi Roda</td>
					<td><input type="checkbox" name="asisten" value="2"  <?=($e_khusus_asisten==2)?'checked="checked"':''?> /> &nbsp;&nbsp;Asistensi Anak yang khusus</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top" colspan="2">Perihal Pribadi</th>
					<td>
					</td>
				</tr>
				<tr>
					<td colspan="3"><table width="100%">
                    	<tr>
                          <td width="130">
                          <input type="checkbox" name="darah_tinggi" value="1"  <?=($e_perihal_darah==1)?'checked="checked"':''?> /> &nbsp;&nbsp;Darah Tinggi
                          </td>
                          <td width="150">
                          <input type="checkbox" name="takut_ketinggian" value="2"  <?=($e_perihal_tinggi==2)?'checked="checked"':''?> /> &nbsp;&nbsp;Takut Ketinggian
                          </td>
                          <td>
                          <input type="checkbox" name="smooking_room" value="3"  <?=($e_perihal_smooking==3)?'checked="checked"':''?> /> &nbsp;&nbsp;Perokok
                          </td>
                         </tr>
                       </table>
                     </td>
				</tr>
				<tr>
					<td colspan="3"><table width="100%">
                    	<tr>
                          <td width="130">
                          <input type="checkbox" name="jantung" value="4"  <?=($e_perihal_jantung==4)?'checked="checked"':''?> /> &nbsp;&nbsp;Jantung
                          </td>
                          <td width="150">
                          <input type="checkbox" name="asma" value="5" <?=($e_perihal_asma==5)?'checked="checked"':''?> /> &nbsp;&nbsp;Asma
                          </td>
                          <td>
                          <input type="checkbox" name="mendengkur" value="6"  <?=($e_perihal_mendengkur==6)?'checked="checked"':''?> /> &nbsp;&nbsp;Mendengkur
                          </td>
                         </tr>
                       </table>
                     </td>
				</tr>
				<tr>
					<? form_error('jasa_paspor') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Jasa Tambahan</th>
					<td>
                    <? if($e_request_nama == "") { $e_jasa_paspor = 0; }
					   else { $e_jasa_paspor = 1;}
					?>
                    <input type="checkbox" name="jasa_paspor" id="jasa_paspor" value="1" <?=($e_jasa_paspor==1)?'checked="checked"':''?>  onchange="jasaPaspor(this)"/> &nbsp;&nbsp;Tambah Nama (3 suku kata) Paspor</td>
					<td>
						<? if(form_error('jasa_paspor') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('jasa_paspor'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('jasa_paspor_nama') == '' ? $class = 'inp-form-text':$class = 'inp-form-error'; ?>
					<th valign="top"></th>
					<td>
                    <input type="hidden" name="jasa_paspor_nama_edit" value="<?php echo $e_request_nama;?>" />
                    <input type="text" name="jasa_paspor_nama" id="jasa_paspor_nama" value="<?php echo $e_request_nama;?>" class="<? echo $class;?>" disabled="disabled" /></td>
					<td>
						<? if(form_error('jasa_paspor_nama') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('jasa_paspor_nama'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr height="50">
					<? form_error('jasa_maningtis') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top"></th>
					<td valign="top"><input type="checkbox" name="jasa_maningtis" value="1" <?=($e_jasa_tambahan==1)?'checked="checked"':''?> /> &nbsp;&nbsp;Jasa Maningtis</td>
					<td>
						<? if(form_error('jasa_maningtis') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('jasa_maningtis'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th></th>
					<td valign="top">
                    	<input type="hidden" value="<? echo $e_id_candidate ?>" name="id_candidate" />
                    	<input type="hidden" value="<? echo $e_id_account ?>" name="id_account" />
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
		document.getElementById('jasa_paspor_nama').value='<?php echo $e_request_nama ?>';
		document.getElementById('jasa_paspor_nama').disabled=false;
	} else {
		document.getElementById('jasa_paspor_nama').value='<?php echo $e_request_nama ?>';
		document.getElementById('jasa_paspor_nama').disabled=true;
	}
}

</script>