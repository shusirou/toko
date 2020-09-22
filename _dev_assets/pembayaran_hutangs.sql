-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2020 at 08:58 AM
-- Server version: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.27-6+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `pembayaran_hutangs`
--

CREATE TABLE `pembayaran_hutangs` (
  `id` int(11) NOT NULL,
  `id_payment` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `cara_bayar` varchar(50) DEFAULT NULL,
  `no_rekening` varchar(191) DEFAULT NULL,
  `atas_nama_rekening` varchar(191) DEFAULT NULL,
  `kd_invoice` varchar(191) DEFAULT NULL,
  `kd_buku` varchar(191) DEFAULT NULL,
  `kd_rekening` varchar(191) DEFAULT NULL,
  `nominal` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_hutangs`
--

INSERT INTO `pembayaran_hutangs` (`id`, `id_payment`, `tgl_bayar`, `cara_bayar`, `no_rekening`, `atas_nama_rekening`, `kd_invoice`, `kd_buku`, `kd_rekening`, `nominal`, `created_at`, `updated_at`) VALUES
(9, 7, '2020-03-07', 'kas', NULL, NULL, 'PP2020/0006', '211', '211.02', 1000, '2020-03-07 03:45:24', '2020-03-07 03:45:24'),
(11, 7, '2020-03-07', 'bank', '8388383', 'BCA - Atas nama Paimin', 'PP2020/0006', '211', '211.03', 1000, '2020-03-07 03:47:45', '2020-03-07 03:47:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembayaran_hutangs`
--
ALTER TABLE `pembayaran_hutangs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran_hutangs`
--
ALTER TABLE `pembayaran_hutangs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
