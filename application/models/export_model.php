<?php
class export_model extends CI_Model
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
     
			$query=$this->db->query("select *,tahun_anggaran.tahun_anggaran as tahun_anggaran,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran 
			where 1=1 $sql order by a.id desc  LIMIT $limit,$offset");
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
 	function get_update($id=""){
     	$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan , 
			(select nama from t_user where t_user.unit=a.dari LIMIT 0,1) as nama_user  
			from template_renja a 
			left join m_unit_kerja on m_unit_kerja.id_divisi = a.dari
			where a.id='$id'");
		return 	$query->row();
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
	function get_child_data_renja($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";

		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$style_header="style='font-family:Tahoma;vertical-align:middle;font-size:11px;vertical-align:middle;height:70px";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program'  order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.= " ;background-color:#A6A6A6;font-weight:bold'" ;	
							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header> <b>".($data_f->kode)."</b></td>";
							$table.="<td colspan='2' $style_header > ".($data_f->indikator)."</td>";
							$class_editable="";
							 
							$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							
						} else if($data_f->tipe=="komponen_input"){
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
							if (($check_child!="true")){
								$style_header.= " ;background-color:#fff'" ;
							} else {
								$style_header.= " ;background-color:#DFE3F0'" ;
							}	
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><b> ".($data_f->kode)."</b></td>";
							$table.="<td $style_header> ".($data_f->komponen_input)." </td>";
							 
		 						if (($check_child!="true") and ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
									$class_editable=" class='xeditable' ";
								}
							$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
						}	else if($data_f->tipe=="sub_komponen_input"){
							$style_header.= " ;background-color:#fff'" ;
							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><b> <center>".($data_f->kode)."</center></b></td>";
							$table.="<td $style_header> ".($data_f->komponen_input)." </td>";
							$button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
							if (($check_child!="true") and ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
									$class_editable=" class='xeditable' ";
								}
						}	

							$table.="<td $style_header > ".($data_f->sasaran_kegiatan)." </td>";
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
		 							$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id) + 
		 							$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id)) ;		
	 							} else if($data_f->tipe=="komponen_input"){
	 								$c=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
	 									if($c=="true"){
	 										/* BILA KOMPONEN INPUT MEMILIKI CHILD*/	
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

							$table.="<td $style_header class='".$is_indikator."_bo01'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo01' ".$class_editable." id='bo01' data-type='text' 
						        		data-placement='right' data-id='bo01' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo001)))."</center></a>
					        		</td>";

							$table.="<td $style_header class='".$is_indikator."_bo02'>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo02'  ".$class_editable." id='bo02' data-type='text' 
						        		data-placement='right' data-id='bo02' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo002)))."</center></a>
					        		</td>";

							$table.="<td $style_header class='".$is_indikator."_bno_rm_p'>
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

							$table.="<td $style_header class='".$is_indikator."_bno_phln_p'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_p' ".$class_editable." id='bno_phln_p' data-type='text' 
							        		data-placement='right' data-id='bno_phln_p' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_p)))."</center></a>
									 </td>";

							$table.="<td $style_header class='".$is_indikator."_bno_phln_d'>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_d' ".$class_editable." id='bno_phln_d' data-type='text' 
							        		data-placement='right' data-id='bno_phln_d' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_d)))."</center></a>
									</td>";

							$table.="<td $style_header class='".$is_indikator."_pnbp'>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|pnbp' ".$class_editable." id='pnbp' data-type='text' 
						        		data-placement='right' data-id='pnbp' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($pnbp)))."</center></a>
									</td>";
							$table.="<td $style_header class='".$is_indikator."_pagu'>".strtoupper(trim($total_all))."</td>";
							$table.="<td $style_header><a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl' class='xeditable' id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".strtoupper(trim(($data_f->kl)))."</center></a></td>";	

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
	function button_action($id="",$tipe="",$kode_direktorat=""){
		$button="";		 	
		return $button;
	}	 
	function get_total_program($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran=""){
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
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
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
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and a.id_data_renja='".$id_data_renja."' and kode!=''"); 
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
	function get_data_rekap($id=""){
		 $table="";
		$style_header="style='font-family:Tahoma;height:60px;vertical-align:middle;font-size:12px;font-weight:bold;background-color:#F9F9F9;font-weight:bold'";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {

						$bo001= $this->input->post('t_sum_bo_01'); 
						$bo002=$this->input->post('t_sum_bo_02'); 
	 					$bno_phln_d=$this->input->post('t_sum_bno_phln_d'); 
						$bno_phln_p=$this->input->post('t_sum_bno_phln_p');
						$bno_rm_d=$this->input->post('t_sum_bno_rm_d');
						$bno_rm_p=$this->input->post('t_sum_bno_rm_p');								
						$pnbp=$this->input->post('t_sum_bno_pnbp');							
						$total_all=$this->input->post('t_sum_pagu');

	 
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
						$table.="<td  $style_header colspan='3' ".$style_header."><b>".($data_f->program)."</b></td>";
						$table.="<td ".$style_header."><b>".($data_f->sasaran_program)."</b></td>";
						$table.="<td  ".$style_header.">".$data_f->target."</td>";

						$table.="<td $style_header id='f_sum_bo_01'><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header id='f_sum_bo_02'><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_p'><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_rm_d'><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_p'><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header id='f_sum_bno_phln_d'><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header id='f_sum_pnbp'><center>".number_format($pnbp)."</center></td>";
	
						 
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
							$table.="<td $style_header id='f_sum_pagu'>".(trim(number_format($total_all)))."
							</td>";
							$table.="<td $style_header><a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl' class='xeditable' id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".(trim(($data_f->kl)))."</center></a></td>";
					        $button=$this->button_action($data_f->id,$data_f->tipe,$data_f->kode_direktorat_child);
					       
		 			$table.="</tr>";
		 			if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja($id,$data_f->parent);
					}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='16'  style='vertical-align:middle;font-size:10px;text-align:right'> <center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";
						$table.=$this->button_action($id,'add_program');
						$table.=" </td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	 
 	/* EXPORT KE RENJA BAPPENAS */
 	function get_direktorat($id=""){
		$this->load->database('default', TRUE); 
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  from template_renja a 
			left join m_unit_kerja on m_unit_kerja.id_divisi = a.dari
			where a.id='$id'  ");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->kd_unit_kerja;
				}
				return $menus;
			}
	}
 	function export_renja_bappenas($id=""){
		$this->simpan_indikator($id);
	} 
	function simpan_indikator($id=""){
		$data=array();		
		$direktorat=$this->get_direktorat($id);

		/*$this->other_db->query("delete from d_indikator_output where kddept='010' and kdunit='06' and kdprogram='06' 
		and kddit='01'  and kdoutput='01' and kdgiat='".$direktorat."'");*/

		$this->other_db= $this->load->database('renja_bappenas', TRUE); 
 		$this->other_db->query("delete from d_indikator_output where kddept='010' and kdunit='06'  and kdgiat='".$direktorat."'");
 		$this->other_db->query("delete from d_kmpnen where kddept='010' and kdunit='06'  and kdgiat='".$direktorat."'");
 		$this->other_db->query("delete from d_lok where kddept='010' and kdunit='06'  and kdgiat='".$direktorat."'");

 		$this->load->database('default', TRUE); 
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.kode_direktorat_child='".$direktorat."'  and  trim(tipe)='indikator' and a.tahun_berlaku='".date("Y")."'
			 order by a.urutan asc");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$strlen=strlen(trim($data->urutan));
					if($strlen=="1"){
						$nomor='00'.trim($data->urutan);
					} else if($strlen=="2"){
						$nomor='0'.trim($data->urutan);
					}
					//echo $nomor .'-'.$data->indikator."<br>";
			    	//$this->simpan_komp_input(trim($data->program),$id);
					$data=array(
						'kddept'=>'010',
						'kdunit'=>'06',
						'kdprogram'=>'06',
						'kddit'=>'01',
						'kdgiat'=>$direktorat,
						'kdoutput'=>'01',
						'nomor'=>$nomor,
						'nama'=>(($data->indikator)),  
						'vol1'=>'',
						'vol2'=>'',
						'vol3'=>'',
						'vol4'=>'',
						'satuan'=>'',
						'ket'=>'Prio'
					);

					$this->other_db= $this->load->database('renja_bappenas', TRUE); 
					$this->other_db->trans_start();
					$this->other_db->insert('d_indikator_output',$data);
					$this->other_db->trans_complete();
				}			 
			}
			$this->simpan_komp_input(trim(""),$id);
	}
	function simpan_komp_input($program="",$id=""){	 
		$direktorat=$this->get_direktorat($id);	
		$nomor="";
		$j=1;
		$this->load->database('default', TRUE); 
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.kode_direktorat_child='".$direktorat."'  and  trim(tipe)='komponen_input' and a.tahun_berlaku='".date("Y")."'
			 order by a.urutan asc");
  	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
				 	$strlen=strlen(trim($j));
					if($strlen=="1"){
						$nomor='00'.trim($j);
					} else if($strlen=="2"){
						$nomor='0'.trim($j);
					}
				 	//$this->get_duit_nya_sob($data->id);
					$data=array(
						'thang'=>'',
						'kddept'=>'010',
						'kdunit'=>'06',
						'kdprogram'=>'06',
						'kdgiat'=>$direktorat,
						'kdoutput'=>'01',
						'kdkmpnen'=>$nomor,
						'kdbiaya'=>'',
						'urkmpnen'=>(($data->komponen_input)),
						'status'=>'',
					);

					$this->other_db= $this->load->database('renja_bappenas', TRUE); 
					$this->other_db->trans_start();
					$this->other_db->insert('d_kmpnen',$data);
					$this->other_db->trans_complete();
					$j++;
				}			 
			}
 	}
	function get_duit_nya_sob($id=""){
		$this->load->database('default', TRUE); 
		$query=$this->db->query("select * from data_template_renja where id='".$id."'");

	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {			
					$data=array(
						'kddept'=>'010',
						'kdunit'=>'06',
						'kdprogram'=>'06',
						'kdgiat'=>$data->kode_direktorat_child,
						'kdkmpnen'=>$data->indikator,
						'kdoutput'=>'01',
						'kdprop'=>'',
						'kdkab'=>'',
						'kewenangan'=>'',
						'npphln'=>'',

						'kdsumber'=>'',
						'jenisphln'=>'',
						'volume'=>'',
						'rupiah'=>'',
						'pnbp'=>'',
						'blu'=>'',
						'pln'=>'',
						'pdn'=>'',
						'hibah'=>'',
						'pend'=>'',

						'sbsn'=>'',
						'paguphln'=>'',
						'serap'=>'',
						'tglawal'=>'',
						'tglakhir'=>'',
						'jumlah'=>'',					 
							
					);
					$this->other_db= $this->load->database('renja_bappenas', TRUE); 
					$this->other_db->trans_start();
					$this->other_db->insert('d_lok',$data);
					$this->other_db->trans_complete();
				}
			}	 	
	}

}		
 ?>
