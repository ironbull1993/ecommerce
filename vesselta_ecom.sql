-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 23, 2022 at 02:49 PM
-- Server version: 5.7.38
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vesselta_ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(493, 281, 4, 1),
(494, 281, 6, 5),
(497, 285, 10, 6),
(498, 286, 17, 1),
(510, 290, 1, 1),
(511, 290, 2, 1),
(512, 290, 3, 1),
(515, 292, 2, 1),
(516, 293, 1, 1),
(517, 293, 2, 1),
(519, 293, 4, 1),
(523, 296, 32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`) VALUES
(1, 'Laptops', 'laptops'),
(2, 'Desktop PC', 'desktop-pc'),
(3, 'Tablets', 'tablets'),
(4, 'Groceries ', 'Groceries '),
(6, 'Drinks', 'Drinks'),
(7, 'Dinning & Kitchen', 'Dinning & Kitchen'),
(8, 'Thermos', 'Thermos'),
(9, 'Stove', 'Stove'),
(10, 'Microwave & Oven', 'Microwave & Oven');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `sales_id`, `product_id`, `quantity`) VALUES
(18, 66, 1, 1),
(19, 67, 1, 1),
(20, 68, 6, 1),
(21, 69, 18, 1),
(22, 70, 1, 1),
(23, 70, 2, 1),
(24, 70, 3, 1),
(25, 71, 1, 1),
(26, 71, 2, 1),
(27, 71, 3, 1),
(28, 71, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `del_name` varchar(50) DEFAULT NULL,
  `phone` int(50) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  `pay_status` varchar(50) NOT NULL,
  `created_on` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `user_id`, `del_name`, `phone`, `code`, `pay_status`, `created_on`) VALUES
(11, '30', 'namkunda', 743997716, 'hKrDPH', 'Pending', '2022-05-04');

-- --------------------------------------------------------

--
-- Table structure for table `order_requests`
--

CREATE TABLE `order_requests` (
  `pay_id` varchar(50) DEFAULT NULL,
  `cust_name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `request_status` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date DEFAULT NULL,
  `counter` int(11) DEFAULT NULL,
  `stock` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `slug`, `price`, `photo`, `date_view`, `counter`, `stock`) VALUES
