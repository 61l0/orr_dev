<?php  

class pesan extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function pesan() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
        
    }	
 	function index($limit='',$offset=''){
 	   $this->load->model("pesan_model");      
 	   $data['judul']='Pesan'; 
       $data['view']='pesan/list';
       $data['tujuan']=$this->input->post('tujuan');
 	   $data['get_user']=$this->pesan_model->get_user();
 	   /*$data['tujuan']=$this->upload_model->filter_tujuan();*/
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("pesan_model"); 
		$data['judul']='';
		 
		$data['tujuan']=$this->input->post('tujuan');
		$data['query']=$this->pesan_model->get_data($limit,$offset);
		$this->load->view('pesan/data',$data);
	}
	function simpan(){
		$this->load->model("pesan_model"); 
		$this->pesan_model->simpan();
	} 

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */