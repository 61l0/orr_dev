<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('login_model');
		$this->client_logon = $this->session->userdata('logged');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function index()
	{
	$this->template->set('title', 'RENJA KL');
	if ($this->client_logon){
        $user              = $this->session->userdata('pcUser');
		$otoriname         = $this->session->userdata('pcOtoriName');
		$logintime         = $this->session->userdata('pcLoginTime');
		//$userlevel	  = $$this->session->userdata('pcUserlevel');
		$thn_ang	   = $this->session->userdata('pcThang');	
		//$jaka = $this->session->userdata('pcJaka');
       
		$this->template->load('template', 'home',$otoriname);
	       
        }
	 else
        {
	//$this->welcome->login();
           //redirect('login');
	   redirect('/welcome/login');
	}
	}
	
	Public function login()
	{
	
		if($_POST)
		{
		
		$user = $this->login_model->validate($_POST['username'], $_POST['password'],$_POST['pcthang']);
 
			if($user == TRUE)
			{
				   redirect('welcome');
			}
			else
			{
			$this->template->set('title', 'BAPPENAS');
			
			$data['pesan'] = 'Username atau password salah!';
			$this->template->load('template_login', 'login',$data);
			}
 
		}
		else
		{
		
		$this->template->set('title', 'RENJA KL');
		$this->template->load('template_login', 'login');
		}
	}
 
	 Public function logout()
	{
		$this->login_model->logout();
		   redirect('/welcome/login');;
	}
 

	public function ceklogin(){
		$user=$this->session->userdata('pcNama');
		if ($user==''){
			echo '1';
		}else{
			echo '0';
		}
	}
    
    function summary(){
        $skpd = $this->session->userdata('kdskpd');
        $prog= $this->session->userdata('esselon1');
        $tahun =$this->uri->segment(3);//
        if($tahun==''){
            $tahun='2015';
        }
        $data=array();
		$data2=array();
		$data4=array();
        $data_pie = array();
        
        
        
        $csql2 = "SELECT kddept,kdunit,kdprogram,CONCAT(kddept,'.',kdprogram) AS kode, 
                  nmprogram FROM t_program WHERE kddept='$skpd' order by kdprogram";
                  
		$hasil = $this->db->query($csql2);
        $cstr = "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
                <tr>
                    <td align=\"left\" colspan=\"2\"><b>Keterangan</b></td>
                </tr>
                <tr>
                    <td align=\"center\"><b>Kode</b></td>
                    <td align=\"center\"><b>Nama Program</b></td>
                </tr>
                ";
        
        $totbak = 0;
        $totblk = 0;
		foreach($hasil->result_array() as $row){
		  
          switch ($tahun) {
            case '2015':
                 $csum = "select sum(bak) as bak,sum(total) as blk from d_item_output where kddept='".$row['kddept']."' and 
                  kdprogram='".$row['kdprogram']."'";
                 
                 $csqlpie = "select 'BAK' as nama ,sum(bak) as jml from d_item_output
                    union 
                    select 'BLK' as nama , sum(total) as jml from d_item_output";
                break;
            case '2016':
                 $csum = "select sum(bak1) as bak,sum(total1) as blk from d_item_output where kddept='".$row['kddept']."' and 
                  kdprogram='".$row['kdprogram']."'";
                 $csqlpie = "select 'BAK' as nama ,sum(bak1) as jml from d_item_output
                    union 
                    select 'BLK' as nama , sum(total1) as jml from d_item_output"; 
                break;
            case '2017':
                 $csum = "select sum(bak2) as bak,sum(total2) as blk from d_item_output where kddept='".$row['kddept']."' and 
                  kdprogram='".$row['kdprogram']."'";
                  $csqlpie = "select 'BAK' as nama ,sum(bak2) as jml from d_item_output
                    union 
                    select 'BLK' as nama , sum(total2) as jml from d_item_output";
                break;
            case '2018':
                 $csum = "select sum(bak3) as bak,sum(total3) as blk from d_item_output where kddept='".$row['kddept']."' and 
                  kdprogram='".$row['kdprogram']."'";
                  $csqlpie = "select 'BAK' as nama ,sum(bak3) as jml from d_item_output
                    union 
                    select 'BLK' as nama , sum(total3) as jml from d_item_output";
                break;
            case '2019':
                 $csum = "select sum(bak4) as bak,sum(total4) as blk from d_item_output where kddept='".$row['kddept']."' and 
                  kdprogram='".$row['kdprogram']."'";
                  $csqlpie = "select 'BAK' as nama ,sum(bak4) as jml from d_item_output
                    union 
                    select 'BLK' as nama , sum(total4) as jml from d_item_output";
                break;
            
        }
 
          
         // $csum = "select sum(bak) as bak,sum(total) as blk from d_item_output where kddept='".$row['kddept']."' and 
//                  kdprogram='".$row['kdprogram']."'";
//          
          $hasilsum = $this->db->query($csum)->row();
          
          $nbak =(double)$hasilsum->bak;  
          $nblk =(double)$hasilsum->blk;  
          
          $totbak = $totbak + $nbak;
          $totblk = $totblk + $nblk;
                  
          $data[] =  $nbak;
		  $data2[] = $nblk;
		  $data4[] = $row['kode'];
          $cstr .="<tr>
                        <td valign=\"top\">".$row['kode']."</td>
                        <td>".$row['nmprogram']."$nbak $hasilsum->bak</td>
                   </tr>";  
                
		}
        
        
       // $csqlpie = "select 'BAK' as nama ,sum(bak) as jml from d_item_output
//                    union 
//                    select 'BLK' as nama , sum(total) as jml from d_item_output";
        $hasilpie = $this->db->query($csqlpie);
        
        foreach($hasilpie->result_array() as $row)
        {$data_pie[] = array(
                    $row['nama'],
					(double) $row['jml'] 
                  );
        
        }
        
        $cstr .= "</table";	
        $this->template->set('title', 'Master SKPD');   
        $this->template->load('template_summary','summary',array('data'=>$data,'data2'=>$data2,'data4'=>$data4,'data_pie'=>$data_pie,'tabel'=>$cstr,'tahun'=>$tahun)) ;
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */