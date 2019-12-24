<?php session_start();
  setlocale(LC_ALL, 'ru_RU.utf8');
  // Header("Content-Type: text/html;charset=UTF-8");
  if(isset($_GET['exit'])){
    session_unset();
    // session_destroy();
    header("Location: /slotmachinephp/index.php");
    exit;
  }

  if(isset($_SESSION['logged_user'])){
     echo "HI, ".$_SESSION['logged_user'];
     echo " <a href='?exit'>Exit</a>";



     include_once("container.php");

   }else{
     include_once("login.html");
      // echo "Login plz ";
      // echo '<input type="text" id="nickname" name="nickname" class="nickname" value="">
      // <button type="button" onclick="setNickname()" name="button">SET NICK</button>';
   }


?>

<script>
  function reg() {
    // console.log($(".nickname").val().length);
    if ($(".nickname").val().length >= 4){
      if ($(".password").val() == $(".password2").val() && ($(".password").val() != "" && $(".password2").val() != "") ) {
        jQuery.ajax({
          type: "POST", // HTTP метод  POST или GET
          url: "php/auth.php", //url-адрес, по которому будет отправлен запрос
          dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
          data:{nickname: $(".nickname").val(), password:$(".password").val()}, //данные, которые будут отправлены на сервер (post переменные)
          success:function(data){
            if(data == "This nickname already exists") {
              $('.reg_error').html(data);
            }else {
              location.reload();
            }
          },
          error:function (xhr, ajaxOptions, thrownError){
            alert(thrownError); //выводим ошибку
          }
        });
      }else{
        $('.reg_error').html('Invalid password');
      }
    }else{
      $('.reg_error').html('Invalid nickname ( >= 4 chars)');
    }
  }
  function auth() {
      jQuery.ajax({
        type: "POST", // HTTP метод  POST или GET
        url: "php/auth.php", //url-адрес, по которому будет отправлен запрос
        dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
        data:{reg:"reg", log_nickname: $(".log_nickname").val(), log_password:$(".log_password").val()}, //данные, которые будут отправлены на сервер (post переменные)
        success:function(data){
          if(data != "") $('.login_error').html(data);
          else location.reload();
        },
        error:function (xhr, ajaxOptions, thrownError){
          alert(thrownError); //выводим ошибку
        }
      });
  }

</script>
</body>
</html>
