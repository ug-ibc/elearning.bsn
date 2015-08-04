-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 17, 2015 at 01:51 PM
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
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `nm_album`, `cover_album`, `create_date`) VALUES
(1, 'Album 1', '014a5554630c386efe34ee2963b24ed5.jpg', '2015-06-09 03:25:06');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`idSoal`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `idKursus`, `idMateri`, `idGrup_kursus`, `n_status`) VALUES
(1, '1. Definisi algoritma adalah :', 'Sebuah system manusia/mesin yang terpadu untuk menyajikan informasi ', 'Sebuah kumpulan system yang digunakan pada suatu organisasi', 'Metode untuk menyelesaikan masalah besar ', 'Urutan langkah-langkah logis penyelesaian masalah yang disusun secara sistematis ', 0, '', '4', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE IF NOT EXISTS `catatan` (
  `idCatatan` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `tipe` tinyint(1) DEFAULT NULL COMMENT '1:qlosarium;2:quote',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `files` varchar(255) DEFAULT NULL,
  `downloadCount` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idFile`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`idFile`, `namafile`, `jenisfile`, `statusfile`, `idMateri`, `idKursus`, `idGrup_kursus`, `create_time`, `files`, `downloadCount`, `n_status`) VALUES
(2, 'Ebook 1 Update', 1, 1, 2, 1, 1, '2015-06-08 19:38:48', '39763b7d571daa1b0a5cfdf7be3598a9.pdf', NULL, 1),
(3, 'Video 1', 2, 1, 1, 1, 1, '2015-06-09 10:37:21', '', NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `id_album`, `jns_file`, `nm_gallery`, `path_lokasi`, `deskripsi`, `create_date`) VALUES
(1, 1, 'Foto', 'Foto 1', 'ffbe1ebe85e77a68e50963933349ab14.jpg', '', '2015-06-09 03:25:22'),
(2, 1, 'Foto', 'Foto 2', 'aa136aac77dff8113d933f6f7813dcb8.jpg', '', '2015-06-09 03:25:35'),
(3, 1, 'Foto', 'Foto 3', '006a866061d0a5dff88022721c3f0c90.jpg', '', '2015-06-09 03:25:51');

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
(1, 'Grup 1', 'tesst', NULL, '2015-06-08 12:31:51', 1),
(2, 'Grup 2', 'tesst', NULL, '2015-06-08 12:33:34', 1);

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
  `parentCourse` int(11) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idKursus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`idKursus`, `namakursus`, `keterangan`, `jeniskursus`, `statuskursus`, `statussoal`, `tipepenutupan`, `start_date`, `end_date`, `quota`, `idGrup_kursus`, `parentCourse`, `image`, `create_time`, `n_status`) VALUES
(1, 'Kursus 1', 'asdas', '3', NULL, NULL, NULL, '2015-06-09 00:00:00', '2015-06-12 00:00:00', 0, 1, NULL, 'b1d5b3c4abafee487e57a19b4baf0414.png', '2015-06-08 16:24:31', 1),
(2, 'Kursus 2', 'sdsds', '1', NULL, NULL, NULL, '2015-06-10 00:00:00', '2015-06-17 00:00:00', 0, 2, NULL, '7451d5d8f4cdca04c6a008767f249b33.jpg', '2015-06-08 17:28:44', 1),
(4, 'Kursus 1.1 update', 'sdsfs', '2', NULL, NULL, NULL, '2015-06-10 00:00:00', '2015-06-13 00:00:00', 0, 1, 1, 'b4a13b056e5e1a4c6b34191e4b8657b9.jpg', '2015-06-08 17:31:33', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`idMateri`, `urutan`, `namamateri`, `keterangan`, `jenismateri`, `idKursus`, `idGrup_kursus`, `create_time`, `hirarki`, `n_status`) VALUES
(1, 1, 'Materi 1', 'Desc 1', 3, 1, 1, '2015-06-08 18:25:52', NULL, 1),
(2, 2, 'Materi 2', 'Desc 2', 3, 1, 1, '2015-06-08 18:26:08', NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id_news`, `judul`, `author`, `posted`, `gambar`, `brief`, `isi`, `status`) VALUES
(1, 'Jokowi: Reshuffle Kabinet Tergantung Kebutuhan ', 1, '2015-06-09 17:00:00', '39536c0a227d43d608c5e8e4b9eb4409.png', 'Presiden Joko Widodo akan melakukan reshuffle kabinet setelah lebaran. Lalu siapa menteri yang bakal kena imbas reshuffle kabinet?', '<strong>Jakarta</strong> - Isu santer Presiden Joko Widodo akan \r\nmelakukan reshuffle kabinet setelah lebaran. Lalu siapa menteri yang \r\nbakal kena imbas reshuffle kabinet?<br><br>Presiden Jokowi ternyata \r\nterus melakukan evaluasi kabinet kerja. Evaluasi dilakukan per minggu, \r\nbahkan tiap hari Jokowi terus memantau kinerja menterinya.<br><br>"Evaluasi\r\n kita lakukan setiap hari, setiap minggu evaluasi," kata Jokowi saat \r\nberbincang dengan detikcom di Istana Negara, Jakarta, Senin (8/6/2015).<br><br>Lalu apakah Jokowi akan melakukan reshuffle kabinet?<br><br>"Yang kita lihat kebutuhannya, apa perlu reshuffle, simpel saja," kata Jokowi sembari tersenyum.<br><br>Lebih\r\n jauh Jokowi menuturkan reshuffle kabinet sangat terkait dengan \r\nkebutuhan di pemerintahan. Dia tak ingin isu reshuffle kabinet dikaitkan\r\n dengan merapatnya sejumlah parpol baru ke pemerintahan.<br><br>"Masalah reshuffle untuk menjawab kebutuhan, bukan parpol ingin merapat atau tidak," katanya.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `idNilai` int(11) NOT NULL AUTO_INCREMENT,
  `nilai` int(11) DEFAULT NULL,
  `benar` int(11) DEFAULT NULL,
  `salah` int(11) DEFAULT NULL,
  `statusulang` tinyint(1) DEFAULT NULL,
  `statuskelulusan` tinyint(1) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  `idKursus` int(11) DEFAULT NULL,
  `idGrup_kursus` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idNilai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`idNilai`, `nilai`, `benar`, `salah`, `statusulang`, `statuskelulusan`, `create_time`, `idUser`, `idKursus`, `idGrup_kursus`, `n_status`) VALUES
(1, 1, NULL, NULL, 0, 0, '2015-06-09 12:42:09', 8, 1, NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`idSoal_user`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `jawabanuser`, `idSoal`, `idMateri`, `idGrup_kursus`, `idUser`, `idKursus`, `attempt`, `attempt_date`, `n_status`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:41:54', 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:41:56', 1),
(3, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '3', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:00', 1),
(4, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '4', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:02', 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:04', 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:04', 1),
(7, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:05', 1),
(8, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:05', 1),
(9, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '2', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:06', 1),
(10, NULL, NULL, NULL, NULL, NULL, NULL, '1', '4', '1', 1, 1, NULL, 8, 1, 1, '2015-06-09 19:42:07', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_activity_log`
--

INSERT INTO `tbl_activity_log` (`id`, `activity`, `description`, `userID`, `source`, `datetimes`, `n_status`) VALUES
(1, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:10:16', 1),
(2, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:10:40', 1),
(3, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:10:46', 1),
(4, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:28:56', 1),
(5, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:30:33', 1),
(6, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:30:57', 1),
(7, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 15:31:43', 1),
(8, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 18:39:01', 1),
(9, 'surf', 'landing home bsn', 0, '127.0.0.1', '2015-06-16 18:41:43', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_generate_soal`
--

INSERT INTO `tbl_generate_soal` (`id`, `idKursus`, `idMateri`, `idUser`, `soal`, `generate_date`, `start_date`, `end_date`, `finish`, `n_status`) VALUES
(1, 1, 1, 8, 'a:1:{i:0;s:1:"1";}', '2015-06-09 19:41:51', '2015-06-09 19:41:54', '2015-06-09 20:41:54', 1, 1);

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
(8, 'bayu', 'bayu', 'andreass.bayu@gmail.com', 'a79463c981d361d67628b9be3ee75eded30295bf', '2015-06-04 04:27:08', NULL, '', '0000-00-00', '', '', '', '', 2, 'c0d3k1r-v1.0', 6, 'nj71vbti90seqgkwy4o3mf8cpazl5du2xh6r', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
