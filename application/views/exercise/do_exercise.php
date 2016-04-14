 <br>
 
 <script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
<script>
	$(function () {
	    $("#table_renja").stickyTableHeaders();
	});
 
 function save(id){ 	
 	 	$("#panel_confirm").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
		$("#panel_confirm").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: true,
					 width: 'auto',
					 height: 'auto', 
					 buttons: {					  
					  "Tutup": function(){
						   $(this).dialog("close");
						}
		 }});

		var tipe="";
		if ($("input[id='radio1']").is(':checked')) {
		   tipe=0;
		}
		if ($("input[id='radio2']").is(':checked')) {
		  tipe=1;
		}
		
		$.ajax({
			url:'<?php echo base_url(); ?>exercise/do_it/'+id,		 
			type:'POST',
			data:$('#form_data').serialize() + "&tipe=" + tipe,
			success:function(data){ 
				   $("#panel_confirm").html("OK");
				    var win = window.open('<?php echo base_url(); ?>exercise/hasil_exercise/'+id, '_blank');
  		 			win.focus();

				   
			 }
		});		
		
}
function refresh(){
	$.ajax({
			url:'<?php echo base_url(); ?>exercise/refresh/',		 
			type:'POST',
			data:$('#form_simpan').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#data_renja_up" ).html(data);
				}  
			 }
		});		
} 

</script>
	<script>
 	 
	function confirm(id){
		 
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Anda Mau Melakukan Exercise ? ...",
					 draggable: false,
					 width: '500',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){	
						 save(id);				 
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
	}
			
	</script>
	<div id="konfirmasi" style="display:none">
	Metode Exercise : 
	<radio>
		<table class="table table-striped table-bordered">			 
			<tr>
				<td>Divide / Pembagian Merata </td>
				<td><input type="radio" checked="checked" value="0" id="radio1" name="radio1"></td>
			</tr>	
			<tr>
				<td>Normalisasi / Pembagian Bulat </td>
				<td><input type="radio" id="radio2" value="1" name="radio1"></td>
			</tr>	
		</table>
		

	</div>
   	<div id="panel_confirm" style="display:none"></div>

<div class="panel panel-primary">
  <!-- Default panel contents -->
 
  <!-- Default panel contents -->
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
          <td style="vertical-align:middle;font-size:10px;width:30px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 4>KL/<br>AP/QW/<br>PL/PN</td>
 		</tr>
          <tr>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 2 rowspan =  2>BELANJA OPERASIONAL</td>
            <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold" colspan = 5 >BELANJA NON OPERASIONAL</td>
           <td style="vertical-align:middle;font-size:10px;text-align:center;background-color:#31BC86;color:#fff;font-weight:bold"  rowspan = 3>JUMLAH PAGU</td>
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

 <form method="post" class="form1" id="form_data" name="form_data"/>
       <tr>
       		<td style="padding:0px;vertical-align:middle;font-size:10px;text-align:center;background-color:#F39C12;color:#fff;font-weight:bold" colspan="6">
            	KOLOM EXERCISE
            </td>
 			<td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_bo01" id="bo01" value="<?php echo number_format($bo01); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_bo02" id="bo02" value="<?php echo number_format($bo02); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_rm_p" id="t_rm_p" value="<?php echo number_format($rm_p); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_rm_d" id="t_rm_d" value="<?php echo number_format($rm_d); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_phln_p" id="t_phln_p" value="<?php echo number_format($phln_p); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_phln_d" id="t_phln_d" value="<?php echo number_format($phln_d); ?>"/></td>
            <td style="background-color:#F39C12;padding:0px"><input style="font-size:10px" readonly class="form-control input-sm" type="text" name="t_pnbp" id="t_pnbp" value="<?php echo number_format($pnbp); ?>"/></td>
            <td style="padding:0px;vertical-align:middle;font-size:10px;text-align:center;background-color:#F39C12;color:#fff;font-weight:bold"><input style="font-size:10px" class="form-control input-sm" type="text" name="pagu" id="pagu" value="<?php echo number_format($pagu); ?>"></td>
            <td style="background-color:#F39C12;padding:0px"><a style="width:100%" onclick="return confirm(<?php echo $id;?>)" class='btn btn-primary btn-sm' ><i class="glyphicon glyphicon-refresh"></i></a></td>
        </tr>
        </form>
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