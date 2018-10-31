-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.29-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for demo
CREATE DATABASE IF NOT EXISTS `demo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `demo`;

-- Dumping structure for table demo.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table demo.tbl_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` (`id`, `user_role_id`, `first_name`, `last_name`, `email`, `password`) VALUES
	(1, 1, 'john', 'doe', 'john_doe@example.com', '0192023a7bbd73250516f069df18b500');
INSERT INTO `tbl_users` (`id`, `user_role_id`, `first_name`, `last_name`, `email`, `password`) VALUES
	(2, 2, 'ahsan', 'zameer', 'ahsan@example.com', '3d68b18bd9042ad3dc79643bde1ff351');
INSERT INTO `tbl_users` (`id`, `user_role_id`, `first_name`, `last_name`, `email`, `password`) VALUES
	(3, 3, 'sarah', 'khan', 'sarah@example.com', 'ec26202651ed221cf8f993668c459d46');
INSERT INTO `tbl_users` (`id`, `user_role_id`, `first_name`, `last_name`, `email`, `password`) VALUES
	(4, 4, 'salman', 'ahmed', 'salman@example.com', '97502267ac1b12468f69c14dd70196e9');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;

-- Dumping structure for table demo.tbl_user_role
CREATE TABLE IF NOT EXISTS `tbl_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table demo.tbl_user_role: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_user_role` DISABLE KEYS */;
INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
	(1, 'admin');
INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
	(2, 'editor');
INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
	(3, 'author');
INSERT INTO `tbl_user_role` (`id`, `user_role`) VALUES
	(4, 'contributor');
/*!40000 ALTER TABLE `tbl_user_role` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;



/****Set Up delivery request database****/


/***Status table creation***/
CREATE TABLE Request_status (
    `status_id` int(11) NOT NULL AUTO_INCREMENT,
    `status_name` varchar(255) DEFAULT NULL,
     PRIMARY KEY (`status_id`)
)ENGINE=INNODB;

INSERT INTO `Request_status` (`status_id`, `status_name`) VALUES
	(1, 'Pending');
INSERT INTO `Request_status` (`status_id`, `status_name`) VALUES
	(2, 'Processing');
INSERT INTO `Request_status` (`status_id`, `status_name`) VALUES
	(3, 'Delayed');
INSERT INTO `Request_status` (`status_id`, `status_name`) VALUES
	(4, 'Cancelled');
INSERT INTO `Request_status` (`status_id`, `status_name`) VALUES
  (5, 'Fulfilled');

/**Receiver table creation**/

CREATE TABLE Receiver (
    `receiver_id` int(11) NOT NULL AUTO_INCREMENT,
    `company_name` varchar(255) DEFAULT NULL,
    `first_name` varchar(255) DEFAULT NULL,
    `last_name` varchar(255) DEFAULT NULL,
    `phone` varchar(15) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `city` varchar(255) DEFAULT NULL,
    `country` varchar(255) DEFAULT NULL,
    `postalcode` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`receiver_id`)	 
)ENGINE=INNODB;



/**Employee table creation**/

-- CREATE TABLE Employee (
--     `employee_id` int(11) NOT NULL AUTO_INCREMENT,
--     `first_name` varchar(255) DEFAULT NULL,
--     `last_name` varchar(255) DEFAULT NULL,
--     `email` varchar(255) DEFAULT NULL,
--     `jobTitle` varchar(255) DEFAULT NULL,
--     `department` varchar(255) DEFAULT NULL,
--     PRIMARY KEY (`employee_id`)	 
-- )ENGINE=INNODB;



/**Delivery Request table creation**/
CREATE TABLE Request (
    `RequestID` int(11) NOT NULL AUTO_INCREMENT,
    `ReceiverID` INT(11) Not NULL,
    `RequestDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `ShipDate` date DEFAULT NULL,
    `RequestStatusID` INT(11)  NOT NULL ,
    `Comments` varchar(255),
    `RequestEmployeeID` INT(11) NOT NULL,
    PRIMARY KEY (`RequestID`), 
    FOREIGN KEY (`ReceiverID`) REFERENCES Receiver(`receiver_id`) ,
    FOREIGN KEY (`RequestStatusID`) REFERENCES Request_status(`status_id`) ,
	  FOREIGN KEY (`RequestEmployeeID`) REFERENCES tbl_users(`id`) 
)ENGINE=INNODB;


/**Product_request junction table creation**/

-- CREATE TABLE Product_Request_junction (
--     `delivery_id` int(11),
--     `product_id` INT(11),
--     `Qty` int(11) DEFAULT NULL,
--      PRIMARY KEY (`delivery_id`), 
--      FOREIGN KEY (`product_id`) REFERENCES pawtrails(`id`)
-- )ENGINE=INNODB;

create table Pawtrails_Request_junction
( 
  `id` int(11)  NOT NULL AUTO_INCREMENT,
  `request_id` int(11),
  `pawtrails_id` int(11) UNSIGNED NOT NULL,
  `Qty` int(11) DEFAULT NULL,

  PRIMARY KEY(`id`),
  FOREIGN KEY (`pawtrails_id`) REFERENCES pawtrails (`id`),
  FOREIGN KEY (`request_id`) REFERENCES Request (`RequestID`)

)ENGINE=INNODB;

