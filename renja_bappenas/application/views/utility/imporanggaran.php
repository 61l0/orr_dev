<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- doni star -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	<style type="text/css">
	.container {
		width:1240px;
		margin:0 auto 10px;
		padding:0 60px 10px ;
		border: 1px solid #ddd;
	}
	 div.container {
		padding-top:10px;
	}
	label, input{
		display:block;
	}
	.asd, p {
		border-bottom:1px solid #ddd;
		padding:10px 0;
		margin:0;
	}
	pre {
		background:#FDFFCD;
		margin:10px 0 0 0;
		padding: 10px;
		overflow:auto;
		max-height:350px;
	} 
	</style> 
<script type="text/javascript">
	function data(){
		if(confirm('Apakah Anda yakin akan Import Data Anggaran? Data Lama akan hilang!')){
			document.getElementById("load").style.display="block";
			return true;
		}else{
			return false;
		}
	}	

</script>
</head>
<body>
 

<div class="container">
	<div><center><font size="4"><b />IMPORT DATA RENSTRA </font></center></div><br />
<div id="content">
<form action="" method="post" name="postform" enctype="multipart/form-data" >

	<div>
	
	<table align="center" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
	<tr >
	<td width="60%"><input type="file" name="datafile" size="30" id="gambar" /></td>
	<td width="40%"><center><input type="submit" onClick="data()" name="restore" value="MULAI IMPORT DATA" /></center></td>
	</tr>
	<tr height="70%" >
		<td colspan="2" align="center" ><DIV id="load" style="display:none"> <IMG SRC="<?php echo base_url(); ?>assets/images/loading3.gif" WIDTH="50" HEIGHT="50" BORDER="0" ALT=""></DIV></td>
	</tr>
	</table>
		

	</div>
</form>
</div>
<br />
</body>

</html>

<?php



if(isset($_POST['restore']))
{
	$kdskpd=$this->session->userdata('kdskpd');

	$sql="select nm_skpd from ms_skpd where kd_skpd='$kdskpd'";
	$query=$this->db->query($sql);
	$hasil=$query->row();
	$nm_skpd=$hasil->nm_skpd;

	restore($_FILES['datafile'],$kdskpd,$nm_skpd);
	
	
}
else
{
	unset($_POST['restore']);
}

?>
</div>

<?php


		
 function restore($file,$kode,$nama) {

	$nama_file	= $file['name'];
	$ukrn_file	= $file['size'];
	$tmp_file	= $file['tmp_name'];

	if ($nama_file == "")
	{
		echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
	 	echo '<center><font size="4" color="#FF0000">" File Masih Kosong "</font></center>';
		return; 
	}
	else
	{
	
		if(substr($nama_file,8,9)!="ANGGARAN_")
		{
		echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
		echo '<center><font size="4" color="#FF0000">" File Backup Salah "</font></center>';
		return; 
		}
		
			if(substr($nama_file,17,10)!=$kode)
		{
		echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
		echo '<center><font size="4" color="#FF0000">"File Backup Salah, Bukan data SKPD '.$kode.' - '.$nama.'"</font></center>';
		return; 
		}
		
	
		if(substr(substr($nama_file,-7),0,3)!="_1_")
		{
		echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
		echo '<center><font size="4" color="#FF0000">" File Backup Salah "</font></center>';
		return; 
		}
		
		$valid_xt=substr($nama_file,-3);
	 	if(!($valid_xt == "dny" || $valid_xt == "DNY")){
				echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
				echo '<center><font size="4" color="#FF0000">" File Backup Salah "</font></center>';
				return;
		} 
		
		$alamatfile	="upload/anggaran/".$nama_file;


		if (move_uploaded_file($tmp_file , $alamatfile))
		{			
			$templine	= '';
			
			$lines		= file($alamatfile);
	
			if((substr($lines[0],2,10))!=$kode){
				echo '<center><font size="4" color="#FF0000">PERINGATAN !</font></center>';
				echo '<center><font size="4" color="#FF0000">"File Backup Salah, Bukan data SKPD '.$kode.' - '.$nama.'"</font></center>';
				return; 
			}
		
			foreach ($lines as $line)
			{
						
							
		 		 if (substr($line, 0, 2) == '--' || $line == '')
				continue;
		
				$templine .= $line; 
							
		 	 	  if (substr(trim($line), -1, 1) == ';')
				{ 
			
				 	mysql_query($templine) or print('Query gagal \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
					$templine = ''; 
				} 
			}


			echo '<center><font size="4" color="#009900">" Data Anggaran SKPD '.$kode.' - '.$nama.' Berhasil di Import "</font></center>';
	
		}else{
			echo "Proses upload gagal, kode error = " . $file['error'];
		}	
	}
	
} 
?>

<!-- </body>

</html>
 -->
<!-- doni end -->