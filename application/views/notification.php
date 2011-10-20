<?php echo form_open('check_availability/do_check'); ?>
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
				<div class="step-no-off">3</div>
				<div class="step-light-left">Registration Form</div>
				<div class="step-light-right">&nbsp;</div>
				<div class="step-no">4</div>
				<div class="step-dark-left">Notification Page</div>
				<div class="step-dark-round">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<!--  end step-holder -->
			
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Nama</th>
					<td><?php echo $account['NAMA_USER']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">E-mail</th>
					<td><?php echo $account['EMAIL']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Telp / Mobile</th>
					<td><?php $account['TELP']!='' ? $separator='/ ' :$separator=''; echo $account['TELP'].' '.$separator.$account['MOBILE']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Propinsi</th>
					<td><?php echo $account['NAMA_PROPINSI']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Kota</th>
					<td><?php echo $account['KOTA']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Alamat</th>
					<td><?php echo $account['ALAMAT']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">No ID Card (i.e. KTP)</th>
					<td><?php echo $account['NO_ID_CARD']; ?></td>
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
								Terima kasih telah melakukan registrasi keberangkatan Umroh pada Umrah Kamilah.
						</div>
							
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>
							
						<div class="left"><img src="<?php echo base_url();?>images/forms/icon_edit.gif" width="21" height="21" alt="" /></div>
						<div class="right">
							<h5>Informasi Registrasi</h5>
								Data Registrasi anda telah masuk ke dalam sistem kami.
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

<script>
	function _add_more() {
		var index = document.getElementsByName('kamar[]');
		var txt = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr valign=\"middle\"><td><select name=\"kamar[]\" id=\"kamar"+index.length+
					"\" class=\"styledselect-kamar\"><option value=\"0\">-- Pilih Jenis Kamar --</option></select></td>"+
					"<td>&nbsp; Jumlah :&nbsp;<select name=\"jml_kamar[]\" id=\"jml_kamar"+index.length+"\" class=\"styledselect-day\">"+
					"<option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option></select></td></tr></table>";
		
		var txt2 = "<select name=\"kamar[]\" id=\"kamar"+index.length+
					"\" class=\"styledselect-kamar\"><option value=\"0\">-- Pilih Jenis Kamar --</option></select><br/>";
					
		var txt3 = "&nbsp; Jumlah :<select name=\"jml_kamar[]\" id=\"jml_kamar"+index.length+"\" class=\"styledselect-day\">"+
					"<option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option></select><br/>";
		document.getElementById("dvFile").innerHTML += txt;
		//document.getElementById("dvFile2").innerHTML += txt2;
		//document.getElementById("dvFile3").innerHTML += txt3;
		
		loadkamar();
	}
	
	function loadkamar() {
		var count = document.getElementsByName('kamar[]');
	    $.ajax({
	           url: "<?=base_url();?>index.php/check_availability/getKamar/",
	           global: false,
	           type: "POST",
	           async: false,
	           //dataType: "html",
	           //data: "produsen="+produsen +"&no_serti="+noserti +"&varietas="+varietas +"&kls_benih="+kls_benih, //the name of the $_POST variable and its value
	           success: function (response) //'response' is the output provided by the controller method prova()
	                    {
							//counts the number of dynamically generated options
							var dynamic_options = $("*").index( $('.dynamic4')[0] );
							//removes previously dynamically generated options if they exists (not equal to 0)
							if ( dynamic_options != (-1)) $(".dynamic4").remove();
								
							for (i = 0; i < count.length; i++){
								$("select#kamar"+i).append(response);
							}
							
		                    $(".selected").attr({selected: ' selected'});
	                   }
	                   
	          });
	    
	          return false;
	}
</script>