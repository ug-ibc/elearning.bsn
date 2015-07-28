-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2015 at 02:33 
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
-- Table structure for table `video_webex`
--

CREATE TABLE IF NOT EXISTS `video_webex` (
`id_video` int(3) NOT NULL,
  `title` varchar(50) NOT NULL,
  `video` varchar(255) NOT NULL,
  `jenisfile` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_webex`
--

INSERT INTO `video_webex` (`id_video`, `title`, `video`, `jenisfile`, `status`) VALUES
(7, 'sdsad', '83a224433f307316a3b372461ff2ca6a.flv', 0, 2),
(8, 'ssadsad', 'https://www.youtube.com/embed/iG9isG5Aop4', 0, 1),
(9, 'xzcxz', '7353fd377aa22dfb23e4b1ed408e9be0.flv', 2, 1),
(10, 'komang', 'a17fdfb1099794ad0c7fad3534465341.flv', 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `video_webex`
--
ALTER TABLE `video_webex`
 ADD PRIMARY KEY (`id_video`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `video_webex`
--
ALTER TABLE `video_webex`
MODIFY `id_video` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
