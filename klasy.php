<?php 

class Uczen
{
	private $ID_Usera;
	private $login;
	private $haslo;
	private $poziom = 1;
	private $id_klas;
	
	public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			$data = date("Y");
			$miesiac = date("n");
			if($miesiac >= 6)
			{
				$sql = "select ID_Klasy from klasa_uczniowie WHERE ID_Uzytkownika = $id and Rok_Rozpoczecia <= $data and Rok_Zakonczenia > $data";
				$zapytanie = $polaczenie->query($sql);
				$dane = $zapytanie->fetch(PDO::FETCH_ASSOC);
				$this->id_klas = $dane["ID_Klasy"];
			}
			else
			{
				$sql = "select ID_Klasy from klasa_uczniowie WHERE ID_Uzytkownika = $id and Rok_Rozpoczecia < $data and Rok_Zakonczenia >= $data";
				$zapytanie = $polaczenie->query($sql);
				$dane = $zapytanie->fetch(PDO::FETCH_ASSOC);
				$this->id_klas = $dane["ID_Klasy"];
			}
	}
	
	
	public function getid()
	{
		return $this->ID_Usera;
	
	}
	public function WypiszLogin()
	{
	echo "Zalogowano konto: " . $this->login . "<br>Klasa: " . $this->id_klas;
	}
	
	
	public function Poziom()
	{
		return $this->poziom;
	}
	
	public function Wypisz_Oceny()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$miesiac = date("n");
		$date = date("Y");
		$id_klasy = $this->id_klas;
			if($miesiac >= 6)
				{
			$sql = "select distinct ID_Przedmiotu from klasa_przedmiot where ID_Klasy = $id_klasy and Rok_Rozpoczecia <= $date and Rok_Zakonczenia > $date";
			$zapytanie = $polaczenie->query($sql);
			
			echo "<table border>";
			echo "<th> Nazwa Przedmiotu <th>  Oceny <th> Średnia";
		
			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				$id_przedmiotu = $data['ID_Przedmiotu'];
				$sql = "select * from przedmioty where ID_Przedmiotu = $id_przedmiotu ";
				
				$zapytanie = $polaczenie->query($sql);
				$nazwa_przedmiotu = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "<tr><td>" . $nazwa_przedmiotu['Nazwa_Przedmiotu'] . "<td>";
				
				$sql = "select * from oceny where ID_Przedmiotu = $id_przedmiotu and ID_Uzytkownika = $this->ID_Usera and Rok_Rozpoczecia <= $date and Rok_Zakonczenia > $date";
			
				$zapytanie = $polaczenie->query($sql);
				$liczba_ocen = 0;
				$oceny = 0;
						while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
							{	
							$oceny = $oceny+ $data['Ocena'];
							$liczba_ocen++;
							echo $data['Ocena'] . " ";
							}
								echo "<td>";
							if($liczba_ocen != 0)
							{
								echo round($oceny / $liczba_ocen,2);
							}
							else
							{
								echo "brak ocen";
							}
			}
			echo "</table>";
				}
			else
			{
			
			$sql = "select distinct ID_Przedmiotu from klasa_przedmiot where ID_Klasy = ". $id_klasy . " and Rok_Rozpoczecia < $date and Rok_Zakonczenia >= $date";
			
			$zapytanie = $polaczenie->query($sql);
			echo "<table border>";
			echo "<th> Nazwa Przedmiotu <th>  Oceny <th> Średnia";
		
			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
					
				$id_przedmiotu = $data['ID_Przedmiotu'];
				
				$sql = "select * from przedmioty where ID_Przedmiotu = $id_przedmiotu";
			
				$zapytanie_nazwa = $polaczenie->query($sql);
				$nazwa_przedmiotu = $zapytanie_nazwa->fetch(PDO::FETCH_ASSOC);
				echo "<tr><td>" . $nazwa_przedmiotu['Nazwa_Przedmiotu'] . "<td>";
				
				$sql = "select * from oceny where ID_Przedmiotu = $id_przedmiotu and ID_Uzytkownika = $this->ID_Usera and Rok_Rozpoczecia < $date and Rok_Zakonczenia >= $date";
			
				$zapytanie_oceny = $polaczenie->query($sql);
				$liczba_ocen = 0;
				$oceny = 0;
						while($data1 = $zapytanie_oceny->fetch(PDO::FETCH_ASSOC))
							{	
							$oceny = $oceny+ $data1['Ocena'];
							$liczba_ocen++;
							echo $data1['Ocena'] . " ";
							}
							
								echo "<td>";
							if($liczba_ocen != 0)
							{
								echo round($oceny / $liczba_ocen,2);
							}
							else
							{
								echo "brak ocen";
							}
			
			}
			echo "</table>";
		
	}
	}

	
	public function Obecnosc_Na_Zajeciach($id_zajecia)
	{
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$sql = "Select * from nieobecnosci where ID_Uzytkownika = $this->ID_Usera and ID_Zajecia = $id_zajecia";
		$zapytanie = $polaczenie->query($sql);
		$liczba_row = $zapytanie->rowCount();
		$wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC);
		if($liczba_row == 0)
			return 1; //był na zajeciach
		else
		{
			if($wiersz['Usprawiedliwione'] == "Tak")
				return 2; //usprawiedliwione
			else
				return 0; //nieobecny
			
			
			
		}
	}

	public function Wypisz_Frekwencje($zmienna = 1,$zmienna_datowa ='')
	{
		if($zmienna == 1)
		{
		echo "<form name='czas' method=POST action=''>";
		echo "<label><h1>Wybierz początkowy dzień</h1></label>";		
				echo "<br>";
				echo "<input type='text' id='datepicker' name='datepicker' required>";	
				echo "<br><input type = 'submit' value = 'Wybierz'  name = 'Data'>";
				echo '</form><br>';
		
		
			if(isset($_POST['Data']))
			{
			
				$data_koncowa = DateTime::createFromFormat('m/d/Y', $_POST['datepicker']);
				$data_koncowa = date_modify($data_koncowa,'+6 days');
				$data_koncowa_dobra =  $data_koncowa->format('Y-m-d');
				$data_static = new DateTime($data_koncowa_dobra); 
			
			}
			else
				$data_static = new DateTime(); 
		}
		else
		{
		$data_koncowa = DateTime::createFromFormat('m/d/Y', $zmienna_datowa);
		$data_koncowa = date_modify($data_koncowa,'+6 days');
		$data_koncowa_dobra =  $data_koncowa->format('Y-m-d');
		$data_static = new DateTime($data_koncowa_dobra); 
		
		}
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$date = date_modify($data_static,'-6 days');
		
		$data_do_zapytan = new DateTime(); //tutaj bedzie zmienna z kalendarza 
		$date_do_zapytan = date_modify($data_do_zapytan,'-6 days');
		
		$data_poczatkowa = $date->format('Y-m-d');
		
		$date_1 = new DateTime();
		$data_koncowa = $date_1->format('Y-m-d');
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$godziny_lekcyjne = array('8:00-8:45', '8:50-9:35','9:40-10:25','10:30-11:15','11:20-12:05','12:10-12:55','13:00-13:45','13:50-14:35');
		$pomoc = 1;
		echo "<table border>";
		echo "<th> Godzina Lekcyjna";
		echo "<th>". $data_poczatkowa;
		$date_tytuly = date_modify($data_static,'+1 day');
		echo "<th>" . $date_tytuly->format('Y-m-d');
		for($i = 2;$i <7 ;$i++)
		{
		$date_tytuly = date_modify($data_static,'+1 day');
		echo "<th>" . $date_tytuly->format('Y-m-d');
		
		}
	
		for($j = 1; $j < 9;$j++)
		{
			echo "<tr><td>" . $godziny_lekcyjne[$pomoc - 1];
			$sql = "Select * from zajecia where ID_Klasy = $this->id_klas and Data_Zajec >= '$data_poczatkowa' and Data_Zajec < '$data_koncowa' and Godzina_Lekcyjna = $j order by Data_Zajec";
			
			$zapytanie = $polaczenie->query($sql);
			$date_tytuly = date_modify($data_static,'-6 days');
			$wynik = $zapytanie->fetch(PDO::FETCH_ASSOC);
			for($i = 1; $i <8;$i++)
			{
			
				if($date_tytuly->format('Y-m-d') == $wynik['Data_Zajec'])
				{
				
					$sql_o_zajeciach = "Select * from zajecia z join przedmioty p on p.ID_Przedmiotu=z.ID_Przedmiotu join slownik_zajec sz on sz.ID_SZajecia=z.ID_SZajecia where ID_Zajecia = ".$wynik['ID_Zajecia'];
					
					$dane_o_zajeciach = $polaczenie->query($sql_o_zajeciach);
					$dane = $dane_o_zajeciach->fetch(PDO::FETCH_ASSOC);
					
					echo "<td><p  class='tooltip'  title='Nazwa Przedmiotu: ". $dane['Nazwa_Przedmiotu'] . " Nazwa Zajecia: " . $dane['Nazwa_Zajecia'] ." Temat: " . $dane['Temat'] . "'>";
					if($this->Obecnosc_Na_Zajeciach($wynik['ID_Zajecia']) == 1)
						echo "Obecny</p></td>";
					else if($this->Obecnosc_Na_Zajeciach($wynik['ID_Zajecia']) == 2)
						echo "Usprawiedliwione</p></td>";
					else	
						echo "Nieobecny</p></td>";
						$wynik = $zapytanie->fetch(PDO::FETCH_ASSOC);
				}
				else
				{
				echo "<td>";
					
				}
				$date_tytuly = date_modify($data_static,'+1 day');
			}
			$date_tytuly = date_modify($data_static,'-1 day');
			$pomoc++;
		}

	echo "</table>";
		
		
	}
	
	
	public function Wypisz_Konsultacje()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$miesiac = date("n");
		$date = date("Y");
		$id_klasy = $this->id_klas;
			$dzis = date("Y-m-d");
			if($miesiac >= 6)
				{
			$sql = "select distinct ID_Przedmiotu from klasa_przedmiot where ID_Klasy = $id_klasy and Rok_Rozpoczecia <= $date and Rok_Zakonczenia > $date";
			$zapytanie = $polaczenie->query($sql);
			
			echo "<table border>";
			echo "<th> Nazwa Przedmiotu <th>  Imie i Nazwisko Nauczyciela <th> Data Konsultacji";
		
			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				$id_przedmiotu = $data['ID_Przedmiotu'];
				$sql = "select * from przedmioty where ID_Przedmiotu = $id_przedmiotu ";
				
				$zapytanie = $polaczenie->query($sql);
				$nazwa_przedmiotu = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "<tr><td>" . $nazwa_przedmiotu['Nazwa_Przedmiotu'];
			
				$sql = "select * from konsultacje where Data_Konsultacji >= $dzis";
			
				$zapytanie_konsultacja = $polaczenie->query($sql);
				
						while($row = $zapytanie_konsultacja->fetch(PDO::FETCH_ASSOC))
							{	
							$sql2 = "select * from uzytkownicy where ID_Uzytkownika =" . $row['ID_Nauczyciela'];
							$zapytanie_nauczyciel = $polaczenie->query($sql2);
							$dane = $zapytanie_nauczyciel->fetch(PDO::FETCH_ASSOC);
							echo "<td>" . $dane['Imie'] . " " . $dane['Nazwisko'];
							echo "<td>" . $row['Data_Konsultacji'];
			}
			echo "</table>";
				}
				}
			else
			{
			
			$sql = "select distinct ID_Przedmiotu from klasa_przedmiot where ID_Klasy = ". $id_klasy . " and Rok_Rozpoczecia < $date and Rok_Zakonczenia >= $date";
			
			$zapytanie = $polaczenie->query($sql);
				echo "<table border>";
			echo "<th> Nazwa Przedmiotu <th>  Imie i Nazwisko Nauczyciela <th> Data Konsultacji";
		
			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				$id_przedmiotu = $data['ID_Przedmiotu'];
				$sql = "select * from przedmioty where ID_Przedmiotu = $id_przedmiotu ";
				
				$zapytanie = $polaczenie->query($sql);
				$nazwa_przedmiotu = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "<tr><td>" . $nazwa_przedmiotu['Nazwa_Przedmiotu'];
			
				$sql = "select * from konsultacje where Data_Konsultacji >= $dzis";
			
				$zapytanie_konsultacja = $polaczenie->query($sql);
				
						while($row = $zapytanie_konsultacja->fetch(PDO::FETCH_ASSOC))
							{	
							
							$sql2 = "select * from uzytkownicy where ID_Uzytkownika =" . $row['ID_Nauczyciela'];
							$zapytanie_nauczyciel = $polaczenie->query($sql2);
							$dane = $zapytanie_nauczyciel->fetch(PDO::FETCH_ASSOC);
							echo "<td>" . $dane['Imie'] . " " . $dane['Nazwisko'];
							echo "<td>" . $row['Data_Konsultacji'];
			}
			echo "</table>";
		
		}
		
	}
				}
				
	
		public function Zmien_Haslo()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID_Uzytkownika = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Haslo'] == $haslo)
				{
					
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Haslo = :haslo where ID_Uzytkownika = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
}
	
	

