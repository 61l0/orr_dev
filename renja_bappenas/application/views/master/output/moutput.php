<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>   
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
    
    <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  
  <script type="text/javascript">
    
    //var kode = '';
//    var giat = '';
//    var nomor= '';
    var judul= '';
    var cid = 0;
    var lcidx = 0;
    var lcstatus = '';
                    
     $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 450,
            width: 650,
            modal: true,
            autoOpen:false
        });
        get_skpd();
        });    
     
     $(function(){  
        
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_output',
        idField:'id',            
        rownumbers:"true", 
        fitColumns:"true",
        singleSelect:"true",
        autoRowHeight:"false",
        loadMsg:"Tunggu Sebentar....!!",
        pagination:"true",
        nowrap:"true",                       
        columns:[[
            {field:'kd_output',
    		title:'Kode Output',
    		width:10,
            align:"center"},
            {field:'kd_kegiatan',
    		title:'Kode Kegiatan',
    		width:10,
            align:"center"},
    	    {field:'kd_program',
    		title:'Kode program',
    		width:10,
            align:"center"},
            {field:'nm_output',
    		title:'Nama Output',
    		width:60},
            {field:'satuan',
    		title:'Satuan',
    		width:10}
        ]],
        onSelect:function(rowIndex,rowData){
          kd_o = rowData.kd_output;  
          kd_k = rowData.kd_kegiatan;
          kd_p = rowData.kd_program;
          nm_o = rowData.nm_output;
          sat = rowData.satuan;//
//          get(kd_o,kd_k,kd_p,nm_o,sat); 
//          alert(kd_o+'/'+kd_k+'/'+kd_p+'/'+nm_o+'/'+sat);
          lcidx = rowIndex;  
                                       
        },
        onDblClickRow:function(rowIndex,rowData){
            
           lcidx = rowIndex;
           judul = 'Edit Data '; 
           edit_data(); 
           get(kd_o,kd_k,kd_p,nm_o,sat);   
        }
        
        });
       
    }); 
   
   
    function get_skpd()
        {
        	$.ajax({
        		url:'<?php echo base_url(); ?>index.php/rka/config_skpd',
        		type: "POST",
        		dataType:"json",                         
        		success:function(data){
        								$("#sskpd").attr("value",data.kd_skpd);
        								$("#nmskpd").attr("value",data.nm_skpd.toUpperCase());
        								kdskpd = data.kd_skpd;
                                        validate_prog();
        							  }                                     
        	});
        }
    
    function validate_prog(){
        $('#kode_p').combogrid({  
       panelWidth:500,  
       idField:'kd_program',  
       textField:'kd_program',  
       mode:'remote',
       url:'<?php echo base_url(); ?>index.php/master/ambil_program',  
       columns:[[  
           {field:'kd_program',title:'Kode Program',width:100},  
           {field:'nm_program',title:'Nama Program',width:400}    
       ]],  
       onSelect:function(rowIndex,rowData){
           kd_prog = rowData.kd_program;
           $("#nm_u").attr("value",rowData.nm_program.toUpperCase());
           validate_giat();  
           
                          
       }  
     });     
    } 
    
    function validate_giat(){
        //alert(kdskpd+"/"+kd_prog)
	  	    $(function(){
            $('#kode').combogrid({  
            panelWidth : 700,  
            idField    : 'kdgiat',  
            textField  : 'kdgiat',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/rka/pgiat/'+kdskpd+'/'+kd_prog,  
            columns    : [[  
                {field:'kdgiat',title:'Kode Giat',width:70},  
                {field:'nmgiat',title:'Nama Giat',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kegiatan = rowData.kdprogram;
                $("#nmgiat").attr("value",rowData.nmgiat.toUpperCase());
            }
            }); 
            });
		}
    
    function get(kd_o,kd_k,kd_p,nm_o,sat) {
        $("#kd").attr("value",kd_o);
        $("#kode").attr("value",kd_k);
        $("#kode_p").combogrid("setValue",kd_p);
        $("#nama").attr("value",nm_o);     
        $("#satuan").attr("value",sat);               
    }
       
    function kosong(){
        $("#kd").attr("value",'');
        $("#kode").attr("value",'');
        $("#kode_p").combogrid("setValue",'');
        $("#nama").attr("value",'');     
        $("#satuan").attr("value",'');  
    }
    
    function muncul(){
        var c_prog=kd_prog+'.';
        var c_keg=kd_k
        if(lcstatus=='tambah'){ 
            $("#kode").attr("value",c_prog);
        } else {
        $("#kode").attr("value",c_keg);
        }     
    }
    
    
    function cari(){
    var kriteria = document.getElementById("txtcari").value; 
    $(function(){ 
     $('#dg').edatagrid({
		url: '<?php echo base_url(); ?>/index.php/master/load_output',
        queryParams:({cari:kriteria})
        });        
     });
    }
    
       function simpan_skpd(){
        var cdept = document.getElementById('sskpd').value;
        var ckd = document.getElementById('kd').value;
        var ckode = $('#kode').combogrid('getValue');
        var ckode_p= $('#kode_p').combogrid('getValue');
        var cnama = document.getElementById('nama').value;
        var cnmgiat = document.getElementById('nmgiat').value;
        var cnmprog= document.getElementById('nm_u').value;
        var csat = document.getElementById('satuan').value;
                
        if (ckode==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (ckode_p==''){
            alert('Kode  Tidak Boleh Kosong');
            exit();
        } 
        if (cnama==''){
            alert('Nama Golongan Tidak Boleh Kosong');
            exit();
        }

        
        if(lcstatus=='tambah'){ 
            
            lcinsert = "(kddept,kdprogram,nmprogram,kdgiat,nmgiat,kdnewoutput,kdoutput,nmoutput,sat,satlama,pagu,ket)";
            lcvalues = "('"+cdept+"','"+ckode_p+"','"+cnmprog+"','"+ckode+"','"+cnmgiat+"','"+ckd+"','','"+cnama+"','"+csat+"','',0,'4')";
            
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/master/simpan_master2',
                    data: ({tabel:'t_new_output',kolom:lcinsert,nilai:lcvalues,cid:'kdgiat',lcid:ckode,cido:'kdnewoutput',lcido:ckd}),
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
            
            lcquery = "UPDATE t_new_output SET nmoutput='"+cnama+"',sat='"+csat+"'where kdprogram='"+ckode_p+"' and kdgiat='"+ckode+"' and kdnewoutput='"+ckd+"'";

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
        
        
       
        $("#dialog-modal").dialog('close');
        $('#dg').edatagrid('reload'); 

    } 
    
      function edit_data(){
        lcstatus = 'edit';
        judul = 'Edit Data output';
        $("#dialog-modal").dialog({ title: judul });
        $("#dialog-modal").dialog('open');
        }    
        
    
     function tambah(){
        lcstatus = 'tambah';
        judul = 'Input Data Output';
        $("#dialog-modal").dialog({ title: judul });
        kosong();
        $("#dialog-modal").dialog('open');
        document.getElementById("kd").disabled=false;
        document.getElementById("kd").focus();
        } 
     function keluar(){
        $("#dialog-modal").dialog('close');
        lcstatus = 'edit';
     }    
    
     function hapus(){
        var ckode = document.getElementById('kode').value;
        
        var urll = '<?php echo base_url(); ?>index.php/master/hapus_master';
        $(document).ready(function(){
         $.post(urll,({tabel:'t_giat',cnid:ckode,cid:'kdgiat'}),function(data){
            status = data;
            if (status=='0'){
                alert('Gagal Hapus..!!');
                exit();
            } else {
                $('#dg').datagrid('deleteRow',lcidx);   
                alert('Data Berhasil Dihapus..!!');
                exit();
            }
         });
        });    
    } 
    
       
    
  
    
  
   </script>

</head>
<body>

<div id="content"> 
<h3 align="center"><u><b><a>INPUTAN MASTER OUTPUT</a></b></u></h3>
    <div align="center">
    <p align="center">     
    <table style="width:400px;" border="0">
        <tr>
        <td width="10%">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah()">Tambah</a></td>               
        
        <td width="5%"><a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a></td>
        <td><input type="text" value="" id="txtcari" style="width:300px;"/></td>
        </tr>
        <tr>
        <td colspan="4">
        
        
        <table id="dg" title="LISTING DATA KEGIATAN" style="width:900px;height:440px;" >  
        </table>
        </td>
        </tr>
       
    </table> 
        
 
    </p> 
    </div>   
</div>

<div id="dialog-modal" title="">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p> 
    <fieldset>
     <table align="center" style="width:100%;" border="0">
            <tr>
                <td width="30%">KEMENTERIAN/LEMBAGA</td>
                <td width="1%">:</td>
                <td><input id="sskpd" name="sskpd" readonly="true" style="width:55px;border: 0;" />
                <input id="nmskpd" name="nmskpd" readonly="true" style="width: 300px; border:0;  " /></td>  
            </tr> 
            <tr>
                <td width="30%">KODE PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode_p" style="width:50px;"/></td>  
            </tr>
            <tr>
                <td width="30%">NAMA PROGRAM</td>
                <td width="1%">:</td>
                <td><input type="text" id="nm_u" style="width:350px;"/></td>  
            </tr> 
           <tr>
                <td width="30%">KODE KEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="kode" style="width:50px;"/></td>  
            </tr>
             <tr>
                <td width="30%">NAMA KEGIATAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="nmgiat" style="width:350px;"/></td>  
            </tr> 
            <tr>
                <td width="30%">KODE OUTPUT</td>
                <td width="1%">:</td>
                <td><input type="text" id="kd" style="width:20px;" maxlength="2"/></td>  
            </tr>           
            <tr>
                <td width="30%">NAMA OUTPUT</td>
                <td width="1%">:</td>
                <td><textarea name="nama" id="nama" cols="50" rows="1" ></textarea></td>  
            </tr>
            <tr>
                <td width="30%">SATUAN</td>
                <td width="1%">:</td>
                <td><input type="text" id="satuan" style="width:130px;"/></td>  
            </tr> 
            
            <tr>
            <td colspan="3">&nbsp;</td>
            </tr>            
            <tr>
                <td colspan="3" align="center"><a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_skpd();">Simpan</a>
		        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();">Hapus</a>
                <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Kembali</a>
                </td>                
            </tr>
        </table>       
    </fieldset>
</div>

</body>

</html>