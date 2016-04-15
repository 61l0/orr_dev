	<script type="text/javascript">
	$(document).ready(function() { 
	   get_data_capaian(1);
 	   $( "#tabs" ).tabs();
	});
	function get_data_capaian(id){
		  $("#data_capaian_target").html("<center><div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div></center>");
		  $("#data_capaian_realisasi").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
		   get_data_capaian_target(id);
		   get_data_capaian_realisasi(id);
		   $( "#li_1" ).removeClass( "active" ) ;
		   $( "#li_2" ).removeClass( "active" ) ;
		   $( "#li_3" ).removeClass( "active" ) ;
		   $( "#li_4" ).removeClass( "active" ) ;
		   $( "#li_6" ).removeClass( "active" ) ;
		   $( "#li_"+id ).addClass( "active" );
		   if(id=="1"){
		   	 $("#target_label").html('<i class="glyphicon glyphicon-signal"></i>  Target Kinerja');
		   	 $("#realisasi_label").html('<i class="glyphicon glyphicon-signal"></i>  Realisasi Kinerja');
		   } else  if(id=="2"){
		   	 $("#target_label").html('<i class="glyphicon glyphicon-signal"></i>  Target Keuangan');
		   	 $("#realisasi_label").html('<i class="glyphicon glyphicon-signal"></i>  Realisasi Keuangan');
		   } else  if(id=="3"){
		   	 $("#target_label").html('<i class="glyphicon glyphicon-signal"></i>  Target PHLN');
		   	 $("#realisasi_label").html('<i class="glyphicon glyphicon-signal"></i>  Realisasi PHLN');
		   } else  if(id=="4"){
		   	 $("#target_label").html('<i class="glyphicon glyphicon-signal"></i>  Target DKTP');
		   	 $("#realisasi_label").html('<i class="glyphicon glyphicon-signal"></i>  Realisasi DKTP');
		   } else if(id=="6"){
		   	 $("#target_label").html('<i class="glyphicon glyphicon-signal"></i>  Target Renaksi');
		   	 $("#realisasi_label").html('<i class="glyphicon glyphicon-signal"></i>  Realisasi Renaksi');
		   }  
	}
	function get_data_capaian_target(id){
		$.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>pengingat/get_capaian_target/"+id,			  
			  success: function(msg) {
				$("#data_capaian_target").html(msg);
 			  }
			});
		return false;
	}
	function get_data_capaian_realisasi(id){
		$.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>pengingat/get_capaian_realisasi/"+id,			  
			  success: function(msg) {
				$("#data_capaian_realisasi").html(msg);
 			  }
			});
		return false;
	}
	function load_send_mail_capaian(id_direktorat,bulan){
		var status_user="<?php echo $this->session->userdata('STATUS');?>";
		if(status_user=="1"){
			 return false
		}
		$.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>pengingat/form_mail_capaian/"+id_direktorat+'/'+bulan,			  
			  success: function(msg) {
				$("#confirm").html(msg);
				$("#confirm").dialog({
 					 modal: true,
					 title:"Kirim Email Terkait Capaian...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
					 	send_mail();
 						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
 			   }
			});		
	}
	function send_mail(){
		 $( "#infodlg" ).html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
		 $( "#infodlg" ).dialog({  width: 'auto',
		 height: 'auto',title:"Info...",width:"600", draggable: false, modal: true,buttons: {
		  "Tutup": function(){
			   $(this).dialog("close");
			}
		 }});
		
		$.ajax({
			  type: "POST",
			  data: $("#frmupdate").serialize(),
			  url: "<?php echo base_url()?>pengingat/send_mail", 
			  success: function(msg) {
				 $( "#infodlg" ).html(msg);
			  }
		});
 	}
	</script>
 
  <style>
   	.header_table{
   		 vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold 
   	}
   	a{
   		cursor:pointer;
   	}
   	.small_font{
   		font-size:10px;
   		text-align:center;
   		padding:0px;
   	}
   
   </style>
   <div id="confirm" style="display:none">
   	
   </div>
