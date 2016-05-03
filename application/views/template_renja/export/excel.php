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
          
<<<<<<< HEAD
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold;font-weight:bold" rowspan = 4 colspan = <?php echo isset($colspan) ? $colspan : "3";?> >PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
=======
            <td style="vertical-align:middle;font-size:15px;text-align:center;background-color:#7F7F7F;color:#000;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
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
     <tbody>
			<tr>
				<td>06</td>
<<<<<<< HEAD
				<td style="font-size:12px" colspan='<?php echo isset($colspan) ? $colspan : "3";?>'>PROGRAM BINA PEMBANGUNAN DAERAH</td>
=======
				<td style="font-size:12px" colspan='3'>PROGRAM BINA PEMBANGUNAN DAERAH</td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
				<td> </td>
				<td> </td>
				<td id="f_sum_bo_01"><?php echo isset($t_sum_bo_01)  ? number_format($t_sum_bo_01) : "0"; ?></td>
				<td id="f_sum_bo_02"><?php echo isset($t_sum_bo_02)  ? number_format($t_sum_bo_02) : "0"; ?></td>
				<td id="f_sum_bno_rm_p"><?php echo isset($t_sum_bno_rm_p)  ? number_format($t_sum_bno_rm_p) : "0"; ?></td>
				<td id="f_sum_bno_rm_d"><?php echo isset($t_sum_bno_rm_d)  ? number_format($t_sum_bno_rm_d) : "0"; ?></td>
				<td id="f_sum_bno_phln_p"><?php echo isset($t_sum_bno_phln_p)  ? number_format($t_sum_bno_phln_p) : "0"; ?></td>
				<td id="f_sum_bno_rm_d"><?php echo isset($t_sum_bno_phln_d)  ? number_format($t_sum_bno_phln_d) : "0"; ?></td>
				<td id="f_sum_pnbp"><?php echo isset($t_sum_bno_pnbp)  ? number_format($t_sum_bno_pnbp) : "0"; ?></td>
				<td id="f_sum_pagu"><right><?php echo isset($t_sum_pagu)  ? number_format($t_sum_pagu) : "0"; ?></right></td>
<<<<<<< HEAD
				<td   > </td>
=======
				<td> </td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
				</tr>
			<tr>
				<td></td>
				<td style="font-size:10px" colspan='3'></td><td style="font-size:12px">Meningkatnya kualitas pembangunan daerah yang merupakan perwujudan dari pelaksanaan urusan pemerintahan daerah sebagai bagian integral dari pembangunan nasional</td>
				<td> </td>
				<td></td>
				<td></td><td></td>
				<td></td
				><td></td><td></td><td>
					
				</td><td></td>
<<<<<<< HEAD
				<<td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td>
=======
				<td> </td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
				</tr><tr><td></td>
				<td></td>
				<td  style='vertical-align:middle;font-size:10px;text-align:center'>1</td>
				<td style="font-size:10px">Persentase konsistensi dokumen perencanaan pembangunan daerah</td><td></td>
				<td>50%</td>
				<td></td><td></td><td></td>
				<td></td>
				<td></td><td></td><td></td>
<<<<<<< HEAD
				<td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td>
=======
				<td></td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
				<td></td>
				</tr><tr><td></td>
				<td></td><td  style='vertical-align:middle;font-size:10px;text-align:center'>2</td><td style="font-size:12px">Persentase / 
	       	Jumlah daerah yang menyelenggarakan SIPD</td><td></td>
	       	<td>20% (5 Provinsi)</td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
<<<<<<< HEAD
	       	<td></td><td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td></tr>
=======
	       	<td></td><td></td></tr>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
	       	<tr><td></td><td></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>3</td><td style="font-size:12px">Persentase penyelesaian perselisihan antar susunan tingkat 
	       	pemerintahan terkait dengan urusan pemerintahan</td><td></td>
	       	<td>100%</td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
<<<<<<< HEAD
	       	<td></td><td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td>
=======
	       	<td></td><td></td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
	       	</tr><tr><td></td>
	       	<td></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>4</td>
	       	<td style="font-size:12px">Persentase Penerapan indikator 
	       	utama SPM di daerah</td><td></td>
	       	<td>100% (6 SPM)</td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
	       	<td></td>
<<<<<<< HEAD
	       	<td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td>
=======
	       	<td></td>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
	       	</tr><tr><td></td>
	       	<td></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>5</td>
	       	<td style="font-size:12px">Persentase Penerapan NSPK di daerah</td>
	       	<td></td><td>100% (32 Urusan))</td><td></td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
	       	<td></td><td></td>
<<<<<<< HEAD
	       	<td  colspan='<?php echo isset($colspan2) ? $colspan2 : "1";?>'> </td></tr>
=======
	       	<td></td></tr>
>>>>>>> 179225fbc5444499cd057a7803641f56589fe469
	       	</tr>
	 
    </tbody>
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