<?php
class Menu_model extends CI_Model
{
	function get_menu($user=1)
	{
	   $categories = array();
	   if($user)
       
       
       if (!empty($_SESSION['user']['user']) && ($_SESSION['user']['level'] == 'admin'))
       {
        $this -> db -> or_where ('visible',2);
        $this -> db -> or_where ('visible',1);
        
       }
       else
       {
        $this -> db -> or_where ('visible',1);
       }
       
       $logged_in = $this->session->userdata('logged_in');
       
       if ((!empty($logged_in)) && ($logged_in == 'logged'))
       {
        $this -> db -> or_where ('visible',3);
        
       }
		
        
        
        
        
		$this -> db -> order_by('position');
		$query = $this -> db -> get ('menu');
		
		foreach ($query->result_array() as $row)
		{
			$categories[$row['id']] = array(
			'id' => $row['id'], 
			'name' => $row['name'], 
			'link' => $row['link'], 
			'parent' => $row['parent'],
            'position' => $row['position'],
            'visible' => $row['visible']
			);
		}
		
		return $categories;
	}
    function turn_on_off($id,$what_update)
    {
        $this->db->where('id',$id);
        $this->db->update('menu',$what_update);
    }
    
    
    
}
?>
