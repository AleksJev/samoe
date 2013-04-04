<?php
      $mysql_hostname = "samoe.phptest.webskola.lv";
      $mysql_user = "samoe_user";
      $mysql_password = "10102020";
      $mysql_database = "samoe_db";
      $bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
      or die("Opps some thing went wrong");
      mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
      ?>