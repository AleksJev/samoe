<div class="rg_nav">
<div>
    <h4>Категории</h4>

    <?foreach($all_category as $item):?>
        <span><a href="/category/show/<?=$item['cat_id']?>"><?=$item['cat_alias']?></a></span><br />
    <?endforeach?>

</div>
<div>
    <h4>Популярное</h4>
        <?foreach($popular_articles as $item):?>
            <a href="<?=base_url()."articles/$item[art_id]"?>"><?=$item['art_title']?></a><small>[<?=$item['count_views']?>]</small><br />
        <?endforeach?>
</div>
<div>
    <h4>Из последнего</h4>
        <?foreach($latest_articles as $item):?>
            <a href="<?=base_url()."articles/$item[art_id]"?>"><?=$item['art_title']?></a><small>[<?=$item['count_views']?>]</small><br />
        <?endforeach?>
    </div>
    <div>
    <h4>RSS лента новостей</h4>
    <?php
    $arzemes = simplexml_load_file('http://news.yandex.ru/computers.rss');
    $novosti = count($arzemes->channel->item );
    for($y=0;$y<5;$y++)
    {
        $title=$arzemes->channel->item->$y->title;
        $link=$arzemes->channel->item->$y->link;
        $desc=$arzemes->channel->item->$y->description;
        $pubdate=$arzemes->channel->item->$y->pubDate;
        echo '<div class="yandex">
                <h3><a href='.$link.'>'.$title.'</a></h3>'
                .$desc.
            '</div>';    
    } ?>
</div>
</div>