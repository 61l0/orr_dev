    <script src="<?php echo base_url();?>js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	  add_tiny_mce();
	});

function add_tiny_mce(){
	tinymce.init({
	    selector: "textarea",
	    height:100,
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
}
</script>
	<script>
 	function save(){
 	
 		 tinymce.remove()	
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/cek/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			 
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true});	
					 add_tiny_mce();
				} else {
					 tinymce.remove()	
					 $("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
					$("#div_info").dialog({ title:"Info...", modal: true,width:"500"});
				$(".ui-button").hide();
					 $("#form_barang").submit();
				}
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
	function show_table_mapping(){
		$( "#table_mapping" ).toggle();
	}
	function show_isi_langsung(){
		$("#export_from_past").hide();
		$("#export_from_excel").hide();
	}
	function show_export_from_past(){
		$("#export_from_past").show();
		$("#export_from_excel").hide();
	}
	function show_export_from_excel(){
		$("#export_from_past").hide();
		$("#export_from_excel").show();
		$("#contoh_renja" ).dialog({ title:"Contoh Form Data Renja...", draggable: false, modal: true,width: 'auto',
					 height: 'auto', buttons: {
					 "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
					});	
		return false;
	}
	</script>
<br>
<div id="div_info" name="div_info"></div>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>   
<div id="contoh_renja" style="display:none">
<h2 style="margin:0px;text-align:left;border-radius:0px" class="btn btn-danger btn-block"><b><i class="glyphicon glyphicon-info-sign"></i> BENTUK EXCEL RENJA YANG AKAN DI UPLOAD...</b></h2><img style="border:1px solid #dedede" src="<?php echo base_url();?>images/contoh_renja.png"></div>     
<form id="form_barang"  enctype="multipart/form-data"  name="form_barang" action="<?php echo base_url();?>template_renja/simpan" method="POST">
<fieldset>
    <input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
    <table   style="width:100%;margin-bottom:5px; ">
	    <tr>
 	    	<td style="display:none" ><b>Judul</b><br><input style="width:300px" class="form-control  required" id="judul" 
 	    	value="<?php echo isset($infouser['judul']) ? $infouser['judul'] : "RENJA ".$this->session->userdata('NAMA_UNIT_KERJA')." ".date('Y') ; ?>" name="judul" required="true" type="text" /></td>
	    	<td><b>Unit</b>
 	    		<?php echo $kepada;?>
 	    	</td>
 	    	</tr>
 	    	<tr>
 	    	<td><br><b>Tahun Anggaran</b>
 	    		<?php echo $tahun_anggaran;?>
 	    	</td>
 	    	 
	    </tr>
	   	<tr>
	    	<td colspan="4">
 	    	 <br>
	    	 <fieldset style="border:2px solid #dedede !important;padding-left:10px !important;padding-bottom:10px !important">
	    	 <legend style="font-size:15px;font-weight:bold;width:15%;margin-left:3px;margin-bottom:0px"> &nbsp;Opsi Export Data Renja</legend>
	    	<i class="glyphicon glyphicon-edit"></i> <input onchange="return show_isi_langsung()" style="margin-top:13px" checked="checked" value="0" type="radio" name="opsi_export" id="r_export_none">  
	    	 Lakukan Pengisian Langsung  <br>

	    	<i class="glyphicon glyphicon-calendar"></i>
	    	<input style="margin-top:13px"
	    	onchange="return show_export_from_past()" value="0" type="radio" name="opsi_export" id="r_export_from_past">  Export Dari Renja ( Tahun ) Yang Tersedia  <br>
	    	 
	    	<i class="glyphicon glyphicon-upload"></i> <input 
	    	onchange="return show_export_from_excel()" style="margin-top:13px" type="radio" name="opsi_export" value='1'
	    	 id="r_export_from_excel">  Export Dari Upload (Excel) </fieldset> </td>
	    </tr>
	    <tr style="display:none" id="export_from_past">
	    	<td>
	    		<b>Export Data Renja Dari Tahun : </b><br>
	    		<table  style="width:96%"  style="margin:0px;padding:0px">
	    			<tr class="btn btn-danger btn-block btn-xs">
	    				<td style="width:30px;padding:5px;vertical-align:top">
	    				 <i style="font-size:40px;color:#fff;margin-left:3px" class="glyphicon glyphicon-info-sign"></i></td>
	    				<td style="width:96%"><?php echo $tahun_renja_export;?></td>
 	    			</tr>	
	    			
	    		</table>
	    		<span style="font-size:12px;color:red">  <b>* Bila Dipilih Maka Data Akan Langsung Di Tambahkan / Ditimpah Bila data Sudah Tersedia</b> </span>    		
	    	</td>
	   		 </tr>
	     <tr style="display:none"   id="export_from_excel">
			<td colspan="4" >   
			<span  class="btn btn-primary"  style="width:100%;margin-top:5px;text-align:left"> 
			<input type="file" style="float:left" name="file_berkas[]" id="file_berkas" size="20" /> 
 	    	( <b>*.xls  </b>)  attachment ini merupakan file excel data renja </span>
 	    	</td>
	     </tr>	
     <tr >
	<td style="display:none" colspan="4">   
			 	     <div class="panel panel-danger" style="margin-top:5px;cursor:pointer" >
					  <div class="panel-heading" onclick="return show_table_mapping()">
					    <input style="height:20px;width:20px;float:left;margin-top:1px" id="is_mapping" value="y" type="checkbox" class="form-control" name="is_mapping"> 
					     &nbsp; Gunakan Table Mapping</div>
					  <div class="panel-body" id="table_mapping" style="padding:0px;display:none">
					      <table style="width:100%" class="table table-striped">
					      		<tr>
					      		  <td style="width:230px">PROGRAM</td>
					      		  <td style="width:10px"> : </td>
					      		  <td><?php echo $combo_mapping_program;?></td>
					      		  <td style="width:200px">&nbsp;</td>
					      		  <td>BO 001</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_bo001;?></td>
				      			</tr>
					      		<tr>
					      		  <td>KEGIATAN</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_kegiatan;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>BO 002</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_bo002;?></td>
				      			</tr>
					      		<tr>
					      		  <td>NORMOR URUT INDIKATOR</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_nomor_urut_indikator;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>RUPIAH MURNI PUSAT</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_rm_p;?></td>
				      			</tr>
					      		<tr>
					      		  <td>INDIKATOR</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_indikator;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>RUPIAH MURNI DAERAH</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_rm_d;?></td>
				      			</tr>
					      		<tr>
					      		  <td>NORMOR URUT KOMPONEN INPUT</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_nomor_urut_komponen_input;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>PHLN PUSAT</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_phln_p;?></td>
				      			</tr>
					      		<tr>
					      		  <td>KOMPONEN INPUT</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_komponen_input;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>PHLN DAERAH</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_phln_d;?></td>
				      			</tr>
					      		<tr>
					      		  <td>SASARAN PROGRAN (Outcome)</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_sasaran_program;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>PNBP</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_pnbp;?></td>
				      			</tr>
					      		<tr>
					      		  <td>SASARAN KEGIATAN (Output)</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_sasaran_kegiatan;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>KL/AP/QW/PL/PN</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_renaksi;?></td>
				      			</tr>
					      		<tr>
					      		  <td>TARGET</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_target;?></td>
					      		  <td>&nbsp;</td>
					      		  <td>UNIT</td>
					      		  <td> : </td>
					      		  <td><?php echo $combo_mapping_unit;?></td>
					      		</tr>
					      </table>
					  </div>
					</div>
 	    	</td>
	     </tr>	

		<tr>
 	    	<td style="display: none" colspan="4"> <b>Note / Catatan </b><br>
 	    		 <textarea name="note" id="note" class="form-control" style="height:200px;width:100%;display: none"><?php echo isset($infouser['note']) ? $infouser['note'] :  "RENJA ".$this->session->userdata('NAMA_UNIT_KERJA').' '.date("Y") ?> </textarea>
 	    	</td>
	    </tr>
	    <tr>
 	    	
	    </tr>

    </table>
 	<hr>
    <a onclick="return confirmdlg()" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i> Simpan </a>
    <a href="<?php echo base_url();?>template_renja" class="btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i> Batal  </a>
</fieldset>
</form>
<br>