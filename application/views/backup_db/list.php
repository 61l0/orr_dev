	<script type="text/javascript">
	$(document).ready(function() { 
	  refreshtable();
	  $( ".datepicker" ).datepicker(
			{ dateFormat: 'dd-mm-yy' ,  
			changeMonth: true,
            changeYear: true});
		 
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		 
		   $.ajax({
			  type: "POST",
			  data:$('#frmsave').serialize(),
			  url: url,
			  beforeSend: function() {
				$(".well-content").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
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
			   data:$('#frmsave').serialize(),
			  url: "<?php echo base_url()?>backup_db/search",
			  beforeSend: function() {
				$(".well-content").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
 			  }
			});
			 return false;
	}
	function deletedata(id){
		$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>backup_db/deletedata/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>backup_db";
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
 <form method="post" class="form1" id="frmsave" name="frmsave"  />
 	<div class="panel panel-primary">
 
   <a href="<?php echo base_url();?>backup_db/form" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>
   <div class="panel-heading">Data Backup

   </div>
  <div class="well" style="margin:0px">
  <input type="text" class="form-control input-sm datepicker" onchange="return refreshtable()" 
            id="tanggal" name="tanggal" placeholder="Tanggal Backup" style="width:300px">
	 <div id="tabledata">
	 </div>
 </div>
 </div>