class Nauczyciel
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 3;
		private $Klasa =0;
	
		
		public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$sql = "SELECT * FROM klasy WHERE ID_Wychowawcy = $id order by ID_Klasy desc";
		$zapytanie = $polaczenie->query($sql);
		$dane = $zapytanie->fetch(PDO::FETCH_ASSOC);
		$this->Klasa = $dane["ID_Klasy"];
	}
		public function Poziom()
	{
		return $this->poziom;
	}
		public function Wychowawca()
	{
		return $this->Klasa;
	}
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
	
	
	public function Dodaj_Nieobecnosci()
	{		
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if(isset($_POST['Nieobecnosci']))
			{
				if(isset($_POST['uczniowie']))
				{
				  $nieobecni = $_POST['uczniowie'];
				for($i =0 ; $i<count($nieobecni) ;$i++)
				{
					
					$zapytanie = $polaczenie->prepare("insert into nieobecnosci(ID_Zajecia,ID_Uzytkownika,Data_Nieobecnosci,Usprawiedliwione) values(:id_z,:id_u,:data_zajec,:uspraw)");
					$zapytanie -> bindParam(':id_z',$_POST['id_zajecia']);
					$zapytanie -> bindParam(':id_u',$nieobecni[$i]);
					$zapytanie -> bindParam(':data_zajec',$_POST['data']);
					$zapytanie -> bindValue(':uspraw',"Nie");
					$zapytanie -> execute();
				}
			
		
				header("Location: index.php");
				exit;
				
				}
			}
			
			
			if(isset($_POST['SubmitButton']))
			{	
					$zapytanie = $polaczenie->prepare("insert into zajecia(ID_SZajecia,ID_Klasy,ID_Przedmiotu,Temat,Data_Zajec,Godzina_Lekcyjna,Link_Google) values(:id_sz,:id_k,:id_p,:temat,:data_zajec,:godzina,:link)");
					$zapytanie -> bindParam(':id_p',$_POST['przedmiot']);
					$zapytanie -> bindParam(':id_k',$_POST['klasa']);
					$zapytanie -> bindParam(':id_sz',$_POST['szajecie']);
					$zapytanie -> bindParam(':temat',$_POST['temat']);
					$zapytanie -> bindParam(':data_zajec',$_POST['date']);
					$zapytanie -> bindParam(':godzina',$_POST['godzina_lekcyjna']);
					if(isset($_POST['link_google']))
					$zapytanie -> bindParam(':link',$_POST['link_google']);
					else
					$zapytanie -> bindParam(':link',$null);
					
					$zapytanie -> execute();
					$last_id = $polaczenie->lastInsertId();
		
					echo "<table border>";
					echo "<th>Uczen<th> Zaznacz Nieobecność";
					$miesiac = date("n");
					$date = date("Y");
						if($miesiac >= 6)
							{
								$poczatek_roku = $date;
								$koniec_roku =$date +1;
								$imie_nazwisko_uczniow = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy u join klasa_uczniowie ku on ku.ID_Uzytkownika=u.ID_Uzytkownika WHERE Rok_Rozpoczecia = $poczatek_roku and Rok_Zakonczenia = $koniec_roku and ku.ID_Klasy = " . $_POST['klasa'];
							}
						else
							{	
								$poczatek_roku = $date-1;
								$koniec_roku =$date;
								$imie_nazwisko_uczniow = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy u join klasa_uczniowie ku on ku.ID_Uzytkownika=u.ID_Uzytkownika WHERE Rok_Rozpoczecia = $poczatek_roku and Rok_Zakonczenia = $koniec_roku and ku.ID_Klasy = " . $_POST['klasa'];
						}
					$zapytanie = $polaczenie->query($imie_nazwisko_uczniow);
					echo "<form method=POST action=''>";
					echo "<input type=hidden name=data value=" . $_POST['date'] ." >";
					echo "<input type=hidden name=id_zajecia value=" . $last_id .">";
				while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					echo "<tr><td>" . $wiersz['Cala'] . "<td><input type=checkbox name=uczniowie[] value=". $wiersz['ID_Uzytkownika'] .">";
					}
					echo "</table>";
			echo "<input type=submit name=Nieobecnosci value='Dodaj Nieobecnosci'>";
			echo "</form>";
			}
	}
	public function Utworz_Zajecie()
	{
		$null= null;
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			

			echo "<h2> Utwórz Nowe Zajęcie</h2><br>";
			echo "<form action='./Nieobecnosci_Zajecia.php' method=POST>";
			echo "<label>Temat: </label><br><input type=text name=temat required><br>";
			echo "<label>Przedmiot: </label><br>";
			echo "<select name=przedmiot required>";
			$sql = "select * from przedmioty";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Przedmiotu'] . "'>". $data['Nazwa_Przedmiotu'] ."</option>";
				}
			echo "</select><br>";
			$miesiac = date("n");
			$date = date("Y");
			
				if($miesiac >= 6)						
					$poczatek_roku = $date . "/" . $date +1;
				else
					$poczatek_roku = $date-1 . "/" . $date;
					
		
			echo "<label>Klasa </label><br>";
			echo "<select name=klasa required>";
			
			$sql = "select * from klasy where Rok like '$poczatek_roku'";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Klasy'] . "'>". $data['Nazwa_Klasy'] ."</option>";
				}
			echo "</select><br>";
		echo "<label>Nazwa Zajecia </label><br>";
			echo "<select name=szajecie required>";
			
			$sql = "select * from slownik_zajec";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_SZajecia'] . "'>". $data['Nazwa_Zajecia'] ."</option>";
				}
			echo "</select><br>";
			if($miesiac >= 6)		
			{				
						$poczatek = $date . "-09-01";
						$koniec = $date+1 . "-07-01";
			}
				else
				{
					$poczatek = $date-1 . "-09-01";
					$koniec = $date . "-07-01";
				}
				echo "<label>Data Zajecia </label><br>";
			echo "<input type=date name=date min='" .$poczatek . "' max='" .$koniec . "'><br>";
			echo "<label>Godzina Lekcyjna </label><br>";
			echo "<select name=godzina_lekcyjna required>";
			$godziny_lekcyjne = array('8:00-8:45', '8:50-9:35','9:40-10:25','10:30-11:15','11:20-12:05','12:10-12:55','13:00-13:45','13:50-14:35');
			
			for($i =1 ;$i <=8;$i++)
			{
				echo "<option value='" . $i . "'>". $godziny_lekcyjne[$i-1] ."</option>";
			}
			echo "</select><br>";
				echo "<label>Link Google </label><br>";
				echo "<input type = text name=link_google><br>";
				echo "<input type=submit name=SubmitButton value=Utworz>";
			
	}
	
	
	public function Wstaw_Uwage()
	{
		$null= null;
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if(isset($_POST['SubmitButton']))
			{			
		
					$zapytanie = $polaczenie->prepare("insert into uwagi(ID_Uzytkownika,Opis_Uwagi,Data_Wystawienia_Uwagi) values(:id_u,:opis,:data)");
					$zapytanie -> bindParam(':opis',$_POST['uwaga']);
					$zapytanie -> bindParam(':id_u',$_POST['uczen']);
					$zapytanie -> bindParam(':data',$_POST['date']);
					$zapytanie -> execute();
			}

			echo "<h2> Dodaj Uwage</h2><br>";
			echo "<form action='' method=POST>";
			echo "<label>Opis Uwagi </label><br><input type=text name=uwaga	required><br>";
			echo "<label>Uczen </label><br>";
			echo "<select name=uczen>";
			$sql = "select *,Concat(Imie, ' ', Nazwisko) as Nazwa  from uzytkownicy WHERE Typ_Uzytkownika = 1";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Uzytkownika'] . "'>". $data['Nazwa'] ."</option>";
				}
			echo "</select><br>";
				$miesiac = date("n");
			$date = date("Y");
			if($miesiac >= 6)		
			{				
						$poczatek = $date . "-09-01";
						$koniec = $date+1 . "-07-01";
			}
				else
				{
					$poczatek = $date-1 . "-09-01";
					$koniec = $date . "-07-01";
				}
				echo "<label>Data Uwagi </label><br>";
			echo "<input type=date name=date min='" .$poczatek . "' max='" .$koniec . "' required><br>";
	
				echo "<input type=submit name=SubmitButton value=Utworz>";
			
	}
	
	public function Wstaw_Konsultacje()
	{
		$null= null;
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if(isset($_POST['SubmitButton']))
			{			
		
					$zapytanie = $polaczenie->prepare("insert into konsultacje(ID_Nauczyciela,ID_Przedmiotu,Data_Konsultacji) values(:id_n,:id_p,:data)");
					$zapytanie -> bindParam(':opis',$this->ID_Usera);
					$zapytanie -> bindParam(':id_u',$_POST['przedmiot']);
					$zapytanie -> bindParam(':data',$_POST['date']);
					$zapytanie -> execute();
			}

			echo "<p allign=center> Dodaj Konsultacje</p><br>";
			echo "<form action='' method=POST>";
			echo "<label>Wybierz Przedmiot: </label>";
			echo "<select name=przedmiot required>";
			$sql = "select * from przedmioty";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Przedmiotu'] . "'>". $data['Naazwa_Przedmiotu'] ."</option>";
				}
			echo "</select><br>";
				$miesiac = date("n");
			$date = date("Y");
			$data_pocz = date("Y-m-d");
			if($miesiac >= 6)		
			{				
						$poczatek = $data_pocz;
						$koniec = $date+1 . "-07-01";
			}
				else
				{
					$poczatek = $data_pocz;
					$koniec = $date . "-07-01";
				}
				echo "<label>Data Konsultacji </label>";
			echo "<input type=date name=date min='" .$poczatek . "' max='" .$koniec . "' required><br>";
	
				echo "<input type=submit name=SubmitButton value='Utworz Konsultacje'>";
		
	}
	
	public function Sprawdz_Oceny()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_dzieci = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where Rodzic_Uzytkownika = $this->ID_Usera";
		$zapytanie = $polaczenie->query($imie_nazwisko_dzieci);
	
		echo "<form action ='' method = 'POST'>";
		$miesiac = date("n");
			$date = date("Y");
			
				if($miesiac >= 6)						
					$poczatek_roku = $date . "/" . $date +1;
				else
					$poczatek_roku = $date-1 . "/" . $date;
					
		
			echo "<label>Klasa </label>";
			echo "<select name=klasa required>";
			
			$sql = "select * from klasy where Rok like '$poczatek_roku'";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Klasy'] . "'>". $data['Nazwa_Klasy'] ."</option>";
				}
			echo "</select><br>";
			echo "<label>Przedmiot </label>";
			echo "<select name=przedmiot required>";
			
			$sql = "select * from przedmioty";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Przedmiotu'] . "'>". $data['Nazwa_Przedmiotu'] ."</option>";
				}
			echo "</select><br>";
		
		echo "<br> <input type = 'submit' value = 'Sprawdz'  name = 'SubmitButton'>";
				echo '</form>';
		if(isset($_POST['SubmitButton']))
			{		

			echo "<table border><th>Uczen<th>Oceny<th>Srednia";
			
			$ID_Uzytkownikow = "select distinct o.ID_Uzytkownika from oceny o join klasa_uczniowie ku on ku.ID_Uzytkownika = o.ID_Uzytkownika where ku.ID_Klasy = " .$_POST['klasa'] . " and o.ID_Przedmiotu = ". $_POST['przedmiot'] . " order by o.ID_Uzytkownika";
	
			$zapytanie_1 = $polaczenie->query($ID_Uzytkownikow);
			while($uzytkownik = $zapytanie_1->fetch(PDO::FETCH_ASSOC))
			{
			echo "<tr><td>";
			$imie_uzytkownika = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where ID_Uzytkownika =" . $uzytkownik['ID_Uzytkownika'];
			$wiersz_uz = $polaczenie->query($imie_uzytkownika);
			$imie_uzytkownika_wiersz = $wiersz_uz->fetch(PDO::FETCH_ASSOC);
			echo $imie_uzytkownika_wiersz['Cala'];
			echo "<td>";
			$miesiac = date("n");
			$date = date("Y");
			
			if($miesiac >= 6)
				{
					$sql = "select * from oceny where ID_Przedmiotu = " . $_POST['przedmiot'] ." and ID_Uzytkownika = ". $uzytkownik['ID_Uzytkownika'] ." and Rok_Rozpoczecia <= $date and Rok_Zakonczenia > $date";
				}
				else
				{	
					$sql = "select * from oceny where ID_Przedmiotu = " . $_POST['przedmiot'] ." and ID_Uzytkownika = ". $uzytkownik['ID_Uzytkownika'] ." and Rok_Rozpoczecia < $date and Rok_Zakonczenia >= $date";
				}
				$oceny = $polaczenie->query($sql);
				$liczba_ocen = 0;
				$ocena_do_sredniej = 0;
						while($ocena = $oceny->fetch(PDO::FETCH_ASSOC))
							{	
							$ocena_do_sredniej = $ocena_do_sredniej+ $ocena['Ocena'];
							$liczba_ocen++;
							echo $ocena['Ocena'] . ",";
							}
								echo "<td>";
							if($liczba_ocen != 0)
							{
								echo round($ocena_do_sredniej / $liczba_ocen,2);
							}
							else
							{
								echo "brak ocen";
							}
			}
			echo "</table>";
	}
	}
	
	public function Modul_Wychowacy()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_uczniow = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy u join klasa_uczniowie ku on ku.ID_Uzytkownika=u.ID_Uzytkownika WHERE ku.ID_Klasy =$this->Klasa";
		$zapytanie = $polaczenie->query($imie_nazwisko_uczniow);
			echo "<form action ='' method = 'POST'>";
			echo "<label>Wybierz Ucznia</label><br>";
			echo "<select name = 'ID_Ucznia'>";
		while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value =" . $wiersz['ID_Uzytkownika'] . ">" . $wiersz['Cala'] . "</option>";
				
			}
			echo "</select>";
			echo "<br><label>Wybierz poczatkowy dzien</label>";		
			
				echo "<br>";
				echo "<input type='text' id='datepicker' name='datepicker' required>";	
			echo "<br> <input type = 'submit' value = 'Wybierz'  name = 'SubmitButton'>";
				echo '</form>';
		
		if(isset($_POST['SubmitButton']))
			{			
				$dziecko = "Select *,Concat(Imie,' ',Nazwisko)  as Cala from uzytkownicy where ID_Uzytkownika =" . $_POST['ID_Ucznia'];
				$zapytanie = $polaczenie->query($dziecko);
				$wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC);
				$obiekt_ucznia = new Uczen($wiersz['ID_Uzytkownika'],$wiersz['Login'],$wiersz['Haslo']);
				echo "Wybrany uczen: " . $wiersz['Cala'] . "<br>";
				$obiekt_ucznia -> Wypisz_Frekwencje(2,$_POST['datepicker']);
				//formularz do usprawiedliwienia
				echo "<form action ='' method = 'POST'>";
				echo "<input name ='id' hidden value= " . $wiersz['ID_Uzytkownika'] . ">";
				echo "<br> Usprawiedliwienie:";
				echo "<br><input type=radio name='wybor' id='pojedynczy' value='dzien' ><label for='pojedynczy'> Konkretny dzień </label> <br>";
				$dni_nieusprawiedliwione = "Select * from nieobecnosci where ID_Uzytkownika =". $_POST['ID_Ucznia']." and Usprawiedliwione = 'Nie'"; 
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
				$zapytanie = $polaczenie->query($dni_nieusprawiedliwione);
				echo "<select name = 'Dzien' disabled = 'disabled'>";
				while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					echo "<option value =" . $wiersz['ID_Nieobecnosci'] . ">" . $wiersz['Data_Nieobecnosci'] . "</option>";	
					}
					echo "</select>";

				//od do daty usprawiedliwic	
				echo "<br><input type=radio name='wybor' id='okres' value='okres'>Data<br>";			
				echo "<label for='okres'>Od</label>";
				echo "<br>";
				echo "<input type='text' id='from' name='from' disabled='disable'>";	echo "<br>";
				echo "<label for='okres'>Do</label>";
				echo "<br>";
				echo "<input type='text' id='to' name='to' disabled='disable'>";

				echo "<div>";
				echo "<br> <label > Kliknij jak chcesz usprawiedliwić ucznia!</label> <br><input type = 'submit' value = 'Wykonaj'  name = 'Usprawiedliw'>";
				echo "</div>";
				echo '</form>';
			}
			{
		if(isset($_POST['Usprawiedliw']))
			{			

				if(!isset($_POST['wybor']))
					{
					
						
						$data_poczatkowa = DateTime::createFromFormat('m/d/Y', $_POST['from']);
						$data_poczatkowa_dobra = $data_poczatkowa->format('Y-m-d');

						
						$data_koncowa = DateTime::createFromFormat('m/d/Y', $_POST['to']);
						$data_koncowa_dobra =  $data_koncowa->format('Y-m-d');
						
						
						$usprawiedl = $polaczenie->prepare("update nieobecnosci set Usprawiedliwione = :wartosc WHERE ID_Uzytkownika = :id and Data_Nieobecnosci >= :data_poczatkowa and Data_Nieobecnosci <= :data_koncowa");
						$usprawiedl ->bindParam(':id',$_POST['id']);
						$usprawiedl ->bindParam(':data_poczatkowa',$data_poczatkowa_dobra);
						$usprawiedl ->bindParam(':data_koncowa',$data_koncowa_dobra);
						$usprawiedl ->bindValue(':wartosc',"Tak");
						$usprawiedl ->execute();
						
					}
					else
						{
							$usprawiedl = $polaczenie->prepare('update nieobecnosci set Usprawiedliwione = :wartosc WHERE ID_Nieobecnosci = :id');
						$usprawiedl ->bindParam(':id',$_POST['Dzien']);
						$usprawiedl ->bindValue(':wartosc',"Tak");
						$usprawiedl ->execute();
						
						}

			}
			
				
	}
	}
	
		public function Zmien_Haslo()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID_Uzytkownika = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Haslo'] == $haslo)
				{
					
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Haslo = :haslo where ID_Uzytkownika = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
}


