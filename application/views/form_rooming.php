<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.multiselect2side.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.multiselect2side.js" ></script>

<script type="text/javascript">
	$().ready(function() {
		$('#fourth').multiselect2side({
			selectedPosition: 'right',
			moveOptions: false,
			labelsx: ' Available ',
			labeldx: ' Selected ',
			autoSort: false,
			autoSortAvailable: false
			});
		//$('#fourth').multiselect2side({maxSelected: 4});
	});
</script>
	
<?php echo form_open('rooming/book_room'); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>			
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Kamar</th>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">E-mail</th>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Konfirmasi</th>
					<td>
						  <select name="fourthSelect[]" id='fourth' multiple='multiple' >
							<option value="1">First <a href="">Option</a></option>
							<option value="2">Option 2th</option>
							<option value="3" SELECTED >Option selected 3</option>
							<option value="4">Option 4</option>
							<option value="5">Option 5</option>
							<option value="6">Option 6</option>
							<option value="7" SELECTED >Option selected 7</option>
							<option value="8">Option 8</option>
						</select>
						  <br/>
						  <input type="submit" value="Submit Form"/>
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
						<div class="left"><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></div>
						<div class="right">
							<h5>Assalamualaikum Wr Wb</h5>
								Terima kasih telah melakukan pendaftaran keberangkatan Umroh pada Umrah Kamilah.
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
							
						<div class="left"><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></div>
						<div class="right">
							<h5>Informasi Pendaftaran</h5>
								Data Pendaftaran anda telah masuk ke dalam sistem kami.
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
							
						<div class="left"><img src="<?php echo base_url();?>images/forms/icon_plus.gif" width="21" height="21" alt="" /></div>
						<div class="right">
							<h5>Proses Selanjutnya</h5>
								Silakan Cek Email anda untuk melakukan Aktivasi akun dan prosedur selanjutnya.
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