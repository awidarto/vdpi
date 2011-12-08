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
	
	function download($table_name){

		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'),$this->config->item('vdpi_bandwidth_menu'));
		
		$from = str_pad($this->input->post('from_year'),4,'0',STR_PAD_LEFT).'-'.str_pad($this->input->post('from_month'),2,'0',STR_PAD_LEFT).'-'.str_pad($this->input->post('from_day'),2,'0',STR_PAD_LEFT).' '.str_pad($this->input->post('from_hour'),4,'0',STR_PAD_LEFT).':'.str_pad($this->input->post('from_min'),2,'0',STR_PAD_LEFT).':'.str_pad($this->input->post('from_sec'),2,'0',STR_PAD_LEFT);
		$to = str_pad($this->input->post('to_year'),4,'0',STR_PAD_LEFT).'-'.str_pad($this->input->post('to_month'),2,'0',STR_PAD_LEFT).'-'.str_pad($this->input->post('to_day'),2,'0',STR_PAD_LEFT).' '.str_pad($this->input->post('to_hour'),4,'0',STR_PAD_LEFT).':'.str_pad($this->input->post('to_min'),2,'0',STR_PAD_LEFT).':'.str_pad($this->input->post('to_sec'),2,'0',STR_PAD_LEFT);
		
		if($this->input->post('pdf') || $this->input->post('csv')){
			
			if($table_name == 'con_ses'){
				$data['title'] = 'Session';
			}else{
				$data['title'] = 'RTT / Retransmit';
			}
			
			$headers = array_keys($menu_table[$table_name]['columns']);
			$columns = implode(',',array_values($menu_table[$table_name]['columns']));
			
			
			$this->db->select($columns);
			$this->db->from($table_name);
			
			$this->db->where(sprintf("unix_timestamp(capture_date) between unix_timestamp('%s') and unix_timestamp('%s')",$from,$to));
			
			$qres = $this->db->get();
			
			//print_r($qres->result());
			
			$this->table->set_heading($headers);
			$table = $this->table->generate($qres);
			
			//print $this->db->last_query();
			
			if($this->input->post('pdf')){
				
				$data['content'] = $table;
				
				$data['subtitle'] = 'Period : '.$from.' to '.$to;
				
				$html = $this->load->view('pdf/doc',$data,true);
				
				pdf_create($html, $table_name.'_'.time(),true);
				
				$tdld = 'PDF';
			}elseif($this->input->post('csv')){
				
				$this->load->dbutil();

				echo $this->dbutil->csv_from_result($qres);
				
				$tdld = 'CSV';
			}
			$data['message'] = sprintf('<p>Your %s download will be started in a jiffy...</p>',$tdld);
		}else{
			$data['message'] = false;
		}
		
		$data['table_name'] = $table_name;
		if($table_name == 'con_ses' || $table_name == 'con_ret_rtt'){
			if($table_name == 'con_ses'){
				$data['title'] = 'Session';
			}else{
				$data['title'] = 'RTT / Retransmit';
			}
		}else{
			$data['title'] = $menu_table[$table_name]['title'];
		}
		$this->load->view('reports/download_data',$data);
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
	
	function testpdf(){
		
		$html =
		  //'<html><body>'.
		  '<p>Put your html here, or generate it with your favourite '.
		  'templating system.</p>';
		  //'</body></html>';
		
		$html = $this->load->view('pdf/bandwidth','',true);
		
		//print $html;
		

		
		pdf_create($html, 'filename3',true);

	}

}

?>