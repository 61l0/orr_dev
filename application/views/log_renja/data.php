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
               <th style="vertical-align:middle;font-size:12px;">REVISI</th>    
             <th style="vertical-align:middle;font-size:12px;">DARI</th>    
            <th style="vertical-align:middle;font-size:12px;width:100px">TAHUN</th>
            <th style="vertical-align:middle;font-size:12px;">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;width:100px">JAM</th> 
            <th style="vertical-align:middle;font-size:12px;text-align:center;width:200px">TAHAPAN DOKUMEN</th>           
             <th style="vertical-align:middle;font-size:12px;width:150px"><center>AKSI</center></th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 <td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
 <td  style="width:100px"><?php echo  ($row->judul) ?></td>
              <td  style="width:100px"><?php echo  ($row->dari) ?></td>
            <td><?php echo strtoupper($row->tahun_anggaran) ?></td>
        	<td style="width:200px"><?php echo date("d-F-Y",strtotime($row->tanggal_log)) ?></td>
            <td><?php echo date("h:m:s ",strtotime($row->tanggal_log)) ?></td>
            <td style="padding:0px">
 			 <a  style="border-radius:0px;text-align:left" class="btn btn-block btn-success ">
 			 <i class="glyphicon glyphicon-ok-sign"></i> 
	         <?php echo  ($row->tahapan_dokumen ? $row->tahapan_dokumen : "-") ?></a></td>
 			 
        	<td  style="max-width:50px !important">      	 
         		<a href="<?php echo base_url();?>log_renja/rekap_renja/<?php echo $row->id;?>/<?php echo $row->id_data_renja;?>"
	        	 class="btn btn-primary btn-xs">
	        	<i class="glyphicon glyphicon-edit"></i>
        	Lihat</a>
        	   <a href="<?php echo base_url();?>log_renja/restore/<?php echo $row->id;?>/<?php echo $row->id_data_renja;?>" class="btn btn-warning btn-xs">
	        	<i class="glyphicon glyphicon-refresh"></i>
        	Restore</a>
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td colspan="9" id="detail<?php echo $row->id ?>"><h3>CATATAN PERSETUJUAN</h3>
				<hr>
				<table  style="width:400px">
					<tr>
						<td>Disetujui oleh </td>
						<td style="width:10px">:</td>
						<td><?php echo $row->nama_user;?></td>
					</tr>
					<tr>
						<td>Tanggal Persetujuan  </td>
						<td>:</td>
						<td><?php echo date("d-F-Y",strtotime($row->tanggal_log)) ;?>
						<b><?php echo date("H:i:s",strtotime($row->tanggal_log)) ;?></b></td>
					</tr>
				</table>
 
			</td>
		</tr>
		 <tr style="display:none" id=""></tr>
		<?php }} else { ?>
		 <tr>
            <td colspan="8"><center>Data Kosong</center></td>
        </tr>
		<?php } ?>
    </tbody>
</table> 
                   <span class="btn btn-primary btn-xs">Terdapat <?php echo $count;?>  Data</span>
								 <p class="pages"> <?php echo $this->pagination->create_links(); ?></p>		