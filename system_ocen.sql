-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Sty 2019, 09:43
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `system_ocen`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasa_przedmiot`
--

CREATE TABLE `klasa_przedmiot` (
  `ID` int(11) NOT NULL,
  `ID_Przedmiotu` int(11) NOT NULL,
  `ID_Klasy` int(11) NOT NULL,
  `Rok_Rozpoczecia` int(11) NOT NULL,
  `Rok_Zakonczenia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klasa_przedmiot`
--

INSERT INTO `klasa_przedmiot` (`ID`, `ID_Przedmiotu`, `ID_Klasy`, `Rok_Rozpoczecia`, `Rok_Zakonczenia`) VALUES
(1, 1, 1, 2018, 2019),
(2, 2, 1, 2018, 2019),
(3, 2, 1, 2021, 2022),
(4, 2, 1, 2018, 2019),
(5, 2, 1, 2021, 2022),
(6, 1, 1, 2021, 2022),
(7, 2, 1, 2021, 2022);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasa_uczniowie`
--

CREATE TABLE `klasa_uczniowie` (
  `ID` int(11) NOT NULL,
  `ID_Klasy` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Rok_Rozpoczecia` int(11) NOT NULL,
  `Rok_Zakonczenia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klasa_uczniowie`
--

INSERT INTO `klasa_uczniowie` (`ID`, `ID_Klasy`, `ID_Uzytkownika`, `Rok_Rozpoczecia`, `Rok_Zakonczenia`) VALUES
(1, 1, 3, 2018, 2019),
(2, 1, 5, 2018, 2019),
(4, 1, 5, 2021, 2022),
(5, 2, 3, 2018, 2019),
(6, 3, 3, 2018, 2019);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `ID_Klasy` int(11) NOT NULL,
  `Nazwa_Klasy` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `ID_Wychowawcy` int(11) NOT NULL,
  `Rok` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klasy`
--

INSERT INTO `klasy` (`ID_Klasy`, `Nazwa_Klasy`, `ID_Wychowawcy`, `Rok`) VALUES
(1, '1 Klasa', 4, '2018/2019'),
(2, '2 Klasa', 4, '2018/2019'),
(3, '3 Klasa', 4, '2018/2019');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konsultacje`
--

CREATE TABLE `konsultacje` (
  `ID_Konsultacji` int(11) NOT NULL,
  `ID_Nauczyciela` int(11) NOT NULL,
  `ID_Przedmiotu` int(11) NOT NULL,
  `Data_Konsultacji` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `konsultacje`
--

INSERT INTO `konsultacje` (`ID_Konsultacji`, `ID_Nauczyciela`, `ID_Przedmiotu`, `Data_Konsultacji`) VALUES
(1, 4, 1, '2019-01-17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nieobecnosci`
--

CREATE TABLE `nieobecnosci` (
  `ID_Nieobecnosci` int(11) NOT NULL,
  `ID_Zajecia` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Data_Nieobecnosci` date NOT NULL,
  `Usprawiedliwione` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `nieobecnosci`
--

INSERT INTO `nieobecnosci` (`ID_Nieobecnosci`, `ID_Zajecia`, `ID_Uzytkownika`, `Data_Nieobecnosci`, `Usprawiedliwione`) VALUES
(1, 3, 3, '2019-01-06', 'Tak'),
(2, 4, 3, '2019-01-10', 'Tak'),
(3, 12, 3, '2019-01-24', 'Nie'),
(4, 12, 3, '2019-01-24', 'Nie'),
(5, 12, 5, '2019-01-24', 'Nie'),
(6, 14, 3, '2019-01-21', 'Nie'),
(7, 14, 5, '2019-01-21', 'Nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `ID_Oceny` int(11) NOT NULL,
  `ID_Przedmiotu` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Ocena` int(11) NOT NULL,
  `Data_Wpisania` date NOT NULL,
  `Rok_Rozpoczecia` int(11) NOT NULL,
  `Rok_Zakonczenia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`ID_Oceny`, `ID_Przedmiotu`, `ID_Uzytkownika`, `Ocena`, `Data_Wpisania`, `Rok_Rozpoczecia`, `Rok_Zakonczenia`) VALUES
(1, 1, 3, 4, '2019-01-08', 2018, 2019),
(2, 2, 3, 5, '2019-01-08', 2018, 2019),
(3, 1, 3, 2, '2019-01-08', 2018, 2019),
(4, 2, 5, 4, '2019-01-13', 2018, 2019);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ogloszenia`
--

CREATE TABLE `ogloszenia` (
  `ID_Ogloszenia` int(11) NOT NULL,
  `Nazwa_Ogloszenia` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Typy_Uzytkownikow` int(11) NOT NULL,
  `Tresc_Ogloszenia` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Data_Ogloszenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `ogloszenia`
--

INSERT INTO `ogloszenia` (`ID_Ogloszenia`, `Nazwa_Ogloszenia`, `Typy_Uzytkownikow`, `Tresc_Ogloszenia`, `Data_Ogloszenia`) VALUES
(1, 'Potencjalne Zmiany w Dzienniku', 0, 'Przerwa Techniczna jest planowana na okres zimowy', '2019-01-18'),
(2, 'Aktualizacja', 0, 'Przerwa techniczna zwiazana z aktualizacja oprogramowania', '2019-01-15');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `ID_Przedmiotu` int(11) NOT NULL,
  `Nazwa_Przedmiotu` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `przedmioty`
--

INSERT INTO `przedmioty` (`ID_Przedmiotu`, `Nazwa_Przedmiotu`) VALUES
(1, 'Matematyka'),
(2, 'Przyroda'),
(3, 'Muzyka'),
(4, 'J. Polski'),
(5, 'J. Angielski'),
(6, 'Chemia'),
(7, 'Fizyka'),
(8, 'Geografia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slownik_zajec`
--

CREATE TABLE `slownik_zajec` (
  `ID_SZajecia` int(11) NOT NULL,
  `Nazwa_Zajecia` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `slownik_zajec`
--

INSERT INTO `slownik_zajec` (`ID_SZajecia`, `Nazwa_Zajecia`) VALUES
(1, 'Lekcja_Wychowawcza'),
(2, 'Ćwiczenia'),
(3, 'Sprawdzian');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uwagi`
--

CREATE TABLE `uwagi` (
  `ID_Uwagi` int(11) NOT NULL,
  `ID_Uzytkownika` int(11) NOT NULL,
  `Opis_Uwagi` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Data_Wystawienia_Uwagi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `uwagi`
--

INSERT INTO `uwagi` (`ID_Uwagi`, `ID_Uzytkownika`, `Opis_Uwagi`, `Data_Wystawienia_Uwagi`) VALUES
(1, 3, 'Złe zachowanie', '2019-01-01'),
(2, 3, 'Dobre zachowanie', '2019-01-01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID_Uzytkownika` int(11) NOT NULL,
  `Imie` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Nazwisko` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Login` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Haslo` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Typ_Uzytkownika` int(11) NOT NULL,
  `Rodzic_Uzytkownika` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID_Uzytkownika`, `Imie`, `Nazwisko`, `Login`, `Haslo`, `Typ_Uzytkownika`, `Rodzic_Uzytkownika`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 4, NULL),
(2, 'Rodzic', 'Rodzic', 'Rodzic', '8a738b25b13a2643e54877c6532634de', 2, NULL),
(3, 'Uczen', 'Uczen', 'Uczen', '82e78c35eeea07152bc2d60145c977c8', 1, 2),
(4, 'Nauczyciel', 'Nauczyciel', 'Nauczyciel', 'e4a1fdeecb1329aa6cc9bf8c3328a4e4', 3, NULL),
(5, 'Testowy_Uczen', 'Testowy_Uczen', 'Testowy_Uczen', '7ad3170d7b7e063cbaa82de3e7cd9a72', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zajecia`
--

CREATE TABLE `zajecia` (
  `ID_Zajecia` int(11) NOT NULL,
  `ID_SZajecia` int(11) NOT NULL,
  `ID_Klasy` int(11) NOT NULL,
  `ID_Przedmiotu` int(11) NOT NULL,
  `Temat` varchar(100) COLLATE utf8mb4_polish_ci NOT NULL,
  `Data_Zajec` date NOT NULL,
  `Godzina_Lekcyjna` int(11) NOT NULL,
  `Link_Google` varchar(100) COLLATE utf8mb4_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `zajecia`
--

INSERT INTO `zajecia` (`ID_Zajecia`, `ID_SZajecia`, `ID_Klasy`, `ID_Przedmiotu`, `Temat`, `Data_Zajec`, `Godzina_Lekcyjna`, `Link_Google`) VALUES
(2, 2, 1, 2, 'Wprowadzenie do przyrody', '2019-01-04', 3, NULL),
(3, 2, 1, 1, 'Wprowadzenie do liczb dziesietnych', '2019-01-06', 4, NULL),
(7, 3, 1, 1, 'Sprawdzian z mnożenia', '2019-01-18', 3, NULL),
(8, 2, 3, 7, 'Omówienie fizyki kwantowej', '2019-01-18', 3, NULL),
(9, 2, 3, 6, 'Wstęp do promili', '2019-01-18', 2, NULL),
(10, 2, 1, 3, 'Nauka o nutach', '2019-01-19', 5, NULL),
(11, 2, 2, 8, 'Przedstawienie regionow geograficznych Europy', '2019-01-19', 1, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klasa_przedmiot`
--
ALTER TABLE `klasa_przedmiot`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `klasa_uczniowie`
--
ALTER TABLE `klasa_uczniowie`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`ID_Klasy`);

--
-- Indeksy dla tabeli `konsultacje`
--
ALTER TABLE `konsultacje`
  ADD PRIMARY KEY (`ID_Konsultacji`);

--
-- Indeksy dla tabeli `nieobecnosci`
--
ALTER TABLE `nieobecnosci`
  ADD PRIMARY KEY (`ID_Nieobecnosci`);

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`ID_Oceny`);

--
-- Indeksy dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  ADD PRIMARY KEY (`ID_Ogloszenia`);

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`ID_Przedmiotu`);

--
-- Indeksy dla tabeli `slownik_zajec`
--
ALTER TABLE `slownik_zajec`
  ADD PRIMARY KEY (`ID_SZajecia`);

--
-- Indeksy dla tabeli `uwagi`
--
ALTER TABLE `uwagi`
  ADD PRIMARY KEY (`ID_Uwagi`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID_Uzytkownika`);

--
-- Indeksy dla tabeli `zajecia`
--
ALTER TABLE `zajecia`
  ADD PRIMARY KEY (`ID_Zajecia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `klasa_przedmiot`
--
ALTER TABLE `klasa_przedmiot`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `klasa_uczniowie`
--
ALTER TABLE `klasa_uczniowie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `klasy`
--
ALTER TABLE `klasy`
  MODIFY `ID_Klasy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `konsultacje`
--
ALTER TABLE `konsultacje`
  MODIFY `ID_Konsultacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `nieobecnosci`
--
ALTER TABLE `nieobecnosci`
  MODIFY `ID_Nieobecnosci` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `ID_Oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `ogloszenia`
--
ALTER TABLE `ogloszenia`
  MODIFY `ID_Ogloszenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `ID_Przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `slownik_zajec`
--
ALTER TABLE `slownik_zajec`
  MODIFY `ID_SZajecia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `uwagi`
--
ALTER TABLE `uwagi`
  MODIFY `ID_Uwagi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID_Uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `zajecia`
--
ALTER TABLE `zajecia`
  MODIFY `ID_Zajecia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
