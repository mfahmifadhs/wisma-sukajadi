-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2022 at 01:47 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kemenkes_sukajadi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mainunits`
--

CREATE TABLE `tbl_mainunits` (
  `id_mainunit` int(11) NOT NULL,
  `mainunit_name` text NOT NULL,
  `mainunit_head` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_mainunits`
--

INSERT INTO `tbl_mainunits` (`id_mainunit`, `mainunit_name`, `mainunit_head`) VALUES
(1, 'SEKRETARIAT JENDERAL', NULL),
(2, 'INSPEKTORAT JENDERAL', NULL),
(3, 'DIREKTORAT JENDERAL KESEHATAN MASYARAKAT', NULL),
(4, 'DIREKTORAT JENDERAL PENCEGAHAN DAN PENGENDALIAN PENYAKIT', NULL),
(5, 'DIREKTORAT JENDERAL PELAYANAN KESEHATAN', NULL),
(6, 'DIREKTORAT JENDERAL KEFARMASIAN DAN ALAT KESEHATAN', NULL),
(7, 'BADAN PENELITIAN DAN PENGEMBANGAN KESEHATAN', NULL),
(8, 'BADAN PENGEMBANGAN DAN PEMBERDAYAAN SDM KESEHATAN', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pnbp`
--

CREATE TABLE `tbl_pnbp` (
  `id_pnbp` int(11) NOT NULL,
  `transaction_num` varchar(30) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `transaction_img` text DEFAULT NULL,
  `pnbp_total_room` bigint(30) DEFAULT NULL,
  `pnbp_total_income` bigint(30) DEFAULT NULL,
  `pnbp_note` text DEFAULT NULL,
  `pnbp_date` date NOT NULL,
  `pnbp_status` enum('belum','proses','sudah') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_rates`
--

CREATE TABLE `tbl_rental_rates` (
  `id_rental_rate` varchar(5) NOT NULL,
  `rental_rate_ctg` enum('bisnis','non-bisnis','sosial') NOT NULL,
  `room_id` int(11) NOT NULL,
  `price_ctg` enum('kategori 1','kategori 2','kategori 3') DEFAULT NULL,
  `price` int(11) NOT NULL,
  `periodecity` enum('harian','8 jam') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rental_rates`
--

INSERT INTO `tbl_rental_rates` (`id_rental_rate`, `rental_rate_ctg`, `room_id`, `price_ctg`, `price`, `periodecity`) VALUES
('BN000', 'bisnis', 0, NULL, 946000, '8 jam'),
('BN001', 'bisnis', 1, NULL, 354000, 'harian'),
('BN002', 'bisnis', 2, NULL, 278000, 'harian'),
('BN003', 'bisnis', 3, NULL, 311000, 'harian'),
('BN004', 'bisnis', 4, NULL, 283000, 'harian'),
('BN005', 'bisnis', 5, NULL, 215000, 'harian'),
('BN006', 'bisnis', 6, NULL, 215000, 'harian'),
('BN007', 'bisnis', 7, NULL, 215000, 'harian'),
('BN008', 'bisnis', 8, NULL, 215000, 'harian'),
('BN009', 'bisnis', 9, NULL, 215000, 'harian'),
('BN010', 'bisnis', 10, NULL, 215000, 'harian'),
('BN011', 'bisnis', 11, NULL, 215000, 'harian'),
('BN012', 'bisnis', 12, NULL, 201000, 'harian'),
('BN013', 'bisnis', 13, NULL, 215000, 'harian'),
('BN014', 'bisnis', 14, NULL, 265000, 'harian'),
('BN015', 'bisnis', 15, NULL, 265000, 'harian'),
('BN016', 'bisnis', 16, NULL, 265000, 'harian'),
('BN017', 'bisnis', 17, NULL, 265000, 'harian'),
('BN018', 'bisnis', 18, NULL, 270000, 'harian'),
('BN019', 'bisnis', 19, NULL, 215000, 'harian'),
('BN020', 'bisnis', 20, NULL, 215000, 'harian'),
('BN021', 'bisnis', 21, NULL, 215000, 'harian'),
('BN022', 'bisnis', 22, NULL, 215000, 'harian'),
('BN023', 'bisnis', 23, NULL, 215000, 'harian'),
('NB100', 'non-bisnis', 0, 'kategori 1', 473000, '8 jam'),
('NB101', 'non-bisnis', 1, 'kategori 1', 177000, 'harian'),
('NB102', 'non-bisnis', 2, 'kategori 1', 139000, 'harian'),
('NB103', 'non-bisnis', 3, 'kategori 1', 155500, 'harian'),
('NB104', 'non-bisnis', 4, 'kategori 1', 141500, 'harian'),
('NB105', 'non-bisnis', 5, 'kategori 1', 107500, 'harian'),
('NB106', 'non-bisnis', 6, 'kategori 1', 107500, 'harian'),
('NB107', 'non-bisnis', 7, 'kategori 1', 107500, 'harian'),
('NB108', 'non-bisnis', 8, 'kategori 1', 107500, 'harian'),
('NB109', 'non-bisnis', 9, 'kategori 1', 107500, 'harian'),
('NB110', 'non-bisnis', 10, 'kategori 1', 107500, 'harian'),
('NB111', 'non-bisnis', 11, 'kategori 1', 107500, 'harian'),
('NB112', 'non-bisnis', 12, 'kategori 1', 100500, 'harian'),
('NB113', 'non-bisnis', 13, 'kategori 1', 107500, 'harian'),
('NB114', 'non-bisnis', 14, 'kategori 1', 132500, 'harian'),
('NB115', 'non-bisnis', 15, 'kategori 1', 132500, 'harian'),
('NB116', 'non-bisnis', 16, 'kategori 1', 132500, 'harian'),
('NB117', 'non-bisnis', 17, 'kategori 1', 132500, 'harian'),
('NB118', 'non-bisnis', 18, 'kategori 1', 135000, 'harian'),
('NB119', 'non-bisnis', 19, 'kategori 1', 107500, 'harian'),
('NB120', 'non-bisnis', 20, 'kategori 1', 107500, 'harian'),
('NB121', 'non-bisnis', 21, 'kategori 1', 107500, 'harian'),
('NB122', 'non-bisnis', 22, 'kategori 1', 107500, 'harian'),
('NB123', 'non-bisnis', 23, 'kategori 1', 107500, 'harian'),
('NB200', 'non-bisnis', 0, 'kategori 2', 378400, '8 jam'),
('NB201', 'non-bisnis', 1, 'kategori 2', 141600, 'harian'),
('NB202', 'non-bisnis', 2, 'kategori 2', 111200, 'harian'),
('NB203', 'non-bisnis', 3, 'kategori 2', 124400, 'harian'),
('NB204', 'non-bisnis', 4, 'kategori 2', 113200, 'harian'),
('NB205', 'non-bisnis', 5, 'kategori 2', 86000, 'harian'),
('NB206', 'non-bisnis', 6, 'kategori 2', 86000, 'harian'),
('NB207', 'non-bisnis', 7, 'kategori 2', 86000, 'harian'),
('NB208', 'non-bisnis', 8, 'kategori 2', 86000, 'harian'),
('NB209', 'non-bisnis', 9, 'kategori 2', 86000, 'harian'),
('NB210', 'non-bisnis', 10, 'kategori 2', 86000, 'harian'),
('NB211', 'non-bisnis', 11, 'kategori 2', 86000, 'harian'),
('NB212', 'non-bisnis', 12, 'kategori 2', 80400, 'harian'),
('NB213', 'non-bisnis', 13, 'kategori 2', 86000, 'harian'),
('NB214', 'non-bisnis', 14, 'kategori 2', 106000, 'harian'),
('NB215', 'non-bisnis', 15, 'kategori 2', 106000, 'harian'),
('NB216', 'non-bisnis', 16, 'kategori 2', 106000, 'harian'),
('NB217', 'non-bisnis', 17, 'kategori 2', 106000, 'harian'),
('NB218', 'non-bisnis', 18, 'kategori 2', 108000, 'harian'),
('NB219', 'non-bisnis', 19, 'kategori 2', 86000, 'harian'),
('NB220', 'non-bisnis', 20, 'kategori 2', 86000, 'harian'),
('NB221', 'non-bisnis', 21, 'kategori 2', 86000, 'harian'),
('NB222', 'non-bisnis', 22, 'kategori 2', 86000, 'harian'),
('NB223', 'non-bisnis', 23, 'kategori 2', 86000, 'harian'),
('NB300', 'non-bisnis', 0, 'kategori 3', 283800, 'harian'),
('NB301', 'non-bisnis', 1, 'kategori 3', 106200, 'harian'),
('NB302', 'non-bisnis', 2, 'kategori 3', 83400, 'harian'),
('NB303', 'non-bisnis', 3, 'kategori 3', 93300, 'harian'),
('NB304', 'non-bisnis', 4, 'kategori 3', 84900, 'harian'),
('NB305', 'non-bisnis', 5, 'kategori 3', 64500, 'harian'),
('NB306', 'non-bisnis', 6, 'kategori 3', 64500, 'harian'),
('NB307', 'non-bisnis', 7, 'kategori 3', 64500, 'harian'),
('NB308', 'non-bisnis', 8, 'kategori 3', 64500, 'harian'),
('NB309', 'non-bisnis', 9, 'kategori 3', 64500, 'harian'),
('NB310', 'non-bisnis', 10, 'kategori 3', 64500, 'harian'),
('NB311', 'non-bisnis', 11, 'kategori 3', 64500, 'harian'),
('NB312', 'non-bisnis', 12, 'kategori 3', 60300, 'harian'),
('NB313', 'non-bisnis', 13, 'kategori 3', 64500, 'harian'),
('NB314', 'non-bisnis', 14, 'kategori 3', 79500, 'harian'),
('NB315', 'non-bisnis', 15, 'kategori 3', 79500, 'harian'),
('NB316', 'non-bisnis', 16, 'kategori 3', 79500, 'harian'),
('NB317', 'non-bisnis', 17, 'kategori 3', 79500, 'harian'),
('NB318', 'non-bisnis', 18, 'kategori 3', 81000, 'harian'),
('NB319', 'non-bisnis', 19, 'kategori 3', 64500, 'harian'),
('NB320', 'non-bisnis', 20, 'kategori 3', 64500, 'harian'),
('NB321', 'non-bisnis', 21, 'kategori 3', 64500, 'harian'),
('NB322', 'non-bisnis', 22, 'kategori 3', 64500, 'harian'),
('NB323', 'non-bisnis', 23, 'kategori 3', 64500, 'harian'),
('SS100', 'sosial', 0, 'kategori 1', 94600, '8 jam'),
('SS101', 'sosial', 1, 'kategori 1', 35400, 'harian'),
('SS102', 'sosial', 2, 'kategori 1', 27800, 'harian'),
('SS103', 'sosial', 3, 'kategori 1', 31100, 'harian'),
('SS104', 'sosial', 4, 'kategori 1', 28300, 'harian'),
('SS105', 'sosial', 5, 'kategori 1', 28300, 'harian'),
('SS106', 'sosial', 6, 'kategori 1', 28300, 'harian'),
('SS107', 'sosial', 7, 'kategori 1', 28300, 'harian'),
('SS108', 'sosial', 8, 'kategori 1', 28300, 'harian'),
('SS109', 'sosial', 9, 'kategori 1', 28300, 'harian'),
('SS110', 'sosial', 10, 'kategori 1', 28300, 'harian'),
('SS111', 'sosial', 11, 'kategori 1', 28300, 'harian'),
('SS112', 'sosial', 12, 'kategori 1', 20100, 'harian'),
('SS113', 'sosial', 13, 'kategori 1', 28300, 'harian'),
('SS114', 'sosial', 14, 'kategori 1', 26500, 'harian'),
('SS115', 'sosial', 15, 'kategori 1', 26500, 'harian'),
('SS116', 'sosial', 16, 'kategori 1', 26500, 'harian'),
('SS117', 'sosial', 17, 'kategori 1', 26500, 'harian'),
('SS118', 'sosial', 18, 'kategori 1', 27000, 'harian'),
('SS119', 'sosial', 19, 'kategori 1', 28300, 'harian'),
('SS120', 'sosial', 20, 'kategori 1', 28300, 'harian'),
('SS121', 'sosial', 21, 'kategori 1', 28300, 'harian'),
('SS122', 'sosial', 22, 'kategori 1', 28300, 'harian'),
('SS123', 'sosial', 23, 'kategori 1', 28300, 'harian'),
('SS200', 'sosial', 0, 'kategori 2', 47300, '8 jam'),
('SS201', 'sosial', 1, 'kategori 2', 17700, 'harian'),
('SS202', 'sosial', 2, 'kategori 2', 13900, 'harian'),
('SS203', 'sosial', 3, 'kategori 2', 15550, 'harian'),
('SS204', 'sosial', 4, 'kategori 2', 14150, 'harian'),
('SS205', 'sosial', 5, 'kategori 2', 10750, 'harian'),
('SS206', 'sosial', 6, 'kategori 2', 10750, 'harian'),
('SS207', 'sosial', 7, 'kategori 2', 10750, 'harian'),
('SS208', 'sosial', 8, 'kategori 2', 10750, 'harian'),
('SS209', 'sosial', 9, 'kategori 2', 10750, 'harian'),
('SS210', 'sosial', 10, 'kategori 2', 10750, 'harian'),
('SS211', 'sosial', 11, 'kategori 2', 10750, 'harian'),
('SS212', 'sosial', 12, 'kategori 2', 10050, 'harian'),
('SS213', 'sosial', 13, 'kategori 2', 10750, 'harian'),
('SS214', 'sosial', 14, 'kategori 2', 13250, 'harian'),
('SS215', 'sosial', 15, 'kategori 2', 13250, 'harian'),
('SS216', 'sosial', 16, 'kategori 2', 13250, 'harian'),
('SS217', 'sosial', 17, 'kategori 2', 13250, 'harian'),
('SS218', 'sosial', 18, 'kategori 2', 13500, 'harian'),
('SS219', 'sosial', 19, 'kategori 2', 10750, 'harian'),
('SS220', 'sosial', 20, 'kategori 2', 10750, 'harian'),
('SS221', 'sosial', 21, 'kategori 2', 10750, 'harian'),
('SS222', 'sosial', 22, 'kategori 2', 10750, 'harian'),
('SS223', 'sosial', 23, 'kategori 2', 10750, 'harian');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservations`
--

CREATE TABLE `tbl_reservations` (
  `id_reservation` bigint(30) NOT NULL,
  `billing_code` varchar(30) DEFAULT NULL,
  `visitor_id` int(11) NOT NULL,
  `assignment_letter` text DEFAULT NULL,
  `total_room` int(11) DEFAULT NULL,
  `status_reservation` enum('cancel','payment','process','checkin','checkout','reserved') NOT NULL,
  `payment_status` enum('belum bayar','sudah bayar') NOT NULL,
  `payment_img` text DEFAULT NULL,
  `payment_total` int(11) DEFAULT NULL,
  `reservation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservations_details`
--

CREATE TABLE `tbl_reservations_details` (
  `id_detail_reservation` bigint(10) NOT NULL,
  `reservation_id` bigint(30) NOT NULL,
  `rental_rate_id` varchar(5) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `duration` int(11) NOT NULL,
  `detail_reservation_price` bigint(30) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id_role` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id_role`, `role_name`) VALUES
(1, 'admin master'),
(2, 'admin roum'),
(3, 'admin pnbp'),
(4, 'admin sukajadi'),
(5, 'pengunjung / tamu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `id_room` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `room_capacity` int(11) DEFAULT NULL,
  `room_img` text NOT NULL,
  `room_status` enum('tersedia','tidak tersedia','maintenance') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`id_room`, `room_name`, `room_capacity`, `room_img`, `room_status`) VALUES
(0, 'Aula / Kelas', 100, 'aula.jpg', 'tersedia'),
(1, 'Kamar 1', 2, 'kamar-1.jpg', 'tersedia'),
(2, 'Kamar 2', 4, 'kamar-2.jpg', 'tersedia'),
(3, 'Kamar 3', 6, 'kamar-3.jpg', 'tersedia'),
(4, 'Kamar 4', 5, 'kamar-4.jpg', 'tersedia'),
(5, 'Kamar 5', 2, 'kamar-5.jpg', 'tersedia'),
(6, 'Kamar 6', 2, 'kamar-6.jpg', 'tersedia'),
(7, 'Kamar 7', 2, 'kamar-7.jpg', 'tersedia'),
(8, 'Kamar 8', 3, 'kamar-8.jpg', 'tersedia'),
(9, 'Kamar 9', 3, 'kamar-9.jpg', 'tersedia'),
(10, 'Kamar 10', 1, 'kamar-10.jpg', 'maintenance'),
(11, 'Kamar 11', 2, 'kamar-11.jpg', 'tersedia'),
(12, 'Kamar 12', 2, 'kamar-12.jpg', 'tersedia'),
(13, 'Kamar 13', 3, 'kamar-13.jpg', 'tersedia'),
(14, 'Kamar 14', 4, 'kamar-14.jpg', 'tersedia'),
(15, 'Kamar 15', 4, 'kamar-15.jpg', 'tersedia'),
(16, 'Kamar 16', 4, 'kamar-16.jpg', 'tersedia'),
(17, 'Kamar 17', 4, 'kamar-17.jpg', 'tersedia'),
(18, 'Kamar 18', 2, 'kamar-18-23.jpg', 'tersedia'),
(19, 'Kamar 19', 2, 'kamar-18-23.jpg', 'tersedia'),
(20, 'Kamar 20', 2, 'kamar-18-23.jpg', 'tersedia'),
(21, 'Kamar 21', 2, 'kamar-18-23.jpg', 'tersedia'),
(22, 'Kamar 22', 2, 'kamar-18-23.jpg', 'tersedia'),
(23, 'Kamar 23', 2, 'kamar-18-23.jpg', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_historys`
--

CREATE TABLE `tbl_room_historys` (
  `id_room_history` int(11) NOT NULL,
  `reservation_id` bigint(30) NOT NULL,
  `history_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_room` int(11) NOT NULL,
  `room_reserved` int(11) NOT NULL,
  `room_notavailable` int(11) NOT NULL,
  `room_available` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surveys`
--

CREATE TABLE `tbl_surveys` (
  `id_survey` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `surver_purpose` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visitors`
--

CREATE TABLE `tbl_visitors` (
  `id_visitor` varchar(50) NOT NULL,
  `identity_num` bigint(20) DEFAULT NULL,
  `identity_img` text DEFAULT NULL,
  `visitor_name` varchar(255) DEFAULT NULL,
  `visitor_birthdate` date DEFAULT NULL,
  `visitor_phone_number` varchar(30) DEFAULT NULL,
  `visitor_address` text DEFAULT NULL,
  `visitor_instance` text DEFAULT NULL,
  `visitor_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visits`
--

CREATE TABLE `tbl_visits` (
  `id_visit` int(11) NOT NULL,
  `visit_date` datetime NOT NULL DEFAULT current_timestamp(),
  `visit_name` varchar(100) NOT NULL,
  `visit_phone_num` varchar(20) NOT NULL,
  `visit_vehicle_num` varchar(30) DEFAULT NULL,
  `visit_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workunits`
--

CREATE TABLE `tbl_workunits` (
  `id_workunit` int(11) NOT NULL,
  `mainunit_id` int(11) NOT NULL,
  `workunit_name` varchar(100) NOT NULL,
  `workunit_head` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_workunits`
--

INSERT INTO `tbl_workunits` (`id_workunit`, `mainunit_id`, `workunit_name`, `workunit_head`) VALUES
(1, 1, 'BIRO UMUM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role_id`, `status`) VALUES
(1, 'adminmaster', '$2y$10$TDSTtM74f1k9lWGWC4U6fup3jKJ9zlOurvVsAzrfzEJ.Gp.4VTte2', 'Super Admin', 1, 'aktif'),
(2, 'wisma_sukajadi1', '$2y$10$6wmkeH9K45dGhy6jbeESku4nJNh9cC2OROOHo96oJbYD3bwCurq6a', 'admin wisma sukajadi', 4, 'aktif'),
(3, 'pnbp_riris', '$2y$10$Vfhx/2XOKMxFleKeXXor6.XYrRXTnaalNoky7eQ00EmoaH4zR4UuG', 'riris', 3, 'aktif'),
(4, 'wisma_sukajadi2', '$2y$10$8/l9b0zagrCzjTHah6.IseY/AWyiAYmcLUfz009z3x2gs/xwSsNle', 'admin wisma sukajadi 2', 4, 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_mainunits`
--
ALTER TABLE `tbl_mainunits`
  ADD PRIMARY KEY (`id_mainunit`),
  ADD KEY `mainunit_head` (`mainunit_head`);

--
-- Indexes for table `tbl_pnbp`
--
ALTER TABLE `tbl_pnbp`
  ADD PRIMARY KEY (`id_pnbp`);

--
-- Indexes for table `tbl_rental_rates`
--
ALTER TABLE `tbl_rental_rates`
  ADD PRIMARY KEY (`id_rental_rate`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `visit_id` (`visitor_id`);

--
-- Indexes for table `tbl_reservations_details`
--
ALTER TABLE `tbl_reservations_details`
  ADD PRIMARY KEY (`id_detail_reservation`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `rental_rate_id` (`rental_rate_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`id_room`);

--
-- Indexes for table `tbl_room_historys`
--
ALTER TABLE `tbl_room_historys`
  ADD PRIMARY KEY (`id_room_history`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `tbl_surveys`
--
ALTER TABLE `tbl_surveys`
  ADD PRIMARY KEY (`id_survey`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Indexes for table `tbl_visitors`
--
ALTER TABLE `tbl_visitors`
  ADD PRIMARY KEY (`id_visitor`);

--
-- Indexes for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  ADD PRIMARY KEY (`id_visit`);

--
-- Indexes for table `tbl_workunits`
--
ALTER TABLE `tbl_workunits`
  ADD PRIMARY KEY (`id_workunit`),
  ADD KEY `mainunit_id` (`mainunit_id`),
  ADD KEY `workunit_head` (`workunit_head`),
  ADD KEY `workunit_head_2` (`workunit_head`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `emp_nip` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_mainunits`
--
ALTER TABLE `tbl_mainunits`
  MODIFY `id_mainunit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pnbp`
--
ALTER TABLE `tbl_pnbp`
  MODIFY `id_pnbp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  MODIFY `id_reservation` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290922110741;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_room_historys`
--
ALTER TABLE `tbl_room_historys`
  MODIFY `id_room_history` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_surveys`
--
ALTER TABLE `tbl_surveys`
  MODIFY `id_survey` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_visits`
--
ALTER TABLE `tbl_visits`
  MODIFY `id_visit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_workunits`
--
ALTER TABLE `tbl_workunits`
  MODIFY `id_workunit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
