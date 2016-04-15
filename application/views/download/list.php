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
			    data:$('#form_filter').serialize(),
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
			   data:$('#form_filter').serialize(),
			  url: "<?php echo base_url()?>download/search",
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
									url:'<?php echo base_url(); ?>download/delete_data/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>download";
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
		 
	 }
	</script>
 
	<div class="panel panel-primary">
  <!-- Default panel contents -->
 
   <div class="panel-heading">Data Download

   </div>
  <div class="well">
     <?php $status_user=$this->session->userdata('STATUS');?>
   <form id="form_filter" name="form_filter">
   <?php if($status_user=="0"){?>		
	<?php echo $dari;?> <br> <!-- <?php echo $tujuan;?>  -->
 	<br>
   <?php } ?>
   </form>	 
	 <div id="tabledata">
	 </div>
 </div>
 </div>