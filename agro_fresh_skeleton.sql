-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 10:53 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agro_fresh`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_balance`
--

CREATE TABLE `ac_balance` (
  `idparty` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `medium` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 means cash 1 means bank',
  `balance` double(18,2) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ac_balance`
--

INSERT INTO `ac_balance` (`idparty`, `title`, `medium`, `balance`, `updated_at`) VALUES
(0, 'Office Cash balance', 0, 0.00, '2020-10-18 01:51:41'),
(0, 'Office Bank Balance', 1, 0.00, '2020-10-18 01:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `cheque`
--

CREATE TABLE `cheque` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank` varchar(64) NOT NULL,
  `branch` varchar(64) NOT NULL,
  `date` date NOT NULL,
  `ac` varchar(24) NOT NULL,
  `cheque_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mesurment_unite`
--

CREATE TABLE `mesurment_unite` (
  `idunite` smallint(5) UNSIGNED NOT NULL,
  `unite` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mesurment_unite`
--

INSERT INTO `mesurment_unite` (`idunite`, `unite`) VALUES
(1, 'BAG'),
(2, 'FEET'),
(4, 'GRAM'),
(3, 'KG'),
(5, 'LITER'),
(7, 'PICS'),
(6, 'PKG');

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_adress`
--

CREATE TABLE `party_adress` (
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `adress` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_email`
--

CREATE TABLE `party_email` (
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_payment`
--

CREATE TABLE `party_payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `idparty` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_phone`
--

CREATE TABLE `party_phone` (
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `phone` varchar(45) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `party_type`
--

CREATE TABLE `party_type` (
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `type` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='0 supplier 1 buyer 2 other';

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `price` double(18,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `idunite` smallint(5) UNSIGNED NOT NULL,
  `sell` tinyint(1) UNSIGNED NOT NULL,
  `purchase` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_input`
--

CREATE TABLE `product_input` (
  `idupdate` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `stock` double(18,3) NOT NULL,
  `type` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `idpurchase` int(10) UNSIGNED NOT NULL,
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_delivery`
--

CREATE TABLE `purchase_delivery` (
  `idpurchase` int(10) UNSIGNED NOT NULL,
  `cost` double(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `idpurchase` int(10) UNSIGNED NOT NULL,
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `unite` double(18,3) NOT NULL,
  `rate` double(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_discount`
--

CREATE TABLE `purchase_discount` (
  `idpurchase` int(10) UNSIGNED NOT NULL,
  `discount` double(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_recipt`
--

CREATE TABLE `purchase_recipt` (
  `idpurchase` int(10) UNSIGNED NOT NULL,
  `recipt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `selles`
--

CREATE TABLE `selles` (
  `idselles` int(10) UNSIGNED NOT NULL,
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `selles_chalan`
--

CREATE TABLE `selles_chalan` (
  `idselles` int(10) NOT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `selles_delivery`
--

CREATE TABLE `selles_delivery` (
  `idselles` int(10) UNSIGNED NOT NULL,
  `cost` double(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `selles_details`
--

CREATE TABLE `selles_details` (
  `idselles` int(10) UNSIGNED NOT NULL,
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `unite` double(18,3) UNSIGNED NOT NULL,
  `rate` double(18,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `selles_discount`
--

CREATE TABLE `selles_discount` (
  `idselles` int(10) UNSIGNED NOT NULL,
  `discount` double(18,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `post` varchar(64) CHARACTER SET latin1 NOT NULL,
  `sallary` double(18,2) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `hour` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_bonus`
--

CREATE TABLE `staff_bonus` (
  `id` int(10) UNSIGNED NOT NULL,
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `month` smallint(5) UNSIGNED NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_joning`
--

CREATE TABLE `staff_joning` (
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_report`
--

CREATE TABLE `staff_report` (
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `rep_month` tinyint(3) UNSIGNED NOT NULL,
  `rep_year` smallint(5) UNSIGNED NOT NULL,
  `attended` smallint(5) UNSIGNED NOT NULL,
  `absent` smallint(5) UNSIGNED NOT NULL,
  `overtime` smallint(5) UNSIGNED NOT NULL,
  `rep_leave` smallint(5) UNSIGNED NOT NULL,
  `sallary` double(18,2) UNSIGNED NOT NULL,
  `hour` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_sallary`
--

CREATE TABLE `staff_sallary` (
  `id` int(10) UNSIGNED NOT NULL,
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `sal_month` smallint(5) UNSIGNED NOT NULL,
  `sal_year` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idproduct` smallint(5) UNSIGNED NOT NULL,
  `stock` double(18,3) UNSIGNED NOT NULL,
  `factory_stock` double(18,3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `medium` tinyint(1) NOT NULL COMMENT '0 mean cash 1 mean bank',
  `ammount` double(18,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_comment`
--

CREATE TABLE `transaction_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_receipt`
--

CREATE TABLE `transaction_receipt` (
  `serial` int(10) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `idparty` smallint(5) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idstaff` smallint(5) UNSIGNED NOT NULL,
  `pass` varchar(45) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `css` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ac_balance`
--
ALTER TABLE `ac_balance`
  ADD UNIQUE KEY `account` (`idparty`,`medium`),
  ADD KEY `idparty` (`idparty`) USING BTREE;

--
-- Indexes for table `cheque`
--
ALTER TABLE `cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesurment_unite`
--
ALTER TABLE `mesurment_unite`
  ADD PRIMARY KEY (`idunite`) USING BTREE,
  ADD UNIQUE KEY `Index_2` (`unite`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`idparty`) USING BTREE;

--
-- Indexes for table `party_adress`
--
ALTER TABLE `party_adress`
  ADD PRIMARY KEY (`idparty`);

--
-- Indexes for table `party_email`
--
ALTER TABLE `party_email`
  ADD UNIQUE KEY `Index_1` (`idparty`);

--
-- Indexes for table `party_payment`
--
ALTER TABLE `party_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_party_payment_2` (`idparty`);

--
-- Indexes for table `party_phone`
--
ALTER TABLE `party_phone`
  ADD UNIQUE KEY `Index_1` (`idparty`,`phone`);

--
-- Indexes for table `party_type`
--
ALTER TABLE `party_type`
  ADD PRIMARY KEY (`idparty`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`idproduct`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idproduct`),
  ADD UNIQUE KEY `Index_2` (`name`) USING BTREE;

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`idproduct`),
  ADD KEY `FK_product_details_1` (`idunite`);

--
-- Indexes for table `product_input`
--
ALTER TABLE `product_input`
  ADD PRIMARY KEY (`idupdate`) USING BTREE,
  ADD KEY `FK_product_input_1` (`idproduct`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`idpurchase`),
  ADD UNIQUE KEY `Index_2` (`idpurchase`,`idparty`) USING BTREE,
  ADD KEY `FK_purchase_1` (`idparty`);

--
-- Indexes for table `purchase_delivery`
--
ALTER TABLE `purchase_delivery`
  ADD PRIMARY KEY (`idpurchase`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD UNIQUE KEY `Index_2` (`idpurchase`,`idproduct`),
  ADD KEY `FK_purchase_details_1` (`idproduct`);

--
-- Indexes for table `purchase_discount`
--
ALTER TABLE `purchase_discount`
  ADD PRIMARY KEY (`idpurchase`);

--
-- Indexes for table `purchase_recipt`
--
ALTER TABLE `purchase_recipt`
  ADD PRIMARY KEY (`idpurchase`);

--
-- Indexes for table `selles`
--
ALTER TABLE `selles`
  ADD PRIMARY KEY (`idselles`),
  ADD UNIQUE KEY `Index_2` (`idselles`,`idparty`) USING BTREE,
  ADD KEY `FK_selles_1` (`idparty`);

--
-- Indexes for table `selles_chalan`
--
ALTER TABLE `selles_chalan`
  ADD KEY `idselles` (`idselles`);

--
-- Indexes for table `selles_delivery`
--
ALTER TABLE `selles_delivery`
  ADD PRIMARY KEY (`idselles`);

--
-- Indexes for table `selles_details`
--
ALTER TABLE `selles_details`
  ADD KEY `Index_2` (`idselles`,`idproduct`),
  ADD KEY `FK_selles_details_2` (`idproduct`);

--
-- Indexes for table `selles_discount`
--
ALTER TABLE `selles_discount`
  ADD PRIMARY KEY (`idselles`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`idstaff`),
  ADD UNIQUE KEY `Index_2` (`name`,`post`) USING BTREE,
  ADD KEY `Index_3` (`idstaff`);

--
-- Indexes for table `staff_bonus`
--
ALTER TABLE `staff_bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_staff_bonus_2` (`idstaff`);

--
-- Indexes for table `staff_joning`
--
ALTER TABLE `staff_joning`
  ADD PRIMARY KEY (`idstaff`);

--
-- Indexes for table `staff_report`
--
ALTER TABLE `staff_report`
  ADD UNIQUE KEY `Index_1` (`idstaff`,`rep_month`,`rep_year`) USING BTREE;

--
-- Indexes for table `staff_sallary`
--
ALTER TABLE `staff_sallary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_staff_sallary_2` (`idstaff`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idproduct`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_comment`
--
ALTER TABLE `transaction_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_receipt`
--
ALTER TABLE `transaction_receipt`
  ADD PRIMARY KEY (`serial`),
  ADD UNIQUE KEY `tranaction_id` (`id`) USING BTREE,
  ADD KEY `party_id` (`idparty`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idstaff`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cheque`
--
ALTER TABLE `cheque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mesurment_unite`
--
ALTER TABLE `mesurment_unite`
  MODIFY `idunite` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `idparty` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party_adress`
--
ALTER TABLE `party_adress`
  MODIFY `idparty` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party_payment`
--
ALTER TABLE `party_payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party_type`
--
ALTER TABLE `party_type`
  MODIFY `idparty` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `idproduct` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idproduct` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `idproduct` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_input`
--
ALTER TABLE `product_input`
  MODIFY `idupdate` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `idpurchase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_discount`
--
ALTER TABLE `purchase_discount`
  MODIFY `idpurchase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_recipt`
--
ALTER TABLE `purchase_recipt`
  MODIFY `idpurchase` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selles`
--
ALTER TABLE `selles`
  MODIFY `idselles` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selles_discount`
--
ALTER TABLE `selles_discount`
  MODIFY `idselles` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `idstaff` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_bonus`
--
ALTER TABLE `staff_bonus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_comment`
--
ALTER TABLE `transaction_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_receipt`
--
ALTER TABLE `transaction_receipt`
  MODIFY `serial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idstaff` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cheque`
--
ALTER TABLE `cheque`
  ADD CONSTRAINT `FK_cheque_1` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `party_adress`
--
ALTER TABLE `party_adress`
  ADD CONSTRAINT `FK_adress_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `party_email`
--
ALTER TABLE `party_email`
  ADD CONSTRAINT `FK_party_email_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `party_payment`
--
ALTER TABLE `party_payment`
  ADD CONSTRAINT `FK_party_payment_1` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_party_payment_2` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `party_phone`
--
ALTER TABLE `party_phone`
  ADD CONSTRAINT `FK_party_phone_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `party_type`
--
ALTER TABLE `party_type`
  ADD CONSTRAINT `FK_party_type_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `FK_price_1` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `FK_product_details_1` FOREIGN KEY (`idunite`) REFERENCES `mesurment_unite` (`idunite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_product_details_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_input`
--
ALTER TABLE `product_input`
  ADD CONSTRAINT `FK_product_input_1` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_purchase_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_delivery`
--
ALTER TABLE `purchase_delivery`
  ADD CONSTRAINT `FK_purchase_delivery_1` FOREIGN KEY (`idpurchase`) REFERENCES `purchase` (`idpurchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `FK_purchase_details_1` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_purchase_details_2` FOREIGN KEY (`idpurchase`) REFERENCES `purchase` (`idpurchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_discount`
--
ALTER TABLE `purchase_discount`
  ADD CONSTRAINT `FK_purchase_discount_1` FOREIGN KEY (`idpurchase`) REFERENCES `purchase` (`idpurchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_recipt`
--
ALTER TABLE `purchase_recipt`
  ADD CONSTRAINT `FK_purchase_recipt_1` FOREIGN KEY (`idpurchase`) REFERENCES `purchase` (`idpurchase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `selles`
--
ALTER TABLE `selles`
  ADD CONSTRAINT `FK_selles_1` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `selles_delivery`
--
ALTER TABLE `selles_delivery`
  ADD CONSTRAINT `FK_selles_delivery_1` FOREIGN KEY (`idselles`) REFERENCES `selles` (`idselles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `selles_details`
--
ALTER TABLE `selles_details`
  ADD CONSTRAINT `FK_selles_details_1` FOREIGN KEY (`idselles`) REFERENCES `selles` (`idselles`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_selles_details_2` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `selles_discount`
--
ALTER TABLE `selles_discount`
  ADD CONSTRAINT `FK_selles_discount_1` FOREIGN KEY (`idselles`) REFERENCES `selles` (`idselles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_bonus`
--
ALTER TABLE `staff_bonus`
  ADD CONSTRAINT `FK_staff_bonus_1` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_staff_bonus_2` FOREIGN KEY (`idstaff`) REFERENCES `staff` (`idstaff`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_joning`
--
ALTER TABLE `staff_joning`
  ADD CONSTRAINT `FK_staff_joning_1` FOREIGN KEY (`idstaff`) REFERENCES `staff` (`idstaff`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_report`
--
ALTER TABLE `staff_report`
  ADD CONSTRAINT `FK_attendence_1` FOREIGN KEY (`idstaff`) REFERENCES `staff` (`idstaff`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff_sallary`
--
ALTER TABLE `staff_sallary`
  ADD CONSTRAINT `FK_staff_sallary_1` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_staff_sallary_2` FOREIGN KEY (`idstaff`) REFERENCES `staff` (`idstaff`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_stock_1` FOREIGN KEY (`idproduct`) REFERENCES `product` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_comment`
--
ALTER TABLE `transaction_comment`
  ADD CONSTRAINT `FK_transaction_comment_1` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_receipt`
--
ALTER TABLE `transaction_receipt`
  ADD CONSTRAINT `fk_trans` FOREIGN KEY (`id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `party` FOREIGN KEY (`idparty`) REFERENCES `party` (`idparty`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_1` FOREIGN KEY (`idstaff`) REFERENCES `staff` (`idstaff`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
