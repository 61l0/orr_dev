<?php  

class kewenangan extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function kewenangan() {
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
		
		$this->load->model("kewenangan_model"); 
		$data['judul']='Master Unit / Divisi';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->kewenangan_model->count($limit,$offset);
		$config['base_url'] = base_url().'kewenangan/search/';
		$config['total_rows'] = $data['count'];
		$config['per_page'] = $this->limit;    
		$config['cur_tag_open'] = '<span class="pg">';
		$config['cur_tag_close'] = '</span>';		
		$this->pagination->initialize($config);
		/*----------------*/
		$data['query']=$this->kewenangan_model->list_skkpd($limit,$offset);
		$data['view']='kewenangan/list';
		$this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("kewenangan_model"); 
		$data['judul']='Master Barang';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->kewenangan_model->count();
		$config['base_url'] = base_url().'kewenangan/search/';
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
		$data['query']=$this->kewenangan_model->list_skkpd($limit,$offset);
		$this->load->view('kewenangan/data',$data);
	}
	function form($id=''){
		$this->load->model("kewenangan_model"); 
		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->kewenangan_model->getUpdate($id);		 
 			$data['infouser']['nama']=$info->nama_kewenangan;
 			$data['infouser']['kode']=$info->kode;
 			$data['mark_as_kewenangan']=$info->mark_as_kewenangan;
 		} else {
			$data['pusat']="0";
			$data['mark_as_kewenangan']="0";
		}
 		$data['id']=$id;	
		$data['view']='kewenangan/form';
		$this->load->view('index',$data);
	}
	function act(){
		$this->load->model("kewenangan_model"); 
		$this->kewenangan_model->act();		 
	}	
	function delete_data($id=''){
		$this->load->model("kewenangan_model"); 
		$this->kewenangan_model->delete_unit($id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */