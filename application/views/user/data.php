   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />

	<script type="text/javascript">
	$(document).ready(function() { 	 
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		   $.ajax({
			  type: "POST",
			   data:$('#form_filter').serialize(),
			  url: url,
			  beforeSend: function() {
 			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
 			  }
			});
			 return false;
			});
		}
	  }); 
	});
 
 
	 function deleteuser(id){
	 	$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>user/deleteuser/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										  window.location="<?php echo base_url() ?>user";
									}  
								});			
							  $(this).dialog("close");
					  } ,
				  "Tutup": function(){
			  			 $(this).dialog("close");
						}
		 }});	
	}
 </script>
 
 <table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIK PEGAWAI</th>
                                            <th>Nama </th>
                                            <th>Unit </th>
                                            <th>Username</th>
                                            <th>Status </th>
                                            <th>Role </th>
                                            <th>Email </th>
                                            <th>Edit </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            <td> <?php echo $row->nik ?></td>
                                            <td><?php echo strtoupper($row->nama) ?></td>
                                            <td><?php echo strtoupper($row->nama_unit_kerja) ?></td>
	                                        <td> <input readonly style="border:none;background:none" type="password" value="<?php echo $row->username ?>"/></td>
                                            <td><?php if($row->status==0){echo"Administrator";} else {echo"User";} ?></td>
                                            <td> <?php echo $row->namarole ?>
                                            <td> <?php echo $row->email ?>
											</td>
                                            <td> 
                                            <a href="<?php echo base_url();?>user/add/<?php echo $row->iduser;?>" class="btn btn-primary btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Edit</a>							
        	<a href="#" onclick="return deleteuser(<?php echo $row->iduser;?>)" class="btn btn-danger btn-xs">
        	<i class="glyphicon glyphicon-trash"></i>
        	Hapus</a>
                                            </td>
                                        </tr>
										<?php }} ?>
                                    </tbody>
                                </table> 
                                  <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		
						 
								 
								  