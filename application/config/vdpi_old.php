<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  VDPI Admin Menu
* 
* Author: Ben Edmunds
* 	  ben.edmunds@gmail.com
*         @benedmunds
*          
* Added Awesomeness: Phil Sturgeon
* 
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth/
*          
* Created:  10.01.2009 
* 
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
* 
*/

	/**
	 * VDPI Menu Tables.
	 **/
	$config['vdpi_menu']  = array(
		'webs'=>array(
			'title'=>'HTTP',
			'table'=>'webs',
			'columns'=>array(
				'Time'=>'capture_date',
				'Host'=>'host',		 	 	 	 	 	 	 
				'Content Type'=>'content_type', 	 	 	 	 	 	 
				'URL'=>'url'
			)
		),
		'arps'=>array(
			'title'=>'ARP',
			'table'=>'arps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',		 	 	 	 	 	 	 
				'MAC'=>'mac', 	 	 	 	 	 	 
				'IP Address'=>'ip'
			)
		),
		'dns_messages'=>array(
			'title'=>'DNS',
			'table'=>'dns_messages',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',		 	 	 	 	 	 	 
				'Important'=>'important', 	 	 	 	 	 	 
				'Host Name'=>'hostname', 	 	 	 	 	 	 
				'CNAME'=>'cname', 	 	 	 	 	 	 
				'IP Address'=>'ip'
			)
		),
		
	);

	
/* End of file vdpi.php */
/* Location: ./system/application/config/vdpi.php */