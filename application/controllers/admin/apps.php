<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apps extends Admin_Controller {

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
    	
        $this->tf_assets->add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', array('group' => 'top'));
        
        
        $this->tf_assets->set_layout('dashboard');
        $this->tf_assets->add_data('page_title', 'Welcome to Jayon Express');
    }

    function index() {
        $crud = new grocery_CRUD();

 		$crud->set_theme('flexigrid');
 		$crud->set_table('applications');

 		$crud->set_subject('Application Key');
 		/*
 		$crud->columns('email','created_on','last_login','active');
 		$crud->display_as('email','Email')
             ->display_as('created_on','Created')
             ->display_as('last_login','Last Login')
             ->display_as('active','Active');
 		$crud->unset_add();
 		$crud->unset_delete();
        */

 		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
        
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

	function thresholds(){
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('thresholds');

		$crud->set_subject('Threshold');
		
		$crud->columns('threshold_name','app','min','max');
		$crud->display_as('threshold_name','Name')
			->display_as('app','Application')
			->display_as('min','Min')
			->display_as('max','Max');

		$output = $crud->render(); 

         $this->tf_assets->add_data('output', $output);
         $this->tf_assets->set_content('dash_content_table');
         $this->tf_assets->render_layout();
	}


}

?>