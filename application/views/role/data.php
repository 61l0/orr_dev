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
			  data: "",
			  url: url,
			  beforeSend: function() {
				$(".well-content").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
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
	 function detailData(id){
		 $("#tr"+id).toggle();
		 $.ajax({
			url:'<?php echo base_url(); ?>user/detail/'+id,		 
			type:'POST',
			data:$('#frmsave').serialize(),
			success:function(data){ 
				$("#detail"+id).html('');  
				$("#detail"+id).append(data);  
			}  
		});		
	 }
	 function getdata(){
	 	  $.ajax({
			  type: "POST",
			  data: "",
			  url:'<?php echo base_url(); ?>role/search/',	
			  beforeSend: function() {
				$(".well-content").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
			  },
			  success: function(msg) {
				$("#tabledata").html(msg);
			  }
			});
	 }
	  function deleterole(id){
	 	$( "#infodlg" ).html("Anda Ingin Menghapus Data Ini ?");
		$( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true, buttons: {
					 "Ya": function(){
							  $.ajax({
									url:'<?php echo base_url(); ?>role/deleterole/'+id,		 
									type:'POST',
									data:"",
									success:function(data){ 
										 window.location="<?php echo base_url() ?>role";
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
                                           
                                            <th>Role  </th>
                                           <th>Edit </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                           
                                            <td>
											<?php echo $row->role ?>
											</td>
                                            <td> 
                                 

                                               <a href="<?php echo base_url();?>role/add/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Edit</a>							
        	<a href="#" onclick="return deleterole(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
        	<i class="glyphicon glyphicon-trash"></i>
        	Hapus</a> 
                                            </td>
                                        </tr>
										 
										<?php }} ?>
                                    </tbody>
                                </table> 
                                               <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		
								 
								 