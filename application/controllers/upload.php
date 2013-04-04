<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	
        $this->data['user_id']      = $this->session->userdata('user_id');
      
	}

	function index()
	{
		redirect(base_url());
	}

	function do_upload()
	{
	   $this->load->model('upload_model');
		$config['upload_path'] = './images/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$upload = $this->data['upload_data'] = array('upload_data' => $this->upload->data());
                $this->upload_model->upload_file($this->data['user_id'],$upload);
            
            redirect(base_url().'users/cabinet');
			//$this->display_lib->user_page($this->data,'users/cabinet');
		}
	}
}
?>