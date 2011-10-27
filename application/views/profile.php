<html>
	<head>
		<title>Profil Calon Jamaah</title>
		<style>
			/*
			--------------------------------------------------------------------------------
			What:	"Oranges in the sky" Styles(Table data design)
			Who:	Krasimir Makaveev(krasi [at] makaveev [dot] com)
			When:	15.09.2005(created)
			--------------------------------------------------------------------------------
			*/

			table {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				border-collapse: collapse; 
				border-left: 1px solid #ccc;
				border-top: 1px solid #ccc; 
				color: #333;
			}

			table caption {
				font-size: 1.1em;
				font-weight: bold;
				letter-spacing: -1px;
				margin-bottom: 10px;
				padding: 5px;
				background: #efefef;
				border: 1px solid #ccc;
				color: #666;
			}

			table a {
				text-decoration: none;
				border-bottom: 1px dotted #f60;
				color: #f60;
				font-weight: bold;
			}

			table a:hover {
				text-decoration: none;
				color: #fff;
				background: #f60;
			}

			table tr th a {
				color: #369;
				border-bottom: 1px dotted #369;
			}

			table tr th a:hover {
				color: #fff;
				background: #369;
			}

			table thead tr th {
				text-transform: uppercase;
				background: #e2e2e2;
			}

			table td, table th {
				border-right: 1px solid #ccc;
				border-bottom: 1px solid #ccc;
				padding: 5px;
				line-height: 1.8em;
				font-size: 0.8em;
				vertical-align: top;
				color: #369;
			}

			table tr.odd th, table tr.odd td {
				background: #efefef;
			}
		</style>
	</head>
	<body>
		<table width="100%" border="0" >
			<caption>Profile Calon Jamaah</caption>
			<?php foreach ($jamaah_profile->result() as $row) {?>
			<tr>
				<td width="30%" rowspan="6"><img src="<?php echo base_url().'images/upload/'.$row->FOTO; ?>" width="145" height="180" /></td>
			</tr>
			<tr>
				<th width="25%" scope="row"><a href="#">Nama Lengkap</a></th>
				<td width="45%"><?php echo $row->NAMA_LENGKAP; ?></td>
			</tr>
			<tr class="odd">
				<th>Jenis Kelamin</th>
				<td><?php echo $row->GENDER==1?"Laki-Laki":"Perempuan"; ?></td>
			</tr>
			<tr>
				<th>Kota Asal</th>
				<td><?php echo $row->KOTA." - ".$row->NAMA_PROPINSI; ?></td>
			</tr>
			<tr class="odd">
				<th>Telp / Mobile</th>
				<td><?php $row->TELP!='' ? $separator=' / ' :$separator=''; echo $row->TELP.$separator.$row->MOBILE; ?></td>
			</tr>
			<tr>
				<th>Perihal Pribadi</th>
				<td>
					<?php
						if ($row->PERIHAL_PRIBADI != NULL) {
						$pecah_pribadi = explode(";", $row->PERIHAL_PRIBADI);
					?>
					<ul>
						<?php for($i=0; $i<count($pecah_pribadi); $i++){?>
						<?php if ($pecah_pribadi[$i] == 1) {?>
						<li>Darah Tinggi</li>
						<? } else if ($pecah_pribadi[$i] == 2) {?>
						<li>Takut Ketinggian</li>
						<? } else if ($pecah_pribadi[$i] == 3) {?>
						<li>Perokok</li>
						<? } else if ($pecah_pribadi[$i] == 4) {?>
						<li>Jantung</li>
						<? } else if ($pecah_pribadi[$i] == 5) {?>
						<li>Asma</li>
						<? } else if ($pecah_pribadi[$i] == 6) {?>
						<li>Mendengkur</li>
						<? }}?>
					</ul>
					<?php } ?>
				</td>
			</tr>
			<?php }?>
		</table>
	</body>
</html>