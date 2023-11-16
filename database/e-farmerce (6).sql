-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 05:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-farmerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(100) NOT NULL,
  `user_id` int(200) NOT NULL,
  `product_id` int(200) NOT NULL,
  `order_qty` int(200) NOT NULL,
  `selected_mode` text DEFAULT NULL,
  `cart_add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `order_qty`, `selected_mode`, `cart_add_date`) VALUES
(60, 10, 10, 20, NULL, '2023-10-01 15:21:49'),
(73, 6, 14, 20, NULL, '2023-10-02 12:24:08'),
(75, 6, 13, 100, NULL, '2023-10-03 14:07:29'),
(76, 7, 13, 100, NULL, '2023-11-14 15:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `barangay_id` int(50) NOT NULL,
  `municipality` varchar(41) NOT NULL,
  `barangay_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`barangay_id`, `municipality`, `barangay_name`) VALUES
(1, 'Oas', 'Balogo'),
(2, 'Oas', 'San Ramon'),
(3, 'Oas', 'San Agustin'),
(4, 'Oas', 'Maporong'),
(5, 'Oas', 'Maramba'),
(6, 'Oas', 'Badbad'),
(7, 'Oas', 'Saban'),
(8, 'Oas', 'Obaliw-Rinas'),
(9, 'Oas', 'Ilaor Sur'),
(10, 'Oas', 'Bagumbayan'),
(11, 'Libon', 'Alongong'),
(12, 'Libon', 'Apud'),
(13, 'Libon', 'Bacolod'),
(14, 'Libon', 'Bariw'),
(15, 'Libon', 'Bonbon'),
(16, 'Libon', 'Buga'),
(17, 'Libon', 'Bulusan'),
(18, 'Libon', 'Burabod'),
(19, 'Libon', 'Caguscos'),
(20, 'Libon', 'East Carisac'),
(21, 'Polangui', 'Alnay'),
(22, 'Polangui', 'Balinad'),
(23, 'Polangui', 'Napo'),
(24, 'Polangui', 'Ponso'),
(25, 'Polangui', 'Basud');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(30) NOT NULL,
  `outgoing_msg_id` int(30) NOT NULL,
  `incoming_msg_id` int(30) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `outgoing_msg_id`, `incoming_msg_id`, `msg`) VALUES
