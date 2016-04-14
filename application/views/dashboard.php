
<link rel="stylesheet" href="<?php echo base_url();?>css/themes/jquery.ui.all.css" type="text/css" />
  	<script>
	$(document).ready(function() {
			cek_if_exist();
	});
	function cek_if_exist(){
		var exist="<?php echo $cek;?>";
		if(exist=="0"){
			confirmdlg();
		}
	}
	function save(){
		$.ajax({
			url:'<?php echo base_url(); ?>backup_db/act/',		 
			type:'POST',
			data:$('#form_barang').serialize(),
			 beforeSend: function() {
			 	$("#div_info").html("<div class='loading_div'><img src='<?php echo base_url() ?>images/loading.gif'></div>");
				$("#div_info").dialog({ title:"Info...", modal: true,width:"500",buttons: {
					  "Tutup": function(){
					  	window.location="<?php echo base_url() ?>home";
						   $(this).dialog("close");
						}
					 }});
 			  },
			success:function(data){ 
			 	 window.location="<?php echo base_url() ?>home";
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
					 "Ya : Lakukan Backup": function(){
						 save();   
						  $(this).dialog("close");
					  },
					}
				  });
 
			}
			
	</script>
<br>
   	<div id="div_info" name="div_info"></div>
   <div class="jumbotron">
       <table>
      		<tr>
      			<td style="padding-left:20px;vertical-align:middle"><br><img src="<?php echo base_url();?>images/logoutama.png"></td>	
      			<td style="padding-left:20px;vertical-align:middle"><h2>Hello, Admin!</h2>
      <p>Aplikasi Ini merupakan implementasi  dan Optimasi dari Aplikasi Renstra dan Renja  Kementrian Dalam Negeri Ditjen Bina Pembangunan Daerah
         yang digunakan untuk mempermudah kinerja pegawai dalam melaksanakan distribusi data 
         dalam kertas kerja RENSTRA dan RENJA.		 </td>	
      		</tr>
      </table> 	
      
      	
      </p>
    </div>
 <div id="confirm" style="display:none">
<table class="table">
						 	<tbody><tr>
						 		<td style="width:21px;vertical-align:middle;padding:10px"> <i style="font-size:40px;color:#E74C3C" class="glyphicon glyphicon-info-sign"></i></td>
						 		<td> Hari Ini Anda Belum Melakukan Backup Database <br> Melakukan Backup Database Sekarang ....</td>
						 	</tr>
						</tbody></table>

</div>     
