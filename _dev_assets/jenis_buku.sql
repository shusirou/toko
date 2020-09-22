-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03 Jan 2020 pada 04.37
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
-- Struktur dari tabel `jenis_buku`
--

CREATE TABLE `jenis_buku` (
  `id` int(2) NOT NULL,
  `unit` varchar(1) NOT NULL DEFAULT '1' COMMENT 'Dana Bergulir (1), Sektor Riil (2), Penjaminan (3), UPK-Pay (4), Minimarket (5), Apotek (6)',
  `posisi` varchar(1) NOT NULL COMMENT 'Aktiva (1), Hutang(2), Modal (3), Pendapatan (4), Biaya (5)',
  `kd_jr` varchar(2) NOT NULL,
  `kd_jb` varchar(20) NOT NULL,
  `ins` varchar(3) NOT NULL,
  `nama_jb` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `ap` int(1) NOT NULL DEFAULT '0' COMMENT 'Apakah termasuk Aset Produktif (Kas, Bank, Produk). Ya(1), Tidak (0)',
  `file` varchar(50) NOT NULL,
  `lokasi` text NOT NULL,
  `kd_kab` int(10) NOT NULL DEFAULT '0',
  `kecuali` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_buku`
--

INSERT INTO `jenis_buku` (`id`, `unit`, `posisi`, `kd_jr`, `kd_jb`, `ins`, `nama_jb`, `icon`, `ap`, `file`, `lokasi`, `kd_kab`, `kecuali`) VALUES
(1, '6', '1', 'K', '111', 'KT', 'Kas Toko', '<i class=\'glyphicon glyphicon-briefcase\'></i>', 1, '', '0', 0, ''),
(2, '6', '1', 'B', '121', 'BO', 'Bank', '<i class=\'fa fa-bank\'></i>', 1, '', '0', 0, ''),
(3, '6', '1', 'P', '131', 'PS', 'Persediaan', '<i class=\'fa fa-credit-card\'></i>', 1, '', '0', 0, ''),
(4, '6', '1', 'P', '132', 'PD', 'Piutang Dagang', '<i class=\'fa fa-credit-card\'></i>', 1, '', '0', 0, ''),
(5, '6', '1', 'P', '133', 'PL', 'Piutang Lain-lain', '<i class=\'fa fa-credit-card\'></i>', 1, '', '0', 0, ''),
(6, '6', '1', 'BM', '141', 'BBM', 'Biaya Dibayar Dimuka', '<i class=\'fa fa-history\'></i>', 0, '', '0', 0, ''),
(7, '6', '1', 'I', '151', 'I', 'Inventaris', '<i class=\'fa fa-car\'></i>', 0, '', '0', 0, ''),
(8, '6', '1', 'AT', '161', 'AT', 'Aktiva Tetap', '<i class=\'fa fa-cubes\'></i>', 0, '', '0', 0, ''),
(9, '6', '1', 'AR', '171', 'AR', 'Aktiva Tetap', '<i class=\'fa fa-cubes\'></i>', 0, '', '0', 0, ''),
(10, '6', '2', 'H', '211', 'HK', 'Hutang Barang Dagang', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(11, '6', '2', 'H', '212', 'HDS', 'Hutang Deviden', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(12, '6', '2', 'H', '213', 'HBU', 'Hutang Lain-lain', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(13, '6', '3', 'M', '311', 'MS', 'Modal Prive', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(14, '6', '3', 'M', '312', 'HM', 'Hibah Modal', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(15, '6', '3', 'M', '313', 'ML', 'Modal Lain-lain', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(16, '6', '3', 'M', '314', 'MSD', 'Surplus/Devisit Ditahan', '<i class=\'fa fa-book\'></i>', 0, '', '0', 0, ''),
(17, '6', '4', 'PD', '411', 'PO', 'Pendapatan Operasional', '<i class=\'fa fa-download\'></i>', 0, '', '0', 0, ''),
(18, '6', '4', 'PD', '412', 'PNO', 'Pendapatan Non Operasional', '<i class=\'fa fa-download\'></i>', 0, '', '0', 0, ''),
(19, '6', '5', 'BY', '511', 'BYD', 'Biaya Modal', '<i class=\'fa fa-upload\'></i>', 0, '', '0', 0, ''),
(20, '6', '5', 'BY', '512', 'BYO', 'Biaya Operasional', '<i class=\'fa fa-upload\'></i>', 0, '', '0', 0, ''),
(21, '6', '5', 'BY', '513', 'BYP', 'Biaya Penghapusan Barang Dagang', '<i class=\'fa fa-upload\'></i>', 0, '', '0', 0, ''),
(22, '6', '5', 'BY', '514', 'BNO', 'Biaya Non Operasional', '<i class=\'fa fa-upload\'></i>', 0, '', '0', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_buku`
--
ALTER TABLE `jenis_buku`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
