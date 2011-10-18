<?php echo form_open('check_availability/do_check'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
			<!--  start step-holder -->
			<div id="step-holder">
				<div class="step-no">1</div>
				<div class="step-dark-left"><a href="">Check Order</a></div>
				<div class="step-dark-right">&nbsp;</div>
				<div class="step-no-off">2</div>
				<div class="step-light-left">Result Page</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no-off">3</div>
				<div class="step-light-left">Registration Form</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no-off">4</div>
				<div class="step-light-left">Notification Page</div>
				<div class="step-light-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->
			
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Group:</th>
					<td>	
						<? $group = 0; if(set_value('group')!='') $group = set_value('group');
							echo form_dropdown('group', $group_options, $group,'id="group" class="styledselect_form_1"'); ?>
					</td>
					<td>
						<? if(form_error('group') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('group'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Kelas Program:</th>
					<td>	
						<? $program = 0; if(set_value('program')!='') $program = set_value('program');
							echo form_dropdown('program', $program_options, $program,'id="program" class="styledselect_form_1"'); ?>
					</td>
					<td>
						<? if(form_error('program') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('program'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('jml_adult') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Jumlah Adult:</th>
					<td><input type="text" name="jml_adult" value="<?php echo set_value('jml_adult');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('jml_adult') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('jml_adult'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('with_bed') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Child With Bed (*):</th>
					<td><input type="text" name="with_bed" value="<?php echo set_value('with_bed');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('with_bed') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('with_bed'); ?></div>
						<? }?>
					</td>
				</tr> 
				<tr>
					<? form_error('no_bed') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Child No Bed:</th>
					<td><input type="text" name="no_bed" value="<?php echo set_value('no_bed');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('no_bed') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('no_bed'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<? form_error('infant') == '' ? $class = 'inp-form':$class = 'inp-form-error'; ?>
					<th valign="top">Infant:</th>
					<td><input type="text" name="infant" value="<?php echo set_value('infant');?>" class="<? echo $class;?>" /></td>
					<td>
						<? if(form_error('infant') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('infant'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Kamar:</th>
					<td class="noheight">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr  valign="top">
								<td>
									<form id="chooseDateForm" action="#">									
										<select id="d" class="styledselect-day">
											<option value="">dd</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
											<option value="29">29</option>
											<option value="30">30</option>
											<option value="31">31</option>
										</select>
								</td>
								<td>&nbsp;</td>
								<td>
									Jumlah :
									<select id="m" class="styledselect-day">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
									</select>&nbsp;
								</td>
								<td><a href=""  id="date-pick"><img src="<?php echo base_url();?>images/forms/icon_plus.gif"   alt="" /></a></td>
							</tr>
						</table>									
					</td>
					<td></td>
				</tr>				
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="submit" value="" class="form-submit" />
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