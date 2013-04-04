<div class="content">
    <div class="in_main">
    <?php 
    //echo $session_id = $this->session->userdata('session_id');
    //echo '<br />';
    //echo $this->session->userdata('login');
    //print_r($this->session->userdata($data_ses))?>
    <?php 
    echo $logged_in;
    echo 'user_id:'.$this->session->userdata('user_id');
    echo 'name'.$this->session->userdata('name')?>
    <hr />
    <?=$user = $this->session->userdata('user');?>
    <?if(isset($user)){
        echo "Вы зашли на сайт под логином $user";
    }?>
    </div>
</div>