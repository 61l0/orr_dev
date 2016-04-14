<?php
class exercise_model extends CI_Model
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
     
			$query=$this->db->query("select *,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
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
			where 1=1 $sql");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
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
     	$query=$this->db->query("select *,
     		(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
     		(select kd_unit_kerja from m_unit_kerja where id_divisi=a.dari) as direktorat, 
     		(select tahun_anggaran from tahun_anggaran where id=a.tahun_anggaran) as tahun_anggaran, 
     		(select tahun_anggaran from tahun_anggaran where id=a.tahun_anggaran) as tahun_anggaran_dasar, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
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
		$select.="<select id='unit' class='form-control' style='width:300px' name='unit'>";
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
	function filter_get_direktorat(){
		$select="";
		$sql="";
		$pusat=$this->session->userdata('PUSAT'); 
		$unit=$this->session->userdata('ID_DIREKTORAT');
		if($pusat=="0"){
			$sql= " where id_divisi='".$unit."'";
		}

		$select.="
		<select id='unit' class='form-control' onchange='return refresh_table()' style='width:300px;float:left' name='unit'>";
 		$select.="<option value=''>-Pilih Direktorat / Semua-</option>";
 		$q2 = $this->db->query("select * from m_unit_kerja ".$sql." order by nama_unit_kerja asc");
 
		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				 
				 	$select.="<option value='$row->id_divisi'>$row->nama_unit_kerja</option>";
				 
			}
		}
		$select.="</select>";
		return $select;
	}
	function filter_tahun_anggaran(){
		$select="";
		$select.="<select id='tahun_anggaran' onchange='return refresh_table()' class='form-control sm' 
		style='width:20%;font-size:15px;padding:5px;margin-right:10px;float:left' name='tahun_anggaran'>";
		$select.="<option value=''>-Pilih Tahun Anggaran-</option>";
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
	 
	 
	function isletter($char=""){
		if (preg_match('/[a-zA-Z]/', $char)) :
		    return $char.' is a letter<br>';
		endif;
	}

	function get_total_all_3($field="",$kode_direktorat="",$tahun_anggaran=""){
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
		 $array=array();
		$query=$this->db->query("select   *,a.id as id, SUBSTRING_INDEX(indikator, '.',1) as indikator_vroh  
			from data_temp_exercise  a
			left join template_renja on template_renja.id= a.id_data_renja
			left join m_unit_kerja on m_unit_kerja.id_divisi= template_renja.dari
			where a.tahun_berlaku like '%$tahun_anggaran%' and  a.kode_direktorat_child like 
			'%$kode_direktorat%' order by a.id asc");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$isletter="";
			 	$isletter_hurup= $this->isletter($data->indikator);
			 	$datanya=trim($data->$field);
				if ((empty($data->kode_direktorat)) and  (empty($data->program))  and(!empty($datanya))   ){
					$total_bo1=$total_bo1+$data->bo01;
					$total_bo2=$total_bo2+$data->bo02;
					$total_rm_pusat=$total_rm_pusat + $data->bno_rm_p;
					$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
					$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
					$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
					$total_pnbp=$total_pnbp+$data->pnbp;
					$array[]=array(
						'id'=>$data->id,
						'indikator'=>$data->indikator,
						'var'=>$data->$field,
					);
					 
					/*echo $data->indikator." = ". $data->$field ."<br>";*/
				}
			}
		}
		
		$j=0;
		$nilai_total=0;
		for($i=0;$i<=count($array) -1; $i++){
			$isletter_hurup= $this->isletter($array[$i]['indikator']);
			if(!empty($array[$i+1]['indikator'])){
				$isletter_hurup_next= $this->isletter($array[$i+1]['indikator']);	
			} 
			$indi=trim(preg_replace('/[.,]/', '', $array[$i]['indikator']));
			if ((is_numeric($indi))  and (empty($isletter_hurup_next))){
				 
					$nilai_total=$nilai_total+$array[$i]['var'];
					$j=$j+1;
			}
			if(!empty($isletter_hurup)){
					 
						$nilai_total=$nilai_total+$array[$i]['var'];
					$j=$j+1;

			}
		}
		return $nilai_total;

	}
	function get_total_all_2($field="",$id_data_renja="",$kode=""){
 		$jumlah=0;
 		$sql="";

 		if($kode!=""){
 			$sql.=" and parent='".$kode."'";
 		}
 		$query=$this->db->query("select childnya from (select ".$field.",kode,tipe,
	 		(select count(1) as total_child from data_template_renja where parent=a.kode and id_data_renja=a.id_data_renja  and trim(tipe)!='program'     and kode!='') as childnya  from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id_data_renja."'  and trim(tipe)!='program'  and ".$field."!='0'  ".$sql."  
 			order by a.urutan asc) as mytable where childnya='0'"); 	 
        			 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {		
					$jumlah=$jumlah+1;
					/*if(($data->$field !="0") and ($data->$field!="") ){
	 					$jumlah=$jumlah+1;
						if ($this->cek_child_anak($field,$id_data_renja,$data->kode)) {
							 $jumlah=$jumlah+1;
						}
					}*/
			  	}		
			}  
			return $jumlah;
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
				$isletter= $this->isletter($data->kode_komponen_input);;
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
	function get_hasil_exercise($id=""){
		$table="";
		$query=$this->db->query("select * from data_temp_exercise where id_data_renja='".$id."' order by id asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
					$mark=$data_f->mark;
					$ditandai="";
					if($mark=="1") {
						$ditandai=" ;background-color:#F2DEDE";
					}		
				 	$table.="<tr>";
		        	$value_kol1=trim($data_f->kode_direktorat);
		        	$value_kol2=trim($data_f->program);
		        	$value_kol3=trim($data_f->indikator);
		        	$value_kol4=trim($data_f->komponen_input);
		        	$bg_ikk="";

		        	$kode_direktorat=$data_f->kode_direktorat;
		        	if($kode_direktorat!=""){
		        		$kodedir=$data_f->kode_direktorat;
		        	} else {
		        		$kode_direktorat=$kode_direktorat;
		        	}

		        	if (empty($value_kol3)   and  empty($value_kol4)) {
		        		$bg_ikk="background-color:#F9F9F9;font-weight:bold". $ditandai;	
		        		$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->kode_direktorat))."</td>";
		        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."' colspan='3'>". strtoupper(trim($data_f->program))."</td>";
		        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sasaran_program))."</td>";
						$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->target))."</td>";
			        } else {
			        	$bg_ikk=  $ditandai;	
			        	$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->kode_direktorat))."</td>";
		        		$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->program))."</td>";
		        		if (empty($value_kol1)   and  (!(empty($value_kol2)))) {
			        			$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."' colspan='3'>". strtoupper(trim($data_f->indikator))."</td>";
			        		    $table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->target))."</td>";
			        	} else {
			        			$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->indikator))."</td>";
							    $table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->komponen_input))."</td>";
					        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sasaran_program))."</td>";
								$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->target))."</td>";
			        		
			        	}
			        }
		        	 
			        if($data_f->kode_direktorat==""){
		        	
		        	if (is_numeric($data_f->bo01)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bo01)))."</td>";
			        } else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bo01)))."</td>";
			        }
			        if (is_numeric($data_f->bo02)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bo02)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bo02)))."</td>";
		        	}	
		 			
		 			if (is_numeric($data_f->bno_rm_p)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bno_rm_p)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>".  strtoupper(trim(($data_f->bno_rm_p)))."</td>";
		        	}		

		        	if (is_numeric($data_f->bno_rm_d)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bno_rm_d)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bno_rm_d)))."</td>";
		        	}		

		        	if (is_numeric($data_f->bno_phln_p)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bno_phln_p)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bno_phln_p)))."</td>";
		        	}		
		        	 
					if (is_numeric($data_f->bno_phln_d)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->bno_phln_d)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bno_phln_d)))."</td>";
		        	}	

					if (is_numeric($data_f->pnbp)){
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->pnbp)))."</td>";
		        	} else {
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->pnbp)))."</td>";
		        	}	

					$total_all=0;
					$total_all=$data_f->bo01+
					$data_f->bo02+$data_f->bno_rm_p+$data_f->bno_rm_d+$data_f->bno_phln_p+$data_f->bno_phln_d+
					$data_f->pnbp;
			        $table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". 
			        strtoupper(trim(number_format($total_all)))."</td>";
		        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->kl))."</td>";
		 			$table.="</tr>";
		 		}	
				}				 
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	 
	function get_data_rekap($id=""){
		$table="";
		$table="";
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
						$table.="<td colspan='3' ".$style_header."><b>".strtoupper($data_f->program)."</b></td>";
						$table.="<td ".$style_header."><b>".strtoupper($data_f->sasaran_program)."</b></td>";
						$table.="<td>".$data_f->target."</td>";

						$table.="<td $style_header id='f_sum_bo_01'><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header id='f_sum_bo_02'><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_p'><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_d'><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_p'><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_d'><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header id='f_sum_pnbp'><center>".number_format($pnbp)."</center></td>";
	
							$total_all=0;
							 
							$table.="<td $style_header id='f_sum_pagu'><center>".strtoupper(trim(number_format($total_all)))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-"; 						 
					        $table.="<td colspan='2' style='vertical-align:middle'>
					        <table>
					        		<tr>
					        			<td>	<input type='text' id='pagu' name='pagu' value='0' style='padding:4px;font-size:12px;width:90px'>
					      					 	<input type='hidden' id='pagu_asli' name='pagu_asli' value='0' style='padding:4px;font-size:12px;width:100%'></td>
					        			<td>";
					        $table.="<a onclick='return confirm_exercise()' class='btn btn-danger btn btn-sm btn-block' style='border-radius:0px;height:28.5px'><i class='glyphicon glyphicon-refresh'></i></a>";			
					        $table.="</td>
					        		</tr>
					        </table>";
					       	
				 			$table.="</td>";
				 			$table.="</tr>";
				 			if ($this->cek_child($id,$data_f->parent)) {
									$table.=$this->get_child_data_renja($id,$data_f->parent);
							}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='17'  style='vertical-align:middle;font-size:10px;text-align:right'> <center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";						 
					 
						$table.="</td>";
		 			$table.="</tr>";
			}

			return $table;
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
 
	function get_child_data_renja($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
 		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program' 
 			order by a.urutan asc");
  			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$class_editablex="";
						$mark=$data_f->mark;
						$ditandai="";
						if($mark=="1") {
							$ditandai="background-color:#F2DEDE !important";
						}	
						$style_header="style='min-width:60px !important;vertical-align:middle;font-size:11px;vertical-align:middle;".$ditandai."'";
						$table.="<tr>";
						 

						$kode="<center>".strtoupper(trim(($data_f->kode)))."</center>";
						if($data_f->tipe=="indikator"){
 							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center> <b>".($kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".ucwords(strtolower($data_f->indikator))."</td>";
							$class_editable="";
							 
							
						} else if($data_f->tipe=="komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><b><center> ".$kode."</b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
		 					
							
						}	else if($data_f->tipe=="sub_komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><center> <b> ".$kode." </b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
							 
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
	 							$bo001=number_format($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$bo002=number_format($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$bno_phln_p=number_format($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$bno_phln_d=number_format($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$bno_rm_p=number_format($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$bno_rm_d=number_format($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 							$pnbp=number_format($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));

	 							$total_all=number_format(
		 							$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun)) ;		
	 							} else if($data_f->tipe=="komponen_input"){
	 								$c=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
	 									if($c=="true"){
	 										/* BILA KOMPONEN INPUT MEMILIKI CHILD*/	
	 										$bo001=number_format($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$bo002=number_format($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$bno_phln_p=number_format($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$bno_phln_d=number_format($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$bno_rm_p=number_format($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$bno_rm_d=number_format($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
				 							$pnbp=number_format($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun));
	 								$total_all=number_format(
		 							$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun) + 
		 							$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun)) ;
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

							$table.="<td $style_header class='".$is_indikator."_bo01'>										
						        		<center>".strtoupper(trim(($bo001)))."</center>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bo02'>									
						        		<center>".strtoupper(trim(($bo002)))."</center>
					        		</td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_rm_p'>								
					        			<center>".strtoupper(trim(($bno_rm_p)))."</center>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_rm_d'>
						        		<center>".strtoupper(trim(($bno_rm_d)))."</center>
									</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_phln_p'>
							        		<center>".strtoupper(trim(($bno_phln_p)))."</center>
									 </td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_phln_d'>
							        		<center>".strtoupper(trim(($bno_phln_d)))."</center>
									</td>";

							$table.="<td $style_header  class='".$is_indikator."_pnbp'>
						        		<center>".strtoupper(trim(($pnbp)))."</center>
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
					        		<center>".$kl."</center></td>";	

							$table.="<td $style_header></td>";
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
	function echo_table_renja_hasil_exercise($id=""){
		$table="";
		$table="";
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
 
						
						$table.="<tr>";
						$table.="<td $style_header >".$data_f->kode_direktorat."</td>";
						$table.="<td colspan='3' ".$style_header."><b>".strtoupper($data_f->program)."</b></td>";
						$table.="<td ".$style_header."><b>".strtoupper($data_f->sasaran_program)."</b></td>";
						$table.="<td>".$data_f->target."</td>";

						$table.="<td $style_header id='f_sum_bo_01'><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header id='f_sum_bo_02'><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_p'><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_d'><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_p'><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_d'><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header id='f_sum_pnbp'><center>".number_format($pnbp)."</center></td>";
	
							$total_all=0;
							 
							$table.="<td $style_header id='f_sum_pagu'><center>".strtoupper(trim(number_format($total_all)))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";

							$class_editable="";
						 
					        $table.="<td colspan='2' style='vertical-align:middle'>";
					       	$table.="<input type='text' id='pagu' name='pagu' value='0' style='padding:4px;font-size:12px;width:100%'>";
				 			$table.="</td>";
				 			$table.="</tr>";
				 			if ($this->cek_child($id,$data_f->parent)) {
									$table.=$this->get_child_data_renja_hasil_exercise($id,$data_f->parent);
							}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='17'  style='vertical-align:middle;font-size:10px;text-align:right'> <center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";						 
					 
						$table.="</td>";
		 			$table.="</tr>";
			}

			return $table;
	}
 
 
 
 
 
	function get_child_data_renja_hasil_exercise($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
 		$query=$this->db->query("select *,
 			(select bo01 from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bo01,
 			(select bo02 from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bo02,
 			(select bno_rm_p from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bno_rm_p,
 			(select bno_rm_d from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bno_rm_d,
 			(select bno_phln_p from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bno_phln_p,
 			(select bno_phln_d from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as bno_phln_d,
 			(select pnbp from data_temp_exercise where kode=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as pnbp 
 			,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_temp_exercise a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program' 
 			order by a.urutan asc");
  			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				 $class_editable="";	
				$class_editablex="";
						$mark=$data_f->mark;
						$ditandai="";
						if($mark=="1") {
							$ditandai="background-color:#F2DEDE !important";
						}	
						$style_header="style='min-width:60px !important;vertical-align:middle;font-size:11px;vertical-align:middle;".$ditandai."'";
						$table.="<tr>";
					 	
						$kode="<center>".strtoupper(trim(($data_f->kode)))."</center>";
						if($data_f->tipe=="indikator"){
 							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center> <b>".($kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".ucwords(strtolower($data_f->indikator))."</td>";
							 
							
						} else if($data_f->tipe=="komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><b><center> ".$kode."</b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
 		 					 
							
						}	else if($data_f->tipe=="sub_komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><center> <b> ".$kode." </b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
							 
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
	 							$bo001=number_format($this->get_total_indikator_hasil_exercise('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bo002=number_format($this->get_total_indikator_hasil_exercise('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_p=number_format($this->get_total_indikator_hasil_exercise('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_d=number_format($this->get_total_indikator_hasil_exercise('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_p=number_format($this->get_total_indikator_hasil_exercise('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_d=number_format($this->get_total_indikator_hasil_exercise('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$pnbp=number_format($this->get_total_indikator_hasil_exercise('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));

	 							$total_all=number_format(
		 							$this->get_total_indikator_hasil_exercise('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;		
	 							} else if($data_f->tipe=="komponen_input"){
	 								$c=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
	 									if($c=="true"){
	 										/* BILA KOMPONEN INPUT MEMILIKI CHILD*/	
	 										$bo001=number_format($this->get_total_indikator_hasil_exercise('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bo002=number_format($this->get_total_indikator_hasil_exercise('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_phln_p=number_format($this->get_total_indikator_hasil_exercise('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_phln_d=number_format($this->get_total_indikator_hasil_exercise('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_rm_p=number_format($this->get_total_indikator_hasil_exercise('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$bno_rm_d=number_format($this->get_total_indikator_hasil_exercise('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
				 							$pnbp=number_format($this->get_total_indikator_hasil_exercise('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 								$total_all=number_format(
		 							$this->get_total_indikator_hasil_exercise('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator_hasil_exercise('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;
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

							$table.="<td $style_header class='".$is_indikator."_bo01'>										
						        		<center>".strtoupper(trim(($bo001)))."</center>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bo02'>									
						        		<center>".strtoupper(trim(($bo002)))."</center>
					        		</td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_rm_p'>								
					        			<center>".strtoupper(trim(($bno_rm_p)))."</center>
					        		</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_rm_d'>
						        		<center>".strtoupper(trim(($bno_rm_d)))."</center>
									</td>";

							$table.="<td $style_header   class='".$is_indikator."_bno_phln_p'>
							        		<center>".strtoupper(trim(($bno_phln_p)))."</center>
									 </td>";

							$table.="<td $style_header  class='".$is_indikator."_bno_phln_d'>
							        		<center>".strtoupper(trim(($bno_phln_d)))."</center>
									</td>";

							$table.="<td $style_header  class='".$is_indikator."_pnbp'>
						        		<center>".strtoupper(trim(($pnbp)))."</center>
									</td>";
							$table.="<td $style_header  class='".$is_indikator."_pagu'><center>".strtoupper(trim($total_all))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";

							$class_editable="";
 							 
							$table.="<td $style_header  class='".$is_indikator."_kl'>
					        		<center>".$kl."</center></td>";	

							$table.="<td $style_header></td>";
		 					$table.="</tr>";		 					
			 			if ($this->cek_child_anak($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja_hasil_exercise($id,trim($data_f->kode));
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
	function get_total_indikator_hasil_exercise($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id_data_renja=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
	  
	 	$query=$this->db->query("select * from data_temp_exercise  a			 
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
	function get_total_indikator($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran=""){
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
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!=''"); 
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
	function cek_child_anak($id="",$kode=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$kode."'   order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
			}
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
	function do_it($id=""){
		$total_bo1=0;
 		$total_bo2=0;
		$total_rm_pusat=0;
 		$total_rm_daerah=0;
 		$total_phln_pusat=0;
 		$total_phln_daerah=0;
 		$total_pnbp=0;
 		$selisih_pagu_lama=0;
		$pagu=$this->input->post('pagu');
		$pagu=preg_replace('/[.,]/', '', $pagu);
 		$info=$this->get_update($id);
		$total_semua_yang_kena=0;
 		$total_bo1=$this->get_total_all_2('bo01', $id);	
 		$total_bo2=$this->get_total_all_2('bo02',  $id);
 		$total_rm_pusat=$this->get_total_all_2('bno_rm_p',  $id);
 		$total_rm_daerah=$this->get_total_all_2('bno_rm_d',  $id);	
 		$total_phln_pusat=$this->get_total_all_2('bno_phln_p', $id);
 		$total_phln_daerah=$this->get_total_all_2('bno_phln_d', $id);
 		$total_pnbp=$this->get_total_all_2('pnbp', $id);
 		$total_semua_yang_kena=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
  		$pagu_asli=$this->input->post('pagu_asli');
 		$this->db->query("delete from data_temp_exercise where id_data_renja='".$id."'");
  		$selisih_pagu=$pagu-$pagu_asli;
 		//$selisih_persentase=($selisih_pagu/$pagu_asli)*100;
 		$nominal_yang_harus_dibagi=($selisih_pagu/$total_semua_yang_kena);
 		$nominal_yang_harus_dibagi=number_format($nominal_yang_harus_dibagi, 0, '.', '');
 		
 		 

   		$this->exercise_bro($id,$nominal_yang_harus_dibagi);
   		$this->fuck_reset_after_upload_excel($id,$info->direktorat,$info->tahun_anggaran);
   		/* PERSENTASE PAGU ASLI */ 
 		/*$persen_bo01=($total_bo1/$pagu_asli)*100;
 		$persen_bo02=($total_bo2/$pagu_asli)*100;
 		$persen_rm_pusat=($total_rm_pusat/$pagu_asli)*100;
 		$persen_rm_daerah=($total_rm_daerah/$pagu_asli)*100;
 		$persen_phln_pusat=($total_phln_pusat/$pagu_asli)*100;
 		$persen_phln_daerah=($total_phln_daerah/$pagu)*100;
 		$persen_pnbp=($total_pnbp/$pagu_asli)*100;
 		/*----------------------*/
 		/* PERSENTASE PAGU BARU */ 
 		/*$persen_baru_bo01=($pagu * $persen_bo01) / 100;
 		$persen_baru_bo02=$pagu * ($persen_bo02 / 100);
 		$persen_baru_rm_pusat=$pagu * ($persen_rm_pusat / 100);
 		$persen_baru_rm_daerah=$pagu * ($persen_rm_daerah / 100);
 		$persen_baru_phln_pusat=$pagu * ($persen_phln_pusat / 100);
 		$persen_baru_phln_daerah=$pagu * ($persen_phln_daerah / 100);
 		$persen_baru_pnbp=$pagu * ($persen_pnbp / 100);
 		/*----------------------*/
 		
 		/*echo "<style>body{font-size:10px;}</style>";
 		echo "PAGU LAMA=<b> Rp . ".number_format($pagu_asli)."</b><br>";
 		echo "BO01=".number_format($total_bo1) .' - '.number_format($persen_bo01)." % <br>";
 		echo "BO02=".number_format($total_bo2) .' - '.number_format($persen_bo02)."  %<br>";
 		echo "RM_PUSAT=".number_format($total_rm_pusat) .' - '.number_format($persen_rm_pusat)."  % <br>";
 		echo "RM_DAERAH=".number_format($total_rm_daerah) .' - '.number_format($persen_rm_daerah)."  %<br>";
 		echo "PHLN_PUSAT=".number_format($total_phln_pusat) .' - '.number_format($persen_phln_pusat)." %<br>";
 		echo "PHLN_DAERAH=".number_format($total_phln_daerah) .' - '.number_format($persen_phln_daerah)."  %<br>";
 		echo "PNBP=".number_format($total_pnbp) .' - '.number_format($persen_pnbp)."<br>";
 		echo "<hr>";
 		echo "PAGU BARU=<b> Rp . ".number_format($pagu)."</b><br>";
 		echo "BO01 EXERCISE=".number_format($persen_baru_bo01)."  <br>";
 		echo "BO02 EXERCISE=".number_format($persen_baru_bo02)."  <br>";
 		echo "RM_PUSAT EXERCISE=".number_format($persen_baru_rm_pusat)."   <br>";
 		echo "RM_DAERAH EXERCISE=".number_format($persen_baru_rm_daerah)."  <br>";
 		echo "PHLN_PUSAT EXERCISE=".number_format($persen_baru_phln_pusat)."  <br>";
 		echo "PHLN_DAERAH EXERCISE=".number_format($persen_baru_phln_daerah)."  <br>";
 		echo "PNBP EXERCISE=".number_format($persen_baru_pnbp)."<br>";
 		echo "<hr>"; */

 		/*$this->copy_table($info->tahun_anggaran,$info->direktorat);
 		$this->exercise_bro('bo01',$info->tahun_anggaran,$info->direktorat,$total_bo1,$persen_baru_bo01);
 		$this->exercise_bro('bo02',$info->tahun_anggaran,$info->direktorat,$total_bo2,$persen_baru_bo02);
 		
 		$this->exercise_bro('bno_rm_p',$info->tahun_anggaran,$info->direktorat,$total_rm_pusat,$persen_baru_rm_pusat);
 		$this->exercise_bro('bno_rm_d',$info->tahun_anggaran,$info->direktorat,$total_rm_daerah,$persen_baru_rm_daerah);
 		$this->exercise_bro('bno_phln_p',$info->tahun_anggaran,$info->direktorat,$total_phln_pusat,$persen_baru_phln_pusat);
 		$this->exercise_bro('bno_phln_d',$info->tahun_anggaran,$info->direktorat,$persen_phln_daerah,$persen_baru_phln_daerah);
 		$this->exercise_bro('pnbp',$info->tahun_anggaran,$info->direktorat,$total_pnbp,$persen_baru_pnbp);
 	 	
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bo01');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bo02');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bno_rm_p');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bno_rm_d');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bno_phln_p');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'bno_phln_d');
 		$this->set_header($info->tahun_anggaran,$info->direktorat,'pnbp');
 		
 		$this->cek_komponen_input('bo01',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('bo02',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('bno_rm_p',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('bno_rm_d',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('bno_phln_p',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('bno_phln_d',$info->direktorat,$info->tahun_anggaran);
 		$this->cek_komponen_input('pnbp',$info->direktorat,$info->tahun_anggaran);*/
 	 
 		$message ="<span style='font-size:14px'><i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Melakukan Generate Data Exercise</b></span><br>";
		echo  $message;		
	}
 
	 
	function exercise_bro($id_data_renja="",$jumlah=""){
	 	$query=$this->db->query("select *
	 	  ,(select count(1) as total_child from data_template_renja where parent=a.kode) as childnya   
	 	  from data_template_renja a where a.id_data_renja='".$id_data_renja."'  and tipe!=''");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$bo01=$data->bo01;
						$bo02=$data->bo02;
			 			$bno_phln_d=$data->bno_phln_d;
						$bno_phln_p=$data->bno_phln_p;
						$bno_rm_d=$data->bno_rm_d;
						$bno_rm_p=$data->bno_rm_p;						
						$pnbp=$data->pnbp;
						 
						if($bo01!="0"){
							$bo01=$bo01+$jumlah;
						}
						if($bo02!="0"){
							$bo02=$bo02+$jumlah;
						}
						if($bno_phln_d!="0"){
							$bno_phln_d=$bo01+$jumlah;
						}
						if($bno_phln_p!="0"){
							$bno_phln_p=$bno_phln_p+$jumlah;
						}
						if($bno_rm_p!="0"){
							$bno_rm_p=$bno_rm_p+$jumlah;
						}
						if($bno_rm_d!="0"){
							$bno_rm_d=$bno_rm_d+$jumlah;
						}
						if($pnbp!="0"){
							$pnbp=$pnbp+$jumlah;
						}

						$data=array(
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
						'bo01'=> $bo01 ,
						'bo02'=>  $bo02,
						'bno_rm_p'=>$bno_rm_p ,
						'bno_rm_d'=> $bno_rm_d ,
						'bno_phln_p'=>$bno_phln_p ,
						'bno_phln_d'=> $bno_phln_d,
						'pnbp'=>$pnbp ,
						'kl'=>$data->kl,
						'tahun_berlaku'=>$data->tahun_berlaku,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
 					);
						$this->db->trans_start();
						$this->db->insert('data_temp_exercise',$data);
						$this->db->trans_complete();


				}
			}	
	}
	function exercise_bro_normalisasi_tahap_satu($id_data_renja="",$jumlah=""){
		$query=$this->db->query("select *
	 	  ,(select count(1) as total_child from data_template_renja where parent=a.kode) as childnya   
	 	  from data_template_renja a where a.id_data_renja='".$id_data_renja."'  and tipe!=''");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$bo01=$data->bo01;
						$bo02=$data->bo02;
			 			$bno_phln_d=$data->bno_phln_d;
						$bno_phln_p=$data->bno_phln_p;
						$bno_rm_d=$data->bno_rm_d;
						$bno_rm_p=$data->bno_rm_p;						
						$pnbp=$data->pnbp;
						 
						if($bo01!="0"){
							$bo01=$bo01+$jumlah;
						}
						if($bo02!="0"){
							$bo02=$bo02+$jumlah;
						}
						if($bno_phln_d!="0"){
							$bno_phln_d=$bo01+$jumlah;
						}
						if($bno_phln_p!="0"){
							$bno_phln_p=$bno_phln_p+$jumlah;
						}
						if($bno_rm_p!="0"){
							$bno_rm_p=$bno_rm_p+$jumlah;
						}
						if($bno_rm_d!="0"){
							$bno_rm_d=$bno_rm_d+$jumlah;
						}
						if($pnbp!="0"){
							$pnbp=$pnbp+$jumlah;
						}

					$data=array(
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
						'bo01'=> $bo01 ,
						'bo02'=>  $bo02,
						'bno_rm_p'=>$bno_rm_p ,
						'bno_rm_d'=> $bno_rm_d ,
						'bno_phln_p'=>$bno_phln_p ,
						'bno_phln_d'=> $bno_phln_d,
						'pnbp'=>$pnbp ,
						'kl'=>$data->kl,
						'tahun_berlaku'=>$data->tahun_berlaku,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
 					);
						$this->db->trans_start();
						$this->db->insert('data_temp_exercise',$data);
						$this->db->trans_complete();


				}
			}
	}
	function exercise_bro_normalisasi_tahap_dua($id_data_renja="",$jumlah=""){
		$query=$this->db->query("select *
	 	  ,(select count(1) as total_child from data_temp_exercise where parent=a.kode) as childnya   
	 	  from data_temp_exercise a where a.id_data_renja='".$id_data_renja."'  and tipe!=''");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$bo01=$data->bo01;
						$bo02=$data->bo02;
			 			$bno_phln_d=$data->bno_phln_d;
						$bno_phln_p=$data->bno_phln_p;
						$bno_rm_d=$data->bno_rm_d;
						$bno_rm_p=$data->bno_rm_p;						
						$pnbp=$data->pnbp;
						 
						if($bo01!="0"){
							$bo01=$bo01+$jumlah;
						}
						if($bo02!="0"){
							$bo02=$bo02+$jumlah;
						}
						if($bno_phln_d!="0"){
							$bno_phln_d=$bo01+$jumlah;
						}
						if($bno_phln_p!="0"){
							$bno_phln_p=$bno_phln_p+$jumlah;
						}
						if($bno_rm_p!="0"){
							$bno_rm_p=$bno_rm_p+$jumlah;
						}
						if($bno_rm_d!="0"){
							$bno_rm_d=$bno_rm_d+$jumlah;
						}
						if($pnbp!="0"){
							$pnbp=$pnbp+$jumlah;
						}

					$dataarray=array(
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
						'bo01'=> $bo01 ,
						'bo02'=>  $bo02,
						'bno_rm_p'=>$bno_rm_p ,
						'bno_rm_d'=> $bno_rm_d ,
						'bno_phln_p'=>$bno_phln_p ,
						'bno_phln_d'=> $bno_phln_d,
						'pnbp'=>$pnbp ,
						'kl'=>$data->kl,
						'tahun_berlaku'=>$data->tahun_berlaku,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
 					);
						$this->db->trans_start();
						$this->db->where('id',$data->id);
						$this->db->update('data_temp_exercise', $dataarray); 
						$this->db->trans_complete();

					 


				}
			}
	}
 	function update_last_exercise_normalisasi($id_data_renja="",$jumlah=""){
		$query=$this->db->query("
	 	  select id,kode , bno_rm_p,childnya from(select *,a.id as idnya
	 	  ,(select count(1) as total_child from data_temp_exercise where parent=a.kode) as childnya   
	 	  from data_temp_exercise a where a.id_data_renja='".$id_data_renja."'   ) as mytable  where childnya='0' limit 0,1
		");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 
						$bno_rm_p=$data->bno_rm_p;						
 						 
						if($bno_rm_p!="0"){
							$bno_rm_p=$bno_rm_p+$jumlah;
						}
					$dataarray=array( 						 
						'bno_rm_p'=>$bno_rm_p ,						 
 					);
					$this->db->trans_start();
					$this->db->where('id',$data->id);
					$this->db->update('data_temp_exercise', $dataarray); 
					$this->db->trans_complete();
				}
			}
	}
	function copy_sob($id=""){
		$this->db->query("delete from data_template_renja where id_data_renja='".$id."'");
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_temp_exercise a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."'
			order by a.urutan asc"); 
   			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$data=array(
						'id_data_renja'=>$id,
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
						'tahun_berlaku'=>$data->tahun_berlaku,
						'unit'=>$data->unit,
						'mark'=>$data->mark,
						'keterangan_tandai'=>$data->keterangan_tandai,
 					);
 					$this->db->trans_start();
					$this->db->insert('data_template_renja',$data);
					$this->db->trans_complete();
				}
			}	
			$message="<span style='font-size:14px'><i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Melakukan Duplikasi Ke Data Utama</b></span>";
			echo $message;
	}
   
 	 
	function isletter_hurup($char=""){
		 if(strlen($char=="1")){
		 	return "isletter_hurup";
		 }
	}

	function cek_total_yang_kena($field="",$kode_direktorat="",$tahun_anggaran=""){
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
		 $array=array();
		$query=$this->db->query("select   *,a.id as id, SUBSTRING_INDEX(indikator, '.',1) as indikator_vroh  
			from data_temp_exercise  a
			left join template_renja on template_renja.id= a.id_data_renja
			left join m_unit_kerja on m_unit_kerja.id_divisi= template_renja.dari
			where a.tahun_berlaku like '%$tahun_anggaran%' and  a.kode_direktorat_child like 
			'%$kode_direktorat%' order by a.id asc");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$isletter="";
			 	$isletter_hurup= $this->isletter($data->indikator);
			 	$datanya=trim($data->$field);
				if ((empty($data->kode_direktorat)) and  (empty($data->program))  and(!empty($datanya))   ){
					$total_bo1=$total_bo1+$data->bo01;
					$total_bo2=$total_bo2+$data->bo02;
					$total_rm_pusat=$total_rm_pusat + $data->bno_rm_p;
					$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
					$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
					$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
					$total_pnbp=$total_pnbp+$data->pnbp;
					$array[]=array(
						'id'=>$data->id,
						'indikator'=>$data->indikator,
						'var'=>$data->$field,
					);
					 
					/*echo $data->indikator." = ". $data->$field ."<br>";*/
				}
			}
		}
		
		$j=0;
		$nilai_total=0;
		for($i=0;$i<=count($array) -1; $i++){
			$isletter_hurup= $this->isletter($array[$i]['indikator']);
			if(!empty($array[$i+1]['indikator'])){
				$isletter_hurup_next= $this->isletter($array[$i+1]['indikator']);	
			} 
			$indi=trim(preg_replace('/[.,]/', '', $array[$i]['indikator']));
			if ((is_numeric($indi))  and (empty($isletter_hurup_next))){				 
					$nilai_total=$nilai_total+$array[$i]['var'];
					$j=$j+1;
					//echo $array[$i]['indikator']."<br>";
			}
			if(!empty($isletter_hurup)){					 
					$nilai_total=$nilai_total+$array[$i]['var'];
					$j=$j+1;
					//echo $array[$i]['indikator']."<br>";
			}
		}
		//echo $j.'-'.$nilai_total."<br>";	
		return $j;	
	}
	 
	function get_nilai_sebelumnya($id="",$field=""){
		$jumlah=0;
		$query=$this->db->query("select  $field as jumlah from data_temp_exercise where id='".$id."'");		 	
	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					return $jumlah;
				}
			}

	}
	function fuck_reset_after_upload_excel($id_data_renja,$kode_direktorat_child,$tahun_anggaran){
		$menus="";
  		$this->load->model("template_renja_model"); 
		$query=$this->db->query("select * from data_temp_exercise  a			 
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
			 
 			$menus=array_unique($menus);
			foreach ($menus as $row){
					$query=$this->db->query("select *,
					(select sum(bo01) as bo01 from data_temp_exercise where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_temp_exercise where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_temp_exercise where parent='".$row."') as pnbp 
 					from data_temp_exercise  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='komponen_input'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
   		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_temp_exercise set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set pnbp='".$datax->pnbp."' where kode='".$row."'");
								//$menus[]=$data->parent;		
 						}
					}	 
			}
			
  				$this->load->model("template_renja_model"); 
				$query=$this->db->query("select * from data_temp_exercise  a			 
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
					(select sum(bo01) as bo01 from data_temp_exercise where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_temp_exercise where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_temp_exercise where parent='".$row."') as pnbp 
 					from data_temp_exercise  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='indikator'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
  		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_temp_exercise set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set pnbp='".$datax->pnbp."' where kode='".$row."'");
  						}
					}	 
				}

		$query=$this->db->query("select * from data_temp_exercise  a			 
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
					(select sum(bo01) as bo01 from data_temp_exercise where parent='".$row."' and      tahun_berlaku='".$tahun_anggaran."'  and kode!='' and kode_direktorat_child='".$kode_direktorat_child."') as bo01,
					(select sum(bo02) as bo02 from data_temp_exercise where parent='".$row."'  and  tahun_berlaku='".$tahun_anggaran."'  and     kode!=''  and kode_direktorat_child='".$kode_direktorat_child."') as bo02,
					(select sum(bno_rm_p) as bno_rm_p from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_p,
					(select sum(bno_rm_d) as bno_rm_d from data_temp_exercise where parent='".$row."'   and  tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_rm_d,
					(select sum(bno_phln_p) as bno_phln_p from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_p,
					(select sum(bno_phln_d) as bno_phln_d from data_temp_exercise where parent='".$row."' and  tahun_berlaku='".$tahun_anggaran."'  and   tahun_berlaku='".$tahun_anggaran."'  and  kode_direktorat_child='".$kode_direktorat_child."'  and kode!='') as bno_phln_d,
					(select sum(pnbp) as pnbp from data_temp_exercise where parent='".$row."') as pnbp 
 					from data_temp_exercise  a			 
					where trim(a.kode_direktorat_child)='".$kode_direktorat_child."'	 and id_data_renja='".$id_data_renja."'
					and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
				 	and tipe='program'	and kode='".$row."'
		 			and trim(a.tahun_berlaku)='".$tahun_anggaran."'  and kode!='' ");
  		  	 		if ($query->num_rows() > 0) {
						foreach ($query->result() as $datax) {			 	 		
					 	 		$this->db->query("update data_temp_exercise set bo01='".$datax->bo01."' where kode='".$row."' and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bo02='".$datax->bo02."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_p='".$datax->bno_rm_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_rm_d='".$datax->bno_rm_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_p='".$datax->bno_phln_p."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set bno_phln_d='".$datax->bno_phln_d."' where kode='".$row."'  and id_data_renja='".$id_data_renja."'");
								$this->db->query("update data_temp_exercise set pnbp='".$datax->pnbp."' where kode='".$row."'");
  						}
					}	 
				}

			}
}		
 ?>
