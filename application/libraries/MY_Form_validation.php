<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * MY_Form_Validation Class
 *
 * Extends Validation library
 *
 * Adds generic validation() method to allow variable validation.
 *
 */

class MY_Form_validation extends CI_Form_validation
{

    function __construct(){
        parent::__construct();
    }

    /**
     * Executes the Validation routines on a var instead of _POST
     *
     * @access    public
     * @param    mixed        Single value or array of values to validate.
     * @param    string        String of cascading rules.
     * @param    function    Callback function with error string as parameter.
     * @return    boolean        True on success, false on fail.
     */
    function validate($var, $rules, $callback=NULL)
    {
        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');
    
        // Let's fake the required variables
        $is_array = FALSE;
        if(is_array($var))
        {
            $is_array = TRUE;
        }
        
        $row = array('field'=>'fake', 'label'=>'fake', 'rules'=>$rules, 'is_array'=>$is_array, 'keys'=>array(), 'postdata'=>NULL, 'error'=>'' );                
        $this->_field_data['fake']['postdata'] = $var;
        
        // Test for errors exactly like run() does...
        $this->_execute($row, explode('|', $row['rules']), $this->_field_data['fake']['postdata']);
        
        // We have an error!
        if ( isset($this->_field_data['fake']['error']) )
        {
            // Slightly reformat the default error messages
            $error = ucfirst( str_replace( 'The fake field ' , '' ,  $this->_field_data['fake']['error'] ));
            
            // Callback func
            if(is_callable($callback))
            {
                call_user_func($callback, $error);
            }
            return FALSE;
        }
        return TRUE;
    }
}
?>