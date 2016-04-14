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
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
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
			  url: "<?php echo base_url()?>renja/search",
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
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
									url:'<?php echo base_url(); ?>renja/delete_data/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>renja";
									}  
								});			
							  $(this).dialog("close");
					  } ,
				  "Tutup": function(){
			   $(this).dialog("close");
				}
		 }});		
	}
	</script>
  
<br>
 
	<div class="panel panel-primary">
  <!-- Default panel contents -->
  <a href="<?php echo base_url();?>renja/form" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>
   <div class="panel-heading">Data Renja

   </div>
  <div class="well">
	 <div id="tabledata">
	 </div>
 </div>
 </div>