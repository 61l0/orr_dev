<?php  

class template_renja extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function template_renja() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        $this->load->model("init"); 
	   $this->init->getLasturl();
    }	
 	function index($limit='',$offset=''){
 	   $this->load->model("init"); 
	   $this->init->getLasturl();
	   $this->load->model("template_renja_model");     
 	   $this->template_renja_model->reset_notifikasi();  
 	   $data['judul']='Data Template Renja'; 
       $data['view']='template_renja/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("template_renja_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->template_renja_model->count();
		$config['base_url'] = base_url().'template_renja/search/';
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
		$data['query']=$this->template_renja_model->get_data($limit,$offset);
		$this->load->view('template_renja/data',$data);
	}
	function form($id=''){
 		$this->load->model("template_renja_model"); 
 		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->template_renja_model->get_update($id);		 
 			$data['infouser']['judul']=$info->judul;
 			$data['infouser']['note']=$info->note;
			$data['kepada']=$this->template_renja_model->get_kepada($info->kepada);
			$data['tahun_anggaran']=$this->template_renja_model->get_tahun_anggaran($info->tahun_anggaran);
			$data['tahapan_dokumen']=$this->template_renja_model->tahapan_dokumen($info->tahapan_dokumen);
		} else {
			$data['kepada']=$this->template_renja_model->get_kepada();
			$data['tahun_anggaran']=$this->template_renja_model->get_tahun_anggaran();
			$data['tahapan_dokumen']=$this->template_renja_model->tahapan_dokumen();
		}
		$data['tahun_renja_export']=$this->template_renja_model->get_tahun_renja_export();
		$data['combo_mapping_program']=$this->template_renja_model->get_combo_mapping("program");
		$data['combo_mapping_kegiatan']=$this->template_renja_model->get_combo_mapping("kegiatan");
		$data['combo_mapping_nomor_urut_indikator']=$this->template_renja_model->get_combo_mapping("nomor_urut_indikator");
		$data['combo_mapping_indikator']=$this->template_renja_model->get_combo_mapping("indikator");
		$data['combo_mapping_nomor_urut_komponen_input']=$this->template_renja_model->get_combo_mapping("nomor_urut_komponen_input");
		$data['combo_mapping_komponen_input']=$this->template_renja_model->get_combo_mapping("komponen_input");
		$data['combo_mapping_sasaran_program']=$this->template_renja_model->get_combo_mapping("sasaran_program");
		$data['combo_mapping_sasaran_kegiatan']=$this->template_renja_model->get_combo_mapping("sasaran_kegiatan");
		$data['combo_mapping_target']=$this->template_renja_model->get_combo_mapping("target");
		$data['combo_mapping_bo001']=$this->template_renja_model->get_combo_mapping("bo001");
		$data['combo_mapping_bo002']=$this->template_renja_model->get_combo_mapping("bo002");
		$data['combo_mapping_rm_p']=$this->template_renja_model->get_combo_mapping("rm_p");
		$data['combo_mapping_rm_d']=$this->template_renja_model->get_combo_mapping("rm_d");
		$data['combo_mapping_phln_p']=$this->template_renja_model->get_combo_mapping("phln_p");
		$data['combo_mapping_phln_d']=$this->template_renja_model->get_combo_mapping("phln_d");
		$data['combo_mapping_pnbp']=$this->template_renja_model->get_combo_mapping("pnbp");
		$data['combo_mapping_renaksi']=$this->template_renja_model->get_combo_mapping("renaksi");
		$data['combo_mapping_unit']=$this->template_renja_model->get_combo_mapping("unit");

		$data['id']=$id;
		$data['view']='template_renja/form';
		$this->load->view('index',$data);
	}
	function cek(){
		$judul=$this->input->post('judul');
		$note=$this->input->post('note');
		$this->load->model("template_renja_model"); 
		$cek_if_exist=$this->template_renja_model->cek_if_exist();
		if($judul==""){
			echo "JUDUL TIDAK BOLEH KOSONG";
		} elseif($note==""){
			echo "NOTE ANGGRAN TIDAK BOLEH KOSONG";
		} elseif($cek_if_exist > 0) {
			echo "DATA SUDAH TERSEDIA / SILAHKAN MELAKUKAN UPDATE";
		}
	}
	function simpan(){
		$direktori = "uploads/";	
		$i=0;
		$newname="";
		$name="";
		$this->load->model("template_renja_model"); 
		 foreach ($_FILES["file_berkas"]["error"] as $key => $error) {
			$newname=date("Ymdhis");	
		    if ($error == UPLOAD_ERR_OK) {
		        $tmp_name = $_FILES["file_berkas"]["tmp_name"][$key];
		        $name = $_FILES["file_berkas"]["name"][$key];
		        $ext=substr(strrchr($name,'.'),1);
		        $newname=trim($newname.'_'.$name);
		        $newname = str_replace(' ', '', $newname);
 		        move_uploaded_file($tmp_name, $direktori."/".$newname); 		        
   		    }
		}		 
		$this->template_renja_model->simpan($newname,$name);
	}	
	function cek_is_open_lock($tipe=""){
		$bulan=date("m");
 		$this->load->model("template_renja_model"); 
		return $this->template_renja_model->cek_is_open_lock($tipe,$bulan);
	}
	function save_live_edit(){
		$this->load->model("template_renja_model");    
		$jumlah=$this->input->post('value');
		$jumlah=str_replace(".","",$jumlah);
		$jumlah=str_replace(",","",$jumlah);
		$tipe_analisis=$this->input->post('tipe_analisis');

		$param=$this->input->post('name');
		$pieces = explode("|", $param);
		$id=$pieces[0];  
		$tipe=$pieces[1]; 
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}
 		if(($tipe!="kl") and ($tipe!="kode")){ 
			if(!is_numeric($jumlah)){
				echo "<i class='glyphicon glyphicon-remove'></i> Nominal Harus Bilangan Angka";
				return false;
			} else {
	 			$this->template_renja_model->save_live_edit();
			}
		} else {
				$this->template_renja_model->save_live_edit();
		}
	} 
	function save_live_edit_komponen_input(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->save_live_edit_komponen_input();   
	}
	function save_live_edit_indikator(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->save_live_edit_indikator();   
	}
	function save_live_edit_sub_komponen_input(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->save_live_edit_sub_komponen_input(); 
	}
	function save_live_edit_program(){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->save_live_edit_program(); 
	}
	function delete_data($id=""){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model");     
		$this->template_renja_model->delete_data($id);     
	}
	function delete_data_renja($id=""){
		$status_locking=$this->cek_is_open_lock('renja');
		if($status_locking=="0"){
			echo "<i class='glyphicon glyphicon-lock'></i> Pengisian / Perubahan Data Dikunci Oleh Administrator ....";
			return false;
		}  
		$this->load->model("template_renja_model");     
		$this->template_renja_model->delete_data_renja($id);    
	}
	function add_program($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("template_renja_model");
		 if($tipe_input=="1"){
			 $info=$this->template_renja_model->get_row($id);	
			 $data['infouser']['komponen_input']=$info->program;
			 $data['infouser']['sasaran_program']=trim($info->sasaran_program) ;
			 $data['infouser']['program']=$info->komponen_input;
		 }	 
		 $data['id_template_renja']=$id;
		 $data['parent']=$this->template_renja_model->get_parent_program($id);
 		 $data['id']=$id;
 		 $data['tipe_input']=$tipe_input;
		 $data['kl']=""; 
 		 $this->load->view('template_renja/form/form_program',$data);
	}
	function add_form_indikator($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("template_renja_model"); 
		 $data['parent']=$this->template_renja_model->get_parent_indikator($id);
 		 $data['id']=$id;
 		 $data['tipe_input']=$tipe_input;
		 $data['kl']=""; 
 		 $this->load->view('template_renja/form/form_indikator',$data);
	}
	function update_form_indikator($id="",$tipe_input=""){
		 $this->load->model("template_renja_model"); 
		 $info=$this->template_renja_model->get_row($id);	
		 $data['infouser']['program']=$info->program;
		 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
		 $data['infouser']['indikator']=trim($info->indikator);
		 $data['infouser']['komponen_input']=$info->komponen_input;
		 $data['infouser']['kode']=$info->kode;
		 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
		 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
		 $data['infouser']['target']=($info->target);
		
		 $data['infouser']['target_kinerja']=($info->target_kinerja);
		 $data['infouser']['target_keuangan']=($info->target_keuangan);
		

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
 		 $data['parent']=$this->template_renja_model->get_parent_indikator($id);
 		 $this->load->view('template_renja/form/form_indikator',$data);
	}
	function add_form_komponen_input($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $data['tipe_input']=$tipe_input;
		 $this->load->model("template_renja_model"); 
		 $data['id']=$id;
		 $data['kl']=""; 		  
  		 $data['parent']=$this->template_renja_model->get_parent_komponen_input($id,'add');
  		  $data['kewenangan']=$this->template_renja_model->get_kewenangan();
 		 $this->load->view('template_renja/form/form_komponen_input',$data);
	} 
	function update_form_komponen_input($id="",$tipe_input=""){
		 $this->load->model("template_renja_model"); 
		 $info=$this->template_renja_model->get_row($id);	
		 $data['infouser']['program']=$info->program;
		 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
		 $data['infouser']['indikator']=trim($info->indikator);
		 $data['infouser']['kode']=trim($info->kode);
		 $data['infouser']['komponen_input']=$info->komponen_input;
		 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
		 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
		 $data['infouser']['urutan']=trim($info->urutan);
		 $data['infouser']['target']=($info->target);
		 $data['infouser']['bo01']=trim($info->bo01);
		 $data['infouser']['bo02']=trim($info->bo02);
		 $data['infouser']['bno_rm_p']=trim($info->bno_rm_p);
		 $data['infouser']['bno_rm_d']=trim($info->bno_rm_d);
		 $data['infouser']['bno_phln_p']=trim($info->bno_phln_p);
		 $data['infouser']['bno_phln_d']=trim($info->bno_phln_d);
		 $data['infouser']['pnbp']=trim($info->pnbp);
		 $data['infouser']['kl']=trim($info->kl);
		  $data['infouser']['target_kinerja']=($info->target_kinerja);
		 $data['infouser']['target_keuangan']=($info->target_keuangan);
		 $data['tipe_input']=$tipe_input;
		 $data['kl']=trim($info->kl);
		 $tipe=($info->tipe);
		 $data['id']=$id;
 		 $data['program']=trim($info->program); 
 		 $data['parent']=$this->template_renja_model->get_parent_komponen_input($id,'update');
 		 $data['kewenangan']=$this->template_renja_model->get_kewenangan($info->id_kewenangan);
 		 
 		 $this->load->view('template_renja/form/form_komponen_input',$data);
	}
	function add_form_sub_komponen_input($id="",$tipe_input=""){		
		$data['judul']='Data Template Renja'; 
		$this->load->model("template_renja_model"); 
		$data['id']=$id;
		$data['kl']="";
		$data['tipe_input']=$tipe_input;
 		$data['parent']=$this->template_renja_model->get_parent_sub_komponen_input($id,'add');
 		$this->load->view('template_renja/form/form_sub_komponen_input',$data);
	}
	function update_form_sub_komponen_input($id="",$tipe_input=""){
		 $data['judul']='Data Template Renja'; 
		 $this->load->model("template_renja_model"); 
		 $info=$this->template_renja_model->get_row($id);	
		 if($tipe_input!="0"){			 
			 $data['infouser']['program']=$info->program;
			 $data['infouser']['kode_indikator']=trim($info->kode_indikator);
			 $data['infouser']['indikator']=trim($info->indikator);
			 $data['infouser']['kode']=trim($info->kode);
			 $data['infouser']['komponen_input']=$info->komponen_input;
			 $data['infouser']['kode_komponen_input']=trim($info->kode_komponen_input);
			 $data['infouser']['sasaran_program']=trim($info->sasaran_program);
			 $data['infouser']['target']=($info->target);
			 $data['infouser']['urutan']=trim($info->urutan);
			 $data['infouser']['bo01']=trim($info->bo01);
			 $data['infouser']['bo02']=trim($info->bo02);
			 $data['infouser']['bno_rm_p']=trim($info->bno_rm_p);
			 $data['infouser']['bno_rm_d']=trim($info->bno_rm_d);
			 $data['infouser']['bno_phln_p']=trim($info->bno_phln_p);
			 $data['infouser']['bno_phln_d']=trim($info->bno_phln_d);
			 $data['infouser']['pnbp']=trim($info->pnbp);
			 $data['infouser']['kl']=trim($info->kl);
			 $data['kewenangan']=$this->template_renja_model->get_kewenangan($info->id_kewenangan);
		 	 $data['kl']=trim($info->kl); 
		 	 $tipe=($info->tipe);		
		 	
		 } else {
		 	$data['kl']=""; 
		 }
		 $data['program']=trim($info->program);
		 $data['tipe_input']=$tipe_input;
		 $data['id']=$id;
 		 $data['parent']=$this->template_renja_model->get_parent_sub_komponen_input($id,'update');
 		 $this->load->view('template_renja/form/form_sub_komponen_input',$data);
	}
	function get_url_file($id=""){
		$this->load->model("template_renja_model");     
		return $this->template_renja_model->get_url_file($id);    
	}
	function get_file_name($id=""){
		$this->load->model("template_renja_model");     
		return $this->template_renja_model->get_file_name($id);    
	}
	function download_app($id=""){
		$this->load->helper('download');
		$url_file=$this->get_url_file($id);
 		$nama_file=$this->get_file_name($id);
		$data = file_get_contents("uploads/".$url_file); // Read the file's contents
		$name = $nama_file;
		force_download($name, $data);
	}
	function rekap_renja($id=""){
		$this->load->model("template_renja_model"); 
		$data['judul']='Rekap Renja';
		$data['table']="<tr><td colspan='16'><center><img src='".base_url()."images/loading.gif'></center></td></tr>";
		//$data['table']=$this->template_renja_model->get_data_rekap($id);		
		$info=$this->template_renja_model->get_update($id);	
		$data['status_perbaikan']=$info->status_perbaikan;		 
		$data['pengkodean']=$this->template_renja_model->filter_get_pengkodean_renja();
		$data['direktorat']=$info->dari;	
		$data['nama']=strtoupper($info->nama_user);	 
		$data['tahapan_dokumen']=$this->template_renja_model->tahapan_dokumen($info->tahapan_dokumen);
		$data['kd_unit_kerja']=$info->kd_unit_kerja;		 
		$data['view']='template_renja/detail';
		$data['id']=$id; 
	    $this->load->view('index',$data);
	}
	function echo_table_renja($id=""){
		$this->load->model("template_renja_model"); 
		$data['table']=$this->template_renja_model->get_data_rekap($id);	
		$this->load->view('template_renja/table',$data);
	}
	function tandai($id=""){
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->tandai($id);
	}
	function load_kesalahan($id=""){
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->load_kesalahan($id);
	}
	function refresh(){
		$id=$this->input->post('id');
		$this->load->model("template_renja_model"); 
		$data['table']=$this->template_renja_model->get_data_rekap($id);
		echo  $data['table'];
	}
	function simpan_status_perbaikan(){
		$this->load->model("template_renja_model"); 
		$status_perbaikan=$this->input->post('status_perbaikan');
		$direktori = "uploads/";	
		$i=0;
		$newname="";
		$name="";
		$this->load->model("template_renja_model"); 
		 foreach ($_FILES["file_berkas"]["error"] as $key => $error) {
			$newname=date("Ymdhis");	
		    if ($error == UPLOAD_ERR_OK) {
		        $tmp_name = $_FILES["file_berkas"]["tmp_name"][$key];
		        $name = $_FILES["file_berkas"]["name"][$key];
		        $ext=substr(strrchr($name,'.'),1);
		        $newname=trim($newname.'_'.$name);
		        $newname = str_replace(' ', '', $newname);
 		        move_uploaded_file($tmp_name, $direktori."/".$newname); 		        
   		    }
		}		 
 		$this->template_renja_model->simpan_status_perbaikan($newname);
		$pesan='<i class="glyphicon glyphicon-ok-sign"></i> Sukses Simpan Data  <br>  <i class="glyphicon glyphicon-ok-sign"></i>  Melakukan Backup Data Ke History Persetujuan..';
		if($status_perbaikan!="0"){
			echo $pesan;
		} else {
			echo '<i class="glyphicon glyphicon-ok-sign"></i>  Sukses Meubah Data...';
		}
	}
	 
	function export_excel(){
		$this->load->model("template_renja_model"); 
		$data['judul']='Export Renja';
		$data['tahun_anggaran']=$this->template_renja_model->filter_tahun_anggaran();
		$data['get_direktorat']=$this->template_renja_model->filter_get_direktorat();
		$data['pengkodean']=$this->template_renja_model->filter_get_pengkodean();

		
		$data['table']="&nbsp;"; 
		$data['view']='template_renja/export'; 
	    $this->load->view('index',$data);
	}
	function refresh_export(){
		$id=$this->input->post('id');
		$this->load->model("template_renja_model"); 
		$data['table']=$this->template_renja_model->get_data_export();	
 		echo  $data['table'];
	}
	function export_now(){
		$this->load->model("template_renja_model"); 
		$data['t_sum_bo_01']=$this->input->post('t_sum_bo_01');
		$data['t_sum_bo_02']=$this->input->post('t_sum_bo_02');
		$data['t_sum_bno_rm_p']=$this->input->post('t_sum_bno_rm_p');
		$data['t_sum_bno_rm_d']=$this->input->post('t_sum_bno_rm_d');
		$data['t_sum_bno_phln_p']=$this->input->post('t_sum_bno_phln_p');
		$data['t_sum_bno_phln_d']=$this->input->post('t_sum_bno_phln_d');
		$data['t_sum_bno_pnbp']=$this->input->post('t_sum_bno_pnbp');
		$data['t_sum_pagu']=$this->input->post('t_sum_pagu');
		$data['table']=$this->template_renja_model->get_data_export();	
		$data['file_name']="LAPORAN_RENJA_".date("YMDHIS");
		$this->load->view('template_renja/export/excel',$data);	 
	}
	function simpan_komponen_input($id=""){
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->simpan_komponen_input($id);
	} 
	function set_numbering($id=""){
		$this->load->model("template_renja_model"); 
		$this->template_renja_model->set_numbering($id);
	}

	function log_persetujuan($id=""){
	   $this->load->model("template_renja_model");     
	   $info=$this->template_renja_model->get_update($id);	
  	   $data['query']=$this->template_renja_model->log_persetujuan($info->darisiapaya,$info->tahun_anggaran);  
 
       $this->load->view('template_renja/data_log_renja',$data);	 
 	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */