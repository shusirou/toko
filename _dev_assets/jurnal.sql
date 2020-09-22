-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27 Des 2019 pada 09.21
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
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `kd_jenis_buku` int(11) NOT NULL,
  `jenis_mutasi` enum('debit','kredit') NOT NULL,
  `kd_rekening` varchar(255) NOT NULL,
  `tanggal_jurnal` date NOT NULL,
  `keterangan` text,
  `nominal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id`, `business_id`, `kd_jenis_buku`, `jenis_mutasi`, `kd_rekening`, `tanggal_jurnal`, `keterangan`, `nominal`) VALUES
(1, 0, 111, 'debit', '111.01', '2019-12-26', 'zzzzz', 0),
(2, 0, 111, 'debit', '111.01', '2019-12-26', 'sss', 100000),
(3, 0, 111, 'debit', '111.01', '2019-12-26', 'dsas', 1000000),
(4, 0, 121, 'debit', '121.01', '2019-12-26', 'xczc', 100000),
(5, 0, 111, 'debit', '111.01', '2019-12-26', 'cccc', 0),
(6, 0, 111, 'debit', '111.01', '2019-12-26', 'fdsfds', 0),
(7, 0, 111, 'debit', '111.01', '2019-12-26', 'gfds', 50000),
(8, 0, 121, 'debit', '121.01', '2019-12-26', 'vxcvxcv', 40000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
