 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>kirim_email/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true,});					 
				} else {
					 window.location="<?php echo base_url() ?>kirim_email";
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
						 save();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
 
			}
			
	</script>
<br>
	<div class="panel panel-primary">
 
  
   <div class="panel-heading">KIRIM EMAIL

   </div>
  <div class="well" style="margin:0px">

<form method="post" class="form1" id="form_barang" name="form_barang"/>
 	<table class="table">
   			<tr>
   				<td style="width:130px">Email Tujuan</td>
   				<td style="width:10px">:</td>
   				<td><input    style="width:350px"  id="email" name="email" type="text" value="" class="form-control input-sm"  placeholder="EMAIL" /></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Subject</td>
   				<td style="width:10px">:</td>
   				<td><input    style="width:250px"  id="subjek" name="subjek" type="text" value="" class="form-control input-sm"  placeholder="SUBJECT" /></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Pesan</td>
   				<td style="width:10px">:</td>
   				<td><textarea   style="width:450px;height:100px"  id="pesan" name="pesan" 
   				type="text"  class="form-control input-sm"  placeholder="PESAN"></textarea></td>
   			</tr>
   		</table> 
 <hr>
		<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-envelope
"></i> Kirim</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>kirim_email" class="btn-warning btn btn-sm"><i class="glyphicon glyphicon-arrow-left
"></i> Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
 
 </div>
 </div>

 