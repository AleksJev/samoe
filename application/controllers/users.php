<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model ('menu_model');
		//$this->load->helper ('menu_helper');
        //$this->load->library('javascript');
        $this->data['menu'] = $this->menu_model->get_menu();
        $this->data['popular_articles']=$this->articles_model->get_popular();
        $this->data['latest_articles']=$this->articles_model->get_latest();		
		$this->data['all_category'] = $this->category_model->get_all();
        $this->data['logged_in'] = $this->session->userdata('logged_in');
        $this->data['name']      = $this->session->userdata('name');
        $this->data['user_id']      = $this->session->userdata('user_id');
        $this->data['activated']      = $this->session->userdata('activated');
        // если он вошел под своим ником то записываем в объект data его имя фамилия чтоб потом в виде легче к нему обращаться и понитней было бы например дизайнерам ...
       if(!empty($this->data['logged_in'])&& ($this->data['logged_in'] == 'logged'))
       {
            $this->data['name']    = $_SESSION['user']['name'];
            $this->data['sname']   = $_SESSION['user']['sname'];
            $this->data['user_id'] = $_SESSION['user']['user_id'];
            $this->data['user']    = $_SESSION['user']['user'];
       }

       
      
        
    }
	
    public function index()
    {
        $this->data['all_users'] = $this->users_model->get_all_users();
        $this->display_lib->user_page($this->data,'users/content');
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
    
    // при нажатии кнопки выход уничтожается все данные сесии и пользователь считается вышел из своего аккаунта
    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
		session_destroy();
        $this->config->set_item('login', 'off');
        redirect(base_url());
        //session_destroy();
        //$_SESSION = array();
    //unset($_COOKIE[session_name()]);

    //header("location: /");
    }
    // метод регистрация что тут еще сказать
    public function register()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->users_model->reg_validation);
		$registerPOST = $this->input->post('register');
        
        if (isset($registerPOST) && $registerPOST)
        {
            if ($this->form_validation->run() == FALSE)
            {                
                $this->display_lib->user_page($this->data,'users/reg');
            }
            else
            {
                $user     = $this->input->post('user');
                $password = $this->input->post('password');
                $name     = $this->input->post('name');
                $sname    = $this->input->post('sname');
                $bday     = $this->input->post('bday');
                $email    = $this->input->post('email');
                $ip       = $this->input->post('ip');
                
                $activation_code = $this->_random_string(10);
                $this->users_model->register_user($user,$password,$name,$sname,$bday,$email,$ip,$activation_code);
                
				//email confirmation посылаем письмо с просьбой подтверждения регистрации
                $this->load->library('email');
                $this->email->from('a.j@gmail.com','Администрация портала samoe.phptest.webskola.lv');
                $this->email->to($email);
                $this->email->subject('Подтверждение регистрации');
                $this->email->message('Была произведена регистрация на портале samoe.phptest.webskola.lv. Для подтверждения регистрации перейдите пожалуйста по данной ссылке '.anchor('http://samoe.phptest.webskola.lv/users/register_confirm/'.$user.'/'.$activation_code,'Подтверждение регистрации'));
                $this->email->send();
                $this->data['print_debugger'] = $this->email->print_debugger();
                $this->data['info'] = "Регистрация успешна, user: $user ,password:$password";
                $this->display_lib->user_page($this->data,'users/reg_ok');
            }
        }
        else
        {            
            $this->display_lib->user_page($this->data,'users/reg');
        }
        //$data['latest_articles']=$this->articles_model->get_latest();
        //$this->display_lib->user_page($data,$name);
    }
    
    // подтверждение регистрации
    function register_confirm()
    {
        $user = $this->uri->segment(3);
        $registration_code = $this->uri->segment(4); // получаем код активации аккаунта который будет в адресе сразу за слешем метода  http:// samoe....../register_confirm/  К О Д
        $this->load->library('form_validation');
        //$this->form_validation->set_rules($registration_code,'alpha_numeric');
        //$this->form_validation->set_rules($user,'alpha_numeric');
        
        if( !$this->form_validation->validate($this->uri->segment(4), 'alpha_numeric') )
        {
            echo '4';
        }
        else if( !$this->form_validation->validate($this->uri->segment(3), 'alpha_numeric') )
        {
            echo '3';
        }
        else
        {
            if('' == $registration_code)
            {
                echo 'Error... No registrarion code in URL';
                exit();
            }
            $registration_confirmed = $this->users_model->confirm_registration($registration_code,$user);
            if (!empty($registration_confirmed))
            {
                //echo 'удачная регистрация';
                $this->load->library('email');
                $this->email->from('aleksejs.jevsejevs@gmail.com','samoe.phptest.webskola.lv');
                $this->email->to($registration_confirmed['email']);
                $this->email->subject('Учетная запись активированна');
                $this->email->message(' ОК ');
                $this->email->send();
                $this->data['info'] = "Ваша учетная запись активированна .<br />Теперь у вас есть возможность воспользоватся всем спектром услуг.";
                $this->display_lib->user_page($this->data,'info');    
                
            }
            else
            {
                $this->data['info'] = "Неудачная активация.<br />Попробуйте все же еще раз запросить активационное письмо через свой кабинет.";
                $this->display_lib->user_page($this->data,'info');
            }
        }
        
    }
    
    // запрос активации аккаунта повторный 
    function activation($user_id)
    {
        if ($user_id != $this->data['user_id'])redirect(base_url());
        $email = $this->users_model->get_email($user_id); 
        $user = $this->users_model->get_user($user_id);
        $activation_code = $this->_random_string(10);
        $data = array('activation_code'=>$activation_code);
        $this->users_model->activation_code_update($user_id,$data); 
        
        $this->session->set_userdata('activated','1');
        $this->load->library('email');
        $this->email->from('aleksejs.jevsejevs@gmail.com','Администрация портала samoe.phptest.webskola.lv');
        $this->email->to($email);
        $this->email->subject('Активация аккаунта');
        $this->email->message('Для активации аккаунта перейдите пожалуйста по данной ссылке '.anchor('http://samoe.phptest.webskola.lv/users/register_confirm/'.$user.'/'.$activation_code,'Подтверждение регистрации'));
        $this->email->send();
        $this->data['info'] = "Проверьте вашу почту и перейдите по ссылке для завершения активации";
        $this->display_lib->user_page($this->data,'info');
    }
    
    //  если забыл пароль
    function forgot_password()
    {
        $this->display_lib->user_page($this->data,'users/forgot_password');
    } 
    function password_reset()
    {
        $this->load->library('form_validation');
        $user = $this->input->post('user');
        $email = $this->input->post('email');
        $change = $this->input->post('change');
        if (isset($change) && $change)
        {
            if (!empty($email) || !empty($user))
            {
                $pass_code = array('activation_code'=>$this->_random_string(10));
                $this->users_model->pass_reset($user,$pass_code);
                $email = $this->users_model->get_email_by_user($user);
                $this->load->library('email');
                $this->email->from('aleksejs.jevsejevs@gmail.com','Администрация портала samoe.phptest.webskola.lv');
                $this->email->to($email);
                $this->email->subject('Сброс пароля');
                $this->email->message('Для сброса пароля перейдите пожалуйста по данной ссылке '.anchor('http://samoe.phptest.webskola.lv/users/reset/'.$user.'/'.$pass_code['activation_code'],'Сброс пароля'));
                $this->email->send();
                $this->data['info'] = "Проверьте вашу почту и перейдите по ссылке для cброса пароля";
                $this->display_lib->user_page($this->data,'info');
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
    // ПРЕДЛАГАЕМ ввести новый пароль
    function reset($user,$code)
    {
        $pass = $this->_random_string(12);
        $new_pass = md5($pass);
        $result = $this->users_model->reset($user,$code,$new_pass);
        if ($result == true)
        {
            $email = $this->users_model->get_email_by_user($user);
            $this->load->library('email');
            $this->email->from('aleksejs.jevsejevs@gmail.com','Администрация портала samoe.phptest.webskola.lv');
            $this->email->to($email);
            $this->email->subject('Новый пароль');
            $this->email->message("Новый пароль $pass");
            $this->email->send();
            $this->data['info'] = 'Проверьте свою почту. там вы найдете новый пароль';
            $this->display_lib->user_page($this->data,'info');
        }
        else
        {
            redirect(base_url());
        }
    }
    
    // проверяем не существует ли уже зарегистрированного с данным ником (user)
    function username_not_exists($user)
    {
        $this->form_validation->set_message('username_not_exists','Данный ник уже занят ,попробуйте выбрать другой');
        if ($this->users_model->check_exist_username($user))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    // проверка не существует ли запись в таблице users с таким то эмайлом
    function email_not_exists($email)
    {
        $this->form_validation->set_message('email_not_exists',"На этот e-mail уже произведена регистарция.\nЕсли это все же ваш эмайл то попробуйте все же восстановить пароль через Забыл пароль");
        if($this->users_model->check_exist_email($email))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    //  случайная строка . формируется для кода который записывается в поле activation code и который в последствии надо ввести автору либо пройим  по ссылке у которой окончание именно такое
    function _random_string($length)
    {
        $len = $length;
        $base = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm123456789';
        $max = strlen($base)-1;
        $activatecode='';
        mt_srand((double)microtime()*1000000);
        while (strlen($activatecode)<$len+1)
            $activatecode.=$base{(mt_rand(0,$max))};
        
        return $activatecode;
    }
    
    
    // вход в кабинет 
    function cabinet()
    {
        if ($_SESSION['logged_in'] != 'logged'){redirect(base_url());}
        
        $this->data['like_art']     = $this->users_model->like_art($this->data['user_id']);
        $this->data['subscription'] = $this->users_model->subscription($this->data['user_id']);
        $this->data['file'] = $this->users_model->get_files($this->data['user_id']);
        $this->data['email']= $this->users_model->get_email($this->data['user_id']);
        $this->display_lib->user_page($this->data,'users/cabinet');
    }
    
    
    // 
    function favorite_art($user_id,$art_id)
    {
        $this->users_model->favorite_art($user_id,$art_id);
        redirect(base_url()."/articles/$art_id");
    }
    
    
    //  подписки. по ид на кого подписан находит все статьи данного автора 
    function subscription_art($user_id)
    {
        $this->data['subscription_art'] = $this->users_model->subscription_art($user_id);
        $this->display_lib->user_page($this->data,'users/subscription');
    }
    
    //  оформление подписки на автора ,поступает автора ид и статьи ид чтоб потом вернутся на страницу
    function subscribe_add($art_user_id,$art_id)
    {
        $this->users_model->subscribe_add($art_user_id);
        redirect(base_url()."/articles/$art_id");
        
    }
    
    
     function articles()
     {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        //$crud->set_theme('flexigrid');
        //$crud->set_theme('datatables');
		$add = $this->uri->segment(3);
        // в переменную сегмент чтоб можно было добавлять статью . иначе имеется конфликт 
        // и условие where user_id он начинает сравнять и по другиим таблицам которые связанны с articles.... 
        if ($add != 'add'){ $this->db->where('user_id',$this->data['user_id']); }
        
        
        
        $crud->set_table('articles');
        $this->grocery_crud->columns('art_title','art_text','count_views');
        //$crud->unset_delete();
        
        $crud->set_relation_n_n('category', 'art_cat', 'category', 'art_id', 'cat_id', 'cat_alias');
        $this->grocery_crud->columns('art_title','art_text','count_views','cat_alias');
        $crud->set_field_upload('file_url','assets/uploads/files');
        $translate = array('art_title'=>'Название статьи','art_text'=>'Текст статьи','count_views'=>'Просмотров','art_votes'=>'Голосов','art_date'=>'Дата добавления','file_url'=>'Адрес картинки');
        $crud->display_as($translate);
        
        $crud->change_field_type('user_id', 'hidden',$this->data['user_id']);
        $crud->change_field_type('count_views', 'hidden', '' );
        $crud->change_field_type('art_votes', 'hidden', '' );
        $crud->change_field_type('art_date', 'hidden', '' );
        $crud->change_field_type('up', 'hidden', '' );
        $crud->change_field_type('down', 'hidden', '' );
        
        //$crud->unset_columns('user_id','art_text','count_views','art_votes');
        //$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');
        
        
        $output = $crud->render();
        $this->display_lib->user_page_edit($this->data,'users/articles_edit',$output);
        
    }
    
    
    
    
    
    
    
    
    
    
    /*
    function articles()
     {
        if ($this->data['logged_in'] != 'logged'){redirect(base_url());}
        
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        //$crud->set_theme('flexigrid');
        $add = $this->uri->segment(3);
        // в переменную сегмент чтоб можно было добавлять статью . иначе имеется конфликт 
        // и условие where user_id он начинает сравнять и по другиим таблицам которые связанны с articles.... 
        if ($add != 'add'){ $this->db->where('user_id',$this->data['user_id']); }
            
        $crud->set_subject('Статью');
        $crud->set_table('articles');
        $this->grocery_crud->columns('art_title','art_text','count_views');
        //$crud->unset_delete();
        $translate = array('art_title'=>'Название статьи','art_text'=>'Текст статьи','count_views'=>'Просмотров','art_votes'=>'Голосов','art_date'=>'Дата добавления','file_url'=>'Адрес картинки');
        $crud->display_as($translate);
        $crud->set_relation_n_n('Раздел', 'art_cat', 'category', 'art_id', 'cat_id', 'cat_alias');
        $crud->change_field_type('user_id', 'hidden',$this->data['user_id']);
        $crud->change_field_type('count_views', 'hidden', '' );
        $crud->change_field_type('art_votes', 'hidden', '' );
        $crud->change_field_type('art_date', 'hidden', '' );
        $crud->change_field_type('up', 'hidden', '' );
        $crud->change_field_type('down', 'hidden', '' );
        $crud->set_field_upload('file_url','assets/uploads/files');
        $output = $crud->render();
        $this->display_lib->user_page_edit($this->data,'users/articles_edit',$output);
        
    }*/
    
    //  редактирование своего профиля
    function useredit()
    {
        $user_id = $this->data['user_id'];
        $id = $this->uri->segment(4);
        $add = $this->uri->segment(3);
        if (isset($id) && $id != $user_id){redirect(base_url());} // защита чтоб не меняли другого пользователя
        if ($add == 'add'){redirect(base_url().'users/useredit');}
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('users')
                ->where('users.user_id',$user_id);
        $this->grocery_crud->columns('user','name','sname','bday','email');
        $crud->change_field_type('password', 'hidden', '' );
        //$crud->change_field_type('password', 'password');
        $crud->change_field_type('user', 'hidden', '' );
        $crud->change_field_type('ip', 'hidden', '' );
        $crud->change_field_type('date_reg', 'hidden', '' );
        $crud->change_field_type('activated', 'hidden', '' );
        $crud->change_field_type('activation_code', 'hidden', '' );
        $crud->change_field_type('level', 'hidden', '' );
        
      
        //$crud->set_theme('flexigrid');
        //$crud->set_theme('datatables');
        //$this->db->where('user_id',$user_id);
        $crud->unset_delete();
        //$crud->unset_insert();
        
        $output = $crud->render();
        $this->display_lib->admin_page($this->data,'users/articles_edit',$output);
    }
    
    
        
    
    
    
    
    
    
    
    
    
    
    
}
?>