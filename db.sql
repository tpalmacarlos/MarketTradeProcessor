CREATE DATABASE  IF NOT EXISTS `markettradeprocessor_local` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `markettradeprocessor_local`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: markettradeprocessor_local
-- ------------------------------------------------------
-- Server version	5.5.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currencyFrom` varchar(3) NOT NULL,
  `currencyTo` varchar(3) NOT NULL,
  `count` int(11) DEFAULT '0',
  `sum` double DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `KEY` (`currencyFrom`,`currencyTo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
INSERT INTO `stats` VALUES (1,'EUR','GBP',13,2007),(7,'GBP','EUR',11,4214);
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx`
--

DROP TABLE IF EXISTS `tx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `currencyFrom` varchar(3) NOT NULL,
  `currencyTo` varchar(3) NOT NULL,
  `amountSell` double NOT NULL,
  `amountBuy` double NOT NULL,
  `rate` double NOT NULL,
  `timePlaced` datetime NOT NULL,
  `originatingCountry` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx`
--

LOCK TABLES `tx` WRITE;
/*!40000 ALTER TABLE `tx` DISABLE KEYS */;
INSERT INTO `tx` VALUES (1,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(2,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(3,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(6,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(7,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(8,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(9,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(10,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(11,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(12,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(13,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(14,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(15,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(16,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(17,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(18,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(19,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(20,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(21,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(22,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR'),(23,134256,'EUR','GBP',1000,747.1,0.7471,'2015-01-14 10:27:44','FR');
/*!40000 ALTER TABLE `tx` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER ins_tx AFTER INSERT ON tx
	FOR EACH ROW BEGIN
		DECLARE updatecount INT;

		SET updatecount = ( SELECT COUNT(id) FROM stats WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyFrom );
		IF updatecount IS NULL THEN
			INSERT INTO stats ( currencyFrom, currencyTo, count, sum ) VALUES ( NEW.currencyFrom, NEW.currencyTo, 1, NEW.amountSell );
		ELSE
			UPDATE stats SET count = count+1, sum = sum + NEW.amountSell WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyTo;
			#UPDATE stats SET count = count+1, sum = sum + NEW.amountSell WHERE currencyFrom = NEW.currencyFrom AND currencyTo = NEW.currencyFrom;
		END IF;
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-12 20:55:53
