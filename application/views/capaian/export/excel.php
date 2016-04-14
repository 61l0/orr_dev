  <?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
   <table border="1" style="font-size:12px">
    <thead>
   		<tr>
      		<td  colspan="44"><h2><?php echo strtoupper($tipe .'-'.$judul);?></h2></td>
      	 
      	</tr>
      	<tr>
      		<td style="background-color:#ECF0F1;height:30px;vertical-align:middle" colspan="5"><center><b>Uraian</b></center></td>
			<td rowspa="4" style="background-color:#ECF0F1;vertical-align:middle" >TARGET</td> 	 

      		<td style="background-color:#ECF0F1;vertical-align:middle" rowspan=3  ><center><b>PAGU</td> 	 
      		 <td style="background-color:#ECF0F1;vertical-align:middle"  rowspan=3 ><center><b>TARGET  KEUANGAN</td> 	
      		 <td style="background-color:#ECF0F1;vertical-align:middle"  rowspan=3 ><center><b>TARGET  KINERJA</td> 	
 			<td colspan="13" style="background-color:#ECF0F1;vertical-align:middle" ><center><b> CAPAIAN KINERJA</b></center></td>
 			<td colspan="22" style="background-color:#ECF0F1;vertical-align:middle" ><center><b> CAPAIAN KEUANGAN</b></center></td>
       	</tr>
      	<tr>
      		<td colspan="6" style="background-color:#ECF0F1;vertical-align:middle"></td>
 
       		<td colspan="3" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN I</b></center></td>
      		<td colspan="3" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN II</b></center></td>
      		<td colspan="3" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN III</b></center></td>
      		<td colspan="3" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN IV</b></center></td>
      		<td rowspan=2 style="background-color:#ECF0F1;vertical-align:middle"><center><b>Total</b></center></td>
 
      		<td colspan="5" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN I</b></center></td>
      		<td colspan="5" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN II</b></center></td>
      		<td colspan="5" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN III</b></center></td>
      		<td colspan="5" style="background-color:#ECF0F1;width:100px;height:30px;vertical-align:middle" ><center><b>TRIWULAN IV</b></center></td>
      		<td rowspan=2 style="background-color:#ECF0F1;vertical-align:middle"><center><b>Total</b></center></td>
 	        <td rowspan=2 style="background-color:#ECF0F1;vertical-align:middle"><center><b>%</b></center></td>

      	</tr>
    	<tr>
			<td style="background-color:#ECF0F1;vertical-align:middle">KODE</td>          
            <td style="background-color:#ECF0F1;vertical-align:middle" colspan = 3>PROGRAM /  KEGIATAN / INDIKATOR /   KOMPONEN INPUT</td>
            <td  colspan="2" style="background-color:#ECF0F1;vertical-align:middle" >SASARAN PROGRAM (OUTCOME)   / SASARAN KEGIATAN (OUTPUT)</td>
   	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>1</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>2</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>3</center></td>
 	        
 
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>4</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>5</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>6</center></td>

 

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>7</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>8</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>9</center></td>

 

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>10</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>11</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>12</center></td>

 
 	        





 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>1</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>2</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>3</center></td>
 	        
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>RP</td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>%</td>

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>4</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>5</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>6</center></td>

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>RP</td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>%</td>


 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>7</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>8</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>9</center></td>

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>RP</td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>%</td>


 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>10</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>11</center></td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><center>12</center></td>

 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>RP</td>
 	        <td style="background-color:#ECF0F1;vertical-align:middle"><br>%</td>

          </tr>
          
    </thead>
    <tbody>
<?php 
	if(!empty($table)){
		echo $table;
	} else {
		echo"Table Kosong";
	}
?>
	</tbody>
</table> 
 