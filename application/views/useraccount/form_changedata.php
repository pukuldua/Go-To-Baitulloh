<div class="titleform">My Account > Change Profile Data</div>

<?php echo form_open('useraccount/updatedata'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" onload="showRecaptcha('recaptcha_div');">
	<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('nama') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No Registrasi :</th>
					<td><input type="text" name="nama" value="<?php echo set_value('nama');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nama') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nama'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('nama') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Nama (*):</th>
					<td><input type="text" name="nama" value="<?php echo set_value('nama');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nama') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nama'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('email') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">E-mail (*):</th>
					<td><input type="text" name="email" class="<? echo $class;?>" value="<?php echo set_value('email'); ?>" /></td>
					<td>
						<? if(form_error('email') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('email'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('telp') == '' || form_error('mobile') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Telp / Mobile (*):</th>
					<td><input type="text" name="telp" value="<?php echo set_value('telp');?>" class="<? echo $class;?>" /> &nbsp; / &nbsp;<input type="text" name="mobile" value="<?php echo set_value('mobile');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('telp') != '' || form_error('mobile') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('telp').' '.form_error('mobile'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Propinsi (*):</th>
					<td>	
						<? $province = 0; if(set_value('province')!='') $province = set_value('province');
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
					<th valign="top">Kota (*):</th>
					<td><input type="text" name="kota" value="<?php echo set_value('kota');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('kota') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('kota'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('alamat') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Alamat (*):</th>
					<td><input type="text" name="alamat" value="<?php echo set_value('alamat');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('alamat') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('alamat'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('id_card') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No ID Card (i.e. KTP *):</th>
					<td><input type="text" name="id_card" value="<?php echo set_value('id_card');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('id_card') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('id_card'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="submit" value="" class="form-submit" />
						<input type="reset" value="" class="form-reset"  />
					</td>
					<td></td>
				</tr>
			</table>
			<!-- end id-form  -->
		</td>
	</tr>
	<tr>
		<td><img src="<?php echo base_url();?>images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
		 
<div class="clear"></div>

<? echo form_close(); ?>
		 