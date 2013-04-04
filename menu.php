<?php
function db_connect()
    {
        $host = "phptest.webskola.lv";
        $user ="samoe_user";
        $pass="10102020";
        $dbname="samoe_db";
        
        if ($db = mysql_connect($host,$user,$pass))   // $db - resurs   @mysql_connect - proverjaet net li uze soedinenija.esli estj to perexodim k punktu mysql_select_db
            {
                mysql_select_db($dbname,$db);
                return $db;
            }
            else
            {
                return false;
            }
    }

db_connect(); 
mysql_query("SET NAMES utf8");
$result = mysql_query("SELECT * FROM menu WHERE visible='1' ORDER BY position");
while ($row = mysql_fetch_assoc($result))
{
  $categories[$row['id']] = array(
    'id' => $row['id'], 
    'name' => $row['name'], 
    'link' => $row['link'], 
    'parent' => $row['parent']
  );
}
mysql_close();
 
function gen_menu($array, $parent = 0, $level = 0)
{
  $has_children = false;
  foreach($array as $key => $value)
  {
    if ($value['parent'] == $parent) 
    {                   
      if ($has_children === false)
      {
        $has_children = true;  
        echo "\n<ul>";
        $level++;
      }
               
    echo '<li><a href="'.$value['link'].'">'.$value['name'].'</a>';
    gen_menu($array, $key, $level); 
    echo "</li>\n";
    }
  }
  if ($has_children === true)
  echo "</ul>\n";
}
gen_menu($categories);

?>