<?php
class mapping_model extends CI_Model{ 

	function mapping_model()
	{
		parent::__construct();
	}
	function get_data($limit='',$offset=''){
			$menus='';
			$mapping=$this->input->post('mapping');		 
			$addTag="";
			$query=$this->db->query("select *   from mapping 
			where mapping.nama like'%$mapping%'
			order by id DESC
			LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}

	}
	function count(){
			$mapping=$this->input->post('mapping');		
			$query=$this->db->query("select count(1) as jumlah from mapping where mapping.nama like'%$mapping%'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function getUpdate($id=''){
			$query=$this->db->query("select * from mapping where id='$id'");
			return $query->row();
	}
		 
	function act(){
		$id=$this->input->post('id');
 		$nama=$this->input->post('mapping');
 		$data=array(
	 	 'nama'=>$nama,
 		);
 			if($id==''){
			$this->db->trans_start();
			$this->db->insert('mapping',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('mapping', $data); 
			$this->db->trans_complete();
		}	

	 
 	}
	 
   function delete_data($id){
		if($this->db->query("delete from mapping where id='$id'")){
			echo"SUKSES MENGHAPUS DATA";
		} else {
			echo"GAGAL MENYIMPAN KARENA SESUATUNYA SYAHRINI";
		}					
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
	function get_data_rekap($id_data_mapping=""){
		$unit=$this->input->post('unit');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$id=$this->get_id_data_template_renja();
		$sql="";
		if($unit!=""){
			$sql="   a.id_data_renja='".$id."' and  ";
		}
 		$table="";
		$style_header="style='height:50px; vertical-align:middle;font-size:10px;font-weight:bold'";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun ,
			(select kode from data_mapping where kode_asli=a.kode and parent=a.parent and id_data_renja=a.id_data_renja) as m_kode
			from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where ".$sql." a.tipe='program' and a.tahun_berlaku='".$tahun_anggaran."' order by a.kode_direktorat_child asc");	 
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
						if($unit==""){
							$id=$data_f->id_data_renja;
						}
 
						
					
						$table.="<tr>";
						$table.="<td  style='font-size:12px;vertical-align:middle'><b>".$data_f->kode_direktorat."</b></td>";
						$table.="<td colspan='3' style='font-size:12px;vertical-align:middle'><b>".ucwords(strtolower($data_f->program))."</b></td>";
  

 						$table.="<td $style_header></td>";
 						$table.="<td $style_header></td>";
	 					$table.="<td $style_header>";
	 				 	$table.="</td>";

						$table.="</tr>";
		 			if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja_export($id,$data_f->parent,$id_data_mapping);
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
/*	function get_kode_unit_kerja($id=""){
		$query=$this->db->query("select * from m_unit_kerja where id_divisi='".$id."'"); 
 			if ($query->num_rows() > 0) {
				return $query->row();
			}		
	}
	function get_child_data_renja_export($id="",$kode="",$id_data_mapping=""){
		$table="";
		$button="";
		$check_child="";
		$id_data_mapping=$this->input->post('id');
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$sql="";
		if($this->input->post('unit')!=""){
			$info_unit_kerja=$this->get_kode_unit_kerja($this->input->post('unit'));
			$kode_direktorat_child=$info_unit_kerja->kd_unit_kerja;
			$sql= " and a.kode_direktorat_child='".$kode_direktorat_child."'  ";
		}
		
		$style_header="style='font-family:Tahoma;vertical-align:middle;font-size:11px;vertical-align:middle;height:60px";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun ,
			(select kode from data_mapping where kode_asli=a.kode and parent=a.parent and  kode_direktorat=a.kode_direktorat_child and tahun_berlaku=a.tahun_berlaku and id_mapping='".$id_data_mapping."') as m_kode
			from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where 1=1 ".$sql." and trim(parent)=trim('".$kode."') and trim(tipe)!='program'   order by a.urutan asc");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.= ";background-color:#F0F0F0;font-weight:bold'" ;	
							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F0F0F0'>'</span>".($data_f->kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".ucwords(strtolower($data_f->indikator))."</td>";
							$class_editable="";							 
 							
						} else if($data_f->tipe=="komponen_input"){		
							$style_header.= " ;background-color:#fff'" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span>".($data_f->kode)."</b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
 						}	else if($data_f->tipe=="sub_komponen_input"){
							$style_header.= " '" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><b> <center><span style='color:#fff'>'</span>".($data_f->kode)."</center></b></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
 							
						}		

							$table.="<td $style_header > ".ucwords(strtolower($data_f->sasaran_kegiatan))." </td>";
	 						$table.="<td $style_header>".$data_f->target."</td>";
	 						$table.="<td $style_header>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->id_data_renja."' name='id_data_renja[]' id='id_data_renja[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->parent."' name='parent[]' id='parent[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->kode."' name='kode_asli[]' id='kode_asli[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->kode_direktorat_child."' name='kode_direktorat_child[]' id='kode_direktorat_child[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->tahun_berlaku."' name='tahun_berlaku[]' id='tahun_berlaku[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='text' value='".$data_f->m_kode."'  name='kode[]' id='kode[]' style='width:100px'>";
	 						$table.="</td>";

	 						  
 							 
 		 					$table.="</tr>";		 					
			 			if ($this->cek_child_anak($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja_export($id,trim($data_f->kode));
						}
			  	}		
			} else {
				 	$table.="<tr>";
						$table.="<td colspan='16'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
		 		 
			}
			return $table;
	}*/
	function get_child_data_renja_export($id="",$kode="",$id_data_mapping=""){
		$table="";
		$button="";
		$check_child="";
		$id_data_mapping=$this->input->post('id');
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$style_header="style='font-family:Tahoma;vertical-align:middle;font-size:11px;vertical-align:middle;height:60px";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun ,
			(select kode from data_mapping where kode_asli=a.kode and
			 parent=a.parent and id_data_renja=a.id_data_renja and id_mapping='".$id_data_mapping."' order by id desc limit 0,1) as m_kode
			from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program'  order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.= ";background-color:#F0F0F0;font-weight:bold'" ;	
							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F0F0F0'>'</span>".($data_f->kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".ucwords(strtolower($data_f->indikator))."</td>";
							$class_editable="";							 
 							
						} else if($data_f->tipe=="komponen_input"){		
							$style_header.= " ;background-color:#fff'" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><center><b><span style='color:#F9F9F9'>'</span>".($data_f->kode)."</b></center></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
 						}	else if($data_f->tipe=="sub_komponen_input"){
							$style_header.= " '" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><b> <center><span style='color:#fff'>'</span>".($data_f->kode)."</center></b></td>";
							$table.="<td $style_header> ".ucwords(strtolower($data_f->komponen_input))." </td>";
 							
						}		

							$table.="<td $style_header > ".ucwords(strtolower($data_f->sasaran_kegiatan))." </td>";
	 						$table.="<td $style_header>".$data_f->target."</td>";
	 						$table.="<td $style_header>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->id_data_renja."' name='id_data_renja[]' id='id_data_renja[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->parent."' name='parent[]' id='parent[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='hidden' value='".$data_f->kode."' name='kode_asli[]' id='kode_asli[]' style='width:100px'>";
	 						$table.="<input class='form-control input-sm' type='text' value='".$data_f->m_kode."'  name='kode[]' id='kode[]' style='width:100px'>";
	 						$table.="</td>";

	 						  
 							 
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
	function cek_child($id="",$parent=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$parent."'  and tipe='program' order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
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
	function simpan_kode(){
		$id=$this->input->post('id');
		$kode=$this->input->post('kode');
 		$kode_asli=$this->input->post('kode_asli');
		$parent=$this->input->post('parent');
		$id_data_renja=$this->input->post('id_data_renja');
		$i=0;
		$unit=$this->input->post('unit');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
 		 
		if($unit==""){
			$this->db->query("delete from data_mapping where id_mapping='".$id."'");
		} else {
			$id_data_renja_del=$this->get_id_data_template_renja();
			$this->db->query("delete from data_mapping where id_mapping='".$id."' and id_data_renja='".$id_data_renja_del."'");
		}
		foreach($kode as $kode){
			$kode=preg_replace("/[']/", "", $kode);
			$kode=trim($kode);
 			$data=array(
				 'id_mapping'=>$id,	
		 		 'kode_asli'=>$kode_asli[$i],
		 		 'parent'=>$parent[$i],
		  		 'kode'=>$kode,
				 'id_data_renja'=>$id_data_renja[$i],
 			);
 			$this->db->trans_start();
			$this->db->insert('data_mapping',$data);
			$this->db->trans_complete(); 
			$i++;
		}
		$message="<span style='font-size:14px'><i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Menyimpan Data </b></span><br>";
		echo $message;
	}
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>