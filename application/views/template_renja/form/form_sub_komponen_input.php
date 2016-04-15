 <script>
  /*$(function() {
    	var program="<?php echo $program;?>";
    	if(program!=""){
    		//$(".nilai").prop("readonly", true);
   		}
  });*/
 
  function save_live_edit_sub_komponen_input(){
		$.ajax({
			url:'<?php echo base_url(); ?>template_renja/save_live_edit_sub_komponen_input/',		 
			type:'POST',
			data:$('#frm_sub_komponen_input').serialize(),
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

<form id="frm_sub_komponen_input" name="frm_sub_komponen_input">
 <input type="hidden" name="id" maxlength="5" size="5"    value="<?php echo $id; ?>"/>
<input type="hidden" id="tipe_input" name="tipe_input" maxlength="5" size="5"    value="<?php echo $tipe_input; ?>"/>
		<table style="width:100%">
				<tr>
					<td style="width:150px">Parent </td>
					<td style="width:20px"><center>:</center></td>
					<td>
					<!--<input type="text" name="program" id="program" class="form-control input-sm" value="<?php echo isset($infouser['kode_indikator']) ? $infouser['kode_indikator'] : '-'; ?>" style="width:50px;float:left">--> 
					<?php echo $parent;?></td>
				</tr>
				<tr>
					<td style="width:150px">Urutan </td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="urutan" id="urutan" class="form-control input-sm" value="<?php echo isset($infouser['urutan']) ? $infouser['urutan'] : '0'; ?>" style="width:50px"></td>
				</tr>
				
				<tr>
					<td>Kode</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" style="width:26%" name="kode" id="kode" class="form-control input-sm" value="<?php echo isset($infouser['kode']) ? $infouser['kode'] : '-'; ?>"></td>
				</tr>
				<tr>
					<td>Komponen Input </td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" style="width:90%" name="komponen_input" id="komponen_input" class="form-control input-sm" value="<?php echo isset($infouser['komponen_input']) ? $infouser['komponen_input'] : '-'; ?>"></td>
				</tr>
				<tr>
					<td>Sasaran Kegiatan</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="sasaran_kegiatan" id="sasaran_kegiatan" class="form-control input-sm" value="<?php echo isset($infouser['sasaran_program']) ? $infouser['sasaran_program'] : '-'; ?>"></td>
				</tr>
				<tr>
					<td >Target </td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="target" id="target" class="form-control input-sm" value="<?php echo isset($infouser['target']) ? $infouser['target'] : '0'; ?>" style="width:80%"></td>
				</tr>
				</table>
				<table style="width:100%">
				<tr>
					<td  style="width:150px" >BO 001</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bo001" id="bo001" class="form-control nilai input-sm" value="<?php echo isset($infouser['bo01']) ? $infouser['bo01'] : '0'; ?>" style="width:100%"></td>
					<td >BO 002</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bo002" id="bo002" class="form-control nilai input-sm" value="<?php echo isset($infouser['bo02']) ? $infouser['bo02'] : '0'; ?>" style="width:100%"></td>

					
			
				</tr>
				<tr>
					<td >BNO RM PUSAT</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bno_rm_p" id="bno_rm_p" class="form-control nilai input-sm" value="<?php echo isset($infouser['bno_rm_p']) ? $infouser['bno_rm_p'] : '0'; ?>" style="width:100%"></td>
					<td >BNO RM DAERAH</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bno_rm_d" id="bno_rm_d" class="form-control nilai input-sm" value="<?php echo isset($infouser['bno_rm_d']) ? $infouser['bno_rm_d'] : '0'; ?>" style="width:100%"></td>
				</tr>
				<tr>
					<td  style="width:150px" >BNO PHLN P</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bno_phln_p" id="bno_phln_p" class="form-control nilai input-sm" value="<?php echo isset($infouser['bno_phln_p']) ? $infouser['bno_phln_p'] : '0'; ?>" style="width:100%"></td>
					<td >BNO PHLN D</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="bno_phln_d" id="bno_phln_d" class="form-control nilai input-sm" value="<?php echo isset($infouser['bno_phln_d']) ? $infouser['bno_phln_d'] : '0'; ?>" style="width:100%"></td>
			
				</tr>
				<tr>
					<td  style="width:150px" >PNBP</td>
					<td style="width:20px"><center>:</center></td>
					<td><input type="text" name="pnbp" id="pnbp" class="form-control nilai input-sm" value="<?php echo isset($infouser['pnbp']) ? $infouser['pnbp'] : '0'; ?>" style="width:100%"></td>
					<td  style="width:150px" >KL/AP/QW/PL/PN</td>
					<td style="width:20px"><center>:</center></td>
					<td>

					<select name="kl"  class="form-control nilai input-sm" id="kl" >	
						<option value="">Pilihan</option>	
						<option <?php if($kl=='kl') echo "selected='selected'"; ?> value="kl">KL</option>	
						<option <?php if($kl=='ap') echo "selected='selected'"; ?> value="ap">AP</option>	
						<option <?php if($kl=='qw') echo "selected='selected'"; ?> value="qw">QW</option>	
						<option <?php if($kl=='pl') echo "selected='selected'"; ?> value="pl">PL</option>	
						<option <?php if($kl=='pn') echo "selected='selected'"; ?> value="pn">PN</option>	
					</select>
					 </td>
				</tr>
		</table>
		</form>