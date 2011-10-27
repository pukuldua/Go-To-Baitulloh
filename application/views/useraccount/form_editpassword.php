<div class="titleform">My Account > Ubah Password Akun</div>

<?php echo $notifikasi;?>

<? echo form_open('useraccount/do_editpassword'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<? form_error('password_sekarang') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Password Sekarang</th>
					<td><input type="password" name="password_sekarang" value="<?if(set_value('password_sekarang')!='') echo set_value('password_sekarang');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('password_sekarang') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('password_sekarang'); ?></div>
						<? }?>
					</td>
				</tr>

				<tr>
					<? form_error('password_baru') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Password Baru</th>
					<td><input type="password" name="password_baru" value="<?if(set_value('password_baru')!='') echo set_value('password_baru');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('password_baru') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('password_baru'); ?></div>
						<? }?>
					</td>
				</tr>
				
				<tr>
					<? form_error('konfirmasi') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Konfirmasi</th>
					<td><input type="password" name="konfirmasi" value="<?if(set_value('konfirmasi')!='') echo set_value('konfirmasi');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('konfirmasi') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('konfirmasi'); ?></div>
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
				
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						
					</td>
					<td></td>
				</tr>
				
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						
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