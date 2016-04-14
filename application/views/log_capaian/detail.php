    <br>
 
   
 	<script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
    <style>
	  .input-medium{
	  	height:35px !important;
	  } 
    </style>
    <script>
 
    function load_capaian(table,id){
     	$("#data_capaian").mask('Loading.....');
    	$.ajax({
			url:'<?php echo base_url(); ?>log_capaian/log_capaian_renja/'+<?php echo $id;?>+"/"+<?php echo $id_data_renja;?>,		 
			type:'POST',
			data:"id="+id,
			success:function(data){ 
				  $("#data_capaian").unmask();
			 	  $("#data_capaian").html(data);	
			 	  set_after_load();	
			 	     	  
			 }
		});	
    }
  
    
    
	function hide_triwulan(id){
		$(".triwulan_"+id).toggle();
		//$('.c_triwulan_'+id).prop( 'checked',false );
  	}
  	function set_after_load(){
  		var mcheck1 = ($("#c_triwulan_1").is(":checked"));
  		var mcheck2 = ($("#c_triwulan_2").is(":checked"));
  		var mcheck3 = ($("#c_triwulan_3").is(":checked"));
  		var mcheck4 = ($("#c_triwulan_4").is(":checked"));
  		if(mcheck1){
  			$(".triwulan_1").show();
  		} else {
  			$(".triwulan_1").hide();
  		}	
  		if(mcheck2){
  			$(".triwulan_2").show();
  		} else {
  			$(".triwulan_2").hide();
  		}	  		 
  		if(mcheck3){
  			$(".triwulan_3").show();
  		} else {
  			$(".triwulan_3").hide();
  		}	
  		if(mcheck4){
  			$(".triwulan_4").show();
  		} else {
  			$(".triwulan_4").hide();
  		}	
  	}
  	$(document).ready(function() {
 
		load_capaian();
  		set_after_load();	
  		 $( ".mcheckbox" ).click(function() {
		 	var mcheck = ($(this).is(":checked"));
			var idnya=($(this).prop('id'));	
			 if(mcheck){
			 	$('.'+idnya).prop( 'checked',true );
			 } else {
			 		$('.'+idnya).prop( 'checked',false );
			 }	
		});
   		 
	     
	});
	</script>
