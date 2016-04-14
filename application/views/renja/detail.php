 <br>
 
  <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
<script>
$(function () {
    $("#table_renja").stickyTableHeaders();
});
</script>
	
	<div class="panel panel-primary">
  <!-- Default panel contents -->
  <a href="<?php echo base_url();?>renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
  <!-- Default panel contents -->
  
  <div class="panel-heading">Data Renja

  </div>
  <div class="well">

	 <div id="tabledata" style="overflow-y: hidden;overflow-x: scroll;">
 
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered">
    <thead >
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">KODE</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">KODE IKK</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">KODE <br>KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold;font-weight:bold">PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">001</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">002</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM DAERAH</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN DAERAH</td>
	        <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PNBP</td>
 	        <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">JUMLAH PAGU</td>
	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">KL/<br>AP/QW/<br>PL/PN</td>
 
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

 	 </div>
 </div>
 </div>