    <br>
     
   	<script>
 		$(function() {
    		$( "#tabs" ).tabs();
		}); 	
	</script>
 	<script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
    <style>
	  .input-medium{
	  	height:35px !important;
	  } 
	  a {
	  	color:#000;
	  	text-decoration:none;
	  }
	  .btn {
	  	padding:6px;
 	  }
    </style> 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
 <script>
 
 function load_table(){
 	$.ajax({
			url:'<?php echo base_url(); ?>log_renja/echo_table_renja/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#data_renja_up").html(data);	
 			 }
		});	
 }
	 
	function restore_bila_tersedia(){
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_sob/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"800",buttons: {
					  "Tutup": function(){
					  	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }});
				$(".ui-button").hide();
			  },
			success:function(data){ 
			  	if(data!=''){
					 $( "#div_info" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_info" ).html("<i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'> </i> Sukses Restore Data !!!");
					  $(".ui-button").show();
				}
			 }
		});		
	}
	function di_restore_dulu_bro(){	 
 		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_bro/',		 
			type:'POST',
			data:$('#form_lost_data_renja').serialize(),
			 beforeSend: function() {
			 	$("#div_restore_bro").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_restore_bro").dialog({ title:"Info...", modal: true,width:"800",buttons: {
					  "Tutup": function(){
					  	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }});
				$(".ui-button").hide();
			  },
			success:function(data){ 
				if(data!=''){
					 $( "#div_restore_bro" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_restore_bro" ).html(data);
					  $(".ui-button").show();
				}
 			}	
 			
		});		
	}
	function restore_bila_kosong(){
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_sob/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"800", buttons: {
					 "Ya": function(){
					 	  di_restore_dulu_bro();
 						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
					});
				$(".ui-button").hide();
			  },
			success:function(data){ 
			  	if(data!=''){
					 $( "#div_info" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_info" ).html("<i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'> </i> Sukses Restore Data !!!");
					  $(".ui-button").show();
				}
			 }
		});		
	}
 function confirmdlg(){
			$("#confirm").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
					 	di_restore_dulu_sob();
 						$(this).dialog("close");
					  },
					  "Tutup / Kembali ": function(){
					 	 	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }
				  });
 
	}	

 function di_restore_dulu_sob(){ 
		var datanya="";
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/cek_if_exist_data_renja/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			success:function(data){ 
 			  	 datanya=data;
 			  	 	 if(datanya!="0"){
					 	restore_bila_tersedia();
					 } else {
					 	restore_bila_kosong();
					 }
 			 }
		});	
	}
 </script>
<script>
 
	$( document ).ready(function() {
   		load_table()
 	});
</script>
<script>
 $(function () {
	    $("#table_renja").stickyTableHeaders();
 });
  

</script>
	 

	<style>
	.form-control{
		margin:2px;
	}
	table{
		font-size:12px;
	}
	td{
		padding:3px;
	}
	</style>
 <form id="form_save"  enctype="multipart/form-data"  name="form_save"   method="POST">
 <div id="div_restore_bro" name="div_restore_bro"></div>
 
<div id="div_info" name="div_info"></div>
<input class="form-control" id="id_backup" name="id_backup" required="true" size="30" value="<?php echo $id_backup ;?>" type="hidden" />
<input class="form-control" id="id_restore" name="id_restore" required="true" size="30" value="<?php echo $id_restore ;?>" type="hidden" />
	<div id="konfirmasi" style="display:none"></div>
	<div id="confirm" style="display:none;vertical-align:middle"> 
		<table style="width:100%">
			<tr>
			<td style="vertical-align:middle;color:#E74C3C"><i style="font-size:40px" class="glyphicon glyphicon-question-sign"></i></td>
			<td style="vertical-align:middle;font-size:15px;"> Anda Ingin Melakukan Restore ?  </td>
			</tr>
		</table>
	</div> 

<div class="panel panel-primary">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
  			<a href="<?php echo base_url();?>log_renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		<i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>

  			 <a href="#" onclick="confirmdlg()" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
	  		<i class="glyphicon glyphicon-refresh"></i> Restore Database</a>
			 
<div class="panel-heading">Data Renja - <?php echo $direktorat;?></div>
  <div class="well">
   
 <table style="width:30%">
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