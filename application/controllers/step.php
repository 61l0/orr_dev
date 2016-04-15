<?php  

class step extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function step() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
    }	
 	function index($limit='',$offset=''){ 
 	   $this->load->model("notifikasi_model");      
 	   $data['judul']='Buku Panduan'; 
 	   $data['view']='panduan/list';
	   $this->load->view('index',$data);
	}
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */