<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/shortcut.js"></script>
   
    <script type="text/javascript">
 
	var lcstatus = 'tambah';
     var dimensi = '';
     var sdimensi ='';
     var kdpbidang = '';
     var kdspbidang = '';
     var kdsspbidang='';
     var kdnwcita='';
    shortcut.add("ctrl+m", function() {
        detsimpan();
    });
    
    $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
                height: 150,
                width: 1100,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal1" ).dialog({
                height: 200,
                width: 1100,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal2" ).dialog({
                height: 200,
                width: 900,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal3" ).dialog({
                height: 500,
                width: 1220,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal4" ).dialog({
                height: 250,
                width: 900,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal5" ).dialog({
                height: 250,
                width: 900,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal6" ).dialog({
                height: 330,
                width: 1200,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal7" ).dialog({
                height: 150,
                width: 320,
                modal: true,
                autoOpen:false                
            });
            $( "#dialog-modal8" ).dialog({
                height: 170,
                width: 320,
                modal: true,
                autoOpen:false                
            });
            get_skpd();
        });    
    
    $(function(){
        });
    $(function(){
             
	       $('#dg1').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_outcome/',
                 idField      : 'id',
                 toolbar      : "#toolbar1",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
					{field:'nosasprog',
					 title:'<span style="color:blue"><b>urut</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'nmsasprog',
					 title:'<span style="color:blue"><b>Uraian Sasaran Program (outcome)</b></span>',
					 width:45
					},
                    {field:'nosasstra',
					 title:'',
					 width:5,
					 align:'left'	
					},
					{field:'nmsasstra',
					 title:'<span style="color:blue"><b>Dukungan Sasaran Strategis KL</b></span>',
					 width:45
					}
                  
				]]
			});
            
            $('#dg2').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_indikatorprog/',
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'noinsasprog',
					 title:'<span style="color:blue"><b>Nomor</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'uraian',
					 title:'<span style="color:blue"><b>Uraian Indikator Kinerja Program (IKP)</b></span>',
					 width:55
					},//
