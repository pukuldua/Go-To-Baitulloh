<? echo form_open_multipart('/payment/do_send'); ?>

<?php echo $notifikasi;?>

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
					<th valign="top">Jumlah Rp. &nbsp;(*)</th>
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
							  '1'  => 'Transfer',
							  '2'  => 'Tunai',
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
					<td><textarea name="bank_pengirim" class="form-textarea-min" /><?php echo set_value('catatan');?></textarea>
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
					<th>&nbsp;</th>
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