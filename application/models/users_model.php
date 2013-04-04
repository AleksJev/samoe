<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model
{
    
    public function __construct()
    {
        parent:: __construct();
       
    }
    
    function register_user($user,$password,$name,$sname,$bday,$email,$ip,$activation_code)
    {
        $this->load->helper('security');
        //$md5_password = do_hash($password, 'md5');
        $md5_password = md5($password);
        $query = "INSERT INTO `users` SET `user`     = '$user',
                                          `password` = '$password',
                                          `name`     = '$name',
                                          `sname`    = '$sname',
                                          `bday`     = '$bday',
                                          `email`    = '$email',
                                          `ip`       = '$ip',
                                          `activation_code` = '$activation_code'";
        $this->db->query($query,array($user,$md5_password,$name,$sname,$bday,$email,$ip,$activation_code));
    }
    
    
    // проверяем не занят ли логин
    function check_exist_username($user)
    {
        //$this->db->where('user',$user);
        //$result = $this->db->select('users');
        $sql="SELECT `user` FROM `users` WHERE user='$user'";
        $result=$this->db->query($sql,$user);
        
        if($result->num_rows() > 0)
        {
            // username exist
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function check_exist_email($email)
    {
        //$this->db->where('email',$email);
        //$result = $this->db->select('email');
        $sql="SELECT `email` FROM `users` WHERE `email`='$email'";
        $result=$this->db->query($sql,$email);
        
        if($result->num_rows() > 0)
        {
            // username exist
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    public function get_user_name($user_id = '0')
    {
        $this->db->where('id',$user_id);
        $this->db->select('user');
        $result = $this->db->get('users');
        return $result->row_array();
        
    }
    // подтверждение регистрации активационным кодом
    function confirm_registration($registration_code,$user)
    {
        $query = "SELECT user_id FROM users WHERE `activation_code` = '$registration_code' AND `user` = '$user'";
        $result = $this->db->query($query);
        if($result->num_rows() == 1)
        {
            $query = "UPDATE users SET `activated` = '1',`activation_code`='' WHERE activation_code = '$registration_code' AND `user` = '$user'";
            $this->db->query($query);
            
            //return true;
            $this->db->select('email');
            $this->db->where('user',$user);
            $result = $this->db->get('users');
            return $result->row_array();
        }
        else
        {
            return false;
        }
    }
    //   вход под своим логином и паролем
    public function enter($user,$pass)
    {
	
        $q = "SELECT user_id,user,name,sname,activated,level FROM users WHERE user='$user' AND password='$pass'";
            $query = $this->db->query($q);
            if($query->num_rows()>0){
                
                foreach($query->row() as $key){
                    $data_ses[]=$key;
                    //$this->session->set_userdata($key,$value);
                }
                //$_SESSION['login'] = $user;
                $session_data = array('logged_in'    => 'logged',
                                      'user_id'  =>$data_ses['0'],
                                      'user'     =>$data_ses['1'],
                                      'name'     =>$data_ses['2'],
                                      'sname'    =>$data_ses['3'], // записываем в сессию признак логона
                                      'activated'=>$data_ses['4'],
                                      'level'    =>$data_ses['5']); // записываем в сессию признак логона
                $this->session->set_userdata($session_data);
				//$this->config->set_item('login', 'yes');
				$_SESSION['logged_in'] = 'logged';
                $_SESSION['user'] = $session_data;
                //$config['logon']= 'yes';
                $this->session->set_userdata('log_on', 'on');
                //$user_id = $this->session->set_userdata('user_id',$data_ses['0']);
                //$this->config->set_item('user_id',$data_ses['0']);
                //$this->session->set_userdata('user',$data_ses['1']);
                //$this->session->set_userdata('name',$data_ses['2']);
                //$this->session->set_userdata('sname',$data_ses['3']);
                //   пример того что в сессию идет при авторизации
                //Array
                //(
                //    [0] => 25
                //    [1] => admin2
                //    [2] => Aleksejs
                //    [3] => Jevsejevs
                //)
                                
                return true;
                //return true;
            }
            else
            {
                return false;
            }
            //$data_ses = 'querty';
            
    }
    //   получить все данные о всех пользователях
    public function get_all_users()
    {
        $sql = "SELECT * FROM `users`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    //  добавление понравившейся статьи себе в кабинет как избранное
    function favorite_art($user_id,$art_id)
    {
        //$q = "SELECT * FROM `like_art`";
        $this->db->where('user_id',$user_id);
        $this->db->where('art_id',$art_id);
        $result = $this->db->get('like_art');
        //$result = $this->db->query($q);
        if($result->num_rows()>0)
        {
            return false;
        }
        else
        {
            $sql = "INSERT INTO `like_art` SET `user_id` = '$user_id' , `art_id` = '$art_id'";
            $this->db->query($sql);
            return true;
        }
    }
    
    
    function like_art($user_id)
    {
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('like_art');
        if ($result->num_rows()<1)
        {
            return false;
        }
        
        foreach($result->result_array() as $key)
        {
            $this->db->or_where('art_id',$key['art_id']);
        }
        
        $res = $this->db->get('articles');
        //$query = $this->db->get_where('articles', array('art_id' => '9','art_id'=> '4'));
        return $res->result_array();
    }
    
    // получение эмайла пользователя
    function get_email($user_id)
    {
        $this->db->select('email');
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('users');
        $res = $result->row_array();
        return $res['email'];
    }
    function get_email_by_user($user)
    {
        $this->db->select('email');
        $this->db->where('user',$user);
        $result = $this->db->get('users');
        $res = $result->row_array();
        return $res['email'];
    }
    
    function get_user($user_id =1)
    {
        $this->db->select('user');
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('users');
        $res = $result->row_array();
        return $res['user'];
    }
    
    // обновление активационного кода в базе 
    function activation_code_update($user_id,$data)
    {
        //$this->db->where('user_id',$user_id);
        $result = $this->db->update('users', $data, "user_id = $user_id");
       /* if ($result->num_rows() == '1')
        {
            return true;
        }
        else
        {
            return false;
        }*/
        return true;
    }
    
    function pass_reset($user,$pass_code)
    {
        $this->db->where('user',$user);
        $this->db->update('users', $pass_code);
        return true;
    }
    
    function reset($user,$code,$new_pass)
    {
        $this->db->where('activation_code',$code);
        $this->db->where('user',$user);
        $result = $this->db->get('users');
        if ($result->num_rows() > 0)
        {
            $sql = "UPDATE `users` SET `password` = '$new_pass',`activation_code` = '' WHERE `user` = '$user' AND `activation_code` = '$code'";
            $res = $this->db->query($sql);
            return true;
        }
        else
        {
            return false;
        }
        
        
    }
    /*
    $this->form_validation->set_rules('user','User','trim|required|min_length[4]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|required|matches[passconf]|md5|xss_clean');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
        $this->form_validation->set_rules('name','Name','trim|required|min_length[4]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('sname','SurName','trim|required|min_length[4]|max_length[20]|xss_clean');
        $this->form_validation->set_rules('bday','birthday','trim|numeric|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    */
    
    // метод подписка. получаем все ид пользователей на которые подписан автор
    function subscription($user_id)
    {
        $this->db->select('art_user_id');
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('subscription');
        if ($result->num_rows()<1)
        {
            return false;
        }
        foreach($result->result_array() as $item)
        {
            $this->db->select('user_id,user');
            $this->db->or_where('user_id',$item['art_user_id']);
            
        }
        $res = $this->db->get('users');
        return $res->result_array();
        
    }
    
    //  получаем ВСЕ статьи пользователь с ид 
    function subscription_art($user_id)
    {
        $this->db->select('art_id');
        $this->db->select('art_title');
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('articles');
        return $result->result_array();
        
    }
    
    //  подписка на какого либо автора
    function subscribe_add($art_user_id)
    {
        $user_id = $_SESSION['user']['user_id'];
        $this->db->where('art_user_id',$art_user_id);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('subscription');
        //$result = $this->db->query($q);
        if($result->num_rows()>0)
        {
            return false;
        }
        else
        {
            $sql = "INSERT INTO `subscription` SET `user_id` = '$user_id' , `art_user_id` = '$art_user_id'";
            $this->db->query($sql);
            return true;
        }
    }
    
    // получение файлов пользователя
    function get_files($user_id)
    {
        $sql = "SELECT * FROM `files` WHERE `user_id` = '$user_id' ORDER BY `file_id` DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    // правила при регистрации
    public $reg_validation = array(
    array
    (
        'field' => 'user',
        'label' => 'User',
        'rules' => 'trim|required|min_length[4]|max_length[20]|xss_clean|callback_username_not_exists'
    ),
    array
    (
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'trim|required|matches[passconf]|md5|xss_clean'
    ),
    array
    (
        'field' => 'passconf',
        'label' => 'Password Confirmation',
        'rules' => 'trim|required'
    ),
    array
    (
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'trim|required|min_length[4]|max_length[20]|xss_clean'
    ),
    array
    (
        'field' => 'sname',
        'label' => 'SurName',
        'rules' => 'trim|required|min_length[4]|max_length[20]|xss_clean'
    ),
    array
    (
        'field' => 'bday',
        'label' => 'Birthday',
        'rules' => 'trim|xss_clean'
    ),
    array
    (
        'field' => 'email',
        'label' => 'E-mail',
        'rules' => 'trim|required|valid_email|callback_email_not_exists'
    )
    );
    
    // правила при авторизации
    public $enter_validation = array(
    array
    (
        'field' => 'user',
        'label' => 'User',
        'rules' => 'trim|required|min_length[4]|max_length[20]|xss_clean'
    ),
    array
    (
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'trim|required|xss_clean'
    )
    );
}


?>