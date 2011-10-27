<div class="titleform">My Account > Change Profile Data</div>

<? echo form_open('useraccount/do_edit'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('no_registrasi') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">No Registrasi</th>
					<td><input readonly="true" type="text" name="no_registrasi" value="<?php echo strtoupper($no_registrasi); ?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('no_registrasi') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('no_registrasi'); ?></div>
						<? }?>
					</td>
				</tr>

				<tr>
					<? form_error('nama') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Nama Lengkap</th>
					<td><input type="text" name="nama" value="<?php echo $nama;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('nama') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('nama'); ?></div>
						<? }?>
					</td>
				</tr>
				
				<tr>
					<? form_error('email') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Email</th>
					<td><input type="text" name="email" value="<?php echo $email;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('email') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('email'); ?></div>
						<? }?>
					</td>
				</tr>
				
				<tr>
					<? form_error('telepon') == '' || form_error('handphone') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Telepon / Mobile</th>
					<td><input type="text" name="telepon" value="<?php echo $telepon; ?>" class="<? echo $class;?>" /> &nbsp; / &nbsp;<input type="text" name="handphone" value="<?php echo $handphone; ?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('telepon') != '' || form_error('handphone') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('telepon').' '.form_error('handphone'); ?></div>
						<? }?>
					</td>
				</tr>
				
			</table>
			<!-- end id-form  -->
		</td>
		
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Propinsi</th>
					<td>	
						<? $province = $propinsi; if(set_value('province')!='') $province = set_value('province');
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
					<th valign="top">Kota</th>
					<td><input type="text" name="kota" value="<?php echo $kota;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('kota') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('kota'); ?></div>
						<? }?>
					</td>
				</tr>
				
				<tr>
					<? form_error('alamat') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Alamat</th>
					<td><input type="text" name="alamat" value="<?php echo $alamat;?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('alamat') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('alamat'); ?></div>
						<? }?>
					</td>
				</tr>
			</table>
			<!-- end id-form  -->
		</td>
	</tr>
</table>
<? echo form_close(); ?>
<div class="clear"></div>