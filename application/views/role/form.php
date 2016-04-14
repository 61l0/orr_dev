 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});


	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>role/simpan/',		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false});					 
				} else {
					  window.location="<?php echo base_url() ?>role";
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
 
   <div class="panel-heading">ROLE

   </div>
  
 
  <div class="well grey" style="margin:10px;">
                                <form id="frmsave" name="frmsave">
                                     <div class="form_row">
                                        <label class="field_name">Nama Role</label>
                                
                                            <input style="width:300px"  type="text" value="<?php echo isset($inforole['role']) ? $inforole['role'] : '-'; ?>" class="form-control"  name="role" id="role" placeholder=".input-small">
											  <input type="hidden" value="<?php echo isset($inforole['id']) ? $inforole['id'] : ''; ?>" class="form-control" name="id" id="id" placeholder=".input-small">
                                        
                                            <?php echo $menuUp ?>
                                         
											  </div>
											  
											 
											<hr>
											 <a onclick="return confirmdlg()" class="btn-primary btn">Submit</a>
                                            <a  href="<?php echo base_url() ?>role" class="btn-danger btn">Cancel</a>
										</div>
                                    </div>
									<h3>&nbsp;</h3>
							   
                                     
                                </form>
                            
    <div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     

 