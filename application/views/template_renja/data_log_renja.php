 
 <table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr> 
            <th>JUDUL</th> 
            <th>DARI</th>    
            <th>TAHUN</th>
            <th style="width:150px">TANGGAL PENGIRIMAN</th>
            <th>JAM</th> 
            <th>TAHAPAN DOKUMEN</th>           
             <th style="vertical-align:middle;font-size:12px;width:170px"><center>AKSI</center></th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 
        <td><?php echo  ($row->judul) ?></td>
            <td><?php echo  ($row->dari) ?></td>
            <td><?php echo strtoupper($row->tahun_anggaran) ?></td>
        	<td><?php echo date("d-F-Y",strtotime($row->tanggal_log)) ?></td>
            <td><?php echo date("h:m:s ",strtotime($row->tanggal_log)) ?></td>
            <td style="padding:0px">
 			 <a  style="border-radius:0px;text-align:left" class="btn btn-block btn-success ">
 			 <i class="glyphicon glyphicon-ok-sign"></i> 
	         <?php echo  ($row->tahapan_dokumen ? $row->tahapan_dokumen : "-") ?></a></td>
 			 
        	<td  style="max-width:50px !important">  
            <?php if($row->daridirektorat==$this->session->userdata('ID_DIREKTORAT')) { ?>    	 
         		<a href="<?php echo base_url();?>log_renja/rekap_renja/<?php echo $row->id;?>/<?php echo $row->id_data_renja;?>"
	        	 class="btn btn-primary btn-xs">
	        	<i class="glyphicon glyphicon-edit"></i>
        	Lihat</a>
            
            <a target="_blank" href="<?php echo base_url();?>template_renja/download_db_rkakl/<?php echo $row->id;?>"
	        	 class="btn btn-danger btn-xs">
	        	<i class="glyphicon glyphicon-edit"></i>
        	DB RKAKL</a>
        	<?php } else { ?>
            <center>-</center>
            <?php } ?>    
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
                  