(1, 6, 8, 'test'),
(2, 6, 8, 'test 2'),
(3, 6, 8, 'test 3'),
(4, 6, 8, 'test 4'),
(5, 6, 8, 'rtestse'),
(6, 6, 8, 'gagi par'),
(7, 6, 8, 'test'),
(8, 6, 8, 'heyy'),
(9, 6, 8, 'yooow'),
(10, 6, 8, 'asdflasdjflaksjdfklalsdfkasjdfhklasjdfhlkajsdhfklasdhflkjasdfha'),
(11, 7, 8, 'heyy'),
(12, 7, 8, 'asdfasjdfasl;fja;lskdfj;lasjdf;alkjsdf'),
(13, 7, 8, 'aflakjsfhlkasjdfhlasjdhflashdflkjashdlfkjashlkdjfhaslkjdfhaskljdfhlaksjdflaksjdf'),
(14, 7, 8, 'kailan shipping?'),
(15, 8, 7, 'sa thursday'),
(16, 7, 8, 'sheesh oki'),
(17, 6, 7, 'tesy'),
(18, 6, 7, 'tesy'),
(19, 6, 8, 'yow'),
(20, 6, 8, 'yow'),
(21, 6, 7, 'hi'),
(22, 6, 7, 'hi'),
(23, 6, 7, 'hi'),
(24, 6, 7, 'hi'),
(25, 6, 7, 'wat'),
(26, 0, 0, 'sep'),
(27, 0, 0, 'sep'),
(28, 6, 8, 'test1'),
(29, 6, 7, 'test2'),
(30, 6, 7, 'test3'),
(31, 6, 7, 'test3'),
(32, 6, 7, 'test4'),
(33, 6, 7, 'test4'),
(34, 6, 7, 'test5'),
(35, 6, 7, 'test5'),
(36, 6, 8, 'test2'),
(37, 6, 8, 'test2'),
(38, 6, 7, 'test6'),
(39, 6, 8, 'test3'),
(40, 6, 8, 'test4'),
(41, 6, 7, 'test7'),
(42, 6, 8, 'test5'),
(43, 6, 7, 'test8'),
(44, 6, 7, 'test9'),
(45, 6, 7, 'test10'),
(46, 6, 7, 'test11'),
(47, 6, 7, 'test11'),
(48, 6, 7, 'test12'),
(49, 6, 7, 'test12'),
(50, 6, 7, 'test13'),
(51, 6, 7, 'test13'),
(52, 6, 7, 'test14'),
(53, 6, 7, 'test14'),
(54, 6, 7, 'test15'),
(55, 6, 7, 'test15'),
(56, 6, 7, 'test16'),
(57, 6, 7, 'test16'),
(58, 6, 7, 'test71'),
(59, 6, 7, 'test71'),
(60, 6, 8, 'test6'),
(61, 6, 8, 'test6'),
(62, 6, 8, ''),
(63, 6, 8, ''),
(64, 6, 8, 'test123'),
(65, 6, 8, 'test123'),
(66, 6, 8, 'test12'),
(67, 6, 8, 'test12'),
(68, 6, 8, 'asdf'),
(69, 6, 8, 'asdf'),
(70, 6, 8, 'fdas'),
(71, 6, 8, 'fdas'),
(72, 6, 8, 'asdf'),
(73, 6, 8, 'asdf'),
(74, 6, 7, 'test14'),
(75, 6, 7, 'test14'),
(76, 6, 8, 'test'),
(77, 6, 7, 'test'),
(78, 7, 6, 'ano'),
(79, 7, 6, 'hoy'),
(80, 6, 7, 'ano man'),
(81, 7, 6, 'wala'),
(82, 7, 6, 'okay'),
(83, 7, 6, 'wala'),
(84, 6, 7, 'weh'),
(85, 7, 6, 'okayy'),
(86, 6, 7, 'suss'),
(87, 7, 6, 'edi wag'),
(88, 6, 7, 'wew'),
(89, 6, 7, 'hoi'),
(90, 7, 6, 'ano?'),
(91, 6, 7, 'hello'),
(92, 7, 6, 'yow'),
(93, 7, 8, 'yow'),
(94, 8, 7, 'wazzup'),
(95, 9, 7, 'Hi'),
(96, 11, 7, 'hi'),
(97, 0, 16, 'Your products with transact order 6BZ8G052SV have been checked out with total of Php 0.00.'),
(98, 0, 18, 'Your products with transact order 5H4MJ9U7YM have been checked out with total of Php 0.00.'),
(99, 0, 19, 'Your products with transact order FSVBCNVL39 have been checked out with total of Php 0.00.'),
(100, 0, 20, 'Your products with transact order 971BYKNK6G have been checked out with total of Php 0.00.'),
(101, 7, 21, 'Your products with transact order H4CYU9YENP have been checked out with total of Php 0.00.'),
(102, 7, 27, 'Your products with transact order 8K96QDWEQI have been checked out with total of Php 0.00.'),
(103, 7, 28, 'Your products with transact order B29S25KMRV have been checked out with total of Php 736.00.'),
(104, 7, 29, 'Your products with transact order AIRE9G6R9R have been checked out with total of Php 500.00.');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` bigint(255) NOT NULL,
  `seller_id` bigint(255) NOT NULL,
  `transact_code` varchar(50) NOT NULL,
  `buyer_id` int(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `mess_status` text NOT NULL DEFAULT 'Unread',
  `date_mess` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `seller_id`, `transact_code`, `buyer_id`, `message`, `mess_status`, `date_mess`) VALUES
(4, 7, '0X1JD8BV2Y', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0X1JD8BV2Yis on the way to pick up location.', 'Read', '2023-09-19 07:54:39'),
(5, 8, '3299GCPEAY', 6, 'Hi Renz Palma,your order with transaction mode Deliver and order reference:3299GCPEAYis now approved by the seller.', 'Read', '2023-09-19 08:15:40'),
(6, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now approved by the seller.', 'Read', '2023-09-19 08:19:20'),
(7, 8, '3299GCPEAY', 6, 'Hi Renz Palma,your order with transaction mode Deliver and order reference:3299GCPEAYis now approved by the seller.', 'Read', '2023-09-19 08:20:04'),
(8, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is on the way to pick up location.', 'Read', '2023-09-19 08:20:09'),
(9, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now ready to pick up.', 'Read', '2023-09-19 08:20:13'),
(10, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now ready to pick up.', 'Read', '2023-09-19 08:20:18'),
(11, 8, '3299GCPEAY', 6, 'Hi Renz Palma,your order with transaction mode Deliver and order reference:3299GCPEAYis now approved by the seller.', 'Read', '2023-09-19 08:20:31'),
(12, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now approved by the seller.', 'Read', '2023-09-19 12:12:50'),
(13, 7, '0I91RWAEQE', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0I91RWAEQEis now approved by the seller.', 'Read', '2023-09-19 12:14:30'),
(14, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now approved by the seller.', 'Read', '2023-09-19 12:15:53'),
(15, 7, 'GLGXDHUW9H', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:GLGXDHUW9His on the way to pick up location.', 'Read', '2023-09-19 12:16:52'),
(16, 7, '0I91RWAEQE', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0I91RWAEQEis now approved by the seller.', 'Read', '2023-09-19 12:31:56'),
(17, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now approved by the seller.', 'Read', '2023-09-19 12:36:06'),
(18, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now approved by the seller.', 'Read', '2023-09-19 12:38:08'),
(19, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now approved by the seller.', 'Read', '2023-09-19 12:39:18'),
(20, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now approved by the seller.', 'Read', '2023-09-19 12:42:19'),
(21, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now approved by the seller.', 'Read', '2023-09-19 12:45:17'),
(22, 7, '0I91RWAEQE', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0I91RWAEQEis now approved by the seller.', 'Read', '2023-09-19 12:47:54'),
(23, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now approved by the seller. Date of Transaction: 2023-09-20-09:02', 'Read', '2023-09-19 13:02:57'),
(24, 7, '0X1JD8BV2Y', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0X1JD8BV2Yis now ready to pick up.', 'Read', '2023-09-20 02:48:35'),
(25, 7, '0X1JD8BV2Y', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:0X1JD8BV2Yis now ready to pick up.', 'Read', '2023-09-20 02:48:38'),
(26, 7, 'GLGXDHUW9H', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:GLGXDHUW9His now ready to pick up.', 'Read', '2023-09-20 06:01:28'),
(27, 7, 'GLGXDHUW9H', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:GLGXDHUW9His now ready to pick up.', 'Read', '2023-09-20 06:02:15'),
(28, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis on the way to pick up location.', 'Read', '2023-09-20 06:03:09'),
(29, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now ready to pick up.', 'Read', '2023-09-20 06:03:21'),
(30, 7, 'ZF1E1IOYVZ', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:ZF1E1IOYVZis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-09-20 06:09:19'),
(31, 7, 'WJL2UL78T0', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:WJL2UL78T0is now approved by the seller.', 'Read', '2023-09-20 09:47:41'),
(32, 7, 'WJL2UL78T0', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:WJL2UL78T0is on the way to pick up location.', 'Read', '2023-09-20 12:55:37'),
(33, 7, '1W7FCGVTOO', 6, 'Hi Renz Palma,your order with transaction mode Pick up and order reference:1W7FCGVTOOis now approved by the seller.', 'Read', '2023-09-21 03:20:20'),
(34, 7, 'WJL2UL78T0', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:WJL2UL78T0is now ready to pick up.', 'Read', '2023-09-22 04:48:43'),
(35, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-09-25 05:37:01'),
(36, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-09-25 05:37:22'),
(37, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-09-25 05:38:51'),
(38, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-09-25 05:40:23'),
(39, 7, 'WJL2UL78T0', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:WJL2UL78T0is now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-09-25 05:40:41'),
(40, 7, '1W7FCGVTOO', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:1W7FCGVTOOis on the way to pick up location.', 'Read', '2023-09-25 05:42:06'),
(41, 7, '1W7FCGVTOO', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:1W7FCGVTOOis now ready to pick up.', 'Read', '2023-09-25 05:43:07'),
(42, 7, '1W7FCGVTOO', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:1W7FCGVTOOis now ready to pick up.', 'Read', '2023-09-25 05:43:18'),
(43, 7, '1W7FCGVTOO', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:1W7FCGVTOOis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-09-25 05:43:37'),
(44, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-09-25 05:47:38'),
(45, 7, 'VOU8HMZQ3P', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:VOU8HMZQ3Pis now approved by the seller.', 'Read', '2023-09-25 10:22:20'),
(46, 7, '41V4DUJI2Y', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:41V4DUJI2Yis now approved by the seller.', 'Read', '2023-09-27 09:16:09'),
(47, 7, 'VOU8HMZQ3P', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:VOU8HMZQ3Pis on the way to pick up location.', 'Read', '2023-10-01 05:09:39'),
(48, 7, 'VOU8HMZQ3P', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:VOU8HMZQ3Pis now ready to pick up.', 'Read', '2023-10-01 05:11:09'),
(49, 7, '4CY3UN2EFQ', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:4CY3UN2EFQis now approved by the seller.', 'Read', '2023-10-01 05:13:38'),
(50, 7, 'VOU8HMZQ3P', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:VOU8HMZQ3Pis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-10-01 05:13:50'),
(51, 7, '4CY3UN2EFQ', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:4CY3UN2EFQis on the way to pick up location.', 'Read', '2023-10-01 05:14:49'),
(52, 7, '4CY3UN2EFQ', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:4CY3UN2EFQis now ready to pick up.', 'Read', '2023-10-01 05:15:01'),
(53, 7, '4CY3UN2EFQ', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:4CY3UN2EFQis now ready to pick up.', 'Read', '2023-10-01 05:15:03'),
(54, 7, '4CY3UN2EFQ', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:4CY3UN2EFQis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-10-01 05:15:14'),
(55, 7, '41V4DUJI2Y', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:41V4DUJI2Yis on the way to pick up location.', 'Read', '2023-10-01 05:15:31'),
(56, 7, '41V4DUJI2Y', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:41V4DUJI2Yis now ready to pick up.', 'Read', '2023-10-01 05:15:37'),
(57, 7, '41V4DUJI2Y', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:41V4DUJI2Yis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-10-01 05:15:44'),
(58, 7, 'DWXLPB9AHL', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:DWXLPB9AHLis now approved by the seller.', 'Read', '2023-10-01 05:16:48'),
(59, 7, 'DWXLPB9AHL', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:DWXLPB9AHLis on the way to pick up location.', 'Read', '2023-10-01 05:16:53'),
(60, 7, 'DWXLPB9AHL', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:DWXLPB9AHLis now ready to pick up.', 'Read', '2023-10-01 05:17:01'),
(61, 7, 'DWXLPB9AHL', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:DWXLPB9AHLis now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-10-01 05:17:08'),
(62, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now approved by the seller.', 'Read', '2023-10-01 05:18:36'),
(63, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is on the way to pick up location.', 'Read', '2023-10-01 05:18:41'),
(64, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now ready to pick up.', 'Read', '2023-10-01 05:18:47'),
(65, 7, 'QRQ2LPTYP1', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:QRQ2LPTYP1is now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Read', '2023-10-01 05:20:45'),
(66, 7, 'F8ZVLVP1HD', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:F8ZVLVP1HDis now approved by the seller.', 'Read', '2023-10-01 05:32:49'),
(67, 7, 'F8ZVLVP1HD', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:F8ZVLVP1HDis on the way to pick up location.', 'Read', '2023-10-01 05:32:54'),
(68, 7, '3XV6W40QLR', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:3XV6W40QLRis now approved by the seller.', 'Unread', '2023-10-04 07:13:57'),
(69, 7, '3XV6W40QLR', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:3XV6W40QLRis on the way to pick up location.', 'Unread', '2023-10-04 07:19:17'),
(70, 7, '3XV6W40QLR', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:3XV6W40QLRis now ready to pick up.', 'Unread', '2023-10-04 07:20:19'),
(71, 7, 'R46962P40R', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:R46962P40Ris now approved by the seller.', 'Unread', '2023-10-04 07:21:31'),
(72, 7, 'R46962P40R', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:R46962P40Ris on the way to pick up location.', 'Unread', '2023-10-04 07:22:47'),
(73, 7, 'R46962P40R', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:R46962P40Ris now ready to pick up.', 'Unread', '2023-10-04 07:23:10'),
(74, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Unread', '2023-11-16 02:23:47'),
(75, 8, '68INX0LTN6', 9, 'Hi Kurth Palma,your order with transaction mode Pick up and order reference:68INX0LTN6is now approved by the seller.', 'Unread', '2023-11-16 02:27:10'),
(76, 7, 'R46962P40R', 6, 'Hi Renz Palma R,your order with transaction mode Pick up and order reference:R46962P40Ris now already been picked up. Please leave a rating and comment on our service and product. Thank you!.', 'Unread', '2023-11-16 02:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `seller_id` int(41) NOT NULL,
  `order_reference` varchar(20) NOT NULL,
  `product_id` int(50) NOT NULL,
  `order_qty` int(50) NOT NULL,
  `order_status` text NOT NULL,
  `order_total` bigint(50) NOT NULL,
  `date_place` datetime NOT NULL,
  `order_delivery_date` datetime DEFAULT NULL,
  `transact_mode` text NOT NULL,
  `order_rating` int(11) DEFAULT NULL,
  `order_comm` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `seller_id`, `order_reference`, `product_id`, `order_qty`, `order_status`, `order_total`, `date_place`, `order_delivery_date`, `transact_mode`, `order_rating`, `order_comm`) VALUES
(8, 6, 8, 'NXDXNUT1CP', 12, 23, 'Confirmed', 529, '2023-09-18 09:06:42', '0000-00-00 00:00:00', 'Deliver', 1, '1'),
(9, 6, 7, 'GLGXDHUW9H', 11, 32, 'Picked up', 736, '2023-09-18 09:06:42', '2023-09-20 10:30:00', 'Pick Up', 0, '0'),
(10, 6, 7, '0X1JD8BV2Y', 10, 20, 'Confirmed', 400, '2023-09-19 06:48:14', '2023-09-20 12:00:00', 'Pick Up', 4, 'nice'),
(11, 6, 7, '0X1JD8BV2Y', 11, 32, 'Confirmed', 736, '2023-09-19 06:48:14', '2023-09-20 12:00:00', 'Pick Up', 4, 'nice'),
(12, 6, 8, '3299GCPEAY', 12, 23, 'Confirmed', 529, '2023-09-19 06:48:14', '0000-00-00 00:00:00', 'Deliver', 5, 'Nice product'),
(13, 9, 8, '68INX0LTN6', 12, 23, 'Approved', 529, '2023-09-19 08:12:58', '2023-11-18 10:27:00', 'Pick Up', NULL, NULL),
(14, 9, 7, 'ZF1E1IOYVZ', 11, 32, 'Picked up', 736, '2023-09-19 08:12:58', '2023-09-21 20:46:00', 'Pick Up', NULL, NULL),
(15, 6, 7, '0I91RWAEQE', 10, 20, 'Cancelled', 400, '2023-09-19 20:12:07', '2023-09-21 08:47:00', 'Pick Up', NULL, NULL),
(16, 6, 7, '0I91RWAEQE', 11, 32, 'Cancelled', 736, '2023-09-19 20:12:07', '2023-09-21 08:47:00', 'Pick Up', NULL, NULL),
(17, 6, 7, '1W7FCGVTOO', 10, 20, 'Picked up', 400, '2023-09-20 12:24:48', '2023-09-22 11:20:00', 'Pick Up', NULL, NULL),
(18, 6, 7, 'WJL2UL78T0', 10, 20, 'Picked up', 400, '2023-09-20 17:45:52', '2023-09-28 10:47:00', 'Pick Up', NULL, NULL),
(19, 6, 7, 'WJL2UL78T0', 13, 100, 'Picked up', 2000, '2023-09-20 17:45:52', '2023-09-28 10:47:00', 'Pick Up', NULL, NULL),
(20, 6, 7, 'VOU8HMZQ3P', 11, 32, 'Picked up', 736, '2023-09-21 11:19:40', '2023-09-27 18:22:00', 'Pick Up', NULL, NULL),
(21, 6, 7, 'QRQ2LPTYP1', 14, 20, 'Picked up', 500, '2023-09-25 13:20:43', '2023-10-05 13:18:00', 'Pick Up', NULL, NULL),
(22, 6, 7, '4CY3UN2EFQ', 10, 20, 'Picked up', 400, '2023-09-25 13:23:54', '2023-10-02 13:13:00', 'Pick Up', NULL, NULL),
(23, 6, 7, 'F8ZVLVP1HD', 14, 20, 'Picked up', 500, '2023-09-25 13:24:41', '2023-10-05 13:32:00', 'Pick Up', NULL, NULL),
(24, 6, 7, 'R46962P40R', 10, 20, 'Picked up', 400, '2023-09-25 13:33:48', '2023-10-05 15:21:00', 'Pick Up', NULL, NULL),
(25, 6, 7, '41V4DUJI2Y', 10, 500, 'Picked up', 10000, '2023-09-27 17:15:36', '2023-09-28 17:16:00', 'Pick Up', NULL, NULL),
(26, 9, 7, 'DWXLPB9AHL', 14, 40, 'Picked up', 1000, '2023-09-28 16:44:08', '2023-10-03 13:16:00', 'Pick Up', NULL, NULL),
(27, 7, 7, 'QQKT3T09AS', 13, 200, 'Cancelled', 4000, '2023-09-28 16:46:25', NULL, 'Pick Up', NULL, NULL),
(28, 9, 7, 'IC3EHRE0FP', 14, 20, 'Cancelled', 500, '2023-10-01 16:09:42', NULL, '', NULL, NULL),
(29, 9, 7, 'MX84W02HN0', 10, 40, 'Cancelled', 800, '2023-10-01 16:20:58', NULL, 'Pick Up', NULL, NULL),
(30, 9, 7, 'DFJB9PL6UF', 10, 40, 'Cancelled', 800, '2023-10-01 16:21:36', NULL, 'Pick Up', NULL, NULL),
(31, 9, 7, 'IF73AZMHU1', 10, 40, 'Cancelled', 800, '2023-10-01 16:22:39', NULL, 'Pick Up', NULL, NULL),
(32, 9, 7, '6CJLPZ5U7N', 10, 40, 'Cancelled', 800, '2023-10-01 16:23:32', NULL, 'Pick Up', NULL, NULL),
(33, 9, 7, 'I44NY8RDAE', 10, 40, 'Cancelled', 800, '2023-10-01 16:24:11', NULL, 'Pick Up', NULL, NULL),
(34, 9, 7, 'YN0L6SL7PD', 10, 40, 'Cancelled', 800, '2023-10-01 16:25:57', NULL, 'Pick Up', NULL, NULL),
(35, 9, 7, 'YN0L6SL7PD', 14, 20, 'Cancelled', 500, '2023-10-01 16:25:57', NULL, 'Pick Up', NULL, NULL),
(36, 9, 7, 'RLBCG6OTYH', 11, 32, 'Cancelled', 736, '2023-10-01 16:27:45', NULL, '', NULL, NULL),
(37, 9, 7, 'BHK8TZZYYD', 13, 100, 'Cancelled', 2000, '2023-10-01 19:13:28', NULL, 'Pick Up', NULL, NULL),
(38, 9, 7, 'BHK8TZZYYD', 14, 40, 'Cancelled', 1000, '2023-10-01 19:13:28', NULL, 'Pick Up', NULL, NULL),
(39, 9, 7, 'C96UEL6ZGG', 14, 20, 'Cancelled', 500, '2023-10-02 15:33:51', NULL, '', NULL, NULL),
(40, 6, 7, '978PCOI45G', 14, 20, 'Pending', 500, '2023-10-02 20:23:59', NULL, '', NULL, NULL),
(41, 9, 7, '3XV6W40QLR', 10, 20, 'Ready to pick up', 400, '2023-10-03 11:03:43', '2023-10-06 16:13:00', 'Pick Up', NULL, NULL),
(42, 11, 7, 'I6YCTQQXYY', 13, 200, 'Pending', 4000, '2023-11-16 09:13:53', NULL, 'Pick Up', NULL, NULL),
(43, 15, 0, '2OIBSHJY0E', 10, 0, 'Pending', 0, '2023-11-16 09:50:56', NULL, 'Pick Up', NULL, NULL),
(44, 16, 0, 'F1D79CW1SD', 10, 20, 'Pending', 0, '2023-11-16 09:56:20', NULL, 'Pick Up', NULL, NULL),
(45, 16, 0, '6BZ8G052SV', 10, 20, 'Pending', 0, '2023-11-16 09:56:49', NULL, 'Pick Up', NULL, NULL),
(46, 18, 0, '5H4MJ9U7YM', 10, 20, 'Pending', 0, '2023-11-16 10:00:04', NULL, 'Pick Up', NULL, NULL),
(47, 19, 0, 'FSVBCNVL39', 10, 20, 'Pending', 0, '2023-11-16 10:01:22', NULL, 'Pick Up', NULL, NULL),
(48, 20, 0, '971BYKNK6G', 10, 20, 'Pending', 0, '2023-11-16 10:04:41', NULL, 'Pick Up', NULL, NULL),
(49, 21, 7, 'H4CYU9YENP', 13, 100, 'Pending', 0, '2023-11-16 10:16:40', NULL, 'Delivery', NULL, NULL),
(50, 27, 7, '8K96QDWEQI', 14, 20, 'Pending', 0, '2023-11-16 10:18:56', NULL, 'Delivery', NULL, NULL),
(51, 28, 7, 'B29S25KMRV', 11, 32, 'Pending', 736, '2023-11-16 10:20:29', NULL, 'Delivery', NULL, NULL),
(52, 29, 7, 'AIRE9G6R9R', 14, 20, 'Pending', 500, '2023-11-16 10:32:34', NULL, 'Delivery', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_img` varchar(200) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(200) NOT NULL,
  `product_cat` text NOT NULL,
  `product_stock` int(200) NOT NULL,
  `min_order` int(100) NOT NULL,
  `product_details` varchar(200) NOT NULL,
  `seller_id` int(100) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_status` text NOT NULL DEFAULT 'On Sale' COMMENT 'On Sale, Sold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_img`, `product_name`, `product_price`, `product_cat`, `product_stock`, `min_order`, `product_details`, `seller_id`, `date_added`, `product_status`) VALUES
