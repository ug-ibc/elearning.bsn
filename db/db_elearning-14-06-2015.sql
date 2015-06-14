-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2015 at 04:29 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`idSoal`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `idKursus`, `idMateri`, `idGrup_kursus`, `n_status`) VALUES
(1, 'Apa yang dimaksud dengan data ?', 'Kumpulan data yang terorganisir berdasarkan suatu struktur', 'fakta, teks, hasil pengukuran, gambar, suara, dan video yang memiliki makna', 'Bagian dari dunia nyata yang dipresentasikan', 'Informasi yang telah diproses sebagai bahan dalam proses pengambilan keputusan', 0, '', '2', 1, 0, 1, 1),
(2, 'Dibawah ini adalah kelemahan-kelemahan pada sistem basis data, kecuali..', 'Memerlukan Tenaga Spesialis', 'Memerlukan Tempat Yang Besar', 'Mahal dan kompleks', 'Sulit/lama untuk dikembangkan', 0, '', '4', 1, 0, 1, 1),
(3, 'Fungsi Database Management System (DBMS) adalah..', 'Penyimpanan, pengambilan dan perubahan data', 'Melayani recovery', 'Katalog yang dapat diakses pemakai', 'A, B, dan C benar', 0, '', '4', 2, 0, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kursus`
--

INSERT INTO `kursus` (`idKursus`, `namakursus`, `keterangan`, `jeniskursus`, `statuskursus`, `statussoal`, `tipepenutupan`, `start_date`, `end_date`, `quota`, `idGrup_kursus`, `image`, `create_time`, `parentCourse`, `n_status`) VALUES
(1, 'kursus 1', 'soalnya susah2 coy', '3', NULL, NULL, NULL, '2015-06-14 00:00:00', '2015-06-20 00:00:00', 10, 1, '9688853ba1ff235fde9c4088fa35ec66.jpg', '2015-06-14 00:13:43', 0, 1),
(2, 'kursus 2', 'coba lagi', '3', NULL, NULL, NULL, '2015-06-14 00:00:00', '2015-06-20 00:00:00', 10, 1, '599fd13f2c6a0460117dac9b8f9c0884.jpg', '2015-06-14 00:16:09', 0, 1);

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
  `idKursus` int(11) DEFAULT NULL,
  `n_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idNilai`),
  UNIQUE KEY `idUser` (`idUser`,`idKursus`,`n_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`idNilai`, `nilai`, `benar`, `salah`, `statusulang`, `statuskelulusan`, `create_time`, `idUser`, `idKursus`, `n_status`) VALUES
(8, 33, 1, 2, 0, 0, '2015-06-14 09:02:27', 9, 1, 1);

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

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`idSoal_user`, `soal`, `pilihan1`, `pilihan2`, `pilihan3`, `pilihan4`, `jenissoal`, `keterangan`, `jawaban`, `jawabanuser`, `idSoal`, `idMateri`, `idGrup_kursus`, `idUser`, `idKursus`, `attempt`, `attempt_date`, `n_status`) VALUES
(11, '53', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:2:"53";}', '2', '2', 1, 0, 1, 9, 1, 1, '2015-06-14 15:50:54', 1),
(12, '53', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:2:"53";}', '4', '3', 2, 0, 1, 9, 1, 1, '2015-06-14 15:51:14', 1),
(13, '53', NULL, NULL, NULL, NULL, NULL, 'a:1:{s:16:"id_generate_soal";s:2:"53";}', '4', '1', 3, 0, 1, 9, 2, 1, '2015-06-14 15:51:17', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `tbl_generate_soal`
--

INSERT INTO `tbl_generate_soal` (`id`, `idGrupKursus`, `idKursus`, `idMateri`, `idUser`, `soal`, `generate_date`, `start_date`, `end_date`, `finish`, `n_status`) VALUES
(53, 1, 0, 0, 9, 'a:3:{i:0;s:1:"3";i:1;s:1:"1";i:2;s:1:"2";}', '2015-06-14 15:50:49', '2015-06-14 15:50:52', '2015-06-14 16:50:52', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `username`, `email`, `password`, `register_date`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `pendidikan`, `institusi`, `jenispekerjaan`, `hp`, `type`, `salt`, `login_count`, `email_token`, `is_online`, `n_status`) VALUES
(1, 'admin', 'admin', 'admin@example.com', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', '2015-06-04 04:26:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'codekir v3.0', 0, NULL, 0, 1),
(8, 'bayu', 'bayu', 'andreass.bayu@gmail.com', 'a79463c981d361d67628b9be3ee75eded30295bf', '2015-06-04 04:27:08', NULL, '', '0000-00-00', '', '', '', '', 2, 'c0d3k1r-v1.0', 2, 'nj71vbti90seqgkwy4o3mf8cpazl5du2xh6r', 1, 1),
(9, 'ovan', 'cop', 'ovan89@gmail.com', '4487befff6f8357fcd16bc9d040fe637b77c5037', '2015-06-14 00:47:01', NULL, 'lobbo', '1989-10-01', 'sarjana', 'gunadarma', 'free lance', '0911', 2, 'c0d3k1r-v1.0', 3, 'gc7e5t6uksjazbrnp8y4q0fxm19olhv2i3wd', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
