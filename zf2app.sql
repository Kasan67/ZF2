-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.49-0ubuntu0.14.04.1 - (Ubuntu)
-- ОС Сервера:                   debian-linux-gnu
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных zf2app
CREATE DATABASE IF NOT EXISTS `zf2app` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `zf2app`;


-- Дамп структуры для таблица zf2app.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf2app.category: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `category_name`) VALUES
	(1, 'Admin'),
	(2, 'PaidCustomer'),
	(3, 'FreeCusmoter'),
	(4, 'ContentManager'),
	(30, 'FreeLance');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Дамп структуры для таблица zf2app.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `account_expired` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar_extension` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_category` (`category`),
  CONSTRAINT `FK_customer_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы zf2app.customer: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `category`, `login`, `password`, `email`, `account_expired`, `avatar_extension`) VALUES
	(5, 1, 'San', '777', 'san@gmail.com', '2016-07-26 17:14:56', '.jpeg'),
	(6, 4, 'Nik', '888', 'Nik@gmail.com', '2016-07-26 17:14:56', '.jpeg'),
	(10, 30, 'FFFFF', 'afasfs', 'san@gmail.com', '2016-07-23 00:00:00', '.jpg');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
