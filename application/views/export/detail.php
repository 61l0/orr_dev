    <br>
 
 
 	<script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
    
 	
    <style>
	  .input-medium{
	  	height:35px !important;
	  } 
	  a{
	  	color:#000;
	  	text-decoration:none;
	  }
    </style> 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
 
  <script>
 
 function load_table(){
 	$.ajax({
			url:'<?php echo base_url(); ?>export/echo_table_renja/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#data_renja_up").html(data);	
			  	  dokumen_sudah_siap()
 			 }
		});	
 }
 </script>
<script>
 $(function () {
	    $("#table_renja").stickyTableHeaders();
	    load_table()
	   
 });
 
 
</script>
<script>
 function formatDollar(num) {
		 return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	function dokumen_sudah_siap(){
			var sum_bo_01 =0;
	var sum_bo_02 =0;
	var sum_bno_rm_p =0;
	var sum_bno_rm_d =0;
	var sum_bno_phln_p =0;
	var sum_bno_phln_d =0;
	var sum_bno_pnbp =0;
	var sum_pagu =0;
		  $( ".is_indikator_bo01" ).each(function( index ) {		
					 	sum_bo_01=parseInt(sum_bo_01) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bo02" ).each(function( index ) {		
					 	sum_bo_02=parseInt(sum_bo_02) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_rm_p" ).each(function( index ) {		
					 	sum_bno_rm_p=parseInt(sum_bno_rm_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_rm_d" ).each(function( index ) {		
					 	sum_bno_rm_d=parseInt(sum_bno_rm_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_phln_p" ).each(function( index ) {		
					 	sum_bno_phln_p=parseInt(sum_bno_phln_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_phln_d" ).each(function( index ) {		
					 	sum_bno_phln_d=parseInt(sum_bno_phln_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_pnbp" ).each(function( index ) {		
					 	sum_bno_pnbp=parseInt(sum_bno_pnbp) + parseInt($(this).text().replace(/,/g, '') );
					 });	
					  $( ".is_indikator_pagu" ).each(function( index ) {		
					  	sum_pagu=parseInt(sum_pagu) + parseInt($(this).text().replace(/,/g, '') );
					 });


					 $("#f_sum_bo_01").html(formatDollar(sum_bo_01));
					 $("#f_sum_bo_02").html(formatDollar(sum_bo_02));
					 $("#f_sum_bno_rm_p").html(formatDollar(sum_bno_rm_p));
					 $("#f_sum_bno_rm_d").html(formatDollar(sum_bno_rm_d));
					 $("#f_sum_bno_phln_p").html(formatDollar(sum_bno_phln_p));
					 $("#f_sum_bno_phln_d").html(formatDollar(sum_bno_phln_d));
					 $("#f_sum_bno_pnbp").html(formatDollar(sum_bno_pnbp));
					 $("#f_sum_pagu").html(formatDollar(sum_pagu));

					 $("#t_sum_bo_01").val((sum_bo_01));
					 $("#t_sum_bo_02").val((sum_bo_02));
					 $("#t_sum_bno_rm_p").val((sum_bno_rm_p));
					 $("#t_sum_bno_rm_d").val((sum_bno_rm_d));
					 $("#t_sum_bno_phln_p").val((sum_bno_phln_p));
					 $("#t_sum_bno_phln_d").val((sum_bno_phln_d));
					 $("#t_sum_bno_pnbp").val((sum_bno_pnbp));
					 $("#t_sum_pagu").val((sum_pagu));
	}
</script>
	<script>
 	function export_to_renja_bappenas(){
   		$.ajax({
			url:'<?php echo base_url(); ?>export/export_renja_bappenas/<?php echo $id;?>',		 
			type:'POST',
			data:$('#form_status_perbaikan').serialize(),
			 beforeSend: function() {
			 	$("#div_renja_bappenas").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_renja_bappenas").dialog({ title:"Info...", modal: true,width:"500",buttons: {
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }});
				$(".ui-button").hide();
			  },
			success:function(data){ 
				if(data!=""){
					$("#div_renja_bappenas").html(data);
					$(".ui-button").show();
				} else {
					$("#div_renja_bappenas").html("<i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Melakukan Export Data.... <br><a href='<?php echo base_url();?>renja_bappenas' target='_blank'><i style='color:#243241' class='glyphicon glyphicon-arrow-right'></i> Menuju Aplikasi...</a> ");
					$(".ui-button").show();
				}
				//$("#konfirmasi").dialog({ modal: true});
				//$("#konfirmasi").dialog({ modal: true});
			 	//$("#konfirmasi").html('Sukses Export Data !!!');
			 	//$("#konfirmasi").dialog({ buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
			 	//$(".loading_div").fadeOut();
			 }
		});		
	}
	function confirm_export(){
		$("#konfirmasi").html('Anda Ingin Melakukan Export Data Ini ? ');
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 export_to_renja_bappenas();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
	}
	function confirm_export_excel(id){
		$("#konfirmasi").html('Anda Ingin Melakukan Export Data Ini ? ');
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 // window.location="<?php echo base_url() ?>export/export_to_excel/"+id;
						  $("#form_status_perbaikan").submit();
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 		
	} 			
	</script>
	<div id="div_renja_bappenas" style="display:none"></div>
	<form id="form_status_perbaikan" name="form_status_perbaikan" method="POST" action="<?php echo base_url() ?>export/export_to_excel/<?php echo $id;?>">
		<div id="konfirmasi" style="display:none"></div>
		<input type="hidden" value="<?php echo $kd_unit_kerja;?>"  name="direktorat" id="direktorat" >
		<input type="hidden" id="t_sum_bo_01" name="t_sum_bo_01" value="0">
		<input type="hidden" id="t_sum_bo_02" name="t_sum_bo_02" value="0">
		<input type="hidden" id="t_sum_bno_rm_p" name="t_sum_bno_rm_p" value="0">
		<input type="hidden" id="t_sum_bno_rm_d" name="t_sum_bno_rm_d" value="0">
		<input type="hidden" id="t_sum_bno_phln_p" name="t_sum_bno_phln_p" value="0">
		<input type="hidden" id="t_sum_bno_phln_d" name="t_sum_bno_phln_d" value="0">
		<input type="hidden" id="t_sum_bno_pnbp" name="t_sum_bno_pnbp" value="0">
		<input type="hidden" id="t_sum_pagu" name="t_sum_pagu" value="0">
 	</form>
    	

<div class="panel panel-primary">
 <a href="<?php echo base_url();?>export" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		 <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
 <div class="panel-heading">Export Data Renja - <?php echo $direktorat;?>

 </div>
<div class="well">
<a class="btn btn-primary btn-sm btn-block pull-left" style="background-color:#fff;color:#000;border:none;width:75%;text-align:left"> 
<i class="glyphicon glyphicon-th"></i> <?php echo $kd_unit_kerja;?> : RENJA <?php echo strtoupper($direktorat);?> , DIUPLOAD OLEH :  <?php echo $nama;?> </a>
<?php if($tipe=="0") { ?>
			<a class="btn btn-danger btn-sm  pull-right"  style="text-align:left;width:300px" onclick="return confirm_export(<?php echo $id;?>)"><i class="glyphicon glyphicon-floppy-disk"> </i> Lakukan Export Ke Aplikasi Renja Bappenas</a>  
			<?php } else { ?>
			<a class="btn btn-success btn-sm  pull-right" style="text-align:left;width:300px" onclick="return confirm_export_excel(<?php echo $id;?>)"><img src="<?php echo base_url();?>images/iconexcel.png"> Lakukan Export Ke Aplikasi Excel </a>  
			<?php } ?>	



<span id="loadingnya"></span>
  <br>
  <br>
  <table style="width:30%;font-size:12px">
    	<tr>
    		<td><div style='height:15px;width:15px;background-color:#2C802C;float:left'></div> &nbsp; Indikator</td>
    	 
    		<td><div style='height:15px;;width:15px;background-color:#31BC86;float:left'></div> &nbsp;  Komponen Input</td>
    	 
    		<td><div style='height:15px;width:15px;background-color:#BED446;float:left'></div> &nbsp;  Sub Komponen Input</td>
    	</tr>
    </table>
<div id="tabledata">
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered" style="width:100%;">
    <thead >
    	<tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>KODE</td>
          
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4 >SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>KL/<br>AP/QW/<br>PL</td>
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