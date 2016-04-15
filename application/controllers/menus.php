<?php  

class menus extends CI_Controller {
 
	var $limit=5;
	var $offset=5;	
	public function menus() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/login_page');			
        } 
        $this->load->model("init"); 
	    $this->init->getLasturl();
    }	
	function index($limit='',$offset=''){
		$this->load->model("init"); 
		$this->init->getLasturl();
		
		if($this->session->userdata('LOGIN')=='TRUE'){
		$this->load->model("menu_model"); 
		$this->load->model("user_model"); 
		
		$data['judul']='Menu';
		$data['view']='menus/list';
		$this->load->view('index',$data);
		}else {
		redirect('home/loginPage');		
		}

	}
	function search($limit='',$offset=''){
	 	$this->load->model("menu_model"); 
		/* VAGINATION */
	 

		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=5 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->menu_model->count();	
		$config['base_url'] = base_url().'menus/search/';
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
		$data['query']=$this->menu_model->getMenus($limit,$offset);
		$this->load->view('menus/data',$data);
	}
	
	function add($id=''){		 
		$this->load->model("menu_model"); 
		$this->load->model("user_model"); 
		$data['judul']='Tambah / Ubah Menu';
		$data['menu']=$this->user_model->getMenu();
		if($id!=''){
		$info=$this->menu_model->get_update($id);		 
			$data['inforole']['name']=$info->name;
			$data['inforole']['url']=$info->url;
			$data['inforole']['id']=$info->id;
			$data['inforole']['urut']=$info->urut;
			$data['inforole']['icon']=$info->icon;
			$data['parent']=$this->user_model->get_parent($info->parent); 
		}	else {
			$data['parent']=$this->user_model->get_parent();  
		}
 		$data['view']='menus/form';
		$this->load->view('index',$data);

	}
	 
	function cek_url_exist(){
		$this->load->model("menu_model"); 
		$cek=$this->menu_model->cek_url_exist();
		return $cek;
	}
	function simpan(){
		$cek=$this->cek_url_exist();
		$this->load->model("menu_model"); 
		if($this->input->post('name')==''){
			echo "Nama Menu Tidak Boleh Kosong"; return false;
		}  
		else if($this->input->post('url')==''){
			echo "Url Tidak Boleh Kosong"; return false;
		} else{
			$this->menu_model->simpan();
		}
	}
	
	 function deletemenu($id){
		$this->load->model("menu_model"); 
		$this->menu_model->deletemenu($id);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */