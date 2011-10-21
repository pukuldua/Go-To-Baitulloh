<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
        	<!--  start step-holder -->
			<div id="step-holder">
				<div class="step-no-off">1</div>
				<div class="step-light-left">Check Order</a></div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no">2</div>
				<div class="step-dark-left">Result Page</div>
				<div class="step-dark-right">&nbsp;</div>
				<div class="step-no-off">3</div>
				<div class="step-light-left">Registration Form</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no-off">4</div>
				<div class="step-light-left">Notification Page</div>
				<div class="step-light-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->
            <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
                	<td>
                    	<h3>
						<? if (isset($message)) echo $message; ?>
						<br /><br />Anda bisa melakukan registrasi online terlebih dahulu, untuk mencatatkan data ke dalam sistem kami.
                        <br />Silahkan login jika anda sudah memiliki akun.
						
                        </h3>
                    </td>
                </tr>
                <tr>
                	<td>
						<h3>
						<? if ($plane_flag) echo "Keberangkatan Jakarta - Jedddah: $depart_jd. <br> Keberangkatan Jakarta - Makkah: $depart_mk."?>
						</h3>
						<br />
						<? if (isset($available_room)) {?>
						<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
							<tr>
								<th>Group</th>
								<th>Program</th>
								<th>Jenis Kamar</th>
								<th>Jumlah Tersedia</th>
							</tr>
							<? foreach($available_room->result() as $row) {?>
							<tr>
								<td><? echo $row->KODE_GROUP; ?></td>
								<td><? echo $row->NAMA_PROGRAM; ?></td>
								<td><? echo $row->JENIS_KAMAR; ?></td>
								<td><? echo $row->JML; ?> Bed</td>
							</tr>
							<? }?>
						</table>
						<? }?>
						
						<? if ($waiting) {?>
                        <h3><br />Anda dapat mencentang poin di bawah ini, Jika bersedia dimasukkan ke dalam daftar waiting list.
                        <br />Jika status waiting list anda berubah, akan kami informasikan via email.
						</h3>						
                    	<?php echo form_open('registration',array('name' => 'form_registrasi')); ?>
                        	<input name="waiting" id="waiting" type="checkbox" value="1" onchange="enableSubmit(this);" />&nbsp;
                            <label for="waiting">Menginginkan masuk Daftar Waiting List</label>
                            <br />
                            <input type="submit" value="" name="submit_button" class="form-submit" disabled="disabled" />
                        <?php echo form_close(); }?>
                    </td>
                </tr>
                <tr>
                	<td>
                    	<a href="<?php echo site_url('registration')?>">
							<img src="<?php echo base_url();?>images/forms/icon_plus.gif" width="21" height="21" alt="" />&nbsp;<strong>Registrasi</strong>
						</a>
                    </td>
                </tr>
            </table>
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
<script>
	function enableSubmit(val){
		if (val.checked)
			document.form_registrasi.submit_button.disabled = false;
		else
			document.form_registrasi.submit_button.disabled = true;
	}
</script>