-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Feb 2024 pada 19.20
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
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`id`, `username`, `name`, `email`, `password`, `role`) VALUES
(5, 'admin', 'admin', 'admin@gmail.com', '$2y$10$u.NrkwyRjlObm3KTsK2RKuGoaYi5u32zPUy6rqr1Pk2BOQbxHWZnS', 'admin'),
(6, 'user4', 'admin', 'mccalister2306@gmail.com', '$2y$10$AMKt2RZHaNQvO4jqLrbCnOBKdRrl0gtEwYtcOGJ5uYKnPIXFrU7V6', 'user'),
(7, 'ardi', 'admin', 'ardiansyah3151@gmail.com', '$2y$10$h0IsgzQlRFeWR2oye0UeEODZX4e6QEsJk00/iBuu1Y/fzgJis8ljq', 'user'),
(8, 'bb', 'admin', 'hiatushiatusx@gmail.com', '$2y$10$ujrUdNPueNs0rTsiaZyEE.G8O26gxsm7//UbgthTKhKCaKkWeBfna', 'user');

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
(22, 'bang al', 'jauh bang', 'perempuan', 'ardiansyah3151@gmail.com', '1231241', 'web-development');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_peserta`
--
ALTER TABLE `tb_peserta`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
