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
	$("#btn_refresh").hide();	

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
	
	 $("#f_sum_bo_01").html("0");
	 $("#f_sum_bo_02").html("0");
	 $("#f_sum_bno_rm_p").html("0");
	 $("#f_sum_bno_rm_d").html("0");
	 $("#f_sum_bno_phln_p").html("0");
	 $("#f_sum_bno_phln_d").html("0");
	 $("#f_sum_bno_pnbp").html("0");
	 $("#f_sum_pagu").html("0");


	$("#data_renja_up").html('<tr><td colspan="20"><center><img src="<?php echo base_url();?>images/loading.gif"></center></td></tr>')
	$.ajax({
			url:'<?php echo base_url(); ?>template_renja/refresh_export/',		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 

			  	if(data!=''){
					 $( "#data_renja_up" ).html(data);
					 $("#btn_export").show();	
					 $("#btn_refresh").show();	
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

<div id="konfirmasi" style="display:none"></div>
<div class="panel panel-primary">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
  <a href="<?php echo base_url();?>template_renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		 <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
 <div class="panel-heading">Data Renja

 </div>
   <div class="well">
   <form id="form_simpan" name="form_simpan" method="POST" action="<?php echo base_url();?>template_renja/export_now">
 		<input type="hidden" id="t_sum_bo_01" name="t_sum_bo_01" value="0">
		<input type="hidden" id="t_sum_bo_02" name="t_sum_bo_02" value="0">
		<input type="hidden" id="t_sum_bno_rm_p" name="t_sum_bno_rm_p" value="0">
		<input type="hidden" id="t_sum_bno_rm_d" name="t_sum_bno_rm_d" value="0">
		<input type="hidden" id="t_sum_bno_phln_p" name="t_sum_bno_phln_p" value="0">
		<input type="hidden" id="t_sum_bno_phln_d" name="t_sum_bno_phln_d" value="0">
		<input type="hidden" id="t_sum_bno_pnbp" name="t_sum_bno_pnbp" value="0">
		<input type="hidden" id="t_sum_pagu" name="t_sum_pagu" value="0">

 		<?php echo $tahun_anggaran;?> &nbsp;   <?php echo $get_direktorat;?>   &nbsp;  &nbsp; <?php echo $pengkodean;?> 
 		<button class="btn-sm btn btn-success pull-right" id="btn_export"> <i class="glyphicon glyphicon-export"></i>  Export To Excel </button>
 		<a class="btn-sm btn btn-warning" onclick="return refresh_table()" id="btn_refresh"> <i class="glyphicon glyphicon-refresh"></i>  Refresh</a>
</form>  

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
            <td class="hulu" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td> 
	        <td class="hulu"  rowspan = 4>KL/<br>AP/QW/<br>PL</td>
 
         </tr>
          <tr>
            <td class="hulu" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td class="hulu" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td class="hulu"  rowspan = 4>JUMLAH PAGU</td>
           </tr>
             <td class="hulu"  colspan = 2>RUPIAH MURNI</td>
            <td class="hulu"  colspan = 2>PHLN</td>
            <td class="hulu" rowspan = 2>PNBP</td>
           	
           </tr>	
         <tr>
            <td class="hulu">001</td>
            <td class="hulu">002</td>
            <td class="hulu">RM PUSAT</td>
            <td class="hulu">RM DAERAH</td>
            <td class="hulu">PHLN PUSAT</td>
            <td class="hulu">PHLN DAERAH</td>
        </tr>
    </thead>
    <tbody>
			<tr>
				<td  class="hulu2">06</td>
				<td  class="hulu2" colspan='3'><a style="cursor:pointer;text-decoration:none" 
				onclick="return show_budak()">PROGRAM BINA PEMBANGUNAN DAERAH  <span style="font-size:10px;text-decoration:italic">(show detail)</span></a></td>
				<td  class="hulu2"> </td>
				<td  class="hulu2"> </td>
				<td  class="hulu3" id="f_sum_bo_01">0</td>
				<td  class="hulu3" id="f_sum_bo_02">0</td>
				<td  class="hulu3" id="f_sum_bno_rm_p">0</td>
				<td  class="hulu3" id="f_sum_bno_rm_d">0</td>
				<td  class="hulu3" id="f_sum_bno_phln_p">0</td>
				<td  class="hulu3" id="f_sum_bno_phln_d">0</td>
				<td  class="hulu3" id="f_sum_pnbp">0</td>
				<td  class="hulu3" id="f_sum_pagu">0</td>
				<td  class="hulu2"> </td>
				</tr>
			<tr class="leungit">
				<td  class="hulu2 leungit"></td>
				<td  class="hulu2 leungit" colspan='3'></td><td  class="hulu2">Meningkatnya kualitas pembangunan daerah yang merupakan perwujudan dari pelaksanaan urusan pemerintahan daerah sebagai bagian integral dari pembangunan nasional</td>
				<td  class="hulu2"> </td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"> </td>
				</tr>
				<tr class="leungit">
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  style='vertical-align:middle;font-size:10px;text-align:center'>1</td>
				<td  class="hulu2">Persentase konsistensi dokumen perencanaan pembangunan daerah</td><td  class="hulu2"></td>
				<td  class="hulu2">50%</td>
				<td  class="hulu2"></td><td  class="hulu2"></td><td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td><td  class="hulu2"></td><td  class="hulu2"></td>
				<td  class="hulu2"></td>
				<td  class="hulu2"></td>
				</tr>
				<tr class="leungit"><td  class="hulu2"></td>
				<td  class="hulu2"></td><td  style='vertical-align:middle;font-size:10px;text-align:center'>2</td><td  class="hulu2">Persentase / 
	       	Jumlah daerah yang menyelenggarakan SIPD</td><td  class="hulu2"></td>
	       	<td  class="hulu2">20% (5 Provinsi)</td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td></tr>
	       	<tr class="leungit"><td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>3</td><td  class="hulu2">Persentase penyelesaian perselisihan antar susunan tingkat 
	       	pemerintahan terkait dengan urusan pemerintahan</td><td  class="hulu2"></td>
	       	<td  class="hulu2">100%</td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	</tr>
	       	<tr class="leungit"><td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>4</td>
	       	<td  class="hulu2">Persentase Penerapan indikator 
	       	utama SPM di daerah</td><td  class="hulu2"></td>
	       	<td  class="hulu2">100% (6 SPM)</td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	</tr><tr class="leungit"><td  class="hulu2"></td>
	       	<td  class="hulu2"></td>
	       	<td  style='vertical-align:middle;font-size:10px;text-align:center'>4</td>
	       	<td  class="hulu2">Persentase Penerapan NSPK di daerah</td>
	       	<td  class="hulu2"></td><td  class="hulu2">100% (32 Urusan))</td><td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td><td  class="hulu2"></td>
	       	<td  class="hulu2"></td></tr>
	       	</tr>
	</tbody>
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
 </div>
 </div>