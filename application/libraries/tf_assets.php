<?php

class TF_Assets
{
    private $ci;
    private $layout;
    private $content;
    private $data = array();
    private $css = array();
    private $js = array();
	private $echo_js = array();
    
    /**
     * Instantly get a reference of CI
     */
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->config('tf_assets', TRUE);
    }
    /**
     * Set the layout to be used
     * @param string $layout 
     */
    public function set_layout($layout)
    {
        $this->layout = $layout;
    }
    /**
     * Set the content to be used
     * @param  string $content 
     */
    public function set_content($content)
    {
        $this->content = $content;
    }
    /**
     * Renders a partial
     * @param  string   $path
     * @param  array    $data
     * @param  boolean  $return
     * @return string/Boolean
     */
    public function render_partial($path, $data = array(), $return = FALSE)
    {
        $prefix = $this->ci->config->item('partial_prefix', 'tf_assets');
        $partial = $this->ci->load->view($prefix . $path, $data, TRUE);
        if ($return)
        {
            return $partial;
        }
        else
        {
            echo $partial;
        }
    }
    /**
     * Render the content
     * @param  array   $data
     * @param  boolean $return
     * @return string/Boolean  
     */
    public function render_content($data = array(), $return = FALSE)
    {
        $prefix = $this->ci->config->item('content_prefix', 'tf_assets');
        $content = $this->ci->load->view($prefix . $this->content, $data, TRUE);
        if (!$return)
        {
            echo $content;
        }
        else
        {
            return $content;
        }
    }
    /**
     * Adds a CSS file to load
     * @param  string $name
     * @param  array  $data 
     * @return
     */
    public function add_css($name, $data = array())
    {
        $this->css[$name] = $data;
    }
    /**
     * Render the CSS files
     * @param  string  $group
     * @param  boolean $return
     * @return string 
     */
    public function render_css($group = '', $return = FALSE)
    {
		$css_string = '';
        foreach ((array) $this->css as $css_path => $css_data)
        {
			$prefix = '';
			$suffix = '';
			$type = '';
			$media = ' media="screen"';
            // If a group is specified only show that group
            // Otherwise show all
            if (($group !== '' && $css_data['group'] == $group) || $group == '')
            {
                if (substr($css_path, 0, 4) != "http")
                {
                    $prefix = base_url() . $this->ci->config->item('css_prefix', 'tf_assets');
                }
                if (substr($css_path, -strlen($this->ci->config->item('css_suffix', 'tf_assets'))) !== $this->ci->config->item('css_suffix', 'tf_assets')
						&& (!isset($css_data['ignore_prefix']) || $css_data['ignore_prefix'] != TRUE))
                {
					$suffix = $this->ci->config->item('css_suffix', 'tf_assets');
                }
                if (isset($css_data['html5']) && $css_data['html5'] == FALSE)
                {
                    $type = ' type="text/css"';
                }
				if (isset($css_data['media']) && $css_data['media'] !== '')
				{
					$media = ' media="' . $css_data['media'] . '"';
				}
                $css_string .= '<link href="' . $prefix . $css_path . $suffix . '"' . $type . $media . ' rel="stylesheet" />';
            }
        }
        
        if (!$return)
        {
            echo $css_string;
        }
        else
        {
            return $css_string;
        }
    }
    /**
     * Add a js file to be loaded
     * @param  string $name
     * @param  array  $data 
     * @return
     */
    public function add_js($name, $data = array())
    {
        $this->js[$name] = $data;
    }
	/**
	 * JavaScript to echo out
	 * @param string $javascript 
	 */
	public function echo_js($javascript, $data = array())
	{
		$this->echo_js[$javascript] = $data;
	}
    /**
     * Render the js files
     * @param  string  $group
     * @param  boolean $return
     * @return string 
     */
    public function render_js($group = '', $return = FALSE)
    {
		$js_string = '';
        foreach ((array) $this->js as $js_path => $js_data)
        {
			$prefix = '';
			$suffix = '';
			$type = '';
            // If a group is specified only show that group
            // Otherwise show all
            if (($group !== '' && $js_data['group'] == $group) || $group == '')
            {
                if (substr($js_path, 0, 4) != "http")
                {
                    $prefix =  base_url() . $this->ci->config->item('js_prefix', 'tf_assets');
                }
                if (substr($js_path, -strlen($this->ci->config->item('js_suffix', 'tf_assets'))) !== $this->ci->config->item('js_suffix', 'tf_assets') 
					&& (!isset($js_data['ignore_prefix']) || $js_data['ignore_prefix'] != TRUE))
                {
                    $suffix = $this->ci->config->item('js_suffix', 'tf_assets');
                }
                
                if (isset($js_data['html5']) && $js_data['html5'] == FALSE)
                {
                    $type = ' type="text/javascript"';
                }
                $js_string .= '<script src="' . $prefix . $js_path . $suffix . '"' . $type .'></script>';
            }
        }
		foreach ((array) $this->echo_js as $js => $js_data)
		{
			$type = '';
			// If a group is specified only show that group
			// Otherwise show all
			if (($group !== '' && $js_data['group'] == $group) || $group == '')
			{
				if (isset($js_data['html5']) && $js_data['html5'] == FALSE)
				{
					$type = ' type="text/javascript"';
				}
				$js_string .= '<script' . $type . '>';
				$js_string .= $js;
				$js_string .= '</script>';
			}
		}
        if (!$return)
        {
            echo $js_string;
        }
        else
        {
            return $js_string;
        }
    }
    /**
     * Add data to be included in the view
     * @param string $name
     * @param mixed  $data 
     */
    public function add_data($name, $data)
    {
        $this->data[$name] = $data;
    }
    /**
     * Adds an array of data to be included in the view
     * @param array $data 
     */
    public function add_multiple_data($data)
    {
        $this->data = array_merge($this->data, $data);
    }
    /**
     * Clears the data
     */
    public function flush_data()
    {
        $this->data = array();
    }
    /**
     * Renders the layout as a whole
     * @param  boolean $return
     * @return string 
     */
    public function render_layout($return = FALSE)
    {
        $prefix = $this->ci->config->item('layout_prefix', 'tf_assets');
        // Need to echo from view straight to make {elapsed_time} etc work
        if (!$return)
        {
            $this->ci->load->view($prefix . $this->layout, $this->data);
        }
        else
        {
            return $this->ci->load->view($prefix . $this->layout, $this->data, TRUE);
        }
    }   
}