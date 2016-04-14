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
			  url: "<?php echo base_url()?>capaian/search",			  
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
									url:'<?php echo base_url(); ?>capaian/delete_data/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>capaian";
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
			  url: "<?php echo base_url()?>capaian/detai_capaian/"+id,			  
			  success: function(msg) {
				$("#div_"+id).html(msg);
 			  }
			});		 
	 }
	</script>
  
<br>
 
	<div class="panel panel-primary">
   <!-- Default panel contents -->
 

 

   <a href="#" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-question-sign"></i> Info</a>

   <div class="panel-heading">Data Capaian
   </div>
  <div class="well">
	 <div id="tabledata">
	 </div>
 </div>
 </div>