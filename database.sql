-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Vært: mysql32.unoeuro.com
-- Genereringstid: 21. 05 2023 kl. 13:48:49
-- Serverversion: 5.7.41-44-log
-- PHP-version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `implex_dk_db_ucrs`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Elev`
--

CREATE TABLE `Elev` (
  `ID` int(11) NOT NULL,
  `Kode` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `Elev`
--

INSERT INTO `Elev` (`ID`, `Kode`) VALUES
(87, 'pete199b'),
(88, 'patr8503'),
(89, 'si281c');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Fest`
--

CREATE TABLE `Fest` (
  `ID` int(11) NOT NULL,
  `Navn` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `Fest_start` date NOT NULL,
  `Billet_start` datetime NOT NULL,
  `Billet_slut` datetime NOT NULL,
  `Drink_billetter` int(11) NOT NULL,
  `BilledeID` int(11) NOT NULL DEFAULT '1',
  `PrisID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `Fest`
--

INSERT INTO `Fest` (`ID`, `Navn`, `Aktiv`, `Fest_start`, `Billet_start`, `Billet_slut`, `Drink_billetter`, `BilledeID`, `PrisID`) VALUES
(56, 'Mads Langer', 0, '2023-05-17', '2023-05-05 22:47:46', '2023-05-13 22:47:50', 12, 16, 105),
(57, 'rock', 0, '2023-05-02', '2023-05-03 23:09:12', '2023-05-15 23:09:14', 0, 16, 105),
(58, 's', 0, '2023-05-03', '2023-05-01 23:09:20', '2023-05-02 23:09:22', 0, 16, 105),
(66, 'Pede', 1, '2023-05-25', '2023-05-16 21:57:00', '2023-05-25 21:57:00', 100, 25, 113);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `FestDeltager`
--

CREATE TABLE `FestDeltager` (
  `ID` int(11) NOT NULL,
  `Elev_navn` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Klasse` text CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `Billet_pris` int(11) NOT NULL,
  `Drink_billetter` int(11) NOT NULL,
  `FestID` int(11) NOT NULL,
  `ElevID` int(11) DEFAULT NULL,
  `Deltog` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `FestDeltager`
--

INSERT INTO `FestDeltager` (`ID`, `Elev_navn`, `Email`, `Klasse`, `Billet_pris`, `Drink_billetter`, `FestID`, `ElevID`, `Deltog`) VALUES
(8, 'Lars', 'Lars@ucrs.dk', 'HHX22b', 50, 0, 56, NULL, 1),
(9, 'Lone', 'Lone@ucrs.dk', 'HTX21', 50, 0, 57, NULL, 1),
(10, 'Karl', 'Karl@ucrs.dk', 'HHX21a', 40, 1, 57, NULL, 1),
(11, 'Signe', 'Signe@ucrs.dk', 'HTX22', 50, 0, 57, NULL, 0),
(12, 'Lars', 'Lars@ucrs.dk', 'HHX22b', 50, 0, 56, NULL, 0),
(66, 'Patrick', 'patrick.2000@live.dk', 'hhx22b', 0, 0, 56, NULL, 1),
(70, 'Patrick', 'patrick.2000@live.dk', 'hhx22b', 2, 0, 56, NULL, 0),
(75, 'Patrick', 'patrick.2000@live.dk', '218', 3000, 0, 66, 87, 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Image`
--

CREATE TABLE `Image` (
  `ID` int(11) NOT NULL,
  `Navn` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `Image`
--

INSERT INTO `Image` (`ID`, `Navn`) VALUES
(1, 'Standard.webp'),
(16, 'Standard.webp'),
(17, '1683663833'),
(18, '1683670454pexels-cottonbro-studio-3171837.jpg'),
(19, '1683671223pexels-cottonbro-studio-3171837.jpg'),
(20, '1683671501pexels-cottonbro-studio-3171837.jpg'),
(21, '1683672472Studieplan-Hfe-Olivia.jpg'),
(22, '1683703227pexels-cottonbro-studio-3171837.jpg'),
(23, ' Standard.webp'),
(24, 'Standard.webp'),
(25, '1684353482ezgif-5-6d2afe2517.gif');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Login`
--

CREATE TABLE `Login` (
  `ID` int(11) NOT NULL,
  `Brugernavn` varchar(255) NOT NULL,
  `Kode` varchar(255) NOT NULL,
  `Rolle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `Login`
--

INSERT INTO `Login` (`ID`, `Brugernavn`, `Kode`, `Rolle`) VALUES
(2, 'Admin', '$2y$10$keHds75n8hAADQYnOwWiDOHUAI.1duX6VTAjD0qwgHFtt/fuFPIvi', 'Super'),
(7, 'qr', '$2y$10$sXwSflGVg/LFWQP9vr/UVeMWROhCQpFcBhBlYtsIzTnuoqp1NIbPC', 'QR');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `Pris`
--

CREATE TABLE `Pris` (
  `ID` int(11) NOT NULL,
  `Tilbuds_pris` int(11) NOT NULL,
  `Tilbuds_dage` int(11) NOT NULL,
  `Standard_pris` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `Pris`
--

INSERT INTO `Pris` (`ID`, `Tilbuds_pris`, `Tilbuds_dage`, `Standard_pris`) VALUES
(105, 40, 2, 50),
(106, 40, 2, 50),
(107, 1, 1, 1),
(108, 78, 677, 7),
(109, 4, 1, 5),
(110, 0, 0, 50),
(111, 40, 2, 50),
(112, 40, 2, 50),
(113, 3000, 10, 4500);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `Elev`
--
ALTER TABLE `Elev`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `Fest`
--
ALTER TABLE `Fest`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Pris` (`PrisID`) USING BTREE,
  ADD KEY `Fest_ibfk_2` (`BilledeID`);

--
-- Indeks for tabel `FestDeltager`
--
ALTER TABLE `FestDeltager`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FestDeltager_ibfk_2` (`ElevID`),
  ADD KEY `FestDeltager_ibfk_1` (`FestID`);

--
-- Indeks for tabel `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks for tabel `Pris`
--
ALTER TABLE `Pris`
  ADD PRIMARY KEY (`ID`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `Elev`
--
ALTER TABLE `Elev`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Tilføj AUTO_INCREMENT i tabel `Fest`
--
ALTER TABLE `Fest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Tilføj AUTO_INCREMENT i tabel `FestDeltager`
--
ALTER TABLE `FestDeltager`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Tilføj AUTO_INCREMENT i tabel `Image`
--
ALTER TABLE `Image`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tilføj AUTO_INCREMENT i tabel `Login`
--
ALTER TABLE `Login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tilføj AUTO_INCREMENT i tabel `Pris`
--
ALTER TABLE `Pris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `Fest`
--
ALTER TABLE `Fest`
  ADD CONSTRAINT `Fest_ibfk_1` FOREIGN KEY (`PrisID`) REFERENCES `Pris` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fest_ibfk_2` FOREIGN KEY (`BilledeID`) REFERENCES `Image` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `FestDeltager`
--
ALTER TABLE `FestDeltager`
  ADD CONSTRAINT `FestDeltager_ibfk_1` FOREIGN KEY (`FestID`) REFERENCES `Fest` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FestDeltager_ibfk_2` FOREIGN KEY (`ElevID`) REFERENCES `Elev` (`ID`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
