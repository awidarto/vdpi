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
		$this->load->helper('vdpi_helper');
		print get_setting('smtp_server')."\r\n".get_setting('smtp_port');
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
		    print "Error sending mail\r\n";
		}
		
	}
	
	function report(){
		
	}
}

?>