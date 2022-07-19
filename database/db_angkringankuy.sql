-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2022 at 01:04 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_angkringankuy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(20) NOT NULL,
  `kategori` varchar(7) NOT NULL,
  `harga_produk` int(5) NOT NULL,
  `jumlah_produk` int(2) NOT NULL,
  `foto_produk` varchar(20) NOT NULL,
  `rating_produk` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`id_produk`, `nama_produk`, `kategori`, `harga_produk`, `jumlah_produk`, `foto_produk`, `rating_produk`) VALUES
(1, 'Es Teh Manis', 'Minuman', 3000, 4, 'estehmanis.jpg ', 4.33),
(2, 'Sate Ayam', 'Makanan', 3000, 5, 'sateayam.jpg', 3.5),
(3, 'Sate Ati ', 'Makanan', 2000, 1, 'sateati.jpg ', 0),
(4, 'Susu Jahe', 'Minuman', 3000, 7, 'susujahe.png ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id_pesanan` bigint(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total_harga` int(6) NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `status_pemesanan` varchar(15) NOT NULL,
  `pembayaran` varchar(20) NOT NULL,
  `konfirmasi` int(1) NOT NULL,
  `selesai` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id_pesanan`, `id_user`, `total_harga`, `tanggal_pemesanan`, `status_pemesanan`, `pembayaran`, `konfirmasi`, `selesai`) VALUES
(50901221, 5, 3000, '2022-01-09 16:13:27', 'Makan Di Tempat', '61db86fbf07e2.png', 1, 1),
(50906220, 5, 6000, '2022-06-09 17:38:29', 'Makan Di Tempat', 'Belum Dibayar', 0, 0),
(51001220, 5, 22000, '2022-01-10 08:29:24', 'Antar Ke Rumah', 'Belum Dibayar', 0, 0),
(51101220, 5, 14000, '2022-01-11 12:39:58', 'Antar Ke Rumah', '61dd1862c2eb3.png', 1, 1),
(51101221, 5, 6000, '2022-01-11 13:18:54', 'Makan Di Tempat', '61dd21792f6b5.png', 1, 1),
(52706220, 5, 9000, '2022-06-27 16:38:43', 'Makan Di Tempat', 'Belum Dibayar', 0, 0),
(71101220, 7, 5000, '2022-01-11 21:54:05', 'Antar Ke Rumah', '61dd9ae18a15b.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_sub_pesanan`
--

CREATE TABLE `tb_sub_pesanan` (
  `sub_id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(2) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_sub_pesanan`
--

INSERT INTO `tb_sub_pesanan` (`sub_id`, `id_pesanan`, `id_produk`, `jumlah`, `rating`) VALUES
(313, 50901221, 1, 1, 4),
(314, 51001220, 3, 3, 0),
(315, 51001220, 4, 1, 0),
(316, 51001220, 1, 1, 0),
(317, 51001220, 2, 2, 0),
(318, 51101220, 1, 1, 5),
(319, 51101220, 3, 1, 0),
(320, 51101220, 2, 2, 3),
(321, 51101220, 4, 1, 0),
(324, 51101221, 2, 1, 4),
(325, 51101221, 4, 1, 0),
(330, 71101220, 1, 1, 4),
(331, 71101220, 3, 1, 0),
(332, 50906220, 3, 3, 0),
(333, 52706220, 2, 2, 0),
(334, 52706220, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `email`, `password`, `nama`, `alamat`, `no_telp`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$r/OOngBn8Dm3fqHNwOow4upr9tT/ppDPfO8QNNtQV965bhNC/d6Fy', 'Admin', 'Rumah admin', '08123456789', 'admin'),
(5, 'trian', 'triankpam@gmail.com', '$2y$10$AOYbufdsTJgnJ63bkQOTUej39rTsg8.dbiiLH7qRt2YaM.JFp5mr.', 'Muhamad Trian', 'Jalan Benteng Jaya Rt.03 Rw.09 No.2\r\nTangerang, Banten 15111', '081234567', 'user'),
(6, 'user', 'user@gmail.com', '$2y$10$G4GBp3OD2PtT24l6/q/HTexwLcN4MbpYs3Lf1e3mCbsgg0fIO1ja.', 'Muhamad Trian Diwandanu', 'Jalan Benteng Jaya No.2\r\nTangerang Kota', '08123456788', 'user'),
(7, 'triandiwandanu', 'triandiwandanu@gmail.com', '$2y$10$uWkB8ow8Jwuc3ErCA8fDvuQxNKt.6tung6uOznxE2ZfdlqqFTzIqy', 'Diwandanu', 'Jalan Benteng Jaya RT.03 RW.09 No.2\r\nTangerang, Banten 15111', '081234', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `tb_sub_pesanan`
--
ALTER TABLE `tb_sub_pesanan`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_menu`
--
ALTER TABLE `tb_menu`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  MODIFY `id_pesanan` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220122101;

--
-- AUTO_INCREMENT for table `tb_sub_pesanan`
--
ALTER TABLE `tb_sub_pesanan`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
