<?php
class capaian_renja_model extends CI_Model{
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
			where 1=1 $sql  order by a.id desc LIMIT $limit,$offset");
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
	 function get_data_detail($id=""){     	
			$query=$this->db->query("select * from template_renja where id='".$id."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
	function simpan_selain_kinerja_target(){
		$id=$this->input->post('name');
		$tipe_analisis=$this->input->post('tipe_analisis');
		$kode_direktorat_child="";
	 	$kode_indikator="";
	 	$indikator="";
	 	$bulan="";
	 	$jumlah=$this->input->post('value');
	 	$deskripsi=$this->input->post('deskripsi');
	 	$bulan=$this->session->userdata('bulan');
		$panjang=strlen($bulan);
		if($panjang=="1"){
			$bulan='0'.$bulan;
		}
		$query=$this->db->query("select  *,template_renja.tahun_anggaran,a.kode_direktorat_child,a.kode,a.parent
		from data_template_renja a 
		left join template_renja on template_renja.id=a.id_data_renja	
		where a.id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $kode_direktorat_child=$data->kode_direktorat_child;
					 $kode=$data->kode;
					 $parent=$data->parent; 
					 $tahun_anggaran=$data->tahun_anggaran;
				}
			}
		
		
		if($tipe_analisis=="kinerja"){
           $table_capaian="capaian_kinerja_target";
        } else  if($tipe_analisis=="keuangan"){
           $table_capaian="capaian_keuangan_target";
        } else  if($tipe_analisis=="phln"){
           $table_capaian="capaian_phln_target";
        } else  if($tipe_analisis=="dktp"){
           $table_capaian="capaian_dktp_target";
        } else  if($tipe_analisis=="lakip"){
           $table_capaian="capaian_lakip_target";
        } else  if($tipe_analisis=="renaksi"){
           $table_capaian="capaian_renaksi_target";
		}
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$data=array(
	 	 'kode_direktorat_child'=>$kode_direktorat_child,
		 'kode'=>$kode,
		 'parent'=>$parent,
		 'jumlah'=>0,
		 'c_'.$bulan=>$jumlah,
		 'd_'.$bulan=>$deskripsi,
		 'tahun'=>$tahun_anggaran,
		 'tanggal'=>date("Y-m-d"),
		);

		$cek_exist=$this->cek_exist($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
 		if($cek_exist =='0'){
			$this->db->trans_start();
			$this->db->insert($table_capaian,$data);
			$this->db->trans_complete();
		} else {
			$this->db->trans_start();
			$this->db->where(('trim(kode_direktorat_child)'),trim($kode_direktorat_child));
			$this->db->where(('trim(kode)'),trim($kode));
			$this->db->where(('trim(parent)'),trim($parent));
			$this->db->where(('trim(tahun)'),trim($tahun_anggaran));
			$this->db->update($table_capaian,$data); 
			$this->db->trans_complete();
	 	}	 
	 	$json=json_encode($data);
	 	$this->load->model("history_model"); 
		$this->history_model->simpan('capaian_target','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);

	 	//$this->reset_indikator_affter_insert_sub_komponen_input('target');

	}
	function get_parent($parent=""){
		$query=$this->db->query("select * from data_template_renja where trim(kode)='$parent'");
 		return $query->row();
	}
	function reset_indikator_affter_insert_sub_komponen_input($tipe=""){		
		$id=$this->input->post('name');
		$tipe_analisis=$this->input->post('tipe_analisis');
		$table="";
		$total=0;
		$tipe_tabel="";
		if($tipe=='target'){
			$tipe_tabel="_target";
		}
		$bulan=$this->session->userdata('bulan');
		if($tipe_analisis=="kinerja"){
           $table="capaian_kinerja".$tipe_tabel;
        } else  if($tipe_analisis=="keuangan"){
           $table="capaian_keuangan".$tipe_tabel;
        } else  if($tipe_analisis=="phln"){
           $table="capaian_phln".$tipe_tabel;
        } else  if($tipe_analisis=="dktp"){
           $table="capaian_dktp".$tipe_tabel;
        } else  if($tipe_analisis=="lakip"){
           $table="capaian_lakip".$tipe_tabel;
        } else  if($tipe_analisis=="renaksi"){
           $table="capaian_renaksi".$tipe_tabel;
		}

		$query=$this->db->query("select  *,template_renja.tahun_anggaran,template_renja.tahun_anggaran,a.kode_direktorat_child,a.kode,a.parent
		from data_template_renja a 
		left join template_renja on template_renja.id=a.id_data_renja	
		where a.id='$id'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $kode_direktorat_child=$data->kode_direktorat_child;
					 $kode=$data->kode;
					 $parent=$data->parent; 
					 $tahun=$data->tahun_anggaran;
					 $tipe=$data->tipe;			
					 $info=$this->get_parent(trim($parent));		
					 $lv_up_kode=$info->kode;
					 $lv_up_parent=$info->parent;
				}
		}
	 	if($tipe=="sub_komponen_input"){
	 		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah from ".$table." where 
	 			trim(parent)='".trim($parent)."'		 
	  			and trim(tahun)='".trim($tahun)."'"); 
	    			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {				
	  					 $total=$data->jumlah;
					}		
				}
		}
		$cek_if_exist_capaian=$this->cek_if_exist_capaian($kode_direktorat_child,$table,$lv_up_kode,$lv_up_parent,$tahun);
			$data=array(
		 	 'kode_direktorat_child'=>$kode_direktorat_child,
			 'kode'=>$lv_up_kode,
			 'parent'=>$lv_up_parent,
			 'jumlah'=>"0",
			 'c_'.$bulan=>$total,
			 'tahun'=>$tahun,
			 'tanggal'=>date("Y-m-d"),

			);
 		if($cek_if_exist_capaian=="0"){
			$this->db->trans_start();
			$this->db->insert($table,$data);
			$this->db->trans_complete();
		} else {
			$this->db->trans_start();
			$this->db->where(('trim(kode_direktorat_child)'),trim($kode_direktorat_child));
			$this->db->where(('trim(kode)'),trim($lv_up_kode));
			$this->db->where(('trim(parent)'),trim($lv_up_parent));
			$this->db->where(('trim(tahun)'),trim($tahun));
			$this->db->update($table,$data); 
			$this->db->trans_complete();
		}

		// echo $this->db->last_query();
		//echo $cek_if_exist_capaian;
		/*echo("update ".$table." set 
			c_".$bulan."='".$total."' where  kode='".$lv_up_kode."'  and parent='".$lv_up_parent."' "); */
		
	}
	function cek_if_exist_capaian($kode_direktorat_child="",$table_capaian="",$kode="",$parent="",$tahun_anggaran=""){
		$query=$this->db->query("select count(1) as jumlah from ".trim($table_capaian)."    
		where trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'	
		and trim(kode)='".trim($kode)."'	
		and trim(parent)='".trim($parent)."'	
		and trim(tahun)='".trim($tahun_anggaran)."'");
		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function simpan_selain_kinerja_realisasi(){
		$id=$this->input->post('name');
		$tipe_analisis=$this->input->post('tipe_analisis');
		$kode_direktorat_child="";
	 	$kode_indikator="";
	 	$indikator="";
	 	$bulan="";
	 	$jumlah=$this->input->post('value');
	 	$deskripsi=$this->input->post('deskripsi');
	 	$bulan=$this->session->userdata('bulan');
		$panjang=strlen($bulan);
		if($panjang=="1"){
			$bulan='0'.$bulan;
		}
		$query=$this->db->query("select  *,template_renja.tahun_anggaran,a.kode_direktorat_child,a.kode,a.parent
		from data_template_renja a 
		left join template_renja on template_renja.id=a.id_data_renja	
		where a.id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $kode_direktorat_child=$data->kode_direktorat_child;
					 $kode=$data->kode;
					 $parent=$data->parent; 
					 $tahun_anggaran=$data->tahun_anggaran;
				}
			}
		
		
		if($tipe_analisis=="kinerja"){
           $table_capaian="capaian_kinerja";
        } else  if($tipe_analisis=="keuangan"){
           $table_capaian="capaian_keuangan";
        } else  if($tipe_analisis=="phln"){
           $table_capaian="capaian_phln";
        } else  if($tipe_analisis=="dktp"){
           $table_capaian="capaian_dktp";
        } else  if($tipe_analisis=="lakip"){
           $table_capaian="capaian_lakip";
        } else  if($tipe_analisis=="renaksi"){
           $table_capaian="capaian_renaksi";
		}
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$data=array(
	 	 'kode_direktorat_child'=>$kode_direktorat_child,
		 'kode'=>$kode,
		 'parent'=>$parent,
		 'jumlah'=>0,
		 'c_'.$bulan=>$jumlah,
		 'd_'.$bulan=>$deskripsi,
		 'tahun'=>$tahun_anggaran,
		 'tanggal'=>date("Y-m-d"),
		);

		$cek_exist=$this->cek_exist($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
 		if($cek_exist =='0'){
			$this->db->trans_start();
			$this->db->insert($table_capaian,$data);
			$this->db->trans_complete();
		} else {
			$this->db->trans_start();
			$this->db->where(('trim(kode_direktorat_child)'),trim($kode_direktorat_child));
			$this->db->where(('trim(kode)'),trim($kode));
			$this->db->where(('trim(parent)'),trim($parent));
			$this->db->where(('trim(tahun)'),trim($tahun_anggaran));
			$this->db->update($table_capaian,$data); 
			$this->db->trans_complete();
	 	}	 	
	 	$json=json_encode($data); 
	 	$this->load->model("history_model"); 
		$this->history_model->simpan('capaian_realisasi','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);

	 //	$this->reset_indikator_affter_insert_sub_komponen_input('realisasi');
	}
	function get_last_capaian($table="",$id_data_renja="",$tahun="",$kd_unit_kerja=""){
		$i=1;
		$query=$this->db->query("select *  from  log_capaian a
 		where a.kode_direktorat_child='".$kd_unit_kerja."' and tahun='".$tahun."' and jenis_capaian='$table' group by random");
    		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$i++;
				
			}
		}		
		return $i ;
	}
	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	function backup_data_capaian($table="",$id_data_renja="",$tahun="",$kd_unit_kerja="",$judul=""){		
		$max_id=$this->get_last_capaian($table,$id_data_renja,$tahun,$kd_unit_kerja);
		$random=$this->generateRandomString();
 		$query=$this->db->query("select * from ".$table." a
 		where a.kode_direktorat_child='".$kd_unit_kerja."' and tahun='".$tahun."'");
  		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				 	$data=array(
				 		 'random'=>$random,	
				 		 'judul'=>'REVISI KE ( '.$max_id.' ) ',
				 	 	 'jenis_capaian'=>$table,
				 	 	 'text'=>$judul,
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
						 'tanggal_log'=>date("Y-m-d h:i:s")
						);		
						$this->db->trans_start();
						$this->db->insert('log_capaian',$data);
						$this->db->trans_complete();
					}
				}

	}		
	function cek_if_capaian_approve(){
		$capaian_dktp_realisasi=$this->input->post('capaian_dktp_realisasi');
		$capaian_dktp_target=$this->input->post('capaian_dktp_target');
		$capaian_keuangan_realisasi=$this->input->post('capaian_keuangan_realisasi');
		$capaian_keuangan_target=$this->input->post('capaian_keuangan_target');
		$capaian_kinerja_realisasi=$this->input->post('capaian_kinerja_realisasi');
		$capaian_kinerja_target=$this->input->post('capaian_kinerja_target');
		$capaian_phln_realisasi=$this->input->post('capaian_phln_realisasi');
		$capaian_phln_target=$this->input->post('capaian_phln_target');
		$capaian_renaksi_realisasi=$this->input->post('capaian_renaksi_realisasi');
		$capaian_renaksi_target=$this->input->post('capaian_renaksi_target');
		$id=$this->input->post('id');

		$tahun="";
		$kd_unit_kerja="";
		$query=$this->db->query("select * from template_renja a
		left join m_unit_kerja on m_unit_kerja.id_divisi=a.dari 
		where a.id='".$id."'");
 		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$row_capaian_dktp_realisasi=$data->capaian_dktp_realisasi;
				$row_capaian_dktp_target=$data->capaian_dktp_target;
				$row_capaian_keuangan_realisasi=$data->capaian_keuangan_realisasi;
				$row_capaian_keuangan_target=$data->capaian_keuangan_target;
				$row_capaian_kinerja_realisasi=$data->capaian_kinerja_realisasi;
				$row_capaian_kinerja_target=$data->capaian_kinerja_target;
				$row_capaian_phln_realisasi=$data->capaian_phln_realisasi;
				$row_capaian_phln_target=$data->capaian_phln_target;
				$row_capaian_renaksi_realisasi=$data->capaian_renaksi_realisasi;
				$row_capaian_renaksi_target=$data->capaian_renaksi_target;
				$tahun=$data->tahun_anggaran;					
				$kd_unit_kerja=$data->kd_unit_kerja;		
				$id_data_renja=$data->id;			
			}
		}

		if(($capaian_kinerja_target=="1") and ($row_capaian_kinerja_target=="0")){
			$this->backup_data_capaian('capaian_kinerja_target',$id_data_renja,$tahun,$kd_unit_kerja,'TARGET KINERJA');
 
 		}
		if(($capaian_keuangan_realisasi=="1") and ($row_capaian_kinerja_realisasi=="0")){
			$this->backup_data_capaian('capaian_kinerja',$id_data_renja,$tahun,$kd_unit_kerja,'REALISASI KINERJA');
 		}

		if(($capaian_keuangan_target=="1") and ($row_capaian_keuangan_target=="0")){
			$this->backup_data_capaian('capaian_keuangan_target',$id_data_renja,$tahun,$kd_unit_kerja,'TARGET KEUANGAN');
 		}
		if(($capaian_keuangan_realisasi=="1") and ($row_capaian_keuangan_realisasi=="0")){
			$this->backup_data_capaian('capaian_keuangan',$id_data_renja,$tahun,$kd_unit_kerja,'REALISASI KEUANGAN');
 		}

		if(($capaian_phln_target=="1") and ($row_capaian_phln_target=="0")){
			$this->backup_data_capaian('capaian_phln_target',$id_data_renja,$tahun,$kd_unit_kerja,'TARGET PHLN');
 		}
		if(($capaian_phln_realisasi=="1") and ($row_capaian_phln_realisasi=="0")){
			$this->backup_data_capaian('capaian_phln',$id_data_renja,$tahun,$kd_unit_kerja,'REALISASI PHLN');
 		}

		if(($capaian_dktp_target=="1") and ($row_capaian_dktp_target=="0")){
			$this->backup_data_capaian('capaian_dktp_target',$id_data_renja,$tahun,$kd_unit_kerja,'TARGET DKTP');
 		}
		if(($capaian_dktp_realisasi=="1") and ($row_capaian_dktp_realisasi=="0")){
			$this->backup_data_capaian('capaian_dktp',$id_data_renja,$tahun,$kd_unit_kerja,'REALISASI DKTP');
 		}

		if(($capaian_renaksi_target=="1") and ($row_capaian_renaksi_target=="0")){
			$this->backup_data_capaian('capaian_renaksi_target',$id_data_renja,$tahun,$kd_unit_kerja,'TARGET RENAKSI');
 		}
		if(($capaian_renaksi_realisasi=="1") and ($row_capaian_renaksi_realisasi=="0")){
			$this->backup_data_capaian('capaian_renaksi',$id_data_renja,$tahun,$kd_unit_kerja,'REALISASI RENAKSI');
 		}

	}
	function simpan_persetujuan(){
		$id=$this->input->post('id');
		$capaian_dktp_realisasi=$this->input->post('capaian_dktp_realisasi');
		$capaian_dktp_target=$this->input->post('capaian_dktp_target');
		$capaian_keuangan_realisasi=$this->input->post('capaian_keuangan_realisasi');
		$capaian_keuangan_target=$this->input->post('capaian_keuangan_target');
		$capaian_kinerja_realisasi=$this->input->post('capaian_kinerja_realisasi');
		$capaian_kinerja_target=$this->input->post('capaian_kinerja_target');
		$capaian_phln_realisasi=$this->input->post('capaian_phln_realisasi');
		$capaian_phln_target=$this->input->post('capaian_phln_target');
		$capaian_renaksi_realisasi=$this->input->post('capaian_renaksi_realisasi');
		$capaian_renaksi_target=$this->input->post('capaian_renaksi_target');
		$cek_if_capaian_approve=$this->cek_if_capaian_approve();
		$data=array(
	 	 'capaian_dktp_realisasi'=>$capaian_dktp_realisasi,
		 'capaian_dktp_target'=>$capaian_dktp_target,
		 'capaian_keuangan_realisasi'=>$capaian_keuangan_realisasi,
		 'capaian_keuangan_target'=>$capaian_keuangan_target,
		 'capaian_kinerja_realisasi'=>$capaian_kinerja_realisasi,
		 'capaian_kinerja_target'=>$capaian_kinerja_target,
		 'capaian_phln_realisasi'=>$capaian_phln_realisasi,
		 'capaian_phln_target'=>$capaian_phln_target,
		 'capaian_renaksi_realisasi'=>$capaian_renaksi_realisasi,
		 'capaian_renaksi_target'=>$capaian_renaksi_target,
		);
		$this->db->trans_start();
		$this->db->where('id',$id);
		$this->db->update('template_renja', $data); 
		$this->db->trans_complete();
		if($cek_if_capaian_approve){
		$c= '<i class="glyphicon glyphicon-ok-sign" style="font-size:20px"></i> Sukses Melakukan Persetujuan Data ....<br>'.
			 '<i class="glyphicon glyphicon-ok-sign" style="font-size:20px"></i> Sukses Melakukan Backup Data ....';
			 echo $c;
		}	 
	}
	function simpan_target(){
		$id=$this->input->post('name');
		$tipe_analisis=$this->input->post('tipe_analisis');
		$kode_direktorat_child="";
	 	$kode_indikator=""; 
	 	$indikator="";
	 	$bulan="";
	 	$jumlah=$this->input->post('value');
	 	$deskripsi=$this->input->post('deskripsi');
	 	$bulan=$this->session->userdata('bulan');
		$panjang=strlen($bulan);
 		if($panjang=="1"){
			$bulan='0'.$bulan;
		}
		$query=$this->db->query("select  *,template_renja.tahun_anggaran,a.kode_direktorat_child,a.kode,a.parent
		from data_template_renja a 
		left join template_renja on template_renja.id=a.id_data_renja	
		where a.id='$id'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $kode_direktorat_child=$data->kode_direktorat_child;
					 $kode=$data->kode;
					 $parent=$data->parent; 
					 $tahun_anggaran=$data->tahun_anggaran;
				}
			}
		
		
		if($tipe_analisis=="kinerja"){
           $table_capaian="capaian_kinerja_target";
        } else  if($tipe_analisis=="keuangan"){
           $table_capaian="capaian_keuangan_target";
        } else  if($tipe_analisis=="phln"){
           $table_capaian="capaian_phln_target";
        } else  if($tipe_analisis=="dktp"){
           $table_capaian="capaian_dktp_target";
        } else  if($tipe_analisis=="lakip"){
           $table_capaian="capaian_lakip_target";
        } else  if($tipe_analisis=="renaksi"){
           $table_capaian="capaian_renaksi_target";
		}
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$data=array(
	 	 'kode_direktorat_child'=>$kode_direktorat_child,
		 'kode'=>$kode,
		 'parent'=>$parent,
		 'jumlah'=>0,
		 'c_'.$bulan=>$jumlah,
		 'd_'.$bulan=>$deskripsi,
		 'tahun'=>$tahun_anggaran,
		 'tanggal'=>date("Y-m-d"),
		);

		$cek_exist=$this->cek_exist($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
 		if($cek_exist =='0'){
			$this->db->trans_start();
			$this->db->insert($table_capaian,$data);
			$this->db->trans_complete();
		} else {
			$this->db->trans_start();
			$this->db->where(('trim(kode_direktorat_child)'),trim($kode_direktorat_child));
			$this->db->where(('trim(kode)'),trim($kode));
			$this->db->where(('trim(parent)'),trim($parent));
			$this->db->where(('trim(tahun)'),trim($tahun_anggaran));
			$this->db->update($table_capaian,$data); 
			$this->db->trans_complete();
	 	}	 	 
	 	$json=json_encode($data);
	 	$this->load->model("history_model"); 
		$this->history_model->simpan('capaian_target','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
	 	//$this->reset_indikator_affter_insert_sub_komponen_input('target');
	}

	function simpan_realisasi(){
		$id=$this->input->post('name');
		$tipe_analisis=$this->input->post('tipe_analisis');
		$kode_direktorat_child="";
	 	$kode_indikator="";
	 	$indikator="";
	 	$bulan="";
	 	$jumlah=$this->input->post('value');
	 	$deskripsi=$this->input->post('deskripsi');
	 	$bulan=$this->session->userdata('bulan');
		$panjang=strlen($bulan);
		if($panjang=="1"){
			$bulan='0'.$bulan;
		}
		$query=$this->db->query("select  *,template_renja.tahun_anggaran,a.kode_direktorat_child,a.kode,a.parent
		from data_template_renja a 
		left join template_renja on template_renja.id=a.id_data_renja	
		where a.id='$id'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $kode_direktorat_child=$data->kode_direktorat_child;
					 $kode=$data->kode;
					 $parent=$data->parent; 
					 $tahun_anggaran=$data->tahun_anggaran;
				}
			}
		
		
		if($tipe_analisis=="kinerja"){
           $table_capaian="capaian_kinerja";
        } else  if($tipe_analisis=="keuangan"){
           $table_capaian="capaian_keuangan";
        } else  if($tipe_analisis=="phln"){
           $table_capaian="capaian_phln";
        } else  if($tipe_analisis=="dktp"){
           $table_capaian="capaian_dktp";
        } else  if($tipe_analisis=="lakip"){
           $table_capaian="capaian_lakip";
        } else  if($tipe_analisis=="renaksi"){
           $table_capaian="capaian_renaksi";
		}
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$data=array(
	 	 'kode_direktorat_child'=>$kode_direktorat_child,
		 'kode'=>$kode,
		 'parent'=>$parent,
		 'jumlah'=>0,
		 'c_'.$bulan=>$jumlah,
		 'd_'.$bulan=>$deskripsi,
		 'tahun'=>$tahun_anggaran,
		 'tanggal'=>date("Y-m-d"),
		);
		$cek_exist=$this->cek_exist($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
		$cek_if_lebih_seratus=$this->cek_if_lebih_seratus($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
 		$get_field_month=$this->get_field_month($kode_direktorat_child,$kode,$parent,$table_capaian,$tahun_anggaran);
 		$jumlah_semua=$cek_if_lebih_seratus-$get_field_month+$jumlah;
 		//if($jumlah_semua <= 100000){
 		if($jumlah <= 100){
	 		if($cek_exist =='0'){
				$this->db->trans_start();
				$this->db->insert($table_capaian,$data);
				$this->db->trans_complete();
			} else {
				$this->db->trans_start();
				$this->db->where(('trim(kode_direktorat_child)'),trim($kode_direktorat_child));
				$this->db->where(('trim(kode)'),trim($kode));
				$this->db->where(('trim(parent)'),trim($parent));
				$this->db->update($table_capaian,$data); 
				$this->db->trans_complete();
		 	}	 	
		 } else {
		 	echo "Jumlah Tidak Boleh Lebih Dari 100% ";
		 }	 
		 $json=json_encode($data);
		$this->load->model("history_model"); 
		$this->history_model->simpan('capaian_realisasi','USER BERNAMA ' .$this->session->userdata('NAMA') .' MELAKUKAN PERUBAHAN DATA RENJA  DENGAN DATA ' ,$json);
		//$this->reset_indikator_affter_insert_sub_komponen_input('realisasi');
	}
	function get_field_month($kode_direktorat_child="",$kode_indikator="",$indikator="",$table_capaian="",$tahun_anggaran=""){
		$total=0;
		$bulan=$this->session->userdata('bulan');
		$query=$this->db->query("select 
			(c_".$bulan.") as jumlah
			from capaian_kinerja where trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(kode)='".trim($kode_indikator)."'	
			and trim(parent)='".trim($indikator)."'	
			and trim(tahun)='".trim($tahun_anggaran)."'");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total=$data->jumlah;
					}			 	 
			}
			return $total;
	}
	function cek_if_lebih_seratus($kode_direktorat_child="",$kode_indikator="",$indikator="",$table_capaian="",$tahun_anggaran=""){		 
			$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_kinerja where trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(kode)='".trim($kode_indikator)."'	
			and trim(parent)='".trim($indikator)."'	
			and trim(tahun)='".trim($tahun_anggaran)."'	
			");
			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total=$data->jumlah;
					}			 	 
			}
			return $total;
	}

