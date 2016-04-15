    <br>
    <script src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/js/xeditable/bootstrap.min.js"></script>  
    <link href="<?php echo base_url();?>/js/xeditable/bootstrap-editable.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/js/xeditable/bootstrap-editable.js"></script>
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
 function add_program(id,tipe){
 	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/add_program/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_program").html(data);
	 			 	  load_form_program(id);
 			 	}
 			 }
		});	
 }
 function add_form_indikator(id,tipe){
  	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/add_form_indikator/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_indikator").html(data);
	 			 	  load_form_add_indikator(id);
 			 	}
 			 }
		});		
 }
 function update_form_indikator(id,tipe){
 	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/update_form_indikator/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_indikator").html(data);
	 			 	  load_form_add_indikator(id);
 			 	}
 			 }
		});	
 }
 function add_form_komponen_input(id,tipe){
 	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/add_form_komponen_input/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_komponen_input").html(data);
	 			 	  load_form_komponen_input(id);
 			 	}
 			 }
		});		
 }
 function add_form_sub_komponen_input(id,tipe){
 	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/add_form_sub_komponen_input/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_sub_komponen_input").html(data);
	 			 	  load_form_sub_komponen_input(id);
 			 	}
 			 }
		});
 }
 function update_form_sub_komponen_input(id,tipe){
 	 $.ajax({
			url:'<?php echo base_url(); ?>template_renja/update_form_sub_komponen_input/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_sub_komponen_input").html(data);
	 			 	  load_form_sub_komponen_input(id);
 			 	}
 			 }
		});
 }
 function update_form_komponen_input(id,tipe){
 	$.ajax({
			url:'<?php echo base_url(); ?>template_renja/update_form_komponen_input/'+id+'/'+tipe,		 
			type:'POST',
 			success:function(data){ 
 				if(data!=""){
			 	     $("#div_komponen_input").html(data);
	 			 	  load_form_komponen_input(id);
 			 	}
 			 }
		});
 }
 function load_table(){
 	var sum_bo_01 =0;
	var sum_bo_02 =0;
	var sum_bno_rm_p =0;
	var sum_bno_rm_d =0;
	var sum_bno_phln_p =0;
	var sum_bno_phln_d =0;
	var sum_bno_pnbp =0;
	var sum_pagu =0;
	var mix_kode=$('#mix_kode').is(':checked'); 
 	if(mix_kode==0){
 		$("#td_program").attr('colspan',3);
 	} else {
 		$("#td_program").attr('colspan',4);
 	}
 	
 	$.ajax({
			url:'<?php echo base_url(); ?>template_renja/echo_table_renja/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			beforeSend: function() {
				$("#isi_data_renja").mask('LOADING...');
 			},
			success:function(data){ 
			    $("#data_renja_up").html(data);			  	 
			  	$("#isi_data_renja").unmask();
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


					 $("#f_sum_bo_01").html("<center>"+formatDollar(sum_bo_01)+"</center>");
					 $("#f_sum_bo_02").html("<center>"+formatDollar(sum_bo_02)+"</center>");
					 $("#f_sum_bno_rm_p").html("<center>"+formatDollar(sum_bno_rm_p)+"</center>");
					 $("#f_sum_bno_rm_d").html("<center>"+formatDollar(sum_bno_rm_d)+"</center>");
					 $("#f_sum_bno_phln_p").html("<center>"+formatDollar(sum_bno_phln_p)+"</center>");
					 $("#f_sum_bno_phln_d").html("<center>"+formatDollar(sum_bno_phln_d)+"</center>");
					 $("#f_sum_bno_pnbp").html("<center>"+formatDollar(sum_bno_pnbp)+"</center>");
					 $("#f_sum_pagu").html("<center>"+formatDollar(sum_bo_01+sum_bo_02+sum_bno_rm_p+sum_bno_rm_d+sum_bno_phln_p+sum_bno_phln_d+sum_bno_pnbp)+"</center>");
					  
 			  		 run_editable_text();
			 }
		});	
 	
 }
 function formatDollar(num) {
		 return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
 </script>
<script>
	function run_editable_text(){
		$.fn.editable.defaults.mode = 'popup';  
			  $('.xeditable').editable({
				    type: 'text',
				    url: '<?php echo base_url();?>template_renja/save_live_edit',    
				    pk:"0",
				    title: 'Enter Value',
				    ajaxOptions: {
				        type: 'POST'
				    } ,
				    params:  {
					   'tipe_analisis': "0",							     
			    	},
			    	
			    	success: function(data) {	
			    	load_table();								
						if(data!=""){
						    $( "#infodlg" ).html(data);
							$( "#infodlg" ).dialog({  width: 'auto',title:"Info...", draggable: false,modal:true,
							 buttons: {
								  "Tutup": function(){
									   $(this).dialog("close");
									}
								 }
								});	
						   }
						   $(".ui-dialog-titlebar-close").hide();
						}      
			});
	}
	$( document ).ready(function() {
   		run_editable_text();	
   		load_table();
 	});
</script>
<script>
 $(function () {
	    $("#table_renja").stickyTableHeaders();
 });
 
 function save(id){ 		 
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/tandai/'+id,		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 
				  refresh();
			 }
		});		
}
function refresh(){
	$.ajax({
			url:'<?php echo base_url(); ?>template_renja/refresh/',		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#data_renja_up" ).html(data);
				}  
			 }
		});		
}
function load_kesalahan(id){ 
	 
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/load_kesalahan/'+id,		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $("#keterangan_tandai").val(data)
				}  
			 }
	});	
		$("#confirm").dialog({width: 'auto',modal: true,height: 'auto',title:"Info...",
					 buttons: {
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
	   });
}
	
	function tandai(id){
		$("#keterangan_tandai").val('');
		load_kesalahan(id)
		$("#confirm").dialog({
						 resizable: false,
						 modal: true,
						 title:"Info...",
						 draggable: false,
						 width: 'auto',
						 height: 'auto',
						 buttons: {
						 "Ya": function(){
							 save(id);   
							  $(this).dialog("close");
						  },
						  "Tutup": function(){
							   $(this).dialog("close");
							}
						 }
		  });
		$(".ui-dialog-titlebar-close").hide();	
	}

</script>

	<script>
 	function simpan_status_perbaikan(){
 		/*$.ajax({
			url:'<?php echo base_url(); ?>template_renja/simpan_status_perbaikan/',		 
			type:'POST',
			data:$('#form_status_perbaikan').serialize(),
			success:function(data){ 
			 	  $("#konfirmasi").html(data);
			 	  $("#konfirmasi").dialog({ buttons: { "Tutup": function(){ 
			 	  	 window.location="<?php echo base_url() ?>template_renja/rekap_renja/"+<?php echo $id;?>;
			 	  	$(this).dialog("close"); 
			 	  } }});
			 }
		});*/
		$("#form_status_perbaikan").submit();
	}
	function confirm_status_perbaikan(){
		$("#konfirmasi").html('Anda Mau Menyimpan Data ini ? ');
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 simpan_status_perbaikan();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
		$(".ui-dialog-titlebar-close").hide();
	}
	function simpan_komponen_input(id){
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/simpan_komponen_input/'+id,		 
			type:'POST',
			data:$('#form_komponen_input').serialize(),
			success:function(data){ 
				if(data==""){
			 	  $("#konfirmasi").html('Sukses Simpan Data');
			 	  $("#konfirmasi").dialog({ title:"Sukses Tambah / Ubah Data",modal: true,buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
			 	  $(".ui-dialog-titlebar-close").hide();
			 	  $(".ui-dialog-content").dialog("close");
			 	    load_table();
			 	} else {
			 	  $("#konfirmasi").html(data);
			 	  $("#konfirmasi").dialog({ title:"Error",modal: true,buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
			 	  $(".ui-dialog-titlebar-close").hide();
			 	}
			 }
		});		
	}	
 	function load_form_program(id){
		$("#div_program").dialog({
							 resizable: false,
							 modal: true,
							 title:"Form Tambah / Ubah Kegiatan...",
							 draggable: false,
							 width: '800',
							 height: 'auto',
							 buttons: {
							 "Ya": function(){
							 	 save_live_edit_program(id);
		  						 $(this).dialog("close");
							  },
							  "Tutup": function(){
								   $(this).dialog("close");
								}
							 }
						  }); 
				$(".ui-dialog-titlebar-close").hide();	
	}
	function load_status_perbaikan(){
			$("#confirm_status_perbaikan").dialog({
							 resizable: false,
							 modal: true,
							 title:"Persetujuan Status Perbaikan",
							 draggable: false,
							 width: 'auto',
							 height: 'auto',
							 buttons: {
							 "Ya": function(){
							 	confirm_status_perbaikan();
 		  						 $(this).dialog("close");
							  },
							  "Tutup": function(){
								   $(this).dialog("close");
								}
							 }
						  }); 
				$(".ui-dialog-titlebar-close").hide();	
	}
	function load_form_sub_komponen_input(id){
		$("#div_sub_komponen_input").dialog({
							 resizable: false,
							 modal: true,
							 title:"Form Tambah / Ubah Sub Komponen Input...",
							 draggable: false,
							 width: '800',
							 height: 'auto',
							 buttons: {
							 "Ya": function(){
							 	save_live_edit_sub_komponen_input(id);
		  						 $(this).dialog("close");
							  },
							  "Tutup": function(){
								   $(this).dialog("close");
								}
							 }
						  }); 
				$(".ui-dialog-titlebar-close").hide();	
	}
	function load_form_add_indikator(id){
		$("#div_indikator").dialog({
					 resizable: false,
					 modal: true,
					 title:"Form Tambah / Ubah Indikator...",
					 draggable: false,
					 width: '800',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
					 	save_live_edit_indikator(id);
  						 $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
		$(".ui-dialog-titlebar-close").hide();	
	}
	function load_form_komponen_input(id){	
 		$("#div_komponen_input").dialog({
					 resizable: false,
					 modal: true,
					 title:"Form Tambah / Ubah Komponen Input...",
					 draggable: false,
					 width: '800',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
					 	 save_live_edit_komponen_input(id);
 						 $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
		$(".ui-dialog-titlebar-close").hide();	
	}
	 function delete_data_renja(id){
   		$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>template_renja/delete_data_renja/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  $("#infodlg").html(data);
			 							  $("#infodlg").dialog({  width: 'auto',buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
										  load_table();
									}  
								});			
							  $(this).dialog("close");
					  } ,
				  "Tutup": function(){
			   $(this).dialog("close");
				}
		 }});	
		 $(".ui-dialog-titlebar-close").hide();		
  }
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
	<div id="div_program" name="div_program" style="display:none"></div>
	<div id="div_indikator"  name="div_indikator" style="display:none"></div>
	<div id="div_sub_komponen_input" name="div_sub_komponen_input" style="display:none"></div>
	<div style="display:none" id="div_komponen_input" name="div_komponen_input"></div>
	<div id="konfirmasi" style="display:none"></div>
	<div id="confirm" style="display:none">
		<table>
			<tr>
				<td>Keterangan</td>	
			</tr>
			<tr>
				<td> 
				<form id="form_simpan" name="form_simpan">
				<input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />	
				<textarea   <?php if($this->session->userdata('PUSAT') !='1') { ?> readonly <?php } ?>  name="keterangan_tandai" id="keterangan_tandai" 
				class="form-control" style="height:200px;width:500px">
				</textarea></form></td>	
			</tr>
		</table>	
	</div>    	

<div class="panel panel-primary" id="isi_data_renja">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
  			<a href="<?php echo base_url();?>template_renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		<i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
<?php if($this->session->userdata('PUSAT') =='1') { ?>
  			<a onclick="return load_status_perbaikan();" class="btn btn-danger btn-sm pull-right" style="margin:5px"> 
	  		<i class="glyphicon glyphicon-check"></i> Persetujuan Data Renja</a>
<?php } ?>
  			 
<div class="panel-heading">Data Renja - <?php echo $direktorat;?></div>
	  <div class="well">
	
	  <div id="confirm_status_perbaikan" name="confirm_status_perbaikan" style=";display:none">
	   <form  enctype="multipart/form-data" action="<?php echo base_url();?>template_renja/simpan_status_perbaikan" 
	   name="form_status_perbaikan"  id="form_status_perbaikan" method="POST">
	    <input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
	     <input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
		<table style="margin:10px;width:100%">
			<tr><td rowspan="5" colspan="2" style="padding:10px;width:30px;border-right:1px solid #dedede">
			<i  style="color:#E74C3C;font-size:30px;border:5px solid #18BC9C;border-radius:50px;padding:5px" class="glyphicon glyphicon-ok"></i>
			  </td></tr>
			<tr>
				<td style="padding-left:10px"><input type="radio" style="margin-top:0px" name="status_perbaikan" 
				<?php if($status_perbaikan=="0") {echo "checked";} ?> id="status_perbaikan" value="0"> </td>
				<td style="font-size:13px"><label><i class="glyphicon glyphicon-remove" style="color:red"></i> Masih Perlu Diperbaiki / Belum Disetujui </label></td>
			</tr>
			<tr>
				<td style="padding-left:10px">
				<input type="radio" style="margin-top:1px"  name="status_perbaikan" <?php if($status_perbaikan=="1") {echo "checked";} ?> 
				id="status_perbaikan" value="1"> </td>
				<td style="font-size:13px">   <label><i class="glyphicon glyphicon-ok"  style="color:green"></i>  Ya  Sudah Selsai / Disetujui  [ Otomatis Dilakukan Backup ]  </label></td>
			</tr>	
			<tr>
				<td style="padding-left:10px" colspan="2">
				<hr style="margin-top:5px;margin-bottom:5px">
				<b><i class="glyphicon glyphicon-th-list"></i> Tahapan Dokumen</b>
				<?php echo $tahapan_dokumen;?> </td>
 			</tr>	
			<tr>
				<td style="padding-left:10px" colspan="2">
				<hr style="margin-top:5px;margin-bottom:5px">
				<b><i class="glyphicon glyphicon-info-sign"></i> Upload Database RKAKL Jika Dibutuhkan  </b><br>
				<input type="file" class="form-control input-sm"  name="file_berkas[]" id="file_berkas" size="20" style="padding:5px;margin-top: :10px" /> 
				</td>
 			</tr>	
		</table>
		</form>
	 </div>
 
	<?php if($status_perbaikan=="1") { ?> 
		<a class="btn btn-success btn-block" style="border-radius:0px;margin-left:1px;text-align:left;vertical-align:middle;"><i class="glyphicon glyphicon-lock" style="font-size:40px;"></i> <span style="text-align:center;font-size:20px;margin-top:8px" class="pull-right"><i class="glyphicon glyphicon-ok-sign"></i> <span> Acuan Data Renja Sudah Sudah Disetujui <i> ( Data Terkunci ) . </i> </span></a>
	<?php } else { ?>
		<a class="btn btn-danger btn-block" style="border-radius:0px;margin-left:1px;text-align:left;vertical-align:middle;"><i class="glyphicon glyphicon-link" style="font-size:40px;"></i>  <span style="text-align:center;font-size:20px;margin-top:8px" class="pull-right"><i class="glyphicon glyphicon-remove-sign"></i> Acuan Data Renja Masih Belum Disetujui <i>( Data Tidak Terkunci ) . </i></span></a>
	<?php } ?>
 
 <form id="form_barang" name="form_barang" method="POST">
  <table style="width:100%">
    	<tr>
    		<td><div style='height:15px;width:15px;background-color:#2C802C;float:left'></div> &nbsp; Indikator</td>    	 
    		<td><div style='height:15px;;width:15px;background-color:#31BC86;float:left'></div> &nbsp;  Komponen Input</td>    	 
    		<td><div style='height:15px;width:15px;background-color:#BED446;float:left'></div> &nbsp;  Sub Komponen Input</td>
    		<td style="text-align:right"> <label class="btn btn-primary btn-sm"> <input onchange="return load_table()" value="1" type="checkbox" name="mix_kode" id="mix_kode"> &nbsp; Tampilkan Kode "RKAKL" dan "KEUANGAN" &nbsp; </label></td>
    		<td style="width:10%"><?php echo $pengkodean;?> </td>
    	</tr>

    </table>
    
<div id="tabledata">
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered" style="width:100%;">
    <thead >
    	<tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>KODE</td>
          
            <td id="td_program" style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4 >SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="width:100px;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>KL/<br>AP/QW/<br>PL</td>
 	        <td style="vertical-align:middle;font-size:10px;width:50px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>AKSI</td>
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
<a class="btn btn-danger btn-sm" style="margin-bottom:2px"><i class="glyphicon glyphicon-info-sign"></i> &nbsp; Setiap Melakukan Perubahan Maka Akan Merubah Proses Persetujuan Secara Otomatis </a>

 	 </div>
 </div>
 </div>
 </form>