<?php
class Pagination_lib 
{
    
    // id для чего навигация ,name - имя длля подстановки к bast_url (только для категории),всего,ограничение)
    public function get_settings($id,$name,$total,$limit)
    {
        $config = array();
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['first_link'] = '&laquo; Первая';
        $config['last_link'] = 'Последняя &raquo;';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        
        
        ///////////////////////////
        $config['full_tag_open'] = '<ul id="pagination">';		 // открывющий тэг перед навигацией
        $config['full_tag_close'] = '</ul>';   					 // закрывающий тэг после навигации 
        $config['first_tag_open'] = '<li>';  					 // первая страница открывающий тэг 
        $config['first_tag_close'] = '</li>'; 					 // первая страница закрывающий тэг 
        $config['last_tag_open'] = '<li>';  					 // последняя страница открывающий тэг 
        $config['last_tag_close'] = '</li>';  					 // последняя страница закрывающий тэг
        $config['prev_tag_open'] = '<li>';						 // предыдущая страница открывающий тэг
        $config['prev_tag_close'] = '</li>'; 					 // предыдущая страница закрывающий тэг 
        $config['cur_tag_open'] = '<li class = "active">';   	 // текущая страница открывающий тэг
        $config['cur_tag_close'] = '</li>';  					 // текущая страница закрывающий тэг
        $config['num_tag_open'] = '<li>'; 						 // цифровая ссылка открывающий тэг
        $config['num_tag_close'] = '</li>';						 // цифровая ссылка закрывающий тэг
        $config['next_tag_open'] = '<li>'; 						 // следующая страница открывающий тэг
        $config['next_tag_close'] = '</li>'; 					 // следующая страница закрывающий тэг
        
        
        //////////////////////////
        
        
        switch($id)// для чего навигация
        {
            // если навигация для категорий
            case 'category':
            
                $config['base_url'] = base_url().'category/show/'.$name;
                $config['uri_segment'] = 4;
                // количество цифровых сссылок по блокам от текущей
                $config['num_links'] =2;
                
                return  $config;
                break;
           case 'comments':
            
                $config['base_url'] = base_url().'comments/show/'.$name;
                $config['uri_segment'] = 4;
                // количество цифровых сссылок по блокам от текущей
                $config['num_links'] =2;
                
                return  $config;
                break;
           
            
            
            
        }
        
        
        
    }
    
    
    
    
}




?>