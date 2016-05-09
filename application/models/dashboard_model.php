<?php
class dashboard_model extends CI_Model{ 

	function dashboard_model()
	{
		parent::__construct();
	}
	function belanja_operasional(){
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
	 /*
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp from data_template_renja  a			 
			where 
			(a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($datenow)."'  and kode!='' ");
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
		
		$series.="{ name: '001', y: ".$total_bo1." },"; 
		$series.="{ name: '002', y: ".$total_bo2." },"; 
		$series.="{ name: 'RM_PUSAT', y: ".$total_rm_pusat." },"; 
		$series.="{ name: 'RM_DAERAH', y: ".$total_rm_daerah." },"; 
		$series.="{ name: 'RM_DAERAH', y: ".$total_phln_pusat." },"; 
		$series.="{ name: 'PHLN_DAERAH', y: ".$total_phln_daerah." },"; 
		$series.="{ name: 'PNBP', y: ".$total_pnbp." },"; */
		$total=0;
		$total_dana=0;
		 
		$query=$this->db->query("select kode_direktorat,m_unit_kerja.nama_unit_kerja from data_template_renja
		LEFT JOIN m_unit_kerja on m_unit_kerja.kd_unit_kerja=data_template_renja.kode_direktorat
		where kode_direktorat !=''  and m_unit_kerja.nama_unit_kerja!=''  group by kode_direktorat");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$jumlah=0;
				$jumlah=$this->get_detail_kegiatan_dit($data->kode_direktorat);
				$total=$total+$jumlah;
				$jumlah_dana=$this->get_total_program($data->kode_direktorat,date("Y"));			
				$total_dana=$total_dana+$jumlah_dana;	
			 
				 	$series.="{ name: '".$data->nama_unit_kerja."', y:  ".$jumlah_dana."  },"; 
 
			}
		}
 
