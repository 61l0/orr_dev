<?php  

class log_renja extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function log_renja() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){
	  $this->load->model("log_renja_model");     
  	   $data['judul']='Data Template Renja'; 
       $data['view']='log_renja/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("log_renja_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->log_renja_model->count();
		$config['base_url'] = base_url().'log_renja/search/';
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
		$data['query']=$this->log_renja_model->get_data($limit,$offset);
		$this->load->view('log_renja/data',$data);
	}
	function form($id=''){
 		$this->load->model("log_renja_model"); 
 		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->log_renja_model->get_update($id);		 
 			$data['infouser']['judul']=$info->judul;
 			$data['infouser']['note']=$info->note;
			$data['kepada']=$this->log_renja_model->get_kepada($info->kepada);
			$data['tahun_anggaran']=$this->log_renja_model->get_tahun_anggaran($info->tahun_anggaran);
		} else {
			$data['kepada']=$this->log_renja_model->get_kepada();
			$data['tahun_anggaran']=$this->log_renja_model->get_tahun_anggaran();
		}
		$data['combo_mapping_program']=$this->log_renja_model->get_combo_mapping("program");
		$data['combo_mapping_kegiatan']=$this->log_renja_model->get_combo_mapping("kegiatan");
		$data['combo_mapping_nomor_urut_indikator']=$this->log_renja_model->get_combo_mapping("nomor_urut_indikator");
		$data['combo_mapping_indikator']=$this->log_renja_model->get_combo_mapping("indikator");
		$data['combo_mapping_nomor_urut_komponen_input']=$this->log_renja_model->get_combo_mapping("nomor_urut_komponen_input");
		$data['combo_mapping_komponen_input']=$this->log_renja_model->get_combo_mapping("komponen_input");
		$data['combo_mapping_sasaran_program']=$this->log_renja_model->get_combo_mapping("sasaran_program");
		$data['combo_mapping_sasaran_kegiatan']=$this->log_renja_model->get_combo_mapping("sasaran_kegiatan");
		$data['combo_mapping_target']=$this->log_renja_model->get_combo_mapping("target");
		$data['combo_mapping_bo001']=$this->log_renja_model->get_combo_mapping("bo001");
		$data['combo_mapping_bo002']=$this->log_renja_model->get_combo_mapping("bo002");
		$data['combo_mapping_rm_p']=$this->log_renja_model->get_combo_mapping("rm_p");
		$data['combo_mapping_rm_d']=$this->log_renja_model->get_combo_mapping("rm_d");
		$data['combo_mapping_phln_p']=$this->log_renja_model->get_combo_mapping("phln_p");
		$data['combo_mapping_phln_d']=$this->log_renja_model->get_combo_mapping("phln_d");
		$data['combo_mapping_pnbp']=$this->log_renja_model->get_combo_mapping("pnbp");
		$data['combo_mapping_renaksi']=$this->log_renja_model->get_combo_mapping("renaksi");
		$data['combo_mapping_unit']=$this->log_renja_model->get_combo_mapping("unit");
		$data['id']=$id;
		$data['view']='log_renja/form';
		$this->load->view('index',$data);
	}
	function cek(){
		$judul=$this->input->post('judul');
		$note=$this->input->post('note');
		$this->load->model("log_renja_model"); 
		$cek_if_exist=$this->log_renja_model->cek_if_exist();
		if($judul==""){
			echo "JUDUL TIDAK BOLEH KOSONG";
		} elseif($note==""){
			echo "NOTE ANGGRAN TIDAK BOLEH KOSONG";
		} elseif($cek_if_exist > 0) {
			echo "DATA SUDAH TERSEDIA / SILAHKAN MELAKUKAN UPDATE";
		}
	}
	function simpan(){
		 
	}	
	function cek_is_open_lock($tipe=""){
		$this->load->model("log_renja_model"); 
		return $this->log_renja_model->cek_is_open_lock($tipe);
	}
	function restore($id="",$id_template=""){
		$this->load->model("log_renja_model"); 
 		if($id_template!=''){
 			$cek_if_data_exist=$this->log_renja_model->cek_if_data_exist();
 			if($cek_if_data_exist!="0"){
 				$info=$this->log_renja_model->get_update($id_template);		 
	 			$data['infouser']['judul']=$info->judul;
	 			$data['infouser']['note']=$info->note;
	 			$data['infouser']['tujuan']=$info->tujuan;
	 			$data['infouser']['dari']=$info->dari;
	 			$data['infouser']['tanggal']=$info->tanggal;
 			} else {
 				$data['infouser']['judul']="TIDAK TERSEDIA";
	 			$data['infouser']['note']="-";
	 			$data['infouser']['tujuan']="-";
	 			$data['infouser']['dari']="-";
	 			$data['infouser']['tanggal']=date("Y-m-d");
 			}			
 		} 
 		if($id!=''){
			$info_log=$this->log_renja_model->get_update_log($id);		 
 			$data['info_log']['judul']=$info_log->judul;
 			$data['info_log']['note']=$info_log->note;
 			$data['info_log']['tujuan']=$info_log->tujuan;
 			$data['info_log']['dari']=$info_log->dari;
 			$data['info_log']['tanggal']=$info_log->tanggal;
 		} 
 		$data['id_restore']=$id_template;
 		$data['id_backup']=$id;
 		
	 	$data['view']='log_renja/form_restore';
		$this->load->view('index',$data);
	} 
	function cek_if_exist_data_renja(){
		$this->load->model("log_renja_model"); 
		$cek_if_data_exist=$this->log_renja_model->cek_if_data_exist();
		echo $cek_if_data_exist;
	}
	function di_restore_dulu_sob(){		 
		$this->load->model("log_renja_model"); 
		$cek_if_data_exist=$this->log_renja_model->cek_if_data_exist();
		if($cek_if_data_exist !="0"){
			$this->log_renja_model->di_restore_dulu_sob();   
		} else {			 
			$table=$this->log_renja_model->load_data_exist();   
			echo $table;
			//return false;
		}
	}
	function di_restore_dulu_bro(){
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->di_restore_dulu_bro();   
		echo "<i class='glyphicon glyphicon-ok'></i> Sukses Melakukan Restore Data";
			return false;
	}
	function save_live_edit_indikator(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->save_live_edit_indikator();   
	}
	function save_live_edit_sub_komponen_input(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->save_live_edit_sub_komponen_input(); 
	}
	function save_live_edit_program(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->save_live_edit_program(); 
	}
	function delete_data($id=""){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("log_renja_model");     
		$this->log_renja_model->delete_data($id);     
	}
	function delete_data_renja($id=""){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("log_renja_model");     
		$this->log_renja_model->delete_data_renja($id);    
	}
	function add_program($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("log_renja_model"); 
		 $data['parent']=$this->log_renja_model->get_parent_program($id);
 		 $data['id']=$id;
 		 $data['tipe_input']=$tipe_input;
		 $data['kl']=""; 
 		 $this->load->view('log_renja/form/form_program',$data);
	}
	function add_form_indikator($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("log_renja_model"); 
		 $data['parent']=$this->log_renja_model->get_parent_indikator($id);
 		 $data['id']=$id;
 		 $data['tipe_input']=$tipe_input;
		 $data['kl']=""; 
 		 $this->load->view('log_renja/form/form_indikator',$data);
	}
	function update_form_indikator($id="",$tipe_input=""){
		 $this->load->model("log_renja_model"); 
		 $info=$this->log_renja_model->get_row($id);	
		 $data['infouser']['program']=$info->program;
		 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
		 $data['infouser']['indikator']=trim($info->indikator);
		 $data['infouser']['komponen_input']=$info->komponen_input;
		 $data['infouser']['kode']=$info->kode;
		 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
		 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
		 $data['infouser']['urutan']=trim($info->urutan);
		 $data['infouser']['bo01']=0;
		 $data['infouser']['bo02']=0;
		 $data['infouser']['bno_rm_p']=0;
		 $data['infouser']['bno_rm_d']=0;
		 $data['infouser']['bno_phln_p']=0;
		 $data['infouser']['bno_phln_d']=0;
		 $data['infouser']['pnbp']=0;
		 $data['infouser']['kl']=0;
		 $data['tipe_input']=$tipe_input;
 		 $data['program']=trim($info->program);
 		 $data['kl']=trim($info->kl); 
 		 $data['id']=$id;
 		 $data['parent']=$this->log_renja_model->get_parent_indikator($id);
 		 $this->load->view('log_renja/form/form_indikator',$data);
	}
	function add_form_komponen_input($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $data['tipe_input']=$tipe_input;
		 $this->load->model("log_renja_model"); 
		 $data['id']=$id;
		 $data['kl']=""; 		  
  		 $data['parent']=$this->log_renja_model->get_parent_komponen_input($id,'add');
 		 $this->load->view('log_renja/form/form_komponen_input',$data);
	} 
	function update_form_komponen_input($id="",$tipe_input=""){
		 $this->load->model("log_renja_model"); 
		 $info=$this->log_renja_model->get_row($id);	
		 $data['infouser']['program']=$info->program;
		 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
		 $data['infouser']['indikator']=trim($info->indikator);
		 $data['infouser']['kode']=trim($info->kode);
		 $data['infouser']['komponen_input']=$info->komponen_input;
		 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
		 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
		 $data['infouser']['urutan']=trim($info->urutan);
		 $data['infouser']['bo01']=trim($info->bo01);
		 $data['infouser']['bo02']=trim($info->bo02);
		 $data['infouser']['bno_rm_p']=trim($info->bno_rm_p);
		 $data['infouser']['bno_rm_d']=trim($info->bno_rm_d);
		 $data['infouser']['bno_phln_p']=trim($info->bno_phln_p);
		 $data['infouser']['bno_phln_d']=trim($info->bno_phln_d);
		 $data['infouser']['pnbp']=trim($info->pnbp);
		 $data['infouser']['kl']=trim($info->kl);
		 $data['tipe_input']=$tipe_input;
		 $data['kl']=trim($info->kl);
		 $tipe=($info->tipe);
		 $data['id']=$id;
 		 $data['program']=trim($info->program); 
 		 $data['parent']=$this->log_renja_model->get_parent_komponen_input($id,'update');
 		 $this->load->view('log_renja/form/form_komponen_input',$data);
	}
	function add_form_sub_komponen_input($id="",$tipe_input=""){		
		$data['judul']='Data Template Renja'; 
		$this->load->model("log_renja_model"); 
		$data['id']=$id;
		$data['kl']="";
		$data['tipe_input']=$tipe_input;
 		$data['parent']=$this->log_renja_model->get_parent_sub_komponen_input($id,'add');
 		$this->load->view('log_renja/form/form_sub_komponen_input',$data);
	}
	function update_form_sub_komponen_input($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("log_renja_model"); 
		 $info=$this->log_renja_model->get_row($id);	
		 if($tipe_input!="0"){			 
			 $data['infouser']['program']=$info->program;
			 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
			 $data['infouser']['indikator']=trim($info->indikator);
			 $data['infouser']['kode']=trim($info->kode);
			 $data['infouser']['komponen_input']=$info->komponen_input;
			 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
			 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
			 $data['infouser']['urutan']=trim($info->urutan);
			 $data['infouser']['bo01']=trim($info->bo01);
			 $data['infouser']['bo02']=trim($info->bo02);
			 $data['infouser']['bno_rm_p']=trim($info->bno_rm_p);
			 $data['infouser']['bno_rm_d']=trim($info->bno_rm_d);
			 $data['infouser']['bno_phln_p']=trim($info->bno_phln_p);
			 $data['infouser']['bno_phln_d']=trim($info->bno_phln_d);
			 $data['infouser']['pnbp']=trim($info->pnbp);
			 $data['infouser']['kl']=trim($info->kl);
		 	 $data['kl']=trim($info->kl); 
		 	 $tipe=($info->tipe);		
		 	
		 } else {
		 	$data['kl']=""; 
		 }
		 $data['program']=trim($info->program);
		 $data['tipe_input']=$tipe_input;
		 $data['id']=$id;
 		 $data['parent']=$this->log_renja_model->get_parent_sub_komponen_input($id,'update');
 		 $this->load->view('log_renja/form/form_sub_komponen_input',$data);
	}
	function get_url_file($id=""){
		$this->load->model("log_renja_model");     
		return $this->log_renja_model->get_url_file($id);    
	}
	function get_file_name($id=""){
		$this->load->model("log_renja_model");     
		return $this->log_renja_model->get_file_name($id);    
	}
	function download_app($id=""){
		$this->load->helper('download');
		$url_file=$this->get_url_file($id);
 		$nama_file=$this->get_file_name($id);
		$data = file_get_contents("uploads/".$url_file); // Read the file's contents
		$name = $nama_file;
		force_download($name, $data);
	}
	function rekap_renja($id="",$id_renja=""){
		$this->load->model("log_renja_model"); 
		$data['judul']='Rekap Renja';
		$data['table']="<tr><td colspan='15'><center><img src='".base_url()."images/loading.gif'></center></td></tr>";
		$info=$this->log_renja_model->get_update_log($id,$id_renja);	
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['direktorat']=$info->dari;		 
		$data['view']='log_renja/detail';
		$data['id']=$id; 
		$data['id_restore']=$id_renja;
 		$data['id_backup']=$id;
	    $this->load->view('index',$data);
	}
	function echo_table_renja($id=""){
		$this->load->model("log_renja_model"); 
		$data['table']=$this->log_renja_model->get_data_rekap($id);	
		$this->load->view('log_renja/table',$data);
	}
	 
	function refresh(){
		$id=$this->input->post('id');
		$this->load->model("log_renja_model"); 
		$data['table']=$this->log_renja_model->get_data_rekap($id);
		echo  $data['table'];
	}
	 
	function export_excel(){
		$this->load->model("log_renja_model"); 
		$data['judul']='Export Renja';
		$data['tahun_anggaran']=$this->log_renja_model->filter_tahun_anggaran();
		$data['get_direktorat']=$this->log_renja_model->filter_get_direktorat();
		$data['table']=$this->log_renja_model->get_data_export();				 
		$data['view']='log_renja/export'; 
	    $this->load->view('index',$data);
	}
	function refresh_export(){
		$id=$this->input->post('id');
		$this->load->model("log_renja_model"); 
		$data['table']=$this->log_renja_model->get_data_export();	
 		echo  $data['table'];
	}
	function export_now(){
		$this->load->model("log_renja_model"); 
		$data['table']=$this->log_renja_model->get_data_export();	
		$data['file_name']="LAPORAN_RENJA_".date("YMDHIS");
		$this->load->view('log_renja/export/excel',$data);	 
	}
	function simpan_komponen_input($id=""){
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->simpan_komponen_input($id);
	} 
	function set_numbering($id=""){
		$this->load->model("log_renja_model"); 
		$this->log_renja_model->set_numbering($id);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */