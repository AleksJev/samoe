<div class="content">
    <div class="in_main">
    <?//=$counts?><br />
    
    <?//php print_r($cat_articles)?>
    <?php foreach($article_list as $item):?>
<div>
    <h4><a href="/articles/<?=$item['art_id']?>"><?=$item['art_title']?></a></h4>
   <p>
   <?=strip_tags(implode(array_slice(explode('<br />',wordwrap($item['art_text'],300,'<br />',false)),0,1)))?>
   </p>
      
</div>
<?//=$item['art_date']?>
<?//=$item['user_id']?>
<?//=$item['file_id']?>
<?//=$item['count_views']?>

<?php endforeach;?>
<hr />
<?=$page_nav;?>
    <hr />
    <pre>
     <?//php print_r($article_list)?>
    </pre>
   
    </div>

</div>


<!--
Array ( [0] => Array ( [art_id] => 1 [art_title] => Toshiba Excite 10 LE [art_text] =>
[user_id] => 1 [count_views] => 42 [art_votes] => 0 [art_date] => 2012-03-02 18:08:59 [file_id] => 1 [status] => 1 [file_name] => toshiba_excite_10_le [file_sername] => /images/toshiba_excite_10_le.jpg [file_size] => 67007 ) )-->