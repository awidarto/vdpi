<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {

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
    	$this->tf_assets->add_css('plugin/uniform.default.css');
    	$this->tf_assets->add_css('plugin/dataTables.css');
    	$this->tf_assets->add_css('custom.css');
    	
        //$this->tf_assets->add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', array('group' => 'top'));
        $this->tf_assets->add_js('jquery/jquery-1.7.1.min.js', array('group' => 'top'));
        $this->tf_assets->add_js('highcharts/js/highcharts.js', array('group' => 'top'));
        $this->tf_assets->add_js('highstock/js/highstock.js', array('group' => 'top'));
        $this->tf_assets->add_js('fancybox/jquery.fancybox.js', array('group' => 'top'));

        $this->tf_assets->add_js('fancybox/jquery.easing-1.3.pack.js', array('group' => 'top'));
        $this->tf_assets->add_js('fancybox/jquery.fancybox-buttons.js', array('group' => 'top'));
        $this->tf_assets->add_js('fancybox/jquery.fancybox-thumbs.js', array('group' => 'top'));
        $this->tf_assets->add_js('fancybox/jquery.mousewheel-3.0.6.pack.js', array('group' => 'top'));

        
        $this->tf_assets->set_layout('dashboard');
        $this->tf_assets->add_data('page_title', 'Welcome to Jayon Express');

		$this->load->model('vdpi_model');
		
		$this->load->library('jpgraph');

    }

    function index() {
		$this->tf_assets->set_content('report');
		$this->tf_assets->render_layout();
    }

	function protocol($protocol,$column_name,$time_col,$from,$to,$calc_type){
		
		if($calc_type == 'sum'){
			$this->db->select_sum($column_name);
			$this->db->where('packet_type',$r->table_name);
			$query = $this->db->get('aggregates');
			$val = $query->row();
			$val = $val->{$r->column_name};
		}elseif($shot_type == 'count'){
			$this->db->where('packet_type',$table_name);
			$this->db->from('aggregates');
			$val = $this->db->count_all_results();
			//$query = $this->db->get('aggregates');
			//$val = $query->row();
			//$val = $val->numrows;
		}elseif($shot_type == 'snapshot'){
			$this->db->select($r->column_name);
			$this->db->where('packet_type',$table_name);
			$query = $this->db->get('aggregates',1,0);
			$val = $query->row();
			$val = $val->{$r->column_name};
		}
	}
	
	function bandwidth($proto){
		$this->db->select("concat_ws(' ',substring(first_pkt,1,10),substring(substring_index(first_pkt,'.',1),11)) as packet_time,substring_index(first_pkt,'.',-1) as ms,sum(total_pkt) as total_pkt",false);
		$this->db->group_by('packet_time');
		$this->db->from('con_ret_rtt');
		$this->db->where('prot_type',$proto);
		$query = $this->db->get();
		
		//print $this->db->last_query();
		
		$out = array();
		foreach($query->result_array() as $val){
			$out[] = array(mysql_to_unix($val['packet_time']),$val['total_pkt']);
			//$out['x'][] = mysql_to_unix($val['packet_time']);
			//$out['y'][] = $val['total_pkt'];
		}
		
		print json_encode($out);
		
	}

	function bw($proto,$from = null, $to = null){
		$this->db->select("substring_index(first_pkt, '.', 1 ) as packet_time,substring_index(first_pkt,'.',-1) as ms,sum(total_pkt) as total_pkt",false);
		$this->db->group_by('packet_time');
		$this->db->from('con_ret_rtt');
		$this->db->where('prot_type',$proto);
		
		if($from != null){
			
		}
		
		$query = $this->db->get();
		
		//print $this->db->last_query();
		
		$out = array();
		foreach($query->result_array() as $val){
			//$out[] = array(mysql_to_unix($val['packet_time']),$val['total_pkt']);
			$x[] = $val['packet_time'];
			$y[] = $val['total_pkt'];
		}
		
		//print json_encode($out);
		
		$opt = array(
			'width'=>1000,
			'height'=>600,
			'scale'=>'auto'
		);
		
		$graph = $this->jpgraph->Graph($opt);
		$graph->SetScale("textlin");
		$graph->SetMargin(80,60,50,180);

		//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
		$graph->SetBox(true);

		$graph->ygrid->SetFill(false);
		
		$graph->xaxis->SetTitle('Time','middle');
		$graph->xaxis->SetTitleMargin(150);
		$graph->xaxis->SetTickLabels($x);
		$graph->xaxis->SetLabelAngle(90);

		$graph->yaxis->SetTitle('Packet (Avg.)','middle');
		$graph->yaxis->SetTitleMargin(60);
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);

		// Create the bar plots
		$bplot = $this->jpgraph->linePlot($y);
		// ...and add it to the graPH
		$graph->Add($bplot);

		$bplot->SetColor("white");
		$bplot->SetFillColor("#cc1111");

		$graph->title->Set(strtoupper($proto));
		$graph->title->SetMargin(20);

		// Display the graph
		$graph->Stroke();
		
	}
	
	function pie(){
		
		$this->db->select("substring_index(first_pkt, '.', 1 ) as packet_time,substring_index(first_pkt,'.',-1) as ms,sum(total_pkt) as total_pkt",false);
		$this->db->group_by('packet_time');
		$this->db->from('con_ret_rtt');
		$this->db->where('prot_type',$proto);
		$query = $this->db->get();
		
		//print $this->db->last_query();
		
		$out = array();
		foreach($query->result_array() as $val){
			//$out[] = array(mysql_to_unix($val['packet_time']),$val['total_pkt']);
			$x[] = $val['packet_time'];
			$y[] = $val['total_pkt'];
		}
		
		//print json_encode($out);
		
		$opt = array(
			'width'=>1000,
			'height'=>600,
			'scale'=>'auto'
		);
		
		$graph = $this->jpgraph->Graph($opt);
		$graph->SetScale("textlin");
		$graph->SetMargin(80,60,50,180);

		//$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
		$graph->SetBox(true);

		$graph->ygrid->SetFill(false);
		
		$graph->xaxis->SetTitle('Time','middle');
		$graph->xaxis->SetTitleMargin(150);
		$graph->xaxis->SetTickLabels($x);
		$graph->xaxis->SetLabelAngle(90);

		$graph->yaxis->SetTitle('Packet (Avg.)','middle');
		$graph->yaxis->SetTitleMargin(60);
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);

		// Create the bar plots
		$bplot = $this->jpgraph->linePlot($y);
		// ...and add it to the graPH
		$graph->Add($bplot);

		$bplot->SetColor("white");
		$bplot->SetFillColor("#cc1111");

		$graph->title->Set(strtoupper($proto));
		$graph->title->SetMargin(20);

		// Display the graph
		$graph->Stroke();
	}


}

?>