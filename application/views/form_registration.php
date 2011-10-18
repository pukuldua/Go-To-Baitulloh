<?php echo form_open('registration/do_register'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" onload="showRecaptcha('recaptcha_div');">
	<tr valign="top">
		<td>
			<!--  start step-holder -->
			<div id="step-holder">
				<div class="step-no-off">1</div>
				<div class="step-light-left">Check Order</a></div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no-off">2</div>
				<div class="step-light-left">Result Page</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no">3</div>
				<div class="step-dark-left">Registration Form</div>
				<div class="step-dark-right">&nbsp;</div>
				<div class="step-no-off">4</div>
				<div class="step-light-left">Notification Page</div>
				<div class="step-light-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->
			
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
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
					<th>Masukkan Kode (*):</th>
					<td>
						<script type="text/javascript"
						   src="http://www.google.com/recaptcha/api/challenge?k=6LcdLMkSAAAAAAfa3Zx-jQ0sgWdyfVj2Bo_3njQ1">
						</script>
						<noscript>
						   <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcdLMkSAAAAAAfa3Zx-jQ0sgWdyfVj2Bo_3njQ1"
							   height="300" width="500" frameborder="0"></iframe><br>
						   <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
						   <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
						</noscript>
					</td>
					<td>
						<? if(form_error('recaptcha_response_field') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('recaptcha_response_field'); ?></div>
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
		
		<td>
			<!--  start related-activities -->
			<div id="related-activities">
				
				<!--  start related-act-top -->
				<div id="related-act-top">
					<img src="<?php echo base_url();?>images/forms/header_related_act.gif" width="271" height="43" alt="" />
				</div>
				<!-- end related-act-top -->
					
				<!--  start related-act-bottom -->
				<div id="related-act-bottom">
					<!--  start related-act-inner -->
					<div id="related-act-inner">
						<div class="left"><a href=""><img src="<?php echo base_url();?>images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<h5>Add another product</h5>
								Lorem ipsum dolor sit amet consectetur
								adipisicing elitsed do eiusmod tempor.
							<ul class="greyarrow">
								<li><a href="">Click here to visit</a></li> 
								<li><a href="">Click here to visit</a> </li>
							</ul>
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
							
						<div class="left"><a href=""><img src="<?php echo base_url();?>images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<h5>Delete products</h5>
								Lorem ipsum dolor sit amet consectetur
								adipisicing elitsed do eiusmod tempor.
							<ul class="greyarrow">
								<li><a href="">Click here to visit</a></li> 
								<li><a href="">Click here to visit</a> </li>
							</ul>
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
							
						<div class="left"><a href=""><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<h5>Edit categories</h5>
								Lorem ipsum dolor sit amet consectetur
								adipisicing elitsed do eiusmod tempor.
							<ul class="greyarrow">
								<li><a href="">Click here to visit</a></li> 
								<li><a href="">Click here to visit</a> </li>
							</ul>
						</div>
							<div class="clear"></div>						
					</div>
					<!-- end related-act-inner -->
						
					<div class="clear"></div>			
				</div>
				<!-- end related-act-bottom -->
			</div>
			<!-- end related-activities -->
		</td>
	</tr>
	<tr>
		<td><img src="<?php echo base_url();?>images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
		 
<div class="clear"></div>

<? echo form_close(); ?>
		 