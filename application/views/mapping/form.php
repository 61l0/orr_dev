 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>mapping/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true,});					 
				} else {
					 window.location="<?php echo base_url() ?>mapping";
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
 
  
   <div class="panel-heading">TAMBAH / UBAH 

   </div>
  <div class="well" style="margin:0px">

<form method="post" class="form1" id="form_barang" name="form_barang"/>
<input type="hidden" name="id" maxlength="5" size="5"  hidden value="<?php echo $id; ?>"/>
 	<table class="table">
   			<tr>
   				<td style="width:130px">Nama</td>
   				<td style="width:10px">:</td>
   				<td><input    style="width:350px"  id="mapping" value="<?php echo isset($infouser['nama']) ? $infouser['nama'] : ''; ?>" name="mapping" type="text" value="" class="form-control input-sm"  p
   				laceholder="NAMA" /></td>
   			</tr>
   		 
   		</table> 
 <hr>
		<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-edit
"></i> Simpan</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>mapping" class="btn-warning btn btn-sm"><i class="glyphicon glyphicon-arrow-left
"></i> Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
 
 </div>
 </div>

 