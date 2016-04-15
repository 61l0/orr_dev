   <?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
      <table border="1">
   	<thead>
      	<tr>
      		<td colspan="4">	<h1 style="margin:0px">Rp. <?php echo number_format($selisih);?></h1></td>      		 
      	</tr>    	 
    </thead>
 

    <thead>
      	<tr>
      		<td><b> <?php echo $direktorat;?></b></td>
      		<td><b> TARGET</b></td>
      		<td><b>	REALISASI</b></td>
      		<td><b>	STATUS</b></td>
      	</tr>    	 
    </thead>
	    <tbody>
	    	 <?php echo $tabelnya;?>

	    </tbody>
    </table>
    