		return $series;
	}
	function capaian(){
		$select="";
		$select.="<select id='nama_capaian' onchange='return capaian_se_bangda_sob()' class='form-control'  name='nama_capaian'>";
	 		$select.="<option  value='1'>CAPAIAN KINERJA</option>";
	 		$select.="<option  value='2'>CAPAIAN KEUANGAN</option>";
	  

		$select.="</select>";
		return $select;
	}
	function capaian_se_bangda_sob(){
		$c_01=0;$c_02=0;$c_03=0;$c_04=0;$c_05=0;$c_06=0;$c_07=0;
		$c_08=0;$c_09=0;$c_10=0;$c_11=0;$c_12=0;
		$total=0;
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
		$tahun_berlaku=date("Y");
		if(date("Y")=="2016"){
			$tahun_berlaku="2";
		} else if(date("Y")=="2017"){
			$tahun_berlaku="3";
		} if(date("Y")=="2018"){
			$tahun_berlaku="4";
		} if(date("Y")=="2019"){
			$tahun_berlaku="5";
		}
		$id_capaian=$this->input->post('id_capaian');
		$table_capaian="";
		$target="";
		if($id_capaian=="1"){
		   $target="kinerja";	
           $table_capaian="capaian_kinerja";
        } else  if($id_capaian=="2"){
		   $target="keuangan";	
           $table_capaian="capaian_keuangan";
        } else  if($id_capaian=="3"){
           $table_capaian="capaian_phln";
        } else  if($id_capaian=="4"){
           $table_capaian="capaian_dktp";
        } else  if($id_capaian=="5"){
           $table_capaian="capaian_lakip";
        } else  if($id_capaian=="6"){
           $table_capaian="capaian_renaksi";
		}  else  if($id_capaian=="1"){
           $table_capaian="capaian_kinerja";
		}
		$query=$this->db->query("select 
		sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
		from ".$table_capaian." where  tahun='".$tahun_berlaku."' ");

			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					 $total_realisasi=$data->jumlah;
				}			 	 
			}

  		/*$query=$this->db->query("select 
				sum(c_01+c_02+c_03+c_04+c_05+c_06+c_07+c_08+c_09+c_10+c_11+c_12) as jumlah
				from ".$table_capaian."_target where  tahun='".$tahun_berlaku."' and ( kode='' or kode IS NULL)");
					 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							 $total_target=$data->jumlah;
						}			 	 
				}
		*/
			$query=$this->db->query("select 
				sum(target_".$target.") as jumlah
				from data_template_renja where  tahun_berlaku='".date("Y")."'");
					 if ($query->num_rows() > 0) {
						foreach ($query->result() as $data) {
							 $total_target=$data->jumlah;
						}			 	 
				}
			$yg_sudah=$total_realisasi;
			$yg_belum=$total_target;
			
			if(($yg_belum=="") or ($yg_sudah=="")){
				echo "<center><h3>DATA TIDAK DITEMUKAN</h3></center>";
				return false;
			}
			
			if(($yg_belum!="") and ($yg_sudah=="")){
				$yg_sudah=0;
			} else if(($yg_belum=="") and ($yg_sudah!="")){
				$yg_belum=0;
			}

			$series="{
	               name: 'Sudah',
	                y: ".($yg_sudah)."
	            },{
	               name: 'Belum',
	                y: ".($yg_belum -$yg_sudah)."
	            }"; 
	         return $series;
	}
	function isletter($char=""){
		/*if (preg_match('/[a-zA-Z]/', $char)) :
		    return $char.' is a letter<br>';
		endif;*/
		$char=substr($char, 0,1);
		if(is_numeric($char)){
			return '0';
		}
	}
	function belanja_operasional_direktorat(){
			$series='';
			$datenow=date("Y");
			$query=$this->db->query("select * from  m_unit_kerja order by kd_unit_kerja asc");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {					 
						 $series.="{ name: '".$data->nama_unit_kerja."', data: [".$this->get_total_belanja_operasional_direktorat($data->kd_unit_kerja)."] },"; 
					 
				}
			}
			return $series;
	}
	function get_total_belanja_operasional_direktorat($kode_direktorat=""){
		$datenow=date("Y");
		$total=0;
		$field=$this->input->post('kode');

		if($field=="001"){
				$field="bo01";
			}elseif($field=="002"){
				$field="bo02";
			}elseif($field=="RM_PUSAT"){
				$field="bno_rm_p";
			}elseif($field=="RM_DAERAH"){
				$field="bno_rm_d";
			}elseif($field=="PHLN_PUSAT"){
				$field="bno_phln_p";
			}elseif($field=="PHLN_DAERAH"){
				$field="bno_phln_d";
			}elseif($field=="PNBP"){
				$field="pnbp";
			}
 
		$query=$this->db->query("	select  sum(".$field.") as jumlah from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".($datenow)."'  and kode!='' "); 	
 			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {				 
						$total=$total+$data->jumlah;				 
				}
			}
		return $total;
	}
	function belanja_non_operasional(){
		$series='';
		$bulan='';
		$datenow=date("Y");
 		$total_rm_pusat=0;
 		$total_rm_daerah=0;
 		$total_phln_pusat=0;
 		$total_phln_daerah=0;
 		$total_pnbp=0;
		$j=1;
		 $total_bo1=0;
 		$total_bo2=0;
	 	$query=$this->db->query("
	 		select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp from data_template_renja  a			 
			where 
			(a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($datenow)."'  and kode!='' ");
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
		$series.="{ name: '001', data: [".$total_bo1."] },"; 
		$series.="{ name: '002', data: [".$total_bo2."] },"; 
		$series.="{ name: 'RM_PUSAT', data: [".$total_rm_pusat."] },"; 
		$series.="{ name: 'RM_DAERAH', data: [".$total_rm_daerah."] },"; 
	    $series.="{ name: 'PHLN_PUSAT', data: [".$total_phln_pusat."] },"; 
		$series.="{ name: 'PHLN_DAERAH', data: [".$total_phln_daerah."] },"; 
		$series.="{ name: 'PNBP', data: [".$total_pnbp."] },"; 

		return $series;
	}
	function get_detail_kegiatan_dit($kode_direktorat="",$tipe=""){
		$jumlah=0;
		$tahun_anggaran=date("Y");
		$total_bo1=0;
 		$total_bo2=0;
		$total_rm_pusat=0;
 		$total_rm_daerah=0;
 		$total_phln_pusat=0;
 		$total_phln_daerah=0;
 		$total_pnbp=0;
 		$jumlah=0;
		$query=$this->db->query("select * from data_template_renja  a			 
			where a.tahun_berlaku like '%".$tahun_anggaran."%' and a.kode_direktorat_child like'%".$kode_direktorat."%'	
			and a.tipe='komponen_input' and a.kode!='OUTPUT'");	 
  			if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				 $jumlah=$jumlah+1;
			}
		}
		return $jumlah;	 
	}
	function get_total_program($kode_direktorat_child="",$tahun_anggaran=""){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
		$total_semua=0;
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp 
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
 		$total_semua=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
 		return $total_semua;
	}	
	function get_kegiatan_dit(){
		$total=0;
			$total_dana=0;
		$table="<table class='table multimedia table-striped table-hover table-bordered'>";
		 $table.="<tr>";
				 	$table.="<th><h4>Direktorat</h4></th>";
  				 	$table.="<th><h4>Jumlah Kegiatan</h4></th>";
  				 	$table.="<th><h4>Total Anggaran</h4></th>";
		 $table.="</tr>";
		$query=$this->db->query("select kode_direktorat,m_unit_kerja.nama_unit_kerja from data_template_renja
		LEFT JOIN m_unit_kerja on m_unit_kerja.kd_unit_kerja=data_template_renja.kode_direktorat
		where kode_direktorat !='' and m_unit_kerja.nama_unit_kerja!='' group by kode_direktorat");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$jumlah=0;
				$jumlah=$this->get_detail_kegiatan_dit($data->kode_direktorat);
				$total=$total+$jumlah;
				$jumlah_dana=$this->get_total_program($data->kode_direktorat,date("Y"));			
				$total_dana=$total_dana+$jumlah_dana;				
				 $table.="<tr>";
				 	$table.="<td><h5  style='margin:5px'><i class='glyphicon glyphicon-folder-open icon-white'></i> &nbsp;".$data->nama_unit_kerja."</h5></td>";
  				 	$table.="<td><h5 style='margin:5px'>".$jumlah." - Kegiatan</h5></td>";
  				 	$table.="<td><h5 style='margin:5px'>Rp. ".number_format($jumlah_dana)."</h5></td>";
				 $table.="</tr>";
			}
		}
		 $table.="<tr>";
				 	$table.="<td><h5  style='margin:5px'><b>TOTAL </b></td>";
  				 	$table.="<td><h5 style='margin:5px'><b>".$total." - Kegiatan</b><br><br></td>";
  				 	$table.="<td><h5 style='margin:5px'><b>Rp. ".number_format($total_dana)."</b><br><br></td>";
				 $table.="</tr>";
		$table.="</table>";
		echo $table;
	}
	function get_total_program_2($field="",$kode_direktorat_child="",$tahun_anggaran=""){
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
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' and UPPER(kode)!='OUTPUT'"); 
  			//echo $this->db->last_query().';<br>';	
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
	function belanja_operasional_list($id=""){
		$series='';
		$total_bo1_a='0';
		$total_bo2_a='0';
		$datenow=date("Y");
 		$list="";
 		$j=1;
	 	$table="<table class='table multimedia table-striped table-hover table-bordered'>";
	 	$table.="<thead>";
	 	$table.="<tr>";
				$table.="<th>DIREKTORAT</th>";
				$table.="<th>001</th>";
				$table.="<th>002</th>";
		$table.="</tr>";	
	 	$table.="</thead>";
	 	$table.="<tbody>";
	 	$query=$this->db->query("select *  from m_unit_kerja a
 	 	  order by a.kd_unit_kerja asc"); 
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {				 
					$table.="<tr>";
					$total_bo1=$this->get_total_program_2('bo01',$data->kd_unit_kerja,$datenow);
					$total_bo2=$this->get_total_program_2('bo02',$data->kd_unit_kerja,$datenow);
					$total_bo1_a=$total_bo1_a+$total_bo1;
					$total_bo2_a=$total_bo2_a+$total_bo2;					
							$table.="<td>" .$data->nama_unit_kerja. "</td>";
							$table.="<td style='vertical-align:middle'>" .number_format($total_bo1). "</td>";
							$table.="<td style='vertical-align:middle'>" .number_format($total_bo2). "</td>";
					$table.="</tr>";
 				 
			}
		}
		$table.="<tr>";
				$table.="<th>TOTAL</th>";
				$table.="<th>".number_format($total_bo1_a)."</th>";
				$table.="<th>".number_format($total_bo2_a)."</th>";
		$table.="</tr>";	
	 	$table.="<tbody>";
		$table.="</table>";
		echo $table;
	}
	 
	function get_total_kegiatan_prioritas($field="",$kode_direktorat_child="",$tahun_anggaran=""){
		$jumlah=0;
		$field=strtolower($field);
	 	$query=$this->db->query("select count(1) as jumlah from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='indikator'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' and UPPER(kode)!='OUTPUT' and kl='".$field."'"); 
  	 		if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {					 
					$jumlah=$data->jumlah; 					 
			}
			return $jumlah;
		}	 
 	}
 	function get_total_total_duit_kegiatan_kl($kode_direktorat_child="",$tahun_anggaran="",$filter=''){
		$jumlah=0;
		$total_bo1=0;
		$total_bo2=0;
		$total_rm_pusat=0;
		$total_rm_daerah=0;
		$total_phln_pusat=0;
		$total_phln_daerah=0;
		$total_pnbp=0;	  
		$total_semua=0;
	 	$query=$this->db->query("select id_data_renja,kode,bo01,bo02,bno_rm_p,bno_rm_d,bno_phln_p,bno_phln_d,pnbp 
	 		from data_template_renja  a			 
			where trim(a.kode_direktorat_child)='".trim($kode_direktorat_child)."'	
			and (a.kode_direktorat='' or a.kode_direktorat IS NULL)
		 	and tipe='komponen_input'	
 			and trim(a.tahun_berlaku)='".trim($tahun_anggaran)."'  and kode!='' and UPPER(kode)!='OUTPUT' and kl='".$filter."'"); 
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
 		$total_semua=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
 		return $total_semua;
	}
	function kegiatan_prioritas($id=""){
		$datenow=date("Y");
 		$jumlah_dana_kl=0;
		$jumlah_dana_qw=0;
		$jumlah_dana_pl=0;

 		$total_jumlah_dana_kl=0;
		$total_jumlah_dana_qw=0;
		$total_jumlah_dana_pl=0;
		
		$table="<table class='table multimedia table-striped table-hover table-bordered'>";
	 	$table.="<thead>";
	 	$table.="<tr>";
				$table.="<th></th>";
				$table.="<th colspan='2'><center>KL </center></th>";
 				$table.="<th colspan='2'><center>AP (QW)</center></th>";
 				$table.="<th colspan='2'><center>AP (PL)</center></th>";
 		$table.="</tr>";	
	 	$table.="<tr>";
				$table.="<th></th>";
				$table.="<th><center>Kegiatan</center></th>";
 				$table.="<th><center>Dana</center></th>";
 				$table.="<th><center>Kegiatan</center></th>";
				$table.="<th><center>Dana</center></th>";
 				$table.="<th><center>Kegiatan</center></th>";
 				$table.="<th><center>Dana</center></th>";
 		$table.="</tr>";	
	 	$table.="</thead>";
	 	$table.="<tbody>";
	 	$query=$this->db->query("select *  from m_unit_kerja a
 	 	  order by a.kd_unit_kerja asc");
	 	$total_kl=0;
	 	$total_qw=0;
	 	$total_pl=0;
	 	if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
					$total_all_samping=0;
	 	
					$KL=$this->get_total_kegiatan_prioritas('KL',$data->kd_unit_kerja,$datenow);
					$QW=$this->get_total_kegiatan_prioritas('QW',$data->kd_unit_kerja,$datenow);
					$PL=$this->get_total_kegiatan_prioritas('PL',$data->kd_unit_kerja,$datenow);
					$total_kl=$total_kl+$KL;
					$total_qw=$total_qw+$QW;
					$total_pl=$total_pl+$PL;
					$jumlah_dana_kl=$this->get_total_total_duit_kegiatan_kl($data->kd_unit_kerja,date("Y"),'KL');	
					$jumlah_dana_qw=$this->get_total_total_duit_kegiatan_kl($data->kd_unit_kerja,date("Y"),'QW');	
					$jumlah_dana_pl=$this->get_total_total_duit_kegiatan_kl($data->kd_unit_kerja,date("Y"),'PL');	
 					$table.="<tr>";
							$table.="<td><b>" . $data->nama_unit_kerja. "</b></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($KL)). "</center></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($jumlah_dana_kl)). "</center></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($QW)). "</center></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($jumlah_dana_qw)). "</center></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($PL)). "</center></td>";
							$table.="<td style='vertical-align:middle'><center>" . number_format(($jumlah_dana_pl)). "</center></td>";
 					$table.="</tr>";					 
 					 		$total_jumlah_dana_kl=$total_jumlah_dana_kl+$jumlah_dana_kl;
							$total_jumlah_dana_qw=$total_jumlah_dana_qw+$jumlah_dana_qw;
							$total_jumlah_dana_pl=$total_jumlah_dana_pl+$jumlah_dana_pl;

			}
		}
		$table.="<tr>";
				$table.="<th>TOTAL</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center class='badge'>".number_format($total_kl)."</center></th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center>".number_format($total_jumlah_dana_kl)."</center></th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center class='badge'>".number_format($total_qw)."</center></th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center>".number_format($total_jumlah_dana_qw)."</center></th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center class='badge'>".number_format($total_pl)."</center></th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff;text-align:center'><center>".number_format($total_jumlah_dana_pl)."</center></th>";
		$table.="</tr>";	
	 	$table.="<tbody>";
		$table.="</table>";
		echo $table;
	}
	function belanja_non_operasional_list($id=""){
		$series='';
		$total_bo01_a='0';
		$total_bo02_a='0';
		$total_rm_p_a='0';
		$total_rm_d_a='0';
		$total_phln_p_a='0';
		$total_phln_d_a='0';
		$total_pnbp_a='0';
		$datenow=date("Y");
 		$list="";
 		$j=1;
	 	$table="<table class='table multimedia table-striped table-hover table-bordered'>";
	 	$table.="<thead>";
	 	$table.="<tr>";
				$table.="<th></th>";
				$table.="<th>001</th>";
				$table.="<th>002</th>";
				$table.="<th><center>RM <br> PUSAT</center></th>";
				$table.="<th><center>RM <br> DAERAH</center></th>";
				$table.="<th><center>PHLN <br> PUSAT</center></th>";
				$table.="<th><center>PHLN<br> DAERAH</center></th>";
				$table.="<th>PNBP</th>";
				$table.="<th>TOTAL</th>";
		$table.="</tr>";	
	 	$table.="</thead>";
	 	$table.="<tbody>";
	 	$query=$this->db->query("select *  from m_unit_kerja a
 	 	  order by a.kd_unit_kerja asc");
	 	$total_all=0;
	 	$total_all_samping=0;
	 	if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
					$total_all_samping=0;
	 				$total_pnbp=0;
	 				$total_pnbp_a=0;
					$total_bo01=$this->get_total_program_2('bo01',$data->kd_unit_kerja,$datenow);
					$total_bo02=$this->get_total_program_2('bo02',$data->kd_unit_kerja,$datenow);
					$total_bno_rm_p=$this->get_total_program_2('bno_rm_p',$data->kd_unit_kerja,$datenow);
					$total_bno_rm_d=$this->get_total_program_2('bno_rm_d',$data->kd_unit_kerja,$datenow);
					$total_bno_phln_p=$this->get_total_program_2('bno_phln_p',$data->kd_unit_kerja,$datenow);
					$total_bno_phln_d=$this->get_total_program_2('bno_phln_d',$data->kd_unit_kerja,$datenow);
					$total_pnbp=$this->get_total_program_2('pnbp',$data->kd_unit_kerja,$datenow);
					$total_all_samping=$total_bo01+$total_bo02+$total_bno_rm_p+$total_bno_rm_d+$total_bno_phln_p+$total_bno_phln_d+$total_pnbp;

					$total_bo01_a=$total_bo01_a+$total_bo01;
					$total_bo02_a=$total_bo02_a+$total_bo02;
					$total_rm_p_a=$total_rm_p_a+$total_bno_rm_p;
					$total_rm_d_a=$total_rm_d_a+$total_bno_rm_d;
					$total_phln_p_a=$total_phln_p_a+$total_bno_phln_p;
					$total_phln_d_a=$total_phln_d_a+$total_bno_phln_d;
					$total_pnbp_a=$total_pnbp_a+$total_pnbp;
 					$total_all=$total_all+$total_all_samping;
 					$table.="<tr>";
							$table.="<td><b>" . $data->nama_unit_kerja. "</b></td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bo01)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bo02)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_rm_p)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_rm_d)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_phln_p)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_phln_d)). "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_pnbp)). "</td>";
							$table.="<td style='vertical-align:middle;padding:0px;background-color:#E74C3C'><a style='color:#fff' 
							class='btn-block btn-sm btn btn-danger'>" . number_format(($total_all_samping)). "</a></td>";
					$table.="</tr>";	 				 
					}
		}
		$table.="<tr>";
				$table.="<th>TOTAL</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_bo01_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_bo02_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_rm_p_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_rm_d_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_phln_p_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_phln_d_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_pnbp_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_all)."</th>";
		$table.="</tr>";	
	 	$table.="<tbody>";
		$table.="</table>";
		echo $table;
	}
	 function belanja_non_operasional_list_group($id=""){
		$series='';
		$total_bo01_a='0';
		$total_bo02_a='0';
		$total_rm_p_a='0';
		$total_rm_d_a='0';
		$total_phln_p_a='0';
		$total_phln_d_a='0';
		$total_pnbp_a='0';
		$datenow=date("Y");
 		$list="";
 		$j=1;
	 	$table="<table class='table multimedia table-striped table-hover table-bordered'>";
	 	$table.="<thead>";
	 	$table.="<tr>";
				$table.="<th></th>";
				$table.="<th style='vertical-align:middle'><center>BELANJA <br> OPERASIONAL</center></th>";
 				$table.="<th  style='vertical-align:middle'><center>RUPIAH  MURNI <br> PUSAT + DAERAH </center></th>";
				$table.="<th  style='vertical-align:middle'><center>PHLN <br>PUSAT + DAERAH</center> </th>";
				$table.="<th  style='vertical-align:middle'><center>PNBP</center></th>";		 
				$table.="<th  style='vertical-align:middle'><center>TOTAL</center></th>";
		$table.="</tr>";	
	 	$table.="</thead>";
	 	$table.="<tbody>";
	 	$query=$this->db->query("select *  from m_unit_kerja a
 	 	  order by a.kd_unit_kerja asc");
	 	$total_all=0;
	 	$total_all_samping=0;
	 	if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
					$total_all_samping=0;
	 	
					$total_bo01=$this->get_total_program_2('bo01',$data->kd_unit_kerja,$datenow);
					$total_bo02=$this->get_total_program_2('bo02',$data->kd_unit_kerja,$datenow);
					$total_bno_rm_p=$this->get_total_program_2('bno_rm_p',$data->kd_unit_kerja,$datenow);
					$total_bno_rm_d=$this->get_total_program_2('bno_rm_d',$data->kd_unit_kerja,$datenow);
					$total_bno_phln_p=$this->get_total_program_2('bno_phln_p',$data->kd_unit_kerja,$datenow);
					$total_bno_phln_d=$this->get_total_program_2('bno_phln_d',$data->kd_unit_kerja,$datenow);
					$total_pnbp=$this->get_total_program_2('pnbp',$data->kd_unit_kerja,$datenow);
					$total_all_samping=$total_bo01+$total_bo02+$total_bno_rm_p+$total_bno_rm_d+$total_bno_phln_p+$total_bno_phln_d+$total_pnbp;

					$total_bo01_a=$total_bo01_a+$total_bo01;
					$total_bo02_a=$total_bo02_a+$total_bo02;
					$total_rm_p_a=$total_rm_p_a+$total_bno_rm_p;
					$total_rm_d_a=$total_rm_d_a+$total_bno_rm_d;
					$total_phln_p_a=$total_phln_p_a+$total_bno_phln_p;
					$total_phln_d_a=$total_phln_d_a+$total_bno_phln_d;
					$total_pnbp_a=$total_pnbp_a+$total_pnbp;
					$total_pnbp_a=$total_pnbp_a+$total_pnbp;
					$total_all=$total_all+$total_all_samping;
 					$table.="<tr>";
							$table.="<td><b>" . $data->nama_unit_kerja. "</b></td>";
							$table.="<td style='vertical-align:middle'>" . number_format(($total_bo01+$total_bo02)). "</td>";
 							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_rm_p+$total_bno_rm_d)). "</td>";
 							$table.="<td style='vertical-align:middle'>" . number_format(($total_bno_phln_p+$total_bno_phln_d)). "</td>";
 							$table.="<td style='vertical-align:middle'>" . number_format(($total_pnbp)). "</td>";
							$table.="<td style='vertical-align:middle;padding:0px;background-color:#E74C3C'><a style='padding-top:10px;color:#fff;border-radius:0px;height:40px;' class='btn-block btn-sm btn btn-danger'>" . number_format(($total_all_samping)). "</a></td>";
					$table.="</tr>";
					 
				 
			}
		}
		$table.="<tr>";
				$table.="<th>TOTAL</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_bo01_a+$total_bo02_a)."</th>";
 				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_rm_p_a+$total_rm_d_a)."</th>";
 				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_phln_p_a+$total_phln_d_a)."</th>";
 				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_pnbp_a)."</th>";
				$table.="<th style='background-color:#8BBC21 !important;color:#fff'>".number_format($total_all)."</th>";
		$table.="</tr>";	
	 	$table.="<tbody>";
		$table.="</table>";
		echo $table;
	}
 function pnbp(){
		$series='';
 		$datenow=date("Y");
 		$total_pnpb=0;
 	 	$query=$this->db->query("select * from data_template_renja where tahun_berlaku='".$datenow."'");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$isletter="";
				$isletter= $this->isletter($data->kode_komponen_input);;
				if( (empty($data->kode_direktorat)) and  (empty($data->program)) and (empty($isletter))  ){
					$total_pnpb=$total_pnpb+$data->pnbp;
 				}
			}
		}

		$series.="{ name: 'PNBP', data: [".$total_pnpb."] },";  	
		return $series;
	} 
	function pnbp_list($id=""){
		$series='';
		$total_pnbp=0;
 
		$datenow=date("Y");
 		$list="";
 		$j=1;
	 	$table="<table class='table multimedia table-striped table-hover table-bordered'>";
	 	$table.="<thead>";
	 	$table.="<tr>";
				$table.="<th>DIREKTORAT</th>";
				$table.="<th>PNBP</th>";
 		$table.="</tr>";	
	 	$table.="</thead>";
	 	$table.="<tbody>";
	 	$query=$this->db->query("select *,m_unit_kerja.nama_unit_kerja as unit from data_template_renja a
	 	left join m_unit_kerja on m_unit_kerja.kd_unit_kerja=a.kode_direktorat
	 	where tahun_berlaku='".$datenow."' order by m_unit_kerja.kd_unit_kerja asc");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				if((!empty($data->unit))  ){
					$table.="<tr>";
							$table.="<td>" . $data->unit. "</td>";
							$table.="<td style='vertical-align:middle'>" . number_format($data->pnbp). "</td>";
 					$table.="</tr>";
					$total_pnbp=$total_pnbp+$data->pnbp;
 				}
			}
		}
		$table.="<tr>";
				$table.="<th>TOTAL</th>";
				$table.="<th>".number_format($total_pnbp)."</th>";
 		$table.="</tr>";	
	 	$table.="<tbody>";
		$table.="</table>";
		echo $table;
	}
	function bulan(){
		$select="";
		$selected="";
		$select.="<select style='margin-top:5px;margin-right:5px;float:right' name='bulan' id='bulan'>";
				$select.="<option ";if(date("m")==01){$select.="selected='selected'";}  $select.="value='01'>Januari</option>";
				$select.="<option ";if(date("m")==02){$select.="selected='selected'";}  $select.="value='02'>Februari</option>";
				$select.="<option ";if(date("m")==03){$select.="selected='selected'";}  $select.="value='03'>Maret</option>";
				$select.="<option ";if(date("m")==04){$select.="selected='selected'";}  $select.="value='04'>April</option>";
				$select.="<option ";if(date("m")==05){$select.="selected='selected'";}  $select.="value='05'>Mei</option>";
				$select.="<option ";if(date("m")==06){$select.="selected='selected'";}  $select.="value='06'>Juni</option>";
				$select.="<option ";if(date("m")==07){$select.="selected='selected'";}  $select.="value='07'>Juli</option>";
				$select.="<option ";if(date("m")==08){$select.="selected='selected'";}  $select.="value='08'>Agustus</option>";
				$select.="<option ";if(date("m")==09){$select.="selected='selected'";}  $select.="value='09'>September</option>";
				$select.="<option ";if(date("m")==10){$select.="selected='selected'";}  $select.="value='10'>Oktober</option>";
				$select.="<option ";if(date("m")==11){$select.="selected='selected'";}  $select.="value='11'>November</option>";
				$select.="<option ";if(date("m")==12){$select.="selected='selected'";}  $select.="value='12'>Desember</option>";		 
		$select.="</select>";
		return $select;
	}
	function tahun(){
		$select="";
		$selected="";
		$select.="<select   style='margin-top:5px;margin-right:5px;float:right' name='tahun' id='tahun'>";
		for($i=date("Y")-10;$i<=date("Y")+10;$i++){
			$selected='';
			if(date("Y")==$i){	$selected="selected='selected'";}
			$select.="<option $selected  value='".$i."'>$i</option>";
		}
		$select.="</select>";
		return $select;
	}	
 
	
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>