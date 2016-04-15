   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />

	<script type="text/javascript">
	$(document).ready(function() { 
	$( "#form_filter" ).submit(function( event ) {
 		return false;
	});

	refresh_table();
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		   $.ajax({
			  data:$('#form_filter').serialize(),
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
  function refresh_table(){
 	 	  $.ajax({
			  type: "POST",
			  data:$('#form_filter').serialize(),
			  url:'<?php echo base_url(); ?>menus/search/',	
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
			  }
			});
	 }
	 function deletemenu(id){
	 	$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>menus/deletemenu/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										refresh_table();
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
  <a href="<?php echo base_url();?>menus/add" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>
   <div class="panel-heading">Data Menu

   </div>
  <div class="well" style="margin:0px">
   <form id="form_filter" name="form_filter">
  <input type="text" class="form-control input-sm" onchange="return refresh_table()" 
            id="menu" name="menu"  placeholder="Nama Menu" style="width:300px">
</form>	 
	 <div id="tabledata">

	 </div>
 </div>
 </div>