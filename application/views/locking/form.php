 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		var tipe=$("#tipe").val();
 		$.ajax({
			url:'<?php echo base_url(); ?>locking/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false});					 
				} else {
					 if(tipe=="renja"){
					 	 window.location="<?php echo base_url() ?>locking/#tabs-1";
					 } else if(tipe=="capaian_target"){
					 	 window.location="<?php echo base_url() ?>locking/#tabs-2";
					 } else if(tipe=="capaian_realisasi"){
					 	 window.location="<?php echo base_url() ?>locking/#tabs-3";
					 } 
					
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
    
   <div class="panel-heading">Ubah Data Status Penguncian Data
   </div>
  <div class="well">
	 	<form method="post" class="form1" id="form_barang" name="form_barang"/>
	 	<input type="hidden" name="tipe" id="tipe" maxlength="5" size="5"  hidden value="<?php echo isset($infouser['tipe']) ? $infouser['tipe'] : ''; ?>"/>
  <table style="width:100%">
    <tr>
      <td><input type="hidden" name="id" maxlength="5" size="5"  hidden value="<?php echo $id; ?>"/></td>
    </tr>
    
    <tr>
      <td style="width:100px">Judul </td>
      <td> : </td>
      <td><?php echo isset($infouser['judul']) ? $infouser['judul'] : ''; ?>
         </td>
    </tr>
     <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <tr>
      <td>Pusat</td>
      <td> : </td>
      <td> 
      <select id="status" name="status" style="width:200px" class="form-control input-sm">
      		<option <?php if($status=="0") { echo "selected='selected'"; } ;?> value="0">Terkunci</option>
      		<option <?php if($status=="1") { echo "selected='selected'"; } ;?> value="1">Terbuka</option>
      </select>
      </td>
    </tr>
</table>
<hr>
<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-save"></i> Simpan</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>locking" class="btn-warning btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i>  Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
 </div>
 </div>
