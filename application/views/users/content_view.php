<div class="content">
    <div class="in_main">
    all users :<br />
    <?foreach($all_users as $item):?>
    <a href=""><?=$item['user']?></a><br />
    
    <?endforeach?>
    <hr />
    <?=$this->config->item('login');?>
    </div>
</div>