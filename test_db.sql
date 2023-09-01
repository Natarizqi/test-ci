-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for test_db
DROP DATABASE IF EXISTS `test_db`;
CREATE DATABASE IF NOT EXISTS `test_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test_db`;

-- Dumping structure for table test_db.berita
DROP TABLE IF EXISTS `berita`;
CREATE TABLE IF NOT EXISTS `berita` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `kategori_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table test_db.kategori
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure test_db.create data
DROP PROCEDURE IF EXISTS `create data`;
DELIMITER //
CREATE PROCEDURE `create data`(
	IN `judul_berita` VARCHAR(50),
	IN `deskripsi_berita` TEXT,
	IN `kategori_id_berita` INT,
	IN `created_at_berita` DATETIME
)
BEGIN
	INSERT INTO berita (judul, deskripsi, kategori_id, created_at) VALUES (judul_berita, deskripsi_berita, kategori_id_berita, created_at_berita);
END//
DELIMITER ;

-- Dumping structure for procedure test_db.create data kategori
DROP PROCEDURE IF EXISTS `create data kategori`;
DELIMITER //
CREATE PROCEDURE `create data kategori`(
	IN `nama_kategori` VARCHAR(50),
	IN `created_at_kategori` DATETIME
)
BEGIN
	INSERT INTO kategori (nama, created_at) VALUES (nama_kategori, created_at_kategori);
END//
DELIMITER ;

-- Dumping structure for procedure test_db.delete data
DROP PROCEDURE IF EXISTS `delete data`;
DELIMITER //
CREATE PROCEDURE `delete data`(
	IN `id_berita` INT
)
BEGIN
	DELETE FROM berita WHERE id = id_berita;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.delete data kategori
DROP PROCEDURE IF EXISTS `delete data kategori`;
DELIMITER //
CREATE PROCEDURE `delete data kategori`(
	IN `id_kategori` INT
)
BEGIN
	DELETE FROM kategori WHERE id = id_kategori;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.edit data
DROP PROCEDURE IF EXISTS `edit data`;
DELIMITER //
CREATE PROCEDURE `edit data`(
	IN `id_berita` INT,
	IN `judul_berita` VARCHAR(50),
	IN `deskripsi_berita` TEXT,
	IN `kategori_id_berita` INT,
	IN `updated_at_berita` DATETIME
)
BEGIN
	UPDATE 
		berita
	SET 
		judul = judul_berita, 
		deskripsi = deskripsi_berita,
		kategori_id = kategori_id_berita,
		updated_at = updated_at_berita
	WHERE 
		id = id_berita;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.edit data kategori
DROP PROCEDURE IF EXISTS `edit data kategori`;
DELIMITER //
CREATE PROCEDURE `edit data kategori`(
	IN `id_kategori` INT,
	IN `nama_kategori` VARCHAR(50),
	IN `updated_at_kategori` DATETIME
)
BEGIN
	UPDATE 
		kategori
	SET 
		nama = nama_kategori, 
		updated_at = updated_at_kategori
	WHERE 
		id = id_kategori;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.select all data
DROP PROCEDURE IF EXISTS `select all data`;
DELIMITER //
CREATE PROCEDURE `select all data`()
BEGIN
	SELECT 
		berita.id,
		berita.judul,
		berita.deskripsi,
		berita.kategori_id,
		kategori.nama AS nama_kategori
	FROM berita
	LEFT JOIN kategori ON kategori.id = berita.kategori_id;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.select data by id
DROP PROCEDURE IF EXISTS `select data by id`;
DELIMITER //
CREATE PROCEDURE `select data by id`(
	IN `id_berita` INT
)
BEGIN
	SELECT 
		berita.id,
		berita.judul,
		berita.deskripsi,
		berita.kategori_id,
		kategori.nama AS nama_kategori
	FROM berita
	LEFT JOIN kategori ON kategori.id = berita.kategori_id
	WHERE berita.id = id_berita;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.select data kategori all
DROP PROCEDURE IF EXISTS `select data kategori all`;
DELIMITER //
CREATE PROCEDURE `select data kategori all`()
BEGIN
	SELECT * FROM kategori;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.select data kategori by id
DROP PROCEDURE IF EXISTS `select data kategori by id`;
DELIMITER //
CREATE PROCEDURE `select data kategori by id`(
	IN `id_kategori` INT
)
BEGIN
	SELECT * FROM kategori WHERE id = id_kategori;
END//
DELIMITER ;

-- Dumping structure for procedure test_db.select data kategori search nama
DROP PROCEDURE IF EXISTS `select data kategori search nama`;
DELIMITER //
CREATE PROCEDURE `select data kategori search nama`(
	IN `nama_kategori` VARCHAR(50)
)
BEGIN
	SELECT * FROM kategori WHERE nama LIKE CONCAT('%', nama_kategori , '%');
END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
