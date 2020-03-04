<?php
error_reporting(E_ERROR);
require('klasy.php');

require('fpdf/fpdf.php');
session_start();

if (!isset($_SESSION['obiekt']) ) 
{	   
		header("Location: formularz_logowania.php");
		exit;
}
$obiekt = $_SESSION['obiekt'];

$pdf = new FPDF();



$pdf -> AddPage();
$pdf -> SetFont('Arial','B',20);
$pdf -> Cell(75,15,'',0,0);

$pdf -> Cell(50,15,'Spis Podrecznikow dla klasy 1',0,1,'C');
$pdf -> SetFont('Arial','B',14);

$pdf -> SetFillColor(255,255,255);
$halp = 1;

	$pdf -> Cell(60,10,'Tytul podrecznika',1,0,'C');
    $pdf -> Cell(60,10,'Autor podrecznika',1,0,'C');
    $pdf -> Cell(70,10,'Wydawca',1,0,'C');    
    $pdf -> Ln();

    $pdf -> cell(60,10,'Smart Junior',1,0,'C');
	$pdf -> cell(60,10,'H.Q.Mitchell ',1,0,'C');
    $pdf -> cell(70,10,'MM Publications ',1,0,'C');
    $pdf -> Ln();
    
    $pdf -> cell(60,10,'Smileys',1,0,'C');
	$pdf -> cell(60,10,'Virginia Evans',1,0,'C');
    $pdf -> cell(70,10,'EGIS Sp. z o.o.',1,0,'C');
    $pdf -> Ln();

    $pdf -> cell(60,10,'English Quest',1,0,'C');
	$pdf -> cell(60,10,'Jeannette Corbett',1,0,'C');
    $pdf -> cell(70,10,'Macmillan Polska Sp. z o.o.',1,0,'C');
    $pdf -> Ln();

    $pdf -> cell(60,10,'Oxford Explorers',1,0,'C');
	$pdf -> cell(60,10,'Charlotte Covill',1,0,'C');
    $pdf -> cell(70,10,'Oxford University',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'Matematyka z kluczem ',1,0,'C');
	$pdf -> cell(60,10,'Marcin Braun',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'Tajemnice przyrody ',1,0,'C');
	$pdf -> cell(60,10,'Maria Marko-Worlowska',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'Do dziela!',1,0,'C');
	$pdf -> cell(60,10,'Jadwiga Lukas',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'Lekcje z komputerem ',1,0,'C');
	$pdf -> cell(60,10,'Wanda Jochemczyk',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'Jak to dziala? ',1,0,'C');
	$pdf -> cell(60,10,'Marta Labecka',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();
    $pdf -> cell(60,10,'My i historia ',1,0,'C');
	$pdf -> cell(60,10,'Bogumila Olszewska',1,0,'C');
    $pdf -> cell(70,10,'Nowa Era Spolka z o.o.',1,0,'C');
    $pdf -> Ln();

	$pdf -> SetFillColor(255,255,255);


$pdf -> Output();

?>