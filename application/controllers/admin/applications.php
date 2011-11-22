<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Applications extends Admin_Controller {

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
    }

    function index($menu = 'webs') {
        $crud = new grocery_CRUD();
		
		$menu_table = array_merge($this->config->item('vdpi_content_menu'),$this->config->item('vdpi_protocol_menu'),$this->config->item('vdpi_application_menu'));

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
		return anchor_popup('http://'.$value,$value,'target="_blank"');
	}
    
    function log() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('delivery_log');

		$crud->set_subject('Delivery Log');
		$crud->columns('email','created_on','last_login','active');
		$crud->display_as('email','Email')
            ->display_as('created_on','Created')
            ->display_as('last_login','Last Login')
            ->display_as('active','Active');
		$crud->unset_add();
		$crud->unset_delete();
		
		$output = $crud->render(); 
		
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }


}

?>