-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2017 at 06:03 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 5.6.32-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_pemberi` int(11) NOT NULL,
  `tgl_disposisi` datetime NOT NULL,
  `tgl_selesai` datetime DEFAULT NULL,
  `id_intruksi` tinyint(4) DEFAULT NULL,
  `pesan` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id`, `id_surat`, `id_pemberi`, `tgl_disposisi`, `tgl_selesai`, `id_intruksi`, `pesan`) VALUES
(1, 8, 2, '2017-10-04 00:00:00', '2017-10-10 00:00:00', NULL, 'Pesan disposisi 1'),
(2, 9, 2, '2017-10-11 00:00:00', '2017-10-18 00:00:00', NULL, 'pesan disposisi 9');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi_tujuan`
--

CREATE TABLE `disposisi_tujuan` (
  `id` int(11) NOT NULL,
  `id_disposisi` int(11) NOT NULL,
  `id_penerima` smallint(6) NOT NULL,
  `tgl_diterima` datetime DEFAULT NULL,
  `keterangan` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi_tujuan`
--

INSERT INTO `disposisi_tujuan` (`id`, `id_disposisi`, `id_penerima`, `tgl_diterima`, `keterangan`) VALUES
(1, 1, 6, NULL, NULL),
(2, 2, 6, NULL, NULL),
(3, 2, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `gender_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender_name`) VALUES
(1, 'male'),
(2, 'female');

-- --------------------------------------------------------

--
-- Table structure for table `kecepatan_sampai`
--

