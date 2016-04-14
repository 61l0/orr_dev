<?php  

class upload extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function upload() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
    }	
 	function index($limit='',$offset=''){
 	   $this->load->model("upload_model");      
 	   $data['judul']='Data Pengiriman File'; 
       $data['view']='upload/list';
 	   $data['dari']=$this->upload_model->filter_dari();
 	   $data['tujuan']=$this->upload_model->filter_tujuan();
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("upload_model"); 
		$data['judul']='Master Upload';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=10 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->upload_model->count();
		$config['base_url'] = base_url().'upload/search/';
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
		$data['query']=$this->upload_model->get_data($limit,$offset);
		$this->load->view('upload/data',$data);
	}
	function form($id=''){
 		$this->load->model("upload_model"); 
 		$data['judul']='Form Pengiriman File';
		if($id!=''){
		$info=$this->upload_model->get_update($id);		 
 			$data['infouser']['judul']=$info->judul;
 			$data['infouser']['note']=$info->note;
			$data['kepada']=$this->upload_model->get_kepada($info->kepada);
		} else {
			$data['kepada']=$this->upload_model->get_kepada();
		}
		$data['id']=$id;
		$data['view']='upload/form';
		$this->load->view('index',$data);
	}
	function cek(){
		$judul=$this->input->post('judul');
		$note=$this->input->post('note');
		if($judul==""){
			echo "JUDUL TIDAK BOLEH KOSONG";
		} elseif($note==""){
			echo "NOTE ANGGRAN TIDAK BOLEH KOSONG";
		} 
	}
	function simpan(){
		$direktori = "uploads/";	
		$i=0;
		$newname="";
		$name="";
		$this->load->model("upload_model"); 
		$extensionList =  array('xlsm');
		foreach ($_FILES["file_berkas"]["error"] as $key => $error) {
			$newname=date("Ymdhis");	
		    if ($error == UPLOAD_ERR_OK) {
		        $tmp_name = $_FILES["file_berkas"]["tmp_name"][$key];
		        $name = $_FILES["file_berkas"]["name"][$key];
		        $ext=substr(strrchr($name,'.'),1);
		        $newname=trim($newname.'_'.$name);
		        $newname = str_replace(' ', '', $newname);	
		        $fileName = $_FILES['file_berkas']['name'];
                $pecah = explode(".", $name);  
			    $belah = count($pecah);
			    $ekstensi = strtolower($pecah[$belah-1]); 			     
			   if (in_array($ekstensi, $extensionList)){
			         move_uploaded_file($tmp_name, $direktori."/".$newname);
			    }else{
			    	 echo '<link href="'.base_url().'/css/bootstrap.css" rel="stylesheet"><br><br><center>';	
	 
			      	 echo "<span class='alert alert-warning'>File Yang Di Upload Tidak Sesuai , File Harus Memiliki Extensi *.XLMS</span></center> <style>div{display:none;}</style>";	
			   		return false;
			    }
 			 }
		}
		
		$this->upload_model->simpan($newname,$name);	 
	}	
	 
	function delete_data($id=""){
		$this->load->model("upload_model");     
		$this->upload_model->delete_data($id);     
	}
	 
	function get_url_file($id=""){
		$this->load->model("upload_model");     
		return $this->upload_model->get_url_file($id);    
	}
	function get_file_name($id=""){
		$this->load->model("upload_model");     
		return $this->upload_model->get_file_name($id);    
	}
	function download_app($id=""){
		$this->load->helper('download');
		$url_file=$this->get_url_file($id);
 		$nama_file=$this->get_file_name($id);
		$data = file_get_contents("uploads/".$url_file); // Read the file's contents
		$name = $nama_file;
		force_download($name, $data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */