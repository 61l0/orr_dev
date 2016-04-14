 
   <link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			$( ".datepicker" ).datepicker();
	});

	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>kirim_email/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	if(data!=''){
					 $( "#infodlg" ).html(data);
					 $( "#infodlg" ).dialog({ title:"Info...", draggable: false, modal: true,});					 
				} else {
					 window.location="<?php echo base_url() ?>kirim_email";
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
	function load_div_user_tersedia(){
					$("#div_user_tersedia").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
				  });
 
			}
			function pilih_user(email){
				$("#email").val(email);
				 $('#div_user_tersedia').dialog('close')
			}
	</script>
<br>
<div id="div_user_tersedia" style="display:none">
	<table class="table multimedia table-striped table-hover">
                                    <thead>
                                        <tr>
                                             <th>Nama </th>
                                            <th>Unit </th>
                                              <th>Email </th>
                                              <th>Aksi </th>
                                         </tr>
                                    </thead>
                                    <tbody>
									 	<?php  if(!empty($query)) { foreach($query as $row) { ?> 
                                        <tr>
                                             <td><?php echo strtoupper($row->nama) ?></td>
                                            <td><?php echo strtoupper($row->nama_unit_kerja) ?></td>
                                              <td> <?php echo $row->email ?>
											</td>
                                            <td><a class='btn btn-warning btn-xs' onclick="return pilih_user('<?php echo $row->email ?>')" style='color:#fff'><i class="glyphicon glyphicon-check"></i></a></td>
                                        </tr>
										<?php }} ?>
                                    </tbody>
                                </table> 
</div>
	<div class="panel panel-primary">
     <div class="panel-heading">KIRIM EMAIL
   </div>
  <div class="well" style="margin:0px">

<form method="post" class="form1" id="form_barang" name="form_barang"/>
 	<table class="table">
   			<tr>
   				<td style="width:130px">Email Tujuan </td>
   				<td style="width:10px">:</td>
   				<td><input    style="width:350px"  id="email" name="email" type="text" value="" class="form-control input-sm pull-left"  placeholder="EMAIL" />
   				<a onclick="return load_div_user_tersedia()" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-user"></i> Lihat User</a></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Subject</td>
   				<td style="width:10px">:</td>
   				<td><input    style="width:250px"  id="subjek" name="subjek" type="text" value="" class="form-control input-sm"  placeholder="SUBJECT" /></td>
   			</tr>
   			<tr>
   				<td style="width:130px">Pesan</td>
   				<td style="width:10px">:</td>
   				<td><textarea   style="width:450px;height:100px"  id="pesan" name="pesan" 
   				type="text"  class="form-control input-sm"  placeholder="PESAN"></textarea></td>
   			</tr>
   		</table> 
 <hr>
		<a style="margin-bottom:5px;" onclick="return confirmdlg()" href="#" class="btn-primary btn btn-sm"><i class="glyphicon glyphicon-envelope
"></i> Kirim</a>
       <a style="margin-bottom:5px;" href="<?php echo base_url() ?>kirim_email" class="btn-warning btn btn-sm"><i class="glyphicon glyphicon-arrow-left
"></i> Kembali</a>
</form>
<div id="confirm" style="display:none"> Anda Ingin Meyimpan data ini</div>     
 
 </div>
 </div>

 