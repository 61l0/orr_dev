<?php
class notifikasi_model extends CI_Model{ 

	function notifikasi_model()
	{
		parent::__construct();
	}
	function get_status_persetujuan_renja(){
		$tahun=0;
		$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and a.dari='".$dari."'";
     		} else {
     			$sql="";
     		}     

			$query=$this->db->query("select id from tahun_anggaran where tahun_anggaran ='".date("Y")."' ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$tahun=$data->id;
				}
 			}

			$query=$this->db->query("select  
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari,a.tanggal,a.jam
			 from template_renja a    where 1=1  $sql and tahun_anggaran='".$tahun."' and status_perbaikan='0' ");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	function get_status_persetujuan_capaian(){
		$tahun=0;
		$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and a.dari='".$dari."'";
     		} else {
     			$sql="";
     		}     
			$query=$this->db->query("select id from tahun_anggaran where tahun_anggaran ='".date("Y")."' ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$tahun=$data->id;
				}
 			}

			$query=$this->db->query("select  * ,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari,a.tanggal,a.jam
			 from template_renja a    where  1=1   $sql  and tahun_anggaran='".$tahun."' 
			 and capaian_kinerja_target='0' and
			 capaian_kinerja_target='0' and
	 		 capaian_dktp_realisasi='0' and
			 capaian_dktp_target='0' and
			 capaian_keuangan_realisasi='0' and
			 capaian_keuangan_target='0' and
			 capaian_kinerja_realisasi='0' and
	 		 capaian_phln_realisasi='0' and
			 capaian_phln_target='0' and
			 capaian_renaksi_realisasi='0' and
			 capaian_renaksi_target='0'
			   
			 ");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	function get_status_keterisian_capaian($table=""){
		$tahun="";
		$tahun=0;
		$status_user=$this->session->userdata('STATUS');
     		$sql="";
     		$dari=$this->session->userdata('ID_DIREKTORAT');
     		$tujuan=$this->session->userdata('ID_DIREKTORAT');
     		if($status_user=="1"){
     			$sql=" and a.dari='".$dari."'";
     		} else {
     			$sql="";
     		}     
			$query=$this->db->query("select id from tahun_anggaran where tahun_anggaran ='".date("Y")."' ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$tahun=$data->id;
				}
 			}
		$query=$this->db->query("select id from tahun_anggaran where tahun_anggaran ='".date("Y")."' ");
		 if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$tahun=$data->id;
			}
		}
		$bulan=date("m");
		$jumlah=0;
  		$query=$this->db->query("select  
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari,a.tanggal,a.jam,
			(select SUM(c_".$bulan.") from ".$table." where kode_direktorat_child=m_unit_kerja.kd_unit_kerja and tahun='".$tahun."') as jumlah
			from template_renja a    
			left join m_unit_kerja on m_unit_kerja.id_divisi=a.dari
			where 1=1 $sql	 and tahun_anggaran='".$tahun."' and ( ((select SUM(c_".$bulan.") from ".$table." where kode_direktorat_child=m_unit_kerja.kd_unit_kerja and tahun='".$tahun."') ='0') or( (select SUM(c_".$bulan.") from ".$table." where kode_direktorat_child=m_unit_kerja.kd_unit_kerja and tahun='".$tahun."') IS NULL))");
     			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {	
						 		 
						   $datac[]=$data;
						   
 					}
 					return $datac; 
 			}
 			
	}
	function detail_status_pengiriman(){
		$menus='';
			$id_direktorat=$this->session->userdata('ID_DIREKTORAT');	
			$status_user=$this->session->userdata('STATUS');	 
			$addTag="";
			if($status_user=="1"){
     			$sql=" and  a.status='upload'";
     		} else {
     			$sql=" and  a.status='download'";
     		}

			$query=$this->db->query("select *,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from upload a 
			left join t_user on t_user.id=a.add_by 
			where 1=1 and a.status_baca='1' $sql order by a.id desc ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	function detail_status_pengiriman_acuan(){
		$menus='';
			$id_direktorat=$this->session->userdata('ID_DIREKTORAT');	
			$status_user=$this->session->userdata('STATUS');	 
			$addTag="";
			if($status_user=="1"){
     			$sql=" and  a.status='upload'";
     		} else {
     			$sql=" and  a.status='download'";
     		}

			$query=$this->db->query("select *,a.id as id,t_user.nama as nama_user,
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
			(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
			from template_renja a 
			left join t_user on t_user.id=a.add_by 
			where 1=1 and a.status_acuan='1' $sql order by a.id desc ");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
			}
	}
	 
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>