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
                height: 150,
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
                height: 600,
                width: 1200,
                modal: true,
                autoOpen:false                
            });
            get_skpd();
        });    
    
   
    
    
    
    
    
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
                                        get_prog();
                                        grid_output();
                                        grid_visi();
                                        grid_misi();
        							  }                                     
        	});
        }
    
    function get_prog()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/master/config_prog',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#kdprog").attr("value",data.kdprogram);
        								$("#nmprog").attr("value",data.nmprogram.toUpperCase());
        								program = data.kdprogram;
                                        validate_giat();
        							  }                                     
        	});
        }
    function validate_giat(){
	  	    $(function(){
            $('#kdgiat').combogrid({  
            panelWidth : 700,  
            idField    : 'kdgiat',  
            textField  : 'kdgiat',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/pgiat/'+kdskpd+'/'+program,  
            columns    : [[  
                {field:'kdgiat',title:'Kode Giat',width:70},  
                {field:'nmgiat',title:'Nama Giat',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kegiatan = rowData.kdgiat;
                $("#nmgiat").attr("value",rowData.nmgiat.toUpperCase());
                grid_output();
            }
            }); 
            });
		}
    function grid_visi(){
            var mskpd = document.getElementById('sskpd').value; 
	       $('#dg').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_sasaran_kl/'+mskpd,
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
					{field:'nomor',
					 title:'Urut',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'Uraian Sasaran Strategis Kegiatan',
					 width:90,
                     align:'left'	
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              no  = rowData.nomor;
                              nm  = rowData.nama;
                            
                              
                              $("#nomer").attr("value",no);
                              $("#nama").attr("value",nm);
                             
                              lcstatus = 'edit'; 
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal2").dialog('open');
        }
			});
    } 
    
    function grid_misi(){
           var mskpd = document.getElementById('sskpd').value; 
	       $('#dg1').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_misi/'+mskpd,
                 idField      : 'id',
                 toolbar      : "#toolbar1",              
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
					{field:'kdmisi',
					 title:'urut',
					 width:5,
					 align:'left'	
					},
					{field:'nmmisi',
					 title:'Uraian Output',
					 width:90
					},
                    {field:'lokasi',
            		title:'<b><span style="color:#3366FF">Lokasi</span></b>',
                    width:5,
                    align:"center",
                    align:"center",
                    formatter:function(value,rec){                                                                       
                        return '<img src="<?php echo base_url(); ?>/image/PLUS.bmp" onclick="javascript:muka();" />';                  
                        }                            
                    }
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              kdmisi  = rowData.kdmisi;
                              nmmisi  = rowData.nmmisi;
                              
                              $("#kdmisi").attr("value",kdmisi);
                              $("#nmmisi").attr("value",nmmisi);
                              lcstatus = 'edit'; 
                              grid_lokasi()
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal1").dialog('open');
        }
			});
    } 
    
    function grid_output(){
        //alert('jaka');
           var mskpd = document.getElementById('sskpd').value; 
	       $('#dg2').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_sasaran_kl/'+mskpd,
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
					{field:'nomor',
					 title:'urut',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'Uraian Indikator Kinerja Kegiatan (IKP)',
					 width:90
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              no  = rowData.nomor;
                              nm  = rowData.nama;
                            
                              
                              $("#novisi").attr("value",no);
                              $("#nmvisi").attr("value",nm);
                             
                              lcstatus = 'edit'; 
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal").dialog('open');
        }
			});
    } 
    
    function grid_lokasi(){
        //alert('jaka');
           var mskpd = document.getElementById('sskpd').value; 
	       $('#dg3').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/',
                 idField      : 'id',             
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
                    
	                
					{field:'prov',
					 title:'<b><span style="color:#3366FF">Prov</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'kab',
					 title:'<b><span style="color:#3366FF">Kab</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'vol15',
					 title:'<b><span style="color:#3366FF">Vol15</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'alokasi15',
					 title:'<b><span style="color:#3366FF">Alokasi 2015</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'vol16',
					 title:'<b><span style="color:#3366FF">Vol16</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'rupiah15',
					 title:'<b><span style="color:#3366FF">Rupiah 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'pnbp',
					 title:'<b><span style="color:#3366FF">PNBP 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'blu',
					 title:'<b><span style="color:#3366FF">BLU 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'pln',
					 title:'<b><span style="color:#3366FF">PLN 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'pdn',
					 title:'<b><span style="color:#3366FF">PDN 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'hibah',
					 title:'<b><span style="color:#3366FF">Hibah 2016</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'pend',
					 title:'<b><span style="color:#3366FF">Pendamping</span></b>',
					 width:10,
					 align:'left'	
					},
                    {field:'v2017',
					 title:'<b><span style="color:#3366FF">2017</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'v2018',
					 title:'<b><span style="color:#3366FF">2018</span></b>',
					 width:5,
					 align:'left'	
					},
                    {field:'v2019',
					 title:'<b><span style="color:#3366FF">2019</span></b>',
					 width:5,
					 align:'left'	
					}
                    
                  
				]]
			});
    } 
    
    function barumisi(){
        
        $("#kdmisi").attr("value",'');
        $("#nmmisi").attr("value",'');
        
        document.getElementById('kdmisi').focus();
         $("#dialog-modal1").dialog('open');
        lcstatus = 'tambah';
    } 
    function muka(){
         $("#dialog-modal3").dialog('open');
     }
    function baru(){
        
        $("#nama").attr("value",'');
        $("#nomer").attr("value",'');
        
        document.getElementById('nomer').focus();
         $("#dialog-modal2").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function simpanvisi(){
           var mskpd = document.getElementById('sskpd').value;           
           var cnovisi = document.getElementById('novisi').value;           
           var cnmvisi = document.getElementById('nmvisi').value;
           
          //alert(mskpd+"/"+cnovisi+"/"+cnmvisi);
          
           if (cnovisi==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdvisi,nmvisi)";
            lcvalues = "('"+mskpd+"','"+cnovisi+"','"+cnmvisi+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'t_visi',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cido:'kdvisi',lcido:cnovisi}),
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
            
            lcquery = "UPDATE t_visi SET nmvisi='"+cnmvisi+"' where kddept='"+mskpd+"' and kdvisi='"+cnovisi+"'";
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
        grid_visi();
    }
    
    function simpanmisi(){
           var mskpd = document.getElementById('sskpd').value;           
           var ckdmisi = document.getElementById('kdmisi').value;           
           var cnmmisi = document.getElementById('nmmisi').value;
           
          //alert(mskpd+"/"+cnovisi+"/"+cnmvisi);
          
           if (ckdmisi==''){
            alert('nomor  diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,kdmisi,nmmisi)";
            lcvalues = "('"+mskpd+"','"+ckdmisi+"','"+cnmmisi+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'t_misi',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cido:'kdmisi',lcido:ckdmisi}),
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
            
            lcquery = "UPDATE t_misi SET nmmisi='"+cnmmisi+"' where kddept='"+mskpd+"' and kdmisi='"+ckdmisi+"'";
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
        grid_misi();
    }
         
    function simpan(){
           var mskpd = document.getElementById('sskpd').value;           
           var cno = document.getElementById('nomer').value;           
           var cnama = document.getElementById('nama').value;
           
          //alert(mskpd+"/"+cno+"/"+cnama);
          
           if (cno==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,nomor,nama)";
            lcvalues = "('"+mskpd+"','"+cno+"','"+cnama+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'d_sasarankl',kolom:lcinsert,nilai:lcvalues,cid:'kddept',lcid:mskpd,cido:'nomor',lcido:cno}),
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
            
            lcquery = "UPDATE d_sasarankl SET nama='"+cnama+"' where nomor='"+cno+"'";

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
   
   function hapusmisi(){
        var ckode = document.getElementById('kdmisi').value;
        var mskpd = document.getElementById('sskpd').value;
        //alert(mskpd+"/"+ckode);
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master1';
        $(document).ready(function(){
         $.post(urll,({tabel:'t_misi',prog:mskpd,kd1:'kddept',nomor:ckode,kd2:'kdmisi'}),function(data){
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
        grid_misi();   
    }
    
   function hapus(){
        var ckode = document.getElementById('nomer').value;
        var mskpd = document.getElementById('sskpd').value;
        //alert(mskpd+"/"+ckode);
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master1';
        $(document).ready(function(){
         $.post(urll,({tabel:'d_sasarankl',prog:mskpd,kd1:'kddept',nomor:ckode,kd2:'nomor'}),function(data){
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
    
    function enter(ckey,_cid){
        if (ckey==13)
        	{  
        	   document.getElementById(_cid).focus();
                if(_cid=='vol1'){
                   simpan();
                   //grid_output();
                   }
               
        	}     
        }
    
    function kembali(){
      
             $("#dialog-modal").dialog('close');
             $("#dialog-modal1").dialog('close');
             $("#dialog-modal2").dialog('close');
             $("#dialog-modal3").dialog('close');
        
                
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
   <td>KEMENTERIAN/LEMBAGA :   &nbsp;&nbsp;<input id="sskpd" name="sskpd" readonly="true" style="width:55px;border: 0;" />
    <input id="nmskpd" name="nmskpd" readonly="true" style="width: 320px; border:0;  " /></td>
   </tr>
   <tr style="border-style:hidden;">
   <td>PROGRAM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input id="kdprog" name="kdprog" readonly="true" style="width:50px; border:0;"/>  
   &nbsp;&nbsp;&nbsp;<input id="nmprog" name="nmprog" readonly="true" style="width:680px;border:0;background-color:transparent;color: black;" disabled="true"/>
   </td>
   </tr>
    <tr style="border-style:hidden;">
   <td>KEGIATAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<input id="kdgiat" name="kdgiat" style="width:70px;" />  
   &nbsp;&nbsp;&nbsp;<input id="nmgiat" name="nmgiat" readonly="true" style="width:650px;border:0;background-color:transparent;color: black;" disabled="true"/>
   </td>
   </tr>
   </table>

<div id="accordion">



<h3><a href="#" id="section1" onclick="javascript:grid_visi()">Sasaran Kegiatan</a></h3>
   
   <div  style="height:700px;">      
   
       
       <table id="dg" title="Sasaran Kegiatan" style="width:1170px;height:250px;" >          
       </table>
        
    </div>
    


<h3><a href="#" id="section2" onclick="javascript:grid_misi()">OUTPUT </a></h3>
   
   <div  style="height:700px;">      
   
       <table id="dg1" title="Output" style="width:1170px;height:250px;" >          
       </table>
       <div id="toolbar1">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barumisi();">Tambah</a>   		
        </div> 
    </div>


<h3><a href="#" id="section3" onclick="javascript:grid_output()">Indikator Kinerja Kegiatan (IKK)</a></h3>
   
   <div  style="height:700px;">  
       
       <table id="dg2" title="Indikator Kinerja Kegiatan (IKK)" style="width:1170px;height:250px;" >          
       </table>
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baru();">Tambah</a>  		
        </div>
    </div>


</div>

</div>  
<div id="dialog-modal" title="Indikator Kinerja Kegiatan (IKK)">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1070px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">KODE </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="novisi" name="novisi" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Indikator Kinerja Kegiatan (IKK)</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nmvisi" name="nmvisi" style="width:870px;" /></td>  
        </tr> 
       
  
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
      
       
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanvisi()">simpan</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>

<div id="dialog-modal1" title="OUTPUT">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1070px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="kdmisi" name="kdmisi" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Output</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nmmisi" name="nmmisi" style="width:870px;" /></td>  
        </tr> 
    
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barumisi()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanmisi()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapusmisi()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>

<div id="dialog-modal2" title="INPUT/EDIT SASARAN KEGIATAN">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Nomor</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="nomer" name="nomer" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Nama Sasaran</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nama" name="nama" style="width:770px;" /></td>  
        </tr> 
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baru()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;">
       </tr>
       </table>
  
</div>

<div id="dialog-modal3" title="INPUT/EDIT LOKASI">
    <p class="validateTips"></p> 
       <table id="dg3" title="Lokasi" style="width:1170px;height:200px;" >          
       </table><br />  
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1170px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Provinsi<input id="prov" name="prov" style="width:30px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Kab/Kota<input id="kab" name="kab" style="width:30px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Volume 2015<input id="prov" name="prov" style="width:30px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Alokasi 2015<input id="prov" name="prov" style="width:30px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-left-style:hidden;">Kewenangan<input id="kab" name="kab" style="width:30px;" /></td>
      

      
      
       </table>
       
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
       <td colspan="6" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Volume&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Rupiah&nbsp;&nbsp;&nbsp;<input id="kab" name="kab" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">PNBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >BLU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">SDI/PSO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >SBSN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /> </td> 

       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Sumber&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >NPPHLN&nbsp;<input id="kab" name="kab" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Jenis Biaya&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Pagu&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Penyerapan&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Tgl Mulai&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /> </td> 

       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;">Tgl Tutup&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >PLN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="kab" name="kab" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">PDN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;" >Hibah&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:70px;border-bottom-style:hidden;border-right-style:hidden;border-left-style:hidden;">Pend&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="prov" name="prov" style="width:100px;" /></td>
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
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" style="border-bottom-style:hidden;" align="center"><b><span style="color:#cc0000">Prakiraan Maju(Juta Rupiah)</span></b></td>
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
       </tr>
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="3" align="center" style="border-bottom-style:hidden;">
      
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baru()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="3" style="border-bottom-color:black;height:1px;">
       </tr>
       
       </table>
       
</div>
	
</body>

</html>