(10, 'licensed-image.jpg', 'Petsay', 20, '', 260, 20, 'fresh', 7, '2023-11-16 02:04:41', 'On Sale'),
(11, 'kalabasa.jpg', 'Pumpkin', 23, '', 3301, 32, 'pumpkin ', 7, '2023-11-16 02:20:29', 'On Sale'),
(12, '1200px-Bawang.jpg', 'Bawang', 23, '', 17, 23, 'mabango', 8, '2023-11-16 04:05:58', 'Restricted'),
(13, 'coco.jpg', 'coco', 20, 'fruit', 200, 100, 'Random size, per kilo not sako', 7, '2023-11-16 03:19:56', 'On Sale'),
(14, 'images (1).jpg', 'Mango', 25, 'fruit', 173, 20, 'Red Mango na may konting yelow', 7, '2023-11-16 03:19:56', 'On Sale');

-- --------------------------------------------------------

--
-- Table structure for table `seller_notif`
--

CREATE TABLE `seller_notif` (
  `notif_seller_id` int(20) NOT NULL,
  `seller_id` int(20) NOT NULL,
  `product_id` int(200) NOT NULL,
  `not_info` varchar(200) NOT NULL,
  `notif_sts` text NOT NULL DEFAULT 'Unread',
  `notif_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transact_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_notif`
--

INSERT INTO `seller_notif` (`notif_seller_id`, `seller_id`, `product_id`, `not_info`, `notif_sts`, `notif_date`, `transact_code`) VALUES
(1, 7, 13, 'Your product with product ID 13  changed the quanity in the cart by user 9.', 'Read', '2023-10-01 04:52:10', NULL),
(2, 7, 11, 'Your product with product ID 11 added to cart  user 9.', 'Read', '2023-10-01 04:59:35', NULL),
(3, 7, 13, 'Your product with product ID 13 added to cart  user 9.', 'Read', '2023-10-01 06:54:02', NULL),
(4, 7, 14, 'Your product with product ID 14 added to cart  user 9.', 'Read', '2023-10-01 08:09:37', NULL),
(5, 7, 10, 'Your product with product ID 10 added to cart  user 9.', 'Read', '2023-10-01 08:09:47', NULL),
(6, 7, 10, 'Your product with product ID 10  changed the quanity in the cart by user 9.', 'Read', '2023-10-01 08:10:51', NULL),
(9, 7, 11, 'Your product with product ID 11 added to cart  user 9.', 'Read', '2023-10-01 08:27:39', NULL),
(10, 7, 11, 'Your products with transact order RLBCG6OTYH have been checked out with total of 736.', 'Read', '2023-10-01 08:27:45', 'RLBCG6OTYH'),
(11, 7, 10, 'Your products with transact order MX84W02HN0 have been cancelled.', 'Read', '2023-10-01 08:32:23', 'MX84W02HN0'),
(12, 7, 13, 'Your product with product ID 13 added to cart  user 9.', 'Read', '2023-10-01 10:02:59', NULL),
(13, 7, 14, 'Your product with product ID 14 added to cart  user 9.', 'Read', '2023-10-01 10:03:02', NULL),
(14, 7, 14, 'Your product with product ID 14  changed the quanity in the cart by user 9.', 'Read', '2023-10-01 10:03:07', NULL),
(15, 7, 13, 'Your products with transact order BHK8TZZYYD have been checked out with total of 2000.', 'Read', '2023-10-01 11:13:28', 'BHK8TZZYYD'),
(16, 7, 14, 'Your products with transact order BHK8TZZYYD have been checked out with total of 1000.', 'Read', '2023-10-01 11:13:28', 'BHK8TZZYYD'),
(17, 7, 14, 'Your product with product ID 14 added to cart  user 9.', 'Read', '2023-10-02 07:33:33', NULL),
(18, 7, 14, 'Your products with transact order C96UEL6ZGG have been checked out with total of Php 500.00.', 'Read', '2023-10-02 07:33:51', 'C96UEL6ZGG'),
(19, 7, 14, 'Your product with product ID 14 added to cart  user 6.', 'Read', '2023-10-02 12:23:40', NULL),
(20, 7, 14, 'Your products with transact order 978PCOI45G have been checked out with total of Php 500.00.', 'Read', '2023-10-02 12:23:59', '978PCOI45G'),
(21, 7, 14, 'Your product with product ID 14 added to cart  user 6.', 'Read', '2023-10-02 12:24:08', NULL),
(22, 7, 10, 'Your product with product ID 10 added to cart  user 9.', 'Read', '2023-10-02 12:25:10', NULL),
(23, 7, 10, 'Your products with transact order DFJB9PL6UF have been cancelled.', 'Read', '2023-10-03 03:03:27', 'DFJB9PL6UF'),
(24, 7, 10, 'Your products with transact order IF73AZMHU1 have been cancelled.', 'Read', '2023-10-03 03:03:31', 'IF73AZMHU1'),
(25, 7, 13, 'Your products with transact order BHK8TZZYYD have been cancelled.', 'Read', '2023-10-03 03:03:34', 'BHK8TZZYYD'),
(26, 7, 14, 'Your products with transact order BHK8TZZYYD have been cancelled.', 'Read', '2023-10-03 03:03:34', 'BHK8TZZYYD'),
(27, 7, 14, 'Your products with transact order C96UEL6ZGG have been cancelled.', 'Read', '2023-10-03 03:03:36', 'C96UEL6ZGG'),
(28, 7, 10, 'Your products with transact order 3XV6W40QLR have been checked out with total of Php 400.00.', 'Read', '2023-10-03 03:03:43', '3XV6W40QLR'),
(29, 7, 13, 'Your product with product ID 13 added to cart  user 6.', 'Read', '2023-10-03 14:07:29', NULL),
(30, 7, 13, 'Your products with transact order QQKT3T09AS have been cancelled.', 'Read', '2023-10-04 07:21:17', 'QQKT3T09AS'),
(31, 7, 13, 'Your product with product ID 13 added to cart  user 7.', 'Read', '2023-11-14 15:38:37', NULL),
(32, 7, 13, 'Your product with product ID 13 added to cart  user 11.', 'Read', '2023-11-15 03:58:34', NULL),
(33, 7, 13, 'Your product with product ID 13 added to cart  user 11.', 'Read', '2023-11-15 04:10:44', NULL),
(34, 7, 13, 'Your product with product ID 13 added to cart  user 11.', 'Read', '2023-11-15 04:10:56', NULL),
(35, 7, 13, 'Your product with product ID 13  changed the quanity in the cart by user 11.', 'Read', '2023-11-16 01:13:44', NULL),
(36, 7, 13, 'Your products with transact order I6YCTQQXYY have been checked out with total of Php 4,000.00.', 'Read', '2023-11-16 01:13:53', 'I6YCTQQXYY'),
(37, 0, 10, 'Your products with transact order 2OIBSHJY0E have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 01:50:56', '2OIBSHJY0E'),
(38, 0, 10, 'Your products with transact order F1D79CW1SD have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 01:56:20', 'F1D79CW1SD'),
(39, 0, 10, 'Your products with transact order 6BZ8G052SV have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 01:56:49', '6BZ8G052SV'),
(40, 0, 10, 'Your products with transact order 5H4MJ9U7YM have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 02:00:04', '5H4MJ9U7YM'),
(41, 0, 10, 'Your products with transact order FSVBCNVL39 have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 02:01:22', 'FSVBCNVL39'),
(42, 0, 10, 'Your products with transact order 971BYKNK6G have been checked out with total of Php 0.00.', 'Unread', '2023-11-16 02:04:41', '971BYKNK6G'),
(43, 7, 13, 'Your products with transact order H4CYU9YENP have been checked out with total of Php 0.00.', 'Read', '2023-11-16 02:16:40', 'H4CYU9YENP'),
(44, 7, 14, 'Your products with transact order 8K96QDWEQI have been checked out with total of Php 0.00.', 'Read', '2023-11-16 02:18:56', '8K96QDWEQI'),
(45, 7, 11, 'Your products with transact order B29S25KMRV have been checked out with total of Php 736.00.', 'Read', '2023-11-16 02:20:29', 'B29S25KMRV'),
(46, 7, 14, 'Your products with transact order AIRE9G6R9R have been checked out with total of Php 500.00.', 'Read', '2023-11-16 02:32:34', 'AIRE9G6R9R');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` text NOT NULL,
  `number` varchar(13) NOT NULL,
  `address` varchar(50) NOT NULL,
  `municipality` varchar(20) NOT NULL,
  `user_type` text NOT NULL,
  `pickup_address` varchar(100) DEFAULT NULL,
  `delivery_area` varchar(200) NOT NULL,
  `forgot_code` varchar(20) DEFAULT NULL,
  `sts` text NOT NULL DEFAULT 'Active',
  `last_login` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `number`, `address`, `municipality`, `user_type`, `pickup_address`, `delivery_area`, `forgot_code`, `sts`, `last_login`) VALUES
(6, '', 'niceone', 'Renz Palma R', '09158374062', 'Balinad,Polangui', 'Polangui', 'Buyer', '', 'Purok 7, Balinad, Polangui, Albay', '8GCR2J', 'Active', '2023-10-04 07:20:40'),
(7, 'jona', 'asd', 'Jonaliza Moralde', '2147483647', 'Alongong,Libon', '', 'Seller', 'Polangui, Centro', 'Libon', '', 'Restricted', '2023-11-16 15:18:55'),
(8, 'Lio', 'asd', 'Lionese Ramos', '2147483647', 'Alnay,Polangui', '', 'Seller', 'Polangui, Centro', 'Polangui', '', 'Restricted', '2023-11-16 02:22:11'),
(9, '', 'asd', 'Kurth Palma', '2147483647', 'Balogo,Oas', 'Oas', 'Buyer', NULL, 'Sampalok, St Balogo, Oas, Albay', '033B03', 'Active', '2023-10-04 05:29:43'),
(10, '', 'admin', '', '', '', '', 'Admin', NULL, '', NULL, '', '2023-10-03 11:52:25'),
(11, 'renz', 'asd', 'Renz Palma', '09454545344', 'Balogo,Oas', 'Oas', 'Buyer', NULL, 'Sampalok, St Balogo, Oas, Albay', NULL, 'Verified', '2023-11-16 01:13:41'),
(12, 'Seller', 'asd', 'Jona Liza', '09823232', 'Bacolod,Libon', '', 'Seller', 'Polangui, Centro', 'Libon', NULL, 'Verified', '2023-11-16 00:27:01'),
(13, 'Admin', 'asd', 'Jona Than', '093434343', 'Bacolod,Libon', 'Libon', 'Admin', NULL, 'Sampalok, St Balogo, Oas, Albay', NULL, 'Verified', '2023-11-16 06:27:55'),
(16, '09321235415', '8^}pyE+Q', 'Renz GG', '09321235415', 'Sampalok St. Balogo, Oas, Albay', 'Oas', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 01:56:20'),
(17, '09321235415', '.W@s&q2D', 'Renz GG', '09321235415', 'Sampalok St. Balogo, Oas, Albay', 'Oas', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 01:56:49'),
(19, '09142368421', 'H$miGdfm', 'Test 1', '09142368421', 'Legazpi, City', 'Libon', 'Buyer', NULL, 'Legazpi, City', NULL, 'Active', '2023-11-16 02:01:22'),
(20, '09158374061', 'zN=KX3N}', 'Test 3', '09158374061', 'Sampalok St. Balogo, Oas, Albay', 'Oas', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:04:41'),
(21, '09457792455', 'LTfp}8sL', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:11:18'),
(22, '09457792455', 'Fk1xOjir', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:12:29'),
(23, '09457792455', 'FU9R!itE', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:12:40'),
(24, '09457792455', 'PB6L!M6v', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:14:55'),
(25, '09457792455', '5_Xn=AaO', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:15:24'),
(26, '09457792455', 'X.8cIGXV', 'Test 4', '09457792455', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:16:40'),
(27, '09457792454', 'CpgUvHi*', 'Test 5', '09457792454', 'Sampalok St. Balogo, Oas, Albay', 'Libon', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:18:56'),
(28, '09568357331', 'YCiLXcKP', 'Test 6', '09568357331', 'Sampalok St. Balogo, Oas, Albay', 'Oas', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:20:29'),
(29, '09566739421', '&gxYn(VL', 'Last Test', '09566739421', 'Sampalok St. Balogo, Oas, Albay', 'Oas', 'Buyer', NULL, 'Sampalok St. Balogo, Oas, Albay', NULL, 'Active', '2023-11-16 02:32:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_ibfk_2` (`user_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`barangay_id`),
  ADD KEY `municipality_id` (`municipality`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `seller_notif`
--
ALTER TABLE `seller_notif`
  ADD PRIMARY KEY (`notif_seller_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `barangay_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller_notif`
--
ALTER TABLE `seller_notif`
  MODIFY `notif_seller_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
