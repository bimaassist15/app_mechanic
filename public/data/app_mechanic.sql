/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : app_mechanic

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 28/03/2024 07:25:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `barcode_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_id` bigint UNSIGNED NOT NULL,
  `deskripsi_barang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `snornonsn_barang` enum('sn','non sn') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_barang` double NOT NULL,
  `hargajual_barang` double NOT NULL,
  `lokasi_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `status_barang` enum('dijual','khusus servis','dijual & untuk servis','tidak dijual') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `barang_satuan_id_foreign`(`satuan_id` ASC) USING BTREE,
  INDEX `barang_kategori_id_foreign`(`kategori_id` ASC) USING BTREE,
  INDEX `barang_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `barang_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `barang_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES (1, 'KD001', 'Barang 1', 1, 'Deskripsi Barang 1', 'sn', 1850, 20000, 'A1', 1, 'dijual', 1, '2024-03-09 03:21:03', '2024-03-26 05:22:53');
INSERT INTO `barang` VALUES (2, 'KD002', 'Barang2', 2, 'Deskripsi Barang 2', 'sn', 952, 30000, 'A2', 2, 'dijual', 1, '2024-03-09 03:21:45', '2024-03-22 07:41:35');
INSERT INTO `barang` VALUES (3, 'KD003', 'Barang3', 3, 'Deskripsi Barang 3', 'sn', 30, 40000, 'A3', 3, 'dijual', 1, '2024-03-09 03:22:12', '2024-03-16 13:26:55');
INSERT INTO `barang` VALUES (4, 'KD004', 'Barang4', 4, 'Deskripsi Barang 4', 'sn', 50, 50000, 'A4', 3, 'dijual', 1, '2024-03-09 03:22:44', '2024-03-16 10:00:27');
INSERT INTO `barang` VALUES (5, 'KD005', 'Barang5', 4, 'Deskripsi Barang 5', 'sn', 40, 60000, 'A5', 1, 'dijual', 1, '2024-03-09 03:23:17', '2024-03-16 10:02:40');
INSERT INTO `barang` VALUES (6, 'ORD001', 'BARANG ORDER SERVIS 1', 2, 'KETERANGAN BARANG ORDER SERVIS 1', 'sn', 90, 30000, 'A3', 1, 'dijual & untuk servis', 1, '2024-03-24 09:55:57', '2024-03-28 04:44:20');
INSERT INTO `barang` VALUES (7, 'ORD002', 'BARANG ORDER SERVIS 2', 3, 'KETERANGAN BARANG ORDER SERVIS 2', 'sn', 141, 50000, 'A4', 3, 'khusus servis', 1, '2024-03-24 09:56:37', '2024-03-28 03:55:55');
INSERT INTO `barang` VALUES (8, 'ORD003', 'BARANG ORDER SERVIS 3', 2, 'KETERANGAN BARANG ORDER SERVIS 1', 'sn', 69, 80000, 'A5', 2, 'khusus servis', 1, '2024-03-24 09:57:14', '2024-03-25 08:46:49');
INSERT INTO `barang` VALUES (9, 'ORD004', 'BARANG ORDER SERVIS 4', 2, 'KETERANGAN BARANG ORDER SERVIS 4', 'sn', 88, 87000, 'A7', 3, 'khusus servis', 1, '2024-03-24 09:58:14', '2024-03-24 22:40:00');
INSERT INTO `barang` VALUES (10, 'ORD005', 'BARANG ORDER SERVIS 5', 2, 'KETERANGAN BARANG ORDER SERVIS 5', 'sn', 88, 90000, 'A8', 2, 'khusus servis', 1, '2024-03-24 09:58:53', '2024-03-24 09:58:53');
INSERT INTO `barang` VALUES (11, 'ORD006', 'BARANG ORDER SERVIS 6', 2, 'KETERANGAN BARANG ORDER SERVIS 6', 'sn', 180, 15000, 'A10', 1, 'dijual & untuk servis', 1, '2024-03-24 09:59:46', '2024-03-24 09:59:46');

-- ----------------------------
-- Table structure for cabang
-- ----------------------------
DROP TABLE IF EXISTS `cabang`;
CREATE TABLE `cabang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bengkel_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nowa_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat_cabang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status_cabang` tinyint(1) NOT NULL DEFAULT 1,
  `notelpon_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipeprint_cabang` enum('thermal','biasa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `printservis_cabang` enum('thermal','biasa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lebarprint_cabang` double NOT NULL,
  `lebarprintservis_cabang` double NOT NULL,
  `domain_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `teksnotamasuk_cabang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `teksnotaambil_cabang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cabang
-- ----------------------------
INSERT INTO `cabang` VALUES (1, 'Bengkel cabang 1', 'Cabang 1', '30287832897', 'Kota Cabang 1', 'cabang1@gmail.com', 'Alamat cabang 1', 1, '8398327987', 'thermal', 'thermal', 80, 84, 'cabang1@gmail.com', 'Teks nota servis masuk', 'Teks nota servis ambil', '2024-03-08 08:02:44', '2024-03-08 08:02:44');
INSERT INTO `cabang` VALUES (2, 'Bengkel cabang 2', 'Cabang 2', '89284928', 'Kota cabang 2', 'cabang2@gmail.com', 'Alamat cabang 2', 1, '832982398', 'thermal', 'thermal', 89, 89, 'cabang2@gmail.com', 'Teks nota servis masuk', 'Teks nota servis ambil', '2024-03-08 08:03:52', '2024-03-08 08:03:52');
INSERT INTO `cabang` VALUES (3, 'Bengkel cabang 3', 'Cabang 3', '8942894823', 'Kota Cabang 3', 'cabang3@gmail.com', 'Alamat cabang 3', 1, '39289429898', 'thermal', 'thermal', 89, 75, 'cabang3@gmail.com', 'Teks nota servis masuk', 'Teks nota servis ambil', '2024-03-08 08:04:40', '2024-03-08 08:04:40');
INSERT INTO `cabang` VALUES (4, 'Bengkel cabang 4', 'Cabang 4', '802984928', 'Kota Cabang 4', 'cabang4@gmail.com', 'Alamat cabang 4', 1, '032893289', 'thermal', 'thermal', 60, 70, 'cabang4@gmail.com', 'Teks nota servis masuk', 'Teks nota servis ambil', '2024-03-08 08:05:23', '2024-03-08 08:05:23');
INSERT INTO `cabang` VALUES (5, 'Bengkel Cabang pusat', 'Cabang pusat', '082277506232', 'Jakarta', 'cabangpusat@gmail.com', 'Jakarta pusat', 1, '6210898313', 'thermal', 'thermal', 80, 85, 'cabangpusatdomain@gmail.com', 'Hello selamat datang di cabang pusat', 'Silahkan berbelanja kembali', '2024-03-10 09:53:02', '2024-03-10 09:53:02');

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nowa_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `alamat_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_customer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `customer_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 'Customer 1', '802893278', 'customer1@gmail.com', 'alamat customer 1', '1', 1, '2024-03-09 03:28:05', '2024-03-09 03:28:05');
INSERT INTO `customer` VALUES (2, 'Customer 2', '8320872987', 'customer2@gmail.com', 'alamat customer 2', '1', 1, '2024-03-09 03:28:22', '2024-03-09 03:28:22');
INSERT INTO `customer` VALUES (3, 'Customer 3', '82330978', 'customer3@gmail.com', 'Alamat customer 3', '1', 1, '2024-03-09 03:28:37', '2024-03-09 03:28:37');
INSERT INTO `customer` VALUES (4, 'Customer 4', '82309723987', 'customer4@gmail.com', 'alamat customer 4', '1', 1, '2024-03-09 03:29:05', '2024-03-09 03:29:05');
INSERT INTO `customer` VALUES (5, 'Customer 5', '829073289789', 'customer5@gmail.com', 'alamat customer 5', '1', 1, '2024-03-09 03:29:18', '2024-03-09 03:29:18');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for harga_servis
-- ----------------------------
DROP TABLE IF EXISTS `harga_servis`;
CREATE TABLE `harga_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_hargaservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_hargaservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jasa_hargaservis` double NOT NULL,
  `deskripsi_hargaservis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `profit_hargaservis` double NOT NULL,
  `total_hargaservis` double NOT NULL,
  `status_hargaservis` tinyint(1) NOT NULL DEFAULT 1,
  `kategori_servis_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `harga_servis_kategori_servis_id_foreign`(`kategori_servis_id` ASC) USING BTREE,
  INDEX `harga_servis_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `harga_servis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `harga_servis_kategori_servis_id_foreign` FOREIGN KEY (`kategori_servis_id`) REFERENCES `kategori_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of harga_servis
-- ----------------------------
INSERT INTO `harga_servis` VALUES (1, 'KS001', 'Servis 1', 20000, 'Deskripsi Servis 1', 30000, 50000, 1, 1, 1, '2024-03-09 03:38:25', '2024-03-09 03:38:25');
INSERT INTO `harga_servis` VALUES (2, 'KS002', 'Servis 2', 20000, 'Deskripsi servis 2', 10000, 30000, 1, 2, 1, '2024-03-09 04:58:25', '2024-03-09 04:58:25');
INSERT INTO `harga_servis` VALUES (3, 'KS003', 'Servis 3', 30000, 'Deskripsi servis 3', 30000, 60000, 1, 3, 1, '2024-03-09 04:58:45', '2024-03-09 04:58:45');
INSERT INTO `harga_servis` VALUES (4, 'KS004', 'Servis 4', 25000, 'Deskripsi servis 4', 25000, 50000, 1, 4, 1, '2024-03-09 04:59:21', '2024-03-09 04:59:21');
INSERT INTO `harga_servis` VALUES (5, 'KS005', 'Servis 5', 25000, 'Deskripsi servis 5', 30000, 55000, 1, 5, 1, '2024-03-09 04:59:40', '2024-03-09 04:59:40');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kategori` tinyint(1) NOT NULL DEFAULT 1,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kategori_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `kategori_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Kategori 1', 1, 1, '2024-03-09 03:06:46', '2024-03-09 03:06:46');
INSERT INTO `kategori` VALUES (2, 'Kategori 2', 1, 1, '2024-03-09 03:07:20', '2024-03-09 03:07:20');
INSERT INTO `kategori` VALUES (3, 'Kategori 3', 1, 1, '2024-03-09 03:07:26', '2024-03-09 03:07:26');

-- ----------------------------
-- Table structure for kategori_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `kategori_pembayaran`;
CREATE TABLE `kategori_pembayaran`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kpembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kpembayaran` tinyint(1) NOT NULL DEFAULT 1,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `tipe_kpembayaran` enum('cash','transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kategori_pembayaran_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `kategori_pembayaran_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori_pembayaran
-- ----------------------------
INSERT INTO `kategori_pembayaran` VALUES (1, 'Langsung', 1, 1, 'cash', '2024-03-09 09:24:21', '2024-03-09 09:24:21');
INSERT INTO `kategori_pembayaran` VALUES (2, 'Kartu Kredit', 1, 1, 'transfer', '2024-03-09 09:25:03', '2024-03-09 09:25:03');
INSERT INTO `kategori_pembayaran` VALUES (3, 'Kartu Debit', 1, 1, 'transfer', '2024-03-09 09:25:13', '2024-03-09 09:25:13');
INSERT INTO `kategori_pembayaran` VALUES (4, 'Deposit', 1, 1, 'deposit', '2024-03-09 09:25:22', '2024-03-09 09:25:22');

-- ----------------------------
-- Table structure for kategori_servis
-- ----------------------------
DROP TABLE IF EXISTS `kategori_servis`;
CREATE TABLE `kategori_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kservis` tinyint(1) NOT NULL DEFAULT 1,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kategori_servis_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `kategori_servis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kategori_servis
-- ----------------------------
INSERT INTO `kategori_servis` VALUES (1, 'Kategori Servis 1', 1, 1, '2024-03-09 03:36:44', '2024-03-09 03:36:44');
INSERT INTO `kategori_servis` VALUES (2, 'Kategori Servis 2', 1, 1, '2024-03-09 03:37:03', '2024-03-09 03:37:03');
INSERT INTO `kategori_servis` VALUES (3, 'Kategori Servis 3', 1, 1, '2024-03-09 03:37:09', '2024-03-09 03:37:09');
INSERT INTO `kategori_servis` VALUES (4, 'Kategori Servis 4', 1, 1, '2024-03-09 03:37:14', '2024-03-09 03:37:14');
INSERT INTO `kategori_servis` VALUES (5, 'Kategori Servis 5', 1, 1, '2024-03-09 03:37:20', '2024-03-09 03:37:20');

-- ----------------------------
-- Table structure for kendaraan
-- ----------------------------
DROP TABLE IF EXISTS `kendaraan`;
CREATE TABLE `kendaraan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `nopol_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `merek_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipe_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jenis_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tahunbuat_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tahunrakit_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `silinder_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `warna_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `norangka_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomesin_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_kendaraan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kendaraan_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  INDEX `kendaraan_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  CONSTRAINT `kendaraan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kendaraan_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kendaraan
-- ----------------------------
INSERT INTO `kendaraan` VALUES (1, 1, '83290792837', 'Honda', 'Tipe Kendaraan 1', 'Honda', '2022', '2021', 'Silinder kendaraan 1', 'Hitam', '8329797', '8320789237', 'Keterangan kendaraan 1', 1, '2024-03-09 03:30:51', '2024-03-09 03:30:51');
INSERT INTO `kendaraan` VALUES (2, 2, '83290732978', 'Yamaha 2', 'Yamaha', 'Yamaha', '2024', '2023', 'Silinder kendaraan 2', 'Pink', '3289798327', '83297923870', 'Keterangan kendaraan 2', 1, '2024-03-09 03:31:26', '2024-03-09 03:31:26');
INSERT INTO `kendaraan` VALUES (3, 3, '832907329', 'Ninja', 'Kawasaki', 'Kawasaki', '2022', '2018', 'Silinder kendaraan 3', 'Merah', '832097', '32990803928', 'Keterangan kendaraan 3', 1, '2024-03-09 03:32:13', '2024-03-09 03:32:13');
INSERT INTO `kendaraan` VALUES (4, 4, '3273279', 'Kawasaki', 'FU', 'Kawasaki Ninja', '2023', '2019', 'Silinder kendaraan 4', 'Merah Hijau', '82389732897', '3287932879', 'Keterangan kendaraan 4', 1, '2024-03-09 03:32:54', '2024-03-09 03:32:54');
INSERT INTO `kendaraan` VALUES (5, 5, '2389738927', 'Kawasaki', 'RXKing', 'Kawasaki', '2023', '2020', 'Silinder kendaraan 5', 'Hitam Merah', '823927987', '32708', 'Keterangan kendaraan 5', 1, '2024-03-09 03:33:37', '2024-03-09 03:33:37');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 88 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_10_000002_create_cabangs_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_02_23_173455_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (7, '2024_03_03_071034_create_kategoris_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_03_04_001247_create_kategori_servis_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_03_04_002921_create_customers_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_03_04_021802_create_kendaraans_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_03_05_004001_create_satuans_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_03_06_010710_create_barangs_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_03_06_045529_create_serial_barangs_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_03_06_135811_create_suppliers_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_03_07_003748_create_harga_servis_table', 1);
INSERT INTO `migrations` VALUES (16, '2024_03_07_124633_create_penjualans_table', 1);
INSERT INTO `migrations` VALUES (17, '2024_03_07_124652_create_penjualan_products_table', 1);
INSERT INTO `migrations` VALUES (18, '2024_03_08_073856_create_profiles_table', 1);
INSERT INTO `migrations` VALUES (19, '2024_03_08_075828_add_roles_id_to_table_users', 1);
INSERT INTO `migrations` VALUES (20, '2024_03_08_080838_add_status_to_table_users', 1);
INSERT INTO `migrations` VALUES (21, '2024_03_09_090527_create_kategori_pembayarans_table', 1);
INSERT INTO `migrations` VALUES (22, '2024_03_09_090558_create_sub_pembayarans_table', 1);
INSERT INTO `migrations` VALUES (23, '2024_03_10_114723_add_column_to_penjualan_table', 1);
INSERT INTO `migrations` VALUES (24, '2024_03_10_115056_change_column_type_in_penjualan_table', 1);
INSERT INTO `migrations` VALUES (25, '2024_03_10_115735_change_column_type_in_penjualan_table', 1);
INSERT INTO `migrations` VALUES (26, '2024_03_10_115959_add_column_to_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (27, '2024_03_10_121535_add_column_to_penjualan_table', 1);
INSERT INTO `migrations` VALUES (28, '2024_03_10_122355_remove_column_to_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (29, '2024_03_10_122626_create_penjualan_pembayarans_table', 1);
INSERT INTO `migrations` VALUES (30, '2024_03_10_123342_change_column_type_in_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (31, '2024_03_10_124108_rename_table_penjualan_pembayaran', 1);
INSERT INTO `migrations` VALUES (32, '2024_03_10_124825_add_column_to_penjualan_pembayaran_table', 1);
INSERT INTO `migrations` VALUES (33, '2024_03_10_144954_add_column_to_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (34, '2024_03_10_145128_add_column_to_penjualan_pembayaran_table', 1);
INSERT INTO `migrations` VALUES (35, '2024_03_11_021709_change_column_type_in_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (36, '2024_03_11_021922_change_column_type_in_penjualan_product_table', 1);
INSERT INTO `migrations` VALUES (37, '2024_03_11_023350_add_column_to_penjualan_pembayaran_table', 1);
INSERT INTO `migrations` VALUES (38, '2024_03_11_025933_add_column_to_roles_table', 1);
INSERT INTO `migrations` VALUES (39, '2024_03_11_052317_add_column_to_penjualan_table', 2);
INSERT INTO `migrations` VALUES (40, '2024_03_13_000902_create_penjualan_cicilans_table', 3);
INSERT INTO `migrations` VALUES (41, '2024_03_13_143747_add_column_to_penjualan_table', 4);
INSERT INTO `migrations` VALUES (42, '2024_03_14_005829_add_column_to_penjualan_cicilan_table', 5);
INSERT INTO `migrations` VALUES (43, '2024_03_15_231739_create_pembelians_table', 6);
INSERT INTO `migrations` VALUES (44, '2024_03_15_232236_create_pembelian_cicilans_table', 6);
INSERT INTO `migrations` VALUES (45, '2024_03_15_232826_create_pembelian_pembayarans_table', 6);
INSERT INTO `migrations` VALUES (46, '2024_03_15_233322_create_pembelian_products_table', 6);
INSERT INTO `migrations` VALUES (47, '2024_03_18_064718_create_penerimaan_servis_table', 7);
INSERT INTO `migrations` VALUES (49, '2024_03_18_065329_create_pembayaran_servis_table', 8);
INSERT INTO `migrations` VALUES (50, '2024_03_18_070009_create_saldo_customers_table', 9);
INSERT INTO `migrations` VALUES (51, '2024_03_20_003236_create_saldo_details_table', 9);
INSERT INTO `migrations` VALUES (52, '2024_03_20_012915_add_column_to_penerimaan_servis', 10);
INSERT INTO `migrations` VALUES (53, '2024_03_21_095658_add_column_to_saldo_detail', 11);
INSERT INTO `migrations` VALUES (56, '2024_03_21_101950_add_column_to_penerimaan_servis', 12);
INSERT INTO `migrations` VALUES (57, '2024_03_21_102230_add_column_to_saldo_detail', 12);
INSERT INTO `migrations` VALUES (58, '2024_03_21_115414_add_column_to_saldo_customer', 13);
INSERT INTO `migrations` VALUES (59, '2024_03_21_115435_add_column_to_saldo_detail', 13);
INSERT INTO `migrations` VALUES (60, '2024_03_21_142211_change_column_to_pembayaran_servis', 14);
INSERT INTO `migrations` VALUES (66, '2024_03_21_172256_add_column_penerimaan_servis', 15);
INSERT INTO `migrations` VALUES (68, '2024_03_21_175620_rename_column_saldo_detail', 16);
INSERT INTO `migrations` VALUES (69, '2024_03_21_234734_add_column_penerimaan_servis', 16);
INSERT INTO `migrations` VALUES (70, '2024_03_22_005737_add_column_penerimaan_servis', 16);
INSERT INTO `migrations` VALUES (71, '2024_03_22_015512_add_column_penerimaan_servis', 17);
INSERT INTO `migrations` VALUES (72, '2024_03_24_022629_add_column_to_pembayaran_servis', 18);
INSERT INTO `migrations` VALUES (73, '2024_03_24_024950_create_order_servis_table', 19);
INSERT INTO `migrations` VALUES (74, '2024_03_24_092131_add_column_to_penerimaan_servis', 20);
INSERT INTO `migrations` VALUES (77, '2024_03_24_094040_create_order_barangs_table', 21);
INSERT INTO `migrations` VALUES (79, '2024_03_24_172820_create_service_histories_table', 22);
INSERT INTO `migrations` VALUES (80, '2024_03_24_195604_add_column_to_order_barang', 23);
INSERT INTO `migrations` VALUES (81, '2024_03_24_195633_add_column_to_order_servis', 23);
INSERT INTO `migrations` VALUES (82, '2024_03_24_195837_add_column_to_service_histori', 23);
INSERT INTO `migrations` VALUES (83, '2024_03_25_001510_add_column_to_penerimaan_servis', 24);
INSERT INTO `migrations` VALUES (84, '2024_03_25_092548_add_column_to_penerimaan_servis', 25);
INSERT INTO `migrations` VALUES (85, '2024_03_26_050839_add_column_to_penerimaan_servis', 26);
INSERT INTO `migrations` VALUES (86, '2024_03_28_034355_change_column_to_pembayaran_servis', 27);
INSERT INTO `migrations` VALUES (87, '2024_03_28_034714_change_column_to_pembayaran_servis', 28);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 8);
INSERT INTO `model_has_roles` VALUES (2, 'App\\Models\\User', 9);
INSERT INTO `model_has_roles` VALUES (3, 'App\\Models\\User', 10);
INSERT INTO `model_has_roles` VALUES (4, 'App\\Models\\User', 11);
INSERT INTO `model_has_roles` VALUES (6, 'App\\Models\\User', 12);

-- ----------------------------
-- Table structure for order_barang
-- ----------------------------
DROP TABLE IF EXISTS `order_barang`;
CREATE TABLE `order_barang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `penerimaan_servis_id` bigint UNSIGNED NOT NULL,
  `qty_orderbarang` double NOT NULL,
  `typediskon_orderbarang` enum('fix','%') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon_orderbarang` double NULL DEFAULT NULL,
  `subtotal_orderbarang` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_barang_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `order_barang_barang_id_foreign`(`barang_id` ASC) USING BTREE,
  INDEX `order_barang_penerimaan_servis_id_foreign`(`penerimaan_servis_id` ASC) USING BTREE,
  INDEX `order_barang_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `order_barang_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_barang_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_barang_penerimaan_servis_id_foreign` FOREIGN KEY (`penerimaan_servis_id`) REFERENCES `penerimaan_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_barang_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_barang
-- ----------------------------
INSERT INTO `order_barang` VALUES (21, 8, 6, 26, 1, NULL, NULL, 30000, '2024-03-28 04:44:20', '2024-03-28 04:44:20', 1);

-- ----------------------------
-- Table structure for order_servis
-- ----------------------------
DROP TABLE IF EXISTS `order_servis`;
CREATE TABLE `order_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` bigint UNSIGNED NOT NULL,
  `harga_servis_id` bigint UNSIGNED NOT NULL,
  `penerimaan_servis_id` bigint UNSIGNED NOT NULL,
  `users_id_mekanik` bigint NULL DEFAULT NULL,
  `harga_orderservis` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_servis_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `order_servis_harga_servis_id_foreign`(`harga_servis_id` ASC) USING BTREE,
  INDEX `order_servis_penerimaan_servis_id_foreign`(`penerimaan_servis_id` ASC) USING BTREE,
  INDEX `order_servis_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `order_servis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_servis_harga_servis_id_foreign` FOREIGN KEY (`harga_servis_id`) REFERENCES `harga_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_servis_penerimaan_servis_id_foreign` FOREIGN KEY (`penerimaan_servis_id`) REFERENCES `penerimaan_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_servis_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_servis
-- ----------------------------
INSERT INTO `order_servis` VALUES (20, 8, 1, 26, 11, 50000, '2024-03-28 04:44:08', '2024-03-28 04:44:15', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pembayaran_servis
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran_servis`;
CREATE TABLE `pembayaran_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `sub_pembayaran_id` bigint NULL DEFAULT NULL,
  `bayar_pservis` double NOT NULL,
  `dibayaroleh_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `kembalian_pservis` double NOT NULL,
  `hutang_pservis` double NOT NULL,
  `nomorkartu_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pemilikkartu_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penerimaan_servis_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deposit_pservis` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pembayaran_servis_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  INDEX `pembayaran_servis_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `pembayaran_servis_penerimaan_servis_id_foreign`(`penerimaan_servis_id` ASC) USING BTREE,
  INDEX `pembayaran_servis_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `pembayaran_servis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembayaran_servis_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembayaran_servis_penerimaan_servis_id_foreign` FOREIGN KEY (`penerimaan_servis_id`) REFERENCES `penerimaan_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembayaran_servis_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembayaran_servis
-- ----------------------------
INSERT INTO `pembayaran_servis` VALUES (32, 1, 9, 200000, 'Bima Ega', 8, 0, 0, NULL, NULL, 26, 1, NULL, NULL, 200000);

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_pembelian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaksi_pembelian` datetime NOT NULL,
  `supplier_id` bigint NULL DEFAULT NULL,
  `tipe_pembelian` enum('cash','hutang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `total_pembelian` double NOT NULL,
  `hutang_pembelian` double NOT NULL,
  `kembalian_pembelian` double NOT NULL,
  `bayar_pembelian` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pembelian_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `pembelian_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `pembelian_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (4, '202403162', '2024-03-16 10:02:39', 2, 'cash', 8, 1, 610000, 0, 60000, 670000, '2024-03-16 10:02:40', '2024-03-16 11:05:40');
INSERT INTO `pembelian` VALUES (5, '202403162', '2024-03-16 11:51:00', 4, 'cash', 8, 1, 250000, 0, 50000, 300000, '2024-03-16 11:51:01', '2024-03-16 12:04:36');
INSERT INTO `pembelian` VALUES (6, '202403163', '2024-03-16 12:58:55', 3, 'hutang', 8, 1, 250000, 100000, 0, 150000, '2024-03-16 12:58:56', '2024-03-16 12:58:56');
INSERT INTO `pembelian` VALUES (7, '202403164', '2024-03-16 17:17:39', 1, 'cash', 8, 1, 200000, 0, 70000, 270000, '2024-03-16 17:17:40', '2024-03-16 18:31:14');

-- ----------------------------
-- Table structure for pembelian_cicilan
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_cicilan`;
CREATE TABLE `pembelian_cicilan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `sub_pembayaran_id` bigint UNSIGNED NOT NULL,
  `bayar_pbcicilan` double NOT NULL,
  `dibayaroleh_pbcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `kembalian_pbcicilan` double NOT NULL,
  `hutang_pbcicilan` double NOT NULL,
  `nomorkartu_pbcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pemilikkartu_pbcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pembelian_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pembelian_cicilan_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  INDEX `pembelian_cicilan_sub_pembayaran_id_foreign`(`sub_pembayaran_id` ASC) USING BTREE,
  INDEX `pembelian_cicilan_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `pembelian_cicilan_pembelian_id_foreign`(`pembelian_id` ASC) USING BTREE,
  INDEX `pembelian_cicilan_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `pembelian_cicilan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_cicilan_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_cicilan_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_cicilan_sub_pembayaran_id_foreign` FOREIGN KEY (`sub_pembayaran_id`) REFERENCES `sub_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_cicilan_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_cicilan
-- ----------------------------
INSERT INTO `pembelian_cicilan` VALUES (13, 1, 9, 150000, 'Bima Ega', 8, 0, 60000, NULL, NULL, 4, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (14, 2, 12, 20000, NULL, 8, 0, 40000, '8934749', 'Bima Ega', 4, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (15, 1, 9, 100000, 'Bima Ega', 8, 60000, 0, NULL, NULL, 4, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (16, 2, 13, 30000, NULL, 8, 0, 70000, '8239723', 'Bima Ega', 5, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (17, 1, 9, 20000, 'Bima Ega', 8, 0, 50000, NULL, NULL, 5, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (18, 1, 9, 100000, 'Bima Ega', 8, 50000, 0, NULL, NULL, 5, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (21, 1, 9, 70000, 'Bima Ega', 8, 0, 30000, NULL, NULL, 7, 1, NULL, NULL);
INSERT INTO `pembelian_cicilan` VALUES (22, 1, 8, 100000, 'Bima Ega', 8, 70000, 0, NULL, NULL, 7, 1, NULL, NULL);

-- ----------------------------
-- Table structure for pembelian_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_pembayaran`;
CREATE TABLE `pembelian_pembayaran`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `sub_pembayaran_id` bigint UNSIGNED NOT NULL,
  `bayar_pbpembayaran` double NOT NULL,
  `dibayaroleh_pbpembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `kembalian_pbpembayaran` double NOT NULL,
  `hutang_pbpembayaran` double NOT NULL,
  `nomorkartu_pbpembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pemilikkartu_pbpembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pembelian_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pembelian_pembayaran_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  INDEX `pembelian_pembayaran_sub_pembayaran_id_foreign`(`sub_pembayaran_id` ASC) USING BTREE,
  INDEX `pembelian_pembayaran_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `pembelian_pembayaran_pembelian_id_foreign`(`pembelian_id` ASC) USING BTREE,
  INDEX `pembelian_pembayaran_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `pembelian_pembayaran_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_pembayaran_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_pembayaran_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_pembayaran_sub_pembayaran_id_foreign` FOREIGN KEY (`sub_pembayaran_id`) REFERENCES `sub_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_pembayaran_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_pembayaran
-- ----------------------------
INSERT INTO `pembelian_pembayaran` VALUES (6, 1, 9, 300000, 'Supplier 2', 8, 0, 310000, NULL, NULL, 4, 1, NULL, NULL);
INSERT INTO `pembelian_pembayaran` VALUES (7, 2, 11, 100000, NULL, 8, 0, 210000, '23898329', 'Bima Ega', 4, 1, NULL, NULL);
INSERT INTO `pembelian_pembayaran` VALUES (8, 1, 9, 150000, 'Supplier 4', 8, 0, 100000, NULL, NULL, 5, 1, NULL, NULL);
INSERT INTO `pembelian_pembayaran` VALUES (9, 1, 9, 150000, 'Supplier 3', 8, 0, 100000, NULL, NULL, 6, 1, NULL, NULL);
INSERT INTO `pembelian_pembayaran` VALUES (10, 1, 9, 100000, 'Supplier 1', 8, 0, 100000, NULL, NULL, 7, 1, NULL, NULL);

-- ----------------------------
-- Table structure for pembelian_product
-- ----------------------------
DROP TABLE IF EXISTS `pembelian_product`;
CREATE TABLE `pembelian_product`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaksi_pembelianproduct` datetime NOT NULL,
  `supplier_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah_pembelianproduct` double NOT NULL,
  `typediskon_pembelianproduct` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon_pembelianproduct` double NULL DEFAULT NULL,
  `subtotal_pembelianproduct` double NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `pembelian_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembelian_product
-- ----------------------------
INSERT INTO `pembelian_product` VALUES (1, '2024-03-16 09:55:11', 3, 1, 3, NULL, NULL, 60000, 1, 1, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (2, '2024-03-16 09:55:11', 3, 2, 5, NULL, NULL, 150000, 1, 1, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (3, '2024-03-16 09:59:47', 1, 5, 3, NULL, NULL, 180000, 1, 2, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (4, '2024-03-16 09:59:47', 1, 4, 2, NULL, NULL, 100000, 1, 2, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (5, '2024-03-16 09:59:47', 1, 1, 2, NULL, NULL, 40000, 1, 2, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (6, '2024-03-16 10:01:38', 2, 1, 2, NULL, NULL, 40000, 1, 3, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (7, '2024-03-16 10:01:38', 2, 3, 3, NULL, NULL, 120000, 1, 3, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (8, '2024-03-16 10:01:38', 2, 5, 5, NULL, NULL, 300000, 1, 3, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (9, '2024-03-16 10:02:39', 2, 1, 2, NULL, NULL, 40000, 1, 4, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (10, '2024-03-16 10:02:39', 2, 3, 3, NULL, NULL, 120000, 1, 4, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (11, '2024-03-16 10:02:39', 2, 5, 5, NULL, NULL, 300000, 1, 4, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (12, '2024-03-16 10:02:39', 2, 2, 5, NULL, NULL, 150000, 1, 4, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (13, '2024-03-16 11:51:00', 4, 1, 5, NULL, NULL, 100000, 1, 5, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (14, '2024-03-16 11:51:00', 4, 2, 5, NULL, NULL, 150000, 1, 5, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (15, '2024-03-16 12:58:55', 3, 1, 5, NULL, NULL, 100000, 1, 6, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (16, '2024-03-16 12:58:55', 3, 2, 5, NULL, NULL, 150000, 1, 6, NULL, NULL);
INSERT INTO `pembelian_product` VALUES (17, '2024-03-16 17:17:39', 1, 1, 10, NULL, NULL, 200000, 1, 7, NULL, NULL);

-- ----------------------------
-- Table structure for penerimaan_servis
-- ----------------------------
DROP TABLE IF EXISTS `penerimaan_servis`;
CREATE TABLE `penerimaan_servis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kendaraan_id` bigint UNSIGNED NOT NULL,
  `kategori_servis_id` bigint UNSIGNED NOT NULL,
  `kerusakan_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan_pservis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kmsekarang_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tipe_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isdp_pservis` tinyint(1) NOT NULL DEFAULT 0,
  `total_dppservis` double NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `kembalian_pservis` double NOT NULL DEFAULT 0,
  `hutang_pservis` double NOT NULL DEFAULT 0,
  `noantrian_pservis` int NOT NULL,
  `status_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'antrian servis masuk',
  `users_id` bigint UNSIGNED NOT NULL,
  `nonota_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `customer_id` bigint UNSIGNED NOT NULL,
  `totalbiaya_pservis` double NOT NULL DEFAULT 0,
  `kondisiservis_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nilaiberkala_pservis` int NULL DEFAULT NULL,
  `tipeberkala_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pesanwa_pservis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `catatanteknisi_pservis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `servisberkala_pservis` date NULL DEFAULT NULL,
  `nilaigaransi_pservis` int NULL DEFAULT NULL,
  `tipegaransi_pservis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `servisgaransi_pservis` date NULL DEFAULT NULL,
  `bayar_pservis` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `penerimaan_servis_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  INDEX `penerimaan_servis_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `penerimaan_servis_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  CONSTRAINT `penerimaan_servis_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penerimaan_servis_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penerimaan_servis_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penerimaan_servis
-- ----------------------------
INSERT INTO `penerimaan_servis` VALUES (26, 1, 1, 'Rusak parah cok', 'keluhan dihantam mobil puso', 'Keluhan masuk woi', '2000', 'data langsung ke bengkel', 1, 200000, '2024-03-28 04:43:39', '2024-03-28 04:45:02', 1, 120000, 0, 1, 'bisa diambil', 8, '1', 1, 80000, 'sudah ok', 3, 'bulan', 'pwa', 'wajib servis di 3 bulan kemudian', '2024-06-28', NULL, NULL, NULL, 200000);

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaksi_penjualan` datetime NOT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `tipe_penjualan` enum('cash','hutang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_penjualan` double NOT NULL,
  `hutang_penjualan` double NOT NULL DEFAULT 0,
  `kembalian_penjualan` double NOT NULL,
  `bayar_penjualan` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `penjualan_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `penjualan_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `penjualan_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `penjualan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 94 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan
-- ----------------------------
INSERT INTO `penjualan` VALUES (86, '202403152', '2024-03-15 09:38:33', 1, 'cash', 8, 1, '2024-03-15 09:38:34', '2024-03-15 09:39:51', 200000, 0, 30000, 230000);
INSERT INTO `penjualan` VALUES (87, '202403152', '2024-03-15 09:52:40', NULL, 'cash', 8, 1, '2024-03-15 09:52:41', '2024-03-15 09:52:41', 60000, 0, 40000, 100000);
INSERT INTO `penjualan` VALUES (88, '202403161', '2024-03-16 11:09:45', 2, 'cash', 8, 1, '2024-03-16 11:09:46', '2024-03-16 11:14:32', 250000, 0, 50000, 300000);
INSERT INTO `penjualan` VALUES (89, '202403162', '2024-03-16 13:26:54', NULL, 'cash', 8, 1, '2024-03-16 13:26:55', '2024-03-16 16:46:07', 450000, 0, 20000, 470000);
INSERT INTO `penjualan` VALUES (90, '202403163', '2024-03-16 17:00:52', 4, 'cash', 8, 1, '2024-03-16 17:00:52', '2024-03-16 17:12:57', 100000, 0, 30000, 130000);
INSERT INTO `penjualan` VALUES (92, '202403222', '2024-03-22 07:41:34', 1, 'cash', 8, 1, '2024-03-22 07:41:35', '2024-03-22 07:41:35', 130000, 0, 20000, 150000);
INSERT INTO `penjualan` VALUES (93, '202403261', '2024-03-26 05:22:52', 1, 'cash', 8, 1, '2024-03-26 05:22:53', '2024-03-26 05:25:57', 160000, 0, 40000, 200000);

-- ----------------------------
-- Table structure for penjualan_cicilan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_cicilan`;
CREATE TABLE `penjualan_cicilan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `sub_pembayaran_id` bigint UNSIGNED NOT NULL,
  `bayar_pcicilan` double NOT NULL,
  `dibayaroleh_pcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `kembalian_pcicilan` double NOT NULL,
  `hutang_pcicilan` double NOT NULL,
  `nomorkartu_pcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pemilikkartu_pcicilan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `penjualan_cicilan_penjualan_id_foreign`(`penjualan_id` ASC) USING BTREE,
  INDEX `penjualan_cicilan_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  INDEX `penjualan_cicilan_sub_pembayaran_id_foreign`(`sub_pembayaran_id` ASC) USING BTREE,
  INDEX `penjualan_cicilan_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `penjualan_cicilan_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `penjualan_cicilan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_cicilan_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_cicilan_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_cicilan_sub_pembayaran_id_foreign` FOREIGN KEY (`sub_pembayaran_id`) REFERENCES `sub_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_cicilan_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 85 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_cicilan
-- ----------------------------
INSERT INTO `penjualan_cicilan` VALUES (68, 2, 12, 20000, NULL, 8, 0, 50000, '839382982', 'Bima Ega', 86, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (69, 3, 14, 30000, NULL, 8, 0, 20000, '23989328', 'Bima Ega', 86, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (70, 1, 2, 50000, 'Bima Ega', 8, 30000, 0, NULL, NULL, 86, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (73, 1, 9, 50000, 'Bima Ega', 8, 0, 100000, NULL, NULL, 88, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (74, 3, 14, 50000, NULL, 8, 0, 50000, '82397329', 'Bima Ega', 88, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (75, 1, 9, 100000, 'Bima Ega', 8, 50000, 0, NULL, NULL, 88, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (76, 1, 9, 50000, 'Bima EGa', 8, 0, 100000, NULL, NULL, 89, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (79, 1, 9, 120000, 'Bima Ega', 8, 20000, 0, NULL, NULL, 89, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (80, 1, 9, 30000, 'Bima', 8, 0, 20000, NULL, NULL, 90, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (81, 1, 9, 50000, 'Bima', 8, 30000, 0, NULL, NULL, 90, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (82, 1, 9, 30000, 'Bima Ega', 8, 0, 30000, NULL, NULL, 93, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (83, 1, 5, 20000, 'Bima Ega', 8, 0, 10000, NULL, NULL, 93, 1, NULL, NULL);
INSERT INTO `penjualan_cicilan` VALUES (84, 1, 9, 50000, 'Bima Ega', 8, 40000, 0, NULL, NULL, 93, 1, NULL, NULL);

-- ----------------------------
-- Table structure for penjualan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_pembayaran`;
CREATE TABLE `penjualan_pembayaran`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `sub_pembayaran_id` bigint UNSIGNED NOT NULL,
  `bayar_ppembayaran` double NOT NULL,
  `dibayaroleh_ppembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `kembalian_ppembayaran` double NOT NULL,
  `hutang_ppembayaran` double NOT NULL,
  `nomorkartu_ppembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pemilikkartu_ppembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `penjualan_pembayaran_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  INDEX `penjualan_pembayaran_sub_pembayaran_id_foreign`(`sub_pembayaran_id` ASC) USING BTREE,
  INDEX `penjualan_pembayaran_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `penjualan_pembayaran_penjualan_id_foreign`(`penjualan_id` ASC) USING BTREE,
  INDEX `cabang_id`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `penjualan_pembayaran_ibfk_1` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_pembayaran_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_pembayaran_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_pembayaran_sub_pembayaran_id_foreign` FOREIGN KEY (`sub_pembayaran_id`) REFERENCES `sub_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_pembayaran_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_pembayaran
-- ----------------------------
INSERT INTO `penjualan_pembayaran` VALUES (86, NULL, NULL, 1, 2, 50000, 'Customer 1', 8, 0, 150000, NULL, NULL, 86, 1);
INSERT INTO `penjualan_pembayaran` VALUES (87, NULL, NULL, 2, 12, 80000, NULL, 8, 0, 70000, '3298398', 'Bima Ega', 86, 1);
INSERT INTO `penjualan_pembayaran` VALUES (88, NULL, NULL, 1, 9, 100000, 'Bima', 8, 40000, 0, NULL, NULL, 87, 1);
INSERT INTO `penjualan_pembayaran` VALUES (89, NULL, NULL, 1, 9, 50000, 'Customer 2', 8, 0, 200000, NULL, NULL, 88, 1);
INSERT INTO `penjualan_pembayaran` VALUES (90, NULL, NULL, 2, 12, 50000, NULL, 8, 0, 150000, '3897239', 'Bima EGa', 88, 1);
INSERT INTO `penjualan_pembayaran` VALUES (91, NULL, NULL, 1, 9, 300000, 'Bima Ega', 8, 0, 150000, NULL, NULL, 89, 1);
INSERT INTO `penjualan_pembayaran` VALUES (92, NULL, NULL, 1, 9, 50000, 'Customer 4', 8, 0, 50000, NULL, NULL, 90, 1);
INSERT INTO `penjualan_pembayaran` VALUES (94, NULL, NULL, 1, 9, 150000, 'Customer 1', 8, 20000, 0, NULL, NULL, 92, 1);
INSERT INTO `penjualan_pembayaran` VALUES (95, NULL, NULL, 1, 9, 50000, 'Customer 1', 8, 0, 110000, NULL, NULL, 93, 1);
INSERT INTO `penjualan_pembayaran` VALUES (96, NULL, NULL, 2, 11, 50000, NULL, 8, 0, 60000, '23892389', 'Bima Ega', 93, 1);

-- ----------------------------
-- Table structure for penjualan_product
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_product`;
CREATE TABLE `penjualan_product`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaksi_penjualanproduct` datetime NOT NULL,
  `customer_id` bigint NULL DEFAULT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `jumlah_penjualanproduct` double NOT NULL,
  `typediskon_penjualanproduct` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `diskon_penjualanproduct` double NULL DEFAULT NULL,
  `subtotal_penjualanproduct` double NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `penjualan_product_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `penjualan_product_barang_id_foreign`(`barang_id` ASC) USING BTREE,
  INDEX `penjualan_product_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  INDEX `penjualan_product_penjualan_id_foreign`(`penjualan_id` ASC) USING BTREE,
  CONSTRAINT `penjualan_product_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_product_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `penjualan_product_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 125 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penjualan_product
-- ----------------------------
INSERT INTO `penjualan_product` VALUES (112, '2024-03-15 09:38:33', 1, 1, 10, NULL, NULL, 200000, 1, NULL, NULL, 86);
INSERT INTO `penjualan_product` VALUES (113, '2024-03-15 09:52:40', NULL, 2, 2, NULL, NULL, 60000, 1, NULL, NULL, 87);
INSERT INTO `penjualan_product` VALUES (114, '2024-03-16 11:09:45', 2, 1, 5, NULL, NULL, 100000, 1, NULL, NULL, 88);
INSERT INTO `penjualan_product` VALUES (115, '2024-03-16 11:09:45', 2, 2, 5, NULL, NULL, 150000, 1, NULL, NULL, 88);
INSERT INTO `penjualan_product` VALUES (116, '2024-03-16 13:26:54', NULL, 1, 5, NULL, NULL, 100000, 1, NULL, NULL, 89);
INSERT INTO `penjualan_product` VALUES (117, '2024-03-16 13:26:54', NULL, 2, 5, NULL, NULL, 150000, 1, NULL, NULL, 89);
INSERT INTO `penjualan_product` VALUES (118, '2024-03-16 13:26:54', NULL, 3, 5, NULL, NULL, 200000, 1, NULL, NULL, 89);
INSERT INTO `penjualan_product` VALUES (119, '2024-03-16 17:00:52', 4, 1, 5, NULL, NULL, 100000, 1, NULL, NULL, 90);
INSERT INTO `penjualan_product` VALUES (122, '2024-03-22 07:41:34', 1, 1, 2, NULL, NULL, 40000, 1, NULL, NULL, 92);
INSERT INTO `penjualan_product` VALUES (123, '2024-03-22 07:41:34', 1, 2, 3, NULL, NULL, 90000, 1, NULL, NULL, 92);
INSERT INTO `penjualan_product` VALUES (124, '2024-03-26 05:22:52', 1, 1, 8, NULL, NULL, 160000, 1, NULL, NULL, 93);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for profile
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `jeniskelamin_profile` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `profile_users_id_foreign`(`users_id` ASC) USING BTREE,
  INDEX `profile_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `profile_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `profile_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES (6, 'user1', '82302038', 'alamat user 1', 'L', 8, 1, '2024-03-08 17:26:12', '2024-03-08 17:26:12');
INSERT INTO `profile` VALUES (7, 'user2', '82308239', 'alamat user 2', 'L', 9, 1, '2024-03-08 17:40:00', '2024-03-08 17:40:18');
INSERT INTO `profile` VALUES (8, 'user 3', '83298329', 'alamat user 3', 'L', 10, 1, '2024-03-08 17:40:51', '2024-03-08 17:40:51');
INSERT INTO `profile` VALUES (9, 'user 4', '83209823', 'alamat user 4', 'L', 11, 1, '2024-03-08 17:41:16', '2024-03-08 17:41:28');
INSERT INTO `profile` VALUES (10, 'admin', '082277506232', 'Jakarta pusat', 'L', 12, 5, '2024-03-10 09:53:02', '2024-03-10 09:53:02');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE,
  INDEX `cabang_id`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Super Admin', 'web', '2024-03-08 08:06:14', '2024-03-08 08:06:14', 1);
INSERT INTO `roles` VALUES (2, 'Admin', 'web', '2024-03-08 08:06:18', '2024-03-08 08:06:18', 1);
INSERT INTO `roles` VALUES (3, 'Finance', 'web', '2024-03-08 08:06:27', '2024-03-08 08:06:27', 1);
INSERT INTO `roles` VALUES (4, 'Mekanik', 'web', '2024-03-08 08:06:33', '2024-03-08 08:06:33', 1);
INSERT INTO `roles` VALUES (5, 'Staff', 'web', '2024-03-08 08:06:39', '2024-03-08 08:06:39', 1);
INSERT INTO `roles` VALUES (6, 'Free Admin', 'web', '2024-03-10 09:53:02', '2024-03-10 09:53:02', 1);

-- ----------------------------
-- Table structure for saldo_customer
-- ----------------------------
DROP TABLE IF EXISTS `saldo_customer`;
CREATE TABLE `saldo_customer`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `jumlah_saldocustomer` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `saldo_customer_customer_id_foreign`(`customer_id` ASC) USING BTREE,
  INDEX `saldo_customer_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `saldo_customer_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `saldo_customer_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of saldo_customer
-- ----------------------------
INSERT INTO `saldo_customer` VALUES (8, 1, 200000, '2024-03-28 04:43:39', '2024-03-28 04:43:39', 1);

-- ----------------------------
-- Table structure for saldo_detail
-- ----------------------------
DROP TABLE IF EXISTS `saldo_detail`;
CREATE TABLE `saldo_detail`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `saldo_customer_id` bigint UNSIGNED NOT NULL,
  `penerimaan_servis_id` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `totalsaldo_detail` double NOT NULL,
  `kembaliansaldo_detail` double NOT NULL DEFAULT 0,
  `hutangsaldo_detail` double NOT NULL DEFAULT 0,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `saldo_detail_saldo_customer_id_foreign`(`saldo_customer_id` ASC) USING BTREE,
  INDEX `saldo_detail_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `saldo_detail_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `saldo_detail_saldo_customer_id_foreign` FOREIGN KEY (`saldo_customer_id`) REFERENCES `saldo_customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of saldo_detail
-- ----------------------------
INSERT INTO `saldo_detail` VALUES (19, 8, 26, '2024-03-28 04:43:39', '2024-03-28 04:43:39', 200000, 0, 0, 1);

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_satuan` tinyint(1) NOT NULL DEFAULT 1,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `satuan_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `satuan_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of satuan
-- ----------------------------
INSERT INTO `satuan` VALUES (1, 'Satuan 1', 1, 1, '2024-03-09 03:19:09', '2024-03-09 03:19:09');
INSERT INTO `satuan` VALUES (2, 'Satuan 2', 1, 1, '2024-03-09 03:19:13', '2024-03-09 03:19:13');
INSERT INTO `satuan` VALUES (3, 'Satuan 3', 1, 1, '2024-03-09 03:19:18', '2024-03-09 03:19:18');
INSERT INTO `satuan` VALUES (4, 'Satuan 4', 1, 1, '2024-03-09 03:19:28', '2024-03-09 03:19:28');

-- ----------------------------
-- Table structure for serial_barang
-- ----------------------------
DROP TABLE IF EXISTS `serial_barang`;
CREATE TABLE `serial_barang`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_serial_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_serial_barang` enum('ready','return','cancel transaction','not sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `serial_barang_barang_id_foreign`(`barang_id` ASC) USING BTREE,
  INDEX `serial_barang_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `serial_barang_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `serial_barang_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of serial_barang
-- ----------------------------
INSERT INTO `serial_barang` VALUES (1, '23978832', 'ready', 1, 1, NULL, '2024-03-09 03:25:45');
INSERT INTO `serial_barang` VALUES (2, '7897986', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (3, '68397987', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (4, '6389297', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (5, '89237397', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (6, '8632982379', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (7, '892872397', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (8, '3829798', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (9, '69832797', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (10, '83729797', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (11, '8627497', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (12, '689274987', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (13, '82698279', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (14, '8789247987', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (15, '62489789427', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (16, '72989', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (17, '642987289', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (18, '6489272897', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (19, '8729748927', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (20, '84289797', 'ready', 1, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (21, '8239723897', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (22, '689472987', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (23, '6849278', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (24, '874298798', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (25, '84928709', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (26, '89072487', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (27, '68942790', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (28, '86492987', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (29, '842970', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (30, '8429709', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (31, '84297986', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (32, '89749207', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (33, '32879879', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (34, '897240987', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (35, '897429870', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (36, '3489574', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (37, '87402987', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (38, '89472087', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (39, '89742980', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (40, '849720987', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (41, '6489277', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (42, '8492709', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (43, '89407928', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (44, '84907', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (45, '890374', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (46, '89079079', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (47, '897948752', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (48, '8907497829', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (49, '897409827', 'ready', 2, 1, NULL, NULL);
INSERT INTO `serial_barang` VALUES (50, '840798273', 'ready', 2, 1, NULL, NULL);

-- ----------------------------
-- Table structure for service_histori
-- ----------------------------
DROP TABLE IF EXISTS `service_histori`;
CREATE TABLE `service_histori`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `penerimaan_servis_id` bigint UNSIGNED NOT NULL,
  `status_histori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `service_histori_penerimaan_servis_id_foreign`(`penerimaan_servis_id` ASC) USING BTREE,
  INDEX `service_histori_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `service_histori_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `service_histori_penerimaan_servis_id_foreign` FOREIGN KEY (`penerimaan_servis_id`) REFERENCES `penerimaan_servis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of service_histori
-- ----------------------------
INSERT INTO `service_histori` VALUES (21, 26, 'antrian servis masuk', '2024-03-28 04:43:39', '2024-03-28 04:43:39', 1);
INSERT INTO `service_histori` VALUES (22, 26, 'menunggu sparepart', '2024-03-28 04:44:25', '2024-03-28 04:44:25', 1);
INSERT INTO `service_histori` VALUES (23, 26, 'proses servis', '2024-03-28 04:44:33', '2024-03-28 04:44:33', 1);
INSERT INTO `service_histori` VALUES (24, 26, 'bisa diambil', '2024-03-28 04:45:02', '2024-03-28 04:45:02', 1);

-- ----------------------------
-- Table structure for sub_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `sub_pembayaran`;
CREATE TABLE `sub_pembayaran`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_spembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_spembayaran` tinyint(1) NOT NULL DEFAULT 1,
  `kategori_pembayaran_id` bigint UNSIGNED NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sub_pembayaran_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  INDEX `sub_pembayaran_kategori_pembayaran_id_foreign`(`kategori_pembayaran_id` ASC) USING BTREE,
  CONSTRAINT `sub_pembayaran_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sub_pembayaran_kategori_pembayaran_id_foreign` FOREIGN KEY (`kategori_pembayaran_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sub_pembayaran
-- ----------------------------
INSERT INTO `sub_pembayaran` VALUES (1, 'T-Cash', 1, 1, 1, '2024-03-09 12:39:02', '2024-03-09 12:39:02');
INSERT INTO `sub_pembayaran` VALUES (2, 'Ovo', 1, 1, 1, '2024-03-09 12:39:51', '2024-03-09 12:39:51');
INSERT INTO `sub_pembayaran` VALUES (3, 'Berhutang', 1, 1, 1, '2024-03-09 12:40:13', '2024-03-09 12:40:13');
INSERT INTO `sub_pembayaran` VALUES (4, 'Bayar', 1, 1, 1, '2024-03-09 12:40:34', '2024-03-09 12:40:34');
INSERT INTO `sub_pembayaran` VALUES (5, 'U-Cash', 1, 1, 1, '2024-03-09 12:40:45', '2024-03-09 12:40:45');
INSERT INTO `sub_pembayaran` VALUES (6, 'V-Cash', 1, 1, 1, '2024-03-09 12:40:59', '2024-03-09 12:40:59');
INSERT INTO `sub_pembayaran` VALUES (7, 'Qris', 1, 1, 1, '2024-03-09 12:41:11', '2024-03-09 12:41:11');
INSERT INTO `sub_pembayaran` VALUES (8, 'Gopay', 1, 1, 1, '2024-03-09 12:41:21', '2024-03-09 12:41:21');
INSERT INTO `sub_pembayaran` VALUES (9, 'Tunai', 1, 1, 1, '2024-03-09 12:41:30', '2024-03-09 12:41:30');
INSERT INTO `sub_pembayaran` VALUES (11, 'BRI', 1, 2, 1, '2024-03-09 12:46:50', '2024-03-09 12:46:50');
INSERT INTO `sub_pembayaran` VALUES (12, 'BCA', 1, 2, 1, '2024-03-09 12:47:01', '2024-03-09 12:47:01');
INSERT INTO `sub_pembayaran` VALUES (13, 'BANK MANDIRI', 1, 2, 1, '2024-03-09 12:47:18', '2024-03-09 12:47:18');
INSERT INTO `sub_pembayaran` VALUES (14, 'BCA', 1, 3, 1, '2024-03-09 12:48:07', '2024-03-09 12:48:07');
INSERT INTO `sub_pembayaran` VALUES (15, 'BRI', 1, 3, 1, '2024-03-09 12:48:24', '2024-03-09 12:48:24');
INSERT INTO `sub_pembayaran` VALUES (16, 'BNI', 1, 3, 1, '2024-03-09 12:48:36', '2024-03-09 12:48:36');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nowa_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_supplier` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `perusahaan_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_supplier` tinyint(1) NOT NULL DEFAULT 1,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `supplier_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  CONSTRAINT `supplier_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 'Supplier 1', '8923732987', 'Deskripsi supplier 1', 'Perusahaan Supplier 1', 1, 1, '2024-03-09 03:34:46', '2024-03-09 03:34:46');
INSERT INTO `supplier` VALUES (2, 'Supplier 2', '897329871398398', 'Deskripsi supplier 2', 'Perusahaan Supplier 2', 1, 1, '2024-03-09 03:35:09', '2024-03-09 03:35:09');
INSERT INTO `supplier` VALUES (3, 'Supplier 3', '3289723987897', 'Deskripsi supplier 3', 'Perusahaan Supplier 3', 1, 1, '2024-03-09 03:35:25', '2024-03-09 03:35:25');
INSERT INTO `supplier` VALUES (4, 'Supplier 4', '832978789', 'Deskripsi supplier 4', 'Perusahaan Supplier 4', 1, 1, '2024-03-09 03:35:41', '2024-03-09 03:35:41');
INSERT INTO `supplier` VALUES (5, 'Supplier 5', '897872988979', 'Deskripsi supplier 5', 'Perusahaan Supplier 5', 1, 1, '2024-03-09 03:35:55', '2024-03-09 03:35:55');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_id` bigint UNSIGNED NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `roles_id` bigint UNSIGNED NOT NULL,
  `status_users` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username` ASC) USING BTREE,
  INDEX `users_cabang_id_foreign`(`cabang_id` ASC) USING BTREE,
  INDEX `users_roles_id_foreign`(`roles_id` ASC) USING BTREE,
  CONSTRAINT `users_cabang_id_foreign` FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_roles_id_foreign` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (8, 'user1', 'user1@gmail.com', 'user1', NULL, '$2y$10$nyDzy1iLHHeGuO/mtNqhPOLdkSfnCp5RriCdD0TFmOcflrL8BKMVa', 1, NULL, '2024-03-08 17:26:12', '2024-03-08 17:26:12', 1, 1);
INSERT INTO `users` VALUES (9, 'user2', 'user2@gmail.com', 'user2', NULL, '$2y$10$BIYwBcnZmHmBp1nZmOF3oeXKZ0IrXbtrKsMmq5Ldsg.CkiH6lg5Be', 1, NULL, '2024-03-08 17:40:00', '2024-03-08 17:40:18', 2, 1);
INSERT INTO `users` VALUES (10, 'user 3', 'user3@gmail.com', 'user3', NULL, '$2y$10$jX1U2tnPGnBOTOyUImbTGOiw2hkvz2VGf3lTiy5da22BLxIk3xYGy', 1, NULL, '2024-03-08 17:40:51', '2024-03-08 17:40:51', 3, 1);
INSERT INTO `users` VALUES (11, 'user 4', 'user4@gmail.com', 'user4', NULL, '$2y$10$xZ8SS3WnJ8EnxEWYyBXgSubcs2ZuBtK0I1.HxmSeoHqlKNF24WZLa', 1, NULL, '2024-03-08 17:41:16', '2024-03-08 17:41:28', 4, 1);
INSERT INTO `users` VALUES (12, 'admin', 'admin@gmail.com', 'admin', NULL, '$2y$10$/dBubDHKS9bSwQd0AKBwieNGm15RMOGSUC.8Rd7D8xxybQNP5kPVm', 5, NULL, '2024-03-10 09:53:02', '2024-03-10 09:53:02', 6, 1);

SET FOREIGN_KEY_CHECKS = 1;
