<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1" style="border:none;font-size:15px">
 <thead>
 	<tr>
		<td colspan="15" style="border:none"><center>RENCANA KERJA KEMENTERIAN DALAM NEGERI</center></td>
	</tr>
	<tr>
		<td colspan="15" style="border:none"><center>APBN TAHUN ANGGARAN 2016</center></td>
	</tr>
	<tr>
		<td colspan="15" style="border:none"><center>(Berdasarkan Penyesuaian Nomenklatur SOTK Kemendagri)</center></td>
	</tr>
	<tr>
		<td colspan="15" style="border:none"><center>KOMPONEN: DIREKTORAT JENDERAL BINA PEMBANGUNAN DAERAH</center></td>
	 </tr>
	 <tr>
		<td colspan="15" style="border:none"> </td>
	 </tr>
	 </thead>

    	<tr>
            <td  style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" rowspan = 4>KODE</td>
          
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" rowspan = "4" >SASARAN PROGRAM  <br>(OUTCOME)  <br> / SASARAN KEGIATAN  <br>(OUTPUT)</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
	        <td style="vertical-align:middle;font-size:15px;width:70px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"  rowspan = 4>KL/ AP/QW/ PL/PN</td>
          </tr>
          <tr>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"  rowspan = 3>JUMLAH PAGU</td>
           </tr>
             <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"  colspan = 2>RUPIAH MURNI</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"  colspan = 2>PHLN</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold" rowspan = 2>PNBP</td>
           	
           </tr>	
         <tr>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"><span style='color:#7F7F7F'>'</span>001</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold"><span style='color:#7F7F7F'>'</span>002</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold">RM PUSAT</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold">RM DAERAH</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold">PHLN PUSAT</td>
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold">PHLN DAERAH</td>
	       

 
        </tr>
    </thead>
<tbody id="data_renja_up" style="overflow:scroll;border:1px solid #000">

		<?php 
			if(!empty($table)){
				echo $table;
			} else {
				echo"Table Kosong";
			}
		?>
</tbody>
</table>  