<form id="frmupdate" name="frmupdate">
<input type="text" id="id_direktorat" value="<?php echo $id_direktorat;?>" name="id_direktorat" style="display:none">
	<table class="table">
   			<tr>
   				<td style="width:130px">Email Tujuan</td>
   				<td style="width:10px">:</td>
   				<td><div style="font-size:12px"><?php echo isset($email) ? $email : ''; ?></div></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Subject</td>
   				<td style="width:10px">:</td>
   				<td><input  readonly style="width:250px"  id="subject" name="subject" type="text" value="<?php echo $subject; ?>" class="form-control input-sm"  placeholder="EMAIL" /></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Pesan</td>
   				<td style="width:10px">:</td>
   				<td><textarea   style="width:450px;height:100px"  id="pesan" name="pesan" 
   				type="text"  class="form-control input-sm"  placeholder="PESAN"><?php echo $text;?></textarea></td>
   			</tr>
   		</table> 
</form>   		