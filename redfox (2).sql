-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2018 at 05:45 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redfox`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Jaket', 'jaket', '2018-03-11 15:46:48', '2018-03-11 22:48:48'),
(2, 'Rompi', 'rompi', '2018-03-16 06:32:07', '0000-00-00 00:00:00');

--
-- Triggers `categories`
--
DELIMITER $$
CREATE TRIGGER `update_category` BEFORE UPDATE ON `categories` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_other` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `created_at`, `updated_at`, `name`, `address`, `phone`, `phone_other`) VALUES
(1, '2018-03-12 17:00:00', '2018-06-13 13:03:45', 'None', '', '', ''),
(9, '2018-06-06 08:24:55', '2018-06-06 15:24:55', 'Nana', NULL, NULL, NULL),
(10, '2018-06-06 10:24:07', '2018-06-06 17:24:07', 'Danu', NULL, NULL, NULL),
(11, '2018-06-10 23:43:51', '2018-06-10 19:43:51', 'miftah', NULL, NULL, NULL),
(12, '2018-06-11 00:02:11', '2018-06-10 20:02:11', 'MAIL SIRI', NULL, NULL, NULL),
(13, '2018-06-11 00:04:07', '2018-06-10 20:04:07', 'safa', NULL, NULL, NULL),
(14, '2018-06-11 00:20:11', '2018-06-10 20:20:11', 'marwah', NULL, NULL, NULL),
(15, '2018-06-11 17:14:35', '2018-06-12 00:14:35', 'Barry', NULL, NULL, NULL),
(16, '2018-06-14 03:25:18', '2018-06-13 20:25:18', 'DERI NAIBAHO', NULL, NULL, NULL),
(17, '2018-06-14 03:32:31', '2018-06-13 20:32:31', 'DAVID MIFTAH', NULL, NULL, NULL),
(18, '2018-06-14 03:40:37', '2018-06-13 20:40:37', 'binjie', NULL, NULL, NULL);

--
-- Triggers `customers`
--
DELIMITER $$
CREATE TRIGGER `update_customer` BEFORE UPDATE ON `customers` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `qty` int(15) NOT NULL,
  `price` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `product_id`, `order_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 1, 90000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(2, 18, 1, 1, 100000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(3, 12, 1, 1, 87000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(4, 17, 1, 1, 95000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(5, 13, 1, 1, 89000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(6, 11, 1, 1, 85000, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(7, 27, 1, 1, 85000, '2018-06-28 14:45:56', '2018-06-28 21:45:56'),
(8, 28, 1, 1, 50000, '2018-06-28 14:45:56', '2018-06-28 21:45:56'),
(9, 29, 1, 1, 55000, '2018-06-28 14:45:56', '2018-06-28 21:45:56'),
(10, 33, 1, 1, 40000, '2018-06-28 14:45:56', '2018-06-28 21:45:56'),
(11, 11, 2, 12, 85000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(12, 12, 2, 1, 87000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(13, 21, 2, 1, 82000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(14, 23, 2, 6, 72000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(15, 16, 2, 1, 90000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(16, 15, 2, 1, 92000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(17, 27, 2, 12, 85000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(18, 16, 3, 1, 90000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(19, 18, 3, 12, 100000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(20, 14, 3, 1, 89000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(21, 17, 3, 1, 95000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(22, 11, 3, 1, 85000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(23, 9, 3, 1, 85000, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(24, 15, 3, 36, 92000, '2018-06-28 14:47:19', '2018-06-28 21:47:19'),
(25, 16, 4, 12, 90000, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(26, 14, 4, 12, 89000, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(27, 19, 4, 18, 100000, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(28, 23, 4, 6, 72000, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(29, 38, 5, 3, 100000, '2018-06-30 16:42:38', '2018-06-30 23:42:38'),
(30, 44, 5, 8, 46000, '2018-06-30 16:42:38', '2018-06-30 23:42:38'),
(31, 16, 6, 1, 90000, '2018-06-30 17:28:08', '2018-07-01 00:28:08'),
(32, 10, 6, 6, 85000, '2018-06-30 17:28:08', '2018-07-01 00:28:08'),
(33, 12, 6, 1, 87000, '2018-06-30 17:28:08', '2018-07-01 00:28:08'),
(34, 12, 7, 20, 87000, '2018-06-30 18:21:23', '2018-07-01 01:21:23'),
(35, 16, 7, 92, 90000, '2018-06-30 18:21:23', '2018-07-01 01:21:23'),
(36, 19, 7, 13, 100000, '2018-06-30 18:21:23', '2018-07-01 01:21:23'),
(37, 13, 8, 12, 89000, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(38, 12, 8, 3, 87000, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(39, 17, 8, 6, 95000, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(40, 19, 8, 8, 100000, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(41, 15, 9, 8, 92000, '2018-07-11 17:02:36', '2018-07-12 00:02:36'),
(42, 14, 9, 34, 89000, '2018-07-11 17:02:36', '2018-07-12 00:02:36'),
(43, 23, 9, 1, 72000, '2018-07-11 17:02:36', '2018-07-12 00:02:36');

--
-- Triggers `items`
--
DELIMITER $$
CREATE TRIGGER `update_item` BEFORE UPDATE ON `items` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_qty` int(15) NOT NULL,
  `total_price` int(15) NOT NULL,
  `payment_method` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `tgl_dibayar` date DEFAULT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `store_id`, `customer_id`, `total_qty`, `total_price`, `payment_method`, `status`, `tgl_dibayar`, `validated`, `created_at`, `updated_at`) VALUES
