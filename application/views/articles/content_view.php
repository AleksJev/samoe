<div class="content">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div class="in_main">
    <div class="article">
    <?php
    if(!empty($success_comment))
    {
        redirect (base_url()."articles/$art_id/#new_comment");
    }
    ?>
        <h3><?=$article['art_title']?></h3>
        <p>
        <?php
        if(!empty($article['file_url']) )echo "<img src='/assets/uploads/files/$article[file_url]'/>";
        ?>  
        <?=$article['art_text']?></p>
        <br />
       
        <hr style="margin-top: 20px;min-width: 700px;"/>
		
    </div><a name="vote_add"></a>
    <div>
         <div class="fb-like" data-send="true" data-width="450" data-show-faces="true"></div>
		
		<?php
			$v = get_cookie('votes_'.$art_id);
		if (empty($v))
		{
		  ?> <a href="/articles/art_votes/<?=$art_id?>/up"><img src="/images/up.png" /></a> <?=$article['up']?> | <a href="/articles/art_votes/<?=$art_id?>/down"><img src="/images/down.png" /></a> <?=$article['down']?><?
		}
		elseif ($v == $art_id)
		{
			?><img src="/images/up.png" /> <?=$article['up']?> | <img src="/images/down.png" /> <?=$article['down']?><?
		}
        ?>
        
       
        
    
		<input type="button" value="Print this page" onClick="window.print()">
        <hr />
	 <?php if(!empty($logged_in)&& ($logged_in == 'logged')):?>
            <a href="/users/favorite_art/<?=$user_id?>/<?=$art_id?>">Добавить в кабинет</a><br />
            <a href="/users/subscribe_add/<?=$article['user_id']?>/<?=$art_id?>">Подписаться на автора</a><br />
        <?php endif?>
        
        <?php if(!empty($level)&&($level == 'admin')):?>
            <a href="/admin/articles/edit/<?=$art_id?>">Редактировать</a>
        <?php endif; ?>
        
  </div>
    
     <a name="new_comment"></a>
     
         <?php foreach($comments_list as $item):?>
            <div class="comment">
                <?php if($item['user_id']=='0'){echo "Author: $item[author]";}else{echo "User id: $item[user_id]";}?>
				<?=$item['name']?>
				
				<br />
				<?=$item['comm_text'];?>
				Date : <?=$item['date'];?>
            </div>
       <?php endforeach; ?>
       
       <?php if($limit < $total):?>
       <a href="/comments/<?=$art_id?>">все комменты</a>
       <?php endif?>
       
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