-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 06:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spet_zevci1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cenik`
--

CREATE TABLE `cenik` (
  `id_cenik` int(11) NOT NULL,
  `storitev` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `cena` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obvestila`
--

CREATE TABLE `obvestila` (
  `id_obvestila` int(11) NOT NULL,
  `vsebina` text NOT NULL,
  `dat_objave` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `obvestila`
--

INSERT INTO `obvestila` (`id_obvestila`, `vsebina`, `dat_objave`) VALUES
(1, 'Serbus', '2025-06-28');

-- --------------------------------------------------------

--
-- Table structure for table `ocene_voznika`
--

CREATE TABLE `ocene_voznika` (
  `id_ocena` int(11) NOT NULL,
  `ocena` int(11) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `dat_ocene` datetime DEFAULT NULL,
  `id_uporabnik` int(11) DEFAULT NULL,
  `id_voznik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `placila`
--

CREATE TABLE `placila` (
  `id_placila` int(11) NOT NULL,
  `znesek` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL,
  `dat_placila` datetime NOT NULL,
  `nacin_placila` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prevoz`
--

CREATE TABLE `prevoz` (
  `id_prevoz` int(11) NOT NULL,
  `zacetek` varchar(100) NOT NULL,
  `cilj` varchar(100) NOT NULL,
  `datum` date NOT NULL,
  `ura` time NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `opis` text DEFAULT NULL,
  `id_vozila` int(11) DEFAULT NULL,
  `id_voznik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `id_rezervacija` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `id_uporabnik` int(11) DEFAULT NULL,
  `id_prevoz` int(11) DEFAULT NULL,
  `id_placila` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uporabnik`
--

CREATE TABLE `uporabnik` (
  `id_uporabnik` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `ime` varchar(20) NOT NULL,
  `priimek` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `geslo` varchar(255) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `datum_reg` datetime NOT NULL,
  `id_obvestila` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `uporabnik`
--

INSERT INTO `uporabnik` (`id_uporabnik`, `admin`, `ime`, `priimek`, `email`, `geslo`, `telefon`, `datum_reg`, `id_obvestila`) VALUES
(1, 0, 'Živa', '', '', '', NULL, '0000-00-00 00:00:00', NULL),
(2, 0, 'Živa', '', '', '', NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vozila`
--

CREATE TABLE `vozila` (
  `id_vozila` int(11) NOT NULL,
  `znamka` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `registracija` varchar(20) NOT NULL,
  `st_sedezev` int(11) NOT NULL,
  `barva` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voznik`
--

CREATE TABLE `voznik` (
  `id_voznik` int(11) NOT NULL,
  `ime` varchar(20) NOT NULL,
  `priimek` varchar(20) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

-- Tabela zgodovina_prevozov je IZBRISANA.

-- --------------------------------------------------------

-- Nova tabela za podatke o podjetju

CREATE TABLE `podjetje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(255) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `telefon` varchar(50),
  `email` varchar(100),
  `davcna_stevilka` varchar(50),
  `maticna_stevilka` varchar(50),
  `odgovorna_oseba` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO `podjetje` (`ime`, `naslov`, `telefon`, `email`, `davcna_stevilka`, `maticna_stevilka`, `odgovorna_oseba`) VALUES
('Dynamic OTransp0rt1 d.o.o.', 'Glavna cesta 123, 3320 Velenje, Slovenija', '+386 40 123 456', 'info@otransport1.si', 'SI12345678', '9876543', 'Živa Zupanc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cenik`
--
ALTER TABLE `cenik`
  ADD PRIMARY KEY (`id_cenik`);

--
-- Indexes for table `obvestila`
--
ALTER TABLE `obvestila`
  ADD PRIMARY KEY (`id_obvestila`);

--
-- Indexes for table `ocene_voznika`
--
ALTER TABLE `ocene_voznika`
  ADD PRIMARY KEY (`id_ocena`);

--
-- Indexes for table `placila`
--
ALTER TABLE `placila`
  ADD PRIMARY KEY (`id_placila`);

--
-- Indexes for table `prevoz`
--
ALTER TABLE `prevoz`
  ADD PRIMARY KEY (`id_prevoz`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`id_rezervacija`);

--
-- Indexes for table `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`id_uporabnik`);

--
-- Indexes for table `vozila`
--
ALTER TABLE `vozila`
  ADD PRIMARY KEY (`id_vozila`);

--
-- Indexes for table `voznik`
--
ALTER TABLE `voznik`
  ADD PRIMARY KEY (`id_voznik`);

--
-- Indexes for table `podjetje`
--
ALTER TABLE `podjetje`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cenik`
--
ALTER TABLE `cenik`
  MODIFY `id_cenik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `obvestila`
--
ALTER TABLE `obvestila`
  MODIFY `id_obvestila` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ocene_voznika`
--
ALTER TABLE `ocene_voznika`
  MODIFY `id_ocena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `placila`
--
ALTER TABLE `placila`
  MODIFY `id_placila` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prevoz`
--
ALTER TABLE `prevoz`
  MODIFY `id_prevoz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `id_rezervacija` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `id_uporabnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vozila`
--
ALTER TABLE `vozila`
  MODIFY `id_vozila` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voznik`
--
ALTER TABLE `voznik`
  MODIFY `id_voznik` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `podjetje`
--
ALTER TABLE `podjetje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
