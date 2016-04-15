<?php
class rest_model extends CI_Model
 {
     function __construct(){
         parent::__construct();
     }
     
 
    function get_notification(){     	
    		$json=""; 
     		$query=$this->db->query("select * from t_user"); 
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$json.=$data->nama .'|';
				}
			}
			echo $json;			 
    }     
    function cek_login($username="",$password=""){
    	$json=""; 
    	$password=md5($password);
     		$query=$this->db->query("select *,t_role.role as nama_role,m_unit_kerja.nama_unit_kerja,t_user.nama,t_user.nik,  
                      t_user.username,t_user.password,t_user.id as id_user,  
                      t_user.status,t_user.role from t_user  
                      left join m_unit_kerja on m_unit_kerja.id_divisi=t_user.unit  
                      left join t_role on t_role.id=t_user.role 
                      where t_user.username = '" . $username . "' and t_user.password='" . $password . "'"); 
			 if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$json.=$data->nama_role .'|' . $data->nama .'|' .$data->nama_unit_kerja .'|' .
					$data->unit .'|'.$data->status .'|';
				}
			}
			echo $json;
	}
	function count_notifikasi($status_user="",$id_direktorat=""){
		$json=""; 
     	$status_sql="";
     	$sql="";
     	$json2="";

     	if ($status_user == "1") {
            $sql = " and  status='upload'";
        } else {
            $sql = " and  status='download'";
        }

     	$query=$this->db->query("select count(1) as jumlah from upload where kepada='" . $id_direktorat . "' and  status_baca='1' " . $sql);
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$json.=$data->jumlah;
				}
		}
		if ($status_user == "0") {
			$query=$this->db->query("select count(1) as jumlah from template_renja where 1=1
				and status_acuan='1'   $sql ");
				 if ($query->num_rows() > 0) {
					foreach ($query->result() as $data) {
						$json2=$data->jumlah;
					}
					 
				}
		}	
		
		 
		echo $json+$json2;		
	}

	function get_detail_notifikasi($status_user="",$id_direktorat=""){
		$json=""; 
     	$status_sql="";
     	$sql="";
     	if ($status_user == "1") {
            $sql = " and  a.status='upload'";
        } else {
            $sql = " and  a.status='download'";
        }
        $menus="";
     	$query=$this->db->query("select *,a.id as id,t_user.nama as nama_user, 
            (select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari_direktorat, 
            (select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan_direktorat  
            from upload a   
            left join t_user on t_user.id=a.add_by 
            where 1=1 and a.status_baca='1' ". $sql ." order by a.id desc");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					$json.=  " PENGIRIMAN FILE DARI [ ". $data->dari_direktorat  ." ]|";
				}
			}
		if ($status_user == "0") {	
			$query2=$this->db->query("select *,a.id as id,t_user.nama as nama_user,
				(select nama_unit_kerja from m_unit_kerja where id_divisi=a.dari) as dari, 
				(select nama_unit_kerja from m_unit_kerja where id_divisi=a.kepada) as tujuan  
				from template_renja a 
				left join t_user on t_user.id=a.add_by 
				where 1=1 and a.status_acuan='1' ". $sql ." order by a.id desc");
				if ($query2->num_rows() > 0) {
					foreach ($query2->result() as $row) {
						$json.=  ' USULAN RENJA DARI [ '.$row->dari ." ]|";
					}
				}	
		}	
		echo  ($json);
	}
	 
	 
}		
 ?>