(1, 121, 1, 1, 10, 776000, 'tunai', 'lunas', '2018-06-28', 0, '2018-06-28 14:45:55', '2018-06-28 21:45:55'),
(2, 121, 1, 16, 34, 2823000, 'tunai', 'hutang', '2018-06-28', 0, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(3, 121, 1, 1, 53, 4956000, 'tunai', 'lunas', '2018-06-28', 0, '2018-06-28 14:47:18', '2018-06-28 21:47:18'),
(4, 121, 1, 1, 48, 4380000, 'tunai', 'lunas', '2018-06-30', 0, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(5, 121, 1, 1, 11, 668000, 'tunai', 'lunas', '2018-06-30', 0, '2018-06-30 16:42:37', '2018-06-30 23:42:37'),
(6, 121, 1, 1, 8, 687000, 'tunai', 'lunas', '2018-07-01', 0, '2018-06-30 17:28:08', '2018-07-01 00:28:08'),
(7, 121, 1, 1, 125, 11320000, 'tunai', 'lunas', '2018-07-01', 0, '2018-06-30 18:21:23', '2018-07-01 01:21:23'),
(8, 121, 1, 1, 29, 2699000, 'tunai', 'lunas', '2018-07-12', 0, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(9, 121, 1, 1, 43, 3834000, 'tunai', 'lunas', '2018-07-12', 0, '2018-07-11 17:02:36', '2018-07-12 00:02:36');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `update_orders` BEFORE UPDATE ON `orders` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `nominal` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `order_id`, `nominal`, `created_at`, `updated_at`) VALUES
(1, 1, 776000, '2018-06-28 14:45:56', '2018-06-28 21:45:56'),
(2, 2, 1000000, '2018-06-28 14:46:49', '2018-06-28 21:46:49'),
(3, 3, 4956000, '2018-06-28 14:47:19', '2018-06-28 21:47:19'),
(4, 4, 4380000, '2018-06-30 16:42:15', '2018-06-30 23:42:15'),
(5, 5, 668000, '2018-06-30 16:42:38', '2018-06-30 23:42:38'),
(6, 6, 687000, '2018-06-30 17:28:08', '2018-07-01 00:28:08'),
(7, 7, 11320000, '2018-06-30 18:21:23', '2018-07-01 01:21:23'),
(8, 8, 2699000, '2018-07-11 17:01:53', '2018-07-12 00:01:53'),
(9, 9, 3834000, '2018-07-11 17:02:37', '2018-07-12 00:02:37');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) NOT NULL,
  `label` varchar(100) NOT NULL,
  `name_permission` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `label`, `name_permission`, `created_at`, `updated_at`) VALUES
(7, 'Dashboard', 'dashboard.index', '2017-01-23 09:53:55', '2017-01-23 09:01:02'),
(32, 'Kasir penjualan cepat', 'kasir.quick', '2018-03-12 13:42:05', '2018-03-12 20:42:05'),
(33, 'Simpan Transaksi penjualan', 'kasir.save', '2018-03-13 09:43:15', '2018-03-13 16:43:15'),
(34, 'Kasir Index', 'kasir.index', '2018-03-13 11:13:07', '2018-03-13 18:13:07'),
(35, 'List Penjualan Hari Ini', 'penjualan.hari.ini', '2018-06-02 07:41:36', '2018-06-02 14:41:36'),
(36, 'List Semua Penjualan', 'penjualan.semua', '2018-06-02 07:42:25', '2018-06-02 14:42:25'),
(37, 'Detail Penjualan', 'penjualan.detail', '2018-06-06 05:11:13', '2018-06-06 12:11:13'),
(38, 'Edit Penjualan', 'penjualan.edit', '2018-06-06 05:12:29', '2018-06-06 12:12:29'),
(39, 'Update data penjualan', 'post.penjualan.update', '2018-06-06 05:15:35', '2018-06-06 12:15:35'),
(40, 'Penjualan ke Langganan', 'kasir.to.customer', '2018-06-06 05:19:16', '2018-06-06 12:19:16'),
(41, 'Kasir Save penjualan ke customer', 'kasir.save.to.customer', '2018-06-06 06:11:20', '2018-06-06 13:11:20'),
(42, 'Post Penjualan selesai', 'kasir.finish', '2018-06-06 06:25:25', '2018-06-06 13:25:25'),
(43, 'Finish Penjualan ke customer', 'kasir.finish.to.customer', '2018-06-06 08:04:28', '2018-06-06 15:04:28'),
(44, 'Transaksi antar toko', 'kasir.tostore', '2018-06-06 08:29:40', '2018-06-06 15:29:40'),
(45, 'Finish To Store', 'kasir.finish.to.store', '2018-06-06 09:46:56', '2018-06-06 16:46:56'),
(46, 'Kasir delete Penjualan', 'kasir.penjualan.delete', '2018-06-06 14:52:20', '2018-06-06 21:52:20'),
(47, 'Kasir List Stock Barang', 'kasir.stocks.index', '2018-06-06 15:27:53', '2018-06-06 22:27:53'),
(48, 'Kasir View Detail stock product', 'kasir.stock.product.view', '2018-06-06 15:32:40', '2018-06-06 22:32:40'),
(49, 'Kasir tambah stock Produk', 'kasir.product.addstock', '2018-06-06 15:39:52', '2018-06-06 22:39:52'),
(50, 'Kasir (POST) Insert Stock', 'kasir.insert.stock', '2018-06-07 14:35:39', '2018-06-07 21:35:39'),
(51, 'Finish Final Penjualan ke customer', 'kasir.finish.final.tocustomer', '2018-06-11 17:54:22', '2018-06-12 00:54:22'),
(52, 'Bayar Hutang penjualan', 'kasir.hutang.penjualan', '2018-06-20 02:51:01', '2018-06-20 09:51:01'),
(53, 'Bayar Hutang Penjualan', 'kasir.bayar.hutang.penjualan', '2018-06-20 02:52:15', '2018-06-20 09:52:15'),
(54, 'POST Bayar Hutang Penjualan', 'kasir.post.bayar.hutang.penjualan', '2018-06-20 03:10:56', '2018-06-20 10:10:56'),
(55, 'List Penjualan', 'orders.index', '2018-06-21 14:42:02', '2018-06-21 21:42:02'),
(56, 'Lihat Detail Penjualan', 'order.view', '2018-06-21 14:42:26', '2018-06-21 21:42:26'),
(57, 'Report Index', 'report.index', '2018-06-21 14:43:21', '2018-06-21 21:43:21'),
(58, 'Product Index', 'products.index', '2018-06-21 14:44:03', '2018-06-21 21:44:03'),
(59, 'Product View', 'product.view', '2018-06-21 14:44:17', '2018-06-21 21:44:17'),
(60, 'Product Add', 'product.add', '2018-06-21 14:44:34', '2018-06-21 21:44:34'),
(61, 'Post Product add (Store)', 'post.product.add', '2018-06-21 14:44:58', '2018-06-21 21:44:58'),
(62, 'Edit Product', 'product.edit', '2018-06-21 14:45:17', '2018-06-21 21:45:17'),
(63, 'Post Product Update', 'post.product.update', '2018-06-21 14:45:33', '2018-06-21 21:45:33'),
(64, 'Product Add Stocks', 'product.addstocks', '2018-06-21 14:45:55', '2018-06-21 21:45:55'),
(65, 'Edit stock Product', 'product.edit.stock', '2018-06-21 14:46:58', '2018-06-21 21:46:58'),
(66, 'Post update stock Product', 'product.update.stock', '2018-06-21 14:47:17', '2018-06-21 21:47:17'),
(67, 'Delete Product Stock', 'stock.delete', '2018-06-21 14:47:35', '2018-06-21 21:47:35'),
(68, 'Ubah password untuk kasir', 'kasir.ubah.password', '2018-06-22 17:45:14', '2018-06-23 00:45:14'),
(69, 'Ubah password untuk kasir (POST)', 'post.kasir.ubah.password', '2018-06-22 17:45:37', '2018-06-23 00:45:37'),
(70, 'Kasir Delete Stock', 'kasir.stock.delete', '2018-06-27 14:54:50', '2018-06-27 21:54:50'),
(71, 'Kasir stock berdasarkan tanggal', 'kasir.stocks.bydate', '2018-06-27 16:15:23', '2018-06-27 23:15:23'),
(72, 'Kasir report', 'kasir.report', '2018-07-03 07:53:54', '2018-07-03 14:53:54');