<script>
	$(function () {
	    $(".table_renja").stickyTableHeaders();
	});
  
	</script>
 <script>
	function di_restore_dulu_sob(){ 
		  	
		  	$.ajax({
			url:'<?php echo base_url(); ?>log_capaian/di_restore_dulu_sob/',		 
			type:'POST',
			data:$('#form_save').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"700",buttons: {
					  "Tutup": function(){
					   window.location="<?php echo base_url() ?>log_capaian";
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
					  $( "#div_info" ).html("<a style='color:#fff;vertical-align:middle;font-size:20px' class='btn-block btn btn-success'><i style='font-size:20px' class='glyphicon glyphicon-ok-sign '></i> Sukses Restore Data !!!</a>");
					  $(".ui-button").show();
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
					  "Tutup  ": function(){
					 	 
						   $(this).dialog("close");
						}
					 }
				  });
 
	}	
</script>
 <style>
 .bg_image{
 	background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;
 }
 </style>
 <?php
 	function status_capaian($st=""){
 		$color="";
 		$text="";
 		if($st=="1"){
 			$color="#31BC86";
 			$text="<i class='glyphicon glyphicon-ok-sign'></i>  &nbsp; SUDAH DISETUJUI";
 		}	else {
 			$color="#E74C3C";
 			$text="<i class='glyphicon glyphicon-remove-sign'></i>  &nbsp; MASIH HARUS DIPERBAIKI";
 		}
 		$toogle=' 
	  		<table style="width:80%;margin-bottom:3px;float:left" class="table table-bordered" >
	  			<tr>
	  				<td style="width:40%;background-color:'.$color.';color:#fff;font-weight:bold">  	
	  				<h5 style="margin-left:5px;margin-top:5px;margin-bottom:5px;float:left"> 
	  				<b>'.$text.'</b> </h5></td>	   				 
	   			</tr>
	  		</table>
	  	 ';
	  	echo $toogle;
 	}
 	function cetak_toogle($text=""){
	 	$toogle="";
	 	$check_triwulan_1="";
	 	$check_triwulan_2="";
	 	$check_triwulan_3="";
	 	$check_triwulan_4="";
	 	if((date("m")=="01") or (date("m")=="02") or (date("m")=="03") ){
	 		$check_triwulan_1=' checked="checked" ';
	 	} else if((date("m")=="04") or (date("m")=="05") or (date("m")=="06")){
	 		$check_triwulan_2=' checked="checked" ';
	 	} if((date("m")=="07") or (date("m")=="08") or (date("m")=="09")){
	 		$check_triwulan_3=' checked="checked" ';
	 	} if((date("m")=="10") or (date("m")=="11") or (date("m")=="12")){
	 		$check_triwulan_4=' checked="checked" ';
	 	}
	 	$toogle='<div>
	  		<table style="width:100%;margin-bottom:3px" class="table table-bordered" >
	  			<tr>
	  				<td style="width:40%;background-color:#2C3E50;color:#fff;font-weight:bold">  	
	  				<h5 style="margin-left:5px;margin-top:5px;margin-bottom:5px;float:left"><i class="glyphicon glyphicon-th"></i> 
	  				<b>CAPAIAN '.$text.'</b> </h5></td>
	   				<td style="background-color:#31BC86;font-weight:bold">
	   				<input onchange="return hide_triwulan(1)" class="mcheckbox c_triwulan_1"  '.$check_triwulan_1.' style="float:left;margin:7px;" type="checkbox" name="c_triwulan_1" id="c_triwulan_1">  TRIWULAN I </td>
	  				<td style="background-color:#36D195;font-weight:bold"">
	  				<input onchange="return hide_triwulan(2)" class="mcheckbox c_triwulan_2" '.$check_triwulan_2.'   style="float:left;margin:7px;" type="checkbox" name="c_triwulan_2" id="c_triwulan_2">
	  				 TRIWULAN II </td>
	  				<td style="background-color:#41E8A7;font-weight:bold">
	  				<input onchange="return hide_triwulan(3)" class="mcheckbox c_triwulan_3"  '.$check_triwulan_3.'   style="float:left;margin:7px;" type="checkbox" name="c_triwulan_3" id="c_triwulan_3"> TRIWULAN III </td>
	  				<td style="background-color:#49F2B0;font-weight:bold">
	  				<input onchange="return hide_triwulan(4);" class="mcheckbox c_triwulan_4" '.$check_triwulan_4.' style="float:left;margin:7px;" type="checkbox" name="c_triwulan_4" id="c_triwulan_4">
	  			    TRIWULAN IV </td>
	  			    <td style="background-color:#49F2B0;font-weight:bold;padding:0px;">
	  				<a href="#" onclick="confirmdlg()" class="btn btn-block btn-danger  " 
	  				style="border-radius:0px;"> 
	  				<i class="glyphicon glyphicon-refresh"></i> Restore Database</a></td>
	   			</tr>
	  		</table>
	  	</div>';
	  	echo $toogle;
	 }	
 ?> 
 <form id="form_save"  enctype="multipart/form-data"  name="form_save"   method="POST">
<input class="form-control" id="id_backup" name="id_backup" required="true" size="30" value="<?php echo $id_backup ;?>" type="hidden" />
<input class="form-control" id="id_restore" name="id_restore" required="true" size="30" value="<?php echo $id_restore ;?>" type="hidden" />
</form>
<div id="div_info" name="div_info"></div>
	<div id="konfirmasi" style="display:none"></div>
	<div id="confirm" style="display:none;vertical-align:middle"> 
		<table style="width:100%">
			<tr>
			<td style="vertical-align:middle;color:#E74C3C"><i style="font-size:40px" class="glyphicon glyphicon-question-sign"></i></td>
			<td style="vertical-align:middle;font-size:15px;"> Anda Ingin Melakukan Restore ?  </td>
			</tr>
		</table>
	</div> 
<div style="background-color:#fff">
<?php cetak_toogle($direktorat);?>
 <?php $this->load->view('log_capaian/header_table_renja');?>
<tbody id="data_capaian" style="overflow:scroll">
	<td colspan="29">
    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
	</td>
</tbody>
</table> 
</div>