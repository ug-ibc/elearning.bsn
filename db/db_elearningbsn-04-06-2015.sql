-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2015 at 01:54 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

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
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(4) NOT NULL AUTO_INCREMENT,
  `nm_album` varchar(30) NOT NULL,
  `cover_album` varchar(255) NOT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `nm_album`, `cover_album`) VALUES
(3, 'Test album', '18c5d5e250f59aad01590909ef3604bd.png');

-- --------------------------------------------------------

--
-- Table structure for table `banksoal`
--

CREATE TABLE IF NOT EXISTS `banksoal` (
  `idSoal` int(11) NOT NULL AUTO_INCREMENT,
  `soal` text,
  `pilihan1` tinytext,
  `pilihan2` tinytext,
  `pilihan3` tinytext,
  `pilihan4` tinytext,
  `jenissoal` tinyint(1) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `jawaban` text,
  `idKursus` int(11) DEFAULT NULL,
  `idMateri` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idSoal`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`idSoal`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `idKursus`, `idMateri`, `idGrup_kursus`, `n_status`) VALUES
(1, 'tanya apa?', 'apa hayo', 'APA AJA', 'bole', 'naah', 1, 'adasdas', 'C', 1, 1, 1, NULL),
(2, 'tes tanya apa ayo', '1', '2', '3', '4', 1, 'asdasd', '3', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `idFile` int(11) NOT NULL AUTO_INCREMENT,
  `namafile` varchar(255) DEFAULT NULL,
  `jenisfile` tinyint(1) DEFAULT NULL,
  `statusfile` tinyint(1) DEFAULT NULL COMMENT '1:login,2:free',
  `idMateri` int(11) DEFAULT NULL,
  `idKursus` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idFile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id_gallery` int(4) NOT NULL AUTO_INCREMENT,
  `id_album` int(4) NOT NULL,
  `jns_file` varchar(7) NOT NULL,
  `nm_gallery` varchar(50) NOT NULL,
  `path_lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`id_gallery`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_album`, `jns_file`, `nm_gallery`, `path_lokasi`, `deskripsi`) VALUES
