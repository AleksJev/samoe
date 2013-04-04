<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller{
    function __construct()
	{
		parent :: __construct();
        $this->data['popular_articles']=$this->articles_model->get_popular();
        $this->data['latest_articles']=$this->articles_model->get_latest();
        $this->data['all_category'] = $this->category_model->get_all();
        $this->data['menu'] = $this -> menu_model -> get_menu();
        $this->data['logged_in'] = $this->session->userdata('logged_in');
        $this->data['name']      = $this->session->userdata('name');
	}
    
    public function index()
    {
        //redirect(base_url());
    }
    
    public function show($cat_id,$start_from = 0)
    {
        $this->load->library('pagination');
        $this->load->library('pagination_lib');
        
        $this->data['cat_articles']=$this->category_model->get_articles($cat_id);
        $total = $this->data['counts']=$this->category_model->count_by($cat_id);
        $limit = $this->config->item('art_per_page');
        
        //  настройки постраничной навигации
        $settings = $this->pagination_lib->get_settings('category',$cat_id,$total,$limit);
        // применяем настройки
        $this->pagination->initialize($settings);
        //$limit=1;
        $this->data['article_list'] = $this->category_model->get_by($cat_id,$limit,$start_from);
        
        $this->data['page_nav'] = $this->pagination->create_links();
        $this->display_lib->user_page($this->data,'category/articles');
    }
    
}
?>