/*
Navicat MySQL Data Transfer

Source Server         : Conn-mysql
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : dbwebpos

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-11-01 00:48:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for detail_item
-- ----------------------------
DROP TABLE IF EXISTS `detail_item`;
CREATE TABLE `detail_item` (
  `id_det_item` int(11) NOT NULL AUTO_INCREMENT,
  `code_item` varchar(7) DEFAULT NULL,
  `hpp` int(11) DEFAULT NULL,
  `qty_stock` int(11) DEFAULT NULL,
  `entrydate` datetime DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` varchar(10) DEFAULT NULL,
  `satuan` varchar(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_det_item`),
  KEY `code_item` (`code_item`),
  CONSTRAINT `detail_item_ibfk_1` FOREIGN KEY (`code_item`) REFERENCES `mst_item` (`code_item`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detail_item
-- ----------------------------
INSERT INTO `detail_item` VALUES ('1', 'B200003', '900000', '12', '2020-10-29 00:24:57', '2020-10-30 01:43:59', 'admin01', 'Lusin', '1');
INSERT INTO `detail_item` VALUES ('2', 'B200002', '1500000', '24', '2020-10-29 21:50:20', '2020-10-30 01:43:59', 'admin01', 'Pack', '1');
INSERT INTO `detail_item` VALUES ('5', 'B200001', '4300000', '75', '2020-10-20 00:23:35', '2020-10-30 22:35:12', 'admin01', 'Box', '1');
INSERT INTO `detail_item` VALUES ('6', 'B200001', '3000000', '15', '2020-11-01 00:44:12', '2020-11-01 00:44:12', 'admin01', 'Box', '1');

-- ----------------------------
-- Table structure for history_akses
-- ----------------------------
DROP TABLE IF EXISTS `history_akses`;
CREATE TABLE `history_akses` (
  `tgl` datetime DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `deskripsi` text,
  `idkey` varchar(25) DEFAULT NULL COMMENT 'idkey dari record yg di insert/edit\r\n',
  `tableref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of history_akses
-- ----------------------------
INSERT INTO `history_akses` VALUES ('2020-10-29 00:42:29', 'admin01', 'input data barang', null, 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-10-29 00:43:48', 'admin01', 'input data barang', '0', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-10-29 10:03:53', 'admin01', 'mengubah data barang', 'B200001', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-10-29 10:15:37', 'admin01', 'menghapus data barang', 'B200001', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-10-30 01:43:59', 'admin01', 'input data barang masuk', null, 'detail_item');
INSERT INTO `history_akses` VALUES ('2020-10-30 22:35:12', 'admin01', 'input data barang masuk', 'B200003', 'detail_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:04:22', 'admin01', 'mengubah data barang masuk', '5', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:09:26', 'admin01', 'mengubah data barang masuk', '5', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:19:52', 'admin01', 'mengubah data barang masuk', '5', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:22:23', 'admin01', 'mengubah data barang masuk', '5', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:23:35', 'admin01', 'mengubah data barang masuk', '5', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:24:57', 'admin01', 'mengubah data barang masuk', '1', 'mst_item');
INSERT INTO `history_akses` VALUES ('2020-11-01 00:44:12', 'admin01', 'input data barang masuk', 'B200001', 'detail_item');

-- ----------------------------
-- Table structure for mst_customer
-- ----------------------------
DROP TABLE IF EXISTS `mst_customer`;
CREATE TABLE `mst_customer` (
  `id_customer` int(11) NOT NULL AUTO_INCREMENT,
  `name_cust` varchar(100) DEFAULT NULL,
  `addr_cust` text,
  `cp_cust` varchar(50) NOT NULL COMMENT 'contact person',
  `no_telp` varchar(50) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mst_customer
-- ----------------------------

-- ----------------------------
-- Table structure for mst_item
-- ----------------------------
DROP TABLE IF EXISTS `mst_item`;
CREATE TABLE `mst_item` (
  `code_item` varchar(7) NOT NULL COMMENT 'TN20001\r\n2 jenis barang\r\n2 tahun sekarang\r\n3 no.urut',
  `name_item` varchar(100) NOT NULL,
  `totalstock` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`code_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mst_item
-- ----------------------------
INSERT INTO `mst_item` VALUES ('B200001', 'Printer Epson L2002 Hitam Putih', '90', '1', '2020-10-29 00:35:21', 'admin01');
INSERT INTO `mst_item` VALUES ('B200002', 'Printer Epson L201 + Scanner', '24', '1', '2020-10-29 00:42:29', 'admin01');
INSERT INTO `mst_item` VALUES ('B200003', 'Printer LG L291 + Scanner', '12', '1', '2020-10-29 00:43:48', 'admin01');

-- ----------------------------
-- Table structure for mst_reference
-- ----------------------------
DROP TABLE IF EXISTS `mst_reference`;
CREATE TABLE `mst_reference` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `kode_ref` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `details` varchar(150) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ref`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mst_reference
-- ----------------------------
INSERT INTO `mst_reference` VALUES ('1', 'SATUANBRG', 'Pack', null, '1', '0');
INSERT INTO `mst_reference` VALUES ('2', 'SATUANBRG', 'Box', null, '1', '0');
INSERT INTO `mst_reference` VALUES ('3', 'SATUANBRG', 'Lusin', null, '1', '0');

-- ----------------------------
-- Table structure for mst_user
-- ----------------------------
DROP TABLE IF EXISTS `mst_user`;
CREATE TABLE `mst_user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `fullname` varchar(20) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mst_user
-- ----------------------------
INSERT INTO `mst_user` VALUES ('1', 'admin01', 'Ibu Wati', '827ccb0eea8a706c4c34a16891f84e7b', '1');

-- ----------------------------
-- Table structure for tst_selling
-- ----------------------------
DROP TABLE IF EXISTS `tst_selling`;
CREATE TABLE `tst_selling` (
  `id_invoice` int(11) NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(10) DEFAULT NULL,
  `id_cust` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `total_payment` int(11) DEFAULT NULL,
  `status_payment` varchar(15) DEFAULT NULL,
  `date_invoice` datetime DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_invoice`),
  KEY `id_cust` (`id_cust`),
  CONSTRAINT `tst_selling_ibfk_1` FOREIGN KEY (`id_cust`) REFERENCES `mst_customer` (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tst_selling
-- ----------------------------
