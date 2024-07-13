-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Jul 2024 pada 07.44
-- Versi server: 8.0.30
-- Versi PHP: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pt_fbs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int NOT NULL,
  `nama_aplikasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_perusahaan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `favicon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `maps` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `app_settings`
--

INSERT INTO `app_settings` (`id`, `nama_aplikasi`, `nama_perusahaan`, `deskripsi`, `logo`, `favicon`, `no_hp`, `alamat`, `maps`, `created_at`, `updated_at`) VALUES
(1, 'Web App', 'PT Four Best Synergy', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus aspernatur quasi, magnam porro labore placeat! At reiciendis voluptates non perferendis suscipit rem placeat, voluptatum ea, saepe, eligendi error cum minima.', 'logo.png', 'favicon.png', '0', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus aspernatur quasi, magnam porro labore placeat!', '', '2023-11-10 18:41:00', '2024-07-13 14:38:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berkas`
--

CREATE TABLE `berkas` (
  `id` int NOT NULL,
  `no_bukti` int NOT NULL,
  `tanggal_bukti` date NOT NULL,
  `npwp_dipotong` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berkas`
--

INSERT INTO `berkas` (`id`, `no_bukti`, `tanggal_bukti`, `npwp_dipotong`, `nama`, `created_at`, `updated_at`) VALUES
(2, 2000000001, '2024-05-27', '123456789015', 'KREASI FUNEDGE NUSANTARA', '2024-07-13 14:04:05', '2024-07-13 14:04:05'),
(4, 2000000001, '2024-05-27', '755808078085', 'KREASI FUNEDGE NUSANTARA', '2024-07-13 14:42:13', '2024-07-13 14:42:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `nama` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `nama`, `slug`) VALUES
(1, 'Admin', 'admin'),
(2, 'User', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` varchar(12) COLLATE utf8mb4_general_ci NOT NULL,
  `id_role` int NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `id_role`, `password`, `created_at`, `updated_at`) VALUES
('123456789012', 2, 'd38b0aa1902ed52a515a79c11fa1ee752954c8cce76fe095e61ca0c6bbdc080cda7afc2924541685edd889eccd9b93fce518fafbe11b90967a0a5aabf3347fcd', '2024-07-13 11:25:08', '2024-07-13 11:25:08'),
('123456789015', 2, '58fb41d4f6691ab64f67546e19619686db51ca86469e6f40e18db18a28f18793f3e4f09e1ef0cfdc60d994c07a5cc4ba26f72738f9b24df2a4366244eb37c220', '2024-07-13 11:54:25', '2024-07-13 11:55:26'),
('admin', 1, 'c98acc44522a00d059fbd601206d2898c1e0f49e9028513e624ed7796d151f17649624697c97c9bfe7a9a8fa4321ed8254b0021c86344af64d16437d6a600714', '2024-07-13 09:54:25', '2024-07-13 09:54:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
