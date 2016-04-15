
<table class="table">
<?php  if(!empty($query)) { foreach($query as $row) { ?> 
				<tr>
					<td>
						<div class="bs-callout bs-callout-danger" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats
"></i> Target Capaian Kinerja</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_kinerja_target=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum Disetujui</a>";?> </p></div>
					</td>
					<td> 
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats
"></i> Target Capaian Keuangan</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_keuangan_target=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>

					</td>
					<td>
						<div class="bs-callout bs-callout-danger" id="callout-glyphicons-location"> <h4> <i class="glyphicon glyphicon-stats
"></i> Target Capaian PHLN</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_phln_target=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	

					</td>
					<td>
							<div class="bs-callout bs-callout-info" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats
"></i> Target Capaian DKTP</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_dktp_target=="1" ? "<a  style='text-align:left' class='btn btn-success btn-block  btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	

					</td>
					<td>
						<div class="bs-callout bs-callout-warning" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats
"></i> Target Capaian RENAKSI</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_renaksi_target=="1" ? "<a  style='text-align:left' class='btn  btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	
					</td>
				</tr>		
				

				<tr>
					<td>
						<div class="bs-callout bs-callout-danger" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats"></i> Realisasi Capaian Kinerja</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_kinerja_realisasi=="1" ? "<a  style='text-align:left' class='btn btn-success btn-block   btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>
					</td>
					<td> 
						<div class="bs-callout bs-callout-info" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats"></i> Realisasi Capaian Keuangan</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_keuangan_realisasi=="1" ? "<a  style='text-align:left' class='btn  btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>

					</td>
					<td>
						<div class="bs-callout bs-callout-danger" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats"></i> Realisasi Capaian PHLN</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_phln_realisasi=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	

					</td>
					<td>
							<div class="bs-callout bs-callout-info" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats"></i> Realisasi Capaian DKTP</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_dktp_realisasi=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	

					</td>
					<td>
						<div class="bs-callout bs-callout-warning" id="callout-glyphicons-location"> <h4><i class="glyphicon glyphicon-stats"></i> Realisasi Capaian RENAKSI</h4>  
						<p style="margin-top:10px;"><?php echo $row->capaian_renaksi_realisasi=="1" ? "<a  style='text-align:left' class='btn btn-block btn-success btn-sm'><i class='glyphicon glyphicon-ok-sign
'></i> Data  Disetujui</a>" : "<a style='text-align:left' class='btn btn-danger  btn-block btn-sm'><i class='glyphicon glyphicon-remove-sign

'></i> Data Belum   Disetujui</a>";?> </p></div>	
					</td>
				</tr>		
				<?php }} else { ?>
		 <tr>
            <td colspan="7"><center>Data Kosong</center></td>
        </tr>
		<?php } ?>	
			</table>