//                    {field:'vol1',
//					 title:'2015',
//					 width:5
//					},
                    {field:'vol2',
					 title:'<span style="color:blue"><b>Target 2016</b></span>',
					 width:10
					},
                    {field:'vol3',
					 title:'<span style="color:blue"><b>Target 2017</b></span>',
					 width:10
					},
                    {field:'vol4',
					 title:'<span style="color:blue"><b>Target 2018</b></span>',
					 width:10
					},
                    {field:'vol5',
					 title:'<span style="color:blue"><b>Target 2019</b></span>',
					 width:10
					}
                  
				]]
			});
            
            $('#dg3').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_output/',
                 idField      : 'id',
                 toolbar      : "#toolbar3",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:2,
                     hidden:true
					},
					{field:'kdoutput',
					 title:'<span style="color:blue"><b>Kode</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'nmoutput',
					 title:'<span style="color:blue"><b>Uraian Sasaran Kegiatan (Output)</b></span>',
					 width:40
					},
                    {field:'nosasprog',
					 title:'<span style="color:blue"><b>Sasaran Program </b></span>',
					 width:5,
                     align:'left'
					},
                    {field:'noissustra',
					 title:'<span style="color:blue"><b>Dimensi/Bidang </b></span>',
					 width:5,
                     align:'center'
					},
                    {field:'prioritas',
					 title:'<span style="color:blue"><b>Prioritas</b></span>',
					 width:5,
                     align:'center'
					},
                    {field:'vol1',
					 title:'<span style="color:blue"><b>Volume</b></span>',
					 width:10,
                     align:'center'
					},
                    {field:'harga1',
					 title:'<span style="color:blue"><b>Alokasi</b></span>',
					 width:10,
                     align:'right'
					}
                    ,
                    {field:'dppp',
					 title:'<span style="color:blue"><b>PPP</b></span>',
					 width:5,
                     align:'right'
					}
                    ,
                    {field:'darg',
					 title:'<span style="color:blue"><b>ARG</b></span>',
					 width:5,
                     align:'right'
					}
                    ,
                    {field:'dksst',
					 title:'<span style="color:blue"><b>KSST</b></span>',
					 width:5,
                     align:'right'
					}
                    ,
                    {field:'dmpi',
					 title:'<span style="color:blue"><b>MPI</b></span>',
					 width:5,
                     align:'right'
					}
                    
				]]
			});
            
            $('#dg4').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_indikatoroutput/',
                 idField      : 'id',
                 toolbar      : "#toolbar4",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'nomor',
					 title:'Nomor',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'Uraian Indikator Kinerja Kegiatan (IKK)',
					 width:50
					},
                    {field:'vol1',
					 title:' Target 2016',
					 width:10
					},
                    {field:'vol2',
					 title:'Target 2017',
					 width:10
					},
                    {field:'vol3',
					 title:'Target 2018',
					 width:10
					},
                    {field:'vol4',
					 title:'Target 2019',
					 width:10
					},
                    {field:'satuan',
					 title:'Satuan',
					 width:5
					}
                  
				]]
			});
            
            $('#dg5').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_komponen/',
                 idField      : 'id',
                 toolbar      : "#toolbar5",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'kdkmpnen',
					 title:'Nomor',
					 width:5,
					 align:'left'	
					},
					{field:'urkmpnen',
					 title:'Uraian Komponen',
					 width:55
					},
                    {field:'kdbiaya',
					 title:'Jenis',
					 width:5
					}
				]]
			});
            
            $('#dg6').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_lokasi/',
                 idField      : 'id', 
                 toolbar      : "#toolbar6",            
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                
					{field:'kdprop',
					 title:'<b><span style="color:#3366FF">Prov</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'kdkab',
					 title:'<b><span style="color:#3366FF">Kab</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'volume',
					 title:'<b><span style="color:#3366FF">Volume</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'rupiah',
					 title:'<b><span style="color:#3366FF">Rupiah</span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pend',
					 title:'<b><span style="color:#3366FF">Pendamping</span></b>',
					 width:5,
					 align:'right'	
					},
                    {field:'pnbp',
					 title:'<b><span style="color:#3366FF">PNBP</span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'blu',
					 title:'<b><span style="color:#3366FF">BLU </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pln',
					 title:'<b><span style="color:#3366FF">PLN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pdn',
					 title:'<b><span style="color:#3366FF">PDN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'hibah',
					 title:'<b><span style="color:#3366FF">Hibah </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'sbsn',
					 title:'<b><span style="color:#3366FF">SBSN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'jumlah',
					 title:'<b><span style="color:#3366FF">Jumlah </span></b>',
					 width:10,
					 align:'right'	
					}
                    
                  
				]]
			});
            
            $('#prio').combogrid({  
            panelWidth : 700,  
            idField    : 'kdprio',  
            textField  : 'kdprio',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_prio',  
            columns    : [[  
                {field:'kdprio',title:'Kode',width:50},
                {field:'nmprio',title:'Prioritas',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                nmprio = rowData.nmprio;
                $("#nmprio").attr("value",rowData.nmprio);
                
            }
            }); 
            
            $('#jns').combogrid({  
            panelWidth : 50,  
            idField    : 'jns',  
            textField  : 'jns',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/jns',  
            columns    : [[  
                {field:'jns',title:'jns',width:50}    
            ]],
            onSelect:function(rowIndex,rowData){
                jns = rowData.jns;
                
            }
            });
            
            $('#prop').combogrid({  
            panelWidth : 200,  
            idField    : 'kdprop',  
            textField  : 'kdprop',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/prop',  
            columns    : [[  
                {field:'kdprop',title:'Kode',width:50},
                {field:'nmprop',title:'Provinsi',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                propinsi = rowData.kdprop;
                $("#nmprop").attr("value",rowData.nmprop);
                get_kab();
            }
            });
            //$.ajax({url:'<?php echo base_url(); ?>index.php/master/ambil_prop_lst',
//            type: "POST",
//			 dataType:'json',                               
//            success:function(data){
//                dataprop = eval(data);
//				
//                $("#prop").autocomplete({
//                
//				source:function(request,response){
//                    var propinsi = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
//                   
//				    response($.grep(dataprop, function(value) {
//                        return propinsi.test(value.value) || propinsi.test(value.label);                
//                    }));
//                
//				}, 
//                minLength:0,
//                autoFocus:true,
//				
//                select:function(event,ui){                    
//                                    
//				  var ckec = ui.item;       
//				  $("#nmprop").attr("value",ckec);                              
//				  get_kab();                                     
//   
//                },
//
//			   change: function(event,ui){
//			  		 label = ui.item['label'];
//						$("#nmprop").attr("value",label);  
//						get_kab();
//
//			   }		
//
//                }).on("focus", function () {
//                $(this).autocomplete("search", '');});                
//            }
//
//
//    });

 
            
            $('#kdkewe').combogrid({  
            panelWidth : 200,  
            idField    : 'kddekon',  
            textField  : 'kddekon',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/dekon',  
            columns    : [[  
                {field:'kddekon',title:'Kode',width:50},
                {field:'nmdekon',title:'Kewenangan',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                kewe = rowData.kddekon;
                $("#nmkewe").attr("value",rowData.nmdekon);
            }
            });
            
            $('#issu').combogrid({  
            panelWidth : 500,  
            idField    : 'kdissue',  
            textField  : 'kdissue',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/issue',  
            columns    : [[  
                {field:'kdissue',title:'Kode',width:50},
                {field:'nmissue',title:'Issue',width:450}    
            ]],
            onSelect:function(rowIndex,rowData){
                issu = rowData.kdissue;
                $("#nmissu").attr("value",rowData.nmissue);
            }
            });
            
            $('#sumber').combogrid({  
            panelWidth : 200,  
            idField    : 'kdsumber',  
            textField  : 'nmsumber',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/sumber',  
            columns    : [[  
                {field:'kdsumber',title:'Kode',width:50},
                {field:'nmsumber',title:'Sumber',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                sumber = rowData.kdsumber;
                get_npphln();
            }
            });
            
            $('#kdsu').combogrid({  
            panelWidth : 200,  
            idField    : 'kdsumber',  
            textField  : 'nmsumber',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/sumber',  
            columns    : [[  
                {field:'kdsumber',title:'Kode',width:50},
                {field:'nmsumber',title:'Sumber',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                sumber = rowData.kdsumber;
                get_npphln();
            }
            });
            
            $('#npphln').combogrid({  
            panelWidth : 200,  
            idField    : 'kdnpphln',  
            textField  : 'kdnpphln',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/npphln/'+sumber,  
            columns    : [[  
                {field:'kdnpphln',title:'Kode ',width:70},  
                {field:'nmnpphln',title:'Nama ',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                jnpphln = rowData.kdnpphln;
            }
            });
            
            $('#jeni').combogrid({  
            panelWidth : 200,  
            idField    : 'kdjenisbiaya',  
            textField  : 'kdjenisbiaya',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/jenis_biaya',  
            columns    : [[  
                {field:'kdjenisbiaya',title:'Kode',width:50},
                {field:'nmjenisbiaya',title:'Jenis',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                jeni = rowData.kdjenisbiaya;
            }
            }); 
            
             
            
            $('#tglm').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
            });
            
            $('#tglt').datebox({  
            required:true,
            formatter :function(date){
            	var y = date.getFullYear();
            	var m = date.getMonth()+1;
            	var d = date.getDate();
            	return y+'-'+m+'-'+d;
            }
            }); 
            
            $('#dimensi').combogrid({  
            panelWidth : 900,  
            idField    : 'kdsdimensi',  
            textField  : 'kdsdimensi',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_dimensi',  
            columns    : [[  
                {field:'kddimensi',title:'Kode1',width:50},
                {field:'nmdimensi',title:'Dimensi1',width:400},
                {field:'kdsdimensi',title:'Kode2',width:50},
                {field:'nmsdimensi',title:'Dimensi2',width:400}    
            ]],
            onSelect:function(rowIndex,rowData){
                dimensi = rowData.kddimensi
                sdimensi= rowData.kdsdimensi;
                $("#nmdimensi").attr("value",rowData.nmsdimensi);
            }
            });
            
            $('#bidang1').combogrid({  
            panelWidth : 1000,  
            idField    : 'kdspbidang',  
            textField  : 'kdspbidang',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_bidang1',  
            columns    : [[  
                {field:'kdpbidang',title:'Kode1',width:50},
                {field:'nmpbidang',title:'Bidang',width:450},
                {field:'kdspbidang',title:'Kode2',width:50},
                {field:'nmspbidang',title:'Prioritas Bidang',width:450}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdspbdg = rowData.kdspbidang;
                $("#nmbidang1").attr("value",rowData.nmspbidang);
                get_bidang();
            }
            }); 
            
            $('#nawa').combogrid({  
            panelWidth : 700,  
            idField    : 'kdnwcita',  
            textField  : 'kdnwcita',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_nawacita',  
            columns    : [[  
                {field:'kdnwcita',title:'Kode',width:50},
                {field:'nmnwcita',title:'Uraian',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdnwcita = rowData.kdnwcita;
                $("#nmnawa").attr("value",rowData.nmnwcita);
            }
            });  
    });

    $(function(){
            $('#nomorkl').combogrid({  
            panelWidth : 700,  
            idField    : 'nomor',  
            textField  : 'nomor',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_sasaran_kl',  
            columns    : [[  
                {field:'nomor',title:'nomor',width:50},
                {field:'nama',title:'Uraian',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdsasstra = rowData.nomor;
                $("#uraiankl").attr("value",rowData.nama);
                
            }
            }); 
    });
    function get_bidang(){
        $('#bidang').combogrid({  
            panelWidth : 700,  
            idField    : 'kdsspbidang',  
            textField  : 'kdsspbidang',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/select_bidang/'+kdspbdg,  
            columns    : [[  
                {field:'kdpbidang',title:'Kode1',width:50},
                {field:'kdspbidang',title:'Kode2',width:50},
                {field:'kdsspbidang',title:'Kode3',width:50},
                {field:'nmsspbidang',title:'Prioritas Bidang',width:550}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdpbidang = rowData.kdpbidang;
                kdspbidang = rowData.kdspbidang;
                kdsspbidang = rowData.kdsspbidang;
                $("#nmbidang").attr("value",rowData.nmsspbidang);
                
            }
            }); 
    }
    function get_kab(){
	  	    $(function(){
            $('#kab').combogrid({  
            panelWidth : 200,  
            idField    : 'kdkab',  
            textField  : 'kdkab',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/kab/'+propinsi,  
            columns    : [[  
                {field:'kdkab',title:'Kode ',width:70},  
                {field:'nmkab',title:'Nama ',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kab = rowData.kdkab;
                $("#nmkab").attr("value",rowData.nmkab);
            }
            }); 
            });
		}
    function get_sumber(){
	  	    $(function(){
            $('#sumber').combogrid({  
            panelWidth : 200,  
            idField    : 'kdsumber',  
            textField  : 'nmsumber',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/sumber',  
            columns    : [[  
                {field:'kdsumber',title:'Kode',width:50},
                {field:'nmsumber',title:'Sumber',width:650}    
            ]],
            onSelect:function(rowIndex,rowData){
                sumber = rowData.kdsumber;
                get_npphln();
            }
            });
            });
		}
    function get_npphln(){
	  	    $(function(){
            $('#npphln').combogrid({  
            panelWidth : 200,  
            idField    : 'kdnpphln',  
            textField  : 'kdnpphln',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/npphln/'+sumber,  
            columns    : [[  
                {field:'kdnpphln',title:'Kode ',width:70},  
                {field:'nmnpphln',title:'Nama ',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                jnpphln = rowData.kdnpphln;
            }
            }); 
            });
		}
    
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/master/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd.toUpperCase());
        								kdskpd = data.kd_skpd;
                                        sta    = data.statu;
                                        get_unit();
                                        
        							  }                                     
        	});
        }
    
    function get_unit()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/master/config_unit',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#kdunit").attr("value",data.kdunit);
        								$("#nmunit").attr("value",data.nmunit.toUpperCase());
        								unit = data.kdunit;
                                        validate_prog();
                                        
                                        
        							  }                                     
        	});
        }
        
    function validate_prog(){
	  	    $(function(){
            $('#kdprog').combogrid({  
            panelWidth : 700,  
            idField    : 'kdprogram',  
            textField  : 'kdprogram',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/pprog/'+kdskpd+'/'+unit,  
            columns    : [[  
                {field:'kdprogram',title:'Kode Program',width:70},  
                {field:'nmprogram',title:'Nama Program',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                program = rowData.kdprogram;
                $("#nmprog").attr("value",rowData.nmprogram);
                grid_outcome();
                validate_giat();
                sasaran_prog();
                
            }
            }); 
            });
		}    
    
    function validate_giat(){
	  	    $(function(){
            $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kdgiat',  
            textField  : 'kdgiat',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/pgiat/'+kdskpd+'/'+program+'/'+unit,  
            columns    : [[  
                {field:'kdgiat',title:'Kode Giat',width:70},  
                {field:'nmgiat',title:'Nama Giat',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kegiatan = rowData.kdgiat;
                $("#nmgiat").attr("value",rowData.nmgiat);
                $("#kdoutput").attr("value",'');
                grid_output();
            }
            }); 
            });
		} 
    function sasaran_prog(){
        
	  	    $(function(){
            $('#sprog').combogrid({  
            panelWidth : 700,  
            idField    : 'nomor',  
            textField  : 'nomor',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/ambil_sasaranprog/'+kdskpd+'/'+program,  
            columns    : [[  
                {field:'nomor',title:'Kode Program',width:70},  
                {field:'nama',title:'Nama Program',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                sprog = rowData.nomor;
                $("#nmspog").attr("value",rowData.nama);
            }
            }); 
            });
		}  
    function grid_outcome(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value; 
	       $('#dg1').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_outcome/'+mskpd+'/'+munit+'/'+program,
                 idField      : 'id',
                 toolbar      : "#toolbar1",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
					{field:'nosasprog',
					 title:'<span style="color:blue"><b>urut</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'nmsasprog',
					 title:'<span style="color:blue"><b>Uraian Sasaran Program (outcome)</b></span>',
					 width:45
					},
                    {field:'nosasstra',
					 title:'',
					 width:5,
					 align:'left'	
					},
					{field:'nmsasstra',
					 title:'<span style="color:blue"><b>Dukungan Sasaran Strategis KL</b></span>',
					 width:45
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              kdsasprog  = rowData.nosasprog;
                              nmsasprog  = rowData.nmsasprog;
                              kdsasstra  = rowData.nosasstra;
                              
                              $("#nomor").attr("value",kdsasprog);
                              $("#uraian").attr("value",nmsasprog);
                              $("#nomorkl").combogrid("setValue",kdsasstra);
                              lcstatus = 'edit';
                              grid_ikp(); 
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal1").dialog('open');
        }
			});
    } 
    
    function grid_ikp(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value; 
	       $('#dg2').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_indikatorprog/'+mskpd+'/'+munit+'/'+program+'/'+kdsasprog,
                 idField      : 'id',
                 toolbar      : "#toolbar",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'noinsasprog',
					 title:'<span style="color:blue"><b>Nomor</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'uraian',
					 title:'<span style="color:blue"><b>Uraian Indikator Kinerja Program (IKP)</b></span>',
					 width:55
					},
                    //{field:'vol1',
//					 title:'2015',
//					 width:5
//					},
                    {field:'vol2',
					 title:'<span style="color:blue"><b>Target 2016</b></span>',
					 width:10
					},
                    {field:'vol3',
					 title:'<span style="color:blue"><b>Target 2017</b></span>',
					 width:10
					},
                    {field:'vol4',
					 title:'<span style="color:blue"><b>Target 2018</b></span>',
					 width:10
					},
                    {field:'vol5',
					 title:'<span style="color:blue"><b>Target 2019</b></span>',
					 width:10
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              noinsas  = rowData.noinsasprog;
                              nminsas  = rowData.uraian;
                              vol1 = rowData.vol1;
                              vol2 = rowData.vol2;
                              vol3 = rowData.vol3;
                              vol4 = rowData.vol4;
                              vol5 = rowData.vol5;
                              $("#nomerikp").attr("value",noinsas);
                              $("#namaikp").attr("value",nminsas);
                              $("#vol1").attr("value",vol1);
                              $("#vol2").attr("value",vol2);
                              $("#vol3").attr("value",vol3);
                              $("#vol4").attr("value",vol4);
                              $("#vol5").attr("value",vol5);
                              lcstatus = 'edit'; 
                              
		          },
                   onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal2").dialog('open');
        }
			});
    } 
    
    function grid_output(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
           //alert('<?php echo base_url(); ?>/index.php/rka/select_output/'+mskpd+'/'+mprog+'/'+mgiat);
	       $('#dg3').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_output/'+mskpd+'/'+munit+'/'+program+'/'+mgiat,
                 idField      : 'id',
                 toolbar      : "#toolbar3",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:2,
                     hidden:true
					},
					{field:'kdoutput',
					 title:'<span style="color:blue"><b>Kode</b></span>',
					 width:4,
					 align:'left'	
					},
					{field:'nmoutput',
					 title:'<span style="color:blue"><b>Uraian Sasaran Kegiatan (Output)</b></span>',
					 width:35
					},
                    {field:'nosasprog',
					 title:'<span style="color:blue"><b>Sas Prog</b></span>',
					 width:9,
                     align:'left'
					},
                    {field:'kdsdimensi',
					 title:'<span style="color:blue"><b>Dimensi</b></span>',
					 width:9,
                     align:'center'
					},
                    {field:'kdsspbidang',
					 title:'<span style="color:blue"><b>Bidang</b></span>',
					 width:9,
                     align:'center'
					},
                    {field:'kdnwcita',
					 title:'<span style="color:blue"><b>Nawa Cita</b></span>',
					 width:9,
                     align:'center'
					},
                    {field:'vol1',
					 title:'<span style="color:blue"><b>Volume</b></span>',
					 width:10,
                     align:'center'
					},
                    {field:'dppp',
					 title:'<span style="color:blue"><b>PPP</b></span>',
					 width:3,
                     align:'center'
					},
                    {field:'darg',
					 title:'<span style="color:blue"><b>ARG</b></span>',
					 width:3,
                     align:'center'
					},
                    {field:'dksst',
					 title:'<span style="color:blue"><b>KSST</b></span>',
					 width:3,
                     align:'center'
					},
                    {field:'dmpi',
					 title:'<span style="color:blue"><b>MPI</b></span>',
					 width:3,
                     align:'center'
					},
                    {field:'ppban',
					 title:'<span style="color:blue"><b>PPBAN</b></span>',
					 width:3,
                     align:'center'
					}
                    
				]],
                 onSelect:function(rowIndex,rowData){						
                              kdoutput  = rowData.kdoutput;
                              nmoutput  = rowData.nmoutput;
                              sasprog = rowData.nosasprog;
                              dimensi = rowData.kdsdimensi;
                              kdspbidang = rowData.kdspbidang;
                              kdsspbidang = rowData.kdsspbidang;
                              kdnwcita = rowData.kdnwcita;
                              prio =rowData.prioritas;                              
                              vol1  = rowData.vol1;
                              vol2  = rowData.vol2;
                              vol3  = rowData.vol3;
                              vol4  = rowData.vol4;
                              hrg1  = rowData.hrg1;
                              hrg2  = rowData.hrg2;
                              hrg3  = rowData.hrg3;
                              hrg4  = rowData.hrg4;
                              dppp = rowData.dppp,
                              darg = rowData.darg,
                              dksst = rowData.dksst,
                              dmpi = rowData.dmpi
                              ppban = rowData.ppban
                              $("#kdoutput").attr("value",kdoutput);
                              $("#nmoutput").attr("value",nmoutput);
                              $('#sprog').combogrid('setValue',sasprog);
                              $("#dimensi").combogrid('setValue',dimensi);//attr("value",issu);
                              $("#bidang1").combogrid('setValue',kdspbidang);
                              $("#bidang").combogrid('setValue',kdsspbidang);
                              $("#nawa").combogrid('setValue',kdnwcita);;
                              $("#volume1").attr("value",vol1);
                              $("#volume2").attr("value",vol2);
                              $("#volume3").attr("value",vol3);
                              $("#volume4").attr("value",vol4);
                              $("#alokasi1").attr("value",hrg1);
                              $("#alokasi2").attr("value",hrg2);
                              $("#alokasi3").attr("value",hrg3);
                              $("#alokasi4").attr("value",hrg4);
                              if (dppp==1){            
                                    $("#dppp").attr("checked",true);
                              } else {
                                    $("#dppp").attr("checked",false);
                              }
                              if (darg==1){            
                                    $("#darg").attr("checked",true);
                              } else {
                                    $("#darg").attr("checked",false);
                              }
                              if (dksst==1){            
                                    $("#dksst").attr("checked",true);
                              } else {
                                    $("#dksst").attr("checked",false);
                              }
                              if (dmpi==1){            
                                    $("#dmpi").attr("checked",true);
                              } else {
                                    $("#dmpi").attr("checked",false);
                              }
                              if (ppban==1){            
                                    $("#ppban").attr("checked",true);
                              } else {
                                    $("#ppban").attr("checked",false);
                              }
                              
                              lcstatus = 'edit'; 

                              grid_ikk();
                              grid_kmpnen();
                              //grid_output_renstra(); 
                              
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal3").dialog('open');
        }
			});
    }
    
    function grid_output_renstra(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
          // alert('<?php echo base_url(); ?>/index.php/master/select_output_renstra/'+mskpd+'/'+munit+'/'+program+'/'+mgiat);
	       $('#dg7').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_output_renstra/'+mskpd+'/'+munit+'/'+program+'/'+mgiat,
                 idField      : 'id',            
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
	                {field:'id',
					 title:'id',
					 width:2,
                     hidden:true
					},
					{field:'kdoutput',
					 title:'<span style="color:blue"><b>Kode</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'nmoutput',
					 title:'<span style="color:blue"><b>Nama Output</b></span>',
					 width:33
					},
                    {field:'vol1',
					 title:'<span style="color:blue"><b>Target 2016 </b></span>',
					 width:5,
                     align:'left'
					},
                    {field:'vol2',
					 title:'<span style="color:blue"><b>Target 2017 </b></span>',
					 width:5,
                     align:'center'
					},
                    {field:'vol3',
					 title:'<span style="color:blue"><b>Target 2018</b></span>',
					 width:5,
                     align:'center'
					},
                    {field:'vol4',
					 title:'<span style="color:blue"><b>Target 2019</b></span>',
					 width:5,
                     align:'center'
					},
                    {field:'total1',
					 title:'<span style="color:blue"><b>2016</b></span>',
					 width:10,
                     align:'right'
					},
                    {field:'total2',
					 title:'<span style="color:blue"><b>2017</b></span>',
					 width:10,
                     align:'right'
					},
                    {field:'total3',
					 title:'<span style="color:blue"><b>2018</b></span>',
					 width:10,
                     align:'right'
					},
                    {field:'total4',
					 title:'<span style="color:blue"><b>2019</b></span>',
					 width:10,
                     align:'right'
					}
                    
				]],
                 onSelect:function(rowIndex,rowData){						
                              kdo = rowData.kdoutput;
                              nmo  = rowData.nmoutput;
                              volu1  = rowData.vol1;
                              volu2  = rowData.vol2;
                              volu3  = rowData.vol3;
                              volu4  = rowData.vol4;
                              total1  = rowData.total1;
                              total2  = rowData.total2;
                              total3  = rowData.total3;
                              total4  = rowData.total4;
                              $("#kdoutput").attr("value",kdo);
                              $("#nmoutput").attr("value",nmo);
                              $("#volume1").attr("value",volu1);
                              $("#volume2").attr("value",volu2);
                              $("#volume3").attr("value",volu3);
                              $("#volume4").attr("value",volu4);
                              $("#alokasi1").attr("value",total1);
                              $("#alokasi2").attr("value",total2);
                              $("#alokasi3").attr("value",total3);
                              $("#alokasi4").attr("value",total4);
                              
                              
		          }
			});
    } 
    
    function grid_ikk(){
        //alert('jaka');
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
	       $('#dg4').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_indikatoroutput/'+mskpd+'/'+munit+'/'+program+'/'+mgiat+'/'+kdoutput,
                 idField      : 'id',
                 toolbar      : "#toolbar4",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'nomor',
					 title:'<span style="color:blue"><b>Nomor</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'<span style="color:blue"><b>Uraian Indikator Kinerja Kegiatan (IKK)</b></span>',
					 width:50
					},
                    {field:'vol1',
					 title:'<span style="color:blue"><b>Target 2016</b></span>',
					 width:10
					},
                    {field:'vol2',
					 title:'<span style="color:blue"><b>Target 2017</b></span>',
					 width:10
					},
                    {field:'vol3',
					 title:'<span style="color:blue"><b>Target 2018</b></span>',
					 width:10
					},
                    {field:'vol4',
					 title:'<span style="color:blue"><b>Target 2019</b></span>',
					 width:10
					},
                    {field:'satuan',
					 title:'<span style="color:blue"><b>Satuan</b></span>',
					 width:10
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              noikk  = rowData.nomor;
                              nmikk  = rowData.nama;
                              volikk1 = rowData.vol1;
                              volikk2 = rowData.vol2;
                              volikk3 = rowData.vol3;
                              volikk4 = rowData.vol4;
                              satuan = rowData.satuan;
                              $("#noikk").attr("value",noikk);
                              $("#nmikk").attr("value",nmikk);
                              $("#volikk1").attr("value",volikk1);
                              $("#volikk2").attr("value",volikk2);
                              $("#volikk3").attr("value",volikk3);
                              $("#volikk4").attr("value",volikk4);
                              $("#sat").attr("value",satuan);
                              lcstatus = 'edit'; 
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal4").dialog('open');
        }
			});
    } 
    
    function grid_kmpnen(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
	       $('#dg5').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_komponen/'+mskpd+'/'+munit+'/'+program+'/'+mgiat+'/'+kdoutput,
                 idField      : 'id',
                 toolbar      : "#toolbar5",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'kdkmpnen',
					 title:'<span style="color:blue"><b>Nomor</b></span>',
					 width:5,
					 align:'left'	
					},
					{field:'urkmpnen',
					 title:'<span style="color:blue"><b>Uraian Komponen</b></span>',
					 width:55
					},
                    {field:'kdbiaya',
					 title:'<span style="color:blue"><b>Jenis</b></span>',
					 width:5
					}
				]],
                 onSelect:function(rowIndex,rowData){						
                              komponen  = rowData.kdkmpnen;
                              nmkmpnen = rowData.urkmpnen;
                              jns = rowData.kdbiaya;;
                              $("#kdkmpnen").attr("value",komponen);
                              $("#nmkmpnen").attr("value",nmkmpnen);
                              $('#jns').combogrid('setValue',jns);
                              lcstatus = 'edit';
                              grid_lokasi();
                              //grid_kmpnen_renstra();
                    },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal5").dialog('open');
        }
			});
    }
    function grid_kmpnen_renstra(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
	       $('#dg8').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_komponen_renstra/'+mskpd+'/'+munit+'/'+program+'/'+mgiat+'/'+kdoutput,
                 idField      : 'id',             
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                {field:'id',
					 title:'id',
					 width:5,
                     hidden:true
					},
					{field:'kdkmpnen',
					 title:'Nomor',
					 width:5,
					 align:'left'	
					},
					{field:'nmkmpnen',
					 title:'Uraian Komponen',
					 width:55
					},
                    {field:'kdbiaya',
					 title:'Jenis',
					 width:5
					}
				]],
                 onSelect:function(rowIndex,rowData){						
                              komponen1  = rowData.kdkmpnen;
                              nmkmpnen1  = rowData.nmkmpnen;
                              jns1 = rowData.kdbiaya;;
                              $("#kdkmpnen").attr("value",komponen1);
                              $("#nmkmpnen").attr("value",nmkmpnen1);
                              $('#jns').combogrid('setValue',jns1);
                              
                    }
			});
    }
    function grid_lokasi(){
         var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mgiat = $('#kdgiat').combogrid('getValue');
        //alert('<?php echo base_url(); ?>/index.php/master/select_lokasi/'+mskpd+'/'+munit+'/'+program+'/'+mgiat+'/'+kdoutput+'/'+komponen); 
	       $('#dg6').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_lokasi/'+mskpd+'/'+munit+'/'+program+'/'+mgiat+'/'+kdoutput+'/'+komponen,
                 idField      : 'id', 
                 toolbar      : "#toolbar6",            
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                
					{field:'kdprop',
					 title:'<b><span style="color:#3366FF">Prov</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'kdkab',
					 title:'<b><span style="color:#3366FF">Kab</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'volume',
					 title:'<b><span style="color:#3366FF">Volume</span></b>',
					 width:5,
					 align:'center'	
					},
                    {field:'rupiah',
					 title:'<b><span style="color:#3366FF">Rupiah</span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pend',
					 title:'<b><span style="color:#3366FF">Pendamping</span></b>',
					 width:5,
					 align:'right'	
					},
                    {field:'pnbp',
					 title:'<b><span style="color:#3366FF">PNBP</span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'blu',
					 title:'<b><span style="color:#3366FF">BLU </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pln',
					 title:'<b><span style="color:#3366FF">PLN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'pdn',
					 title:'<b><span style="color:#3366FF">PDN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'hibah',
					 title:'<b><span style="color:#3366FF">Hibah </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'sbsn',
					 title:'<b><span style="color:#3366FF">SBSN </span></b>',
					 width:10,
					 align:'right'	
					},
                    {field:'jumlah',
					 title:'<b><span style="color:#3366FF">Jumlah </span></b>',
					 width:10,
					 align:'right'	
					}
				]],
                 onSelect:function(rowIndex,rowData){						
                              jkdprop  = rowData.kdprop;
                              jkdkab  = rowData.kdkab;
                              jkewe = rowData.kewe;
                              jnpphln = rowData.npphln;
                              jkdsumber =rowData.kdsumber;
                              jjenisphln =rowData.jenisphln;                              
                              jvolu  = rowData.volume;
                              jrupiah  = rowData.rupiah1;
                              jpnbp  = rowData.pnbp1;
                              jblu  = rowData.blu1;
                              jpln  = rowData.pln1;
                              jpdn  = rowData.pdn1;
                              jhibah  = rowData.hibah1;
                              jpend  = rowData.pend1;
                              jsbsn = rowData.sbsn1;
                              jpaguphln = rowData.paguphln1;
                              jserap = rowData.serap1;
                              jtglawal = rowData.tglawal;
                              jtglakhir = rowData.tglakhir;
                              $("#prop").combogrid('setValue',jkdprop);
                              $("#kab").combogrid('setValue',jkdkab);
                              $('#kdkewe').combogrid('setValue',jkewe);
                              $("#volu").attr("value",jvolu);
                              $('#rupiah').attr("value",jrupiah);
                              $("#pnbp").attr("value",jpnbp);
                              $("#blu").attr("value",jblu);
                              $("#sbsn").attr("value",jsbsn);
                              $("#sumber").combogrid('setValue',jkdsumber);
                              $("#npphln").combogrid('setValue',jnpphln);
                              $("#jeni").combogrid('setValue',jjenisphln);
                              $("#pagu").attr("value",jpaguphln);
                              $("#serap").attr("value",jserap);
                              $("#tglm").attr("value",jtglawal);
                              $("#tglt").attr("value",jtglakhir);
                              $("#pln").attr("value",jpln);
                              $("#pdn").attr("value",jpdn);
                              $("#hibah").attr("value",jhibah);
                              $("#pend").attr("value",jpend);
                              lcstatus = 'edit';
                              
                    },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal6").dialog('open');
        }
			});
    }  
    
    function barusasprog(){
        
        $("#nomor").attr("value",'');
        $("#uraian").attr("value",'');
        $("#nomorkl").combogrid("setValue",'');
        
        document.getElementById('nomor').focus();
         $("#dialog-modal1").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function baruikp(){
        
        $("#namaikp").attr("value",'');
        $("#nomerikp").attr("value",'');
        $("#vol1").attr("value",'');
        $("#vol2").attr("value",'');
        $("#vol3").attr("value",'');
        $("#vol4").attr("value",'');
        $("#vol5").attr("value",'');       
        document.getElementById('nomerikp').focus();
         $("#dialog-modal2").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function baruout(){
         var dimensi = '';
         var sdimensi ='';
         var kdpbidang = '';
         var kdspbidang = '';
         var kdsspbidang='';
         var kdnwcita='';
        
          $("#kdoutput").attr("value",'');
          $("#nmoutput").attr("value",'');
          $('#sprog').combogrid('setValue','');
          $("#nmspog").attr("value",'');
          $("#dimensi").combogrid('setValue','');//attr("value",'');
          $("#nmdimensi").attr("value",'');
          $("#bidang1").combogrid('setValue','');
          $("#nmbidang1").attr("value",'');
          $("#bidang").attr("value",'');
          $("#nmbidang").attr("value",'');
          $("#nawa").combogrid('setValue','');
          $("#nmnawa").attr("value",'');
          $("#volume1").attr("value",'');
          $("#volume2").attr("value",'');
          $("#volume3").attr("value",'');
          $("#volume4").attr("value",'');
          $("#alokasi1").attr("value",'');
          $("#alokasi2").attr("value",'');
          $("#alokasi3").attr("value",'');
          $("#alokasi4").attr("value",'');
          $("#dppp").attr("checked",false);
          $("#darg").attr("checked",false);
          $("#dksst").attr("checked",false);
          $("#dmpi").attr("checked",false);
          $("#ppban").attr("checked",false);
          //grid_output_renstra();       
        document.getElementById('kdoutput').focus();
         $("#dialog-modal3").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function baruout1(){
        
           var dimensi = '';
         var sdimensi ='';
         var kdpbidang = '';
         var kdspbidang = '';
         var kdsspbidang='';
         var kdnwcita='';
        
          $("#kdoutput").attr("value",'');
          $("#nmoutput").attr("value",'');
          $('#sprog').combogrid('setValue','');
          $("#nmspog").attr("value",'');
          $("#dimensi").combogrid('setValue','');//attr("value",'');
          $("#nmdimensi").attr("value",'');
          $("#bidang1").combogrid('setValue','');
          $("#nmbidang1").attr("value",'');
          $("#bidang").combogrid('setValue','');
          $("#nmbidang").attr("value",'');
          $("#nawa").combogrid('setValue','');
          $("#nmnawa").attr("value",'');
          $("#volume1").attr("value",'');
          $("#volume2").attr("value",'');
          $("#volume3").attr("value",'');
          $("#volume4").attr("value",'');
          $("#alokasi1").attr("value",'');
          $("#alokasi2").attr("value",'');
          $("#alokasi3").attr("value",'');
          $("#alokasi4").attr("value",'');
          $("#dppp").attr("checked",false);
          $("#darg").attr("checked",false);
          $("#dksst").attr("checked",false);
          $("#dmpi").attr("checked",false);
          $("#ppban").attr("checked",false);
          //grid_output_renstra();       
        document.getElementById('kdoutput').focus();
         $("#dialog-modal3").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function baruikk(){
        
        $("#noikk").attr("value",'');
        $("#nmikk").attr("value",'');
        $("#volikk1").attr("value",'');
        $("#volikk2").attr("value",'');
        $("#volikk3").attr("value",'');
        $("#volikk4").attr("value",'');      
        document.getElementById('nomerikp').focus();
         $("#dialog-modal4").dialog('open');
        lcstatus = 'tambah';
    }
    
    function barukmp(){
        
        $("#kdkmpnen").attr("value",'');
        $("#nmkmpnen").attr("value",'');
        $('#jns').combogrid('setValue','');      
        document.getElementById('kdkmpnen').focus();
         $("#dialog-modal5").dialog('open');
        lcstatus = 'tambah';
        //grid_kmpnen_renstra();
    }
    
    function barulok(){ 
            $("#prop").combogrid('setValue','');
            $("#nmprop").attr("value",'');
            $("#kab").attr("value",'');
            $("#nmkab").attr("value",'');
          $("#kdkewe").combogrid('setValue','');
          $("#nmkewe").attr("value",'');
          $("#volu").attr("value",'');
          $("#rupiah").attr("value",'0');
          $("#pnbp").attr("value",'0');
          $("#blu").attr("value",'0');
          $("#sbsn").attr("value",'0');
          $("#sumber").combogrid('setValue','');
          $("#npphln").attr("value",'');
          $("#jeni").combogrid('setValue','');
          $("#pagu").attr("value",'0');
          $("#serap").attr("value",'0');
          $("#tglm").datebox("setValue",'');
          $("#tglt").datebox("setValue",'');
          $("#pln").attr("value",'0');
          $("#pdn").attr("value",'0');
          $("#hibah").attr("value",'0');
          $("#pend").attr("value",'0');

         $("#dialog-modal6").dialog('open');
        lcstatus = 'tambah';
    }
    
    function barusumber(){ 
            $("#kds").attr("value",'');
            $("#nms").attr("value",'');

         $("#dialog-modal7").dialog('open');
        lcstatus = 'tambah';
    }
    
   function barunpphln(){ 
            $("#kdsu").combogrid('setValue','');
            $("#kdn").attr("value",'');
            $("#nmn").attr("value",'');

         $("#dialog-modal8").dialog('open');
        lcstatus = 'tambah';
    }
    
    
    function simpansasprog(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var cprog = $('#kdprog').combogrid('getValue');
           var nosasprog = document.getElementById('nomor').value;
           var ursasprog = document.getElementById('uraian').value;
           var csasstra = $('#nomorkl').combogrid('getValue');
           var ursasstra = document.getElementById('uraiankl').value;
          //alert(mskpd+"/"+cnovisi+"/"+cnmvisi);
          
           if (nosasprog==''){
            alert('nomor  diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,nosasprog,nmsasprog,nosasstra,nmsasstra)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+cprog+"','"+nosasprog+"','"+ursasprog+"','"+csasstra+"','"+ursasstra+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master1',
                    data: ({tabel:'d_sasaran_prog',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cprog:'kdprogram',lcprog:cprog,cgiat:'kdunit',lcgiat:munit,cidnew:'nosasprog',lcidnew:nosasprog}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_sasaran_prog SET nmsasprog='"+ursasprog+"',nosasstra='"+csasstra+"',nmsasstra='"+ursasstra+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and kdprogram='"+cprog+"' and nosasprog='"+nosasprog+"'";
           // alert(lcquery);
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_outcome();
    }
         
    function simpanikp(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mprog = $('#kdprog').combogrid('getValue');
           var nosasprog = document.getElementById('nomor').value;            
           var cno = document.getElementById('nomerikp').value;           
           var cnama = document.getElementById('namaikp').value;
           var cvol1 = document.getElementById('vol1').value;
           var cvol2 = document.getElementById('vol2').value;
           var cvol3 = document.getElementById('vol3').value;
           var cvol4 = document.getElementById('vol4').value;
           var cvol5 = document.getElementById('vol5').value;
           var cdept ='kddept';
           var cunit ='kdunit'
           var cprog ='kdprogram';
           var csasaran= 'nosasprog';
           var cid ='noinsasprog';
           
          
           if (cno==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,nosasprog,noinsasprog,uraian,vol,vol1,vol2,vol3,vol4)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+mprog+"','"+nosasprog+"','"+cno+"','"+cnama+"','"+cvol1+"','"+cvol2+"','"+cvol3+"','"+cvol4+"','"+cvol5+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master3',
                    data: ({tabel:'d_indikator_prog',kolom:lcinsert,nilai:lcvalues,cdept:cdept,lcdept:mskpd,cprog:cprog,lcprog:mprog,cunit:cunit,lcunit:munit,csasaran:csasaran,lcsasaran:nosasprog,cid:cid,lcid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_indikator_prog SET uraian='"+cnama+"',vol='"+cvol1+"',vol1='"+cvol2+"',vol2='"+cvol3+"',vol3='"+cvol4+"',vol4='"+cvol5+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and noinsasprog='"+cno+"' and kdprogram='"+mprog+"' and nosasprog='"+nosasprog+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_ikp();
    }
    
   function simpanout(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mprog = $('#kdprog').combogrid('getValue');
           var mgiat = $('#kdgiat').combogrid('getValue');            
           var cno = document.getElementById('kdoutput').value;           
           var cnama = document.getElementById('nmoutput').value;
           var csprog = $('#sprog').combogrid('getValue');
           var cdimensi = dimensi;//$('#issu').combogrid('getValue');//document.getElementById('issu').value;
           var csdimensi = sdimensi;
           var ckdpbidang = kdpbidang;
           var ckdspbidang = kdspbidang;
           var ckdsspbidang = kdsspbidang;
           var ckdnwcita = kdnwcita;//$('#prio').combogrid('getValue');
           var cvolume1 = document.getElementById('volume1').value;
           var cvolume2 = document.getElementById('volume2').value;
           var cvolume3 = document.getElementById('volume3').value;
           var cvolume4 = document.getElementById('volume4').value;
           var calokasi1 = $('#alokasi1').numberbox('getValue');//angka(document.getElementById('alokasi1').value);
           var calokasi2 = $('#alokasi2').numberbox('getValue');//angka(document.getElementById('alokasi2').value);
           var calokasi3 = $('#alokasi3').numberbox('getValue');//angka(document.getElementById('alokasi3').value);
           var calokasi4 =$('#alokasi4').numberbox('getValue');// angka(document.getElementById('alokasi4').value);
           var cdppp  = document.getElementById('dppp').checked;
           var cdarg  = document.getElementById('darg').checked;
           var cdksst  = document.getElementById('dksst').checked;
           var cdmpi  = document.getElementById('dmpi').checked;
           var cppban  = document.getElementById('ppban').checked;
            if (cdppp==false){cdppp=0;}else{cdppp=1;}
            if (cdarg==false){cdarg=0;}else{cdarg=1;}
            if (cdksst==false){cdksst=0;}else{cdksst=1;}
            if (cdmpi==false){cdmpi=0;}else{cdmpi=1;}
            if (cppban==false){cppban=0;}else{cppban=1;}
           var cdept ='kddept';
           var cunit ='kdunit'
           var cprog ='kdprogram';
           var cgiat= 'kdgiat';
           var cid ='kdoutput';
           
          
           if (cno==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,kdgiat,kdoutput,nmoutput,nosasprog,kddimensi,kdsdimensi,kdpbidang,kdspbidang,kdsspbidang,kdnwcita,vol1,vol2,vol3,vol4,harga1,harga2,harga3,harga4,dppp,darg,dksst,dmpi,ppban)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+mprog+"','"+mgiat+"','"+cno+"','"+cnama+"','"+csprog+"','"+cdimensi+"','"+csdimensi+"','"+ckdpbidang+"','"+ckdspbidang+"','"+ckdsspbidang+"','"+ckdnwcita+"','"+cvolume1+"','"+cvolume2+"','"+cvolume3+"','"+cvolume4+"','"+calokasi1+"','"+calokasi2+"','"+calokasi3+"','"+calokasi4+"','"+cdppp+"','"+cdarg+"','"+cdksst+"','"+cdmpi+"','"+cppban+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master3',
                    data: ({tabel:'d_item_output',kolom:lcinsert,nilai:lcvalues,cdept:cdept,lcdept:mskpd,cprog:cprog,lcprog:mprog,cunit:cunit,lcunit:munit,csasaran:cgiat,lcsasaran:mgiat,cid:cid,lcid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_item_output SET nmoutput='"+cnama+"',nosasprog='"+csprog+"',kddimensi='"+cdimensi+"',kdsdimensi='"+csdimensi+"',kdpbidang='"+ckdpbidang+"',kdspbidang='"+ckdspbidang+"',kdsspbidang='"+ckdsspbidang+"',kdnwcita='"+ckdnwcita+"',vol1='"+cvolume1+"',vol2='"+cvolume2+"',vol3='"+cvolume3+"',vol4='"+cvolume4+"',harga1='"+calokasi1+"',harga2='"+calokasi2+"',harga3='"+calokasi3+"',harga4='"+calokasi4+"',dppp='"+cdppp+"',darg='"+cdarg+"',dksst='"+cdksst+"',dmpi='"+cdmpi+"',ppban='"+cppban+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and kdoutput='"+cno+"' and kdprogram='"+mprog+"' and kdgiat='"+mgiat+"'";

            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_output();
    } 
   
   function simpanikk(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mprog = $('#kdprog').combogrid('getValue');
           var mgiat = $('#kdgiat').combogrid('getValue');            
           var moutput = document.getElementById('kdoutput').value; 
           var cno = document.getElementById('noikk').value;                     
           var cnama = document.getElementById('nmikk').value;
           var cvolume1 = document.getElementById('volikk1').value;
           var cvolume2 = document.getElementById('volikk2').value;
           var cvolume3 = document.getElementById('volikk3').value;
           var cvolume4 = document.getElementById('volikk4').value;
           var csat = document.getElementById('sat').value;
           var cdept ='kddept';
           var cunit ='kdunit'
           var cprog ='kdprogram';
           var cgiat= 'kdgiat';
           var coutput ='kdoutput';
           var cid ='nomor';
           
          
           if (cno==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,kdgiat,kdoutput,nomor,nama,vol1,vol2,vol3,vol4,satuan)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+mprog+"','"+mgiat+"','"+moutput+"','"+cno+"','"+cnama+"','"+cvolume1+"','"+cvolume2+"','"+cvolume3+"','"+cvolume4+"','"+csat+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master5',
                    data: ({tabel:'d_indikator_output',kolom:lcinsert,nilai:lcvalues,cdept:cdept,lcdept:mskpd,cprog:cprog,lcprog:mprog,cunit:cunit,lcunit:munit,cgiat:cgiat,lcgiat:mgiat,coutput:coutput,lcoutput:moutput,cid:cid,lcid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_indikator_output SET nama='"+cnama+"',vol1='"+cvolume1+"',vol2='"+cvolume2+"',vol3='"+cvolume3+"',vol4='"+cvolume4+"',satuan='"+csat+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and kdoutput='"+moutput+"' and kdprogram='"+mprog+"' and kdgiat='"+mgiat+"' and nomor='"+cno+"'";
            //alert(lcquery);
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_ikk();
    }
    
    function simpankmp(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mprog = $('#kdprog').combogrid('getValue');
           var mgiat = $('#kdgiat').combogrid('getValue');            
           var moutput = document.getElementById('kdoutput').value; 
           var cno = document.getElementById('kdkmpnen').value;                     
           var cnama = document.getElementById('nmkmpnen').value;
           var cjns = $('#jns').combogrid('getValue'); 
           var cdept ='kddept';
           var cunit ='kdunit'
           var cprog ='kdprogram';
           var cgiat= 'kdgiat';
           var coutput ='kdoutput';
           var cid ='kdkmpnen';
           
          
           if (cno==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,kdgiat,kdoutput,kdkmpnen,urkmpnen,kdbiaya)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+mprog+"','"+mgiat+"','"+moutput+"','"+cno+"','"+cnama+"','"+cjns+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master5',
                    data: ({tabel:'d_kmpnen',kolom:lcinsert,nilai:lcvalues,cdept:cdept,lcdept:mskpd,cprog:cprog,lcprog:mprog,cunit:cunit,lcunit:munit,cgiat:cgiat,lcgiat:mgiat,coutput:coutput,lcoutput:moutput,cid:cid,lcid:cno}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_kmpnen SET urkmpnen='"+cnama+"',kdbiaya='"+cjns+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and kdoutput='"+moutput+"' and kdprogram='"+mprog+"' and kdgiat='"+mgiat+"' and kdkmpnen='"+cno+"'";
            //alert(lcquery);
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_kmpnen();
    }
   
   function simpanlok(){
           var mskpd = document.getElementById('sskpd').value;
           var munit = document.getElementById('kdunit').value;
           var mprog = $('#kdprog').combogrid('getValue');
           var mgiat = $('#kdgiat').combogrid('getValue');
           var moutput = document.getElementById('kdoutput').value; 
           var mkmpnen = document.getElementById('kdkmpnen').value;
           var mprop = $('#prop').combogrid('getValue');
           var mkab = $('#kab').combogrid('getValue');
           var ckewe = $('#kdkewe').combogrid('getValue');
           var cvolu = document.getElementById('volu').value;
           var crupiah = $('#rupiah').numberbox('getValue');//angka(document.getElementById('rupiah').value);
           var cpnbp= $('#pnbp').numberbox('getValue');//angka(document.getElementById('pnbp').value);
           var cblu= $('#blu').numberbox('getValue');//angka(document.getElementById('blu').value); 
           var csbsn= $('#sbsn').numberbox('getValue');//angka(document.getElementById('sbsn').value);
           var csumber = $('#sumber').combogrid('getValue');
           var cnpphln = $('#npphln').combogrid('getValue');
           var cjeni = $('#jeni').combogrid('getValue');
           var cpagu= $('#pagu').numberbox('getValue');//angka(document.getElementById('pagu').value);
           var cserap= $('#serap').numberbox('getValue');//angka(document.getElementById('serap').value);
           var cpln= $('#pln').numberbox('getValue');//angka(document.getElementById('pln').value);
           var cpdn= $('#pdn').numberbox('getValue');//angka(document.getElementById('pdn').value);
           var chibah= $('#hibah').numberbox('getValue');//angka(document.getElementById('hibah').value);
           var cpend= $('#pend').numberbox('getValue');//angka(document.getElementById('pend').value);
           var ctglm = document.getElementById('tglm').value;
           var ctglt = document.getElementById('tglt').value;
           var cjml = crupiah+cpnbp+cblu+csbsn+cpagu+cserap+cpln+cpdn+chibah+cpend;
           var cdept ='kddept';
           var cunit ='kdunit'
           var cprog ='kdprogram';
           var cgiat= 'kdgiat';
           var coutput ='kdoutput';
           var ckmpnen ='kdkmpnen';
           var cprop ='kdprop';
           var ckab ='kdkab';
           
          
           if (mprop==''){
            alert('prop diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdunit,kdprogram,kdgiat,kdoutput,kdkmpnen,kdprop,kdkab,kewenangan,npphln,kdsumber,jenisphln,volume,rupiah,pnbp,blu,pln,pdn,hibah,pend,sbsn,paguphln,serap,tglawal,tglakhir,jumlah)";
            lcvalues = "('"+mskpd+"','"+munit+"','"+mprog+"','"+mgiat+"','"+moutput+"','"+mkmpnen+"','"+mprop+"','"+mkab+"','"+ckewe+"','"+cnpphln+"','"+csumber+"','"+cjeni+"','"+cvolu+"','"+crupiah+"','"+cpnbp+"','"+cblu+"','"+cpln+"','"+cpdn+"','"+chibah+"','"+cpend+"','"+csbsn+"','"+cpagu+"','"+cserap+"','"+ctglm+"','"+ctglt+"','"+cjml+"')";
            //alert(lcinsert+"/"+lcvalues);
            //alert('cdept'+'='+cdept+'/'+'lcdept'+'='+mskpd+'/'+'cprog'+'='+cprog+'/'+'lcprog'+'='+mprog+'/'+'cunit'+'='+cunit+'/'+'lcunit'+'='+munit+'/'+'cgiat'+'='+cgiat+'/'+'lcgiat'+'='+mgiat+'/'+'coutput'+'='+coutput+'/'+'lcoutput'+'='+moutput+'/'+'ckmpnen'+'='+ckmpnen+'/'+'lckmpnen'+'='+mkmpnen+'/'+'cprop'+'='+cprop+'/'+'lcprop'+'='+mprop+'/'+'ckab'+'='+ckab+'/'+'lckab'+'='+mkab);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master6',
                    data: ({tabel:'d_lok',kolom:lcinsert,nilai:lcvalues,cdept:cdept,lcdept:mskpd,cprog:cprog,lcprog:mprog,cunit:cunit,lcunit:munit,cgiat:cgiat,lcgiat:mgiat,coutput:coutput,lcoutput:moutput,ckmpnen:ckmpnen,lckmpnen:mkmpnen,cprop:cprop,lcprop:mprop,ckab:ckab,lckab:mkab}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } else{
            
            lcquery = "UPDATE d_lok SET kewenangan='"+ckewe+"',npphln='"+cnpphln+"',kdsumber='"+csumber+"',jenisphln='"+cjeni+"',volume='"+cvolu+"',rupiah='"+crupiah+"',pnbp='"+cpnbp+"',blu='"+cblu+"',pln='"+cpln+"',pdn='"+cpdn+"',hibah='"+chibah+"',pend='"+cpend+"',sbsn='"+csbsn+"',paguphln='"+cpagu+"',serap='"+cserap+"',tglawal='"+ctglm+"',tglakhir='"+ctglt+"',jumlah='"+cjml+"' where kddept='"+mskpd+"' and kdunit='"+munit+"' and kdoutput='"+moutput+"' and kdprogram='"+mprog+"' and kdgiat='"+mgiat+"' and kdkmpnen='"+mkmpnen+"' and kdprop='"+mprop+"' and kdkab='"+mkab+"'";
            //alert(lcquery);
            $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>/index.php/master/update_master',
                data: ({st_query:lcquery}),
                dataType:"json",
                success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
            });
            });
            
            
        }
        grid_lokasi();
    }
   
   function simpansumber(){
           var mskpd = document.getElementById('sskpd').value;
           var kds = document.getElementById('kds').value;
           var nms = document.getElementById('nms').value;
           
          
           
          
           if (kds==''){
            alert('nomor  diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdsumber,nmsumber)";
            lcvalues = "('"+mskpd+"','"+kds+"','"+nms+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'t_sumber',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cido:'kdsumber',lcido:kds}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } 
    }
   function simpannpphln(){
           var mskpd = document.getElementById('sskpd').value;
           var kdsu = $('#kdsu').combogrid('getValue');
           var kdn = document.getElementById('kdn').value;
           var nmn = document.getElementById('nmn').value;
           
          
           if (kdsu==''){
            alert('sumber  diisi Dahulu');
            exit();
            } 
          
           if (kdn==''){
            alert('nomor  diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdsumber,kdnpphln,nmnpphln)";
            lcvalues = "('"+mskpd+"','"+kdsu+"','"+kdn+"','"+nmn+"')";
            //alert(lcinsert+"/"+lcvalues);
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master33',
                    data: ({tabel:'t_npphln',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cido:'kdsumber',lcido:kdsu,ckdn:'kdnpphln',lckdn:kdn}),
                    dataType:"json",
                    success:function(data){
                        status = data;
                        if (status=='0'){
                            alert('Gagal Simpan..!!');
                            exit();
                        }else if(status=='1'){
                            alert('Data Sudah Ada..!!');
                            exit();
                        }else{
                            alert('Data Tersimpan..!!');
                            exit();
                        }
                    }
                });
            });   
           
        } 
    }
   function hapussasprog(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var nosasprog = document.getElementById('nomor').value;
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fkdx='nosasprog';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master3';
        var tny = confirm('Yakin Ingin Menghapus Data,Sasaran Program : '+nosasprog+' Program : '+cprog);
        //alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fkdx+'/'+nosasprog);
        $(document).ready(function(){
         $.post(urll,({tabel:'d_sasaran_prog',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fkdx:fkdx,kdx:nosasprog}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {  
                alert('Data Berhasil Dihapus..!!');
                exit();
            }
         });
        }); 
        grid_outcome();   
    }
    
   function hapusikp(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var nosasprog = document.getElementById('nomor').value;
        var noinsasprog = document.getElementById('nomerikp').value;
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fkdx='nosasprog';
        var fnoinsasprog='noinsasprog';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master4';
        var tny = confirm('Yakin Ingin Menghapus Data,IKP : '+noinsasprog+' Sasaran Program : '+nosasprog);
        //alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fkdx+'/'+nosasprog+'/'+fnoinsasprog+'/'+noinsasprog);
        if (tny==true){
            $(document).ready(function(){
             $.post(urll,({tabel:'d_indikator_prog',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fkdx:fkdx,kdx:nosasprog,fnoinsasprog:fnoinsasprog,noinsasprog:noinsasprog}),function(data){
                status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {  
                    alert('Data Berhasil Dihapus..!!');
                    exit();
                }
             });
            }); 
            grid_ikp(); 
       } 
    } 
    function hapusout(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var cgiat = $('#kdgiat').combogrid('getValue'); 
        var noinsasprog = document.getElementById('kdoutput').value;
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fkdx='kdgiat';
        var fnoinsasprog='kdoutput';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master44';
        var tny = confirm('Yakin Ingin Menghapus Data, Sasaran Kegiatan : '+noinsasprog+' Kegiatan : '+cgiat+'(IKK,KOMPONEN dan Lokasi Akan Terhapus)');
        //alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fkdx+'/'+cgiat+'/'+fnoinsasprog+'/'+noinsasprog);
        if (tny==true){
            $(document).ready(function(){
             $.post(urll,({tabel:'d_item_output',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fkdx:fkdx,kdx:cgiat,fnoinsasprog:fnoinsasprog,noinsasprog:noinsasprog}),function(data){
                status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {  
                    alert('Data Berhasil Dihapus..!!');
                    exit();
                }
             });
            }); 
            grid_output();
         }   
    }
    
    function hapusikk(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var cgiat = $('#kdgiat').combogrid('getValue'); 
        var ckdoutput = document.getElementById('kdoutput').value;
        var cnoikk = document.getElementById('noikk').value;
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fgiat='kdgiat';
        var fkdoutput='kdoutput';
        var fnoikk='nomor';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master5';
        var tny = confirm('Yakin Ingin Menghapus Data, IKK : '+cnoikk+' di Sasaran Kegiatan : '+ckdoutput);
        //alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fkdx+'/'+cgiat+'/'+fnoinsasprog+'/'+noinsasprog);
        if (tny==true){
            $(document).ready(function(){
             $.post(urll,({tabel:'d_indikator_output',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fgiat:fgiat,cgiat:cgiat,fkdoutput:fkdoutput,kdoutput:ckdoutput,fnoikk:fnoikk,cnoikk:cnoikk}),function(data){
                status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {  
                    alert('Data Berhasil Dihapus..!!');
                    exit();
                }
             });
            }); 
            grid_output();
         }   
    }
    
    function hapuskmp(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var cgiat = $('#kdgiat').combogrid('getValue'); 
        var ckdoutput = document.getElementById('kdoutput').value;
        var cnokmp = document.getElementById('kdkmpnen').value;
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fgiat='kdgiat';
        var fkdoutput='kdoutput';
        var fnoikk='kdkmpnen';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master55';
        var tny = confirm('Yakin Ingin Menghapus Data, Komponen : '+cnokmp+' di Sasaran Kegiatan : '+ckdoutput);
        //alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fkdx+'/'+cgiat+'/'+fkdoutput+'/'+noinsasprog);
        if (tny==true){
            $(document).ready(function(){
             $.post(urll,({tabel:'d_kmpnen',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fgiat:fgiat,cgiat:cgiat,fkdoutput:fkdoutput,kdoutput:ckdoutput,fnoikk:fnoikk,cnoikk:cnokmp}),function(data){
                status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {  
                    alert('Data Berhasil Dihapus..!!');
                    exit();
                }
             });
            }); 
            grid_kmpnen();  
         } 
    }
    
    function hapuslok(){
        var mskpd = document.getElementById('sskpd').value;
        var munit = document.getElementById('kdunit').value;
        var cprog = $('#kdprog').combogrid('getValue');
        var cgiat = $('#kdgiat').combogrid('getValue'); 
        var ckdoutput = document.getElementById('kdoutput').value;
        var cnokmp = document.getElementById('kdkmpnen').value;
        var cprop = $('#prop').combogrid('getValue');
        var ckab = $('#kab').combogrid('getValue');
        var fkdprogram ='kdprogram';
        var fskpd='kddept';
        var fkdunit='kdunit';
        var fgiat='kdgiat';
        var fkdoutput='kdoutput';
        var fnokmp='kdkmpnen';
        var fprop='kdprop';
        var fkab='kdkab';
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master6';
        var tny = confirm('Yakin Ingin Menghapus Data, Lokasi : '+cprop+' di Komponen : '+cnokmp);
       // alert(fskpd+'/'+mskpd+'/'+fkdunit+'/'+munit+'/'+fkdprogram+'/'+cprog+'/'+fgiat+'/'+cgiat+'/'+fkdoutput+'/'+ckdoutput+'/'+fnokmp+'/'+cnokmp+'/'+fprop+'/'+cprop+'/'+fkab+'/'+ckab);
        if (tny==true){
            $(document).ready(function(){
             $.post(urll,({tabel:'d_lok',fkdprogram:fkdprogram,kdprogram:cprog,fskpd:fskpd,skpd:mskpd,fkdunit:fkdunit,kdunit:munit,fgiat:fgiat,cgiat:cgiat,fkdoutput:fkdoutput,kdoutput:ckdoutput,fnokmp:fnokmp,cnokmp:cnokmp,fprop:fprop,cprop:cprop,fkab:fkab,ckab:ckab}),
             function(data){
                status = data;
                if (status=='0'){
                    alert('Gagal Hapus..!!');
                    exit();
                } else {  
                    alert('Data Berhasil Dihapus..!!');
                    exit();
                }
             });
            }); 
            grid_lokasi();  
        } 
    } 
   
    function enter(ckey,_cid){
        if (ckey==13)
        	{  
        	   document.getElementById(_cid).focus();
               $('#kdgiat').combogrid.focus();
                //if(_cid=='vol1'){
//                   simpan();
//                   }
               
        	}     
        }
    function enter1(ckey,_cid){
        
        if (ckey==13)
        	{  
               $('#kab').combogrid.focus();
        	}     
        }
    
    function kembali(){
      
             $("#dialog-modal").dialog('close');
             $("#dialog-modal1").dialog('close');
             $("#dialog-modal2").dialog('close');
             $("#dialog-modal3").dialog('close');
             $("#dialog-modal4").dialog('close');
             $("#dialog-modal5").dialog('close');
             $("#dialog-modal6").dialog('close');
             $("#dialog-modal7").dialog('close');
        
                
    }
    function kembali_lokasi(){
      
            
             $("#dialog-modal7").dialog('close');
             $("#dialog-modal8").dialog('close');
                 get_sumber();
                
    }
    
    function nextgiat(){
        var cprog = $('#kdprog').combogrid('getValue');
        if(cprog==''){
            alert('Pilih Program Dulu')
        }else{
            $("#section2").click();
        }
        
     }
     function nextprog(){
        
            $("#section1").click();
        
     }
     function nextkmpnen(){
        var cgiat = $('#kdgiat').combogrid('getValue');
        var ckdoutput = document.getElementById('kdoutput').value;
        if(cgiat=='' || ckdoutput==''){
            alert('Silahkan Pilih Kegiatan dan sasaran kegiatan(Output) Dulu')
            $("#section2").click()
        }else{
            $("#section3").click();
        }
        
     }
</script>


<STYLE TYPE="text/css"> 
input.right{ 
         text-align:right; 
         } 
</STYLE> 


</head>
<body>

<div id="content">

   
   <table style="border-collapse:collapse;border-style:hidden;" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
   <tr style="border-style:hidden;">
   <td>KEMENTRIAN/LEMBAGA :   &nbsp;&nbsp;<input id="sskpd" name="sskpd" readonly="true" style="width:55px;border: 0;" />
    <input id="nmskpd" name="nmskpd" readonly="true" style="width: 320px; border:0;  " /></td>
   </tr>
   <tr style="border-style:hidden;">
   <td>UNIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input id="kdunit" name="kdunit" readonly="true" style="width:50px; border:0;"/>  
   &nbsp;&nbsp;&nbsp;<input id="nmunit" name="nmunit" readonly="true" style="width:680px;border:0;background-color:transparent;color: black;" disabled="true"/>
   </td>
   </tr>
   
   </table>

<div id="accordion">





<h3><a href="#" id="section1" ></a></h3>
   
   <div  style="height:250px;">      
        <table style="border-collapse:collapse;border-style:hidden;" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
   
       <tr style="border-style:hidden;">
       <td>PROGRAM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input id="kdprog" name="kdprog" readonly="true" style="width:50px; border:0;" />  
       &nbsp;&nbsp;&nbsp;<input id="nmprog" name="nmprog" readonly="true" style="width:680px;border:0;background-color:transparent;color: black;" disabled="true"/>
       </td>
       </tr>
       </table>
       <table id="dg1" title="Sasaran Program (Outcome) " style="width:1170px;height:250px;" >          
       </table><br/> 
       <div id="toolbar1">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barusasprog();">Tambah</a>
            <!--<a class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="javascript:nextgiat();">Kegiatan</a> -->  		
        </div>
         <table id="dg2" title="Indikator Kinerja Program (IKP)" style="width:1170px;height:250px;" >          
       </table> <br/>  &nbsp; <button id="next1" class="easyui-linkbutton"  onclick="javascript:nextgiat()">Kegiatan >></a></button><br />&nbsp;
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikp();">Tambah</a>  		
        </div> 
    </div>

<h3><a href="#" id="section2" ></a></h3>
   
   <div  style="height:250px;">      
        <table style="border-collapse:collapse;border-style:hidden;" width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
   
       <tr style="border-style:hidden;">
       <td>KEGIATAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input id="kdgiat" name="kdgiat" readonly="true" style="width:60px; border:0;" />  
       &nbsp;&nbsp;&nbsp;<input id="nmgiat" name="nmgiat" readonly="true" style="width:780px;border:0;background-color:transparent;color: black;" disabled="true"/>
       </td>
       </tr>
       </table>
       <table id="dg3" title="Sasaran Kegiatan (Output) " style="width:1170px;height:250px;" >          
       </table><br/> 
       <div id="toolbar3">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruout();">Tambah</a>
            <a class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:nextprog();">Program</a>
            <!--<a class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="javascript:nextkmpnen();">Komponen</a> -->  		
        </div>
        <table id="dg4" title="Indikator Kinerja Kegiatan (IKK)" style="width:1170px;height:250px;" >          
       </table> <br/> <button id="next2" class="easyui-linkbutton"  onclick="javascript:nextprog()"> << Program </a></button> &nbsp; <button id="next2" class="easyui-linkbutton"  onclick="javascript:nextkmpnen()"> Komponen >></a></button><br />&nbsp;
        <div id="toolbar4">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikk();">Tambah</a>  		
        </div>
       
    </div>
<h3><a href="#" id="section3" onclick="javascript:grid_kmpnen();"> </a></h3>
   
   <div  style="height:250px;">      
      
       <table id="dg5" title="Komponen " style="width:1170px;height:250px;" >          
       </table><br/>
       <div id="toolbar5">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barukmp();">Tambah</a> 
            <!--<a class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="javascript:nextgiat();">Kegiatan</a> --> 		
        </div>
        <table id="dg6" title="LOKASI " style="width:1170px;height:250px;" >          
       </table><br/><br/>  &nbsp; <button id="next3" class="easyui-linkbutton"  onclick="javascript:nextgiat()"><< Kegiatan </a></button><br />&nbsp; 
       <div id="toolbar6">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barulok();">Tambah</a>   		
        </div>
         
    </div>


</div>

</div>  


<div id="dialog-modal1" title="Input/Edit Sasaran Program (Outcome)">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1070px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="nomor" name="nomor" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Sasaran Program (Outcome)</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="uraian" name="uraian" style="width:870px;" /></td>  
       </tr> 
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Sasaran Strategis KL</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nomorkl" name="nomorkl" style="width:50px;" /> <input id="uraiankl" name="uraiankl" style="width:870px;" /></td>  
        </tr>  
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barusasprog()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpansasprog()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapussasprog()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>

<div id="dialog-modal2" title="Input/Edit Indikator Kinerja Program (IKP) ">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="nomerikp" name="nomerikp" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Indikator Program (IKP)</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="namaikp" name="namaikp" style="width:770px;" /></td>  
        </tr> 
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Target </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"> 
        &nbsp;<input type="hidden" id="vol1" name="vol1" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol2');"/>
       2016 &nbsp;<input id="vol2" name="vol2" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol3');"/>
       2017 &nbsp;<input id="vol3" name="vol2" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol4');"/>
       2018 &nbsp;<input id="vol4" name="vol4" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol5');"/>
       2019 &nbsp;<input id="vol5" name="vol4" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
       
       </tr>
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikp()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanikp()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapusikp()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
  
</div>

<div id="dialog-modal3" title="INPUT/EDIT SASARAN KEGIATAN(OUTPUT)">
    <p class="validateTips"></p> 
      <!--<table id="dg7" title="Output Renstra " style="width:980px;height:200px;" >          
       </table> -->
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1200px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode Sasaran Kegiatan</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="4"><input id="kdoutput" name="kdoutput" style="width:50px;"  />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Sasaran Kegiatan</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nmoutput" name="nmoutput" style="width:770px;" /></td>   
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Sasaran Program</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="sprog" name="sprog" style="width:50px;" /><input id="nmspog" name="nmspog" style="width:520px;" readonly="true"/></td>   
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Target </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"> 
       2016 &nbsp;<input id="volume1" name="volume1" style="width:140px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volume2');"/>
       2017 &nbsp;<input id="volume2" name="volume2" style="width:140px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volume3');"/>
       2018 &nbsp;<input id="volume3" name="volume3" style="width:140px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volume4');"/>
       2019 &nbsp;<input id="volume4" name="volume4" style="width:140px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volume1');"/></td>
       </tr> 
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Alokasi</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"> 
       
       <input type="hidden" id="alokasi1" name="alokasi1" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="."  />
       2017<input id="alokasi2" name="alokasi2" style="width:150px;text-align:right;"  class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="."  />
       2018<input id="alokasi3" name="alokasi3" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="."/>
       2019<input id="alokasi4" name="alokasi4" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." /></td>
       </tr>
       
      <!--<tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input type="hidden" id="prio" name="prio" style="width:50px;" /><input id="nmprio" name="nmprio" style="width:570px;" readonly="true"/></td>   
       </tr>-->
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Dimensi</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="dimensi" name="dimensi" style="width:100px;" /><input id="nmdimensi" name="nmdimensi" style="width:870px;" readonly="true"/></td>   
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Bidang</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="bidang1" name="bidang1" style="width:100px;" /><input id="nmbidang1" name="nmbidang1" style="width:870px;" readonly="true"/></td>   
       </tr>
        <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;"></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="bidang" name="bidang" style="width:100px;" /><input id="nmbidang" name="nmbidang" style="width:870px;" readonly="true"/></td>   
       </tr>
       
      <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Nawa Cita</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nawa" name="nawa" style="width:100px;" /><input id="nmnawa" name="nmnawa" style="width:820px;" readonly="true"/></td>   
       </tr>
       
       
        <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Dukungan</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3">
       <input type="checkbox" id="dppp"/>PPP  <input type="checkbox" id="darg"/>ARG  <input type="checkbox" id="dksst"/>KSST  <input type="checkbox" id="dmpi"/>MPI <input type="checkbox" id="ppban"/>PPBAN</td>  
       </tr><br />&nbsp;
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruout1()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanout()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapusout()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
  
</div>

<div id="dialog-modal4" title="INPUT/EDIT INDIKATOR KINERJA KEGIATAN(IKK)">
    <p class="validateTips"></p> 
   
     <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Nomor</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="noikk" name="noikk" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Nama Indikator</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nmikk" name="nmikk" style="width:770px;" /></td>  
        </tr> 
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Target </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3">
       2016 &nbsp;<input id="volikk1" name="volikk1" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volikk2');"/>
       2017 &nbsp;<input id="volikk2" name="volikk2" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volikk3');"/>
       2018 &nbsp;<input id="volikk3" name="volikk3" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volikk4');"/>
       2019 &nbsp;<input id="volikk4" name="volikk4" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'volikk1');"/></td>
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Satuan</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="sat" name="sat" style="width:140px;" />  
       </td>
       </tr>
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikk()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanikk()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapusikk()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
  
</div>
<div id="dialog-modal5" title="KOMPONEN">
    <p class="validateTips"></p> 
        <!--<table id="dg8" title="Komponen Renstra " style="width:870px;height:200px;" >          
       </table> <br />-->
     <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Urut</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="kdkmpnen" name="kdkmpnen" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Komponen</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nmkmpnen" name="nmkmpnen" style="width:770px;" /></td>  
        </tr> 
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Jenis</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="jns" name="jns" style="width:70px;" readonly="true"/></td>   
       </tr>
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barukmp()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpankmp()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapuskmp()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
  
</div>

<!--<div id="dialog-modal6" title="INPUT/EDIT LOKASI">
    <p class="validateTips"></p> 
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="6" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="6" style="border-bottom-style:hidden;" align="center"><b><span style="color:#3366FF">Rencana 2016(Juta Rupiah)</span></b></td>
       </tr>
       
       
       </table>  
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Provinsi<input id="prop" name="prop" style="width:60px;" /><input id="nmprop" name="nmprop" style="width:200px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Kab/Kota<input id="kab" name="kab" style="width:60px;" /><input id="nmkab" name="nmkab" style="width:200px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-left-style:hidden;">Kewenangan<input id="kdkewe" name="kdkewe" style="width:60px;" /><input id="nmkewe" name="nmkewe" style="width:200px;" /></td>
      

      
      
       </table>
       
       
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="6" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Volume&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="volu" name="volu" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Rupiah&nbsp;&nbsp;&nbsp;<input id="rupiah" name="rupiah" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">PNBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="pnbp" name="pnbp" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden" >BLU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="blu" name="blu" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
      <!-- <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">SDI/PSO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="sdi" name="sdi" style="width:100px;" /></td>-->
       <!--<td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden" >SBSN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="sbsn" name="sbsn" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))" /> </td> 

       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Sumber&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="sumber" name="sumber" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >NPPHLN&nbsp;<input id="npphln" name="npphln" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Jenis PHLN&nbsp;<input id="jeni" name="jeni" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Pagu PHLN&nbsp;<input id="pagu" name="pagu" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Penyerapan&nbsp;<input id="serap" name="serap" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Tgl Mulai&nbsp;&nbsp;<input id="tglm" name="tglm" style="width:100px;" /> </td> 

       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Tgl Tutup&nbsp;&nbsp;<input id="tglt" name="tglt" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >PLN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="pln" name="pln" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">PDN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="pdn" name="pdn" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Hibah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="hibah" name="hibah" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Pend&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="pend" name="pend" style="width:100px;text-align:right;" onkeypress="return(currencyFormat(this,',','.',event))"/></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" > </td> 

       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <!--<tr style="border-bottom-style:hidden;">
       <!--<td colspan="3" style="border-bottom-style:hidden;" align="center"><b><span style="color:#cc0000">Prakiraan Maju(Juta Rupiah)</span></b></td>
       </tr>
       
       
       </table>
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Volume 2017&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Volume 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="kab" name="kab" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-left-style:hidden;">Volume 2019&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Alokasi 2017&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Alokasi 2018&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="kab" name="kab" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-left-style:hidden;">Alokasi 2019&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       </tr>
       
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="3" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" style="border-bottom-style:hidden;"></td>
       </tr>-->
       
       <!--<tr style="border-bottom-style:hidden;">
       <td colspan="3" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barulok()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanlok()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapuslok()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="3" style="border-bottom-color:black;height:1px;">
       </tr>
       
       </table>
       
</div>-->

<div id="dialog-modal6" title="INPUT/EDIT LOKASI">
    <p class="validateTips"></p> 
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="8" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="8" style="border-bottom-style:hidden;" align="center"><b><span style="color:#3366FF">Rencana 2016(Dalam Juta Rupiah)</span></b></td>
       </tr>
       
       
       </table>  
      
       
       
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="8" style="border-bottom-style:hidden;"></td>
       </tr>
        <tr>
       <td colspan="2"  align="center"><b><span style="color:#3366FF">Kelompok Lokasi</span></b></td>
       <td colspan="2"  align="center"><b><span style="color:#3366FF">Kelompok Rupiah</span></b></td>
       <td colspan="4"  align="center"><b><span style="color:#3366FF">Kelompok PHLN</span></b></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2" >1. Provinsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="prop" name="prop" style="width:50px;" /><input id="nmprop" name="nmprop"  /></td>
       <td colspan="2" >5. Rupiah&nbsp;:<input id="rupiah" name="rupiah" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'pnbp');" /></td>
       <td colspan="2" >9. Sumber&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="sumber" name="sumber" style="width:100px;" /><button id="smbr" onclick="javascript:barusumber()">...</button></td>
       <td colspan="2" >16. PLN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="pln" name="pln" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'pdn');"/></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2">2. Kab/Kota&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="kab" name="kab" style="width:50px;" /><input id="nmkab" name="nmkab"  /></td>
       <td colspan="2">6. PNBP&nbsp;&nbsp;&nbsp;:<input id="pnbp" name="pnbp" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'blu');" /></td>
       <td colspan="2">10. NPPHLN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="npphln" name="npphln" style="width:100px;" /><button id="npph" onclick="javascript:barunpphln()">...</button></td>
       <td colspan="2">17. PDN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="pdn" name="pdn" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'hibah');"/></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2">3. Kewenangan&nbsp;:<input id="kdkewe" name="kdkewe" style="width:50px;" /><input id="nmkewe" name="nmkewe"  /></td>
       <td colspan="2">7. BLU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="blu" name="blu" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'sbsn');" /></td>
       <td colspan="2">11. Jenis PHLN&nbsp;&nbsp;:<input id="jeni" name="jeni" style="width:100px;" /></td>
       <td colspan="2">18. Hibah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="hibah" name="hibah" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'pend');"/></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2">4. Volume&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="volu" name="volu" style="width:100px;" onkeypress="javascript:enter(event.keyCode,'rupiah');"/></td>
       <td colspan="2">8. SBSN&nbsp;&nbsp;&nbsp;:<input id="sbsn" name="sbsn" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="."  onkeypress="javascript:enter(event.keyCode,'pagu');"/></td>
       <td colspan="2">12. Pagu PHLN&nbsp;&nbsp;:<input id="pagu" name="pagu" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'serap');"/></td>
       <td colspan="2">19. Pendamping:<input id="pend" name="pend" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." /></td>
      </tr>
      <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2"></td>
       <td colspan="2"></td>
       <td colspan="2">13. Penyerapan:<input id="serap" name="serap" style="width:150px;text-align:right;" class="easyui-numberbox" data-options="min:0,precision:1" groupSeparator="," decimalSeparator="." onkeypress="javascript:enter(event.keyCode,'pln');"/></td>
       <td colspan="2"></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2"></td>
       <td colspan="2"></td>
       <td colspan="2">14. Tgl Mulai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="tglm" name="tglm" style="width:100px;" /></td>
       <td colspan="2"></td>
      </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td colspan="2"></td>
       <td colspan="2"></td>
       <td colspan="2">15. Tgl Tutup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input id="tglt" name="tglt" style="width:100px;" /></td>
       <td colspan="2"></td>
      </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
       
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" style="border-bottom-style:hidden;"></td>
       </tr>
       
     
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barulok()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanlok()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapuslok()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="3" style="border-bottom-color:black;height:1px;">
       </tr>
       
       </table>
       
</div>

<div id="dialog-modal7" title="Sumber">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:300px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="2" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" ><input id="kds" name="kds" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;" ><input id="nms" name="nms" style="width:150px;" /></td>  
       </tr> 
      
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="2" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barusumber()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpansumber()">Simpan</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali_lokasi()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="2" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>
<div id="dialog-modal8" title="NPPHLN">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:300px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="2" style="border-bottom-style:hidden;"></td>
       </tr>
        <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Sumber</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" ><input id="kdsu" name="kdsu" style="width:100px;" />  
       </td>
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" ><input id="kdn" name="kdn" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;" ><input id="nmn" name="nmn" style="width:150px;" /></td>  
       </tr> 
      
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="2" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barunpphln()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpannpphln()">Simpan</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali_lokasi()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="2" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>	
</body>

</html>