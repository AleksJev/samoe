<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages_model extends Crud
{
    public $table ='pages'; //имя таблицы
    public $idkey ='page_id'; // имя индексного поля ID
    
    public $contact_rules = array
    (
        array
        (
            'field' => 'name',
            'label' => 'Имя',
            'rules' => 'trim|strtolower|ucfirst|required|xss_clean|max_length[70]'
        ),
        array
        (
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'trim|required|valid_email|xss_clean|max_length[70]'
        
        ),
        array
        (
            'field' => 'topic',
            'label' => 'Тема сообщения',
            'rules' => 'required|xss_clean|max_length[70]'
        ),
        array
        (
            'field' => 'message',
            'label' => 'Текст сообщения',
            'rules' => 'required|xss_clean|max_length[5000]'
        ),
        array
        (
            'field' => 'captcha',
            'label' => 'Цифры с картинки',
            'rules' => 'required|numeric|exact_length[5]'
        )
    
    
    );
    
 
}

?>