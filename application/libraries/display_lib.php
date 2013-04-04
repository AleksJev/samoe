<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display_lib
{
    private $ci;
	public function __construct()
	{
		$this -> ci =& get_instance();//functija kotoraja vozvrashaet object glavnogo controllera, 4tobi bili dostupni drugie objekti CI ih metodi ... v nashem primere eto view
	}    
    // data - массив с данными
    public function user_page($data,$name)
    {
        $CI =& get_instance(); // 
        $CI->load->view('header_view',$data);
        $CI->load->view('nav_view',$data);
        $CI->load->view('main_up_view',$data);
        $CI->load->view($name.'_view',$data);
        $CI->load->view('rg_nav_view',$data);
        $CI->load->view('main_down_view',$data);
        $CI->load->view('footer_view',$data);
    }
    
    public function user_page_test($name,$data,$output)
    {
        $CI =& get_instance(); // 
        $CI->load->view('header_view',$data);
        $CI->load->view('nav_view',$data);
        $CI->load->view('main_up_view',$data);
        $CI->load->view($name.'_view',$output);
        //$CI->load->view('rg_nav_view',$data);
        $CI->load->view('main_down_view',$data);
        $CI->load->view('footer_view',$data);
    }
    
    public function user_page_edit($data,$name,$output)
    {
        $CI =& get_instance(); // 
        $CI->load->view('header_view',$data);
        $CI->load->view('nav_view',$data);
        $CI->load->view('main_up_view',$data);
        $CI->load->view($name.'_view',$output);
        //$CI->load->view('rg_nav_view',$data);
        $CI->load->view('main_down_view',$data);
        $CI->load->view('footer_view',$data);
    }
    
    public function admin_page($data,$name,$output)
    {
        $CI =& get_instance(); // 
        $CI->load->view('header_view',$data);
        $CI->load->view('nav_view',$data);
        $CI->load->view('main_up_view',$data);
        $CI->load->view($name.'_view',$output);
        //$CI->load->view('rg_nav_view',$data);
        $CI->load->view('main_down_view',$data);
        $CI->load->view('footer_view',$data);
    }
      
}?>