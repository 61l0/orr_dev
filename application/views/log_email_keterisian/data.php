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
	
	</script>
 
 <table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td>Email</td>
                                             <td>Tanggal </td>
                                            <td>Isi </td>
                                         </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            <td> <?php echo $row->to_email ?>  </td>
                                             <td><?php echo date("d-F-Y",strtotime($row->tanggal)) ?></td>
                                            <td><?php echo strtoupper($row->pesan) ?></td>
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