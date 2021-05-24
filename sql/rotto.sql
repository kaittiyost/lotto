-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 05:36 PM
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
-- Database: `rotto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `reg_date`) VALUES
(0, 'unknow', 'uncheck', '91a73fd806ab2c005c13b4dc19130a884e909dea3f72d46e30266fe1a1f588d8', '2021-05-24 15:33:28'),
(2, 'เทวินทร์', 'admin', '91a73fd806ab2c005c13b4dc19130a884e909dea3f72d46e30266fe1a1f588d8', '2021-05-24 09:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `bucket`
--

CREATE TABLE `bucket` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `lottery_id` int(20) NOT NULL,
  `quan` int(6) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fb_user`
--

CREATE TABLE `fb_user` (
  `FB_USER_ID` int(10) NOT NULL,
  `USER_ID` int(15) DEFAULT NULL,
  `FB_ID` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `img_confirm`
--

CREATE TABLE `img_confirm` (
  `id` int(9) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `img` varchar(225) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `time_reg` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_confirm`
--

INSERT INTO `img_confirm` (`id`, `sale_id`, `img`, `status`, `time_reg`) VALUES
(1, 21, NULL, 0, '2021-05-24 15:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `lottery`
--

CREATE TABLE `lottery` (
  `id` int(20) NOT NULL,
  `number` varchar(6) NOT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` int(6) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT 80,
  `status` tinyint(1) DEFAULT 1,
  `reg_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lottery`
--

INSERT INTO `lottery` (`id`, `number`, `date`, `img`, `stock`, `price`, `status`, `reg_date`) VALUES
(0, '999555', '2021-06-01', 'lotto_excemple.jpeg', 9, '80', 1, '2021-05-18'),
(1, '123456', '2021-06-01', 'lotto_excemple.jpeg', 0, '80', 1, '2021-05-18'),
(2, '654321', '2021-06-01', 'lotto_excemple.jpeg', 60, '80', 1, '2021-05-18'),
(4, '000333', '2021-05-22', 'lotto_excemple.jpeg', 9, '80', 1, '2021-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `confirm_by_admin` int(10) DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `status`, `confirm_by_admin`, `reg_date`) VALUES
(21, 113, 0, 0, '2021-05-24 15:35:11');

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `TG_INSERT_IMG_CONFIRM` AFTER INSERT ON `sales` FOR EACH ROW BEGIN
	INSERT INTO img_confirm (sale_id, img) 
								VALUES (new.id,NULL);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `bf_del_sales` BEFORE DELETE ON `sales` FOR EACH ROW BEGIN
		DECLARE xlot_id int(10);
		DECLARE xquan int(10);
		DECLARE finished TINYINT(1) DEFAULT 0;
		
		DECLARE salse_det_set CURSOR FOR 
		SELECT lottery_id,quan FROM sales_det 
		WHERE sale_id = OLD.id;
		
		DECLARE CONTINUE HANDLER 
			FOR NOT FOUND SET finished = 1;
		
		OPEN salse_det_set;
		
		sale_det_loop : LOOP 
			FETCH salse_det_set INTO xlot_id,xquan;
			IF finished = 1 THEN 
				LEAVE sale_det_loop;
			END IF;
			UPDATE lottery SET stock = stock + xquan WHERE id = xlot_id;
		END LOOP sale_det_loop;
		
		CLOSE salse_det_set;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales_det`
--

CREATE TABLE `sales_det` (
  `id` int(10) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `lottery_id` int(20) DEFAULT NULL,
  `quan` int(6) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_det`
--

INSERT INTO `sales_det` (`id`, `sale_id`, `lottery_id`, `quan`, `price`) VALUES
(18, 21, 1, 1, '80'),
(19, 21, 2, 5, '400');

--
-- Triggers `sales_det`
--
DELIMITER $$
CREATE TRIGGER `af_add_sales_det` AFTER INSERT ON `sales_det` FOR EACH ROW BEGIN
		UPDATE lottery 
		SET stock = stock - new.quan 
		WHERE id = new.lottery_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(10) NOT NULL,
  `USER_USERNAME` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(70) NOT NULL,
  `USER_UUID` varchar(255) DEFAULT NULL,
  `USER_LASTNAME` varchar(255) NOT NULL DEFAULT '',
  `USER_NAME` varchar(225) NOT NULL DEFAULT '',
  `USER_EMAIL` varchar(225) DEFAULT '',
  `USER_TEL` varchar(20) DEFAULT '',
  `REGIS_TIME` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `USER_USERNAME`, `USER_PASSWORD`, `USER_UUID`, `USER_LASTNAME`, `USER_NAME`, `USER_EMAIL`, `USER_TEL`, `REGIS_TIME`) VALUES
(113, 'admin', '91a73fd806ab2c005c13b4dc19130a884e909dea3f72d46e30266fe1a1f588d8', 'test', '', '', '', '0970655563', '2021-05-24 09:25:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bucket`
--
ALTER TABLE `bucket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bucket_fk_lot` (`lottery_id`),
  ADD KEY `bucket_fk_user` (`user_id`);

--
-- Indexes for table `fb_user`
--
ALTER TABLE `fb_user`
  ADD PRIMARY KEY (`FB_USER_ID`) USING BTREE,
  ADD KEY `FB_USER_FK` (`USER_ID`) USING BTREE;

--
-- Indexes for table `img_confirm`
--
ALTER TABLE `img_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imgcon_fk_sales` (`sale_id`);

--
-- Indexes for table `lottery`
--
ALTER TABLE `lottery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_fk` (`user_id`),
  ADD KEY `sales_fk_admin` (`confirm_by_admin`);

--
-- Indexes for table `sales_det`
--
ALTER TABLE `sales_det`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_det_fk` (`sale_id`),
  ADD KEY `sales_det_fk2` (`lottery_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`) USING BTREE,
  ADD UNIQUE KEY `USER_USERNAME` (`USER_USERNAME`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bucket`
--
ALTER TABLE `bucket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `fb_user`
--
ALTER TABLE `fb_user`
  MODIFY `FB_USER_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `img_confirm`
--
ALTER TABLE `img_confirm`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lottery`
--
ALTER TABLE `lottery`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sales_det`
--
ALTER TABLE `sales_det`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bucket`
--
ALTER TABLE `bucket`
  ADD CONSTRAINT `bucket_fk_lot` FOREIGN KEY (`lottery_id`) REFERENCES `lottery` (`id`),
  ADD CONSTRAINT `bucket_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`USER_ID`);

--
-- Constraints for table `fb_user`
--
ALTER TABLE `fb_user`
  ADD CONSTRAINT `FB_USER_FK` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `img_confirm`
--
ALTER TABLE `img_confirm`
  ADD CONSTRAINT `imgcon_fk_sales` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sale_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`USER_ID`),
  ADD CONSTRAINT `sales_fk_admin` FOREIGN KEY (`confirm_by_admin`) REFERENCES `admin` (`id`);

--
-- Constraints for table `sales_det`
--
ALTER TABLE `sales_det`
  ADD CONSTRAINT `sales_det_fk` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_det_fk2` FOREIGN KEY (`lottery_id`) REFERENCES `lottery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
