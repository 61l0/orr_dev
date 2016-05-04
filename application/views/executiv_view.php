<script src="<?php echo base_url();?>js/circlechart/circlechart.js"></script> 
<script src="<?php echo base_url();?>js/highchart/highcharts.js"></script> 
<script src="<?php echo base_url();?>js/highchart/modules/exporting.js"></script> 
  <script>
 	$(document).ready(function() {		 
		belanja_operasional();		 
		belanja_non_operasional();	 
		/*pnbp();	*/ 
		kegiatan();
		capaian_se_bangda_sob();
  	});
 		function capaian_se_bangda_sob(){
 			var nama_capaian=$("#nama_capaian").val();
 			 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/capaian_se_bangda_sob/',		 
					type:'POST',
					data:"id_capaian="+nama_capaian,
					success:function(data){ 
					  	 $( "#div_capaian_se_bangda_sob" ).html(data);
					 }
				});		
 		}
 		function kegiatan(){
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/get_kegiatan_dit/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 $( "#kegiatan" ).html(data);
					 }
				});		
	 	}
		function belanja_operasional(){
			     $("#belanja_operasional_chart").mask("Loading...");
				  $.ajax({
					url:'<?php echo base_url(); ?>dashboard/belanja_operasional/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 $( "#belanja_operasional_chart" ).html(data);
					 }
				});		
	 	}
		function belanja_operasional_list(){
		 		$("#belanja_operasional_list").mask("Loading...");
		 		 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/belanja_operasional_list/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 <!-- $( "#belanja_operasional_list" ).html(data); -->
					  	  $( "#infodlg" ).html(data);
	  					  $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, width:'auto'});	
					 }
				});	
		}	 	
		function belanja_non_operasional(){
				$("#belanja_non_operasional_chart").mask("Loading...");
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/belanja_non_operasional/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 $( "#belanja_non_operasional_chart" ).html(data);
					 }
				});		
	 	}
	 	function belanja_non_operasional_list(){
	 		 $( "#tabs" ).tabs();
			$('#list_data_tabular_keseluruhan').html('<center><img style="margin-top:50px" src="<?php echo base_url();?>images/loading.gif"></center>');
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/belanja_non_operasional_list/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
 					  	  $( "#list_data_tabular_keseluruhan" ).html(data);
					  	  belanja_non_operasional_list_group();
	  					  $( "#list_data_tabular" ).dialog({ title:"Info...", draggable: false, modal: true, width:'auto'});	
					 }
				});	
		}	
		function belanja_non_operasional_list_group(){
 
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/belanja_non_operasional_list_group/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
 					  	  $( "#list_data_tabular_group" ).html(data);
 					 }
				});	
		}	
		function kegiatan_prioritas(){ 
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/kegiatan_prioritas/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
 					  	  $( "#list_data_kegiatan_prioritas" ).html(data);
 					 }
				});	
		}	
		/*function pnbp(){
				$('#pnbp_chart').html('<center><img style="margin-top:50px" src="<?php echo base_url();?>images/loading.gif"></center>');
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/pnbp/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 $( "#pnbp_chart" ).html(data);
					 }
				});		
	 	} 	*/
	 	function pnbp_list(){
				$('#pnbp_list').html('<center><img style="margin-top:50px" src="<?php echo base_url();?>images/loading.gif"></center>');
				 $.ajax({
					url:'<?php echo base_url(); ?>dashboard/pnbp_list/',		 
					type:'POST',
					data:$('#form_barang').serialize(),
					success:function(data){ 
					  	 <!-- $( "#pnbp_list" ).html(data); -->
 					 	  $( "#infodlg" ).html(data);
	  					  $( "#infodlg" ).dialog({ title:"Info...", draggable: true, modal: true, width:'auto'});	
					 }
				});		
	 	} 	
	</script>
	<br>
