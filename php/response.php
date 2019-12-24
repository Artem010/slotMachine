<?php
session_start();
//подключаем конфигурационный файл бд
include_once("config.php");

//проверяем $_POST["content_txt"] на пустое значение
if(isset($_POST["results"]) )
{

    // очищаем значение переменной, PHP фильтры FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH
    // (Удаляют тэги, при необходимости удаляет или кодирует специальные символы)

    $results = filter_var($_POST["results"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $balance = $_POST["balance"];
    $attempts = $_POST["attempts"];
    $steps = $_POST["steps"];


    // Insert sanitize string in record
    // if(mysql_query("INSERT INTO users(nickname,results,balance, attempts) VALUES('".$_SESSION['logged_user']."','".$results."','".$balance."','".$attempts."')"))
    // $querystring = "UPDATE reviews SET ".$querystring." where `id`=:id";
    if(mysql_query("UPDATE users SET results='".$results."', balance='".$balance."', attempts='".$attempts."', steps='".$steps."' where nickname='".$_SESSION['logged_user']."' "))
    {
      if($_POST["results"]!=""){
        //Record is successfully inserted, respond to ajax request
        $my_id = mysql_insert_id(); //Get ID of last inserted record from MySQL
        echo '<li id="item_'.$my_id.'">'.$_SESSION["logged_user"].': '.$results;
        echo '(balance: $'.$balance.', last attempts:'.$attempts.')</li>';
        mysql_close($connecDB);

      }

    }else{
        //вывод ошибки

        //header('HTTP/1.1 500 '.mysql_error());
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

}else{

    //Output error
    header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();
}
?>