class Admin	
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 4;
	
		
		public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
	}
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
		public function Poziom()
	{
		return $this->poziom;
	}
	
	
	public function Dodaj_Uzytkownika()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		if(isset($_POST['SubmitButton']))
		{
				$zapytanie = $polaczenie->prepare("insert into uzytkownicy(Imie,Nazwisko,Login,Haslo,Typ_Uzytkownika,Rodzic_Uzytkownika) values(:imie,:nazwisko,:login,:haslo,:typ,:rodzic)");
				$zapytanie -> bindParam(':imie',$_POST['imie']);
				$zapytanie -> bindParam(':nazwisko',$_POST['nazwisko']);
				$zapytanie -> bindParam(':login',$_POST['login']);
				$zapytanie -> bindParam(':haslo',md5($_POST['haslo']));
				$zapytanie -> bindParam(':typ',$_POST['typ_uzytkownika']);
				$zapytanie -> bindParam(':rodzic',$_POST['rodzic_uzytkownika']);
				$zapytanie -> execute();
			
		}
		
		
		//formularz do dodania uzytkownika
		echo "<form action'' method=POST>";
		echo "<label>Imie </label><br>";
		echo "<input type=text name=imie required><br>";
			echo "<label>Nazwisko </label><br>";
		echo "<input type=text name=nazwisko required><br>";
			echo "<label>Login</label><br>";
		echo "<input type=text name=login required><br>";
			echo "<label>Haslo </label><br>";
		echo "<input type=password name=haslo required><br>";
			echo "<label>Typ Uzytkownika: </label><br>";
		echo "<select name=typ_uzytkownika required>";
		echo "<option value=1>Uczen</option>";
		echo "<option value=2>Rodzic</option>";
		echo "<option value=3>Nauczyciel</option>";
		echo "<option value=4>Admin</option>";
		echo "</select><br>";
		echo "<label>Rodzic Uzytkownika: </label><br>";
		echo "<select name=rodzic_uzytkownika required>";
		echo "<option value='0' selected>Brak</option>";
		$sql = "select *,Concat(Imie, ' ', Nazwisko) as Nazwa  from uzytkownicy WHERE Typ_Uzytkownika = 2";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Uzytkownika'] . "'>". $data['Nazwa'] ."</option>";
				}
			echo "</select><br>";
		echo "<br><input type=submit name=SubmitButton value=Dodaj>";
		echo "</form>";
	}
	
	public function Dodaj_Ogloszenie()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		if(isset($_POST['SubmitButton']))
		{
				$zapytanie = $polaczenie->prepare("insert into ogloszenia(Nazwa_Ogloszenia,Typy_Uzytkownikow,Tresc_Ogloszenia,Data_Ogloszenia) values(:nazwa,:typ,:tresc,:data)");
				$zapytanie -> bindParam(':nazwa',$_POST['nazwa']);
				$zapytanie -> bindParam(':typ',$_POST['typ_uzytkownika']);
				$zapytanie -> bindParam(':tresc',$_POST['tresc']);
				$zapytanie -> bindParam(':data',$_POST['data']);
				$zapytanie -> execute();
			
		}
		
		
		//formularz do dodania uzytkownika
		echo "<form action'' method=POST>";
		echo "<label>Nazwa Ogloszenia </label><br>";
		echo "<input type=text name=nazwa required><br>";
		echo "<label>Typy Uzytkownikow </label><br>";
		echo "<select name=typ_uzytkownika required>";
		echo "<option value=0>Wszyscy</option>";
		echo "<option value=1>Uczniowie</option>";
		echo "<option value=2>Rodzice</option>";
		echo "<option value=3>Nauczyciele</option>";
		echo "<option value=4>Uczniowie + Rodzice</option>";	
		echo "</select><br>";	
		echo "<label>Tresc Ogłoszenia </label><br>";
		echo "<input type=text name=tresc required><br>";
		echo "<label>Data Ogłoszenia </label><br>";
		echo "<input type=date name=data required><br>";	
		echo "<br><input type=submit name=SubmitButton value=Dodaj>";
		echo "</form>";
	}
	public function Dodaj_Klase()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		if(isset($_POST['SubmitButton']))
		{
				$zapytanie = $polaczenie->prepare("insert into klasy(Nazwa_Klasy,ID_Wychowawcy,Rok) values(:nazwa,:id,:rok)");
				$zapytanie -> bindParam(':nazwa',$_POST['nazwa']);
				$zapytanie -> bindParam(':id',$_POST['wychowawca']);
				$zapytanie -> bindParam(':rok',$_POST['lata']);
				$zapytanie -> execute();
			
		}
		
		
		//formularz do dodania uzytkownika
		echo "<form action'' method=POST>";
		echo "<label>Nazwa Klasy </label><br>";
		echo "<input type=text name=nazwa required><br>";
		echo "<label>Wychowawca Klasy : </label><br>";
		echo "<select name=wychowawca required>";
		$sql = "select *,Concat(Imie, ' ', Nazwisko) as Nazwa  from uzytkownicy WHERE Typ_Uzytkownika = 3";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Uzytkownika'] . "'>". $data['Nazwa'] ."</option>";
				}
			echo "</select><br>";
			
		echo "<label>Lata</label><br>";
		echo "<select name=lata required>";
		echo "<option value=2018/2019>2018/2019</option>";
		echo "<option value=2019/2020>2019/2020</option>";
		echo "<option value=2020/2021>2020/2021</option>";
		echo "<option value=2021/2022>2021/2022</option>";
		echo "<option value=2022/2023>2022/2023</option>";	
		echo "</select><br>";	
		echo "<br><input type=submit name=SubmitButton value=Dodaj>";
		echo "</form>";
	}
	
	public function Przypisz_Klasa_Uczniowie()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if(isset($_POST['SubmitButton']))
		{
				$pomoc = $_POST['uczen'];
				
				$rok_rozpoczecia = substr($_POST['lata'],0,4);
				$rok_zakonczenia = substr($_POST['lata'],5);
				for($i=0;$i<$_POST['liczba'];$i++)
				{
				$zapytanie = $polaczenie->prepare("insert into klasa_uczniowie(ID_Klasy,ID_Uzytkownika,Rok_Rozpoczecia,Rok_Zakonczenia) values(:klasa,:id_u,:rok_r,:rok_z)");
				$zapytanie -> bindParam(':klasa',$_POST['klasa']);
				$zapytanie -> bindParam(':id_u',$pomoc[$i]);
				$zapytanie -> bindParam(':rok_r',$rok_rozpoczecia);
				$zapytanie -> bindParam(':rok_z',$rok_zakonczenia);
				$zapytanie -> execute();
				}
				
				$_POST['LiczbaDzieci'] = null;
		}
		if(isset($_POST['LiczbaDzieci']))
		{
			echo "<form action'' method=POST>";
			echo "<label>Klasa: </label>";
			$sql = "select * from klasy";
				echo "<select name=klasa required>";
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Klasy'] . "'>". $data['Nazwa_Klasy'] ."</option>";
				}
			echo "</select><br>";
			for($i=1;$i<=$_POST['liczba'];$i++)
			{
				echo "<select name='uczen[]' required>";
				$sql = "select *,Concat(Imie, ' ', Nazwisko) as Nazwa  from uzytkownicy WHERE Typ_Uzytkownika = 1";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Uzytkownika'] . "'>". $data['Nazwa'] ."</option>";
				}
			echo "</select><br>";
			}
			echo "<input type=hidden name=liczba value=". $_POST['liczba'] . ">";
			echo "<label>Lata </label><br>";
			echo "<select name=lata required>";
			echo "<option value=2018/2019>2018/2019</option>";
			echo "<option value=2019/2020>2019/2020</option>";
			echo "<option value=2020/2021>2020/2021</option>";
			echo "<option value=2021/2022>2021/2022</option>";
			echo "<option value=2022/2023>2022/2023</option>";	
			echo "</select><br>";	
			echo "<br><input type=submit name=SubmitButton value=Przydziel>";
			echo "</form>";
		}
		else
		{
		

		echo "<form action'' method=POST>";
		echo "<label>Liczba uczniow </label><br>";
		echo "<input type=number min=0 max=30 name=liczba required>";
		echo "<br><input type=submit name=LiczbaDzieci value=Wybierz>";
		echo "</form>";
		}
	}
	
	
	public function Przypisz_Klasa_Przedmiot()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			if(isset($_POST['SubmitButton']))
		{
				$pomoc = $_POST['przedmiot'];
				
				$rok_rozpoczecia = substr($_POST['lata'],0,4);
				$rok_zakonczenia = substr($_POST['lata'],5);
				for($i=0;$i<$_POST['liczba'];$i++)
				{
				$zapytanie = $polaczenie->prepare("insert into klasa_przedmiot(ID_Przedmiotu,ID_Klasy,Rok_Rozpoczecia,Rok_Zakonczenia) values(:id_p,:id_k,:rok_r,:rok_z)");
				$zapytanie -> bindParam(':id_k',$_POST['klasa']);
				$zapytanie -> bindParam(':id_p',$pomoc[$i]);
				$zapytanie -> bindParam(':rok_r',$rok_rozpoczecia);
				$zapytanie -> bindParam(':rok_z',$rok_zakonczenia);
				$zapytanie -> execute();
				}
				
				$_POST['LiczbaPrzedmiotow'] = null;
		}
		if(isset($_POST['LiczbaPrzedmiotow']))
		{
			echo "<form action'' method=POST>";
			echo "<label>Klasa: </label>";
			$sql = "select * from klasy";
				echo "<select name=klasa required>";
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Klasy'] . "'>". $data['Nazwa_Klasy'] ."</option>";
				}
			echo "</select><br>";
			for($i=1;$i<=$_POST['liczba'];$i++)
			{
				echo "<select name='przedmiot[]' required>";
				$sql = "select * from przedmioty";
				
				$zapytanie = $polaczenie->query($sql);
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					echo "<option value='" . $data['ID_Przedmiotu'] . "'>". $data['Nazwa_Przedmiotu'] ."</option>";
				}
			echo "</select><br>";
			}
			echo "<input type=hidden name=liczba value=". $_POST['liczba'] . ">";
			echo "<label>Lata </label><br>";
			echo "<select name=lata required>";
			echo "<option value=2018/2019>2018/2019</option>";
			echo "<option value=2019/2020>2019/2020</option>";
			echo "<option value=2020/2021>2020/2021</option>";
			echo "<option value=2021/2022>2021/2022</option>";
			echo "<option value=2022/2023>2022/2023</option>";	
			echo "</select><br>";	
			echo "<br><input type=submit name=SubmitButton value=Przydziel>";
			echo "</form>";
		}
		else
		{
		

		echo "<form action'' method=POST>";
		echo "<label>Liczba przedmiotow </label><br>";
		echo "<input type=number min=0 max=15 name=liczba required>";
		echo "<br><input type=submit name=LiczbaPrzedmiotow value=Wybierz>";
		echo "</form>";
		}
	}
	
	
		public function Zmien_Haslo()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID_Uzytkownika = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Haslo'] == $haslo)
				{
					
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Haslo = :haslo where ID_Uzytkownika = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}

}


class Rodzic
{
	private $ID_Usera;
	private $login;
	private $haslo;
	private $poziom = 2;
	private $tablica_id_dzieci;
	
	public function __construct($id,$login,$haslo)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$sql = "SELECT * from uzytkownicy Where Rodzic_Uzytkownika = $id";
		$zapytanie = $polaczenie->query($sql);

			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				$tablica_id_dzieci[] = $data['ID_Uzytkownika'];
				
			}
			
	}
	
	
	public function getid()
	{return $this->$ID_Usera;
	}
	public function WypiszLogin()
	{
	echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
	
	
	public function Poziom()
	{
		return $this->poziom;
	}
	public function Wypisz_Oceny_Dzieci()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_dzieci = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where Rodzic_Uzytkownika = $this->ID_Usera";
		$zapytanie = $polaczenie->query($imie_nazwisko_dzieci);
		echo "<label>Wybierz Ucznia</label><br>";
		echo "<form action ='' method = 'POST'>";
		
		echo "<select name = 'ID_Dziecka'>";

		while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value =" . $wiersz['ID_Uzytkownika'] . ">" . $wiersz['Cala'] . "</option>";
				
			}
			echo "</select>";
			echo "<br> <input type = 'submit' value = 'Sprawdz'  name = 'SubmitButton'>";
				echo '</form>';
		
		if(isset($_POST['SubmitButton']))
			{			
		$dziecko = "Select * from uzytkownicy where ID_Uzytkownika =" . $_POST['ID_Dziecka'];
		$zapytanie = $polaczenie->query($dziecko);
		$wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC);
		
		$obiekt_dziecka = new Uczen($wiersz['ID_Uzytkownika'],$wiersz['Login'],$wiersz['Haslo']);
		$obiekt_dziecka -> Wypisz_Oceny();
			}
	}



	public function Wypisz_Frekwencje()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_dzieci = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where Rodzic_Uzytkownika = $this->ID_Usera";
		$zapytanie = $polaczenie->query($imie_nazwisko_dzieci);
		echo "<label>Wybierz Dziecko</label><br>";
			echo "<form action ='' method = 'POST'>";
			echo "<select name = 'ID_Dziecka'>";

		while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value =" . $wiersz['ID_Uzytkownika'] . ">" . $wiersz['Cala'] . "</option>";
				
			}
			echo "</select>";
			echo "<br><label>Wybierz poczatkowy dzien</label>";		
			
				echo "<br>";
				echo "<input type='text' id='datepicker' name='datepicker' required>";	
			echo "<br> <input type = 'submit' value = 'Wybierz'  name = 'SubmitButton'>";
				echo '</form>';

		
		if(isset($_POST['SubmitButton']))
			{			
				$dziecko = "Select *,Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where ID_Uzytkownika =" . $_POST['ID_Dziecka'];
				$zapytanie = $polaczenie->query($dziecko);
				$wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC);
				$obiekt_dziecka = new Uczen($wiersz['ID_Uzytkownika'],$wiersz['Login'],$wiersz['Haslo']);
				echo "Wybrane dziecko: " . $wiersz['Cala'] . "<br>";
				$obiekt_dziecka -> Wypisz_Frekwencje(2,$_POST['datepicker']);
				//formularz do usprawiedliwienia
				echo "<form action ='' method = 'POST'>";
				echo "<input name ='id' hidden value= " . $wiersz['ID_Uzytkownika'] . ">";
				echo "<br> Usprawiedliwienie:";
				echo "<br><input type=radio name='wybor' id='pojedynczy' value='dzien' ><label for='pojedynczy'> Konkretny dzień </label> <br>";
				$dni_nieusprawiedliwione = "Select * from nieobecnosci where ID_Uzytkownika =". $_POST['ID_Dziecka']." and Usprawiedliwione = 'Nie'"; 
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
				$zapytanie = $polaczenie->query($dni_nieusprawiedliwione);
				echo "<select name = 'Dzien' disabled = 'disabled'>";
				while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
					{
					echo "<option value =" . $wiersz['ID_Nieobecnosci'] . ">" . $wiersz['Data_Nieobecnosci'] . "</option>";	
					}
					echo "</select>";

				//od do daty usprawiedliwic	
				echo "<br><input type=radio name='wybor' id='okres' value='okres'>Data<br>";			
				echo "<label for='okres'>Od</label>";
				echo "<br>";
				echo "<input type='text' id='from' name='from' disabled='disable'>";	echo "<br>";
				echo "<label for='okres'>Do</label>";
				echo "<br>";
				echo "<input type='text' id='to' name='to' disabled='disable'>";

				echo "<div>";
				echo "<br> <label > Kliknij jak chcesz usprawiedliwić ucznia!</label> <br><input type = 'submit' value = 'Wykonaj'  name = 'Usprawiedliw'>";
				echo "</div>";
				echo '</form>';
			}
			{
		if(isset($_POST['Usprawiedliw']))
			{			

				if(!isset($_POST['wybor']))
					{
					
						
						$data_poczatkowa = DateTime::createFromFormat('m/d/Y', $_POST['from']);
						$data_poczatkowa_dobra = $data_poczatkowa->format('Y-m-d');

						
						$data_koncowa = DateTime::createFromFormat('m/d/Y', $_POST['to']);
						$data_koncowa_dobra =  $data_koncowa->format('Y-m-d');
						
						
						$usprawiedl = $polaczenie->prepare("update nieobecnosci set Usprawiedliwione = :wartosc WHERE ID_Uzytkownika = :id and Data_Nieobecnosci >= :data_poczatkowa and Data_Nieobecnosci <= :data_koncowa");
						$usprawiedl ->bindParam(':id',$_POST['id']);
						$usprawiedl ->bindParam(':data_poczatkowa',$data_poczatkowa_dobra);
						$usprawiedl ->bindParam(':data_koncowa',$data_koncowa_dobra);
						$usprawiedl ->bindValue(':wartosc',"Tak");
						$usprawiedl ->execute();
						
					}
					else
						{
							$usprawiedl = $polaczenie->prepare('update nieobecnosci set Usprawiedliwione = :wartosc WHERE ID_Nieobecnosci = :id');
						$usprawiedl ->bindParam(':id',$_POST['Dzien']);
						$usprawiedl ->bindValue(':wartosc',"Tak");
						$usprawiedl ->execute();
						
						}

			}
			
				
	}
	}
		public function Wypisz_Konsultacje()
		{
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_dzieci = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where Rodzic_Uzytkownika = $this->ID_Usera";
		$zapytanie = $polaczenie->query($imie_nazwisko_dzieci);
			echo "<form action ='' method = 'POST'>";
			echo "<select name = 'ID_Dziecka'>";

		while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value =" . $wiersz['ID_Uzytkownika'] . ">" . $wiersz['Cala'] . "</option>";
				
			}
			echo "</select>";
			echo "<br> <input type = 'submit' value = 'Wybierz'  name = 'SubmitButton'>";
				echo '</form>';
		
		if(isset($_POST['SubmitButton']))
			{	
			$dziecko = "Select * from uzytkownicy where ID_Uzytkownika =" . $_POST['ID_Dziecka'];
				$zapytanie = $polaczenie->query($dziecko);
				$wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC);
				$obiekt_dziecka = new Uczen($wiersz['ID_Uzytkownika'],$wiersz['Login'],$wiersz['Haslo']);
				$obiekt_dziecka -> Wypisz_Konsultacje();
		
			}
		}

		public function Wypisz_Uwagi()
		{
				$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
		$imie_nazwisko_dzieci = "Select *, Concat(Imie,' ',Nazwisko) as Cala from uzytkownicy where Rodzic_Uzytkownika = $this->ID_Usera";
		$zapytanie = $polaczenie->query($imie_nazwisko_dzieci);
			echo "<form action ='' method = 'POST'>";
			echo "<label>Wybierz Dziecko</label><br>";
			echo "<select name = 'ID_Dziecka'>";

		while($wiersz = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<option value =" . $wiersz['ID_Uzytkownika'] . ">" . $wiersz['Cala'] . "</option>";
				
			}
			echo "</select>";
			echo "<br> <input type = 'submit' value = 'Wybierz'  name = 'SubmitButton'>";
				echo '</form>';
		
		if(isset($_POST['SubmitButton']))
			{	
			$miesiac = date("n");
			$date = date("Y");
			$dzis = date("Y-m-d");
				if($miesiac >= 6)
					{
						
						$poczatek_roku = $date . "-09-01";
						$sql = "select * FROM uwagi WHERE ID_Uzytkownika = " . $_POST['ID_Dziecka'] ." and Data_Wystawienia_Uwagi >= $poczatek_roku";
						$zapytanie = $polaczenie->query($sql);
				
					}
				else
				{
					$data_przed = $date - 1;
					$poczatek_roku = $data_przed . "-09-01";
						$sql = "select * FROM uwagi WHERE ID_Uzytkownika =".  $_POST['ID_Dziecka'] ." and Data_Wystawienia_Uwagi >= $poczatek_roku";
						$zapytanie = $polaczenie->query($sql);
				}
		
			while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
			{
				echo "<br><h1>" . $data['Opis_Uwagi'] . "</h1><br><p> Data Wystawienia Uwagi: ". $data['Data_Wystawienia_Uwagi'] . "</br>";
			}
			}
		
	}
			
			
		
	
		
		public function Zmien_Haslo()
	{
		$polaczenie = new PDO('mysql:host=localhost;dbname=system_ocen','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID_Uzytkownika = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Haslo'] == $haslo)
				{
					
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Haslo = :haslo where ID_Uzytkownika = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
	}
	

	

?>
