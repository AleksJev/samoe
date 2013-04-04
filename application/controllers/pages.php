<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller
{
    function __construct()
	{
		parent :: __construct();
        $this->data['popular_articles' ] = $this->articles_model->get_popular();
        $this->data['latest_articles']   = $this->articles_model->get_latest();
        $this->data['all']               = $this->articles_model->get_article_index_page();
        $this->data['user_articles']               = $this->articles_model->get_user_article_index_page();
        $this->data['menu']              = $this -> menu_model -> get_menu();
        $this->data['all_category']      = $this->category_model->get_all();
        $this->data['name']      = $this->session->userdata('name');
		$this->data['logged_in'] = $this->session->userdata('logged_in');
        if(!empty($_SESSION['logged_in'])&& ( $_SESSION['logged_in'] == 'logged'))
        {
            $this->data['in_login'] = $_SESSION['logged_in'];
            $this->data['name']  = $_SESSION['user']['name'];
            $this->data['sname'] = $_SESSION['user']['sname'];
            $this->data['login'] = $this->config->item('login');
        }
	}
    public function index()
    {
        redirect(base_url());
    }
    public function show($page_id = '0')
    {
        $this->data['main_info'] = $this->pages_model->get($page_id);
        $this->users_model->get_user();
        $data = array();
        switch($page_id)
        {
            case '404':
                $this->display_lib->user_page($this->data,'404');
                break;
            case 'index':
                $this->display_lib->user_page($this->data,'pages/main_content');
                break;
            case 'site_info':
                $this->display_lib->user_page($this->data,'pages/site_info');
                break;
            case 'category':
                $this->display_lib->user_page($this->data,'pages/category');
                break;
            case 'contact':
         // Не нажата кнопка "Отправить"    
        if ( ! isset($_POST['send_message']))
        {    
            //Получаем код картинки
            $this->data['imgcode'] = $this->captcha_lib->captcha_actions(); 
            $this->data['info'] = ''; //Информационное сообщение                           
            $this->display_lib->user_page($this->data,'pages/contact');
        }
        else// Нажата кнопка "Отправить"
        {  //Установка правил валидации
            $this->form_validation->set_rules($this->pages_model->contact_rules);		
        	$val_res = $this->form_validation->run();
            //Если валидация пройдена
            if ($val_res == TRUE)
            {//Получаем значение поля капча
        	     $entered_captcha = $this->input->post('captcha');
        		 if ($entered_captcha == $this->session->userdata('rnd_captcha'))
                 {
                     $this->load->library('typography');
                     //Имя отправителя
                     $name = $this->input->post('name');
                     //Указанный отправителем email 
                     $email = $this->input->post('email'); 
                     //Тема сообщения, указанная отправителем
                     $topic = $this->input->post('topic'); 
                     //Текст сообщения
                     $text = $this->input->post('message');
                     //Переносы после 70 знаков (ограничение mail в PHP)  
                     $text = wordwrap($text,70); 
                     // TRUE - более двух переводов строк все равно 
                     //      считаются за два перевода строки
                     $text = $this->typography->auto_typography($text,TRUE);
                     // Удаляем html-тэги для удобства чтения
                     $text = strip_tags($text);
                     //Куда отправляется письмо
                     $address = "aleksejs.jevsejevs@gmail.com"; 
                     //Тема письма как ее видит получатель
                     $subject = "Вопрос из формы обратной связи";          
                     $message = "Написал(а):$name\nТема: $topic\nСообщение:\n$text\nE-mail отправителя: $email"; 
                     //Отправляем письмо
        	         if ((mail ($address,$subject,$message,"Content-type:text/plain;charset = UTF-8\r\n")) ===true)
                     {
                        $this->data['info'] = 'Ваше сообщение отправлено. Если оно
                        требует ответа, я свяжусь с вами в кратчайшие сроки.';
                     }
                     else
                     {
                        $this->data['info'] = 'error';
                     }
                     $this->display_lib->user_page($this->data,'info');
        	     }   
                 // Если капча не совпадает
                 else 
                 {
                     //Получаем код картинки;
                     $this->data['imgcode'] = $this->captcha_lib->captcha_actions();
                     $this->data['info'] = 'Неверно введены цифры с картинки';                                   
                     $this->display_lib->user_page($this->data,'pages/contact');
                 }            						
            }
            //Если валидация не пройдена
            else
            {   
                //Получаем код картинки;
                $this->data['imgcode'] = $this->captcha_lib->captcha_actions(); 
                $this->data['info'] = ''; //Информационное сообщение                               
                $this->display_lib->user_page($this->data,'pages/contact');
            }
        }
        break;
         ///////////////////////////////////     DEFAULT   CASE 
        default:
            if(empty($this->data['main_info']))
            {
                $this->data['info'] = '<div>Нет такой страницы<br />Обратитесь в навигацию по сайту</div>';
                $this->data['main_info'] = array('title'=>'no_page');
                $this->display_lib->user_page($this->data,'info');
            }
            else
            {
                $this->display_lib->user_page($this->data,'pages/page');
            }
            break;
        }
    }
    
    //  метод вход . чтоб пользователь мог авторизоватся
    public function enter()
    {
        $enter = $this->input->post('enter'); // нажата ли кнопка Вход
        if(isset($enter) && $enter)
        {
            $this->form_validation->set_rules($this->users_model->enter_validation);
            if ($this->form_validation->run() == FALSE)
            {
                redirect(base_url().'?false');
            }
            else
            {
                 $user = $this->input->post('user');
                $p = $this->input->post('password');
                $this->data['pass'] = $pass = md5($p);
                $this->data['data'] = $this->users_model->enter($user,$pass);
                redirect(base_url().'?enter');
            }
       }
    }
}
?>