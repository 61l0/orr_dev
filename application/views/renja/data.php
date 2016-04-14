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
			  data: "kategori="+kategori,
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

 <table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr>                                             
            <th style="vertical-align:middle;font-size:12px">JUDUL</th>
            <th style="vertical-align:middle;font-size:12px;width:170px">TAHUN ANGGARAN</th>
            <th style="vertical-align:middle;font-size:12px;width:270px">AKSI</th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
            <td><?php echo strtoupper($row->judul) ?></td>
        	<td><?php echo $row->tahun_anggaran ?></td>
        	<td>
        	<a href="<?php echo base_url();?>renja/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Edit</a>
        	<a href="#" onclick="return delete_data(<?php echo $row->id;?>)" class="btn btn-danger btn-xs">
        	<i class="glyphicon glyphicon-trash"></i>
        	Hapus</a>
        	<a href="<?php echo base_url();?>renja/rekap_renja/<?php echo $row->id;?>" class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Rekap</a>
        	</td>
        </tr>
		<?php }} else { ?>
		 <tr>
            <td colspan="3"><center>Data Kosong</center></td>
        </tr>
		<?php } ?>
    </tbody>
</table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		