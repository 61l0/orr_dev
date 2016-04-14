<?php
class log_capaian_model extends CI_Model
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
			$query=$this->db->query("select *,a.id as id ,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where kd_unit_kerja=a.kode_direktorat_child)  as nama_unit_kerjax ,
			(select tahun_anggaran from tahun_anggaran where tahun_anggaran.id=a.tahun)  as tahunx 			
			,m_unit_kerja.nama_unit_kerja,a.judul as judul,template_renja.id as id_data_renjax,
			(select id from template_renja where tahun_anggaran=a.tahun and dari=m_unit_kerja.id_divisi)  as id_renja_sob 	
			from log_capaian a 
			left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child 
			left join template_renja on template_renja.dari=m_unit_kerja.id_divisi 
			left join t_user on t_user.id=a.approve_by
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where 1=1 group by a.random   $sql order by a.id desc LIMIT $limit,$offset");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
    function count(){
			$i=0;	
			$query=$this->db->query("select * 
			from log_capaian a 
			left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child 
			left join template_renja on template_renja.dari=m_unit_kerja.id_divisi 
			left join t_user on t_user.id=a.approve_by
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran 
			group by a.random  ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$i++;
				}
				return $i;
			}
	}
	function get_update($id="",$id_data_renja=""){
     	$query=$this->db->query("select *,a.id as id ,
			(select nama_unit_kerja from m_unit_kerja where kd_unit_kerja=a.kode_direktorat_child)  as nama_unit_kerjax ,
			(select tahun_anggaran from tahun_anggaran where tahun_anggaran.id=a.tahun)  as tahunx 			
			,m_unit_kerja.nama_unit_kerja,a.judul as judul,template_renja.id as id_data_renjax,
			(select id from template_renja where tahun_anggaran=a.tahun and dari=m_unit_kerja.id_divisi)  as id_renja_sob 	
			from log_capaian a 
			left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child 
			left join template_renja on template_renja.dari=m_unit_kerja.id_divisi 
			left join t_user on t_user.id=template_renja.dari
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id='".$id."'");
 		return 	$query->row();
    }
    function get_update_log($id="",$id_data_renja=""){
     	$query=$this->db->query("select *,a.id as id ,
			(select nama_unit_kerja from m_unit_kerja where kd_unit_kerja=a.kode_direktorat_child)  as nama_unit_kerjax ,
			(select tahun_anggaran from tahun_anggaran where tahun_anggaran.id=a.tahun)  as tahunx 			
			,m_unit_kerja.nama_unit_kerja,a.judul as judul,template_renja.id as id_data_renjax,
			(select id from template_renja where tahun_anggaran=a.tahun and dari=m_unit_kerja.id_divisi)  as id_renja_sob 	
			from log_capaian a 
			left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat_child 
			left join template_renja on template_renja.dari=m_unit_kerja.id_divisi 
			left join t_user on t_user.id=template_renja.dari
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id='".$id."'");
 		return 	$query->row();
    }
    function di_restore_dulu_sob(){
    	$id_backup=$this->input->post('id_backup');
		$id_restore=$this->input->post('id_restore');
		
		$table="";
		$jenis_capaian="";
		$kode_direktorat_child="";
		$tahun="";
    	$query=$this->db->query("select * from log_capaian a
			where a.id='".$id_backup."'  ");
  	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
 	 				$table=$data->jenis_capaian;
 	 				$jenis_capaian=$data->jenis_capaian;
 	 				$kode_direktorat_child=$data->kode_direktorat_child;
 	 				$tahun=$data->tahun;
 	 				$random=$data->random;
 				}
			}
		$queryx=$this->db->query("select * from template_renja a
			where a.id='".$id_restore."'  ");
   	 		if($queryx->num_rows() > 0){
 	 			foreach ($queryx->result() as $row) {	
 	 				$capaian_kinerja_target=$row->capaian_kinerja_target;
 	 				$capaian_kinerja_realisasi=$row->capaian_kinerja_realisasi;
		 			$capaian_dktp_realisasi=$row->capaian_dktp_realisasi;
					$capaian_dktp_target=$row->capaian_dktp_target;
					$capaian_keuangan_realisasi=$row->capaian_keuangan_realisasi;
					$capaian_keuangan_target=$row->capaian_keuangan_target;
					$capaian_kinerja_realisasi=$row->capaian_kinerja_realisasi;
		 			$capaian_phln_realisasi=$row->capaian_phln_realisasi;
					$capaian_phln_target=$row->capaian_phln_target;
					$capaian_renaksi_realisasi=$row->capaian_renaksi_realisasi;
					$capaian_renaksi_target=$row->capaian_renaksi_target;
 				}
		}
		if(($jenis_capaian=="capaian_kinerja_target") and($capaian_kinerja_target=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_kinerja") and($capaian_kinerja_realisasi=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}

		if(($jenis_capaian=="capaian_keuangan_target") and ($capaian_keuangan_target=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_keuangan") and ($capaian_keuangan_realisasi=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
 		if(($jenis_capaian=="capaian_dktp_target") and($capaian_dktp_target=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_dktp") and($capaian_dktp_realisasi=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_phln_target") and($capaian_phln_target=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_phln") and($capaian_phln_realisasi=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}

		if(($jenis_capaian=="capaian_renaksi_target") and($capaian_renaksi_target=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}
		if(($jenis_capaian=="capaian_renaksi") and($capaian_renaksi_realisasi=="1")){
			echo "<a style='color:#fff;font-size:20px' class='btn-block btn btn-danger'><i style='font-size:20px' class='glyphicon glyphicon-remove-sign '></i> Data Capaian Sudah Disetujui , Proses Dibatalkan ...</a>";
			return false;
		}

		$this->db->query("delete from ".$table." where trim(kode_direktorat_child)='".$kode_direktorat_child."' and trim(tahun)='".$tahun."'");
 		$query=$this->db->query("select * from log_capaian a
			where a.random='".$random."'  ");
  	 		if($query->num_rows() > 0){
 	 			foreach ($query->result() as $data) {	
 	 					$data=array(
 					 	 'kode_direktorat_child'=>$data->kode_direktorat_child,
						 'kode'=>$data->kode,
						 'parent'=>$data->parent,
						 'c_01'=>$data->c_01,
						 'c_02'=>$data->c_02,
						 'c_03'=>$data->c_03,
						 'c_04'=>$data->c_04,
						 'c_05'=>$data->c_05,
						 'c_06'=>$data->c_06,
						 'c_07'=>$data->c_07,
						 'c_08'=>$data->c_08,
						 'c_09'=>$data->c_09,
						 'c_10'=>$data->c_10,
						 'c_11'=>$data->c_11,
						 'c_12'=>$data->c_12,
						 'tahun'=>$data->tahun,
						 'tanggal'=>$data->tanggal,
						 'jumlah'=>$data->jumlah,
 						);		
 	 					$this->db->trans_start();
						$this->db->insert($table,$data);
						$this->db->trans_complete();
 	 			}
 	 		}	

    }


    function get_capaian($id="",$table_capaian="",$id_data_renja="",$random=""){
		$table="";
		$class_xeditable='';
 		$bg_ikk="";
		$style=";font-size:10px;font-weight:bold;padding:10px";
 	 
		$query=$this->db->query("select *,template_renja.tahun_anggaran as tahun_anggaran,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,
		(select c_01 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12'
		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id_data_renja."' and tipe='program' order by a.urutan asc");
 
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
					$c_01=0;
					$c_02=0;
					$c_03=0;
					$c_04=0;
					$c_05=0;
					$c_06=0;
					$c_07=0;
					$c_08=0;
					$c_09=0;
					$c_10=0;
					$c_11=0;
					$c_12=0;
					
					$total_pagu=0;
					$total_bo1=0;
					$total_bo2=0;
					$total_rm_pusat=0;
					$total_rm_daerah=0;
					$total_phln_pusat=0;
					$total_phln_daerah=0;
					$total_pnbp=0;
					$total_all_pagu=0;

					$total_bo1=$total_bo1+$this->
					get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_bo2=$total_bo2+$this->
					get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_rm_pusat=$total_rm_pusat+$this->
					get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_rm_daerah=$total_rm_daerah+$this->
					get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_phln_pusat=$total_phln_pusat+$this->
					get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_phln_daerah=$total_phln_daerah+$this->
					get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					$total_pnbp=$total_pnbp+$this->
					get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$random);
					
					 
					$total_all_pagu=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
				 

					$table.="<tr>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->kode_direktorat."</td>";
					$table.="<td style='".$style.";vertical-align:middle;' colspan='3'>".strtoupper($data_f->program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".strtoupper($data_f->sasaran_program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->target."</td>"; 
					$table.="<td style='".$style.";vertical-align:middle;'>".number_format($total_all_pagu)."</td>"; 

				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='';
			        	}	
						$c_01=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,$id,$random);
						$c_02=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,$id,$random);
						$c_03=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,$id,$random);
						$c_04=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,$id,$random);
						$c_05=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,$id,$random);
						$c_06=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,$id,$random);
						$c_07=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,$id,$random);
						$c_08=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,$id,$random);
						$c_09=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,$id,$random);
						$c_10=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,$id,$random);
						$c_11=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,$id,$random);
						$c_12=$this->get_total_header($table_capaian,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,$id,$random);
					 	
					 	 
					 
							$persen_triwulan_1=0;
							$persen_triwulan_2=0;
							$persen_triwulan_3=0;
							$persen_triwulan_4=0;
							
							$rp_triwulan_1=0;
							$rp_triwulan_2=0;
							$rp_triwulan_3=0;
							$rp_triwulan_4=0;
							
							$rp_triwulan_1=($c_01+$c_02+$c_03);
				        	$rp_triwulan_2=($c_04+$c_05+$c_06);
				        	$rp_triwulan_3=($c_07+$c_08+$c_09);
				        	$rp_triwulan_4=($c_10+$c_11+$c_12);
							
							$pembagi=1;
							$kali_seratus=1;

							if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
				        	 	$pembagi=3;
					        } else {
					        	$pembagi=$total_all_pagu;
					        	$kali_seratus=100;
					        }	
				        	
				        	if($pembagi!="0"){  	 
				            	$persen_triwulan_1=(($rp_triwulan_1) / $pembagi) * $kali_seratus;
						        $persen_triwulan_2=(($rp_triwulan_2) / $pembagi) * $kali_seratus;
						        $persen_triwulan_3=(($rp_triwulan_3) / $pembagi) * $kali_seratus;
						        $persen_triwulan_4=(($rp_triwulan_4) / $pembagi) * $kali_seratus;
					        }

				        	$rp_triwulan_1=number_format($rp_triwulan_1);
				        	$rp_triwulan_2=number_format($rp_triwulan_2);
				        	$rp_triwulan_3=number_format($rp_triwulan_3);
				        	$rp_triwulan_4=number_format($rp_triwulan_4);

				        	if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  		


				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_01)))."</center></a>";
				        	$table.="</td>";
				        	
				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_02)))."</center></a>";
				        	$table.="</td>";


				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_03)))."</center></a>";
				        	$table.="</td>";

				        	$table.="<td  class='triwulan_1'style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_1."</b></center></td>";
				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";


				        	$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_04)))."</center></a>";
				        	$table.="</td>";



				        	$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_05)))."</center></a>";
				        	$table.="</td>";

				        	$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_06)))."</center></a>";
				        	$table.="</td>";

				        	$table.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_2."</b></center></td>";
				        	$table.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";


				        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_07)))."</center></a>";
				        	$table.="</td>";


				        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_08)))."</center></a>";
				        	$table.="</td>";


				        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_09)))."</center></a>";
				        	$table.="</td>";

				        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_3."</b></center></td>";
				        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";


				        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_10)))."</center></a>";
				        	$table.="</td>";


				        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_11)))."</center></a>";
				        	$table.="</td>";


				        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a><center>".strtoupper(trim(number_format($c_12)))."</center></a>";
				        	$table.="</td>";
				        	
				        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_4."</b></center></td>";
				        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";

				        	$total_kesamping=0;
							if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
								//$total_kesamping=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
								//$total_kesamping="-";
							} else {
								$total_kesamping=$c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12;
								$total_kesamping=($total_kesamping);
							}

						 	if(($table_capaian!="capaian_kinerja_target") and ($table_capaian!="capaian_kinerja")){
		 						$table.="<td style='vertical-align:middle;font-size:10px;'>";
						        $table.="<center><b>".strtoupper(trim(number_format($total_kesamping)))."</b></center>";
						        $table.="</td>";
						    } else {
						    	$table.="<td style='vertical-align:middle;font-size:10px;'>";
						        $table.="<center>-</center>";
						        $table.="</td>";
						    }   
				         	
				        	$percentange=0;
				        	if(($table_capaian!="capaian_kinerja_target") and ($table_capaian!="capaian_kinerja")){
					        	if($total_all_pagu!="0"){
					        		$percentange=($total_kesamping/$total_all_pagu)*100;
					        	}
					        } else {
					        	$percentange=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
					        }	
				        	$table.="<td style='".$style.";vertical-align:middle;'><center>".number_format($percentange,1)."</center></td>"; 
				        
				        
				       
				        $table.="</tr>";
			        	if ($this->cek_child($id_data_renja,$data_f->parent)) {
							$table.=$this->get_child_capaian($id_data_renja,$table_capaian,$data_f->parent,$random);
						}  	 
			    } 
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	function get_total_program($field="",$kode_direktorat_child="",$tahun_anggaran=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
		$total_semua=0;
		$tahun_anggaran=date("Y");
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,
	 		bno_rm_d,bno_phln_p,bno_phln_d,pnbp 
 	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' "); 
 		 	 
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
				} else if($field=="bno_rm_p"){
						if($total_rm_pusat!=""){	
							return $total_rm_pusat;
						}
				} else if($field=="bno_rm_d"){
						if($total_rm_daerah!=""){	
							return $total_rm_daerah;
						}
				}else if($field=="bno_phln_p"){
						if($total_phln_pusat!=""){	
							return $total_phln_pusat;
						}
			 	}else if($field=="bno_phln_d"){
			 			if($total_phln_daerah!=""){	
							return $total_phln_daerah;
						}
			 	}else if($field=="pnbp"){
			 			if($total_pnbp!=""){	
							return $total_pnbp;
						}
			 	}  

		}
	 
	 function get_total_header($table_capaian="",$kode_direktorat_child="",$bulan="",$tahun="",$id="",$random=""){
 		
 		$jumlah=0;	
 		$tipe_table="";
 		 
        $total_komponen_input_capaian_kinerja=1;
        $total_komponen_input_capaian_kinerja= $this->cek_total_komponen_input($kode_direktorat_child,$tahun);
 		$query=$this->db->query("select   (c_".$bulan.") as jumlah,kode,parent from ".$table_capaian." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
 			and  (tahun)='".trim($tahun)."' and kode!='' and random='".$random."'");
    		 	if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					if(!$this->check_child_total_header($id,$data->kode)){
						$jumlah=$jumlah+$data->jumlah;	
					}
				}			 	
			}
		if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
			return $jumlah / $total_komponen_input_capaian_kinerja;
		}	 else {
	 		return $jumlah;
 		}
 	}
 	function cek_total_komponen_input($kode_direktorat_child="",$tahun=""){
 		$jumlah=0;
 		$tahun_anggaran=0;
 		$q=$this->db->query("select tahun_anggaran as  tahun_anggaran from tahun_anggaran where id='".$tahun."'");
			 if ($q->num_rows() > 0) {
				foreach ($q->result() as $row) {
					$tahun_anggaran=$row->tahun_anggaran;
				}
 			}
  		$query=$this->db->query("select count(1) as jumlah from data_template_renja where kode_direktorat_child='".$kode_direktorat_child."'  and tahun_berlaku='".$tahun_anggaran."' 
  			and tipe='komponen_input'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
 	}
 	function check_child_total_header($id="",$kode=""){
		$query=$this->db->query("select  a.id as id,tahun_anggaran.tahun_anggaran as tahun from data_template_renja a
			left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			where a.id_data_renja='".$id."' and parent='".$kode."' and tipe!='sub_komponen_input'  order by a.urutan asc");
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
	function get_child_capaian($id="",$table_capaian="",$parent="",$random=""){
		$table="";
		$class_xeditable='';
 		 
		$bg_ikk="";
		$style_header="vertical-align:middle;font-size:10px;font-weight:normal;height:50px;";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,template_renja.tahun_anggaran as tahun_berlaku,
		(select c_01 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from ".$table_capaian." where random='".$random."' and  trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from ".$table_capaian." where random='".$random."' and trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12'
		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$parent."') and trim(tipe)!='program' order by a.urutan asc");
   			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				   if($data_f->tipe!="sub_komponen_input") {
					$c_01=0;
					$c_02=0;
					$c_03=0;
					$c_04=0;
					$c_05=0;
					$c_06=0;
					$c_07=0;
					$c_08=0;
					$c_09=0;
					$c_10=0;
					$c_11=0;
					$c_12=0;
					 
 					$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.=";font-weight:bold";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;width:10px;background-color:#2C802C'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center> ".strtoupper($data_f->kode)."  </center></td>";
							$table.="<td colspan='2' style='".$style_header."'> ".ucwords(strtolower($data_f->indikator))."</td>";
							$c_01=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,$random);
							$c_02=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,$random);
							$c_03=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,$random);
							$c_04=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,$random);
							$c_05=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,$random);
							$c_06=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,$random);
							$c_07=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,$random);
							$c_08=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,$random);
							$c_09=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,$random);
							$c_10=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,$random);
							$c_11=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,$random);
							$c_12=$this->get_total_indikator_capaian($table_capaian,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,$random);
						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;;width:10px;background-color:#31BC86'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center>".strtoupper($data_f->kode)."</center> </td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".ucwords(strtolower($data_f->komponen_input))."  </td>";
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
			 					 
								
								$c_01=$data_f->c_01;
								$c_02=$data_f->c_02;
								$c_03=$data_f->c_03;
								$c_04=$data_f->c_04;
								$c_05=$data_f->c_05;
								$c_06=$data_f->c_06;
								$c_07=$data_f->c_07;
								$c_08=$data_f->c_08;
								$c_09=$data_f->c_09;
								$c_10=$data_f->c_10;
								$c_11=$data_f->c_11;
								$c_12=$data_f->c_12;
								 
						}	else if($data_f->tipe=="sub_komponen_input"){
 
						}	
						

					
							
							$total_pagu=0;
							$bo01=0;
							$bo02=0;
							$bno_phln_p=0;
							$bno_phln_d=0;
							$bno_rm_p=0;
							$bno_rm_d=0;
							$pnbp=0;

					 		if ($this->cek_child_anak($data_f->id_data_renja,$data_f->kode)) {
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
 							} else {
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun);
								
							}
 					 
				 			$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
									
							
							$table.="<td style='".$style_header."'> ".ucwords(strtolower($data_f->sasaran_kegiatan))." </td>";
				 			$table.="<td style='".$style_header."'>".$data_f->target."</td>"; 	
				 			$table.="<td style='".$style_header."'><center>".number_format($total_pagu)."</center></td>"; 

							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
 					 		
 					 		$rp_triwulan_1=($c_01+$c_02+$c_03);
				        	$rp_triwulan_2=($c_04+$c_05+$c_06);
				        	$rp_triwulan_3=($c_07+$c_08+$c_09);
				        	$rp_triwulan_4=($c_10+$c_11+$c_12);
							
							$pembagi=1;
							$kali_seratus=1;
				        	if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
								$pembagi=3;
					        } else {
					        	if($total_pagu==0){
					        		$total_pagu=1;
					        	}
					        	$pembagi=$total_pagu;
					        	$kali_seratus=100;
					        }	
				         	
				        	$persen_triwulan_1=(($rp_triwulan_1) / $pembagi) * $kali_seratus;
					        $persen_triwulan_2=(($rp_triwulan_2) / $pembagi) * $kali_seratus;
					        $persen_triwulan_3=(($rp_triwulan_3) / $pembagi) * $kali_seratus;
					        $persen_triwulan_4=(($rp_triwulan_4) / $pembagi) * $kali_seratus;

				        	$rp_triwulan_1=number_format($rp_triwulan_1);
				        	$rp_triwulan_2=number_format($rp_triwulan_2);
				        	$rp_triwulan_3=number_format($rp_triwulan_3);
				        	$rp_triwulan_4=number_format($rp_triwulan_4);

				        	if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  				       

				        	$tipe_capaian="";
							$table_append="";
					        $table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_01)))."</center>";
				        	$table_append.="</td>";
				        	
				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_02)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_03)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_1."</b></center></td>";
				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";


				        	$table_append.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_04)))."</center>";
				        	$table_append.="</td>";



				        	$table_append.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_05)))."</center>";
				        	$table_append.="</td>";

				        	$table_append.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_06)))."</center>";
				        	$table_append.="</td>";

				        	$table_append.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_2."</b></center></td>";
				        	$table_append.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";


				        	$table_append.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_07)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_08)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_09)))."</center>";
				        	$table_append.="</td>";

				        	$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_3."</b></center></td>";
				        	$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";


				        	$table_append.="<td  class='triwulan_4' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_10)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_11)))."</center>";
				        	$table_append.="</td>";


				        	$table_append.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="
				        	<center>".strtoupper(trim(number_format($c_12)))."</center>";
				        	$table_append.="</td>";

				        	$table_append.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b>".$rp_triwulan_4."</b></center></td>";
				        	$table_append.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";
				        	
				        	$table_append.="<td style='vertical-align:middle;font-size:10px;'>";
				        	$total_kesamping=0;

							if(($table_capaian=="capaian_kinerja_target") or ($table_capaian=="capaian_kinerja")){
									$total_kesamping=(($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12);
									$table_append.="<center>-</a>";
								} else {
									$total_kesamping=$c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12;
									$table_append.="<center>".strtoupper(trim(number_format($total_kesamping)))."</center></a>";
							}
							$table_append.="</td>";


				        	$percentange=0;
				        	if($table_capaian=="capaian_kinerja_target")  {
					        	if($total_kesamping > 0){
						        	$percentange=$total_kesamping;
								}
								if($total_pagu > 0){
						        	$percentange=$total_kesamping;
								}
							} else if ($table_capaian=="capaian_kinerja"){
								if($total_kesamping > 0){
						        	$percentange=$total_kesamping;
								}
								if($total_pagu > 0){
						        	$percentange=$total_kesamping;
								}
							} else { 
								$percentange=($total_kesamping / $total_pagu ) * 100;							
							}	

				        	$table_append.="<td style='vertical-align:middle;font-size:10px;'>";
				        	$table_append.="<center><b>".strtoupper(trim(number_format($percentange,1)))."</b></center></a>";
				        	$table_append.="</td>";



					        $table.=$table_append;
					        $table.="</tr>";
						}	

						
				        	if ($this->cek_child_anak($id,$data_f->parent)) {
								$table.=$this->get_child_capaian($id,$table_capaian,trim($data_f->kode),$random);
						}
				} 
			}  
			return $table;
	}
	function get_total_indikator_capaian($table_capaian="",$kode_direktorat_child="",$parent="",$bulan="",$tahun="",$random=""){
		$tipe_data="";
		 
		$bagi=0;
		$total=0;
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah,(
		select count(c_".$bulan.") as total  from ".$table_capaian." where trim(parent)='".trim($parent)."' and trim(tahun)='".trim($tahun)."'  
		) as total from ".$table_capaian." where 
		trim(parent)='".trim($parent)."'		 
		and trim(tahun)='".trim($tahun)."' and random='".$random."'");
 		   		 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							$jumlah=$data->jumlah;
							$total=$data->total;
						}
				}		
 				
		if($table_capaian=="capaian_kinerja_target"){
		  		if($total!="0"){
		  			return $jumlah/$total;
		  		}	
		} else if($table_capaian=="capaian_kinerja")	{
				if($total!="0"){
		  			return $jumlah/$total;
		  		}	
		} else {
			 
 				return $jumlah;
			 
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
		}	else {
		$query=$this->db->query("select * from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.kode)='".trim($kode)."'	
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
}		
?>
