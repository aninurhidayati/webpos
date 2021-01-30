/*
Navicat MySQL Data Transfer

Source Server         : Conn-mysql
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : dbwebpos

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-12-01 17:49:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for detail_item
-- ----------------------------
DROP TABLE IF EXISTS `detail_item`;
CREATE TABLE `detail_item` (
  `id_det_item` int(11) NOT NULL AUTO_INCREMENT,
  `code_item` varchar(7) DEFAULT NULL,
  `no_faktur` varchar(20) DEFAULT NULL,
  `hpp` int(11) DEFAULT NULL,
  `hpp_ppn` int(11) DEFAULT NULL,
  `qty_stock` int(11) DEFAULT NULL,
  `real_stock` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL COMMENT 'total = hpp*qty_stock',
  `satuan` varchar(11) DEFAULT NULL,
  `is_active` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_det_item`),
  KEY `code_item` (`code_item`),
  KEY `no_faktur` (`no_faktur`),
  CONSTRAINT `detail_item_ibfk_1` FOREIGN KEY (`code_item`) REFERENCES `mst_item` (`code_item`),
  CONSTRAINT `detail_item_ibfk_2` FOREIGN KEY (`no_faktur`) REFERENCES `faktur_item` (`no_faktur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of detail_item
-- ----------------------------

-- ----------------------------
-- Table structure for det_tst_selling
-- ----------------------------
DROP TABLE IF EXISTS `det_tst_selling`;
CREATE TABLE `det_tst_selling` (
  `iddetail` int(11) NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(15) DEFAULT NULL,
  `iddetail_brg` int(11) DEFAULT NULL,
  `kode_brg` varchar(15) DEFAULT NULL,
  `nama_brg` varchar(100) DEFAULT NULL,
  `hrg_jual` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `hpp` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of det_tst_selling
-- ----------------------------

-- ----------------------------
-- Table structure for faktur_item
-- ----------------------------
DROP TABLE IF EXISTS `faktur_item`;
CREATE TABLE `faktur_item` (
  `idhead` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(20) NOT NULL,
  `sales` varchar(25) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `subtotal` varchar(255) DEFAULT NULL COMMENT 'subtotal = total+ppn',
  `total_payment` int(11) DEFAULT NULL,
  `jml_bayar` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `entrydate` datetime DEFAULT NULL COMMENT 'tgl masuk faktur',
  `tgl_jatuhtempo` datetime DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` varchar(10) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idhead`,`no_faktur`),
  KEY `no_faktur` (`no_faktur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of faktur_item
-- ----------------------------

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

-- ----------------------------
-- Table structure for mst_customer
-- ----------------------------
DROP TABLE IF EXISTS `mst_customer`;
CREATE TABLE `mst_customer` (
  `id_customer` int(11) NOT NULL AUTO_INCREMENT,
  `name_cust` varchar(100) DEFAULT NULL,
  `addr_cust` text,
  `cp_cust` varchar(50) DEFAULT NULL COMMENT 'contact person',
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
  `name_item` varchar(200) NOT NULL,
  `totalstock` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` varchar(10) NOT NULL,
  PRIMARY KEY (`code_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mst_item
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of mst_reference
-- ----------------------------
INSERT INTO `mst_reference` VALUES ('1', 'SATUANBRG', 'Pack', null, '1', '0');
INSERT INTO `mst_reference` VALUES ('2', 'SATUANBRG', 'Box', null, '1', '0');
INSERT INTO `mst_reference` VALUES ('3', 'SATUANBRG', 'Lusin', null, '1', '0');
INSERT INTO `mst_reference` VALUES ('4', 'JENISBRG', 'PN', 'Printer', '1', '0');
INSERT INTO `mst_reference` VALUES ('5', 'JENISBRG', 'TN', 'Tinta', '1', '0');
INSERT INTO `mst_reference` VALUES ('6', 'JENISBRG', 'TR', 'Toner', '1', '0');
INSERT INTO `mst_reference` VALUES ('7', 'JENISBRG', 'CR', 'Catridge', '1', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mst_user
-- ----------------------------
INSERT INTO `mst_user` VALUES ('1', 'admin01', 'Ibu Suwati', '18c6d818ae35a3e8279b5330eda01498', '1');
INSERT INTO `mst_user` VALUES ('2', 'admin02', 'Admin', '827ccb0eea8a706c4c34a16891f84e7b', '1');
INSERT INTO `mst_user` VALUES ('3', 'superadmin', 'Ani Nur', '827ccb0eea8a706c4c34a16891f84e7b', '1');

-- ----------------------------
-- Table structure for tst_selling
-- ----------------------------
DROP TABLE IF EXISTS `tst_selling`;
CREATE TABLE `tst_selling` (
  `id_invoice` int(11) NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(15) DEFAULT NULL,
  `id_cust` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `total_payment` int(11) DEFAULT NULL,
  `status_payment` varchar(15) DEFAULT NULL,
  `date_invoice` datetime DEFAULT NULL,
  `created_by` varchar(15) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id_invoice`),
  KEY `id_cust` (`id_cust`),
  CONSTRAINT `tst_selling_ibfk_1` FOREIGN KEY (`id_cust`) REFERENCES `mst_customer` (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tst_selling
-- ----------------------------

-- ----------------------------
-- View structure for barangmasuk_view
-- ----------------------------
DROP VIEW IF EXISTS `barangmasuk_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `barangmasuk_view` AS SELECT ft.*, dt.id_det_item, dt.code_item, mt.name_item, dt.hpp, dt.hpp_ppn, dt.qty_stock, dt.real_stock, dt.satuan, dt.total, dt.is_active as item_aktif
FROM faktur_item ft INNER JOIN detail_item dt ON ft.no_faktur = dt.no_faktur
INNER JOIN mst_item mt ON dt.code_item = mt.code_item ;

-- ----------------------------
-- View structure for tst_barangkeluar_view
-- ----------------------------
DROP VIEW IF EXISTS `tst_barangkeluar_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `tst_barangkeluar_view` AS SELECT mc.name_cust, ts.* FROM tst_selling ts INNER JOIN mst_customer mc ON ts.id_cust=mc.id_customer  ORDER BY ts.createddate DESC ;

-- ----------------------------
-- View structure for tst_selling_view
-- ----------------------------
DROP VIEW IF EXISTS `tst_selling_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `tst_selling_view` AS SELECT ts.id_invoice, ts.no_invoice, ts.id_cust, mc.name_cust, ts.date_invoice, ts.subtotal, ts.total_payment, ts.status_payment,
ds.iddetail, ds.iddetail_brg, ds.kode_brg, ds.nama_brg, ds.hrg_jual, ds.jumlah, ds.hpp, ds.total, ts.is_active
FROM tst_selling ts INNER JOIN det_tst_selling ds ON ts.no_invoice=ds.no_invoice
INNER JOIN mst_customer mc ON ts.id_cust=mc.id_customer ;
