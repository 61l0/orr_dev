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

 <table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr>
        <th style="vertical-align:middle;font-size:12px;width:20px"></th>
        	<th style="vertical-align:middle;font-size:12px;width:120px">DARI</th>                              
             <th style="vertical-align:middle;font-size:12px;width:170px">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;width:90px">JAM</th>
            
            <th style="vertical-align:middle;font-size:12px;width:100px">STATUS</th>
            <th style="vertical-align:middle;font-size:12px;width:60px">AKSI</th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 <td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
        	<td><?php echo  ($row->dari) ?></td>  
         	<td><?php echo date("d-F-Y",strtotime($row->tanggal)) ?></td>
            <td><?php echo  ($row->jam) ?></td>
            
 			<td style="padding:0px">
 			 <?php if($row->status_perbaikan=="1") { ?>	
 			 	<a  style="border-radius:0px" class="btn btn-block btn-success ">
	        	<i class="glyphicon glyphicon-ok-sign"></i>
	        	DISETUJUI</a>
 			 <?php } else { ?>
 			 	<a style="border-radius:0px" href="#"   class=" btn-block  btn btn-danger ">
	        	<i class="glyphicon glyphicon-remove-sign"></i>
	        	PENDING</a>
 			 <?php } ?>
 			 </td>
        	<td>
        	<?php if($row->add_by==$this->session->userdata('ID_USER')) { ?>
	        	<a href="<?php echo base_url();?>exercise/do_exercise/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
	        	<i class="glyphicon glyphicon-open"></i>
	        	Exercise</a> 
        	<?php } ?>
        	<a href="<?php echo base_url();?>exercise/rekap_renja/<?php echo $row->id;?>" class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-edit"></i>
        	Lihat</a>
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td colspan="9" id="detail<?php echo $row->id ?>"><h3>Catatan</h3>
			<br><?php echo  ($row->note) ?>

			<hr>
			<span style="font-size:10px" class="pull-left">
				Oleh <b><?php echo $row->nama_user;?> </b><br>
				 Kementerian Dalam Negeri Ditjen Bina Pembangunan Daerah<br>
				Jalan Taman Makam Pahlawan No 20 Kalibata , Jakarta Sleatan 12750  , Telp 021-794653 , www.depdagri.co.id<br>
				ISO . 9001 : 2008 - CERTIFICATE NO 2013/1202
			</span>		
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