<br>
 
	 	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Data Renja</a></li>
    <li><a href="#tabs-3">Data Capaian</a></li>
    <li><a href="#tabs-2">Data Keterisian Capaian</a></li>
   </ul>
  <div id="tabs-1">
 		<table class="table multimedia table-striped table-hover table-bordered">
 			<thead>
 				<th>DIREKTORAT</th>	
 				<th style="width:120px !important">TAHUN</th>	
 				<th>KETERSEDIAAN</th>	
 				<th>PERSETUJUAN</th>	
   			</thead>
		    <tbody>
			 	<?php  if(!empty($get_direktorat)) { foreach($get_direktorat as $row) { ?> 
		        <tr>
		            <td style="width:200px">
		             <?php echo  ($row->nama_unit_kerja) ?>
		             </td>
		            <td>  <?php echo  (date("Y")) ?> </td>
		   			<td style="padding:0px">
		   				<?php if($row->tersedia==1){ ?>
		   					<a style="text-align:left;border-radius:0px;color:#fff" class="btn btn-block btn-success btn-sm pull-right" style="color:#fff;margin-top:8px"><i class="glyphicon glyphicon-ok-sign"></i> Sudah Tersedia</a>
		   				<?php } else { ?>
		   					<a style="text-align:left;border-radius:0px;color:#fff" class="btn btn-block btn-danger btn-sm pull-right" style="color:#fff;margin-top:8px"><i class="glyphicon glyphicon-remove-sign"></i>  Belum Tersedia</a>
		   				<?php } ?>
		   			</td>
		   			<td style="padding:0px">
		   				<?php if($row->status_perbaikan==1){ ?>
		   					<a style="text-align:left;border-radius:0px;color:#fff" class="btn btn-block btn-success btn-sm pull-right" style="color:#fff;margin-top:8px"><i class="glyphicon glyphicon-ok-sign"></i> Data Renja Sudah Disetujui</a>
		   				<?php } else { ?>
		   					<a style="text-align:left;border-radius:0px;color:#fff" class="btn btn-block btn-danger btn-sm pull-right" style="color:#fff;margin-top:8px"><i class="glyphicon glyphicon-remove-sign"></i> Data Renja Belum Disetujui</a>
		   				<?php } ?>
		   			</td>
		   		</tr>
				<?php }} else { ?>
				<tr>
					<td colspan="6"> <center>Data Tidak Tersedia</center> </td>
				</tr>
					<?php } ?>
		    </tbody>
		</table>
  </div>
  <div id="tabs-3">
  <table class="table multimedia table-striped table-hover table-bordered">
 			<thead>
 				<th>DIREKTORAT</th>	
 				<th style="width:120px !important">TAHUN</th>	
  				<th>PERSETUJUAN CAPAIAN</th>	
   			</thead>
		    <tbody>
			 	<?php  if(!empty($get_capaian)) { foreach($get_capaian as $rowx) { ?> 
		        <tr>
		            <td style="width:200px">
		             <?php echo  ($rowx->nama_unit_kerja) ?>
		             </td>
		            <td>  <?php echo  (date("Y")) ?> </td>
		   			 
		   			<td style="padding:0px">
		   				  <?php if 
			 				(($rowx->capaian_kinerja_target=="1") and 
				 			($rowx->capaian_dktp_realisasi=="1") and 
							($rowx->capaian_dktp_target=="1") and 
							($rowx->capaian_keuangan_realisasi=="1") and 
							($rowx->capaian_keuangan_target=="1") and 
							($rowx->capaian_kinerja_realisasi=="1") and 
				 			($rowx->capaian_phln_realisasi=="1") and 
							($rowx->capaian_phln_target=="1") and 
							($rowx->capaian_renaksi_realisasi=="1") and 
							($rowx->capaian_renaksi_target=="1"))
			 			 { ?>	
			 			 	<a   style="text-align:left;border-radius:0px;color:#fff" class="btn btn-block  btn-success btn-sm">
				        	<i class="glyphicon glyphicon-ok-sign"></i> 
				        	SUDAH DISETUJUI</a>
			 			 <?php } else { ?>
			 			 	<a  style="text-align:left;border-radius:0px;color:#fff" href="#"   class="btn btn-block  btn-danger btn-sm">
				        	<i class="glyphicon glyphicon-remove-sign"></i> 
				        	BELUM DISETUJUI</a>
			 			 <?php } ?>
		   			</td>
		   		</tr>
				<?php }} else { ?>
				<tr>
					<td colspan="6"> <center>Data Tidak Tersedia</center> </td>
				</tr>
					<?php } ?>
		    </tbody>
		</table>
  </div>
  <div id="tabs-2">
				  <nav class="navbar navbar-default">
				    <div class="container-fluid">
				    <div class="navbar-header">
				      <a class="navbar-brand"  ><i class="glyphicon glyphicon-signal"></i> CAPAIAN</a>
				    </div>
 				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				     		<ul class="nav navbar-nav">
					        <li id="li_1" class='active'><a onclick="return get_data_capaian(1)"><i class="glyphicon glyphicon-th"></i>
					         KINERJA</a></li>
					        <li id="li_2"><a onclick="return get_data_capaian(2)"><i class="glyphicon glyphicon-th"></i> KEUANGAN</a></li>
					       <!-- <li id="li_3"><a onclick="return get_data_capaian(3)"><i class="glyphicon glyphicon-th"></i> PHLN</a></li>
					        <li id="li_4"><a onclick="return get_data_capaian(4)"><i class="glyphicon glyphicon-th"></i> DKTP</a></li>
					        <li id="li_6"><a onclick="return get_data_capaian(6)"><i class="glyphicon glyphicon-th"></i> RENAKSI</a></li> -->
				      </ul>
				    </div><!-- /.navbar-collapse -->
				  </div><!-- /.container-fluid -->
				</nav>			
				 	 <script>
				  $(function() {
				    $( "#tabs_target_realisasi" ).tabs();
				  });
				  </script>
 
 
