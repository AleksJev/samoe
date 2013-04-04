<div class="content">
    <div class="in_main">
    <?php echo "Вы искали по названию : $search<br />";?>
    <pre>
    <?//php print_r($articles_serch_result);?>
    </pre>
    <hr />
    <?php $mas ='';
    if (!empty($articles_serch_result)){
        foreach($articles_serch_result as $item){?>
        <div>
        <h3><a href="/articles/<?=$item['art_id']?>"><?=$item['art_title']?></a></h3>
            
            <p>
                <?=implode(array_slice(explode('<br />',wordwrap($item['art_text'],500,'<br />',false)),0,1))." <a href='/articles/$item[art_id]'>Открыть всю статью</a>"?>
            </p>
        </div>
        <?php
        }
    }
    else
    {
        
    }
    ?>
    
    
    </div>
</div>