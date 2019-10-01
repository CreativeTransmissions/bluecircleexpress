USE wordpress_test;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: vvv.test    Database: tailwind
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.18-MariaDB-1:10.3.18+maria~bionic-log

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
-- Table structure for table `wptests_tq_pro4_journey_lengths`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_journey_lengths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_journey_lengths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distance` decimal(10,2) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_journey_lengths`
--

LOCK TABLES `wptests_tq_pro4_journey_lengths` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_journey_lengths` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_journey_lengths` VALUES (1,0.00,'2019-10-01 09:43:51','2019-10-01 09:43:51');
/*!40000 ALTER TABLE `wptests_tq_pro4_journey_lengths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_rates`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL DEFAULT 1,
  `vehicle_id` int(11) NOT NULL DEFAULT 1,
  `journey_length_id` int(11) DEFAULT NULL,
  `distance` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `unit` decimal(10,2) DEFAULT NULL,
  `hour` decimal(10,2) DEFAULT NULL,
  `amount_holiday` decimal(10,2) DEFAULT NULL,
  `amount_weekend` decimal(10,2) DEFAULT NULL,
  `amount_out_of_hours` decimal(10,2) DEFAULT NULL,
  `unit_holiday` decimal(10,2) DEFAULT NULL,
  `unit_weekend` decimal(10,2) DEFAULT NULL,
  `unit_out_of_hours` decimal(10,2) DEFAULT NULL,
  `hour_holiday` decimal(10,2) DEFAULT NULL,
  `hour_weekend` decimal(10,2) DEFAULT NULL,
  `hour_out_of_hours` decimal(10,2) DEFAULT NULL,
  `amount_dispatch` decimal(10,2) DEFAULT NULL,
  `unit_dispatch` decimal(10,2) DEFAULT NULL,
  `hour_dispatch` decimal(10,2) DEFAULT NULL,
  `amount_return_to_pickup` decimal(10,2) DEFAULT NULL,
  `unit_return_to_pickup` decimal(10,2) DEFAULT NULL,
  `hour_return_to_pickup` decimal(10,2) DEFAULT NULL,
  `amount_return_to_base` decimal(10,2) DEFAULT NULL,
  `unit_return_to_base` decimal(10,2) DEFAULT NULL,
  `hour_return_to_base` decimal(10,2) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_rates`
--

LOCK TABLES `wptests_tq_pro4_rates` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_rates` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_rates` VALUES (1,1,1,1,0.00,0.00,2.35,0.00,0.00,0.00,0.00,2.35,2.35,2.35,0.00,0.00,0.00,0.00,0.65,0.00,0.00,0.00,0.00,0.00,0.00,0.00,'2019-10-01 09:43:51','2019-10-01 09:43:51');
/*!40000 ALTER TABLE `wptests_tq_pro4_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_services`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_services`
--

LOCK TABLES `wptests_tq_pro4_services` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_services` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_services` VALUES (1,'Standard','Standard rates and turnaround apply.',0.00,'0000-00-00 00:00:00','2019-10-01 09:43:51');
/*!40000 ALTER TABLE `wptests_tq_pro4_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_vehicles`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_vehicles`
--

LOCK TABLES `wptests_tq_pro4_vehicles` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_vehicles` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_vehicles` VALUES (1,'Van','Standard delivery vehicle.',0.00,'0000-00-00 00:00:00','2019-10-01 09:43:51');
/*!40000 ALTER TABLE `wptests_tq_pro4_vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-01 10:57:29
