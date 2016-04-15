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
                                            <td>Kode Program</td>
                                            <td>Nama </td>
                                            <td>Pusat </td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            <td style="text-align:center;font-weight:bold">
											<span style="float:left" class="label label-warning"><?php echo $row->kd_unit_kerja ?></span>
											</td>
                                            <td><?php echo strtoupper($row->nama_unit_kerja) ?></td>
                                            <td><?php if($row->pusat=="1") { echo "Ya"; } else { echo "Tidak";} ?></td>
                                            <td>
                                                <div class="btn-group">
                                        	            <a href="<?php echo base_url();?>unit_kerja/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
											        	<i class="glyphicon glyphicon-edit"></i>
											        	Edit</a>							
											        	<a href="#" onclick="return delete_data(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
											        	<i class="glyphicon glyphicon-trash"></i>
											        	Hapus</a> 
											     </div>   	
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