-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: vvv.test    Database: tailwind
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.20-MariaDB-1:10.3.20+maria~bionic-log

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
-- Table structure for table `wptests_tq_pro4_jobs`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_contact_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_time` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `accepted_quote_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `payment_status_id` int(11) DEFAULT NULL,
  `status_type_id` int(11) NOT NULL DEFAULT 1,
  `vehicle_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `move_size_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_jobs`
--

LOCK TABLES `wptests_tq_pro4_jobs` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_jobs` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_jobs` VALUES (16,'','2019-11-29 15:00:00','test','',14,66,1,1,1,1,1,0,'2019-11-29 14:51:56','2019-11-29 14:51:56');
/*!40000 ALTER TABLE `wptests_tq_pro4_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_journeys_locations`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_journeys_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_journeys_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journey_id` int(11) DEFAULT NULL,
  `location_status_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `journey_order` int(11) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `contact_name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_journeys_locations`
--

LOCK TABLES `wptests_tq_pro4_journeys_locations` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_journeys_locations` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_journeys_locations` VALUES (141,91,NULL,10,1,'','2019-11-29 14:50:20','2019-11-29 14:50:20','',''),(142,91,NULL,43,2,'','2019-11-29 14:50:20','2019-11-29 14:50:20','','');
/*!40000 ALTER TABLE `wptests_tq_pro4_journeys_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_journeys`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_journeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_journeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `distance` decimal(10,4) DEFAULT NULL,
  `time` decimal(10,2) DEFAULT NULL,
  `deliver_and_return` tinyint(1) DEFAULT NULL,
  `optimize_route` tinyint(1) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_journeys`
--

LOCK TABLES `wptests_tq_pro4_journeys` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_journeys` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_journeys` VALUES (91,16,49.0174,0.00,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wptests_tq_pro4_journeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_legs`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_legs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_legs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directions_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` decimal(10,4) DEFAULT NULL,
  `time` decimal(10,2) DEFAULT NULL,
  `stage_id` int(11) NOT NULL,
  `leg_order` int(11) NOT NULL,
  `leg_type_id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_legs`
--

LOCK TABLES `wptests_tq_pro4_legs` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_legs` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_legs` VALUES (120,'{\"distance\":{\"text\":\"59.6 km\",\"value\":59648},\"duration\":{\"text\":\"59 mins\",\"value\":3535},\"end_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"end_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"start_address\":\"19 S Plainfield Ave, South Plainfield, NJ 07080, USA\",\"start_location\":{\"lat\":40.5792106,\"lng\":-74.41152850000003},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}',37.0715,37.07,110,0,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(121,'{\"distance\":{\"text\":\"19.2 km\",\"value\":19221},\"duration\":{\"text\":\"36 mins\",\"value\":2148},\"end_address\":\"John F. Kennedy International Airport (JFK), Queens, NY 11430, USA\",\"end_location\":{\"lat\":40.6446301,\"lng\":-73.77736859999999},\"start_address\":\"200 Eastern Pkwy, Brooklyn, NY 11238, USA\",\"start_location\":{\"lat\":40.6709891,\"lng\":-73.96415660000002},\"traffic_speed_entry\":[],\"via_waypoint\":[],\"via_waypoints\":[]}',11.9459,11.95,110,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wptests_tq_pro4_legs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_quote_surcharges`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_quote_surcharges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_quote_surcharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `surcharge_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_quote_surcharges`
--

LOCK TABLES `wptests_tq_pro4_quote_surcharges` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_quote_surcharges` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_quote_surcharges` VALUES (84,66,1,12,'2019-11-29 14:50:20','2019-11-29 14:50:20'),(85,66,3,0,'2019-11-29 14:50:20','2019-11-29 14:50:20');
/*!40000 ALTER TABLE `wptests_tq_pro4_quote_surcharges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_quotes_stages`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_quotes_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_quotes_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) DEFAULT NULL,
  `stage_id` int(11) DEFAULT NULL,
  `journey_id` int(11) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `time_cost` decimal(10,2) DEFAULT NULL,
  `set_cost` decimal(10,2) DEFAULT NULL,
  `stage_total` decimal(10,2) DEFAULT NULL,
  `rates` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_quotes_stages`
--

LOCK TABLES `wptests_tq_pro4_quotes_stages` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_quotes_stages` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_quotes_stages` VALUES (100,66,110,91,24.10,0.00,0.00,24.10,'2','2019-11-29 14:50:20','2019-11-29 14:50:20'),(101,66,111,91,28.07,0.00,0.00,28.07,'1','2019-11-29 14:50:20','2019-11-29 14:50:20');
/*!40000 ALTER TABLE `wptests_tq_pro4_quotes_stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_quotes`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `rate_unit` decimal(10,2) DEFAULT NULL,
  `rate_hour` decimal(10,2) DEFAULT NULL,
  `rate_tax` decimal(10,2) DEFAULT NULL,
  `basic_cost` decimal(10,2) DEFAULT NULL,
  `distance_cost` decimal(10,2) DEFAULT NULL,
  `time_cost` decimal(10,2) DEFAULT NULL,
  `notice_cost` decimal(10,2) DEFAULT NULL,
  `tax_cost` decimal(10,2) DEFAULT NULL,
  `breakdown` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rates` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_quotes`
--

LOCK TABLES `wptests_tq_pro4_quotes` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_quotes` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_quotes` VALUES (66,77.00,0.00,0.00,0.00,64.17,52.17,0.00,0.00,12.83,'','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wptests_tq_pro4_quotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wptests_tq_pro4_stages`
--

DROP TABLE IF EXISTS `wptests_tq_pro4_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wptests_tq_pro4_stages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journey_id` int(11) DEFAULT NULL,
  `stage_order` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wptests_tq_pro4_stages`
--

LOCK TABLES `wptests_tq_pro4_stages` WRITE;
/*!40000 ALTER TABLE `wptests_tq_pro4_stages` DISABLE KEYS */;
INSERT INTO `wptests_tq_pro4_stages` VALUES (110,91,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(111,91,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wptests_tq_pro4_stages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-29 16:15:37
