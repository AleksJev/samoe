<?php
      include("config.php");
      $ip=$_SERVER['REMOTE_ADDR'];
if($_POST['id'])
      {

      $id=$_POST['id'];
      $id = mysql_escape_String($id);
      //Verify IP address in Voting_IP table
      $ip_sql=mysql_query("select ip_add from Voting_IP where art_id_fk='$id' and ip_add='$ip'");
      $count=mysql_num_rows($ip_sql);
if($count==0)
      {
      // Update Vote.

      $sql = "update articles set up=up+1 where art_id='$id'";
      mysql_query( $sql);
      // Insert IP address and Message Id in Voting_IP table.
      $sql_in = "insert into Voting_IP (art_id_fk,ip_add) values ('$id','$ip')";
      mysql_query( $sql_in);
      echo "<script>alert('Thanks for the vote');</script>";
      }
      else
      {
      echo "<script>alert('You have already voted');</script>";
      }
$result=mysql_query("select up from articles where art_id='$id'");
      $row=mysql_fetch_array($result);

      $up_value=$row['up'];
      echo $up_value;
}
      ?>