<?php
session_start();
if($_POST["interval"] == true )
{
  include_once("config.php");
  $Result = mysql_query("SELECT id,nickname,results,balance,attempts FROM users ORDER BY balance DESC");
  while($row = mysql_fetch_array($Result))
    {
      if($row["nickname"] == $_SESSION['logged_user']){
        $myNickName = $row["nickname"];
        $myBalance = $row["balance"];
        $myAttempts = $row["attempts"];
      }
      echo '<li id="item_'.$row["id"].'">'.$row["nickname"].': '.$row["results"];
      echo '(balance: $'.$row["balance"].', last attempts:'.$row["attempts"].')</li>';
    }
  mysql_close($connecDB);
}
?>
