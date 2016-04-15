<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Master extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
	}
    
   function user()
	{	
	 $this->index('0','user','id_user','nama','User','user','');
	} 
   
   function index($offset=0,$lctabel,$field,$field1,$judul,$list,$lccari)
	{
		$data['page_title'] = "Master Data $judul";
		//echo CI_VERSION;
		//$total_rows = $this->master_model->get_count($lctabel);
        if(empty($lccari)){
            $total_rows = $this->master_model->get_count($lctabel);
            $lc = "/.$lccari";
        }else{
            $total_rows = $this->master_model->get_count_teang($lctabel,$field,$field1,$lccari);
            $lc = "";
        }
		// pagination        
        if(empty($lccari)){
		$config['base_url']		= site_url("master/".$list);
        }else{
        $config['base_url']		= site_url("master/cari_".$list);    
        }
		$config['total_rows'] 	= $total_rows;
		$config['per_page'] 	= '10';
		$config['uri_segment'] 	= 3;
		$config['num_links'] 	= 5;
		$config['full_tag_open'] = '<ul class="page-navi">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current">';
		$config['cur_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$limit            		= $config['per_page'];  
		$offset         		= $this->uri->segment(3);  
		$offset         		= ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
		  
		if(empty($offset))  
		{  
			$offset=0;  
		}
	    //$data['isi']=$this->aktif_menu();
        //$data['isi']=$this->aktif_menu(); 
        //$data['isi']= $this->session->userdata('lcisi');         
		//$data['list'] 		= $this->master_model->getAll($lctabel,$field,$limit, $offset);
         if(empty($lccari)){     
		$data['list'] 		= $this->master_model->getAll($lctabel,$field,$limit, $offset);
        }else {
            $data['list'] 		= $this->master_model->getCari($lctabel,$field,$field1,$limit, $offset,$lccari);
        }
		$data['num']		= $offset;
		$data['total_rows'] = $total_rows;
		
				$this->pagination->initialize($config);
		$a=$judul;
		$this->template->set('title', 'Master Data ');
		$this->template->load('template', "master/".$list."/list", $data);
	}
     
   function mskpd()
    {
        $data['page_title']= 'Master SKPD';
        $this->template->set('title', 'Master SKPD');   
        $this->template->load('template','master/skpd/mskpd',$data) ; 
    }
    
    function mprogram()
    {
        $data['page_title']= 'Master PROGRAM';
        $this->template->set('title', 'Master PROGRAM');   
        $this->template->load('template','master/program/mprogram',$data) ; 
    }
    
    function mprogram_baru()
    {
        $data['page_title']= 'Master PROGRAM';
        $this->template->set('title', 'Master PROGRAM');   
        $this->template->load('template','master/program/mprogram_baru',$data) ; 
    }
    
    function mkegiatan()
    {
        $data['page_title']= 'Master KEGIATAN';
        $this->template->set('title', 'Master KEGIATAN');   
        $this->template->load('template','master/kegiatan/mkegiatan',$data) ; 
    }
    
    function mkegiatan_baru()
    {
        $data['page_title']= 'Master KEGIATAN';
        $this->template->set('title', 'Master KEGIATAN');   
        $this->template->load('template','master/kegiatan/mkegiatan_baru',$data) ; 
    }
    
    function moutput()
    {
        $data['page_title']= 'Master Output';
        $this->template->set('title', 'Master KEGIATAN');   
        $this->template->load('template','master/output/moutput',$data) ; 
    }
    
     function load_program() {
        $dept     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kddept='$dept'";
        if ($kriteria <> ''){                               
            $where="where kddept='$dept' and (upper(nmprogram) like upper('%$kriteria%') or kdprogram like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_program $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT kdprogram,nmprogram,pelaksana,status,IF(status='3','Berlanjut',IF(status='4','Baru','Berhenti')) AS ket from t_program $where order by kdprogram limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_program' => $resulte['kdprogram'],        
                        'nm_program' => $resulte['nmprogram'],
                        'pelaksana' => $resulte['pelaksana'],
                        'status' => $resulte['status'],
                        'ket'=>  $resulte['ket']                                                                              
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_program_baru() {
        $dept     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kddept='$dept' and status='4'";
        if ($kriteria <> ''){                               
            $where="where kddept='$dept' and status='4' and (upper(nmprogram) like upper('%$kriteria%') or kdprogram like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_program $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT kdprogram,nmprogram,pelaksana,status,IF(status='3','Berlanjut',IF(status='4','Baru','Berhenti')) AS ket from t_program $where order by kdprogram limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_program' => $resulte['kdprogram'],        
                        'nm_program' => $resulte['nmprogram'],
                        'pelaksana' => $resulte['pelaksana'],
                        'status' => $resulte['status'],
                        'ket'=>  $resulte['ket']                                                                              
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_kegiatan() {
        $dept     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kddept='$dept'";
        if ($kriteria <> ''){                               
            $where="where kddept='$dept' and (upper(nmgiat) like upper('%$kriteria%') or kdgiat like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_giat $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT kdgiat,kdprogram,nmgiat,pelaksana,kl,status,IF(status='3','Berlanjut',IF(status='4','Baru','Berhenti')) AS ket from t_giat $where order by kdgiat limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kdgiat'], 
                        'kd_program' => $resulte['kdprogram'],       
                        'nm_kegiatan' => $resulte['nmgiat'],
                        'pelaksana' => $resulte['pelaksana'],
                        'kl' => $resulte['kl'],
                        'status' => $resulte['status'],
                        'ket'=>  $resulte['ket']                                                                             
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_kegiatan_baru() {
        $dept     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kddept='$dept' and status='4'";
        if ($kriteria <> ''){                               
            $where="where kddept='$dept' and status='4' and (upper(nmgiat) like upper('%$kriteria%') or kdgiat like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_giat $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT kdgiat,kdprogram,nmgiat,pelaksana,kl,status,IF(status='3','Berlanjut',IF(status='4','Baru','Berhenti')) AS ket from t_giat $where order by kdgiat limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_kegiatan' => $resulte['kdgiat'], 
                        'kd_program' => $resulte['kdprogram'],       
                        'nm_kegiatan' => $resulte['nmgiat'],
                        'pelaksana' => $resulte['pelaksana'],
                        'kl' => $resulte['kl'],
                        'status' => $resulte['status'],
                        'ket'=>  $resulte['ket']                                                                             
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function load_output() {
        $dept     = $this->session->userdata('kdskpd');
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ="where kddept='$dept' and ket='4'";
        if ($kriteria <> ''){                               
            $where="where kddept='$dept' and ket='4' and (upper(nmoutput) like upper('%$kriteria%') or kdoutput like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_new_output $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from t_new_output $where order by kdprogram,kdgiat,kdnewoutput limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_output' => $resulte['kdnewoutput'],
                        'kd_kegiatan' => $resulte['kdgiat'], 
                        'kd_program' => $resulte['kdprogram'],       
                        'nm_output' => $resulte['nmoutput'],
                        'satuan' => $resulte['sat'],                                                                              
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function sasaran_kl()
    {
        $data['page_title']= 'Sasaran Strategis K/L';
        $this->template->set('title', 'Sasaran Strategis K/L');   
        $this->template->load('template','master/skpd/sasaran_kl',$data) ; 
    }
    
    function sasaran_prog()
    {
        $data['page_title']= 'Sasaran Program';
        $this->template->set('title', 'Sasaran Program ');   
        $this->template->load('template','master/program/program',$data) ; 
    }
    
    function sasaran_prog_baru()
    {
        $data['page_title']= 'Sasaran Program';
        $this->template->set('title', 'Sasaran Program ');   
        $this->template->load('template','master/program/program_baru',$data) ; 
    }
    
    function sasaran_giat()
    {
        $data['page_title']= 'Sasaran Kegiatan';
        $this->template->set('title', 'Sasaran Kegiatan ');   
        $this->template->load('template','master/kegiatan/kegiatan',$data) ; 
    }
    
    function indikator_kl()
    {
        $data['page_title']= 'Indikator Kinerja Sasaran Strategis ';
        $this->template->set('title', 'Indikator Kinerja Sasaran Strategis');   
        $this->template->load('template','master/skpd/indikator_kl',$data) ; 
    }
    
    function indikator_prog()
    {
        $data['page_title']= 'Indikator Kinerja Sasaran Strategis ';
        $this->template->set('title', 'Indikator Kinerja Sasaran Strategis');   
        $this->template->load('template','master/skpd/indikator_prog',$data) ; 
    }
    
    function indikator_output()
    {
        $data['page_title']= 'Indikator Kinerja Kegiatan ';
        $this->template->set('title', 'Indikator Kinerja kegiatan');   
        $this->template->load('template','master/skpd/indikator_output',$data) ; 
    }
    
    function ambil_sasarankl($cskpd='') {
            
            $lccr = $this->input->post('q');
            $sql  = " SELECT nomor,nama FROM d_sasarankl  where kddept='$cskpd' and ( upper(nomor) like upper('%$lccr%') or upper(nama) like upper('%$lccr%') ) order by nomor";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'nomor'  => $resulte['nomor'],  
                            'nama'  => $resulte['nama']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
    function ambil_sasaranprog($cskpd='',$cprog='') {
            
            $lccr = $this->input->post('q');
            $sql  = " SELECT nosasprog,nmsasprog FROM d_sasaran_prog  where kddept='$cskpd' and kdprogram='$cprog' and ( upper(nosasprog) like upper('%$lccr%') or upper(nmsasprog) like upper('%$lccr%') ) order by nosasprog";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'nomor'  => $resulte['nosasprog'],  
                            'nama'  => $resulte['nmsasprog']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
    function ambil_program() {
        $dept     = $this->session->userdata('kdskpd');
        $lccr = $this->input->post('q');
        $sql = "SELECT kdprogram, nmprogram FROM t_program where kddept='$dept' and status <>'5' and (upper(kdprogram) like upper('%$lccr%') or upper(nmprogram) like upper('%$lccr%'))   order by kdprogram ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_program' => $resulte['kdprogram'],  
                        'nm_program' => $resulte['nmprogram']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ket() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd,ket from t_ket where  kd='3' or kd='5' order by kd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd' => $resulte['kd'],  
                        'ket' => $resulte['ket']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    
    
     function ket1() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd,ket from t_ket where kd='2' or kd='3' or kd='5' order by kd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd' => $resulte['kd'],  
                        'ket' => $resulte['ket']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ket2() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd,ket from t_ket where kd='3' or kd='4' or kd='5' order by kd";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd' => $resulte['kd'],  
                        'ket' => $resulte['ket']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function jns() {
        $lccr = $this->input->post('q');
        $sql = "SELECT jns from t_jns  ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'jns' => $resulte['jns']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function prop() {
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_prop where upper(kdprop) like upper('%$lccr%') or upper(nmprop) like upper('%$lccr%') order by kdprop";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdprop' => $resulte['kdprop'],
                        'nmprop' => $resulte['nmprop']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_prop_lst(){    
        $sql = "SELECT kdprop,nmprop FROM t_prop order by kdprop"; 
        $query1 = $this->db->query($sql); 
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        {        
        $result[] = array(
                    "label" => $resulte['kdprop']."||".$resulte['nmprop'],
                    "value" => $resulte['kdprop']
                                                      
                    );
                    $ii++;
        }       
        echo json_encode($result);
        $query1->free_result();
    }
    
    function kab($cprop='') {
            
    		$sql = "SELECT * from t_kab WHERE kdprop='$cprop' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdkab' => $resulte['kdkab'],
                            'nmkab' => $resulte['nmkab']                         
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    
    function dekon() {
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_dekon where upper(kddekon) like upper('%$lccr%') or upper(nmdekon) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kddekon' => $resulte['kddekon'],
                        'nmdekon' => $resulte['nmdekon']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function issue() {
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_issue where upper(kdissue) like upper('%$lccr%') or upper(nmissue) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdissue' => $resulte['kdissue'],
                        'nmissue' => $resulte['nmissue']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function sumber() {
        $dept     = $this->session->userdata('kdskpd');
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_sumber where kddept='$dept' and (upper(kdsumber) like upper('%$lccr%') or upper(nmsumber) like upper('%$lccr%') )";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdsumber' => $resulte['kdsumber'],
                        'nmsumber' => $resulte['nmsumber']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    function jenis_biaya() {
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_jenis where upper(kdjenisbiaya) like upper('%$lccr%') or upper(nmjenisbiaya) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdjenisbiaya' => $resulte['kdjenisbiaya'],
                        'nmjenisbiaya' => $resulte['nmjenisbiaya']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    function npphln($csumber='') {
            $dept     = $this->session->userdata('kdskpd');
    		$sql = "SELECT * from t_npphln WHERE kddept='$dept' and kdsumber='$csumber' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdnpphln' => $resulte['kdnpphln'],
                            'nmnpphln' => $resulte['nmnpphln']                         
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function jns_user() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd,jns from jns_user  ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd' => $resulte['kd'],
                        'jns' => $resulte['jns']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function parameter()
    {
        $data['page_title']= 'PARAMETER';
        $this->template->set('title', 'Parameter Inflasi');   
        $this->template->load('template','master/skpd/parameter',$data) ; 
    }
    function parameterbak()
    {
        $data['page_title']= 'PARAMETER BAK';
        $this->template->set('title', 'PARAMETER BAK');   
        $this->template->load('template','master/skpd/parameterbak',$data) ; 
    }
    function tambah_renstra()
	{
		
        $data['page_title']= 'Master Renstra';
        $this->template->set('title', 'Master Renstra');   
        
        $this->template->load('template','master/renstra/tambah_renstra',$data) ; 
   }
    
   function mapping_output_lama()
	{
		
        $data['page_title']= 'Master Renstra';
        $this->template->set('title', 'Master Renstra');   
        
        $this->template->load('template','master/renstra/mapping_output',$data) ; 
   } 
   
   function tambah_komponen()
	{
		
        $data['page_title']= 'Master Renstra';
        $this->template->set('title', 'Master Renstra');   
        
        $this->template->load('template','master/renstra/tambah_komponen',$data) ; 
   } 
   
    function ambil_urusan() {
        $lccr = $this->input->post('q');
        $sql = "SELECT kd_urusan, nm_urusan FROM ms_urusan where upper(kd_urusan) like upper('%$lccr%') or upper(nm_urusan) like upper('%$lccr%') ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kd_urusan' => $resulte['kd_urusan'],  
                        'nm_urusan' => $resulte['nm_urusan']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function ambil_output($cskpd='',$cprog='',$cgiat='') {
        $lccr = $this->input->post('q');
        $sql = "SELECT kdnewoutput,kdoutput, nmoutput,sat,satlama FROM t_new_output where kddept='$cskpd' and kdprogram='$cprog' and kdgiat='$cgiat' and (ket='1' or ket='4') group by kdnewoutput, nmoutput";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdnewoutput' => $resulte['kdnewoutput'],
                        'kdoutputlama' => $resulte['kdoutput'],  
                        'nmoutput' => $resulte['nmoutput'],
                        'sat' => $resulte['sat'],
                        'satlama' => $resulte['satlama']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function lokasi() {
        $lccr = $this->input->post('q');
        $sql = "SELECT * from t_lokasi";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kdlokasi' => $resulte['kdlokasi'],  
                        'nmlokasi' => $resulte['nmlokasi']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function load_skpd() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
        if ($kriteria <> ''){                               
            $where="where (upper(nmdept) like upper('%$kriteria%') or kddept like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from t_dept $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
        
        
        
        $sql = "SELECT * from t_dept $where order by kddept limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
                        'kd_skpd' => $resulte['kddept'],
                        'nm_skpd' => $resulte['nmdept']                                                                                       
                        );
                        $ii++;
        }
           
        $result["total"] = $total->tot;
        $result["rows"] = $row; 
        echo json_encode($result);
    	   
	}
    
    function select_visi($cskpd='') {
            
    		$sql = "SELECT * from t_visi WHERE kddept='$cskpd' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdvisi' => $resulte['kdvisi'],
                            'nmvisi' => $resulte['nmvisi']                         
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
     
     function select_misi($cskpd='') {
            
    		$sql = "SELECT * from t_misi WHERE kddept='$cskpd' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdmisi' => $resulte['kdmisi'],
                            'nmmisi' => $resulte['nmmisi']                         
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
        
     function select_sasaran_kl($cskpd='') {
            $dept     = $this->session->userdata('kdskpd');
    		$sql = "SELECT * from d_sasarankl WHERE kddept='$dept' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'nomor' => $resulte['nomor'],
                            'nama' => $resulte['nama'],
                            'pelaksana' => $resulte['pelaksana']                          
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_outcome($cskpd='',$cunit='',$cprog='') {
            
    		$sql = "SELECT * from d_sasaran_prog WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog'  ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'nosasprog' => $resulte['nosasprog'],        
                            'nmsasprog' => $resulte['nmsasprog'],
                            'nosasstra' => $resulte['nosasstra'],
                            'nmsasstra' => $resulte['nmsasstra']                           
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_outcome_baru($cskpd='',$cunit='',$cprog='') {
            
    		$sql = "SELECT * from d_sasaran_prog WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and status='4'";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'nosasprog' => $resulte['nosasprog'],        
                            'nmsasprog' => $resulte['nmsasprog'],
                            'nosasstra' => $resulte['nosasstra'],
                            'nmsasstra' => $resulte['nmsasstra']                           
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }  
    function select_output($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379') {
            
    	$sql = "SELECT * from d_item_output WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' AND kdgiat='$cgiat'  order by kdoutput";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdoutput' => $resulte['kdoutput'],  
                            'nmoutput' => $resulte['nmoutput'],  
                            'nosasprog' => $resulte['nosasprog'],
                            'noissustra' => $resulte['noissustra'],
                            'kddimensi' => $resulte['kddimensi'],
                            'kdsdimensi' => $resulte['kdsdimensi'],
                            'kdpbidang' => $resulte['kdpbidang'],
                            'kdspbidang' => $resulte['kdspbidang'],
                            'kdsspbidang' => $resulte['kdsspbidang'],
                            'kdnwcita' => $resulte['kdnwcita'],
                            'prioritas' => $resulte['prioritas'],
                            'vol' => $resulte['vol'],
                            'vol1' => $resulte['vol1'],
                            'vol2' => $resulte['vol2'],
                            'vol3' => $resulte['vol3'],
                            'vol4' => $resulte['vol4'],
                            'harga' => number_format($resulte['harga']),
                            'harga1' => number_format($resulte['harga1']),
                            'hrg1' => $resulte['harga1'],
                            'harga2' => number_format($resulte['harga2']),
                            'hrg2' => $resulte['harga2'],
                            'harga3' => number_format($resulte['harga3']),
                            'hrg3' => $resulte['harga3'],
                            'harga4' => number_format($resulte['harga4']),
                            'hrg4' => $resulte['harga4'],
                            'hrg' => $resulte['harga'],
                            'hrg1' => $resulte['harga1'],
                            'hrg2' => $resulte['harga2'],
                            'hrg3' => $resulte['harga3'],
                            'hrg' => $resulte['harga4'],
                            'dppp' => $resulte['dppp'],
                            'darg' => $resulte['darg'],
                            'dksst' => $resulte['dksst'],
                            'dmpi' => $resulte['dmpi'],
                            'ppban' => $resulte['ppban']
                                                  
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
        
        function select_dimensi() {
        $lccr = $this->input->post('q');
        $sql = "SELECT a.*,b.nmdimensi FROM t_sdimensi a INNER JOIN t_dimensi b ON a.kddimensi=b.kddimensi where upper(a.kddimensi) like upper('%$lccr%') or upper(a.nmsdimensi) like upper('%$lccr%') order by a.kddimensi,a.kdsdimensi ";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $result[] = array(
                        'id' => $ii,        
                        'kddimensi' => $resulte['kddimensi'],
                        'kdsdimensi' => $resulte['kdsdimensi'],
                        'nmdimensi' => $resulte['nmdimensi'],
                        'nmsdimensi' => $resulte['nmsdimensi']
                        );
                        $ii++;
        }
           
        echo json_encode($result);
    	   
	}
    
    function select_bidang1() {
            $lccr = $this->input->post('q');
            $sql = "SELECT a.kdpbidang,b.nmpbidang,a.kdspbidang,a.nmspbidang FROM t_spbidang a inner join t_pbidang b on a.kdpbidang=b.kdpbidang where a.kdpbidang not in('01','02','03') and  (upper(a.kdpbidang) like upper('%$lccr%') or upper(a.nmspbidang) like upper('%$lccr%')) ORDER BY a.kdpbidang,a.kdspbidang";
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdpbidang' => $resulte['kdpbidang'],  
                            'nmpbidang' => $resulte['nmpbidang'],
                            'kdspbidang' => $resulte['kdspbidang'],  
                            'nmspbidang' => $resulte['nmspbidang']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
    }
    
    function select_bidang($cbidang='') {
            $lccr = $this->input->post('q');
            $sql = "SELECT * FROM t_sspbidang where kdspbidang='$cbidang' and  (upper(kdpbidang) like upper('%$lccr%') or upper(nmsspbidang) like upper('%$lccr%'))   order by kdpbidang,kdspbidang,kdsspbidang ";
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdpbidang' => $resulte['kdpbidang'],  
                            'kdspbidang' => $resulte['kdspbidang'],
                            'kdsspbidang' => $resulte['kdsspbidang'],  
                            'nmsspbidang' => $resulte['nmsspbidang']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
    }
    
    function select_nawacita() {
            $lccr = $this->input->post('q');
            $sql = "SELECT * FROM t_nawacita where upper(kdnwcita) like upper('%$lccr%') or upper(nmnwcita) like upper('%$lccr%')   order by kdnwcita";
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdnwcita' => $resulte['kdnwcita'],  
                            'nmnwcita' => $resulte['nmnwcita']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
    }
        
    function select_output_renstra($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379') {
            
    	$sql = "SELECT a.kdoutput,a.nmoutput,b.vol2,b.vol3,b.vol4,b.vol5,SUM(a15) AS a15,SUM(a16) AS a16,SUM(a17) AS a17,SUM(a18) AS a18,SUM(a19) AS a19 FROM d_item_ikk a
                INNER JOIN t_new_output b ON a.kddept=b.kddept AND a.kdprogram=b.kdprogram AND a.kdgiat=b.kdgiat AND a.kdoutput=b.kdnewoutput
                WHERE a.kddept='$cskpd' and a.kdprogram='$cprog' AND a.kdgiat='$cgiat'  AND b.ket='4' GROUP BY  a.kdoutput,a.nmoutput";                   
           $query1 = $this->master_model->conn_renstra($sql);
            //$query1 = $this->userconn->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdoutput' => $resulte['kdoutput'],  
                            'nmoutput' => $resulte['nmoutput'],  
                            'vol1' => $resulte['vol2'],
                            'vol2' => $resulte['vol3'],
                            'vol3' => $resulte['vol4'],
                            'vol4' => $resulte['vol5'],
                            'total1' => $resulte['a16'],
                            'total2' => $resulte['a17'],
                            'total3' => $resulte['a18'],
                            'total4' => $resulte['a19']
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_output_baru($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379') {
            
    	$sql = "SELECT * from d_item_output WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' AND kdgiat='$cgiat' and status='4' order by kdoutput";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdoutput' => $resulte['kdoutput'],  
                            'nmoutput' => $resulte['nmoutput'],  
                            'nosasprog' => $resulte['nosasprog'],
                            'noissustra' => $resulte['noissustra'],
                            'prioritas' => $resulte['prioritas'],
                            'vol' => $resulte['vol'],
                            'vol1' => $resulte['vol1'],
                            'vol2' => $resulte['vol2'],
                            'vol3' => $resulte['vol3'],
                            'vol4' => $resulte['vol4'],
                            'harga' => number_format($resulte['harga']),
                            'harga1' => number_format($resulte['harga1']),
                            'harga2' => number_format($resulte['harga2']),
                            'harga3' => number_format($resulte['harga3']),
                            'harga4' => number_format($resulte['harga4']),
                            'hrg' => $resulte['harga'],
                            'hrg1' => $resulte['harga1'],
                            'hrg2' => $resulte['harga2'],
                            'hrg3' => $resulte['harga3'],
                            'hrg' => $resulte['harga4'],
                            'dppp' => $resulte['dppp'],
                            'darg' => $resulte['darg'],
                            'dksst' => $resulte['dksst'],
                            'dmpi' => $resulte['dmpi']
                                                  
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_indikatorkl($cskpd='001',$cprog='01') {
            
    		$sql = "SELECT * from d_indikatorkl WHERE kddept='$cskpd' and nomor_sasarankl='$cprog' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'nomor_sasarankl' => $resulte['nomor_sasarankl'],        
                            'nomor' => $resulte['nomor'],
                            'nama' => $resulte['nama'],
                            'vol1' => $resulte['vol1'], 
                            'vol2' => $resulte['vol2'], 
                            'vol3' => $resulte['vol3'], 
                            'vol4' => $resulte['vol4'],
                            'satuan' => $resulte['satuan']                            
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        } 
    function select_prio() {
            $lccr = $this->input->post('q');
            $sql = "SELECT kdprio, nmprio FROM t_prio where  (upper(kdprio) like upper('%$lccr%') or upper(nmprio) like upper('%$lccr%'))   order by kdprio ";
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'kdprio' => $resulte['kdprio'],  
                            'nmprio' => $resulte['nmprio']
                            );
                            $ii++;
            }
               
            echo json_encode($result);
    }
    function select_indikatorprog($cskpd='',$cunit='',$cprog='',$csasaran='') {
            
    		$sql = "SELECT * from d_indikator_prog WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and nosasprog='$csasaran' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'kdprogram' => $resulte['kdprogram'],
                            'nosasprog' => $resulte['nosasprog'],        
                            'noinsasprog' => $resulte['noinsasprog'],
                            'uraian' => $resulte['uraian'],
                            'vol1' => $resulte['vol'],
                            'vol2' => $resulte['vol1'], 
                            'vol3' => $resulte['vol2'], 
                            'vol4' => $resulte['vol3'], 
                            'vol5' => $resulte['vol4'],
                            'satuan' => $resulte['satuan']                           
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    
    function select_indikatoroutput($cskpd='',$cunit='',$cprog='',$cgiat='',$coutput='') {
            
    		$sql = "SELECT * from d_indikator_output WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and kdgiat='$cgiat' and kdoutput='$coutput' ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'nomor' => $resulte['nomor'],
                            'nama' => $resulte['nama'],
                            'vol1' => $resulte['vol1'],
                            'vol2' => $resulte['vol2'], 
                            'vol3' => $resulte['vol3'], 
                            'vol4' => $resulte['vol4'],
                            'satuan' => $resulte['satuan']                           
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_komponen($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379',$coutput='01') {
            
    		$sql = "SELECT * from d_kmpnen WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and kdgiat='$cgiat' and kdoutput='$coutput' order by kdkmpnen ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'kdkmpnen' => $resulte['kdkmpnen'],
                            'kdbiaya' => $resulte['kdbiaya'],
                            'urkmpnen' => $resulte['urkmpnen']                     
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_komponen_renstra($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379',$coutput='01') {
            
    		$sql = "SELECT * from t_new_komponen WHERE kddept='$cskpd' and kdprogram='$cprog' and kdgiat='$cgiat' and kdnewoutput='$coutput' order by kdkmpnen ";                   
            $query1 = $this->master_model->conn_renstra($sql);
            //$query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'kdkmpnen' => $resulte['kdkmpnen'],
                            'kdbiaya' => $resulte['jns'],
                            'nmkmpnen' => $resulte['nmkmpnen']                     
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
    function select_komponen_baru($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379',$coutput='01') {
            
    		$sql = "SELECT * from d_kmpnen WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and kdgiat='$cgiat' and kdoutput='$coutput' and status='4' order by kdkmpnen ";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'kdkmpnen' => $resulte['kdkmpnen'],
                            'kdbiaya' => $resulte['kdbiaya'],
                            'urkmpnen' => $resulte['urkmpnen']                     
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
        
    function select_lokasi($cskpd='033',$cunit='01',$cprog='01',$cgiat='2379',$coutput='01',$ckmpnen='01') {
            //033/01/01/2379/01/02
    		$sql = "SELECT * from d_lok WHERE kddept='$cskpd' and kdunit='$cunit' and kdprogram='$cprog' and kdgiat='$cgiat' and kdoutput='$coutput' and kdkmpnen='$ckmpnen' ";                   
            echo $sql;
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,
                            'kdprop' => $resulte['kdprop'],
                            'kdkab' => $resulte['kdkab'],
                            'kewe' => $resulte['kewenangan'],
                            'npphln' => $resulte['npphln'],
                            'kdsumber' => $resulte['kdsumber'],
                            'jenisphln' => $resulte['jenisphln'],
                            'volume' => $resulte['volume'],
                            'rupiah' => number_format($resulte['rupiah'],"1",".",","),
                            'rupiah1' => $resulte['rupiah'],
                            'pnbp' => number_format($resulte['pnbp'],"1",".",","),
                            'pnbp1' => $resulte['pnbp'],
                            'blu' => number_format($resulte['blu'],"1",".",","),
                            'blu1' => $resulte['blu'],
                            'pln' => number_format($resulte['pln'],"1",".",","),
                            'pln1' => $resulte['pln'],
                            'pdn' => number_format($resulte['pdn'],"1",".",","),
                            'pdn1' => $resulte['pdn'],
                            'hibah' => number_format($resulte['hibah'],"1",".",","),
                            'hibah1' => $resulte['hibah'],
                            'pend' => number_format($resulte['pend'],"1",".",","),
                            'pend1' => $resulte['pend'],
                            'sbsn' => number_format($resulte['sbsn'],"1",".",","),
                            'sbsn1' =>$resulte['sbsn'],
                            'paguphln' => number_format($resulte['sbsn'],"1",".",","),
                            'paguphln1' => $resulte['sbsn'],
                            'serap' => number_format($resulte['serap'],"1",".",","),
                            'serap1' => $resulte['serap'],
                            'tglawal' => $resulte['tglawal'],
                            'tglakhir' => $resulte['tglakhir'],
                            'jumlah' => number_format($resulte['jumlah'],"1",".",",")                     
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
               $query1->free_result();
        }
    function simpan_master(){
        
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        
        $sql = "select $cid from $tabel where $cid='$lcid'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    function simpan_master_prog(){
        $skpd     = $this->session->userdata('kdskpd');
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        
        $sql = "select $cid from $tabel where $cid='$lcid' and kddept='$skpd'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    function simpan_master1(){
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cprog = $this->input->post('cprog');
        $lcprog = $this->input->post('lcprog');
        $cgiat = $this->input->post('cgiat');
        $lcgiat = $this->input->post('lcgiat');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        $cidnew = $this->input->post('cidnew');
        $lcidnew = $this->input->post('lcidnew');

 
        
        $sql = "select $cid from $tabel where $cid='$lcid' and $cprog='$lcprog' and $cidnew='$lcidnew' and  $cgiat='$lcgiat'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    function simpan_master3(){
        //(kddept,kdunit,kdprogram,nosasprog,noinsasprog,uraian,vol,vol1,vol2,vol3,vol4)/('033','01','01','02','02','sonjaya','1','3','3','3','7')
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cdept = $this->input->post('cdept');
        $lcdept = $this->input->post('lcdept');
        $cprog = $this->input->post('cprog');
        $lcprog = $this->input->post('lcprog');
        $cunit= $this->input->post('cunit');
        $lcunit = $this->input->post('lcunit');
        $csasaran = $this->input->post('csasaran');
        $lcsasaran = $this->input->post('lcsasaran');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        
        $sql = "select $cid from $tabel where $cdept='$lcdept' and $cprog='$lcprog' and $cunit='$lcunit' and  $csasaran='$lcsasaran' and $cid='$lcid'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    function simpan_master5(){
        
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cdept = $this->input->post('cdept');
        $lcdept = $this->input->post('lcdept');
        $cprog = $this->input->post('cprog');
        $lcprog = $this->input->post('lcprog');
        $cunit= $this->input->post('cunit');
        $lcunit = $this->input->post('lcunit');
        $cgiat = $this->input->post('cgiat');
        $lcgiat = $this->input->post('lcgiat');
        $coutput = $this->input->post('coutput');
        $lcoutput = $this->input->post('lcoutput');
        $cid = $this->input->post('cid');
        $lcid = $this->input->post('lcid');
        
        $sql = "select $cid from $tabel where $cdept='$lcdept' and $cprog='$lcprog' and $cunit='$lcunit' and  $cgiat='$lcgiat' and $coutput='$lcoutput' and $cid='$lcid'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    function simpan_master6(){
   
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cdept = $this->input->post('cdept');
        $lcdept = $this->input->post('lcdept');
        $cprog = $this->input->post('cprog');
        $lcprog = $this->input->post('lcprog');
        $cunit= $this->input->post('cunit');
        $lcunit = $this->input->post('lcunit');
        $cgiat = $this->input->post('cgiat');
        $lcgiat = $this->input->post('lcgiat');
        $coutput = $this->input->post('coutput');
        $lcoutput = $this->input->post('lcoutput');
        $ckmpnen = $this->input->post('ckmpnen');
        $lckmpnen = $this->input->post('lckmpnen');
        $cprop = $this->input->post('cprop');
        $lcprop =$this->input->post('lcprop');
        $ckab = $this->input->post('ckab');
        $lckab = $this->input->post('lckab');
        
        $sql = "select $cprop from $tabel where $cdept='$lcdept' and $cprog='$lcprog' and $cunit='$lcunit' and  $cgiat='$lcgiat' and $coutput='$lcoutput' and $ckmpnen='$lckmpnen' and $cprop='$lcprop' and $ckab='$lckab'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    function simpan_master4(){
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        
        
       
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        
    }
    function simpan_master2(){
        $dept     = $this->session->userdata('kdskpd');
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cgiat = $this->input->post('cid');
        $lcgiat = $this->input->post('lcid');
        $cid = $this->input->post('cido');
        $lcid = $this->input->post('lcido');

 
        
        $sql = "select $cid from $tabel where kddept='$dept' and $cgiat='$lcgiat' and  $cid='$lcid'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    function simpan_master33(){
        $tabel  = $this->input->post('tabel');
        $lckolom = $this->input->post('kolom');
        $lcnilai = $this->input->post('nilai');
        $cgiat = $this->input->post('cid');
        $lcgiat = $this->input->post('lcid');
        $cid = $this->input->post('cido');
        $lcid = $this->input->post('lcido');
        $ckdn = $this->input->post('ckdn');
        $lckdn = $this->input->post('lckdn');

 
        
        $sql = "select $ckdn from $tabel where  $cgiat='$lcgiat' and  $cid='$lcid' and $ckdn='$lckdn'";
        $res = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into $tabel $lckolom values $lcnilai";
            $asg = $this->db->query($sql);
            if($asg){
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    function update_master(){
        $query = $this->input->post('st_query');
        //$query1 = $this->input->post('st_query1');
        $asg = $this->db->query($query);
        if($asg){
            echo '1';
        }else{
            echo '0';
        }
        //$asg1 = $this->db->query($query1);
  

    }
    
    function hapus_master3(){
       
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fkdx = $this->input->post('fkdx');
        $kdx = $this->input->post('kdx');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx'";
        $asg = $this->db->query($sql);
        $sql1 = "delete from d_indikator_prog where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx'";
        $asg1 = $this->db->query($sql1);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master4(){
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fkdx = $this->input->post('fkdx');
        $kdx = $this->input->post('kdx');
        $fnoinsasprog = $this->input->post('fnoinsasprog');
        $noinsasprog = $this->input->post('noinsasprog');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx' and $fnoinsasprog='$noinsasprog'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master44(){
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fkdx = $this->input->post('fkdx');
        $kdx = $this->input->post('kdx');
        $fnoinsasprog = $this->input->post('fnoinsasprog');
        $noinsasprog = $this->input->post('noinsasprog');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx' and $fnoinsasprog='$noinsasprog'";
        $asg = $this->db->query($sql);
        $sql1 = "delete from d_indikator_output where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx' and $fnoinsasprog='$noinsasprog'";
        $asg1 = $this->db->query($sql1);
        $sql2 = "delete from d_kmpnen where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx' and $fnoinsasprog='$noinsasprog'";
        $asg2 = $this->db->query($sql2);
        $sql3 = "delete from d_lok where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fkdx='$kdx' and $fnoinsasprog='$noinsasprog'";
        $asg3 = $this->db->query($sql3);
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master5(){
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fgiat = $this->input->post('fgiat');
        $cgiat = $this->input->post('cgiat');
        $fkdoutput = $this->input->post('fkdoutput');
        $kdoutput = $this->input->post('kdoutput');
        $fnoikk = $this->input->post('fnoikk');
        $cnoikk = $this->input->post('cnoikk');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fgiat='$cgiat' and $fkdoutput='$kdoutput' and $fnoikk='$cnoikk'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master55(){
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fgiat = $this->input->post('fgiat');
        $cgiat = $this->input->post('cgiat');
        $fkdoutput = $this->input->post('fkdoutput');
        $kdoutput = $this->input->post('kdoutput');
        $fnoikk = $this->input->post('fnoikk');
        $cnoikk = $this->input->post('cnoikk');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fgiat='$cgiat' and $fkdoutput='$kdoutput' and $fnoikk='$cnoikk'";
        $asg = $this->db->query($sql);
        $sql1 = "delete from d_lok where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fgiat='$cgiat' and $fkdoutput='$kdoutput' and $fnoikk='$cnoikk'";
        $asg1 = $this->db->query($sql1);
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master6(){
        $ctabel = $this->input->post('tabel');
        $fskpd = $this->input->post('fskpd');
        $skpd = $this->input->post('skpd');
        $fkdunit = $this->input->post('fkdunit');
        $kdunit = $this->input->post('kdunit');
        $fkdprogram = $this->input->post('fkdprogram');
        $kdprogram = $this->input->post('kdprogram');
        $fgiat = $this->input->post('fgiat');
        $cgiat = $this->input->post('cgiat');
        $fkdoutput = $this->input->post('fkdoutput');
        $kdoutput = $this->input->post('kdoutput');
        $fnokmp = $this->input->post('fnokmp');
        $cnokmp = $this->input->post('cnokmp');
        $fprop = $this->input->post('fprop');
        $cprop = $this->input->post('cprop');
        $fkab = $this->input->post('fkab');
        $ckab = $this->input->post('ckab');
        $msg = array();
        $sql = "delete from $ctabel where $fkdprogram='$kdprogram' and $fskpd='$skpd' and $fkdunit='$kdunit' and $fgiat='$cgiat' and $fkdoutput='$kdoutput' and $fnokmp='$cnokmp' and $fprop='$cprop' and $fkab='$ckab'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_master(){
        //no:cnomor,skpd:cskpd
        $ctabel = $this->input->post('tabel');
        $cid = $this->input->post('cid');
        $cnid = $this->input->post('cnid');
        
        $csql = "delete from $ctabel where $cid = '$cnid'";
                
        //$sql = "delete from mbidang where bidang='$ckdbid'";
        $asg = $this->db->query($csql);
        if ($asg){
            echo '1'; 
        } else{
            echo '0';
        }
                       
    }
    
    function hapus_master1(){
        $tabel= $this->input->post('tabel');
        $kd1 = $this->input->post('kd1');
        $prog = $this->input->post('prog');
        $kd2 = $this->input->post('kd2');
        $nomor = $this->input->post('nomor');
        $msg = array();
        $sql = "delete from $tabel where $kd1='$prog' and $kd2='$nomor'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_user()
	{
		$id = $this->uri->segment(3);
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('user','id_user',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/user');
		
		else:
			$this->master_model->delete("otori","user_id",$id);
				
			$this->master_model->delete('user','id_user',$id);
						
			$this->session->set_flashdata('notify', 'Data berhasil dihapus !');
			
			redirect('master/user');
			
		endif;
	}
    
    function hapus_master2(){
        $tabel= $this->input->post('tabel');
        $kd1 = $this->input->post('kd1');
        $prog = $this->input->post('prog');
        $kd2 = $this->input->post('kd2');
        $sasaran = $this->input->post('sasaran');
        $kd3 = $this->input->post('kd3');
        $nomor = $this->input->post('nomor');
        $msg = array();
        $sql = "delete from $tabel where $kd1='$prog' and $kd2='$sasaran' and $kd3='$nomor'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function hapus_komponen(){
        
        $prog = $this->input->post('prog');
        $giat = $this->input->post('giat');
        $outputlama = $this->input->post('outout');
        $outputbaru = $this->input->post('newoutput');
        $kdkomp =$this->input->post('kdkomp');
        $msg = array();
        $sql = "delete from t_new_komponen where  kdprogram='$prog' and kdgiat='$giat' and kdnewoutput='$outputbaru' and kdoutput='$outputlama'  and kdkmpnen='$kdkomp'";
        $asg = $this->db->query($sql);
    
    	
    
    	if ($asg){
            $msg = array('pesan'=>'1');
            echo json_encode($msg);
        } else {
            $msg = array('pesan'=>'0');
            echo json_encode($msg);
            
        }
    }
    
    function load_parameter() {
            
    	$sql = "select * from proyeksi";                   
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
               
                $result[] = array(
                            'id' => $ii,        
                            'no' => $resulte['no'],  
                            'faktor' => $resulte['faktor'],  
                            'thn1' => $resulte['thn1'],
                            'thn2' => $resulte['thn2'],
                            'thn3' => $resulte['thn3'],
                            'thn4' => $resulte['thn4'],  
                            'bakthn1' => $resulte['bakthn1'],
                            'bakthn2' => $resulte['bakthn2'],
                            'bakthn3' => $resulte['bakthn3'],
                            'bakthn4' => $resulte['bakthn4']                         
                                                          
                            );
                            $ii++;
            }
               
               echo json_encode($result);
                $query1->free_result();
        }
        function simpan_paramater(){
            $kd   = $this->input->post('kd');
            $thn1 =   $this->input->post('thn1');
            $thn2 =   $this->input->post('thn2');
            $thn3 =   $this->input->post('thn3');
            $thn4 =   $this->input->post('thn4');
           
                
                    
    				$sql = "update proyeksi set thn1='$thn1',thn2='$thn2',thn3='$thn3',thn4='$thn4'
                            where no='$kd' ";
                    //echo($sql);
                    $asg = $this->db->query($sql);
    
    
    
    
                    if (!($asg)){
                       $msg = array('pesan'=>'0');
                       echo json_encode($msg);
                        exit();
                    } else {
                        $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }             
                
                
            
        }
        function simpan_paramaterbak(){
            $kd   = $this->input->post('kd');
            $bakthn1 =   $this->input->post('bakthn1');
            $bakthn2 =   $this->input->post('bakthn2');
            $bakthn3 =   $this->input->post('bakthn3');
            $bakthn4 =   $this->input->post('bakthn4');
                
                    
    				$sql = "update proyeksi set bakthn1='$bakthn1',bakthn2='$bakthn2',bakthn3='$bakthn3',bakthn4='$bakthn4'
                            where no='$kd' ";
                    $asg = $this->db->query($sql);
    
    
    
    
                    if (!($asg)){
                       $msg = array('pesan'=>'0');
                       echo json_encode($msg);
                        exit();
                    } else {
                        $msg = array('pesan'=>'1');
                        echo json_encode($msg);
                    }             
                
                
            
        }
        
        function cari_user()
	{
	$lccr =  $this->input->post('pencarian');
    $this->index('0','user','user_name','nama','USER','user',$lccr);
	}

	function edit_user()
	{
		
		$id = $this->uri->segment(3);
		
		$data['list'] 		= $this->db->query("SELECT a.*,b.user_id FROM dyn_menu_renja a LEFT JOIN (SELECT * FROM otori WHERE user_id = '$id') b ON a.id = b.menu_id order by a.id");
		
		if ( ( $id == "" ) || ( $this->master_model->get_by_id('user','id_user',$id)->num_rows() <= 0 ) ) :
		
			redirect('master/user');
		
		endif;
		
		//*
		$config = array(
               array(
                     'field'   => 'id_user',
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'user_name',
                     'label'   => 'User Uame',
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim'
                  ),
               array(
                     'field'   => 'type',
                     'label'   => 'Type',
                     'rules'   => 'trim'
                  ),
               array(
                     'field'   => 'nama',
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                  )
				  
            );
			
		$this->form_validation->set_message('required', '%s harus diisi !');
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title'] = "Master Data User &raquo; Ubah Data";
			$data['user'] = $this->master_model->get_by_id('user','id_user',$id)->row();
		}
		else
		{
			if((md5($this->input->post('password')) == $this->input->post('password_before')) || ($this->input->post('password') == ""))
			{
			$data = array(
						'id_user' => $this->input->post('id_user'),
						'user_name' => $this->input->post('user_name'),
						'password' => $this->input->post('password_before'),
						//'password' => md5($this->input->post('password')),
						'nama' => $this->input->post('nama'),
						'type' => $this->input->post('type'),
                        'esselon1' => $this->input->post('esselon1'),
                        'type' => $this->input->post('type')
						);
			}
			else
			{
			$data = array(
						'id_user' => $this->input->post('id_user'),
						'user_name' => $this->input->post('user_name'),
						//'password' => $this->input->post('password'),
						'password' => md5($this->input->post('password')),
						'nama' => $this->input->post('nama'),
						'type' => $this->input->post('type'),
                        'esselon1' => $this->input->post('esselon1'),
                        'type' => $this->input->post('type')
						);
			}
			$this->master_model->delete("otori","user_id",$this->input->post('id_user'));



			//*
			$max=count($this->input->post('otori_id')) - 1;
			for ($i = 0; $i <= $max; $i++) 
           	{
			$id_menu = $this->input->post('otori_id');
			
			$data_otori = array(
						'user_id' => $this->input->post('id_user'),
						'menu_id' => $id_menu[$i],
						'akses' => "1"
						);
			$this->master_model->save('otori',$data_otori);
			}
			//*/
						
			$this->master_model->update('user','id_user',$id, $data);
						
			$this->session->set_flashdata('notify', 'Data User berhasil diupdate !');
			
			redirect('master/user');

		}
		
		$this->template->set('title', 'Master Data User &raquo; Ubah Data');
		$this->template->load('template', 'master/user/edit', $data);
		//*/
	}
        
        function tambah_user()
    	{
    		$data['list'] 		= $this->db->query("SELECT * FROM dyn_menu_renja ORDER BY page_id");
    		
    		$config = array(
                   array(
                         'field'   => 'id_user',
                         'label'   => 'ID',
                         'rules'   => 'trim|required'
                      ),
                   array(
                         'field'   => 'user_name',
                         'label'   => 'User_name',
                         'rules'   => 'trim|required'
                      ),
                   array(
                         'field'   => 'password',
                         'label'   => 'Password',
                         'rules'   => 'trim|required'
                      ),
                   array(
                         'field'   => 'type',
                         'label'   => 'Type',
                         'rules'   => 'trim|required'
                      ),
                   array(
                         'field'   => 'nama',
                         'label'   => 'Nama',
                         'rules'   => 'trim|required'
                      )
                );
    			
    		$this->form_validation->set_message('required', '%s harus diisi !');
    		$this->form_validation->set_rules($config);
    		$this->form_validation->set_error_delimiters('<div class="single_error">', '</div>');
    
    		if ($this->form_validation->run() == FALSE)
    		{
    			$data['page_title'] = "Master Data User &raquo; Tambah";
    		}
    		else
    		{
    								
    			$data = array(
    						'id_user' => $this->input->post('id_user'),
    						'user_name' => $this->input->post('user_name'),
    						'password' => md5($this->input->post('password')),
    						'type' => $this->input->post('type'),
    						'nama' => $this->input->post('nama')
    						);
    						
    			$this->master_model->save('user',$data);
    			
    			//*
    			$max=count($this->input->post('otori_id')) - 1;
    			for ($i = 0; $i <= $max; $i++) 
               	{
    			$id_menu = $this->input->post('otori_id');
    			
    			$data_otori = array(
    						'user_id' => $this->input->post('id_user'),
    						'menu_id' => $id_menu[$i],
    						'akses' => "1"
    						);
    			$this->master_model->save('otori',$data_otori);
    			}
    			//*/
    			
    			$this->session->set_flashdata('notify', 'Data User berhasil disimpan !');
    			
    			redirect('master/user');
    
    		}
    		
    		$this->template->set('title', 'Master Data User &raquo; Tambah Data');
    		$this->template->load('template', 'master/user/tambah', $data);
    	}
        
        function simpan_user(){
        
        $cidus = $this->input->post('cidus');
        $cus   = $this->input->post('cus');
        $cpa   = md5($this->input->post('cpa'));
        $cnm   = $this->input->post('cnm');
        $csikd = $this->input->post('csikd');
        $cprg   = $this->input->post('cprg');
        $cjs   = $this->input->post('cjs');
            
        $sql   = "select id_user from user where id_user='$cidus'";
        $res   = $this->db->query($sql);
        if($res->num_rows()>0){
            echo '1';
        }else{
            $sql = "insert into user(id_user,user_name,password,type,nama,kd_skpd,esselon1) values ('$cidus','$cus','$cpa','$cjs','$cnm','$csikd','$cprg')";
            $asg = $this->db->query($sql);
            if($asg){
                if($cjs==1){
                    $sql1 = "INSERT INTO otori(user_id,menu_id,akses) SELECT '$cidus' as user_id,menu_id,akses FROM otori WHERE user_id='4'";
                }else{
                    $sql1 = "INSERT INTO otori(user_id,menu_id,akses) SELECT '$cidus' as user_id,menu_id,akses FROM otori WHERE user_id='9'";
                }
                $asg1 = $this->db->query($sql1);
                echo '2';
            }else{
                echo '0';
            }
        }
    }
    
    function update_user(){
        
        $cidus = $this->input->post('cidus');
        $cus   = $this->input->post('cus');
        $cpas  = $this->input->post('cpa');
        $cpa   = md5($this->input->post('cpa'));
        $cnm   = $this->input->post('cnm');
        $csikd = $this->input->post('csikd');
        $cprg   = $this->input->post('cprg');
        $cjs   = $this->input->post('cjs');    
        
        $sql   = "select id_user from user where id_user='$cidus'";
        $res   = $this->db->query($sql);
 
       // $pass   = $this->db->query("select password from user where id_user='$cidus'");
        $pass   =mysql_query("select password from user where id_user='$cidus'");
        $resulte=mysql_fetch_array($pass);
        if($res->num_rows() > 0){
            if ($resulte['password'] == $cpas){
                $sql1 = "update user set user_name='$cus',password='$cpas',type='$cjs',nama='$cnm',kd_skpd='$csikd',esselon1='$cprg' where id_user='$cidus'";
                $asg1 = $this->db->query($sql1);
                if($asg1){
                    echo '2';
                }else{
                    echo '0';
                }
            }else{
                 $sql = "update user set user_name='$cus',password='$cpa',type='$cjs',esselon1='$cprg',nama='$cnm',kd_skpd='$csikd' where id_user='$cidus'";
                $asg = $this->db->query($sql);
                if($asg){
                    echo '2';
                }else{
                    echo '0';
                }
            }
        }else{
             echo '1';
        }
    }
    
    function yatidak() {
		$result[] = array('status' => 'YA');
		$result[] = array('status' => 'TIDAK');                       
        echo json_encode($result);    	   
	}
    function jenis() {
		$result[] = array('jenis' => 'BAK');
		$result[] = array('jenis' => 'BLK');                       
        echo json_encode($result);    	   
	}
    function simpan_otorisasi(){
        $tet        =$this->input->post('vids');	
		$idx		=$this->input->post('idx');	
		$tt   		=$this->input->post('tt');	
		$sta	    =trim($this->input->post('st'));	
        
        if ($sta=='YA'){
            $statue='1';
        }else{
             $statue='0';
        };
        
        $sql="select menu_id FROM otori where user_id='$tet' and menu_id='$idx'  ";
        $query1 = $this->db->query($sql);

        if ($query1->num_rows()>0){
           $this->db->query("update otori set akses='$statue' where menu_id='$idx' and user_id='$tet'");
        }else{
           $this->db->query("insert into otori(user_id,menu_id,akses) values ('$tet','$idx','$statue')");
        }

	}
    
    function load_otorisasi() {
        
        $test= $this->uri->segment(3);
        $result = array();
        $row = array();
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;        
        
        $sql="select count(*) as tot FROM dyn_menu_renja where page_id<>'0' ";
        $query1 = $this->db->query($sql);
        $trh = $query1->row();

        $sql = "SELECT a.id as idx,a.title as title, (SELECT IF(b.akses=1,'YA','TIDAK') FROM otori b where b.menu_id=a.id AND user_id=$test) AS status FROM dyn_menu_renja a ORDER BY a.id
                limit $offset,$rows  ";

        $query1 = $this->db->query($sql);  


        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte){ 

            $coba[] = array(
                        'id' => $ii,  
                        'idx' => $resulte['idx'],
                        'title'  => $resulte['title'],
                        'status'  => $resulte['status'],
                        );
                        $ii++;
        }
        
        $result["rows"] = $coba;   
		$result["total"] = $trh->tot; 				
        echo json_encode($result);
    //	$query1->free_result();   
	}
    
    function config_skpd(){
            $skpd     = $this->session->userdata('kdskpd');
            $sql = "SELECT kddept,nmdept,'0' as statu FROM  t_dept  WHERE kddept = '$skpd'";
            $query1 = $this->db->query($sql);  
    		
    		$test = $query1->num_rows();
    		
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result = array(
                            'id' => $ii,        
                            'kd_skpd' => $resulte['kddept'],
                            'nm_skpd' => $resulte['nmdept'],
                            'statu' => $resulte['statu']
                            );
                            $ii++;
            }
    		
    
    		
    		
            echo json_encode($result);
        	$query1->free_result();   
        }
        
        function config_dept1(){
            $lccr = $this->input->post('q');
           // $sql  = " SELECT kddept,nmdept FROM t_dept  where  ( upper(kddept) like upper('%$lccr%') or upper(nmdept) like upper('%$lccr%') ) order by kddept";
            $sql  = " SELECT kddept,nmdept FROM t_dept where  ( upper(kddept) like upper('%$lccr%') or upper(nmdept) like upper('%$lccr%') ) order by kddept" ;
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kddept'  => $resulte['kddept'],  
                            'nmdept'  => $resulte['nmdept']
                            );
                            $ii++;
            }
            echo json_encode($result);
             
    }
        
        function config_unit(){
            $skpd = $this->session->userdata('kdskpd');
            $unit= $this->session->userdata('esselon1');
            $sql = "SELECT kdunit,nmunit FROM t_unit  WHERE kddept='$skpd' and kdunit = '$unit'";
            $query1 = $this->db->query($sql);  
    		
    		$test = $query1->num_rows();
    		
            $ii = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result = array(
                            'id' => $ii,        
                            'kdunit' => $resulte['kdunit'],
                            'nmunit' => $resulte['nmunit']
                            );
                            $ii++;
            }
    		
    
    		
    		
            echo json_encode($result);
        	$query1->free_result();   
        }
        
        function config_unit1($kdskpd=''){
          
            $sql  = " SELECT kddept,kdunit,nmunit FROM t_unit where kddept='$kdskpd' ORDER BY kddept,kdunit" ;
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdunit'  => $resulte['kdunit'],  
                            'nmunit'  => $resulte['nmunit']
                            );
                            $ii++;
            }
            echo json_encode($result);
             
    }
        
        function pprog($cskpd='',$cunit='') {
            $skpd     = $this->session->userdata('kdskpd');
            $lccr = $this->input->post('q');
            $sql  = " SELECT kdprogram,nmprogram FROM t_program where kddept='$skpd' and kdunit='$cunit' and ( upper(kdprogram) like upper('%$lccr%') or upper(nmprogram) like upper('%$lccr%') ) order by kdprogram";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdprogram'  => $resulte['kdprogram'],  
                            'nmprogram'  => $resulte['nmprogram']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
        
        function punit() {
            $skpd     = $this->session->userdata('kdskpd');
            $lccr = $this->input->post('q');
            $sql  = " SELECT kdunit,nmunit FROM t_unit where kddept='$skpd'  and ( upper(kdunit) like upper('%$lccr%') or upper(nmunit) like upper('%$lccr%') )";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdunit'  => $resulte['kdunit'],  
                            'nmunit'  => $resulte['nmunit']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
        
        function pgiat($cskpd='',$cprog='',$cunit='') {
            $skpd     = $this->session->userdata('kdskpd');
            $lccr = $this->input->post('q');
            $sql  = " SELECT kdgiat,nmgiat FROM t_giat where  kddept='$skpd' and kdprogram='$cprog' and kdunit='$cunit' and ( upper(kdgiat) like upper('%$lccr%') or upper(nmgiat) like upper('%$lccr%') ) order by kdgiat";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdgiat'  => $resulte['kdgiat'],  
                            'nmgiat'  => $resulte['nmgiat']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
        
        function ambil_giat($cprog='') {
            $skpd     = $this->session->userdata('kdskpd');
            $lccr = $this->input->post('q');
            $sql  = " SELECT kdgiat,nmgiat FROM t_giat where  kddept='$skpd' and kdprogram='$cprog'  and ( upper(kdgiat) like upper('%$lccr%') or upper(nmgiat) like upper('%$lccr%') )";
            
            $query1 = $this->db->query($sql);  
            $result = array();
            $ii     = 0;
            foreach($query1->result_array() as $resulte)
            { 
                $result[] = array(
                            'id' => $ii,        
                            'kdgiat'  => $resulte['kdgiat'],  
                            'nmgiat'  => $resulte['nmgiat']
                            );
                            $ii++;
            }
            echo json_encode($result);
        	   
    	}
    
}


