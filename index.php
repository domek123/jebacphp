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
    $url = 'http://localhost/jebacphp/img.php';
    if(!empty($_GET['w']) && !empty($_GET['h']) && !empty($_GET['days'])){
        $url='http://localhost/jabecphp/img.php?w='.$_GET["w"].'&h='.$_GET['h'].'&days='.$_GET["days"];
    }
    echo "<img src='".$url."' usemap='#workmap'/>";
    session_start();
    $s = session_id();
    if($s!=false){
        echo '<map name="workmap">';
        foreach($_SESSION["data"] as $arr){
           
            echo '<area shape="circle" coords="'.$arr[0].','.$arr[1].',5" onclick="myFunction('.$arr[2].')">';
        }
        echo "</map>";
    }
    ?>
    <script>
        function myFunction(temp) {
            alert(temp)
}
    </script>
    <form action="generatePDf.php" method="post">
        <button type="submit">Generuj pdf</button>
    </form>
    
</body>
</html>