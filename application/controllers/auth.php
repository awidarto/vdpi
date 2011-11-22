<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        redirect('/');
    }

    /**
     * Global Login function to log user in and direct to proper area
     *
     * @return void
     * @author Jonathan Johnson
     **/
	//log the user in
	function login()
	{
		$this->data['title'] = "Login";
		
		if ($this->ion_auth->logged_in())
		{
			//already logged in so no need to access this page
			redirect($this->config->item('base_url'), 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{ //check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
			{ //if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect($user->group.'/home', 'refresh');
			}
			else
			{ //if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->load->view('auth/login', $this->data);
		}
	}

    /**
     * Global logout function to destroy user session
     *
     * @return void
     * @author Jonathan Johnson
     **/
    function logout() {   //Basic Ion_Auth Logout function
        $this->ion_auth->logout();
        redirect('/');
    }

}