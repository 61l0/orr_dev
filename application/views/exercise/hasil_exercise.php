 <br>
 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
<script>
	$(function () {
		load_table();
	    $("#table_renja").stickyTableHeaders();
	});
 
 
function load_table(){
 	var sum_bo_01 =0;
	var sum_bo_02 =0;
	var sum_bno_rm_p =0;
	var sum_bno_rm_d =0;
	var sum_bno_phln_p =0;
	var sum_bno_phln_d =0;
	var sum_bno_pnbp =0;
	var sum_pagu =0;
	

 	$.ajax({
			url:'<?php echo base_url(); ?>exercise/echo_table_renja_hasil_exercise/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			 
			success:function(data){ 
			    $("#data_renja_up").html(data);			  	 
 				    $( ".is_indikator_bo01" ).each(function( index ) {		
					 	sum_bo_01=parseInt(sum_bo_01) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bo02" ).each(function( index ) {		
					 	sum_bo_02=parseInt(sum_bo_02) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_rm_p" ).each(function( index ) {		
					 	sum_bno_rm_p=parseInt(sum_bno_rm_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_rm_d" ).each(function( index ) {		
					 	sum_bno_rm_d=parseInt(sum_bno_rm_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_phln_p" ).each(function( index ) {		
					 	sum_bno_phln_p=parseInt(sum_bno_phln_p) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_phln_d" ).each(function( index ) {		
					 	sum_bno_phln_d=parseInt(sum_bno_phln_d) + parseInt($(this).text().replace(/,/g, '') );
					 });
					 $( ".is_indikator_bno_pnbp" ).each(function( index ) {		
					 	sum_bno_pnbp=parseInt(sum_bno_pnbp) + parseInt($(this).text().replace(/,/g, '') );
					 });	
					  $( ".is_indikator_pagu" ).each(function( index ) {		
					  	sum_pagu=parseInt(sum_pagu) + parseInt($(this).text().replace(/,/g, '') );
					 });

					 $("#f_sum_bo_01").html("<center>"+formatDollar(sum_bo_01)+"</center>");
					 $("#f_sum_bo_02").html("<center>"+formatDollar(sum_bo_02)+"</center>");
					 $("#f_sum_bno_rm_p").html("<center>"+formatDollar(sum_bno_rm_p)+"</center>");
					 $("#f_sum_bno_rm_d").html("<center>"+formatDollar(sum_bno_rm_d)+"</center>");
					 $("#f_sum_bno_phln_p").html("<center>"+formatDollar(sum_bno_phln_p)+"</center>");
					 $("#f_sum_bno_phln_d").html("<center>"+formatDollar(sum_bno_phln_d)+"</center>");
					 $("#f_sum_bno_pnbp").html("<center>"+formatDollar(sum_bno_pnbp)+"</center>");
					 $("#f_sum_pagu").html("<center>"+formatDollar(sum_pagu)+"</center>");
					 $("#pagu").val(formatDollar(sum_pagu));
					 $("#pagu_asli").val((sum_pagu));


 			 }
		});	
 	
 }
  function formatDollar(num) {
		 return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  function copy_sob(){
  		$.ajax({
			url:'<?php echo base_url(); ?>exercise/copy_sob/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_renja').serialize(),			 
			success:function(data){ 
			  	  $("#infodlg").html(data);
			 	  $("#infodlg").dialog({ title:"Error",modal: true, width: 'auto',
					 height: 'auto',buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
			 	  $(".ui-dialog-titlebar-close").hide();
			 }
		});		
  }
  function refresh(){
	load_table();
  }
  function copy_data_renja(){
  	$("#div_copy_data_renja").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 copy_sob();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
  }	
  function confirm_exercise(){
  	$("#confirm").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 do_it();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  });
  }	
</script>
<div id="div_copy_data_renja" style="display:none"> 

	

	<table style="margin:10px;width:100%">
			<tr><td rowspan="3" colspan="2" style="padding:10px;width:30px;border-right:1px solid #dedede">
			<i  style="color:#E74C3C;font-size:30px;border:5px solid #18BC9C;border-radius:50px;padding:5px" class="glyphicon glyphicon-ok"></i>
			  </td></tr>
			<tr>
				<td style="padding-left:10px"> Lakukan Duplikasi Ke Data Renja Asli ..... </td>
			</tr>
			 
		</table>

 
</div>
    <form method="post" class="form1" id="form_barang" name="form_barang"/>
<div id="konfirmasi" style="display:none"></div>
<div id="confirm" style="display:none"><i class="glyphicon glyphicon-question-sign"></i> Anda Ingin Melakukan  Exercise ??</div>    	
<a onclick="return copy_data_renja();" class="btn btn-danger btn-sm pull-right" style="margin:5px"> 
	  		<i class="glyphicon glyphicon-check"></i> Lakukan Duplikasi Ke Data Renja  </a>
<div class="panel panel-primary">
 
  <a href="<?php echo base_url();?>template_renja" class="btn btn-warning btn-sm pull-right" style="margin:5px"> 
	  		 <i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
 <div class="panel-heading">Data Renja

 </div>
  <div class="well">
 
<div id="tabledata">
<table id="table_renja" class="table multimedia table-striped table-hover table-bordered" style="width:100%;">
    <thead >
    	<tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>KODE</td>
          
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold;font-weight:bold" rowspan = 4 colspan = 3>PROGRAM / <br> KEGIATAN / INDIKATOR /  <br> KOMPONEN INPUT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4 >SASARAN PROGRAM (OUTCOME)  <br> / SASARAN KEGIATAN (OUTPUT)</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 4>TARGET</td> 
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 8>RENCANA PAGU TAHUN 2016 (Rp. X 1000)</td>  
        	
 
 	        <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan="2" rowspan = 4>EXERCISE</td>
         </tr>
          <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>JUMLAH PAGU</td>
           </tr>
             <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  colspan = 2>RUPIAH MURNI</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  colspan = 2>PHLN</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" rowspan = 2>PNBP</td>
           	
           </tr>	
         <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">001</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">002</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">RM DAERAH</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN PUSAT</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold">PHLN DAERAH</td>
	       

 
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
 	 </div>
 </div>
 </div>