<?php
class pengingat_model extends CI_Model{ 

	function pengingat_model()
	{
		parent::__construct();
	}
	function get_direktorat(){	
		$tahun=date("Y");	
		$qt=$this->db->query("select id from tahun_anggaran where tahun_anggaran='".date("Y")."'");
			 if ($qt->num_rows() > 0) {
				foreach ($qt->result() as $data) {
					$tahun=$data->id;
				}
 		}
		$query=$this->db->query("select *,
				(select count(1) from template_renja where dari=a.id_divisi and tahun_anggaran='".$tahun."') as tersedia ,
				(select status_perbaikan from template_renja where dari=a.id_divisi and tahun_anggaran='".$tahun."') as status_perbaikan  				
 				from m_unit_kerja a");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
		}
	}
	function get_capaian(){
		$tahun=date("Y");	
		$qt=$this->db->query("select id from tahun_anggaran where tahun_anggaran='".date("Y")."'");
			 if ($qt->num_rows() > 0) {
				foreach ($qt->result() as $data) {
					$tahun=$data->id;
				}
 		}
		$query=$this->db->query("select * from template_renja a
			 left join m_unit_kerja on m_unit_kerja.id_divisi=a.dari
			 where tahun_anggaran='".$tahun."'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$datac[]=$data;
				}
				return $datac;
		}
	}
	function send_mail(){
		$message="";
		$j=0;
		$id=$this->input->post('id_direktorat');
		$query=$this->db->query("select * from t_user where unit='".$id."'");
  		 if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					if(!empty($row->email)){

		 				$to_email=$row->email;
						$subject=$this->input->post('subject');
						$pesan=$this->input->post('pesan');
						$this->load->library('email');
					    $this->email->from('biskemendagri@gmail.com', 'Administrator Ditjen Bina Pembangunan Daerah');
					    $this->email->to($to_email);	 
					    $this->email->subject($subject);
					    $this->email->message($pesan);
						$this->email->send(); 
						$data=array(	 	 
				 		 'to_email'=>$to_email,
						 'pesan'=>$pesan,
						 'tanggal'=>date("Y-m-d")
						);
						 
						$this->db->trans_start();
						$this->db->insert('hist_kirim_email',$data);
						$this->db->trans_complete(); 
						$message.="<span style='font-size:14px'><i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Mengirim Email Kepada ".($row->nama).' : <b>'.$row->email.'</b></span><br>';
						$j++;
					}	
			}
 		} if($j=="0") {
						$message.="<span style='font-size:14px'><i style='color:#E74C3C' class='glyphicon glyphicon-remove-sign'></i> Data Email Tidak Tersedia </span><br> ";
 		}
		echo $message;
	}	
	function get_bulan($id=""){
		$bulan="";
		if($id=="1"){
			$bulan="January";
		} else if($id=="2"){
			$bulan="February";
		} else if($id=="3"){
			$bulan="Maret";
		} else if($id=="4"){
			$bulan="April";
		} else if($id=="5"){
			$bulan="Mei";
		} else if($id=="6"){
			$bulan="Juni";
		} else if($id=="7"){
			$bulan="Juli";
		} else if($id=="8"){
			$bulan="Agustus";
		} else if($id=="9"){
			$bulan="September";
		} else if($id=="10"){
			$bulan="Oktober";
		} else if($id=="11"){
			$bulan="November";
		} else if($id=="12"){
			$bulan="Desember";
		} 
		return $bulan;
	}
	function get_email($id=""){
		$datac="";
		$table="<table>";
		$query=$this->db->query("select * from t_user where unit='".$id."'");
 			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$email=$data->email ? $data->email : "-";	
					$table.="<tr>";
					$table.="<td>";
					$table.="<i class='glyphicon glyphicon-envelope'></i> ". strtoupper($data->nama);
					
					$table.="</td>";
					$table.="<td> &nbsp; : &nbsp; </td>";
					$table.="<td>";
					$table.=$email;
					
					$table.="</td>";
					$table.="</tr>";
				}
			
		}
		$table.="</table>";
		return $table;
	}
	function get_table_table($id_table="",$tipe_capaian=""){
 		$tipe_tabel="";
		if($tipe_capaian=='target'){
			$tipe_tabel="_target";
		}
		if($id_table=="1"){
			$table="capaian_kinerja".$tipe_tabel;
		} else if($id_table=="2"){
			$table="capaian_keuangan".$tipe_tabel;
		} else if($id_table=="3"){
			$table="capaian_phln".$tipe_tabel;
		} else if($id_table=="4"){
			$table="capaian_dktp".$tipe_tabel;
		} else if($id_table=="5"){
			$table="capaian_lakip".$tipe_tabel;
		} else if($id_table=="6"){
			$table="capaian_renaksi".$tipe_tabel;
		}
		$tahun=date("Y");	
		$qt=$this->db->query("select id from tahun_anggaran where tahun_anggaran='".date("Y")."'");
			 if ($qt->num_rows() > 0) {
				foreach ($qt->result() as $data) {
					$tahun=$data->id;
				}
 		}
		$query=$this->db->query("select *,
				(select count(1) from template_renja where dari=a.id_divisi and tahun_anggaran='".$tahun."') as tersedia,
				(select SUM(c_01) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_01',
				(select SUM(c_02) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_02',
				(select SUM(c_03) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_03',
				(select SUM(c_04) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_04',
				(select SUM(c_05) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_05',
				(select SUM(c_06) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_06',
				(select SUM(c_07) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_07',
				(select SUM(c_08) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_08',
				(select SUM(c_09) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_09',
				(select SUM(c_10) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_10',
				(select SUM(c_11) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_11',
				(select SUM(c_12) from ".$table." where kode_direktorat_child=a.kd_unit_kerja and tahun='".$tahun."') as 'c_12'
				from m_unit_kerja a
				");
 				if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
 					$datac[]=$data;
 				}
 				return $datac;
 		}
	}
}
?>