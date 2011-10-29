<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Admin | Online Registration - Kamilah Wisata</title>
		
		<!-- ICON -->
		<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>images/favicon.ico" />
		
		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>css/screen.css" type="text/css" media="screen" title="default" />
		
		<!--  JAVASCRIPT -->
		<script src="<?php echo base_url();?>js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery/custom_jquery.js" type="text/javascript"></script>
	</head>
	
	<body id="login-bg"> 
		<?=form_open('admin/login/cek_login');?>
		<!-- Start: login-holder -->
		<div id="login-holder">
			
			<!-- start logo -->
			<div id="logo-login">
				<a href="index.html"><img src="<?php echo base_url() ?>images/shared/logo.png" width="156" height="40" alt="" /></a>
			</div>
			<!-- end logo -->
			
			<div class="clear"></div>
			
			<!--  start loginbox ................................................................................. -->
			<div id="loginbox">
			
				<!--  start login-inner -->
				<div id="login-inner">
					<? if(isset($cek_form))
						{								
							echo '<div id="message-red">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td class="red-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username atau Password Salah !</td>
										<td class="red-right"><a class="close-red"><img src="'.base_url().'images/table/icon_close_red.gif"   alt="" /></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th></th>
						<td valign="top">
						
						</td>
					</tr>
					<tr>
						<th>Username</th>
						<td><input autocomplete="off" name="username" type="text"  class="login-inp" /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input name="password" type="password" value=""  onfocus="this.value=''" class="login-inp" /></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" class="submit-login" /><input type="reset" class="reset-login" /></td>
					</tr>
					</table>
				</div>
				<!--  end login-inner -->
				<div class="clear"></div>
				<div class="foot-login">- Umroh Online Management System -</div>
			</div>
		 <!--  end loginbox -->
		</div>
		<!-- End: login-holder -->
		<?=form_close()?>
	</body>
</html> 
