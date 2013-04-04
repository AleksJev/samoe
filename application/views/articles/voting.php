<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
      libs/jquery/1.3.0/jquery.min.js"></script>
      <script type="text/javascript">
      $(function() {
      $(".vote").click(function() 
      {

      var id = $(this).attr("id");
      var name = $(this).attr("name");
      var dataString = 'id='+ id ;
      var parent = $(this);
if (name=='up')
      {
$(this).fadeIn(200).html('<img src="dot.gif" />');
      $.ajax({
      type: "POST",
      url: "up_vote.php",
      data: dataString,
      cache: false,
success: function(html)
      {
      parent.html(html);

      } 
      });
      }
else
{
$(this).fadeIn(200).html('<img src="dot.gif" />');
      $.ajax({

      type: "POST",
      url: "down_vote.php",
      data: dataString,
      cache: false,
success: function(html)
      {
      parent.html(html);
      }
      });
      }
return false;
});
      });
      <script
//HTML Code

    
<?php
include('config.php');
      $sql=mysql_query("SELECT * FROM messages LIMIT 9");
      while($row=mysql_fetch_array($sql))
      {
$msg=$row['msg'];
      $mes_id=$row['mes_id'];
      $up=$row['up'];
      $down=$row['down'];
      ?>
<div class="main"> 
    
<div class="box1">
      <div class='up'>
      <a href="" class="vote" id="<?php echo $mes_id; ?>" name="up">
      <?php echo $up; ?></a></div>
<div class='down'>
      <a href="" class="vote" id="<?php echo $mes_id; ?>;" name="down">
      <?php echo $down; ?></a></div>
      </div>
<div class='box2' ><?php echo $msg; ?></div>
      </div>
<?php } ?>