<?php
class Comments_model extends Crud
{
    public $table = 'comments';   // имя таблицы
    public $idkey = 'comm_id'; // имя ID
    
    public function get_by($art_id)
    {
		$q = "SELECT comments.*,users.name FROM comments LEFT JOIN users ON comments.user_id";
		$sql = "SELECT comments.* ,(SELECT users.name FROM users WHERE users.user_id = comments.user_id) AS name FROM comments WHERE comments.art_id = $art_id ORDER BY comments.comm_id";
        $this->db->order_by('comm_id','desc');
        $this->db->where('art_id',$art_id);
        $query = $this->db->get('comments');
		$result = $this->db->query($sql);
        return $result->result_array(); // массив с комментариями к материалу
        
    }
    
    public function get_by_art($art_id,$limit)
    {
		$q = "SELECT comments.*,users.name FROM comments LEFT JOIN users ON comments.user_id";
		$sql = "SELECT comments.* ,(SELECT users.name FROM users WHERE users.user_id = comments.user_id) AS name FROM comments WHERE comments.art_id = $art_id ORDER BY comments.comm_id LIMIT $limit";
        $this->db->order_by('comm_id','desc');
        $this->db->where('art_id',$art_id);
        $query = $this->db->get('comments');
		$result = $this->db->query($sql);
        return $result->result_array(); // массив с комментариями к материалу
        
    }
    
    public function count_by($art_id)
    {
		$q = "SELECT comments.*,users.name FROM comments LEFT JOIN users ON comments.user_id";
		$sql = "SELECT comments.* ,(SELECT users.name FROM users WHERE users.user_id = comments.user_id) AS name FROM comments WHERE comments.art_id = $art_id ORDER BY comments.comm_id";
        $this->db->order_by('comm_id','desc');
        $this->db->where('art_id',$art_id);
        $query = $this->db->get('comments');
		$result = $this->db->query($sql);
        return $result->num_rows(); // массив с комментариями к материалу
        
    }
    
    public function comm_get_by($art_id,$limit,$start_from)
    {
		$q = "SELECT comments.*,users.name FROM comments LEFT JOIN users ON comments.user_id";
		$sql = "SELECT comments.* ,(SELECT users.name FROM users WHERE users.user_id = comments.user_id) AS name FROM comments WHERE comments.art_id = $art_id ORDER BY comments.comm_id LIMIT $start_from,$limit";
        $this->db->order_by('comm_id','desc');
        $this->db->where('art_id',$art_id);
        $query = $this->db->get('comments');
		$result = $this->db->query($sql);
        return $result->result_array(); // массив с комментариями к материалу
        
    }
    
    public $add_rules = array
    (
        array
        (
            'field' => 'author',
            'label'  => 'Author',
            'rules'  => 'trim|required|xss_clean|max_length[70]'
        ),
        array
        (
            'field' => 'comm_text',
            'label'  => 'Текст комментария',
            'rules'  => 'xss_clean|max_length[5000]'
        ),
        array
        (
            'field' => 'captcha',
            'label'  => 'Цифры с картинки',
            'rules'  => 'required|numeric|exact_length[5]'
        )
    
    
    );
    
    public function add_new($comment_data)
    {
        $this->db->insert('comments',$comment_data);
    }
    
}

?>