<div id="tabs_target_realisasi">
  <ul>
    <!--<li><a href="#tabs-1_target">TARGET</a></li> -->
    <li><a href="#tabs-2_realisasi">REALISASI</a></li>
   </ul><!--
  <div id="tabs-1_target">
  			<h3 id="target_label"> <i class="glyphicon glyphicon-signal"></i>  Target </h3>	
			<table id="table_renja" class="table_renja table multimedia table-striped table-hover table-bordered" style="width:100%;">
			  <thead >
			      	<tr>
			      		<td  style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan="1"><?php echo date("Y");?></td>
			      		<td colspan="13" style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" > BULAN
			      		</td>
			      	</tr>
			      	 <tr>
 			      	 	 <td class="header_table"></td>
				      	 <td  class="header_table" colspan="3">TRIWULAN I</td>
				      	 <td class="header_table" colspan="3">TRIWULAN II</td>
				      	 <td class="header_table" colspan="3">TRIWULAN III</td>
				      	 <td  class="header_table" colspan="3">TRIWULAN IV</td>
			      	 </tr>
			    	<tr>
						<td style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>DIREKTORAT</td>          
			 			<td  class="header_table"><br>1</td>
			 	        <td  class="header_table"><br>2</td>
			 	        <td  class="header_table"><br>3</td>
			 	        <td  class="header_table"><br>4</td>
			 	        <td  class="header_table"><br>5</td>
			 	        <td  class="header_table"><br>6</td>
			 	        <td  class="header_table"><br>7</td>
			 	        <td  class="header_table"><br>8</td>
			 	        <td  class="header_table"><br>9</td>
			 	        <td  class="header_table"><br>10</td>
			 	        <td  class="header_table"><br>11</td>
			 	        <td  class="header_table"><br>12</td>
			          </tr>			          
			    </thead>
			    <tbody id="data_capaian_target">
			    
				</tbody>	
			    </table>
  </div>-->
  <div id="tabs-2_realisasi">

			  <h3 id="realisasi_label"> <i class="glyphicon glyphicon-signal"></i> Realisasi </h3>
			  <table id="table_renja" class="table_renja table multimedia table-striped table-hover table-bordered" style="width:100%;">
			  <thead >
			      	<tr>
			      		<td  style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan="1"><?php echo date("Y");?></td>
			      		<td colspan="13" style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" > BULAN
			      		</td>
			      	</tr>
			      	 <tr>
 			      	 	 <td class="header_table"></td>
				      	 <td  class="header_table" colspan="3">TRIWULAN I</td>
				      	 <td class="header_table" colspan="3">TRIWULAN II</td>
				      	 <td class="header_table" colspan="3">TRIWULAN III</td>
				      	 <td  class="header_table" colspan="3">TRIWULAN IV</td>
			      	 </tr>
			    	<tr>
						<td style="width:400px !important;vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>DIREKTORAT</td>          
			 			<td  class="header_table"><br>1</td>
			 	        <td  class="header_table"><br>2</td>
			 	        <td  class="header_table"><br>3</td>
			 	        <td  class="header_table"><br>4</td>
			 	        <td  class="header_table"><br>5</td>
			 	        <td  class="header_table"><br>6</td>
			 	        <td  class="header_table"><br>7</td>
			 	        <td  class="header_table"><br>8</td>
			 	        <td  class="header_table"><br>9</td>
			 	        <td  class="header_table"><br>10</td>
			 	        <td  class="header_table"><br>11</td>
			 	        <td  class="header_table"><br>12</td>
			          </tr>			          
			    </thead>
			    <tbody id="data_capaian_realisasi">
			    
				</tbody>	
			    </table>
   </div>
 
</div>					

			<hr>

			    <a class="btn btn-info btn-block btn-sm" style="color:#fff;text-align:left"> * 
			    <i class="glyphicon glyphicon-envelope"></i> Klik Untuk Mengirimkan Notifikasi Secara Manual  (Hanya Untuk Administrator) </a>

			   </div>
			</div>

  
 