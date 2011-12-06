<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vdaemon extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
		$this->load->config('vdpi');
    }
	
	function agg(){
		set_time_limit(0);
		while(1){
			//$this->db->reconnect();
			$tables = array_merge($this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_content_menu'),$this->config->item('vdpi_application_menu'));
			foreach($tables as $key=>$val){
				$table = $key;
				$query = $this->db->query('SELECT * FROM '.$table.' WHERE aggd = 0');
				if($query->num_rows() > 0){
					$rows = $query->result_array();
					foreach($rows as $row){
						print_r($row);
						$data = $row;
						$data['packet_type'] = $table;
						unset($data['id']);
						unset($data['aggd']);
						$ins = $this->db->insert('aggregates',$data);
						if($ins){
							$this->db->where('id', $row['id']);
							$upd = $this->db->update($table, array('aggd'=>1));
							if($upd){
								print "data updated\r\n";
							}else{
								print "failed to update\r\n";
							}
						}
					}
				}
			}
			//$this->db->close();
			sleep(10);
		}
	}
	
	function alert(){
		//TODO : incorporate time interval
		
		$q = $this->db->get('thresholds');
		//print_r($q->result());
		foreach($q->result() as $r){
			
			/*
			[id] => 2
            [threshold_name] => Threshold 2
            [app] => 1
            [table_name] => arps
            [column_name] => 
            [is_sum] => 0
            [time_interval] => 300000
            [min] => 234
            [max] => 10000
			*/
			
			//print_r($r);

			if($r->table_name != '' && $r->column_name != ''){
				if($r->shot_type == 'sum'){
					$this->db->select_sum($r->column_name);
					$this->db->where('packet_type',$r->table_name);
					$query = $this->db->get('aggregates');
					$val = $query->row();
					$val = $val->{$r->column_name};
				}elseif($r->shot_type == 'count'){
					$this->db->where('packet_type',$r->table_name);
					$this->db->from('aggregates');
					$val = $this->db->count_all_results();
					//$query = $this->db->get('aggregates');
					//$val = $query->row();
					//$val = $val->numrows;
				}elseif($r->shot_type == 'snapshot'){
					$this->db->select($r->column_name);
					$this->db->where('packet_type',$r->table_name);
					$query = $this->db->get('aggregates',1,0);
					$val = $query->row();
					$val = $val->{$r->column_name};
				}
				
				//print_r($query->result());
				
				//print $this->db->last_query();
				//print_r($query->result());
				print "value : ".$val."\r\n";
				if($val > $r->max || $val < $r->min){
					
					$this->db->select('users.email');
					$this->db->from('users');
					$this->db->join('threshold_users', 'users.id = threshold_users.user_id');
					$this->db->where('threshold_users.threshold_id',$r->id);
					$recs = $this->db->get();

					//print($this->db->last_query());
					
					//print_r($recs->result());
					
					foreach($recs->result() as $rec){
						$subject = 'VDPI Alert';
						$body = sprintf('%s = %s, exceeding threshold ( min %s , max %s)',$r->table_name.':'.$r->column_name,$val,$r->min,$r->max);
						$this->send_email($subject,$body,'admin@bigjava.com',$rec->email,null);
					}
					
				}
				
			}
		}
	}
	
	function report(){
		
	}
	
	function dbbackup(){
		$this->load->dbutil();
		$prefs = $this->config->item('backup_prefs');
		$backup =& $this->dbutil->backup($prefs); 
		
		if($prefs['format'] == 'gzip'){
			$ext = '.tgz';
		}else if($prefs['format'] == 'txt'){
			$ext = '.sql';
		}
		
		$filename = 'backup_'.time().$ext;
		
		write_file($this->config->item('backup_dir').'backup_'.time().$ext, $backup);
		
		$fileinfo = array('filename'=>$filename);
		
		$this->db->insert('backups',$fileinfo);
		
	}
	
	function send_email($subject,$body,$from,$to,$attachment_path = null){
		$this->load->helper('vdpi_helper');
		//print get_setting('smtp_server')."\r\n".get_setting('smtp_port');
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => get_setting('smtp_server'),
		    'smtp_port' => get_setting('smtp_port'),
		    'smtp_user' => get_setting('smtp_user'),
		    'smtp_pass' => get_setting('smtp_pass'),
		    'charset'   => 'iso-8859-1'
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('admin@bigjava.com', 'VDPI Admin');
		$this->email->to('andy.awidarto@bigjava.com'); 

		$this->email->subject('Threshold Alert');
		$this->email->message('Testing the email class.');	

		if ( ! $this->email->send())
		{
		    return False;
		}else{
		    return True;
		}
		
	}
}

?>