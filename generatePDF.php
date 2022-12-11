<?php

require_once('library/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);


// set default header data


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor


// set some language-dependent strings (optional)


// -------------------------------------------------------------------

// add a page
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(75);






 $url = 'http://localhost/wykres/img.php';
   

$pdf->Image($url, 10, 15, 190,70, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
$style_bollino = array('width' => 0.25, 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Circle(10, 110, 2, 0, 360, 'DF', $style_bollino, array(210, 0, 0));
$pdf->Text(15, 107.6, 'Choroba');

$pdf->Circle(10, 120, 2, 0, 360, 'DF', $style_bollino, array(150, 150, 150));
$pdf->Text(15, 117.6, 'Brak pomiaru');


// Stretching, position and alignment example
$pdf->Text(120, 97, 'Pomiary');

$pdf->SetFont ('helvetica', '', 8 , '', 'default', true );

$pdf->SetXY(140, 100);

$pdf->Cell(15, 4, 'Dzien', 1, 1, 'C', 0, '', 0);
$pdf->SetXY(155, 100);
$pdf->Cell(40, 4, 'Pomiar', 1, 1, 'C', 0, '', 0);

$y = 104;
$pdf->SetXY(140, $y);
include('hidden.php');
$mysqli = new mysqli($host, $user, $passwd, 'wykres');

$resultWykres = $mysqli->query('select * from daneWykresu');
$daneWykresu = $resultWykres->fetch_all(MYSQLI_ASSOC);

for($i = 0; $i < count($daneWykresu); $i = $i + 1){
    $pdf->Cell(15, 4, $i, 1, 1, 'C', 0, '', 0);
    $pdf->SetXY(155, $y);
    if($daneWykresu[$i]["state"] == "ill"){
        $pdf->Cell(40, 4, "Choroba", 1, 1, 'C', 0, '', 0);
    }else if($daneWykresu[$i]["state"] == "none"){
        $pdf->Cell(40, 4, "Brak pomiaru", 1, 1, 'C', 0, '', 0);
    }else{
        $pdf->Cell(40, 4, $daneWykresu[$i]["temp"], 1, 1, 'C', 0, '', 0);
    }
    $y = $y + 4;
    $pdf->SetXY(140, $y);
}



// -------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_009.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+