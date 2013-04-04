<div class="content">
    <div class="in_main">
        <div>
        <h3>Ваш кабинет  <?=$name;?> <?=$sname;?></h3>
        <a href="/users/activation/<?=$user_id?>">Activation</a><br />
        <a class="button" href="/users/useredit/edit/<?=$user_id?>">Редактировать свои данные</a>
        </div>
        <!--
        <div>
            <h4>Подписки</h4>
            <?//php if(!empty($subscription)):?>
            <?//php foreach($subscription as $item):?>
                <a href="/users/subscription_art/<?//=$item['user_id']?>"><?//=$item['user']?></a><br />
            <?//php endforeach ;?>
            <?//php endif ;?>
        </div>
        <div>
            <h4>Понравившиеся статьи</h4>
            <?//php print_r($like_art)?>
            <?//php if(!empty($like_art)):?>
            <?//php foreach($like_art as $item):?>
                <a href="/articles/<?//=$item['art_id']?>"><?//=$item['art_title'];?></a> <br />
            <?//php endforeach ;?>
            <?//php endif ;?>
        </div>-->
        <hr />
        <div>
            <?php if($activated == '1'):?>
            <a class="button" href="/users/articles">Ваши статьи</a>
            <?php endif;?>
        </div>
   <script>
	$(function() {
		$( "#accordion" ).accordion({ autoHeight: false });
	});
	</script>
<div class="demo">
<div id="accordion">
	<h3><a href="#">Подписки</a></h3>
	<div>
		<?php if(!empty($subscription)):?>
            <?php foreach($subscription as $item):?>
                <a href="/users/subscription_art/<?=$item['user_id']?>"><?=$item['user']?></a><br />
            <?php endforeach ;?>
            <?php endif ;?>
	</div>
	<h3><a href="#">Понравившиеся статьи</a></h3>
	<div>
		<?//php print_r($like_art)?>
            <?php if(!empty($like_art)):?>
            <?php foreach($like_art as $item):?>
                <a href="/articles/<?=$item['art_id']?>"><?=$item['art_title'];?></a> <br />
            <?php endforeach ;?>
            <?php endif ;?>
	</div>
    <?php if($activated == '1'):?>
    <h3><a href="/users/articles">Ваши Файлы</a></h3>
    <div>
        
            <?php echo form_open_multipart('upload/do_upload');?>
            <input type="file" name="userfile" size="20" />
            <br /><br />
            <input type="submit" value="upload" />
            </form>
            <?php foreach($file as $item):?>
            <a href="/images/uploads/<?=$item['file_servername']?>"><img src="/images/uploads/<?=$item['file_servername']?>" width="100px" height="70px"/></a> <input type="text" size="50" value="/images/uploads/<?=$item['file_servername']?>"/><br />
            
            <?php endforeach?>
    </div>
    <h3><a href="#">Инструкция добавления статьи на сайт</a></a></h3>
    <div>
        <iframe width="480" height="360" src="http://www.youtube-nocookie.com/embed/_xYDItDsADg" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php else: ?>
        <h3><a href="#">Активация аккаунта</a></h3>
        <div>
        <a href="/users/activation/<?=$user_id?>">Activation</a><br />
        </div>
     <?php endif;?>
</div>
    </div>
    
    <?php if(!empty($upload_data))print_r($upload_data)?>
</div>
</div>