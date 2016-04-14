<?php  

class tahapan_dokumen extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function tahapan_dokumen() {
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
		
		 
		$data['view']='tahapan_dokumen/list';
		$this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("tahapan_dokumen_model"); 
		$data['judul']='Master Barang';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->tahapan_dokumen_model->count();
		$config['base_url'] = base_url().'tahapan_dokumen/search/';
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
		$data['query']=$this->tahapan_dokumen_model->get_data($limit,$offset);
		$this->load->view('tahapan_dokumen/data',$data);
	}
	function form($id=''){
		$this->load->model("tahapan_dokumen_model"); 
		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->tahapan_dokumen_model->getUpdate($id);		 
 			$data['infouser']['nama']=$info->nama_tahapan;
 			$data['infouser']['kode']=$info->id_dokumen;
  		} else {
			$data['pusat']="0";
			$data['mark_as_kewenangan']="0";
		}
 		$data['id']=$id;	
		$data['view']='tahapan_dokumen/form';
		$this->load->view('index',$data);
	}
	function act(){
		$this->load->model("tahapan_dokumen_model"); 
		$this->tahapan_dokumen_model->act();		 
	}	
	function delete_data($id=''){
		$this->load->model("tahapan_dokumen_model"); 
		$this->tahapan_dokumen_model->delete_unit($id);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */