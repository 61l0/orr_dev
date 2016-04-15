    <br>
        <script src="<?php echo base_url();?>js/bootstrap.js"></script>

     <script src="<?php echo base_url();?>/js/xeditable/bootstrap.min.js"></script>  
     <link href="<?php echo base_url();?>/js/xeditable/bootstrap-editable.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>/js/xeditable/bootstrap-editable-capaian.js"></script>
    <script src="<?php echo base_url();?>js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/uploadify/uploadify.css">
   	<script>
 		$(function() {
    			$( "#tabs" ).tabs();
				$( "#tabs_realisasi_capaian_kinerja" ).tabs();
				$( "#tabs_realisasi_capaian_keuangan" ).tabs();
		});
	</script>
	 
 	<script src="<?php echo base_url(); ?>js/float_thead/sticky.js"></script>	
    <style>
	  .input-medium{
	  	height:35px !important;
	  } 
    </style>
    <script>
    function get_detail_dokumen(id){
     	 $("#detail_dok_"+id).toggle();
		 $.ajax({
			  type: "POST",
			  url: "<?php echo base_url()?>capaian/get_detail_dokumen/"+id,			  
			  success: function(msg) {
				$("#data_detail_dok_"+id).html(msg);
 			  }
			});
    }
    function get_executiv_view_capaian_kinerja(){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/get_total_capaian_kinerja/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#chart_capaian_kinerja").html(data);	
			 }
		});	
    }
    function get_executiv_view_capaian_keuangan(){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/get_total_capaian_keuangan/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#chart_capaian_keuangan").html(data);	
			 }
		});		
    }
    function get_executiv_view_capaian_phln(){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/get_total_capaian_phln/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#chart_capaian_phln").html(data);	
			 }
		});		
    }
    function get_executiv_view_capaian_dktp(){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/get_total_capaian_dktp/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#chart_capaian_dktp").html(data);	
			 }
		});		
    }
     function get_executiv_view_capaian_renaksi(){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/get_total_capaian_renaksi/'+<?php echo $id;?>,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	 $("#chart_capaian_renaksi").html(data);	
			 }
		});		
    }
    function save_bulan(bulan,tipe,target_or_realisasi,id_template_renja,kinerja_or_keuangan){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/simpan_bulan/'+bulan+'/'+tipe+'/'+target_or_realisasi+'/'+id_template_renja+'/'+kinerja_or_keuangan,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	  $.ajax({
                    url: '<?php echo base_url(); ?>capaian/get_deskrpsi/',      
                    type:'POST',
                    success:function(msg){ 
                        $("#deskripsi").val(msg)
                   	  }
              	  }); 
			 }
		});		
    }
    function load_capaian_lainnya(id,div){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_capaian_lainnya/'+<?php echo $id;?>+"/"+id,		
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	$("#content_"+div).html(data);
			 }
		});		
    }
    function load_capaian_all(table,id){
    	$("#data_capaian_target_"+table).mask('Loading.....');
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_capaian_all/'+<?php echo $id;?>+"/"+id,		 
			type:'POST',
			data:"id="+id,
			success:function(data){ 
				  $("#data_capaian_all").unmask();
			 	  $("#data_capaian_all").html(data);				 	  
			 }
		});	
    }
    function load_capaian_target(table,id){
       	$("#data_capaian_target_"+table).mask('Loading.....');
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_capaian_target/'+<?php echo $id;?>+"/"+id,		 
			type:'POST',
			data:"id="+id,
			success:function(data){ 
				  $("#data_capaian_target_kinerja").unmask();
			 	  $("#data_capaian_target_kinerja").html(data);	
			 	  	  set_after_load();	
			 	  	  $(".containernya").width(1200);
					  $("body").width(1200);
	 				  $(".containernya").width($(document).width()+200);
					  $("body").width($(document).width());
			 	      $.fn.editable.defaults.mode = 'popup';  
			 	      /* SET CAPAIAN KINERJA */
					  $('.text_'+table+'_target').editable({
						    type: 'text',
						    url: '<?php echo base_url();?>capaian/simpan_target',    
						    pk: table,
						    title: 'Enter Value',
 						    ajaxOptions: {
						        type: 'POST'
						    } ,
						    params:  {
							   'tipe_analisis': table,			
						    } ,						   
							success: function(data) {  							
						        load_capaian_target('kinerja',1);
						        if(data!=""){
						        	 $( "#infodlg" ).html(data);
									 $( "#infodlg" ).dialog({width: 'auto',height: 'auto', title:"Info...", draggable: false,modal:true,buttons: { "Tutup": function(){ $(this).dialog("close"); } }});	
						        	$(".ui-dialog-titlebar-close").hide();	
						        }
						    }      
					  });	
    				  /* END SET CAPAIAN KINERJA */	
    				 $('.text_keuangan_target').editable({
						    type: 'text',
						    url: '<?php echo base_url();?>capaian/simpan_target',    
						    pk: 'keuangan',
						    data:$("#form-inline").serialize(),
						    title: 'Enter Value',
						    ajaxOptions: {
						        type: 'POST'
						    } ,
						    params:  {
							   'tipe_analisis': 'keuangan',							     
						    } ,						   
							success: function(data) {  							
						        load_capaian_target('keuangan',2);
						        if(data!=""){
						        	 $( "#infodlg" ).html(data);
									 $( "#infodlg" ).dialog({width: 'auto',height: 'auto', title:"Info...", draggable: false,modal:true,buttons: { "Tutup": function(){ $(this).dialog("close"); } }});	
						        	$(".ui-dialog-titlebar-close").hide();	
						        }
						    }      
					 });	

    				

			 }
		});	
    }
    function load_capaian_realisasi(table,id,komparasi){
     	if(komparasi=="2"){
    		komparasi=$("#select_komparasi_keuangan").val();
    	}
    	if(komparasi=="3"){
    		komparasi=$("#select_komparasi_phln").val();
    	}
    	if(komparasi=="4"){
    		komparasi=$("#select_komparasi_dktp").val();
    	}
    	if(komparasi=="6"){
    		komparasi=$("#select_komparasi_renaksi").val();
    	}
    	if(id=="2"){
    		komparasi=$("#select_komparasi_keuangan").val();
    	}
    	if(id=="3"){
    		komparasi=$("#select_komparasi_phln").val();
    	}
    	if(id=="4"){
    		komparasi=$("#select_komparasi_dktp").val();
    	}
    	if(id=="6"){
    		komparasi=$("#select_komparasi_renaksi").val();
    	}
     	$("#data_capaian_"+table).mask("Loading...");
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_capaian_realisasi/'+<?php echo $id;?>+"/"+id,		 
			type:'POST',
			data:"id="+id+"&komparasi="+komparasi,
			success:function(data){ 
  				  $("#data_capaian_"+table).unmask();
 			 	  $("#data_capaian_"+table).html(data);	
 			 	  set_after_load();	
 			 	  $(".containernya").width(1200);
				  $("body").width(1200);
 				  $(".containernya").width($(document).width()+200);
				  $("body").width($(document).width());
			 	      $.fn.editable.defaults.mode = 'popup';  
					  $('.text_'+table).editable({
						    type: 'text',
						    url: '<?php echo base_url();?>capaian/simpan_realisasi',    
						    pk: table,
						    title: 'Enter Value',
						    data:$("#form-inline").serialize(),
						    ajaxOptions: {
						        type: 'POST'
						    } ,
						    params:  {
							   'tipe_analisis': table,							     
						    } , 		
							success: function(data) {	
								load_capaian_target('kinerja',1);								
						        if(id=="1"){
						        	load_capaian_realisasi('kinerja',1);
						        	get_executiv_view_capaian_kinerja();
						        	load_komparasi('capaian_kinerja');	
						        } else if(id=="2"){
 						        	//load_capaian_realisasi('keuangan',2);
						        	load_capaian_realisasi('kinerja',1);
						        	get_executiv_view_capaian_keuangan();
						        	load_komparasi('capaian_keuangan');
 						        } if(id=="3"){
						        	load_capaian_realisasi('phln',3);
						        	get_executiv_view_capaian_phln();
						        	load_komparasi('capaian_phln');	

						        } if(id=="4"){
						        	load_capaian_realisasi('dktp',4);
						        	get_executiv_view_capaian_dktp();
						        	load_komparasi('capaian_dktp');	
						        } if(id=="5"){
						        	load_capaian_realisasi('lakip',5);
						        } if(id=="6"){
						        	load_capaian_realisasi('renaksi',6);
						        	get_executiv_view_capaian_renaksi();
						        	load_komparasi('capaian_renaksi');	
						        }
						        if(data!=""){
						        	 $( "#infodlg" ).html(data);
									 $( "#infodlg" ).dialog({ title:"Info...", draggable: false,modal:true});	
						        }
						    }      
					  });		 
					   $('.text_keuangan').editable({
						    type: 'text',
						    url: '<?php echo base_url();?>capaian/simpan_realisasi',    
						    pk: 'keuangan',
						    title: 'Enter Value',
						    data:$("#form-inline").serialize(),
						    ajaxOptions: {
						        type: 'POST'
						    } ,
						    params:  {
							   'tipe_analisis': 'keuangan',							     
						    } ,						   
							success: function(data) {  							
 						        load_capaian_realisasi('kinerja',1);
 						        load_capaian_target('kinerja',1);	

						        if(data!=""){
						        	 $( "#infodlg" ).html(data);
									 $( "#infodlg" ).dialog({width: 'auto',height: 'auto', title:"Info...", draggable: false,modal:true,buttons: { "Tutup": function(){ $(this).dialog("close"); } }});	
						        	$(".ui-dialog-titlebar-close").hide();	
						        }
						    }      
					  });	
 

			 }
		});	
		

    }
    function load_komparasi(table){
    	$.ajax({
			url:'<?php echo base_url(); ?>capaian/load_komparasi/'+<?php echo $id;?>+'/'+table,		 
			type:'POST',
			data:$('#form_barang').serialize(),
			success:function(data){ 
			  	$("#div_komparasi_"+table).html(data)
			 }
		});	
    }
    
    function load_data_chart(id){
    	if(id=="0"){
    		/* HANYA MENAMPILKAN VIEW */	
    		load_capaian_all('kinerja',1);
    	}	else  if(id=="1") {
    		load_capaian_target('kinerja',1);
    	} else  if(id=="2") {
    		load_capaian_realisasi('kinerja',1);
    	}

    	/*if(nama_capaian!="0" && kode_capaian=="0" && komparasi=="0"){
	      	 if ($("#data_capaian_target_"+nama_capaian+"").find("img").length > 0) {
			    	if(nama_capaian=='kinerja'){
			    		load_capaian_target('kinerja',1);
			    	} else if(nama_capaian=='keuangan'){
			    		load_capaian_target('keuangan',2);
			    	} else if(nama_capaian=='phln'){
			    		load_capaian_target('phln',3);
			    	} else if(nama_capaian=='dktp'){
			    		load_capaian_target('dktp',4);
			    	} else if(nama_capaian=='lakip'){
			    		load_capaian_target('lakip',5);
			    	} else if(nama_capaian=='renaksi'){
			    		load_capaian_target('renaksi',6);
			    	}
		    }	
		}
 		if(nama_capaian=="0" && kode_capaian!="0" && komparasi=="0"){
	      	 if ($("#data_capaian_"+kode_capaian).find("img").length > 0) {
			    	if(kode_capaian=='kinerja'){
			    		load_capaian_realisasi('kinerja',1);
			    	} else if(kode_capaian=='keuangan'){
			    		load_capaian_realisasi('keuangan',2);
			    	} else if(kode_capaian=='phln'){
			    		load_capaian_realisasi('phln',3);
			    	} else if(kode_capaian=='dktp'){
			    		load_capaian_realisasi('dktp',4);
			    	} else if(kode_capaian=='lakip'){
			    		load_capaian_realisasi('lakip',5);
			    	} else if(kode_capaian=='renaksi'){
			    		load_capaian_realisasi('renaksi',6);
			    	}
		    }	
		}
		/*if(nama_capaian=="0" && kode_capaian=="0"  && komparasi!="0"){
	      	 if ($("#data_capaian_"+komparasi).find("img").length > 0) {
			    	if(komparasi=='kinerja'){
			    		load_komparasi('capaian_kinerja',1);
			    	} else if(komparasi=='keuangan'){
			    		load_komparasi('capaian_keuangan',2);
			    	} else if(komparasi=='phln'){
			    		load_komparasi('capaian_phln',3);
			    	} else if(komparasi=='dktp'){
			    		load_komparasi('capaian_dktp',4);
			    	} else if(komparasi=='lakip'){
			    		load_komparasi('capaian_lakip',5);
			    	} else if(komparasi=='renaksi'){
			    		load_komparasi('capaian_renaksi',6);
			    	}
		    }	
		}*/
	}
	function hide_triwulan(id){
		$(".triwulan_"+id).toggle();
		var mcheck1 = ($("#c_triwulan_1").is(":checked"));
  		var mcheck2 = ($("#c_triwulan_2").is(":checked"));
  		var mcheck3 = ($("#c_triwulan_3").is(":checked"));
  		var mcheck4 = ($("#c_triwulan_4").is(":checked")); 	
 		//$('.c_triwulan_'+id).prop( 'checked',false );
 		 
  		value=mcheck1+mcheck2+mcheck3+mcheck4;
  		var value_kinerja=(value*3);
  		var value_keuangan=(value*5);

 		$(".td_capaian_kinerja").attr('colspan',value_kinerja);
 		$(".td_capaian_keuangan").attr('colspan',value_keuangan);
 		
 		$(".containernya").width(1200);
		$("body").width(1200);
	 	$(".containernya").width($(document).width()+200);
		$("body").width($(document).width());
  	}
  	function set_after_load(){
  		var mcheck1 = ($("#c_triwulan_1").is(":checked"));
  		var mcheck2 = ($("#c_triwulan_2").is(":checked"));
  		var mcheck3 = ($("#c_triwulan_3").is(":checked"));
  		var mcheck4 = ($("#c_triwulan_4").is(":checked")); 	

  		if(mcheck1){
  			$(".triwulan_1").show();
  		} else {
  			$(".triwulan_1").hide();
  		}	
  		if(mcheck2){
  			$(".triwulan_2").show();
  		} else {
  			$(".triwulan_2").hide();
  		}	  		 
  		if(mcheck3){
  			$(".triwulan_3").show();
  		} else {
  			$(".triwulan_3").hide();
  		}	
  		if(mcheck4){
  			$(".triwulan_4").show();
  		} else {
  			$(".triwulan_4").hide();
  		}	
  		hide_triwulan();
  	}
  	function formatDollar(num) {
		 return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
  	function load_table_renja(){
	 	var sum_bo_01 =0;
		var sum_bo_02 =0;
		var sum_bno_rm_p =0;
		var sum_bno_rm_d =0;
		var sum_bno_phln_p =0;
		var sum_bno_phln_d =0;
		var sum_bno_pnbp =0;
		var sum_pagu =0;	
		var data=$("#data_renja_up").html();
 		if(data!=""){
			return false;
		} else {
	 	$.ajax({
				url:'<?php echo base_url(); ?>capaian/echo_table_renja/'+<?php echo $id;?>,		 
				type:'POST',
				data:$('#form_barang').serialize(),
				beforeSend: function() {
					$("#data_renja_up").html('<td colspan="15"> <center><div><img src="<?php echo base_url();?>images/loading.gif"></div></center></td>');
	 			},
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


						 $("#f_sum_bo_01").html(formatDollar(sum_bo_01));
						 $("#f_sum_bo_02").html(formatDollar(sum_bo_02));
						 $("#f_sum_bno_rm_p").html(formatDollar(sum_bno_rm_p));
						 $("#f_sum_bno_rm_d").html(formatDollar(sum_bno_rm_d));
						 $("#f_sum_bno_phln_p").html(formatDollar(sum_bno_phln_p));
						 $("#f_sum_bno_phln_d").html(formatDollar(sum_bno_phln_d));
						 $("#f_sum_bno_pnbp").html(formatDollar(sum_bno_pnbp));
						 $("#f_sum_pagu").html(formatDollar(sum_pagu));
						  
	 			 }
			});	
    		}
		 }
	  	$(document).ready(function() {
	  		load_table_renja();
		$( ".export_to_excel" ).click(function() {
  			var href=($(this).prop('href'));
  			var nama=($(this).prop('name'));
  			var komparasi=$("#"+nama).val();
   			window.location=href+'/'+komparasi;
   			return false;
  		});

   		 $( ".mcheckbox" ).click(function() {
		 	var mcheck = ($(this).is(":checked"));
			var idnya=($(this).prop('id'));	
			 if(mcheck){
			 	$('.'+idnya).prop( 'checked',true );
			 } else {
			 		$('.'+idnya).prop( 'checked',false );
			 }	
		});
   		 //load_komparasi('capaian_kinerja');	
  		 //load_komparasi('capaian_keuangan');	
  		 //load_komparasi('capaian_dktp');	
  		 //load_komparasi('capaian_phln');	
  		 //load_komparasi('capaian_renaksi');	
  		
  		 //get_executiv_view_capaian_keuangan();
  		 //get_executiv_view_capaian_phln();
	     //get_executiv_view_capaian_dktp();
	     //get_executiv_view_capaian_renaksi();
	     //get_executiv_view_capaian_kinerja();  
	     
	     //load_capaian_realisasi('kinerja',1);
	     //load_capaian_realisasi('keuangan',2);
	     //load_capaian_realisasi('phln',3);
	     //load_capaian_realisasi('dktp',4);
	     //load_capaian_realisasi('lakip',5);
	     //load_capaian_realisasi('renaksi',6);

	     //load_capaian_target('kinerja',1);
	     //load_capaian_target('keuangan',2);
	     //load_capaian_target('phln',3);
	     //load_capaian_target('dktp',4);
	     //load_capaian_target('lakip',5);
	     //load_capaian_target('renaksi',6);  
	     
	});
	</script>
<script>
	$(function () {
	    $(".table_renja").stickyTableHeaders();
	});
 	function set_mask(table){ 
  			$(".containernya").css("width", "100%");
  			$("body").css("width", "100%");
	 		$("#"+table).mask("Loading...");
	  		setTimeout(function() {
		    $("#"+table).unmask();
		    $(".containernya").width($(document).width());
  			$("body").width($(document).width());
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
			url:'<?php echo base_url(); ?>capaian/simpan_persentase_target/',		 
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
		$(".ui-dialog-titlebar-close").hide();
	}
	function load_status_perbaikan(){
		$("#status_perbaikan").toggle();
	}			
	function simpan_persetujuan(){
		$.ajax({
			url:'<?php echo base_url(); ?>capaian/simpan_persetujuan/',		 
			type:'POST',
			data:$('#form_persetujuan_capaian').serialize(),
			success:function(data){ 
				if(data!=''){
				  $("#konfirmasi").html(data);
			 	  $("#konfirmasi").dialog({ buttons: { "Tutup": function(){ $(this).dialog("close"); } }});
				} else {
				  $("#konfirmasi").html('<i class="glyphicon glyphicon-ok-sign" style="font-size:20px"></i> Sukses Melakukan Persetujuan Data ....');
			 	  $("#konfirmasi").dialog({ buttons: { "Tutup": function(){ window.location="<?php echo base_url();?>capaian/rekap_renja/<?php echo $id;?>/#tabs-persetujuan"; $(this).dialog("close"); } }});
				}

			 }
		});		
	}
	function hide_kinerja(){
 		 
 		
  		var c_kinerja = ($("#chk_kinerja").is(":checked"));

  		if(c_kinerja){
  			$(".td_kinerja").show();
  		} else {
  			$(".td_kinerja").hide();
  		}	


 	}
 	function hide_keuangan(){
 		var c_keuangan = ($("#chk_keuangan").is(":checked"));
  		if(c_keuangan){
  			$(".td_keuangan").show();
  		} else {
  			$(".td_keuangan").hide();
  		}	
 	}
	function form_simpan_persetujuan(){
		$("#konfirmasi").html('Anda Mau Melakukan Persetujuan Terhadap Capaian Ini ? ');
		$("#konfirmasi").dialog({
					 resizable: false,
					 modal: true,
					 title:"Info...",
					 draggable: false,
					 width: 'auto',
					 height: 'auto',
					 buttons: {
					 "Ya": function(){
						 simpan_persetujuan();   
						  $(this).dialog("close");
					  },
					  "Tutup": function(){
						   $(this).dialog("close");
						}
					 }
				  }); 
		$(".ui-dialog-titlebar-close").hide();
	}
	</script>
	 
 <style>
 .bg_image{
 	background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;
 }
 </style>
 <?php
 	function status_capaian($st=""){
 		$color="";
 		$text="";
 		if($st=="1"){
 			$color="#31BC86";
 			$text="<i class='glyphicon glyphicon-ok-sign'></i>  &nbsp; SUDAH DISETUJUI";
 		}	else {
 			$color="#E74C3C";
 			$text="<i class='glyphicon glyphicon-remove-sign'></i>  &nbsp; MASIH HARUS DIPERBAIKI";
 		}
 		$toogle=' 
	  		<table style="width:80%;margin-bottom:3px;float:left" class="table table-bordered" >
	  			<tr>
	  				<td style="width:40%;background-color:'.$color.';color:#fff;font-weight:bold">  	
	  				<h5 style="margin-left:5px;margin-top:5px;margin-bottom:5px;float:left"> 
	  				<b>'.$text.'</b> </h5></td>	   				 
	   			</tr>
	  		</table>
	  	 ';
	  	echo $toogle;
 	}
 	
 	function cetak_toogle($text=""){
	 	$toogle="";
	 	$check_triwulan_1="";
	 	$check_triwulan_2="";
	 	$check_triwulan_3="";
	 	$check_triwulan_4="";
	 	if((date("m")=="01") or (date("m")=="02") or (date("m")=="03") ){
	 		$check_triwulan_1=' checked="checked" ';
	 	} else if((date("m")=="04") or (date("m")=="05") or (date("m")=="06")){
	 		$check_triwulan_2=' checked="checked" ';
	 	} if((date("m")=="07") or (date("m")=="08") or (date("m")=="09")){
	 		$check_triwulan_3=' checked="checked" ';
	 	} if((date("m")=="10") or (date("m")=="11") or (date("m")=="12")){
	 		$check_triwulan_4=' checked="checked" ';
	 	}
	 	$toogle='<div>
	  		<table style="width:100%;margin-bottom:3px" class="table table-bordered" >
	  			<tr>
	  				<td style="width:40%;background-color:#2C3E50;color:#fff;font-weight:bold">  	
	  				<h5 style="margin-left:5px;margin-top:5px;margin-bottom:5px;float:left"><i class="glyphicon glyphicon-th"></i> 
	  				<b>CAPAIAN '.$text.'</b> </h5></td>
	   				<td style="background-color:#31BC86;font-weight:bold;">
	   				<input   onchange="return hide_triwulan(1)"   class="mcheckbox c_triwulan_1"  '.$check_triwulan_1.' style="float:left;margin:7px;" type="checkbox" name="c_triwulan_1" id="c_triwulan_1">  TRIWULAN I </td>
	  				<td style="background-color:#36D195;font-weight:bold;">
	  				<input   onchange="return hide_triwulan(2)"  class="mcheckbox c_triwulan_2" '.$check_triwulan_2.'   style="float:left;margin:7px;" type="checkbox" name="c_triwulan_2" id="c_triwulan_2">
	  				 TRIWULAN II </td>
	  				<td style="background-color:#41E8A7;font-weight:bold;">
	  				<input   onchange="return hide_triwulan(3)"    class="mcheckbox c_triwulan_3"  '.$check_triwulan_3.'   style="float:left;margin:7px;" type="checkbox" name="c_triwulan_3" id="c_triwulan_3"> TRIWULAN III </td>
	  				<td style="background-color:#49F2B0;font-weight:bold;">
	  				<input   onchange="return hide_triwulan(4);"   class="mcheckbox c_triwulan_4" '.$check_triwulan_4.' style="float:left;margin:7px;" type="checkbox" name="c_triwulan_4" id="c_triwulan_4">
	  			    TRIWULAN IV </td>
 
	   			</tr>
	  		</table>
	  	</div>';
	  	echo $toogle;
	 }	
 ?> 
<div id="konfirmasi" style="display:none"></div>
<div id="tabs">
  <ul>
    <!--<li><a href="#tabs-executiv"><i class="glyphicon glyphicon-inbox"></i> Executiv View</a> </li>-->
    <li><a href="#tabs-renja" onclick="return load_table_renja();"><i class="glyphicon glyphicon-cog"></i> Data Renja</a> </li>
    <li><a href="#tabs-kinerja" onclick="set_mask('tabs_1_target_kinerja');load_data_chart(0)"><i class="glyphicon glyphicon-transfer"></i> Capaian Kinerja dan Keuangan (<i>Form Input</i>)</a> </li>
    <?php  if(!empty($get_kewenangan)) { foreach($get_kewenangan as $get_kewenangan1) { ?> 
	    <li><a href="#<?php echo strtolower(preg_replace('/\s+/', '', $get_kewenangan1->nama_kewenangan)) ;?>" onclick="set_mask('<?php echo trim($get_kewenangan1->nama_kewenangan);?>');load_capaian_lainnya('<?php echo $get_kewenangan1->id;?>','<?php echo strtolower(preg_replace('/\s+/', '', $get_kewenangan1->nama_kewenangan))   ;?>')"><i class="glyphicon glyphicon-transfer"></i> Capaian <?php echo  ($get_kewenangan1->kode);?> (<i>Form View</i>)</a> </li>
    <?php }} ?>
    
    <!--<li><a href="#tabs-keuangan" onclick="set_mask('tabs_1_target_keuangan');load_data_chart('keuangan','0','0')"><i class="glyphicon glyphicon-euro"></i> Capaian Keuangan</a></li>-->
    <!--<li><a href="#tabs-phln" onclick="set_mask('tabs_1_target_phln');load_data_chart('phln','0','0')"><i class="glyphicon glyphicon-th"></i> Capaian PHLN</a></li>-->
    <!--<li><a href="#tabs-dktp" onclick="set_mask('tabs_1_target_dktp');load_data_chart('dktp','0','0')"><i class="glyphicon glyphicon-cog"></i> Capaian DKTP</a></li>-->
    <!--<li><a href="#tabs-lakip" onclick="set_mask('lakip')"><i class="glyphicon glyphicon-repeat"></i> Capaian LAKIP</a></li>-->
    <!--<li><a href="#tabs-renaksi" onclick="set_mask('tabs_1_target_renaksi');load_data_chart('renaksi','0','0')"><i class="glyphicon glyphicon-bookmark"></i> Capaian Renaksi</a></li>-->
    <?php if($this->session->userdata("PUSAT")=="1") { ?>
	    <li>
	    	<a href="#tabs-persetujuan"
		    style="border-radius:0px;color:#000"><i class="glyphicon glyphicon-ok-sign"></i> <b>
			Persetujuan</b></a>
		</li>
    <?php } ?>

   </ul>
 <?php  if(!empty($get_kewenangan)) { foreach($get_kewenangan as $get_kewenangan2) { ?>
   <div id="<?php echo strtolower(preg_replace('/\s+/', '', $get_kewenangan2->nama_kewenangan)) ;?>">
   <?php 
    $data_lainnya['title'] = strtolower(preg_replace('/\s+/', '', $get_kewenangan2->nama_kewenangan));
   $this->load->view('capaian/header_capaian_lainnya',$data_lainnya);?>
    
   </div>
 <?php }} ?>
    
  <!-- <div id="tabs-executiv">
   <a class="pull-right"><i class="glyphicon glyphicon-th"></i> <?php echo strtoupper($judul);?></a> 
   <div id="confirm_status_perbaikan" style="display:none">
	  <form name="form_status_perbaikan"  id="form_status_perbaikan" method="POST">
	  <input class="form-control" id="id" name="id" required="true" size="30" value="<?php echo $id ;?>" type="hidden" />
		<table class="table multimedia table-striped table-hover table-bordered">
			<tr>
				<td colspan="2" ><a style="cursor:pointer;text-decoration:none"  onclick="return load_status_perbaikan()">
				 <i class="glyphicon glyphicon-chevron-right" ></i>  Target Tahun <?php echo $tahun_anggaran;?> ( % )</a> </td>
			</tr>	
			<tr>
				<td style="width:210px"> 
					<input type="text" name="target_capaian" id="target_capaian" 
					value="<?php echo $target_capaian ? $target_capaian : '0'; ?>" class="form-control" style="width:210px;margin:5px;height:36px">
					<input type="hidden" name="id_tahun" id="id_tahun" value="<?php echo $id_tahun_anggaran;?>">
					</td><td>
					<a "#" onclick="return confirm_status_perbaikan()" class="btn btn-success btn-sm pull-left" style="margin:5px;color:#fff"> 
			   		<i class="glyphicon glyphicon-check"></i> Simpan</a>	   		  
				</td>
			</tr>	
		</table>
		</form>
	</div>
	<table style="width:40%;font-size:13px">
				<tr>
				<td style="width:25px">
					<a  class="btn  btn-sm pull-left btn-block" style="border-radius:0px;height:21px;width:21px;margin:5px;color:#fff; background-color:#2F7ED8;border:1px solid #2F7ED8"></a>
				</td>
				<td>	   Sudah Dilaksanakan
				 </td>

				<td style="width:25px">
					<a  class="btn btn-danger btn-sm pull-left btn-block" style="border-radius:0px;height:21px;width:21px;margin:5px;color:#fff;"></a> </td>
				<td>Belum Dilaksanakan
				</td>
			</tr>	
	</table>		
 	<table style="width:100%;height:100%" class="table table-stripped">
		<tr>
			<td style="height:400px;width:500px;text-align:center;vertical-align:middle"  id="">
	 	        <table class="table multimedia table-striped table-hover table-bordered">
			    <thead>
		        <tr>                                             
		            <th style="vertical-align:middle;font-size:12px">
		            <center>CAPAIAN KINERJA TAHUN <?php echo date("Y");?></center></th>
		        </tr>
		    	</thead>
		   		<tbody>
					<tr><th>
					<center><div id="chart_capaian_kinerja"><img src="<?php echo base_url();?>images/loading.gif"></div></center>
					</th></tr>
				</tbody>
				</table>
 			 </td>
			<td  id="">
			 <table class="table multimedia table-striped table-hover table-bordered">
			    <thead>
		        <tr>                                             
		            <th style="vertical-align:middle;font-size:12px">
		            <center>CAPAIAN KEUANGAN TAHUN <?php echo date("Y");?></center></th>
		        </tr>
		    	</thead>
		   		<tbody>
					<tr><th style="vertical-align:middle;font-size:12px">
					<center><div id="chart_capaian_keuangan"><img src="<?php echo base_url();?>images/loading.gif"></div></center>
					</th></tr>
				</tbody>
				</table></td>
		</tr>
		<tr>
			<td id="">
					 <table class="table multimedia table-striped table-hover table-bordered">
					    <thead>
				        <tr>                                             
				            <th style="vertical-align:middle;font-size:12px">
				            <center>CAPAIAN PHLN TAHUN <?php echo date("Y");?></center></th>
				        </tr>
				    	</thead>
				   		<tbody>
							<tr><th style="vertical-align:middle;font-size:12px">
							<center><div id="chart_capaian_phln"><img src="<?php echo base_url();?>images/loading.gif"></div></center>
							</th></tr>
						</tbody>
				</table>
			</td>
			<td id="">
					<table class="table multimedia table-striped table-hover table-bordered">
					    <thead>
				        <tr>                                             
				            <th style="vertical-align:middle;font-size:12px">
				            <center>CAPAIAN DKTP TAHUN <?php echo date("Y");?></center></th>
				        </tr>
				    	</thead>
				   		<tbody>
							<tr><th style="vertical-align:middle;font-size:12px">
							<center><div id="chart_capaian_dktp"><img src="<?php echo base_url();?>images/loading.gif"></div></center>
							</th></tr>
						</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"  style="height:400px;width:400px;text-align:center;vertical-align:middle;text-align:center"> 
				 <center>
					<table class="table multimedia table-striped table-hover table-bordered">
					    <thead>
				        <tr>                                             
				            <th style="vertical-align:middle;font-size:12px">
				            <center>CAPAIAN RENAKSI TAHUN <?php echo date("Y");?></center></th>
				        </tr>
				    	</thead>
				   		<tbody>
							<tr><th style="vertical-align:middle;font-size:12px">
							<center><div id="chart_capaian_renaksi"><img src="<?php echo base_url();?>images/loading.gif"></div></center>
							</th></tr>
						</tbody>
				</table>

				</center> 
			</td>
		 	</tr>
	</table>
  </div> -->
  <div id="tabs-renja">
  		<table id="table_renja" class="table_renja table multimedia table-striped table-hover table-bordered" style="width:100%;">
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
    <tbody id="data_renja_up" style="overflow:scroll"></tbody>
</table>
  </div>
  <div id="tabs-kinerja">
   	<?php cetak_toogle($direktorat);?>
	<div id="tabs_realisasi_capaian_kinerja">
		  <ul>
		    <li><a href="#tabs_1_target_kinerja"    onclick="set_mask('tabs_1_target_kinerja');load_data_chart(0)">
		    <i class="glyphicon glyphicon-fullscreen"></i> Target & Realisasi (View)</a></li>

		    <li><a href="#tabs_3_target_input"    onclick="set_mask('tabs_3_target_input');load_data_chart(1)">
		    <i class="glyphicon glyphicon-retweet"></i> Target    ( <i>Form Input</i>)</a></li>
		    
		    <li><a href="#tabs_2_relisasi_kinerja"  onclick="set_mask('tabs_2_relisasi_kinerja');load_data_chart(2)">
		    <i class="glyphicon glyphicon-ok"></i> Realisasi  ( <i>Form Input</i>)</a></li>		    
		    <li style="display:none"><a href="#tabs_3_komparasi_kinerja" onclick="set_mask('tabs_3_komparasi_kinerja');load_data_chart('0','0','kinerja')">
		    <i class="glyphicon glyphicon-transfer"></i>  Perbandingan Target dan Realisasi</a></li>
		   
		   </ul>
		 <div id="tabs_1_target_kinerja" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">				  
 				<?php  status_capaian($capaian_kinerja_target); ?>
 				<table style="width:15%;margin-bottom:5px;float:right">
 					<tr>
 						<td>
 							<span class="pull-left" style="font-size:12px"> </span>
 						</td>
 						<td>
 							<!--<a class="btn btn-success  pull-right " style="border-radius:0px;color:#fff"
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/1/0"
 							style="color:#fff;margin-left:5px">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a> -->
						</td>
 					</tr>
 				</table> 
 				<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:500px">
 							 <i> <b>* Data Dalam Bentuk Persentase % Untuk capaian Kinerja</b></i></td>
 						</tr>
 				</table>
 			

 				<?php $this->load->view('capaian/header_table_renja_target');?>
				<tbody id="data_capaian_all" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
					</tbody>
				</table> 
	    </div>
	    <div id="tabs_3_target_input" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
 	    	<?php  status_capaian($capaian_kinerja_target); ?>
 				<table style="width:15%;margin-bottom:5px;float:right">
 					<tr>
 						<td>
 							<span class="pull-left" style="font-size:12px"> </span>
 						</td>
 						<td>
 							<!--<a class="btn btn-success  pull-right " style="border-radius:0px;color:#fff"
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/1/0"
 							style="color:#fff;margin-left:5px">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a> -->
						</td>
 					</tr>
 				</table> 
 				<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:500px">
 							 <i> <b>* Data Dalam Bentuk Persentase % Untuk capaian Kinerja</b></i></td>
 						</tr>
 				</table>			
 				<?php $this->load->view('capaian/header_table_renja_taget_2');?>
				<tbody id="data_capaian_target_kinerja" style="overflow:scroll">
				    	<td colspan="52">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
					</tbody>
				</table> 
	    </div>
		<div id="tabs_2_relisasi_kinerja" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_kinerja_realisasi); ?>
				<table style="width:15%;margin-bottom:5px;float:right">
 					<tr>
 						<td></td>
 						<td><a class="btn btn-success  pull-right " style="border-radius:0px;color:#fff"
	 						href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/1/1"
 							style="color:#fff">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							
						</td>
 					</tr>
 				</table>
 				<br><br>
  				<table style="margin-left:1px;overflow: scroll;">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:500px">
 							 <i> <b>* Data Dalam Bentuk Persentase % Untuk Capaian Kinerja </b></i></td>
 						</tr>
 				</table>
			 	<?php $this->load->view('capaian/header_table_renja');?>
				<tbody id="data_capaian_kinerja" style="overflow:scroll">
				    	<td colspan="52">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
					</tbody>
				</table> 
 		</div> 
		<div id="tabs_3_komparasi_kinerja"  style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
			<table style="width:15%;margin-bottom:5px;float:right">
 					<tr>
 						<td><span class="pull-left" style="font-size:12px"> <i> <b>* Data Dalam Bentuk Persentase % Untuk Capaian Kinerja</b></i> </span></td>
 						<td><a class="btn btn-success pull-right " style="border-radius:0px;color:#fff"
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob_komparasi/<?php echo $id;?>/capaian_kinerja"
 							style="color:#fff">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
						</td>
 					</tr>
 				</table>
			<div id="div_komparasi_capaian_kinerja">
				<center><img src="<?php echo base_url();?>images/loading.gif"></center>
 			</div>
		</div>
	</div>

  </div>
<!--  <div id="tabs-keuangan">
  	<?php cetak_toogle($direktorat);?>
 	<div id="tabs_realisasi_capaian_keuangan">
		<ul>
		    <li><a href="#tabs_1_target_keuangan"    onclick="set_mask('tabs_1_target_keuangan');"><i class="glyphicon glyphicon-fullscreen"></i> Target Keuangan</a></li>
		    <li><a href="#tabs_2_relisasi_keuangan"  onclick="set_mask('tabs_2_relisasi_keuangan');load_data_chart('0','keuangan','0')"><i class="glyphicon glyphicon-ok"></i>  Realisasi Keuangan</a></li>
		    <li><a href="#tabs_3_komparasi_keuangan" onclick="set_mask('tabs_3_komparasi_keuangan');load_data_chart('0','0','keuangan')"><i class="glyphicon glyphicon-transfer"></i>  Perbandingan Target dan Realisasi</a></li>
		  </ul>
		<div id="tabs_1_target_keuangan" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
					<?php  status_capaian($capaian_keuangan_target); ?>
					<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right " style="border-radius:0px;color:#fff"
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/2/0"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>

					<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_target_keuangan" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table> 
	    </div>
		<div id="tabs_2_relisasi_keuangan" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_keuangan_realisasi); ?>
				<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>	 						 
	 						<td>
	 							
	 						</td>
	 						<td><a class="btn btn-success pull-right export_to_excel" name="select_komparasi_keuangan" id="1" 
	 						style="border-radius:0px;color:#fff" 
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/2/1"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
 					<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:300px">
 							<i style="float:left;border-radius:0px" class="btn btn-primary btn-sm glyphicon glyphicon-wrench"></i>
	 							<select onchange="return load_capaian_realisasi('keuangan','2','2')" 
	 							class="form-control btn btn-primary btn-sm input-sm"
	 							id="select_komparasi_keuangan"
	 							style="border-radius:0px; font-size:12px;padding:2px;width:88%">
	 								<option value="0" ><b>Bandingkan Dengan Data Renja</b></option>	
	 								<option value="1" selected="selected"><b>Bandingkan Dengan Data Target</b></option>	
	 							</select>
	 						</td>
 						</tr>
 				</table> 			
	 								
				<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_keuangan" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table> 
		</div>
		<div id="tabs_3_komparasi_keuangan" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
			<a class="btn btn-success btn-sm pull-right " 
 				href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob_komparasi/<?php echo $id;?>/capaian_keuangan"
 				style="color:#fff">
			<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
			<div id="div_komparasi_capaian_keuangan">
				<center><img src="<?php echo base_url();?>images/loading.gif"></center>
 			</div>
		</div>
	</div>
</div> -->
<!--
  <div id="tabs-phln" >
  	<?php cetak_toogle($direktorat);?>
 	  <div id="tabs_realisasi_capaian_phln" >
			<ul>
			    <li><a href="#tabs_1_target_phln"    onclick="set_mask('tabs_1_target_phln');"><i class="glyphicon glyphicon-fullscreen"></i> Target PHLN</a></li>
			    <li><a href="#tabs_2_relisasi_phln"  onclick="set_mask('tabs_2_relisasi_phln');load_data_chart('0','phln','0')"><i class="glyphicon glyphicon-ok"></i>  Realisasi PHLN</a></li>
			    <li><a href="#tabs_3_komparasi_phln" onclick="set_mask('tabs_2_relisasi_phln');load_data_chart('0','0','phln')"><i class="glyphicon glyphicon-transfer"></i>  Perbandingan Target dan Realisasi</a></li>
			  </ul>
			<div id="tabs_1_target_phln" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_phln_target); ?>

				<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right " style="border-radius:0px;color:#fff"
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/3/0"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
				<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_target_phln" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table> 
		    </div>
			<div id="tabs_2_relisasi_phln" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
					<?php  status_capaian($capaian_phln_realisasi); ?>					
					<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a  class="btn btn-success pull-right export_to_excel" name="select_komparasi_phln" id="1" 
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/3/1"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
 					<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:300px">
 							<i style="float:left;border-radius:0px" class="btn btn-primary btn-sm glyphicon glyphicon-wrench"></i>
	 							<select onchange="return load_capaian_realisasi('phln','3','3')" 
	 							class="form-control btn btn-primary btn-sm input-sm"
	 							id="select_komparasi_phln"
	 							style="border-radius:0px; font-size:12px;padding:2px;width:88%">
	 								<option value="0"  ><b>Bandingkan Dengan Data Renja</b></option>	
	 								<option value="1" selected="selected"><b>Bandingkan Dengan Data Target</b></option>	
	 							</select>
	 						</td>
 						</tr>
 				</table> 	
					<?php $this->load->view('capaian/header_table_renja');?>
	    				<tbody id="data_capaian_phln" style="overflow:scroll">
	    					<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
	    				</tbody>
					</table> 
			</div>
			<div id="tabs_3_komparasi_phln" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
			<a class="btn btn-success btn-sm pull-right " 
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob_komparasi/<?php echo $id;?>/capaian_phln"
 							style="color:#fff">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
			<div id="div_komparasi_capaian_phln">
				<center><img src="<?php echo base_url();?>images/loading.gif"></center>
 			</div>
		</div>
		</div>    
  </div>-->
 <!-- <div id="tabs-dktp">
  	<?php cetak_toogle($direktorat);?>
   		<div id="tabs_realisasi_capaian_dktp">
			<ul>
			    <li><a href="#tabs_1_target_dktp" 	  onclick="set_mask('tabs_1_target_dktp');"><i class="glyphicon glyphicon-fullscreen"></i> Target DKTP</a></li>
			    <li><a href="#tabs_2_relisasi_dktp"   onclick="set_mask('tabs_2_relisasi_dktp');load_data_chart('0','dktp','0')"><i class="glyphicon glyphicon-ok"></i>  Realisasi  DKTP</a></li>
			    <li><a href="#tabs_3_komparasi_dktp"  onclick="set_mask('tabs_3_komparasi_dktp');load_data_chart('0','0','dktp')"><i class="glyphicon glyphicon-transfer"></i>  Perbandingan Target dan Realisasi</a></li>
			  </ul>
			<div id="tabs_1_target_dktp" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_dktp_target); ?>
				<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right " style="border-radius:0px;color:#fff"
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/4/0"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
				<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_target_dktp" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table> 
		    </div>
			<div id="tabs_2_relisasi_dktp" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
					<?php  status_capaian($capaian_dktp_realisasi); ?>
					<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right export_to_excel" name="select_komparasi_dktp" id="1" 
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/4/1"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
 					<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:300px">
 							<i style="float:left;border-radius:0px" class="btn btn-primary btn-sm glyphicon glyphicon-wrench"></i>
	 							<select onchange="return load_capaian_realisasi('dktp','4','4')" 
	 							class="form-control btn btn-primary btn-sm input-sm"
	 							id="select_komparasi_dktp"
	 							style="border-radius:0px; font-size:12px;padding:2px;width:88%">
	 								<option value="0"  ><b>Bandingkan Dengan Data Renja</b></option>	
	 								<option value="1" selected="selected"><b>Bandingkan Dengan Data Target</b></option>	
	 							</select>
	 						</td>
 						</tr>
 				</table> 			
					 <?php $this->load->view('capaian/header_table_renja');?>
				   		  <tbody id="data_capaian_dktp" style="overflow:scroll">
				   		  	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				   		  </tbody>
					</table> 
			</div>
		<div id="tabs_3_komparasi_dktp" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<a class="btn btn-success btn-sm pull-right " 
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob_komparasi/<?php echo $id;?>/capaian_dktp"
 							style="color:#fff">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
				<div id="div_komparasi_capaian_dktp">
					<center><img src="<?php echo base_url();?>images/loading.gif"></center>
 				</div>
			</div>
		</div>  	
  </div>-->
 
<!--  <div id="tabs-renaksi">
  	<?php cetak_toogle($direktorat);?>
   		<div id="tabs_realisasi_capaian_renaksi">
			<ul>
			    <li><a href="#tabs_1_target_renaksi" 	onclick="set_mask('tabs_1_target_renaksi');"><i class="glyphicon glyphicon-fullscreen"></i> Target Renaksi</a></li>
			    <li><a href="#tabs_2_relisasi_renaksi"  onclick="set_mask('tabs_2_relisasi_renaksi');load_data_chart('0','renaksi','0')"><i class="glyphicon glyphicon-ok"></i>  Realisasi Renaksi</a></li>
			    <li><a href="#tabs_3_komparasi_renaksi" onclick="set_mask('tabs_3_komparasi_renaksi');load_data_chart('0','0','renaksi')"><i class="glyphicon glyphicon-transfer"></i>  Perbandingan Target dan Realisasi</a></li>
			  </ul>
			<div id="tabs_1_target_renaksi" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_renaksi_target); ?>
				<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right " style="border-radius:0px;color:#fff"
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/6/0"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
				<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_target_renaksi" style="overflow:scroll">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table> 
		    </div>
			<div id="tabs_2_relisasi_renaksi" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<?php  status_capaian($capaian_renaksi_realisasi); ?>
				<table style="width:15%;margin-bottom:5px;float:right">
	 					<tr>
	 						<td></td>
	 						<td><a class="btn btn-success pull-right export_to_excel" name="select_komparasi_renaksi" id="1" 
	 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob/<?php echo $id;?>/6/0"
	 							style="color:#fff">
								<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							</td>
	 					</tr>
 					</table>
 					<table style="margin-left:1px">
 						<tr>
 							<td class="btn btn-primary btn-sm" style="border-radius:0px;padding:0px;text-align:left;width:300px">
 							<i style="float:left;border-radius:0px" class="btn btn-primary btn-sm glyphicon glyphicon-wrench"></i>
	 							<select onchange="return load_capaian_realisasi('renaksi','6','6')" 
	 							class="form-control btn btn-primary btn-sm input-sm"
	 							id="select_komparasi_renaksi"
	 							style="border-radius:0px; font-size:12px;padding:2px;width:88%">
	 								<option value="0"  ><b>Bandingkan Dengan Data Renja</b></option>	
	 								<option value="1" selected="selected"><b>Bandingkan Dengan Data Target</b></option>	
	 							</select>
	 						</td>
 						</tr>
 				</table> 		
				<?php $this->load->view('capaian/header_table_renja');?>
				    <tbody id="data_capaian_renaksi" style="overflow:scroll;">
				    	<td colspan="29">
					    	<center><img src="<?php echo base_url();?>images/loading.gif"></center>
				    	</td>
				    </tbody>
				</table>
			</div>
			<div id="tabs_3_komparasi_renaksi" style="background-image: url(<?php echo base_url();?>/images/mask.png)  ; width: 100%;background-repeat: no-repeat;">
				<a class="btn btn-success btn-sm pull-right " 
 							href="<?php echo base_url();?>capaian/export_excel_atu_atu_sob_komparasi/<?php echo $id;?>/capaian_renaksi"
 							style="color:#fff;border-radius:0px">
							<img src="<?php echo base_url();?>images/iconexcel.png"> Export To Excel </a>
							<div id="div_komparasi_capaian_renaksi">
								<center><img src="<?php echo base_url();?>images/loading.gif"></center>
			 				</div>
					</div>
				</div>  
			</div>-->
		<?php if($this->session->userdata("PUSAT")=="1") { ?>	
			<div id="tabs-persetujuan">
				<form id="form_persetujuan_capaian" name="form_persetujuan_capaian" method="post">
				<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
		 		<div class="panel panel-primary">
				   <div class="panel-heading">Data Persetujuan
				   </div>
					  <div class="well">
						<table class="table">
						 	<tr>
						 		<td style="width:21px;vertical-align:middle;padding:10px"> <i style="font-size:40px;color:#5F8FDC" class="glyphicon glyphicon-info-sign"></i></td>
						 		<td> <span> Persetujuan Capaian Dilakukan Oleh <i class="glyphicon glyphicon-user"></i> <b><?php echo strtoupper($this->session->userdata('NAMA'));?></b>, pada tanggal <b><?php echo strtoupper(date("d-F-Y"));?></b>,  Persetujuan dilakukan dengan cara memilih memilih salah satu maupun semua opsi  yang disediakan </span></td>
						 	</tr>
						</table>
						<code class="btn-block" style="padding:10px"><i class="glyphicon glyphicon-ok-sign" style="margin-left:18px"></i> Komponen Yang Disetujui</code>  
 						<table style="margin-left:21px" class="table">
							 <tr>
							 	<td colspan="2"></td>
							 </tr>
							 	<tr>
								 	<td style="width:21px;vertical-align:top"></td>
								 	<td><label><i class="glyphicon glyphicon-stats"></i> CAPAIAN KINERJA</label><br>
								 	<input type="checkbox" <?php echo $capaian_kinerja_target=="1" ? "checked='checked'" : "";?>  value="1" id="capaian_kinerja_target" name="capaian_kinerja_target">  Target  <br>
								 	<input type="checkbox" <?php echo $capaian_kinerja_realisasi=="1" ? "checked='checked'" : "";?> value="1" id="capaian_kinerja_realisasi" name="capaian_kinerja_realisasi">   Realisasi  <br>
								 	<br></td>							 	 
								 	<td style="width:21px;vertical-align:top"></td>
								 	<td><label><i class="glyphicon glyphicon-stats"></i> CAPAIAN KEUANGAN</label>
								 	<br>
								 	<input type="checkbox" <?php echo $capaian_keuangan_target=="1" ? "checked='checked'" : "";?> value="1" id="capaian_keuangan_target" name="capaian_keuangan_target">  Target  <br>
								 	<input type="checkbox" <?php echo $capaian_keuangan_realisasi=="1" ? "checked='checked'" : "";?> value="1" id="capaian_keuangan_realisasi" name="capaian_keuangan_realisasi">   Realisasi  <br>
								 	<br></td>
							  
								 	<!--<td style="width:21px;vertical-align:top"></td>
								 	<td><label><i class="glyphicon glyphicon-stats"></i> CAPAIAN PHLN</label>
								 	<br>
								 	<input type="checkbox" <?php echo $capaian_phln_target=="1" ? "checked='checked'" : "";?> value="1" id="capaian_phln_target" name="capaian_phln_target">  Target  <br>
								 	<input type="checkbox" <?php echo $capaian_phln_realisasi=="1" ? "checked='checked'" : "";?> value="1" id="capaian_phln_realisasi" name="capaian_phln_realisasi">   Realisasi  <br>
								 	<br>
								 	</td>
							 	 
								 	<td style="width:21px;vertical-align:top"></td>
								 	<td><label><i class="glyphicon glyphicon-stats"></i> CAPAIAN DKTP</label>
								 	<br>
								 	<input type="checkbox" <?php echo $capaian_dktp_target=="1" ? "checked='checked'" : "";?> value="1" id="capaian_dktp_target" name="capaian_dktp_target">  Target  <br>
								 	<input type="checkbox" <?php echo $capaian_dktp_realisasi=="1" ? "checked='checked'" : "";?> value="1" id="capaian_dktp_realisasi" name="capaian_dktp_realisasi">   Realisasi  <br>
								 	<br></td>
							 	 
								 	<td style="width:21px;vertical-align:top"></td>
								 	<td><label><i class="glyphicon glyphicon-stats"></i> CAPAIAN RENAKSI</label>
								 	<br>
								 	<input type="checkbox" <?php echo $capaian_renaksi_target=="1" ? "checked='checked'" : "";?>  value="1"  id="capaian_renaksi_target" name="capaian_renaksi_target">  Target  <br>
								 	<input type="checkbox" <?php echo $capaian_renaksi_realisasi=="1" ? "checked='checked'" : "";?>  value="1" id="capaian_renaksi_realisasi" name="capaian_renaksi_realisasi">   Realisasi  <br>
								 	<br></td> -->
							 	</tr>
							 </table>
							 
							 <hr>
							 <a class="btn btn-success btn-sm" onclick="return form_simpan_persetujuan()" style="color:#fff"><i class="glyphicon glyphicon-ok-sign"></i> Simpan</a>
							 <a class="btn btn-danger btn-sm" href="<?php echo base_url();?>capaian" style="color:#fff"><i class="glyphicon glyphicon-remove-sign"></i> Kembali</a>
					 </div>
				 </div>
				 </form>
			</div>	
		<?php } ?>		
		</div>

 