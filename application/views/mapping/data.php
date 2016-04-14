		     <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />

	<script type="text/javascript">
	$(document).ready(function() { 
	 $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		    var mapping =$("#mapping").val();
		   $.ajax({
			  type: "POST",
			  data: "mapping="+mapping,
			  url: url,
			  beforeSend: function() {
				$("#tabledata").html("<div class='loading_div'><img src='<?php echo base_url() ?>img/loading.gif'></div>");
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
 
 <table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td>Nama</td>
                                             <td style="width:300px">Aksi </td>
                                         </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            <td> <?php echo $row->nama ?>  </td>
                                             <td> 
                                              <div class="btn-group">
                                              			<?php if($row->status!="1") { ?>
                                        	            <a href="<?php echo base_url();?>mapping/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
											        	<i class="glyphicon glyphicon-edit"></i>
											        	Edit</a>							
											        	<a href="#" onclick="return delete_data(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
											        	<i class="glyphicon glyphicon-trash"></i>
											        	Hapus</a> 
											        	<?php } ?> 
											        	<a  href="<?php echo base_url();?>mapping/buat/<?php echo $row->id;?>" class="btn btn-info btn-xs">
											        	<i class="glyphicon glyphicon-info-sign"></i>
											        	Lihat</a> 
											     </div>  
											     </td>
										</tr>
										<?php }} else { ?>
										<tr>
												<td colspan="6"> <center>Data Tidak Tersedia</center> </td>
										</tr>
											<?php } ?>
                                    </tbody>
                                </table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		