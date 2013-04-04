<?
$name = form_error('name');
$email = form_error('email');
$topic = form_error('topic');
$message =form_error('message');
$captcha = form_error('captcha');
?>
<div class="content">
    <div class="in_main">
        <div class="contact">
        <?//=$info;?>
        <h4><?//=$main_info['page_title']?></h4>
        <p> <?=$main_info['page_text']?>
        </p>
        
        <?//php print_r($test());?>
        <fieldset class="mail">
            <legend>Обратная связь</legend>
            <?=form_open(base_url().'pages/contact')?>
            <p><label>Ваше имя</label>
                <input type="text" name="name" value="<?//=set_value('name');?>"/> <b>*</b>
                <small><?=form_error('name');?></small>
                </p>
                <p><label>Ваш E-mail</label>
                <input type="text" name="email" value="<?//=set_value('email');?>"/> <b>*</b>
                <small><?=form_error('email');?></small>
                </p>
                <p><label>Тема сообщения</label>
                <input type="text" name="topic" value="<?//=set_value('topic');?>"/> <b>*</b>
                <small><?=form_error('topic');?></small>
                </p>
                <p><label>Текст сообщения</label><br />
                <textarea name="message" cols="80" rows="7"><?//=set_value('message');?></textarea> <b>*</b>
                <small><?=form_error('message');?></small>
                </p>
                <p><label>Введите цифры с картинки</label></p>
                <p><?=$imgcode;?></p>
                <p><input type="text" name="captcha" size="5" maxlength="5" pattern= "[0-9]{5}"/> <b>*</b><br />
                <small><?=form_error('captcha'),$info;?></small>
                </p>
                <p><input type="submit" name="send_message" value="Отправить письмо"/></p>
            <?=form_close();?>
            <?$ip=$_SERVER['REMOTE_ADDR'];?>
        </fieldset>
        
        <br /><br />
            <script>
                $(document).ready(function(){
                    initialize();
                })
            </script>
         <div id="map_canvas" style="width:400px; height:300px;"></div>
        
        </div>
    </div>
</div>
    <div class="errors">
        <span class="close">X</span>
        <?echo $name.'<br>'. $email.'<br>'.$topic.'<br>'.$message.'<br>'.$captcha ;?>
    </div>
    <script>
        $(document).ready(function() {
           //if($('.mail').find('small').length){
             /*  if($('input:submit').on('click',function(){
               $('small').hide();
               $('.errors').slideToggle(500);
           }))
            $('.close').on('click',function() {
                $('.errors').hide();
            })
        })*/
    </script>