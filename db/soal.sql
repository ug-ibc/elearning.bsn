-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2015 at 05:18 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bsn`
--

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE IF NOT EXISTS `soal` (
  `idSoal_user` int(11) NOT NULL AUTO_INCREMENT,
  `soal` text,
  `pilihan1` tinytext,
  `pilihan2` tinytext,
  `pilihan3` tinytext,
  `pilihan4` tinytext,
  `jenissoal` tinyint(1) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `jawaban` text,
  `jawabanuser` text,
  `idSoal` int(11) DEFAULT NULL,
  `idMateri` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idKursus` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `attempt_date` datetime DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idSoal_user`),
  UNIQUE KEY `idSoal` (`idSoal`,`idGrup_kursus`,`idUser`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
