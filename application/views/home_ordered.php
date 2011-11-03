<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>		
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Grup</th>
					<td>	
						<? if (isset($group)) echo $group ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Kelas Program</th>
					<td>	
						<? if (isset($program)) echo $program ?>
					</td>
					<td></td>
				</tr>
				<tr>					
					<th valign="top">Jumlah Dewasa (*)</th>
					<td>	
						<? if (isset($adult)) echo $adult ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Anak Dengan Ranjang</th>
					<td>	
						<? if (isset($with_bed)) echo $with_bed ?>
					</td>
					<td></td>
				</tr> 
				<tr>
					<th valign="top">Anak Tanpa Ranjang</th>
					<td>	
						<? if (isset($no_bed)) echo $no_bed ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Bayi</th>
					<td>	
						<? if (isset($infant)) echo $infant ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Kamar</th>
					<td class="noheight">
						<div id="dvFile">
							<table border="0" cellpadding="0" cellspacing="0">
								<?php foreach ($room as $row) {?>
								<tr valign="middle">
									<td><? echo $row->JENIS_KAMAR." - "; ?></td>
									<td>Jumlah : <? echo $row->JUMLAH; ?></td>
								</tr>
								<? }?>
							</table>
						</div>
					</td>
					<td></td>
				</tr>
				<? if (isset($waiting) && $waiting){?>
				<tr height="50">
					<th valign="top">Keterangan</th>
					<td>						
						<div class="error-left"></div>
						<div class="error-repeat">
							Anda masuk dalam daftar tunggu untuk pilihan paket di atas.
						</div>		
						<div class="error-inner"></div>
					</td>
					<td></td>
				</tr>
				<? } ?>
				<tr>
					<th></th>
					<td valign="top"></td>
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
						<div class="left"><a href=""><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></a></div>
						<div class="right">
							<? if (isset($waiting) && $waiting){?>
							<h5>Info Waiting List</h5>
							<ul class="greyarrow">
							<li>Akun anda dinonaktifkan untuk sementara waktu.</li>
							<li>Akun anda akan aktif kembali jika status daftar tunggu anda berubah.</li>
							<li>Informasi tentang update status akun anda akan dikirim melalui email.</li>
							</ul>
							<br />Terima kasih.
							<? } else {?>
							<h5>Keterangan Group <a id="info_kode"></a></h5>
                            <br /><i><? echo $keterangan_group; ?></i>
								                                
                              <br />  Keberangkatan :
							<ul class="greyarrow">
								<li><? if (isset($mk)) echo $mk; ?></li> 
							</ul>
                            <div class="lines-dotted-short"></div>	
                               Batas Akhir Pembayaran Uang Muka:
							<ul class="greyarrow">
								<li><? if (isset($dp)) echo $dp; ?></li> 
							</ul>
                            <div class="lines-dotted-short"></div>	
                               Batas Akhir Pelunasan:
							<ul class="greyarrow">
								<li><? if (isset($lunas)) echo $lunas; ?></li> 
							</ul>
                            <div class="lines-dotted-short"></div>	
                                Batas Akhir Upload Data Passport:
							<ul class="greyarrow">
								<li><? if (isset($paspor)) echo $paspor; ?></li> 
							</ul>
                            <div class="lines-dotted-short"></div>	
                                Batas Akhir Pengumpulan Berkas Fisik:
							<ul class="greyarrow">
								<li><? if (isset($berkas)) echo $berkas; ?></li> 
							</ul>
							<? } ?>
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