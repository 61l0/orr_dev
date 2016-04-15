<?php  

class renja extends CI_Controller {
 
	var $limit=10;
	var $offset=10;	
	public function renja() {
        parent::__construct();
        if ($this->session->userdata('LOGIN') != 'TRUE') {
           redirect('home/loginPage');			
        } 
    }	
 	function index($limit='',$offset=''){
 	   $this->load->model("renja_model");      
 	   $data['judul']='Renja'; 
       $data['view']='renja/list';
	   $this->load->view('index',$data);
	}
	function search($limit='',$offset=''){
	 	$this->load->model("renja_model"); 
		$data['judul']='Master Renja';
		/* VAGINATION */
		if($limit==''){ $limit = 0; $offset=10 ;}
		if($limit!=''){ $limit = $limit ; $offset=$this->offset ;}
		$data['count']=$this->renja_model->count();
		$config['base_url'] = base_url().'renja/search/';
		$config['total_rows'] = $data['count'];
		$config['per_page'] = $this->limit;    
		$config['cur_tag_open'] = '<span class="pg">';
		$config['cur_tag_close'] = '</span>';		
		$this->pagination->initialize($config);
		/*----------------*/
		$data['query']=$this->renja_model->get_data($limit,$offset);
		$this->load->view('renja/data',$data);
	}
	function form($id=''){
 		$this->load->model("renja_model"); 
 		$data['judul']='Tambah / Ubah';
		if($id!=''){
		$info=$this->renja_model->get_update($id);		 
 			$data['infouser']['judul']=$info->judul;
			$data['tahun_anggaran']=$this->renja_model->get_tahun_anggaran($info->tahun_anggaran);
		} else {
			$data['tahun_anggaran']=$this->renja_model->get_tahun_anggaran();
		}
		$data['id']=$id;
		$data['view']='renja/form';
		$this->load->view('index',$data);
	}
	function cek(){
		$judul=$this->input->post('judul');
		$tahun_anggaran=$this->input->post('tahun_anggaran');
		if($judul==""){
			echo "JUDUL TIDAK BOLEH KOSONG";
		} elseif($tahun_anggaran==""){
			echo "TAHUN ANGGRAN TIDAK BOLEH KOSONG";
		} 
	}
	function simpan(){
		$direktori = "uploads/";	
		$i=0;
		$this->load->model("renja_model"); 
		foreach ($_FILES["file_berkas"]["error"] as $key => $error) {
			$newname=date("Ymdhis");	
		    if ($error == UPLOAD_ERR_OK) {
		        $tmp_name = $_FILES["file_berkas"]["tmp_name"][$key];
		        $name = $_FILES["file_berkas"]["name"][$key];
		        $ext=substr(strrchr($name,'.'),1);
		        $newname=trim($newname.'_'.$name);
		        $newname = str_replace(' ', '', $newname);
 		        move_uploaded_file($tmp_name, $direktori."/".$newname);
				$this->renja_model->import_renja($newname);
  		    }
		}
		
		$this->renja_model->simpan();	 
	}	
	function rekap_renja($id=""){
		$this->load->model("renja_model"); 
		$data['judul']='Rekap Renja';
		$data['table']=$this->renja_model->get_data_rekap($id);
		$data['view']='renja/detail';
	    $this->load->view('index',$data);
	}
	function delete_data($id=""){
		$this->load->model("renja_model");     
		$this->renja_model->delete_data($id);     
	}
	function baca_excel(){
       $this->load->model("renja_model");       
       $data['table']=$this->renja_model->baca_excel();
	   $data['view']='renja/excel';
	   $this->load->view('index',$data);
	}
	function cek_total_excel(){
		$this->load->model("renja_model");       
		$this->renja_model->cek_total_excel();
	}
	function read_excel(){
		$file = 'd:/renja.xls';
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
 		//$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	 	//extract to a PHP readable array format
	 	$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		$i=19;
		$table="<table border='1' style='width:100%'> ";
		for($i;$i<=$highestRow;$i++){ 
		 if ($sheet->getRowDimension($i)->getVisible()) { 
	  		$table.="<tr>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(0, $i)))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(1, $i)))."</td>";
        	$table.="<td  tyle='vertical-align:middle;font-size:12px'>".  strtoupper(trim($sheet->getCellByColumnAndRow(2, $i)))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(3, $i)))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(4, $i)))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(5, $i)))."</td>";

        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(5, $i)))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(14, $i)))."</td>";

        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(15, $i)->getCalculatedValue()))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(16, $i)->getCalculatedValue()))."</td>";

        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(17, $i)->getCalculatedValue()))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(18, $i)->getCalculatedValue()))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(19, $i)->getCalculatedValue()))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(20, $i)->getCalculatedValue()))."</td>";
        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(21, $i)->getCalculatedValue()))."</td>";

        	$table.="<td  style='vertical-align:middle;font-size:12px'>". strtoupper(trim($sheet->getCellByColumnAndRow(31, $i)))."</td>";
 			$table.="</tr>"; 
			} 
		}
		$table.="</table>";
		echo $table;
	}		

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */