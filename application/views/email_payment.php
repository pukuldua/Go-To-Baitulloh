<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />
        
        <title><?php echo $subject; ?></title>
		<style type="text/css">
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

			/* Template Styles */

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COMMON PAGE ELEMENTS /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Page
			* @section background color
			* @tip Set the background color for your email. You may want to choose one that matches your company's branding.
			* @theme page
			*/
			body, #backgroundTable{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Page
			* @section email border
			* @tip Set the border for your email.
			*/
			#templateContainer{
				/*@editable*/ border: 1px solid #DDDDDD;
			}

			/**
			* @tab Page
			* @section heading 1
			* @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			* @style heading 1
			*/
			h1, .h1{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 2
			* @tip Set the styling for all second-level headings in your emails.
			* @style heading 2
			*/
			h2, .h2{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:30px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 3
			* @tip Set the styling for all third-level headings in your emails.
			* @style heading 3
			*/
			h3, .h3{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:26px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ /*text-align:left*/;
			}

			/**
			* @tab Page
			* @section heading 4
			* @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			* @style heading 4
			*/
			h4, .h4{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:22px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ /*text-align:left*/;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: PREHEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section preheader style
			* @tip Set the background color for your email's preheader area.
			* @theme page
			*/
			#templatePreheader{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Header
			* @section preheader text
			* @tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
			*/
			.preheaderContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:10px;
				/*@editable*/ line-height:100%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Header
			* @section preheader link
			* @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
			*/
			.preheaderContent div a:link, .preheaderContent div a:visited, /* Yahoo! Mail Override */ .preheaderContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: HEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section header style
			* @tip Set the background color and border for your email's header area.
			* @theme header
			*/
			#templateHeader{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-bottom:0;
			}

			/**
			* @tab Header
			* @section header text
			* @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
			*/
			.headerContent{
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ padding:0;
				/*@editable*/ text-align:center;
				/*@editable*/ vertical-align:middle;
			}

			/**
			* @tab Header
			* @section header link
			* @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
			*/
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Body
			* @section body style
			* @tip Set the background color for your email's body area.
			*/
			#templateContainer, .bodyContent{
				/*@editable*/ background-color:#FFFFFF;
			}

			/**
			* @tab Body
			* @section body text
			* @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
			* @theme main
			*/
			.bodyContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:14px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Body
			* @section body link
			* @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
			*/
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: FOOTER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Footer
			* @section footer style
			* @tip Set the background color and top border for your email's footer area.
			* @theme footer
			*/
			#templateFooter{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-top:0;
			}

			/**
			* @tab Footer
			* @section footer text
			* @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
			* @theme footer
			*/
			.footerContent div{
				/*@editable*/ color:#707070;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:125%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Footer
			* @section footer link
			* @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
			*/
			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}

			/**
			* @tab Footer
			* @section social bar style
			* @tip Set the background color and border for your email's footer social bar.
			* @theme footer
			*/
			#social{
				/*@editable*/ background-color:#FAFAFA;
				/*@editable*/ border:0;
			}

			/**
			* @tab Footer
			* @section social bar style
			* @tip Set the background color and border for your email's footer social bar.
			*/
			#social div{
				/*@editable*/ text-align:center;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			* @theme footer
			*/
			#utility{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border:0;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			*/
			#utility div{
				/*@editable*/ text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
			
			table.front_price {
			  border-collapse: collapse;
			}
			
			table.front_price td {
			  border-bottom:1px dashed #CCC;
			  padding: 5px;
			  -moz-border-radius: ;
			}
			
			.bg_head {
				background:#F7F7F7;
			}
			
			.bg_head2 {
				background:#FCFCFC;
			}
			
			table.front_payment {
				border-width: 1px;
				border-spacing: 1px;
				border-style: dashed;
				border-color: gray;
				border-collapse: collapse;
			}
			table.front_payment th {
				border-width: 1px;
				padding: 5px;
				border-style: dashed;
				border-color: gray;
				-moz-border-radius: ;
			}
			table.front_payment td {
				border-width: 1px;
				padding: 5px;
				border-style: dashed;
				border-color: #CCC;
				-moz-border-radius: ;
			}
			.garis_pisah {
				border-bottom:1px solid #CCC;
				margin:0px 0px 20px 0px;
				text-align:left;
				font-size:14px;
				font-weight:bold;
				padding:0px 0px 5px 5px;
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                        <!-- // Begin Template Preheader \\ -->
                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent">
                                
                                	<!-- // Begin Module: Standard Preheader \ -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    	<tr>
                                        	<td valign="top">
                                            	<div mc:edit="std_preheader_content">
                                                	 Use this area to offer a short teaser of your email's content. Text here will show in the preview area of some email clients.
                                                </div>
                                            </td>
                                            <!-- *|IFNOT:ARCHIVE_PAGE|* -->
											<td valign="top" width="190">
                                            	<div mc:edit="std_preheader_links">
                                                	Is this email not displaying correctly?<br /><a href="*|ARCHIVE|*" target="_blank">View it in your browser</a>.
                                                </div>
                                            </td>
											<!-- *|END:IF|* -->
                                        </tr>
                                    </table>
                                	<!-- // End Module: Standard Preheader \ -->
                                
                                </td>
                            </tr>
                        </table>
                        <!-- // End Template Preheader \\ -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent">
                                            
                                            	<!-- // Begin Module: Standard Header Image \\ -->
                                            	<img src="<?php echo base_url();?>images/shared/header-email.png" style="max-width:600px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                            	<!-- // End Module: Standard Header Image \\ -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" class="bodyContent">
                                
                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div mc:edit="std_content00">
                                                                <h4 class="h4">Konfirmasi Pembayaran</h4>
                                                              <p><strong>Assalamualaikum, <?php echo $nama_user;?></strong></p>
                                                              <p>Terima kasih kami ucapkan atas pesanan paket umrah Anda bersama kami dan kesediaan Anda untuk melakukan pembayaran paket keberangkatan umrah anda. berikut rincian biaya paket Anda dan biaya yg telah dibayarkan: <br />
<br />
<div class="garis_pisah"> RINCIAN BIAYA</div>
																
<table width="100%" class="front_price" align="center">
	<tr height="30">
		<td width="300" class="bg_head"></td>
		<td width="150" class="bg_head" align="center"><strong>HARGA</strong></td>
		<td width="150" class="bg_head" align="center"><strong>JML. KAMAR</strong></td>
		<td width="150" class="bg_head" align="center"><strong>TOTAL</strong></td>
    </tr>	
	<? 
	if(isset($row_price))
	{
		echo $row_price;
	}
	?>	
	<tr height="30">
		<td align="right" class="front_price_no_border">Biaya Jasa Tambah Nama</td>
		<td align="center">20.00 $</td>
		<td align="center"><? if(isset($hitung_jasa_nama)) { echo $hitung_jasa_nama; } ?></td>
		<td align="center"><? if(isset($hitung_total)) { echo $hitung_total; } ?> $</td>
    </tr>	
	<tr height="30">
		<td align="right" class="front_price_no_border">Biaya Jasa Pengurusan Buku Maningtis</td>
		<td align="center">20.00 $</td>
		<td align="center"><? if(isset($hitung_jasa_maningtis)) { echo $hitung_jasa_maningtis; } ?></td>
		<td align="center"><? if(isset($hitung_total_maningtis)) { echo $hitung_total_maningtis; } ?> $</td>
    </tr>	
	<tr height="30" valign="bottom">
		<td class="bg_head"></td>
		<td class="bg_head"></td>
		<td class="bg_head"><strong>TOTAL BIAYA</strong></td>
		<td class="bg_head" align="center"><strong><? if(isset($total_biaya2)) { echo $total_biaya2; } ?> $</strong></td>
    </tr>
</table>
<br />
<br />
<div class="garis_pisah"> RINCIAN PEMBAYARAN</div>

<table width="100%" class="front_price" align="center">
	<tr height="30">
		<td width="200" class="bg_head">Bank pengirim</td>
		<td width="10" class="bg_head"><strong>:</strong></td>
		<td width="400" class="bg_head"><? echo strtoupper($NAMA_BANK); ?></td>
    </tr>
	<tr height="30">
		<td width="150" class="bg_head2">Rek. Atas Nama</td>
		<td width="10" class="bg_head2"><strong>:</strong></td>
		<td width="500" class="bg_head2"><? echo strtoupper($NAMA_REKENING); ?></td>
    </tr>
	<tr height="30">
		<td width="200" class="bg_head">Jumlah ($)</td>
		<td width="10" class="bg_head"><strong>:</strong></td>
		<td width="400" class="bg_head"><? echo $JUMLAH." $"; ?></td>
    </tr>
	<tr height="30">
		<td width="150" class="bg_head2">Tgl. Transfer</td>
		<td width="10" class="bg_head2"><strong>:</strong></td>
		<td width="500" class="bg_head2"><? echo $TGL_TRANSFER; ?></td>
    </tr>
	<tr height="30">
		<td width="200" class="bg_head">Tipe Pembayaran</td>
		<td width="10" class="bg_head"><strong>:</strong></td>
		<td width="400" class="bg_head"><? ($JENIS == 1) ? $jenis_s = "UANG MUKA" : $jenis_s = "PELUNASAN"; echo $jenis_s;?></td>
    </tr>
	<tr height="30">
		<td width="150" class="bg_head2">Catatan</td>
		<td width="10" class="bg_head2"><strong>:</strong></td>
		<td width="500" class="bg_head2"><? echo $CATATAN; ?></td>
    </tr>
</table>
<br /><br />
															Pesan dan rincian konfirmasi pembayaran ini sudah tersimpan ke dalam sistem dan kami akan segera memproses pembayaran Anda. proses sendiri memerlukan waktu paling lama 3x24 jam dan Anda akan menerima Email Balasan dari kami jika sejumlah uang berdasar rincian di atas yg Anda transfer sudah masuk ke rekening kami.<br />
																Terima Kasih.
                                                              <p>															  
                                                                  <strong>Wassalamualaikum Wr. Wb<br />
                                                                  Umrahkamilah.com
                                                              </strong>                                                            </p>
                                                            </div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Content \\ -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                            
                                                <!-- // Begin Module: Standard Footer \\ -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" width="350">
                                                            <div mc:edit="std_footer">
																<p><strong>Head Office :</strong>
																<br />
																PT. KAMILAH WISATA MUSLIM<br />
																Jl. Haji Nawi Raya no.  10 Gandaria Selatan<br />
																Cilandak  Jakarta Selatan 12420<br />
																Telp : +6221  7279 4230<br />
																Fax : +6221  7590 3619</p>
                                                      </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" id="utility" align="center">
                                                            <div mc:edit="std_utility">
                                                                Online Registration System - Kamilah Wisata<br />
                                                              Membangun Karakter Jamaah Menuju Kehidupan yang Lebih Baik,<br />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Footer \\ -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>