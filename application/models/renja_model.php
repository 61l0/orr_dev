<?php
class renja_model extends CI_Model
 {
     function __construct(){
         parent::__construct();
     }
     
 
     function get_data(){
			$query=$this->db->query("select *,data_renja.id as id,tahun_anggaran.tahun_anggaran as tahun_anggaran from data_renja 
			left join tahun_anggaran on tahun_anggaran.id=data_renja.tahun_anggaran  order by tahun_anggaran.tahun_anggaran asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus[]=$data;
				}
				return $menus;
			}
     }     
    function count(){
			$kategori=$this->input->post('kategori');		
			$query=$this->db->query("select count(1) as jumlah from data_renja
			left join tahun_anggaran on tahun_anggaran.id=data_renja.id
			");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$menus=$data->jumlah;
				}
				return $menus;
			}
	}
	function get_data_rekap($id=""){
		$table="";
		$query=$this->db->query("select * from renja where id_data_renja='".$id."' order by id asc");
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data_f) {
							
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
		        		$bg_ikk="background-color:#F9F9F9;font-weight:bold";	
		        		$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->kode_direktorat))."</td>";
		        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."' colspan='3'>". strtoupper(trim($data_f->program))."</td>";
		        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sasaran_program))."</td>";
						$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->target))."</td>";
			        } else {
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
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(($data_f->bno_rm_p)))."</td>";
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
			} else {
					$table.="</tr>";
					$table.="<td colspan='15'  style='vertical-align:middle;font-size:10px;'><center>Data Kosong</center></td>";
		 			$table.="</tr>";
			}
			return $table;
	}
	function get_update($id=""){
     	$query=$this->db->query("select * from data_renja where id='$id'");
		return 	$query->row();
    }
   
    function get_tahun_anggaran($tahun_anggaran=''){
		$select="";
		$select.="<select id='tahun_anggaran' class='form-control' style='width:300px' name='tahun_anggaran'>";
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
	function simpan(){
		$id=$this->input->post('id');
		$judul=$this->input->post('judul');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$data=array(
	 	 'judul'=>$judul,
		 'tahun_anggaran'=>$tahun_anggaran,
		);
		if($id==''){
			$this->db->trans_start();
			$this->db->insert('data_renja',$data);
			$this->db->trans_complete(); } 
			else {
			$this->db->trans_start();
			$this->db->where('id',$id);
			$this->db->update('data_renja', $data); 
			$this->db->trans_complete();
		}	
		 
		redirect(base_url()."renja");
	}
	function delete_data($id=""){
		$this->db->delete('data_renja', array('id' => $id)); 
		 
	}
	function cek_total_excel(){
		include_once ( APPPATH . "libraries/excel_reader/excel/reader.php");
        $data_f = new Spreadsheet_Excel_Reader();
        $j = -1;
		$jumlahRowdbx='';
		$jumlah_rows=0;
        error_reporting(E_ALL ^ E_NOTICE);
        $data_f->read('d:/renja.xls');
        $total=0;
        for ($i = 19; $i <= $data_f->sheets[0]['numRows']; $i++) {
        	if ($data_f->sheets[0]['cells'][$i][1]  and $data_f->sheets[0]['cells'][$i][2])  {
				$total=$total+$data_f->sheets[0]['cells'][$i][14];
			}
        }
        echo $total;
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
	function import_renja($file_name=""){
		$id=$this->input->post('id');
		$parent=$this->input->post('parent');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		$tahun_berlaku=$this->get_tahun_berlaku($tahun_anggaran);
		include_once ( APPPATH . "libraries/excel_reader/excel/reader.php");
        $data_f = new Spreadsheet_Excel_Reader();
        $j = -1;
		$jumlahRowdbx='';
		$jumlah_rows=0;
		$this->db->query("delete from renja where id_data_renja='".$id."'");
        error_reporting(E_ALL ^ E_NOTICE);       
        $data_f->read('uploads/'.$file_name);
        for ($i = 19; $i <= $data_f->sheets[0]['numRows']; $i++) {

        	 $value_kol1=trim($data_f->sheets[0]['cells'][$i][1]);
        	 $value_kol2=trim($data_f->sheets[0]['cells'][$i][2]);
        	 $value_kol3=trim($data_f->sheets[0]['cells'][$i][3]);
        	 $value_kol4=trim($data_f->sheets[0]['cells'][$i][4]);

        	$kode_direktorat=$data_f->sheets[0]['cells'][$i][1];
        	if($kode_direktorat!=""){
        		$kodedir=$data_f->sheets[0]['cells'][$i][1];
        	} else {
        		$kode_direktorat=$kode_direktorat;
        	}

        	 
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
			 	 'id_data_renja'=>$id,
				 'parent'=>$parent,
				 'kode_direktorat_child'=>$kodedir,
				 'kode_direktorat'=>$kode_direktorat,
				 'program'=>$program,
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

	        $this->db->trans_start();
			$this->db->insert('renja',$data);
			$this->db->trans_complete(); 
        }
       
	}
	function baca_excel(){
		include_once ( APPPATH . "libraries/excel_reader/excel/reader.php");
        $data_f = new Spreadsheet_Excel_Reader();
        $j = -1;
		$jumlahRowdbx='';
		$jumlah_rows=0;
        error_reporting(E_ALL ^ E_NOTICE);       
        $data_f->read('d:/renja.xls');
        for ($i = 19; $i <= $data_f->sheets[0]['numRows']; $i++) {
        	$table.="<tr>";
        	$value_kol1=trim($data_f->sheets[0]['cells'][$i][1]);
        	$value_kol2=trim($data_f->sheets[0]['cells'][$i][2]);
        	$value_kol3=trim($data_f->sheets[0]['cells'][$i][3]);
        	$value_kol4=trim($data_f->sheets[0]['cells'][$i][4]);
        	$bg_ikk="";

        	$kode_direktorat=$data_f->sheets[0]['cells'][$i][1];
        	if($kode_direktorat!=""){
        		$kodedir=$data_f->sheets[0]['cells'][$i][1];
        	} else {
        		$kode_direktorat=$kode_direktorat;
        	}

        	if (empty($value_kol3)   and  empty($value_kol4)) {
        		$bg_ikk="background-color:#F9F9F9;font-weight:bold";	
        		$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ik."''>". strtoupper(trim($data_f->sheets[0]['cells'][$i][1]))."</td>";
        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."' colspan='3'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][2]))."</td>";
        		$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][5]))."</td>";
				$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][8]))."</td>";
	        } else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->sheets[0]['cells'][$i][1]))."</td>";
        		$table.="<td  style='vertical-align:middle;font-size:10px;font-weight:bold;".$bg_ikk."''>". strtoupper(trim($data_f->sheets[0]['cells'][$i][2]))."</td>";
        		if (empty($value_kol1)   and  (!(empty($value_kol2)))) {
	        			$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."' colspan='3'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][3]))."</td>";
	        		    $table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][8]))."</td>";
	        		
	        	} else {
	        			$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][3]))."</td>";
					    $table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][4]))."</td>";
			        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][5]))."</td>";
						$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][8]))."</td>";
	        		
	        	}
	        }
        	 

        	
        	if (is_numeric($data_f->sheets[0]['cells'][$i][14])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][14])))."</td>";
	        } else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][14])))."</td>";
	        }
	        if (is_numeric($data_f->sheets[0]['cells'][$i][15])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][15])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][15])))."</td>";
        	}	
 			
 			if (is_numeric($data_f->sheets[0]['cells'][$i][16])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][16])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][16])))."</td>";
        	}		

        	if (is_numeric($data_f->sheets[0]['cells'][$i][17])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][17])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][17])))."</td>";
        	}		

        	if (is_numeric($data_f->sheets[0]['cells'][$i][18])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][18])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][18])))."</td>";
        	}		
        	 
			if (is_numeric($data_f->sheets[0]['cells'][$i][19])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][19])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][19])))."</td>";
        	}	

			if (is_numeric($data_f->sheets[0]['cells'][$i][20])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][20])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][20])))."</td>";
        	}	

			if (is_numeric($data_f->sheets[0]['cells'][$i][21])){
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][21])))."</td>";
        	} else {
	        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim(number_format($data_f->sheets[0]['cells'][$i][21])))."</td>";
        	}	

        	$table.="<td  style='vertical-align:middle;font-size:10px;".$bg_ikk."'>". strtoupper(trim($data_f->sheets[0]['cells'][$i][31]))."</td>";
 			$table.="</tr>";

 		 
        }
       
       return $table;

	}
}		
 ?>
