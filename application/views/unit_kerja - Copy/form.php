 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>log_history_data/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false});					 
				} else {
					 window.location="<?php echo base_url() ?>log_history_data";
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
<form method="post" class="form1" id="form_barang" name="form_barang"/>
  <table style="width:100%">
    <tr>
      <td><input type="hidden" name="id" maxlength="5" size="5"  hidden value="<?php echo $id; ?>"/></td>
    </tr>
    <tr>
      <td style="width:150px">Kode Direktorat</td>
      <td><input type="text" name="id_divisi" name="id_divisi"  
       style="width:100px"  class="form-control"   value="<?php echo isset($infouser['kd_unit_kerja']) ? $infouser['kd_unit_kerja'] : ''; ?>"/>
        </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Nama Direktorat </td>
      <td><input class="form-control"  type="text" name="nama"  id="nama" style="width:500px" value="<?php echo isset($infouser['nama']) ? $infouser['nama'] : ''; ?>" />
         </td>
    </tr>
     <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <tr>
      <td>Pusat</td>
      <td>
      <select id="pusat" name="pusat" style="width:300px" class="form-control">
      		<option <?php if($pusat=="0") { echo "selected='selected'"; } ;?> value="0">Tidak</option>
      		<option <?php if($pusat=="1") { echo "selected='selected'"; } ;?> value="1">Ya</option>
      </select>
      </td>
    </tr>
</table>
<hr>
<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn">Simpan</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>unit_kerja" class="btn-warning btn">Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     