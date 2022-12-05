<?php

include('hidden.php');
$mysqli = new mysqli($host, $user, $passwd, 'wykres');

$resultWykres = $mysqli->query('select * from daneWykresu');
$daneWykresu = $resultWykres->fetch_all(MYSQLI_ASSOC);
$width = 800;
$height = 300;
$days = 24;
// print_r($daneWykresu)
if(!empty($_GET['w']) && !empty($_GET['h']) && !empty($_GET['days'])){
        $width = $_GET['w'];
        $height = $_GET['h'];
        $days = $_GET['days'];
}
        // Create the size of image or blank image
        $image = imagecreatetruecolor($width, $height);
        
        // Set the background color of image
        $background_color = imagecolorallocate($image,  255, 255, 255);
            
        // Fill background with above selected color
        imagefill($image, 0, 0, $background_color);

        $textcolor = imagecolorallocate($image, 0, 0, 0);
        $redline = imagecolorallocate($image, 255, 0, 0);
        $blueline = imagecolorallocate($image, 0, 0, 255);
        $greyline = imagecolorallocate($image, 128, 128, 128);


        // Write the string at the top left
        imagestring($image, 4, 0.45 * $width, 0.90 * $height, 'dzien miesiaca', $textcolor);

        imagestringup($image, 4, 0.01 * $width , 0.60 * $height, 'temperatura', $textcolor);

        $sppxchart = 0.1*$width;
        $sppychart = 0.1*$height;
        $eppxchart = 0.1*$width;
        $eppychart = 0.80*$height;

        $spozpxchart = 0.1*$width;
        $spozpychart = 0.8*$height;
        $epozpxchart = 0.9*$width;
        $epozpychart = 0.8*$height;

        imageline($image, $sppxchart, $sppychart, $eppxchart, $eppychart, $textcolor);
        imageline($image, $spozpxchart, $spozpychart, $epozpxchart, $epozpychart, $textcolor);

        $ylinesize = $height - 0.3*$height - 20;
        $xlinesize = $width - 0.2*$width - 20;

        for($i = 1; $i <= 6; $i++){
            $startx = 0.1 * $width;
            $endx = 0.9 * $width;
            $starty = 0.8 * $height - $i * ($ylinesize / 6);
            $endy = 0.8 * $height - $i * ($ylinesize / 6);
            $startTemp = 36 + ($i * 0.2);

            if($i == 5){
                imageline($image, $startx, $starty, $endx, $endy, $redline);
            }else{
                imagedashedline($image, $startx, $starty, $endx, $endy, $textcolor);
            }

            if($startTemp == 36.2){
                imagestring($image, 4, 0.05 * $width, $starty - (0.05 * $starty) * $i * 0.5, $startTemp, $textcolor);
            }else if($startTemp == 37){
                imagestring($image, 4, 0.1 * $width - 25, $starty - (0.05 * $starty) * $i * 0.5, $startTemp, $textcolor);
            }else{
                $startTemp = $startTemp - 36;
                $startTemp = strval($startTemp);
                $startTemp = substr($startTemp, 1);
                imagestring($image, 4, 0.1 * $width - 25, $starty - (0.05 * $starty) * $i * 0.5, $startTemp, $textcolor);
            }    
        }

        for($i = 1; $i <= $days; $i++){
            $startx = 0.1 * $width + $i * ($xlinesize / $days);
            $endx = 0.1 * $width + $i * ($xlinesize / $days);
            $starty = 0.1 * $height;
            $endy = 0.8 * $height;

            imagedashedline($image, $startx, $starty, $endx, $endy, $textcolor);

            imagestring($image, 4, $startx - 5, 0.8 * $height + 10, $i, $textcolor);
        }
        $data = array();
        for($i = 1; $i <= $days; $i++){
            $startx = 0.1 * $width + $i * ($xlinesize / $days);
            $endx = 0.1 * $width + ($i+1) * ($xlinesize / $days);
            $starty = 0.8 * $height - ((($daneWykresu[$i-1]['temp'] -36)/0.2) * ($ylinesize/6));
            $endy = 0.8 * $height - ((($daneWykresu[$i]['temp'] - 36)/0.2) * ($ylinesize/6));

            array_push($data,[$startx,$starty]);

            if($daneWykresu[$i-1]['state'] == "normal" &&  $daneWykresu[$i]['state'] == "normal"){
                imageline($image, $startx, $starty, $endx, $endy, $blueline);
                imagefilledellipse($image, $startx, $starty, $width * 0.01,$width * 0.01,$blueline);
                //imagefill($point, 0,0,$blueline);
            }else if($daneWykresu[$i-1]['state'] == 'none'){
                imagefilledellipse($image, $startx, 0.8*$height, $width * 0.01,$width * 0.01,$greyline);
            }
            else if($daneWykresu[$i-1]['state'] == "ill"){
                imagefilledellipse($image, $startx, 0.8*$height, $width * 0.01,$width * 0.01,$redline);
            }else if($daneWykresu[$i-1]['state'] == "normal"){
                imagefilledellipse($image, $startx, $starty, $width * 0.01,$width * 0.01,$blueline);
            }else if($daneWykresu[$i-1]['state'] == "normal" && $daneWykresu[$i]['state'] != "normal"){
                imagefilledellipse($image, $startx, $starty, $width * 0.01,$width * 0.01,$blueline);
            }
            
        }
        session_start();
$_SESSION["data"] = $data;

header('Content-type: image/png');
     
imagepng($image);

?>