CREATE TABLE `kecepatan_sampai` (
  `id` smallint(6) NOT NULL,
  `nama_kecepatan` varchar(50) NOT NULL,
  `nilai_kecepatan` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kecepatan_sampai`
--

INSERT INTO `kecepatan_sampai` (`id`, `nama_kecepatan`, `nilai_kecepatan`) VALUES
(1, 'Biasa', 10),
(2, 'Segera', 20),
(3, 'Amat Segera', 30);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1436495090),
('m130524_201442_init', 1436495111);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` text,
  `last_name` text,
  `birthdate` date DEFAULT NULL,
  `gender_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `first_name`, `last_name`, `birthdate`, `gender_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Yasrul', 'Abdullah', '1974-02-03', 1, '2015-07-30 16:21:39', '2015-07-30 16:21:39'),
(2, 3, 'Abdullah', 'Rawahah', '1979-05-16', 1, '2015-07-30 16:23:56', '2015-07-30 16:23:56'),
(3, 4, 'Fatimah', 'Sholihah', '1978-05-17', 2, '2015-07-30 16:25:15', '2015-07-30 16:25:15'),
(4, 5, 'Hamzah', 'Namira', '1980-08-27', 1, '2015-08-03 09:51:06', '2015-08-03 09:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `id_unit` smallint(6) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `tgl_trans` datetime NOT NULL,
  `no_agenda` varchar(30) DEFAULT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `status_surat` tinyint(4) NOT NULL,
  `status_reg` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` smallint(6) NOT NULL,
  `role_name` varchar(45) NOT NULL,
  `role_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `role_value`) VALUES
(1, 'User', 10),
(2, 'Operator', 20),
(3, 'AdminSystem', 30);

-- --------------------------------------------------------

--
-- Table structure for table `status_akses`
--

CREATE TABLE `status_akses` (
  `id` tinyint(4) NOT NULL,
  `status_value` smallint(6) NOT NULL,
  `status_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_akses`
--

INSERT INTO `status_akses` (`id`, `status_value`, `status_name`) VALUES
(1, 10, 'Draff'),
(2, 20, 'Aktif'),
(3, 30, 'Non Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `status_reg`
--

CREATE TABLE `status_reg` (
  `id` smallint(6) NOT NULL DEFAULT '0',
  `status_name` varchar(30) NOT NULL,
  `status_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_reg`
--

INSERT INTO `status_reg` (`id`, `status_name`, `status_value`) VALUES
(1, 'Masuk', 10),
(2, 'Keluar', 20),
(3, 'Draff Masuk', 30),
(4, 'Draff Keluar', 40);

-- --------------------------------------------------------

--
-- Table structure for table `status_surat`
--

CREATE TABLE `status_surat` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_surat`
--

INSERT INTO `status_surat` (`id`, `status_name`, `status_value`) VALUES
(1, 'Sedia', 10),
(2, 'Terbaca', 20),
(3, 'Terhapus', 0);

-- --------------------------------------------------------

--
-- Table structure for table `status_tujuan`
--

CREATE TABLE `status_tujuan` (
  `id` tinyint(4) NOT NULL,
  `status_name` varchar(30) NOT NULL,
  `status_value` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_tujuan`
--

INSERT INTO `status_tujuan` (`id`, `status_name`, `status_value`) VALUES
(1, 'Utama', 10),
(2, 'Tembusan', 20);

-- --------------------------------------------------------

--
-- Table structure for table `status_user`
--

CREATE TABLE `status_user` (
  `id` smallint(6) NOT NULL,
  `status_name` varchar(45) NOT NULL,
  `status_value` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_user`
--

INSERT INTO `status_user` (`id`, `status_name`, `status_value`) VALUES
(1, 'Active', 10),
(2, 'Pending', 5);

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `id_dari` smallint(6) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tgl_surat` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `lampiran` varchar(100) DEFAULT NULL,
  `kecepatan_sampai` smallint(6) DEFAULT NULL,
  `tingkat_keamanan` smallint(6) DEFAULT NULL,
  `id_pengirim` smallint(6) DEFAULT NULL,
  `pengirim_manual` varchar(100) DEFAULT NULL,
  `alamat_manual` varchar(255) DEFAULT NULL,
  `status_akses` tinyint(4) DEFAULT NULL,
  `doc_srcfilename` varchar(255) NOT NULL,
  `doc_appfilename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `id_dari`, `no_surat`, `tgl_surat`, `perihal`, `lampiran`, `kecepatan_sampai`, `tingkat_keamanan`, `id_pengirim`, `pengirim_manual`, `alamat_manual`, `status_akses`, `doc_srcfilename`, `doc_appfilename`) VALUES
(1, 5, '345', '2017-08-09', 'Uji Coba', '1', 1, 2, 5, '', '', NULL, '', NULL),
(2, 5, '123', '2017-08-07', 'perihal 2', '', 2, 2, 5, '', '', NULL, '', NULL),
(3, 5, '321', '2017-08-16', 'Perihal 3', 'satu gabung', 1, 1, 5, '', '', NULL, '', NULL),
(4, 5, '789', '2017-08-10', 'Perihal 4', 'lamp 4', 1, 2, 5, '', '', NULL, '', NULL),
(5, 4, '67', '2017-08-17', 'Perihal 5', 'lamp 5', 1, 1, 2, '', '', NULL, '', NULL),
(6, 3, '7435', '2017-09-04', 'Perihal saja', '', 1, 1, 2, '', '', NULL, '', NULL),
(8, 4, '777', '2017-09-07', 'Perihal penting', '', 2, 1, 2, '', '', NULL, '', NULL),
(9, 3, '555', '2017-09-09', 'Perihal 9', '', 2, 2, 2, '', '', NULL, '', NULL),
(10, 5, '899', '2017-09-05', 'Perihal 899', '', 1, 1, 5, NULL, NULL, NULL, '', NULL),
(11, 2, '9456', '2017-09-04', 'Perihal 9456', '', 1, 1, 2, NULL, NULL, NULL, '', NULL),
(12, 5, '477', '2017-09-11', 'Perihal 477', '', 1, 1, 3, NULL, NULL, NULL, '', NULL),
(14, 2, '382', '2017-11-07', 'Perihal 382', '', 1, 1, 2, '', '', NULL, '20170808_slide_hulk.jpg', 'gd_QgUfzmA4nGapKLwAs-IXV3RuI5KVD.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tingkat_keamanan`
--

CREATE TABLE `tingkat_keamanan` (
  `id` int(11) NOT NULL,
  `nama_tingkat` varchar(50) NOT NULL,
  `nilai_tingkat` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tingkat_keamanan`
--

INSERT INTO `tingkat_keamanan` (`id`, `nama_tingkat`, `nilai_tingkat`) VALUES
(1, 'Biasa', 10),
(2, 'Rahasia', 20),
(3, 'Sangat Rahasia', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tujuan_surat`
--

CREATE TABLE `tujuan_surat` (
  `id` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_penerima` int(11) DEFAULT NULL,
  `penerima_manual` varchar(255) DEFAULT NULL,
  `alamat_manual` varchar(255) DEFAULT NULL,
  `status_tujuan` tinyint(4) DEFAULT NULL,
  `status_baca` tinyint(4) DEFAULT NULL,
  `tgl_diterima` datetime DEFAULT NULL,
  `tgl_diteruskan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tujuan_surat`
--

INSERT INTO `tujuan_surat` (`id`, `id_surat`, `id_penerima`, `penerima_manual`, `alamat_manual`, `status_tujuan`, `status_baca`, `tgl_diterima`, `tgl_diteruskan`) VALUES
(1, 2, 23, NULL, NULL, 0, NULL, NULL, NULL),
(2, 3, 56, NULL, NULL, 0, NULL, NULL, NULL),
(3, 4, 34, NULL, NULL, 0, NULL, NULL, NULL),
(4, 4, 67, NULL, NULL, 0, NULL, NULL, NULL),
(5, 5, 34, NULL, NULL, 0, NULL, NULL, NULL),
(6, 5, 56, NULL, NULL, 0, NULL, NULL, NULL),
(11, 8, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(12, 8, 3, NULL, NULL, 0, NULL, '2017-09-08 00:00:00', NULL),
(13, 9, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(14, 9, 3, NULL, NULL, 0, NULL, '2017-09-10 00:00:00', NULL),
(15, 10, 6, NULL, NULL, 0, NULL, NULL, NULL),
(16, 11, 6, NULL, NULL, 0, NULL, NULL, NULL),
(17, 11, 7, NULL, NULL, 0, NULL, NULL, NULL),
(18, 12, 6, NULL, NULL, 0, NULL, NULL, NULL),
(19, 12, 7, NULL, NULL, 0, NULL, NULL, NULL),
(20, 14, 3, NULL, NULL, NULL, NULL, '2017-11-09 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id` smallint(6) NOT NULL,
  `unit_kerja` varchar(255) NOT NULL,
  `id_induk` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_kerja`
--

INSERT INTO `unit_kerja` (`id`, `unit_kerja`, `id_induk`) VALUES
(1, 'Provinsi NTB', 0),
(2, 'Sekretariat Daerah', 1),
(3, 'Biro Umum', 2),
(4, 'Biro Organisasi', 2),
(5, 'Dinas Kominfotik', 1),
(6, 'Bagian Keuangan', 3),
(7, 'Bagian Rumah Tangga', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_id` smallint(6) NOT NULL,
  `role_id` smallint(6) NOT NULL,
  `status_id` smallint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `unit_id`, `role_id`, `status_id`, `created_at`, `updated_at`) VALUES
(2, 'yasrul', 'UqzdPXfxR1V_AsgDagf2BGnTjsBGrJDQ', '$2y$13$uh7OXxGwgwHgkicXhO3tfex7IOimuILC2s.WgdfrqwENDjR6n099G', NULL, 'yasrul93@gmail.com', 3, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'amiruddin', 'IvGFzQ3uvJPi_P3JmqKEXdK0V9YYF7St', '$2y$13$ArWhFm0bGSl9jpZF/xIH1.hqboi..Fi0/oz59JQXnkl4OyArqWzA.', NULL, 'amir@ntbprov.go.id', 3, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Administrator', 'N5yGLBNsIa7oyk35Eq3wiBfZW9cq0Ynp', '$2y$13$QjgGiHcANDFYU5bURinx0Oj3fLE7mLFp9cVyLkAc5w39Kd72IS.xu', NULL, 'yasrul@gmail.com', 5, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'abdullah', '6URjxAyu8dR9n9x_5JYnc68Im6eKhMoY', '$2y$13$xx87TaYGKgmA.ZRRSvUDEuhWtyo9Qs1NyHe4WYKl8buRmZ6v1Og3y', NULL, 'abdullah@gmail.com', 4, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_regin` (`id_surat`),
  ADD KEY `id_pemberi` (`id_pemberi`);

--
-- Indexes for table `disposisi_tujuan`
--
ALTER TABLE `disposisi_tujuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kecepatan_sampai`
--
ALTER TABLE `kecepatan_sampai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender_id_idx` (`gender_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_akses`
--
ALTER TABLE `status_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_reg`
--
ALTER TABLE `status_reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_surat`
--
ALTER TABLE `status_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_tujuan`
--
ALTER TABLE `status_tujuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_user`
--
ALTER TABLE `status_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kecepatan_tanggapan` (`kecepatan_sampai`),
  ADD KEY `tingkat_keamanan` (`tingkat_keamanan`),
  ADD KEY `id_pengirim` (`id_pengirim`);

--
-- Indexes for table `tingkat_keamanan`
--
ALTER TABLE `tingkat_keamanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tujuan_surat`
--
ALTER TABLE `tujuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_surat` (`id_surat`),
  ADD KEY `id_penerima` (`id_penerima`),
  ADD KEY `status` (`status_tujuan`);

--
-- Indexes for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `disposisi_tujuan`
--
ALTER TABLE `disposisi_tujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `kecepatan_sampai`
--
ALTER TABLE `kecepatan_sampai`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status_akses`
--
ALTER TABLE `status_akses`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status_surat`
--
ALTER TABLE `status_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status_tujuan`
--
ALTER TABLE `status_tujuan`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `status_user`
--
ALTER TABLE `status_user`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tingkat_keamanan`
--
ALTER TABLE `tingkat_keamanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tujuan_surat`
--
ALTER TABLE `tujuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `gender_id_fk` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`);

--
-- Constraints for table `tujuan_surat`
--
ALTER TABLE `tujuan_surat`
  ADD CONSTRAINT `fk_surat_tujuansurat` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
