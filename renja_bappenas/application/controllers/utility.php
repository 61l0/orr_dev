<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//doni star -->
class Utility extends CI_Controller {

	function __contruct()
	{	
		parent::__construct();
	}
    
     function transfer()
    {
        $data['page_title']= 'TRANSFER DATA SPP / SPM';
        $this->template->set('title', 'TRANSFER SPP / SPM');   
        $this->template->load('template','utility/transfer',$data) ; 
    }
	
	function backuprenja()
    {
	
		$data['page_title']= 'TRANSFER DATA ANGGARAN';
        $this->template->set('title', 'TRANSFER ANGGARAN');   
        $this->template->load('template','utility/backuprenja',$data) ; 
		
    }
    
   	
    function restorerenja_kl()
    {
	
		$data['page_title']= 'IMPORT DATA ';
        $this->template->set('title', 'IMPORT ');   
        $this->template->load('template','utility/restorerenja_kl',$data) ; 
		
    }
    function restorerenja_unit()
    {
	
		$data['page_title']= 'IMPORT DATA ';
        $this->template->set('title', 'IMPORT ');   
        $this->template->load('template','utility/restorerenja_unit',$data) ; 
		
    }
    function restorerenja_prog()
    {
	
		$data['page_title']= 'IMPORT DATA ';
        $this->template->set('title', 'IMPORT ');   
        $this->template->load('template','utility/restorerenja_prog',$data) ; 
		
    }
    function restorerenja_giat()
    {
	
		$data['page_title']= 'IMPORT DATA ';
        $this->template->set('title', 'IMPORT ');   
        $this->template->load('template','utility/restorerenja_giat',$data) ; 
		
    }
    function restorerenja_ref()
    {
	
		$data['page_title']= 'IMPORT DATA ';
        $this->template->set('title', 'IMPORT ');   
        $this->template->load('template','utility/restorerenja_ref',$data) ; 
		
    }
    function backup_data_renja_ref()
	{
		$kd_skpd=$this->input->get('kdskpd');
		
		$nama_file	  =	'C:/BACKUP/RENJA/RENJA_ref'.'_'.$kd_skpd.'_'.date("DdMY").'_'.time().'_.dny';

		$return='';
		$return	.= "/*".$kd_skpd."*/\n";
			
		$tables2=array('t_dept','t_unit','t_dit','t_program','t_giat');
		
		foreach($tables2 as $tabel2){
		
		
		$query_create_table=$this->db->query("show create table $tabel2");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		
		}
		
        $return .= "DELETE FROM t_dept where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_dept');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dept'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dept ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_unit where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_unit');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_unit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_unit ($field_name) VALUES ($values);\n"; 
		}
        
