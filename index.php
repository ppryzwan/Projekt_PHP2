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
<body>

	<header>
		<nav>
			<div class="headerlogo">
				<a href = "./index.php"><img src="img/logo2.png" alt="Strona startowa"></a>
			</div>
		</nav>
	</header>

<section class="banner">
	<h2>WITAJ</h2>
	
</section>
<div id = "Kontener">

	<div class = "menu">
		<?php 
		if(!isset($_GET['link']))
		{
			echo "<H1>";
			
			$obiekt -> WypiszLogin();
			echo "</H1>";
		}
		else
		{	
	
			if($_GET['link'] == 'zmienhaslo')
			$obiekt->Zmien_Haslo();
			
		}
	?>
	<br>
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
				if($obiekt->Poziom() == 4) 
			{
				echo "<li><a href = './Dodaj_Uzytkownika.php'>Dodaj Uzytkownika</a></li>";
				echo "<li><a href = './Dodaj_Ogloszenie.php'>Dodaj Ogloszenia</a></li>";
				echo "<li><a href = './Dodaj_Klase.php'>Dodaj Klase</a></li>";
				echo "<li><a href = './Przypisz_Klasa_Uczniowie.php'>Przypisz Uczniow do Klasy</a></li>";
				echo "<li><a href = './Przypisz_Klasa_Przedmioty.php'>Przypisz Klase do Przedmiotu</a></li>";
				
			}		
		
		
		?>
			<li><a href = "./index.php?link=zmienhaslo">Zmien haslo</a></li>
			<li><a href = "./logout.php">Wyloguj </a></li>
		</ul>
	</div>

<div class = "ogloszenia">
	<h2> Ogłoszenia </h2> <br>
		<?php
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if($obiekt->Poziom() == 1)
			{

			$sql = "select * from ogloszenia WHERE Typy_Uzytkownikow = 1 or Typy_Uzytkownikow = 4 or Typy_Uzytkownikow =0 order by Data_Ogloszenia desc";
			$zapytanie = $polaczenie->query($sql);
			
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
				echo "<h1>" . $data['Nazwa_Ogloszenia'] . "</h1> <br>";
				echo "<h3>" . $data['Tresc_Ogloszenia'] . "</h3><br>";
				echo "<h3>Data Ogloszenia: " . $data['Data_Ogloszenia'] ." </h3><br>";
				
				}
			}			
				if($obiekt->Poziom() == 2) 
					{

			$sql = "select * from ogloszenia WHERE Typy_Uzytkownikow = 2 or Typy_Uzytkownikow = 4 or Typy_Uzytkownikow =0 order by Data_Ogloszenia desc";
			$zapytanie = $polaczenie->query($sql);
			
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
				echo "<h1>" . $data['Nazwa_Ogloszenia'] . "</h1> <br>";
				echo "<h3>" . $data['Tresc_Ogloszenia'] . "</h3><br>";
				echo "<h3>Data Ogloszenia: " . $data['Data_Ogloszenia'] ." </h3><br>";
				
				}
			}		
			if($obiekt->Poziom() == 3) 
					{

			$sql = "select * from ogloszenia WHERE Typy_Uzytkownikow = 3 or Typy_Uzytkownikow =0 order by Data_Ogloszenia desc";
			$zapytanie = $polaczenie->query($sql);
			
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
				echo "<h1>" . $data['Nazwa_Ogloszenia'] . "</h1> <br>";
				echo "<h3>" . $data['Tresc_Ogloszenia'] . "</h3><br>";
				echo "<h3>Data Ogloszenia: " . $data['Data_Ogloszenia'] ." </h3><br>";
				
				}
			}	
				if($obiekt->Poziom() == 4) 
					{

			$sql = "select * from ogloszenia order by Data_Ogloszenia desc";
			$zapytanie = $polaczenie->query($sql);
			
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
				echo "<h1>" . $data['Nazwa_Ogloszenia'] . "</h1> <br>";
				echo "<h3>" . $data['Tresc_Ogloszenia'] . "</h3><br>";
				echo "<h3>Data Ogloszenia: " . $data['Data_Ogloszenia'] ." </h3><br>";
				
				}
			}	
		
		
		?>


	

</div>



</div>


</html>
