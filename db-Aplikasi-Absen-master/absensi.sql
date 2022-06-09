-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2022 at 04:34 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_in`
--

CREATE TABLE `history_in` (
  `id_masuk` int(11) NOT NULL,
  `date_masuk` datetime NOT NULL,
  `username` varchar(50) NOT NULL,
  `level_user` enum('mahasiswa','dosen','tata_usaha','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_in`
--

INSERT INTO `history_in` (`id_masuk`, `date_masuk`, `username`, `level_user`) VALUES
(349, '2022-05-07 20:30:08', 'aji', 'tata_usaha'),
(350, '2022-05-07 20:32:12', 'fara', 'mahasiswa'),
(351, '2022-05-07 21:17:14', 'rangga', 'mahasiswa'),
(352, '2022-05-07 21:22:34', 'putri', 'mahasiswa'),
(353, '2022-05-17 14:39:27', 'putri', 'mahasiswa'),
(354, '2022-05-17 17:00:57', 'raga', 'dosen'),
(355, '2022-05-17 19:41:41', 'raga', 'dosen'),
(356, '2022-05-22 14:38:18', 'liza', 'dosen'),
(357, '2022-05-30 21:11:23', 'raga', 'dosen');

-- --------------------------------------------------------

--
-- Table structure for table `history_out`
--

CREATE TABLE `history_out` (
  `id_out` int(11) NOT NULL,
  `date_out` datetime NOT NULL,
  `username` varchar(50) NOT NULL,
  `level_user` enum('mahasiswa','dosen','tata_usaha','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_out`
--

INSERT INTO `history_out` (`id_out`, `date_out`, `username`, `level_user`) VALUES
(5, '2022-05-07 22:02:15', 'rangga', 'mahasiswa'),
(6, '2022-05-17 14:31:27', 'putri', 'mahasiswa'),
(7, '2022-05-17 17:01:05', 'raga', 'dosen'),
(8, '2022-05-17 19:41:48', 'raga', 'dosen'),
(9, '2022-05-22 14:38:27', 'liza', 'dosen');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `createDate` timestamp NULL DEFAULT current_timestamp(),
  `dateCheckout` timestamp NULL DEFAULT current_timestamp(),
  `IsActive` int(10) NOT NULL,
  `IsLogin` int(10) NOT NULL,
  `nim` varchar(15) NOT NULL,
  `level_user` enum('mahasiswa','dosen','tata_usaha','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `createDate`, `dateCheckout`, `IsActive`, `IsLogin`, `nim`, `level_user`) VALUES
(20, 'fara', 'fara', '2022-05-07 13:32:12', '2022-05-07 14:56:53', 1, 0, '3311801039', 'mahasiswa'),
(35, 'rangga', 'rangga', '2022-05-07 14:17:14', '2022-05-07 15:02:15', 1, 0, '213213213', 'mahasiswa'),
(36, 'liza', 'liza', '2022-05-22 07:38:18', '2022-05-22 07:38:27', 1, 0, '123213124', 'dosen'),
(37, 'putri', 'putri', '2022-05-17 07:39:27', '2022-05-17 07:31:27', 1, 0, '213214342', 'mahasiswa'),
(42, 'arun', 'arun', '2022-04-09 08:00:06', '2022-05-07 14:56:53', 1, 0, '123543', 'mahasiswa'),
(43, 'aji', 'aji', '2022-05-07 13:30:08', '2022-05-07 14:56:53', 1, 0, '22343', 'tata_usaha'),
(44, 'fachri', 'fachri', '2022-05-07 13:45:26', '2022-05-07 14:56:53', 1, 0, '12312', 'tata_usaha'),
(45, 'bina', 'bina', '2022-05-17 07:45:06', '2022-05-17 07:45:06', 1, 0, '231412', 'tata_usaha'),
(46, 'raga', 'raga', '2022-05-30 14:11:23', '2022-05-17 12:41:48', 1, 0, '46375', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_in`
--
ALTER TABLE `history_in`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indexes for table `history_out`
--
ALTER TABLE `history_out`
  ADD PRIMARY KEY (`id_out`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_in`
--
ALTER TABLE `history_in`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `history_out`
--
ALTER TABLE `history_out`
  MODIFY `id_out` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
