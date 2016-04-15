<br>
<script>
	 
	function restore_bila_tersedia(){
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_sob/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"800",buttons: {
					  "Tutup": function(){
					  	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }});
				$(".ui-button").hide();
			  },
			success:function(data){ 
			  	if(data!=''){
					 $( "#div_info" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_info" ).html("<i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'> </i> Sukses Restore Data !!!");
					  $(".ui-button").show();
				}
			 }
		});		
	}
	function di_restore_dulu_bro(){	 
 		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_bro/',		 
			type:'POST',
			data:$('#form_lost_data_renja').serialize(),
			 beforeSend: function() {
			 	$("#div_restore_bro").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_restore_bro").dialog({ title:"Info...", modal: true,width:"800",buttons: {
					  "Tutup": function(){
					  	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }});
				$(".ui-button").hide();
			  },
			success:function(data){ 
				if(data!=''){
					 $( "#div_restore_bro" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_restore_bro" ).html(data);
					  $(".ui-button").show();
				}
 			}	
 			
		});		
	}
	function restore_bila_kosong(){
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/di_restore_dulu_sob/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"800", buttons: {
					 "Ya": function(){
					 	  di_restore_dulu_bro();
 						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
					});
				$(".ui-button").hide();
			  },
			success:function(data){ 
			  	if(data!=''){
					 $( "#div_info" ).html(data);
					 $(".ui-button").show();
 				} else {
					  $( "#div_info" ).html("<i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'> </i> Sukses Restore Data !!!");
					  $(".ui-button").show();
				}
			 }
		});		
	}
	function di_restore_dulu_sob(){ 
		var datanya="";
		$.ajax({
			url:'<?php echo base_url(); ?>log_renja/cek_if_exist_data_renja/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			success:function(data){ 
 			  	 datanya=data;
 			  	 	 if(datanya!="0"){
					 	restore_bila_tersedia();
					 } else {
					 	restore_bila_kosong();
					 }
 			 }
		});	
	}
	function confirmdlg(){
			$("#confirm").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
					 	di_restore_dulu_sob();
 						$(this).dialog("close");
					  },
					  "Tutup / Kembali ": function(){
					 	 	window.location="<?php echo base_url() ?>log_renja";
						   $(this).dialog("close");
						}
					 }
				  });
 
	}	
</script>

	<style>
	.form-control{
		margin:2px;
	}
	table{
		font-size:12px;
	}
	td{
		padding:3px;
	}
	</style>
<div id="div_restore_bro" name="div_restore_bro"></div>
<div id="div_info" name="div_info"></div>
<div id="confirm" style="display:none">
	<table style="width:100%">
			<tr>
			<td style="vertical-align:middle;color:#E74C3C"><i style="font-size:40px" class="glyphicon glyphicon-question-sign"></i></td>
			<td style="vertical-align:middle;font-size:15px;"> &nbsp;&nbsp; Anda Ingin Melakukan Restore ?  </td>
			</tr>
		</table>
</div> 
<form id="form_save"  enctype="multipart/form-data"  name="form_save"   method="POST">
<input class="form-control" id="id_backup" name="id_backup" required="true" size="30" value="<?php echo $id_backup ;?>" type="hidden" />
<input class="form-control" id="id_restore" name="id_restore" required="true" size="30" value="<?php echo $id_restore ;?>" type="hidden" />
     <div class="jumbotron" style="padding:0px;border:1px solid #dedede;border-radius:0px">
     <div style="height:100px;width:100%;background-color:#fff">
     	<table style="width:100%">
     		<tr>
 	    		<td style="width:100px"><img src="<?php echo base_url();?>images/db.jpg" style="height:100px !important"></td>
 	    		<td style="vertical-align:top"><h2 style="margin-top:2px">Restore Database</h2><hr style="margin:5px">
 	    		Dilakukan Pada Tanggal : <?php echo date("d-F-Y");?><br>
 	    		Oleh : <b><?php echo strtoupper($this->session->userdata('NAMA'));?></b> <br></td>
     		</tr>
     	</table>
     	
     </div>
     <br>
     <table style="width:100%">
      		<tr>
      			<td  class="btn btn-primary btn-block" style="text-align:left"> 
     			 <table style="width:100%">
      				<tr>
	      				<td rowspan="3" style="width:80px"><h2 style="font-size:70px"> <i class="glyphicon glyphicon-cog"></i></h2> </td>
      				</tr>
      				<td>
      					<td></td> 
	      				<td><h3> <?php echo isset($info_log['judul']) ? strtoupper($info_log['judul']) : "-";?></h3> 
	      				<h5>  DARI : <?php echo isset($info_log['dari']) ? strtoupper($info_log['dari']) : "-";?></h5>
						<h5>  TANGGAL : <?php echo isset($info_log['tanggal']) ? strtoupper(date("d-F-Y",strtotime($info_log['tanggal']))) : "-";?>
						</h5>
						<h5>STATUS : <b>BACKUP</b></h5>
	      				</td>
	      			</tr>	
	      			 
      			</table>
      			</td>	
      			<td><center>
       			<h2 style="font-size:70px"> <i  style='color:#F07320' class="glyphicon glyphicon-arrow-right"></i></h2> </center></td>
      			<td  class="btn btn-success btn-block"  style="text-align:left">
      			<table   style="width:100%">
      				<tr>
	      				<td rowspan="3" style="width:80px"><h1 style="font-size:70px"> <i class="glyphicon glyphicon-cog"></i></h1> </td>
      				</tr>
      				<td>
      					<td></td> 
	      				<td><h3> <?php echo isset($infouser['judul']) ? strtoupper($infouser['judul']) : "-";?></h3> 
	      				<h5>  DARI : <?php echo isset($infouser['dari']) ? strtoupper($infouser['dari']) : "-";?></h5>
						<h5>  TANGGAL : <?php echo isset($infouser['tanggal']) ? strtoupper(date("d-F-Y",strtotime($infouser['tanggal']))) : "-";?></h5>
						<h5>STATUS : <b>EXISTING</b></h5>
	      				</td>
	      			</tr>	
	      			 
      			</table>
      			
      				
      			</td>	
      		</tr>
      </table> 	
      
  </div>
  </form>
  <hr>
 

      	<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-save"></i> Lakukan Restore</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>log_renja" class="btn-warning btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i>  Kembali</a>

      	<br><br><br>