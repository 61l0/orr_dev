<script>
	

</script>
 <script>
  /*$(function() {
    	var program="<?php echo $program;?>";
    	if(program!=""){
    		//$(".nilai").prop("readonly", true);
   		}
  }); */
 
  function save_live_edit_program(){
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/save_live_edit_program/',		 
			type:'POST',
			data:$('#frm_komponen_input').serialize(),
			success:function(data){ 
			  	$( "#infodlg" ).html(data);
				$( "#infodlg" ).dialog({  width: 'auto',title:"Info...", draggable: false,modal: true,buttons: {
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }});	
				$(".ui-dialog-titlebar-close").hide();
				load_table();
			 }
		});

	}
  </script>
  
<form id="frm_komponen_input" name="frm_komponen_input">
<input type="hidden" name="id" maxlength="5" size="5"    value="<?php echo $id; ?>"/>
<input type="hidden" id="tipe_input" name="tipe_input" maxlength="5" size="5"    value="<?php echo $tipe_input; ?>"/>
		<table style="width:100%">
				<tr>
					<td style="width:150px">Parent </td>
					<td style="width:20px"><center>:</center></td>
					<td>
					<input type="hidden" name="id_template_renja" id="id_template_renja" value="<?php echo isset($id_template_renja) ? $id_template_renja : ''; ?>">
					<!--<input type="text" name="program" id="program" class="form-control input-sm" value="<?php echo isset($infouser['kode_indikator']) ? $infouser['kode_indikator'] : '-'; ?>" style="width:50px;float:left">--> <?php echo $parent;?></td>
				</tr>
				<tr>
					<td>Kode</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" readonly style="width:26%" name="kode" id="kode" 
					class="form-control input-sm" value="<?php echo $this->session->userdata('KODE_DIREKTORAT');?>"></td>
				</tr>
				<tr>
					<td>Program </td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" style="width:90%" name="komponen_input" id="komponen_input" class="form-control input-sm" value="<?php echo isset($infouser['komponen_input']) ? $infouser['komponen_input'] : '-'; ?>"></td>
				</tr>
				<tr>
					<td>Sasaran Program</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="sasaran_kegiatan" id="sasaran_kegiatan" class="form-control input-sm" value="<?php echo isset($infouser['sasaran_program']) ? $infouser['sasaran_program'] : '-'; ?>"></td>
				</tr>
				<tr>
					<td >Target </td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="target" id="target" class="form-control input-sm" value="<?php echo isset($infouser['target']) ? $infouser['target'] : '0'; ?>" style="width:50%"></td>
				</tr>
				</table>
				 
		</table>
		</form>