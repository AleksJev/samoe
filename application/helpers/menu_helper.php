<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function gen_menu($array, $parent = 0, $level = 0)
{
  $has_children = false;
  
  foreach($array as $key => $value)
  {
    if ($value['parent'] == $parent) 
    {                   
      if ($has_children === false)
      {
        $has_children = true;  
        echo "\n<ul>";
        $level++;
      }
               
    echo '<li><a href="'.$value['link'].'">'.$value['name'].'</a>';
    gen_menu($array, $key, $level); 
    echo "</li>\n";
    }
  }
  if ($has_children === true)
  echo "</ul>\n";
}


function get_parent_name($id)
    {
        
        if($id !=0)
        {
            $ci = get_instance();
            $ci->db->select('name');
            $ci->db->where('id',$id);
            $query=$ci->db->get('menu');
            $result = $query->row_array();
            return $result['name'];
        }
        else
        {
            return 'root';
        }
    }
    
    function hlebnaja_kroshka($menu_id)
    {
        $ci = get_instance();
        $ci ->db->select('name,parent');
        $ci->db->where('id',$menu_id);
        $query = $ci ->db->get('menu');
        $result = $query -> row_array();
        $hleb[] = $result['name'];      //
        if($result['parent'] !=0) 
        hlebnaja_kroshka($result['parent']); 
        
        
        
        return $hleb;
    } 
    
    
    
    
    
    
    
?>