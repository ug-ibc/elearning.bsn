-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2015 at 04:17 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `nm_album`, `cover_album`) VALUES
(1, 'Upacara Bendera', 'ffbc67bfcf9bfb37eb5ea7f4da2cd90e.jpg'),
(2, 'Tamasya', 'b597bf1aac155989baa6458149074270.jpg');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`idSoal`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `idKursus`, `idMateri`, `idGrup_kursus`, `n_status`) VALUES
(1, 'Start -> Settings -> Control Panels -> ', 'Setting Jaringan', 'Setting IP address ', 'Setting Kabel ', 'Setting Modem', 1, 'Soal jaringan komputer', '1', 1, 1, 1, 1),
(2, 'Start -> Settings -> Control Panels -> Network Connections Klik kanan -> Properties (pada Local Area Connection) pada Tab -> general cari This connection use the following items -> Internet Protocol [TCP/IP] klik properties -> pada tab general pilih obtain an iP address automaticaly ini setting yang DHCP, untuk yang statik pilih Use this following IP address.Langkah di atas adalah untuk..... ', 'Setting Jaringan', 'Setting IP address ', 'Setting Kabel ', 'Setting Modem', 1, 'Soal jaringan komputer', '1', 1, 1, 1, 1),
(3, 'Media Transmisi dapat digolongkan menjadi dua, yaitu :', 'Unguided ', 'Guided', 'a dan b benar', 'a dan b salah', 1, NULL, '3', 1, 1, 1, 1),
(4, 'Dibawah ini merupakan contoh dari Unguided, kecuali :', 'Twisted pair', 'Vaccum', 'Propagasi udara', 'Air laut', 1, NULL, '1', 1, 1, 1, 1),
(5, 'Tiga hal penting dalam signal periodik adalah....', 'Amplitudo, Periode dan Phase ', 'Frekuensi, Amplitudo dan Phase ', 'Periode, Phase dan Frekuensi', 'Salah Semua', 1, NULL, '2', 1, 1, 1, 1),
(6, 'Komunikasi dari data dengan penyebaran dan pemrosesan signal adalah pengertian dari :', 'Signaling ', 'Attenuasi', 'Transmisi', 'Delay distortion', 1, NULL, '3', 1, 1, 1, 1),
(7, 'Faktor yang menentukan sukses dari receiver dalam mengartikan sinyal yang datang adalah, kecuali :', 'Bandwidth ', 'S / N ', 'Data Rate', 'Clocking', 1, NULL, '4', 1, 1, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_album`, `jns_file`, `nm_gallery`, `path_lokasi`, `deskripsi`) VALUES
(1, 1, '', 'sctv', '0', 'sctv'),
(7, 1, '', 'komangkomang', '0', 'koma'),
(8, 1, '', 'asd', '0', 'dfg'),
(14, 1, 'Foto', 'sdfsdf', '5e10b7fe7d1e3d7d294a55271573bc21.jpg', 'sdfsdf'),
(15, 1, '', 'totot', '2cd226934ca6dbcf65784163d501cea6.jpg', 'fsd'),
(21, 1, '', 'sfsdfsds', '465b1a164c5e02e754f60329ece3fdab.jpg', 'dsfsdf'),
(27, 1, '', 'local', '000b3bcd132014685822fcc721d541a5.jpg', 'dsadasdas'),
(33, 1, '', 'kokokoko', '', 'j;lj;l;jl;;lk'),
(89, 1, '', 'robot', 'd92a1e3f279c473d0467c6ebb5d0c9dc.jpg', 'robot'),
(97, 1, '', 'susu', '34b65e4c270d3d2184d5106c3ab76916.jpg', 'adadad'),
(105, 1, '', 'fd', '295e41c8962ce77692405ea8c89e72ae.jpg', 'fgfg'),
(106, 0, '', '', '', ''),
(107, 0, '', '', '', ''),
(108, 0, '', '', '', ''),
(109, 0, '', '', '', ''),
(110, 0, '', '', '', ''),
(111, 0, '', '', '', ''),
(112, 0, '', '', '', ''),
(113, 1, '', 'firus', '831cafd8e61a7258c8961f75b121063e.jpg', 'fsdfsdfsdf'),
(114, 0, '', '', '', ''),
(115, 0, '', '', '', ''),
(116, 0, '', '', '', ''),
(117, 0, '', '', '', ''),
(118, 0, '', '', '', ''),
(119, 0, '', '', '', ''),
(120, 0, '', '', '', ''),
(121, 1, '', 'aaaaaa', '0a43673cd6411c0ea53c318f62ca0d00.jpg', 'sdasdasd'),
(122, 0, '', '', '', ''),
(123, 0, '', '', '', ''),
(124, 0, '', '', '', ''),
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
(149, 1, 'Video', 'dadada', 'e44ac3384b7279c6d8d1a64496cf2bdb.mp4', 'dada');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `grup_kursus`
--

INSERT INTO `grup_kursus` (`idGrup_kursus`, `namagrup`, `syaratkelulusan`, `keterangan`, `create_time`, `n_status`) VALUES
(1, 'Grup jaringan', 'dapat nilai 100', 'dapat nilai 100', '2015-05-28 01:00:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`idKursus`, `namakursus`, `keterangan`, `jeniskursus`, `statuskursus`, `statussoal`, `tipepenutupan`, `start_date`, `end_date`, `quota`, `idGrup_kursus`, `create_time`, `n_status`) VALUES
(1, 'Jaringan Komputer', 'Jaringan Komputer', 'pemula', 1, 1, 1, '2015-05-28 00:00:00', '2015-05-31 00:00:00', 50, 1, '2015-05-27 23:00:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`idMateri`, `urutan`, `namamateri`, `keterangan`, `jenismateri`, `idKursus`, `idGrup_kursus`, `create_time`, `hirarki`, `n_status`) VALUES
(1, 1, 'pengantar jaringan', 'pengantar jaringan', 1, 1, 1, '2015-05-28 03:00:00', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id_news`, `judul`, `author`, `posted`, `gambar`, `brief`, `isi`, `status`) VALUES
(21, 'ibc', 1, '2015-05-03 17:00:00', '91fca47af106e886f9ab6a9e876b3f00.jpg', '<p>sadasdas<br></p>', '<p>asda<br></p>', 1),
(22, 'berita1', 1, '2015-05-26 05:39:50', '', '<p>dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsd', '<p>dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff dfsfsfsdfsdfsfsdfsdfffffffffffffffffffffffffffffffffffffff</p>', 2);

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
  PRIMARY KEY (`idSoal_user`),
  UNIQUE KEY `idSoal` (`idSoal`,`idMateri`,`idUser`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`idSoal_user`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `jawabanuser`, `idSoal`, `idMateri`, `idGrup_kursus`, `idUser`, `idKursus`, `attempt`, `attempt_date`, `n_status`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', 1, 1, NULL, 1, 1, NULL, '2015-05-26 13:30:00', 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '3', 2, 1, NULL, 1, 1, NULL, '2015-05-26 13:30:52', 1),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3', '3', 3, 1, NULL, 1, 1, NULL, '2015-05-27 08:39:10', 1),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3', '2', 3, 1, NULL, 3, 1, NULL, '2015-05-27 08:40:17', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `tbl_generate_soal`
