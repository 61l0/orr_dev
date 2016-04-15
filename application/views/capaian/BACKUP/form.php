    <script src="<?php echo base_url();?>js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	  add_tiny_mce();
	});

function add_tiny_mce(){
	tinymce.init({
	    selector: "textarea",
	    height:180,
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
}
</script>
	<script>
 	function save(){
 	
 		 tinymce.remove()	
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/cek/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true});	
					 add_tiny_mce();
				} else {
					  tinymce.remove()	
					  $("#form_barang").submit();
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

<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
<form id="form_barang"  enctype="multipart/form-data"  name="form_barang" action="<?php echo base_url();?>template_renja/simpan" method="POST">
<fieldset>
    <input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
    <table style="width:100%;margin-bottom:5px">
	    <tr>
 	    	<td style="width:520px;"><b>Judul</b><br><input style="width:500px" class="form-control  required" id="judul" value="<?php echo isset($infouser['judul']) ? $infouser['judul'] : ''; ?>" name="judul" required="true" type="text" /></td>
	    	<td style="width:320px;"><b>Unit</b>
 	    		<?php echo $kepada;?>
 	    	</td>
 	    	<td><b>Tahun Anggaran</b>
 	    		<?php echo $tahun_anggaran;?>
 	    	</td>
 	    	
	    </tr>
	    
	     <tr >
			<td colspan="3">   
			<span  class="btn btn-primary"  style="width:100%;margin-top:5px;text-align:left"> 
			<input type="file" style="float:left" name="file_berkas[]" id="file_berkas" size="20" /> 
 	    	( *xlsx , *xls  )  attachment ini merupakan file excel data renja </span>
 	    	</td>
	     </tr>	
	    <tr>
 	    	<td colspan="3"><br><b>Note / Catatan </b><br>
 	    		 <textarea name="note" id="note" class="form-control" style="height:200px;width:100%"><?php echo isset($infouser['note']) ? $infouser['note'] : ''; ?></textarea>
 	    	</td>
	    </tr>
	    <tr>
 	    	
	    </tr>

    </table>
 
    <a onclick="return confirmdlg()" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i> Simpan </a>
    <a href="<?php echo base_url();?>template_renja" class="btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i> Batal  </a>
</fieldset>
</form>
<br>