<div id="list_data_tabular" name="lidt_data_tabular" style="display:none">
	<div id="tabs">
  <ul>
	    <li><a href="#tabs-1">Keseluruhan</a></li>
   		<li><a href="#tabs-2">Per Group</a></li>
   		<li><a href="#tabs-3" onclick="return kegiatan_prioritas()">Kegiatan Prioritas</a></li>
    </ul>
  <div id="tabs-1">
    	<div id="list_data_tabular_keseluruhan"></div>
  </div>
  <div id="tabs-2">
    	<div id="list_data_tabular_group"></div>
  </div>
    <div id="tabs-3">
    	<div id="list_data_kegiatan_prioritas"></div>
  </div>
  
</div>
</div>	
<div class="row">
        <div class="col-md-6">  
	        <table class="table multimedia table-striped table-hover table-bordered">
		    <thead>
	        <tr>                                             
	            <th style="vertical-align:middle;font-size:12px">
	            <br>
	            <!--<a onclick="return belanja_operasional_list()" class="btn btn-primary btn-xs" style="float:left"><i class="glyphicon glyphicon-cog"></i> Detail</a>	
	            &nbsp; <a onclick="return belanja_operasional()" class="btn btn-success btn-xs" 
	            style="float:none">
	            <i class="glyphicon glyphicon-arrow-left"></i> Back</a>	-->
	            
	            <center>PERSENTASE PENGGUNAAN DANA TAHUN <?php echo date("Y");?></center></th>
	        </tr>
	    	</thead>
	   		<tbody>
			<tr>                                             
	            <th style="vertical-align:middle;font-size:12px"><div id="belanja_operasional_chart"></div></th>
			</tr>
			</tbody>
			</table>
        </div>        
        <div class="col-md-6">
        	 <table class="table multimedia table-striped table-hover table-bordered">

		    <thead>
	        <tr>                                             
	            <th style="vertical-align:middle;font-size:12px">
	            <!--<a  class="btn btn-primary btn-xs" style="float:left"><i class="glyphicon glyphicon-cog"></i> Detail</a>	
	             &nbsp; <a onclick="return pnbp()" class="btn btn-success btn-xs" 
	            style="float:none">
	            <i class="glyphicon glyphicon-arrow-left"></i> Back</a>	-->
	            <a onclick="return belanja_non_operasional_list()" class="btn btn-primary btn-xs" style="float:left"><i class="glyphicon glyphicon-cog"></i> Detail</a>
	            <br>
	            <center>KEGIATAN DIT <?php echo date("Y");?></center></th>
	        </tr>
	    	</thead>
	   		<tbody>
			<tr>                                             
	            <th style="vertical-align:middle;font-size:12px"><div id="kegiatan"></div></th>
			</tr>
			</tbody>
			</table>

        </div> 
</div>
 
<div class="row">
        <div class="col-md-6">  
	        <table class="table multimedia table-striped table-hover table-bordered">
		    <thead>
	        <tr>                                             
	            <th style="vertical-align:middle;font-size:12px"><center>DATA RENJA TAHUN <?php echo date("Y");?></center>
	            	<a onclick="return belanja_non_operasional_list()" class="btn btn-primary btn-xs" style="float:left"><i class="glyphicon glyphicon-cog"></i> Detail</a>
	             &nbsp; <a onclick="return belanja_non_operasional()" class="btn btn-success btn-xs" 
	            style="float:none">
	            <i class="glyphicon glyphicon-arrow-left"></i> Back</a>	
	            </th>
	        </tr>
	    	</thead>
	   		<tbody>
			<tr>                                             
	            <th style="vertical-align:middle;font-size:12px"><div id="belanja_non_operasional_chart"></div></th>
			</tr>
			</tbody>
			</table>
        </div>        
         <div class="col-md-6">  
	        <table class="table multimedia table-striped table-hover table-bordered">
		    <thead>
	        <tr>                                             
	            <th> <?php echo $capaian;?> 
	             
	            </th>
	        </tr>
	    	</thead>
	   		<tbody>
			<tr>                                             
	            <th style="vertical-align:middle;font-size:12px"><div id="div_capaian_se_bangda_sob"></div></th>
			</tr>
			</tbody>
			</table>
        </div>        
        
</div>
 