<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .center{
            margin:30px auto;
            text-align:center;
        }
        #hover{
            display:none;
            top:0;
            width:100vw;
            height:100vh;
            background-color:black;
            position:absolute;
            opacity:0.7;
        }
        #okno{
            display:none;
        }
        #okno{
            position: absolute;
            top:150px;
            left:calc(50vw - 80px);
            width:160px;
            padding:10px;
            height:150px;
            flex-direction:column;
            justify-content:space-evenly;
            border:1px solid black;
            background-color:blue;
        }
        #okno form{
            display: flex;
            flex-direction:column;
            justify-content:space-evenly;
        }
        #okno form button{
            margin-top:7px;
        }
    </style>
</head>
<body>
    <div class="center">
        <?php
        $url = 'http://localhost/wykres/img.php';
        if(!empty($_GET['w']) && !empty($_GET['h']) && !empty($_GET['days'])){
            $url='http://localhost/wykres/img.php?w='.$_GET["w"].'&h='.$_GET['h'].'&days='.$_GET["days"];
        }
        echo "<img src='".$url."' usemap='#workmap'/>";
        session_start();
            echo '<map name="workmap">';
            for($i = 0;$i<count($_SESSION["data"]);$i+=1){
                echo "</br>";
                echo '<area shape="circle" coords="'.$_SESSION["data"][$i][0].','.$_SESSION["data"][$i][1].',5" 
                onclick="myFunction('.$_SESSION["data"][$i][2].','.$i.')">';
            }
            echo "</map>";
        session_abort()
        ?>
    </div>
    <div id='hover'></div>
    <div id="okno">
        <input type="text" name='temp' id='temp'/>
        <button id="save" onclick="Save()">Zapisz temperature</button> 
        <button id="ill" onclick="Ill()">Choroba</button>
        <button id="none" onclick="None()">Brak pomiaru</button>
        <button id="cancel" onclick='Cancel()'>Anuluj</button>
    </div>

    <script>
        const hover = document.getElementById("hover")
        const okno = document.getElementById("okno")
        const val = document.getElementById("temp")
        let d;
        function myFunction(temp,day) {
            hover.style.display = 'block'
            okno.style.display = 'flex'
            val.value = temp  
            d = day + 1
        }
        function Cancel(){
            hover.style.display = 'none'
            okno.style.display = 'none'
            document.location.reload()
        }

        function Ill(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "update.php?status=ill&temp=0&d=" +d, true);
            xmlhttp.send(); 
            Cancel()
        }
        function None(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "update.php?status=none&temp=0&d=" +d, true);
            xmlhttp.send(); 
            Cancel()
        }
        function Save(){
            if(/^36[.]*[0-9]*$/.test(val.value) && parseFloat(val.value)<37){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "update.php?status=normal&temp="+ val.value +"&d=" +d, true);
                xmlhttp.send(); 
                Cancel()
            }
        }

    </script>
    <form action="generatePDf.php" method="post">
        <button type="submit">Generuj pdf</button>
    </form>
    
</body>
</html>