-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2017 at 11:24 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_furniture_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `tab_customer`
--

CREATE TABLE `tab_customer` (
  `cust_no` int(11) NOT NULL,
  `first_name` varchar(35) NOT NULL,
  `last_name` varchar(35) NOT NULL,
  `contact_no` char(10) NOT NULL,
  `house_no` varchar(6) NOT NULL,
  `street1` varchar(32) NOT NULL,
  `street2` varchar(32) DEFAULT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `postal_code` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_customer`
--

INSERT INTO `tab_customer` (`cust_no`, `first_name`, `last_name`, `contact_no`, `house_no`, `street1`, `street2`, `city`, `district`, `postal_code`) VALUES
(1, 'John', 'Doe', '0123456789', '1A', 'A Street', NULL, 'A', 'Colombo', '00100'),
(7, 'Jane', 'Doe', '0123654789', '1', 'Downing St', '', 'Galle', 'Galle', '06000');

-- --------------------------------------------------------

--
-- Table structure for table `tab_furniture`
--

CREATE TABLE `tab_furniture` (
  `pc_id` int(11) NOT NULL,
  `pc_name` varchar(32) NOT NULL,
  `pc_type` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `stock_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_furniture`
--

INSERT INTO `tab_furniture` (`pc_id`, `pc_name`, `pc_type`, `description`, `price`, `stock_qty`) VALUES
(1, 'Mahogany Table', 'Table', 'A table made out of Mahogany Wood', '30000.00', 0),
(2, 'Mahogany Chair', 'Chair', 'A chair made out of Mahogany', '15000.00', 25);

-- --------------------------------------------------------

--
-- Table structure for table `tab_order`
--

CREATE TABLE `tab_order` (
  `order_no` int(11) NOT NULL,
  `cust_no` int(11) NOT NULL,
  `date_placed` date NOT NULL,
  `delivery_date` date NOT NULL,
  `showroom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_order`
--

INSERT INTO `tab_order` (`order_no`, `cust_no`, `date_placed`, `delivery_date`, `showroom`) VALUES
(1, 1, '2017-05-27', '2017-06-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tab_order_item`
--

CREATE TABLE `tab_order_item` (
  `order_no` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_order_item`
--

INSERT INTO `tab_order_item` (`order_no`, `item_no`, `qty`) VALUES
(1, 1, 1),
(1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tab_request`
--

CREATE TABLE `tab_request` (
  `ord_no` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tab_showroom`
--

CREATE TABLE `tab_showroom` (
  `srm_id` int(11) NOT NULL,
  `house_no` varchar(5) NOT NULL,
  `street1` varchar(32) NOT NULL,
  `street2` varchar(32) DEFAULT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `postal_code` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_showroom`
--

INSERT INTO `tab_showroom` (`srm_id`, `house_no`, `street1`, `street2`, `city`, `district`, `postal_code`) VALUES
(1, '20', 'Joseph\'s Lane', NULL, 'Bambalapitiya', 'Colombo', 700);

-- --------------------------------------------------------

--
-- Table structure for table `tab_user`
--

CREATE TABLE `tab_user` (
  `usr_id` int(4) NOT NULL,
  `usr_name` varchar(20) NOT NULL,
  `usr_pwd` varchar(20) NOT NULL,
  `access_lvl` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tab_user`
--

INSERT INTO `tab_user` (`usr_id`, `usr_name`, `usr_pwd`, `access_lvl`) VALUES
(1, 'admin', 'admin', 1),
(2, 'sales', 'sales', 2),
(3, 'manager', 'manager', 3),
(4, 'factory', 'factory', 4);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_complete_order`
-- (See below for the actual view)
--
CREATE TABLE `view_complete_order` (
`order_no` int(11)
,`cust_no` int(11)
,`date_placed` date
,`delivery_date` date
,`showroom` int(11)
,`pc_name` varchar(32)
,`qty` int(11)
,`tot_price` decimal(19,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order_subtotal`
-- (See below for the actual view)
--
CREATE TABLE `view_order_subtotal` (
`order_no` int(11)
,`subtotal` decimal(41,2)
);

-- --------------------------------------------------------

--
-- Structure for view `view_complete_order`
--
DROP TABLE IF EXISTS `view_complete_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_complete_order`  AS  select `tab_order`.`order_no` AS `order_no`,`tab_order`.`cust_no` AS `cust_no`,`tab_order`.`date_placed` AS `date_placed`,`tab_order`.`delivery_date` AS `delivery_date`,`tab_order`.`showroom` AS `showroom`,`tab_furniture`.`pc_name` AS `pc_name`,`tab_order_item`.`qty` AS `qty`,(`tab_furniture`.`price` * `tab_order_item`.`qty`) AS `tot_price` from ((`tab_order_item` left join `tab_furniture` on((`tab_order_item`.`item_no` = `tab_furniture`.`pc_id`))) left join `tab_order` on((`tab_order_item`.`order_no` = `tab_order`.`order_no`))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_order_subtotal`
--
DROP TABLE IF EXISTS `view_order_subtotal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_order_subtotal`  AS  select `view_complete_order`.`order_no` AS `order_no`,sum(`view_complete_order`.`tot_price`) AS `subtotal` from `view_complete_order` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_customer`
--
ALTER TABLE `tab_customer`
  ADD PRIMARY KEY (`cust_no`),
  ADD UNIQUE KEY `cust_no` (`cust_no`);

--
-- Indexes for table `tab_furniture`
--
ALTER TABLE `tab_furniture`
  ADD PRIMARY KEY (`pc_id`),
  ADD UNIQUE KEY `pc_id` (`pc_id`);

--
-- Indexes for table `tab_order`
--
ALTER TABLE `tab_order`
  ADD PRIMARY KEY (`order_no`),
  ADD UNIQUE KEY `order_no` (`order_no`),
  ADD KEY `FK_customer` (`cust_no`),
  ADD KEY `FK_showroom` (`showroom`);

--
-- Indexes for table `tab_order_item`
--
ALTER TABLE `tab_order_item`
  ADD PRIMARY KEY (`order_no`,`item_no`),
  ADD KEY `FK_furniture` (`item_no`);

--
-- Indexes for table `tab_request`
--
ALTER TABLE `tab_request`
  ADD PRIMARY KEY (`ord_no`,`pc_id`);

--
-- Indexes for table `tab_showroom`
--
ALTER TABLE `tab_showroom`
  ADD PRIMARY KEY (`srm_id`),
  ADD UNIQUE KEY `srm_id` (`srm_id`);

--
-- Indexes for table `tab_user`
--
ALTER TABLE `tab_user`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_name` (`usr_name`),
  ADD UNIQUE KEY `usr_id` (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tab_customer`
--
ALTER TABLE `tab_customer`
  MODIFY `cust_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tab_furniture`
--
ALTER TABLE `tab_furniture`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tab_order`
--
ALTER TABLE `tab_order`
  MODIFY `order_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tab_showroom`
--
ALTER TABLE `tab_showroom`
  MODIFY `srm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tab_user`
--
ALTER TABLE `tab_user`
  MODIFY `usr_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tab_order`
--
ALTER TABLE `tab_order`
  ADD CONSTRAINT `FK_customer` FOREIGN KEY (`cust_no`) REFERENCES `tab_customer` (`cust_no`),
  ADD CONSTRAINT `FK_showroom` FOREIGN KEY (`showroom`) REFERENCES `tab_showroom` (`srm_id`);

--
-- Constraints for table `tab_order_item`
--
ALTER TABLE `tab_order_item`
  ADD CONSTRAINT `FK_furniture` FOREIGN KEY (`item_no`) REFERENCES `tab_furniture` (`pc_id`),
  ADD CONSTRAINT `FK_order` FOREIGN KEY (`order_no`) REFERENCES `tab_order` (`order_no`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
