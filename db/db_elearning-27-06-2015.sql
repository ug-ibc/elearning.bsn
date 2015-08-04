-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2015 at 04:19 PM
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
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(4) NOT NULL AUTO_INCREMENT,
  `nm_album` varchar(30) NOT NULL,
  `cover_album` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`idSoal`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `idKursus`, `idMateri`, `idGrup_kursus`, `n_status`) VALUES
(1, 'pertanyaan 1', 'aa', 'bb', 'as', 'sda', 0, '', '1', 1, 0, 1, 1),
(2, 'pertanyaan 2', 'das', 'csaca 2', 'Bagian dari dunia nyata yang dipresentasikan', 'sda', 0, '', '3', 2, 0, 1, 1),
(3, 'ada pertanyaan lagi', 'casca', 'asca', 'cascsa', 'vaa', 0, '', '4', 3, 0, 2, 1),
(4, 'pertanyaan baru lagi', 'aaaa', 'sasaa', 'fdsa', 'qwery', 0, '', '4', 1, 0, 1, 1),
(5, 'dsafsafafsa', 'vavas', 'dasa', 'fdasfa', 'fsafaf', 0, '', '2', 2, 0, 1, 1),
(6, 'mhgmhgmg', 'fsdfsdfs', 'tfyty', 'grdgd', 'grddrg', 0, '', '3', 2, 0, 1, 1),
(7, 'vcsfsfds', 'aadasa', 'dwqdq', 'cscsd', 'sdsasd', 0, '', '2', 1, 0, 1, 1),
(8, 'jnsdknsk', 'cksndn', 'ncdks', 'jcdsk', 'nknksnndksks', 0, '', '3', 1, 0, 1, 1),
(9, 'csaa', 'csasa', 'cascsa', 'caca', 'casvssca', 0, '', '3', 3, 0, 2, 1),
(10, 'dwqdwqq', 'dwqwqd', 'sadad', 'dwqdwq', 'dqweq', 0, '', '3', 3, 0, 2, 1),
(11, 'csaa 12121', 'sacaca', 'dvsvs', 'vsdvsvs', 'vssvs', 0, '', '4', 3, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE IF NOT EXISTS `catatan` (
  `idCatatan` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tipe` tinyint(1) DEFAULT NULL COMMENT '1:qlosarium;2:quote',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catatan`
--

INSERT INTO `catatan` (`idCatatan`, `judul`, `keterangan`, `tipe`, `create_time`, `n_status`) VALUES
(1, 'ddr3 ', 'jenis ram ', 1, '2015-06-10 07:26:30', 1),
(2, 'lcd', 'sejenis teknologi layar', 1, '2015-06-10 07:27:38', 1),
(4, 'Bill Copeland edit', 'The trouble with not having a goal is that you can spend your life running up and down the field and never score edit', 2, '2015-06-10 10:33:26', 1),
(5, 'iman edit', 'If what youâ€™re doing is not your passion, you have nothing to lose edit', 2, '2015-06-10 10:41:04', 1),
(0, 'aaa', 'okeee', 2, '2015-06-25 07:50:24', 1),
(0, 'aaa', 'okeee', 3, '2015-06-25 07:51:41', 1);

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
  `downloadCount` int(11) NOT NULL DEFAULT '0',
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
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_gallery`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(1, 'Grup kursus 1', 'harus jawab semua soal oke!', NULL, '2015-06-14 00:08:10', 1),
(2, 'grup kursus 2', 'ini sama aja dengan yg pertama', NULL, '2015-06-14 00:09:13', 1);

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
  `image` varchar(150) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parentCourse` int(11) NOT NULL DEFAULT '0',
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idKursus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`idKursus`, `namakursus`, `keterangan`, `jeniskursus`, `statuskursus`, `statussoal`, `tipepenutupan`, `start_date`, `end_date`, `quota`, `idGrup_kursus`, `image`, `create_time`, `parentCourse`, `n_status`) VALUES
(1, 'kursus 1', 'soalnya susah2 coy', '3', NULL, NULL, NULL, '2015-06-14 00:00:00', '2015-06-20 00:00:00', 10, 1, '9688853ba1ff235fde9c4088fa35ec66.jpg', '2015-06-14 00:13:43', 0, 1),
(2, 'kursus 2', 'coba lagi', '3', NULL, NULL, NULL, '2015-06-14 00:00:00', '2015-06-20 00:00:00', 10, 1, '599fd13f2c6a0460117dac9b8f9c0884.jpg', '2015-06-14 00:16:09', 0, 1),
(3, 'kursus baru', 'kursus baru', '3', NULL, NULL, NULL, '2015-06-21 00:00:00', '2015-06-28 00:00:00', 10, 2, 'dummy.jpg', '2015-06-21 09:52:50', 0, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `idNilai` int(11) NOT NULL AUTO_INCREMENT,
  `nilai` int(11) DEFAULT NULL,
  `benar` int(11) NOT NULL DEFAULT '0',
  `salah` int(11) NOT NULL DEFAULT '0',
  `statusulang` tinyint(1) DEFAULT NULL,
  `statuskelulusan` tinyint(1) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  `idGroupKursus` int(11) NOT NULL DEFAULT '0',
  `idKursus` int(11) DEFAULT NULL,
  `kodeSertifikat` varchar(50) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idNilai`),
  UNIQUE KEY `idUser` (`idUser`,`idKursus`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`idNilai`, `nilai`, `benar`, `salah`, `statusulang`, `statuskelulusan`, `create_time`, `idUser`, `idGroupKursus`, `idKursus`, `kodeSertifikat`, `data`, `n_status`) VALUES
(1, 25, 1, 3, 0, 0, '2015-06-24 13:26:29', 16, 1, 1, 'ELS/1/XV', NULL, 1),
(2, 0, 0, 3, 0, 0, '2015-06-24 13:52:40', 16, 2, 3, 'ELS/2/XV', NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`idSoal_user`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `jawabanuser`, `idSoal`, `idMateri`, `idGrup_kursus`, `idUser`, `idKursus`, `attempt`, `attempt_date`, `n_status`) VALUES
(1, '1', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"1";}', '1', '1', 1, 0, 1, 16, 1, 1, '2015-06-24 20:26:17', 1),
(2, '1', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"1";}', '3', '1', 2, 0, 1, 16, 2, 1, '2015-06-24 20:26:18', 1),
(3, '1', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"1";}', '4', '1', 4, 0, 1, 16, 1, 1, '2015-06-24 20:26:20', 1),
(4, '1', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"1";}', '3', '1', 6, 0, 1, 16, 2, 1, '2015-06-24 20:26:21', 1),
(14, '5', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"5";}', '4', '1', 3, 0, 2, 16, 3, 1, '2015-06-24 20:50:41', 1),
(15, '5', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"5";}', '3', '1', 10, 0, 2, 16, 3, 1, '2015-06-24 20:50:42', 1),
(16, '5', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:1:"5";}', '4', '1', 11, 0, 2, 16, 3, 1, '2015-06-24 20:50:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity_log`
--

CREATE TABLE IF NOT EXISTS `tbl_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL DEFAULT '0',
  `source` varchar(255) DEFAULT NULL,
  `datetimes` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `tbl_activity_log`
--

INSERT INTO `tbl_activity_log` (`id`, `activity`, `description`, `userID`, `source`, `datetimes`, `n_status`) VALUES
(1, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 07:25:50', 1),
(2, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:34:34', 1),
(3, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:39:46', 1),
(4, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:42:29', 1),
(5, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:47:18', 1),
(6, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:47:41', 1),
(7, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-18 20:47:48', 1),
(8, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-19 17:55:44', 1),
(9, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-19 19:34:08', 1),
(10, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-19 19:34:24', 1),
(11, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-19 19:34:30', 1),
(12, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-21 12:08:29', 1),
(13, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-21 15:45:46', 1),
(14, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-21 19:16:26', 1),
(15, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 10:03:50', 1),
(16, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 10:03:58', 1),
(17, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 10:39:16', 1),
(18, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 12:16:37', 1),
(19, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 12:17:03', 1),
(20, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 12:17:09', 1),
(21, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 12:17:46', 1),
(22, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 13:43:26', 1),
(23, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 16:29:13', 1),
(24, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-22 16:29:19', 1),
(25, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 13:52:49', 1),
(26, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 13:54:54', 1),
(27, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 14:15:50', 1),
(28, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 19:14:17', 1),
(29, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 20:18:57', 1),
(30, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-23 20:19:04', 1),
(31, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 07:26:08', 1),
(32, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 08:12:16', 1),
(33, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 08:12:25', 1),
(34, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 08:12:42', 1),
(35, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 08:13:06', 1),
(36, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 18:26:13', 1),
(37, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 18:26:15', 1),
(38, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 18:30:43', 1),
(39, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 19:01:26', 1),
(40, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 19:11:11', 1),
(41, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-24 20:20:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_generate_soal`
--

CREATE TABLE IF NOT EXISTS `tbl_generate_soal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGrupKursus` int(11) NOT NULL DEFAULT '0',
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
  UNIQUE KEY `idGrupKursus` (`idGrupKursus`,`idUser`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_generate_soal`
--

INSERT INTO `tbl_generate_soal` (`id`, `idGrupKursus`, `idKursus`, `idMateri`, `idUser`, `soal`, `generate_date`, `start_date`, `end_date`, `finish`, `n_status`) VALUES
(1, 1, 0, 0, 16, 'a:4:{i:0;s:1:"4";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"6";}', '2015-06-24 20:26:14', '2015-06-24 20:26:17', '2015-06-24 20:28:17', 1, 1),
(5, 2, 0, 0, 16, 'a:3:{i:0;s:1:"3";i:1;s:2:"11";i:2;s:2:"10";}', '2015-06-24 20:50:37', '2015-06-24 20:50:40', '2015-06-24 20:52:40', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_quiz_setting`
--

INSERT INTO `tbl_quiz_setting` (`id`, `maxSoal`, `kategoriBaik`, `kategoriCukup`, `kategoriKurang`, `waktu`, `idGroupKursus`, `idKursus`, `data`, `n_status`) VALUES
(1, 4, '80-100', '60-79', '0-59', 2, 1, 0, NULL, 1),
(2, 3, '12', '12', '21', 2, 2, 0, NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `email`, `password`, `register_date`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `pendidikan`, `institusi`, `jenispekerjaan`, `hp`, `type`, `salt`, `login_count`, `email_token`, `is_online`, `n_status`) VALUES
(1, 'admin', 'admin', 'admin@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2015-06-03 21:26:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 1),
(16, 'ovan', 'ovan', 'o.pulu@yahoo.com', '57791c9336d1628e873ca54c61551beb46f3957c', '2015-06-24 00:57:25', NULL, 'a', '2015-05-06', 'aa', 'aa', 'aa', '123', 2, 'c0d3k1r-v1.0', 3, 'zia9txn2qehcp5fswjb4l3rog16k0yu7d8mv', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
