-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2023 at 03:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cheetah_net`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_devices`
--

CREATE TABLE `tbl_devices` (
  `deviceid` int(20) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `mastid` varchar(20) DEFAULT NULL,
  `wireless_mode` varchar(20) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `connected_from` varchar(20) NOT NULL,
  `connection_status` varchar(12) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_devices`
--

INSERT INTO `tbl_devices` (`deviceid`, `device_name`, `mastid`, `wireless_mode`, `ip_address`, `connected_from`, `connection_status`, `dateCreated`) VALUES
(2, 'swv cyber ap', '1', 'AP', '192.168.93.14', '0', 'Online', '2023-02-16 16:24:29'),
(4, 'CHT TINGANGA TOWN', '8', 'AP', '192.168.13.77', '0', 'Online', '2023-02-15 17:18:18'),
(5, 'CHT Tingz-Ikinu', '8', 'AP', '192.168.20.88', '0', 'Online', '2023-02-15 17:34:10'),
(6, 'cht kiambu high wanjo ap', '20', 'AP', '192.168.15.72', '0', 'Online', '2023-02-15 17:13:21'),
(7, 'sector6_ngegu', '2', 'AP', '192.168.89.149', '0', 'Online', '2023-02-16 16:14:20'),
(13, 'Cht Fuse Ap', '4', 'AP', '192.168.16.6', '0', 'Online', '2023-02-15 17:09:27'),
(15, 'Soft Kia mapa', '1', 'AP', '192.168.10.74', '0', 'Online', '2023-02-15 17:05:20'),
(16, 'Denali M5', '16', 'AP', '192.168.89.62', '0', 'Online', '2023-02-16 16:14:38'),
(17, 'CHT GICOCO AP', '4', 'AP', '192.168.12.58', '0', 'Online', '2023-02-15 17:10:56'),
(18, 'swv_Sector1_kangoya', '4', 'AP', '192.168.20.18', '0', 'Online', '2023-02-15 17:19:01'),
(19, 'Ting\'ang\'a_secondary', '17', 'AP', '192.168.14.22', '0', 'Online', '2023-02-16 16:15:23'),
(20, 'tinganga rocket ap', '4', 'AP', '192.168.13.90', '0', 'Online', '2023-02-15 17:21:50'),
(21, 'kamiti kona ap  M2', '7', 'AP', '192.168.93.119', '0', 'Online', '2023-02-15 17:23:08'),
(22, 'kamitiapM5', '7', 'AP', '192.168.89.189', '0', 'Online', '2023-02-15 17:23:44'),
(23, 'kamiti_ap_swv', '7', 'AP', '192.168.89.233', '0', 'Online', '2023-02-15 17:24:32'),
(24, 'CHT RURIGI', '17', 'AP', '192.168.17.204', '0', 'Online', '2023-02-16 16:16:14'),
(25, 'CHT NDB KBU', '4', 'AP', '192.168.20.3', '0', 'Offline', '2023-02-15 17:26:23'),
(26, 'cht mugumo carwash elsha', '3', 'AP', '192.168.93.146', '0', 'Online', '2023-02-15 17:27:21'),
(27, 'CHT BAHAMAS', '4', 'AP', '192.168.17.202', '0', 'Online', '2023-02-15 17:28:31'),
(28, 'CHT-ELD-HN', '3', 'AP', '192.168.94.129', '0', 'Online', '2023-02-15 17:29:07'),
(29, 'CHT-EL-LAP', '3', 'AP', '192.168.19.20', '0', 'Online', '2023-02-15 17:29:49'),
(30, 'CHT GICOCO ST ANNES', '8', 'AP', '192.168.15.160', '0', 'Online', '2023-02-15 17:30:37'),
(31, 'cht githunguri', '11', 'AP', '192.168.15.237', '0', 'Online', '2023-02-16 16:17:05'),
(32, 'Cht Ikinu CBD M5', '10', 'AP', '192.168.13.4', '0', 'Offline', '2023-02-16 16:17:38'),
(33, 'Kamiti Corner Ap (Cambium)', '3', 'AP', '192.168.92.2', '0', 'Online', '2023-02-15 17:36:10'),
(34, 'CHT-KAMITI-STATION (Cambium)', '7', 'Station', '192.168.92.3', '33', 'Online', '2023-02-16 16:18:52'),
(35, 'Kahawa west AP (Cambium)', '7', 'AP', '192.168.92.4', '0', 'Online', '2023-02-15 17:39:16'),
(36, 'Kahawa West Station', '16', 'Station', '192.168.92.5', '35', 'Online', '2023-02-16 16:18:34'),
(37, 'CHT_KANGOYA', '4', 'AP', '192.168.11.39', '0', 'Online', '2023-02-15 17:43:47'),
(38, 'Pami Ptp', '4', 'AP', '192.168.20.79', '0', 'Online', '2023-02-15 17:47:47'),
(39, 'RIABAI-AP', '18', 'AP', '192.168.95.138', '0', 'Online', '2023-02-16 16:12:18'),
(40, 'Riara secondary ptp', '4', 'AP', '192.168.15.171', '0', 'Online', '2023-02-15 17:49:01'),
(41, 'Sector8_Kirigiti', '20', 'AP', '192.168.89.133', '0', 'Online', '2023-02-16 16:12:48'),
(42, 'sector7', '20', 'AP', '192.168.89.78', '0', 'Online', '2023-02-16 16:13:06'),
(43, 'cht Sector1_loreto AP', '2', 'AP', '192.168.13.100', '0', 'Online', '2023-02-15 17:53:58'),
(44, 'CHT TINGANGA 1', '8', 'AP', '192.168.13.109', '0', 'Online', '2023-02-15 17:55:17'),
(45, 'CHT TINGANGA M5 ap', '8', 'AP', '192.168.18.37', '0', 'Online', '2023-02-15 17:55:57'),
(46, 'CHT NDB  CHRIS AP', '4', 'AP', '192.168.92.241', '0', 'Online', '2023-02-15 17:58:34'),
(47, 'CHT TINGANGA M5 ap', '8', 'AP', '192.168.18.37', '0', 'Online', '2023-02-16 16:21:16'),
(48, 'EdenVille Kist', '2', 'AP', '192.168.16.218', '0', 'Online', '2023-02-16 16:22:35'),
(49, 'CHT_Kamae_ap', '16', 'AP', '192.168.89.99', '0', 'Online', '2023-02-16 16:25:48'),
(50, 'kwest horn ap rocket m5', '16', 'AP', '192.168.89.195', '0', 'Online', '2023-02-16 16:27:03'),
(51, 'cht_evastellathin_ap', '2', 'AP', '192.168.93.179', '0', 'Online', '2023-02-16 16:27:30'),
(52, 'Loreto Sector', '2', 'AP', '192.168.20.41', '0', 'Online', '2023-02-16 16:28:01'),
(53, 'CHT-kamae', '16', 'AP', '192.168.94.28', '0', 'Online', '2023-02-16 16:28:30'),
(54, 'KWEST GEN2', '16', 'AP', '192.168.94.247', '0', 'Online', '2023-02-16 16:29:23'),
(55, 'cht_thindigua_ap', '1', 'AP', '192.168.93.71', '0', 'Online', '2023-02-16 16:30:07'),
(56, 'Cht Loith ap', '18', 'AP', '192.168.16.240', '0', 'Online', '2023-02-16 16:31:23'),
(57, 'CHT-WHITE HOUSE', '18', 'AP', '192.168.93.68', '0', 'Online', '2023-02-16 16:33:27'),
(58, 'soft kirigiti', '18', 'AP', '192.168.20.111', '0', 'Online', '2023-02-16 16:35:14'),
(59, 'Ngegu Evastella', '2', 'AP', '192.168.89.24', '0', 'Online', '2023-02-16 16:36:29'),
(60, 'KANUNGA SECTOR', '4', 'AP', '192.168.89.11', '0', 'Online', '2023-02-16 16:37:02'),
(61, 'CHT RIVERSIDE', '1', 'AP', '192.168.93.94', '0', 'Online', '2023-02-16 16:37:36'),
(62, 'swvMugumo', '1', 'AP', '192.168.89.108', '0', 'Online', '2023-02-16 16:39:14'),
(63, 'St.Joseph', '8', 'AP', '192.168.15.226', '0', 'Online', '2023-02-16 16:40:32'),
(64, 'Ndumberi powerbeam', '4', 'AP', '192.168.12.251', '0', 'Online', '2023-02-16 16:41:06'),
(65, 'cht_thindigua', '22', 'AP', '192.168.17.78', '0', 'Offline', '2023-02-16 16:43:45'),
(66, 'Soft Kia mapa', '1', 'AP', '192.168.10.74', '0', 'Online', '2023-02-16 16:45:10'),
(67, 'CHT wambui court', '21', 'AP', '192.168.17.156', '0', 'Online', '2023-02-16 16:45:56'),
(68, 'kirigitisector4swv', '18', 'AP', '192.168.89.47', '0', 'Online', '2023-02-16 16:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_levels`
--

CREATE TABLE `tbl_levels` (
  `id` int(10) NOT NULL,
  `level_name` varchar(25) NOT NULL,
  `level_code` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_levels`
--

INSERT INTO `tbl_levels` (`id`, `level_name`, `level_code`, `status`) VALUES
(1, 'Admin', 'admin', 1),
(2, 'Staff', 'staff', 1),
(3, 'Tech', 'tech', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_masts`
--

CREATE TABLE `tbl_masts` (
  `mastid` int(30) NOT NULL,
  `mast_name` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `connection_via` varchar(20) NOT NULL,
  `connected_from` varchar(100) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_masts`
--

INSERT INTO `tbl_masts` (`mastid`, `mast_name`, `location`, `connection_via`, `connected_from`, `dateCreated`) VALUES
(1, 'Mapa Mast', '-1.171667867263045, 36.828626082244504', '', '1', '2023-02-15 16:49:29'),
(2, 'Evastella Mast', '-1.1773258552908072, 36.825553422691776', 'Fiber', '1', '2023-02-15 16:49:54'),
(3, 'Elshadai Mast', '-1.1679589645543966, 36.82804395677722', 'Fiber', '1', '2023-02-15 16:52:03'),
(4, 'Ndumberi Mast', '-1.1570284039922192, 36.811352014588586', 'Fiber', '1', '2023-02-05 10:46:06'),
(5, 'Kawaida Mast', '-1.1731401415664109, 36.75826842715459', 'Fiber', '1', '2023-01-31 18:46:01'),
(6, 'Banana Mast', '000000,111111', 'Fiber', '1', '2023-02-05 10:46:06'),
(7, 'Kamiti Corner Mast', '-1.1604079519263502, 36.88255789394747', 'Radio', '3', '2023-01-31 18:46:01'),
(8, 'Ting\'ang\'a Mast', '-1.1336194171074094, 36.81455916700365', 'Fiber', '4', '2023-02-05 10:46:06'),
(9, 'Raini Mast', '-1.1591006797720975, 36.74448821248496', 'Radio', '6', '2023-02-15 16:58:00'),
(10, 'Ikinu Mast', '-1.1006293213210596, 36.796469886572226', 'Radio', '5', '2023-02-15 16:58:36'),
(11, 'Githunguri Mast', '-1.0601437487320908, 36.77414067664376', 'Radio', '5', '2023-02-15 16:59:15'),
(12, 'Karanjee mast', '-1.1231602598849504, 36.645879218987616', 'Radio', '5', '2023-02-15 16:59:57'),
(13, 'Ngarariga Mast', '-1.086363, 36.624892', 'Radio', '12', '2023-02-15 17:00:42'),
(14, 'Kamandura Mast', '-1.1286880755408926, 36.63341847555408', 'Radio', '12', '2023-02-15 17:01:11'),
(15, 'Rironi Mast', '', 'Radio', '14', '2023-02-15 17:01:41'),
(16, 'Kahawa West Mast', '-1.1876820160091026, 36.90583556448791', 'Radio', '7', '2023-02-15 17:02:45'),
(17, 'Tinganga Secondary Mast', '-1.1399174720701726, 36.829515805052516', 'Radio', '8', '2023-02-15 17:20:08'),
(18, 'Kirigiti Mast', '-1.1701922294165128, 36.84125628963033', 'Fiber', '1', '2023-02-15 17:06:33'),
(19, 'Waironjo Mast', '-1.1711495273839847, 36.851061854671805', 'Fiber', '18', '2023-02-15 17:12:36'),
(20, 'Kirigiti Kwa Cyber Mast', '', 'Radio', '18', '2023-02-15 17:53:22'),
(21, 'Wambui Court', '', 'Fiber', '1', '2023-02-16 16:34:20'),
(22, 'Thindigua Mast (Nyawira Apts)', '', 'Radio', '1', '2023-02-16 16:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `full_names` varchar(100) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_level` varchar(3) NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT '1',
  `isFirstTimeLogin` varchar(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `full_names`, `phonenumber`, `user_email`, `user_password`, `user_level`, `active`, `isFirstTimeLogin`) VALUES
(1, 'pmugo', 'Patrick Mugo', '254700538015', 'e.patrickmugo@gmail.com', '89fca3f69e402d2a5da9eb709a88387a', '1', '1', '0'),
(22, 'pmuchiri', 'Pascal Muchiri', '254746839553', 'pmuchiri@squarefoot.co.ke', '25d55ad283aa400af464c76d713c07ad', '1', '1', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_devices`
--
ALTER TABLE `tbl_devices`
  ADD PRIMARY KEY (`deviceid`),
  ADD KEY `mastid` (`mastid`);

--
-- Indexes for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_masts`
--
ALTER TABLE `tbl_masts`
  ADD PRIMARY KEY (`mastid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_devices`
--
ALTER TABLE `tbl_devices`
  MODIFY `deviceid` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_masts`
--
ALTER TABLE `tbl_masts`
  MODIFY `mastid` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
