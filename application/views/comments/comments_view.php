<div class="content">
<div class="in_main">
<?//=$count?>
<h3><?=$article['art_title']?></h3>
<?=strip_tags(implode(array_slice(explode('<br />',wordwrap($article['art_text'],300,'<br />',false)),0,1)))?><br /><br />
<?php foreach($comments_list as $item):?>
            <div class="comment">
                <?php if($item['user_id']=='0'){echo "Author: $item[author]";}else{echo "User id: $item[user_id]";}?>
				<?=$item['name']?>
				
				<br />
				<?=$item['comm_text'];?>
				Date : <?=$item['date'];?>
            </div>
       <?php endforeach; ?>
       <hr />
<?=$page_nav;?>
    <hr />
     <br /><br />
        <fieldset class="add_comments">
            <form action="<?=base_url()."comments/add/$art_id";?>" method="post">
                <div class="name"><!--Ваше имя<br />-->
                <?php $user_id=$this->session->userdata('user_id');?>
                
                <?php if(!empty($user_id))
                {
                    //echo $user_id;
                }
                else
                {
                    //echo 'enter the site';
                }
                ?>
                <?if(!empty($name)){
                    echo $name;
                    ?>
                    
                    <input type="hidden" name="user_id" value="<?=$user_id?>"/>
                    <input type="hidden" name="author" value="<?=$name?>"/>
                    
                    <?
                }
                else
                {
                    ?>
                    <input placeholder="Ваше имя" type="text" name="author" value="<?php if(empty($success_comment)) echo set_value('author');?>"/><br />
                    <strong><?=form_error('user_id');?></strong>
                    
                    <?
                }?>
                    
                    
                    
                </div>
                <div class="text"><!--Текст комментария <br />-->
                    <textarea placeholder="Текст комментария" name="comm_text" cols="50" rows="5"><?php if(empty($success_comment)) echo set_value('comm_text');?></textarea><br />
                    <strong><?=form_error('comm_text');?></strong>
                </div>
                <a name="captcha"></a>
                <div class="captcha"><!--Введите цифры с картинки-->
                    <p><?=$imgcode;?></p>
                    <p><input type="text" name="captcha" size="10" autocomplete="off"/><br />
                    <strong><?//=form_error('captcha');?></strong>
                </div>
                <input name="art_id" type="hidden" value="<?=$art_id;?>"/>
                <input type="submit" class="blue" name="add_comment" value="Комментировать"/>
            </form>
        </fieldset>
</div>
</div>


