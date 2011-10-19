<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<?=form_open('/forgot/send');?>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
                	<th valign="top"></th>
					<td>
                    	
                    </td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">E-mail :</th>
					<td><input type="text" name="email" id="email" class="inp-form<?=$cek_error?>" value="<? echo set_value('email') ?>" /></td>
					<td>
						<? echo form_error('email', '<div class="error-left"></div><div class="error-inner">', '</div>'); ?>
                        
                        <? if(isset($cek_form))
							{								
								echo '<div class="error-left"></div><div class="error-inner">
										<strong>Email</strong> tidak ditemukan di Database
									  </div>';
							}
						?>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="submit" value="Send" class="form-submit" />
						<input type="reset" value="" class="form-reset"  />
					</td>
					<td></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top"><br /><ul class="greyarrow"><li><a href="<?=site_url() ?>/login" title="Form Login">Login</a></li></ul></td>
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
							
						<div class="left"><a href=""><img src="<?=base_url()?>images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
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
							
						<div class="left"><a href=""><img src="<?=base_url()?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
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
		<td><img src="<?=base_url()?>images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
		 
<div class="clear"></div>
		 