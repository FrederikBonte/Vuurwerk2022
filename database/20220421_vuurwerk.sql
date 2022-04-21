-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2022 at 07:05 AM
-- Server version: 5.6.34
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vuurwerk`
--
CREATE DATABASE IF NOT EXISTS `vuurwerk` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `vuurwerk`;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `artikelnummer` int(11) NOT NULL,
  `naam` varchar(50) COLLATE utf8_bin NOT NULL,
  `omschrijving` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `prijs` float NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `plaatje` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Plaatje van dit soort vuurwerk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`artikelnummer`, `naam`, `omschrijving`, `prijs`, `deleted`, `plaatje`) VALUES
(168, 'Sterrenregen', NULL, 12.95, 0, 'php12A2.jpg'),
(233, 'astronauten (100)', 'slof van 100 astronauten', 3, 0, 'php72BC.jpg'),
(358, '1000 klapper', 'Deze klapt wel 1000 keer!', 2.75, 0, NULL),
(359, 'romeinse kaars (5)', NULL, 2.95, 0, NULL),
(360, 'sterretje', NULL, 0.45, 0, 'php3B1E.png'),
(364, 'Groot vuurwerk', 'Deze doet heel hard boem!', 3.75, 0, NULL),
(365, 'Rotje (groot)', 'Een heel groot rotje!', 3.97, 1, NULL),
(366, 'Lawinepijl', 'Leuk voor oosternrijk!', 17.83, 0, NULL),
(367, 'Sky of Diamonds', NULL, 49.99, 0, NULL),
(368, 'Golden Kingdom', NULL, 29.99, 0, NULL),
(369, 'King & Queen', NULL, 29.99, 0, NULL),
(370, 'Ironheart', NULL, 24.99, 0, NULL),
(371, 'Excalibur', NULL, 19.99, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bestelling`
--

CREATE TABLE `bestelling` (
  `bestelnummer` int(11) NOT NULL,
  `klantnummer` int(11) NOT NULL,
  `betaald` tinyint(1) NOT NULL DEFAULT '0',
  `afgehandeld` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bestelling`
--

INSERT INTO `bestelling` (`bestelnummer`, `klantnummer`, `betaald`, `afgehandeld`) VALUES
(68839, 2, 1, 0),
(123125, 17, 1, 1),
(123126, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bestelling_artikel`
--

CREATE TABLE `bestelling_artikel` (
  `bestelnummer` int(11) NOT NULL,
  `artikelnummer` int(11) NOT NULL,
  `aantal` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bestelling_artikel`
--

INSERT INTO `bestelling_artikel` (`bestelnummer`, `artikelnummer`, `aantal`) VALUES
(68839, 168, 2),
(68839, 233, 2),
(68839, 358, 3),
(123125, 360, 2);

-- --------------------------------------------------------

--
-- Table structure for table `klant`
--

CREATE TABLE `klant` (
  `klantnummer` int(11) NOT NULL,
  `naam` varchar(50) COLLATE utf8_bin NOT NULL,
  `korting` tinyint(4) DEFAULT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `salt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `klant`
--

INSERT INTO `klant` (`klantnummer`, `naam`, `korting`, `username`, `password`, `salt`) VALUES
(1, 'Frederik Bonte', 10, 'frederik', '1b8b6ba090c8144c7cbaa749bc2b9220', 83935),
(2, 'Piet Verhoef', NULL, 'piet', 'a65925f10fdea53d4a2f7b9e76900243', 72716),
(17, 'Niek Tempert', 15, 'niek', 'e9e877c002954b05e0c76f468c0bf114', 27691),
(18, 'Rinse Karst', NULL, 'rinse', '928e494c54ca347472eb119aa7906075', 89104),
(19, 'Harm Stevelink', 5, 'harm', '98a420b62ad3db9543f8b09eef9b7275', 67969),
(20, 'Henk Pietersen', NULL, 'hepi1966', '70ead999c2abbe0b7bc18669205aedae', 13759);

--
-- Triggers `klant`
--
DELIMITER $$
CREATE TRIGGER `ON_KLANT_INSERT` BEFORE INSERT ON `klant` FOR EACH ROW SET NEW.salt = FLOOR(RAND()*90000)+10000,
NEW.password = MD5(CONCAT(NEW.password, NEW.salt))
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ON_KLANT_UPDATE` BEFORE UPDATE ON `klant` FOR EACH ROW IF (NEW.password!=OLD.password OR OLD.password iS NULL) THEN
  SET NEW.salt = FLOOR(RAND()*90000)+10000,
  NEW.password = MD5(CONCAT(NEW.password, NEW.salt));
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medewerker`
--

CREATE TABLE `medewerker` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) COLLATE utf8_bin NOT NULL,
  `rol` varchar(5) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `salt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `medewerker`
--

INSERT INTO `medewerker` (`id`, `naam`, `rol`, `password`, `salt`) VALUES
(10000, 'Frederik Bonte', 'admin', 'bacf6d251a8789f0a99f264a9d8c7684', 79680);

--
-- Triggers `medewerker`
--
DELIMITER $$
CREATE TRIGGER `ON_MEDEWERKER_INSERT` BEFORE INSERT ON `medewerker` FOR EACH ROW SET NEW.salt = FLOOR(RAND()*90000)+10000,
NEW.password = MD5(CONCAT(NEW.password, NEW.salt))
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ON_MEDEWERKER_UPDATE` BEFORE UPDATE ON `medewerker` FOR EACH ROW IF (NEW.password!=OLD.password OR OLD.password iS NULL) THEN
  SET NEW.salt = FLOOR(RAND()*90000)+10000,
  NEW.password = MD5(CONCAT(NEW.password, NEW.salt));
END IF
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`artikelnummer`);

--
-- Indexes for table `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`bestelnummer`),
  ADD KEY `FK_bestelling_klant` (`klantnummer`);

--
-- Indexes for table `bestelling_artikel`
--
ALTER TABLE `bestelling_artikel`
  ADD PRIMARY KEY (`bestelnummer`,`artikelnummer`),
  ADD KEY `FK_bestelling_artikel_artikel` (`artikelnummer`);

--
-- Indexes for table `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantnummer`),
  ADD UNIQUE KEY `IDX_username` (`username`);

--
-- Indexes for table `medewerker`
--
ALTER TABLE `medewerker`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `artikelnummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT for table `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `bestelnummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123127;

--
-- AUTO_INCREMENT for table `klant`
--
ALTER TABLE `klant`
  MODIFY `klantnummer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `medewerker`
--
ALTER TABLE `medewerker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10001;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `FK_bestelling_klant` FOREIGN KEY (`klantnummer`) REFERENCES `klant` (`klantnummer`);

--
-- Constraints for table `bestelling_artikel`
--
ALTER TABLE `bestelling_artikel`
  ADD CONSTRAINT `FK_bestelling_artikel_artikel` FOREIGN KEY (`artikelnummer`) REFERENCES `artikel` (`artikelnummer`),
  ADD CONSTRAINT `FK_bestelling_artikel_bestelling` FOREIGN KEY (`bestelnummer`) REFERENCES `bestelling` (`bestelnummer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
