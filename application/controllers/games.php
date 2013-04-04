<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Games extends CI_Controller {
    function __construct()
	{
		parent::__construct();
        $this->data['menu']             = $this->menu_model->get_menu();
        $this->data['popular_articles'] =$this->articles_model->get_popular();
        $this->data['latest_articles']  =$this->articles_model->get_latest();
        $this->data['all_category']     = $this->category_model->get_all();
        $this->data['logged_in']        = $this->session->userdata('logged_in');
        $this->data['name']             = $this->session->userdata('name');
	}
    
    function index()
    {
        $this->display_lib->user_page($this->data,'games/index');
    }
}


?>