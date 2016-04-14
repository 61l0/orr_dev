<?php  

class backup_db extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function backup_db() {
        parent::__construct();
       
    }	
	
 	function index($limit='',$offset=''){
		$this->load->model("init"); 
		$this->init->getLasturl();		
		$this->load->model("backup_db_model"); 
 		$data['judul']='Master Backup';
		$data['view']='backup_db/list';
		$this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("backup_db_model"); 
		$data['judul']='Master media';
 
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->backup_db_model->count();
		$config['base_url'] = base_url().'backup_db/search/';
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
		$data['query']=$this->backup_db_model->getdata($limit,$offset);
		$this->load->view('backup_db/data',$data);
	}
	function aktif($id=""){
		$this->load->model("backup_db_model"); 
		$this->backup_db_model->aktif($id);
	}
	function form($id=''){
		$this->load->model("backup_db_model"); 
		$data['judul']='Backup Database';
		if($id!=''){
		$info=$this->backup_db_model->get_update($id);		 
			$data['infouser']['id']=$info->id;
			$data['infouser']['tanggal']=$info->tanggal;
			$data['infouser']['url']=$info->url;
		}
 		$data['id']=$id;	
		$data['view']='backup_db/form';
		$this->load->view('index',$data);
	}
	function act(){
		$this->load->model("backup_db_model"); 
		$this->backup_db_model->act();
	}	
	function deletedata($id=''){
		$this->load->model("backup_db_model"); 
		$this->backup_db_model->deletedata($id);
	}
	function restore($id=""){
		$this->load->model("backup_db_model"); 
		$data['id_backup']=$id;
		$zip = new ZipArchive;
		$info=$this->backup_db_model->get_update($id);
		$location=$info->url;
		if ($zip->open("db/".$location) === TRUE) {
		    $zip->extractTo('db/extract/');
		    $zip->close();
 		} else {
 		}
 		$data['infouser']['judul']="DATA EXISTING";
 		$data['infouser']['note']="";
 		$data['infouser']['tujuan']="";
 		$data['infouser']['dari']="";
 		$data['infouser']['tanggal']="";

		$data['info_log']['judul']="DATA BACKUP";
 		$data['info_log']['note']="";
 		$data['info_log']['tujuan']="";
 		$data['info_log']['dari']="";
 		$data['info_log']['tanggal']="";
		$data['view']='backup_db/form_restore';

		$this->load->view('index',$data);
	}
	function di_restore_dulu_sob(){
		$this->load->model("backup_db_model"); 
		$this->backup_db_model->di_restore_dulu_sob();
	}
	function read_progress(){
		 $c="";
		 $progress=$this->session->userdata('IS_BACKUP_PROGRESS');
 			$progress_bar='<div class="progress">
			  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$progress.'%">
			    <span class="sr-only">"'.$progress.'"% Complete (success)</span>
			  </div>
			</div>';
		echo $progress_bar;
	 
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */