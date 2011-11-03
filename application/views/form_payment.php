<?php 
echo $notifikasi;
echo $error_file;
?>

<div class="garis_pisah"> RINCIAN BIAYA</div>
<center>
<table width="100%" class="front_price" align="center">
	<tr height="30">
		<td width="300" class="front_price_no_border"></td>
		<td width="150" align="center"><h3>HARGA</h3></td>
		<td width="150" align="center"><h3>JUMLAH</h3></td>
		<td width="150" align="center"><h3>TOTAL</h3></td>
    </tr>	
	<? 
	if(isset($row_price))
	{
		echo $row_price;
	}
	?>	
	<tr height="30">
		<td align="right" class="front_price_no_border"><h4>Biaya Jasa Tambah Nama</h4></td>
		<td align="center"><h4>20.00 $</h4></td>
		<td align="center"><? if(isset($hitung_jasa_nama)) { echo $hitung_jasa_nama; } ?></td>
		<td align="center"><h4><? if(isset($hitung_total)) { echo $hitung_total; } ?> $</h4></td>
    </tr>	
	<tr height="30">
		<td align="right" class="front_price_no_border"><h4>Biaya Jasa Penngurusan Buku Maningtis</h4></td>
		<td align="center"><h4>20.00 $</h4></td>
		<td align="center"><? if(isset($hitung_jasa_maningtis)) { echo $hitung_jasa_maningtis; } ?></td>
		<td align="center"><h4><? if(isset($hitung_total_maningtis)) { echo $hitung_total_maningtis; } ?> $</h4></td>
    </tr>	
	<tr height="30" valign="bottom">
		<td class="front_price_no_border"></td>
		<td class="bg_kolom"></td>
		<td class="bg_kolom"><strong>T O T A L &nbsp; B I A Y A</strong></td>
		<td class="bg_kolom"><h4><? if(isset($total_biaya2)) { echo $total_biaya2; } ?> $</h4></td>
    </tr>
</table>
<br /><br /><br /><br />

<div class="garis_pisah"> RINCIAN PEMBAYARAN</div>

<!-- ------- Rincian Pembayaran --------->

<br />
<table width="100%" class="front_payment" align="center">
	<tr height="30">
		<td width="150" class="bg_kolom"></td>
		<td width="150" class="bg_kolom"><h3>BIAYA</h3></td>
		<td width="150" class="bg_kolom"><h3>DIBAYARKAN</h3></td>
		<td width="150" class="bg_kolom"><h3>STATUS</h3></td>
		<td width="150" class="bg_kolom"><h3>JATUH TEMPO</h3></td>
    </tr>	
	<tr height="30">
		<td class="bg_kolom_right front_payment_top"><h4>Uang Muka</h4></td>
		<td align="center"><h4>1.100 $</h4></td>
		<td align="center"><h4><? if(isset($jumlah_dp)) { echo $jumlah_dp; } ?> $</h4></td>
		<td align="center"><span class="box_status_<?=$css_dp?>"><? if(isset($status_dp)) { echo $status_dp; } ?></span></td>
		<td align="center"><h4><? if(isset($tgl_dp)) { echo $tgl_dp; } ?></h4></td>
    </tr>	
	<tr height="30">
		<td class="bg_kolom_right"><h4>Sisa Pelunasan</h4></td>
		<td align="center"><h4><? if(isset($total_pelunasan)) { echo $total_pelunasan; } ?> $</h4></td>
		<td align="center"><h4><? if(isset($jumlah_lunas)) { echo $jumlah_lunas; } ?> $</h4></td>
		<td align="center"><span class="box_status_<?=$css_lunas?>"><? if(isset($status_lunas)) { echo $status_lunas; } ?></span></td>
		<td align="center"><h4><? if(isset($tgl_lunas)) { echo $tgl_lunas; } ?></h4></td>
    </tr>	
	<tr height="30" valign="bottom">
		<td class="bg_kolom_right"><h4>T O T A L</h4></td>
		<td align="center"><h4><? if(isset($total_biaya2)) { echo $total_biaya2; } ?> $</h4></td>
		<td align="center"><h4><? if(isset($total_pay_cek)) { echo $total_pay_cek; } ?> $</h4></td>
		<td align="center"><span class="box_status_<?=$css_total?>"><? if(isset($total_status)) { echo $total_status; } ?></span></td>
		<td></td>
    </tr>
</table>
</center>
<br /><br /><br /><br />

<div class="garis_pisah">FORM KONFIRMASI</div>

<!-- ------- form konfirmasi --------->


<? echo form_open_multipart('/payment/do_send'); ?>

<br />
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('nama_rekening') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Rek. Atas Nama (*)</th>
					<td><input type="text" name="nama_rekening" value="<?php echo set_value('nama_rekening');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nama_rekening') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nama_rekening'); ?></div>
						<? }?>
					</td>
				</tr>
                <tr>
					<th valign="top">Tgl. Transfer (*)</th>
					<td>
                    	<input type="text" name="tgl_transfer" value="<?php echo set_value('tgl_transfer');?>" class="inp-form-disable" id="date_on" readonly="readonly" />
                        <a id="date-pick"><img src="<? echo base_url() ?>images/forms/icon_calendar.jpg" /></a>
                     </td>
					<td>
						<? if(form_error('tgl_transfer') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('tgl_transfer'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('bank') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Nama Bank (*)</th>
					<td><input type="text" name="bank" value="<?php echo set_value('bank');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('bank') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('bank'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('nominal') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Jumlah $. &nbsp;(*)</th>
					<td><input type="text" name="nominal" value="<?php echo set_value('nominal');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nominal') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nominal'); ?></div>
						<? }?>
					</td>
				</tr>
			</table>
			<!-- end id-form  -->
		</td>
        <td>
        <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('metode') == '' ? $class = 'inp-form2':$class = 'inp-form-error2'; ?>
					<th valign="top">Jenis Pembayaran (*)</th>
					<td><? $metode = 0; if(set_value('metode')!='') $metode = set_value('metode');
							$metode_options = array(
							  '0'  => '-- Jenis Pembayaran --',
							  '1'  => 'Uang Muka',
							  '2'  => 'Sisa Pelunasan',
							);
							
							echo form_dropdown('metode', $metode_options, $metode,'id="metode" class="styledselect_form_1"'); ?>
                        </td>
					<td>
						<? if(form_error('metode') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('metode'); ?></div>
						<? }?>
					</td>
				</tr>
                <tr>
					<th valign="top">Catatan</th>
					<td><textarea name="catatan" class="form-textarea-min" /><?php echo set_value('catatan');?></textarea>
                        </td>
					<td>
						<? if(form_error('catatan') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('catatan'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
                	<? form_error('foto') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th>Scan Bukti Pembayaran</th>
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
				<tr height="80">
					<th></th>
					<td valign="bottom">
						<input type="submit" value="" class="form-submit" />
						<input type="reset" value="" class="form-reset"  />
					</td>
					<td></td>
				</tr>
			</table>
         </td>
	</tr>
	<tr>
		<td><img src="<?php echo base_url()?>images/shared/blank.gif" width="480" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
<? echo form_close(); ?>		 
<div class="clear"></div>