(125, 0, '', '', '', ''),
(126, 0, '', '', '', ''),
(127, 0, '', '', '', ''),
(128, 0, '', '', '', ''),
(129, 1, '', 'bbbb', 'd9ee3ade25714cf108959e9ded44af73.jpg', 'dfdfdfdfdf'),
(130, 0, '', '', '', ''),
(131, 0, '', '', '', ''),
(132, 0, '', '', '', ''),
(133, 0, '', '', '', ''),
(134, 0, '', '', '', ''),
(135, 0, '', '', '', ''),
(136, 0, '', '', '', ''),
(137, 1, '', 'cccc', 'bbe48177271ad4bb2a349992ed86ed20.jpg', 'ccc'),
(138, 1, '', 'cccc', 'e3cc13118bc0d9ecc18f9ef5a9deeccc.jpg', 'ccc'),
(139, 1, '', 'dddddd', '9e2a863115e6c2ffed87f85b6dee3fcc.jpg', 'dsdsds'),
(140, 1, '', 'ffff', '', 'ffsfsf'),
(141, 1, '', 'ggggg', '', 'hjhkhkh'),
(142, 1, '', 'daasda', '', 'dsadsads'),
(143, 1, '', 'faasfas', '3d24bec1d5da133317df4b6a158df577.flv', 'xsasax'),
(144, 1, '', '', '', ''),
(145, 1, 'Video', 'chandra', 'cde653b70a0604bcf61f24d90f66805b.flv', 'laiow'),
(146, 2, 'Foto', 'Foto1', '7a3cd164d2e6ff7830e522aec18ab6b1.jpg', 'foto'),
(147, 2, 'Foto', 'asdasd', '2db35b3cff693e855bd0910c90ec20a5.jpg', 'sasasda'),
(148, 1, 'Video', 'adasd', '95c9e0d502cdb970d6778489ce68cb8d.flv', 'sadadas'),
(149, 1, 'Video', 'dadada', 'e44ac3384b7279c6d8d1a64496cf2bdb.mp4', 'dada'),
(150, 3, 'Foto', 'Tes lagi', '4186bd86632fc9e2b8620110ec7d3f81.png', 'sdfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `grup_kursus`
--

CREATE TABLE IF NOT EXISTS `grup_kursus` (
  `idGrup_kursus` int(11) NOT NULL AUTO_INCREMENT,
  `namagrup` varchar(255) DEFAULT NULL,
  `syaratkelulusan` tinytext,
  `keterangan` text,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idGrup_kursus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `grup_kursus`
--

INSERT INTO `grup_kursus` (`idGrup_kursus`, `namagrup`, `syaratkelulusan`, `keterangan`, `create_time`, `n_status`) VALUES
(1, 'bayu', 'bayu', NULL, '2015-05-21 12:12:08', 1),
(2, 'tes grup', 'dfsfd', NULL, '2015-06-04 03:27:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE IF NOT EXISTS `kursus` (
  `idKursus` int(11) NOT NULL AUTO_INCREMENT,
  `namakursus` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `jeniskursus` varchar(45) DEFAULT NULL,
  `statuskursus` tinyint(1) DEFAULT NULL,
  `statussoal` tinyint(1) DEFAULT NULL,
  `tipepenutupan` tinyint(1) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `quota` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idKursus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE IF NOT EXISTS `materi` (
  `idMateri` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) DEFAULT NULL,
  `namamateri` tinytext,
  `keterangan` text,
  `jenismateri` tinyint(1) DEFAULT NULL,
  `idKursus` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hirarki` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idMateri`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(3) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `author` int(11) NOT NULL,
  `posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gambar` varchar(255) NOT NULL,
  `brief` tinytext NOT NULL,
  `isi` text NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id_news`, `judul`, `author`, `posted`, `gambar`, `brief`, `isi`, `status`) VALUES
(21, 'ibc', 1, '2015-05-03 17:00:00', '91fca47af106e886f9ab6a9e876b3f00.jpg', '<p>sadasdas<br></p>', '<p>asda<br></p>', 1),
(22, 'berita1', 1, '2015-05-26 05:39:50', '', '<p>dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsd', '<p>dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff</p>', 2),
(23, 'Tes news', 1, '2015-05-25 17:00:00', '2e33a2735d94abfcb5eda0740fc872f9.png', '<p>tessss<br></p>', '<p>asasasas<br></p>', 1),
(24, 'Tes lagi', 1, '2015-05-25 17:00:00', '', '<p>sadsdf<br></p>', '<p>sdfsdfsdsdfsdf<br></p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `idNilai` int(11) NOT NULL AUTO_INCREMENT,
  `nilai` int(11) DEFAULT NULL,
  `statusulang` tinyint(1) DEFAULT NULL,
  `statuskelulusan` tinyint(1) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  `idKursus` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idNilai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `keterangan` varchar(45) DEFAULT NULL,
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
  PRIMARY KEY (`idSoal_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_generate_soal`
--

CREATE TABLE IF NOT EXISTS `tbl_generate_soal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKursus` int(11) NOT NULL,
  `idMateri` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `soal` text NOT NULL,
  `generate_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `finish` int(11) NOT NULL DEFAULT '0',
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idKursus` (`idKursus`,`idMateri`,`idUser`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jeniskelamin` tinyint(1) DEFAULT NULL,
  `tempatlahir` tinytext,
  `tanggallahir` date DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `institusi` tinytext,
  `jenispekerjaan` varchar(255) DEFAULT NULL,
  `hp` tinytext,
  `type` int(11) DEFAULT NULL COMMENT '1:admin,2:user',
  `salt` varchar(200) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `email_token` varchar(255) DEFAULT NULL,
  `is_online` int(11) NOT NULL DEFAULT '0',
  `n_status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `email`, `password`, `register_date`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `pendidikan`, `institusi`, `jenispekerjaan`, `hp`, `type`, `salt`, `login_count`, `email_token`, `is_online`, `n_status`) VALUES
(1, 'admin', 'admin', 'admin@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2015-06-04 04:26:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 1),
(8, 'bayu', 'bayu', 'andreass.bayu@gmail.com', 'a79463c981d361d67628b9be3ee75eded30295bf', '2015-06-04 04:27:08', NULL, '', '0000-00-00', '', '', '', '', 2, 'c0d3k1r-v1.0', 2, 'nj71vbti90seqgkwy4o3mf8cpazl5du2xh6r', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
