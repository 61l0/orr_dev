	<script type="text/javascript">
	$(document).ready(function() { 
	refreshtable();
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		    var kewenangan =$("#kewenangan").val();
		   $.ajax({
			  type: "POST",
			  data: "kewenangan="+kewenangan,
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
			 
			 var kewenangan =$("#kewenangan").val();
			   $.ajax({
			  type: "POST",
			  data: "kewenangan="+kewenangan,
			  url: "<?php echo base_url()?>tahapan_dokumen/search",
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
									url:'<?php echo base_url(); ?>tahapan_dokumen/delete_data/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  refreshtable()
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
 
  <a href="<?php echo base_url();?>tahapan_dokumen/form" class="btn btn-success btn-sm pull-right" style="margin:5px"> 
   <i class="glyphicon glyphicon-plus"></i> Tambah</a>
   <div class="panel-heading">Data Kewenangan

   </div>
  <div class="well" style="margin:0px">
  <input type="text" class="form-control input-sm" onchange="return refreshtable()" 
            id="kewenangan" name="kewenangan" placeholder="Nama Kewenangan" style="width:300px">
	 <div id="tabledata">
	 </div>
 </div>
 </div>
