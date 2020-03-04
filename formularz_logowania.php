<!DOCTYPE html>
<html>
	<head>
		<link rel="Stylesheet" type="text/css" href="style.css" />
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);
	
      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Konto', 'Liczba'],
		  		<?php
				
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		

			$sql = "select count(*) as liczba,Typ_Uzytkownika from uzytkownicy group by Typ_Uzytkownika order by Typ_Uzytkownika";
			$zapytanie = $polaczenie->query($sql);

				$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "['Uczen'," . $data['liczba'] . "],";
					$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "['Rodzic'," . $data['liczba'] . "],";
					$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "['Nauczyciel'," . $data['liczba'] . "],";
					$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "['Admin'," . $data['liczba'] . "]";
				?>
    
        ]);

        var options = {
          title: 'Liczba Kont',
          width: 800,
          legend: { position: 'none' },
          chart: { title: 'Liczba Kont',
                   subtitle: 'Liczba Kont  w naszym eDzienniku' },
          bars: 'horizontal', 
          axes: {
            x: {
              0: { side: 'top', label: 'Liczba'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%"},
		  colors:['red','#004411']
		  
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
	  </script>
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
	<h2>LOGOWANIE</h2>
</section>


<div id = "Kontener" >
	<div class = "logowanie">

	<h2> Formularz Logowania </h2>


		<form action ="./logowanie.php" method = "POST">
			<gachi>Login:</gachi>
			<br>
		<input type = "text" name = "login">
			<br>
			<gachi>Haslo:</gachi>
			<br>
		<input type = "password" name = "haslo">
			<br>
		<button type = "submit">Zaloguj sie </button>
		</form>

		<!-- <a href = "./formularz_rejestracji.php"> Zarejestruj sie</a> -->
	</div>
	
	<div class = "ogloszenia">
	<h2> Ogłoszenia </h2> <br>
	<h1>Przekroczyliśmy magiczną barierę 5 kont!</h3>
	<h3>Nastał ten dzień. Nasz dziennik z dnia na dzień jest coraz lepszy! Dziękujemy! <br><br></h3>
	<div id="top_x_div" style="width: 750px; height: 400px; margin: 30px;"></div>
	<br>
	
		<?php
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		

			$sql = "select * from ogloszenia WHERE Typy_Uzytkownikow =0 order by Data_Ogloszenia desc";
			$zapytanie = $polaczenie->query($sql);
			
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
				echo "<h1>" . $data['Nazwa_Ogloszenia'] . "</h1> <br>";
				echo "<h3>" . $data['Tresc_Ogloszenia'] . "</h3><br>";
				echo "<h3>Data Ogloszenia: " . $data['Data_Ogloszenia'] ." </h3><br>";
				
				}
		?>
	</div>
</div>

</html>
