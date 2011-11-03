<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Online Registration - Kamilah Wisata</title>
		
		<!-- ICON -->
		<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/favicon.ico" />
		
		<link rel="stylesheet" href="<?php echo base_url();?>css/screen.css" type="text/css" media="screen" title="default" />
        <link rel="stylesheet" href="<?php echo base_url();?>css/flexigrid.css" type="text/css" />
		<!--[if IE]>
		<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
		<![endif]-->

		<!--  jquery core -->
		<script src="<?php echo base_url();?>js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
		 
		<!--  checkbox styling script -->
		<script src="<?php echo base_url();?>js/jquery/ui.core.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery/ui.checkbox.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery/jquery.bind.js" type="text/javascript"></script>
		
		<script type="text/javascript">
		$(function(){
			$('input').checkBox();
			$('#toggle-all').click(function(){
			$('#toggle-all').toggleClass('toggle-checked');
			$('#mainform input[type=checkbox]').checkBox('toggle');
			return false;
			});
		});
		</script>  

		<![if !IE 7]>

		<!--  styled select box script version 1 -->
		<script src="<?php echo base_url();?>js/jquery/jquery.selectbox-0.5.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
		});
		</script>
		 
		<![endif]>

		<!--  styled select box script version 2 --> 
		<script src="<?php echo base_url();?>js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
			$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
		});
		</script>

		<!--  styled select box script version 3 --> 
		<script src="<?php echo base_url();?>js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
		});
		</script>

		<!--  styled file upload script --> 
		<script src="<?php echo base_url();?>js/jquery/jquery.filestyle.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
		$(function() {
			$("input.file_1").filestyle({ 
			image: "<?php echo base_url() ?>images/forms/upload_file.gif",
			imageheight : 29,
			imagewidth : 78,
			width : 110
			});
		});
		</script>

		<!-- Custom jquery scripts -->
		<script src="<?php echo base_url();?>js/jquery/custom_jquery.js" type="text/javascript"></script>
		 
		<!-- Tooltips -->
		<script src="<?php echo base_url();?>js/jquery/jquery.tooltip.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery/jquery.dimensions.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function() {
			$('a.info-tooltip ').tooltip({
				track: true,
				delay: 0,
				fixPNG: true, 
				showURL: false,
				showBody: " - ",
				top: -35,
				left: 5
			});
		});
		</script> 

		<!--  date picker script -->
		<link rel="stylesheet" href="<?php echo base_url();?>css/datePicker.css" type="text/css" />
		<script src="<?php echo base_url();?>js/jquery/date.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery/jquery.datePicker.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			$(function()
			{
				// initialise the "Select date" link
				$('#date-pick')
				.datePicker(
					// associate the link with a date picker
					{
						createButton:false,
						startDate:'01/01/2005',
						endDate:'31/12/2020'
					}
				).bind(
					// when the link is clicked display the date picker
					'click',
					function()
					{
						updateSelects($(this).dpGetSelected()[0]);
						$(this).dpDisplay();
						return false;
					}
				).bind(
					// when a date is selected update the SELECTs
					'dateSelected',
					function(e, selectedDate, $td, state)
					{
						/*updateSelects(selectedDate);*/
						var bulan = parseInt(selectedDate.getMonth()) + 1;
						document.getElementById('date_on').value = +selectedDate.getDate()+'/'+bulan+'/'+selectedDate.getFullYear();
					}
				).bind(
					'dpClosed',
					function(e, selected)
					{
						updateSelects(selected[0]);
					}
				);
				
				var updateSelects = function (selectedDate)
				{
					var selectedDate = new Date(selectedDate);
					/*
					$('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
					$('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
					$('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
					*/
				}
				
				// listen for when the selects are changed and update the picker
				$('#d, #m, #y')
				.bind(
					'change',
					function()
					{
						var d = new Date(
									$('#y').val(),
									$('#m').val(),
									$('#d').val()
								);
						$('#date-pick').dpSetSelected(d.asString());
					}
				);

				// default the position of the selects to today
				var today = new Date();
				updateSelects(today.getTime());

				// and update the datePicker to reflect it...
				$('#d').trigger('change');
			});
		</script>

		<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
		<script src="<?php echo base_url();?>js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			$(document).pngFix( );
			});
		</script>
		<!--<script type="text/javascript" src="<?php echo base_url();?>js/jquery.pack.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url();?>js/flexigrid.pack.js"></script>
	</head>
	
	<body> 
		<!-- Start: page-top-outer -->
		<div id="page-top-outer">    

			<!-- Start: page-top -->
			<div id="page-top">

				<!-- start logo -->
				<div id="logo">
					<a href=""><img src="<?php echo base_url();?>images/shared/logo.png" width="320" height="73" alt="" /></a>
				</div>
				<!-- end logo -->

			</div>
			<!-- End: page-top -->

		</div>
		<!-- End: page-top-outer -->
		
		<div class="clear">&nbsp;</div>
	 	
		<!--  start nav-outer-repeat.................................................. START -->
		<div class="nav-outer-repeat"> 
			<!--  start nav-outer -->

            <? echo $this->load->view('menu_atas'); ?>
				<!--  start nav -->
			</div>
			<div class="clear"></div>
			<!--  start nav-outer -->
		</div>
		<!--  start nav-outer-repeat................................................... END -->
		 
		<div class="clear"></div>
	 
		<!-- start content-outer -->
		<div id="content-outer">
			<!-- start content -->
			<div id="content">
				<? if($this->session->userdata('email') == NULL) { ?>
				<div id="page-heading"><h1></h1></div>
				<? } else { ?>
				<div id="page-heading"><h4>Assalamualaikum, <strong><? echo ucwords($this->session->userdata('nama')); ?></strong></h4></div>
                <? } ?>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
					<tr>
						<th rowspan="3" class="sized"><img src="<?php echo base_url();?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
						<th class="topleft"></th>
						<td id="tbl-border-top">&nbsp;</td>
						<th class="topright"></th>
						<th rowspan="3" class="sized"><img src="<?php echo base_url();?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
					</tr>
					
					<tr>
						<td id="tbl-border-left"></td>
						<td>
							<!--  start content-table-inner ---------------------------------------------------------------------------------->
							<div id="content-table-inner">
								<?php echo $content;?>
							</div>
							<!--  end content-table-inner  -->
						</td>
						<td id="tbl-border-right"></td>
					</tr>
					
					<tr>
						<th class="sized bottomleft"></th>
						<td id="tbl-border-bottom">&nbsp;</td>
						<th class="sized bottomright"></th>
					</tr>
				</table>
					 
				<div class="clear">&nbsp;</div>
			</div>
		</div>
		
		<!-- start footer -->         
		<div id="footer">
			<!--  start footer-left -->
			<div id="footer-left">Online Registration System | Kamilah Wisata - Membangun Karakter Jamaah Menuju Kehidupan yang Lebih Baik,</div>
			<!--  end footer-left -->
			<div class="clear">&nbsp;</div>
		</div>
		<!-- end footer -->
	</body>
</html> 
