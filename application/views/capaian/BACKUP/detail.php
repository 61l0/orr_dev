    <br>
    <!-- bootstrap -->
    <!--  <link href="<?php echo base_url();?>/js/xeditable/bootstrap-combined.min.css" rel="stylesheet">-->
  <script src="<?php echo base_url();?>js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>/js/xeditable/bootstrap.min.js"></script>  

    <!-- x-editable (bootstrap version) -->
    <link href="<?php echo base_url();?>/js/xeditable/bootstrap-editable.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/js/xeditable/bootstrap-editable.js"></script>
   	<script>
 		$(function() {
    		$( "#tabs" ).tabs();
		});
 	
	</script>
 	<script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
    <style>
	  .input-medium{
	  	height:35px !important;
	  } 
    </style>
    <script>
    function save_bulan(bulan){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/simpan_bulan/'+bulan,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	
			 }
		});		
    }
    function load_capaian(table,id){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_capaian/'+<?php echo $id;?>+"/"+id,		 
			type:'POST',
			data:"id="+id,
			success:function(data){ 
			 	  $("#data_capaian_"+table).html(data);	
			 	   $.fn.editable.defaults.mode = 'popup';  
					  $('.text_'+table).editable({
						    type: 'text',
						    url: '<?php echo base_url();?>capaian/simpan',    
						    pk: table,
						    title: 'Enter Value',
						    ajaxOptions: {
						        type: 'POST'
						    } ,
						    params:  {
							   'tipe_analisis': table,							     
						    } ,

							success: function() {									
						        if(id=="1"){
						        	load_capaian('kinerja',1);
						        } else if(id=="2"){
						        	load_capaian('keuangan',2);
						        } if(id=="3"){
						        	load_capaian('phln',3);
						        } if(id=="4"){
						        	load_capaian('dktp',4);
						        } if(id=="5"){
						        	load_capaian('lakip',5);
						        } if(id=="6"){
						        	load_capaian('renaksi',6);
						        }
						    }      
					  });		  
			 }
		});	
    }
  	$(document).ready(function() {
	     load_capaian('kinerja',1);
	     load_capaian('keuangan',2);
	     load_capaian('phln',3);
	     load_capaian('dktp',4);
	     load_capaian('lakip',5);
	     load_capaian('renaksi',6);
	});
	</script>
<script>
	$(function () {
	    $(".table_renja").stickyTableHeaders();
	});
 	function set_mask(table){
 		$("#tabs-"+table).mask("Loading...");
 		setTimeout(function() {
		    $("#tabs-"+table).unmask();
		  }, 1000);
 	}
	function save(id){ 		 
			$.ajax({
				url:'<?php echo base_url(); ?>capaian/tandai/'+id,		 
				type:'POST',
				data:$('#form_simpan').serialize(),
				success:function(data){ 
					  refresh();
				 }
			});		
	}
	 
	</script>
	<script>
 	function simpan_status_perbaikan(){
 		$.ajax({
			url:'<?php echo base_url(); ?>capaian/simpan_status_perbaikan/',		 
			type:'POST',
			data:$('#form_status_perbaikan').serialize(),
			success:function(data){ 
			 	  $("#konfirmasi").html('Sukses Simpan Data');
			 	  $("#konfirmasi").dialog({ buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
			 }
		});		
	}
	function confirm_status_perbaikan(){
		$("#konfirmasi").html('Anda Mau Menyimpan Data ini ? ');
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 simpan_status_perbaikan();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
	}
	function load_status_perbaikan(){
		$("#status_perbaikan").toggle();
	}			
	</script>
 
<div id="konfirmasi" style="display:none"></div>
 
<div id="tabs">
  <ul>
    <li><a href="#tabs-kinerja" onclick="set_mask('kinerja')"><i class="glyphicon glyphicon-transfer"></i> Capaian Kinerja</a> </li>
    <li><a href="#tabs-keuangan" onclick="set_mask('keuangan')"><i class="glyphicon glyphicon-euro"></i> Capaian Keuanagan</a></li>
    <li><a href="#tabs-phln" onclick="set_mask('phln')"><i class="glyphicon glyphicon-th"></i> Capaian PHLN</a></li>
    <li><a href="#tabs-dktp" onclick="set_mask('dktp')"><i class="glyphicon glyphicon-cog"></i> Capaian DKTP</a></li>
    <li><a href="#tabs-lakip" onclick="set_mask('lakip')"><i class="glyphicon glyphicon-repeat"></i> Capaian LAKIP</a></li>
    <li><a href="#tabs-renaksi" onclick="set_mask('renaksi')"><i class="glyphicon glyphicon-bookmark"></i> Capaian Renaksi</a></li>
  </ul>
  <div id="tabs-kinerja">
 	<?php $this->load->view('capaian/header_table_renja');?>
    <tbody id="data_capaian_kinerja" style="overflow:scroll">
    	<td colspan="19">
    	<center>
    		<img src="<?php echo base_url();?>images/loading.gif">
    	</center>
    	</td>
		<!-- <?php 
			if(!empty($table_capaian_keuangan)){
				echo $table_capaian_keuangan;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
</table> 
  </div>
  <div id="tabs-keuangan">
  <?php $this->load->view('capaian/header_table_renja');?>
    <tbody id="data_capaian_keuangan" style="overflow:scroll">
		<!-- <?php 
			if(!empty($table_capaian_kinerja)){
				echo $table_capaian_kinerja;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
</table> 
  </div>
  <div id="tabs-phln">
    <?php $this->load->view('capaian/header_table_renja');?>
    <tbody id="data_capaian_phln" style="overflow:scroll">
		<!--<?php 
			if(!empty($table_capaian_phln)){
				echo $table_capaian_phln;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
</table> 
  </div>
  <div id="tabs-dktp">
  	 <?php $this->load->view('capaian/header_table_renja');?>
     <tbody id="data_capaian_dktp" style="overflow:scroll">
		<!--<?php 
			if(!empty($table_capaian_dktp)){
				echo $table_capaian_dktp;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
	</table> 
  </div>
  <div id="tabs-lakip">
  	 <?php $this->load->view('capaian/header_table_renja');?>
     <tbody id="data_capaian_lakip" style="overflow:scroll">
		<!--<?php 
			if(!empty($table_capaian_lakip)){
				echo $table_capaian_lakip;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
	</table> 
  </div>
  <div id="tabs-renaksi">
  	 <?php $this->load->view('capaian/header_table_renja');?>
     <tbody id="data_capaian_renaksi" style="overflow:scroll">
		<!--<?php 
			if(!empty($table_capaian_renaksi)){
				echo $table_capaian_renaksi;
			} else {
				echo"Table Kosong";
			}
		?> -->
	  </tbody>
	</table> 
  </div>
</div>
 