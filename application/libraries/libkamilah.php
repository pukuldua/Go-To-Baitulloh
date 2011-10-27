<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Libkamilah {
	
    function cek_session_login()
	{
		$CI =& get_instance();
		$CI->load->library('session');
	
		if($CI->session->userdata('email') == NULL)
			redirect();
  	}//end cek_session
	
}//end class

?>