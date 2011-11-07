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
	});
	
	function enableSubmit(val){
		if (val.checked)
			document.form_rooming.submit_button.disabled = false;
		else
			document.form_rooming.submit_button.disabled = true;
	}
	
	function getJamaah(room){
		if (room.value != 0 && room.selectedIndex != 0){
			var prp = room[room.selectedIndex].text;			
			document.getElementById("div_room").innerHTML = prp;
			
				$.ajax({
						url: "<?=base_url();?>index.php/rooming/getJamaah/",
						global: false,
						type: "POST",
						async: false,
						dataType: "html",
						data: "id_room="+ room.value, //the name of the $_POST variable and its value
						success: function (response) {
							 document.getElementById("div_prev").innerHTML = response;
						}
				});
							
				$.ajax({
						url: "<?=base_url();?>index.php/rooming/getMax_room/",
						global: false,
						type: "POST",
						async: false,
						dataType: "html",
						data: "id_room="+ room.value, //the name of the $_POST variable and its value
						success: function (response) {
							var sisa = "Kuota Maksimum Kamar "+prp+" =  ";
							document.getElementById("div_max").innerHTML = sisa+response+" Orang";
							$('#fourth').multiselect2side('destroy');
							$('#fourth').multiselect2side({
								selectedPosition: 'right',
								moveOptions: false,
								labelsx: ' Available ',
								labeldx: ' Selected ',
								autoSort: false,
								autoSortAvailable: false,
								maxSelected: response
							});
						}
				});
		}else {
			document.getElementById("div_room").innerHTML = "";
			document.getElementById("div_max").innerHTML = "";
			document.getElementById("div_prev").innerHTML = "";
		}
		// return false;
	}
</script>

<?php echo form_open('rooming/book_room', array('name' => 'form_rooming')); ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td>			
			<!-- start id-form -->
			<? if ($is_pay){ ?>
			<? if ($is_booking) {?>
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Nama</th>
					<th valign="top">Jenis Kelamin</th>
					<th valign="top">Tipe Kamar</th>
					<th valign="top">Kode Kamar</th>
				</tr>
				<? foreach ($candidate_inroom->result() as $row) {?>
				<tr>
					<td><? echo $row->NAMA_LENGKAP; ?></td>
					<td><? echo $row->GENDER==1 ?  "Laki-laki": "Perempuan"; ?></td>
					<td><? echo $row->JENIS_KAMAR; ?></td>
					<td><? echo $row->KODE_KAMAR; ?></td>
				</tr>
				<? }?>
			</table>
			<? } else {?>
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
				<tr>
					<th valign="top">Kamar</th>
					<td>
						<? $room = 0; if(set_value('room')!='') $room = set_value('room');
							echo form_dropdown('room', $room_options, $room,'id="room" class="styledselect-kamar2" onchange="getJamaah(this);"'); ?>
					</td>
					<td>
						<? if(form_error('room') != '') {?>
						<div class="error-left"></div>
						<div class="error-inner"><?php echo form_error('room'); ?></div>
						<? }?>
					</td>
				</tr>
				<tr>
					<th valign="top">Pemesanan Kamar</th>
					<td>
						<? if (isset($list_candidate)) {$candidate = 0; if(set_value('candidate[]')!='') $candidate = set_value('candidate[]');
							echo form_dropdown('candidate[]', $list_candidate, $candidate,'id="fourth" multiple="multiple"'); }?>
						<br /><br />
						<div id="div_max"></div>
					</td>
					<td></td>
				</tr>
				<tr>
					<th valign="top">Konfirmasi</th>
					<td>
						<input name="setuju" id="setuju" type="checkbox" value="1" onchange="enableSubmit(this);" />&nbsp;
						<label for="setuju">Yakin dan Setuju</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td valign="top">
						<input type="submit" value="" name="submit_button" class="form-submit" disabled="disabled" />
					</td>
					<td></td>
				</tr>
			</table>
			<? }} else {?>
			<div class="form-front2">
			<h2>
				Maaf, Anda tercatat belum melakukan pembayaran.
				<br /> Silahkan melakukan pembayaran pada rekening yang tersedia (disamping).
				<br /> Dan lakukan konfirmasi melalui menu <strong>Pembayaran</strong>
			</h2>
			</div>
			<? }?>
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
						<? if ($is_pay) {?>
						<div class="right">
							<h5>Data Jamaah Kamar : <div id="div_room"></div></h5>							
						</div>
						<? } else {?>
						<div class="right">
							<h5>Rekening untuk pembayaran : </h5>
							<strong>BANK MUAMALAT cab. Kemayoran<br />
							a.n. PT KAMILAH WISATA MUSLIM<br />
							US Dollar : 2300-300-723 <br />
							ID Rupiah : 2300-723-723</strong><br /><br />
							<strong>Bank Mandiri Cab. PIM 1 Pondok Indah<br />
							a.n. PT KAMILAH WISATA MUSLIM<br />
							USDollar : 101-000-644-5454<br />
							IDRupiah : 101-000-644-5421</strong>
						</div>
						<? }?>
						<div class="clear"></div>
						<div class="lines-dotted-short"></div>						
						
						<div class="right" id="div_prev"></div>
						
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