 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
   
  	<script>
	$(document).ready(function() {
 
 	});
  
	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>home/simpan_change_pass/',		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false,modal: true});					 
				} else {
					  window.location="<?php echo base_url() ?>home";
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
  <!-- Default panel contents -->
 
   <div class="panel-heading">GANTI PASSWORD

   </div>
  <div class="well grey" style="margin:10px;">
	<?php   isset($infouser['status']) ? $st=$infouser['status'] : $st=''; ?>
                <?php   isset($infouser['role']) ? $rl=$infouser['role'] : $rl=''; ?>
                    <form id="frmsave" name="frmsave">
                                <input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>">
                                    <div class="well-content no_padding">
                              		 <div class="form_row">
                                        <label class="field_name">Nik</label>
                                        <div class="field">
                                         <input  readonly style="width:250px" onchange="return get_detail();" id="nik" name="nik" type="text" value="<?php echo isset($infouser['nik']) ? $infouser['nik'] : ''; ?>" class="form-control"  placeholder="NIK">                                            
                                        </div>
                                    </div>
                              		<div class="form_row">
                                        <label class="field_name">Nama</label>
                                        <div class="field">
                                         <input  readonly   style="width:300px" id="nama" name="nama" type="text" value="<?php echo isset($infouser['nama']) ? $infouser['nama'] : ''; ?>" class="form-control"  placeholder="NAMA">                                            
                                        </div>
                                    </div>
                                    
									 <div class="form_row">
                                        <label class="field_name">Username</label>
                                        <div class="field">
                                           <input type="text" style="width:350px"   value="<?php echo isset($infouser['username']) ? $infouser['username'] : ''; ?>" name="username" id="username" class="form-control"   placeholder="USERNAME"> 
										</div>
									 </div>
									 <div class="form_row">
                                        <label class="field_name">Password</label>
                                        <div class="field">
                                           <input style="width:300px" type="password"  value="" name="password" id="password" class="form-control"   placeholder="PASSWORD"> 
										</div>
									 </div>
									 	
									 
									  
                                    <hr>
                                    <a href="#" onclick="return confirmdlg()" class="btn-primary btn">Simpan</a>
        <a href="<?php echo base_url()?>user" class="btn-danger btn">Batal</a>
									
                                  
                                   
                            </div>
									 
			</form>		 			 
		 </div>
    <div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     

 
 
