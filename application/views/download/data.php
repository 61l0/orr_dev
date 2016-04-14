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
 <?php $pusat=$this->session->userdata('PUSAT');?>
 
 <table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr><th style="vertical-align:middle;font-size:12px;width:20px"></th>                              
            <th style="vertical-align:middle;font-size:12px;width:300px">JUDUL</th>
            <th style="vertical-align:middle;font-size:12px;width:170px">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;width:90px">JAM</th>
            <?php if($pusat=="1") { ?>
            	<th style="vertical-align:middle;font-size:12px;width:170px">DARI</th>
            <?php } ?>

            <!-- 
            <?php if($pusat!="1") { ?>
            	<th style="vertical-align:middle;font-size:12px;width:170px">TUJUAN</th>
            <?php }  ?>
            -->
            
            <th style="vertical-align:middle;font-size:12px;width:100px">AKSI</th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 <td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
            <td><?php echo strtoupper($row->judul) ?></td>
        	<td><?php echo date("d-F-Y",strtotime($row->tanggal)) ?></td>
            <td><?php echo  ($row->jam) ?></td>
            <?php if($pusat=="1") { ?>
            	<td><?php echo  ($row->dari) ?></td>
            <?php } ?>
            <!-- <?php if($pusat!="1") { ?>
            <td><?php echo  ($row->tujuan) ?></td>
              <?php }?>	 -->
        	<td>
        	<a href="<?php echo base_url();?>upload/download_app/<?php echo $row->id;?>"  class="btn btn-info btn-xs">
        	<i class="glyphicon glyphicon-download"></i>
        	Download</a>
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td colspan="9" id="detail<?php echo $row->id ?>"><h3>Catatan</h3><br><?php echo  ($row->note) ?>
			</td>
		</tr>
		 <tr style="display:none" id=""></tr>
		<?php }} else { ?>
		 <tr>
            <td colspan="7"><center>Data Kosong</center></td>
        </tr>
		<?php } ?>
    </tbody>
</table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		