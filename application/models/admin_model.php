<?php
class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent :: __construct();
        $this->get_preferences();
    }
    
    public function get_preferences()
    {
        $query = $this->db->get('preferences');
        $preferences = $query->result_array();
        
        foreach($preferences as $item)
        {
            $val = $item['value'];
            
            if(is_numeric($val))
            {
                settype($val,"int");
            }
            $this->config->set_item($item['pref_id'],$val);
        }
    }
}


?>