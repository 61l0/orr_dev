         <script src="<?php echo base_url();?>js/dataTables/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>js/dataTables/js/dataTables.bootstrap.js"></script>	
  <style>
 	.dataTables_length{
 		display:none;
 	}
 	.dataTables_info{
 		display:none; 		
 	}
 	.dataTables_paginate{
 		float:right;
 	}
 </style> 
	<script type="text/javascript">
	$(document).ready(function() { 
			search_renja();
			search_capaian_target();
			search_capaian_realisasi();

	});
	function search_renja(){
			$.ajax({
			  type: "POST",
 			  url: "<?php echo base_url()?>locking/search_renja",			  
			  success: function(msg) {
				$("#tabledata1").html(msg);
	 			
			  }
			});
			return false;
	}
	function search_capaian_target(){
			$.ajax({
			  type: "POST",
 			  url: "<?php echo base_url()?>locking/search_capaian_target",			  
			  success: function(msg) {
				$("#tabledata2").html(msg);
	 			 
			  }
			});
			return false;
	}
	function search_capaian_realisasi(){
			$.ajax({
			  type: "POST",
 			  url: "<?php echo base_url()?>locking/search_capaian_realisasi",			  
			  success: function(msg) {
				$("#tabledata3").html(msg);	 			 	
	 			  
			  	}
			});
			return false;
	}
	 
	</script>
 
	 <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
 
 <br>

	<div class="panel panel-primary">
 
   <div class="panel-heading">Data Locking</div>
  <div class="well" style="margin:0px">
 <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Data Renja</a></li>
    <li><a href="#tabs-2">Capaian (Target)</a></li>
    <li><a href="#tabs-3">Capaian (Realisasi)</a></li>
  </ul>
  <div id="tabs-1">
 	 <div id="tabledata1">
	 </div>
	 <code> * Pengisian data Dinamis , Dilakukan Penguncian Bila Status Dibuat Terkunci</code>
   </div>
  <div id="tabs-2">
  	 <div id="tabledata2">
	 </div>
   </div>
  <div id="tabs-3">
  	 <div id="tabledata3">
	 </div>
    </div>
</div>
	 
 </div>
 </div>
