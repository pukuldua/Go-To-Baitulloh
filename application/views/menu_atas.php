<div class="nav-outer"> 
				<? if($this->session->userdata('email') != NULL){ ?>
				<!-- start nav-right -->
				<div id="nav-right">
					<div class="nav-divider">&nbsp;</div>
					<div class="showhide-account"><img src="<?php echo base_url();?>images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></div>
					<div class="nav-divider">&nbsp;</div>
					<a href="<? echo site_url() ?>/logout" id="logout"><img src="<?php echo base_url();?>images/shared/nav/nav_logout.gif" width="64" height="14" alt="" /></a>
					<div class="clear">&nbsp;</div>
				
					<!--  start account-content -->	
					<div class="account-content">
					<div class="account-drop-inner">
						<a href="" id="acc-settings">Change Profile Data</a>
						<div class="clear">&nbsp;</div>
						<div class="acc-line">&nbsp;</div>
						<a href="" id="acc-settings">Change Password</a>
					</div>
					</div>
					<!--  end account-content -->
				</div>
				<!-- end nav-right -->
				<? }?>
								
				<!--  start nav -->
				<div class="nav">
					<div class="table">
                    
                    	<? if($this->session->userdata('email') == NULL) { ?>
						<ul class="<?=($this->uri->segment(1)==='check_availability')?'current':'select'?>">
                          <li>
                          	<a href="<?php echo site_url('check_availability')?>"><b>Check Order Availability</b><!--[if IE 7]><!--></a><!--<![endif]-->
                           </li>
                          </ul>
						<div class="nav-divider">&nbsp;</div>
						<ul class="<?=($this->uri->segment(1)==='login')?'current':'select'?>">
                          <li>
                            <a href="<?php echo site_url('login')?>"><b>Login</b><!--[if IE 7]><!--></a><!--<![endif]-->
                          </li>
                        </ul>
						<? } ?>
                        
						<div class="nav-divider">&nbsp;</div>
                        
						<? if($this->session->userdata('email') != NULL){ ?>
						<ul class="<?=($this->uri->segment(1)==='beranda')?'current':'select'?>">
                          <li>
                        	<a href="<? echo site_url().'/beranda' ?>"><b>Dashboard</b><!--[if IE 7]><!--></a><!--<![endif]-->
                          </li>
                        </ul>
						<div class="nav-divider">&nbsp;</div>		
						
						<ul class="<?=($this->uri->segment(1)==='biodata')?'current':'select'?>">
							<li><a href="<? echo site_url() ?>/biodata"><b>Biodata</b><!--[if IE 7]><!--></a><!--<![endif]-->
								<!--[if lte IE 6]><table><tr><td><![endif]-->
								<div class="select_sub show">
									<ul class="sub">
										<li class="<?=($this->uri->segment(2)==='list_jamaah')?'sub_current':''?>"><a href="<? echo site_url() ?>/biodata/list_jamaah">Daftar Calon Jamaah</a></li>
										<li class="<?=($this->uri->segment(2)==='input')?'sub_current':''?>"><a href="<? echo site_url() ?>/biodata/input">Form Tambah Calon Jamaah</a></li>
									</ul>
								</div>
								<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
						</ul>
						<div class="nav-divider">&nbsp;</div>
					
						<ul class="select"><li><a href="#nogo"><b>Documents</b><!--[if IE 7]><!--></a><!--<![endif]--></li></ul>
						<div class="nav-divider">&nbsp;</div>
					
						<ul class="select"><li><a href="#nogo"><b>Payment</b><!--[if IE 7]><!--></a><!--<![endif]--></li></ul>
						<div class="nav-divider">&nbsp;</div>
					
						<ul class="select"><li><a href="#nogo"><b>Cancellation</b><!--[if IE 7]><!--></a><!--<![endif]--></li></ul>
						<div class="nav-divider">&nbsp;</div>
						
						<ul class="select"><li><a href="#nogo"><b>Rooming</b><!--[if IE 7]><!--></a><!--<![endif]--></li></ul>
						<div class="nav-divider">&nbsp;</div>
						<? }?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>