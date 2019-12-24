<?php session_start();
  include_once("config.php");

  if(isset($_POST['nickname']) AND $_POST['password'] ) {

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $rez = mysql_query("SELECT nickname FROM users WHERE nickname='".$nickname."'");
	   if (@mysql_num_rows($rez) != 0){
        echo "This nickname already exists";
     }else {
       mysql_query("INSERT INTO users(nickname,password,results,balance,attempts,steps) VALUES('".$nickname."','".$password."','0','100','0','0') ");
       $_SESSION['logged_user'] = $_POST['nickname'];
       mysql_close($connecDB);
       header("Location: /slotmachinephp/index.php");
       exit;
     }
   }elseif ($_POST['reg'] == 'reg'){
     $log_nickname = $_POST['log_nickname'];
     $log_password = $_POST['log_password'];

     $query = mysql_query("SELECT * FROM users WHERE nickname='".$log_nickname."' AND password='".$log_password."' ");

     if (mysql_num_rows($query) != 0){
       while($row=mysql_fetch_assoc($query))
        {
       	$dbusername=$row['nickname'];
        $dbpassword=$row['password'];
        }
         if($log_nickname == $dbusername && $log_password == $dbpassword){

           $_SESSION['logged_user'] = $log_nickname;
           mysql_close($connecDB);
           // header("Location: /index.php");

       	} else {
       	  echo "IIIIII";
        }
      }else{
        echo "Invalid username or password";
      }
   }



 ?>
