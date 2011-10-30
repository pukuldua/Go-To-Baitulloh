<?=$added_js?>
<?=$js_grid;?>
<table id="flex1" style="display:none"></table>

<div class="clear"></div>

<script type="text/javascript">
function show_confirm(txt)
{
	var r=confirm("Konfirmasi untuk mengubah Status Pembayaran menjadi Complete ?");
	if (r==true)
	{
	  window.location=""+txt;
	}
	else
	{
	  
	}
}

</script>