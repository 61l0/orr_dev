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
     var msskl='01';
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
                height: 270,
                width: 900,
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
                                        grid_output();
                                        grid_ikks()
                                        grid_visi();
                                        grid_misi();
        							  }                                     
        	});
        }
    
   
    function grid_visi(){
           var mskpd = document.getElementById('sskpd').value; 
	       $('#dg').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_visi/'+mskpd,
                 idField      : 'id',             
                 rownumbers   : "true", 
                 fitColumns   : "true",
                 singleSelect : "true",
				 columns:[[
					{field:'kdvisi',
					 title:'<b><span style="color:#3366FF">Kode</span></b>',
					 width:5,
					 align:'left'	
					},
					{field:'nmvisi',
					 title:'<b><span style="color:#3366FF">Uraian Visi K/L</span></b>',
					 width:95
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              novisi  = rowData.kdvisi;
                              nmvisi  = rowData.nmvisi;
                              
                              $("#novisi").attr("value",novisi);
                              $("#nmvisi").attr("value",nmvisi);
                              lcstatus = 'edit'; 
                              
		          },
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal").dialog('open');
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
					 title:'<b><span style="color:#3366FF">Kode</span></b>',
					 width:5,
					 align:'left'	
					},
					{field:'nmmisi',
					 title:'<b><span style="color:#3366FF">Uraian Misi K/L</span></b>',
					 width:95
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              kdmisi  = rowData.kdmisi;
                              nmmisi  = rowData.nmmisi;
                              
                              $("#kdmisi").attr("value",kdmisi);
                              $("#nmmisi").attr("value",nmmisi);
                              lcstatus = 'edit'; 
                              
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
					 title:'<b><span style="color:#3366FF">Kode</span></b>',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'<b><span style="color:#3366FF">Uraian Sasaran Strategis K/L</span></b>',
					 width:90
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              no  = rowData.nomor;
                              nm  = rowData.nama;
                            
                              
                              $("#nomer").attr("value",no);
                              $("#nama").attr("value",nm);
                             
                              lcstatus = 'edit'; 
                              grid_ikks();
                              
		          },
                  
                    onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal2").dialog('open');
        }
			});
    } 
    
    function grid_ikks(){
        //alert('jaka');
           var mskpd = document.getElementById('sskpd').value;
           var msskl  = document.getElementById('nomer').value;
          // alert(mskpd+'/'+msskl)
	       $('#dg3').edatagrid({
				url           : '<?php echo base_url(); ?>/index.php/master/select_indikatorkl/'+mskpd+'/'+msskl,
                 idField      : 'id',
                 toolbar      : "#toolbar3",              
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
					 title:'<b><span style="color:#3366FF">Kode</span></b>',
					 width:5,
					 align:'left'	
					},
					{field:'nama',
					 title:'<b><span style="color:#3366FF">Uraian Indikator Kinerja Sasaran Strategis (IKSS)</span></b>',
					 width:50
					},
                    {field:'vol1',
					 title:'<b><span style="color:#3366FF">Target 2016</span></b>',
					 width:10
					},
                    {field:'vol2',
					 title:'<b><span style="color:#3366FF">Target 2017</span></b>',
					 width:10
					},
                    {field:'vol3',
					 title:'<b><span style="color:#3366FF">Target 2018</span></b>',
					 width:10
					},
                    {field:'vol4',
					 title:'<b><span style="color:#3366FF">Target 2019</span></b>',
					 width:10
					},
                    {field:'satuan',
					 title:'<b><span style="color:#3366FF">Satuan</span></b>',
					 width:5
					}
                  
				]],
                 onSelect:function(rowIndex,rowData){						
                              no  = rowData.nomor;
                              nm  = rowData.nama;
                              vol1 = rowData.vol1;
                              vol2 = rowData.vol2;
                              vol3 = rowData.vol3;
                              vol4 = rowData.vol4;
                              vol5 = rowData.vol5;
                              satuan = rowData.satuan;
                              $("#nomers").attr("value",no);
                              $("#namas").attr("value",nm);
                              $("#vol1").attr("value",vol1);
                              $("#vol2").attr("value",vol2);
                              $("#vol3").attr("value",vol3);
                              $("#vol4").attr("value",vol4);
                              $("#vol5").attr("value",vol5);
                              $("#sat").attr("value",satuan);
                              lcstatus = 'edit'; 
                              
		          },
                  onDblClickRow:function(rowIndex,rowData){
                       $("#dialog-modal3").dialog('open');
                }
			});
    } 
    
    function barumisi(){
        
        $("#kdmisi").attr("value",'');
        $("#nmmisi").attr("value",'');
        
        document.getElementById('kdmisi').focus();
         $("#dialog-modal1").dialog('open');
        lcstatus = 'tambah';
    } 
    
    function baru(){
        
        $("#nama").attr("value",'');
        $("#nomer").attr("value",'');
        
        document.getElementById('nomer').focus();
         $("#dialog-modal2").dialog('open');
        lcstatus = 'tambah';
    }
     function baruikss(){
        
        $("#namas").attr("value",'');
        $("#nomers").attr("value",'');
        $("#vol1").attr("value",'');
        $("#vol2").attr("value",'');
        $("#vol3").attr("value",'');
        $("#vol4").attr("value",'');
        $("#vol5").attr("value",'');
        $("#sat").attr("value",'');
        document.getElementById('nomers').focus();
         $("#dialog-modal3").dialog('open');
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
    
    function simpanikss(){
           var mskpd = document.getElementById('sskpd').value;
           var msas  = document.getElementById('nomer').value;         
           var cnoikks = document.getElementById('nomers').value;           
           var cnmikks = document.getElementById('namas').value;
           var cvol1 = document.getElementById('vol1').value;
           var cvol2 = document.getElementById('vol2').value;
           var cvol3 = document.getElementById('vol3').value;
           var cvol4 = document.getElementById('vol4').value;
           var cvol5 = document.getElementById('vol5').value;
           var csat = document.getElementById('sat').value;
          //alert(mskpd+"/"+cnoikks+"/"+msas);
          
           if (msas==''){
            alert('nomor Sasaran diisi Dahulu');
            exit();
            } 
            
          if(lcstatus=='tambah'){ 
             
            lcinsert = "(kddept,nomor_sasarankl,nomor,nama,vol,vol1,vol2,vol3,vol4,satuan)";
            lcvalues = "('"+mskpd+"','"+msas+"','"+cnoikks+"','"+cnmikks+"','"+cvol1+"','"+cvol2+"','"+cvol3+"','"+cvol4+"','"+cvol5+"','"+csat+"')";
            //alert(lcinsert+"/"+lcvalues)
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'d_indikatorkl',kolom:lcinsert,nilai:lcvalues,cid:'nomor_sasarankl',lcid:msas,cido:'nomor',lcido:cnoikks}),
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
            
            lcquery = "UPDATE d_indikatorkl SET nama='"+cnmikks+"',vol='"+cvol1+"',vol1='"+cvol2+"',vol2='"+cvol3+"',vol3='"+cvol4+"',vol4='"+cvol5+"',satuan='"+csat+"' where nomor='"+cnoikks+"' and nomor_sasarankl='"+msas+"'";

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
        grid_ikks();
    }
   function hapusikks(){
        var msas  = document.getElementById('nomer').value;
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master1';
        var cnoikss = document.getElementById('nomers').value;
        var tny = confirm('Yakin Ingin Menghapus Data, Indikator Sasaran Strategis Kode: '+msas+' ,kode Sasaran Strategis K/L : '+cnoikss);
       
        if (tny==true){
            $(document).ready(function(){
            $.ajax({url:urll,
                     dataType:'json',
                     type: "POST",    
                     data:({tabel:'d_indikatorkl',kd1:'nomor_sasarankl',prog:msas,kd2:'nomor',nomor:cnoikss}),
                     success:function(data){
                            status = data.pesan;
                            if (status=='1'){
                                alert('Data Berhasil Terhapus');         
                            } else {
                                alert('Gagal Hapus');
                            }        
                     }
                     
                    });           
            });
           grid_ikks();
        } 
        
    }
   function hapusmisi(){
        var ckode = document.getElementById('kdmisi').value;
        var mskpd = document.getElementById('sskpd').value;
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master1';
        var tny = confirm('Yakin Ingin Menghapus Misi, kode : '+ckode );
        
        if (tny==true){
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
    }
    
   function hapus(){
        var ckode = document.getElementById('nomer').value;
        var mskpd = document.getElementById('sskpd').value;
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master1';
        var tny = confirm('Yakin Ingin Menghapus Sasaran Trategis K/L, kode : '+ckode );
        
        if (tny==true){
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
    
    function nextvisi(){
        
            $("#section1").click();
        
     }
     function nextsasaran(){
        
            $("#section2").click();
        
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
   
   </table>

<div id="accordion">



<h3><a href="#" id="section1" onclick="javascript:grid_visi()"> </a></h3>
   
   <div  style="height:400px;">      
   
       
       <table id="dg" title="VISI " style="width:1170px;height:150px;" >          
       </table><br />
       <table id="dg1" title="MISI" style="width:1170px;height:250px;" >          
       </table> <br/>  <button id="next1" class="easyui-linkbutton"  onclick="javascript:nextsasaran()">Sasaran Strategis K/L >></a></button>
       <div id="toolbar1">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:barumisi();">Tambah</a>   		
        </div> 
        
    </div>

<h3><a href="#" id="section2" onclick="javascript:grid_output()"></a></h3>
   
   <div  style="height:400px;">  
       
       <table id="dg2" title="Sasaran Strategis K/L " style="width:1170px;height:200px;" >          
       </table> <br />
        <div id="toolbar">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baru();">Tambah</a>  		
        </div>
        
        <table id="dg3" title="Indikator Kinerja Sasaran Strategis" style="width:1170px;height:200px;" >          
       </table> <br/>  <button id="next1" class="easyui-linkbutton"  onclick="javascript:nextvisi()"><< Visi/Misi</a></button>
        <div id="toolbar3">
    		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikss();">Tambah</a>  		
        </div>
    </div>


</div>

</div>  
<div id="dialog-modal" title="VISI">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:1070px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="novisi" name="novisi" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Visi K/L</td>
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

<div id="dialog-modal1" title="MISI">
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
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Misi K/L</td>
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

<div id="dialog-modal2" title="INPUT/EDIT SASARAN STRATEGIS K/L">
    <p class="validateTips"></p> 
   
      <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="nomer" name="nomer" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian Sasaran Strategis K/L</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="nama" name="nama" style="width:770px;" /></td>  
        </tr> 
       
      <!-- <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Pelaksana</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="pelaksana" name="pelaksana" style="width:770px;" /></td>  
        </tr> -->
       
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

<div id="dialog-modal3" title="Indikator Kinerja Sasaran Strategis K/L (IKSS)">
    <p class="validateTips"></p> 
   
       <table border='1'  style="border-spacing:0px;padding:0px 0px 0px 0px;border-collapse:collapse;width:880px;border-style: ridge;" >
       
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" style="border-bottom-style:hidden;"></td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Kode</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="nomers" name="nomers" style="width:30px;" />  
       </td>
       </tr>
       
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Uraian IKSS</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"><input id="namas" name="namas" style="width:770px;" /></td>  
        </tr> 
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Target </td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;" colspan="3"> 
       <input type="hidden" id="vol1" name="vol1" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol2');"/>
       2016 &nbsp;<input id="vol2" name="vol2" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol3');"/>
       2017 &nbsp;<input id="vol3" name="vol2" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol4');"/>
       2018 &nbsp;<input id="vol4" name="vol4" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol5');"/>
       2019 &nbsp;<input id="vol5" name="vol4" style="width:100px;text-align:right;" onkeypress="javascript:enter(event.keyCode,'vol1');"/></td>
       </tr>
       <tr style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;border-bottom-style:hidden;">
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:170px;border-bottom-style:hidden;border-right-style:hidden;">Satuan</td>
       <td style="border-spacing:3px;padding:3px 3px 3px 3px;border-collapse:collapse;width:770px;border-bottom-style:hidden;" colspan="3"><input id="sat" name="sat" style="width:140px;" />  
       </td>
       </tr>
       <tr style="border-bottom-style:hidden;">
       <td colspan="5" align="center" style="border-bottom-style:hidden;">
       <button id="input" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:baruikss()">Baru</button>
       <button id="add" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpanikss()">Simpan</button>
       <button id="del" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapusikks()">Hapus</button>
       <button id="back" class="easyui-linkbutton"  iconCls="icon-back" plain="true" onclick="javascript:kembali()">Kembali</button>
       
       </td>
       </tr>
       <tr style="border-bottom-color:black;height:1px;" >
       <td colspan="5" style="border-bottom-color:black;height:1px;"></td>
       </tr>
       </table>
  
</div>
	
</body>

</html>