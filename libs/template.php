<?php
/*
 * Template loader class
 *
 * @author		Tomas Jakstas
 * @license		GNU AFFERO GENERAL PUBLIC LICENSE
 * @date		2010-10-01
 */

class Template {


    public $template_dir ;//= APP_PATH.'/templates/';
    public $template_ext = '.php';
    public $template_main = 'template';

    protected $tpl_arr = array();
    private static $s_template;

    
    function  __construct() {
	$this->template_dir = APP_PATH.'templates/';
    }


    /**
     * retrieve class instance
     * @return <type> 
     */
    static function get_instance() {
	if ( ! self::$s_template )
	     self::$s_template = new Template();
	return self::$s_template;
    }

    /**
     * load template using array keys as variables
     * @param <type> $name
     * @param <type> $var_array
     * @param <type> $return
     * @return <type> 
     */

    function load( $type, $name, $var_array, $return = false ) {

	global $config, $lang;
	
	$fullpath = $this->template_dir.$name.$this->template_ext;
	if ( file_exists($fullpath)) {

	    	if ( !is_array($var_array))
		    $var_array = (array)$var_array;
	        ob_start();
		extract($var_array);
		include $fullpath;
		$msg=ob_get_clean();
		if ( $return )
		    return $msg;
		//if template exists append
		if ( isset($this->tpl_arr[$type]) )
			$this->tpl_arr[$type] .= $msg;
		else
		    $this->tpl_arr[$type] = $msg;
	}
	else {
	    throw new Exception('file not found '.$fullpath);
	}
    }


    /**
     * render final output
     * @param <type> $return
     * @return <type> 
     */
    function render( $return = false ) {
	
	$arr = $this->tpl_arr;
	$this->tpl_arr = array();
	if ( $return )
	    return $this->load('main_template', $this->template_main, $arr, true);
	echo $this->load('main_template', $this->template_main, $arr, true);
    }
}