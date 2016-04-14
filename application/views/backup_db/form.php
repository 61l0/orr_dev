      <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>backup_db/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false});					 
				} else {
					 window.location="<?php echo base_url() ?>backup_db";
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
 <div class="panel-heading">Backup Database</div>
 <div class="well" style="margin:0px">


<form method="post" class="form1" id="form_barang" name="form_barang"/>
<h2>BACKUP TANGGAL : <?php echo strtoupper(date("d-F-Y"));?></h2>
<hr>
<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-save"></i> Simpan</a> 
<a style="margin-bottom:5px;" href="<?php echo base_url() ?>home" class="btn-danger btn btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>

</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
 </div>
 </div>
