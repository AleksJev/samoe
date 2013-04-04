<div style="margin-bottom: 100px;">
<a class="button" href="/users/cabinet">В кабинет</a>
    <?php if(!empty($output)):?>
         <?php 
        foreach($css_files as $file): ?>
        	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach($js_files as $file): ?>
        	<script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <?php echo $output; endif ;?>

</div>