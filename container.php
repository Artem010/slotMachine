<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="jquery.animateNumber.min.js"></script>
  <link rel="stylesheet" href="main.css">
  <title>Slot Machine</title>
</head>
<body>
  <div class="container">
    <div class="row">
        <div class="col-md-6">
          <h2>
            <span class="lines1">0</span><span class="lines2">0</span><span class="lines3">0</span>
          </h2>
          <input type="number" name="rate" value="10">
          <button class="button" type="button" name="button" onclick="setRate()">Set Rate</button>
          <button class="button clsGame" type="button" name="button" onclick="game()" >Game</button>
          <h3>Last attempts: <span class="attempts">0</span> </h3>
          <h3>Your balance: $<span class="balance">100</span> </h3>
          <p></p>
          <div class="winMoney">
            <span>WinMoney:</span>

          </div><br>
        </div>
        <div class="col-md-6 interval">
          <?php
          include_once("php/config.php");
          $Result = mysql_query("SELECT id,nickname,results,balance,attempts,steps FROM users ORDER BY balance DESC");
          while($row = mysql_fetch_array($Result))
            {
              if($row["nickname"] == $_SESSION['logged_user']){
                $myNickName = $row["nickname"];
                $myBalance = $row["balance"];
                $myAttempts = $row["attempts"];
                $mySteps = $row["steps"];
              }
              echo '<li id="item_'.$row["id"].'">'.$row["nickname"].': '.$row["results"];
              echo '(balance: $'.$row["balance"].', last attempts:'.$row["attempts"].')</li>';
            }
          mysql_close($connecDB);
          ?>
        </div>
    </div>
    <div class="row">
      <ul class="response">

      </ul>

    </div>
  </div>
  <script type="text/javascript">

    var balance  = Number('<?php echo $myBalance?>'),
        rate,
        steps = Number('<?php echo $mySteps?>'),
        rndSTR,
        attempts =  Number('<?php echo $myAttempts?>'),
        isActivGame = false,
        items = [];;

    function random(min,max) {
      return Math.floor(Math.random() * (max - min)) + min
    }
    function setValues () {
      $('.balance').text(balance);
      $(".attempts").text(attempts);
    }
    function downLoadOnBD (){
      if (!rndSTR) rndSTR="";
      let myData = {
        "results": rndSTR,
        "balance": balance,
        "attempts": attempts,
        "steps": steps
      };
      jQuery.ajax({
          type: "POST",
          url: "php/response.php",
          dataType:"text",
          data:myData,
          success:function(response){
            $(".response").prepend(response);
          },
          error:function (xhr, ajaxOptions, thrownError){
              alert(thrownError);
          }
      });
    }

    setValues();

    function win (x,i){
      var moneyWin;
      if (x==3){
        moneyWin = i*rate

        console.log(balance);
        console.log(moneyWin);
        balance+=moneyWin;
        setTimeout(function(){
          $('.balance').text(balance);
          $(".winMoney").append("<span>+" + moneyWin + "$ </span>");
        },1200);
      }else{
        moneyWin = (i*rate)/2
        balance+=moneyWin;
        setTimeout(function(){
          $('.balance').text(balance);
          $(".winMoney").append("<span>+" + moneyWin + "$ </span>");
        },1200);
      }
    }
    function setRate (){
      rate = $('input').val();
      if (attempts==0){
        if (rate <= balance && rate != 0){
          attempts = 4;
          $(".attempts").text(attempts);
          balance-=rate;
          $('.balance').text(balance);
        }
        downLoadOnBD();
      }

    }
    function game() {
      if(attempts>0 && !isActivGame){
        isActivGame = true;
        steps++;
        console.log(steps);
        attempts--;
        $(".attempts").text(attempts);

        rndSTR = "";
        for (i=0;i<3;i++){
          let rnd = random(0,10);
          rndSTR += String(rnd);
          items[i] = rnd;
          $('.lines'+(i+1)).animateNumber({ number: rnd ,easing: 'slow', duration: 250000 });
        }

        for (i=1;i<10;i++){
          if (items[0] == i && items[1]==i && items[2]==i) win(3,i);
          else if (items[0] == i && items[1]==i || items[1]==i && items[2]==i) win(2,i)
        }

        downLoadOnBD();


        setTimeout(function(){

            isActivGame = false;
        }, 1200);

      }
    }

    setInterval(function() {
      jQuery.ajax({
          type: "POST",
          url: "php/interval.php",
          dataType:"text",
          data:{interval:true},
          success:function(response){
            $(".interval").html(response);
          },
          error:function (xhr, ajaxOptions, thrownError){
              alert(thrownError);
          }
      });
    }, 1*1000)
  </script>