--
-- Triggers `permissions`
--
DELIMITER $$
CREATE TRIGGER `update_permission` BEFORE INSERT ON `permissions` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(16, 4, 7, '2017-04-16 10:08:26', '2017-04-16 03:08:26'),
(38, 7, 7, '2018-03-12 13:31:44', '2018-03-12 20:31:44'),
(39, 7, 32, '2018-03-12 13:42:14', '2018-03-12 20:42:14'),
(40, 7, 33, '2018-03-13 09:44:06', '2018-03-13 16:44:06'),
(41, 7, 34, '2018-03-13 11:13:16', '2018-03-13 18:13:16'),
(42, 7, 35, '2018-06-02 07:41:45', '2018-06-02 14:41:45'),
(43, 7, 36, '2018-06-02 07:42:34', '2018-06-02 14:42:34'),
(44, 7, 37, '2018-06-06 05:11:22', '2018-06-06 12:11:22'),
(45, 7, 38, '2018-06-06 05:12:43', '2018-06-06 12:12:43'),
(46, 7, 39, '2018-06-06 05:15:42', '2018-06-06 12:15:42'),
(47, 7, 40, '2018-06-06 05:19:24', '2018-06-06 12:19:24'),
(48, 7, 42, '2018-06-06 06:25:35', '2018-06-06 13:25:35'),
(49, 7, 41, '2018-06-06 07:36:27', '2018-06-06 14:36:27'),
(50, 7, 43, '2018-06-06 08:04:36', '2018-06-06 15:04:36'),
(51, 7, 44, '2018-06-06 08:29:47', '2018-06-06 15:29:47'),
(52, 7, 45, '2018-06-06 09:47:05', '2018-06-06 16:47:05'),
(53, 7, 46, '2018-06-06 14:52:32', '2018-06-06 21:52:32'),
(54, 7, 47, '2018-06-06 15:28:00', '2018-06-06 22:28:00'),
(55, 7, 48, '2018-06-06 15:32:50', '2018-06-06 22:32:50'),
(56, 7, 49, '2018-06-06 15:40:01', '2018-06-06 22:40:01'),
(57, 7, 50, '2018-06-07 14:36:18', '2018-06-07 21:36:18'),
(58, 7, 51, '2018-06-11 17:54:36', '2018-06-12 00:54:36'),
(59, 7, 52, '2018-06-20 02:51:12', '2018-06-20 09:51:12'),
(60, 7, 53, '2018-06-20 02:52:25', '2018-06-20 09:52:25'),
(61, 7, 54, '2018-06-20 03:11:08', '2018-06-20 10:11:08'),
(62, 4, 55, '2018-06-21 14:43:33', '2018-06-21 21:43:33'),
(63, 4, 56, '2018-06-21 14:43:33', '2018-06-21 21:43:33'),
(64, 4, 57, '2018-06-21 14:43:33', '2018-06-21 21:43:33'),
(65, 4, 58, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(66, 4, 59, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(67, 4, 60, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(68, 4, 61, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(69, 4, 62, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(70, 4, 63, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(71, 4, 64, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(72, 4, 65, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(73, 4, 66, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(74, 4, 67, '2018-06-21 14:47:52', '2018-06-21 21:47:52'),
(75, 7, 68, '2018-06-22 17:45:50', '2018-06-23 00:45:50'),
(76, 7, 69, '2018-06-22 17:45:50', '2018-06-23 00:45:50'),
(77, 7, 70, '2018-06-27 14:55:02', '2018-06-27 21:55:02'),
(78, 7, 71, '2018-06-27 16:15:34', '2018-06-27 23:15:34'),
(79, 7, 72, '2018-07-03 07:54:07', '2018-07-03 14:54:07');

--
-- Triggers `permission_role`
--
DELIMITER $$
CREATE TRIGGER `update_permission_role` BEFORE INSERT ON `permission_role` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `description` text,
  `sell_price` int(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `slug`, `category_id`, `description`, `sell_price`, `created_at`, `updated_at`) VALUES
(9, 'BB001', 'BB STD Redmove', 'bb-redmove', 1, NULL, 85000, '2018-03-16 06:25:46', '2018-06-23 13:30:12'),
(10, 'BB002', 'BB DF', 'bb-df', 1, NULL, 85000, '2018-03-16 06:26:07', '2018-03-16 13:26:07'),
(11, 'BB003', 'BB Plasbox', 'bb-plasbox', 1, NULL, 85000, '2018-03-16 06:26:20', '2018-03-16 13:26:20'),
(12, 'BB004', 'BB Redvox', 'bb-redvox', 1, NULL, 87000, '2018-03-16 06:26:45', '2018-03-16 13:26:45'),
(13, 'BB005', 'BB Converse/DC', 'bb-converse-dc', 1, NULL, 89000, '2018-03-16 06:27:13', '2018-03-16 13:27:13'),
(14, 'BB006', 'BB Kombinasi', 'bb-kombinasi', 1, NULL, 89000, '2018-03-16 06:27:31', '2018-03-16 13:27:31'),
(15, 'BB007', 'BB Jumbo', 'bb-jumbo', 1, NULL, 92000, '2018-03-16 06:27:48', '2018-03-16 13:27:48'),
(16, 'BB008', 'BB Bomber M', 'bb-bomber-m', 1, NULL, 90000, '2018-03-16 06:28:07', '2018-03-16 13:28:07'),
(17, 'BB009', 'BB Bomber L', 'bb-bomber-l', 1, NULL, 95000, '2018-03-16 06:28:24', '2018-03-16 13:28:24'),
(18, 'BB010', 'BB Bomber XXL', 'bb-bomber-xxl', 1, NULL, 100000, '2018-03-16 06:28:47', '2018-03-16 13:28:47'),
(19, 'BOM001', 'Bomber Topi', 'bomber-topi', 1, NULL, 100000, '2018-03-16 06:29:25', '2018-03-16 13:29:25'),
(20, 'BOM002', 'Bomber Elang', 'bomber-elang', 1, NULL, 105000, '2018-03-16 06:29:43', '2018-03-16 13:29:43'),
(21, 'BB011', 'BB Cewek M', 'bb-cewek-m', 1, NULL, 82000, '2018-03-16 06:31:25', '2018-03-16 13:31:25'),
(22, 'TS001', 'Taslan M', 'taslan-m', 2, NULL, 70000, '2018-03-16 06:32:25', '2018-03-16 13:32:25'),
(23, 'TS002', 'Taslan STD', 'taslan-std', 2, NULL, 72000, '2018-03-16 06:32:41', '2018-06-23 23:18:03'),
(24, 'TS003', 'Taslan Jumbo', 'taslan-jumbo', 2, NULL, 74000, '2018-03-16 06:33:00', '2018-03-16 13:33:00'),
(25, 'BOM003', 'Bomber Polos M', 'bomber-polos-m', 1, NULL, 65000, '2018-03-16 06:33:24', '2018-03-16 13:33:24'),
(26, 'BOM004', 'Bomber polos L', 'bomber-polos-l', 1, NULL, 70000, '2018-03-16 06:33:44', '2018-03-16 13:33:44'),
(27, 'BOM005', 'Bomber Kotak L', 'bomber-kotak-l', 1, NULL, 85000, '2018-03-16 06:34:09', '2018-06-23 15:27:19'),
(28, 'DES001', 'Despo Polos', 'despo-polos', 1, NULL, 50000, '2018-03-16 06:34:25', '2018-03-16 13:34:25'),
(29, 'MER001', 'Merona Jumbo', 'merona-jumbo', 1, NULL, 55000, '2018-03-16 06:34:45', '2018-06-23 23:16:58'),
(30, 'DES002', 'Despo RF Kombi', 'despo-rf-kombi', 1, NULL, 47000, '2018-03-16 06:35:07', '2018-03-16 13:35:07'),
(31, 'ROM001', 'Rompi BB', 'rompi-bb', 2, NULL, 75000, '2018-03-16 06:35:30', '2018-03-16 13:35:30'),
(32, 'ROM002', 'Rompi Polos std', 'rompi-polos-std', 2, NULL, 37000, '2018-03-16 06:36:07', '2018-03-16 13:36:07'),
(33, 'ROM003', 'Rompi 3M Std', 'rompi-3m-std', 2, NULL, 40000, '2018-03-16 06:36:27', '2018-03-16 13:36:27'),
(34, 'ROM004', 'Rompi Polos Jumbo ', 'rompi-polos-jumbo', 2, NULL, 40000, '2018-03-16 06:36:51', '2018-03-16 13:36:51'),
(35, 'ROM005', 'Rompi 3M Jumbo', 'rompi-3m-jumbo', 2, NULL, 42000, '2018-03-16 06:37:28', '2018-03-16 13:37:28'),
(36, 'ROM006', 'Rompi kombinasi', 'rompi-kombinasi', 2, NULL, 37000, '2018-03-16 06:37:53', '2018-03-16 13:37:53'),
(37, 'KAR001', 'Karlit Rip', 'karlit-rip', 1, NULL, 100000, '2018-03-16 06:48:18', '2018-03-16 13:48:18'),
(38, 'KAR002', 'Karlit Viena Los', 'karlit-viena-los', 1, NULL, 100000, '2018-03-16 06:48:37', '2018-06-23 23:10:36'),
(39, 'KAR003', 'Kalit Bomber', 'kalit-bomber', 1, NULL, 110000, '2018-03-16 06:48:55', '2018-03-16 13:48:55'),
(40, 'KAR004', 'Karlit Res Jumbo', 'karlit-res-jumbo', 1, NULL, 120000, '2018-03-16 06:49:26', '2018-03-16 13:49:26'),
(41, 'SW001', 'Sweater STD', 'sweater-standar', 1, NULL, 46000, '2018-03-16 06:49:46', '2018-06-23 23:38:32'),
(42, 'SW002', 'Sweater Oblong STD', 'sweater-oblong', 1, NULL, 44000, '2018-03-16 06:50:06', '2018-06-24 16:49:59'),
(43, 'SW003', 'Sweater Reglan Sablon', 'sweater-reglan-sablon', 1, NULL, 47500, '2018-03-16 06:50:23', '2018-06-24 01:01:30'),
(44, 'SW004', 'Sweater res 1/2', 'sweater-res-1-2', 1, NULL, 46000, '2018-03-16 06:50:51', '2018-06-23 23:40:48'),
(45, 'SW013', 'Sweater Harakiri', 'harakiri', 1, NULL, 52000, '2018-03-16 06:51:07', '2018-06-24 16:51:18'),
(46, 'SW010', 'Sweater Harajuku', 'harajuku', 1, NULL, 44000, '2018-03-16 06:51:24', '2018-06-24 16:42:34'),
(47, 'RES001', 'Res tuton krah', 'res-tuton-krah', 1, NULL, 55500, '2018-03-16 06:51:46', '2018-06-24 00:59:59'),
(48, 'RES002', 'Res Tuton Topi', 'res-tuton-topi', 1, NULL, 57500, '2018-03-16 06:52:01', '2018-06-24 00:58:31'),
(49, 'TUT001', 'Tuton AW', 'tuton-aw', 1, NULL, 65000, '2018-03-16 06:52:18', '2018-03-16 13:52:18'),
(50, 'SW005', 'Sweater Jumbo', 'sweater-jumbo', 1, NULL, 55000, '2018-03-16 06:52:35', '2018-03-16 13:52:35'),
(51, 'SW006', 'Sweater Loreng', 'sweater-loreng', 1, NULL, 46500, '2018-03-16 06:52:52', '2018-06-23 23:41:23'),
(52, 'SW007', 'Sweater Bomber', 'sweater-bomber', 1, NULL, 53500, '2018-03-16 06:53:11', '2018-06-24 16:48:54'),
(53, 'bbloreng', 'BB LORENG TOPI', 'bb-loreng-topi', 1, NULL, 95000, '2018-06-11 00:24:05', '2018-06-10 09:36:29'),
(54, 'BBLO', 'BB LORENG KRAH', 'bb-loreng', 1, NULL, 95000, '2018-06-11 00:32:19', '2018-06-10 09:46:49'),
(55, 'BB012', 'BB REDMOVE KRAH', 'bb-redmove-krah', 1, NULL, 90000, '2018-06-11 00:51:28', '2018-06-10 20:51:28'),
(56, 'BOM006', 'Bomber Anak', 'bomber-anak', 1, NULL, 65000, '2018-06-23 08:24:32', '0000-00-00 00:00:00'),
(57, 'BOM007', 'Bomber Topi M', 'bomber-topi-m', 1, NULL, 95000, '2018-06-23 08:25:46', '0000-00-00 00:00:00'),
(58, 'BOM008', 'Bomber Kotak M', 'bomber-kotak-m', 1, NULL, 80000, '2018-06-23 16:01:45', '0000-00-00 00:00:00'),
(59, 'BOM009', 'Bomber Despo', 'bomber-despo', 1, NULL, 70000, '2018-06-23 16:02:28', '0000-00-00 00:00:00'),
(60, 'DES003', 'Despo Nike', 'despo-nike', 0, NULL, 50000, '2018-06-23 16:04:22', '0000-00-00 00:00:00'),
(61, 'MER002', 'Merona Kombinasi', 'merona-kombinasi', 1, NULL, 47000, '2018-06-23 16:05:57', '0000-00-00 00:00:00'),
(62, 'RED001', 'Redfox Kombinasi', 'redfox-kombinasi', 1, NULL, 55000, '2018-06-23 16:07:33', '0000-00-00 00:00:00'),
(63, 'KAR005', 'Karlit Angela XXL', 'karlit-angela-xxl', 1, NULL, 120000, '2018-06-23 16:08:58', '0000-00-00 00:00:00'),
(64, 'BB010', 'BB Kerah Redmove', 'bb-kerah-redmove', 1, NULL, 0, '2018-06-23 16:23:51', '0000-00-00 00:00:00'),
(65, 'BB011', 'BB Kerah Redvox', 'bb-kerah-redvox', 1, NULL, 0, '2018-06-23 16:24:56', '0000-00-00 00:00:00'),
(67, 'SW008', 'Sweater Full Print', 'sweater-full-print', 1, NULL, 45000, '2018-06-23 16:44:35', '0000-00-00 00:00:00'),
(68, 'SW009', 'Sweater Res Dagu', 'sweater-res-dagu', 1, NULL, 47000, '2018-06-23 17:54:23', '0000-00-00 00:00:00'),
(69, 'SW011', 'Sweater Batok', 'sweater-batok', 1, NULL, 45000, '2018-06-24 09:45:05', '0000-00-00 00:00:00'),
(70, 'SW012', 'Sweater Reglan Bordir', 'sweater-reglan-bordir', 1, NULL, 44500, '2018-06-24 09:46:34', '0000-00-00 00:00:00'),
(71, 'LOT001', 'Lotto STD', 'lotto-std', 1, NULL, 50000, '2018-06-24 09:52:35', '0000-00-00 00:00:00');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `update_products` BEFORE UPDATE ON `products` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Superadmin', '2015-02-03 11:29:40', '2017-01-21 23:01:28'),
(4, 'Administrator', '2017-04-16 17:08:26', '2017-04-16 10:08:26'),
(7, 'Kasir', '2018-03-12 13:31:44', '2018-03-12 20:31:44');

--
-- Triggers `roles`
--
DELIMITER $$
CREATE TRIGGER `update_role` BEFORE UPDATE ON `roles` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'bayar_via', 'a:3:{i:1;s:5:\"Tunai\";i:2;s:37:\"BSM 7197977878 a.n DKM Burj Al Bakrie\";i:3;s:7:\"eWallet\";}', '2017-06-20 06:05:37', '0000-00-00 00:00:00'),
(2, 'simpanan_wajib_bulanan', '50000', '2017-07-22 13:29:25', '0000-00-00 00:00:00'),
(3, 'email_from', 'kopsyahmun@gmail.com', '2017-08-01 07:45:57', '0000-00-00 00:00:00'),
(4, 'company_name', 'REDFOX STORE', '2017-08-01 07:47:44', '0000-00-00 00:00:00'),
(5, 'toko_penerima_stock', '1', '2018-06-06 14:38:07', '0000-00-00 00:00:00'),
(6, 'main_store', '1', '2018-06-23 06:24:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `stock_in` int(11) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL,
  `stock_from` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stocks coming form supplier or store?',
  `stock_from_id` int(11) NOT NULL,
  `stock_out` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `tanggal`, `created_at`, `updated_at`, `product_id`, `user_id`, `stock_in`, `store_id`, `stock_from`, `stock_from_id`, `stock_out`, `description`) VALUES
(21, '2018-06-23', '2018-06-23 07:18:54', '2018-06-23 14:18:54', 9, 121, 11, 1, 'supplier', 1, 0, ''),
(22, '2018-06-23', '2018-06-23 07:19:56', '2018-06-23 14:19:56', 12, 121, 114, 1, 'supplier', 1, 0, ''),
(23, '2018-06-23', '2018-06-23 07:21:02', '2018-06-23 14:21:02', 14, 121, 348, 1, 'supplier', 1, 0, ''),
(24, '2018-06-23', '2018-06-23 07:21:41', '2018-06-23 14:21:41', 13, 121, 814, 1, 'supplier', 1, 0, ''),
(25, '2018-06-23', '2018-06-23 07:22:36', '2018-06-23 14:22:36', 15, 121, 224, 1, 'supplier', 1, 0, ''),
(26, '2018-06-23', '2018-06-23 07:23:30', '2018-06-23 14:23:30', 16, 121, 250, 1, 'supplier', 1, 0, ''),
(27, '2018-06-23', '2018-06-23 07:24:08', '2018-06-23 14:24:08', 21, 121, 1162, 1, 'supplier', 1, 0, ''),
(28, '2018-06-23', '2018-06-23 07:26:20', '2018-06-23 14:26:20', 17, 121, 337, 1, 'supplier', 1, 0, ''),
(29, '2018-06-23', '2018-06-23 07:26:44', '2018-06-23 14:26:44', 18, 121, 49, 1, 'supplier', 1, 0, ''),
(30, '2018-06-23', '2018-06-23 07:28:32', '2018-06-23 14:28:32', 19, 121, 74, 1, 'supplier', 1, 0, ''),
(31, '2018-06-23', '2018-06-23 07:28:47', '2018-06-23 14:28:47', 10, 121, 447, 1, 'supplier', 1, 0, ''),
(32, '2018-06-23', '2018-06-23 07:29:03', '2018-06-23 14:29:03', 11, 121, 233, 1, 'supplier', 1, 0, ''),
(33, '2018-06-23', '2018-06-23 08:24:57', '2018-06-23 15:24:57', 56, 121, 75, 1, 'supplier', 1, 0, ''),
(34, '2018-06-23', '2018-06-23 08:26:17', '2018-06-23 15:26:17', 57, 121, 33, 1, 'supplier', 1, 0, ''),
(35, '2018-06-23', '2018-06-23 08:27:36', '2018-06-23 15:27:36', 27, 121, 214, 1, 'supplier', 1, 0, ''),
(36, '2018-06-23', '2018-06-23 16:00:29', '2018-06-23 23:00:29', 27, 121, 214, 1, 'supplier', 1, 0, ''),
(37, '2018-06-23', '2018-06-23 16:02:48', '2018-06-23 23:02:48', 59, 121, 211, 1, 'supplier', 1, 0, ''),
(38, '2018-06-23', '2018-06-23 16:03:21', '2018-06-23 23:03:21', 28, 121, 836, 1, 'supplier', 1, 0, ''),
(39, '2018-06-23', '2018-06-23 16:04:41', '2018-06-23 23:04:41', 60, 121, 130, 1, 'supplier', 1, 0, ''),
(40, '2018-06-23', '2018-06-23 16:06:13', '2018-06-23 23:06:13', 61, 121, 526, 1, 'supplier', 1, 0, ''),
(41, '2018-06-23', '2018-06-23 16:07:48', '2018-06-23 23:07:48', 62, 121, 302, 1, 'supplier', 1, 0, ''),
(42, '2018-06-23', '2018-06-23 16:09:14', '2018-06-23 23:09:14', 63, 121, 19, 1, 'supplier', 1, 0, ''),
(43, '2018-06-23', '2018-06-23 16:09:41', '2018-06-23 23:09:41', 37, 121, 50, 1, 'supplier', 1, 0, ''),
(44, '2018-06-23', '2018-06-23 16:10:51', '2018-06-23 23:10:51', 38, 121, 44, 1, 'supplier', 1, 0, ''),
(45, '2018-06-23', '2018-06-23 16:17:17', '2018-06-23 23:17:17', 29, 121, 82, 1, 'supplier', 1, 0, ''),
(46, '2018-06-23', '2018-06-23 16:19:18', '2018-06-23 23:19:18', 23, 121, 13, 1, 'supplier', 1, 0, ''),
(47, '2018-06-23', '2018-06-23 16:19:54', '2018-06-23 23:19:54', 33, 121, 39, 1, 'supplier', 1, 0, ''),
(48, '2018-06-23', '2018-06-23 16:20:26', '2018-06-23 23:20:26', 35, 121, 30, 1, 'supplier', 1, 0, ''),
(49, '2018-06-23', '2018-06-23 16:21:00', '2018-06-23 23:21:00', 32, 121, 67, 1, 'supplier', 1, 0, ''),
(50, '2018-06-23', '2018-06-23 16:21:22', '2018-06-23 23:21:22', 34, 121, 320, 1, 'supplier', 1, 0, ''),
(51, '2018-06-23', '2018-06-23 16:21:50', '2018-06-23 23:21:50', 36, 121, 188, 1, 'supplier', 1, 0, ''),
(52, '2018-06-23', '2018-06-23 16:22:09', '2018-06-23 23:22:09', 39, 121, 55, 1, 'supplier', 1, 0, ''),
(53, '2018-06-23', '2018-06-23 16:38:45', '2018-06-23 23:38:45', 41, 121, 967, 1, 'supplier', 1, 0, ''),
(55, '2018-06-23', '2018-06-23 16:40:59', '2018-06-23 23:40:59', 44, 121, 17, 1, 'supplier', 1, 0, ''),
(56, '2018-06-23', '2018-06-23 16:41:40', '2018-06-23 23:41:40', 51, 121, 210, 1, 'supplier', 1, 0, ''),
(57, '2018-06-23', '2018-06-23 16:43:38', '2018-06-23 23:43:38', 50, 121, 174, 1, 'supplier', 1, 0, ''),
(58, '2018-06-23', '2018-06-23 16:44:53', '2018-06-23 23:44:53', 67, 121, 26, 1, 'supplier', 1, 0, ''),
(59, '2018-06-24', '2018-06-23 17:54:52', '2018-06-24 00:54:52', 68, 121, 180, 1, 'supplier', 1, 0, ''),
(61, '2018-06-24', '2018-06-23 17:59:09', '2018-06-24 00:59:09', 48, 121, 600, 1, 'supplier', 1, 0, ''),
(62, '2018-06-24', '2018-06-23 17:59:36', '2018-06-24 00:59:36', 47, 121, 138, 1, 'supplier', 1, 0, ''),
(63, '2018-06-24', '2018-06-24 09:41:16', '2018-06-24 16:41:16', 43, 121, 276, 1, 'supplier', 1, 0, ''),
(64, '2018-06-24', '2018-06-24 09:43:10', '2018-06-24 16:43:10', 46, 121, 360, 1, 'supplier', 1, 0, ''),
(65, '2018-06-24', '2018-06-24 09:45:29', '2018-06-24 16:45:29', 69, 121, 27, 1, 'supplier', 1, 0, ''),
(66, '2018-06-24', '2018-06-24 09:47:42', '2018-06-24 16:47:42', 70, 121, 14, 1, 'supplier', 1, 0, ''),
(67, '2018-06-24', '2018-06-24 09:48:17', '2018-06-24 16:48:17', 52, 121, 64, 1, 'supplier', 1, 0, ''),
(68, '2018-06-24', '2018-06-24 09:50:20', '2018-06-24 16:50:20', 42, 121, 402, 1, 'supplier', 1, 0, ''),
(69, '2018-06-24', '2018-06-24 09:51:36', '2018-06-24 16:51:36', 45, 121, 328, 1, 'supplier', 1, 0, ''),
(70, '2018-06-24', '2018-06-24 09:52:59', '2018-06-24 16:52:59', 71, 121, 336, 1, 'supplier', 1, 0, '');

--
-- Triggers `stocks`
--
DELIMITER $$
CREATE TRIGGER `update_stock` BEFORE UPDATE ON `stocks` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Blok F', 'Pasar Tanah Abang Blok F', '0875654168555', '2018-06-11 14:23:07', '2018-06-11 21:23:07'),
(2, 'Blok A', 'Pasar Tanah Abang Blok F', '08784545454', '2018-06-20 02:56:37', '2018-06-20 09:56:37');

--
-- Triggers `stores`
--
DELIMITER $$
CREATE TRIGGER `update_store` BEFORE UPDATE ON `stores` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `created_at`, `updated_at`, `name`, `address`, `phone`) VALUES
(1, NULL, NULL, 'Bandung Konveksi', 'Soreang Bandung', '00878787878787'),
(2, NULL, NULL, 'Blok A', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `role_id` int(10) NOT NULL,
  `store_id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8_unicode_ci,
  `address` text COLLATE utf8_unicode_ci,
  `phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_plus_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `store_id`, `username`, `email`, `password`, `activated`, `activation_code`, `activated_at`, `last_login`, `reset_password_code`, `remember_token`, `first_name`, `last_name`, `api_token`, `about`, `address`, `phone`, `facebook_url`, `twitter_url`, `google_plus_url`, `created_at`, `updated_at`, `photo`) VALUES
(85, 2, 0, 'admin', 'digicrea08@gmail.com', '$2y$10$YM/FncH.PD9875h96vlK6ujr50SbVtWYZW3xYMsODER8QD0gL22UG', 1, NULL, NULL, NULL, 'CmH4QxNsBOIQgS2dOgosb5kXzTRPHrrkY6A30pAk86V8vw3yvit8WnIu2m1O', 'cs1wjjcIILK4YBa1ZSaibp3jd5yuszi8EFTb2MGLMYhLLgoloRgAFZZDyLCN', 'Basrul', 'Yandri', '', 'Seseorang yang baru tau kalau ternyata kita gak bisa garuk kuping pake sikut :D', 'Perumahan Maharaja Blok N5-12 Depok', '081290751101', 'https://www.facebook.com/digicrea', 'https://twitter.com/basrul14', 'https://plus.google.com/u/0/103471078199126216243', '2016-11-27 20:29:35', '2018-06-13 08:02:40', 'basrul.jpg'),
(121, 7, 1, 'Jefri', 'jefry@gmail.com', '$2y$10$9kOCGD/LMWKMqrlcD7.4Tep2zocnb9lP0ADnGEA4a/HWPH6epx7ze', 1, NULL, NULL, NULL, NULL, 'a8ZtSXhyzZR1xD1zmDe4FOdzpENDH9Dd8jlVafTcqZxGYAu3XETAepb9UydS', NULL, NULL, '1jMEVSb7289tZa2lP7fjVxijOXq4ftsHR6SBOy8gDZTLBk3PEEJlfXn88usb', NULL, NULL, '0812654789', NULL, NULL, NULL, '2018-03-12 13:34:46', '2018-07-04 19:27:28', '15208616859355-200.png'),
(122, 7, 2, 'joko', 'joko@gmail.com', '$2y$10$WECxRTfXnzIwfJGUrsjslOOXTeJvmeHpE0W1dwnDJVgxfQyT865CW', 1, NULL, NULL, NULL, NULL, 'SnIELJh8XbeXKIyDDlqCL386O2q76SfaJZjWW5jWRfyhzSoVyVWwjbE9YEhZ', NULL, NULL, 'PiYS3NHlb7TRZXRDwunS6LAR3mi3mtPezxz4qWsiGu10FpvTHUjqulnQceZI', NULL, NULL, '087878719285', NULL, NULL, NULL, '2018-03-16 14:55:38', '2018-06-13 06:41:23', '1521212138users-group_318-48680.jpg'),
(123, 4, 0, 'ade', 'ade@gmail.com', '$2y$10$J/fAW04UEx54.cZkkgFySOQJ261yQoXGPoolx87JdYsRkFZnoIzCa', 1, NULL, NULL, NULL, NULL, 'tHOAPtJRPC6wRYBh8RhOpvL6x3Sxroh6wZap4KKtaMEx39yrr39BsFrDehNH', 'Ade', NULL, 'eeKjxywD1aB3aEJK1EBOFmA8hMEYY8LNWWaHgJilk4ZusRqpcHwVeNKuaQXB', NULL, NULL, '0811', NULL, NULL, NULL, '2018-06-21 14:38:24', '2018-06-23 13:32:49', NULL);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `update_user` BEFORE UPDATE ON `users` FOR EACH ROW SET NEW.`updated_at` = NOW()
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idgroup` (`role_id`,`permission_id`),
  ADD KEY `idpermission` (`permission_id`),
  ADD KEY `idrole` (`role_id`),
  ADD KEY `idpermission_2` (`permission_id`),
  ADD KEY `idrole_2` (`role_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_stock_products_id_foreign` (`product_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_activation_code_index` (`activation_code`),
  ADD KEY `users_reset_password_code_index` (`reset_password_code`),
  ADD KEY `idgroup` (`role_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `role_id_2` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
