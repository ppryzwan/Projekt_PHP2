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
require('klasy.php');
session_start();


$polaczenie = new mysqli('localhost', 'root','','system_ocen');

if (mysqli_connect_errno() !=0)
	{
	echo 'Jest blad polaczenia '.mysqli_connect_error();
	exit;
	}
	
	$login = $_POST['login'];
	$password = md5($_POST['haslo']);
	
	$sql = "Select * from Uzytkownicy where Login = '$login' and Haslo = '$password' ";
	$wynik = $polaczenie -> query($sql);
   //czy liczba wierszy jest rowna 0
	$ilerowsow = $wynik->num_rows;
	
	if($ilerowsow ==  0)
	{
		echo "Nie ma takiego uzytkownika";
		echo "<br><BR>";
		echo "<button><a href = './formularz_logowania.php'> Powrot to formularza logowania </a></button>";
	}
	else
	{		
		$rekord = $wynik -> fetch_assoc();
		//jesli jest adminem rob to
		if($rekord['Typ_Uzytkownika'] == 4)
		{
			$obiekt = new Admin($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
		else if($rekord['Typ_Uzytkownika'] == 3)
		{
			$obiekt = new Nauczyciel($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
			else if($rekord['Typ_Uzytkownika'] == 2)
		{
			$obiekt = new Rodzic($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
			else 
		{
			$obiekt = new Uczen($rekord['ID_Uzytkownika'],$rekord['Login'],$rekord['Haslo']);
			$_SESSION['obiekt'] = $obiekt;
		}
		header("Location: index.php");
			exit;
		
	}
		
	
	
?>
	</div>
	
</div>
</html>