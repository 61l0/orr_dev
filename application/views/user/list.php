   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />

	<script type="text/javascript">
	$(document).ready(function() { 
	
	  $(function() {
 		  getdata();
		  
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		   $.ajax({
			  type: "POST",
			  data: "",
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
	 function detailData(id){
		 $("#tr"+id).toggle();
		 $.ajax({
			url:'<?php echo base_url(); ?>user/detail/'+id,		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
				$("#detail"+id).html('');  
				$("#detail"+id).append(data);  
			}  
		});		
	 }
	 function getdata(){
 	 	  $.ajax({
			  type: "POST",
			  data: "",
			  url:'<?php echo base_url(); ?>user/search/',	
			  beforeSend: function() {
			  	$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
 			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
			  }
			});
	 }
	 function deleteuser(id){
	 	$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>user/deleteuser/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										 getdata()
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
  <a href="<?php echo base_url();?>user/add" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>
   <div class="panel-heading">Data User

   </div>
  <div class="well">
	 <div id="tabledata">
	 </div>
 </div>
 </div>