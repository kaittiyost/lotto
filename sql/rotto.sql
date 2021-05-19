/*
 Navicat Premium Data Transfer

 Source Server         : thewin
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : rotto

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 19/05/2021 21:26:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bucket
-- ----------------------------
DROP TABLE IF EXISTS `bucket`;
CREATE TABLE `bucket`  (
  `user_id` int(10) NOT NULL,
  `lottery_id` int(20) NOT NULL,
  `size` int(6) NULL DEFAULT NULL,
  `reg_date` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`user_id`, `lottery_id`) USING BTREE,
  INDEX `bucket_fk_lot`(`lottery_id`) USING BTREE,
  CONSTRAINT `bucket_fk_lot` FOREIGN KEY (`lottery_id`) REFERENCES `lottery` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `bucket_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`USER_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fb_user
-- ----------------------------
DROP TABLE IF EXISTS `fb_user`;
CREATE TABLE `fb_user`  (
  `FB_USER_ID` int(10) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(15) NULL DEFAULT NULL,
  `FB_ID` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`FB_USER_ID`) USING BTREE,
  INDEX `FB_USER_FK`(`USER_ID`) USING BTREE,
  CONSTRAINT `FB_USER_FK` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for img_confirm
-- ----------------------------
DROP TABLE IF EXISTS `img_confirm`;
CREATE TABLE `img_confirm`  (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NULL DEFAULT NULL,
  `img` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  `time_reg` date NULL DEFAULT curdate,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `img_con_fk`(`user_id`) USING BTREE,
  CONSTRAINT `img_con_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`USER_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lottery
-- ----------------------------
DROP TABLE IF EXISTS `lottery`;
CREATE TABLE `lottery`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `number` int(6) NULL DEFAULT NULL,
  `date` date NULL DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `stock` int(6) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `reg_date` date NULL DEFAULT curdate,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lottery
-- ----------------------------
INSERT INTO `lottery` VALUES (0, 999555, '2021-06-01', 'lotto_excemple.jpeg', 2, 1, '2021-05-18');
INSERT INTO `lottery` VALUES (1, 123456, '2021-06-01', 'lotto_excemple.jpeg', 20, 1, '2021-05-18');
INSERT INTO `lottery` VALUES (2, 654321, '2021-06-01', 'lotto_excemple.jpeg', 100, 1, '2021-05-18');

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NULL DEFAULT NULL,
  `reg_date` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sale_fk`(`user_id`) USING BTREE,
  CONSTRAINT `sale_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`USER_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sales_det
-- ----------------------------
DROP TABLE IF EXISTS `sales_det`;
CREATE TABLE `sales_det`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sale_id` int(10) NULL DEFAULT NULL,
  `lottery_id` int(20) NULL DEFAULT NULL,
  `size` int(6) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sales_det_fk`(`sale_id`) USING BTREE,
  INDEX `sales_det_fk2`(`lottery_id`) USING BTREE,
  CONSTRAINT `sales_det_fk` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sales_det_fk2` FOREIGN KEY (`lottery_id`) REFERENCES `lottery` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `USER_ID` int(10) NOT NULL AUTO_INCREMENT,
  `USER_USERNAME` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USER_PASSWORD` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `USER_UUID` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `USER_LASTNAME` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `USER_NAME` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `USER_EMAIL` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `USER_TEL` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `REGIS_TIME` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`USER_ID`) USING BTREE,
  UNIQUE INDEX `USER_USERNAME`(`USER_USERNAME`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 114 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (113, 'admin', '91a73fd806ab2c005c13b4dc19130a884e909dea3f72d46e30266fe1a1f588d8', 'test', '', '', '', '', '2021-05-18 00:06:39');

SET FOREIGN_KEY_CHECKS = 1;
