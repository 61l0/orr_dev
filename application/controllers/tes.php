<?php  
class tes extends CI_Controller { 
	var $limit=5;
	var $offset=5;	
	public function tes() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/login_page');			
        } 
    }	
	function index($limit='',$offset=''){
		 echo "DOSOL";

	}
	 
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */