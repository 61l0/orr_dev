<?php  

class notifikasi extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function notifikasi() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
    }	
 	function index($limit='',$offset=''){ 
 	   $this->load->model("notifikasi_model");      
 	   $data['judul']='Data Notifikasi'; 
 	   $data['status_persetujuan_renja']=$this->notifikasi_model->get_status_persetujuan_renja();
 	   $data['status_persetujuan_capaian']=$this->notifikasi_model->get_status_persetujuan_capaian();

 	   $data['status_keterisian_capaian_kinerja']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_kinerja');
	   $data['status_keterisian_capaian_keuangan']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_keuangan');
 	   $data['status_keterisian_capaian_phln']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_phln');
 	   $data['status_keterisian_capaian_dktp']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_dktp');
 	   $data['status_keterisian_capaian_renaksi']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_renaksi');
 
 	   //$data['detail_status_pengiriman']=$this->notifikasi_model->detail_status_pengiriman();
 	   //$data['detail_status_pengiriman_acuan']=$this->notifikasi_model->detail_status_pengiriman_acuan();
 	   $data['status_pengiriman']=count($data['status_persetujuan_renja']) + 
 	   count($data['status_persetujuan_capaian']) + count( $data['status_keterisian_capaian_kinerja']) + count($data['status_keterisian_capaian_keuangan']);
 //	   + count($data['status_keterisian_capaian_phln'])+ count($data['status_keterisian_capaian_dktp']) + count($data['status_keterisian_capaian_renaksi']);	


       $data['view']='notifikasi/list';
	   $this->load->view('index',$data);
	}
	function get_notifikasi(){
		$this->load->model("notifikasi_model");    
		 $data['status_persetujuan_renja']=$this->notifikasi_model->get_status_persetujuan_renja();
 	   $data['status_persetujuan_capaian']=$this->notifikasi_model->get_status_persetujuan_capaian();

 	   $data['status_keterisian_capaian_kinerja']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_kinerja');
	   $data['status_keterisian_capaian_keuangan']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_keuangan');
 	   $data['status_keterisian_capaian_phln']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_phln');
 	   $data['status_keterisian_capaian_dktp']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_dktp');
 	   $data['status_keterisian_capaian_renaksi']=$this->notifikasi_model->get_status_keterisian_capaian('capaian_renaksi');
 
 	    
 	   echo $data['status_pengiriman']=count($data['status_persetujuan_renja']) + 
 	   count($data['status_persetujuan_capaian']) + count( $data['status_keterisian_capaian_kinerja']) + count($data['status_keterisian_capaian_keuangan']);

 	   //+ count($data['status_keterisian_capaian_phln'])+ count($data['status_keterisian_capaian_dktp']) + count($data['status_keterisian_capaian_renaksi']);	


		 
	}
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */