	<script type="text/javascript">
	$(document).ready(function() { 
	  refreshtable();
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
 		   $.ajax({
			  type: "POST",
 			  url: url,
			  success: function(msg) {
				$("#tabledata").html(msg);
			  }
			});
			 return false;
			});
		}
	  }); 
	});
	function refreshtable(){
		   $.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>template_renja/search",
			  success: function(msg) {
				$("#tabledata").html(msg);
 			  }
			});
			 return false;
	}
	function delete_data(id){
		$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>template_renja/delete_data/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>template_renja";
									}  
								});			
							  $(this).dialog("close");
					  } ,
				  "Tutup": function(){
			   $(this).dialog("close");
				}
		 }});		
	}
	 function detailData(id){
		 $("#tr"+id).toggle();
		  $.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>template_renja/log_persetujuan/"+id,
			  success: function(msg) {
				 $("#detail"+id).html(msg);
 			  }
			});
		 return false;
	 }
	function show_export_from_excel(){
 		$("#contoh_renja" ).dialog({ title:"Contoh Form Data Renja...", draggable: false, modal: true,width: 'auto',
					 height: 'auto', buttons: {
					 "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
					});	
		return false;
	}
	</script>
  
<br>
 <div id="contoh_renja" style="display:none">
<h2 style="margin:0px;text-align:left;border-radius:0px" class="btn btn-danger btn-block"><b><i class="glyphicon glyphicon-info-sign"></i> BENTUK EXCEL RENJA YANG AKAN DI UPLOAD...</b></h2><img style="border:1px solid #dedede" src="<?php echo base_url();?>images/contoh_renja.png"></div>    
	<div class="panel panel-primary">
   <!-- Default panel contents -->
   <a href="<?php echo base_url();?>template_renja/form" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>

   <a href="<?php echo base_url();?>template_renja/export_excel" class="btn btn-info btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-export"></i> Export to Excel</a>

   <a href="<?php echo base_url();?>download/EXCEL_TEMPLATE.xlsx" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
   <img src="<?php echo base_url();?>images/iconexcel.png">  Contoh Excel Data Renja </a>

   <div class="panel-heading">Data Template Renja

   </div>
  <div class="well">
	 <div id="tabledata">
	 </div>
 </div>
 </div>