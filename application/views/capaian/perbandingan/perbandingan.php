    <style>
   		.header_table{
   			 vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold 
   			}
   		.value{
   			text-align:center;font-size:12px;
   		}	
   </style>
   <?php 
   	$class="";
   	if($selisih < 0){
   		$class="danger";	
   	} else    	if($selisih > 0){
   		$class="success";	
   	}	 else    	if($selisih == 0){
   		$class="info";	
   	}	
	
   ?>
   <div>
   		<span style="border-radius:0px;"  class="btn btn-<?php echo $class;?>"><h1 style="margin:0px ">  Rp. <?php echo number_format($selisih);?> </h1></span>
   </div>
   <table id="table_renja" class="table_renja table multimedia table-striped table-hover table-bordered" style="width:100%;">
    <thead>
      	<tr>
      		<td  class="header_table" style="width:200px;font-size:15px;text-align:left">
      		<i class="glyphicon glyphicon-tower"></i> <?php echo $direktorat;?></td>
      		<td class="header_table" style="font-size:12px" style="width:200px;font-size:15px">
      		<i class="glyphicon glyphicon-stats"></i> TARGET</td>
      		<td class="header_table" style="font-size:12px"><i class="glyphicon glyphicon-send"></i> REALISASI</td>
      		<td class="header_table" style="font-size:12px;width:100px"><i class="glyphicon glyphicon-send"></i> STATUS</td>
      	</tr>    	 
    </thead>
	    <tbody>
	    	 <?php echo $tabelnya;?>

	    </tbody>
    </table>
    