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
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if ( ! function_exists('get_setting'))
{
	function get_setting($key)
	{
		$CI =& get_instance();
		$query = $CI->db->query('SELECT val_txt,val_int FROM settings WHERE skey = \''.$key.'\'');
		$result = false;
		if($query->num_rows > 0){
			$res = $query->row();
			if($res->val_txt == ''){
				$result = $res->val_int;
			}else{
				$result = $res->val_txt;
			}
		}else{
			$result = 0;
		}
		return $result;
	}
}

