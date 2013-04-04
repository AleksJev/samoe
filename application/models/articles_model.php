<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Articles_model extends Crud
{
    public $table = 'articles';
    public $idkey = 'art_id';
    public function get_latest()
    {
        
        $this->db->order_by('art_id','desc');
        $this->db->limit(5);
        $query = $this->db->get('articles'); // информация из базы данных таблицв articles
        return $query->result_array(); // возвращает ассоциативный массив массив с последними материалами
        
        
    }
    
    //  получаем статьи которые больше всего посещались 
    public function get_popular()
    {
        $this->db->order_by('count_views','desc');
        $this->db->limit(10);
        $query = $this->db->get('articles'); 
        return $query->result_array(); // возвращает массив с найболее популярными материалами
        
    }
    
    //  получение адреса картинки по id статьи
    public function get_img_url($art_id)
    {
        $sql = "SELECT `file_sername` FROM `files` WHERE `file_id` IN
                (SELECT `file_id` FROM `art_files` WHERE `art_id` =$art_id AND `status`= '1')";
        $query = $this->db->query($sql);
        return $query->row_array();
        
        
    }
    
    //  
    public function get_art($art_id)
    {
        $sql = "SELECT articles .* ,users.user
                FROM articles
                LEFT JOIN users ON articles.user_id = users.user_id
                WHERE articles.art_id =  '$art_id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    //  получение статей для главной страницы
    public function get_article_index_page()
    {
        $limit = $this->config->item('article_per_index_page');
        $sql = "SELECT * FROM `articles` WHERE `user_id` IN
                (SELECT `user_id` FROM `users` WHERE `level` = 'admin')ORDER BY `art_id` DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_user_article_index_page()
    {
        $limit = $this->config->item('article_per_index_page');
        $sql = "SELECT * FROM `articles` WHERE `user_id` IN
                (SELECT `user_id` FROM `users` WHERE `level` = 'user')ORDER BY `art_id` DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    public function update_counter($art_id,$counter_data)
    {
        $this->db->where('art_id',$art_id);
        $this->db->update('articles',$counter_data);
    }
    public function search($search){
        $q = "SELECT * FROM articles WHERE art_title LIKE '%".mysql_real_escape_string($search)."%'";
        $query = $this->db->query($q);
        if($query->num_rows()>0){
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	//  голосование за статью
	public function votes_update($art_id,$value)
	{
		$sql ="UPDATE `articles` SET `art_votes` = `art_votes` + $value WHERE `art_id` = $art_id ";
		$this->db->query($sql);
		return true;
		
	
	}
    
    public function votes_upd($art_id,$value)
    {
        $sql = "UPDATE `articles` SET `$value` = `$value` + '1' WHERE `art_id` = $art_id";
        $this->db->query($sql);
		return true;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
?>