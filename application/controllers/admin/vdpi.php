<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vdpi extends Admin_Controller {

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
    	$this->tf_assets->add_css('plugin/facebox.css');
    	$this->tf_assets->add_css('plugin/uniform.default.css');
    	$this->tf_assets->add_css('plugin/dataTables.css');
    	$this->tf_assets->add_css('custom.css');
    	
        //$this->tf_assets->add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', array('group' => 'top'));
        $this->tf_assets->add_js('jquery/jquery-1.5.2.min.js', array('group' => 'top'));
        $this->tf_assets->add_js('highcharts/js/highcharts.js', array('group' => 'top'));
        
        $this->tf_assets->set_layout('dashboard');
        $this->tf_assets->add_data('page_title', 'Welcome to Jayon Express');

		$this->load->model('vdpi_model');

    }

    function index($menu = 'webs') {
        $crud = new grocery_CRUD();
		
		$menu_table = $this->config->item('vdpi_menu');

 		$crud->set_theme('flexigrid');
 		$crud->set_table($menu_table[$menu]['table']);

 		$crud->set_subject($menu_table[$menu]['title']);
 		$crud->columns(array_values($menu_table[$menu]['columns']));
		foreach($menu_table[$menu]['columns'] as $key=>$val){
 			$crud->display_as($val,$key);
		}
		
		$crud->callback_column('url',array($this,'url_to_link'));
		
 		$crud->unset_add();
 		$crud->unset_edit();
 		$crud->unset_delete();

 		$crud->required_fields('first_name','last_name');

 		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
        
    }

	function url_to_link($value,$row){
		return anchor('http://'.$value,$value,'target="_blank"');
	}
	
	function aggregates() {
        $crud = new grocery_CRUD();
		
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));

 		$crud->set_theme('flexigrid');
 		$crud->set_table('aggregates');

 		$crud->set_subject('Live Monitor');
 		$crud->columns( 
			'packet_type',
			'capture_date',
			'ip',
			'mac',
			'hostname',
			'data_size',
			'cname',
			'url',
			'flow_info'
		);
		$crud->display_as('packet_type','Traffic Type')
			->display_as('capture_date','Timestamp')
			->display_as('flow_info','Flow Info')
			->display_as('hostname','Host Name')
			->display_as('cname','CNAME')
			->display_as('ip','IP Address')
			->display_as('url','URL')
			->display_as('mac','MAC Address')
			->display_as('data_size', 'Data Size');
		
		$crud->order_by('capture_date','desc');
		
		$crud->callback_column('url',array($this,'url_to_link'));
		
 		$crud->unset_add();
 		$crud->unset_edit();
 		$crud->unset_delete();

 		$crud->required_fields('first_name','last_name');

 		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();


        
    }
    
    
	function thresholds(){
		$crud = new grocery_CRUD();

 		$crud->set_theme('flexigrid');
		$crud->set_table('thresholds');
		
		//$crud->set_relation('app', 'applications','application_name');
		$crud->set_relation_n_n('thresholds', 'threshold_users', 'users', 'threshold_id', 'user_id', 'first_name');

		$crud->set_subject('Threshold');
		
		$crud->columns('threshold_name','table_name','column_name','is_sum','time_interval','min','max');
		$crud->display_as('threshold_name','Name')
			->display_as('column_name','Column')
			->display_as('table_name','Table')
			->display_as('is_sum','Sum | ~Count')
			->display_as('time_interval','Time Interval (ms)')
			->display_as('min','Min')
			->display_as('max','Max');
		
		$crud->callback_add_field('table_name',array($this,'_table_names_add'));
		$crud->callback_edit_field('table_name',array($this,'_table_names_edit'));

		$crud->callback_add_field('column_name',array($this,'_column_names_add'));
		$crud->callback_edit_field('column_name',array($this,'_column_names_edit'));
		
		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
	}
	
	
	function _table_names_add(){
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));
		$selections = array();
		foreach($menu_table as $key=>$val){
			$selections[$key] = $val['title'];
		}
		return form_dropdown('table_name',$selections);
	}

	function _table_names_edit($value,$primary_key){
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));
		$selections = array();
		foreach($menu_table as $key=>$val){
			$selections[$key] = $val['title'];
		}
		return form_dropdown('table_name',$selections,$value);
	}


	function _column_names_add(){
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));
		$selections = array();
		foreach($menu_table as $key=>$val){
			foreach($val['columns'] as $key=>$val){
				$selections[$val] = $key; 
			}
		}
		return form_dropdown('column_name',array_unique($selections));
	}

	function _column_names_edit($value,$primary_key){
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));
		$selections = array();
		foreach($menu_table as $key=>$val){
			foreach($val['columns'] as $key=>$val){
				$selections[$val] = $key; 
			}
		}
		return form_dropdown('column_name',array_unique($selections),$value);
	}


	function applications(){
		$crud = new grocery_CRUD();

 		$crud->set_theme('flexigrid');
		$crud->set_table('applications');

		$crud->set_subject('Threshold Application');
		
		$crud->columns('application_name','application_table');
		$crud->display_as('application_name','Application Name')
			->display_as('application_table','Application Table')
			->display_as('application_parameter','Application Parameter');

		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
	}
	
	function settings(){
		$crud = new grocery_CRUD();

 		$crud->set_theme('flexigrid');
		$crud->set_table('settings');

		$crud->set_subject('Setting');
		
		$crud->columns('skey','val_txt','val_int','name');
		$crud->display_as('skey','Key')
			->display_as('val_txt','Text Value')
			->display_as('val_int','Integer Value')
			->display_as('name','Name')
			;

		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
	}

	function periodicals(){
		$crud = new grocery_CRUD();

 		$crud->set_theme('flexigrid');
		$crud->set_table('periodicals');
		
		$crud->set_relation_n_n('periodicals', 'periodical_users', 'users', 'periodical_id', 'user_id', 'first_name');

		$crud->set_subject('Periodical Reports');
		
		$crud->columns('periodical_name','controller','action','param');
		$crud->display_as('periodical_name','Name')
			->display_as('controller','Controller')
			->display_as('action','Action')
			->display_as('param','Parameter');

		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
	}

	function reports(){
		$this->tf_assets->set_content('report');
        $this->tf_assets->render_layout();
	}
	
	function dbbackup(){
		$this->tf_assets->set_content('dbbackup');
        $this->tf_assets->render_layout();
	}

	function live($protocol,$column,$type,$lasttime = null,$interval = 0){

		header("Content-type: text/json");

		// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
		$x = time() * 1000;
		
		//print_r(getdate($x));
		
		if(is_null($lasttime) || $lasttime == 0){
			if($interval == 0){
				$where = 'capture_date >= FROM_UNIXTIME('.time().')';
			}else{
				$where = 'capture_date BETWEEN FROM_UNIXTIME('.(time() - $interval).') AND FROM_UNIXTIME('.time().') ORDER BY capture_date DESC';
			}
		}else{
			if($interval == 0){
				$where = 'capture_date >= FROM_UNIXTIME('.$lasttime.')';
			}else{
				$where = 'capture_date BETWEEN FROM_UNIXTIME('.($lasttime - $interval).') AND FROM_UNIXTIME('.$lasttime.') ORDER BY capture_date DESC';
			}
		}
				
		if($type == 'sum'){
			$sum = $this->vdpi_model->getSumFromTable($protocol,$column,$where);
		}else{
			$sum = $this->vdpi_model->getCountFromTable($protocol,$column,$where);
		}
		
		$sql = $this->db->last_query();
		
		//print_r($sum->result());
		
		$sum = $sum->row();
		
		$y = $sum->{$column};
		
		$y = (is_null($y))?10:$y;

		// Create a PHP array and echo it as JSON
		$ret = array($x, $y,$sql);
		echo json_encode($ret);
	}


}

?>