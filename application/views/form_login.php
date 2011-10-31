<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<?=form_open('/login/cek_login');?>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
                	<th valign="top"></th>
					<td>
                    	<? if(isset($cek_form))
							{								
								echo '<div class="error-left-both"></div><div class="error-inner">
										<strong>Email</strong> atau <strong>Password</strong> salah
									  </div>';
							}
						?>
                    </td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">E-mail</th>
					<td><input type="text" name="email" id="email" class="inp-form<?=$cek_error?>" /></td>
					<td>
						<? echo form_error('email', '<div class="error-left"></div><div class="error-inner">', '</div>'); ?>
					</td>
				</tr>
				<tr>
					<th valign="top">Password </th>
					<td><input type="password" name="password" id="password" class="inp-form<?=$cek_error?>" /></td>
					<td>
						<? echo form_error('password', '<div class="error-left"></div><div class="error-inner">', '</div>'); ?>
                    </td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="submit" value="Login" class="form-submit" />
						<input type="reset" value="" class="form-reset"  />
					</td>
					<td></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top"><br />
                    <ul class="greyarrow"><li><a href="<?=site_url() ?>/forgot" title="Forgot Password?">Lupa Password?</a></li></ul></td>
					<td></td>
				</tr>
			</table>
			<!-- end id-form  -->
            <?=form_close()?>
		</td>
		
		<td>
			<!--  start related-activities -->
			<div id="related-activities">
				
				<!--  start related-act-top -->
				<div id="related-act-top">
					<img src="<?=base_url()?>images/forms/header_related_act.gif" width="271" height="43" alt="" />
				</div>
				<!-- end related-act-top -->
					
				<!--  start related-act-bottom -->
				<div id="related-act-bottom">
					<!--  start related-act-inner -->
					<div id="related-act-inner">
						<div class="left"><a href=""><img src="<?=base_url()?>images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<h5>Halaman Login</h5>
                            <br />
                            <ul class="greyarrow">
								<li>Masukan <strong>Email</strong> yang valid sesusai saat proses registrasi User. dan <strong>Password</strong> yang dikirim melalui Email.</li>
							</ul>
                            <br />
                            <ul class="greyarrow">
								<li>Jika kurang yakin atau lupa dengan password Anda, silahkan klik <a href="<?=site_url().'/forgot/'?>">Lupa Password</a> untuk mendapatkan <strong>Password Baru</strong>. </li>
							</ul>
						</div>
					<!-- end related-act-inner -->
						
					<div class="clear"></div>			
				</div>
				<!-- end related-act-bottom -->
			</div>
			<!-- end related-activities -->
		</td>
	</tr>
	<tr height="30">
		<td><img src="<?=base_url()?>images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
		 
<div class="clear"></div>
		 