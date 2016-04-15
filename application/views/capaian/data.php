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
        <tr><th style="vertical-align:middle;font-size:12px;width:10px !important"></th>                              
            <th style="vertical-align:middle;font-size:12px;width:140px">DARI</th>
            <th style="vertical-align:middle;font-size:12px;width:40px">TAHUN ANGGARAN</th>
             <th style="vertical-align:middle;font-size:12px;width:90px">JAM</th>
             <th style="vertical-align:middle;font-size:12px;width:100px">STATUS CAPAIAN</th>
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
             <td><?php echo  ($row->jam) ?></td>
  			<td style="padding:0px">
 			 <?php if 
 				(($row->capaian_kinerja_target=="1") and 
	 			($row->capaian_dktp_realisasi=="1") and 
				($row->capaian_dktp_target=="1") and 
				($row->capaian_keuangan_realisasi=="1") and 
				($row->capaian_keuangan_target=="1") and 
				($row->capaian_kinerja_realisasi=="1") and 
	 			($row->capaian_phln_realisasi=="1") and 
				($row->capaian_phln_target=="1") and 
				($row->capaian_renaksi_realisasi=="1") and 
				($row->capaian_renaksi_target=="1"))
 			 { ?>	
 			 	<a  style="border-radius:0px;text-align:left" class="btn btn-block btn-success ">
	        	<i class="glyphicon glyphicon-ok-sign"></i>
	        	DISETUJUI <i> (  Terkunci   )</i></a>
 			 <?php } else { ?>
 			 	<a style="border-radius:0px;text-align:left" href="#"   class=" btn-block  btn btn-danger ">
	        	<i class="glyphicon glyphicon-remove-sign"></i>
	        	PENDING <i> (  Tidak Terkunci  )  </i></a>
 			 <?php } ?>
 			 </td>
 			<td>
         		<center><a 
         		 href="<?php echo base_url();?>capaian/rekap_renja/<?php echo $row->id;?>"  class="btn-xs btn btn-info ">
        		<i class="glyphicon glyphicon-eye-open"></i>
        		Lihat</a></center>
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td colspan="6" id="detail<?php echo $row->id ?>"><h3>Catatan</h3>
			<br>
			<?php echo  ($row->note) ?>			
			<div id="div_<?php echo $row->id ?>">
			
			</div>
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