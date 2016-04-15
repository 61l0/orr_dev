<?php  

class exercise extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function exercise() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){

 	
 	   $this->load->model("exercise_model");     
 	   $this->exercise_model->reset_notifikasi();  
 	   $data['judul']='Data Exercise Renja'; 
       $data['view']='exercise/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("exercise_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->exercise_model->count();
		$config['base_url'] = base_url().'exercise/search/';
		$config['total_rows'] = $data['count'];
		$config['per_page'] = $this->limit;    
		$config['full_tag_open'] = '<div ><ul class="pagination pages">';
		$config['full_tag_close'] = '</ul></div>'; 
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>'; 
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>'; 
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>'; 
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>'; 		
		$this->pagination->initialize($config);
		/*----------------*/
		$data['query']=$this->exercise_model->get_data($limit,$offset);
		$this->load->view('exercise/data',$data);
	}
	function do_exercise($id=''){
 		$this->load->model("exercise_model"); 
		$data['judul']='Rekap Renja';
		$data['table']=$this->exercise_model->get_data_rekap($id);		
 		$data['view']='exercise/do_exercise';
 		$info=$this->exercise_model->get_update($id);	

 		$data['bo01']=$this->exercise_model->get_total_all_2('bo01', $info->direktorat, $info->tahun_anggaran);
 		$data['bo02']=$this->exercise_model->get_total_all_2('bo02', $info->direktorat, $info->tahun_anggaran);
 		$data['rm_p']=$this->exercise_model->get_total_all_2('rm_p', $info->direktorat, $info->tahun_anggaran);
 		$data['rm_d']=$this->exercise_model->get_total_all_2('rm_d', $info->direktorat, $info->tahun_anggaran);
 		$data['phln_p']=$this->exercise_model->get_total_all_2('phln_p', $info->direktorat, $info->tahun_anggaran);
 		$data['phln_d']=$this->exercise_model->get_total_all_2('phln_d', $info->direktorat, $info->tahun_anggaran);
 		$data['pnbp']=$this->exercise_model->get_total_all_2('pnbp', $info->direktorat, $info->tahun_anggaran); 		
 		$data['pagu']=$this->exercise_model->get_total_all_2('pagu', $info->direktorat, $info->tahun_anggaran);
		$data['direktorat']=$info->direktorat;
		$data['id']=$id; 
	    $this->load->view('index',$data);
	}
	function hasil_exercise($id=''){
 		$this->load->model("exercise_model"); 
		$data['judul']='Rekap Renja';
		$data['table']=$this->exercise_model->get_hasil_exercise($id);		
 		$data['view']='exercise/hasil_exercise';
 		$info=$this->exercise_model->get_update($id);	

 		$data['bo01']=$this->exercise_model->get_total_all_3('bo01', $info->direktorat, $info->tahun_anggaran);
 		$data['bo02']=$this->exercise_model->get_total_all_3('bo02', $info->direktorat, $info->tahun_anggaran);
 		$data['rm_p']=$this->exercise_model->get_total_all_3('bno_rm_p', $info->direktorat, $info->tahun_anggaran);
 		$data['rm_d']=$this->exercise_model->get_total_all_3('bno_rm_d', $info->direktorat, $info->tahun_anggaran);
 		$data['phln_p']=$this->exercise_model->get_total_all_3('bno_phln_p', $info->direktorat, $info->tahun_anggaran);
 		$data['phln_d']=$this->exercise_model->get_total_all_3('bno_phln_d', $info->direktorat, $info->tahun_anggaran);
 		$data['pnbp']=$this->exercise_model->get_total_all_3('pnbp', $info->direktorat, $info->tahun_anggaran); 		
 		$data['pagu']= $data['bo01']+$data['bo02']+$data['rm_p']+$data['rm_d']+$data['phln_p']+$data['phln_d']+$data['pnbp'];
		$data['direktorat']=$info->direktorat;
		$data['id']=$id; 
	    $this->load->view('index',$data);
	}
 	function rekap_renja($id=""){
		$this->load->model("exercise_model"); 
		$data['table']="<td colspan='16'><center><img src='".base_url()."images/loading.gif'></center></td>";
		$info=$this->exercise_model->get_update($id);	
		$data['judul']='Data Renja ' . $info->dari;
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['view']='exercise/detail';
		$data['id']=$id; 

	    $this->load->view('index',$data);
	}	 
	function echo_table_renja($id=""){
		//$id=$this->input->post('id');
		$this->load->model("exercise_model"); 
		$data['id']=$id; 
		$data['table']=$this->exercise_model->get_data_rekap($id);
		echo  $data['table'];
	}
	function hasil_exercise_table($id=""){
		$this->load->model("exercise_model"); 
		$data['table']="<td colspan='16'><center><img src='".base_url()."images/loading.gif'></center></td>";
		$info=$this->exercise_model->get_update($id);	
		$data['judul']='Data Renja ' . $info->dari;
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['view']='exercise/hasil_exercise';
		$data['id']=$id; 
	    $this->load->view('index',$data);
	}
	function echo_table_renja_hasil_exercise($id=""){
		//$id=$this->input->post('id');
		$this->load->model("exercise_model"); 
		$data['id']=$id; 
		$data['table']=$this->exercise_model->echo_table_renja_hasil_exercise($id);
		echo  $data['table'];
	}
 
	function do_it($id=""){ 
		$tipe=$this->input->post('tipe');
		if($tipe=="0"){	
			$this->load->model("exercise_model"); 
			$this->exercise_model->do_it($id);		
		} else {
			$this->normalisasi($id);
		}
	} 
	function ojo_nesu($id="56"){
		$this->load->model("exercise_model"); 
		$info=$this->exercise_model->get_update($id);	
		$data['rm_p']=$this->exercise_model->ojo_nesu('bno_rm_p', $info->direktorat, $info->tahun_anggaran);	
		echo $data['rm_p'];
	}
	function copy_sob($id=""){
		$this->load->model("exercise_model"); 
		$this->exercise_model->copy_sob($id); 
	}
	function ojo_lali($id="56"){
		$this->load->model("exercise_model"); 
		$info=$this->exercise_model->get_update($id);	
		$data['rm_p']=$this->exercise_model->ojo_lali('bno_rm_p', $info->direktorat, $info->tahun_anggaran);	
		echo $data['rm_p'];
	}
	function normalisasi($id=""){
		//1 Satuan
		//2 Puluhan
		//3 Ratusan
		//4 Ribuan
		//5 Puluhan Ribu
		//6 Ratusan Ribu
		//7 Jutaan
		//8 Puluhan Juta
		//9 Ratusan Juta
		//10 Milyaran
		
		$total_bo1=0;
 		$total_bo2=0;
		$total_rm_pusat=0;
 		$total_rm_daerah=0;
 		$total_phln_pusat=0;
 		$total_phln_daerah=0;
 		$total_pnbp=0;
 		$total_semua_item=0;
 		$total_hasil_bagi_pertama=0;
 		$str_len_hasil_bagi=0;
 		$sub_str_hasil=0;
 		$str_len_hasil_bagi_kedua=0;
		$this->load->model("exercise_model"); 
		$a=$this->input->post('pagu');
		$a=preg_replace('/[.,]/', '', $a);
		
		$this->load->model("exercise_model"); 
		$info=$this->exercise_model->get_update($id);	
		$this->db->query("delete from data_temp_exercise where id_data_renja='".$id."'");
	 
	 
		
		$pagu=$this->input->post('pagu');
		$pagu=preg_replace('/[.,]/', '', $pagu);
 		$pagu_asli=$this->input->post('pagu_asli');
 		$pagu=$pagu-$pagu_asli;
		
 		$info=$this->exercise_model->get_update($id);

		$total_semua_yang_kena=0;
 		$total_bo1=$this->exercise_model->get_total_all_2('bo01', $id);	
 		$total_bo2=$this->exercise_model->get_total_all_2('bo02',  $id);
 		$total_rm_pusat=$this->exercise_model->get_total_all_2('bno_rm_p',  $id);
 		$total_rm_daerah=$this->exercise_model->get_total_all_2('bno_rm_d',  $id);	
 		$total_phln_pusat=$this->exercise_model->get_total_all_2('bno_phln_p', $id);
 		$total_phln_daerah=$this->exercise_model->get_total_all_2('bno_phln_d', $id);
 		$total_pnbp=$this->exercise_model->get_total_all_2('pnbp', $id);
 		$total_semua_item=$total_bo1+$total_bo2+$total_rm_pusat+$total_rm_daerah+$total_phln_pusat+$total_phln_daerah+$total_pnbp;
  		$pagu_asli=$this->input->post('pagu_asli');
 		//$this->db->query("delete from data_temp_exercise where id_data_renja='".$id."'");
  		$total_hasil_bagi_pertama=$pagu/$total_semua_item;
		$sub_str_hasil_pertama=substr($total_hasil_bagi_pertama, 0,1);
		$str_len_hasil_bagi_pertama=strlen(round($total_hasil_bagi_pertama));
  		//echo "<hr>TOTAL KESELURUHAN ITEM = ".$total_semua_item;
		//echo "<br>TOTAL HASIL BAGI PERTAMA ITEM = ".number_format($total_hasil_bagi_pertama);
		//echo "<br>SUB STR HASIL BAGI PERTAMA = ".number_format($sub_str_hasil_pertama);
		//echo "<br>STR LEN HASIL BAGI PERTAMA = ".number_format($str_len_hasil_bagi_pertama);
	 	
 		if($str_len_hasil_bagi_pertama=="1") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*1;
		} elseif($str_len_hasil_bagi_pertama=="2") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*10;
		}  elseif($str_len_hasil_bagi_pertama=="3") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*100;
		}  elseif($str_len_hasil_bagi_pertama=="4") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*1000;
		}  elseif($str_len_hasil_bagi_pertama=="5") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*10000;
		} elseif($str_len_hasil_bagi_pertama=="6") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*100000;
		} elseif($str_len_hasil_bagi_pertama=="7") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*1000000;
		} elseif($str_len_hasil_bagi_pertama=="8") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*10000000;
		} elseif($str_len_hasil_bagi_pertama=="9") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*100000000;
		} elseif($str_len_hasil_bagi_pertama=="10") {
			$sub_str_hasil_pertama=$sub_str_hasil_pertama*1000000000;
		}
		
 		$this->exercise_model->exercise_bro_normalisasi_tahap_satu($id,$sub_str_hasil_pertama);
 
		/*$this->exercise_model->get_exercise_normalisasi('bo01',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('bo02',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('bno_rm_p',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('bno_rm_d',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('bno_phln_p',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('bno_phln_d',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		$this->exercise_model->get_exercise_normalisasi('pnbp',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
	 	*/
	 	$hasil_bagi_kedua=0;
	 	$hasil_bagi_kedua=(($total_hasil_bagi_pertama) - $sub_str_hasil_pertama) ;	
	 	$hasil_bagi_kedua=$hasil_bagi_kedua;
 		$str_len_hasil_bagi_kedua=strlen(round($hasil_bagi_kedua));
 		$sub_str_hasil_kedua=substr($hasil_bagi_kedua, 0,1);
 
 		
		if($str_len_hasil_bagi_kedua=="1") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*1;
		} elseif($str_len_hasil_bagi_kedua=="2") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*10;
		}  elseif($str_len_hasil_bagi_kedua=="3") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*100;
		}  elseif($str_len_hasil_bagi_kedua=="4") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*1000;
		}  elseif($str_len_hasil_bagi_kedua=="5") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*10000;
		} elseif($str_len_hasil_bagi_kedua=="6") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*100000;
		} elseif($str_len_hasil_bagi_kedua=="7") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*1000000;
		} elseif($str_len_hasil_bagi_kedua=="8") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*10000000;
		} elseif($str_len_hasil_bagi_kedua=="9") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*100000000;
		} elseif($str_len_hasil_bagi_kedua=="10") {
			$sub_str_hasil_kedua=$sub_str_hasil_kedua*1000000000;
		}	
 		$this->exercise_model->exercise_bro_normalisasi_tahap_dua($id,$sub_str_hasil_kedua);
 		
 		$hasil_akhir=$pagu-($pagu-($sub_str_hasil_kedua+$sub_str_hasil_pertama)); 		
   		$hasil_akhir=$sub_str_hasil_pertama+ $sub_str_hasil_kedua;
   		
  		//$this->exercise_model->update_last_exercise_normalisasi($id,$hasil_akhir);
		$this->exercise_model->fuck_reset_after_upload_excel($id,$info->direktorat,$info->tahun_anggaran);
   	 	



   	 	//$this->exercise_model->exercise_bro_normalisasi_tahap_dua($id,$sub_str_hasil_pertama);
 		/*$this->exercise_model->get_exercise_normalisasi('bo01',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('bo02',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('bno_rm_p',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('bno_rm_d',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('bno_phln_p',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('bno_phln_d',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama+$sub_str_hasil_kedua);
		$this->exercise_model->get_exercise_normalisasi('pnbp',$info->direktorat,$info->tahun_anggaran_dasar,$sub_str_hasil_pertama);
		*/
		//$sisa_pembagian_terakhir= $a - (($sub_str_hasil_pertama * $total_semua_item) + ($sub_str_hasil_kedua*$total_semua_item));
		//echo $sisa_pembagian_terakhir=$sub_str_hasil_pertama-$sub_str_hasil_kedua;
		//echo $sisa_pembagian_terakhir;;
		//$this->exercise_bro($id,$sub_str_hasil_kedua);
		
		/*
		
 		

		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bo01');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bo02');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bno_rm_p');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bno_rm_d');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bno_phln_p');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'bno_phln_d');
 		$this->exercise_model->set_header($info->tahun_anggaran_dasar,$info->direktorat,'pnbp');
 		
 		$this->exercise_model->cek_komponen_input('bo01',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('bo02',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('bno_rm_p',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('bno_rm_d',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('bno_phln_p',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('bno_phln_d',$info->direktorat,$info->tahun_anggaran_dasar);
 		$this->exercise_model->cek_komponen_input('pnbp',$info->direktorat,$info->tahun_anggaran_dasar);*/
 	 	$message ="<span style='font-size:14px'><i style='color:#31BC86' class='glyphicon glyphicon-ok-sign'></i> Sukses Melakukan Generate Data Exercise</b></span><br>";
		echo  $message;		

	}
	function fuck_reset_after_upload_excel(){
		$this->load->model("exercise_model"); 
		//$this->exercise_model->fuck_reset_after_upload_excel(68,1256,2016);
	}
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */