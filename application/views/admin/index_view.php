<div style="min-height: 300px;">
    <div style="margin: 5px; padding:10px 5px;background-color: #FFFFFF;min-height: 100px;min-width: 500px;">
    
     <?php if(!empty($output)):?>
         <?php 
        foreach($css_files as $file): ?>
        	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach($js_files as $file): ?>
        	<script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <style type='text/css'>
        /*body
        {
        	font-family: Arial;
        	font-size: 14px;
        }
        a {
            color: blue;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover
        {
        	text-decoration: underline;
        }*/
        </style>
        <?php echo $output; endif ;?>


    </div>
</div>