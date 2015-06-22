-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2015 at 09:25 PM
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
-- Table structure for table `tbl_quiz_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_quiz_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maxSoal` int(11) NOT NULL,
  `kategoriBaik` varchar(20) DEFAULT NULL,
  `kategoriCukup` varchar(20) DEFAULT NULL,
  `kategoriKurang` varchar(20) DEFAULT NULL,
  `waktu` int(11) NOT NULL,
  `idGroupKursus` int(11) NOT NULL DEFAULT '0',
  `idKursus` int(11) NOT NULL DEFAULT '0',
  `data` varchar(255) DEFAULT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idGroupKursus` (`idGroupKursus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
