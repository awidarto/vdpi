<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->tf_assets->add_css('reset');
    	$this->tf_assets->add_css('text');
    	$this->tf_assets->add_css('form');
    	$this->tf_assets->add_css('buttons');
    	$this->tf_assets->add_css('grid');
    	$this->tf_assets->add_css('layout');
    	

    	$this->tf_assets->add_css('ui-darkness/jquery-ui-1.8.12.custom.css');
    	$this->tf_assets->add_css('plugin/jquery.visualize.css');
    	$this->tf_assets->add_css('plugin/jquery.fancybox.css');
    	$this->tf_assets->add_css('helpers/jquery.fancybox-buttons.css');
    	$this->tf_assets->add_css('helpers/jquery.fancybox-thumbs.css');
    	$this->tf_assets->add_css('plugin/uniform.default.css');
    	$this->tf_assets->add_css('plugin/dataTables.css');
    	$this->tf_assets->add_css('custom.css');
    	
        //$this->tf_assets->add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', array('group' => 'top'));
        $this->tf_assets->add_js('jquery/jquery-1.7.1.min.js', array('group' => 'top'));
        //$this->tf_assets->add_js('highcharts/js/highcharts.js', array('group' => 'top'));
        //$this->tf_assets->add_js('highstock/js/highstock.js', array('group' => 'top'));
        $this->tf_assets->add_js('flot/jquery.flot.js', array('group' => 'top'));
        $this->tf_assets->add_js('fancybox/jquery.fancybox.js', array('group' => 'top'));
        
        $this->tf_assets->set_layout('dashboard');
        $this->tf_assets->add_data('page_title', 'Welcome to VDPI');
		
		$this->load->model('vdpi_model');
    }

    function index() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $this->tf_assets->set_content('dash_home');
        $this->tf_assets->render_layout();
        
    }

	function sess(){
		
		$this->db->select('unix_timestamp(session_start) as session_start,(src_sent_byte+dst_sent_byte+src_sent_pkt+dst_sent_pkt) as bw')->from('con_ses');
		$this->db->limit(100);
		$this->db->order_by('session_start','desc');
		$query = $this->db->get();
		$xc = 0;
		foreach($query->result() as $r){
			
			//$dt = strtotime(date('Y-m-d h:i:s UTC',$r->session_start)) * 1000;
			$dt = $r->session_start * 1000;
			
			$x[] = array($dt,(int)$r->bw);
		}
		
		$sdata = array('label'=>'Session','data'=>$x);
		// Create a PHP array and echo it as JSON
		echo json_encode($sdata);
	}

	function ret(){
		
		$this->db->select('unix_timestamp(first_pkt) as session_start,(src_addr_ret_byte+dst_addr_ret_byte) as bw')->from('con_ret_rtt');
		$this->db->limit(100);
		$this->db->order_by('session_start','desc');
		$query = $this->db->get();
		$xc = 0;
		foreach($query->result() as $r){
			$dt = $r->session_start * 1000;
			$x[] = array($dt,((int)$r->bw));
		}
		
		$sdata = array('label'=>'Retransmit','data'=>$x);
		// Create a PHP array and echo it as JSON
		echo json_encode($sdata);
	}

	function combined(){
		$this->db->select('unix_timestamp(session_start) as session_start,(src_sent_byte+dst_sent_byte+src_sent_pkt+dst_sent_pkt) as bw')->from('con_ses');
		$this->db->limit(100);
		$query = $this->db->get();
		foreach($query->result() as $r){
			$a[] = array($r->session_start,((int)$r->bw)/1000);
		}

		$this->db->select('unix_timestamp(first_pkt) as session_start,(src_addr_ret_byte+dst_addr_ret_byte) as bw')->from('con_ret_rtt');
		$this->db->limit(200);
		$this->db->order_by('session_start','desc');
		$query = $this->db->get();
		foreach($query->result() as $r){
			$b[] = array($r->session_start,((int)$r->bw)/1000);
		}
		
		$sdata = array(array('label'=>'Retransmit','data'=>$a),array('label'=>'Session','data'=>$b));
		// Create a PHP array and echo it as JSON
		echo json_encode($sdata);
	}

	function live($protocol,$column,$type,$lasttime = null){

		header("Content-type: text/json");

		// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
		$x = time() * 1000;
		
		//print_r(getdate($x));
		
		if(is_null($lasttime) || $lasttime == 0){
			$where = 'capture_date >= '.time();
		}else{
			$where = 'capture_date >= '.$lasttime;
		}
				
		if($type == 'sum'){
			$sum = $this->vdpi_model->getSumFromTable($protocol,$column,$where);
		}else{
			$sum = $this->vdpi_model->getCountFromTable($protocol,$column,$where);
		}
		
		//print_r($sum->result());
		
		$sum = $sum->row();
		
		$y = $sum->{$column};
		
		$y = (is_null($y))?0:$y;

		// Create a PHP array and echo it as JSON
		$ret = array($x, $y);
		echo json_encode($ret);
	}

	function ajax(){
		// Set the JSON header
		header("Content-type: text/json");

		// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
		$x = time() * 1000;
		// The y value is a random number
		$y = rand(0, 100);
		

		// Create a PHP array and echo it as JSON
		$ret = array($x, $y);
		echo json_encode($ret);
	}

}

?>