         $return .= "DELETE FROM t_dit where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_dit');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dit ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_program where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_program');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_program'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_program ($field_name) VALUES ($values);\n"; 
		}
		
        $return .= "DELETE FROM t_giat where kddept='".$kd_skpd."';\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_giat');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_giat'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_giat ($field_name) VALUES ($values);\n"; 
		}
	
		
	   $handle = fopen($nama_file,'w+');
		fwrite($handle, $return); 
		fclose($handle);    
		 //echo("jaka");
	}

	
	function backup_data_renja_kl()
	{
		$kd_skpd=$this->input->get('kdskpd');
		
		$nama_file	  =	'C:/BACKUP/RENJA/RENJA_KL'.'_'.$kd_skpd.'_'.date("DdMY").'_'.time().'_.dny';

		$return='';
		$return	.= "/*".$kd_skpd."*/\n";
			
		$tables2=array('t_dept','t_visi','t_misi','d_sasarankl','d_indikatorkl','t_unit','t_program','d_sasaran_prog','d_indikator_prog','t_giat','d_item_output','d_indikator_output','d_kmpnen','d_lok','t_dit','t_sumber','t_npphln');
		
		foreach($tables2 as $tabel2){
		
		
		$query_create_table=$this->db->query("show create table $tabel2");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		
		}
		
        $return .= "DELETE FROM t_dept where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_dept');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dept'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dept ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_visi where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_visi');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_visi'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_visi ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_misi where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_misi');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_misi'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_misi ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_sasarankl where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('d_sasarankl');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_sasarankl'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_sasarankl ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_indikatorkl where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('d_indikatorkl');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikatorkl'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikatorkl ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_unit where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_unit');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_unit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_unit ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_program where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_program');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_program'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_program ($field_name) VALUES ($values);\n"; 
		}
        
         $return .= "DELETE FROM d_sasaran_prog where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM d_sasaran_prog WHERE kddept='".$kd_skpd."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_sasaran_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_sasaran_prog ($field_name) VALUES ($values);\n"; 
		}  
		 
        $return .= "DELETE FROM d_indikator_prog where kddept='".$kd_skpd."';\n";
		
		$sql="SELECT * FROM d_indikator_prog WHERE kddept='".$kd_skpd."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_prog ($field_name) VALUES ($values);\n"; 
		}
		
        $return .= "DELETE FROM t_giat where kddept='".$kd_skpd."';\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('t_giat');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_giat'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_giat ($field_name) VALUES ($values);\n"; 
		}
	
		$return .= "DELETE FROM d_item_output where kddept='".$kd_skpd."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
		$query =$this->db->get('d_item_output');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_item_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_item_output ($field_name) VALUES ($values);\n"; 
		}
        
         $return .= "DELETE FROM d_indikator_output where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM d_indikator_output WHERE kddept='".$kd_skpd."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_output ($field_name) VALUES ($values);\n"; 
		}	       
	
		$return .= "DELETE FROM d_kmpnen where kddept='".$kd_skpd."';\n";
		
		$sql="SELECT * FROM d_kmpnen WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_kmpnen'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			
			$return .= "INSERT INTO d_kmpnen ($field_name) VALUES ($values);\n"; 
		} 
        
        $return .= "DELETE FROM d_lok where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM d_lok WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_lok'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_lok ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_sumber where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_sumber WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_sumber'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_sumber ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_npphln where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_npphln WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_npphln'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_npphln ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_dit where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_dit WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dit ($field_name) VALUES ($values);\n"; 
		}
	
	   $handle = fopen($nama_file,'w+');
		fwrite($handle, $return); 
		fclose($handle);  
	}

	
	 function backup_data_renja()
	{
		$kd_skpd=$this->input->get('kdskpd');
        $kd_unit=$this->input->get('kdunit');
        $kd_prog=$this->input->get('kdprog');
		
		$nama_file	  =	'C:/BACKUP/RENJA/RENJA_UNIT'.'_'.$kd_skpd.'_'.$kd_unit.'_'.date("DdMY").'_'.time().'_.dny';

		$return='';
		$return	.= "/*".$kd_skpd."*/\n";
			
		$tables2=array('t_unit','t_program','t_giat','d_item_output','d_kmpnen','d_sasaran_prog','d_indikator_prog','d_indikator_output','d_lok','t_dit','t_sumber','t_npphln');
		
		foreach($tables2 as $tabel2){
		
		
		$query_create_table=$this->db->query("show create table $tabel2");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		
		}
        
         $return .= "DELETE FROM t_unit where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
		$query =$this->db->get('t_unit');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_unit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_unit ($field_name) VALUES ($values);\n"; 
		}
		
        $return .= "DELETE FROM t_program where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
		$query =$this->db->get('t_program');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_program'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_program ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_sasaran_prog where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$sql="SELECT * FROM d_sasaran_prog WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_sasaran_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_sasaran_prog ($field_name) VALUES ($values);\n"; 
		}  
		 
        $return .= "DELETE FROM d_indikator_prog where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$sql="SELECT * FROM d_indikator_prog WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_prog ($field_name) VALUES ($values);\n"; 
		}
		
        $return .= "DELETE FROM t_giat where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
		$query =$this->db->get('t_giat');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_giat'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_giat ($field_name) VALUES ($values);\n"; 
		}
	
		$return .= "DELETE FROM d_item_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
		$query =$this->db->get('d_item_output');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_item_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_item_output ($field_name) VALUES ($values);\n"; 
		} 
	
	
	
		$return .= "DELETE FROM d_kmpnen where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$sql="SELECT * FROM d_kmpnen WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_kmpnen'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			
			$return .= "INSERT INTO d_kmpnen ($field_name) VALUES ($values);\n"; 
		}
        
        
        
        $return .= "DELETE FROM d_indikator_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$sql="SELECT * FROM d_indikator_output WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_output ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_lok where kddept='".$kd_skpd."' and kdunit='".$kd_unit."';\n";
		
		$sql="SELECT * FROM d_lok WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_lok'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_lok ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_sumber where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_sumber WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_sumber'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_sumber ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_npphln where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_npphln WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_npphln'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_npphln ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_dit where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' ;\n";
		
		$sql="SELECT * FROM t_dit WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dit ($field_name) VALUES ($values);\n"; 
		}
	
	   $handle = fopen($nama_file,'w+');
		fwrite($handle, $return); 
		fclose($handle);    
		 //echo("jaka");
	}
    
    function backup_data_renja_prog()
	{
		$kd_skpd=$this->input->get('kdskpd');
        $kd_unit=$this->input->get('kdunit');
        $kd_prog=$this->input->get('kdprog');
		$nm_skpd=substr($this->input->get('nmskpd'),0,20);
		
		$nama_file	  =	'C:/BACKUP/RENJA/RENJA_PROG'.'_'.$kd_skpd.'_'.$kd_unit.'_'.$kd_prog.'_'.date("DdMY").'_'.time().'_.dny';

		$return='';
		$return	.= "/*".$kd_skpd."*/\n";
			
		$tables2=array('t_program','d_sasaran_prog','d_indikator_prog','t_giat','d_item_output','d_indikator_output','d_kmpnen','d_lok','t_dit','t_sumber','t_npphln');
		
		foreach($tables2 as $tabel2){
		
		
		$query_create_table=$this->db->query("show create table $tabel2");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		
		}
        		
        $return .= "DELETE FROM t_program where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
        $this->db->where('kdprogram',$kd_prog);
		$query =$this->db->get('t_program');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_program'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_program ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_sasaran_prog where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$sql="SELECT * FROM d_sasaran_prog WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_sasaran_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_sasaran_prog ($field_name) VALUES ($values);\n"; 
		}  
		 
        $return .= "DELETE FROM d_indikator_prog where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$sql="SELECT * FROM d_indikator_prog WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_prog'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_prog ($field_name) VALUES ($values);\n"; 
		}
		
        $return .= "DELETE FROM t_giat where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'  ;\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
        $this->db->where('kdprogram',$kd_prog);
		$query =$this->db->get('t_giat');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_giat'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_giat ($field_name) VALUES ($values);\n"; 
		}
	
		$return .= "DELETE FROM d_item_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
        $this->db->where('kdprogram',$kd_prog);
		$query =$this->db->get('d_item_output');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_item_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_item_output ($field_name) VALUES ($values);\n"; 
		} 
	
	    $return .= "DELETE FROM d_indikator_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$sql="SELECT * FROM d_indikator_output WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_output ($field_name) VALUES ($values);\n"; 
		}
	
		$return .= "DELETE FROM d_kmpnen where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$sql="SELECT * FROM d_kmpnen WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_kmpnen'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			
			$return .= "INSERT INTO d_kmpnen ($field_name) VALUES ($values);\n"; 
		} 
        
        
        
        $return .= "DELETE FROM d_lok where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."';\n";
		
		$sql="SELECT * FROM d_lok WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_lok'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_lok ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_sumber where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_sumber WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_sumber'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_sumber ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_npphln where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_npphln WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_npphln'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_npphln ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_dit where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_dit WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dit ($field_name) VALUES ($values);\n"; 
		}
	
	   $handle = fopen($nama_file,'w+');
		fwrite($handle, $return); 
		fclose($handle);    
		 
	}
    
    function backup_data_renja_giat()
	{
		$kd_skpd=$this->input->get('kdskpd');
        $kd_unit=$this->input->get('kdunit');
        $kd_prog=$this->input->get('kdprog');
        $kd_giat=$this->input->get('kdgiat');
		$nm_skpd=substr($this->input->get('nmskpd'),0,20);
		
		$nama_file	  =	'C:/BACKUP/RENJA/RENJA_GIAT'.'_'.$kd_skpd.'_'.$kd_unit.'_'.$kd_prog.'_'.$kd_giat.'_'.date("DdMY").'_'.time().'_.dny';

		$return='';
		$return	.= "/*".$kd_skpd."*/\n";
			
		$tables2=array('t_giat','d_item_output','d_kmpnen','d_indikator_output','d_lok','t_dit','t_sumber','t_npphln');
		
		foreach($tables2 as $tabel2){
		
		
		$query_create_table=$this->db->query("show create table $tabel2");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		
		}
		

		
        $return .= "DELETE FROM t_giat where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
        $this->db->where('kdprogram',$kd_prog);
        $this->db->where('kdgiat',$kd_giat);
		$query =$this->db->get('t_giat');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_giat'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_giat ($field_name) VALUES ($values);\n"; 
		}
	
		$return .= "DELETE FROM d_item_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."' ;\n";
		
		$this->db->where('kddept',$kd_skpd);
        $this->db->where('kdunit',$kd_unit);
        $this->db->where('kdprogram',$kd_prog);
        $this->db->where('kdgiat',$kd_giat);
		$query =$this->db->get('d_item_output');
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_item_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_item_output ($field_name) VALUES ($values);\n"; 
		} 
	
	
	
		$return .= "DELETE FROM d_kmpnen where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."' ;\n";
		
		$sql="SELECT * FROM d_kmpnen WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_kmpnen'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			
			$return .= "INSERT INTO d_kmpnen ($field_name) VALUES ($values);\n"; 
		} 
	
		
        

        
        $return .= "DELETE FROM d_indikator_output where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."' ;\n";
		
		$sql="SELECT * FROM d_indikator_output WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_indikator_output'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_indikator_output ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM d_lok where kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."';\n";
		
		$sql="SELECT * FROM d_lok WHERE kddept='".$kd_skpd."' and kdunit='".$kd_unit."' and kdprogram='".$kd_prog."' and kdgiat='".$kd_giat."'";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 'd_lok'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO d_lok ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_sumber where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_sumber WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_sumber'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_sumber ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_npphln where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_npphln WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_npphln'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_npphln ($field_name) VALUES ($values);\n"; 
		}
        
        $return .= "DELETE FROM t_dit where kddept='".$kd_skpd."' ;\n";
		
		$sql="SELECT * FROM t_dit WHERE kddept='".$kd_skpd."' ";
		$query=$this->db->query($sql);
		
		 foreach($query->result() as $result){
	
			  $query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='renjakl' AND table_name = 't_dit'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
	
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
									  
				 $field_name .= $column->COLUMN_NAME. ",";
				 
			
				
				$column_name = $column->COLUMN_NAME;
					 
					
				$values .= '"'.$result->$column_name.'",'; 
				
			
	
			} 
		 
		
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
			
			$return .= "INSERT INTO t_dit ($field_name) VALUES ($values);\n"; 
		}
	
	   $handle = fopen($nama_file,'w+');
		fwrite($handle, $return); 
		fclose($handle);    
		 
	}
    
		function imporrenstra()
    {
	
		$data['page_title']= 'IMPORT DATA ANGGARAN';
        $this->template->set('title', 'IMPORT ANGGARAN');   
        $this->template->load('template','utility/imporanggaran',$data) ; 
		
    }
	
		
	function load_transfer() {
        $result = array();
        $row = array();
      	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	    $offset = ($page-1)*$rows;
        $kriteria = '';
        $kriteria = $this->input->post('cari');
        $where ='';
		
        if ($kriteria <> ''){                               
            $where="where (upper(nm_skpd) like upper('%$kriteria%') or kd_skpd like'%$kriteria%' or no_spm like'%$kriteria%' or no_spp like'%$kriteria%')";            
        }
             
        $sql = "SELECT count(*) as tot from trhspm $where" ;
        $query1 = $this->db->query($sql);
        $total = $query1->row();
		     
        $sql = "SELECT * from trhspm $where order by no_spm limit $offset,$rows";
        $query1 = $this->db->query($sql);  
        $result = array();
        $ii = 0;
        foreach($query1->result_array() as $resulte)
        { 
           
            $row[] = array(
                        'id' => $ii,
						'no_spm' => $resulte['no_spm'],     
						'no_spp' => $resulte['no_spp'], 	
                        'kd_skpd' => $resulte['kd_skpd'],
                        'nm_skpd' => $resulte['nm_skpd']                                                                                                
                        );
                        $ii++;
        }
        
		
		
        $result["total"] = $total->tot;
        $result["rows"] = $row; 

        echo json_encode($result);
    	   
	}
	
	function backup_data(){
	
					   
		$kodeskpd=$this->session->userdata('kdskpd');
		$sql="select nm_skpd from ms_skpd where kd_skpd='$kodeskpd'";
		$query=$this->db->query($sql);
		$hasil=$query->row();
		$namaskpd=$hasil->nm_skpd;
		
		$nm_skpd=substr($namaskpd,0,20);
	
		$array_no_spm = explode('|',$this->input->get('str_no_spm'));
		$array_no_spp = explode('|',$this->input->get('str_no_spp'));

		$nama_file	  =	'C:/BACKUP/SPM/SIADINDA_SPM'.'_'.$kodeskpd.'_'.date("DdMY").'_'.time().'_1.dny';
		
	
		$return="";
		
		$return	.= "/*".$kodeskpd."*/\n";
		$return	.= "DROP TABLE IF EXISTS trhspmtemp;\n" ;
	
		$query_create_table=$this->db->query("show create table trhspm");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trhspm','trhspmtemp',$field_create).";\n";
		
		
		foreach($array_no_spm as $array_no_spm){
			$this->db->or_where('no_spm',$array_no_spm);
		} 
		 
		$query =$this->db->get('trhspm');
		
		foreach($query->result() as $result){

			$query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='siadinda_transfer' AND table_name = 'trhspm'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trhspmtemp ($field_name) VALUES ($values);\n";
				
			
		}
		
		
		$array_no_spm = explode('|',$this->input->get('str_no_spm'));
		
		$return	.= "DROP TABLE IF EXISTS trspmpottemp;\n" ;
		
		$query_create_table=$this->db->query("show create table trspmpot");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trspmpot','trspmpottemp',$field_create).";\n";
		
		
		foreach($array_no_spm as $array_no_spm){
			$this->db->or_where('no_spm',$array_no_spm);
		} 
		 
		$query =$this->db->get('trspmpot');
		
		foreach($query->result() as $result){

			$query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='siadinda_transfer' AND table_name = 'trspmpot'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trspmpottemp ($field_name) VALUES ($values);\n";
				
			
		}
		
		$return	.= "DROP TABLE IF EXISTS trhspptemp;\n" ;
		

		$query_create_table=$this->db->query("show create table trhspp");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trhspp','trhspptemp',$field_create).";\n";
		
		
		foreach($array_no_spp as $array_no_spp){
			$this->db->or_where('no_spp',$array_no_spp);
		} 
		 
		$query =$this->db->get('trhspp');
		
		foreach($query->result() as $result){

			$query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='siadinda_transfer' AND table_name = 'trhspp'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trhspptemp ($field_name) VALUES ($values);\n";
							
			
		}
		
		
		$array_no_spp = explode('|',$this->input->get('str_no_spp'));
		
		$return	.= "DROP TABLE IF EXISTS trdspptemp;\n" ;
		
		$query_create_table=$this->db->query("show create table trdspp");
		$result_create=$query_create_table->result_array();
		$field_create=$result_create[0]['Create Table'];
		$return .= str_replace('trdspp','trdspptemp',$field_create).";\n";
		
		
		foreach($array_no_spp as $array_no_spp){
			$this->db->or_where('no_spp',$array_no_spp);
		} 
		 
		$query =$this->db->get('trdspp');
		
		foreach($query->result() as $result){

			$query_column = $this->db->query("SELECT COLUMN_NAME
												FROM   information_schema.columns
												WHERE  table_schema='siadinda_transfer' AND table_name = 'trdspp'
												ORDER  BY ordinal_position");
			
			
			$result_column = $query_column->result();
			
		
			
		 	$field_name = '';
			$values = ''; 
			foreach($result_column as $column){
				$field_name .= $column->COLUMN_NAME. ",";
					
				$column_name = $column->COLUMN_NAME;			
				$values .= '"'.$result->$column_name.'",';
			}
			
			$field_name = substr($field_name, 0, -1);
			$values = substr($values, 0, -1);
		
			$return .= "INSERT INTO trdspptemp ($field_name) VALUES ($values);\n";
			
		
		
			
						
			
		}
		
		
	$handle = fopen($nama_file,'w+');
	fwrite($handle, $return);
	fclose($handle);
		       
	}

}

//doni end -->