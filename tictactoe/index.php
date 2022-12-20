<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TicTacToe</title>
    <style>
      .container {
  display: flex;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  flex-direction:column;
}
#root {
  display: flex;
  flex-direction: column;
}
.row {
  display: flex;
}
.item {
  width: 100px;
  height: 100px;
  margin: 3px;
  background-color: black;

  display: flex;
  justify-content: center;
  align-items: center;
}
.item div {
  color: white;
}
#message{
  display:block;
  position:absolute;
  top:200px;
  left:calc(50%-100px);
}

    </style>
  </head>
  <body>
    <div class="container">
    <h2 >Gracz <span id="p">X</span></h2>
      <div id="root"></div>
      <div id='message'>
        <h1 id="text">Oczekiwanie na drugiego gracza</h1>
      </div>
    </div>
  </body>
  <?php
    session_start();
    if(isset($_SESSION["players"])){
      session_destroy();
      session_start();
      $_SESSION["game"] = "play";
      $_SESSION["data"] = [0,0,0,0,0,0,0,0,0];
      $_SESSION["player"] = 1;
    }else{
      $_SESSION["game"] = "wait";
      $_SESSION["players"] = 1;
      $_SESSION["data"] = [0,0,0,0,0,0,0,0,0];
    }
  ?>
  <script>
    const root = document.getElementById("root");

    function loadDoc() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText)
          let json = [];
          const ar = this.responseText.split(" ");
          json = JSON.parse(ar[1]);
          if (ar[0] == "end") {
            clearInterval(interval);
            document.getElementById("message").style.display = "block"
            let winner = "O"
            if(ar[2] == "1"){
              winner = "X"
            }
            document.getElementById("text").innerText = "Koniec gry! Zwycięstwo gracza: " + winner
          }else if(ar[0] == "wait"){
            document.getElementById("p").innerText = "O"
            document.getElementById("message").style.display = "block"
          }else if(ar[0] == "play"){
            document.getElementById("message").style.display = "none"
          }
          let str = "";
          let licznik = 0;
          let pMove = "2"
          if(document.getElementById("p").innerText == "O"){
            pMove = "1"
          }
          for (let i = 0; i < 3; i++) {
            str += "<div class='row'>";
            for (let j = 0; j < 3; j++) {
              if (json[licznik] == 0) {
                if (ar[0] == "play" && ar[2] == pMove)
                  str += `<div class="item" onclick="move(${licznik})"></div>`;
                else str += `<div class="item"></div>`;
              } else if (json[licznik] == 1) {
                str += '<div class="item"><div>O</div></div>';
              } else if (json[licznik] == 2) {
                str += '<div class="item"><div>X</div></div>';
              }
              licznik++;
            }
            str += "</div>";
            root.innerHTML = str;
          }
        }
      };
      xhttp.open("GET", "server.php", true);
      xhttp.send();
    }
    const interval = setInterval(() => loadDoc(), 500);
    function move(id) {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", "server.php?pos=" + id, true);
      xhttp.send();
    }
  </script>
</html>
