<br>

 <?php if($status_pengiriman > 0) { ?>
<div class="alert alert-danger" style="border-radius:0px" role="alert">Terdapat  <b><span style="font-size:20px"> ( <?php echo $status_pengiriman; ?> ) </span></b> Notifikasi Yang Harus Segera Di Akomodir
 
 </div>

  <!-- PERSETUJUAN DATA RENJA -->
 
  <table>
  	<tr>
	  	<td  style="width:50%"> <span style="font-size:15px;margin-left:0px"><b> PERSETUJUAN DATA RENJA DAN CAPAIAN </b>  </span><br></td>
  	  	<td><span style="font-size:15px;margin-left:0px"><b> STATUS KETERISIAN DATA CAPAIAN </b>  </span><br></td>
  	</tr>
  	<tr>
  		<td style="vertical-align:top;padding-right:10px">
  			<h3><i class="glyphicon glyphicon-info-sign" style="font-size:20px"></i> PERSETUJUAN DATA RENJA</h3>

  				 <?php  if(!empty($status_persetujuan_renja)) { foreach($status_persetujuan_renja as $status_persetujuan_renja) { ?> 
					  <li class="list-group-item ">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA <b>RENJA &nbsp;&nbsp;&nbsp;&nbsp;</b> <b>&nbsp; ( <?php echo  strtoupper($status_persetujuan_renja->dari) ?> ) </b> BELUM MENDAPATKAN PERSETUJUAN / <i><b>MASIH DALAM PERBAIKAN</b> </i><br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_persetujuan_renja->tanggal)) ?> /  <?php echo  $status_persetujuan_renja->jam ?>   </span>
					   	</li>
					  <?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG / SEMUA SUDAH DISETUJUI
					   	</li>
					  <?php } ?>
					  <!-- END OF -->
					 <h3><i class="glyphicon glyphicon-info-sign" style="font-size:20px"></i> PERSETUJUAN DATA CAPAIAN</h3>
					 <!-- PERSETUJUAN DATA RENJA -->
					 <?php  if(!empty($status_persetujuan_capaian)) { foreach($status_persetujuan_capaian as $status_persetujuan_capaian) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA <b>CAPAIAN</b> <b>&nbsp;  ( <?php echo  strtoupper($status_persetujuan_capaian->dari) ?> ) </b> BELUM MENDAPATKAN PERSETUJUAN / <i><b>MASIH DALAM PERBAIKAN </b> </i><br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_persetujuan_capaian->tanggal)) ?> /  <?php echo  $status_persetujuan_capaian->jam ?>   </span>
					   	</li>
					 <?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG / SEMUA SUDAH DISETUJUI
					   	</li>
					  <?php } ?>
					  <!-- END OF -->
			</td>

  			<td style="vertical-align:top">
  			<h3><span  class="badge"><?php echo count($status_keterisian_capaian_kinerja);?></span> CAPAIAN KINERJA </h3>
  				  <?php  if(!empty($status_keterisian_capaian_kinerja)) { foreach($status_keterisian_capaian_kinerja as $status_keterisian_capaian_kinerja) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA KETERISIAN <b>CAPAIAN KINERJA </b> BULAN <b><?php echo strtoupper(date("F Y"));?></b> <b>&nbsp;  ( <?php echo  strtoupper($status_keterisian_capaian_kinerja->dari) ?> ) </b> MASIH BELUM DIISI<br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_keterisian_capaian_kinerja->tanggal)) ?> /  <?php echo  $status_keterisian_capaian_kinerja->jam ?>   </span>
					   	</li>
				   <?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG
					   	</li>
					  <?php } ?>

				  <h3><span  class="badge"><?php echo count($status_keterisian_capaian_keuangan);?></span> CAPAIAN KEUANGAN</h3>
				  <?php  if(!empty($status_keterisian_capaian_keuangan)) { foreach($status_keterisian_capaian_keuangan as $status_keterisian_capaian_keuangan) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA KETERISIAN <b>CAPAIAN KEUANGAN </b> BULAN <b><?php echo strtoupper(date("F Y"));?></b> <b>&nbsp;  ( <?php echo  strtoupper($status_keterisian_capaian_keuangan->dari) ?> ) </b> MASIH BELUM DIISI<br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_keterisian_capaian_keuangan->tanggal)) ?> /  <?php echo  $status_keterisian_capaian_keuangan->jam ?>   </span>
					   	</li>
				 <?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG
					   	</li>
					  <?php } ?>
					   <!-- 
				   <h3><span  class="badge"><?php echo count($status_keterisian_capaian_phln);?></span>  CAPAIAN PHLN</h3>
				   <?php  if(!empty($status_keterisian_capaian_phln)) { foreach($status_keterisian_capaian_phln as $status_keterisian_capaian_phln) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA KETERISIAN <b>CAPAIAN PHLN </b> BULAN <b><?php echo strtoupper(date("F Y"));?></b> <b>&nbsp;  ( <?php echo  strtoupper($status_keterisian_capaian_phln->dari) ?> ) </b> MASIH BELUM DIISI<br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_keterisian_capaian_phln->tanggal)) ?> /  <?php echo  $status_keterisian_capaian_phln->jam ?>   </span>
					   	</li>
				 	<?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG
					   	</li>
					  <?php } ?>

				<h3><span  class="badge"><?php echo count($status_keterisian_capaian_dktp);?></span>   CAPAIAN DKTP</h3>
				   <?php  if(!empty($status_keterisian_capaian_dktp)) { foreach($status_keterisian_capaian_dktp as $status_keterisian_capaian_dktp) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA KETERISIAN <b>CAPAIAN DKTP </b> BULAN <b><?php echo strtoupper(date("F Y"));?></b> <b>&nbsp;  ( <?php echo  strtoupper($status_keterisian_capaian_dktp->dari) ?> ) </b> MASIH BELUM DIISI<br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_keterisian_capaian_dktp->tanggal)) ?> /  <?php echo  $status_keterisian_capaian_dktp->jam ?>   </span>
					   	</li>
				<?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG
					   	</li>
					  <?php } ?>
				  <h3><span  class="badge"><?php echo count($status_keterisian_capaian_renaksi);?></span>   CAPAIAN RENAKSI</h3>
				  <?php  if(!empty($status_keterisian_capaian_renaksi)) { foreach($status_keterisian_capaian_renaksi as $status_keterisian_capaian_renaksi) { ?> 
					  <li class="list-group-item">	
						<i class="glyphicon glyphicon-remove-sign" style="color:#E74C3C"> </i>
					   	DATA KETERISIAN <b>CAPAIAN RENAKSI </b> BULAN <b><?php echo strtoupper(date("F Y"));?></b> <b>&nbsp;  ( <?php echo  strtoupper($status_keterisian_capaian_renaksi->dari) ?> ) </b> MASIH BELUM DIISI<br>
					   	<span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($status_keterisian_capaian_renaksi->tanggal)) ?> /  <?php echo  $status_keterisian_capaian_renaksi->jam ?>   </span>
					   	</li>
				  <?php }} else { ?>
					   <li class="list-group-item" style="background-color:#2BA86B;color:#fff">	
						 <i class="glyphicon glyphicon-remove-sign" style="color:#fff"> </i>
					   	 DATA KOSONG
					   	</li>
					  <?php } ?>
  			 
  		</td>
  	</tr>
  </table>
 
  <ul class="list-group">
  	<?php $i=1;?>
 	<?php  if(!empty($detail_status_pengiriman)) { foreach($detail_status_pengiriman as $row) { ?> 
   		 <li class="list-group-item">
 			<span style="font-size:11px;margin-left:0px"><b> PENGIRIMAN KERTAS KERJA </b>  </span><br>
   	     <i class="glyphicon glyphicon-envelope"> </i> &nbsp; 
   		  <?php echo  strtoupper($row->judul) ?>  <b> ( <?php echo  ($row->dari) ?> ) </b><br>
   		  <span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($row->tanggal)) ?> /  <?php echo  $row->jam ?>   </span>
		 </li>
    <?php $i++;}} ?>

    <?php $i=1;?>
 	<?php  if(!empty($detail_status_pengiriman_acuan)) { foreach($detail_status_pengiriman_acuan as $data) { ?> 
   		 <li class="list-group-item">
 			<span style="font-size:11px;margin-left:0px"><b> PENGIRIMAN ACUAN KERTAS KERJA </b>  </span><br>
   	     <i class="glyphicon glyphicon-envelope"> </i> &nbsp; 
   		  <?php echo  strtoupper($data->judul) ?>  <b> ( <?php echo  ($data->dari) ?> ) </b><br>
   		  <span style="font-size:11px;margin-left:0px"><?php echo  date("d-F-Y" ,strtotime($data->tanggal)) ?> /  <?php echo  $data->jam ?>   </span>

   		  </li>
    <?php $i++;}} ?>
  </ul>
</div>
<?php } else {  ?>
<!--<div class="alert alert-success" role="alert">
  <a href="#" class="alert-link" style=" text-decoration: none;"><i class="glyphicon glyphicon-ok"></i>  Anda Tidak memiliki Notifikasi</a>
</div>-->
<?php } ?>
