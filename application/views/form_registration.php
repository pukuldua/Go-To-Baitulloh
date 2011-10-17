<table border="0" width="100%" cellpadding="0" cellspacing="0">
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
					<th valign="top">Nama:</th>
					<td><input type="text" class="inp-form" /></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">E-mail:</th>
					<td><input type="text" class="inp-form-error" /></td>
					<td>
						<div class="error-left"></div>
						<div class="error-inner">This field is required.</div>
					</td>
				</tr>
				<tr>
					<th valign="top">Telp / Mobile:</th>
					<td><input type="text" class="inp-form" /></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Propinsi:</th>
					<td>	
						<? $province = 0; if(set_value('province')!='') $province = set_value('province');
							echo form_dropdown('province', $province_options, $province,'id="province" class="styledselect_form_1"'); ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Kota:</th>
					<td><input type="text" class="inp-form" /></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Alamat:</th>
					<td><input type="text" class="inp-form" /></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">No ID Card (i.e. KTP):</th>
					<td><input type="text" class="inp-form" /></td>
					<td></td>
				</tr>
				<tr>
					<th>Image 1:</th>
					<td><input type="file" class="file_1" /></td>
					<td>
						<div class="bubble-left"></div>
						<div class="bubble-inner">JPEG, GIF 5MB max per image</div>
						<div class="bubble-right"></div>
					</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="button" value="" class="form-submit" />
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
					<img src="images/forms/header_related_act.gif" width="271" height="43" alt="" />
				</div>
				<!-- end related-act-top -->
					
				<!--  start related-act-bottom -->
				<div id="related-act-bottom">
					<!--  start related-act-inner -->
					<div id="related-act-inner">
						<div class="left"><a href=""><img src="images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
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
							
						<div class="left"><a href=""><img src="images/forms/icon_minus.gif" width="21" height="21" alt="" /></a></div>
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
							
						<div class="left"><a href=""><img src="images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
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
		<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
		<td></td>
	</tr>
</table>
		 
<div class="clear"></div>
		 