--

INSERT INTO `tbl_generate_soal` (`id`, `idKursus`, `idMateri`, `idUser`, `soal`, `generate_date`, `start_date`, `end_date`, `finish`, `n_status`) VALUES
(123, 1, 1, 3, 'a:7:{i:0;s:1:"6";i:1;s:1:"3";i:2;s:1:"7";i:3;s:1:"1";i:4;s:1:"5";i:5;s:1:"2";i:6;s:1:"4";}', '2015-05-28 19:41:04', '2015-05-28 19:41:07', '2015-05-28 20:41:07', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `email`, `password`, `register_date`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `pendidikan`, `institusi`, `jenispekerjaan`, `hp`, `type`, `salt`, `login_count`, `email_token`, `is_online`, `n_status`) VALUES
(1, NULL, 'admin', 'admin@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2015-05-02 04:38:26', 1, 'Jakarta', '2015-05-02', NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 1),
(2, NULL, 'admin2', 'admin2@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2015-05-02 04:38:26', 1, 'Jakarta', '2015-05-02', NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 0),
(3, 'ovan', 'ovan', 'ovan89@gmail.com', '110c56bd17a70ed6c36ca6fa2f920124436debd2', '2015-05-26 10:37:46', 1, 'dasdsada', '2015-05-05', '1', 'trinata', 'scasa', 'csaa', 1, 'cop', 8, NULL, 1, 1),
(4, 'csacas', 'csaca', 'csacsa', 'fec64299d314b05ca46ba0fb18f2f6bed89945e7', '2015-05-27 02:05:32', NULL, 'csacas', '0000-00-00', 'csacsa', 'csacsa', 'csaca', 'csac', 1, 'c0d3k1r-v1.0', 0, '4wunidf2s1ag5rptye8c7z3l9hojmqbxk06v', 0, 0),
(7, 'ovancop', 'cop', 'ovan89@gmail.com', '4487befff6f8357fcd16bc9d040fe637b77c5037', '2015-05-27 02:11:58', NULL, 'dsadsa', '2011-11-01', 'csacsa', 'cascsa', 'cascsa', 'csacsaca', 2, 'c0d3k1r-v1.0', 10, 'gkl6dxqhm324rfa0twv1noizue8cy5sbjp79', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
