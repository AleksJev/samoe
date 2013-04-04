<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->library('grocery_CRUD');
        $this->data['logged_in'] = $this->session->userdata('logged_in');
        $this->data['name']      = $this->session->userdata('name');
        $this->data['user']      = $this->session->userdata('user');
        $this->data['level']      = $this->session->userdata('level');
        $this->data['menu'] = $this -> menu_model -> get_menu();
        
        if ($this->data['level'] != 'admin'){redirect(base_url());}	
	}
    function index()
    {
        $this->display_lib->admin_page($this->data,'admin/index','');
    }
    
     
    function articles()
    {
        $crud = new grocery_CRUD();
        //$crud->set_theme('flexigrid');
        //$crud->set_theme('datatables');
	
        $crud->set_table('articles');
        $crud->set_relation_n_n('category', 'art_cat', 'category', 'art_id', 'cat_id', 'cat_alias');
        $crud->change_field_type('count_views', 'hidden', '' );
        $crud->change_field_type('art_votes', 'hidden', '' );
        $crud->change_field_type('art_date', 'hidden', '' );
        $crud->display_as('category','Категории');
        //$crud->unset_columns('user_id','art_text','count_views','art_votes');
        //$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');
        $crud->set_field_upload('file_url','assets/uploads/files');
        $output = $crud->render();
        $this->display_lib->admin_page($this->data,'admin/index',$output);
        
    }
    function menu()
    {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $output = $crud->render();
        $this->display_lib->admin_page($this->data,'admin/index',$output);
    } 
    
    function users()
    {
        $crud = new grocery_CRUD();
        $output = $this->grocery_crud->render();
        $this->display_lib->admin_page($this->data,'admin/index',$output);
    }
    function category()
    {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $output = $crud->render();
        $this->display_lib->admin_page($this->data,'admin/index',$output);
    }  
    
    function subscription()
    {
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $output = $crud->render();
        $this->display_lib->admin_page($this->data,'admin/index',$output);
    } 
    
  
    
    
}




?>