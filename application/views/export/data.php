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
        <tr><th style="vertical-align:middle;font-size:12px;width:20px"></th>                              
            <th style="vertical-align:middle;font-size:12px;width:140px">DARI</th>
            <th style="vertical-align:middle;font-size:12px;width:100px">TAHUN ANGGARAN</th>
            <th style="vertical-align:middle;font-size:12px;width:170px">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;width:90px">JAM</th>
             <th style="vertical-align:middle;font-size:12px;width:100px">STATUS</th>
            <th style="vertical-align:middle;font-size:12px;width:80px">AKSI</th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 <td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
            <td><?php echo strtoupper($row->dari) ?></td>
            <td><?php echo strtoupper($row->tahun_anggaran) ?></td>
        	<td><?php echo date("d-F-Y",strtotime($row->tanggal)) ?></td>
            <td><?php echo  ($row->jam) ?></td>
  			<td>
 			 <?php if($row->status_perbaikan=="1") { ?>	
 			 	<a  class="btn btn-success btn-xs">
	        	<i class="glyphicon glyphicon-edit"></i>
	        	OK</a>
 			 <?php } else { ?>
 			 	<a href="#"   class="btn btn-danger btn-xs">
	        	<i class="glyphicon glyphicon-trash"></i>
	        	PENDING</a>
 			 <?php } ?>
 			 </td>
        	<td> 
        	 <div class="btn-group">
				  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Tujuan Export &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <?php if($this->session->userdata('PUSAT')=='1'){ ?>
				   		 <li><a href="<?php echo base_url();?>export/rekap_renja/<?php echo $row->id;?>/0" style="text-decoration:none"><i class="glyphicon glyphicon-list-alt"></i> Aplikasi Bappenas</a></li>
				    <?php } ?>
				   		 <li><a href="<?php echo base_url();?>export/rekap_renja/<?php echo $row->id;?>/1" style="text-decoration:none"><i class="glyphicon glyphicon-export"></i> Microsoft Excel</a></li>
				  </ul>
				</div>
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td colspan="9" id="detail<?php echo $row->id ?>"><h3>Catatan</h3>
			<br><?php echo  ($row->note) ?>
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