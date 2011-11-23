<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class Admin_Controller extends CI_Controller {

    protected $the_user = null;

	/**
	 * Constructor
	 */
	public function __construct()
	{
        parent::__construct();

        //Check if user is in admin group
        if ( $this->ion_auth->logged_in() ) {
                        
            //Put User in Class-wide variable
            $this->the_user = $this->ion_auth->user()->row();

            //Store user in $data
            $data->the_user = $this->the_user;

            //Load $the_user in all views
            $this->load->vars($data);
        } else {
            redirect('/','refresh');
        }
	}

	public function logout()
	{
	    // log current user out and send back to public root
	    $this->ion_auth->logout();
	    redirect('/');
	}	

}

class User_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->is_group('user')) {
            $data->the_user = $this->ion_auth->user()->row();
            $this->the_user = $data->the_user;
            $this->load->vars($data);
        }
        else {
            redirect('/','refresh');
        }
    }
}

class Common_Auth_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->logged_in()) {
            $data->the_user = $this->ion_auth->user()->row();
            $this->the_user = $data->the_user;
            $this->load->vars($data);
        }
        else {
            redirect('/');
        }
    }
}

class Public_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->logged_in()) {
            $data->the_user = $this->ion_auth->user()->row();
            $this->the_user = $data->the_user;
            $this->load->vars($data);
        }
        else {
            $this->the_user = null;
            $data->the_user = $this->the_user;
            $this->load->vars($data);
        }
    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */