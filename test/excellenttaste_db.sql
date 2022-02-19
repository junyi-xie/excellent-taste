-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 06 Jan 2021 om 21:18
-- Serverversie: 5.1.37
-- PHP-Versie: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `excellenttaste_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Reservering_ID` int(11) NOT NULL,
  `Menuitem_ID` int(11) NOT NULL,
  `Aantal` int(11) NOT NULL,
  `Geserveerd` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `FK_Menuitem_ID` (`Menuitem_ID`),
  KEY `FK_Reservering_ID` (`Reservering_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`ID`, `Reservering_ID`, `Menuitem_ID`, `Aantal`, `Geserveerd`) VALUES
(11, 10, 28, 3, 1),
(12, 10, 14, 3, 1),
(13, 10, 19, 2, 0),
(14, 10, 43, 5, 0),
(15, 10, 12, 4, 0),
(20, 14, 27, 2, 0),
(21, 14, 21, 3, 0),
(23, 14, 42, 1, 0),
(24, 14, 43, 3, 0),
(30, 5, 32, 3, 0),
(32, 12, 1, 1, 0),
(38, 3, 3, 2, 0),
(39, 3, 15, 3, 0),
(41, 2, 38, 1, 0),
(43, 15, 39, 5, 1),
(54, 2, 35, 3, 1),
(55, 2, 40, 1, 0),
(56, 15, 3, 3, 0),
(60, 19, 12, 3, 0),
(62, 24, 2, 1, 0),
(69, 2, 11, 1, 0),
(70, 2, 36, 1, 0),
(71, 2, 35, 1, 0),
(72, 2, 33, 1, 1),
(73, 2, 33, 1, 0),
(74, 14, 23, 1, 0),
(77, 14, 37, 1, 0),
(78, 14, 35, 3, 0),
(79, 14, 15, 1, 0),
(81, 20, 30, 1, 0),
(82, 25, 6, 4, 0),
(83, 25, 16, 4, 0),
(84, 25, 33, 1, 0),
(85, 25, 29, 1, 0),
(86, 25, 5, 1, 0),
(87, 25, 34, 1, 0),
(88, 25, 38, 1, 0),
(89, 25, 3, 1, 0),
(90, 25, 9, 1, 0),
(91, 25, 27, 1, 0),
(92, 25, 19, 1, 0),
(95, 32, 27, 3, 0),
(96, 1, 37, 2, 0),
(99, 1, 23, 2, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechtcategorien`
--

CREATE TABLE IF NOT EXISTS `gerechtcategorien` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(3) NOT NULL,
  `Naam` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UK_Code` (`Code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerechtcategorien`
--

INSERT INTO `gerechtcategorien` (`ID`, `Code`, `Naam`) VALUES
(1, 'drk', 'Dranken'),
(2, 'hap', 'Hapjes'),
(3, 'hog', 'Hoofdgerechten'),
(4, 'nag', 'Nagerechten'),
(5, 'vog', 'Voorgerechten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerechtsoorten`
--

CREATE TABLE IF NOT EXISTS `gerechtsoorten` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(4) NOT NULL,
  `Naam` varchar(25) NOT NULL,
  `Gerechtcategorie_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Gerechtcategorie_ID` (`Gerechtcategorie_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Gegevens worden uitgevoerd voor tabel `gerechtsoorten`
--

INSERT INTO `gerechtsoorten` (`ID`, `Code`, `Naam`, `Gerechtcategorie_ID`) VALUES
(1, 'ijn', 'Ijs', 4),
(2, 'koh', 'Koude hapjes', 2),
(3, 'kov', 'Koude voorgerechten', 5),
(4, 'mon', 'Mousse', 4),
(5, 'veh', 'Vegetarische gerechten', 3),
(6, 'vih', 'Visgerechten', 3),
(7, 'vlh', 'Vleesgerechten', 3),
(8, 'wah', 'Warme hapjes', 2),
(9, 'wav', 'Warme voorgerechten', 5),
(10, 'wdk', 'Warme dranken', 1),
(11, 'wik', 'Wijnen', 1),
(12, 'bik', 'Bier', 1),
(13, 'fik', 'Frisdrank', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE IF NOT EXISTS `klanten` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(25) NOT NULL,
  `Telefoon` varchar(11) NOT NULL,
  `Email` varchar(128) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `klanten`
--

INSERT INTO `klanten` (`ID`, `Naam`, `Telefoon`, `Email`) VALUES
(1, 'Piet Hein', '0616243524', 'piet.hein@gmail.com'),
(2, 'Yolanthe Snijder', '0633442188', 'yolo@hotmail.nl'),
(3, 'Mata Hari', '0676453212', 'matahari@gmail.com'),
(4, 'Piet Mondriaan', '06989898877', 'piet@mondriaan.nl'),
(5, 'Johnny Jordaan', '0678453425', 'john@jordaan.nl'),
(6, 'Linda de Mol', '0699889988', 'lindademol@demol.com'),
(7, 'Louis Couperus', '0600110023', 'l.couperus@obscura'),
(8, 'Freddy Heinek', '0612123232', 'f.heinenken@heineken.eu'),
(9, 'Jeroen Krabbe', '0699998811', 'jeroenkrabbe@hotmail.com'),
(11, 'Willem Alexander van Bure', '0610000000', 'willem@oranje.nl'),
(12, 'Herman Brood', '0612123333', 'herman@hermanbrood.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menuitems`
--

CREATE TABLE IF NOT EXISTS `menuitems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(4) NOT NULL,
  `Naam` varchar(30) NOT NULL,
  `Prijs` decimal(5,2) NOT NULL,
  `Gerechtsoort_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Gerechtsoort_ID` (`Gerechtsoort_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Gegevens worden uitgevoerd voor tabel `menuitems`
--

INSERT INTO `menuitems` (`ID`, `Code`, `Naam`, `Prijs`, `Gerechtsoort_ID`) VALUES
(1, 'bi1', 'Pilsner', '2.95', 12),
(2, 'bi2', 'Weizen', '3.95', 12),
(3, 'bi3', 'Stender', '2.95', 12),
(4, 'bi4', 'Palm', '3.60', 12),
(5, 'bi5', 'Kasteel donker', '4.85', 12),
(6, 'bi6', 'Brugse Zot', '3.55', 12),
(7, 'bi7', 'Grimbergen dubbel', '3.95', 12),
(8, 'fi1', 'Tonic', '2.95', 13),
(9, 'fi2', 'Seven Up', '2.95', 13),
(10, 'fi3', 'Verse Jus', '3.95', 13),
(11, 'fi4', 'Chaudfontaine rood', '2.75', 13),
(12, 'fi5', 'Chaudfontaine blauw', '2.75', 13),
(13, 'ij1', 'Black Lady', '4.95', 1),
(14, 'ij2', 'Vruchtenijs', '2.95', 1),
(15, 'ko1', 'Portie kaas met mosterd', '4.00', 2),
(16, 'ko2', 'Brood met kruidenboter', '5.00', 2),
(17, 'ko3', 'Portie salami worst', '4.00', 2),
(18, 'kv1', 'Salade met geitenkaas', '4.95', 3),
(19, 'kv2', 'Tonijnsalade', '5.95', 3),
(20, 'kv3', 'Zalmsalade', '5.95', 3),
(21, 'mo1', 'Chocolademousse', '4.95', 4),
(22, 'mo2', 'Vanillemousse', '3.95', 4),
(23, 've1', 'Bonengerecht met diverse groen', '11.95', 5),
(24, 've2', 'Gebakken banana', '10.95', 5),
(25, 'vi1', 'Gebakken makreel', '8.95', 6),
(26, 'vi2', 'Mosselen uit pan', '9.95', 6),
(27, 'vl1', 'Biefstuk in champignonsaus', '11.95', 7),
(28, 'vl2', 'Wienerschnitzel', '9.95', 7),
(29, 'wa1', 'Bitterballetjes met mosterd', '4.25', 8),
(30, 'wd1', 'Koffie', '2.54', 10),
(31, 'wd2', 'Thee', '2.45', 10),
(32, 'wd3', 'Chocolademelk', '2.95', 10),
(33, 'wd4', 'Espresso', '2.45', 10),
(34, 'wd5', 'Cappucino', '2.75', 10),
(35, 'wd6', 'Koffie verkeerd', '2.95', 10),
(36, 'wd7', 'Latte Macchiato', '3.95', 10),
(37, 'wi1', 'Per glas', '3.95', 11),
(38, 'wi2', 'Per fles', '17.95', 11),
(39, 'wi3', 'Seizoenswijn', '3.95', 11),
(40, 'wi4', 'Rode port', '3.60', 11),
(41, 'wv1', 'Tomatensoep', '4.95', 9),
(42, 'wv2', 'Groentesoep', '3.95', 9),
(43, 'wv3', 'Aspergesoep', '4.95', 9),
(44, 'wv4', 'Uiensoep', '3.95', 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reserveringen`
--

CREATE TABLE IF NOT EXISTS `reserveringen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tafel` int(11) NOT NULL,
  `Datum` date NOT NULL,
  `Tijd` time NOT NULL,
  `Klant_ID` int(11) NOT NULL,
  `Aantal` int(11) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '1',
  `Datum_toegevoegd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `FK_Klant_ID` (`Klant_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Gegevens worden uitgevoerd voor tabel `reserveringen`
--

INSERT INTO `reserveringen` (`ID`, `Tafel`, `Datum`, `Tijd`, `Klant_ID`, `Aantal`, `Status`, `Datum_toegevoegd`) VALUES
(1, 1, '2020-07-13', '17:16:00', 1, 5, 1, '2017-01-24 16:05:17'),
(2, 6, '2020-07-13', '17:00:00', 3, 4, 1, '2017-01-24 16:05:17'),
(3, 7, '2020-07-13', '17:15:00', 4, 8, 1, '2017-01-24 16:05:17'),
(4, 2, '2020-07-13', '21:30:00', 5, 2, 1, '2017-01-24 16:05:17'),
(5, 7, '2020-07-13', '19:00:00', 2, 6, 1, '2017-01-24 16:15:56'),
(7, 4, '2020-07-13', '21:30:00', 7, 8, 1, '2017-01-24 20:59:51'),
(10, 8, '2020-07-13', '21:00:00', 9, 5, 1, '2017-01-24 21:40:32'),
(12, 4, '2020-07-13', '22:00:00', 5, 3, 1, '2017-01-25 21:12:02'),
(14, 6, '2020-07-13', '16:00:00', 9, 5, 1, '2017-01-26 09:11:34'),
(15, 2, '2020-07-13', '20:18:00', 1, 5, 1, '2017-09-25 13:00:04'),
(16, 4, '2020-07-13', '20:00:00', 2, 4, 1, '2017-10-23 12:08:25'),
(19, 8, '2020-07-13', '20:18:00', 1, 8, 1, '2017-11-16 16:23:38'),
(20, 8, '2020-07-13', '17:00:00', 1, 15, 1, '2017-11-16 16:24:05'),
(24, 5, '2020-07-13', '17:30:00', 1, 5, 1, '2017-11-16 16:28:53'),
(25, 4, '2020-07-13', '19:00:00', 1, 4, 1, '2017-11-16 16:29:03'),
(26, 2, '2020-07-13', '17:00:00', 1, 3, 1, '2017-11-16 16:29:33'),
(29, 6, '2020-07-13', '19:00:00', 8, 1, 1, '2017-12-13 10:28:52'),
(32, 4, '2020-07-13', '13:30:00', 3, 4, 1, '2017-12-15 15:36:36'),
(33, 7, '2020-07-13', '17:00:00', 5, 6, 1, '2017-12-15 22:28:23'),
(37, 6, '2020-07-13', '15:00:00', 1, 6, 1, '2017-12-16 00:00:22'),
(38, 1, '2020-07-13', '15:00:00', 6, 2, 1, '2020-07-13 10:41:42');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`Reservering_ID`) REFERENCES `reserveringen` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bestellingen_ibfk_2` FOREIGN KEY (`Menuitem_ID`) REFERENCES `menuitems` (`ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `gerechtsoorten`
--
ALTER TABLE `gerechtsoorten`
  ADD CONSTRAINT `gerechtsoorten_ibfk_1` FOREIGN KEY (`Gerechtcategorie_ID`) REFERENCES `gerechtcategorien` (`ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`Gerechtsoort_ID`) REFERENCES `gerechtsoorten` (`ID`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD CONSTRAINT `reserveringen_ibfk_1` FOREIGN KEY (`Klant_ID`) REFERENCES `klanten` (`ID`) ON DELETE CASCADE;