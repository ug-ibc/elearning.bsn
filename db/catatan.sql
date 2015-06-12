-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2015 at 01:39 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_elearningbsn`
--

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE IF NOT EXISTS `catatan` (
`idCatatan` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tipe` tinyint(1) DEFAULT NULL COMMENT '1:qlosarium;2:quote',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Truncate table before insert `catatan`
--

TRUNCATE TABLE `catatan`;
--
-- Dumping data for table `catatan`
--

INSERT INTO `catatan` (`idCatatan`, `judul`, `keterangan`, `tipe`, `create_time`, `n_status`) VALUES
(1, 'ddr3 ', 'jenis ram ', 1, '2015-06-10 14:26:30', 1),
(2, 'lcd', 'sejenis teknologi layar', 1, '2015-06-10 14:27:38', 1),
(4, 'Bill Copeland edit', 'The trouble with not having a goal is that you can spend your life running up and down the field and never score edit', 2, '2015-06-10 17:33:26', 1),
(5, 'iman edit', 'If what youâ€™re doing is not your passion, you have nothing to lose edit', 2, '2015-06-10 17:41:04', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catatan`
--
ALTER TABLE `catatan`
 ADD PRIMARY KEY (`idCatatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catatan`
--
ALTER TABLE `catatan`
MODIFY `idCatatan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
