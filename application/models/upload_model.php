<?php
class Upload_model extends CI_Model
{
    public function __construct(){
        parent:: __construct();
       
    }
    
    function upload_file($user_id,$data)
    {
        $file_name = $data['upload_data']['orig_name']; 
        $file_servername = $data['upload_data']['file_name']; 
        $file_size =  $data['upload_data']['file_size']; 
        $sql = "INSERT INTO `files` SET `file_name` = '$file_name',`file_servername` = '$file_servername',`file_size`='$file_size',`user_id`='$user_id'";
        $query = $this->db->query($sql);
        return true;
    }
}



?>