
        <script type="text/javascript">
            $(function() {
                $('#table_gue_<?php echo $id;?>').dataTable({
                	searching:false,
                	"pageLength":5,
                 });
            });
        </script>  

 <table id="table_gue_<?php echo $id;?>"  class="table multimedia table-bordered table-striped table-hover" style="font-size:12px">
                                    <thead>
                                        <tr>
                                            <th style='width:200px'>DATA YANG DIKUNCI</th>
                                            <th>BULAN </th>
                                            <th>STATUS </th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									 	<?php $bulan_text=""; if(!empty($query)) { foreach($query as $row) { ?> 
                                        <?php 
                                        	if($row->bulan=="1"){
                                        		$bulan_text="January" .' - '. date("Y");;
                                        	} else if($row->bulan=="2"){
                                        		$bulan_text="February"  .' - '. date("Y");;
                                        	}if($row->bulan=="3"){
                                        		$bulan_text="Maret"  .' - '. date("Y");;
                                        	}if($row->bulan=="4"){
                                        		$bulan_text="April"  .' - '. date("Y");;
                                        	}if($row->bulan=="5"){
                                        		$bulan_text="Mei"  .' - '. date("Y");;
                                        	}if($row->bulan=="6"){
                                        		$bulan_text="Juni"  .' - '. date("Y");;
                                        	}if($row->bulan=="7"){
                                        		$bulan_text="Juli"  .' - '. date("Y");;
                                        	}if($row->bulan=="8"){
                                        		$bulan_text="Agustus";
                                        	}if($row->bulan=="9"){
                                        		$bulan_text="September"  .' - '. date("Y");;
                                        	}if($row->bulan=="10"){
                                        		$bulan_text="Oktober"  .' - '. date("Y");;
                                        	}if($row->bulan=="11"){
                                        		$bulan_text="Novemvber"  .' - '. date("Y");;
                                        	}if($row->bulan=="12"){
                                        		$bulan_text="Desember"  .' - '. date("Y");;
                                        	}if($row->bulan==""){
                                        		$bulan_text="Tidak Tersedia";
                                        	}
                                        ?>
                                        <tr>
                                            <td><b><?php echo $row->judul ?></b></td>                                            
                                            <td><?php echo $bulan_text;?> </td>
                                            <td><?php if($row->status=="0") 
                                            { echo " <a class='btn btn-danger btn-xs'  style='color:#fff'>
                                            <i class='glyphicon glyphicon-lock
											'></i> Terkunci</a>"; } 
                                             else { echo "<a class='btn btn-success  btn-xs' style='color:#fff'><i class='glyphicon glyphicon-ok
											'></i> Terbuka</a>";} ?></td>
                                            <td>
                                                <div class="btn-group">
                                        	            <a style="color:#fff" href="<?php echo base_url();?>locking/form/<?php echo $row->id;?>" class="btn btn-primary btn-xs">
											        	<i class="glyphicon glyphicon-edit"></i>
											        	Edit</a>							
											        	 
										</tr>
										<?php }} else { ?>
										<tr>
												<td colspan="6"> <center>Data Tidak Tersedia</center> </td>
										</tr>
											<?php } ?>
                                    </tbody>
                                </table> 
  