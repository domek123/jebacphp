<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $url = 'http://localhost:8080/wykresy/img.php';
    if(!empty($_GET['w']) && !empty($_GET['h']) && !empty($_GET['days'])){
        $url='http://localhost:8080/wykresy/img.php?w='.$_GET["w"].'&h='.$_GET['h'].'&days='.$_GET["days"];
    }
    echo "<img src='".$url."' usemap='#workmap'/>";
    session_start();
    $s = session_id();
    if($s!=false){
        // print_r($_SESSION["data"]);
        echo '<map name="workmap">';
        foreach($_SESSION["data"] as $arr){
            print_r($arr);
            print_r($arr[0]);
            echo("</br>");
            echo '<area shape="circle" coords="'.$arr[0].','.$arr[1].',5" onclick="myFunction()">';
        }
        echo "</map>";
    }
    ?>
    <script>
        function myFunction() {
            alert("XXXDDDD")
}
    </script>
</body>
</html>