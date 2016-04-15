<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table  border="1">
    <thead >
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none">KODE</td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none">APBN TAHUN ANGGARAN 2016</td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none">(Berdasarkan Penyesuaian Nomenklatur SOTK Kemendagri)</td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none"></td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none">KOMPONEN: DIREKTORAT JENDERAL BINA PEMBANGUNAN DAERAH</td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none"></td></tr>
    <tr> <td  colspan="15" style="color:#000;text-align:center;border:none"></td></tr>

 
	<tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" rowspan = 4>KODE</td>
          
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM /   KEGIATAN / INDIKATOR /    KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" rowspan = 4 >SASARAN PROGRAM (OUTCOME)   / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold"  rowspan = 4>KL/ AP/QW/ PL/PN</td>
 	      </tr>
          <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold"  rowspan = 3>JUMLAH PAGU</td>
           </tr>
             <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold"  colspan = 2>RUPIAH MURNI</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold"  colspan = 2>PHLN</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold" rowspan = 2>PNBP</td>
           	
           </tr>	
         <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">001</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">002</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">RM PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">RM DAERAH</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">PHLN PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#A6A6A6;color:#000;font-weight:bold">PHLN DAERAH</td>
	       

 
        </tr>
    </thead>
<tbody id="data_renja_up" style="overflow:scroll">

		<?php 
			if(!empty($table)){
				echo $table;
			} else {
				echo"Table Kosong";
			}
		?>
</tbody>
</table>  