	function cek_exist($kode_direktorat_child="",$kode="",$parent="",$table_capaian="",$tahun_anggaran=""){
		$query=$this->db->query("select count(1) as jumlah from ".trim($table_capaian)."    
		where trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'	
		and trim(kode)='".trim($kode)."'	
		and trim(parent)='".trim($parent)."'	
		and trim(tahun)='".trim($tahun_anggaran)."'	
		");
		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
  
	function get_update($id=""){
     	$query=$this->db->query("select *,tahun_anggaran.id as id_tahun_anggaran,
     		(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  ,
			(select kd_unit_kerja from m_unit_kerja where id_divisi=a.dari) as kd_unit_kerja  
			from template_renja a 
			left join tahun_anggaran on tahun_anggaran.id=a.tahun_anggaran
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
    function cek_tahun_target_capaian_exist(){
    	$id_tahun=$this->input->post('id_tahun');
		$query=$this->db->query("select count(1) as jumlah from capaian_kinerja_target where tahun_anggaran='".$id_tahun."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}
				return $jumlah;
			}
    }

    function simpan_persentase_target(){
    	$id=$this->input->post('id');
		$id_tahun=$this->input->post('id_tahun');
		$target_capaian=$this->input->post('target_capaian');	
		$cek=$this->cek_tahun_target_capaian_exist();
		$data=array(
	 	 'target'=>$target_capaian,
		 'tahun_anggaran'=>$id_tahun,
		);
 
		if($cek=='0'){
			$this->db->trans_start();
			$this->db->insert('capaian_persentase_kinerja_target',$data);
			$this->db->trans_complete(); 
		} 
			else 
		{
			$this->db->trans_start();
			$this->db->where('tahun_anggaran',$id_tahun);
			$this->db->update('capaian_kinerja_target', $data); 
			$this->db->trans_complete();
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
 	function get_target_capaian($id=""){
 		$target=0;
 		$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
 		$query=$this->db->query("select target from capaian_persentase_kinerja_target where tahun_anggaran='".$tahun_berlaku."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$target=$data->target;
				}
				return $target;
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
 	function get_total_header_capaian_target($id_table="",$kode_direktorat_child="",$bulan="",$tahun="",$tipe="",$id=""){
 		
 		$jumlah=0;	
 		$tipe_table="";
 		if($tipe=="target"){
 			$tipe_table="_target";
 		}
 		if($id_table=="1"){
           $table="capaian_kinerja".$tipe_table;
        } else  if($id_table=="2"){
           $table="capaian_keuangan".$tipe_table;
        } else  if($id_table=="3"){
           $table="capaian_phln".$tipe_table;
        } else  if($id_table=="4"){
           $table="capaian_dktp".$tipe_table;
        } else  if($id_table=="5"){
           $table="capaian_lakip".$tipe_table;
        } else  if($id_table=="6"){
           $table="capaian_renaksi".$tipe_table;
        }
        $total_komponen_input_capaian_kinerja=1;
        $total_komponen_input_capaian_kinerja= $this->cek_total_komponen_input($kode_direktorat_child,$tahun);
 		$query=$this->db->query("select   (c_".$bulan.") as jumlah,kode,parent from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
 			and  (tahun)='".trim($tahun)."'");
    		 	if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					if(!$this->check_child_total_header($id,$data->kode)){
						$jumlah=$jumlah+$data->jumlah;	
					}
				}			 	
			}
		if($id_table=="1"){
			return $jumlah / $total_komponen_input_capaian_kinerja;
		}	 else {
	 		return $jumlah;
 		}
 	}
	function get_total_header_capaian_realisasi($id_table="",$kode_direktorat_child="",$bulan="",$tahun="",$tipe="",$id=""){
 		
 		$jumlah=0;	
 		$tipe_table="";
 		if($tipe=="target"){
 			$tipe_table="_target";
 		}
 		if($id_table=="1"){
           $table="capaian_kinerja".$tipe_table;
        } else  if($id_table=="2"){
           $table="capaian_keuangan".$tipe_table;
        } else  if($id_table=="3"){
           $table="capaian_phln".$tipe_table;
        } else  if($id_table=="4"){
           $table="capaian_dktp".$tipe_table;
        } else  if($id_table=="5"){
           $table="capaian_lakip".$tipe_table;
        } else  if($id_table=="6"){
           $table="capaian_renaksi".$tipe_table;
        }
        $total_komponen_input_capaian_kinerja=1;
        $total_komponen_input_capaian_kinerja= $this->cek_total_komponen_input($kode_direktorat_child,$tahun);
 		$query=$this->db->query("select   (c_".$bulan.") as jumlah,kode,parent from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
 			and  (tahun)='".trim($tahun)."'");
     		 	if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					if(!$this->check_child_total_header($id,$data->kode)){
						$jumlah=$jumlah+$data->jumlah;	
					}
				}			 	
		}

		if($id_table=="1"){
			return $jumlah / $total_komponen_input_capaian_kinerja;
			}	 else {
	 		return $jumlah;
 		}
 	} 
	function isletter($char=""){
		if (preg_match('/[a-zA-Z]/', $char)) :
		    return $char.' is a letter<br>';
		endif;
	}
 
	function get_total_capaian_baru_target($id_table="",$kode_direktorat_child="",$kode_indikator="",$indikator="",$bulan="",$tahun=""){
		$jumlah=0;
		if($id_table=="1"){
			$table="capaian_kinerja_target";
		} else if($id_table=="2"){
			$table="capaian_keuangan_target";
		} else if($id_table=="3"){
			$table="capaian_phln_target";
		} else if($id_table=="4"){
			$table="capaian_dktp_target";
		} else if($id_table=="5"){
			$table="capaian_lakip_target";
		} else if($id_table=="6"){
			$table="capaian_renaksi_target";
		}
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
 			and  (tahun)='".trim($tahun)."'");
		 	if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}			 	
			}
		if($id_table!="1"){	
			return $jumlah;	
		} else {
			return "0";
		}
	}
	function get_total_capaian_baru($id_table="",$kode_direktorat_child="",$kode_indikator="",$indikator="",$bulan="",$tahun=""){
		$jumlah=0;
		if($id_table=="1"){
			$table="capaian_kinerja";
		} else if($id_table=="2"){
			$table="capaian_keuangan";
		} else if($id_table=="3"){
			$table="capaian_phln";
		} else if($id_table=="4"){
			$table="capaian_dktp";
		} else if($id_table=="5"){
			$table="capaian_lakip";
		} else if($id_table=="6"){
			$table="capaian_renaksi";
		}
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
 			and  (tahun)='".trim($tahun)."'");
		 	if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}			 	
			}
		if($id_table!="1"){	
			return $jumlah;	
		} else {
			return "0";
		}
	}
	function cari_capaian_jumlah_komponen_input_target($id_table="",$kode_direktorat_child="",$kode_indikator="",$indikator="",$bulan="",$tahun=""){
		if($id_table=="1"){
			$table="capaian_kinerja_target";
		} else if($id_table=="2"){
			$table="capaian_keuangan_target";
		} else if($id_table=="3"){
			$table="capaian_phln_target";
		} else if($id_table=="4"){
			$table="capaian_dktp_target";
		} else if($id_table=="5"){
			$table="capaian_lakip_target";
		} else if($id_table=="6"){
			$table="capaian_renaksi_target";
		}
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
			and trim(kode_indikator)='".trim($kode_indikator)."'		 
 			and  (tahun)='".trim($tahun)."'");

		 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}
			}
		if($id_table!="1"){	
			return $jumlah;	
		} else {
			return "0";
		}	
	}
	function cari_capaian_jumlah_komponen_input($id_table="",$kode_direktorat_child="",$kode_indikator="",$indikator="",$bulan="",$tahun=""){
		if($id_table=="1"){
			$table="capaian_kinerja";
		} else if($id_table=="2"){
			$table="capaian_keuangan";
		} else if($id_table=="3"){
			$table="capaian_phln";
		} else if($id_table=="4"){
			$table="capaian_dktp";
		} else if($id_table=="5"){
			$table="capaian_lakip";
		} else if($id_table=="6"){
			$table="capaian_renaksi";
		}
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
			and trim(kode_indikator)='".trim($kode_indikator)."'		 
 			and  (tahun)='".trim($tahun)."'");

		 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}
			}
		if($id_table!="1"){	
			return $jumlah;	
		} else {
			return "0";
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
	function get_total_indikator_capaian($id_table="",$kode_direktorat_child="",$parent="",$bulan="",$tahun="",$tipe=""){
 		$tipe_data="";
 		if($tipe=='target'){
			$tipe_data="_target";
		}
		if($id_table=="1"){
			$table="capaian_kinerja".$tipe_data;
		} else if($id_table=="2"){
			$table="capaian_keuangan".$tipe_data;
		} else if($id_table=="3"){
			$table="capaian_phln".$tipe_data;
		} else if($id_table=="4"){
			$table="capaian_dktp".$tipe_data;
		} else if($id_table=="5"){
			$table="capaian_lakip".$tipe_data;
		} else if($id_table=="6"){
			$table="capaian_renaksi".$tipe_data;
		}
		$bagi=0;
		$total=0;
		$query=$this->db->query("select  sum(c_".$bulan.") as jumlah,(
		select count(c_".$bulan.") as total  from capaian_kinerja_target where trim(parent)='".trim($parent)."' and trim(tahun)='".trim($tahun)."'  
		) as total from ".$table." where 
		trim(parent)='".trim($parent)."'		 
		and trim(tahun)='".trim($tahun)."'");
		   		 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							$jumlah=$data->jumlah;
							$total=$data->total;
						}
				}
		if($id_table!="1"){	
				return $jumlah;	
			} else {
				if($total!="0"){
					$bagi=$jumlah/$total;
					return $bagi;
				}	
		}	
	}
	function get_total_indikator_from_target($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran="",$id_table=""){
		$jumlah=0;
		$table="";
		$total_semua=0; 

 		if(($id_table=="") and ($id_table!="undefined")) {
			$id_table=$this->input->post('id');
		}	

		if($id_table=="1"){
           $table="capaian_kinerja_target";
        } else  if($id_table=="2"){
           $table="capaian_keuangan_target";
        } else  if($id_table=="3"){
           $table="capaian_phln_target";
        } else  if($id_table=="4"){
           $table="capaian_dktp_target";
        } else  if($id_table=="5"){
           $table="capaian_lakip_target";
        } else  if($id_table=="6"){
           $table="capaian_renaksi_target";
        }
	 	/*$query=$this->db->query("select a.id,
	 		(SELECT sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_11+c_12) from ".$table." where kode=a.kode) as total_semua
	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and trim(a.parent)='".trim($kode)."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!=''"); 
   			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {						 
					$total_semua=$total_semua+$data->total_semua;	 
			}
		}*/
		/*if(($total_semua=="") or ($total_semua=="0") ){*/
				$query=$this->db->query("select a.id,
		 		(SELECT sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_11+c_12) from ".$table." where kode=a.kode) as total_semua
		 		from data_template_renja  a			 
				where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
				and trim(a.kode)='".trim($kode)."'	
	 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!=''"); 
	   			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {						 
						$total_semua=$total_semua+$data->total_semua;	 
				}
			}
		/*} */ 
 		if($field=="total_all"){
			if($total_semua!=""){	
				return $total_semua;
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
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and id_data_renja='".$id_data_renja."' and kode!=''"); 
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
	function get_child_capaian_all($id="",$id_table="",$parent=""){
		$table="";
		$class_xeditable='';
		$tipe_capaian='';
		if($id_table=="1"){
	           $tipe_capaian="kinerja_target";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan_target";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln_target";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp_target";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip_target";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi_target";
		}
		$bg_ikk="";
		$style_header="vertical-align:middle;font-size:10px;font-weight:normal;height:50px;";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,template_renja.tahun_anggaran as tahun_berlaku,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12',
 		
 		(select c_01 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_kinerja_realisasi',
		(select c_02 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_kinerja_realisasi',
		(select c_03 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_kinerja_realisasi',
		(select c_04 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_kinerja_realisasi',
		(select c_05 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_kinerja_realisasi',
		(select c_06 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_kinerja_realisasi',
		(select c_07 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_kinerja_realisasi',
		(select c_08 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_kinerja_realisasi',
		(select c_09 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_kinerja_realisasi',
		(select c_10 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_kinerja_realisasi',
		(select c_11 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_kinerja_realisasi',
		(select c_12 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_kinerja_realisasi',


		(select c_01 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_keuangan',
		(select c_02 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_keuangan',
		(select c_03 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_keuangan',
		(select c_04 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_keuangan',
		(select c_05 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_keuangan',
		(select c_06 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_keuangan',
		(select c_07 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_keuangan',
		(select c_08 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_keuangan',
		(select c_09 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_keuangan',
		(select c_10 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_keuangan',
		(select c_11 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_keuangan',
		(select c_12 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_keuangan',


		(select c_01 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_keuangan_target',
		(select c_02 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_keuangan_target',
		(select c_03 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_keuangan_target',
		(select c_04 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_keuangan_target',
		(select c_05 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_keuangan_target',
		(select c_06 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_keuangan_target',
		(select c_07 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_keuangan_target',
		(select c_08 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_keuangan_target',
		(select c_09 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_keuangan_target',
		(select c_10 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_keuangan_target',
		(select c_11 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_keuangan_target',
		(select c_12 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_keuangan_target'

		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$parent."') and trim(tipe)!='program' order by a.urutan asc");
     			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				  if(strtoupper($data_f->kode)!="OUTPUT"){
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
					$class_xeditable='';
				    if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        	$class_xeditable='text_'.$tipe_capaian.'';
			        }	
 					$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.=";font-weight:bold";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;width:10px;background-color:#2C802C'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center> ".strtoupper($data_f->kode)."  </center></td>";
							$table.="<td colspan='2' style='".$style_header."'> ".(($data_f->indikator))."</td>";
							/*$c_01=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'target');
							$c_02=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'target');
							$c_03=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'target');
							$c_04=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'target');
							$c_05=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'target');
							$c_06=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'target');
							$c_07=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'target');
							$c_08=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'target');
							$c_09=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'target');
							$c_10=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'target');
							$c_11=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'target');
							$c_12=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'target');*/
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
						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;;width:10px;background-color:#31BC86'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center>".strtoupper($data_f->kode)."</center> </td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".(($data_f->komponen_input))."  </td>";
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
			 					if (($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
									$class_xeditable='text_'.$tipe_capaian.'';
								}
								
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
								/* TIDAK DIGUNAKAN KARENA HANYA SAMPAI KOMPONEN INPUT */
								/*
								if ($check_child!="true") {
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
								} else {
									$c_01=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'target');
									$c_02=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'target');
									$c_03=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'target');
									$c_04=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'target');
									$c_05=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'target');
									$c_06=$this->get_total_indikator($id_table,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'target');
									$c_07=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'target');
									$c_08=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'target');
									$c_09=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'target');
									$c_10=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'target');
									$c_11=$this->get_total_indikator($id_table,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'target');
									$c_12=$this->get_total_indikator($id_table,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'target');
								}
								*/
						}	else if($data_f->tipe=="sub_komponen_input"){

								/*$table.="<td></td>";
								$table.="<td></td>";
								$table.="<td style='".$style_header.";vertical-align:middle;'> <center>".strtoupper($data_f->kode)."</center></b></td>";
								$table.="<td style='".$style_header.";vertical-align:middle;'> ".(($data_f->komponen_input))." </td>";
								$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
			 					if (($check_child!="true") and ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
										$class_xeditable='text_'.$tipe_capaian.'';
								}
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
								$c_12=$data_f->c_12;*/
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
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
 							} else {
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								
							}
 					 
				 			$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
									
							$target= $data_f->target ? $data_f->target : " - ";
							$table.="<td style='".$style_header."'> ".(($data_f->sasaran_kegiatan))." </td>";
				 			$table.="<td style='".$style_header."'><center>".$target ."</center></td>"; 	
				 			$table.="<td style='".$style_header."'><center>".number_format($total_pagu)."</center></td>"; 

							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
 					 		
 					 		$rp_triwulan_1=($c_01+$c_02+$c_03);
				        	$rp_triwulan_2=($c_04+$c_05+$c_06);
				        	$rp_triwulan_3=($c_07+$c_08+$c_09);
				        	$rp_triwulan_4=($c_10+$c_11+$c_12);
							
							$pembagi=1;
							$kali_seratus=1;
				        	if($id_table=="1"){
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  				       


							$table_append="";
					       // 
				        	
				        	/*$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='".$tipe_capaian."' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0)'>
				        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
				        	$table_append.="</td>";*/

				        	
				        	//$target_keuangan = $data_f->target_keuangan ? number_format($data_f->target_keuangan)  : "-";
				        	$target_keuangan=
				        	$data_f->c_01_keuangan_target+
				        	$data_f->c_02_keuangan_target+
				        	$data_f->c_03_keuangan_target+
				        	$data_f->c_04_keuangan_target+
				        	$data_f->c_05_keuangan_target+
				        	$data_f->c_06_keuangan_target+
				        	$data_f->c_07_keuangan_target+
				        	$data_f->c_08_keuangan_target+
				        	$data_f->c_09_keuangan_target+
				        	$data_f->c_10_keuangan_target+
				        	$data_f->c_11_keuangan_target+
				        	$data_f->c_12_keuangan_target;

				        	//$target_keuangan2= $data_f->target_keuangan ?  ($data_f->target_keuangan)  : "1";
				        	$target_keuangan2= $target_keuangan;

				        	$total_kesamping_keuangan=0;
				        	$total_kesamping_kinerja=0;


				        	$c_01_keuangan=$data_f->c_01_keuangan;
							$c_02_keuangan=$data_f->c_02_keuangan;
							$c_03_keuangan=$data_f->c_03_keuangan;
							$c_04_keuangan=$data_f->c_04_keuangan;
							$c_05_keuangan=$data_f->c_05_keuangan;
							$c_06_keuangan=$data_f->c_06_keuangan;
							$c_07_keuangan=$data_f->c_07_keuangan;
							$c_08_keuangan=$data_f->c_08_keuangan;
							$c_09_keuangan=$data_f->c_09_keuangan;
							$c_10_keuangan=$data_f->c_10_keuangan;
							$c_11_keuangan=$data_f->c_11_keuangan;
							$c_12_keuangan=$data_f->c_12_keuangan;

							$c_01_target_kinerja=$data_f->c_01;
							$c_02_target_kinerja=$data_f->c_02;
							$c_03_target_kinerja=$data_f->c_03;
							$c_04_target_kinerja=$data_f->c_04;
							$c_05_target_kinerja=$data_f->c_05;
							$c_06_target_kinerja=$data_f->c_06;
							$c_07_target_kinerja=$data_f->c_07;
							$c_08_target_kinerja=$data_f->c_08;
							$c_09_target_kinerja=$data_f->c_09;
							$c_10_target_kinerja=$data_f->c_10;
							$c_11_target_kinerja=$data_f->c_11;
							$c_12_target_kinerja=$data_f->c_12;

							//$target_kinerja = $data_f->target_kinerja ? $data_f->target_kinerja . " <b>%</b> " : "-";
				        	//$target_kinerja2 = $data_f->target_kinerja ? $data_f->target_kinerja   : "1";

							$target_kinerja = $c_01_target_kinerja+
							$c_02_target_kinerja+
							$c_03_target_kinerja+
							$c_04_target_kinerja+
							$c_05_target_kinerja+
							$c_06_target_kinerja+
							$c_07_target_kinerja+
							$c_08_target_kinerja+
							$c_09_target_kinerja+
							$c_10_target_kinerja+
							$c_11_target_kinerja+
							$c_12_target_kinerja;
				        	$target_kinerja2 = $target_kinerja ? $target_kinerja   : "1";

							$c_01_kinerja_realisasi=$data_f->c_01_kinerja_realisasi;
							$c_02_kinerja_realisasi=$data_f->c_02_kinerja_realisasi;
							$c_03_kinerja_realisasi=$data_f->c_03_kinerja_realisasi;
							$c_04_kinerja_realisasi=$data_f->c_04_kinerja_realisasi;
							$c_05_kinerja_realisasi=$data_f->c_05_kinerja_realisasi;
							$c_06_kinerja_realisasi=$data_f->c_06_kinerja_realisasi;
							$c_07_kinerja_realisasi=$data_f->c_07_kinerja_realisasi;
							$c_08_kinerja_realisasi=$data_f->c_08_kinerja_realisasi;
							$c_09_kinerja_realisasi=$data_f->c_09_kinerja_realisasi;
							$c_10_kinerja_realisasi=$data_f->c_10_kinerja_realisasi;
							$c_11_kinerja_realisasi=$data_f->c_11_kinerja_realisasi;
							$c_12_kinerja_realisasi=$data_f->c_12_kinerja_realisasi;

							$total_kesamping_keuangan=$c_01_keuangan+
							$c_02_keuangan+
							$c_03_keuangan+
							$c_04_keuangan+
							$c_05_keuangan+
							$c_06_keuangan+
							$c_07_keuangan+
							$c_08_keuangan+
							$c_09_keuangan+
							$c_10_keuangan+
							$c_11_keuangan+
							$c_12_keuangan;

							$total_kesamping_kinerja=$c_01_kinerja_realisasi+
							$c_02_kinerja_realisasi+
							$c_03_kinerja_realisasi+
							$c_04_kinerja_realisasi+
							$c_05_kinerja_realisasi+
							$c_06_kinerja_realisasi+
							$c_07_kinerja_realisasi+
							$c_08_kinerja_realisasi+
							$c_09_kinerja_realisasi+
							$c_10_kinerja_realisasi+
							$c_11_kinerja_realisasi+
							$c_12_kinerja_realisasi;

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0)'>
				        	<center>".strtoupper(trim(number_format($target_keuangan)))."</center></a>";
				        	$table_append.="</td>";

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru'>
				        	<center>".number_format($total_kesamping_keuangan)."</center></a>";
				        	$table_append.="</td>";	        	

				        	if (($target_keuangan!="-")){
				        		$progress_keuangan= number_format((($total_kesamping_keuangan / $target_keuangan2 ) * 100),2);
 				        	} else {
				        		$progress_keuangan="0";
				        	}

				        	$bg1="";
				        	$bg2="";

				        	if($target_keuangan2 < $total_kesamping_keuangan){
				        		$bg1="background:#31BC86";
				        	} else if($target_keuangan2 > $total_kesamping_keuangan){
				        		$bg1="background:#B50000";
				        	}  

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru'>
				        	<center class='badge' style='".$bg1."'>".($progress_keuangan)." <b>%</b> </center></a>";
				        	$table_append.="</td>";


				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='".$class_xeditable."_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='".$tipe_capaian."' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0)'>
				        	<center >".$target_kinerja."</center></a>";
				        	$table_append.="</td>";

				        	

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0)'>
				        	<center>".$total_kesamping_kinerja." <b> % </b></center></a>";
				        	$table_append.="</td>";
 							

				        	//$progress_kinerja=($total_kesamping_kinerja/$target_kinerja2) * 100;
 							
 

 							if (($target_kinerja!="-")){
				        		$progress_kinerja=number_format((($total_kesamping_kinerja / $target_kinerja2 ) * 100),2);
				        	} else {
				        		$progress_kinerja="0";
				        	}

 							if($target_kinerja2 > $total_kesamping_kinerja){
				        		$bg2="background:#B50000";
				        	} else if($target_kinerja2 < $total_kesamping_kinerja){
				        		$bg2="background:#31BC86";
				        	} 

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0)'>
				        	<center class='badge' style='".$bg2."'>".($progress_kinerja)." <b> % </b></center></a>";
				        	$table_append.="</td>";
				        	 


					        if (($check_child=="true") and ($id_table=="1")){
					        	 $table.=$table_append;
					        }	else {
					        	 $table.=$table_append;
					        }
					        $table.="</tr>";
						}	

						
				        	if ($this->cek_child_anak($id,$data_f->parent)) {
								$table.=$this->get_child_capaian_all($id,$id_table,trim($data_f->kode));
						}
					}	
				} 
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
	function get_capaian_all($id="",$id_table=""){
		$table="";
		$class_xeditable='';
		$tipe_capaian='';
		$bg_ikk="";
		$style=";font-size:10px;font-weight:bold;padding:10px";

		if($id_table=="1"){
	           $tipe_capaian="kinerja_target";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan_target";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln_target";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp_target";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip_target";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi_target";
		}
		$query=$this->db->query("select *,template_renja.tahun_anggaran as tahun_anggaran,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12'
		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc");
 
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
					get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_bo2=$total_bo2+$this->
					get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_pusat=$total_rm_pusat+$this->
					get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_daerah=$total_rm_daerah+$this->
					get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_pusat=$total_phln_pusat+$this->
					get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_daerah=$total_phln_daerah+$this->
					get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_pnbp=$total_pnbp+$this->
					get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					
					 
					$total_all_pagu=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
				 

					$table.="<tr>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->kode_direktorat."</td>";
					$table.="<td style='".$style.";vertical-align:middle;' colspan='3'>".strtoupper($data_f->program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".strtoupper($data_f->sasaran_program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->target."</td>"; 
					$table.="<td style='".$style.";vertical-align:middle;'>".number_format($total_all_pagu)."</td>"; 

				        $class_xeditable='';
				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='text_'.$tipe_capaian.'';
			        	}	
						/*$c_01=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,'target',$id);
						$c_02=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,'target',$id);
						$c_03=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,'target',$id);
						$c_04=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,'target',$id);
						$c_05=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,'target',$id);
						$c_06=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,'target',$id);
						$c_07=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,'target',$id);
						$c_08=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,'target',$id);
						$c_09=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,'target',$id);
						$c_10=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,'target',$id);
						$c_11=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,'target',$id);
						$c_12=$this->get_total_header_capaian_target($id_table,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,'target',$id);*/
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
				        	if($id_table=="1"){
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  		

				        	/*$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='".$tipe_capaian."' 
				        	data-title='Masukan Nilai Baru' 
				        	onclick='return save_bulan(1,0)'><center>".strtoupper(trim(number_format($c_01)))."</center></a>";
				        	$table.="</td>";*/

				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center>  </center></a>";
				        	$table.="</td>";
				        	
							$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center> - </center></a>";
				        	$table.="</td>";
				        	
				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center> - </center></a>";
				        	$table.="</td>";
				        	
				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center> - </center></a>";
				        	$table.="</td>";
				        	
				        	$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center>-</center></a>";
				        	$table.="</td>";
 							
 							$table.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table.="<a style='text-decoration:none'><center> - </center></a>";
				        	$table.="</td>";
				        
				        
				       
				        $table.="</tr>";
			        	if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_capaian_all($id,$id_table,$data_f->parent);
						}  	 
			    } 
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	function get_capaian_target($id="",$id_table="",$komparasi=""){
		$table="";
		$class_xeditable='';
		$tipe_capaian='';
		$this_month="";
		$id_table="1";
		if($komparasi==""){
			$komparasi=$this->input->post('komparasi');
		}
 		$style=";font-size:10px;font-weight:bold;padding:10px";
		if($id_table=="1"){
	           $tipe_capaian="kinerja_target";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan_target";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln_target";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp_target";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip_target";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi_target";
		}
 		$query=$this->db->query("select *,template_renja.tahun_anggaran as tahun_anggaran,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12'
		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc"); 
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
					$total_pagu=0;
					$total_bo1=0;
					$total_bo2=0;
					$total_rm_pusat=0;
					$total_rm_daerah=0;
					$total_phln_pusat=0;
					$total_phln_daerah=0;
					$total_pnbp=0;
					$total_all_pagu=0;
					
					$total_pagu=0;
					$total_bo1=0;
					$total_bo2=0;
					$total_rm_pusat=0;
					$total_rm_daerah=0;
					$total_phln_pusat=0;
					$total_phln_daerah=0;
					$total_pnbp=0;
					$total_all_pagu=0;
					$total_all=0;
					$total_bo1=$total_bo1+$this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_bo2=$total_bo2+$this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_pusat=$total_rm_pusat+$this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_daerah=$total_rm_daerah+$this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_pusat=$total_phln_pusat+$this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_daerah=$total_phln_daerah+$this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_pnbp=$total_pnbp+$this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_all=$total_all+$this->get_total_program_from_target('total_all',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id_table,$id);
 					
 					if($komparasi!="1"){
 						$total_all_pagu=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
					} else {
						$total_all_pagu=$total_all;
					}
					$target_kinerja= $data_f->target_kinerja ."<b> % </b>" ? $data_f->target_kinerja : " - ";
					$target_keuangan= $data_f->target_keuangan ? $data_f->target_keuangan : " - ";
					$table.="<tr>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->kode_direktorat."</td>";
					$table.="<td style='".$style.";vertical-align:middle;' colspan='3'>".strtoupper($data_f->program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".strtoupper($data_f->sasaran_program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'><center>".number_format($total_all_pagu)."<center></td>";
   					 	
   					 	/*$c_01=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,'target',$id);
						$c_02=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,'target',$id);
						$c_03=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,'target',$id);
						$c_04=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,'target',$id);
						$c_05=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,'target',$id);
						$c_06=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,'target',$id);
						$c_07=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,'target',$id);
						$c_08=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,'target',$id);
						$c_09=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,'target',$id);
						$c_10=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,'target',$id);
						$c_11=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,'target',$id);
						$c_12=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,'target',$id); */  

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

						$class_xeditable='';
				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='text_'.$tipe_capaian.'';
			        	}	
			        	
			        	$this_month_01="";$this_month_02="";$this_month_03="";$this_month_04="";$this_month_05="";
		 				$this_month_06="";$this_month_07="";$this_month_08="";$this_month_09="";$this_month_10="";
		 				$this_month_11="";$this_month_12="";

		 				$color_01="";$color_02="";$color_03="";$color_04="";$color_05="";
		 				$color_06="";$color_07="";$color_08="";$color_09="";$color_10="";
		 				$color_11="";$color_12="";
	 					

 			        	if(date("m")=="01"){
			        		$this_month_01=" background-color:#C07B6B;color:#fff;";$color_01=";color:#fff;";
			        	} else if(date("m")=="02"){
			        		$this_month_02=" background-color:#C07B6B;color:#fff;";$color_02=";color:#fff;";
			        	}  else if(date("m")=="03"){
			        		$this_month_03=" background-color:#C07B6B;color:#fff;";$color_03=";color:#fff;";
			        	} else if(date("m")=="04"){
			        		$this_month_04=" background-color:#C07B6B;color:#fff;";$color_04=";color:#fff;";
			        	} else if(date("m")=="05"){
			        		$this_month_05=" background-color:#C07B6B;color:#fff;";$color_05=";color:#fff;";
			        	} else if(date("m")=="06"){
			        		$this_month_06=" background-color:#C07B6B;color:#fff;";$color_06=";color:#fff;";
			        	} else if(date("m")=="07"){
			        		$this_month_07=" background-color:#C07B6B;color:#fff;";$color_07=";color:#fff;";
			        	} else if(date("m")=="08"){
			        		$this_month_08=" background-color:#C07B6B;color:#fff;";$color_08=";color:#fff;";
			        	} else if(date("m")=="09"){
			        		$this_month_09=" background-color:#C07B6B;color:#fff;";$color_09=";color:#fff;";
			        	} else if(date("m")=="10"){
			        		$this_month_10=" background-color:#C07B6B;color:#fff;";$color_10=";color:#fff;";
			        	} else if(date("m")=="11"){
			        		$this_month_11=" background-color:#C07B6B;color:#fff;";$color_11=";color:#fff;";
			        	} else if(date("m")=="12"){
			        		$this_month_12=" background-color:#C07B6B;color:#fff;";$color_12=";color:#fff;";
			        	}

			        	 
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
				        	if($id_table=="1"){
								$pembagi=3;
					        } else {
					        	$pembagi=$total_all_pagu;
					        	$kali_seratus=100;
					        }	
				        	
				        	

				        	$rp_triwulan_1=number_format($rp_triwulan_1);
				        	$rp_triwulan_2=number_format($rp_triwulan_2);
				        	$rp_triwulan_3=number_format($rp_triwulan_3);
				        	$rp_triwulan_4=number_format($rp_triwulan_4);

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  		

				        	

		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
	        		$table.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
		        	$table.="</td>";
		        	
		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_1'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_1."</b></center></td>";
		        	$table.="<td class='triwulan_1'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";*/


		        	$table.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
		        	$table.="</td>";



		        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
	       			$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
		        	$table.="</td>";
 
		        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_2."</b></center></td>"; 
		        	$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";*/

		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
	     		   	$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_3."</b></center></td>"; 
		        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";*/

		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,0,0,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
		        	$table.="</td>";
		        	
		        	/*$table.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_4."</b></center></td>"; 
		        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";*/

		        	 
		         	
		        	$percentange=0;
		        	if($id_table!="1"){
			        	if($total_all_pagu!="0"){
			        		$percentange=($total_kesamping/$total_all_pagu)*100;
			        	}
			        } else {
			        	$percentange=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
			        }	
		       	   $table.="<td style='".$style.";vertical-align:middle;'>".number_format($percentange,1)."</td>"; 


		        /* AMBIL CAPAIAN KEUANGAN */
		        $id_table=2;
		        if($id_table=="1"){
		           $tipe_capaian="kinerja";
		        } else  if($id_table=="2"){
		           $tipe_capaian="keuangan";
		        } else  if($id_table=="3"){
		           $tipe_capaian="phln";
		        } else  if($id_table=="4"){
		           $tipe_capaian="dktp";
		        } else  if($id_table=="5"){
		           $tipe_capaian="lakip";
		        } else  if($id_table=="6"){
		           $tipe_capaian="renaksi";
				}

			$c_01=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,'target',$id);
			$c_02=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,'target',$id);
			$c_03=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,'target',$id);
			$c_04=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,'target',$id);
			$c_05=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,'target',$id);
			$c_06=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,'target',$id);
			$c_07=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,'target',$id);
			$c_08=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,'target',$id);
			$c_09=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,'target',$id);
			$c_10=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,'target',$id);
			$c_11=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,'target',$id);
			$c_12=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,'target',$id); 

			$rp_triwulan_1=$c_01+$c_02+$c_03;
	        $rp_triwulan_2=$c_04+$c_05+$c_06;
	        $rp_triwulan_3=$c_07+$c_08+$c_09;
	        $rp_triwulan_4=$c_10+$c_11+$c_12;
	        if($pembagi!="0"){  	 
				            	$persen_triwulan_1=(($rp_triwulan_1) / $total_all_pagu) * 100;
						        $persen_triwulan_2=(($rp_triwulan_2) / $total_all_pagu) * 100;
						        $persen_triwulan_3=(($rp_triwulan_3) / $total_all_pagu) * 100;
						        $persen_triwulan_4=(($rp_triwulan_4) / $total_all_pagu) * 100;
					        }

        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
    		$table.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0,0,".$data_f->id.",1)'>
	        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
        	$table.="</td>";
        	
        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_1,1)."</b></center></td>";
        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";


        	$table.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
        	$table.="</td>";



        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
   			$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_2,1)."</b></center></td>";
        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";

        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
 		   	$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_3,1)."</b></center></td>";
        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";

        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,0,0,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
        	$table.="</td>";
        	
        	$table.="<td class='triwulan_4 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_4,1)."</b></center></td>";
        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";

        	$total_kesamping=0;
			if($id_table=="1"){
				//$total_kesamping=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
				//$total_kesamping="-";
			} else {
				$total_kesamping=$c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12;
				$total_kesamping=($total_kesamping);
			}

		 	if($id_table!="1"){
					$table.="<td class='' style='vertical-align:middle;font-size:10px;'>";
		        $table.="<center><b>".strtoupper(trim(number_format($total_kesamping)))."</b></center>";
		        $table.="</td>";
		    } else {
		    	$table.="<td  class='' style='vertical-align:middle;font-size:10px;'>";
		        $table.="<center>-</center>";
		        $table.="</td>";
		    }   
         	
        	$percentange=0;
        	if($id_table!="1"){
	        	if($total_all_pagu!="0"){
	        		$percentange=($total_kesamping/$total_all_pagu)*100;
	        	}
	        } else {
	        	$percentange=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
	        }	
       	 $table.="<td  class='' style='".$style.";vertical-align:middle;'><center>".number_format($percentange,1)." % </center>  </td>"; 
	        $table.="</tr>";	        	
	        	if ($this->cek_child($id,$data_f->parent)) {
					$table.=$this->get_child_capaian_target($id,$id_table,$data_f->parent,$komparasi);
					}  		 			        	
			 	} 
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
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

 	function get_child_capaian_target($id="",$id_table="",$parent="",$komparasi=""){
 		$table="";
		if($komparasi==""){
			$komparasi=$this->input->post('komparasi');
		}
		$class_xeditable='';
		$tipe_capaian='';
		$id_table="1";
		if($id_table=="1"){
	           $tipe_capaian="kinerja_target";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan_target";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln_target";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp_target";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip_target";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi_target";
		}
		$total_kesamping=0;
		$this_month="";
		$style_header="vertical-align:middle;font-size:10px;height:50px";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,template_renja.tahun_anggaran as tahun_berlaku,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12',

		(select c_01 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_keuangan',
		(select c_02 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_keuangan',
		(select c_03 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_keuangan',
		(select c_04 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_keuangan',
		(select c_05 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_keuangan',
		(select c_06 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_keuangan',
		(select c_07 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_keuangan',
		(select c_08 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_keuangan',
		(select c_09 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_keuangan',
		(select c_10 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_keuangan',
		(select c_11 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_keuangan',
		(select c_12 from capaian_keuangan_target where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_keuangan'


		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$parent."') and trim(tipe)!='program' order by a.urutan asc");

    			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				   if(strtoupper($data_f->kode)!="OUTPUT"){	
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

						$c_01_keuangan=0;
						$c_02_keuangan=0;
						$c_03_keuangan=0;
						$c_04_keuangan=0;
						$c_05_keuangan=0;
						$c_06_keuangan=0;
						$c_07_keuangan=0;
						$c_08_keuangan=0;
						$c_09_keuangan=0;
						$c_10_keuangan=0;
						$c_11_keuangan=0;
						$c_12_keuangan=0;	
						$class_xeditable_keuangan='';
						$class_xeditable='';
				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='text_kinerja_target';
			        	}	
	 					$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.=";font-weight:bold";
							$table.="<td  style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;width:10px;background-color:#2C802C'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".strtoupper($data_f->kode)." </td>";
							$table.="<td colspan='2' style='".$style_header."'> ".(($data_f->indikator))."</td>";
							/*$c_01=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'realisasi');
							$c_02=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'realisasi');
							$c_03=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'realisasi');
							$c_04=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'realisasi');
							$c_05=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'realisasi');
							$c_06=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'realisasi');
							$c_07=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'realisasi');
							$c_08=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'realisasi');
							$c_09=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'realisasi');
							$c_10=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'realisasi');
							$c_11=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'realisasi');
							$c_12=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'realisasi');*/
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

							$c_01_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'target');
							$c_02_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'target');
							$c_03_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'target');
							$c_04_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'target');
							$c_05_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'target');
							$c_06_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'target');
							$c_07_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'target');
							$c_08_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'target');
							$c_09_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'target');
							$c_10_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'target');
							$c_11_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'target');
							$c_12_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'target');
 						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";
							$table.="<td  style='".$style_header.";vertical-align:middle;'><center>
							<div style='height:10px;;width:10px;background-color:#31BC86'></div></center></td>";
							$table.="<td style='".$style_header."'> ".strtoupper($data_f->kode)." </td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".(($data_f->komponen_input))." </td>";
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

							$c_01_keuangan=$data_f->c_01_keuangan;
							$c_02_keuangan=$data_f->c_02_keuangan;
							$c_03_keuangan=$data_f->c_03_keuangan;
							$c_04_keuangan=$data_f->c_04_keuangan;
							$c_05_keuangan=$data_f->c_05_keuangan;
							$c_06_keuangan=$data_f->c_06_keuangan;
							$c_07_keuangan=$data_f->c_07_keuangan;
							$c_08_keuangan=$data_f->c_08_keuangan;
							$c_09_keuangan=$data_f->c_09_keuangan;
							$c_10_keuangan=$data_f->c_10_keuangan;
							$c_11_keuangan=$data_f->c_11_keuangan;
							$c_12_keuangan=$data_f->c_12_keuangan;
							if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        			$class_xeditable_keuangan="text_keuangan_target";
			        		}	
						}	else if($data_f->tipe=="sub_komponen_input"){
							  
						}	

						/* KALO TIDAK SAMA DENGAN SUB KOMPONEN INPUT */
					
							$total_pagu=0;
							$bo01=0;
							$bo02=0;
							$bno_phln_p=0;
							$bno_phln_d=0;
							$bno_rm_p=0;
							$bno_rm_d=0;
							$pnbp=0;
							 
					 		$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id); 

 					 
				 			$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
							$total_all=0;
							$total_all=$total_all+$this->get_total_indikator_from_target('total_all',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$id_table);
							if($komparasi!="1"){
								$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
							} else {
								$total_pagu=$total_all;
							}

							$target_kinerja=$data_f->target_kinerja ? $data_f->target_kinerja." <b> % </b>" : "-" ;
							$target_keuangan=$data_f->target_keuangan ? number_format($data_f->target_keuangan) : "-" ;
							$target_keuangan2=$data_f->target_keuangan ? ($data_f->target_keuangan) : "" ;
							//$total_pagu=$data_f->target_keuangan;

							$table.="<td style='".$style_header."'> ".(($data_f->sasaran_kegiatan))." </td>";
    							$table.="<td style='".$style_header."'> ".(number_format($total_pagu))." </td>";
 	
		 				$this_month_01="";$this_month_02="";$this_month_03="";$this_month_04="";$this_month_05="";
		 				$this_month_06="";$this_month_07="";$this_month_08="";$this_month_09="";$this_month_10="";
		 				$this_month_11="";$this_month_12="";

		 				$color_01="";$color_02="";$color_03="";$color_04="";$color_05="";
		 				$color_06="";$color_07="";$color_08="";$color_09="";$color_10="";
		 				$color_11="";$color_12="";
	 					

 			        	if(date("m")=="01"){
			        		$this_month_01=" background-color:#C07B6B;color:#fff;";$color_01=";color:#fff;";
			        	} else if(date("m")=="02"){
			        		$this_month_02=" background-color:#C07B6B;color:#fff;";$color_02=";color:#fff;";
			        	}  else if(date("m")=="03"){
			        		$this_month_03=" background-color:#C07B6B;color:#fff;";$color_03=";color:#fff;";
			        	} else if(date("m")=="04"){
			        		$this_month_04=" background-color:#C07B6B;color:#fff;";$color_04=";color:#fff;";
			        	} else if(date("m")=="05"){
			        		$this_month_05=" background-color:#C07B6B;color:#fff;";$color_05=";color:#fff;";
			        	} else if(date("m")=="06"){
			        		$this_month_06=" background-color:#C07B6B;color:#fff;";$color_06=";color:#fff;";
			        	} else if(date("m")=="07"){
			        		$this_month_07=" background-color:#C07B6B;color:#fff;";$color_07=";color:#fff;";
			        	} else if(date("m")=="08"){
			        		$this_month_08=" background-color:#C07B6B;color:#fff;";$color_08=";color:#fff;";
			        	} else if(date("m")=="09"){
			        		$this_month_09=" background-color:#C07B6B;color:#fff;";$color_09=";color:#fff;";
			        	} else if(date("m")=="10"){
			        		$this_month_10=" background-color:#C07B6B;color:#fff;";$color_10=";color:#fff;";
			        	} else if(date("m")=="11"){
			        		$this_month_11=" background-color:#C07B6B;color:#fff;";$color_11=";color:#fff;";
			        	} else if(date("m")=="12"){
			        		$this_month_12=" background-color:#C07B6B;color:#fff;";$color_12=";color:#fff;";
			        	}

			        	$rp_triwulan_1=($c_01+$c_02+$c_03);
				        $rp_triwulan_2=($c_04+$c_05+$c_06);
				        $rp_triwulan_3=($c_07+$c_08+$c_09);
				        $rp_triwulan_4=($c_10+$c_11+$c_12);
						$rp_total_kesamping=$rp_triwulan_1+$rp_triwulan_2+$rp_triwulan_3+$rp_triwulan_4;

						if($total_pagu=="0"){ $total_pagu=1; }
							$pembagi=1;
							$kali_seratus=1;
				        	if($id_table=="1"){
								$pembagi=3;
					        } else {
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  				       

			        	$table_append="";
			        	 
			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
			        	$table_append.="</td>";
			        	
			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_02."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_03."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_1."</center></td>"; 
				        $table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";*/

			        	$table_append.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_04."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_05."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_06."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_2."</center></td>";
				        $table_append.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";*/


			        	$table_append.="<td class='triwulan_3 '  style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_07."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_08."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_09."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_3."</center></td>"; 
				        $table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";*/

			        	$table_append.="<td  class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_10."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_11."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_12."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,0,0,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
			        	$table_append.="</td>";		

			        	/*$table_append.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_4."</center></td>"; 
				        $table_append.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";	    */    	
			        	$total_kesamping=0;

						 

				        	$percentange=0;
				        	/*if($id_table!="1"){
					        	if($total_kesamping > 0){
						        	$percentange=($total_kesamping / $total_pagu ) * 100;
								}
								if($total_pagu > 0){
						        	$percentange=($total_kesamping / $total_pagu ) * 100;
								}
							} else {
								$percentange=$total_kesamping;
							}	*/
							$percentange=$rp_triwulan_1+
				        	$rp_triwulan_2+
				        	$rp_triwulan_3+
				        	$rp_triwulan_4 ;
				        	$table_append.="<td style='vertical-align:middle;font-size:10px;'>";
				        	$table_append.="<center><b>".strtoupper(trim(number_format($rp_total_kesamping,1)))." </b></center></a>";
				        	$table_append.="</td>";

				        	
				        	
							$tipe_capaian='';
							$id_table="2";
 				        	if($id_table=="1"){
					           $tipe_capaian="kinerja";
					        } else  if($id_table=="2"){
					           $tipe_capaian="keuangan";
					        } else  if($id_table=="3"){
					           $tipe_capaian="phln";
					        } else  if($id_table=="4"){
					           $tipe_capaian="dktp";
					        } else  if($id_table=="5"){
					           $tipe_capaian="lakip";
					        } else  if($id_table=="6"){
					           $tipe_capaian="renaksi";
						}
						
						$total_kesamping=0;
						$this_month="";
							$rp_triwulan_1=($c_01_keuangan+$c_02_keuangan+$c_03_keuangan);
				        	$rp_triwulan_2=($c_04_keuangan+$c_05_keuangan+$c_06_keuangan);
				        	$rp_triwulan_3=($c_07_keuangan+$c_08_keuangan+$c_09_keuangan);
				        	$rp_triwulan_4=($c_10_keuangan+$c_11_keuangan+$c_12_keuangan);
							
							if(($total_pagu=="0") or ($total_pagu=="")){ $total_pagu=1; }
							$pembagi=1;
							$kali_seratus=1;
				        	if($id_table=="1"){
								$pembagi=3;
					        } else {
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	} 
				        $table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_01_keuangan)))."</center></a>";
			        	$table_append.="</td>";
			        	
			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_02."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_02_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_03."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_03_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_1."</center></td>";
				        $table_append.="<td class='triwulan_1 ' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";

			        	$table_append.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_04."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_04_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_05."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_05_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_06."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_06_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_2."</center></td>";
				        $table_append.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";


			        	$table_append.="<td class='triwulan_3 '  style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_07."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_07_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_08."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_08_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_09."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_09_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_3."</center></td>";
				        $table_append.="<td  class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";

			        	$table_append.="<td  class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_10."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_10_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_11."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_11_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_12."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,0,0,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_12_keuangan)))."</center></a>";
			        	$table_append.="</td>";		

			        	$table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_4."</center></td>";
				        $table_append.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";	        	
			        	$total_kesamping=0;

						$table_append.="<td class='' style='vertical-align:middle;font-size:10px;'>";
				        	$total_kesamping=0;
							if($id_table=="1"){
									$total_kesamping=(($c_01_keuangan+$c_02_keuangan+$c_03_keuangan+$c_04_keuangan+$c_05_keuangan+$c_06_keuangan+$c_07_keuangan+$c_08_keuangan+$c_09_keuangan+$c_10_keuangan+$c_11_keuangan+$c_12_keuangan)/12);
									$table_append.="<center>-</a>";
								} else {
									$total_kesamping=$c_01_keuangan+$c_02_keuangan+$c_03_keuangan+$c_04_keuangan+$c_05_keuangan+$c_06_keuangan+$c_07_keuangan+$c_08_keuangan+$c_09_keuangan+$c_10_keuangan+$c_11_keuangan+$c_12_keuangan;
									$table_append.="<center>".strtoupper(trim(number_format($total_kesamping)))."</center></a>";
							}
							$table_append.="</td>";

				        	$percentange=0;
				        	if($id_table!="1"){
					        	if($target_keuangan2 > 0){
						        	$percentange=($total_kesamping / $target_keuangan2 ) * 100;
								}
								if($target_keuangan2 > 0){
						        	$percentange=($total_kesamping / $target_keuangan2 ) * 100;
								}
							} else {
								$percentange=$total_kesamping;
							}	
				        	$table_append.="<td class='' style='vertical-align:middle;font-size:10px;'>";
				        	$table_append.="<center><b>".strtoupper(trim(number_format($percentange,1)))." % </b> </center></a>";
				        	$table_append.="</td>";

							$table.=$table_append;
				        }

				        /* END OF TIDAK SAMA DENGAN SUB KOMPOENEN INPUT */
				        /* AMBIL CAPAIAN KEUANGAN */



				        /*---------------------------------------------*/
				        if ($this->cek_child_anak($id,$data_f->parent)) {
				        	$id_table="1";
							$table.=$this->get_child_capaian_target($id,$id_table,trim($data_f->kode),$komparasi);
						}

					}	

				} 
			}  
			return $table;
 	}
	function get_child_realisasi_capaian($id="",$id_table="",$parent="",$komparasi=""){
		$table="";
		if($komparasi==""){
			$komparasi=$this->input->post('komparasi');
		}
		$class_xeditable='';
		$tipe_capaian='';
		$id_table="1";
		if($id_table=="1"){
	           $tipe_capaian="kinerja";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi";
		}
		$total_kesamping=0;
		$this_month="";
		$style_header="vertical-align:middle;font-size:10px;height:50px";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,template_renja.tahun_anggaran as tahun_berlaku,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12',

		(select c_01 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_keuangan',
		(select c_02 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_keuangan',
		(select c_03 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_keuangan',
		(select c_04 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_keuangan',
		(select c_05 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_keuangan',
		(select c_06 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_keuangan',
		(select c_07 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_keuangan',
		(select c_08 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_keuangan',
		(select c_09 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_keuangan',
		(select c_10 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_keuangan',
		(select c_11 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_keuangan',
		(select c_12 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_keuangan',

		(select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_keuangan_target where trim(kode_direktorat_child)=a.kode_direktorat_child
			and    kode=a.kode and trim(parent)=a.parent and tahun=template_renja.tahun_anggaran
		) as target_keuangan_dari_table ,

		(select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_kinerja_target where trim(kode_direktorat_child)=a.kode_direktorat_child
			and    kode=a.kode and trim(parent)=a.parent and tahun=template_renja.tahun_anggaran
		) as target_kinerja_dari_table

		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and trim(parent)=trim('".$parent."') and trim(tipe)!='program' order by a.urutan asc");
      			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
				   if(strtoupper($data_f->kode)!="OUTPUT"){	
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

						$c_01_keuangan=0;
						$c_02_keuangan=0;
						$c_03_keuangan=0;
						$c_04_keuangan=0;
						$c_05_keuangan=0;
						$c_06_keuangan=0;
						$c_07_keuangan=0;
						$c_08_keuangan=0;
						$c_09_keuangan=0;
						$c_10_keuangan=0;
						$c_11_keuangan=0;
						$c_12_keuangan=0;	
						$class_xeditable_keuangan='';
						$class_xeditable='';
						$table_capaian_appen_keuangan='';
						$sum_target_indikator=0;
				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='text_'.$tipe_capaian.'';
			        	}	
			        	$pembagi_keuangan=1;
	 					$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.=";font-weight:bold;";
							$table.="<td  style='".$style_header.";vertical-align:middle;' >
							<center><div style='height:10px;width:10px;background-color:#2C802C'>
							</div><br> </center>
							</td>";
							$style_header="vertical-align:middle;font-size:10px;height:50px";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".strtoupper($data_f->kode)." </td>";
							$table.="<td colspan='2' style='".$style_header."'> ".(($data_f->indikator))."</td>";
							/*$c_01=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'realisasi');
							$c_02=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'realisasi');
							$c_03=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'realisasi');
							$c_04=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'realisasi');
							$c_05=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'realisasi');
							$c_06=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'realisasi');
							$c_07=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'realisasi');
							$c_08=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'realisasi');
							$c_09=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'realisasi');
							$c_10=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'realisasi');
							$c_11=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'realisasi');
							$c_12=$this->get_total_indikator_capaian($id_table,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'realisasi');*/
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

							$c_01_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'realisasi');
							$c_02_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'realisasi');
							$c_03_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'realisasi');
							$c_04_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'realisasi');
							$c_05_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'realisasi');
							$c_06_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'realisasi');
							$c_07_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'realisasi');
							$c_08_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'realisasi');
							$c_09_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'realisasi');
							$c_10_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'realisasi');
							$c_11_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'realisasi');
							$c_12_keuangan=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'realisasi'); 

							$c_01_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'01',$data_f->tahun_berlaku,'target');
							$c_02_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'02',$data_f->tahun_berlaku,'target');
							$c_03_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'03',$data_f->tahun_berlaku,'target');
							$c_04_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'04',$data_f->tahun_berlaku,'target');
							$c_05_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'05',$data_f->tahun_berlaku,'target');
							$c_06_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'06',$data_f->tahun_berlaku,'target');
							$c_07_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'07',$data_f->tahun_berlaku,'target');
							$c_08_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'08',$data_f->tahun_berlaku,'target');
							$c_09_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'09',$data_f->tahun_berlaku,'target');
							$c_10_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'10',$data_f->tahun_berlaku,'target');
							$c_11_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'11',$data_f->tahun_berlaku,'target');
							$c_12_keuangan_target=$this->get_total_indikator_capaian(2,$data_f->kode_direktorat_child,$data_f->kode,'12',$data_f->tahun_berlaku,'target');
							$sum_target_indikator=$c_01_keuangan_target+
							$c_02_keuangan_target+
							$c_03_keuangan_target+
							$c_04_keuangan_target+
							$c_05_keuangan_target+
							$c_06_keuangan_target+
							$c_07_keuangan_target+
							$c_08_keuangan_target+
							$c_10_keuangan_target+
							$c_12_keuangan_target;
							$table_capaian_appen_keuangan="<td style='".$style_header.";vertical-align:middle;'><b><center>".number_format($sum_target_indikator)."</center></b></td>";

							$pembagi_keuangan=$sum_target_indikator;
							$target_keuangan2=$pembagi_keuangan;
 						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";


							$table.="<td  style='".$style_header.";vertical-align:middle'><center>
							<div style='height:10px;;width:10px;background-color:#31BC86'></div><br>";
							
			        			$table.="<i class='glyphicon glyphicon-chevron-down' style='color:#000;cursor:pointer' onclick='return get_detail_dokumen(".$data_f->id.")' style='cursor:pointer'></i>";
							 
							$table.="</center></td>";
 							$style_header="width:40px !important;vertical-align:middle;font-size:10px;height:50px; ";
							$table.="<td style='".$style_header."'> ".strtoupper($data_f->kode)." </td>";
							
							$style_header.=';width:170px !important;';

							$table.="<td style='".$style_header.";vertical-align:middle;'> ".(($data_f->komponen_input))." </td>";
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

							$c_01_keuangan=$data_f->c_01_keuangan;
							$c_02_keuangan=$data_f->c_02_keuangan;
							$c_03_keuangan=$data_f->c_03_keuangan;
							$c_04_keuangan=$data_f->c_04_keuangan;
							$c_05_keuangan=$data_f->c_05_keuangan;
							$c_06_keuangan=$data_f->c_06_keuangan;
							$c_07_keuangan=$data_f->c_07_keuangan;
							$c_08_keuangan=$data_f->c_08_keuangan;
							$c_09_keuangan=$data_f->c_09_keuangan;
							$c_10_keuangan=$data_f->c_10_keuangan;
							$c_11_keuangan=$data_f->c_11_keuangan;
							$c_12_keuangan=$data_f->c_12_keuangan;

							$sum_target_indikator=0;
							$sum_target_indikator=$c_01_keuangan+
							$c_02_keuangan+
							$c_03_keuangan+
							$c_04_keuangan+
							$c_05_keuangan+
							$c_06_keuangan+
							$c_07_keuangan+
							$c_08_keuangan+
							$c_10_keuangan+
							$c_12_keuangan;
							$pembagi_keuangan=$data_f->target_keuangan_dari_table;
							$target_keuangan2=$pembagi_keuangan;

							$table_capaian_appen_keuangan="<td style='".$style_header.";vertical-align:middle;width:70px !important;'><b><center>".number_format($data_f->target_keuangan_dari_table)."</center></b></td>";
							if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        			$class_xeditable_keuangan="text_keuangan";
			        		}	
						}	else if($data_f->tipe=="sub_komponen_input"){
							 $table_capaian_appen_keuangan=""; 
						}	

						/* KALO TIDAK SAMA DENGAN SUB KOMPONEN INPUT */
					
							$total_pagu=0;
							$bo01=0;
							$bo02=0;
							$bno_phln_p=0;
							$bno_phln_d=0;
							$bno_rm_p=0;
							$bno_rm_d=0;
							$pnbp=0;
							 
					 		$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
							$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id); 

 					 
				 			$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
							$total_all=0;
							$total_all=$total_all+$this->get_total_indikator_from_target('total_all',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun_anggaran,$id_table);
							if($komparasi!="1"){
								$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
							} else {
								$total_pagu=$total_all;
							}

							$target_kinerja=$data_f->target_kinerja_dari_table ? $data_f->target_kinerja_dari_table." <b> % </b>" : "-" ;
							$target_kinerja2=$data_f->target_kinerja_dari_table ? $data_f->target_kinerja_dari_table : "" ;
							//$target_keuangan=$data_f->target_keuangan ? number_format($data_f->target_keuangan) : "-" ;
							//$target_keuangan2=$data_f->target_keuangan ? ($data_f->target_keuangan) : "" ;
							//$total_pagu=$data_f->target_keuangan;

							$table.="<td style='".$style_header."'> ".(($data_f->sasaran_kegiatan))." </td>";
							$style_header="vertical-align:middle;font-size:10px;height:50px;width:70px !important;";
 				 			$table.="<td style='".$style_header."'><center>".number_format($total_pagu)."</center></td>"; 
							//$table.="<td style='".$style_header.";vertical-align:middle;'><b>".($target_keuangan)."</b></td>"; 
							
							$table.=$table_capaian_appen_keuangan; 


							$target_keuangan=$data_f->target_keuangan_dari_table;
							$style_header="vertical-align:middle;font-size:10px;height:50px;width:70px !important;";
							$table.="<td style='".$style_header.";vertical-align:middle;'><b><center>".$target_kinerja."</center></b></td>"; 

 	
		 				$this_month_01="";$this_month_02="";$this_month_03="";$this_month_04="";$this_month_05="";
		 				$this_month_06="";$this_month_07="";$this_month_08="";$this_month_09="";$this_month_10="";
		 				$this_month_11="";$this_month_12="";

		 				$color_01="";$color_02="";$color_03="";$color_04="";$color_05="";
		 				$color_06="";$color_07="";$color_08="";$color_09="";$color_10="";
		 				$color_11="";$color_12="";
	 					

 			        	if(date("m")=="01"){
			        		$this_month_01=" background-color:#C07B6B;color:#fff;";$color_01=";color:#fff;";
			        	} else if(date("m")=="02"){
			        		$this_month_02=" background-color:#C07B6B;color:#fff;";$color_02=";color:#fff;";
			        	}  else if(date("m")=="03"){
			        		$this_month_03=" background-color:#C07B6B;color:#fff;";$color_03=";color:#fff;";
			        	} else if(date("m")=="04"){
			        		$this_month_04=" background-color:#C07B6B;color:#fff;";$color_04=";color:#fff;";
			        	} else if(date("m")=="05"){
			        		$this_month_05=" background-color:#C07B6B;color:#fff;";$color_05=";color:#fff;";
			        	} else if(date("m")=="06"){
			        		$this_month_06=" background-color:#C07B6B;color:#fff;";$color_06=";color:#fff;";
			        	} else if(date("m")=="07"){
			        		$this_month_07=" background-color:#C07B6B;color:#fff;";$color_07=";color:#fff;";
			        	} else if(date("m")=="08"){
			        		$this_month_08=" background-color:#C07B6B;color:#fff;";$color_08=";color:#fff;";
			        	} else if(date("m")=="09"){
			        		$this_month_09=" background-color:#C07B6B;color:#fff;";$color_09=";color:#fff;";
			        	} else if(date("m")=="10"){
			        		$this_month_10=" background-color:#C07B6B;color:#fff;";$color_10=";color:#fff;";
			        	} else if(date("m")=="11"){
			        		$this_month_11=" background-color:#C07B6B;color:#fff;";$color_11=";color:#fff;";
			        	} else if(date("m")=="12"){
			        		$this_month_12=" background-color:#C07B6B;color:#fff;";$color_12=";color:#fff;";
			        	}

			        	$rp_triwulan_1=($c_01+$c_02+$c_03);
				        $rp_triwulan_2=($c_04+$c_05+$c_06);
				        $rp_triwulan_3=($c_07+$c_08+$c_09);
				        $rp_triwulan_4=($c_10+$c_11+$c_12);
						$rp_total_kesamping=$rp_triwulan_1+$rp_triwulan_2+$rp_triwulan_3+$rp_triwulan_4;

						 
 							$kali_seratus=1;		        	 
				        	$pembagi=3;
				        	$persen_triwulan_1=(($rp_triwulan_1) / $pembagi) * $kali_seratus;
					        $persen_triwulan_2=(($rp_triwulan_2) / $pembagi) * $kali_seratus;
					        $persen_triwulan_3=(($rp_triwulan_3) / $pembagi) * $kali_seratus;
					        $persen_triwulan_4=(($rp_triwulan_4) / $pembagi) * $kali_seratus;

				        	$rp_triwulan_1=number_format($rp_triwulan_1);
				        	$rp_triwulan_2=number_format($rp_triwulan_2);
				        	$rp_triwulan_3=number_format($rp_triwulan_3);
				        	$rp_triwulan_4=number_format($rp_triwulan_4);

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  				       

			        	$table_append="";
			        	if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        			//$class_xeditable='text_'.$tipe_capaian.'';
			        			$class_xeditable="text_kinerja";
			        	}	

			        	$table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_01."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
			        	$table_append.="</td>";
			        	
			        	$table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_02."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_02."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_03."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_03."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_1."</center></td>"; 
				        $table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";*/

			        	$table_append.="<td class='triwulan_2 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_04."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_04."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_2 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_05."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_05."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_06."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_06."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_2."</center></td>";
				        $table_append.="<td class='triwulan_2'  style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";*/


			        	$table_append.="<td class='triwulan_3 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_07."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_07."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_08."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_08."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='width:50px !important;vertical-align:middle;font-size:10px;".$this_month_09."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_09."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
			        	$table_append.="</td>";

			        	/*$table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_3."</center></td>"; 
				        $table_append.="<td  class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";*/

			        	$table_append.="<td  class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_10."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_11."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_11."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_12."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_12."'  
			        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
			        	$table_append.="</td>";		

			        	/*$table_append.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_4."</center></td>"; 
				        $table_append.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";	    */    	
			        		$total_kesamping=0;

						 

				        	$percentange=0;
				        	/*if($id_table!="1"){
					        	if($total_kesamping > 0){
						        	$percentange=($total_kesamping / $total_pagu ) * 100;
								}
								if($total_pagu > 0){
						        	$percentange=($total_kesamping / $total_pagu ) * 100;
								}
							} else {
								$percentange=$total_kesamping;
							}	*/
							$persentase_semua=0;
							if(($target_kinerja2=="") or($target_kinerja2=="")){
								$target_kinerja2=1;
							} else {
								$persentase_semua=number_format((($rp_total_kesamping/$target_kinerja2)*100),1);
							}
							$percentange=$rp_triwulan_1+
				        	$rp_triwulan_2+
				        	$rp_triwulan_3+
				        	$rp_triwulan_4 ;
				        	$table_append.="<td style='width:70px !important;vertical-align:middle;font-size:10px; '>";
				        	$table_append.="<center><b>".strtoupper(trim($persentase_semua))." % &nbsp; </b></center></a>";
				        	$table_append.="</td>";

				        	
				        	
							$tipe_capaian='';
							$id_table="2";
 				        	if($id_table=="1"){
					           $tipe_capaian="kinerja";
					        } else  if($id_table=="2"){
					           $tipe_capaian="keuangan";
					        } else  if($id_table=="3"){
					           $tipe_capaian="phln";
					        } else  if($id_table=="4"){
					           $tipe_capaian="dktp";
					        } else  if($id_table=="5"){
					           $tipe_capaian="lakip";
					        } else  if($id_table=="6"){
					           $tipe_capaian="renaksi";
						}
						$pembagi=$pembagi_keuangan;
						if(($pembagi=="0") or ($pembagi=="")){
							$pembagi="1";
						}
						$total_kesamping=0;
						$this_month="";
							$rp_triwulan_1=($c_01_keuangan+$c_02_keuangan+$c_03_keuangan);
				        	$rp_triwulan_2=($c_04_keuangan+$c_05_keuangan+$c_06_keuangan);
				        	$rp_triwulan_3=($c_07_keuangan+$c_08_keuangan+$c_09_keuangan);
				        	$rp_triwulan_4=($c_10_keuangan+$c_11_keuangan+$c_12_keuangan);
							$babi="";
							if(($sum_target_indikator=="0") or ($sum_target_indikator=="")){ 
								$sum_target_indikator=1; 
 							}
							
  							$kali_seratus=100;	
  								$persen_triwulan_1=0;
						        $persen_triwulan_2=0;
						        $persen_triwulan_3=0;
						        $persen_triwulan_4=0;
  							if(($pembagi_keuangan!="")){				        	 
	 				        	$persen_triwulan_1=(($rp_triwulan_1) / $pembagi) * $kali_seratus;
						        $persen_triwulan_2=(($rp_triwulan_2) / $pembagi) * $kali_seratus;
						        $persen_triwulan_3=(($rp_triwulan_3) / $pembagi) * $kali_seratus;
						        $persen_triwulan_4=(($rp_triwulan_4) / $pembagi) * $kali_seratus;
						    }
				        	$rp_triwulan_1=number_format($rp_triwulan_1);
				        	$rp_triwulan_2=number_format($rp_triwulan_2);
				        	$rp_triwulan_3=number_format($rp_triwulan_3);
				        	$rp_triwulan_4=number_format($rp_triwulan_4);

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	} 
				        $table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_01."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_01_keuangan)))."</center></a>";
			        	$table_append.="</td>";
			        	
			        	$table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_02."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_02."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_02_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_1 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_03."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_03."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_03_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_1 ' style='width:70px !important;vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_1."</center></td>";
				        $table_append.="<td class='triwulan_1 ' style='width:70px !important;vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_1,1)." % </b></center></td>";

			        	$table_append.="<td class='triwulan_2 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_04."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_04."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_04_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_2 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_05."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_05."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_05_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_06."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_06."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_06_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td class='triwulan_2 '  style='width:10px !important;vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_2."</center></td>";
				        $table_append.="<td class='triwulan_2 '  style='width:40px !important;vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_2,1)."  %  </b></center></td>";


			        	$table_append.="<td class='triwulan_3 '  style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_07."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_07."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_07_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_08."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_08."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_08_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td  class='triwulan_3 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_09."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_09."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_09_keuangan)))."</center></a>";
			        	$table_append.="</td>";

			        	$table_append.="<td  class='triwulan_3 ' style='width:40px !important;vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_3."</center></td>";
				        $table_append.="<td  class='triwulan_3 ' style='width:40px !important;vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_3,1)."  %  </b></center></td>";

			        	$table_append.="<td  class='triwulan_4 ' style='width:40px !important;vertical-align:middle;font-size:10px;".$this_month_10."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_10."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_10_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_11."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_11."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_11_keuangan)))."</center></a>";
			        	$table_append.="</td>";


			        	$table_append.="<td class='triwulan_4 ' style='width:10px !important;vertical-align:middle;font-size:10px;".$this_month_12."'>";
			        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_12."'  
			        	class='".$class_xeditable_keuangan."' id='".$data_f->id."' data-type='text' 
			        	data-placement='right' data-id='".$tipe_capaian."' 
			        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,1,1,".$data_f->id.",1)'>
			        	<center>".strtoupper(trim(number_format($c_12_keuangan)))."</center></a>";
			        	$table_append.="</td>";		

			        	$table_append.="<td class='triwulan_4 ' style='width:40px !important;vertical-align:middle;font-size:10px;'>
				        	<center>".$rp_triwulan_4."</center></td>";
				        $table_append.="<td class='triwulan_4 ' style='width:40px !important;vertical-align:middle;font-size:10px;'>
				        	<center><b><span style='color:#fff'>'</span>".number_format($persen_triwulan_4,1)."  %  </b></center></td>";	        	
			        	$total_kesamping=0;

						$table_append.="<td class='' style='width:40px !important;vertical-align:middle;font-size:10px;width:50px !important'>";
				        	$total_kesamping=0;
							if($id_table=="1"){
									$total_kesamping=(($c_01_keuangan+$c_02_keuangan+$c_03_keuangan+$c_04_keuangan+$c_05_keuangan+$c_06_keuangan+$c_07_keuangan+$c_08_keuangan+$c_09_keuangan+$c_10_keuangan+$c_11_keuangan+$c_12_keuangan)/12);
									$table_append.="<center>-</a>";
								} else {
									$total_kesamping=$c_01_keuangan+$c_02_keuangan+$c_03_keuangan+$c_04_keuangan+$c_05_keuangan+$c_06_keuangan+$c_07_keuangan+$c_08_keuangan+$c_09_keuangan+$c_10_keuangan+$c_11_keuangan+$c_12_keuangan;
									$table_append.="<center>".strtoupper(trim(number_format($total_kesamping)))."</center></a>";
							}
							$table_append.="</td>";

				        	$percentange=0;
				        	if(($target_keuangan2=="") or ($target_keuangan2=="0") or  (trim($target_keuangan2)=="-")){
				        		$target_keuangan2=1;
				        		$percentange="0";
 				        	} else {
				        		$percentange=($total_kesamping / $target_keuangan2 ) * 100;
				        	}
				        	
				        	//$percentange=($total_kesamping / $target_keuangan2 ) * 100;

 				        	$table_append.="<td class='' style='width:40px !important;vertical-align:middle;font-size:10px;width:50px !important'>";
				        	$table_append.="<center><b>".strtoupper(trim(number_format($percentange,1)))." % </b> </center></a>";
				        	$table_append.="</td>";
				        	$table_append.="</tr>";
				        	$table_append.="<tr style='display:none' id='detail_dok_".$data_f->id."'>";
				        	$table_append.="<td colspan='52' style='background-color:#dedede;padding:5px' id='data_detail_dok_".$data_f->id."'>";
				        	$table_append.="</td>";
				        	
							$table.=$table_append;

				        }

			        /* END OF TIDAK SAMA DENGAN SUB KOMPOENEN INPUT */
			        /* AMBIL CAPAIAN KEUANGAN */
					/*---------------------------------------------*/
				        if ($this->cek_child_anak($id,$data_f->parent)) {
				        	$id_table="1";
							$table.=$this->get_child_realisasi_capaian($id,$id_table,trim($data_f->kode),$komparasi);
						}
					}	
				} 
			}  
			return $table;
	}
	function load_capaian_lainnya($id="",$id_kewenangan=""){
		$table="";
		$tipe_capaian="keuangan";
		$total_all_pagu=0;
		$style=";font-size:10px;font-weight:bold;padding:10px";

		$query=$this->db->query("select *,template_renja.tahun_anggaran as tahun_anggaran,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12'
		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc"); 
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
					$table.="<tr>";
						$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->kode_direktorat."</td>";
						$table.="<td style='".$style.";vertical-align:middle;' colspan='3'>".strtoupper($data_f->program)."</td>";
						$table.="<td style='".$style.";vertical-align:middle;'>".strtoupper($data_f->sasaran_program)."</td>";
						$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->target."</td>"; 
						$table.="<td style='".$style.";vertical-align:middle;'><b><center>-</center></b></td>"; 
						$table.="<td style='".$style.";vertical-align:middle;'><center>-</center></td>"; 
						$table.="<td style='".$style.";vertical-align:middle;'><center>-</center></td>"; 
 				 	$table.="</tr>";
					$table.="</tr>";
			        if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_load_capaian_lainnya($id,$id_kewenangan,$data_f->parent);
					}  	 
					
				}
		}
		return $table;
	}
	function get_child_load_capaian_lainnya($id="",$id_kewenangan="",$parent=""){
		$table="";
		$class_xeditable='';
		$tipe_capaian='';
		$tipe_capaian="keuangan";
		$bg_ikk="";
		$id_table=2;
		$style_header="vertical-align:middle;font-size:10px;font-weight:normal;height:50px;";
		$query=$this->db->query("select *,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,template_renja.tahun_anggaran as tahun_berlaku,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12',
 		
 		(select c_01 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_kinerja_realisasi',
		(select c_02 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_kinerja_realisasi',
		(select c_03 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_kinerja_realisasi',
		(select c_04 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_kinerja_realisasi',
		(select c_05 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_kinerja_realisasi',
		(select c_06 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_kinerja_realisasi',
		(select c_07 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_kinerja_realisasi',
		(select c_08 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_kinerja_realisasi',
		(select c_09 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_kinerja_realisasi',
		(select c_10 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_kinerja_realisasi',
		(select c_11 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_kinerja_realisasi',
		(select c_12 from capaian_kinerja where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_kinerja_realisasi',


		(select c_01 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01_keuangan',
		(select c_02 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02_keuangan',
		(select c_03 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03_keuangan',
		(select c_04 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04_keuangan',
		(select c_05 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05_keuangan',
		(select c_06 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06_keuangan',
		(select c_07 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07_keuangan',
		(select c_08 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08_keuangan',
		(select c_09 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09_keuangan',
		(select c_10 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10_keuangan',
		(select c_11 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11_keuangan',
		(select c_12 from capaian_keuangan where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12_keuangan' ,

		(select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_keuangan_target where trim(kode_direktorat_child)=a.kode_direktorat_child
			and    kode=a.kode and trim(parent)=a.parent and tahun=template_renja.tahun_anggaran
		) as target_keuangan_dari_table

		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."'  and id_kewenangan='".$id_kewenangan."' order by a.urutan asc");
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
					$class_xeditable='';
				    if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        	$class_xeditable='text_'.$tipe_capaian.'';
			        }	
 					$table.="<tr>";
						if($data_f->tipe=="indikator"){
							$style_header.=";font-weight:bold";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;width:10px;background-color:#2C802C'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center> ".strtoupper($data_f->kode)."  </center></td>";
							$table.="<td colspan='2' style='".$style_header."'> ".(($data_f->indikator))."</td>";
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
						} else if($data_f->tipe=="komponen_input"){
							$table.="<td></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'>
							<center><div style='height:10px;;width:10px;background-color:#31BC86'></div></center></td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> <center>".strtoupper($data_f->kode)."</center> </td>";
							$table.="<td style='".$style_header.";vertical-align:middle;'> ".(($data_f->komponen_input))."  </td>";
							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
			 					if (($this->session->userdata('ID_DIREKTORAT')==$data_f->dari)){
									$class_xeditable='text_'.$tipe_capaian.'';
								}
								
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
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
 							} else {
								$bo01=$this->get_total_indikator('bo01',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bo02=$this->get_total_indikator('bo02',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_p=$this->get_total_indikator('bno_phln_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_phln_d=$this->get_total_indikator('bno_phln_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_p=$this->get_total_indikator('bno_rm_p',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$bno_rm_d=$this->get_total_indikator('bno_rm_d',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								$pnbp=$this->get_total_indikator('pnbp',$data_f->kode_direktorat_child,$data_f->kode,$data_f->tahun,$id);
								
							}
 					 
				 			$total_pagu=$bo01+$bo02+$bno_rm_p+$bno_rm_d+$bno_phln_p+$bno_phln_d+$pnbp;
									
							$target= $data_f->target ? $data_f->target : " - ";
							$table.="<td style='".$style_header."'> ".(($data_f->sasaran_kegiatan))." </td>";
 				 			$table.="<td style='".$style_header."'><center>".number_format($total_pagu)."</center></td>"; 

							$check_child=$this->cek_child_komponen_input($data_f->kode,$data_f->id_data_renja);
 					 		
 					 		$rp_triwulan_1=($c_01+$c_02+$c_03);
				        	$rp_triwulan_2=($c_04+$c_05+$c_06);
				        	$rp_triwulan_3=($c_07+$c_08+$c_09);
				        	$rp_triwulan_4=($c_10+$c_11+$c_12);
							
							$pembagi=1;
							$kali_seratus=1;
				        	if($id_table=="1"){
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  				       


							$table_append="";
					       // 
				        	
				        	/*$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='".$tipe_capaian."' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,0)'>
				        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
				        	$table_append.="</td>";*/

				        	$target_kinerja = $data_f->target_kinerja ? $data_f->target_kinerja . " <b>%</b> " : "-";
				        	$target_kinerja2 = $data_f->target_kinerja ? $data_f->target_kinerja   : "1";
				        	$target_keuangan = $data_f->target_keuangan_dari_table ? number_format($data_f->target_keuangan_dari_table)  : "-";
				        	$target_keuangan2= $data_f->target_keuangan_dari_table ?  ($data_f->target_keuangan_dari_table)  : "1";

				        	$total_kesamping_keuangan=0;
				        	$total_kesamping_kinerja=0;


				        	$c_01_keuangan=$data_f->c_01_keuangan;
							$c_02_keuangan=$data_f->c_02_keuangan;
							$c_03_keuangan=$data_f->c_03_keuangan;
							$c_04_keuangan=$data_f->c_04_keuangan;
							$c_05_keuangan=$data_f->c_05_keuangan;
							$c_06_keuangan=$data_f->c_06_keuangan;
							$c_07_keuangan=$data_f->c_07_keuangan;
							$c_08_keuangan=$data_f->c_08_keuangan;
							$c_09_keuangan=$data_f->c_09_keuangan;
							$c_10_keuangan=$data_f->c_10_keuangan;
							$c_11_keuangan=$data_f->c_11_keuangan;
							$c_12_keuangan=$data_f->c_12_keuangan;

							$c_01_kinerja_realisasi=$data_f->c_01_kinerja_realisasi;
							$c_02_kinerja_realisasi=$data_f->c_02_kinerja_realisasi;
							$c_03_kinerja_realisasi=$data_f->c_03_kinerja_realisasi;
							$c_04_kinerja_realisasi=$data_f->c_04_kinerja_realisasi;
							$c_05_kinerja_realisasi=$data_f->c_05_kinerja_realisasi;
							$c_06_kinerja_realisasi=$data_f->c_06_kinerja_realisasi;
							$c_07_kinerja_realisasi=$data_f->c_07_kinerja_realisasi;
							$c_08_kinerja_realisasi=$data_f->c_08_kinerja_realisasi;
							$c_09_kinerja_realisasi=$data_f->c_09_kinerja_realisasi;
							$c_10_kinerja_realisasi=$data_f->c_10_kinerja_realisasi;
							$c_11_kinerja_realisasi=$data_f->c_11_kinerja_realisasi;
							$c_12_kinerja_realisasi=$data_f->c_12_kinerja_realisasi;

							$total_kesamping_keuangan=$c_01_keuangan+$c_02_keuangan+$c_03_keuangan+$c_04_keuangan+$c_05_keuangan+$c_06_keuangan+$c_07_keuangan+$c_08_keuangan+$c_09_keuangan+$c_10_keuangan+$c_11_keuangan+$c_12_keuangan;
							$total_kesamping_kinerja=$c_01_kinerja_realisasi+$c_02_kinerja_realisasi+$c_03_kinerja_realisasi+$c_04_kinerja_realisasi+$c_05_kinerja_realisasi+$c_06_kinerja_realisasi+$c_07_kinerja_realisasi+$c_08_kinerja_realisasi+$c_09_kinerja_realisasi+$c_10_kinerja_realisasi+$c_11_kinerja_realisasi+$c_12_kinerja_realisasi;

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,0)'>
				        	<center>".strtoupper(trim(($target_keuangan)))."</center></a>";
				        	$table_append.="</td>";

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru'>
				        	<center>".number_format($total_kesamping_keuangan)."</center></a>";
				        	$table_append.="</td>";	        	

				        	if (($target_keuangan!="-")){
				        		$progress_keuangan= number_format((($total_kesamping_keuangan / $target_keuangan2 ) * 100),2);
 				        	} else {
				        		$progress_keuangan="0";
				        	}

				        	$bg1="";
				        	$bg2="";

				        	if($target_keuangan2 < $total_kesamping_keuangan){
				        		$bg1="background:#31BC86";
				        	} else if($target_keuangan2 > $total_kesamping_keuangan){
				        		$bg1="background:#B50000";
				        	}  

				        	$table_append.="<td class='triwulan_1' style='vertical-align:middle;font-size:10px;".$bg_ikk."'>";
				        	$table_append.="<a style='font-size:10px;text-align:center;cursor:pointer'  
				        	class='text_keuangan_target_false' id='".$data_f->id."' data-type='text' 
				        	data-placement='right' data-id='keuangan_target' 
				        	data-title='Masukan Nilai Baru'>
				        	<center class='badge' style='".$bg1."'>".($progress_keuangan)." <b>%</b> </center></a>";
				        	$table_append.="</td>";

 

					        if (($check_child=="true") and ($id_table=="1")){
					        	 $table.=$table_append;
					        }	else {
					        	 $table.=$table_append;
					        }
					        $table.="</tr>";
						}	

						
				        	if ($this->cek_child_anak($id,$data_f->parent)) {
								$table.=$this->get_child_load_capaian_lainnya($id,$id_table,trim($data_f->kode));
						}
				} 
			}  
			return $table;
	}
	function get_capaian_realisasi($id="",$id_table="",$komparasi=""){
		$table="";
		$class_xeditable='';
		$tipe_capaian='';
		$this_month="";
		$id_table="1";
		if($komparasi==""){
			$komparasi=$this->input->post('komparasi');
		}
 		$style=";font-size:10px;font-weight:bold;padding:10px";
		if($id_table=="1"){
	           $tipe_capaian="kinerja";
	        } else  if($id_table=="2"){
	           $tipe_capaian="keuangan";
	        } else  if($id_table=="3"){
	           $tipe_capaian="phln";
	        } else  if($id_table=="4"){
	           $tipe_capaian="dktp";
	        } else  if($id_table=="5"){
	           $tipe_capaian="lakip";
	        } else  if($id_table=="6"){
	           $tipe_capaian="renaksi";
		}
 		$query=$this->db->query("select *,template_renja.tahun_anggaran as tahun_anggaran,m_unit_kerja.kd_unit_kerja,a.id as id,tahun_anggaran.tahun_anggaran as tahun,
		(select c_01 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_01',
		(select c_02 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_02',
		(select c_03 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_03',
		(select c_04 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_04',
		(select c_05 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_05',
		(select c_06 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_06',
		(select c_07 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_07',
		(select c_08 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_08',
		(select c_09 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_09',
		(select c_10 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_10',
		(select c_11 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_11',
		(select c_12 from capaian_".$tipe_capaian." where trim(kode_direktorat_child)=trim(a.kode_direktorat_child) and trim(kode)=trim(a.kode) and trim(parent)=trim(a.parent) and tahun=template_renja.tahun_anggaran) as 'c_12',
		
		(select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_keuangan_target where tahun=template_renja.tahun_anggaran
		) as target_keuangan_dari_table

		from data_template_renja a
		left join template_renja on template_renja.id=a.id_data_renja
			left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
			left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
			where a.id_data_renja='".$id."' and tipe='program' order by a.urutan asc"); 
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
					$total_pagu=0;
					$total_bo1=0;
					$total_bo2=0;
					$total_rm_pusat=0;
					$total_rm_daerah=0;
					$total_phln_pusat=0;
					$total_phln_daerah=0;
					$total_pnbp=0;
					$total_all_pagu=0;
					
					$total_pagu=0;
					$total_bo1=0;
					$total_bo2=0;
					$total_rm_pusat=0;
					$total_rm_daerah=0;
					$total_phln_pusat=0;
					$total_phln_daerah=0;
					$total_pnbp=0;
					$total_all_pagu=0;
					$total_all=0;
					$total_bo1=$total_bo1+$this->get_total_program('bo01',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_bo2=$total_bo2+$this->get_total_program('bo02',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_pusat=$total_rm_pusat+$this->get_total_program('bno_rm_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_rm_daerah=$total_rm_daerah+$this->get_total_program('bno_rm_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_pusat=$total_phln_pusat+$this->get_total_program('bno_phln_p',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_phln_daerah=$total_phln_daerah+$this->get_total_program('bno_phln_d',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_pnbp=$total_pnbp+$this->get_total_program('pnbp',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id);
					$total_all=$total_all+$this->get_total_program_from_target('total_all',$data_f->kode_direktorat_child,$data_f->tahun_anggaran,$id_table,$id);
 					
 					if($komparasi!="1"){
 						$total_all_pagu=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
					} else {
						$total_all_pagu=$total_all;
					}
					$target_kinerja= $data_f->target_kinerja ."<b> % </b>" ? $data_f->target_kinerja : " - ";
					
					$target_keuangan= $data_f->target_keuangan_dari_table ? $data_f->target_keuangan_dari_table : " - ";
					
					
					$table.="<tr>";
					$table.="<td style='".$style.";vertical-align:middle;'>".$data_f->kode_direktorat."</td>";
					$table.="<td style='".$style.";vertical-align:middle;' colspan='3'>".strtoupper($data_f->program)."</td>";
					$table.="<td style='".$style.";vertical-align:middle;'>".strtoupper($data_f->sasaran_program)."</td>";
 					$table.="<td style='".$style.";vertical-align:middle;'><b>".number_format($total_all_pagu)."</b></td>"; 
					$table.="<td style='".$style.";vertical-align:middle;'><center>".number_format($data_f->target_keuangan_dari_table)."</center></td>";$table.="<td style='".$style.";vertical-align:middle;'><center>-</center></td>"; 
					
						/*$c_01=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,'realisasi',$id);
						$c_02=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,'realisasi',$id);
						$c_03=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,'realisasi',$id);
						$c_04=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,'realisasi',$id);
						$c_05=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,'realisasi',$id);
						$c_06=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,'realisasi',$id);
						$c_07=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,'realisasi',$id);
						$c_08=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,'realisasi',$id);
						$c_09=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,'realisasi',$id);
						$c_10=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,'realisasi',$id);
						$c_11=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,'realisasi',$id);
						$c_12=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,'realisasi',$id); */

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

						$class_xeditable='';
				        if ($this->session->userdata('ID_DIREKTORAT')==$data_f->dari){
			        		$class_xeditable='text_'.$tipe_capaian.'';
			        	}	
			        	
			        	$this_month_01="";$this_month_02="";$this_month_03="";$this_month_04="";$this_month_05="";
		 				$this_month_06="";$this_month_07="";$this_month_08="";$this_month_09="";$this_month_10="";
		 				$this_month_11="";$this_month_12="";

		 				$color_01="";$color_02="";$color_03="";$color_04="";$color_05="";
		 				$color_06="";$color_07="";$color_08="";$color_09="";$color_10="";
		 				$color_11="";$color_12="";
	 					

 			        	if(date("m")=="01"){
			        		$this_month_01=" background-color:#C07B6B;color:#fff;";$color_01=";color:#fff;";
			        	} else if(date("m")=="02"){
			        		$this_month_02=" background-color:#C07B6B;color:#fff;";$color_02=";color:#fff;";
			        	}  else if(date("m")=="03"){
			        		$this_month_03=" background-color:#C07B6B;color:#fff;";$color_03=";color:#fff;";
			        	} else if(date("m")=="04"){
			        		$this_month_04=" background-color:#C07B6B;color:#fff;";$color_04=";color:#fff;";
			        	} else if(date("m")=="05"){
			        		$this_month_05=" background-color:#C07B6B;color:#fff;";$color_05=";color:#fff;";
			        	} else if(date("m")=="06"){
			        		$this_month_06=" background-color:#C07B6B;color:#fff;";$color_06=";color:#fff;";
			        	} else if(date("m")=="07"){
			        		$this_month_07=" background-color:#C07B6B;color:#fff;";$color_07=";color:#fff;";
			        	} else if(date("m")=="08"){
			        		$this_month_08=" background-color:#C07B6B;color:#fff;";$color_08=";color:#fff;";
			        	} else if(date("m")=="09"){
			        		$this_month_09=" background-color:#C07B6B;color:#fff;";$color_09=";color:#fff;";
			        	} else if(date("m")=="10"){
			        		$this_month_10=" background-color:#C07B6B;color:#fff;";$color_10=";color:#fff;";
			        	} else if(date("m")=="11"){
			        		$this_month_11=" background-color:#C07B6B;color:#fff;";$color_11=";color:#fff;";
			        	} else if(date("m")=="12"){
			        		$this_month_12=" background-color:#C07B6B;color:#fff;";$color_12=";color:#fff;";
			        	}

			        	 
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
				        	if($id_table=="1"){
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

				        	if($id_table=="1"){
				        		$rp_triwulan_1="-";
				        		$rp_triwulan_2="-";
				        		$rp_triwulan_3="-";
				        		$rp_triwulan_4="-";
				        	}  		

				        	

		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
	        		$table.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,1,1,".$data_f->id.",0)'>
			        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
		        	$table.="</td>";
		        	
		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_1'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_1."</b></center></td>";
		        	$table.="<td class='triwulan_1'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";*/


		        	$table.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
		        	$table.="</td>";



		        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
	       			$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
		        	$table.="</td>";
 
		        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_2."</b></center></td>"; 
		        	$table.="<td class='triwulan_2' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";*/

		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
	     		   	$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
		        	$table.="</td>";

		        	/*$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_3."</b></center></td>"; 
		        	$table.="<td class='triwulan_3' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";*/

		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
		        	$table.="</td>";


		        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
	        		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
		        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
		        	data-placement='right' data-id='".$tipe_capaian."' 
		        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,1,1,".$data_f->id.",0)'>
		        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
		        	$table.="</td>";
		        	
		        	/*$table.="<td class='triwulan_4'  style='vertical-align:middle;font-size:10px;'>
		        	<center><b>".$rp_triwulan_4."</b></center></td>"; 
		        	$table.="<td class='triwulan_4' style='vertical-align:middle;font-size:10px;'>
		        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";*/

		        	 
		         	
		        	$percentange=0;
		        	if($id_table!="1"){
			        	if($total_all_pagu!="0"){
			        		$percentange=($total_kesamping/$total_all_pagu)*100;
			        	}
			        } else {
			        	$percentange=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
			        }	
		       	   $table.="<td style='".$style.";vertical-align:middle;'>".number_format($percentange,1)."</td>"; 


		        /* AMBIL CAPAIAN KEUANGAN */
		        $id_table=2;
		        if($id_table=="1"){
		           $tipe_capaian="kinerja";
		        } else  if($id_table=="2"){
		           $tipe_capaian="keuangan";
		        } else  if($id_table=="3"){
		           $tipe_capaian="phln";
		        } else  if($id_table=="4"){
		           $tipe_capaian="dktp";
		        } else  if($id_table=="5"){
		           $tipe_capaian="lakip";
		        } else  if($id_table=="6"){
		           $tipe_capaian="renaksi";
				}

			$c_01=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'01',$data_f->tahun_anggaran,'realisasi',$id);
			$c_02=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'02',$data_f->tahun_anggaran,'realisasi',$id);
			$c_03=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'03',$data_f->tahun_anggaran,'realisasi',$id);
			$c_04=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'04',$data_f->tahun_anggaran,'realisasi',$id);
			$c_05=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'05',$data_f->tahun_anggaran,'realisasi',$id);
			$c_06=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'06',$data_f->tahun_anggaran,'realisasi',$id);
			$c_07=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'07',$data_f->tahun_anggaran,'realisasi',$id);
			$c_08=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'08',$data_f->tahun_anggaran,'realisasi',$id);
			$c_09=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'09',$data_f->tahun_anggaran,'realisasi',$id);
			$c_10=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'10',$data_f->tahun_anggaran,'realisasi',$id);
			$c_11=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'11',$data_f->tahun_anggaran,'realisasi',$id);
			$c_12=$this->get_total_header_capaian_realisasi($id_table,$data_f->kode_direktorat_child,'12',$data_f->tahun_anggaran,'realisasi',$id); 

			$rp_triwulan_1=$c_01+$c_02+$c_03;
	        $rp_triwulan_2=$c_04+$c_05+$c_06;
	        $rp_triwulan_3=$c_07+$c_08+$c_09;
	        $rp_triwulan_4=$c_10+$c_11+$c_12;

        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_01."'>";
    		$table.="<a style='font-size:10px;text-align:center;cursor:pointer".$color_01."'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(1,1,1,".$data_f->id.",1)'>
	        	<center>".strtoupper(trim(number_format($c_01)))."</center></a>";
        	$table.="</td>";
        	
        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_02."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(2,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_02)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;".$this_month_03."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(3,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_03)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_1,1)."</b></center></td>";
        	$table.="<td class='triwulan_1 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_1,1)."</b></center></td>";


        	$table.="<td class='triwulan_2 '  style='vertical-align:middle;font-size:10px;".$this_month_04."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(4,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_04)))."</center></a>";
        	$table.="</td>";



        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_05."'>";
   			$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(5,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_05)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;".$this_month_06."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(6,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_06)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_2,1)."</b></center></td>";
        	$table.="<td class='triwulan_2 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_2,1)."</b></center></td>";

        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_07."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(7,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_07)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_08."'>";
 		   	$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(8,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_08)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;".$this_month_09."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(9,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_09)))."</center></a>";
        	$table.="</td>";

        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_3,1)."</b></center></td>";
        	$table.="<td class='triwulan_3 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_3,1)."</b></center></td>";

        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_10."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(10,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_10)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_11."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(11,0,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_11)))."</center></a>";
        	$table.="</td>";


        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;".$this_month_12."'>";
    		$table.="<a  style='font-size:10px;text-align:center;cursor:pointer'  
        	class='".$class_xeditable."' id='".$data_f->id."' data-type='text' 
        	data-placement='right' data-id='".$tipe_capaian."' 
        	data-title='Masukan Nilai Baru' onclick='return save_bulan(12,1,1,".$data_f->id.",1)'>
        	<center>".strtoupper(trim(number_format($c_12)))."</center></a>";
        	$table.="</td>";
        	
        	$table.="<td class='triwulan_4 '  style='vertical-align:middle;font-size:10px;'>
        	<center><b>".number_format($rp_triwulan_4,1)."</b></center></td>";
        	$table.="<td class='triwulan_4 ' style='vertical-align:middle;font-size:10px;'>
        	<center><b><span style='color:#F0F0F0'>'</span>".number_format($persen_triwulan_4,1)."</b></center></td>";

        	$total_kesamping=0;
			if($id_table=="1"){
				//$total_kesamping=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
				//$total_kesamping="-";
			} else {
				$total_kesamping=$c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12;
				$total_kesamping=($total_kesamping);
			}

		 	if($id_table!="1"){
					$table.="<td class='' style='vertical-align:middle;font-size:10px;'>";
		        $table.="<center><b>".strtoupper(trim(number_format($total_kesamping)))."</b></center>";
		        $table.="</td>";
		    } else {
		    	$table.="<td  class='' style='vertical-align:middle;font-size:10px;'>";
		        $table.="<center>-</center>";
		        $table.="</td>";
		    }   
         	
        	$percentange=0;
        	/*if($id_table!="1"){
	        	if($target_keuangan!="0"){
	        		$percentange=($total_kesamping/$target_keuangan)*100;
	        	}
	        } else {
	        	$percentange=($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/12;
	        }	*/
	        if(($target_keuangan=="0") or ($target_keuangan=="")  or (trim($target_keuangan)=="-") ){
	        	$target_keuangan="1";
 	        }
	        $percentange=(($c_01+$c_02+$c_03+$c_04+$c_05+$c_06+$c_07+$c_08+$c_09+$c_10+$c_11+$c_12)/$target_keuangan)*100;

       	 $table.="<td  class='' style='".$style.";vertical-align:middle;'><center>".number_format($percentange,1)." % </center>  </td>"; 
	        $table.="</tr>";	        	
	        	if ($this->cek_child($id,$data_f->parent)) {
					$table.=$this->get_child_realisasi_capaian($id,$id_table,$data_f->parent,$komparasi);
					}  		 			        	
			 	} 
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	 
 

	function get_data_capaian($id_table="",$kode_direktorat_child="",$kode_indikator="",$indikator=""){
		
		if($id_table=="1"){
			$table="capaian_kinerja";
		} else if($id_table=="2"){
			$table="capaian_keuangan";
		} else if($id_table=="3"){
			$table="capaian_phln";
		} else if($id_table=="4"){
			$table="capaian_dktp";
		} else if($id_table=="5"){
			$table="capaian_lakip";
		} else if($id_table=="6"){
			$table="capaian_renaksi";
		}
		$query=$this->db->query("select  jumlah from ".$table." where 
			trim(kode_direktorat_child)='".trim($kode_direktorat_child)."'
			and trim(kode_indikator)='".trim($kode_indikator)."'
			and trim(indikator)='".trim($indikator)."'
			");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$jumlah=$data->jumlah;
				}
			 	return $jumlah;
			}
 
	}
	function get_properti_table($properti="",$id=""){
		$query=$this->db->query("select  ".$properti.",m_unit_kerja.kd_unit_kerja as kode_unit_kerja from template_renja  
		left join m_unit_kerja on m_unit_kerja.id_divisi=template_renja.dari
		 where template_renja.id='".$id."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$properti=$data->$properti;
				}
			 	return $properti;
			}
	}
	function get_field_tahun_anggaran($id=""){
		$tahun_anggaran=0;
		$query=$this->db->query("select  tahun_anggaran.tahun_anggaran from template_renja  
		left join tahun_anggaran on tahun_anggaran.id=template_renja.tahun_anggaran
		 where template_renja.id='".$id."'");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$tahun_anggaran=$data->tahun_anggaran;
				}
			 	return $tahun_anggaran;
			}
	}
	function get_total_capaian_keuangan($id=""){
		$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
		$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
		$total=0;
		$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
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
		$table="";
		$total_target="0";
		$total_realisasi="0";
		
		$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);

		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from capaian_keuangan where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."' 
		and ( kode='' or kode IS NULL)");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total_realisasi=$data->jumlah;
				}			 	 
		}
		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from capaian_keuangan_target where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total_target=$data->jumlah;
				}			 	 
		}
		
		$tahun_anggaran=$this->get_field_tahun_anggaran($id);
		 
  	 
 
 		$yg_sudah=$total_realisasi;
		$yg_belum=$total_target;
	 
		$series="{
                name: ' . ',
                y: ".($yg_sudah)."
            },{
                name: ' . ',
                y: ".($yg_belum-$yg_sudah)."
            }"; 
         return $series;   
	}	

	function get_total_capaian_phln($id=""){
		$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
		$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
		$total=0;
		$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
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
		$table="";
		$total_target=0;
		$total_realisasi=0;
		$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from capaian_phln where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total_realisasi=$data->jumlah;
				}			 	 
			}
			$tahun_anggaran=$this->get_field_tahun_anggaran($id);
		 	$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_phln_target where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
				 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total_target=$data->jumlah;
					}			 	 
			}

			$yg_sudah=$total_realisasi;
			$yg_belum=$total_target;

			/* AMBIL BELANJA OPERASIONAL */
	 
			/*$total_phln_pusat=$this->get_total_program('bno_phln_p',$id_direktorat,$tahun_anggaran);
			$total_phln_daerah=$this->get_total_program('bno_phln_d',$id_direktorat,$tahun_anggaran);
 

			$total_renja_phln=0;
			$total_renja_phln=$total_phln_pusat+$total_phln_daerah;
			$yg_sudah=0;
			$yg_belum=0;
			if($total_renja_phln){
				$yg_sudah=($total/$total_renja_phln)*100;
				$yg_belum=100-$yg_sudah;
				$sisa=0;
				$sisa=$total_renja_phln-$total;
			}  */

			$series="{
	               name: ' . ',
	                y: ".($yg_sudah)."
	            },{
	                name: ' . ',
	                y: ".($yg_belum-$yg_sudah)."
	            }"; 
	         return $series;	
	}

	function get_total_capaian_dktp($id=""){
			$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
			$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
			$total=0;
			$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
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
			$table="";
			$total_target=0;
			$total_realisasi=0;
			$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
			$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_dktp where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'  and ( kode='' or kode IS NULL)");
				 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total_realisasi=$data->jumlah;
					}			 	 
				}
				$tahun_anggaran=$this->get_field_tahun_anggaran($id);
			 
				/* AMBIL BELANJA OPERASIONAL */
		 	
				$tahun_anggaran=$this->get_field_tahun_anggaran($id);
			 	$query=$this->db->query("select 
				sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
				from capaian_dktp_target where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."'  and ( kode='' or kode IS NULL)");
					 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							 $total_target=$data->jumlah;
						}			 	 
				}

				$yg_sudah=$total_realisasi;
				$yg_belum=$total_target;

				/*$total_rm_daerah=$this->get_total_program('bno_rm_d',$id_direktorat,$tahun_anggaran);

				$total_renja_dktp=0;
				$total_renja_dktp=$total_rm_daerah;
				$yg_sudah=0;
				$yg_belum=0;
				if($total_renja_dktp){
					$yg_sudah=($total/$total_renja_dktp)*100;
					$yg_belum=100-$yg_sudah;
					$sisa=0;
					$sisa=$total_renja_dktp-$total;
				}  */
				$series="{
		              name: ' . ',
		                y: ".($yg_sudah)."
		            },{
		             name: ' . ',
		                y: ".($yg_belum-$yg_sudah)."
		            }"; 
		         return $series;	
		}
	
	function get_total_capaian_renaksi($id=""){
		$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
		$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
		$total=0;
		$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
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
		$table="";
		$total_target=0;
		$total_realisasi=0;
		$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from capaian_renaksi where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total_realisasi=$data->jumlah;
				}			 	 
			}
		$tahun_anggaran=$this->get_field_tahun_anggaran($id);
 			 	$query=$this->db->query("select 
				sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
				from capaian_renaksi_target where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
					 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							 $total_target=$data->jumlah;
						}			 	 
				}

				$yg_sudah=$total_realisasi;
				$yg_belum=$total_target;
		/* AMBIL BELANJA OPERASIONAL */
	 	/*	$total_renja_renaksi=0;
			$total_bo1=$this->get_total_program('bno_rm_d',$id_direktorat,$tahun_anggaran);
			$total_bo2=$this->get_total_program('bno_rm_d',$id_direktorat,$tahun_anggaran);
			$total_rm_pusat=$this->get_total_program('bno_rm_d',$id_direktorat,$tahun_anggaran);

			$total_renja_renaksi=$total_bo1+$total_bo2+$total_rm_pusat;
 		 	

			$yg_sudah=0;
			$yg_belum=0;
			if($total_renja_renaksi){
				$yg_sudah=($total/$total_renja_renaksi)*100;
				$yg_belum=100-$yg_sudah;
				$sisa=0;
				$sisa=$total_renja_renaksi-$total;
			}  */
			/* AMBIL BELANJA OPERASIONAL */
		 	
				

			$series="{
	               name: ' . ',
	                y: ".($yg_sudah)."
	            },{
	               name: ' . ',
	                y: ".($yg_belum-$yg_sudah)."
	            }"; 
	         return $series;	
		}
	function cek_total_capaian_kinerja($id=""){
		$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
		$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
		$total=0;
		$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
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
		$table="";
		$total=0;
		$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from capaian_kinerja where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total=$data->jumlah;
				}	
				return $total;		 	 
			}

 		
	}	
	function cek_total_data_renja($id="",$tipe=""){
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
		$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
		$tahun_anggaran=$this->get_field_tahun_anggaran($id);
	  	$query=$this->db->query("select * from data_template_renja  a			 
			where a.tahun_berlaku like '%".$tahun_anggaran."%' and a.kode_direktorat_child like'%".$id_direktorat."%'");	 
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$isletter="";
					$isletter= $this->isletter($data->program);;
					if($tipe=='renaksi'){
							if((empty($data->kode_direktorat)) and  (empty($data->program)) and (empty($isletter))  ){
							 	if (($data->kl==strtoupper("QW")) or ($data->kl==strtoupper("KL"))){
									$total_bo1=$total_bo1+$data->bo01;
									$total_bo2=$total_bo2+$data->bo02;
									$total_rm_pusat=$total_rm_pusat+$data->bno_rm_p;
									$total_rm_daerah=$total_rm_daerah+$data->bno_rm_d;
									$total_phln_pusat=$total_phln_pusat+$data->bno_phln_p;
									$total_phln_daerah=$total_phln_daerah+$data->bno_phln_d;
									$total_pnbp=$total_pnbp+$data->pnbp;
							 	}
							}
					} else {
						if((empty($data->kode_direktorat)) and  (empty($data->program)) and (empty($isletter))  ){
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
			}
			if($tipe=='keuangan'){
				return $total_bo1+$total_bo2+$total_rm_pusat;
			} else if($tipe=='phln'){
				return $total_phln_pusat+$total_phln_daerah;
			} else if($tipe=='dktp'){
				return $total_rm_daerah;
			} else if($tipe=='renaksi'){
				return $total_bo1+$total_bo2+$total_rm_pusat;
			}
		}	
		function get_total_capaian_kinerja($id=""){
			$total_target=0;
			$total_realisasi=0;
			$j=0;
			$id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
			$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
			$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_kinerja where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'  and ( kode='' or kode IS NULL)");			 
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total_realisasi=$data->jumlah;
					}			 	 
				}
			
			$tahun_anggaran=$this->get_field_tahun_anggaran($id);
			$tahun_anggaran=$this->get_field_tahun_anggaran($id);
		 	$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from capaian_kinerja_target where kode_direktorat_child='".$id_direktorat."' and tahun='".$tahun_berlaku."'  and ( kode='' or kode IS NULL)");
				 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total_target=$data->jumlah;
					}			 	 
			}

			$yg_sudah=$total_realisasi;
			$yg_belum=$total_target;

			/*$query_2=$this->db->query("select * from data_template_renja  a			 
			where a.tahun_berlaku like '%".$tahun_anggaran."%' and a.kode_direktorat_child like'%".$id_direktorat."%'");	 
			if ($query_2->num_rows() > 0) {
			foreach ($query_2->result() as $row) {
					$isletter="";
					$isletter= $this->isletter($row->program);
						if((empty($row->kode_direktorat)) and  (empty($row->program)) and (empty($isletter))  ){							 	 
							$j=$j+1;
						}			 
					}
				}
			$data_target_capaian=$this->get_target_capaian($id);	
			$total_capaian=0;
			$total_seratus_persen=0;
			$total_seratus_persen=($j * 100)/2;
			//$total_seratus_persen=$total_seratus_persen / ($data_target_capaian*100);
			$total_capaian=$total;*/

			$series="{
	                name: ' . ',
	                y: ".($yg_sudah)."
	            },{
	                name: ' . ',
	                y: ".($total_target-$yg_sudah)."
	            }"; 
	         return $series;	
		 
			 
		}
		function get_capaian_for_dashboard($id="",$id_table=""){
			$table_capaian="";
			if($id_table=="1"){
           	$table_capaian="capaian_kinerja";
	        } else  if($id_table=="2"){
	           $table_capaian="capaian_keuangan";
	        } else  if($id_table=="3"){
	           $table_capaian="capaian_phln";
	        } else  if($id_table=="4"){
	           $table_capaian="capaian_dktp";
	        } else  if($id_table=="5"){
	           $table_capaian="capaian_lakip";
	        } else  if($id_table=="6"){
	           $table_capaian="capaian_renaksi";
	        }
	        $id_direktorat=$this->get_properti_table('kd_unit_kerja',$id);
			$tahun_berlaku=$this->get_properti_table('tahun_anggaran',$id);
			$query=$this->db->query("select 
			sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
			from ".$table_capaian." where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'");

				 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 $total=$data->jumlah;
					}			 	 
				}
				return $total;
		}
		function get_detail($tipe_capaian="",$direktorat=""){
			$table_capaian="";
			if($tipe_capaian=="1"){
           	$table_capaian="capaian_kinerja";
	        } else  if($tipe_capaian=="2"){
	           $table_capaian="capaian_keuangan";
	        } else  if($tipe_capaian=="3"){
	           $table_capaian="capaian_phln";
	        } else  if($tipe_capaian=="4"){
	           $table_capaian="capaian_dktp";
	        } else  if($tipe_capaian=="5"){
	           $table_capaian="capaian_lakip";
	        } else  if($tipe_capaian=="6"){
	           $table_capaian="capaian_renaksi";
	        }
	        $januari=0;
	        $februari=0;
	        $maret=0;
	        $april=0;
	        $mei=0;
	        $juni=0;
	        $juli=0;
	        $september=0;
	        $oktober=0;
	        $november=0;
	        $desember=0;
	        $agustus=0;
	        $target="";
 			$realisasi="";
 			$i=1;
 			$j=1;
	        $tahun_berlaku=$this->get_properti_table('tahun_anggaran',$direktorat);
	        $id_direktorat=$this->get_properti_table('kd_unit_kerja',$direktorat);
	        $query=$this->db->query("select 
			sum(c_01) as januari,
			sum(c_02) as februari,
			sum(c_03) as maret,
			sum(c_04) as april,
			sum(c_05) as mei,
			sum(c_06) as juni,
			sum(c_07) as juli,
			sum(c_08) as agustus,
			sum(c_09) as september,
			sum(c_10) as oktober,
			sum(c_11) as november,
			sum(c_12) as desember
			from ".$table_capaian."_target
			where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'"); 			
 			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 	$januari=$data->januari;
					        $februari=$data->februari;
					        $maret=$data->maret;
					        $april=$data->april;
					        $mei=$data->mei;
					        $juni=$data->juni;
					        $juli=$data->juli;
					        $september=$data->september;
					        $oktober=$data->oktober;
					        $november=$data->november;
					        $desember=$data->desember;
					        $agustus=$data->agustus	;				
					        $target=$januari.','.$februari.','.$maret.','.$april.','.$mei.','.$juni.','.$juli.','.$agustus.','.$september.','.$oktober.','.$november.','.$desember;
					        $i++;
					}			 	 
			}
		$query=$this->db->query("select 
			sum(c_01) as januari,
			sum(c_02) as februari,
			sum(c_03) as maret,
			sum(c_04) as april,
			sum(c_05) as mei,
			sum(c_06) as juni,
			sum(c_07) as juli,
			sum(c_08) as agustus,
			sum(c_09) as september,
			sum(c_10) as oktober,
			sum(c_11) as november,
			sum(c_12) as desember
			from ".$table_capaian."
			where kode_direktorat_child='".$id_direktorat."'  and tahun='".$tahun_berlaku."'");
   			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						 	$januari=$data->januari;
					        $februari=$data->februari;
					        $maret=$data->maret;
					        $april=$data->april;
					        $mei=$data->mei;
					        $juni=$data->juni;
					        $juli=$data->juli;
					        $september=$data->september;
					        $oktober=$data->oktober;
					        $november=$data->november;
					        $desember=$data->desember;
					        $agustus=$data->agustus	;				
					        $realisasi=$januari.','.$februari.','.$maret.','.$april.','.$mei.','.$juni.','.$juli.','.$agustus.','.$september.','.$oktober.','.$november.','.$desember;
					        $j++;
					}			 	 
			}
			if($tipe_capaian=="1"){
				echo "Data Capaian Kinerja Tidak Bisa di Breakdown";
				return false;
			}
			$series="";
			$series="{
		            name: 'TARGET',
		            data: [".$target."]
				  },{
		            name: 'REALISASI',
		            data: [".$realisasi."]
				  }";
			/*$series="{
                name: 'Januari',
                y: ".$januari.",
                drilldown: 'Microsoft Internet Explorer'
            }, {
                name: 'Februari',
                 y: ".$februari.",
                drilldown: 'Chrome'
            }, {
                name: 'Maret',
                 y: ".$maret.",
                drilldown: 'Firefox'
            }, {
                name: 'April',
                 y: ".$april.",
                drilldown: 'Safari'
            }, {
                name: 'Mei',
                 y: ".$mei.",
                drilldown: 'Opera'
            }, {
                name: 'Juni',
                 y: ".$juni.",
                drilldown: null
            }, {
                name: 'Juli',
                y: ".$juli.",
                drilldown: null
            }, {
                name: 'Agustus',
                 y: ".$agustus.",
                drilldown: null
            }, {
                name: 'September',
                y: ".$september.",
                drilldown: null
            }, {
                name: 'Oktober',
                 y: ".$oktober.",
                drilldown: null
            }, {
                name: 'November',
                y: ".$november.",
                drilldown: null
            }, {
                name: 'Desember',
                 y: ".$desember.",
                drilldown: null
            }";	*/
            return $series;
		}


	function cek_is_open_lock($tipe='',$bulan=''){
		$query=$this->db->query("select * from locking where tipe='".$tipe."' and bulan='".$bulan."'");
 		 if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				return $data->status;
 			}
 		}
	}
	function status_locking_is_disetujui($tipe=''){
		$id=$this->input->post('name');
		$id_data_renja="";
		$query=$this->db->query("select id_data_renja from data_template_renja where id='".$id."'");
 		 if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id_data_renja=$row->id_data_renja;
 			}
 		}
		$nama_capaian=$this->input->post('pk');
 		$field='capaian_'.$nama_capaian.'_'.$tipe;
		$query=$this->db->query("select ".$field." from template_renja where id='".$id_data_renja."'");
  		 if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				return $data->$field;
 			}
 		}
	}

	function get_total_program_capaian(){

	}	
	/* GET TOTAL KESELURAN DATA EXISTING */	
	function get_total_program_child($field="",$kode_direktorat_child="",$kode="",$tahun_anggaran=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp from data_template_renja  
	 		a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and parent='".$kode."'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' "); 
	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {						 
					if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
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
	}	 
	function get_total_program_from_target($field="",$kode_direktorat_child="",$tahun_anggaran="",$id_table="",$id_data_renja=""){
		$jumlah=0;
		$total_semua=0;
		$table="";
		$tahun_berlaku=$tahun_anggaran;
		$tahun_anggaran=$this->get_tahun_berlaku($tahun_anggaran);

 		if(($id_table=="") and ($id_table!="undefined")) {
			$id_table=$this->input->post('id');
		}	


		if($id_table=="1"){
           $table="capaian_kinerja_target";
        } else  if($id_table=="2"){
           $table="capaian_keuangan_target";
        } else  if($id_table=="3"){
           $table="capaian_phln_target";
        } else  if($id_table=="4"){
           $table="capaian_dktp_target";
        } else  if($id_table=="5"){
           $table="capaian_lakip_target";
        } else  if($id_table=="6"){
           $table="capaian_renaksi_target";
        }

 	 	/*$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,
	 		bno_rm_d,bno_phln_p,bno_phln_d,pnbp,
	 		(SELECT sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_11+c_12) from ".$table." where kode=a.kode) as total_semua
	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' "); */
		$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,
	 		bno_rm_d,bno_phln_p,bno_phln_d,pnbp,
	 		(SELECT sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_11+c_12) from ".$table." where kode=a.kode and trim(kode_direktorat_child)='".trim($kode_direktorat_child)."' and tahun='".$tahun_berlaku."'	) as total_semua
	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
 		 	and tipe='program'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'"); 
        	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {		 						 						 
						$total_semua=$total_semua+$data->total_semua; 	
					}
				}	

			 if($field=="total_all"){
			 	if($total_semua!=""){	
					return $total_semua;
				}
			}	

		}
	function get_total_program($field="",$kode_direktorat_child="",$tahun_anggaran="",$id_data_renja=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
		$total_semua=0;
		$tahun_anggaran=$tahun_anggaran;
 	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,
	 		bno_rm_d,bno_phln_p,bno_phln_d,pnbp 
 	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and  a.id_data_renja='".$id_data_renja."' and kode!='' "); 
      	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				 
					/* DI LUPAKAN KARENA MERASA BENAR */					/*
					 if ($this->cek_child_anak($data->id_data_renja,$data->kode)) {
   							$total_bo1=$total_bo1+$this->get_total_program_child('bo01',$kode_direktorat_child,$data->kode,$tahun_anggaran);
							$total_bo2=$total_bo2+$this->get_total_program_child('bo02',$kode_direktorat_child,$data->kode,$tahun_anggaran);$total_rm_pusat=$total_rm_pusat+$this->get_total_program_child('bno_rm_p',$kode_direktorat_child,$data->kode,$tahun_anggaran);
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
		function table_komparasi($id="",$table=""){
			$info=$this->get_update($id);
			$tahun_berlaku=$info->id_tahun_anggaran;	
			$id_direktorat=$info->kd_unit_kerja;
			$i=1;
			$total=0;
			$tabelnya="";
			$bulan="";
			$total_jumlah_target=0;
 				$total_jumlah_realisasi=0;
			for($i=1;$i<=12;$i++){
				if(strlen($i)=="1"){
					$i="0".$i;
				}	
				$jumlah_target=0;
				$jumlah_realisasi=0;
				$total_item_jumlah_target=0;
				$total_item_jumlah_realisasi=0;
				$total_ada_realisasi=0;
				$total_ada_target=0;
				$query=$this->db->query("select * from (select 
				(c_".$i.") as jumlah, 
				(select tipe from data_template_renja where kode=a.kode and parent=a.parent  limit 0,1) as tipe
				from ".$table." a
				where a.kode_direktorat_child='".$id_direktorat."' and a.tahun='".$tahun_berlaku."') as mtable ,
				(select count(1) as total_ada_realisasi from ".$table." where tahun='".$tahun_berlaku."' and kode_direktorat_child='".$id_direktorat."') as total_ada_realisasi
				where  tipe='program'");
  	 			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$jumlah_realisasi=$jumlah_realisasi+$data->jumlah;	
						$total_item_jumlah_realisasi++;
						$total_ada_realisasi=$data->total_ada_realisasi;						
					}	
 				}
 				$query2=$this->db->query("select * from (select 
				(c_".$i.") as jumlah, 
				(select tipe from data_template_renja where kode=a.kode and parent=a.parent limit 0,1) as tipe
				from ".$table."_target a
				where a.kode_direktorat_child='".$id_direktorat."' and a.tahun='".$tahun_berlaku."') as mtable,
				(select count(1) as total_ada_target from ".$table."_target where tahun='".$tahun_berlaku."' and kode_direktorat_child='".$id_direktorat."') as total_ada_target
				where  tipe='program'");
   	 			if ($query2->num_rows() > 0) {
					foreach ($query2->result() as $datax) {
						$jumlah_target=$jumlah_target+$datax->jumlah;	
						$total_item_jumlah_target++;	
						$total_ada_target=$datax->total_ada_target;						
					
					}	
 				}
 				/*$jumlah_target=$jumlah_target/$total_item_jumlah_target;
 				$jumlah_realisasi=$jumlah_realisasi/$total_item_jumlah_realisasi;*/

 				$jumlah_target=$jumlah_target;
 				$jumlah_realisasi=$jumlah_realisasi;
 				$total_jumlah_target=$total_jumlah_target+$jumlah_target;
 				$total_jumlah_realisasi=$total_jumlah_realisasi+$jumlah_realisasi;
 				$bulan=$this->get_bulan_name($i);	

 				$label="";
 				$style="";
 				if($jumlah_target > $jumlah_realisasi){
 					$style="background-color:#E74C3C";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-danger btn-sm btn-block'><i class='glyphicon glyphicon-arrow-down'></i></a>";
 				} else if($jumlah_target < $jumlah_realisasi){ 
 					$style="background-color:#31BC86";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-success btn-sm btn-block'><i class='glyphicon glyphicon-arrow-up'></i></a>";
 				} else if($jumlah_target == $jumlah_realisasi){ 
 					$style="background-color:#3498DB";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-info btn-sm btn-block'><i class='glyphicon glyphicon-minus'></i></a>";
 				}  
 				if($table=='capaian_kinerja'){
 					$jumlah_target=$jumlah_target/$total_ada_target;
 					$jumlah_realisasi=$jumlah_realisasi/$total_ada_realisasi;
 				}
				$tabelnya.='<tr>
						    		<td  class="value" style="text-align:left">
						    		<i class="glyphicon glyphicon-calendar"></i> '.$bulan.'</td>	
						    		<td  class="value">'.number_format($jumlah_target).' </td>	
						    		<td  class="value">'.number_format($jumlah_realisasi).'</td>	
						    		<td  style="'.$style.';padding:0px" class="value"  >'.$label.'</td>	
						   </tr>';

			}	
			$label="";
 				if($total_jumlah_target > $total_jumlah_realisasi){
 					$style="background-color:#E74C3C";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-danger btn-sm btn-block'><i class='glyphicon glyphicon-arrow-down'></i></a>";
 				} else if($total_jumlah_target < $total_jumlah_realisasi){ 
 					$style="background-color:#31BC86";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-success  btn-sm btn-block'><i class='glyphicon glyphicon-arrow-up'></i></a>";
 				} else if($total_jumlah_target == $total_jumlah_realisasi){ 
 					$style="background-color:#3498DB";
 					$label="<a style='color:#fff;border-radius:0px' class='btn btn-info  btn-sm btn-block'><i class='glyphicon glyphicon-minus'></i></a>";
 				}  
			$tabelnya.='<tr>
				<thead>
		    		<td  class="header_table" style="text-align:left;font-size:15px">TOTAL</td>	
		    		<td  class="header_table"  style="text-align:center;font-size:15px" id="total_capaian_target_'.$table.'"> Rp. '.number_format($total_jumlah_target).'</td>	
		    		<td  class="header_table"  style="text-align:center;font-size:15px" id="total_capaian_realisasi_'.$table.'"> Rp. '.number_format($total_jumlah_realisasi).'</td>	
		    		<td  class="header_table"   style="text-align:center;font-size:15px;padding:0px;'.$style.'">'.$label.'</td>	
				</thead>
			</tr>';
			return $tabelnya;
		}	
		function get_selisih_all($id="",$table=""){
			$info=$this->get_update($id);
			$tahun_berlaku=$info->id_tahun_anggaran;	
			$id_direktorat=$info->kd_unit_kerja;
			$i=1;
			$total=0;
			$tabelnya="";
			$bulan="";
			$total_jumlah_target=0;
 				$total_jumlah_realisasi=0;
			for($i=1;$i<=12;$i++){
				if(strlen($i)=="1"){
					$i="0".$i;
				}	
				$jumlah_target=0;
				$jumlah_realisasi=0;
				$total_item_jumlah_target=0;
				$total_item_jumlah_realisasi=0;
				

				$query=$this->db->query("select * from (select 
				(c_".$i.") as jumlah, 
				(select tipe from data_template_renja where kode=a.kode and parent=a.parent  limit 0,1) as tipe
				from ".$table." a
				where a.kode_direktorat_child='".$id_direktorat."' and a.tahun='".$tahun_berlaku."') as mtable where  tipe='program'");
  	 			if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$jumlah_realisasi=$jumlah_realisasi+$data->jumlah;	
						$total_item_jumlah_realisasi++;						
					}	
 				}
 				$query2=$this->db->query("select * from (select 
				(c_".$i.") as jumlah, 
				(select tipe from data_template_renja where kode=a.kode and parent=a.parent limit 0,1) as tipe
				from ".$table."_target a
				where a.kode_direktorat_child='".$id_direktorat."' and a.tahun='".$tahun_berlaku."') as mtable where  tipe='program'");
  	 			if ($query2->num_rows() > 0) {
					foreach ($query2->result() as $datax) {
						$jumlah_target=$jumlah_target+$datax->jumlah;	
						$total_item_jumlah_target++;						
					}	
 				}
  
 				$jumlah_target=$jumlah_target;
 				$jumlah_realisasi=$jumlah_realisasi;
 				$total_jumlah_target=$total_jumlah_target+$jumlah_target;
 				$total_jumlah_realisasi=$total_jumlah_realisasi+$jumlah_realisasi;
  				}
		 
				return $total_jumlah_realisasi-$total_jumlah_target;
		}
		function get_bulan_name($i=""){
			if($i=="1"){ $bulan=" JANUARI"; } else
						if($i=="2"){ $bulan=" februari"; } else
						if($i=="3"){ $bulan=" maret"; } else
						if($i=="4"){ $bulan=" april"; } else
						if($i=="5"){ $bulan=" mei"; } else
						if($i=="6"){ $bulan=" juni"; } else
						if($i=="7"){ $bulan=" juli"; } else
						if($i=="8"){ $bulan=" agustus"; } else
						if($i=="9"){ $bulan=" september"; } else
						if($i=="10"){ $bulan=" oktober"; } else
						if($i=="11"){ $bulan=" november"; } else
						if($i=="12"){ $bulan=" desember"; }  
			return strtoupper($bulan);			
		}

		/* AMBIL DATA RENJA */
	function get_data_rekap($id=""){
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
 
						$table.="<td $style_header>
					       		<center>".$kl."</center></td>";
					        
					  
				 		$table.="</tr>";
				 		if ($this->cek_child($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja($id,$data_f->parent);
						}  	 
			  	}		
			} else {
					$table.="<tr>";
						$table.="<td colspan='17'  style='vertical-align:middle;font-size:10px;text-align:right'>
						<center style='float:left;margin-top:10px;margin-left:50%'>Data Kosong</center>";
						$table.="</td>";
		 			$table.="</tr>";
			}

			return $table;
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
						if(strtoupper($data_f->kode)!="OUTPUT"){
 						
						$class_editable="";	
						$class_editablex="";
						$mark=$data_f->mark;
						$ditandai="";
						if($mark=="1") {
							$ditandai="background-color:#F2DEDE !important";
						}	
						$style_header="style='min-width:55px;vertical-align:middle;font-size:10px;vertical-align:middle;".$ditandai."'";
						$table.="<tr>";
						if(($this->session->userdata('ID_DIREKTORAT')==$data_f->dari) and ($data_f->status_perbaikan=="0")){
									$class_editablex=" class='xeditable' ";
						}

						$kode="<a style='font-size:10px;text-align:center;cursor:pointer;'  
							        id='".$data_f->id."|kode'  ".$class_editablex."  id='kode' data-type='text' 
							        data-placement='right' data-id='kode' 
							        data-title='Masukan Nilai Baru'>
							        <center>".strtoupper(trim(($data_f->kode)))."</center></a>";
						if($data_f->tipe=="indikator"){
 							$table.="<td $style_header class='indikator'>
							<div style='height:10px;width:10px;background-color:#2C802C'></div></td>";
							$table.="<td $style_header><center> <b>".($kode)."</b></center></td>";
							$table.="<td colspan='2' $style_header > ".($data_f->indikator)."</td>";
							$class_editable="";
						} else if($data_f->tipe=="komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;;width:10px;background-color:#31BC86'></div></td>";
							$table.="<td $style_header><b><center> ".$kode."</b></center></td>";
							$table.="<td $style_header> ".($data_f->komponen_input)." </td>";
						}	else if($data_f->tipe=="sub_komponen_input"){
 							$table.="<td $style_header></td>";
							$table.="<td $style_header><div style='height:10px;width:10px;background-color:#BED446;float:right;margin-right:10px'></div></td>";
							$table.="<td $style_header><center> <b> ".$kode." </b></center></td>";
							$table.="<td $style_header> ".($data_f->komponen_input)." </td>";
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
							$table.="<td $style_header  class='".$is_indikator."_kl'> 
									<center>".$kl."</center></td>";	

 		 					$table.="</tr>";	

			 			if ($this->cek_child_anak($id,$data_f->parent)) {
							$table.=$this->get_child_data_renja($id,trim($data_f->kode));
						}
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
		function get_kewenangan($limit='',$offset=''){     		 
			$query=$this->db->query("select * from kewenangan where mark_as_kewenangan='1' order by nama_kewenangan ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
    	}
    	function get_update_from_data_template_renja($id){
    		$query=$this->db->query("select * from data_template_renja a     	 
			where a.id='$id'"); 
			return 	$query->row();
    	}
    	function get_download_dokumen($id=""){
    		$query=$this->db->query("select * from dokumen_capaian a     	 
			where a.id='$id'"); 
			return 	$query->row();
    	}
    	function get_detail_dokumen($id=""){
 	  		$info=$this->get_update_from_data_template_renja(($id));
    		$query=$this->db->query("select id,tahun_berlaku as tahun_anggaran,nama_dokumen    	 
    		from dokumen_capaian a   
    	 	where a.parent='".$info->parent."' and a.kode='".$info->kode."' and a.kode_direktorat_child='".$info->kode_direktorat_child."'  and a.tahun_berlaku='".$info->tahun_berlaku."' order by id desc");
  			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
    	}
    	function update_upload($userfile_name,$nama_asli){
    		$id=$this->input->post('id');
	  		$info=$this->get_update_from_data_template_renja(($id));
	  		 
			$data=array(
		 	 'kode_direktorat_child'=>$info->kode_direktorat_child,
			 'kode'=>$info->kode,
			 'parent'=>$info->parent,
			 'url'=>$nama_asli,
			 'nama_dokumen'=>$userfile_name,
			 'tahun_berlaku'=>$info->tahun_berlaku,

			);
			$this->db->trans_start();
			$this->db->insert('dokumen_capaian',$data);
			$this->db->trans_complete(); 		 
    	}     
    	function hapus_detail_dokumen($id=""){
   		if($this->db->query("delete from dokumen_capaian where id='$id'")){ 			 
 		} else {
			echo"GAGAL MENYIMPAN KARENA SESUATUNYA SYAHRINI";
		}	
    	}
	}
?>
