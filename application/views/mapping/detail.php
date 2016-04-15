 <br>
 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
<script>
	$(function () {
	    $("#table_renja").stickyTableHeaders();
	    refresh_table();
	});
 
  
function formatDollar(num) {
		 return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
function refresh_table(){
	$("#btn_export").hide();	
	var sum_bo_01 =0;
	var sum_bo_02 =0;
	var sum_bno_rm_p =0;
	var sum_bno_rm_d =0;
	var sum_bno_phln_p =0;
	var sum_bno_phln_d =0;
	var sum_bno_pnbp =0;
	var sum_pagu =0;
	$("#t_sum_bo_01").val((sum_bo_01));
	$("#t_sum_bo_02").val((sum_bo_02));
	$("#t_sum_bno_rm_p").val((sum_bno_rm_p));
	$("#t_sum_bno_rm_d").val((sum_bno_rm_d));
	$("#t_sum_bno_phln_p").val((sum_bno_phln_p));
	$("#t_sum_bno_phln_d").val((sum_bno_phln_d));
	$("#t_sum_bno_pnbp").val((sum_bno_pnbp));
	$("#t_sum_pagu").val((sum_pagu)); 
	$("#simpan_kode_bro").hide();
	$("#data_renja_up").html('<tr><td colspan="20"><center><img src="<?php echo base_url();?>images/loading.gif"></center></td></tr>')
	$.ajax({
			url:'<?php echo base_url(); ?>mapping/refresh_export/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 

			  	if(data!=''){
					 $( "#data_renja_up" ).html(data);
					 $("#simpan_kode_bro").show();	

					 $( ".sum_bo01" ).each(function( index ) {		
					 	sum_bo_01=parseInt(sum_bo_01) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bo02" ).each(function( index ) {		
					 	sum_bo_02=parseInt(sum_bo_02) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bno_rm_p" ).each(function( index ) {		
					 	sum_bno_rm_p=parseInt(sum_bno_rm_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bno_rm_d" ).each(function( index ) {		
					 	sum_bno_rm_d=parseInt(sum_bno_rm_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bno_phln_p" ).each(function( index ) {		
					 	sum_bno_phln_p=parseInt(sum_bno_phln_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bsum_bno_phln_do01" ).each(function( index ) {		
					 	sum_bno_phln_d=parseInt(sum_bno_phln_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".sum_bno_pnbp" ).each(function( index ) {		
					 	sum_bno_pnbp=parseInt(sum_bno_pnbp) + parseInt($(this).text().replace(/,/g, '') );
					 });	
					 /* $( ".sum_pagu" ).each(function( index ) {		
					  		sum_pagu=parseInt(sum_pagu) + parseInt($(this).text().replace(/,/g, '') );
					 }); */
					 sum_pagu=sum_bo_01+sum_bo_02+sum_bno_rm_p+sum_bno_rm_d+sum_bno_phln_p+sum_bno_phln_d+sum_bno_pnbp;

					 $("#f_sum_bo_01").html(formatDollar(sum_bo_01));
					 $("#f_sum_bo_02").html(formatDollar(sum_bo_02));
					 $("#f_sum_bno_rm_p").html(formatDollar(sum_bno_rm_p));
					 $("#f_sum_bno_rm_d").html(formatDollar(sum_bno_rm_d));
					 $("#f_sum_bno_phln_p").html(formatDollar(sum_bno_phln_p));
					 $("#f_sum_bno_phln_d").html(formatDollar(sum_bno_phln_d));
					 $("#f_sum_bno_pnbp").html(formatDollar(sum_bno_pnbp));
					 $("#f_sum_pagu").html(formatDollar(sum_pagu));

					 $("#t_sum_bo_01").val((sum_bo_01));
					 $("#t_sum_bo_02").val((sum_bo_02));
					 $("#t_sum_bno_rm_p").val((sum_bno_rm_p));
					 $("#t_sum_bno_rm_d").val((sum_bno_rm_d));
					 $("#t_sum_bno_phln_p").val((sum_bno_phln_p));
					 $("#t_sum_bno_phln_d").val((sum_bno_phln_d));
					 $("#t_sum_bno_pnbp").val((sum_bno_pnbp));
					 $("#t_sum_pagu").val((sum_pagu)); 

				}  
			 }
		});		
}
  function show_budak(id){
		 $(".leungit").toggle();
		 
	 }
	function save(){
 		$.ajax({
			url:'<?php echo base_url(); ?>mapping/simpan_kode/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
 				 $( "#infodlg" ).html(data);
				 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true,
				 buttons: {
					 
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }});	
 				 
			 }
		});		
	}
	function confirmdlg(){

			$("#confirm").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 save();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
 
	}
</script> 

<style>
	.hulu{
		vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold
	}
	.hulu2{
		vertical-align:middle;font-size:10px;
 		font-size:11px;
	}
	.hulu3{
		vertical-align:middle;font-size:10px;
		text-align:center;
		font-size:11px;
	}
	.leungit{
		display:none;
	}
 	 
</style> 
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
<div id="konfirmasi" style="display:none"></div>
<div class="panel panel-primary">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
  <a href="<?php echo base_url();?>mapping" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		 <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
	  		 <a id="simpan_kode_bro" onclick="return confirmdlg()" class="btn btn-success btn-sm pull-right" style="margin:5px"><i class="glyphicon glyphicon-ok"></i> Simpan </a>

 <div class="panel-heading">Data Mapping

 </div>

   <div class="well">
 <form id="form_barang"  enctype="multipart/form-data"  name="form_barang"   method="POST">
 
 		 <?php echo $tahun_anggaran;?> &nbsp;   <?php echo $get_direktorat;?> 
  
<input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
<div id="tabledata" style="padding-top:3px">
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered" style="width:100%;">
  	<tr>
 	<td colspan="15">
 		<table style="width:40%;font-size:12px">
    	<tr>
    		<td><div style='height:15px;width:15px;background-color:#2C802C;float:left'></div> &nbsp; Indikator</td>
    	 
    		<td><div style='height:15px;;width:15px;background-color:#31BC86;float:left'></div> &nbsp;  Komponen Input</td>
    	 
    		<td><div style='height:15px;width:15px;background-color:#BED446;float:left'></div> &nbsp;  Sub Komponen Input</td>
    	</tr>
    </table>
 	</td>
 	</tr>
     <thead>
            <td class="hulu" rowspan = 4>KODE</td>          
            <td class="hulu"  rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td class="hulu" rowspan = 4 >SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td class="hulu" style="width:50px !important" rowspan = 4>TARGET</td> 
  
         </tr>
          <tr>
            <td class="hulu" colspan = 2 rowspan =  2>KODE</td>
            
           </tr>	
          
    </thead>
    
    <tbody id="data_renja_up" style="overflow:scroll">
		<?php 
			if(!empty($table)){
				echo $table;
			} else {
				echo"Table Kosong";
			}
		?>
	  </tbody>
</table> 
</div>
</form>
 	 </div>
 </div>
 </div>