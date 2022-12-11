<?php
    include("hidden.php");
    $s = $_GET["status"];
    $t = $_GET["temp"];
    $d = $_GET["d"];
    $dbh = new PDO("mysql:dbname=wykres;host=127.0.0.1", $user, $passwd);
    $count = $dbh->exec('UPDATE daneWykresu SET state="'.$s.'", temp='.floatval($t).' WHERE day='.(intval($d)));
    header("Location: /wykres");
    exit();
   