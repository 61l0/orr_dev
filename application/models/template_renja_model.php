<?php
class template_renja_model extends CI_Model
 {
     function __construct(){
         parent::__construct();
     }
     
 
    function get_data($limit='',$offset=''){
     		$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and a.dari='".$dari."'";
     		} else {
     			$sql="";
     		}     
			$query=$this->db->query("select *,a.dari as daridirektorat,tahun_anggaran.tahun_anggaran as tahun_anggaran,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  ,
			(select nama_tahapan from tahapan_dokumen where id_dokumen=a.tahapan_dokumen) as tahapan_dokumen  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran 
			where 1=1 $sql order by a.id desc LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
    function count(){
			$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and template_renja.dari='".$dari."'";
     		} else {
     			$sql="";
     		}	
			$query=$this->db->query("select count(1) as jumlah from template_renja  
			left join t_user on t_user.id=template_renja.add_by 
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran 
			where 1=1 $sql");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function get_row($id=""){
		$query=$this->db->query("select * from data_template_renja where id='$id'");
		return $query->row();
	}
 	function get_url_file($id=""){
 		$query=$this->db->query("select a.url  from template_renja a where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->url;
				}
				return $menus;
			}
 	}
 	function get_file_name($id=""){
 		$query=$this->db->query("select a.nama_file  from template_renja a where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->nama_file;
				}
				return $menus;
			}
 	}
	function get_update($id=""){
		$query=$this->db->query("select *,a.dari as darisiapaya,m_unit_kerja.kd_unit_kerja,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan , 
			(select nama from t_user where t_user.unit=a.dari LIMIT 0,1) as nama_user  
			from template_renja a 
			left join m_unit_kerja on m_unit_kerja.id_divisi = a.dari
			where a.id='$id'");
 		return 	$query->row();
    }
    function cek_if_exist(){
    	$id=$this->input->post('id');		 
		$unit=$this->session->userdata('ID_DIREKTORAT'); 
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$query=$this->db->query("select count(1) as jumlah from template_renja where tahun_anggaran='$tahun_anggaran' 
			and dari ='$unit' and id !='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				$jumlah=$data->jumlah;
				}
				return $jumlah;
			}

    }
    function get_kepada($id=''){
		$sql="";
    	 

		$select="";
		$select.="<select id='unit_tersedia' class='form-control' style='width:300px' name='unit_tersedia'>";
 		$q2 = $this->db->query("select * from m_unit_kerja where id_divisi='".$this->session->userdata('ID_DIREKTORAT')."' order by nama_unit_kerja asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($id==$row->kd_unit_kerja){
					 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='$row->kd_unit_kerja'>$row->nama_unit_kerja</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function filter_get_pengkodean(){
		$sql="";   	 
		$select="";
		$select.="<select id='pengkodean' class='form-control input-sm' onchange='return refresh_table()' style='width:300px;float:left;margin-left:10px'  name='pengkodean'>";
 		$select.="<option  value=''>Pilih Data Mapping</option>";
 		$q2 = $this->db->query("select *  from mapping order by id asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
 
				 $select.="<option  value='$row->id'>$row->nama</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function filter_get_pengkodean_renja(){
		$sql="";   	 
		$select="";
		$select.="<select id='pengkodean' class='form-control input-sm' onchange='return load_table()'
		 style='width:300px;float:right;margin-left:10px;font-size:12px'  name='pengkodean'>";
 		$select.="<option  value=''>Pilih Data Mapping</option>";
 		$q2 = $this->db->query("select *  from mapping order by id asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
 
				 $select.="<option  value='$row->id'>$row->nama</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function filter_get_direktorat(){
		$select="";
		$sql="";
		$pusat=$this->session->userdata('PUSAT'); 
		$unit=$this->session->userdata('ID_DIREKTORAT');
		$selected="";
		if(($pusat=="0") or ($pusat=="")){
			$sql= " where id_divisi='".$unit."'";
			$selected="selected='selected'";
		}
		$select.="
		<select id='unit' class='form-control input-sm' onchange='return refresh_table()' style='width:300px;float:left' name='unit'>";
 		if($this->session->userdata('PUSAT')=="1"){
 			$select.="<option value=''>-Pilih Direktorat / Semua-</option>";
 		}
 		$q2 = $this->db->query("select * from m_unit_kerja ".$sql." order by nama_unit_kerja asc");
 
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 
				 	$select.="<option ".$selected." value='$row->id_divisi'>$row->nama_unit_kerja</option>";
				 
			}
		}
		$select.="</select>";
		return $select;
	}
	function filter_tahun_anggaran(){
		$select="";
		$select.="<select id='tahun_anggaran' onchange='return refresh_table()' class='form-control input-sm' 
		style='width:20%;font-size:15px;padding:5px;margin-right:10px;float:left' name='tahun_anggaran'>";
		//$select.="<option value=''>-Pilih Tahun Anggaran-</option>";
		$q2 = $this->db->query("select * from tahun_anggaran order by tahun_anggaran asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($row->tahun_anggaran==date("Y")){
				 	 $selected="selected='selected'";
				 }
				 $select.="<option   ".$selected." value='$row->tahun_anggaran'>$row->tahun_anggaran</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function get_tahun_berlaku($id=""){
		$query=$this->db->query("select tahun_anggaran from tahun_anggaran where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->tahun_anggaran;
				}
				return $menus;
			}
	}
	function get_tahun_renja_export($tahun_anggaran=''){
		$select="";
		$select.="<select id='tahun_renja_export' class='form-control' style='width:100%;font-size:13px' name='tahun_renja_export'>";
		$select.="<option value=''>-Pilih Tahun Anggaran-</option>";
		$q2 = $this->db->query("select * from tahun_anggaran order by tahun_anggaran asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($tahun_anggaran==$row->id){
					 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='$row->id'>$row->tahun_anggaran</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function tahapan_dokumen($id=""){
		$select="";
		$select.="<select id='tahapan_dokumen' class='form-control input-xs' style='height:30px;width:100%;font-size:12px;padding:2px;' name='tahapan_dokumen'>";
		$select.="<option value=''>-Pilih Tahapan Dokumen-</option>";
		$q2 = $this->db->query("select * from tahapan_dokumen order by id_dokumen asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($id==$row->id){
					 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='".$row->id_dokumen."'>$row->nama_tahapan</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function get_tahun_anggaran($tahun_anggaran=''){
		$select="";
		$select.="<select id='tahun_anggaran' class='form-control sm' style='width:100%' name='tahun_anggaran'>";
		$select.="<option value=''>-Pilih Tahun Anggaran-</option>";
		$q2 = $this->db->query("select * from tahun_anggaran order by tahun_anggaran asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 $selected="";
				 if($tahun_anggaran==$row->id){
					 $selected="selected='selected'";
				 }
				 $select.="<option $selected value='$row->id'>$row->tahun_anggaran</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	function get_new_id(){
		$query=$this->db->query("select max(id)  as id from template_renja");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->id;
				}
				return $menus;
			}
	}
function import_renja($file_name=""){

		$id=$this->input->post('id');
		if($id==""){
			$id=$this->get_new_id();
		}
		$opsi_export=$this->input->post('opsi_export');
		
		$parent=$this->input->post('parent');
		$unit=$this->input->post('unit');
		$unit_asli=$this->input->post('unit_tersedia');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$tahun_berlaku=$this->get_tahun_berlaku($tahun_anggaran);
		$is_mapping=$this->input->post('is_mapping');
		 
        $j = -1;
		$jumlahRowdbx='';
	 
		//$this->db->query("delete from data_template_renja where kode_direktorat_child='".$unit."' and tahun_berlaku='".$tahun_berlaku."'");
         $this->db->query("delete from data_template_renja where id_data_renja='".$id."'"); 
        $this->load->library('excel');
 		$objPHPExcel = PHPExcel_IOFactory::load('uploads/'.$file_name);
 	 	$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		$i=19;
		$kode_indi="";
		$kodedir="";
		$kode_kl="";
        $urutan=1;
        $parent_komponen_input="";
        $parent_sub_komponen_input="";
        $parent_indikator="";
        $parent_nya="";
        $urutan_komponen_input="";
        $urutan_sub_komponen_input="";
        $urutan_indikator="";
        $urutan_nya="";

        for($i;$i<=$highestRow;$i++){ 
        	 if ($sheet->getRowDimension($i)->getVisible()) {
        	 	$kode_direktorat=$sheet->getCellByColumnAndRow($this->input->post('program'), $i)->getCalculatedValue();

        	 	if($kode_direktorat!=""){
		        		$kodedir=$sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue();
		        }  
		      
			      $value_kol1=trim($sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue());
			      $value_kol2=trim($sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue());
			      $value_kol3=trim($sheet->getCellByColumnAndRow(2, $i)->getCalculatedValue());
			      $value_kol4=trim($sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue());

        	 	 if($is_mapping=="y"){
        	 	 	$value_kol1=trim($sheet->getCellByColumnAndRow($this->input->post('program'), $i)->getCalculatedValue());
		        	$value_kol2=trim($sheet->getCellByColumnAndRow($this->input->post('kegiatan'), $i)->getCalculatedValue());
		        	$value_kol3=trim($sheet->getCellByColumnAndRow($this->input->post('nomor_urut_indikator'), $i)->getCalculatedValue());
		        	$value_kol4=trim($sheet->getCellByColumnAndRow($this->input->post('indikator'), $i)->getCalculatedValue());
		        	$kode_direktorat=$sheet->getCellByColumnAndRow($this->input->post('program'), $i)->getCalculatedValue();
		        	$kode_indikator=$sheet->getCellByColumnAndRow($this->input->post('kegiatan'), $i)->getCalculatedValue();
		        	$kl=$sheet->getCellByColumnAndRow($this->input->post('renaksi'), $i)->getCalculatedValue() ;
		        	if($kode_direktorat!=""){
		        		$kodedir=$sheet->getCellByColumnAndRow($this->input->post('program'), $i)->getCalculatedValue();
		        	}  else {
		        		$kodedir=$kodedir;
		        	}

		        	if($kode_indikator!=""){
		        		$kode_indi=$sheet->getCellByColumnAndRow($this->input->post('kegiatan'), $i)->getCalculatedValue();
		        	}  else {
		        		$kode_indi=$kode_indi;
		        	}


		        	$kode_kl=$sheet->getCellByColumnAndRow($this->input->post('renaksi'), $i)->getCalculatedValue();		        	 
		        	$program=$sheet->getCellByColumnAndRow($this->input->post('kegiatan'), $i)->getCalculatedValue(); 
		        	$indikator=$sheet->getCellByColumnAndRow($this->input->post('indikator'), $i)->getCalculatedValue() ? $sheet->getCellByColumnAndRow($this->input->post('indikator'), $i)->getCalculatedValue()  : " " ;
		        	$kode_komponen_input= $sheet->getCellByColumnAndRow($this->input->post('nomor_urut_komponen_input'), $i)  ;
		        	$komponen_input=$sheet->getCellByColumnAndRow($this->input->post('komponen_input'), $i)->getCalculatedValue()  ? $sheet->getCellByColumnAndRow($this->input->post('komponen_input'), $i)->getCalculatedValue()  : " " ;
		        	$sasaran_program=$sheet->getCellByColumnAndRow($this->input->post('sasaran_program'), $i)->getCalculatedValue() ;
		        	$sasaran_kegiatan=$sheet->getCellByColumnAndRow($this->input->post('sasaran_kegiatan'), $i)->getCalculatedValue() ;
		        	$target=$sheet->getCellByColumnAndRow($this->input->post('target'), $i)->getCalculatedValue() ;
		        	$bo01=$sheet->getCellByColumnAndRow($this->input->post('bo001'), $i)->getCalculatedValue() ;
		        	$bo02=$sheet->getCellByColumnAndRow($this->input->post('bo002'), $i)->getCalculatedValue() ;
		        	$bno_rm_p=$sheet->getCellByColumnAndRow($this->input->post('rm_p'), $i)->getCalculatedValue() ;
		        	$bno_rm_d=$sheet->getCellByColumnAndRow($this->input->post('rm_d'), $i)->getCalculatedValue() ;
		        	$bno_phln_p=$sheet->getCellByColumnAndRow($this->input->post('phln_p'), $i)->getCalculatedValue() ;
		        	$bno_phln_d=$sheet->getCellByColumnAndRow($this->input->post('phln_d'), $i)->getCalculatedValue() ;
		        	$pnbp=$sheet->getCellByColumnAndRow($this->input->post('pnbp'), $i)->getCalculatedValue();		        	 
		        	$unit=$sheet->getCellByColumnAndRow($this->input->post('unit'), $i)->getCalculatedValue() ;
        	 	 } else {
		        	$value_kol1=trim($sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue());
		        	$value_kol2=trim($sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue());
		        	$value_kol3=trim($sheet->getCellByColumnAndRow(2, $i)->getCalculatedValue());
		        	$value_kol4=trim($sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue());
		        	$kode_direktorat=$sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue();
		        	$kode_indikator=$sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue();
		        	$kl=$sheet->getCellByColumnAndRow(31, $i)->getCalculatedValue() ;
		        	
		        	if($kode_direktorat!=""){
		        		$kodedir=$sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue();
		        	}  else {
		        		$kodedir=$kodedir;
		        	}

		        	if($kode_indikator!=""){
		        		$kode_indi=$sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue();
		        	}  else {
		        		$kode_indi=$kode_indi;
		        	}
		        	
					 $isletter= $this->isletter($value_kol3);
		        	 if($value_kol1!=""){
		        	 	$parent=$value_kol1;
		        	 	$kode="";
		        	 	$tipe="program";
		         	 	$parent=$value_kol1;
		        	 	$parent_nya=$parent;
		         	 } else  if (($value_kol1=="") and ($value_kol2!="")){
		        	 	$kode=$value_kol2;
		        	 	$parent=$parent;
		        		$tipe="indikator";
		        		$parent_indikator=$kode;
		        		$parent_nya=$kodedir;
		        		$urutan_indikator ++;
		        		$urutan_nya=$urutan_indikator;
		        		$urutan_komponen_input="1";
		        		$urutan_sub_komponen_input="1";
		        	 } else  if (($value_kol1=="") and ($value_kol2=="") and ($value_kol3!="") and  (empty($isletter))){
		        	 	$kode=$value_kol3;
		        		$tipe="komponen_input";
		        		$parent_komponen_input=$value_kol3;
		        		$parent_nya=$parent_indikator;
		        		$urutan_komponen_input ++;
 		        		$urutan_nya=$urutan_komponen_input;
		        		$urutan_sub_komponen_input="1";
		        	 }  
		        	 if (($value_kol1=="") and ($value_kol2=="") and (!empty($isletter))){
		        	 	$kode=$value_kol3;
		        		$tipe="sub_komponen_input";
		        		$parent_sub_komponen_input=$parent_komponen_input;
		        		$parent_nya=$parent_sub_komponen_input;
		        		$urutan_sub_komponen_input ++;
		        		$urutan_nya=$urutan_sub_komponen_input;
		        	 } 
		       		if ((strtoupper($value_kol3)=="OUTPUT")){
		        	 	$kode=strtoupper($value_kol3);
		        		$tipe="komponen_input";
		        		$parent_sub_komponen_input=$parent_komponen_input;
		        		$parent_nya=$parent_indikator;
		        		$urutan_sub_komponen_input ++;
		        		$urutan_nya=0;
		        	 }
	       	 		//echo "KODE = (".$kode.") TIPE = (".$tipe.") PARENT = (".$parent_nya .") URUTAN = (".$urutan.") ".$sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue()."<br>";
	       	  
		        	 $kode_kl=$sheet->getCellByColumnAndRow(31, $i)->getCalculatedValue();		        	 
		        	 $program=$sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue(); 
		        	 $indikator=$sheet->getCellByColumnAndRow(2, $i)->getCalculatedValue() ? $sheet->getCellByColumnAndRow(2, $i)->getCalculatedValue()  : " " ;
		        	 $kode_komponen_input= $sheet->getCellByColumnAndRow(2, $i)  ;
		        	 $komponen_input=$sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue()  ? $sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue()  : " " ;
		        	 $sasaran_program=$sheet->getCellByColumnAndRow(4, $i)->getCalculatedValue() ;
		        	 $sasaran_kegiatan=$sheet->getCellByColumnAndRow(4, $i)->getCalculatedValue() ;
		        	 $target=$sheet->getCellByColumnAndRow(7, $i)->getCalculatedValue() ;
		        	 $bo01=$sheet->getCellByColumnAndRow(13, $i)->getCalculatedValue() ;
		        	 $bo02=$sheet->getCellByColumnAndRow(14, $i)->getCalculatedValue() ;
		        	 $bno_rm_p=$sheet->getCellByColumnAndRow(15, $i)->getCalculatedValue() ;
		        	 $bno_rm_d=$sheet->getCellByColumnAndRow(16, $i)->getCalculatedValue() ;
		        	 $bno_phln_p=$sheet->getCellByColumnAndRow(17, $i)->getCalculatedValue() ;
		        	 $bno_phln_d=$sheet->getCellByColumnAndRow(18, $i)->getCalculatedValue() ;
		        	 $pnbp=$sheet->getCellByColumnAndRow(19, $i)->getCalculatedValue();		        	 
		        	 $unit=$sheet->getCellByColumnAndRow(32, $i)->getCalculatedValue() ;
	        	 }
	        	 	if  (is_float($target) or  is_numeric ($target))  {
						  $target=$target * 100 ;
							$target=$target.'%';
					}
	        	  $sub_komponen_input="";	
    				  $data=array(
  				  	 'kode'=>$kode,	
				 	 'id_data_renja'=>$id,
					 'parent'=>$parent_nya,
					 'tipe'=>$tipe,
					 'program'=>$kode,
					 'urutan'=>$urutan_nya,
					 'kode_direktorat_child'=>$kodedir,
					 'kode_direktorat'=>$kode_direktorat,
					 'program'=>$program,
					 'kode_indikator'=>$kode_indi,
					 'indikator'=>$indikator,
					 'kode_komponen_input'=>$sasaran_kegiatan,
					 'komponen_input'=>$komponen_input,
					 'sub_komponen_input'=>$sub_komponen_input,
					 'sasaran_program'=>$sasaran_program,
					 'sasaran_kegiatan'=>$sasaran_kegiatan,
					 'target'=>$target,
					 'bo01'=>$bo01,
					 'bo02'=>$bo02,
					 'bno_rm_p'=>$bno_rm_p,
					 'bno_rm_d'=>$bno_rm_d,
					 'bno_phln_p'=>$bno_phln_p,
					 'bno_phln_d'=>$bno_phln_d,
					 'pnbp'=>$pnbp,
					 'kl'=>$kode_kl,
					 'tahun_berlaku'=>$tahun_berlaku,
					 'unit'=>$unit,
				); 
	        	
	        	 if(strtoupper($value_kol3)!="OUTPUT") {
				  	if(trim($kodedir)==trim($unit_asli)){
					  	if(($value_kol1!="") or ($value_kol2!="") or ($value_kol3!="") or ($value_kol4!="")){	 
					  	     	$this->db->trans_start();
								$this->db->insert('data_template_renja',$data);
								$this->db->trans_complete();
								}	 
					   	}
				    }
				    if ((strtoupper($value_kol3)=="OUTPUT")){
		        	 	$this->db->trans_start();
						$this->db->insert('data_template_renja',$data);
						$this->db->trans_complete();
		        	 }
		     
		         	 
				}
			
			   	$urutan++;	
			   	$urutan_nya=$urutan;
			    	
    	} 
    	$this->fuck_reset_after_upload_excel($id,$kodedir,$tahun_berlaku);
    	/*$id=$this->input->post('id');
    	if($id==""){
			$id=$this->get_new_id();
		}
 		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$tahun_berlaku=$this->get_tahun_berlaku($tahun_anggaran);
		include_once ( APPPATH . "libraries/excel_reader/excel/reader.php");
        $data_f = new Spreadsheet_Excel_Reader();
        $j = -1;
		$jumlahRowdbx='';
		$jumlah_rows=0;
		$this->db->query("delete from data_template_renja where id_data_renja='".$id."'");
        error_reporting(E_ALL ^ E_NOTICE);       
        $data_f->read('uploads/'.$file_name);
        $i=1;
        $urutan=1;
        $parent_komponen_input="";
        $parent_sub_komponen_input="";
        $parent_indikator="";
        $parent_nya="";
        for ($i = 19; $i <= $data_f->sheets[0]['numRows']; $i++) {

        	 $value_kol1=trim($data_f->sheets[0]['cells'][$i][1]);
        	 $value_kol2=trim($data_f->sheets[0]['cells'][$i][2]);
        	 $value_kol3=trim($data_f->sheets[0]['cells'][$i][3]);
        	 $value_kol4=trim($data_f->sheets[0]['cells'][$i][4]);

        	 $kode_direktorat=$data_f->sheets[0]['cells'][$i][1];
        	 
        	 if($kode_direktorat!=""){
        	 	$kodedir=$data_f->sheets[0]['cells'][$i][1];
        	 	$parent=$data_f->sheets[0]['cells'][$i][1];
        	 } else {
        		$kode_direktorat=$kode_direktorat;
        	 }
        	 
        	 $isletter= $this->isletter($value_kol3);
 		  	 
        	
        	 if($value_kol1!=""){
        	 	$parent=$value_kol1;
        	 	$kode="";
        	 	$tipe="program";
         	 	$parent=$value_kol1;
        	 	$parent_nya=$parent;
         	 } else  if (($value_kol1=="") and ($value_kol2!="")){
        	 	$kode=$value_kol2;
        	 	$parent=$parent;
        		$tipe="indikator";
        		$parent_indikator=$kode;
        		$parent_nya=$kodedir;
        	 } else  if (($value_kol1=="") and ($value_kol2=="") and ($value_kol3!="") and  (empty($isletter))){
        	 	$kode=$value_kol3;
        		$tipe="komponen_input";
        		$parent_komponen_input=$value_kol3;
        		$parent_nya=$parent_indikator;
        	 }  if (($value_kol1=="") and ($value_kol2=="") and (!empty($isletter))){
        	 	$kode=$value_kol3;
        		$tipe="sub_komponen_input";
        		$parent_sub_komponen_input=$parent_komponen_input;
        		$parent_nya=$parent_sub_komponen_input;
        	 } 

       	 		echo "KODE = (".$kode.") TIPE = (".$tipe.") PARENT = (".$parent_nya .") URUTAN = (".$urutan.") ".$data_f->sheets[0]['cells'][$i][16]." <br>";

         
        	 $program=$data_f->sheets[0]['cells'][$i][2];
        	 $kode_indikator=$data_f->sheets[0]['cells'][$i][2];
        	 $indikator=$data_f->sheets[0]['cells'][$i][3];
        	 $kode_komponen_input=$data_f->sheets[0]['cells'][$i][3];
        	 $komponen_input=$data_f->sheets[0]['cells'][$i][4];
        	 $sasaran_program=$data_f->sheets[0]['cells'][$i][5];
        	 $sasaran_kegiatan=$data_f->sheets[0]['cells'][$i][5];
        	 $target=$data_f->sheets[0]['cells'][$i][8];

        	 $bo01=$data_f->sheets[0]['cells'][$i][14];
        	 $bo02=$data_f->sheets[0]['cells'][$i][15];
        	 $bno_rm_p=$data_f->sheets[0]['cells'][$i][16];
        	 $bno_rm_d=$data_f->sheets[0]['cells'][$i][17];
        	 $bno_phln_p=$data_f->sheets[0]['cells'][$i][18];
        	 $bno_phln_d=$data_f->sheets[0]['cells'][$i][19];
        	 $pnbp=$data_f->sheets[0]['cells'][$i][20];
        	 $kl=$data_f->sheets[0]['cells'][$i][31];
        	 $unit=$data_f->sheets[0]['cells'][$i][33];
        	 $sub_komponen_input="";
 			 	
          	 $data=array(
         	 	 'tipe'=>$tipe,
         	 	 'kode'=>$kode,
         	 	 'urutan'=>$urutan,
         	 	 'kode_direktorat'=>$kode_direktorat,
			 	 'id_data_renja'=>$id,
				 'parent'=>$parent_nya,
				 'kode_direktorat_child'=>$kodedir,
				 'program'=>$kode,
				 'kode_indikator'=>$kode_indikator,
				 'indikator'=>$indikator,
				 'kode_komponen_input'=>$kode_komponen_input,
				 'komponen_input'=>$komponen_input,
				 'sub_komponen_input'=>$sub_komponen_input,
				 'sasaran_program'=>$sasaran_program,
				 'sasaran_kegiatan'=>$sasaran_kegiatan,
				 'target'=>$target,
				 'bo01'=>$bo01,
				 'bo02'=>$bo02,
				 'bno_rm_p'=>$bno_rm_p,
				 'bno_rm_d'=>$bno_rm_d,
				 'bno_phln_p'=>$bno_phln_p,
				 'bno_phln_d'=>$bno_phln_d,
				 'pnbp'=>$pnbp,
				 'kl'=>$kl,
				 'tahun_berlaku'=>$tahun_berlaku,
				 'unit'=>$unit,
			);
          	
          	if(($value_kol1!="") or ($value_kol2!="") or ($value_kol3!="") or ($value_kol4!="")) {
          	 	//$this->db->trans_start();
			  	//$this->db->insert('data_template_renja',$data);
		   	  	//$this->db->trans_complete(); 
          	}

          	$urutan++;
          	$i++;
        */
       
	}
	function reset_notifikasi(){
		$id_direktorat=$this->session->userdata('ID_DIREKTORAT');
 		$menus='';

			$id_direktorat=$this->session->userdata('ID_DIREKTORAT');	
			$status_user=$this->session->userdata('STATUS');	
		 
			$addTag="";
			if($status_user!="1"){
     			$sql=" and  status='upload'";
     			$this->db->query("update template_renja set status_acuan ='0'"); 
     		}  
 	}
	function simpan($newname="",$nama_file=""){
		$id=$this->input->post('id');
		$judul=$this->input->post('judul');
		$note=$this->input->post('note');
		$kepada=$this->input->post('kepada');
		$is_pusat=$this->session->userdata('STATUS');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$tahun_renja_export=$this->input->post('tahun_renja_export');
		$tahapan_dokumen=$this->input->post('tahapan_dokumen');
		$status="";
		if($is_pusat=="1"){
			$status='download';
		}  else {
			$status='template_renja';
		}
		$status_acuan="1";
		if (strpos($newname,'.') !== false) {
		    $data=array(
		 	 'judul'=>$judul,
			 'note'=>$note,
			 'tanggal'=>date("Y-m-d"),
			 'jam'=>date("H:m:i"),
			 'url'=>$newname,
			 'dari'=>$this->session->userdata('ID_DIREKTORAT'),
			 'kepada'=>$kepada,
			 'status'=>$status,
 			 'nama_file'=>$nama_file,
			 'tahun_anggaran'=>$tahun_anggaran,
			 'add_by'=>$this->session->userdata('ID_USER'),
			 'status_acuan'=>$status_acuan
			);		 
		} else {
			 $data=array(
		 	 'judul'=>$judul,
			 'note'=>$note,
			 'tanggal'=>date("Y-m-d"),
			 'jam'=>date("H:m:i"),
			 'dari'=>$this->session->userdata('ID_DIREKTORAT'),
			 'kepada'=>$kepada,
			 'status'=>$status,
			 'tahun_anggaran'=>$tahun_anggaran,
			 'add_by'=>$this->session->userdata('ID_USER'),			 
 			);
		}
		
		
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('template_renja',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('template_renja', $data); 
			$this->db->trans_complete();
		}	
		$opsi_export=$this->input->post('opsi_export');
		if($opsi_export=="1"){
			$this->template_renja_model->import_renja($newname);	
		}
		//if (strpos($newname,'.') !== false) {
			//$this->template_renja_model->import_renja($newname);	
		//}	
		if ($tahun_renja_export!="") {
			$this->template_renja_model->import_renja_from_tahun_berjalan();	
		}		
		redirect(base_url()."template_renja"); 
	}
	function get_max_id_data_renja(){
		$query = $this->db->query("select max(id) as max from template_renja");
   		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return  $row->max;
 			}
		}  
	}
	function import_renja_from_tahun_berjalan(){
		$tahun_renja_export=$this->input->post('tahun_renja_export');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$get_tahun_berlaku=$this->get_tahun_berlaku($tahun_renja_export);
		$tahun_anggaran=$this->get_tahun_berlaku($tahun_anggaran);
		$unit=$this->input->post('unit_tersedia');
		$id=$this->input->post('id');
		if($id==""){
			$id_data_renja=$this->get_max_id_data_renja();
		} else {
			$id_data_renja=$id;
		}
		
		$this->db->query("delete from data_template_renja  where  id_data_renja='".$id_data_renja."'");
		
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.tahun_berlaku='".$get_tahun_berlaku."'   and kode_direktorat_child='".$unit."'
			order by a.urutan asc"); 
   			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array(
						'id_data_renja'=>$id_data_renja,
 						'tipe'=>$data->tipe ,
						'kode'=>$data->kode ,
						'parent'=>$data->parent ,
						'urutan'=>$data->urutan ,						
						'kode_direktorat_child'=>$data->kode_direktorat_child ,
						'kode_direktorat'=>$data->kode_direktorat ,
						'program'=>$data->program ,
						'indikator'=>$data->indikator ,
						'kode_indikator'=>$data->kode_indikator ,
						'komponen_input'=>$data->komponen_input ,
						'kode_komponen_input'=>$data->kode_komponen_input ,
						'sub_komponen_input'=>$data->sub_komponen_input,
						'sasaran_program'=>$data->sasaran_program ,
						'sasaran_kegiatan'=>$data->sasaran_kegiatan,
						'target'=>$data->target ,
						'bo01'=>$data->bo01,
						'bo02'=>$data->bo02 ,
						'bno_rm_p'=>$data->bno_rm_p ,
						'bno_rm_d'=>$data->bno_rm_d,
						'bno_phln_p'=>$data->bno_phln_p ,
						'bno_phln_d'=>$data->bno_phln_d,
						'pnbp'=>$data->pnbp,
						'kl'=>$data->kl,
						'tahun_berlaku'=>$tahun_anggaran,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
 					);
 					$this->db->trans_start();
					$this->db->insert('data_template_renja',$data);
					$this->db->trans_complete();
				}
			}	
	}
	function tandai($id=""){
		$keterangan_tandai=$this->input->post('keterangan_tandai');
		 $data=array(
		 	 'mark'=>'1',
			 'keterangan_tandai'=>$keterangan_tandai,			 
			);
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('data_template_renja', $data); 
		$this->db->trans_complete();
	}
	function delete_data($id=""){
		$this->db->delete('template_renja', array('id' => $id)); 
		$this->db->delete('data_template_renja', array('id_data_renja' => $id)); 

	}
	function delete_data_renja($id=""){
 		$this->db->delete('data_template_renja', array('id' => $id)); 
 		echo "SUKSES HAPUS DATA";
	}
	function simpan_status_perbaikan($db_rkakl=""){
		$id=$this->input->post('id');
		$status_perbaikan=$this->input->post('status_perbaikan');
		$tahapan_dokumen=$this->input->post('tahapan_dokumen');
		$id=$this->input->post('id');
		
		if (strpos($db_rkakl,'.') !== false) {
		  	$data=array(		 	 
				'status_perbaikan'=>$status_perbaikan,		
	 			'tahapan_dokumen'=>$tahapan_dokumen,
		 		'db_rkakl'=>$db_rkakl
			);
		} else {
			$data=array(		 	 
				'status_perbaikan'=>$status_perbaikan,		
 				'tahapan_dokumen'=>$tahapan_dokumen,
 			);
		}

		if($status_perbaikan=="1"){
			$this->db->query("update data_template_renja set mark='0', keterangan_tandai='' where id_data_renja='".$id."'");
		}	

		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('template_renja', $data); 
		$this->db->trans_complete();
		
		if($status_perbaikan=="1"){
			$this->copy_to_log_after_approve();
		}
		redirect("template_renja/rekap_renja/".$id);
	} 
	function get_max_id_log_renja(){
		$query=$this->db->query("select max(id) as id from log_template_renja");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				return $data->id;
			}
		}
	}
	function get_max_revision($id=""){
		$query=$this->db->query("select count(1) as jumlah from log_template_renja where id_data_renja='".$id."'");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					return $data->jumlah;
			}
		}
	}
	function copy_to_log_after_approve(){
		$id=$this->input->post('id');
		$data_array="";
		$max_id=$this->get_max_revision($id) + 1;
		$query=$this->db->query("select * from template_renja where id='".$id."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array(		 
 							'id_user'=>$data->id_user ,
							'judul'=>'REVISI ( '. $max_id .' ) ' ,
							'tanggal'=>$data->tanggal ,
							'jam'=>$data->jam ,
							'note'=>$data->note ,
							'url'=>$data->url ,
							'nama_file'=>$data->nama_file ,
							'dari'=>$data->dari ,
							'kepada'=>$data->kepada ,
							'status'=>$data->status ,
							'add_by'=>$data->add_by ,
							'tahun_anggaran'=>$data->tahun_anggaran ,
							'status_perbaikan'=>$data->status_perbaikan ,
							'status_acuan'=>$data->status_acuan ,
 						 	'id_data_renja'=>$data->id,	
 						 	'tahapan_dokumen'=>$data->tahapan_dokumen,	
							'approve_by'=>$this->session->userdata('ID_USER'),							 
 					);
				}
		}

		$this->db->trans_start();
		$this->db->insert('log_template_renja',$data);
		$this->db->trans_complete();	

		$menus="";
		$info=$this->get_row_program($id);
		$tahun=$info->tahun_anggaran;
		$max_id=$this->get_max_id_log_renja();
		$query=$this->db->query("select * from data_template_renja where id_data_renja='".$id."' and tahun_berlaku='".$tahun."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array(
			  			'id_log'=>$max_id ,
						'tipe'=>$data->tipe ,
						'kode'=>$data->kode ,
						'parent'=>$data->parent ,
						'urutan'=>$data->urutan ,
						'id_data_renja'=>$data->id_data_renja ,
						'kode_direktorat_child'=>$data->kode_direktorat_child ,
						'kode_direktorat'=>$data->kode_direktorat ,
						'program'=>$data->program ,
						'indikator'=>$data->indikator ,
						'kode_indikator'=>$data->kode_indikator ,
						'komponen_input'=>$data->komponen_input ,
						'kode_komponen_input'=>$data->kode_komponen_input ,
						'sub_komponen_input'=>$data->sub_komponen_input,
						'sasaran_program'=>$data->sasaran_program ,
						'sasaran_kegiatan'=>$data->sasaran_kegiatan,
						'target'=>$data->target ,
						'bo01'=>$data->bo01,
						'bo02'=>$data->bo02 ,
						'bno_rm_p'=>$data->bno_rm_p ,
						'bno_rm_d'=>$data->bno_rm_d,
						'bno_phln_p'=>$data->bno_phln_p ,
						'bno_phln_d'=>$data->bno_phln_d,
						'pnbp'=>$data->pnbp,
						'kl'=>$data->kl,
						'tahun_berlaku'=>$data->tahun_berlaku,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
						'target_kinerja'=>$data->target_kinerja,
						'target_keuangan'=>$data->target_keuangan,
						'id_kewenangan'=>$data->id_kewenangan,
 					);
 					$this->db->trans_start();
					$this->db->insert('log_data_template_renja',$data);
					$this->db->trans_complete();
				}
		}
		 
		 

	}
	function isletter($char=""){
		if (preg_match('/[a-zA-Z]/', $char)) :
		    return $char.' is a letter<br>';
		endif;
	}
	function get_total_all(){
		$series='';
		$bulan='';
		$datenow=date("Y");
 		$total_bo1=0;
 		$total_bo2=0;
		$total_rm_pusat=0;
 		$total_rm_daerah=0;
 		$total_phln_pusat=0;
 		$total_phln_daerah=0;
 		$total_pnbp=0;
		$j=1;
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$unit=$this->input->post('unit');
	 	$table="";
	 	$query=$this->db->query("select * from data_template_renja  a
			left join template_renja on template_renja.id= a.id_data_renja
			left join m_unit_kerja on m_unit_kerja.id_divisi= template_renja.dari
			where a.tahun_berlaku like '%$tahun_anggaran%' and template_renja.dari like '%$unit%'
		     ");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$isletter="";
				$isletter= $this->isletter($data->program);;
				if( (empty($data->kode_direktorat)) and  (empty($data->program)) and (empty($isletter))  ){
					$total_bo1=$total_bo1+$data->bo01;
					$total_bo2=$total_bo2+$data->bo02;
					$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
					$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
					$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
					$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
					$total_pnbp=$total_pnbp+$data->pnbp;
				}
			}
		}
		$pagu=0;
		$table.="<tr>";
		$pagu=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>06</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;' colspan='3'><b>PROGRAM BINA PEMBANGUNAN DAERAH</b></td>";
        $table.="<td  style='vertical-align:middle;font-size:10px;'> </td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'> </td>";
 
 
       
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>". strtoupper(trim(number_format($total_bo1)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>". strtoupper(trim(number_format($total_bo2)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>". strtoupper(trim(number_format($total_rm_pusat)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b><b><b>". strtoupper(trim(number_format($total_rm_daerah)))."</td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b><b>". strtoupper(trim(number_format($total_phln_pusat)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>". strtoupper(trim(number_format($total_phln_daerah)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b><b>". strtoupper(trim(number_format($total_pnbp)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'><b>". strtoupper(trim(number_format($pagu)))."</b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'> </td>";
		$table.="</tr>";

		$table.="<tr>";
		$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;' colspan='3'></td>";
        $table.="<td  style='vertical-align:middle;font-size:10px;'>Meningkatnya kualitas pembangunan daerah yang merupakan perwujudan dari pelaksanaan urusan pemerintahan daerah sebagai bagian integral dari pembangunan nasional</td>";
       	
       	$table.="<td  style='vertical-align:middle;font-size:10px;'> </td>";
 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
       	$table.="<td  style='vertical-align:middle;font-size:10px;'> </td>";
		$table.="</tr>";

		
		$table.="<tr>";
			$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	        $table.="<td  style='vertical-align:middle;font-size:10px;text-align:center'>1</td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>Persentase konsistensi dokumen perencanaan pembangunan daerah</td>";
	 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>50%</td>";
	       	for($i=1;$i<=9;$i++){
	       		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	}
		$table.="</tr>";

		$table.="<tr>";
			$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	        $table.="<td  style='vertical-align:middle;font-size:10px;text-align:center'>2</td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>Persentase / 
	       	Jumlah daerah yang menyelenggarakan SIPD</td>";
	 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>20% (5 Provinsi)</td>";
	       	for($i=1;$i<=9;$i++){
	       		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	}
		$table.="</tr>";

		$table.="<tr>";
			$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	        $table.="<td  style='vertical-align:middle;font-size:10px;text-align:center'>3</td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>Persentase penyelesaian perselisihan antar susunan tingkat 
	       	pemerintahan terkait dengan urusan pemerintahan</td>";
	 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>100%</td>";
	       	for($i=1;$i<=9;$i++){
	       		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	}
		$table.="</tr>";

		$table.="<tr>";
			$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	        $table.="<td  style='vertical-align:middle;font-size:10px;text-align:center'>4</td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>Persentase Penerapan indikator 
	       	utama SPM di daerah</td>";
	 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>100% (6 SPM)</td>";
	       	for($i=1;$i<=9;$i++){
	       		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	}
		$table.="</tr>";

		$table.="<tr>";
			$table.="<td  style='vertical-align:middle;font-size:10px;'><b></b></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	        $table.="<td  style='vertical-align:middle;font-size:10px;text-align:center'>4</td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>Persentase Penerapan NSPK di daerah</td>";
	 		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	$table.="<td  style='vertical-align:middle;font-size:10px;'>100% (32 Urusan))</td>";
	       	for($i=1;$i<=9;$i++){
	       		$table.="<td  style='vertical-align:middle;font-size:10px;'></td>";
	       	}
		$table.="</tr>";
		return $table;		 
	}
	function get_id_data_template_renja(){
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$unit=$this->input->post('unit');
		$query=$this->db->query("
		select  a.id from template_renja a 
		left join m_unit_kerja on m_unit_kerja.id_divisi=a.dari
		left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran
		where dari='".$unit."' and tahun_anggaran.tahun_anggaran='".$tahun_anggaran."'"); 
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					return $data->id;
				}
		}		
	}
	function get_data_kode($id_data_renja="",$kode="",$parent="",$pengkodean=""){
			$kodenya="<b>*</b>";
			$query=$this->db->query("select kode from data_mapping 
			where kode_asli='".$kode."' and parent='".$parent."' and id_data_renja='".$id_data_renja."'  and id_mapping='".$pengkodean."'");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					
					$kodenya=$data->kode;
					if($kodenya==""){
						$kodenya="*";
					}
				}		
			}	
			return $kodenya;
	}
	function get_child_data_renja_export($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";
		$pengkodean=$this->input->post('pengkodean');
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$style_header="style='font-family:Tahoma;vertical-align:middle;font-size:11px;vertical-align:middle;height:60px";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program'  order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$table.="<tr>";
						if($pengkodean!=""){
							$kode=$this->get_data_kode($data_f->id_data_renja,$data_f->kode,$data_f->parent,$pengkodean);
						} else {
							$kode=$data_f->kode;
						}
						if($data_f->tipe=="indikator"){
							$style_header.= " ;background-color:#F0F0F0;font-weight:bold'" ;	
							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F0F0F0'>'</span>".($kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".(($data_f->indikator))."</td>";
							$class_editable="";							 
							$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);							
						} else if($data_f->tipe=="komponen_input"){
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
							if (($check_child!="true")){
								$style_header.= " ;background-color:#fff'" ;
							} else {
								$style_header.= " ;background-color:#F9F9F9'" ;
							}	
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span>".($kode)."</b></center></td>";
							$table.="<td $style_header> ".(($data_f->komponen_input))." </td>";
 		 					$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
						}	else if($data_f->tipe=="sub_komponen_input"){
							$style_header.= " '" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;margin-left:20px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><b> <center><span style='color:#fff'>'</span>".($kode)."</center></b></td>";
							$table.="<td $style_header> ".(($data_f->komponen_input))." </td>";
							$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							
						}	
							$table.="<td $style_header > ".(($data_f->sasaran_kegiatan))." </td>";
	 						$table.="<td $style_header>".$data_f->target."</td>";


	 						$bo001=0;
							$bo002=0;
	 						$bno_phln_d=0;
							$bno_phln_p=0;
							$bno_rm_d=0;
							$bno_rm_p=0;								
							$pnbp=0;							
							$total_all=0;
							$is_indikator_bo01="";
							$is_indikator_bo02="";
							$is_indikator_bno_phln_p="";
							$is_indikator_bno_phln_d="";
							$is_indikator_bno_rm_p="";
							$is_indikator_bno_rm_d="";
							$is_indikator_pnbp="";

							$v_bo001=0;
							$v_bo002=0;
	 						$v_bno_phln_d=0;
							$v_bno_phln_p=0;
							$v_bno_rm_d=0;
							$v_bno_rm_p=0;								
							$v_pnbp=0;	

	 						if($data_f->tipe=="indikator"){
	 							$is_indikator_bo01="sum_bo01";
								$is_indikator_bo02="sum_bo02";
								$is_indikator_bno_phln_p="sum_bno_phln_p";
								$is_indikator_bno_phln_d="sum_bno_phln_d";
								$is_indikator_bno_rm_p="sum_bno_rm_p";
								$is_indikator_bno_rm_d="sum_bno_rm_d";
								$is_indikator_pnbp="sum_pnbp";
								 
	 							$v_bo001=($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_bo002=($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_bno_phln_p=($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_bno_phln_d=($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_bno_rm_p=($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_bno_rm_d=($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$v_pnbp=($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
								
								$bo001=number_format($v_bo001);
								$bo002=number_format($v_bo002);
								$bno_phln_p=number_format($v_bno_phln_p);
								$bno_phln_d=number_format($v_bno_phln_d);
								$bno_rm_p=number_format($v_bno_rm_p);
								$bno_rm_d=number_format($v_bno_rm_d);
								$pnbp=number_format($v_pnbp);
								$total_all=number_format($v_bo001+$v_bo002+$v_bno_phln_p+$v_bno_phln_d+$v_bno_rm_p+$v_bno_rm_d+$v_pnbp) ;
										
	 							} else if($data_f->tipe=="komponen_input"){
	 								$c=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
	 									if($c=="true"){
	 										/* BILA KOMPONEN INPUT MEMILIKI CHILD*/	
	 										$v_bo001=($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_bo002=($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_bno_phln_p=($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_bno_phln_d=($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_bno_rm_p=($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_bno_rm_d=($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$v_pnbp=($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
											
											$bo001=number_format($v_bo001);
											$bo002=number_format($v_bo002);
											$bno_phln_p=number_format($v_bno_phln_p);
											$bno_phln_d=number_format($v_bno_phln_d);
											$bno_rm_p=number_format($v_bno_rm_p);
											$bno_rm_d=number_format($v_bno_rm_d);
											$pnbp=number_format($v_pnbp);
											$total_all=number_format($v_bo001+$v_bo002+$v_bno_phln_p+$v_bno_phln_d+$v_bno_rm_p+$v_bno_rm_d+$v_pnbp) ;
	 									} else {
	 										/* BILA KOMPONEN INPUT TIDAK MEMILIKI CHILD*/	
	 										$bo001=number_format($data_f->bo01);
											$bo002=number_format($data_f->bo02);
					 						$bno_phln_d=number_format($data_f->bno_phln_d);
											$bno_phln_p=number_format($data_f->bno_phln_p);
											$bno_rm_d=number_format($data_f->bno_rm_d);
											$bno_rm_p=number_format($data_f->bno_rm_p);								
											$pnbp=number_format($data_f->pnbp);
											$total_all=number_format($data_f->bo01+
											$data_f->bo02+$data_f->bno_rm_p+$data_f->bno_rm_d+$data_f->bno_phln_p+$data_f->bno_phln_d+
											$data_f->pnbp);
	 									}
	 		 						
	 							} else {
		 							$bo001=number_format($data_f->bo01);
									$bo002=number_format($data_f->bo02);
			 						$bno_phln_d=number_format($data_f->bno_phln_d);
									$bno_phln_p=number_format($data_f->bno_phln_p);
									$bno_rm_d=number_format($data_f->bno_rm_d);
									$bno_rm_p=number_format($data_f->bno_rm_p);								
									$pnbp=number_format($data_f->pnbp);
									$total_all=number_format($data_f->bo01+
									$data_f->bo02+$data_f->bno_rm_p+$data_f->bno_rm_d+$data_f->bno_phln_p+$data_f->bno_phln_d+
									$data_f->pnbp);
	 							}

							$table.="<td $style_header class='".$is_indikator_bo01."'> <center>".strtoupper(trim(($bo001)))."</center> </td>";
							$table.="<td $style_header class='".$is_indikator_bo02."'><center>".strtoupper(trim(($bo002)))."</center> </td>";
							$table.="<td $style_header class='".$is_indikator_bno_rm_p."'><center>".strtoupper(trim(($bno_rm_p)))."</center> </td>";
							$table.="<td $style_header class='".$is_indikator_bno_rm_d."'><center>".strtoupper(trim(($bno_rm_d)))." </td>";
							$table.="<td $style_header class='".$is_indikator_bno_phln_p."'><center>".strtoupper(trim(($bno_phln_p)))."</center> </td>";
							$table.="<td $style_header class='".$is_indikator_bno_phln_d."'><center>".strtoupper(trim(($bno_phln_d)))."</center> </td>";
							$table.="<td $style_header class='".$is_indikator_pnbp."'><center>".strtoupper(trim(($pnbp)))."</center> </td>";
							$table.="<td $style_header><right>".strtoupper(trim($total_all))."</right></td>";
							$table.="<td $style_header> <center>".strtoupper(trim(($data_f->kl)))."</center> </td>";	

 							 
 		 					$table.="</tr>";		 					
			 			if ($this->cek_child_anak($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja_export($id,trim($data_f->kode));
						}
			  	}		
			} else {
				/*	$table.="<tr>";
						$table.="<td colspan='16'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
		 		*/	
			}
			return $table;
	}
	function get_data_export(){
		$unit=$this->input->post('unit');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$id=$this->get_id_data_template_renja();
		$sql="";
		if($unit!=""){
			$sql="   a.id_data_renja='".$id."' and  ";
		}
 		$table="";
		$style_header="style='font-size:10px;vertical-align:middle;font-size:10px;color:#000;background-color:#A6A6A6;font-weight:bold'";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where ".$sql." a.tipe='program' and a.tahun_berlaku='".$tahun_anggaran."' order by a.kode_direktorat_child asc");	 
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
						if($unit==""){
							$id=$data_f->id_data_renja;
						}
						$bo001=0;
						$bo002=0;
	 					$bno_phln_d=0;
						$bno_phln_p=0;
						$bno_rm_d=0;
						$bno_rm_p=0;								
						$pnbp=0;							
						$total_all=0;

 						$bo001=($this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
						$bo002=($this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_phln_p=($this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_phln_d=($this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_rm_p=($this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_rm_d=($this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$pnbp=($this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
						
					
						$table.="<tr>";
						$table.="<td $style_header >".$data_f->kode_direktorat."</td>";
						$table.="<td colspan='3' ".$style_header."><b>".(($data_f->program))."</b></td>";
 						$table.="<td ".$style_header."><b>".(($data_f->sasaran_program))."</b></td>";
						$table.="<td  $style_header>".$data_f->target."</td>";

						$table.="<td $style_header class='t_sum_bo01'><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header class='t_sum_bo02'><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header class='t_sum_bno_rm_p'><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header class='t_sum_bno_rm_d'><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header class='t_sum_bno_phln_p'><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header class='t_sum_bno_rm_d'><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header class='t_sum_pnbp'><center>".number_format($pnbp)."</center></td>";
	
						$total_all=0;
						$total_all=(
		 							$this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;	
						
						$table.="<td $style_header class='sum_pagu'><center>".strtoupper(trim(number_format($total_all)))."</center></td>";
						$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";
						$table.="<td $style_header><a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl' class='xeditable' id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".$kl."</center></a></td>";
					        $button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
 		 			$table.="</tr>";
		 			if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja_export($id,$data_f->parent);
					}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;text-align:right'> 
						<center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";
						$table.="</td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	 
	function get_total_program_child($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id_data_renja=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and parent='".$kode."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."' and id_data_renja='".$id_data_renja."' and kode!='' "); 
	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {						 
					if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
  							$total_bo1=$total_bo1+$this->get_total_program_child('bo01',$kode_direktorat_child,$data->kode,$tahun_anggaran,$id_data_renja);
							$total_bo2=$total_bo2+$this->get_total_program_child('bo02',$kode_direktorat_child,$data->kode,$tahun_anggaran,$id_data_renja);		
							$total_rm_pusat=$total_rm_pusat+$this->get_total_program_child('bno_rm_p',$kode_direktorat_child,$data->kode,$tahun_anggaran,$id_data_renja);
							$total_rm_daerah=$total_rm_daerah+$this->get_total_program_child('bno_rm_d',$kode_direktorat_child,$data->kode,$id_data_renja);
							$total_phln_pusat=$total_phln_pusat+$this->get_total_program_child('bno_phln_p',$kode_direktorat_child,$data->kode,$tahun_anggara,$id_data_renjan);
							$total_phln_daerah=$total_phln_daerah+$this->get_total_program_child('bno_phln_d',$kode_direktorat_child,$data->kode,$tahun_anggaran,$id_data_renja);
							$total_pnbp=$total_pnbp+$this->get_total_program_child('pnbp',$kode_direktorat_child,$data->kode,$tahun_anggaran,$id_data_renja);
						} else {
							$total_bo1=$total_bo1+$data->bo01;
							$total_bo2=$total_bo2+$data->bo02;					
							$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
							$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
							$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
							$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
							$total_pnbp=$total_pnbp+$data->pnbp; 	
						} 		
						  						
				}
		}	 

 		if($field=="bo01"){
			if($total_bo1!=""){	
				return $total_bo1;
			}	
		} else if($field=="bo02"){
			if($total_bo2!=""){	
				return $total_bo2;
			}
		} if($field=="bno_rm_p"){
			if($total_rm_pusat!=""){	
				return $total_rm_pusat;
			}
		} if($field=="bno_rm_d"){
			if($total_rm_daerah!=""){	
				return $total_rm_daerah;
			}
		}if($field=="bno_phln_p"){
			if($total_phln_pusat!=""){	
				return $total_phln_pusat;
			}
 		} if($field=="bno_phln_d"){
 			if($total_phln_daerah!=""){	
				return $total_phln_daerah;
			}
 		} if($field=="pnbp"){
 			if($total_pnbp!=""){	
				return $total_pnbp;
			}
 		}		 
	} 
	function get_total_program($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id_data_renja=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."' and id_data_renja='".$id_data_renja."' and kode!='' "); 
 			//echo $this->db->last_query().';<br>';	
 	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {					 
						 
						/*if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
   							$total_bo1=$total_bo1+$this->get_total_program_child('bo01',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_bo2=$total_bo2+$this->get_total_program_child('bo02',$kode_direktorat_child,$data->kode,$tahun_anggaran);		
							$total_rm_pusat=$total_rm_pusat+$this->get_total_program_child('bno_rm_p',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_rm_daerah=$total_rm_daerah+$this->get_total_program_child('bno_rm_d',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_phln_pusat=$total_phln_pusat+$this->get_total_program_child('bno_phln_p',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_phln_daerah=$total_phln_daerah+$this->get_total_program_child('bno_phln_d',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_pnbp=$total_pnbp+$this->get_total_program_child('pnbp',$kode_direktorat_child,$data->kode,$tahun_anggaran);
						} else {
 							$total_bo1=$total_bo1+$data->bo01;
							$total_bo2=$total_bo2+$data->bo02;					
							$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
							$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
							$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
							$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
							$total_pnbp=$total_pnbp+$data->pnbp; 	
						}  */
						$total_bo1=$total_bo1+$data->bo01;
						$total_bo2=$total_bo2+$data->bo02;					
						$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
						$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
						$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
						$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
						$total_pnbp=$total_pnbp+$data->pnbp; 	
					 

				}
		}	 

 		if($field=="bo01"){
			if($total_bo1!=""){	
				return $total_bo1;
			}	
		} else if($field=="bo02"){
			if($total_bo2!=""){	
				return $total_bo2;
			}
		} if($field=="bno_rm_p"){
			if($total_rm_pusat!=""){	
				return $total_rm_pusat;
			}
		} if($field=="bno_rm_d"){
			if($total_rm_daerah!=""){	
				return $total_rm_daerah;
			}
		}if($field=="bno_phln_p"){
			if($total_phln_pusat!=""){	
				return $total_phln_pusat;
			}
 		} if($field=="bno_phln_d"){
 			if($total_phln_daerah!=""){	
				return $total_phln_daerah;
			}
 		} if($field=="pnbp"){
 			if($total_pnbp!=""){	
				return $total_pnbp;
			}
 		}		 
	}
	function get_total_indikator($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id_data_renja=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
	  
	 	$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.parent)='".trim($kode)."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."' and id_data_renja='".$id_data_renja."' and kode!=''"); 
  			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				
  						$total_bo1=$total_bo1+$data->bo01;
						$total_bo2=$total_bo2+$data->bo02;					
						$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
						$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
						$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
						$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
						$total_pnbp=$total_pnbp+$data->pnbp; 			 
			}
		}	 
 		if($field=="bo01"){
			if($total_bo1!=""){	
				return $total_bo1;
			}	
		} else if($field=="bo02"){
			if($total_bo2!=""){	
				return $total_bo2;
			}
		} if($field=="bno_rm_p"){
			if($total_rm_pusat!=""){	
				return $total_rm_pusat;
			}
		} if($field=="bno_rm_d"){
			if($total_rm_daerah!=""){	
				return $total_rm_daerah;
			}
		}if($field=="bno_phln_p"){
			if($total_phln_pusat!=""){	
				return $total_phln_pusat;
			}
 		} if($field=="bno_phln_d"){
 			if($total_phln_daerah!=""){	
				return $total_phln_daerah;
			}
 		} if($field=="pnbp"){
 			if($total_pnbp!=""){	
				return $total_pnbp;
			}
 		}
		 
	}
	function get_total_semua_baru($field="",$kode_direktorat_child="",$kode_indikator="",$indikator="",$tahun_anggaran=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
		$pizza  = $indikator;
		$pieces = explode(".", $pizza);		 
	 	$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'"); 	 
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				
					$isletter="";
					$isletter= $this->isletter($data->program);
					if( (empty($data->kode_direktorat)) and  (empty($data->program)) and (empty($isletter))  ){
						$total_bo1=$total_bo1+$data->bo01;
						$total_bo2=$total_bo2+$data->bo02;					
						$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
						$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
						$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
						$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
						$total_pnbp=$total_pnbp+$data->pnbp; 				 
					}
			}
		}	 
		if($field=="bo01"){
			return $total_bo1;
		} else if($field=="bo02"){
			return $total_bo2;
		} if($field=="bno_rm_p"){
			return $total_rm_pusat;
		} if($field=="bno_rm_d"){
			return $total_rm_daerah;
		}if($field=="bno_phln_p"){
			return $total_phln_pusat;
		} if($field=="bno_phln_d"){
			return $total_phln_daerah;
		} if($field=="pnbp"){
			return $total_pnbp;
		}
	}
	function button_action($id="",$tipe="",$kode_direktorat=""){
		$param="";
		$add_tag="";
		$kode_direktorat_session=$this->session->userdata('KODE_DIREKTORAT');		
		 		if($tipe=="program") {
					$param="load_kesalahan";
					
					$add_tag.='<li><a style="text-decoration:none;cursor:pointer" onclick="return add_form_indikator('.$id.',0)"> 
						      <i class="glyphicon glyphicon-plus" style="color:#31BC86"></i> Tambah Indikator </a></li>';    
					$add_tag.='<li><a style="text-decoration:none;cursor:pointer" onclick="return add_program('.$id.',1)"> 
						      <i class="glyphicon glyphicon-edit" style="color:#879192"></i> Ubah Kegiatan </a></li>';   	      

				} else if($tipe=="indikator") {
					$param="load_kesalahan";
					$add_tag.='<li><a style="text-decoration:none;cursor:pointer" onclick="return add_form_komponen_input('.$id.',0)"> 
						      <i class="glyphicon glyphicon-plus" style="color:#31BC86"></i> Tambah Komponen Input / <b>Output</b> </a></li>';
					$add_tag.=' <li><a style="text-decoration:none;cursor:pointer" onclick="return update_form_indikator('.$id.',1)"> 
						  	  <i class="glyphicon glyphicon-check"></i> Ubah Data Indikator</a></li>';	      
				} else if($tipe=="komponen_input") {
					$add_tag.='<li><a style="text-decoration:none;cursor:pointer" onclick="return add_form_sub_komponen_input('.$id.',0)"> 
						      <i class="glyphicon glyphicon-plus" style="color:#31BC86"></i> Tambah Sub Komponen Input </a></li>';
					$add_tag.='<li><a style="text-decoration:none;cursor:pointer" onclick="return update_form_komponen_input('.$id.',1)"> 
						  	  <i class="glyphicon glyphicon-check"></i> Ubah Komponen Input / <b>Output</b> </a></li>';	      
				} else if($tipe=="sub_komponen_input") {
					$param="tandai";
					$add_tag.=' <li><a style="text-decoration:none;cursor:pointer" onclick="return update_form_sub_komponen_input('.$id.',1)"> 
						   <i class="glyphicon glyphicon-check"></i> Ubah Sub  Komponen Input  </a></li>';	      
				} else if($tipe=="add_program") {
					$param="tandai";					
					$add_tag.=' <li><a style="text-decoration:none;cursor:pointer" onclick="return add_program('.$id.',0)"> 
							   <i class="glyphicon glyphicon-check"></i> Tambah Kegiatan  </a></li>';	      
				}
				
		$button="";
		$button.='<div class="dropdown">
					  <button class="btn btn_gruop_nya btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    <i class="glyphicon glyphicon-edit"></i> Aksi  
					    <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">';
 		if($kode_direktorat==$kode_direktorat_session){
			$button.=$add_tag;
			$button.='<li><a style="text-decoration:none;cursor:pointer" onclick="return delete_data_renja('.$id.')"> 
					   <i class="glyphicon glyphicon-remove" style="color:#C34834"></i> Hapus Data </a></li>
					   <li role="separator" class="divider"></li>';
		}
		if($this->session->userdata('PUSAT')=="1"){
			$button.='<li><a style="text-decoration:none;cursor:pointer" onclick="return tandai('.$id.')"> 
					   <i class="glyphicon glyphicon-pushpin" style="color:#C34834"></i> TANDAI </a></li>
					   <li role="separator" class="divider"></li>';
		}
		$button.='<li><a style="text-decoration:none;cursor:pointer" onclick="return '.$param.'('.$id.')">
					   <i class="glyphicon glyphicon-eye-open"></i> Lihat Kesalahan</a></li>
					  </ul>
					</div>';
		return $button;
	}
 	function get_kode_mapping_fix($id_data_renja="",$kode="",$parent="",$pengkodean=""){
		$kodenya="<b>*</b>";
			$query=$this->db->query("select kode from data_mapping 
			where kode_asli='".$kode."' and parent='".$parent."' and id_data_renja='".$id_data_renja."'  and id_mapping='".$pengkodean."'");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					
					$kodenya=$data->kode;
					if($kodenya==""){
						$kodenya="*";
					}
				}		
			}	
			return $kodenya;
	}
	function get_child_data_renja($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";
		$kode_nya="";
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$pengkodean=$this->input->post('pengkodean');
		$mix_kode=$this->input->post('mix_kode');
		
 		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program' 
 			order by a.urutan asc");
   			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
						if($pengkodean!=""){
							$kode_nya=$this->get_data_kode($data_f->id_data_renja,$data_f->kode,$data_f->parent,$pengkodean);
						} else {
							$kode_nya=$data_f->kode;
						}

						$class_editable="";	
						$class_editablex="";
						$mark=$data_f->mark;
						$ditandai="";
						if($mark=="1") {
							$ditandai="background-color:#F2DEDE !important";
						}	
						$style_header="style='min-width:60px !important;vertical-align:middle;font-size:11px;vertical-align:middle;".$ditandai."'";
						$table.="<tr>";
						if(($this->session->userdata('ID_DIREKTORAT')==$data_f->dari) and ($data_f->status_perbaikan=="0")){
									$class_editablex=" class='xeditable' ";
						}

						$kode="<a style='font-size:10px;text-align:center;cursor:pointer'  
							        id='".$data_f->id."|kode'  ".$class_editablex."  id='kode' data-type='text' 
							        data-placement='right' data-id='kode' 
							        data-title='Masukan Nilai Baru'>
							        <center>".strtoupper(trim(($kode_nya)))."</center></a>";
						if($data_f->tipe=="indikator"){
 							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							if($mix_kode=="1"){
								$kode_mix=$this->get_kode_mapping_fix($data_f->id_data_renja,$data_f->kode,$data_f->parent,"45");
								$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span><span style='color:#E74C3C;font-weight:bold'>".($kode_mix)."</span></b></center></td>";
							}
							$table.="<td $style_header><center> <b>".($kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".ucwords(strtolower($data_f->indikator))."</td>";
							$class_editable="";
							if($data_f->status_perbaikan=="0"){
								$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							}
							
						} else if($data_f->tipe=="komponen_input"){
 							$table.="<td $style_header></td>";
							
							
							if($mix_kode=="1"){
								$kode_mix=$this->get_kode_mapping_fix($data_f->id_data_renja,$data_f->kode,$data_f->parent,"45");
								$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div> ";
								$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span><span style='color:#E74C3C;font-weight:bold'>".($kode_mix)."</span></b></center></td>";
							} else {
								$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							}

							$table.="<td $style_header><b><center> ".$kode."</b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
		 					if($data_f->status_perbaikan=="0"){
	 		 						if(($check_child!="true") and ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
										$class_editable=" class='xeditable' ";
									}
									$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							}
							
						}	else if($data_f->tipe=="sub_komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							if($mix_kode=="1"){
								$kode=$this->get_kode_mapping_fix($data_f->id_data_renja,$data_f->kode,$data_f->parent,"40");
								//$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span>".($kode_mix)."</b></center></td>";
								$table.="<td></td>";
								$table.="<td $style_header><center> <b> <span style='color:#E74C3C;font-weight:bold'>".$kode."</span> </b></center></td>";
							} else {
								$table.="<td $style_header><center> <b> ".$kode." </b></center></td>";
							}
							
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
							if($data_f->status_perbaikan=="0"){
	 		 						if(($check_child!="true") and ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
										$class_editable=" class='xeditable' ";
									}
									$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							}
						}	
							$table.="<td $style_header > ".ucwords(strtolower($data_f->sasaran_kegiatan))." </td>";
	 						$table.="<td $style_header>".$data_f->target."</td>";


	 						$bo001=0;
							$bo002=0;
	 						$bno_phln_d=0;
							$bno_phln_p=0;
							$bno_rm_d=0;
							$bno_rm_p=0;								
							$pnbp=0;							
							$total_all=0;
							
							$is_indikator="";
	 						if($data_f->tipe=="indikator"){
	 						    $is_indikator="is_indikator";	
	 							$bo001=number_format($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bo002=number_format($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_p=number_format($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_d=number_format($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_p=number_format($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_d=number_format($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$pnbp=number_format($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));

	 							$total_all=number_format(
		 							$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;		
	 							} else if($data_f->tipe=="komponen_input"){
	 								$c=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
	 									if($c=="true"){
	 										/* BILA KOMPONEN INPUT MEMILIKI CHILD*/	
	 										$bo001=number_format($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bo002=number_format($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_phln_p=number_format($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_phln_d=number_format($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_rm_p=number_format($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id,$id));
				 							$bno_rm_d=number_format($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$pnbp=number_format($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 								$total_all=number_format(
		 							$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;
	 									} else {
	 										/* BILA KOMPONEN INPUT TIDAK MEMILIKI CHILD*/	
	 										$bo001=number_format($data_f->bo01);
											$bo002=number_format($data_f->bo02);
					 						$bno_phln_d=number_format($data_f->bno_phln_d);
											$bno_phln_p=number_format($data_f->bno_phln_p);
											$bno_rm_d=number_format($data_f->bno_rm_d);
											$bno_rm_p=number_format($data_f->bno_rm_p);								
											$pnbp=number_format($data_f->pnbp);
											$total_all=number_format($data_f->bo01+
											$data_f->bo02+$data_f->bno_rm_p+$data_f->bno_rm_d+$data_f->bno_phln_p+$data_f->bno_phln_d+
											$data_f->pnbp);
	 									}
	 		 					} else {
		 							$bo001=number_format($data_f->bo01);
									$bo002=number_format($data_f->bo02);
			 						$bno_phln_d=number_format($data_f->bno_phln_d);
									$bno_phln_p=number_format($data_f->bno_phln_p);
									$bno_rm_d=number_format($data_f->bno_rm_d);
									$bno_rm_p=number_format($data_f->bno_rm_p);								
									$pnbp=number_format($data_f->pnbp);
									$total_all=number_format($data_f->bo01+
									$data_f->bo02+$data_f->bno_rm_p+$data_f->bno_rm_d+$data_f->bno_phln_p+$data_f->bno_phln_d+
									$data_f->pnbp);
	 							}
	 						if(strtoupper($kode_nya)=="OUTPUT"){
 									$bo001="-";
									$bo002="-";
			 						$bno_phln_d="-";
									$bno_phln_p="-";
									$bno_rm_d="-";
									$bno_rm_p="-";						
									$pnbp="-";
									$class_editable="";
 							} 	
							$table.="<td $style_header class='".$is_indikator."_bo01'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo01' ".$class_editable." id='bo01' data-type='text' 
						        		data-placement='right' data-id='bo01' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo001)))."</center></a>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bo02'>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo02'  ".$class_editable." id='bo02' data-type='text' 
						        		data-placement='right' data-id='bo02' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo002)))."</center></a>
					        		</td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_rm_p'>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
					        			id='".$data_f->id."|bno_rm_p' ".$class_editable." id='bno_rm_p' data-type='text' 
					        			data-placement='right' data-id='bno_rm_p' 
					        			data-title='Masukan Nilai Baru'>
					        			<center>".strtoupper(trim(($bno_rm_p)))."</center></a>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_rm_d'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bno_rm_d' ".$class_editable." id='bno_rm_d' data-type='text' 
						        		data-placement='right' data-id='bno_rm_d' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bno_rm_d)))."</center></a>
									</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_phln_p'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_p' ".$class_editable." id='bno_phln_p' data-type='text' 
							        		data-placement='right' data-id='bno_phln_p' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_p)))."</center></a>
									 </td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_phln_d'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_d' ".$class_editable." id='bno_phln_d' data-type='text' 
							        		data-placement='right' data-id='bno_phln_d' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_d)))."</center></a>
									</td>";

							$table.="<td $style_header  class='".$is_indikator."_pnbp'>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|pnbp' ".$class_editable." id='pnbp' data-type='text' 
						        		data-placement='right' data-id='pnbp' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($pnbp)))."</center></a>
									</td>";
							$table.="<td $style_header  class='".$is_indikator."_pagu'><center>".strtoupper(trim($total_all))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";

							$class_editable="";
 							if($data_f->status_perbaikan=="0"){
	 		 						if(($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
										$class_editable=" class='xeditable' ";
									}
 							}
							$table.="<td $style_header  class='".$is_indikator."_kl'> 
									<a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl' ".$class_editable."  id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".$kl."</center></a></td>";	

							$table.="<td $style_header>".$button."</td>";
		 					$table.="</tr>";		 					
			 			if ($this->cek_child_anak($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja($id,trim($data_f->kode));
						}
			  	}		
			} else {
				/*	$table.="<tr>";
						$table.="<td colspan='16'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
		 		*/	
			}
			return $table;
	}
	function cek_child_anak($id="",$kode=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$kode."'   order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
			}
	}
	function cek_child($id="",$parent=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$parent."'  and tipe='program' order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
			}
	}
	function get_data_rekap($id=""){
		$table="";
		$mix_kode=$this->input->post('mix_kode');
		$style_header="style='vertical-align:middle;font-size:10px;font-weight:bold;background-color:#F9F9F9;font-weight:bold'";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
						$bo001=0;
						$bo002=0;
	 					$bno_phln_d=0;
						$bno_phln_p=0;
						$bno_rm_d=0;
						$bno_rm_p=0;								
						$pnbp=0;							
						$total_all=0;

						/* DIHAPUS KARENA KALKULASINYA LEWAT JS */
 						/*$bo001=($this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
						$bo002=($this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 					$bno_phln_p=($this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 					$bno_phln_d=($this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 					$bno_rm_p=($this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 					$bno_rm_d=($this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 					$pnbp=($this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));*/

						
						$table.="<tr>";
						$table.="<td $style_header >".$data_f->kode_direktorat."</td>";
 						






 						if($mix_kode=="1"){
								$table.="<td colspan='4' ".$style_header."><b>".strtoupper($data_f->program)."</b></td>";
								$table.="<td ".$style_header."><b>".strtoupper($data_f->sasaran_program)."</b></td>";
 						} else {
							$table.="<td colspan='3' ".$style_header."><b>".strtoupper($data_f->program)."</b></td>";
							$table.="<td ".$style_header."><b>".strtoupper($data_f->sasaran_program)."</b></td>";
						}
						
						$table.="<td>".$data_f->target."</td>";

						$table.="<td $style_header id='f_sum_bo_01'><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header id='f_sum_bo_02'><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_p'><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_d'><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_p'><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_d'><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header id='f_sum_pnbp'><center>".number_format($pnbp)."</center></td>";
	
							$total_all=0;
							/* DIHAPUS KARENA KALKULASINYA LEWAT JS */
							/*$total_all=(
		 							$this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun)) ;	
							/*--------------------------------------*/
							$table.="<td $style_header id='f_sum_pagu'><center>".strtoupper(trim(number_format($total_all)))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";

							$class_editable="";
							if($data_f->status_perbaikan=="0"){
					        	$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
					        	$class_editable=" class='xeditable' ";
					    	}
							$table.="<td $style_header><a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl'   id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".$kl."</center></a></td>";
					        $button="";		
					        //if($this->session->userdata('KODE_DIREKTORAT')==$data_f->kode_direktorat_child){
					        	if($data_f->status_perbaikan=="0"){
					       			$button=$this->button_action($data_f->id,'program',$data_f->kode_direktorat_child);
					      		}
					      	//}
					        $table.="<td $style_header>".$button."</td>";
				 			$table.="</tr>";
				 			if ($this->cek_child($id,$data_f->parent)) {
									$table.=$this->get_child_data_renja($id,$data_f->parent);
							}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='17'  style='vertical-align:middle;font-size:10px;text-align:right'> <center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";
						$button=$this->button_action($id,'add_program',$this->session->userdata('KODE_DIREKTORAT'));
						$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
						$info=$this->get_update($id);	
						if($info->dari==$this->session->userdata('NAMA_UNIT_KERJA')){
							$table.=$button;
						}
						$table.="</td>";
		 			$table.="</tr>";
			}

			return $table;
	}



	function save_live_edit(){		 
		$param=$this->input->post('name');
		$jumlah=$this->input->post('value');
		$pieces = explode("|", $param);
		$id=$pieces[0];  
		$tipe=$pieces[1]; 
		$value=strtoupper($this->input->post('value'));
	 	
		if($tipe!="kode"){
			$jumlah=str_replace(".","",$jumlah);
			$jumlah=str_replace(",","",$jumlah);
		} else {
			$jumlah=$value=strtoupper($this->input->post('value'));
		}
		$data=array(
	 	 	$tipe=>$jumlah,		 
		);
		if($tipe=="kl"){
			if(($value=="KL") or ($value=="AP") or ($value=="QW") or ($value=="PL") or ($value=="PN") or ($value=="")) {
	 			$this->update_child_kl();
	 		} else {
				echo "SALAH MEMASUKAN INPUTAN !!!";
	 			return false;
	 		}
	 	}
	 	if($tipe=="kode"){
	 		$this->update_child_kode();
	 	}

		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('data_template_renja', $data); 
		$this->db->trans_complete();
		$this->reset_indikator_affter_insert_sub_komponen_input();		
		$data = array_merge($data, array("id"=>$id));

		$json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
	
		$info=$this->template_renja_model->get_row($id);	
	 	$id_nya=$info->id_data_renja;

	 	if($tipe=="kl"){
	 		$this->update_child_kl();
	 	}
	 	
		$this->db->query("update template_renja set status_perbaikan='0' where id='".$id_nya."'");
	}
	function update_child_kode($id="",$kode=""){
		$value=strtoupper($this->input->post('value'));
		
		if(!empty($id)){
			$param=$this->input->post('name');
			$pieces = explode("|", $param);
			$kode_nya=$pieces[1];  
			$info=$this->get_row($id);
			$kode=$info->kode;
			$parent=$info->parent;
			$tipe=$info->tipe;
			$id_data_renja=$info->id_data_renja;
			$tahun_berlaku=$info->tahun_berlaku;
			$kode_direktorat_child=$info->kode_direktorat_child;
		} else {
			$param=$this->input->post('name');
			$pieces = explode("|", $param);
			$id=$pieces[0];  
			$kode_nya=$pieces[1];  
			$info=$this->get_row($id);
			$kode=$info->kode;
			$parent=$info->parent;
			$tipe=$info->tipe;
			$id_data_renja=$info->id_data_renja;
			$tahun_berlaku=$info->tahun_berlaku;
			$kode_direktorat_child=$info->kode_direktorat_child;
		}		

		$query=$this->db->query("select id,id_data_renja,kode from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and parent='".$kode."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_berlaku)."'  and kode!='' order by urutan ASC"); 
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {	
					if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
						$this->update_child_kode($data->id,$data->kode);
						$this->db->query("update data_template_renja set parent='".$value."' where id='".$data->id."'");
						//echo "update data_template_renja set parent='".$value."' where id='".$data->id."'<br>";
 					} else {
						$this->db->query("update data_template_renja set parent='".$value."' where id='".$data->id."'");
						//echo "update data_template_renja set parent='".$value."' where id='".$data->id."'<br>";
 					}		
				}
			}

 	}
	function update_child_kl($id="",$kode=""){
		$value=strtoupper($this->input->post('value'));
		
		if(!empty($id)){
			$param=$this->input->post('name');
			$pieces = explode("|", $param);
			$kode_nya=$pieces[1];  
			$info=$this->get_row($id);
			$kode=$info->kode;
			$parent=$info->parent;
			$tipe=$info->tipe;
			$id_data_renja=$info->id_data_renja;
			$tahun_berlaku=$info->tahun_berlaku;
			$kode_direktorat_child=$info->kode_direktorat_child;
		} else {
			$param=$this->input->post('name');
			$pieces = explode("|", $param);
			$id=$pieces[0];  
			$kode_nya=$pieces[1];  
			$info=$this->get_row($id);
			$kode=$info->kode;
			$parent=$info->parent;
			$tipe=$info->tipe;
			$id_data_renja=$info->id_data_renja;
			$tahun_berlaku=$info->tahun_berlaku;
			$kode_direktorat_child=$info->kode_direktorat_child;
		}		
		$query=$this->db->query("select id,id_data_renja,kode from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and parent='".$kode."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_berlaku)."'  and kode!='' order by urutan ASC"); 
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {	
					if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
						$this->update_child_kl($data->id,$data->kode);
						$this->db->query("update data_template_renja set kl='".$value."' where id='".$data->id."'");	
 					} else {
						$this->db->query("update data_template_renja set kl='".$value."' where id='".$data->id."'");
 					}		
				}
			}
 	}
	function get_parent_sub_komponen_input($id="",$tipe_input=""){
		$info=$this->template_renja_model->get_row($id);	
		$parent=$info->parent;
		$kode_direktorat_child=$info->kode_direktorat_child;
		$tahun_berlaku=$info->tahun_berlaku;
		$kode=$info->kode;
		$id_nya=$info->id;
		$id_data_renja=$info->id_data_renja;
		$tipe=$info->tipe;
		$cek_child= $this->cek_child_komponen_input($kode,$id_data_renja);
		$tag="";	
	 	$selected="";
		$select="";
		$text="";  	 
		
 
   		$select.="<select class='form-control sm' style='width:90%;float:left;height:34px;padding:0px' id='program' name='program'>";
		$select.="<option value=''>-Pilih Parent-</option>";
		$q2 = $this->db->query("select * from data_template_renja  where tahun_berlaku='".$tahun_berlaku."'  
			and id_data_renja='".$id_data_renja."' and kode!='' ".$tag." order by urutan asc");
		 
  			if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {	

  	 			if($tipe_input=="add"){
	 	 			if(trim($row->id)==trim($id_nya)){
 						$selected="selected='selected'";						 
					}
				}				 
				if($tipe_input=="update"){
 	 	 			if(trim($row->kode)==trim($parent)) {
						$selected="selected='selected'";						 
					}
				}
				$text="";
 				if($tipe=="indikator"){
					$kode=$row->kode;
 				} else if($tipe=="komponen_input"){ 
					$kode=$row->parent.' -> '.$row->kode;
 				} else if($tipe=="sub_komponen_input"){ 
					$kode=$row->parent.' -> '.$row->kode;
 				}

				if($row->tipe=="indikator"){
  					$text=$row->indikator;				
				} else if($row->tipe=="komponen_input"){ 
 					$text=$row->komponen_input;
				} else if($row->tipe=="sub_komponen_input"){ 
 					$text=$row->komponen_input;
				}

				$select.="<option $selected value='".$row->kode."'>".$kode.' . '.$text. "</option>";
				$selected="";	
			}
		}
		$select.="</select>";
		return $select;
	}
	function cek_child_komponen_input($kode="",$id_data_renja=""){
		$q2 = $this->db->query("select parent from data_template_renja where trim(parent)='".trim($kode)."' and id_data_renja='".$id_data_renja."'");
  		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				return "true";
 			}
		} else {
				return  "false";
		}
	}
	function get_parent_komponen_input($id="",$tipe_input=""){
		$info=$this->template_renja_model->get_row($id);	
		$parent=$info->parent;
 		$kode_direktorat_child=$info->kode_direktorat_child;
		$tahun_berlaku=$info->tahun_berlaku;
		$kode_nya=$info->kode;
		$id_data_renja=$info->id_data_renja;
		$tipe=$info->tipe;
		//$cek_child= $this->cek_child_komponen_input($kode_nya,$id_data_renja);
 		 
		$tag="";	
	 	$selected="";
		$select="";
 	 
 		 $i=1;
		$select.="<select class='form-control sm' style='width:90%;float:left;height:34px;padding:0px' id='program' name='program'>";
		$select.="<option value=''>-Pilih Parent-</option>";
		$q2 = $this->db->query("select * from data_template_renja  where tahun_berlaku='".$tahun_berlaku."'  and id_data_renja='".$id_data_renja."'  and kode!='' order by urutan asc");

  		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {							
 	 			if($tipe_input=="add"){
	 	 			if(trim($row->kode)==trim($kode_nya)){
 						$selected="selected='selected'";						 
					}
				}				 
				if($tipe_input=="update"){
 	 	 			if(trim($row->kode)==trim($parent)) {
						$selected="selected='selected'";						 
					}
				}
				$text="";
 				if($tipe=="indikator"){
					$kode=$row->kode;
 				} else if($tipe=="komponen_input"){ 
					$kode=$row->parent.' -> '.$row->kode;
 				} else if($tipe=="sub_komponen_input"){ 
					$kode=$row->parent.' -> '.$row->kode;
 				}

				if($row->tipe=="indikator"){
  					$text=$row->indikator;				
				} else if($row->tipe=="komponen_input"){ 
 					$text=$row->komponen_input;
				} else if($row->tipe=="sub_komponen_input"){ 
 					$text=$row->komponen_input;
				}

				$select.="<option $selected value='".$row->kode."'>".$kode.' . '.$text. "</option>";
				$selected="";	$selected="";	
				$i++;
			}
		}
		$select.="</select>";
		return $select;
	}
	function get_parent_program($id=""){
		$select="";
 		$select.="<select class='form-control sm' style='width:90%;float:left;height:34px;padding:0px' id='program' name='program'>";
 		$select.="<option value='". $this->session->userdata('KODE_DIREKTORAT')."'>". $this->session->userdata('KODE_DIREKTORAT')."</option>";
		$select.="</select>";
		return $select;
	}
	function get_parent_indikator($id=""){
		$info=$this->template_renja_model->get_row($id);	
		$kode_indikator=$info->kode_indikator;
		$kode_direktorat_child=$info->kode_direktorat_child;
		$tahun_berlaku=$info->tahun_berlaku;
		$parent=$info->parent;
		$tipe=$info->tipe;
 		$select="";
 		$kode="";
 		$text="";

 		$select.="<select class='form-control sm' style='width:90%;float:left;height:34px;padding:0px' id='program' name='program'>";
 		$q2 = $this->db->query("select * from data_template_renja where program !='' and tahun_berlaku='".$tahun_berlaku."' 
				and kode_direktorat!='' and kode_direktorat_child='".$kode_direktorat_child."' order by id asc");
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				$selected="";
				if($row->id==$id){
						$selected="selected='selected'";						 
				}
				if($tipe=="indikator"){
					$kode=$row->kode_direktorat;
 					$text=$row->program;				
				} else if($tipe=="komponen_input"){ 
					$kode=$row->kode;
					$text=$row->indikator;
				}	
				else if($tipe=="program"){ 
					$kode=$row->kode_direktorat;
 					$text=$row->program;	
				}	
				 $select.="<option $selected value='".$kode."'>".$kode.' . '.$text."</option>";
			}
		}
		$select.="</select>";
		return $select;
	}
	
	function save_live_edit_komponen_input(){	 
 		$id=$this->input->post('id');
		$program=$this->input->post('program');
		$bno_phln_d=$this->input->post('bno_phln_d');
		$bno_phln_p=$this->input->post('bno_phln_p');
		$bno_rm_d=$this->input->post('bno_rm_d');
		$bno_rm_p=$this->input->post('bno_rm_p');
		$bo001=$this->input->post('bo001');
		$bo002=$this->input->post('bo002');		 
		$indikator=$this->input->post('indikator');
		$kl=$this->input->post('kl');
		$komponen_input=$this->input->post('komponen_input');
		$pnbp=$this->input->post('pnbp');		
		$sasaran_kegiatan=$this->input->post('sasaran_kegiatan');
		$target=$this->input->post('target');
		$urutan=$this->input->post('urutan');
		$kode=$this->input->post('kode');
		$kewenangan=$this->input->post('kewenangan');

 		$target_kinerja=$this->input->post('target_kinerja'); 
	 	$target_keuangan=$this->input->post('target_keuangan'); 
	 	$target_keuangan=str_replace(".","",$target_keuangan);
		$target_keuangan=str_replace(",","",$target_keuangan);

		$tipe_input=$this->input->post('tipe_input');
		$info=$this->get_row($id);	
		$info_program=$info->program;
		$kode_direktorat_child=$info->kode_direktorat_child;
		$id_data_renja=$info->id_data_renja;
		$tahun_berlaku=$info->tahun_berlaku;
		$kode_sebelumnya=$info->kode;
		
		
		$target=str_replace('"','',$target);
		$komponen_input=str_replace('"','',$komponen_input);
		$indikator=str_replace('"','',$indikator);
		$tipe_parent=$this->get_tipe_parent($program);
		$tipe="";

		if($tipe_parent=="program"){
			$tipe="indikator";		}  
		else if($tipe_parent=="indikator"){
			$tipe="komponen_input";
		}  else if($tipe_parent=="komponen_input"){
			$tipe="sub_komponen_input";
		}  else if($tipe_parent==""){
			$tipe="indikator";		
		} 
		
		$data=array(
 		 'urutan'=>$urutan,
 		 'parent'=>$program,
  		 'indikator'=>$indikator,
		 'kode_komponen_input'=>$sasaran_kegiatan,
		 'komponen_input'=>$komponen_input,
 		 'sasaran_program'=>$sasaran_kegiatan,
		 'sasaran_kegiatan'=>$sasaran_kegiatan,
		 'target'=>$target,
 		 'bo01'=>$bo001,
		 'bo02'=>$bo002,
		 'bno_rm_p'=>$bno_rm_p,
		 'bno_rm_d'=>$bno_rm_d,
		 'bno_phln_p'=>$bno_phln_p,
		 'bno_phln_d'=>$bno_phln_d,
		 'pnbp'=>$pnbp,
		 'kode'=>trim($kode),
		 'tahun_berlaku'=>$tahun_berlaku,
		 'tipe'=>$tipe,
		 'kl'=>$kl,
		 'kode_direktorat_child'=>$kode_direktorat_child,
		 'id_data_renja'=>$id_data_renja,		 
		 'id_kewenangan'=>$kewenangan
 		);
  		if($info_program!=""){	
			$data = array_merge($data, array("program"=>$program));
		}
		$cek_is_open_lock=$this->cek_is_open_lock('capaian_target',date("m"));
 		if($cek_is_open_lock=="0"){
 			echo " <i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data (Target) Dikunci Oleh Administrator<br>";
 		}  else {
 			$data = array_merge($data, 
 			array('target_kinerja'=>$target_kinerja,
			'target_keuangan'=>$target_keuangan));
 		}
		if($tipe_input=="0"){
			$this->db->trans_start();
			$this->db->insert('data_template_renja',$data);
			$this->db->trans_complete(); 
			echo "<i class='glyphicon glyphicon-ok'> </i> Sukses Melakukan penambahan Data";
		} else {
			$this->ubah_data_child();
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('data_template_renja', $data); 
			$this->db->trans_complete();
			echo "<i class='glyphicon glyphicon-ok'> </i> Sukses Melakukan Perubahan data";
		}
		
		/* INSERT TO HISTORY */
		$data = array_merge($data, array("id"=>$id));
		$json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
		/*-------------------*/
		$this->reset_indikator_affter_insert_sub_komponen_input();
 		$this->db->query("update template_renja set status_perbaikan='0' where id='".$id_data_renja."'");
	}
	function get_row_program($id=""){
		$id_user=$this->session->userdata('ID_DIREKTORAT');	
		$query=$this->db->query("select *,tahun_anggaran.tahun_anggaran as tahun_anggarannya,a.id as id_data_renja,tahun_anggaran.tahun_anggaran as tahun_anggaran,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran 
			where a.id='".$id."'");

		return $query->row();
	}
	function get_parent_id($id=""){
		$query=$this->db->query("select (select b.id  from template_renja b
		LEFT JOIN m_unit_kerja on m_unit_kerja.id_divisi=b.dari
		LEFT JOIN tahun_anggaran on tahun_anggaran.id=b.tahun_anggaran 
		where m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child 
		and tahun_anggaran.tahun_anggaran=a.tahun_berlaku) as id_parent  from data_template_renja a where a.id='".$id."'"); 
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {	
					 return $data->id_parent;
				}
			}

	}
	function save_live_edit_program(){	 
 		$id=$this->input->post('id');
 		$indikator=$this->input->post('indikator');
		$program=$this->input->post('program');
		$kl=$this->input->post('kl');
		$komponen_input=$this->input->post('komponen_input');
  		$target=$this->input->post('target');
		$komponen_input=trim($this->input->post('komponen_input'));
		$urutan=$this->input->post('urutan');
		$tipe_input=$this->input->post('tipe_input');
		if($tipe_input==0){
			$id=$id;			
  		} else {
  			$id=$this->get_parent_id($id);
  		}
  		$info=$this->get_row_program($id);	
 		$tahun_berlaku=$info->tahun_anggaran;
		$id_data_renja=$info->id_data_renja;
  		
  		$sasaran_program=$this->input->post('sasaran_program');
  		$sasaran_kegiatan=$this->input->post('sasaran_kegiatan');

  		$target=str_replace('"','',$target);
		$komponen_input=str_replace('"','',$komponen_input);
		$indikator=str_replace('"','',$indikator);

 		$data=array(
 		 'tipe'=>'program',		
  		 'urutan'=>0,
  		 'id_data_renja'=>$id_data_renja,
  		 'kode_direktorat_child'=>$program,
  		 'kode'=>"",
  		 'target'=>$target,
  		 'program'=>$komponen_input,
 		 'parent'=>$program,
 		 'kode_direktorat'=>$program,
  		 'kode_indikator'=>$komponen_input,
  		 'tahun_berlaku'=>$tahun_berlaku,
  		 'indikator'=>$indikator,
  		 'sasaran_kegiatan'=>$sasaran_kegiatan,
  		 'sasaran_program'=>$sasaran_kegiatan
  		);
 		 
 		 
 		if($tipe_input=="1") {
	 			$this->db->trans_start();
				$this->db->where('id',$id);
				$this->db->update('data_template_renja', $data); 
				$this->db->trans_complete();
				echo "<i class='glyphicon glyphicon-ok'> </i>  SUKSES MELAKUKAN PERUBAHAN DATA !!!";
		} else {
				$this->db->trans_start();
				$this->db->insert('data_template_renja',$data);
				$this->db->trans_complete(); 
				echo "<i class='glyphicon glyphicon-ok'> </i>  SUKSES MELAKUKAN PENAMBAHAN DATA";
		}	
		
		/* INSERT TO HISTORY */
		$data = array_merge($data, array("id"=>$id));
		$json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
		/*-------------------*/
		$this->db->query("update template_renja set status_perbaikan='0' where id='".$id_data_renja."'");
	}
	function ubah_data_child(){
		$id=$this->input->post('id');
		$info=$this->get_row($id);	
		$kode_sebelumnya=$info->kode;
		$tahun_berlaku=$info->tahun_berlaku;
		$kode=$this->input->post('kode');
		$id=$this->input->post('id');
		$tipe_input=$this->input->post('tipe_input');
		$id_data_renja=$info->id_data_renja;
		$this->db->query("update data_template_renja set
			parent='".$kode."' 
			where parent='".$kode_sebelumnya."' 
			and id_data_renja='".$id_data_renja."'
			and tahun_berlaku='".$tahun_berlaku."'
		");		 
	}
	function save_live_edit_indikator(){	 
 		$id=$this->input->post('id');
 		$indikator=$this->input->post('indikator');
		$program=$this->input->post('program');
		$kl=$this->input->post('kl');
		$komponen_input=$this->input->post('komponen_input');
  		$target=$this->input->post('target');
		$kode=trim($this->input->post('kode'));
		$urutan=$this->input->post('urutan');
 		$info=$this->get_row($id);	
		$info_program=$info->program;
		$tahun_berlaku=$info->tahun_berlaku;
		$id_data_renja=$info->id_data_renja;
		$info=$this->get_row($id);	
		$kode_direktorat=$info->kode_direktorat;
		$tipe_input=$this->input->post('tipe_input');
		

		$target=str_replace('"','',$target);
		$komponen_input=str_replace('"','',$komponen_input);
		$indikator=str_replace('"','',$indikator);
		
		$target_kinerja=$this->input->post('target_kinerja'); 
	 	$target_keuangan=$this->input->post('target_keuangan'); 
	 	$target_keuangan=$this->input->post('target_keuangan'); 
	 	$target_keuangan=str_replace(".","",$target_keuangan);
		$target_keuangan=str_replace(",","",$target_keuangan);

		$tipe_parent=$this->get_tipe_parent($program);
		$tipe="";
		if($tipe_parent=="program"){
			$tipe="indikator";		}  
		else if($tipe_parent=="indikator"){
			$tipe="komponen_input";
		} else if($tipe_parent=="komponen_input"){
			$tipe="sub_komponen_input";
		} else if($tipe_parent==""){
			$tipe="indikator";		
		} 
  		$data=array(
 		 'tipe'=>$tipe,		
  		 'target'=>$target,
  		 'urutan'=>$urutan,
  		 'id_data_renja'=>$id_data_renja,
  		 'kode_direktorat_child'=>$program,
  		 'kode'=>$kode,
  		 'program'=>$kode,
 		 'parent'=>$program,
  		 'kode_indikator'=>$program,
  		 'tahun_berlaku'=>$tahun_berlaku,
  		 'indikator'=>$indikator,
  		 'kl'=>$kl,
  		 
 		);
 		$cek_is_open_lock=$this->cek_is_open_lock('capaian_target',date("m"));
 		if($cek_is_open_lock=="0"){
 			echo " <i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data (Target) Dikunci Oleh Administrator<br>";
 		}  else {
 			$data = array_merge($data, 
 			array('target_kinerja'=>$target_kinerja,
			'target_keuangan'=>$target_keuangan));
 		}
 		if($tipe_input=="1") {
 				$this->ubah_data_child();
	 			$this->db->trans_start();
				$this->db->where('id',$id);
				$this->db->update('data_template_renja', $data); 
				$this->db->trans_complete();
				echo "<i class='glyphicon glyphicon-ok'> </i>  Sukses Melakukan Perubahan Data ";
		} else {
				$this->db->trans_start();
				$this->db->insert('data_template_renja',$data);
				$this->db->trans_complete(); 
				echo "<i class='glyphicon glyphicon-ok'> </i>  Sukses Melakukan Perubahan Data ";
		}	
		
		/* INSERT TO HISTORY */
		$data = array_merge($data, array("id"=>$id));
		$json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
		/*-------------------*/
		$this->db->query("update template_renja set status_perbaikan='0' where id='".$id_data_renja."'");
	}
	function get_tipe_parent($kode=""){
		$query=$this->db->query("select tipe from data_template_renja  where kode='".$kode."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
						return $data->tipe;
 				}
 			}
	}
	function save_live_edit_sub_komponen_input(){
		$id=$this->input->post('id');
		$program=$this->input->post('program');
		$bno_phln_d=$this->input->post('bno_phln_d');
		$bno_phln_p=$this->input->post('bno_phln_p');
		$bno_rm_d=$this->input->post('bno_rm_d');
		$bno_rm_p=$this->input->post('bno_rm_p');
		$bo001=$this->input->post('bo001');
		$bo002=$this->input->post('bo002');		 
		$indikator=$this->input->post('indikator');
		$kl=$this->input->post('kl');
		$komponen_input=$this->input->post('komponen_input');
		$pnbp=$this->input->post('pnbp');		
		$sasaran_kegiatan=$this->input->post('sasaran_kegiatan');
		$target=$this->input->post('target');
		$urutan=$this->input->post('urutan');
		$kode=$this->input->post('kode');
		$tipe_input=$this->input->post('tipe_input');
		$info=$this->get_row($id);	
		$info_program=$info->program;
		$kode_direktorat_child=$info->kode_direktorat_child;
		$id_data_renja=$info->id_data_renja;
		$tahun_berlaku=$info->tahun_berlaku;

		$target=str_replace('"','',$target);
		$komponen_input=str_replace('"','',$komponen_input);
		$indikator=str_replace('"','',$indikator);
		$tipe_parent=$this->get_tipe_parent($program);
		$tipe="";
		if($tipe_parent=="program"){
			$tipe="indikator";		}  
		else if($tipe_parent=="indikator"){
			$tipe="komponen_input";
		} else if($tipe_parent=="komponen_input"){
			$tipe="sub_komponen_input";
		} else if($tipe_parent==""){
			$tipe="indikator";		
		} 
  		$data=array(
 		 'tipe'=>$tipe,
 		 'urutan'=>$urutan,
 		 'parent'=>$program,
  		 'indikator'=>$indikator,
		 'kode_komponen_input'=>$sasaran_kegiatan,
		 'komponen_input'=>$komponen_input,
 		 'sasaran_program'=>$sasaran_kegiatan,
		 'sasaran_kegiatan'=>$sasaran_kegiatan,
		 'target'=>$target,
 		 'bo01'=>$bo001,
		 'bo02'=>$bo002,
		 'bno_rm_p'=>$bno_rm_p,
		 'bno_rm_d'=>$bno_rm_d,
		 'bno_phln_p'=>$bno_phln_p,
		 'bno_phln_d'=>$bno_phln_d,
		 'pnbp'=>$pnbp,
		 'kode'=>trim($kode),
 		 'kl'=>$kl,
		 'kode_direktorat_child'=>$kode_direktorat_child,
		 'id_data_renja'=>$id_data_renja,
		 'tahun_berlaku'=>$tahun_berlaku
 		);
 		if($info_program!=""){	
			$data = array_merge($data, array("program"=>$program));
		}

		 								
		if($tipe_input=="0"){
			$this->db->trans_start();
			$this->db->insert('data_template_renja',$data);
			$this->db->trans_complete(); 
			$this->reset_indikator_affter_insert_sub_komponen_input();
			echo "<i class='glyphicon glyphicon-ok'> </i>  SUKSES MELAKUKAN PENAMBAHAN DATA !!!";
		} else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('data_template_renja', $data); 
			$this->db->trans_complete();
			$this->reset_indikator_affter_insert_sub_komponen_input();
			echo "<i class='glyphicon glyphicon-ok'> </i>  SUKSES MELAKUKAN PERUBAHAN DATA !!!";
		}
		/* INSERT TO HISTORY */
		$data = array_merge($data, array("id"=>$id));
		$json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
		/*-------------------*/
		$this->db->query("update template_renja set status_perbaikan='0' where id='".$id_data_renja."'");
	}
	function get_max_id(){
		$query = $this->db->query("select max(id) as max from data_template_renja");
   		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return  $row->max;
 			}
		}  
	}
	function reset_indikator_affter_insert_sub_komponen_input(){
		
		$param=$this->input->post('name');
		$id=$this->input->post('id');

		$tipe_input=$this->input->post('tipe_input');
		if($tipe_input=="0"){
			$id=$this->get_max_id();
		}
	
		if(empty($param)) {
			$id=$this->input->post('id');
			$info=$this->get_row($id);	
			//return false;
		} else {	
			$param=$this->input->post('name');
			$value=$this->input->post('value');
	 		$value=str_replace(".","",$value);
			$value=str_replace(",","",$value);
			$pieces = explode("|", $param);
			$id=$pieces[0];  
			$tipe=$pieces[1];  
		}
		$parent="";
		$kode="";
		$tipe="";
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
		

		$query = $this->db->query("select tipe,kode,parent from data_template_renja where id='".$id."'");
   		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($row->tipe=="sub_komponen_input"){
					$tipe=$row->tipe;
					$parent=$row->parent;
					$kode=$row->kode;
				} else {
					$parent=$this->input->post('program');
					//return false;
				}
 			}
		}  
		 
 	    $info=$this->get_row($id);	
  		$info_program=$info->program;
		$kode_direktorat_child=$info->kode_direktorat_child;
		$id_data_renja=$info->id_data_renja;
		$tahun_berlaku=$info->tahun_berlaku;
		$id_data_renja="";
	 	$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.parent)='".trim($parent)."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_berlaku)."' and kode!=''"); 
   			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				
  						
  						$total_bo1=$total_bo1+$data->bo01;
						$total_bo2=$total_bo2+$data->bo02;					
						$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
						$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
						$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
						$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
						$total_pnbp=$total_pnbp+$data->pnbp; 
						$id_data_renja=$data->id_data_renja;			 
			}
		}	 
 
 		$this->db->query("update data_template_renja set bo01='".$total_bo1."' where kode='".$parent."' and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set bo02='".$total_bo2."' where kode='".$parent."'  and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set bno_rm_p='".$total_rm_pusat."' where kode='".$parent."'  and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set bno_rm_d='".$total_rm_daerah."' where kode='".$parent."'  and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set bno_phln_p='".$total_phln_pusat."' where kode='".$parent."'  and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set bno_phln_d='".$total_phln_daerah."' where kode='".$parent."'  and id_data_renja='".$id_data_renja."'");
		$this->db->query("update data_template_renja set pnbp='".$total_pnbp."' where kode='".$parent."'");
		
 	}
	function load_kesalahan($id=""){
		$query=$this->db->query("select  keterangan_tandai from data_template_renja where id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->keterangan_tandai;
				}
				 echo $menus;
			}			
	}
	function get_combo_mapping($tipe=""){
		$data=array(
			'A'=>0,
			'B'=>1,
			'C'=>2,
			'D'=>3,
			'E'=>4,
			'F'=>5,
			'G'=>6,
			'H'=>7,
			'I'=>8,
			'J'=>9,
			'K'=>10,
			'L'=>11,
			'M'=>12,
			'N'=>13,
			'O'=>14,
			'P'=>15,
			'Q'=>16,
			'R'=>17,
			'S'=>18,
			'T'=>19,
			'U'=>20,
			'V'=>21,
			'W'=>22,
			'X'=>23,
			'Y'=>24,
			'Z'=>25,
			'AA'=>26,
			'AB'=>27,
			'AC'=>28,
			'AD'=>29,
			'AE'=>30,
			'AF'=>31,
			'AG'=>32,
			'AH'=>33,
			'AI'=>34,
			'AJ'=>35,
			'AK'=>36,
			'AL'=>37,
			'AM'=>38,
			'AN'=>39,
			'AO'=>40,
			'AP'=>41,
			'AQ'=>42,
			'AR'=>43,
			'AS'=>44,
			'AT'=>45,
			'AU'=>46,
			'AV'=>47,
			'AW'=>48,
			'AX'=>49,
			'AY'=>50,
			'AZ'=>51,
		);
		$combo="<select class='form-control'  style='width:120px'  id='".$tipe."' name='".$tipe."'>";
		foreach ($data as $key => $value) {
				 $combo.="<option value='".$value."'>".$key."</option>";
		} 
		$combo.="</select>";
		return  $combo;
	}
	function get_renja_value($id="",$field=""){
		$query=$this->db->query("select * from data_template_renja a where a.id='$id'");
		return 	$query->row();
	}
	function simpan_komponen_input($id=""){
		$info=$this->get_renja_value($id);
		$kode_komponen_input=$this->input->post('urutan'); 
	 	$komponen_input=$this->input->post('komponen_input'); 
	 	$sasaran_kegiatan=$this->input->post('sasaran_kegiatan'); 

	 	$sasaran_kegiatan=$this->input->post('sasaran_kegiatan'); 
	 	$target=$this->input->post('target'); 
	 	$bo001=$this->input->post('bo001'); 
	 	$bo002=$this->input->post('bo002'); 

	 	$bno_rm_p=$this->input->post('bno_rm_p'); 
	 	$bno_rm_d=$this->input->post('bno_rm_d'); 

	 	$bno_phln_p=$this->input->post('bno_phln_p'); 
	 	$bno_phln_d=$this->input->post('bno_phln_d'); 
	 	$pnbp=$this->input->post('pnbp'); 
	 	$kode_kl=$this->input->post('kl'); 
	 	$target_kinerja=$this->input->post('target_kinerja'); 
	 	$target_keuangan=$this->input->post('target_keuangan'); 
	 	
				$data=array(
				 	 'id_data_renja'=>$info->id_data_renja,
					 'parent'=>$info->program,
					 'kode_direktorat_child'=>$info->kode_direktorat_child,
					 'kode_direktorat'=>$info->kode_direktorat,
					 'program'=>"",
					 'kode_indikator'=>$info->kode_indikator,
					 'indikator'=>$kode_komponen_input,
					 'kode_komponen_input'=>"",
					 'komponen_input'=>$komponen_input,
					 'sub_komponen_input'=>"",
					 'sasaran_program'=>$sasaran_kegiatan,
					 'sasaran_kegiatan'=>$sasaran_kegiatan,
					 'target'=>$target,
					 'bo01'=>$bo001,
					 'bo02'=>$bo002,
					 'bno_rm_p'=>$bno_rm_p,
					 'bno_rm_d'=>$bno_rm_d,
					 'bno_phln_p'=>$bno_phln_p,
					 'bno_phln_d'=>$bno_phln_d,
					 'pnbp'=>$pnbp,
					 'kl'=>$kode_kl,
					 'tahun_berlaku'=>$info->tahun_berlaku,
					 'unit'=>$info->unit,
					 'target_kinerja'=>$target_kinerja,
					 'target_keuangan'=>$target_keuangan,
				);
	        	 
			  	$this->db->trans_start();
				$this->db->insert('data_template_renja',$data);
				$this->db->trans_complete();  

				/* INSERT TO HISTORY */
				$data = array_merge($data, array("id"=>$id));
				$json=json_encode($data);
				$this->load->model("history_model"); 
				$this->history_model->simpan('renja','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PENAMBAHAN / PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
				/*-------------------*/
				$this->db->query("update template_renja set status_perbaikan='0' where id='".$info->id_data_renja."'");
	}
	function get_child2 ($parent="",$id="",$kode_indikator=""){
		 $table="";
 		 $query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where trim(a.indikator)='".$parent."' and a.id_data_renja='".$id."' and program='' order by a.urutan asc"); 
	  		 //echo $this->db->last_query()."<br>";
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
 					$table.="<tr>";
						$table.="<td></td>";
						$table.="<td>".$data->indikator." &nbsp; ".$data->komponen_input."</td>";
					$table.="</tr>";
				}
			}	 
 		return $table;		
	}
	function get_child($parent="",$id="",$kode_indikator=""){
		 $table="";
 		 $query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where trim(a.kode_indikator)='".$parent."' and a.id_data_renja='".$id."' and program='' order by a.urutan asc"); 
	  		// echo $this->db->last_query()."<br>";
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
 					$table.="<tr>";
						$table.="<td></td>";
						$table.="<td>".$data->indikator." &nbsp; ".$data->komponen_input."</td>";
						//$this->db->query("update data_template_renja set parent='".$data->kode_indikator."'  , urutan='".$data->program."' where id='".$data->id."' and program=''");	
						if($this->cekChild1($data->program,$id,$data->kode_indikator)){ 
							$table.="<td>".$this->count_child($data->parent,$id)."</td>";
						} else {
							$table.="<td>".$this->count_child($data->parent,$id)."</td>";
						} 
						$table.=$this->get_child($data->parent,$id);
						$table.=$this->get_child2($data->parent,$id);
					$table.="</tr>";
				}
			}	 
 		return $table;		
	}
	function count_child($parent="",$id="",$kode_indikator=""){
		$query=$this->db->query("select count(1) as jumlah from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."'  and parent='".$parent."' and program='' order by a.urutan asc");
  	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
					return $data->jumlah;
				}
			}
	}
	function cekChild1($parent="",$id="",$kode_indikator=""){
 		 $q=$this->db->query("select a.program from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$parent."'"); 
			 
 	 		if($q->num_rows() > 0){
				return TRUE;
			}
	}
	function set_numbering($id=""){
		$table="";
		$table.="<table border='1'>";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and   a.kode_direktorat='' and program !='' order by a.id,a.program,a.indikator asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					//$this->db->query("update data_template_renja set urutan='".$data->program."' where id='".$data->id."'");	
					$table.="<tr>";
						$table.="<td>".$data->program."</td>";
						$table.="<td>".$data->indikator."</td>";
						if($this->cekChild1($data->program,$id,$data->kode_indikator)){ 
							//$table.="<td>".$this->count_child($data->program,$id,$data->kode_indikator)."</td>";
							//$table.=$this->get_child($data->parent,$id);
						} else {
							//$table.="<td>".$this->count_child($data->program,$id)."</td>";
						}
						$table.=$this->get_child($data->program,$id);
						$table.="</tr>";
				}
			}	
		$table.="</table>";	
		echo $table;		
	}

	function cek_is_open_lock($tipe='',$bulan=""){
		$query=$this->db->query("select * from locking where tipe='".$tipe."' and bulan='".$bulan."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
						return $data->status;
 				}
 			}
		}
	

	function fuck_reset_after_upload_excel($id_data_renja,$kode_direktorat_child,$tahun_anggaran){
		$menus="";
  		$this->load->model("template_renja_model"); 
		$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='sub_komponen_input'	
 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' "); 
   	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				   
					$menus[]=$data->parent;			 
				}
			}	 
			$total_bo1=0;
			$total_bo2=0;
			$total_rm_pusat=0;
			$total_rm_daerah=0;
			$total_phln_pusat=0;
			$total_phln_daerah=0;
			$total_pnbp=0;	  
			if(count($menus) > 0){
				return false;
			}
 			$menus=array_unique($menus);
			foreach ($menus as $row){
					$query=$this->db->query("select *,
					(select sum(bo01) as bo01 from data_template_renja where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_template_renja where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_template_renja where parent='".$row."') as pnbp 
 					from data_template_renja  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='komponen_input'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
  		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_template_renja set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set pnbp='".$datax->pnbp."' where kode='".$row."'");
								$this->db->query("update data_template_renja set pnbp='".$datax->pnbp."' where kode='".$row."'");
								//$menus[]=$data->parent;		
 						}
					}	 
			}
			
  				$this->load->model("template_renja_model"); 
				$query=$this->db->query("select * from data_template_renja  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='komponen_input'	
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' "); 
		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {						   
							$menus[]=$data->parent;			 
						}
					}	 
				$total_bo1=0;
				$total_bo2=0;
				$total_rm_pusat=0;
				$total_rm_daerah=0;
				$total_phln_pusat=0;
				$total_phln_daerah=0;
				$total_pnbp=0;	 
		 
 			$menus=array_unique($menus);
			foreach ($menus as $row){
					$query=$this->db->query("select *,
					(select sum(bo01) as bo01 from data_template_renja where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_template_renja where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_template_renja where parent='".$row."') as pnbp 
 					from data_template_renja  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='indikator'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
  		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_template_renja set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set pnbp='".$datax->pnbp."' where kode='".$row."'");
  						}
					}	 
				}

		$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='indikator'	
 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' "); 
  	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {						   
					$menus[]=$data->parent;			 
				}
			}	 
				$total_bo1=0;
				$total_bo2=0;
				$total_rm_pusat=0;
				$total_rm_daerah=0;
				$total_phln_pusat=0;
				$total_phln_daerah=0;
				$total_pnbp=0;	 
		 
 			$menus=array_unique($menus);
			foreach ($menus as $row){
					$query=$this->db->query("select *,
					(select sum(bo01) as bo01 from data_template_renja where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_template_renja where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_template_renja where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_template_renja where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_template_renja where parent='".$row."') as pnbp 
 					from data_template_renja  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='program'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
  		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_template_renja set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_template_renja set pnbp='".$datax->pnbp."' where kode='".$row."'");
  						}
					}	 
				}
		}
		function get_kewenangan($id=""){
			$select="";
			$select.="<select class='form-control input-sm' id='kewenangan' name='kewenangan'>";
			$select.="<option value=''>-Pilih Kewenangan-</option>";
			$q2 = $this->db->query("select *  from kewenangan order by nama_kewenangan asc");
			if ($q2->num_rows() > 0) {
				foreach ($q2->result() as $row) {
					 $selected="";
					 if($id==$row->id){
					 	$selected="selected='selected'";
					 }
					 $select.="<option $selected value='$row->id'>".$row->nama_kewenangan." / (<b><i>". $row->kode ."</i> </b> )</option>";
				} 
			}
			$select.="</select>";
			return $select;
		}	
		function log_persetujuan($dari="",$tahun=""){     		 
			$query=$this->db->query("select *,a.dari as daridirektorat,tahun_anggaran.tahun_anggaran as tahun_anggaran,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  ,
			(select nama_tahapan from tahapan_dokumen where id_dokumen=a.tahapan_dokumen) as tahapan_dokumen  
			from log_template_renja a 
			left join t_user on t_user.id=a.approve_by 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran 
			where 1=1   and a.dari='".$dari."' and a.tahun_anggaran='".$tahun."' order by a.tahapan_dokumen desc ");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
 	}
?>
