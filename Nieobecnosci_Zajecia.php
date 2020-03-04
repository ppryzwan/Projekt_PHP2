<?php

require('klasy.php');
session_start();
if (!isset($_SESSION['obiekt'])) 
{
		header("Location: formularz_logowania.php");
		exit;
}
$obiekt = $_SESSION['obiekt'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> 
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<div id = "Kontener">

	<div class = "menu">
		<ul>
			<li><a href = "./index.php">Strona główna</a></li>
			<?php
			if($obiekt->Poziom() == 1)
			{
			
				echo "<li><a href = './Sprawdz_Oceny.php'>Wyswietl Oceny</a></li>";
				echo "<li><a href = './Frekwencja.php'>Wyswietl Obecnosci</a></li>";
				echo "<li><a href = './Konsultacje.php'>Sprawdz Konsultacje</a></li>";
				echo "<li><a href = './Wykaz_Podrecznikow.php'>Sprawdz Wykaz Podrecznikow</a></li>";
				
			}
				
				if($obiekt->Poziom() == 2) 
				{ 
				echo "<li><a href = './Sprawdz_Oceny.php'>Wyswietl Oceny Dziecka</a></li>";
				echo "<li><a href = './Frekwencja.php'>Wyswietl Obecnosci Dziecka</a></li>";
				echo "<li><a href = './Konsultacje.php'>Sprawdz Konsultacje</a></li>";
				echo "<li><a href = './Uwagi.php'>Wyswietl Uwagi Dziecka</a></li>";
				echo "<li><a href = './Wykaz_Podrecznikow.php'>Sprawdz Wykaz Podrecznikow</a></li>";
			
			}
			if($obiekt->Poziom() == 3) 
			{
				echo "<li><a href = './Utworz_Lekcje.php'>Utwórz Lekcje</a></li>";
				echo "<li><a href = './Uwaga.php'>Wstaw Uwage</a></li>";
				echo "<li><a href = './Konsultacje.php'>Dodaj Konsultacje</a></li>";
				echo "<li><a href = './Sprawdz_Oceny.php'>Sprawdz Oceny</a></li>";
				if($obiekt->Wychowawca() >0)
				echo "<li><a href = './Frekwencja.php'>Modul wychowacy</a></li>";
			}		
		
		?>
			<li><a href = "./index.php?link=zmienhaslo">Zmien haslo</a></li>
			<li><a href = "./logout.php">Wyloguj </a></li>
		</ul>
	</div>
<div class = "srodek">
		<?php 
		$obiekt->Dodaj_Nieobecnosci();
	?>
</div>



</div>


</html>
