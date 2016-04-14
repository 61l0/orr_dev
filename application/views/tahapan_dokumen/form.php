 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>tahapan_dokumen/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false});					 
				} else {
					 window.location="<?php echo base_url() ?>tahapan_dokumen";
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
 
   <div class="panel-heading">Tambah / Ubah

   </div>
  <div class="well" style="margin:0px">
   <form method="post" class="form1" id="form_barang" name="form_barang"/>
  <table style="width:100%">
    <tr>
      <td><input type="hidden" name="id" maxlength="5" size="5"  hidden value="<?php echo $id; ?>"/></td>
    </tr>
      <tr>
      <td style="width:180px">Kode    </td>
      <td> : </td>
      <td><input class="form-control  input-sm"  type="text" name="kode"  id="kode" style="width:10%" value="<?php echo isset($infouser['kode']) ? $infouser['kode'] : ''; ?>" /><br>
         </td>
    </tr>
    <tr>
      <td style="width:180px">Nama Kewenangan   </td>
      <td> : </td>
      <td><input class="form-control  input-sm"  type="text" name="nama"  id="nama" style="width:30%" value="<?php echo isset($infouser['nama']) ? $infouser['nama'] : ''; ?>" />
         <br></td>
    </tr>
   
</table>
<hr>
<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-sm btn-primary btn">Simpan</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>unit_kerja" class="btn-sm btn-warning btn">Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
  </div>
 </div>

