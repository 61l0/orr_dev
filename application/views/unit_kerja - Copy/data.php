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
                                        	<td style="width:50px"></td>
                                            <td>Nama User</td>
                                            <td>Jenis Perubahan Data </td>
                                         </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                        	<td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
                                            <td style="text-align:left;font-weight:bold"><?php echo $row->nama_user ?> </td>
                                            <td><?php echo strtoupper($row->tipe) ?></td>
                                              
										</tr>
										  <tr style="display:none" id="tr<?php echo $row->id ?>">
												<td colspan="9" id="detail<?php echo $row->id ?>"><h3>Detail data</h3>
												<?php 
													 $dataj=(json_decode($row->data));
 													 $someObject =$dataj;
													  foreach($someObject as $key => $value) {
													    echo   $key. " = [ <b>" . $value  . "</b> ]<br>";
													  }
 												?>


												<br> 
												</td>
											</tr>
											 <tr style="display:none" id=""></tr>	
										<?php }} else { ?>
										<tr>
												<td colspan="6"> <center>Data Tidak Tersedia</center> </td>
										</tr>
											<?php } ?>
                                    </tbody>
                                </table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		