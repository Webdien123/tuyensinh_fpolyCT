-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 08:21 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ts_fpoly_ct`
--

-- --------------------------------------------------------

--
-- Table structure for table `diadiem`
--

CREATE TABLE `diadiem` (
  `id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ten_diadiem` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `diadiem`
--

INSERT INTO `diadiem` (`id`, `ten_diadiem`, `diachi`, `lat`, `lng`) VALUES
('ChIJ3_-va0eIoDERLTMF62B5pk0', 'Trường Cao Đẳng Thực Hành FPT Polytechnic Cần Thơ', '288 Đường Nguyễn Văn Linh, Hưng Lợi, Ninh Kiều, Cần Thơ, Vietnam', 10.0268264, 105.75735280000004),
('ChIJjaeJWSOIoDERTXvCzVOjwF4', 'Language Center New Windows', '126A, Ba Tháng Hai, Xuân Khánh, Ninh Kiều, Cần Thơ, Vietnam', 10.0284491, 105.77110540000001),
('ChIJJXL3RTuIoDERsnnoMCjAYLU', 'Trường Cao Đẳng Thực Hành FPT Polytechnic Cần Thơ', '288 Đường Nguyễn Văn Linh, Hưng Lợi, Ninh Kiều, Cần Thơ, Vietnam', 10.0269704, 105.76979310000002),
('ChIJx1hrn55ioDERDwOTEGf_zts', 'A105 Hai Bà Trưng', 'A105 Hai Bà Trưng, Tân An, Ninh Kiều, Cần Thơ, Vietnam', 10.02722, 105.786382);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `ten_level` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ghichu` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level`, `ten_level`, `ghichu`) VALUES
('1', 'Quản trị viên', 'Người có toàn quyền trên hệ thống, được phép sử dụng tất cả chức năng được cung cấp: từ quản lý người dùng, lịch sử thao tác và địa chỉ đánh dấu.'),
('2', 'Nhân viên tuyển sinh', 'Người chỉ được phép quản lý thông tin các địa điểm do mình đánh dấu, xem thông tin gmap và sử dụng các chức năng cơ bản.');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `uname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `level` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`uname`, `hoten`, `pass`, `level`) VALUES
('a', 'Quản Trị 1', '$2y$10$KgyQOTBydKkXzqsJ7DaMy.IT5mP.FaGjfBEYxaT/fSF8iCUR11dMe', '1'),
('b', 'Nhân viên 1', '$2y$10$d.9./Yar6e12cLi1uVORqevfEVJqMGuSDeBRwUmO/vgo4PJ6yg89K', '2'),
('c', 'Quản Trị 2', '$2y$10$RU01KMe9NMJTuWchHY2Fd.4QJXXaAUFw83CWyY9aMuzuujXOeCLuK', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tuyensinh`
--

CREATE TABLE `tuyensinh` (
  `stt` int(11) NOT NULL,
  `id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `chiso1` int(11) NOT NULL,
  `chiso2` int(11) NOT NULL,
  `namhoc` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `ghichu` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tuyensinh`
--

INSERT INTO `tuyensinh` (`stt`, `id`, `chiso1`, `chiso2`, `namhoc`, `ghichu`) VALUES
(1, 'ChIJ3_-va0eIoDERLTMF62B5pk0', 129, 80, '2018', 'ABC'),
(2, 'ChIJjaeJWSOIoDERTXvCzVOjwF4', 150, 100, '2018', NULL),
(3, 'ChIJJXL3RTuIoDERsnnoMCjAYLU', 120, 80, '2018', 'ABC'),
(9, 'ChIJx1hrn55ioDERDwOTEGf_zts', 33, 33, '2018', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diadiem`
--
ALTER TABLE `diadiem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`uname`),
  ADD KEY `level_nguoidung` (`level`);

--
-- Indexes for table `tuyensinh`
--
ALTER TABLE `tuyensinh`
  ADD PRIMARY KEY (`stt`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tuyensinh`
--
ALTER TABLE `tuyensinh`
  MODIFY `stt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `level_nguoidung` FOREIGN KEY (`level`) REFERENCES `level` (`level`);

--
-- Constraints for table `tuyensinh`
--
ALTER TABLE `tuyensinh`
  ADD CONSTRAINT `tuyensinh_ibfk_1` FOREIGN KEY (`id`) REFERENCES `diadiem` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
