<?php
class Articles extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->data['logged_in'] = $this->session->userdata('logged_in');
        $this->data['name'] = $this->session->userdata('name');
        $this->data['user_id'] = $this->session->userdata('user_id');
        $this->data['level'] = $this->session->userdata('level');
        $this->data['latest_articles']=$this->articles_model->get_latest();
        $this->data['popular_articles']=$this->articles_model->get_popular();
        $this->data['menu'] = $this -> menu_model -> get_menu();
        $this->data['all_category'] = $this->category_model->get_all();
        
        
    }
    function index()
    {
        redirect(base_url());
    }
    
    function show($art_id)
    {
        $this->load->model('comments_model');
		$this->data['article'] = $this -> articles_model -> get($art_id);
        $this->data['limit'] = $limit = $this->config->item('comm_per_page_article');
        $this->data['total']= $total = $this->comments_model->count_by($art_id);
        $this->data['comments_list'] = $this->comments_model->get_by_art($art_id,$limit);
        $this->data['art_id']=$art_id;
        $this->data['imgcode'] = $this->captcha_lib->captcha_actions();
		//$this->data['users'] = $this->help_lib->get_user_info($user_id);
		
        if(empty($this->data['article']))
        {
            $this->data['info']='Нет такой статьи';
            $name='info';
            $this->display_lib->user_page($this->data,$name);
            
        }
        else
        {
            
            $counter_data = array('count_views' => $this->data['article']['count_views']+1);
            $this->articles_model->update_counter($art_id,$counter_data);
            
            
            $this->display_lib->user_page($this->data,'articles/content');  
        }
        
    }
    
    function search(){
        if(isset($_POST['search'])){
            $this->data['search'] =$search= $this->input->post('search');
            $this->load->library('form_validation');
            //Установка правил валидации при поиске
            $this->form_validation->set_rules('search','search','trim|required|xss_clean');
            
            if($this->form_validation->run() == TRUE){
                $this->data['articles_serch_result'] = $this->articles_model->search($search);
                /*
                if(empty($this->data['articles_search_result'])){
                    $this->data['articles_serch_result'] = array('art_id'=>'Нет результатов по вашему поиску');
                }*/
                $name = 'articles/search';
                $this->display_lib->user_page($this->data,$name);
            }
            else
            {
                redirect(base_url());
            }
            
        }
        else
        {
            redirect(base_url());
        }
        
    }
	
	
	function votes($art_id,$upd)
	{
		
		$a = get_cookie('votes_'.$art_id);
		if ($a == $art_id)
		{redirect(base_url());}
		$cookie = array(
                   'name'   => "votes_$art_id",
                   'value'  => "$art_id",
                   'expire' => '86500',
                   
               );
		set_cookie($cookie);
		
		switch ($upd){
			case 'plus':
				$value = '1';
			break;
			case 'minus':
				$value = '-1';
			break;
			default:
				redirect(base_url().'articles/'.$art_id);
			break;

		}
		if ($value != '0')
		{
			$this->articles_model->votes_update($art_id,$value);
		}
		redirect(base_url().'articles/'.$art_id.'/#new_comment');
	}
    
    function art_votes($art_id,$upd)
    {
        $a = get_cookie('votes_'.$art_id);
		if ($a == $art_id)
		{redirect(base_url().'articles/'.$art_id);}
		$cookie = array(
                   'name'   => "votes_$art_id",
                   'value'  => "$art_id",
                   'expire' => '86500',
                   
               );
		set_cookie($cookie);
        	switch ($upd){
			case 'up':
				$value = 'up';
			break;
			case 'down':
				$value = 'down';
			break;
			default:
				redirect(base_url().'articles/'.$art_id);
			break;

		}
        
        if ($value != '0')
        {
            $this->articles_model->votes_upd($art_id,$value);
        }
        redirect(base_url().'articles/'.$art_id.'/#new_comment');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	
}


?>