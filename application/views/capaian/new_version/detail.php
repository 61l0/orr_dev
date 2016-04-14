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
			url:'<?php echo base_url(); ?>capaian/load_capaian/'+<?php echo $id;?>,		 
			type:'POST',
			data:"id="+id,
			success:function(data){ 
			 	  $("#data_capaian").html(data);	
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
						       load_capaian('capaian',1);

						    }      
					  });		  
			 }
		});	
    }
  	$(document).ready(function() {
	     /*load_capaian('kinerja',1);*/
	     load_capaian('capaian',2);
	     /*load_capaian('phln',3);
	     load_capaian('dktp',4);
	     load_capaian('lakip',5);
	     load_capaian('renaksi',6);*/
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
    <li><a href="#tabs-dashboard" onclick="set_mask('kinerja')"><i class="glyphicon glyphicon-transfer"></i> Executiv View</a> </li>
    <li><a href="#tabs-capaian" onclick="set_mask('keuangan')"><i class="glyphicon glyphicon-euro"></i> Capaian</a></li>
 
  </ul>
  <div id="tabs-dashboard">
 	<?php $this->load->view('capaian/dashboard/dashboard');?>
  </div>
  <div id="tabs-capaian">
  <?php $this->load->view('capaian/header_table_renja');?>
    <tbody id="data_capaian" style="overflow:scroll">
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
 
</div>
 