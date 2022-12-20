<?php
session_start();
if(isset($_GET["pos"])){
    $tab = $_SESSION["data"];
    if($_SESSION['player'] == 1){
        $tab[intval($_GET["pos"])] = 1;
        $_SESSION['player'] = 2;
    }else{
        $tab[intval($_GET["pos"])] = 2;
        $_SESSION['player'] = 1;
    }
    $_SESSION["data"]=$tab;
    if(handleResultValidation($tab)){
        $_SESSION["game"] = "end";
    }

}

function handleResultValidation($tab) {
    $winningConditions = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];
    $roundWon = false;
    for ($i = 0; $i <= 7; $i++) {
        $winCondition = $winningConditions[$i];
        $a = $tab[$winCondition[0]];
        $b = $tab[$winCondition[1]];
        $c = $tab[$winCondition[2]];
        if ($a == 0 || $b == 0 || $c == 0) {
            continue;
        }
        if ($a == $b && $b == $c) {
            $roundWon = true;
            break;
        }
    }
    return $roundWon;
}
if($_SESSION["game"] == "play"){
    print_r('play '.json_encode($_SESSION["data"])." ". $_SESSION["player"]);
}else if($_SESSION["game"] == "end"){
    print_r("end ".json_encode($_SESSION["data"])." ". $_SESSION["player"]);
}else if($_SESSION["game"] == "wait"){
    print_r("wait ".json_encode($_SESSION["data"])." ok");

}





