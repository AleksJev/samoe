<?php
class Comments extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('comments_model');
         $this->data['popular_articles']=$this->articles_model->get_popular();
        $this->data['latest_articles']=$this->articles_model->get_latest();
        $this->data['all_category'] = $this->category_model->get_all();
        $this->data['menu'] = $this -> menu_model -> get_menu();
        $this->data['logged_in'] = $this->session->userdata('logged_in');
        $this->data['name']      = $this->session->userdata('name');
    }
    
    public function index()
    {
        redirect(base_url());
    }
    
    public function show($art_id,$start_from = 0)
    {
        $this->load->library('pagination');
        $this->load->library('pagination_lib');
        $this->data['article'] = $this -> articles_model -> get($art_id);
        $this->data['art_id'] = $art_id;
        $total = $this->data['count']=$this->comments_model->count_by($art_id);
        $limit = $this->config->item('comm_per_page');
         $this->data['imgcode'] = $this->captcha_lib->captcha_actions();
        $settings = $this->pagination_lib->get_settings('comments',$art_id,$total,$limit);
        // применяем настройки
        $this->pagination->initialize($settings);
		//$this->data['article'] = $this -> articles_model -> get($art_id);
        $this->data['comments_list'] = $this->comments_model->comm_get_by($art_id,$limit,$start_from);
        $this->data['page_nav'] = $this->pagination->create_links();
        $this->display_lib->user_page($this->data,'comments/comments');
    }
    
    public function add($art_id = '',$limit = 0)
    {
        $this->load->library('captcha_lib');
        $this->load->library('typography');
        
        $data = array();
        $data['main_info'] = $this->articles_model->get($art_id);
        $data['menu'] = $this->menu_model->get_menu();
        $data['comments_list'] = $this->comments_model->get_by($art_id);
            
            
        if(!isset($_POST['add_comment']))
        {
            $data['info'] = 'Вы не нажали кнопку Комментировать';
            $data['main_info'] = array('title'=>'no_page');
            $name = 'info';
            $this->display_lib->user_page($data,$name);
        }
        else  // нажата кнопка добавить коммент
        {
            $this->load->library('form_validation');
            //Установка правил валидации
            $this->form_validation->set_rules($this->comments_model->add_rules);
            	  
            $val_res = $this->form_validation->run();
                  
            // Если валидация пройдена
            if ($val_res === TRUE)
            {
                 //Получаем значение поля капча
                 $entered_captcha = $this->input->post('captcha');
            		   //Если оно совпадает со значением в сессии (значение там уже есть - сессия с цифрами капчи создается при просмотре материала, а комментирование идет только со страницы материала)	
                 if ($entered_captcha === $this->session->userdata('rnd_captcha'))
                 {
                     // Массив для вставки данных по комментарию
                      $comment_data = array(); 
                      $comment_text = $this->input->post('comm_text');                       
                      // TRUE - более двух переводов строки все равно                           считаются за два перевода           
                      $comment_text = $this->typography->auto_typography($comment_text,TRUE);
                      
                      //$comment_text = parse_smileys($comment_text,base_url().'img/smileys/');           
                    
                    
                      
                      
                      //Уже передан как параметр функции add 
                      $user_id = $this->input->post('user_id');
                      if(!empty($user_id)){
                          $comment_data['user_id']=$user_id;
                      }
                      else
                      {
                          $comment_data['user_id']='0'; 
                      }
                      
                                     
                      $comment_data['art_id'] = $art_id;       
                      $comment_data['author'] = $this->input->post('author');
                      $comment_data['comm_text'] = $comment_text; 
                      $comment_data['date'] = date('Y-m-d H:i:s');//date('Y-m-d H:i:s')
                      
                      //Вставляем комментарий в базу
                      $this->comments_model->add_new($comment_data);                   
                                      
                        //Готовим данные для отправки письма-оповещения администратору
                      //Имя отправителя
                      $author = $this->input->post('author'); 
                      
                         // Переносы после 70 знаков (ограничение функции mail в PHP)
                      $comment_text = wordwrap($comment_text,70); 
                      
                      // Удаляем html-тэги для удобства чтения      
                      $comment_text = strip_tags($comment_text);
                      
                      //Куда отправляется письмо
                      $address = "aleksejs.jevsejevs@gmail.com"; 
                      
                      // Тема письма
                      $subject = "Комментарий к материалу: ".$data['main_info']['art_title']; 
                      // Сообщение
                      $message = "Написал(а):$author\nТекст комментария:\n$comment_text\nСсылка: http://samoe.phptest.webskola.lv/articles/$art_id#new_comment";                
                      
                      // Оправляем письмо-оповощение   
            	      mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-UTF-8\r\n");                   
                      $data['fail_captcha'] = '';
                      $data['success_comment']  = 'Ваш комментарий успешно добавлен<br><a href="#new_comment">Просмотреть комментарий</a>';          
                      //получаем код капчи
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                     //Получаем список комментариев к материалу заново (так                    как только что был добавлен новый комментарий)
                      $data['comments_list'] = $this->comments_model->get_by($art_id);  
                      $data['art_id'] = $art_id;                                 
                      $name = 'articles/content'; 
                      $this->display_lib->user_page($data,$name);                    
                 }   
                 else   // Если капча не совпадает
                 {                                    
                      $data['fail_captcha'] = 'Неверно введены цифры с картинки<br><a href="#captcha">Ввести еще раз!<a>';
                      
                      //получаем код капчи
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                      
                      $data['success_comment']  = '';                        
                                          
                      $name = 'articles/content';                   
                      $this->display_lib->user_page($data,$name);                 
                 }                  
            }
                
            //Если валидация не пройдена
            else
            {               
                $data['fail_captcha'] = 'Неверно  цифры с картинки<br />
                                        <a href="#captcha">Ввести ещё раз !</a>';
                $data['imgcode']  = $this->captcha_lib->captcha_actions(); //получаем код капчи
                $data['success_comment']  = '';            
                                      
                $this->display_lib->user_page($data,'articles/content');          
            } 
        }
    }
    
    
}


?>