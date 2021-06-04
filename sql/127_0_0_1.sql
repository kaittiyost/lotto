DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

DROP TABLE IF EXISTS `bank_account`;
CREATE TABLE `bank_account` (
  `id` int(11) NOT NULL,
  `bank_account_name` varchar(255) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `bank_type` varchar(255) NOT NULL,
  `bank_account_id` varchar(20) NOT NULL,
  `bank_user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `time_reg` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `bucket`
--

DROP TABLE IF EXISTS `bucket`;
CREATE TABLE `bucket` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `lottery_id` int(20) NOT NULL,
  `quan` int(6) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `fb_user`
--

DROP TABLE IF EXISTS `fb_user`;
CREATE TABLE `fb_user` (
  `FB_USER_ID` int(10) NOT NULL,
  `USER_ID` int(15) DEFAULT NULL,
  `FB_ID` varchar(225) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `img_confirm`
--

DROP TABLE IF EXISTS `img_confirm`;
CREATE TABLE `img_confirm` (
  `id` int(9) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `img` varchar(225) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `date_upload` varchar(255) DEFAULT NULL,
  `time_upload` varchar(255) DEFAULT NULL,
  `bank_upload` varchar(255) DEFAULT NULL,
  `time_reg` timestamp NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `lottery`
--

DROP TABLE IF EXISTS `lottery`;
CREATE TABLE `lottery` (
  `id` int(20) NOT NULL,
  `number` varchar(6) NOT NULL,
  `date` date DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` int(6) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT 80,
  `status` tinyint(1) DEFAULT 1,
  `reg_date` timestamp NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `confirm_by_admin` int(10) DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Triggers `sales`
--
DROP TRIGGER IF EXISTS `TG_INSERT_IMG_CONFIRM`;
DELIMITER $$
CREATE TRIGGER `TG_INSERT_IMG_CONFIRM` AFTER INSERT ON `sales` FOR EACH ROW BEGIN
	INSERT INTO img_confirm (sale_id, img) 
								VALUES (new.id,NULL);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `bf_del_sales`;
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

DROP TABLE IF EXISTS `sales_det`;
CREATE TABLE `sales_det` (
  `id` int(10) NOT NULL,
  `sale_id` int(10) DEFAULT NULL,
  `lottery_id` int(20) DEFAULT NULL,
  `quan` int(6) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ;

--
-- Triggers `sales_det`
--
DROP TRIGGER IF EXISTS `af_add_sales_det`;
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

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `USER_ID` int(10) NOT NULL,
  `USER_USERNAME` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(70) NOT NULL,
  `USER_UUID` varchar(255) DEFAULT NULL,
  `USER_LASTNAME` varchar(255) NOT NULL DEFAULT '',
  `USER_NAME` varchar(225) NOT NULL DEFAULT '',
  `USER_EMAIL` varchar(225) DEFAULT '',
  `USER_TEL` varchar(20) DEFAULT '',
  `REGIS_TIME` timestamp NULL DEFAULT NULL
) ;

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
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_user` (`bank_user`),
  ADD KEY `bank_id` (`bank_id`);

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
  ADD PRIMARY KEY (`FB_USER_ID`),
  ADD KEY `FB_USER_FK` (`USER_ID`);

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
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `USER_USERNAME` (`USER_USERNAME`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bucket`
--
ALTER TABLE `bucket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fb_user`
--
ALTER TABLE `fb_user`
  MODIFY `FB_USER_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_confirm`
--
ALTER TABLE `img_confirm`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lottery`
--
ALTER TABLE `lottery`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_det`
--
ALTER TABLE `sales_det`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD CONSTRAINT `bank_account_ibfk_1` FOREIGN KEY (`bank_user`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `bank_account_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `bank` (`id`);

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