(1, 9, 'Sathiya Gas Cooker', '<p>- Sathiya Gas Cooker ni jiko la gas lenye plate 2 kubwa</p>\r\n\r\n<p><br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya gas,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza Vyakula kwa&nbsp;&nbsp;urahisi na haraka zaidi.</p>\r\n', 'sathiya-gas-cooker', 55000, 'sathiya-gas-cooker_1652882189.jpg', '2022-05-22', 1, 28),
(2, 7, 'METRO COOKWARE Set (7)', '<p>- Sufuria Imara saana</p>\r\n\r\n<p>- zinakaa 7&nbsp;na mifuniko yake</p>\r\n\r\n<p>- Mishikio kwaajili ya kuepulika</p>\r\n\r\n<p>- Hazichafuki haraka</p>\r\n\r\n<p>- Haziunguzi chakula kuendana na material iliyotengenezea</p>\r\n', 'metro-cookware-set-7', 95000, 'metro-cookware-set-7_1652884176.jpg', '2022-05-22', 1, 28),
(3, 9, 'LYONS Gas Stove (\'Double Burners\") -GS005', '<p>- Lyons&nbsp;Gas Stove&nbsp; jiko la gas lenye plate 2 kubwa</p>\r\n\r\n<p><br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya gas,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza Vyakula kwa&nbsp;&nbsp;urahisi na haraka zaidi.</p>\r\n', 'lyons-gas-stove-double-burners-gs005', 85000, 'lyons-gas-stove-double-burners_1652882026.jpg', '2022-05-20', 1, 11),
(4, 7, 'PMC DEEP Fryer (\"HD-3302\") 3.5litre', '<p>- PMC Deep Fryer&nbsp; inaujazo wa 3.5&nbsp;litres<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme (2000W)<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka</p>\r\n', 'pmc-deep-fryer-hd-3302-3-5litre', 80000, 'pmc-deep-fryer-hd-3302-3-5litre_1652882572.jpg', '2022-05-20', 1, 53),
(6, 8, 'SUNDABESTS Thermos 1litre', '<p>- Sundabests product</p>\r\n\r\n<p>- Yenye ujazo wa 1litre (Vikombe 7 vya chai)</p>\r\n\r\n<p>- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia<br />\r\n<br />\r\nInatunza joto nakufanya kimiminika chako kubaki kwenye hali ileile iliyokuwa nayo ulivyokiweka. Kwa matumizi ya familia&nbsp;</p>\r\n', 'sundabests-thermos-1litre', 9500, 'sundabests-thermos_1652881680.jpg', '2022-05-21', 2, 25),
(7, 8, 'NICE ONE  Thermos \"Hot\", Different Color', '<p>- Nice One product<br />\r\n<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia<br />\r\n<br />\r\nInatunza joto nakufanya kimiminika chako kubaki kwenye hali ileile iliyokuwa nayo ulivyokiweka&nbsp;</p>\r\n', 'nice-one-thermos-hot-different-color', 5000, 'nice-one-thermos-hot-different-color_1652881392.jpg', '2022-05-19', 3, 42),
(10, 10, 'WESTPOINT Oven 63litre', '<p>- Westpoint Oven&nbsp;inaujazo wa 63&nbsp;litres<br />\r\n<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka</p>\r\n', 'westpoint-oven-63litre', 320000, 'westpoint-oven-63litre_1652882351.jpg', '2022-05-20', 2, 47),
(11, 7, 'DESNEI MARBLE COOKWARE SET (sufuria za deseni)', '<p>- Sufuria Imara saana</p>\r\n\r\n<p>- zinakaa 3 na mifuniko yake</p>\r\n\r\n<p>- Mshikio kwaajili ya kuepulika</p>\r\n\r\n<p>- Hazichafuki haraka</p>\r\n\r\n<p>- Haziunguzi chakula kuendana na material iliyotengenezea</p>\r\n', 'desnei-marble-cookware-set-sufuria-za-deseni', 95000, 'desnei-marble-cookware-set-sufuria-za-deseni_1652883928.jpg', '2022-05-19', 3, 28),
(12, 10, 'KENWOOD Microwave 20litre', '<p>- Kenwood Microwave inaujazo wa 20 litres<br />\r\n<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka</p>\r\n', 'kenwood-microwave-20litre', 230000, 'kenwood-microwave-20litre_1652879926.jpg', '2022-05-19', 3, 12),
(15, 10, 'Europe Oven 42litre', '<p>- Europe Oven inaujazo wa 42&nbsp;litres<br />\r\n<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka na kupasha kwa urahisi.</p>\r\n', 'europe-oven-42litre', 165000, 'europe-oven-42litre_1652880127.jpg', '2022-05-19', 3, 23),
(17, 9, 'NIKAI Gas Stove', '<p>- Nikai Gas Stove&nbsp; jiko la gas lenye plate 2 kubwa na 1 ndogo</p>\r\n\r\n<p>- 3 plates jumla</p>\r\n\r\n<p><br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya gas,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza Vyakula kwa&nbsp;&nbsp;urahisi na haraka zaidi.</p>\r\n', 'nikai-gas-stove', 145000, 'nikai-gas-stove_1652880388.jpg', '2022-05-19', 3, 30),
(18, 7, 'Cup Source (Dozen)', '<p>- Dosen moja vipo 12&nbsp;</p>\r\n\r\n<p>- Nusu Dosen vipo 6 na unapata kwa bei ya 13000sh</p>\r\n\r\n<p>- Piga simu kama unaitaji nusu dosen au tofauti na apo.</p>\r\n\r\n<p>- Imara na vya kuvutia katika meza yako.</p>\r\n', 'cup-source-dozen', 25000, 'cup-source-dozen_1652880849.jpg', '2022-05-19', 3, 40),
(22, 10, 'WESTPOINT Microwave 23litre', '<p>- WESTPOINT MicrowaveWESTPOINT Microwave inaujazo wa 23&nbsp;litres<br />\r\n<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme,<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka</p>\r\n', 'westpoint-microwave-23litre', 220000, 'westpoint-microwave-23litre.jpg', '2022-05-20', 2, 15),
(23, 7, 'METRO COOKWARE Set (5)', '<p>- Sufuria Imara saana</p>\r\n\r\n<p>- zinakaa 5&nbsp;na mifuniko yake</p>\r\n\r\n<p>- Mishikio kwaajili ya kuepulika</p>\r\n\r\n<p>- Hazichafuki haraka</p>\r\n\r\n<p>- Haziunguzi chakula kuendana na material iliyotengenezea</p>\r\n', 'metro-cookware-set-5', 75000, 'metro-cookware-set-5.jpg', '2022-05-20', 1, 26),
(24, 7, 'WESTPOINT DELUXE Handmixer - WF 9901', '<p>-&nbsp;WESTPOINT DELUXE Handmixer - WF 9901</p>\r\n\r\n<p>- Imara saana</p>\r\n\r\n<p>- Inakupa mchanganyiko usiyo na dosari</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'westpoint-deluxe-handmixer-wf-9901', 70000, 'westpoint-deluxe-handmixer-wf-9901.jpg', '2022-05-22', 1, 50),
(25, 7, 'LUMINAC Plates (Dozen)', '<p>- Dosen moja vipo 12&nbsp;</p>\r\n\r\n<p>- Imara na&nbsp;kuvutia katika meza yako.</p>\r\n', 'luminac-plates-dozen', 65000, 'luminac-plates-dozen.jpg', '2022-05-21', 2, 200),
(26, 8, 'SUNDABET Thermos  1.8litre', '<p>- Sundabests product&nbsp;</p>\r\n\r\n<p>- Yenye ujazo wa 1.8litre (Vikombe 12&nbsp;vya chai)</p>\r\n\r\n<p>- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia<br />\r\n<br />\r\nInatunza joto nakufanya kimiminika chako kubaki kwenye hali ileile iliyokuwa nayo ulivyokiweka. Kwa matumizi ya familia&nbsp;</p>\r\n', 'sundabet-thermos-1-8litre', 7000, 'sundabet-thermos-1-8litre.jpg', '2022-05-21', 2, 55),
(27, 7, 'CUP SET (Dozen)', '<p>- Dosen moja vipo 12&nbsp;</p>\r\n\r\n<p>- Vipo kwa rangi tofautitofauti</p>\r\n\r\n<p>- Piga simu kama unaitaji nusu dosen au tofauti na apo.</p>\r\n\r\n<p>- Imara na vya kuvutia katika meza yako.</p>\r\n', 'cup-set-dozen', 20000, 'cup-set-dozen.jpg', '2022-05-21', 2, 210),
(28, 7, 'CUP Set', '<p>- Dosen moja vipo 12&nbsp;</p>\r\n\r\n<p>- Vipo kwa rangi tofautitofauti</p>\r\n\r\n<p>- Piga simu kama unaitaji nusu dosen au tofauti na apo.</p>\r\n\r\n<p>- Imara na vya kuvutia katika meza yako.</p>\r\n', 'cup-set', 20000, 'cup-set.jpg', '2022-05-21', 2, 100),
(29, 8, 'SUNDABESTS Thermos 1.8litre', '<p>- Sundabests product</p>\r\n\r\n<p>- Yenye ujazo wa 1.8 litre (Vikombe 12&nbsp;vya chai)</p>\r\n\r\n<p>- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia<br />\r\n<br />\r\nInatunza joto nakufanya kimiminika chako kubaki kwenye hali ileile iliyokuwa nayo ulivyokiweka. Kwa matumizi ya familia&nbsp;</p>\r\n', 'sundabests-thermos-1-8litre', 15000, 'sundabests-thermos-1-8litre.jpg', '2022-05-21', 2, 98),
(30, 8, 'SUNDABESTS Thermos 3.2litre', '<p>- Sundabests product</p>\r\n\r\n<p>- Yenye ujazo wa 3.2litre (Vikombe 21&nbsp;vya chai)</p>\r\n\r\n<p>- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia<br />\r\n<br />\r\nInatunza joto nakufanya kimiminika chako kubaki kwenye hali ileile iliyokuwa nayo ulivyokiweka. Kwa matumizi ya familia&nbsp;</p>\r\n', 'sundabests-thermos-3-2litre', 12000, 'sundabests-thermos-3-2litre.jpg', '2022-05-21', 2, 200),
(31, 10, 'SuTai AIR Fryer Oven (ST-708) 7litre ', '<p>- SuTai AIR Fryer Oven</p>\r\n\r\n<p>- Yenye ujazo wa 7 litre</p>\r\n\r\n<p>- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Imara na ya kuvutia</p>\r\n\r\n<p><br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka na kupasha kwa urahisi.</p>\r\n', 'sutai-air-fryer-oven-st-708-7litre', 160000, 'sutai-air-fryer-oven-st-708-7litre.jpg', '2022-05-21', 3, 70),
(32, 7, 'SAHANI ZA MFUPA (Dozen)', '<p>- Dosen moja vipo 12&nbsp;</p>\r\n\r\n<p>- Imara na&nbsp;kuvutia katika meza yako.</p>\r\n', 'sahani-za-mfupa-dozen', 35000, 'sahani-za-mfupa-dozen.jpg', '2022-05-21', 2, 200),
(33, 7, 'DiGi Wave (DW) deep fryer', '<p>- Digi Wave Deep Fryer&nbsp;<br />\r\n- Mpya&nbsp;&nbsp;<br />\r\n<br />\r\n- Inamatumizi madogo ya umeme (2000W)<br />\r\n<br />\r\nInafanya majukumu ya jikoni kuwa rahisi na kuongeza ufanisi na mda wa kutengeneza vyakula kwa kuoka</p>\r\n', 'digi-wave-dw-deep-fryer', 180000, 'digi-wave-dw-deep-fryer.jpg', '2022-05-21', 2, 86),
(34, 7, 'KENWOOD Handmixer', '<p>-&nbsp;KENWOOD&nbsp; Handmixer&nbsp;</p>\r\n\r\n<p>- Imara saana</p>\r\n\r\n<p>- Inakupa mchanganyiko usiyo na dosari</p>\r\n', 'kenwood-handmixer', 175000, 'kenwood-handmixer.jpg', '2022-05-21', 2, 59),
(35, 7, 'HOME BEST Cookware Set (7)', '<p>- Sufuria Imara saana</p>\r\n\r\n<p>- zinakaa 7&nbsp;na mifuniko yake</p>\r\n\r\n<p>- Mishikio kwaajili ya kuepulika na kushikia</p>\r\n\r\n<p>- Hazichafuki haraka</p>\r\n\r\n<p>- Haziunguzi chakula kuendana na material iliyotengenezea</p>\r\n', 'home-best-cookware-set-7', 100000, 'home-best-cookware-set-7.jpg', '2022-05-21', 2, 100),
(36, 7, 'ELECTRIC PRESSURE COOKER (Rice Cooker)  - SINGSUNG', '', 'electric-pressure-cooker-rice-cooker-singsung', 50000, 'electric-pressure-cooker-rice-cooker-singsung.jpg', '2022-05-22', 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_id` varchar(50) DEFAULT NULL,
  `delivery_status` varchar(15) DEFAULT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `pay_id`, `delivery_status`, `sales_date`) VALUES
(66, 277, '2tX5PMiAYqbN', 'Delivered', '2022-05-17'),
(67, 278, 'BO3aKwtHRgkj', 'Delivered', '2022-05-17'),
(68, 279, 'EYh3GcrHsx51', 'Pending', '2022-05-17'),
(69, 280, 'PNBszaAXiKjg', 'Pending', '2022-05-17'),
(70, 288, 'f514OHTcBqjp', 'Pending', '2022-05-19'),
(71, 289, '1ipHuk4zcaVA', 'Delivered', '2022-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `sales_perday`
--

CREATE TABLE `sales_perday` (
  `id` int(50) NOT NULL,
  `product_id` int(50) NOT NULL,
  `qnty_sold` int(50) NOT NULL,
  `amount` int(50) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_perday`
--

INSERT INTO `sales_perday` (`id`, `product_id`, `qnty_sold`, `amount`, `date`) VALUES
(20, 1, 1, 55000, '2022-05-19'),
(21, 2, 1, 95000, '2022-05-19'),
(22, 3, 1, 85000, '2022-05-19'),
(23, 1, 1, 55000, '2022-05-19'),
(24, 2, 1, 95000, '2022-05-19'),
(25, 3, 1, 85000, '2022-05-19'),
(26, 4, 1, 80000, '2022-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `address` text,
  `contact_info` varchar(100) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `activate_code` varchar(15) DEFAULT NULL,
  `reset_code` varchar(15) DEFAULT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `activate_code`, `reset_code`, `created_on`) VALUES
(1, 'code3teck@gmail.com', '$2y$10$suGVGIpYLis3YHNX4nneq.FxcENHGhVRcdvyXE1XyMXf/O9Cdxb8G', 1, 'Daniel', 'John', '', '', 'IMG_20211125_234512.jpg', 1, '', '', '2018-05-01'),
(30, 'chidi@gmail.com', '$2y$10$hn7XLYlBhhcs310tAQVgRuLbtz4MaAtuf3K76hFqE5XD27vVi5Yb2', 3, 'chidi boy', '', '', '0713616638', '', 1, NULL, NULL, '2022-04-20'),
(276, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-17'),
(277, NULL, NULL, 0, 'raphael', 'moses', 'tabata segerea', '0765443344', NULL, 1, 'GBzKOfFiMWIb', NULL, '2022-05-17'),
(278, NULL, NULL, 0, 'raphael', 'alvin', 'ubungo', '0765443667', NULL, 1, 'na1wUxNAEdGO', NULL, '2022-05-17'),
(279, NULL, NULL, 0, 'levina', 'joakim', 'ubungo', '0766778888', NULL, 1, 'G1svP2eW5yNU', NULL, '2022-05-17'),
(280, NULL, NULL, 0, 'Daniels', 'mmbuji', 'TABATA', '+255713616639', NULL, 1, 'Ge62oxXWdOJ1', NULL, '2022-05-17'),
(281, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-17'),
(282, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-17'),
(283, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-18'),
(284, 'nicholassanga@outlook.com', '$2y$10$S9mBB4QApbJTbG77q.46He1zMfHkApKPg8JfGKZHSSqyzSP.ZwVGG', 1, 'Nicholas', 'Sanga', 'mwenge', '0769559466', 'nic.jpg', 1, NULL, NULL, '2022-05-18'),
(285, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-18'),
(286, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-18'),
(287, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-18'),
(288, NULL, NULL, 0, 'Edward', 'Raphael', 'Tabata bima', '0743997716', NULL, 1, 'jEQlObig913x', NULL, '2022-05-19'),
(289, NULL, NULL, 0, 'Jivin', 'Mose', 'TABATA', '+255713616639', NULL, 1, '4tTuHBxg8LIz', NULL, '2022-05-19'),
(290, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-19'),
(291, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-20'),
(292, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-20'),
(293, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-20'),
(294, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-20'),
(295, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-21'),
(296, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2022-05-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_perday`
--
ALTER TABLE `sales_perday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `sales_perday`
--
ALTER TABLE `sales_perday`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
