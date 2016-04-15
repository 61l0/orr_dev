<?php
class log_renja_model extends CI_Model
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
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  ,
			(select nama_tahapan from tahapan_dokumen where id_dokumen=a.tahapan_dokumen) as tahapan_dokumen  
			from log_template_renja a 
			left join t_user on t_user.id=a.approve_by 
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
     			$sql=" and log_template_renja.dari='".$dari."'";
     		} else {
     			$sql="";
     		}	
			$query=$this->db->query("select count(1) as jumlah from log_template_renja  
			left join t_user on t_user.id=log_template_renja.approve_by 
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran 
			where 1=1 $sql");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function get_row($id=""){
		$query=$this->db->query("select * from log_data_template_renja where id='$id'");
		return $query->row();
	}
 	 
	function get_update($id_template=""){
      	$query=$this->db->query("select *,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			where a.id='".$id_template."'");
  		return 	$query->row();
    }
    function get_update_log($id_template=""){
      	$query=$this->db->query("select *,a.dari as daridirektorat,(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from log_template_renja a 
			where a.id='".$id_template."'");
  		return 	$query->row();
    }
	function get_new_id(){
		$query=$this->db->query("select max(id)  as id from log_template_renja");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->id;
				}
				return $menus;
			}
	}
	 
	 
	 
	function delete_data($id=""){
		$this->db->delete('log_template_renja', array('id' => $id)); 
		$this->db->delete('log_data_template_renja', array('id_data_renja' => $id)); 

	}
	function delete_data_renja($id=""){
 		$this->db->delete('log_data_template_renja', array('id' => $id)); 
 		echo "SUKSES HAPUS DATA";
	}
	  
	function isletter($char=""){
		if (preg_match('/[a-zA-Z]/', $char)) :
		    return $char.' is a letter<br>';
		endif;
	}
	 
	function get_total_program($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
	  
	 	$query=$this->db->query("select * from log_data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'
 			and id_log='".$id."'"); 
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
	function get_total_indikator($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;
	  
	 	$query=$this->db->query("select * from log_data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.parent)='".trim($kode)."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."' and id_log='".$id."'"); 
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
	 	$query=$this->db->query("select * from log_data_template_renja  a			 
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
		 
	}
	function get_child_data_renja($id="",$kode=""){
		$table="";
		$button="";
		$check_child="";
		$kode_direktorat=$this->session->userdata('KODE_DIREKTORAT');
		$style_header="style='vertical-align:middle;font-size:10px;vertical-align:middle'";
		$query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where a.id_log='".$id."' and trim(parent)=trim('".$kode."') and trim(tipe)!='program'  order by a.urutan asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				$class_editable="";	
				$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header> <b>".strtoupper($data_f->kode)."</b></td>";
							$table.="<td colspan='2' $style_header > ".strtoupper($data_f->indikator)."</td>";
							$class_editable="";
 							
						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><b> ".strtoupper($data_f->kode)."</b></td>";
							$table.="<td $style_header> ".strtoupper($data_f->komponen_input)." </td>";
						}	else if($data_f->tipe=="sub_komponen_input"){
							$table.="<td></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><b> <center>".strtoupper($data_f->kode)."</center></b></td>";
							$table.="<td $style_header> ".strtoupper($data_f->komponen_input)." </td>";
						}	
							$table.="<td $style_header > ".strtoupper($data_f->sasaran_kegiatan)." </td>";
	 						$table.="<td $style_header>".$data_f->target."</td>";


	 						$bo001=0;
							$bo002=0;
	 						$bno_phln_d=0;
							$bno_phln_p=0;
							$bno_rm_d=0;
							$bno_rm_p=0;								
							$pnbp=0;							
							$total_all=0;
							

	 						if($data_f->tipe=="indikator"){
	 							$bo001=number_format($this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bo002=number_format($this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_p=number_format($this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_phln_d=number_format($this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_p=number_format($this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$bno_rm_d=number_format($this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 							$pnbp=number_format($this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));

	 							$total_all=number_format($bo001+$bo002+$bno_phln_p+$bno_phln_d+$bno_rm_p+$bno_rm_d+$pnbp) ;		
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
	 										$total_all=number_format($bo001+$bo002+$bno_phln_p+$bno_phln_d+$bno_rm_p+$bno_rm_d+$pnbp) ;	
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

							$table.="<td $style_header>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo01' ".$class_editable." id='bo01' data-type='text' 
						        		data-placement='right' data-id='bo01' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo001)))."</center></a>
					        		</td>";

							$table.="<td $style_header>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bo02'  ".$class_editable." id='bo02' data-type='text' 
						        		data-placement='right' data-id='bo02' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bo002)))."</center></a>
					        		</td>";

							$table.="<td $style_header>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
					        			id='".$data_f->id."|bno_rm_p' ".$class_editable." id='bno_rm_p' data-type='text' 
					        			data-placement='right' data-id='bno_rm_p' 
					        			data-title='Masukan Nilai Baru'>
					        			<center>".strtoupper(trim(($bno_rm_p)))."</center></a>
					        		</td>";

							$table.="<td $style_header>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|bno_rm_d' ".$class_editable." id='bno_rm_d' data-type='text' 
						        		data-placement='right' data-id='bno_rm_d' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($bno_rm_d)))."</center></a>
									</td>";

							$table.="<td $style_header>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_p' ".$class_editable." id='bno_phln_p' data-type='text' 
							        		data-placement='right' data-id='bno_phln_p' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_p)))."</center></a>
									 </td>";

							$table.="<td $style_header>
										<a style='font-size:10px;text-align:center;cursor:pointer'  
							        		id='".$data_f->id."|bno_phln_d' ".$class_editable." id='bno_phln_d' data-type='text' 
							        		data-placement='right' data-id='bno_phln_d' 
							        		data-title='Masukan Nilai Baru'>
							        		<center>".strtoupper(trim(($bno_phln_d)))."</center></a>
									</td>";

							$table.="<td $style_header>
									<a style='font-size:10px;text-align:center;cursor:pointer'  
						        		id='".$data_f->id."|pnbp' ".$class_editable." id='pnbp' data-type='text' 
						        		data-placement='right' data-id='pnbp' 
						        		data-title='Masukan Nilai Baru'>
						        		<center>".strtoupper(trim(($pnbp)))."</center></a>
									</td>";
							$table.="<td $style_header><center>".strtoupper(trim($total_all))."</center></td>";
							$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";
							$table.="<td $style_header><a style='text-decoration:none;font-size:10px;text-align:center;cursor:pointer'  
					        		id='".$data_f->id."|kl' class='' id='kl' data-type='text' 
					        		data-placement='right' data-id='kl' 
					        		data-title='Masukan Nilai Baru'>
					        		<center>".$kl."</center></a></td>";	

						 
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
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where a.id_log='".$id."' and parent='".$kode."'   order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
			}
	}
	function cek_child($id="",$parent=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where a.id_log='".$id."' and parent='".$parent."'  and tipe='program' order by a.urutan asc");
	 		if($query->num_rows() > 0){
				return TRUE;
			}
	}
	function get_data_rekap($id=""){
		$table="";
		$style_header="style='vertical-align:middle;font-size:10px;font-weight:bold;background-color:#F9F9F9;font-weight:bold'";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=log_template_renja.dari
			where a.id_log='".$id."' and tipe='program' order by a.urutan asc");
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

 						$bo001=($this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
						$bo002=($this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_phln_p=($this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_phln_d=($this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_rm_p=($this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$bno_rm_d=($this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));
	 					$pnbp=($this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id));

						
						$table.="<tr>";
						$table.="<td $style_header >".$data_f->kode_direktorat."</td>";
						$table.="<td colspan='3' ".$style_header."><b>".strtoupper($data_f->program)."</b></td>";
						$table.="<td ".$style_header."><b>".strtoupper($data_f->sasaran_program)."</b></td>";
						$table.="<td>".$data_f->target."</td>";

						$table.="<td $style_header><center>".number_format($bo001)."</center></td>";
						$table.="<td $style_header><center>".number_format($bo002)."</center></td>";
						$table.="<td $style_header><center>".number_format($bno_rm_p)."</center></td>";
						$table.="<td $style_header><center>".number_format($bno_rm_d)."</center></td>";
						$table.="<td $style_header><center>".number_format($bno_phln_p)."</center></td>";
						$table.="<td $style_header><center>".number_format($bno_phln_d)."</center></td>";
						$table.="<td $style_header><center>".number_format($pnbp)."</center></td>";
	
							 
						$total_all=0;
					 	$total_all=$bo001+$bo002+$bno_phln_p+$bno_phln_d+$bno_rm_p+$bno_rm_d+$pnbp;

						$table.="<td $style_header><center>".strtoupper(trim(number_format($total_all)))."</center></td>";
						$kl=$data_f->kl ? strtoupper(trim(($data_f->kl))) : "-";
						$table.="<td $style_header>
					        		<center>".$kl."</center></td>";

 					       
		 			$table.="</tr>";
		 			if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja($id,$data_f->parent);
					}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='16'  style='vertical-align:middle;font-size:10px;text-align:right'> <center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";
 						 
						$table.="</td>";
		 			$table.="</tr>";
			}
			return $table;
	}

  
	function cek_child_komponen_input($kode="",$id_data_renja=""){
		$q2 = $this->db->query("select parent from log_data_template_renja where trim(parent)='".trim($kode)."' and id_data_renja='".$id_data_renja."'");
  		if ($q2->num_rows() > 0) {
			foreach ($q2->result() as $row) {
				return "true";
 			}
		} else {
				return  "false";
		}
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
	 
 	 
 
	 
	function get_child2 ($parent="",$id="",$kode_indikator=""){
		 $table="";
 		 $query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where trim(a.indikator)='".$parent."' and a.id_log='".$id."' and program='' order by a.urutan asc"); 
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
 		 $query=$this->db->query("select *,a.id as id,tahun_anggaran.tahun_anggaran as tahun from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where trim(a.kode_indikator)='".$parent."' and a.id_log='".$id."' and program='' order by a.urutan asc"); 
	  		// echo $this->db->last_query()."<br>";
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
 					$table.="<tr>";
						$table.="<td></td>";
						$table.="<td>".$data->indikator." &nbsp; ".$data->komponen_input."</td>";
						//$this->db->query("update log_data_template_renja set parent='".$data->kode_indikator."'  , urutan='".$data->program."' where id='".$data->id."' and program=''");	
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
		$query=$this->db->query("select count(1) as jumlah from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where a.id_log='".$id."'  and parent='".$parent."' and program='' order by a.urutan asc");
  	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
					return $data->jumlah;
				}
			}
	}
	function cekChild1($parent="",$id="",$kode_indikator=""){
 		 $q=$this->db->query("select a.program from log_data_template_renja a
			left join log_template_renja on log_template_renja.id=a.id_log
			left join tahun_anggaran on tahun_anggaran.id=log_template_renja.tahun_anggaran
			where a.id_log='".$id."' and parent='".$parent."'"); 
			 
 	 		if($q->num_rows() > 0){
				return TRUE;
			}
	}
	function cek_if_data_exist(){
		$id_backup=$this->input->post('id_backup');
		$id_restore=$this->input->post('id_restore');	
		$query=$this->db->query("select count(1) as jumlah from template_renja a where a.id='".$id_restore."'");
    	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
					return $data->jumlah;
				}
			}
		
	}
	function load_data_exist(){
		$id_backup=$this->input->post('id_backup');
		$id_restore=$this->input->post('id_restore');
		$info_log=$this->get_update_log($id_backup);
 		$dari=$info_log->daridirektorat;	
 		$table="<form id='form_lost_data_renja' name='form_lost_data_renja'>";
 		$table.='<input  id="id_backup" name="id_backup" required="true" size="30" value="'.$id_backup.'" type="hidden" />';

 		$table.="<table class='table multimedia table-striped table-hover table-bordered'> <thead>";
 		$table.="<tr>";
 						$table.="<th style='vertical-align:middle'><i style='color:#E74C3C;font-size:20px' class='glyphicon glyphicon-remove-sign'></i>  </th>";
						$table.="<th colspan='5'>Data Renja   Tidak Tersedia / Terhapus , Silahkan Pilih Salah Satu Data Dibawah Ini Untuk Melakukan Restore Data Ke Data Renja yang Tersedia  ....</th>";
 	 	 				$table.="</tr>";
					$table.="<tr>";
						$table.="<th></th>";
	 	 				$table.="<th>DARI</th>";
	 	 				$table.="<th>TAHUN</th>";
	 	 				$table.="<th>TANGGAL</th>";
	 	 				$table.="<th>JAM</th>";
  	 				$table.=" </thead></tr>";
		$query=$this->db->query("select *,a.dari as daridirektorat,tahun_anggaran.tahun_anggaran as tahun_anggaran,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran 
			where a.dari='".$dari."'");
     	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
					$table.="<tr>";
						$table.="<td><input type='radio' checked='checked' name='id_restore' id='id_restore' value='".$data->id."'></td>";
	 	 				$table.="<td>".$data->dari."</td>";
	 	 				$table.="<td>".$data->tahun_anggaran."</td>";
	 	 				$table.="<td>".date("d-F-Y",strtotime($data->tanggal))."</td>";
	 	 				$table.="<td>".$data->jam."</td>";
  	 				$table.="</tr>";
				}
			}
		$table.="</table></form>"	;
		return $table;	
	}
	function di_restore_dulu_sob(){
		$id_backup=$this->input->post('id_backup');
		$id_restore=$this->input->post('id_restore');
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."'");
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."' and kode=''");
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."' and kode IS NULL");
		$info=$this->get_row_program($id_restore);
		$tahun=$info->tahun_anggaran;
			$query=$this->db->query("select * from log_data_template_renja where id_log='".$id_backup."' and 
				id_data_renja='".$id_restore."' and tahun_berlaku='".$tahun."'  ");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
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
					$this->db->insert('data_template_renja',$data);
					$this->db->trans_complete();
				}
		}

	}	
 	function di_restore_dulu_bro(){
		$id_backup=$this->input->post('id_backup');
		$id_restore=$this->input->post('id_restore');
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."'");
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."' and kode=''");
		$this->db->query("delete from data_template_renja where id_data_renja='".$id_restore."' and kode IS NULL");
		$info=$this->get_row_program($id_restore);
		$tahun=$info->tahun_anggaran;
			$query=$this->db->query("select * from log_data_template_renja where id_log='".$id_backup."' and tahun_berlaku='".$tahun."'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$kode_direktorat_child=$data->kode_direktorat_child;
					$tahun_berlaku=$data->tahun_berlaku;
					$data=array(
						'id_data_renja'=>$id_restore,
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
				 $this->load->model('template_renja_model');
				 $this->template_renja_model->fuck_reset_after_upload_excel($id_restore,$kode_direktorat_child,$tahun_berlaku);
		 
	}	
	 
}		
?>
