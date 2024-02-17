-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Feb 2024 pada 08.25
-- Versi server: 10.4.22-MariaDB-log
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bimbel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_login`
--

CREATE TABLE `tb_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sekolah` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `code_otp_reset` varchar(255) DEFAULT NULL,
  `status` enum('notverified','verified') NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`id`, `username`, `name`, `sekolah`, `email`, `photo_path`, `password`, `otp_code`, `code_otp_reset`, `status`, `role`) VALUES
(7, 'ardi', 'admin', NULL, 'ardiansyah3151@gmail.com', NULL, '$2y$10$RCIplLIxRilGiM1aqsetsOvx.a8qekwYu28ICLo8EaQYGgF0wZR9.', NULL, NULL, 'notverified', 'user'),
(8, 'bb', 'admin', NULL, 'hiatushiatusx@gmail.com', NULL, '$2y$10$ujrUdNPueNs0rTsiaZyEE.G8O26gxsm7//UbgthTKhKCaKkWeBfna', NULL, NULL, 'notverified', 'user'),
(9, 'test', 'test', NULL, 'user@gmail.com', NULL, '$2y$10$8KFOoF9I8B8YjKeIpTT1Y.7Ua.RaLfdFzfni2Da0xGzxrbiMHFxyW', NULL, NULL, 'notverified', 'user'),
(10, 'user99', 'asdw', NULL, 'aaa@gmail.com', NULL, '$2y$10$J8U2g7gZIn4xdsE3/2VKQuI280QSWtlleZlOKUg8lPha19aAU/Qfe', NULL, NULL, 'notverified', 'user'),
(11, '123124', 'jojo', NULL, 'ada@gmail.com', NULL, '$2y$10$FT0LhGZAR/kCEK9apPrHxOk.N51.8IdPK/FDbYxr19sBZ0WYSUNHe', NULL, NULL, 'notverified', 'user'),
(12, 'aaaw', 'ardi', NULL, '32@gmail.com', NULL, '$2y$10$wr8jeu7QrBNqpieeaauSoePNOu4o462bIJtyouN0E39lY3TK/tUt2', NULL, NULL, 'notverified', 'user'),
(13, 'jojojo', 'jajang', NULL, '89@gmail.com', NULL, '$2y$10$GehzKhnhBY08mtiRy8Hj.uFP0WSm6onPPzS3jocembb/Ox2Lv5p2K', NULL, NULL, 'notverified', 'user'),
(20, 'jojo', 'admin', NULL, 'mccalister2306@gmail.com', NULL, '$2y$10$Xwjb5SJgOu12oy.xmDMPb.I4bT8UcNXVHssvF4XatTU56atnqPS0O', '184913', NULL, 'verified', 'user'),
(21, 'babang', 'ardi', NULL, 'lolituketawa1106@gmail.com', NULL, '$2y$10$kzq0U6ViE0AEWPeFLwIgmOJVoiUmZJbdxFO8o0u/NBbb334LGmWKG', '647454', NULL, 'notverified', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peserta`
--

CREATE TABLE `tb_peserta` (
  `id` int(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `sekolah` varchar(255) NOT NULL,
  `gender` enum('laki-laki','perempuan') NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `bidang` enum('web-development','data-science','full-stack-development','mobile-app-development','cyber-security','devops','ui-ux-design','game-development') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_peserta`
--

INSERT INTO `tb_peserta` (`id`, `nama`, `sekolah`, `gender`, `email`, `no_hp`, `bidang`) VALUES
(19, 'awda', 'aa', 'perempuan', 'ardiansyah3151@gmail.com', '1231241', 'data-science'),
(20, 'bang al', 'awda', 'perempuan', 'admin@gmail.com', '1231241', 'data-science'),
(22, 'bang al', 'jauh bang', 'perempuan', 'ardiansyah3151@gmail.com', '1231241', 'web-development'),
(23, 'ciauw', 'jauh bang', 'laki-laki', 'antnjg2306@gmail.com', '1231241', 'data-science'),
(24, 'bang al', 'jauh bang', 'perempuan', 'a@gmail.com', '1231241', 'data-science');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_peserta`
--
ALTER TABLE `tb_peserta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tb_peserta`
--
ALTER TABLE `tb_peserta`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
