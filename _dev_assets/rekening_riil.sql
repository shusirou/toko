-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03 Jan 2020 pada 04.36
-- Versi Server: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siparmy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening_riil`
--

CREATE TABLE `rekening_riil` (
  `id` int(10) NOT NULL,
  `idrekening` int(11) NOT NULL,
  `kd_rr` varchar(2) NOT NULL,
  `nama_rr` varchar(50) NOT NULL,
  `posisi` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening_riil`
--

INSERT INTO `rekening_riil` (`id`, `idrekening`, `kd_rr`, `nama_rr`, `posisi`) VALUES
(1, 11, 'K', 'Kas', 1),
(2, 12, 'B', 'Bank', 1),
(3, 13, 'P', 'Pinjaman', 1),
(4, 14, 'BM', 'Biaya Dibayar Dimuka', 1),
(5, 15, 'I', 'Inventaris', 1),
(6, 16, 'AT', 'Aktiva Tetap', 1),
(7, 17, 'RA', 'Rupa-rupa Aktiva', 1),
(8, 21, 'HT', 'Hutang', 2),
(9, 31, 'MD', 'Modal', 3),
(10, 41, 'PD', 'Pendapatan', 4),
(11, 51, 'BY', 'Biaya', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rekening_riil`
--
ALTER TABLE `rekening_riil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rekening_riil`
--
ALTER TABLE `rekening_riil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
