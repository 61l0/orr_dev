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
            <td>Jenis Lock</td>
            <td>Status </td>
             <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
            <td><?php echo $row->judul ?></td>
             <td><?php if($row->status=="0") { echo " <span class='label label-danger'><i class='glyphicon glyphicon-lock
'></i> Terkunci</span>"; } 
             else { echo "<span class='label label-success'><i class='glyphicon glyphicon-ok
'></i> Terbuka</span>";} ?></td>
            <td>
                <div class="btn-group">
        	            <a href="<?php echo base_url();?>locking/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
			        	<i class="glyphicon glyphicon-edit"></i>
			        	Edit</a>							
			        	 
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