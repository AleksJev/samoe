<div class="content">
    <div class="in_main">
    <h2>О сайте</h2>
    <p>
    Cайт создан как пример для дипоамной работы который я пытаюсь сделать на свой лад.<br />
    Посмотрим как получится<br />
    А пока можете улыбнутся :)<br />
    <br />
    <br />
    </p>


<?php $rss = simplexml_load_file("http://www.anekdot.ru/rss/export_top.xml");
$novosti = count($rss -> channel ->description );
?><div id="wrapper">
        <div id="shape"><?php
for($y=1;$y<=8;$y++)
{
    $desc=$rss -> channel -> item -> $y -> description;
    $title=$rss -> channel -> item -> $y -> title;
    $link=$rss -> channel -> item -> $y -> link;
    ?><div class="plane p<?=$y?>"><a href="<?=$link?>" target="_blank"><?=$desc;?></a></div><?
    
}
?></div>
</div>
<?php
?> 
</div>
</div>
