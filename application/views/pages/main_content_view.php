<div class="content">
    <div class="in_main">
        <?php //if(!empty($_SESSION['logged_in'])&& ( $_SESSION['logged_in'] == 'logged'))
            if ($logged_in == 'logged' && isset($_GET['enter'])) {?>
                <script>
                   <!--
                    if (document.cookie.indexOf('_visited=1') == -1) {
                    // Сюда вставить код открытия окна
                    $.fx.speeds._default = 1000;
                        $(function() {
                            $( "#reg_errors" ).dialog({
                                autoOpen: true,
                                show: "blind",
                                minWidth: 600,
                                /*modal:true,*/
                                hide: "explode"
                            });
                        });
                    document.cookie = '_visited=1; path=/';
                    }
                    //-->
                 </script>
                <div id="reg_errors" title="Поздравляем">
                    <p>Вы вошли на сайт</p>
                </div>
    <?}?>
        <h2><?=$main_info['page_title'];?></h2>
        <?=$main_info['page_text'];?>
        <?php if(isset($_GET['false'])){?>
            <script>
                $.fx.speeds._default = 1000;
                    $(function() {
                        $( "#reg_errors" ).dialog({
                            autoOpen: true,
                            show: "blind",
                            minWidth: 600,
                            /*modal:true,*/
                            hide: "explode"
                        });
                });
            </script>
            <div id="reg_errors" title="Ошибочки такие вот">
                <p>Не правильно введен логин или пароль</p>
            </div>
        <?}?>
            <div class="main_articles">
                <? foreach($all as $item):?>
                    <div class="art">
                        <p>
                            <h3><a href="<?=base_url()."articles/$item[art_id]";?>"><?=$item['art_title'];?></a></h3>
                        <?=strip_tags(implode(array_slice(explode('<br />',wordwrap($item['art_text'],300,'<br />',false)),0,1)))." <a href='articles/$item[art_id]'>подробнее</a>";?>
                        </p>
                        <? if(!empty($item['file_url'])):?>
                            <img src="/assets/uploads/files/<?=$item['file_url'];?>" width="200"/>
                        <? endif?>
                    </div>
                <? endforeach;?>
        </div>
        <h4>Статьи от пользователей</h4>
        <? foreach($user_articles as $item):?>
        <table class="latest_art">
            <tr>
                <td>
                    <p class="lat"><a href="<?=base_url()."articles/$item[art_id]";?>"><?=$item['art_title'];?></a><br />
                    <?=strip_tags(implode(array_slice(explode('<br />',wordwrap($item['art_text'],300,'<br />',false)),0,1)))." <a href='articles/$item[art_id]'>подробнее</a>";?>
                    </p>
                   <!-- <p class="anons_title">User :
                    <?//=$item['user'];?><br />
                    Просмотров : <?//=$item['count_views']?></p>-->
                <?php if(!empty($item['file_url'])):?>
                    <img src="/assets/uploads/files/<?=$item['file_url'];?>" width="200"/>

                <?php endif?>
                автор <?php echo $this->users_model->get_user($item['user_id']);?>
                </td>
            </tr>
        </table>
        <? endforeach;?>
        
    </div>
</div>