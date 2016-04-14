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
        <th style="vertical-align:middle;font-size:12px;width:150px">DARI</th>                             
             <th style="vertical-align:middle;font-size:12px;">TAHUN</th>
            <th style="vertical-align:middle;font-size:12px;width:170px">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;">JAM</th>
            <th style="vertical-align:middle;font-size:12px;text-align:center;width:300px">STATUS</th>
            <th style="vertical-align:middle;font-size:12px;text-align:center;width:200px">TAHAPAN DOKUMEN</th>
            <th style="vertical-align:middle;font-size:12px;width:220px"><center>AKSI</center></th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 <td><a href="#" onclick="return detailData(<?php echo $row->id;?>)"  class="btn btn-success btn-xs">
        	<i class="glyphicon glyphicon-chevron-down"></i>
        	  </a>	</td>
            <td><?php echo  ($row->dari) ?></td>
            <td><?php echo strtoupper($row->tahun_anggaran) ?></td>
        	<td><?php echo date("d-F-Y",strtotime($row->tanggal)) ?></td>
            <td><?php echo  ($row->jam) ?></td>            
 			<td style="padding:0px">
 			 <?php if($row->status_perbaikan=="1") { ?>	
 			 	<a  style="border-radius:0px;text-align:left" class="btn btn-block btn-success ">
	        	<i class="glyphicon glyphicon-ok-sign"></i>  
	        	DISETUJUI  <i> (  Terkunci   )</i>  </a>
 			 <?php } else { ?>
 			 	<a style="border-radius:0px;text-align:left" href="#"   class=" btn-block  btn btn-danger ">
	        	<i class="glyphicon glyphicon-remove-sign"></i>
	        	PENDING  <i> (  Tidak Terkunci  )  </i> </a>
 			 <?php } ?>
 			 </td>
 			 <td style="padding:0px">
 			 <a  style="border-radius:0px;text-align:left" class="btn btn-block btn-success ">
 			 <i class="glyphicon glyphicon-ok-sign"></i> 
	         <?php echo  ($row->tahapan_dokumen ? $row->tahapan_dokumen : "-") ?></a></td> 			 
        	<td  style="width:240px !important">
	        	<?php if($row->daridirektorat==$this->session->userdata('ID_DIREKTORAT')) { ?>
		        <a href="<?php echo base_url();?>template_renja/form/<?php echo $row->id;?>" class="btn   btn-primary btn-xs">
		        <i class="glyphicon glyphicon-edit"></i>       	Ubah</a> 
		        <?php } ?> 
	        	<?php if($row->daridirektorat==$this->session->userdata('ID_DIREKTORAT')) { ?>
	        		<a  href="#" onclick="return delete_data(<?php echo $row->id;?>)" class="btn btn-danger  btn-xs ">
		        	<i class="glyphicon glyphicon-trash"></i> &nbsp;
	        		Hapus</a>
					<?php } ?> 
	        	 <a  href="<?php echo base_url();?>template_renja/rekap_renja/<?php echo $row->id;?>" class="btn  btn-xs btn-info">
		        <i class="glyphicon glyphicon-eye-open"></i> &nbsp;
	        	Lihat  </a> 	        			 
        	</td>
        </tr>
        <tr style="display:none" id="tr<?php echo $row->id ?>">
			<td style="background-color: #dedede;padding:0px"  colspan="9">
			<a class="btn btn-primary btn-sm btn-block" style="border-radius:0px"><i class="glyphicon glyphicon-list"></i> Log History Persetujuan</a>
			<div id="detail<?php echo $row->id ?>" style="padding:5px">
			 <?php echo  ($row->note) ?>
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