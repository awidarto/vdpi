<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends Public_Controller{
    
    public function __construct()
    {
        parent::__construct();
		$this->tf_assets->add_css('reset');
    	$this->tf_assets->add_css('text');
    	$this->tf_assets->add_css('form');
    	$this->tf_assets->add_css('buttons');
    	$this->tf_assets->add_css('login');
    	
        $this->tf_assets->add_js('https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js', array('group' => 'top'));
        
        $this->tf_assets->add_js('site', array('group' => 'bottom'));
        $this->tf_assets->set_layout('login');
        $this->tf_assets->add_data('page_title', 'Welcome to Jayon Express');
    }

	public function index()
	{
        $this->tf_assets->render_layout();
	}
	
	public function login()
	{
	    // if this request is a form submission
	    if ($_POST)
	    {
	        // get form values and xss filter the input
            $identity = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            // if user is logged in successfully
            if($this->ion_auth->login($identity,$password)) 
            {
                // send on to protected area ('user' controller)
				// print $this->ion_auth->logged_in();
                redirect('admin/home','location');
            }
            else // incorrect creds
            {
                // load up error
                $this->tf_assets->add_data('error','Incorrect Credentials');
                
                // load form view again, with error
                $this->tf_assets->render_layout();
            }
	    }
	    else // show form view
	    {
            $this->tf_assets->render_layout();
	    }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */