 
 <table class="table multimedia table-striped table-hover table-bordered">
    <thead>
        <tr> 
            <th style="vertical-align:middle;font-size:12px;">JUDUL</th> 
            <th style="vertical-align:middle;font-size:12px;">DARI</th>    
            <th style="vertical-align:middle;font-size:12px;width:100px">TAHUN</th>
            <th style="vertical-align:middle;font-size:12px;">TANGGAL PENGIRIMAN</th>
            <th style="vertical-align:middle;font-size:12px;width:100px">JAM</th> 
            <th style="vertical-align:middle;font-size:12px;text-align:center;width:200px">TAHAPAN DOKUMEN</th>           
             <th style="vertical-align:middle;font-size:12px;width:50px"><center>AKSI</center></th>
		</tr>
    </thead>
    <tbody>
	 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
        <tr>
        	 
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
            <?php if($row->daridirektorat==$this->session->userdata('ID_DIREKTORAT')) { ?>    	 
         		<a href="<?php echo base_url();?>log_renja/rekap_renja/<?php echo $row->id;?>/<?php echo $row->id_data_renja;?>"
	        	 class="btn btn-primary btn-xs">
	        	<i class="glyphicon glyphicon-edit"></i>
        	Lihat</a>
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
                  