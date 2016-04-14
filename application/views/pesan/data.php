 
 	<input type="hidden" name="tujuan" id="tujuan" value="<?php echo $tujuan;?>">
 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
    	<?php if($row->yang_kirim==$this->session->userdata('ID_USER')) {?> 
		<div>
            <div class="alert alert-info" role="alert" style="margin-top:0px;margin-right:250px">
            <i class="glyphicon glyphicon-user"></i> <span style="font-size:12px"><?php echo strtoupper($row->user_pengirim) ?> /
             <?php echo date("d-F-Y",strtotime($row->tanggal)) ?>  , <?php echo  ($row->jam) ?></span>  
			<br> <span style="font-size:13px">[ <?php echo  ($row->text) ?> ]</span>
			</div>
		</div>
		<?php } else { ?>	 
            <div class="alert alert-success" role="alert" style="margin-top:0px;float:none;margin-left:250px">
		    <i class="glyphicon glyphicon-user"></i> <span style="font-size:12px"><?php echo strtoupper($row->user_penerima) ?>   /  
		    <?php echo date("d-F-Y",strtotime($row->tanggal)) ?> , <?php echo  ($row->jam) ?> </span> 
		    	<br><span style="font-size:13px">[ <?php echo  ($row->text) ?> ]</span>
			</div>
		</div>	
        <?php } ?>
    <?php }} else { ?>
    <center>
    	<div class="alert alert-danger" role="alert">
		  <a href="#" class="alert-link">Data Tidak Tersedia</a>
		</div>
    </center>
    <?php } ?>