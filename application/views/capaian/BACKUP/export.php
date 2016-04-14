 <br>
 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
<script>
	$(function () {
	    $("#table_renja").stickyTableHeaders();
	});
 
 
function refresh_table(){
	$.ajax({
			url:'<?php echo base_url(); ?>template_renja/refresh_export/',		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#data_renja_up" ).html(data);
				}  
			 }
		});		
}
 

</script> 
	<div id="konfirmasi" style="display:none"></div>
  	

<div class="panel panel-primary">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
  <a href="<?php echo base_url();?>template_renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		 <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
 <div class="panel-heading">Data Renja

 </div>
   <div class="well">
   &nbsp; Filter: 
   <form id="form_simpan" name="form_simpan" method="POST" action="<?php echo base_url();?>template_renja/export_now">
 		<?php echo $tahun_anggaran;?> &nbsp; &nbsp;  &nbsp;  <?php echo $get_direktorat;?>  <button class="btn btn-primary"> <i class="glyphicon glyphicon-export"></i>  Export To Excel </button>
 </form>
 <br>
<div id="tabledata">
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered" style="width:100%;">
    <thead >
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>KODE</td>
          
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4 >SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>KL/<br>AP/QW/<br>PL/PN</td>
 
         </tr>
          <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>JUMLAH PAGU</td>
           </tr>
             <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  colspan = 2>RUPIAH MURNI</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  colspan = 2>PHLN</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 2>PNBP</td>
           	
           </tr>	
         <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">001</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">002</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM DAERAH</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN DAERAH</td>
	       

 
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

 	 </div>
 </div>
 </div>