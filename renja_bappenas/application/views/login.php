  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
	<script type="text/javascript">
    
 $(document).ready(function() {
            $("#accordion").accordion();            
            $( "#dialog-modal" ).dialog({
            height: 350,
            width: 600,
            modal: true,
            autoOpen:false
        });
        validate_dept();
        //validate_unit();
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
                                      }                                     
            });
        }

        function validate_dept(){
            $(function(){
            $('#sskpd').combogrid({  
            panelWidth : 700,  
            idField    : 'kddept',  
            textField  : 'kddept',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/config_dept1',  
            columns    : [[  
                {field:'kddept',title:'Kode',width:50},  
                {field:'nmdept',title:'Nama ',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdskpd = rowData.kddept;
                $("#nmskpd").attr("value",rowData.nmdept.toUpperCase());
                validate_unit();                
            }
            }); 
            });
        }

         function validate_unit(){
            $(function(){
            $('#sskpdun').combogrid({  
            panelWidth : 700,  
            idField    : 'kdunit',  
            textField  : 'kdunit',  
            mode       : 'remote',
            url        : '<?php echo base_url(); ?>index.php/master/config_unit1/'+kdskpd,  
            columns    : [[  
                {field:'kdunit',title:'Kode',width:50},  
                {field:'nmunit',title:'Nama ',width:680}    
            ]],
            onSelect:function(rowIndex,rowData){
                kdunit = rowData.kdunit;
                $("#nmunit").attr("value",rowData.nmunit.toUpperCase());
                //skpd_1(kdskpd,kdunit);
            }
            }); 
            });
        }

        /*function skpd_1(kdskpd,kdunit){
            var tskpd = kdskpd;
            var tkdunit = kdunit;
            location.replace= '<?php echo base_url(); ?>index.php/home/panggil/'+tskpd+'/'+tkdunit;          
        }*/

    </script>



<div id="content">
<?php ini_set('memory_limit',"-1"); ?>
<?php $att=array('autocomplete'=>'off');?>
<?php echo form_open('',$att)?>
<?php echo isset($pesan) ? $pesan : ''?>
<table cellpadding="2px" 
cellspacing="1px" bgcolor="#F4F5F7" width="550px" class="tableBorder" align="center">
     <tr>
        <td colspan="3" bgcolor="#0066FF">&nbsp;</td>
    </tr>
    
     <tr>
        <td align="center" colspan="3">
            <img src=" <?php echo base_url();?>image/gembok.png" border="0" align="absbottom"/>&nbsp;
            <span class="message">Silahkan Login Dahulu  </span>        </td>
    </tr>
    <tr>
        <td colspan="3" class="label">&nbsp;</td>
    </tr>

<!-- <tr>
<td class="label" align="right" >Username</td>
<td>
:</td>
<td><?php echo form_input('Username')?></td>
</tr>
 -->

<tr>
                <td width="30%"><span style="colour:blue">KEMENTERIAN/LEMBAGA</span></td>
                <td width="1%">:</td>
                <td><input type="ket" id="sskpd" name="sskpd" style="width:60px;"/> 
                <input id="nmskpd" name="nmskpd" style="width:270px;"  /></td>  
                
</tr> 
<tr>
                <td width="30%"><span style="colour:blue">UNIT</span></td>
                <td width="1%">:</td>
                <td><input type="unit" id="sskpdun" name="sskpdun" style="width:60px;"/> 
                <input id="nmunit" name="nmskpdun" style="width:270px;"  /></td>  
                
</tr> 


<!-- <tr>
 <td class="label" align="right">Password</td><td>
:
</td><td>
<?php echo form_password('password')?>
</td>
</tr>
 -->
<tr>
    <td class="label" align="right" >Tahun Anggaran</td>
    <td>
    :</td>
    <td>
    
    
    <?php $thang =  date("Y")+1; 
        $thang_maks = $thang + 5 ;
        $thang_min = $thang - 5 ;
        echo '<select name ="pcthang">';
        
        for ($th=$thang_min ; $th<=$thang_maks ; $th++)
        {
            if ($th==$thang) {
                echo "<option selected value=$th>$thang</option>";
                }
            else {	
            echo "<option value=$th>$th</option>";
            }
        }
        echo '</select>';	
        
        
    ?>&nbsp;&nbsp;&nbsp;<?php echo form_submit('submit', 'Masuk')?>
    </td>
</tr>



</table>
<?php echo form_close()?>
</div>
