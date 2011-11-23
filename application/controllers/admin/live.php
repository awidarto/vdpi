<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Live extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('vdpi_model');
    }

    function index() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        
    }

	function live($protocol,$column,$type,$lasttime = null){

		header("Content-type: text/json");

		// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
		$x = time() * 1000;
		
		//print_r(getdate($x));
		
		if(is_null($lasttime) || $lasttime == 0 || $lasttime == 'undefined'){
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