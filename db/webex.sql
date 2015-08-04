-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2015 at 11:20 
-- Server version: 5.6.21
-- PHP Version: 5.6.3

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
-- Table structure for table `webex`
--

CREATE TABLE IF NOT EXISTS `webex` (
`id_webex` int(11) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `speaker` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `schedule` date NOT NULL,
  `meeting_number` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webex`
--

INSERT INTO `webex` (`id_webex`, `topic`, `speaker`, `picture`, `cover`, `schedule`, `meeting_number`, `status`) VALUES
(1, 'sad', 'sad', 'b3a9473231aec9a2ea46071a17fb3175.jpeg', '295abd1c04cde29c32c75c72ead4ddff.png', '2015-07-27', 'sadasd', 2),
(2, 'Pemantapan', 'Komang Anom Budi Utama', 'b5ca7dd5222a53cf2f7188e8b49edea0.jpg', '95a1fc7ea528fbc6ace01a9e75a054ee.jpg', '2015-07-15', '1234', 1),
(3, 'zxc', 'xzc', 'ba5f534302422076ae41994a4c30372b.jpg', 'e3abf180b6cd0e713c5885e731fe1d09.jpg', '2015-08-06', 'xzcxz', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `webex`
--
ALTER TABLE `webex`
 ADD PRIMARY KEY (`id_webex`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `webex`
--
ALTER TABLE `webex`
MODIFY `id_webex` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
