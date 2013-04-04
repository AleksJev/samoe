<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends Crud
{
    public $table = 'category';
    public $idkey = 'cat_id';
    
    
    public function get_articles($cat_id)
    {
        $sql= "SELECT * 
                FROM (
                    SELECT art_id
                    FROM art_cat
                    WHERE cat_id =  $cat_id
                )c, articles
                WHERE c.art_id = articles.art_id";      // , art_files . * , files . * 
         $query = $this->db->query($sql);
         return $query->result_array();    
    }
    
    public function get_by($cat_id,$limit,$start_from)
    {
        //$limit = 2;
        $sql= "SELECT * 
                FROM (
                    SELECT art_id
                    FROM art_cat
                    WHERE cat_id =  $cat_id
                )c, articles
                WHERE c.art_id = articles.art_id ORDER BY articles.art_id DESC LIMIT $start_from,$limit";      // , art_files . * , files . * 
         
         //$this->db->limit($limit,$start_from);
         //$this->db->order_by('art_id','desc');
         $query = $this->db->query($sql);
         
         return $query->result_array();    
    }
    
    public function count_by($cat_id)
    {
        $sql = "SELECT * 
                FROM (
                    SELECT art_id
                    FROM art_cat
                    WHERE cat_id =  $cat_id
                )c, articles
                WHERE c.art_id = articles.art_id"; 
        $query = $this->db->query($sql);
        return $query->num_rows();  
    }
    
    /*
    public function get_articles($cat_id)
    {
        $sql = "SELECT * FROM `articles` WHERE cat_id = $cat_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    */
    public function get_all()
    {
        $query = $this->db->get('category');
        return $query->result_array();
    }
    
}




?>