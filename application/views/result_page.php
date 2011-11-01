<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>
        	<!--  start step-holder -->
			<div id="step-holder">
				<div class="step-no-off">1</div>
				<div class="step-light-left">Cek Ketersediaan</a></div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no">2</div>
				<div class="step-dark-left">Hasil Pengecekan</div>
				<div class="step-dark-right">&nbsp;</div>
				<div class="step-no-off">3</div>
				<div class="step-light-left">Pendaftaran</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no-off">4</div>
				<div class="step-light-left">Notifikasi</div>
				<div class="step-light-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->
            <table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
                	<td colspan="2">
                    	<h3>Berdasarkan paket pilihan anda</h3>
						<strong><pre>Group Keberangkatan : <?php echo $kode_group;?></pre></strong>
						<br /><strong><pre>Kelas Program &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $nama_program;?></pre></strong>
						<br />
                    </td>
                </tr>
				<tr>
					<td width="290">
						<h3>Calon Jamaah:</h3>
						<strong><pre>Jumlah Adult &nbsp;&nbsp;&nbsp;<?php echo $jml_adult;?></pre></strong>
						<br /><strong><pre>Child With Bed &nbsp;<?php echo $with_bed;?></pre></strong>
						<br /><strong><pre>Child No Bed &nbsp;&nbsp;&nbsp;<?php echo $no_bed;?></pre></strong>
						<br /><strong><pre>Infant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $infant;?></pre></strong>
						<br /><strong><pre>Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($jml_adult+$with_bed+$no_bed+$infant);?></pre></strong>
						<br />
					</td>
					<td width="513" valign="top">
                    	<h3>Pilihan Kamar:</h3>
						<? foreach($room_choice as $row) { echo "<strong>$row</strong><br />"; }?>
                    </td>
				</tr>
				<tr>
					<td colspan="2">
						<h3>
						<? if (isset($message)) echo $message; ?>
						<br /><br />Anda bisa melakukan registrasi online terlebih dahulu, untuk mencatatkan data ke dalam sistem kami.
                        <br />Silahkan login jika anda sudah memiliki akun.						
                        </h3>
					</td>
				</tr>
                <tr>
                	<td colspan="2">
						<? if (isset($available_room)) {?>
						Ketersediaan kamar untuk group keberangkatan : <strong><?php echo $kode_group;?></strong>
						<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
							<tr>
								<th>Program</th>
								<th>Jenis Kamar</th>
								<th>Jumlah Kamar</th>
								<th>Jumlah Beds</th>
							</tr>
							<? foreach($available_room->result() as $row) {?>
							<tr>
								<td><? echo $row->NAMA_PROGRAM; ?></td>
								<td><? echo $row->JENIS_KAMAR; ?></td>
								<td><? echo $row->JML; ?> </td>
								<td><? echo $row->JML_BEDS; ?> Bed(s)</td>
							</tr>
							<? }?>
						</table>
						<? }?>
                    </td>
                </tr>
				<tr>
					<td colspan="2">
						<? if ($waiting) {?>
                        <h3>Anda dapat mencentang poin di bawah ini, jika bersedia dimasukkan ke dalam daftar tunggu.
						</h3>						
                    	<?php echo form_open('registration',array('name' => 'form_registrasi')); ?>
							<div style="display: none;" >
								<input type="text" name="group" value="<?php echo $group; ?>" />
								<input type="text" name="program" value="<?php echo $program; ?>" />
								<input type="text" name="jml_adult" value="<?php echo $jml_adult; ?>" />
								<input type="text" name="with_bed" value="<?php echo $with_bed; ?>" />
								<input type="text" name="no_bed" value="<?php echo $no_bed; ?>" />
								<input type="text" name="infant" value="<?php echo $infant; ?>" />
								
								<? $no=0; foreach($room_choice2 as $row) {?>
								<input name="kamar[]" id="kamar<? echo $no;?>" value="<? echo $row['ID_ROOM_TYPE']; ?>" />
								<input name="jml_kamar[]" id="jml_kamar<? echo $no;?>" value="<? echo $row['JUMLAH'];?>" />
								<? $no++; }?>
							</div>
							
                        	<input name="waiting" id="waiting" type="checkbox" value="1" onchange="enableSubmit(this);" />&nbsp;
                            <label for="waiting">Menginginkan masuk Daftar Tunggu</label>
                            <br />
                            <input type="submit" value="" name="submit_button" class="form-submit" disabled="disabled" />
                        <?php echo form_close(); }?>
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
						<div class="left"><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></div>
						<div class="right">
							<? if ($plane_flag) {?>
							<h5>Info Keberangkatan</h5>								
							<ul class="greyarrow">
								<li> Jakarta - Jedddah: <? echo "$depart_jd"; ?></li> 
								<li> Jakarta - Makkah: <? echo "$depart_mk" ?></li>
							</ul>
							<? }?>
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
						
						<div class="left"><a href="<?php echo site_url('registration')?>"><img src="<?php echo base_url();?>images/forms/icon_plus.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<h5><a href="<?php echo site_url('registration')?>">Registration</a></h5>
								Form Registrasi Calon Jamaah Umroh
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