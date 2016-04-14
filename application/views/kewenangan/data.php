		     <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />

	<script type="text/javascript">
	$(document).ready(function() { 
	   $(function() {
		applyPagination();
		function applyPagination() {
		  $(".pages a").click(function() {
		   var url = $(this).attr("href");
		    var kewenangan =$("#kewenangan").val();
		   $.ajax({
			  type: "POST",
			  data: "kewenangan="+kewenangan,
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
                                             <td>Kode </td>
                                             <td>Nama </td>
                                             <td>Tampilkan di Capaian </td>
                                             <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                            <td><b><?php echo  strtoupper($row->kode) ?></b></td>
                                            <td><?php echo  ($row->nama_kewenangan) ?></td>
                                             <td><?php if($row->mark_as_kewenangan=="0") 
                                            { echo " <a class='btn btn-danger btn-xs'  style='color:#fff'>
                                            <i class='glyphicon glyphicon-lock
											'></i> Terkunci</a>"; } 
                                             else { echo "<a class='btn btn-success  btn-xs' style='color:#fff'><i class='glyphicon glyphicon-ok
											'></i> Terbuka</a>";} ?></td>
                                            <td>
                                                <div class="btn-group">
                                        	            <a href="<?php echo base_url();?>kewenangan/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
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