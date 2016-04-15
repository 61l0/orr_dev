  <div id="hapus_dok" style="display:none">Anda Mau Menghapus Data Ini ? </div>
  <script>
    function form_hapus_detail_dokumen(id){
    $("#hapus_dok").dialog({
       resizable: false,
       modal: true,
       title:"Info...",
       draggable: false,
       width: 'auto',
       height: 'auto',
       buttons: {
       "Ya": function(){
         hapus_detail_dokumen(id);   
          $(this).dialog("close");
        },
        "Tutup": function(){
           $(this).dialog("close");
        }
       }
    });
    $(".ui-dialog-titlebar-close").hide();  
  }
  function hapus_detail_dokumen(id){
      $.ajax({
      url:'<?php echo base_url(); ?>capaian/hapus_detail_dokumen/'+id,    
      type:'POST',
      data:$('#form_simpan').serialize(),
      success:function(data){ 
          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>capaian/get_detail_dokumen/"+<?php echo $id;?>,       
              success: function(msg) {
              $("#data_detail_dok_"+<?php echo $id;?>).html(msg);
            }
          });
       }
  }); 
  }
  </script>
	<?php if(($this->session->userdata('ID_DIVISI') == $dari)){ ?>
	<form id="fileupload" action="<?php echo base_url();?>capaian/upload_file" method="POST" enctype="multipart/form-data">
        	<div id="queue"></div>
			 <input id="file_upload_<?php echo $id;?>" name="file_upload_<?php echo $id;?>" type="file" multiple="true">
   			<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
   	</form>
   	<?php } ?>
    	<table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr>                 
      		<th style="vertical-align:middle;font-size:12px;width:80px !important">NAMA DOKUMEN </th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	<td>
            <?php if(($this->session->userdata('ID_DIVISI') == $dari)){ ?>
              <a  style="color:#fff;cursor:pointer" onclick="return form_hapus_detail_dokumen(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
                                <i class="glyphicon glyphicon-trash"></i>
                                Hapus</a> 
            <?php } ?>
         		 <a href="<?php echo base_url();?>capaian/download_app/<?php echo $row->id;?>" 
              style="color:#fff"  class="btn-xs btn btn-info ">
        		<i style="color:#fff" class="glyphicon glyphicon-chevron-down"></i>
        		Download</a>  
        	 
        	<!--<a  style="color:#fff" class="btn btn-warning btn-xs"><i  style="color:#fff" class="glyphicon glyphicon-time"></i> <?php echo strtoupper($row->tahun_anggaran) ?> </a> -->
          <?php echo strtoupper($row->nama_dokumen) ?></td>
            
   			 
 			
        </tr> 
		<?php }} else { ?>
		 <tr>
            <td colspan="7"><center>Data Kosong</center></td>
        </tr>
		<?php } ?>
    </tbody>
</table> 

   		<script type="text/javascript">
		<?php $timestamp = time();?>
		function refresh_isi_data(){
			 $.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>capaian/get_detail_dokumen/"+<?php echo $id?>,			  
			  success: function(msg) {
				$("#data_detail_dok_"+<?php echo $id; ?>).html(msg);
 			  }
			});
		} 
 		$(function() {			
  			$('#file_upload_<?php echo $id;?>').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
					'id'	: '<?php echo $id;?>'
				},
				'swf'      : '<?php echo base_url();?>js/uploadify/uploadify.swf',
				'uploader' : '<?php echo base_url();?>capaian/upload_file',
				'onUploadSuccess' : function(file, data, response) {
        	   		refresh_isi_data()
     		    }
			});
		});
</script>