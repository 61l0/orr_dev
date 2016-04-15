	<link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
	 <script type="text/javascript">
	$(document).ready(function() { 
	  $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		     var kategori =$("#kategori").val();
		   $.ajax({
			  type: "POST",
			  data:$('#frmsave').serialize(),
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
	 
	 
	</script>
 <div id="tabledata">

<div class="span12">
 
											<div class="well blue">
												 
													<div class="well-content">
													<div class="table_options top_options">
													</div>

 <table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
                                             
                                            <td>Tanggal </td>
                                            <td>Nama File </td>
                                            <td  style="text-align:right;font-weight:bold">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            
                                            <td> <?php echo date("d-F-Y",strtotime($row->tanggal)) ?> </td>
                                        	<td> <?php echo  ($row->url) ?> </td>
                                       
                                            <td  style="text-align:right;font-weight:bold">
                                                <div class="btn-group">

                                                
                                               
                                                                                              
													<a href="#" onclick="return deletedata(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
	        	<i class="glyphicon glyphicon-trash"></i>
        	Hapus</a>
        	<a href="<?php echo base_url();?>backup_db/restore/<?php echo $row->id;?>" class="btn btn-warning btn-xs">
	        	<i class="glyphicon glyphicon-refresh"></i>
        	Restore</a>
													

                                                    </div>                                            </td>
                                       
                                        </tr>
										
										</tr>
										<?php }} else { ?>
										<tr>
											<td colspan="3"><center>Data Kosong</center></td>
										</tr>
										<?php } ?>
                                    </tbody>
                                </table><br>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		
								 </div>
								 
											  </div>
											</div>
										</div>