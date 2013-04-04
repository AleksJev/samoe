<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends CI_Model
{
    public $table = ''; // название таблицы
    public $idkey = ''; // PK
    
    public function __construct()
    {
        parent :: __construct();
    }
    
    // Получение данных об одной записи
    public function get($obj_id) //идентификатор объекта
    {
        $this->db->where($this->idkey,$obj_id); // page_id , obj_id(индекс)
        $query = $this->db->get($this->table); // заносим результат
        return $query->row_array(); // одномерный массив возвращает
    }
}
?>