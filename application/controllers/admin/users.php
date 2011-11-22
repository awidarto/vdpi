<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller {

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
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('users');
		$crud->set_relation('group_id','groups','name');
		$crud->set_subject('User');

		$crud->columns('username','email','first_name','last_name','active','group_id');
		$crud->display_as('username','Username')
			->display_as('email','Email')
			->display_as('first_name','First Name')
			->display_as('last_name','Last Name')
			->display_as('group_id','Group')
			->display_as('active','Active');
		
		$crud->required_fields('first_name','last_name');
		
		$crud->callback_before_insert('pass_new');
		
		$output = $crud->render();
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }

	function pass_new($data){
		$this->load->model('ion_auth_model');
		$data['salt'] = $this->ion_auth_model->salt();
		$data['password'] = $this->ion_auth_model->hash_password($data['password'], $data['salt']);
		
		return $data;
	}
    
    function admins() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('users');
		$crud->set_relation('id','admin_meta','user_id');

		$crud->set_subject('Administrator');
		$crud->columns('email','created_on','last_login','active');
		$crud->display_as('email','Email')
            ->display_as('created_on','Created')
            ->display_as('last_login','Last Login')
            ->display_as('active','Active');
		$crud->unset_add();
		$crud->unset_delete();
		
		$crud->required_fields('first_name','last_name');
		
		$output = $crud->render(); 
		
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }
    
    function couriers() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('couriers');

		$crud->set_subject('Courier');
		$crud->columns('email','created_on','last_login','active');
		$crud->display_as('email','Email')
            ->display_as('created_on','Created')
            ->display_as('last_login','Last Login')
            ->display_as('active','Active');
		$crud->unset_add();
		$crud->unset_delete();
		
		$crud->required_fields('first_name','last_name');
		
		$output = $crud->render(); 
		
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }

    function buyers() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('users');

		$crud->set_subject('Buyer');
		$crud->columns('email','created_on','last_login','active');
		$crud->display_as('email','Email')
            ->display_as('created_on','Created')
            ->display_as('last_login','Last Login')
            ->display_as('active','Active');
		$crud->unset_add();
		$crud->unset_delete();
		
		$crud->required_fields('first_name','last_name');
		
		$output = $crud->render(); 
		
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }
    

    function merchants() {
        //do stuff here -
        //remember that $this->the_user is available in this controller
        //as is $the_user available in any view I load
        
        //print_r($this->the_user);
        $crud = new grocery_CRUD();

		$crud->set_theme('flexigrid');
		$crud->set_table('merchants');

		$crud->set_subject('Merchant');
		/*
		user_id	mediumint(8)		UNSIGNED	No			 	 	 	 	 	 	
        	street	text	latin1_swedish_ci		No			 	 	 				 
        	city	varchar(15)	latin1_swedish_ci		No			 	 	 	 	 	 	 
        	province	varchar(40)	latin1_swedish_ci		No			 	 	 	 	 	 	 
        	country	varchar(40)	latin1_swedish_ci		Yes	NULL		 	 	 	 	 	 	 
        	zip	varchar(40)	latin1_swedish_ci		No			 	 	 	 	 	 	 
        	phone_1	varchar(40)	latin1_swedish_ci		Yes	NULL		 	 	 	 	 	 	 
        	phone_2	varchar(40)	latin1_swedish_ci		Yes	NULL		 	 	 	 	 	 	 
        	mobile	varchar(40)	latin1_swedish_ci		Yes	NULL		 	 	 	 	 	 	 
        	fax	varchar(40)	latin1_swedish_ci		No			 	 	 	 	 	 	 
        	created_on
		*/
		
		$crud->columns('name','street','city','zip','province','country','phone_1','phone_2','mobile','fax','created_on');
		$crud->display_as('name','Name')
            ->display_as('street','Street')
            ->display_as('city','City')
            ->display_as('province','Province')
            ->display_as('country','Country')
            ->display_as('city','City')
            ->display_as('phone_1','Phone')
            ->display_as('phone_2','Phone (Secondary)')
            ->display_as('mobile','Mobile')
            ->display_as('city','City')
            ->display_as('zip','ZIP')
            ->display_as('created_on','Created')
            ->display_as('last_login','Last Login')
            ->display_as('active','Active');
		$crud->unset_add();
		$crud->unset_delete();
		
		$crud->required_fields('first_name','last_name');
		
		$output = $crud->render(); 
		
        $this->tf_assets->add_data('output', $output);
        $this->tf_assets->set_content('dash_content_table');
        $this->tf_assets->render_layout();
        
    }


}

?>