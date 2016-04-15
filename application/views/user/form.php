 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
   
  	<script>
	$(document).ready(function() {
 
 	});
 	function get_detail(){
 		$.ajax({
			url:'<?php echo base_url(); ?>user/detailPegawai/',		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
			   $("#nama").val(data);
			 }
		});		
 	}
	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>user/simpan/',		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false,modal: true});					 
				} else {
					  window.location="<?php echo base_url() ?>user";
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
 
   <div class="panel-heading"><?php echo $judul;?>

   </div>
  <div class="well grey" style="margin:10px;">
	<?php   isset($infouser['status']) ? $st=$infouser['status'] : $st=''; ?>
                <?php   isset($infouser['role']) ? $rl=$infouser['role'] : $rl=''; ?>
                    <form id="frmsave" name="frmsave">
                            	<table class="table">
                            	  <tr>
                            	    <td style="width:200px"><span class="field_name">Nik</span></td>
                            	    <td><span class="field">
                            	      <input   style="width:250px" onchange="return get_detail();" id="nik" name="nik" type="text" value="<?php echo isset($infouser['nik']) ? $infouser['nik'] : ''; ?>" class="form-control input-sm"  placeholder="NIK" />
                            	    </span></td>
                            	    <td>Email</td>
                            	    <td><span class="field">
                            	      <input   style="width:250px"  id="email" name="email" type="text" value="<?php echo isset($infouser['email']) ? $infouser['email'] : ''; ?>" class="form-control input-sm"  placeholder="EMAIL" />
                            	    </span></td>
                          	    </tr>
                            	  <tr>
                            	    <td><span class="field_name">Nama</span></td>
                            	    <td><span class="field">
                            	      <input     style="width:300px" id="nama" name="nama" type="text" value="<?php echo isset($infouser['nama']) ? $infouser['nama'] : ''; ?>" class="form-control input-sm"  placeholder="NAMA" />
                            	    </span></td>
                            	    <td><span class="field_name">Role</span></td>
                            	    <td><span class="field">
                            	      <select style="width:200px"  class="form-control input-sm" id="role" name="role">
                            	        <?php  if(!empty($role)) { foreach($role as $role) { ?>
                            	        <option  <?php if($rl==$role->id){ echo 'selected="selected"';} ?> value="<?php echo $role->id?>"><?php echo $role->role?></option>
                            	        <?php }} ?>
                          	        </select>
                            	    </span></td>
                          	    </tr>
                            	  <tr>
                            	    <td><span class="field_name">Unit</span></td>
                            	    <td><span class="field"><?php echo $unit;?></span></td>
                            	    <td><span class="form_row"> Jenis User </span></td>
                            	    <td><span class="field">
                            	      <select style="width:200px"  class="form-control input-sm" id="tipeuser" name="tipeuser">
                            	        <option  <?php if($st==0){ echo 'selected="selected"';} ?> value="0">Administrator</option>
                            	        <option  <?php if($st==1){ echo 'selected="selected"';} ?> value="1">User</option>
                          	        </select>
                            	    </span></td>
                          	    </tr>
                            	  <tr>
                            	    <td><span class="field_name">Username</span></td>
                            	    <td><span class="field">
                            	      <input type="text" style="width:350px"   value="<?php echo isset($infouser['username']) ? $infouser['username'] : ''; ?>" name="username" id="username" class="form-control input-sm"   placeholder="USERNAME" />
                            	    </span></td>
                            	    <td><span class="field_name">Password</span></td>
                            	    <td><span class="field">
                            	      <input style="width:300px" type="password"  value="" name="password" id="password" class="form-control input-sm"   placeholder="PASSWORD" />
                            	    </span></td>
                          	    </tr>
                            	  <tr>
                            	    <td>&nbsp;</td>
                            	    <td>&nbsp;</td>
                            	    <td>&nbsp;</td>
                            	    <td>&nbsp;</td>
                          	    </tr>
                          	  </table>
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>">
                                   
                                    <hr>
                                    <a href="#" onclick="return confirmdlg()" class="btn-primary btn btn-sm">Simpan</a>
        <a href="<?php echo base_url()?>user" class="btn-danger btn btn-sm">Batal</a>
									
                                  
                                   
                            </div>
									 
	  </form>		 			 
</div>
    <div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     

 
 
