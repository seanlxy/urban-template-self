-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: thaueastlhs01-dev.hosting.xuridisa.com    Database: urban_db
-- ------------------------------------------------------
-- Server version	5.6.33-0ubuntu0.14.04.1-log

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
-- Table structure for table `accom_feature`
--

DROP TABLE IF EXISTS `accom_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accom_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` enum('A','H','D') NOT NULL DEFAULT 'H',
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accom_feature`
--

LOCK TABLES `accom_feature` WRITE;
/*!40000 ALTER TABLE `accom_feature` DISABLE KEYS */;
INSERT INTO `accom_feature` VALUES (1,'Air Conditioning','A',1),(2,'DVD Player','A',2),(3,'Sky Channels','A',3),(4,'Microwave','A',4),(5,'Toaster','A',5),(6,'Refrigerator','A',6),(7,'Stereo','A',7),(8,'Outdoor Table and Chairs','A',8),(9,'Dining Table and Chairs','A',9),(10,'1 x Queen-Sized Bed','A',19),(11,'1 x Single bed','A',18),(12,'Single Fold out Couch','A',17),(13,'Double Glazed Windows','A',16),(14,'Carpet Throughout','A',15),(15,'Electric Blankets','A',14),(16,'40\" LCD TV','A',13),(17,'Radio Alarm Clock','A',12),(18,'Electric Kettle','A',11),(19,'Wine Glasses','A',10),(20,'Complimentary tea and coffee','A',20),(21,'1 x Double Fold Out Couch','A',21),(22,'Gas Hobs','A',22),(23,'Electric fry pan','A',23),(24,'2 x Single beds','A',24),(25,'Heater','A',25),(26,'Dual temp fridge/freezer','A',26),(27,'1 x Single/Double Bunk Set','A',32),(28,'1 x Single Bunk Set','A',31),(29,'Electric heating','A',30),(30,'Coffee mugs','A',29),(31,'Medium Kitchen Storage','A',28),(32,'Small mini fridge','A',27),(33,'One parking space per cabin booked.','A',33),(34,'Mineral Pools & Swimming Pool (seasonal)','A',39),(35,'Internet lounge with comfortable couches','A',38),(36,'Communal toilets and showers','A',37),(37,'Kitchen/dining rooms (with TV)','A',36),(38,'Drive through waste dump','A',35),(39,'Fresh Water and picnic tables','A',34),(40,'The powered camp sites have electrical hook-up with either hard or grassed surface parking','A',40),(41,'Untitled','D',0),(42,'Patio & BBQ Area','A',41),(43,'Potbelly Stove','A',42),(44,'Heat Pump','A',43),(45,'3 x Single Beds','A',44),(46,'Large deck area with BBQ','A',45),(47,'Outside, private bath','A',46),(48,'Private garden area','A',47),(49,'Small kitchen area','A',48),(50,'En-suite shower room','A',49),(51,'Electric radiator','A',50),(52,'1 x Queen-Sized Double Bed','A',51),(53,'1 x King-Sized Bed','A',52),(54,'BBQ','A',53),(55,'Kitchen Area','A',54),(56,'Dishwasher','A',55),(57,'Large open plan living/kitchen area','A',56),(58,'Untitled','A',67),(59,'Leather Lounge Suite','A',66),(60,'Flat Screen TV','A',65),(61,'Free Wi-Fi','A',64),(62,'Ensuite Bathroom','A',63),(63,'Tea/Coffee making facilities','A',62),(64,'Hairdryer','A',61),(65,'Bathrobes','A',60),(66,'Iron/Ironing board','A',59),(67,'Off Street Parking','A',58),(68,'Private Patio','A',57),(69,'BBQ','A',68),(70,'test','D',69);
/*!40000 ALTER TABLE `accom_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accom_has_feature`
--

DROP TABLE IF EXISTS `accom_has_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accom_has_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) NOT NULL,
  `accom_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1731 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accom_has_feature`
--

LOCK TABLES `accom_has_feature` WRITE;
/*!40000 ALTER TABLE `accom_has_feature` DISABLE KEYS */;
INSERT INTO `accom_has_feature` VALUES (1364,1,3),(1365,5,3),(1366,9,3),(1367,16,3),(1368,12,3),(1369,21,3),(1708,1,2),(1709,3,2),(1710,4,2),(1711,5,2),(1712,32,2),(1713,53,2),(1714,54,2),(1715,68,2),(1716,67,2),(1717,66,2),(1718,65,2),(1719,64,2),(1720,63,2),(1721,61,2),(1722,60,2),(1723,59,2),(1724,1,1),(1725,4,1),(1726,16,1),(1727,20,1),(1728,32,1),(1729,31,1),(1730,61,1);
/*!40000 ALTER TABLE `accom_has_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accommodation`
--

DROP TABLE IF EXISTS `accommodation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accommodation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_price` decimal(11,2) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `page_meta_data_id` int(11) NOT NULL,
  `slideshow_id` int(11) NOT NULL,
  `beds` int(11) DEFAULT NULL,
  `sqm` int(11) DEFAULT NULL,
  `pax` int(11) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `google_map_address` varchar(255) DEFAULT NULL,
  `address` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodation`
--

LOCK TABLES `accommodation` WRITE;
/*!40000 ALTER TABLE `accommodation` DISABLE KEYS */;
INSERT INTO `accommodation` VALUES (1,185.00,16,12,15,1,2,3,'-36.7466955','174.7362914','17 Constellation Dr, Rosedale, Auckland 0632, New Zealand','17 Constellation Dr, Rosedale, Auckland'),(2,185.00,0,13,15,2,3,6,'','','','test addr'),(3,255.00,13,17,11,2,1,1,NULL,NULL,NULL,NULL),(4,200.00,0,21,0,4,32,1,NULL,NULL,NULL,NULL),(5,0.00,14,23,1,0,0,0,NULL,NULL,NULL,NULL),(6,0.00,18,32,21,0,0,0,NULL,NULL,NULL,NULL),(7,0.00,0,36,0,0,0,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `accommodation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accommodation_has_compendium_section`
--

DROP TABLE IF EXISTS `accommodation_has_compendium_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accommodation_has_compendium_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` mediumtext NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `compendium_section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accommodation_has_compendium_section`
--

LOCK TABLES `accommodation_has_compendium_section` WRITE;
/*!40000 ALTER TABLE `accommodation_has_compendium_section` DISABLE KEYS */;
INSERT INTO `accommodation_has_compendium_section` VALUES (7,'',2,1),(8,'',2,8),(9,'',2,9),(10,'',2,10),(11,'',2,11),(12,'',2,12),(13,'',1,1),(14,'',1,8),(15,'',1,9),(16,'',1,10),(17,'',1,11),(18,'',1,12),(19,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit viverra risus, et pharetra sapien malesuada ut. Nunc volutpat venenatis odio eget auctor. Proin malesuada volutpat pretium. Donec elit arcu, pellentesque et laoreet ac, mollis eu magna. Sed semper consectetur libero vitae luctus. Maecenas eu venenatis elit. Proin sit amet facilisis mauris. Duis porttitor tellus a tincidunt consequat. Phasellus sed sem blandit, consectetur lacus vitae, consectetur risus. Morbi non tortor dignissim massa dignissim mollis et et risus. Morbi quis ultricies odio.</p>\r\n\r\n<p>Etiam tincidunt, metus at congue convallis, felis ex egestas nulla, in vehicula libero mauris ut justo. Quisque commodo egestas mauris a mollis. Morbi eget velit non ipsum sollicitudin consequat vitae id risus. Mauris nunc ligula, finibus ac porta at, volutpat quis est. Praesent ante dui, placerat ut nisl et, condimentum accumsan odio. Vestibulum malesuada neque libero, eget suscipit arcu semper ac. In orci dolor, viverra et ex ac, rhoncus faucibus arcu. Quisque quis tristique lectus. Cras nec iaculis dui, id pellentesque est. Donec fringilla nibh quis urna ultricies scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris quis leo vestibulum, malesuada tortor quis, ultrices ex. Ut venenatis, lacus a semper luctus, lorem nunc fermentum dolor, quis posuere metus eros at purus.</p>',1,17);
/*!40000 ALTER TABLE `accommodation_has_compendium_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beamer_campaign`
--

DROP TABLE IF EXISTS `beamer_campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beamer_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `heading` varchar(255) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `thumb_photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `preview_note` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `terms_and_conditions` text CHARACTER SET utf8 NOT NULL,
  `beamer_phase` enum('D','P') NOT NULL DEFAULT 'D' COMMENT 'D= Draft , P=Published',
  `status` enum('A','D','H') NOT NULL DEFAULT 'H',
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_deleted` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beamer_campaign`
--

LOCK TABLES `beamer_campaign` WRITE;
/*!40000 ALTER TABLE `beamer_campaign` DISABLE KEYS */;
INSERT INTO `beamer_campaign` VALUES (6,'Another Long Weekend!','Another Long Weekend!','Another Long Weekend!','/library/pexels-photo-276700.jpg','/uploads/2018/01/img-5a713e11ae762.jpg','Another Long Weekend!','<p>Another Long Weekend!&nbsp;Another Long Weekend!&nbsp;Another Long Weekend!</p>','<p>Another Long Weekend!&nbsp;Another Long Weekend!&nbsp;Another Long Weekend!</p>','P','H','2018-01-31 03:47:48','2018-01-31 03:54:58','0000-00-00 00:00:00',3,3,0),(7,'Testing Urban Campaign','Testing Urban Campaign','Testing Urban Campaign','/library/testing-image.jpg','/uploads/2018/02/img-5a73b4a2b213a.jpg','Testing Urban Campaign','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nulla ante, vulputate vitae convallis vel, malesuada sed libero. Quisque commodo augue tortor, nec molestie sem volutpat a. Etiam metus purus, varius sit amet tempus sed, laoreet vel justo. Nunc sagittis ex at placerat ultrices. Sed sit amet nisl quis erat mattis tempor sed quis mi. Vestibulum maximus libero eget blandit laoreet. Donec vel lectus ac ipsum semper suscipit. Donec efficitur metus at nisi vulputate consectetur sed vel lectus. Phasellus eleifend enim a lectus eleifend, non semper justo auctor. Maecenas ut consectetur justo. Fusce ornare sit amet lectus ac dictum. Praesent hendrerit orci vitae tortor molestie, non sagittis ante efficitur. Pellentesque vel ante molestie, imperdiet risus et, hendrerit ex. Donec rhoncus enim sit amet sollicitudin porttitor. Sed feugiat, lacus in viverra pharetra, mauris neque blandit lacus, eu suscipit turpis massa quis sapien.</p>','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nulla ante, vulputate vitae convallis vel, malesuada sed libero. Quisque commodo augue tortor, nec molestie sem volutpat a. Etiam metus purus, varius sit amet tempus sed, laoreet vel justo. Nunc sagittis ex at placerat ultrices. Sed sit amet nisl quis erat mattis tempor sed quis mi. Vestibulum maximus libero eget blandit laoreet. Donec vel lectus ac ipsum semper suscipit. Donec efficitur metus at nisi vulputate consectetur sed vel lectus. Phasellus eleifend enim a lectus eleifend, non semper justo auctor. Maecenas ut consectetur justo. Fusce ornare sit amet lectus ac dictum. Praesent hendrerit orci vitae tortor molestie, non sagittis ante efficitur. Pellentesque vel ante molestie, imperdiet risus et, hendrerit ex. Donec rhoncus enim sit amet sollicitudin porttitor. Sed feugiat, lacus in viverra pharetra, mauris neque blandit lacus, eu suscipit turpis massa quis sapien.</p>','P','H','2018-02-01 02:13:30','2018-02-02 00:45:22','0000-00-00 00:00:00',3,3,0);
/*!40000 ALTER TABLE `beamer_campaign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beamer_campaign_has_emails`
--

DROP TABLE IF EXISTS `beamer_campaign_has_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beamer_campaign_has_emails` (
  `beamer_campaign_id` int(11) NOT NULL,
  `beamer_email_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beamer_campaign_has_emails`
--

LOCK TABLES `beamer_campaign_has_emails` WRITE;
/*!40000 ALTER TABLE `beamer_campaign_has_emails` DISABLE KEYS */;
INSERT INTO `beamer_campaign_has_emails` VALUES (6,5),(7,6),(7,5);
/*!40000 ALTER TABLE `beamer_campaign_has_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beamer_campaign_section_items`
--

DROP TABLE IF EXISTS `beamer_campaign_section_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beamer_campaign_section_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `rank` smallint(6) NOT NULL,
  `beamer_campaign_section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beamer_campaign_section_items`
--

LOCK TABLES `beamer_campaign_section_items` WRITE;
/*!40000 ALTER TABLE `beamer_campaign_section_items` DISABLE KEYS */;
INSERT INTO `beamer_campaign_section_items` VALUES (87,1,1,31),(88,2,1,32),(89,5,1,33),(92,1,1,35),(94,2,1,36),(95,3,2,36),(96,1,1,37),(97,2,2,37),(98,4,3,37),(99,2,5,35);
/*!40000 ALTER TABLE `beamer_campaign_section_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beamer_campaign_sections`
--

DROP TABLE IF EXISTS `beamer_campaign_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beamer_campaign_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) CHARACTER SET utf8 NOT NULL,
  `section_type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `rank` smallint(6) NOT NULL DEFAULT '0',
  `beamer_campaign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beamer_campaign_sections`
--

LOCK TABLES `beamer_campaign_sections` WRITE;
/*!40000 ALTER TABLE `beamer_campaign_sections` DISABLE KEYS */;
INSERT INTO `beamer_campaign_sections` VALUES (31,'Accommodation','accommodations',0,6),(32,'Blog','blogs',0,6),(33,'Pages','pages',0,6),(35,'Blog','blogs',1,7),(36,'Blog','blogs',1,7),(37,'Pages','pages',1,7);
/*!40000 ALTER TABLE `beamer_campaign_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beamer_email`
--

DROP TABLE IF EXISTS `beamer_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beamer_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `label` varchar(255) CHARACTER SET utf8 NOT NULL,
  `list_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `list_email_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` enum('A','D','H') DEFAULT 'H',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beamer_email`
--

LOCK TABLES `beamer_email` WRITE;
/*!40000 ALTER TABLE `beamer_email` DISABLE KEYS */;
INSERT INTO `beamer_email` VALUES (5,'Test List','Test List','06224f3593','us15-ea8041ee8a-54b903437d@inbound.mailchimp.com','A'),(6,'NewsLetter 2','NewsLetter 2','cef75cbd82','us15-ea8041ee8a-45837cab1c@inbound.mailchimp.com','A');
/*!40000 ALTER TABLE `beamer_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_category`
--

DROP TABLE IF EXISTS `blog_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_meta_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_category`
--

LOCK TABLES `blog_category` WRITE;
/*!40000 ALTER TABLE `blog_category` DISABLE KEYS */;
INSERT INTO `blog_category` VALUES (2,19),(3,33),(4,37);
/*!40000 ALTER TABLE `blog_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_post`
--

DROP TABLE IF EXISTS `blog_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_posted` datetime DEFAULT NULL,
  `page_meta_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_post`
--

LOCK TABLES `blog_post` WRITE;
/*!40000 ALTER TABLE `blog_post` DISABLE KEYS */;
INSERT INTO `blog_post` VALUES (2,'2017-11-16 00:00:00',20),(3,'2017-11-01 00:00:00',25),(4,'2017-12-06 00:00:00',26),(5,'2017-12-06 00:00:00',27),(6,'2017-12-06 00:00:00',28),(7,'2017-12-06 00:00:00',29),(8,'2017-12-27 00:00:00',34);
/*!40000 ALTER TABLE `blog_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_post_has_category`
--

DROP TABLE IF EXISTS `blog_post_has_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_post_has_category` (
  `category_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_post_has_category`
--

LOCK TABLES `blog_post_has_category` WRITE;
/*!40000 ALTER TABLE `blog_post_has_category` DISABLE KEYS */;
INSERT INTO `blog_post_has_category` VALUES (3,8),(2,2),(2,3);
/*!40000 ALTER TABLE `blog_post_has_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_accessgroups`
--

DROP TABLE IF EXISTS `cms_accessgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_accessgroups` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_name` varchar(100) NOT NULL,
  `access_users` char(1) NOT NULL DEFAULT 'N',
  `access_userpasswords` char(1) NOT NULL DEFAULT 'N',
  `access_useraccesslevel` char(1) NOT NULL DEFAULT 'N',
  `access_accessgroups` char(1) NOT NULL DEFAULT 'N',
  `access_cmssettings` char(1) NOT NULL DEFAULT 'N',
  `access_settings` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`access_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_accessgroups`
--

LOCK TABLES `cms_accessgroups` WRITE;
/*!40000 ALTER TABLE `cms_accessgroups` DISABLE KEYS */;
INSERT INTO `cms_accessgroups` VALUES (1,'Super Administrator','Y','Y','Y','Y','Y','Y'),(2,'General Editor','Y','Y','N','N','N','Y');
/*!40000 ALTER TABLE `cms_accessgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_blacklist_user`
--

DROP TABLE IF EXISTS `cms_blacklist_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_blacklist_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_failed_attempt_on` datetime DEFAULT NULL,
  `failed_login_attempt_count` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `disabled_on` datetime DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `recent_login_attempt_on` datetime DEFAULT NULL,
  `failed_hour_count` int(11) NOT NULL,
  `total_failed_attempt` int(11) NOT NULL,
  `is_notified` tinyint(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_blacklist_user`
--

LOCK TABLES `cms_blacklist_user` WRITE;
/*!40000 ALTER TABLE `cms_blacklist_user` DISABLE KEYS */;
INSERT INTO `cms_blacklist_user` VALUES (3,'2017-08-27 21:32:42',1,'2017-08-27 21:32:42',0,NULL,'stay@maramvineyard.com','2017-08-27 21:32:42',0,1,0,'108.162.249.193'),(7,'2018-02-08 01:24:05',1,'2018-02-08 01:24:05',0,NULL,'s','2018-02-08 01:24:05',0,1,0,'114.23.241.67');
/*!40000 ALTER TABLE `cms_blacklist_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_login_attempt`
--

DROP TABLE IF EXISTS `cms_login_attempt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_login_attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinyblob NOT NULL,
  `access_key` tinyblob,
  `is_successful` enum('N','Y') NOT NULL DEFAULT 'N',
  `ip_address` varchar(255) NOT NULL,
  `record_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_login_attempt`
--

LOCK TABLES `cms_login_attempt` WRITE;
/*!40000 ALTER TABLE `cms_login_attempt` DISABLE KEYS */;
INSERT INTO `cms_login_attempt` VALUES (1,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-07-21 16:32:05'),(2,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-07-22 08:45:25'),(3,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-11-14 12:02:00'),(4,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-12-05 13:12:05'),(5,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-12-06 09:38:02'),(6,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-12-07 08:49:19'),(7,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2016-12-08 09:43:35'),(8,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-12 23:18:58'),(9,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','I µíì\÷¸%\‘\‡Q\⁄J','N','127.0.0.1','2017-06-13 22:50:22'),(10,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-13 22:50:27'),(11,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-14 04:20:59'),(12,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-14 23:01:05'),(13,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-15 23:51:40'),(14,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-18 23:55:42'),(15,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-06-19 23:21:52'),(16,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-20 01:45:46'),(17,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-20 23:31:19'),(18,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-22 02:30:17'),(19,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','222.152.160.20','2017-06-23 03:25:18'),(20,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','222.152.160.20','2017-06-23 03:30:04'),(21,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-26 00:34:42'),(22,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-26 04:43:11'),(23,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-27 22:26:22'),(24,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','222.152.162.134','2017-06-28 10:57:51'),(25,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','222.152.162.134','2017-06-28 10:57:58'),(26,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-29 22:50:06'),(27,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-06-29 23:51:26'),(28,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-07-02 22:41:48'),(29,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-07-03 22:11:37'),(30,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-04 03:39:12'),(31,')P\\\‹@¥\‡J\€5)?h\‰«º07\…\r[^ôAf\Á∫#>∏','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','125.236.169.220','2017-08-08 22:08:29'),(32,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-09 00:20:10'),(33,')P\\\‹@¥\‡J\€5)?h\‰«º07\…\r[^ôAf\Á∫#>∏','\‘?/\€F/_∫\ﬁ\»ˇE\r¡\ﬂ\–','N','125.236.169.220','2017-08-09 00:50:50'),(34,')P\\\‹@¥\‡J\€5)?h\‰«º07\…\r[^ôAf\Á∫#>∏','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','125.236.169.220','2017-08-09 00:51:02'),(35,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','122.62.205.56','2017-08-10 01:29:38'),(36,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','122.62.205.56','2017-08-21 05:02:55'),(37,')P\\\‹@¥\‡J\€5)?h\‰«º07\…\r[^ôAf\Á∫#>∏','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','125.236.183.124','2017-08-21 09:25:30'),(38,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-21 22:31:26'),(39,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-22 02:51:29'),(40,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-23 02:10:27'),(41,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-08-23 21:46:41'),(42,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.19','2017-08-24 00:00:23'),(43,'85\⁄`wp∏b¨\’vldC¢-¸n?∑wæç4\‰t','¯hqGá\È	Ö!ıîåYç','N','108.162.249.193','2017-08-27 21:32:42'),(44,')P\\\‹@¥\‡J\€5)?h\‰«º07\…\r[^ôAf\Á∫#>∏','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','108.162.249.193','2017-08-27 21:33:32'),(45,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','198.41.238.31','2017-08-31 00:01:01'),(46,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-08-31 00:02:16'),(47,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-08-31 01:01:23'),(48,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','4{-Ω\Âµ_b«í],\ÿQ','N','198.41.238.31','2017-09-04 05:28:57'),(49,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-09-12 03:45:34'),(50,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-09-15 02:55:59'),(51,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-09-27 03:01:20'),(52,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-09-28 20:00:44'),(53,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-12 01:04:08'),(54,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-12 01:12:33'),(55,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-12 01:12:41'),(56,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-18 01:32:43'),(57,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-18 01:32:52'),(58,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-19 19:57:58'),(59,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-19 19:58:10'),(60,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-19 20:02:33'),(61,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-19 20:02:38'),(62,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-19 23:26:24'),(63,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-19 23:26:29'),(64,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-19 23:27:44'),(65,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','198.41.238.31','2017-10-19 23:29:08'),(66,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-20 01:56:06'),(67,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','198.41.238.31','2017-10-30 01:01:07'),(68,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-10-31 02:51:40'),(69,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-10-31 02:52:22'),(70,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-10-31 02:54:48'),(71,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','Ñ§ó/\‹\Z\¬N!\‹:fŸ´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','127.0.0.1','2017-10-31 22:18:49'),(72,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-01 02:53:07'),(73,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-01 02:56:12'),(74,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-01 03:05:52'),(75,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-06 05:06:56'),(76,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-06 05:07:01'),(77,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Y7£∆å\‚\Àv˘$üZÚ¨\‹\0','N','127.0.0.1','2017-11-06 05:07:06'),(78,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-06 05:07:15'),(79,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Y7£∆å\‚\Àv˘$üZÚ¨\‹\0','N','127.0.0.1','2017-11-06 05:08:31'),(80,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-06 05:08:44'),(81,'8Mëk \ÀM\Íö\„3Û\«\Ï4K\'îK\›\√kêCπ!éaùñ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-07 04:29:03'),(82,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:39:52'),(83,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:40:07'),(84,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:40:18'),(85,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:40:50'),(86,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:42:53'),(87,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:46:23'),(88,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 02:51:09'),(89,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-08 02:51:29'),(90,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 03:02:17'),(91,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 03:02:26'),(92,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','Û1≥˚>≠ë˝NÚ\‰N','N','127.0.0.1','2017-11-08 03:03:03'),(93,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-11-15 19:54:34'),(94,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-11-16 00:28:41'),(95,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-11-16 01:39:30'),(96,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-11-16 02:25:06'),(97,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-24 04:33:43'),(98,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-11-26 23:07:16'),(99,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','127.0.0.1','2017-12-05 23:07:44'),(100,'´)˚\Ó\ \Ì~\\ºÖu:ù\ ','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','114.23.241.67','2017-12-07 22:13:05'),(101,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-07 22:13:10'),(102,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-07 22:22:42'),(103,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-10 20:17:43'),(104,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-10 22:27:24'),(105,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-11 00:05:47'),(106,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-11 00:35:08'),(107,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-17 20:12:52'),(108,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-17 21:13:46'),(109,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-17 21:59:49'),(110,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-18 00:50:31'),(111,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2017-12-21 03:03:27'),(112,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-07 21:03:11'),(113,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-07 21:12:22'),(114,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-17 00:29:54'),(115,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-17 23:07:37'),(116,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-17 23:39:35'),(117,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-22 03:17:05'),(118,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-22 03:50:35'),(119,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-22 21:55:53'),(120,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-23 19:56:54'),(121,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-23 21:46:45'),(122,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-24 22:14:12'),(123,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-24 23:33:32'),(124,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-24 23:37:37'),(125,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','Û1≥˚>≠ë˝NÚ\‰N','N','114.23.241.67','2018-01-24 23:40:12'),(126,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-24 23:40:18'),(127,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','Û1≥˚>≠ë˝NÚ\‰N','N','114.23.241.67','2018-01-24 23:40:26'),(128,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','Û1≥˚>≠ë˝NÚ\‰N','N','114.23.241.67','2018-01-24 23:40:37'),(129,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 02:17:07'),(130,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 03:42:19'),(131,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','/˘¢∑&≠å§?˛å∏Xëò','N','114.23.241.67','2018-01-25 03:46:10'),(132,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 03:46:15'),(133,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 03:46:47'),(134,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 03:47:14'),(135,'Øƒ∫7\“;R\ÕD\‚\Œ!•¿≈â\"ù¨-¡Rc=N\◊JK™','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 03:47:40'),(136,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 21:38:52'),(137,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 21:44:00'),(138,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 22:09:41'),(139,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-25 22:11:14'),(140,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-26 00:59:38'),(141,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-26 01:43:33'),(142,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-26 01:47:07'),(143,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-26 01:56:13'),(144,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-30 02:16:52'),(145,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-30 20:07:04'),(146,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-31 00:42:08'),(147,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-31 03:42:01'),(148,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-31 21:01:05'),(149,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-01-31 23:54:54'),(150,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-01 01:10:29'),(151,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-01 02:09:47'),(152,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-01 03:04:06'),(153,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-01 21:44:05'),(154,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-02 00:41:53'),(155,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-02 01:30:55'),(156,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-02 01:46:08'),(157,'ºßÛ##•pë∞b!PF','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','N','114.23.241.67','2018-02-08 01:24:05'),(158,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-08 01:24:19'),(159,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-13 01:03:44'),(160,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-13 03:22:23'),(161,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-13 22:19:08'),(162,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-14 21:59:42'),(163,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-15 01:13:32'),(164,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-18 20:16:38'),(165,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-18 20:24:16'),(166,']\ŸF\÷@)\÷.\’	?ì\Ô\Õ¯∏\Ã~Ω®Dûnûì˘M≤5k','´)˚\Ó\ \Ì~\\ºÖu:ù\ ','Y','114.23.241.67','2018-02-18 22:16:30');
/*!40000 ALTER TABLE `cms_login_attempt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_settings` (
  `cmsset_id` int(11) NOT NULL AUTO_INCREMENT,
  `cmsset_name` varchar(100) NOT NULL,
  `cmsset_label` varchar(50) NOT NULL,
  `cmsset_explanation` varchar(255) NOT NULL,
  `cmsset_status` char(1) NOT NULL DEFAULT 'I',
  `cmsset_value` varchar(255) NOT NULL,
  PRIMARY KEY (`cmsset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_settings`
--

LOCK TABLES `cms_settings` WRITE;
/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` VALUES (10,'pages_maximum','Page Limit','','I','12'),(2,'pages_generations','Page Generation Limit','The number of levels of children pages that are allowed to be made.','A','5');
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for user',
  `user_fname` varchar(45) DEFAULT NULL COMMENT 'User''s firstname',
  `user_lname` varchar(45) DEFAULT NULL COMMENT 'User''s lastname',
  `user_pass` varchar(255) DEFAULT NULL COMMENT 'User''s password (recommended as being sha256)',
  `user_email` varchar(100) DEFAULT NULL COMMENT 'User''s email address',
  `user_photo_path` varchar(255) DEFAULT NULL,
  `user_thumb_path` varchar(255) DEFAULT NULL,
  `user_introduction` mediumtext,
  `social_links` mediumtext,
  `last_login_date` datetime DEFAULT NULL,
  `access_id` int(11) DEFAULT '1' COMMENT 'User''s rights - whether they are admin, banned, general user etc. This is totally customisable and is up to the programmer.',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_users`
--

LOCK TABLES `cms_users` WRITE;
/*!40000 ALTER TABLE `cms_users` DISABLE KEYS */;
INSERT INTO `cms_users` VALUES (3,NULL,NULL,'9bc129f7a46381be15f1329c4479e02c70d10d19','support@tomahawk.co.nz',NULL,NULL,NULL,NULL,'2018-02-18 22:16:30',1);
/*!40000 ALTER TABLE `cms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color_palette_hex`
--

DROP TABLE IF EXISTS `color_palette_hex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `color_palette_hex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_color` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `secondary_color` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `color1` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `color2` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `color3` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_palette_hex`
--

LOCK TABLES `color_palette_hex` WRITE;
/*!40000 ALTER TABLE `color_palette_hex` DISABLE KEYS */;
INSERT INTO `color_palette_hex` VALUES (1,'#0b1421','#45484F','#F3F3F2','#EAEBEC','#FCFCFC'),(2,'#586936','#45484F','#F3F3F2','#EAEBEC','#FCFCFC'),(3,'#370e4d','#80878D','#F3F3F2','#D5D5D5','#F4F4F4');
/*!40000 ALTER TABLE `color_palette_hex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color_palettes`
--

DROP TABLE IF EXISTS `color_palettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `color_palettes` (
  `color_palette_id` smallint(5) unsigned NOT NULL,
  `color_palette_name` varchar(100) NOT NULL,
  `color_palette_path` varchar(255) NOT NULL,
  `color_palette_cms_preview_thumb_path` varchar(255) NOT NULL,
  `color_palette_ref` varchar(100) NOT NULL,
  PRIMARY KEY (`color_palette_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_palettes`
--

LOCK TABLES `color_palettes` WRITE;
/*!40000 ALTER TABLE `color_palettes` DISABLE KEYS */;
INSERT INTO `color_palettes` VALUES (1,'palette1','/themes/palette1/assets/css/main.css','/images/color-palette-previews/palette4.jpg','palette1'),(2,'palette2','/themes/palette2/assets/css/main.css','/images/color-palette-previews/palette5.jpg','palette2'),(3,'palette3','/themes/palette3/assets/css/main.css','/images/color-palette-previews/palette6.jpg','palette3');
/*!40000 ALTER TABLE `color_palettes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compendium_section`
--

DROP TABLE IF EXISTS `compendium_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compendium_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `status` enum('A','H','D') NOT NULL DEFAULT 'H',
  `rank` int(11) NOT NULL,
  `is_generic` enum('0','1') NOT NULL DEFAULT '0',
  `has_dark_bg` enum('0','1') NOT NULL DEFAULT '0',
  `is_map` enum('0','1') NOT NULL DEFAULT '0',
  `default_content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compendium_section`
--

LOCK TABLES `compendium_section` WRITE;
/*!40000 ALTER TABLE `compendium_section` DISABLE KEYS */;
INSERT INTO `compendium_section` VALUES (1,'fa fa-info-circle','Welcome','A',1,'1','1','','<p>Flag: Generic</p>\r\n\r\n<p>- Welcome -</p>'),(2,'fa fa-clock-o','Arrival Information','A',2,'','1','','<p>Flag: Accommodation</p>\r\n\r\n<p>- Arrival Information -</p>'),(3,'fa fa-check','Departure Checklist','A',3,'','1','',''),(4,'fa fa-home','House Information','A',4,'','0','0',''),(8,'fa fa-ship','About Waiheke','A',6,'1','','','<p><strong>About Waiheke </strong></p>\r\n\r\n<p>Waiheke Island is known internationally as one of the most beautiful islands in the world. Just 35 minutes from downtown Auckland, Waiheke is often referred to as the Jewel in the Hauraki Gulf, and is an island of unique landscapes from beaches to rolling vineyards, diverse people from around the world, and an ever expanding selection of great wine and good food.&nbsp;</p>\r\n\r\n<p><strong>Beaches</strong><br />\r\nThere are five glorious white sand beaches on the north side of the island to choose from &ndash; Oneroa, Little Oneroa, Sandy Bay, Palm Beach and Onetangi Beach.&nbsp;</p>\r\n\r\n<p>The southern side beaches include Surfdale, Blackpool and Rocky Bay, and the Eastern side of the island is the shell covered beach at Whakanewha Regional Park &ndash; the perfect spot for a kayak and also where the camping ground is located.</p>\r\n\r\n<p>Man O&rsquo;War Bay at the &ldquo;bottom end&rdquo; is also well worth a visit (if you have a car) for some wine tasting at the renowned Man O&rsquo; War Vineyards tasting room right on the beach.</p>\r\n\r\n<p><strong>Geography</strong><br />\r\nThe island is 19.3 km long from west to east and varies in width from half a kilomter to 10 kilometers, and has a surface area of 92 km&sup2;. The coastline is 133.5 km, including 40 km of beaches. It is very hilly with few flat areas, the highest point being Maunganui at 231 metres. The climate is slightly warmer than Auckland with less humidity and rain and more sunshine hours.</p>\r\n\r\n<p>Townships<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Oneroa<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Surfdale<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Onetangi<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Rocky Bay</p>\r\n\r\n<p><strong>History</strong><br />\r\nVisit the Stony Batter WWII fortifications, which were built to keep the Japanese forces out. Open to the public they offer both an insight to the extent of defence preparations and wonderful views of the southern end of the Hauraki Gulf. Waiheke was discovered and settled by Maori approximately 1000 years ago and many signs of Maori occupation on Waiheke Island still exist today. Archaeological sites are scattered over the island including more than forty pa sites, cooking pits and terraced areas.</p>\r\n\r\n<p><strong>Viticulture</strong><br />\r\nWinegrowers have successfully matched the unique maritime climate and ancient soil structures to the selection of classical grape varieties in order to produce red and white wines with distinctive varietal character. There are over 20 wineries on the island, and during the summer months most have their cellar doors open to the public. You can visit most wineries via an organised tour, self-drive tour or hop on a many of the local buses.</p>\r\n\r\n<p><strong>Walks or Hiking</strong><br />\r\nOver 8 marked walks ranging in difficulty cross Waiheke with routes suitable for the very fit as well as easier routes for those just out for a stroll. Walkway maps can be found at the i-Site information center in Oneroa.</p>\r\n\r\n<p><strong>Birdlife on the island</strong><br />\r\nThere is a successful dotterel breeding programme, oystercatchers (torea-pango), white-faced heron (matukumoana), pied stilts (poaka), Caspian terns (Taranui), paradise ducks (putangitangi) are all found around the island Godwits (kuaka) are also sometimes spotted on the tidal flats while on the south side of the island where a large wetland is home to bittern (matuku), banded rail (mohopereru) and spotless crake (puweto).</p>\r\n\r\n<p><strong>Native bush</strong><br />\r\nWaiheke Island carefully guards it&rsquo;s status as a possum free island. The absence of these pests means forests and wildlife are allowed to thrive.</p>\r\n\r\n<p><strong>Visiting New Zealand</strong><br />\r\nIf it&rsquo;s your first time in New Zealand be sure to check out the 100% Pure New Zealand page for facts about travelling in New Zealand.</p>'),(9,'fa fa-list','Waiheke Services','A',7,'1','','','<p><strong>Waiheke Services </strong></p>\r\n\r\n<p><strong>Art galleries</strong></p>\r\n\r\n<p>Waiheke Community Art Gallery<br />\r\n2 Korora Road, Oneroa<br />\r\n93729907</p>\r\n\r\n<p>Toi Gallery<br />\r\n145 Ocean View Road, Oneroa<br />\r\n027 7732975</p>\r\n\r\n<p>Red Shed<br />\r\nMiro Road, Palm Beach<br />\r\n09 3729367</p>\r\n\r\n<p>Banks/ATMs</p>\r\n\r\n<p>ANZ<br />\r\n112 Ocean View Road, Oneroa</p>\r\n\r\n<p>ASB<br />\r\n120 Ocean View Road, Oneroa</p>\r\n\r\n<p>BNZ<br />\r\nOcean View Road, Oneroa</p>\r\n\r\n<p>Kiwibank<br />\r\nOcean View Road, Oneroa</p>\r\n\r\n<p>BBQs (public)</p>\r\n\r\n<p>There are free public BBQs located at beaches around the island.<br />\r\nLittle Oneroa, Palm Beach, Onetangi, Man O War Bay, Whakanewha Regional Park</p>\r\n\r\n<p>Cinema/Theatre</p>\r\n\r\n<p>Artworks Community Theatre<br />\r\n127 Ocean View Road, Oneroa<br />\r\n09 3722941</p>\r\n\r\n<p>Waiheke Island Cinema<br />\r\n2 Korora Road, Oneroa<br />\r\n09 3724240</p>\r\n\r\n<p>Dentists</p>\r\n\r\n<p>Oneroa Dental Surgery<br />\r\n9/118 Ocean View Road, Oneroa<br />\r\n09 3726849</p>\r\n\r\n<p>Waiheke Dental Centre<br />\r\n2 Putiki Road, Ostend<br />\r\n09 3727422</p>\r\n\r\n<p>DIY/Garden Centre</p>\r\n\r\n<p>Placemakers<br />\r\n102 Ostend Road, Ostend<br />\r\n09 3720060</p>\r\n\r\n<p>Dry cleaning</p>\r\n\r\n<p>Sparkle<br />\r\nBelgium Street, Ostend<br />\r\n09 3728969</p>\r\n\r\n<p>DVD hire</p>\r\n\r\n<p>Video Ezy<br />\r\nOcean View Road, Oneroa<br />\r\n09 3728192</p>\r\n\r\n<p>Emergency services</p>\r\n\r\n<p>Police/Fire/Ambulance<br />\r\n111</p>\r\n\r\n<p>Waiheke Police Station<br />\r\n104 Ocean View Road<br />\r\n09 3721150</p>\r\n\r\n<p>Facsimile service</p>\r\n\r\n<p>Take Note<br />\r\nOcean View Road, Oneroa<br />\r\n09 3727174</p>\r\n\r\n<p>Ferries</p>\r\n\r\n<p>Fullers<br />\r\nMatiatia Ferry Terminal, Ocean View Road, Oneroa<br />\r\n09 3679111</p>\r\n\r\n<p>Sealink<br />\r\nKennedy Point Terminal,Donald Bruce Rd,Surfdale<br />\r\n09 3005900</p>\r\n\r\n<p>Library</p>\r\n\r\n<p>Auckland City Libraries, Waiheke<br />\r\n2 Korora Road, Oneroa<br />\r\n09 3741325</p>\r\n\r\n<p>Market</p>\r\n\r\n<p>Ostend arts, craft and food market is held every Saturday morning 8am 12.30pm</p>\r\n\r\n<p>War Memorial Hall and grounds, Belgium Street, Ostend</p>\r\n\r\n<p>Medical Centres</p>\r\n\r\n<p>Oneroa Accident and Medical Centre<br />\r\n132 Ocean View Road, Oneroa<br />\r\n09 3728756</p>\r\n\r\n<p>Ostend Medical Centre<br />\r\n9 Belgium Street, Ostend<br />\r\n09 3725005</p>'),(10,'fa fa-star','Complimentary Booking Service','A',8,'1','','','<p><strong>Stay Waiheke Complimentary Booking Service</strong></p>\r\n\r\n<p>Stay Waiheke is pleased to be able to offer a complimentary booking service for a wide range of activities and services on offer including;</p>\r\n\r\n<p>√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Beauty services<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Car/scooter/bike rental<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Catering<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Heli-tours<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Mobile massage services<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Nanny service/ baby equipment hire<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Sightseeing tours<br />\r\n√¢‚Äî¬è&nbsp;&nbsp; &nbsp;Wine-tasting</p>\r\n\r\n<p>For more information about the activities and services we can organise on your behalf please check out our website <a href=\"http://www.staywaiheke.com\">www.staywaiheke.com</a> or give us a call 09 3725402 or 021 563 271.</p>'),(11,'fa fa-file-text-o','Terms & Conditions','A',9,'1','','','<p><strong>Terms &amp; Conditions </strong></p>\r\n\r\n<p><strong>Booking Terms:</strong></p>\r\n\r\n<p>Check-In<br />\r\n1.&nbsp;&nbsp; &nbsp;Check in time is from 2pm. There is no guaranteed check in before 2pm.</p>\r\n\r\n<p>Check-Out<br />\r\n1.&nbsp;&nbsp; &nbsp;Check out time is 10.30 or by prior arrangement. &nbsp;The property must be completely vacated by check out time. Failure to comply will incur surcharge.</p>\r\n\r\n<p>Occupancy<br />\r\n1.&nbsp;&nbsp; &nbsp;All properties are let on the understanding that the accommodation is for holiday use only, for the period specified and that no right to remain in the accommodation exists for the applicants or anyone in the applicant&rsquo;s party beyond the specified date and time.<br />\r\n2.&nbsp;&nbsp; &nbsp;At no time during the period of permitted use may the property be occupied overnight by more than the number of people specified on the booking form.(including children &amp; infants)<br />\r\n3.&nbsp;&nbsp; &nbsp;Guests must not sub-let the property nor use it for the purposes other than a holiday house.<br />\r\n4.&nbsp;&nbsp; &nbsp;No caravans, tents or other accommodation will be placed at the property without written permission.</p>\r\n\r\n<p>Pets<br />\r\n1.&nbsp;&nbsp; &nbsp;The guest agrees not to allow any animals on the property without the written consent of &ldquo;STAY Waiheke&rdquo;.<br />\r\n2.&nbsp;&nbsp; &nbsp;a) When animals are allowed on the property, the guest agrees that pets are not to be left unattended inside or outside the property at any time, guests will remove all pet waste from the property and be fully responsible for any damage caused by the pet.</p>\r\n\r\n<p>No Smoking Policy<br />\r\n1.&nbsp;&nbsp; &nbsp;If smoking is allowed on the property, the guest agrees not to smoke inside the property. A breach of this policy will result in a NZ$500 cleaning fee. If smoking outdoors all cigarette butts must be disposed of.<br />\r\nUse of the Telephone<br />\r\n1.&nbsp;&nbsp; &nbsp;Where a telephone is available, the guest will ensure any calls made are &lsquo;collect&rsquo; or &lsquo;price required&rsquo; for anything outside the local calling area. Any costs incurred will be on charged to the guest.</p>\r\n\r\n<p>Linen<br />\r\n1.&nbsp;&nbsp; &nbsp;Where linen is provided by &lsquo;STAY Waiheke&rsquo; this includes bed sheets, pillow cases, bath towels and face cloths per person, hand towels, tea towels and bath mats. Beach or Spa towels are not provided unless stated on the web page for the property.&nbsp;<br />\r\n2.&nbsp;&nbsp; &nbsp;Some property owners store their own linen in the house. This linen is not intended for guest use. An additional charge is applicable if the guests use owner&rsquo;s linen.</p>\r\n\r\n<p>Quiet Enjoyment and Parties<br />\r\n1.&nbsp;&nbsp; &nbsp;The guest agrees to respect the rights of neighbors in regard to noise. &nbsp;Loud music is not permitted after 11pm. &nbsp;Local council noise regulations apply. &nbsp;Absolutely no house parties or &nbsp;weddings or post wedding BBQ&rsquo;s are allowed at the property without advance permission in writing.<br />\r\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Children<br />\r\n1.&nbsp;&nbsp; &nbsp;The guests accept full responsibility for checking with &ldquo;STAY Waiheke&rdquo; as to whether or not the property is, to the best knowledge of &ldquo;STAY Waiheke&rdquo;, safe for children.</p>\r\n\r\n<p>Property Maintenance<br />\r\n1.&nbsp;&nbsp; &nbsp;Although every effort is made to maintain properties in good order, wear &amp; tear on rental property is unavoidable. &nbsp;Please notify &lsquo;STAY Waiheke&rsquo; as soon as possible if a problem relating to the property exists. Every effort will be made to rectify any problem that exists in a timely manner. &nbsp;Repairs will be made as soon as possible after notification.<br />\r\n2.&nbsp;&nbsp; &nbsp;The Guest is responsible for the safe-keeping of the owner&rsquo;s property and content during the period booked. Neither the owner nor &lsquo;STAY Waiheke&rsquo; is responsible for any stolen or lost items. Be safe and lock doors and windows when you are away and at night as you would at home. &nbsp;Any breakage or damage to content or structure of the building must be reported promptly to &lsquo;STAY Waiheke&rsquo; and the owner will be entitled to recover from the guest the cost of any repair or replacement needed due to guests act or default.<br />\r\n3.&nbsp;&nbsp; &nbsp;The Renter promises that it will:<br />\r\n4.&nbsp;&nbsp; &nbsp; Keep in a clean, liveable condition and in good repair (subject to Reasonable Wear and Tear):<br />\r\n5.&nbsp;&nbsp; &nbsp;(i) The interior of the Accommodation;<br />\r\n6.&nbsp;&nbsp; &nbsp;(ii) The carpets, curtains and all other items of the&nbsp;<br />\r\n7.&nbsp;&nbsp; &nbsp;Accommodation; an<br />\r\n8.&nbsp;&nbsp; &nbsp;(iii) All √Ø¬¨¬Åxtures and √Ø¬¨¬Åttings of the accommodation, including outdoor furniture, kyaks, boats .<br />\r\n9.&nbsp;&nbsp; &nbsp;Clean and keep free from blockages and obstructions all ;baths, sinks, lavatories, cisterns, drains, gutters, pipes, chimneys and the like;<br />\r\n10.&nbsp;&nbsp; &nbsp;16.1 &nbsp;Keep clean the insides of all windows and replace any glass or mirrors which break for any reason.<br />\r\n11.&nbsp;&nbsp; &nbsp;Not damage, change or remove any of the Owner/Property Manager&rsquo;s installations, furniture, √Ø¬¨¬Åxtures and √Ø¬¨¬Åttings;<br />\r\n12.&nbsp;&nbsp; &nbsp;BOND/ SECURITY DEPOSIT: The guest authorises &lsquo;STAY Waiheke&rsquo; to obtain an authorization for the security deposit on his/her credit card and to debit his /her credit card for costs incurred for damage, breakage or cleaning. Where a credit card is not available, the guest agrees to pay a security deposit at the time of final payment if requested to do so.The guest agrees that the liability is not limited to this amount. In the event that there is a problem with the credit card being debited the Renter agrees to immediately pay the amount owing to the Owner/Property Manager in cash, bank cheque or by electronic funds transfer of cleared funds to an account speci√Ø¬¨¬Åed by the Owner/Property Manager.<br />\r\n13.&nbsp;&nbsp; &nbsp;Some Owners/Property Managers require payment of a cash bond in addition to or instead of credit card bond. Typically the cash bond is $500 - $1,500 depending on the nature of the Accommodation, is paid into the Owner/Property Manager&rsquo;s nominated bank account prior to check in and is repaid within 7 working days of the completion of the Holiday Tenancy or upon the √Ø¬¨¬Ånal resolution of a dispute.<br />\r\n14.&nbsp;&nbsp; &nbsp;The property must be left in a clean and tidy state and all furniture returned to the place in which it was found on arrival. &nbsp;Guests are fully responsible for cleaning all crockery, cutlery, general utensils, Oven and BBQ, and disposing of their rubbish in the prescribed way. If they are left dirty you may be charged an min but not limited to excess clean charge of $50. All doors and windows are to be closed and locked before check-out.&nbsp;<br />\r\n15.&nbsp;&nbsp; &nbsp;Neither the owner nor &lsquo;STAY Waiheke&rsquo; shall be liable for any loss or damage to property however caused during your stay.<br />\r\n16.&nbsp;&nbsp; &nbsp;Whenever the Accommodation is left unattended, the Renter will fasten all locks to all doors and windows and activate any burglar alarm, to prevent unauthorised access to the Accommodation. A call out due to lost keys or lockout will attract a non-negotiable minimum fee of $100 plus GST to be deducted from the Renter&rsquo;s credit card. The Renter will not change or install any locks on any doors or windows nor have additional keys made&nbsp;<br />\r\n17.&nbsp;&nbsp; &nbsp;for any locks without the prior written consent of the Owner/Property Manager.</p>\r\n\r\n<p>Booking and Reservation Policy<br />\r\n1.&nbsp;&nbsp; &nbsp;The guest agrees that &lsquo;STAY Waiheke&rsquo; is the booking agent only and any dispute regarding the availability, the standard of the property or chattels will be solely between the guest and the owner of the property. The guest agrees that &lsquo;STAY Waiheke&rsquo; may give the guests contact details to the owner of the property if they request so.<br />\r\n2.&nbsp;&nbsp; &nbsp;No property shall be considered booked until &lsquo;STAY Waiheke&rsquo; has confirmed the booking in writing.<br />\r\n3.&nbsp;&nbsp; &nbsp;A 50% deposit of the total accommodation charge is payable within 48 hours of booking with the balance payable 14 days prior to the date of arrival. &nbsp;If booking falls between 15 December and 15 January, balance of payment is due 21 days prior to the date of arrival. &nbsp;The guests authorise STAY Waiheke to charge full payment due 10 days prior to arrival if no payment is made prior.<br />\r\n4.&nbsp;&nbsp; &nbsp;Some Owner/Property Managers require the Renter to agree to further terms and conditions speci√Ø¬¨¬Åc to its accommodation at the time of booking. If the Renter does not wish to be bound by an Owner/Property Manager&rsquo;s additional terms and conditions for any reason, then the Renter can cancel the booking and STAY Waiheke will refund the Renter in full subject to STAY Waiheke receiving notice in writing from the Renter within 5 working days&nbsp;<br />\r\n5.&nbsp;&nbsp; &nbsp;of the completion of the online booking process.<br />\r\n6.&nbsp;&nbsp; &nbsp;Dishonored payments of balances not received 7 days before the start of the let will result in the booking being canceled and deposit forfeited.</p>\r\n\r\n<p>Cancellation Policy<br />\r\n1.&nbsp;&nbsp; &nbsp;Cancellation of a booking by the guests will incur a $50 administration charge. In addition:<br />\r\na.&nbsp;&nbsp; &nbsp;Within 60 days of arrival:50% of the total accommodation costs unless the property can be rebooked.<br />\r\nb.&nbsp;&nbsp; &nbsp;Within 30 days of arrival: 100% of the total accommodation costs unless the property can be rebooked.<br />\r\nc.&nbsp;&nbsp; &nbsp;All booking canceled within 14 days of arrival or non-arrivals:100% of all booking costs.<br />\r\nd.&nbsp;&nbsp; &nbsp;No refunds are given for early departure.<br />\r\n2.&nbsp;&nbsp; &nbsp;The Guest agrees that, should the property become unavailable or un-live able for any reason (the reason to be verified by &lsquo;STAY Waiheke&rsquo; as being justified), then STAY Waiheke&rsquo; will use their best endeavors to find a satisfactory alternative. Should a replacement property not be available all monies paid by the guest to &lsquo;STAY Waiheke will be refunded in full. The guest agrees that the owner and &lsquo;STAY Waiheke&rsquo; liability is limited to the refunding of such monies.<br />\r\n3.&nbsp;&nbsp; &nbsp;&lsquo;STAY Waiheke&rsquo; reserves the right to cancel reservation at any time, in which event the deposit shall be refunded in full.<br />\r\nPrinciple<br />\r\n1.&nbsp;&nbsp; &nbsp;The guest agrees, that should all of these conditions not be adhered to, the owners or their agents will have the right to immediately terminate this contract and the guest and all other persons will vacate the property immediately if requested to do so by the owners or the owners&rsquo; agent. In this event, the guest agrees that no refund will be due or paid for any unused accommodation nights.<br />\r\n2.&nbsp;&nbsp; &nbsp;The Guest agrees that by making a booking, they indicate to accept the booking conditions as set out above.</p>\r\n\r\n<p>INSURANCE AND NO LIABILITY<br />\r\nThe Renter will not do anything that could adversely affect the Owner/Property Manager&rsquo;s insurance over the Accommodation.<br />\r\n1.&nbsp;&nbsp; &nbsp;The personal effects of the Renter will not be insured by the Owner/Property Manager. The Renter acknowledges that all personal items and vehicles (including vehicle contents) of the Renter remain the Renter&rsquo;s responsibility and the Owner/Property Manager accepts no responsibility for loss or damage.<br />\r\n2.&nbsp;&nbsp; &nbsp;In the event that the Renter uses extra facilities at the Accommodation including, but not limited to, kayaks, dinghies, bicycles, trampolines, spas and swimming pools, such use is entirely at the Renter&rsquo;s own risk at all times and the Owner/Property Manager accepts no responsibility for any injury or loss to the Renter. Children are to be supervised at all times by a parent or responsible adult.</p>'),(12,'fa fa-map-marker','Location Map','A',5,'','','1',''),(17,'fa fa-car','Testing Compendium Section 01','A',10,'','1','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit viverra risus, et pharetra sapien malesuada ut. Nunc volutpat venenatis odio eget auctor. Proin malesuada volutpat pretium. Donec elit arcu, pellentesque et laoreet ac, mollis eu magna. Sed semper consectetur libero vitae luctus. Maecenas eu venenatis elit. Proin sit amet facilisis mauris. Duis porttitor tellus a tincidunt consequat. Phasellus sed sem blandit, consectetur lacus vitae, consectetur risus. Morbi non tortor dignissim massa dignissim mollis et et risus. Morbi quis ultricies odio.</p>\r\n\r\n<p>Etiam tincidunt, metus at congue convallis, felis ex egestas nulla, in vehicula libero mauris ut justo. Quisque commodo egestas mauris a mollis. Morbi eget velit non ipsum sollicitudin consequat vitae id risus. Mauris nunc ligula, finibus ac porta at, volutpat quis est. Praesent ante dui, placerat ut nisl et, condimentum accumsan odio. Vestibulum malesuada neque libero, eget suscipit arcu semper ac. In orci dolor, viverra et ex ac, rhoncus faucibus arcu. Quisque quis tristique lectus. Cras nec iaculis dui, id pellentesque est. Donec fringilla nibh quis urna ultricies scelerisque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris quis leo vestibulum, malesuada tortor quis, ultrices ex. Ut venenatis, lacus a semper luctus, lorem nunc fermentum dolor, quis posuere metus eros at purus.</p>');
/*!40000 ALTER TABLE `compendium_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_column`
--

DROP TABLE IF EXISTS `content_column`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_column` (
  `content` mediumtext NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `span` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `content_row_id` int(11) NOT NULL,
  KEY `content_row_id` (`content_row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_column`
--

LOCK TABLES `content_column` WRITE;
/*!40000 ALTER TABLE `content_column` DISABLE KEYS */;
INSERT INTO `content_column` VALUES ('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam euismod eleifend nibh id mollis. Sed placerat bibendum faucibus. Sed eu pharetra risus. Vestibulum quis enim quis odio congue iaculis eget sed lacus. Etiam fermentum ullamcorper elit eget porttitor.&nbsp;</p>','col-xs-12',0,1,188),('<p>Urban Boutique Hotel</p>\r\n\r\n<p>1 Harbour View Road<br />\r\nSt Kilda<br />\r\nMelbourne<br />\r\nAustralia</p>\r\n\r\n<p>Phone: +61 234 5678<br />\r\nEmail: stay@urbanboutiquehotel.com</p>','col-xs-12',0,1,209),('<p><img alt=\"\" src=\"/library/apartment-1851201_1920.jpg\" />test</p>','col-xs-12',0,1,239),('<p><img alt=\"\" src=\"/library/apartment-1851201_1920.jpg\" /></p>','col-xs-12',0,1,281),('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam euismod eleifend nibh id mollis. Sed placerat bibendum faucibus. Sed eu pharetra risus. Vestibulum quis enim quis odio congue iaculis eget sed lacus. Etiam fermentum ullamcorper elit eget porttitor.</p>','col-xs-12',0,1,298),('<h1 style=\"text-align: center;\">Meet your Hosts</h1>','col-xs-12',0,1,299),('<p><img alt=\"\" src=\"/library/pexels-photo.jpg\" style=\"width: 750px; height: 500px;\" /></p>','col-xs-12',0,1,300),('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam euismod eleifend nibh id mollis. Sed placerat bibendum faucibus. Sed eu pharetra risus. Vestibulum quis enim quis odio congue iaculis eget sed lacus. Etiam fermentum ullamcorper elit eget porttitor.&nbsp;</p>','col-xs-12',0,1,313),('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam euismod eleifend nibh id mollis. Sed placerat bibendum faucibus. Sed eu pharetra risus. Vestibulum quis enim quis odio congue iaculis eget sed lacus. Etiam fermentum ullamcorper elit eget porttitor.&nbsp;</p>','col-xs-12',0,1,315),('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam euismod eleifend nibh id mollis. Sed placerat bibendum faucibus. Sed eu pharetra risus. Vestibulum quis enim quis odio congue iaculis eget sed lacus. Etiam fermentum ullamcorper elit eget porttitor.&nbsp;</p>','col-xs-12',0,1,326),('<p><a href=\"/library/new-microsoft-word-document.pdf\">Column 1</a></p>','col-xs-12',0,1,327);
/*!40000 ALTER TABLE `content_column` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_row`
--

DROP TABLE IF EXISTS `content_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` int(11) NOT NULL,
  `page_meta_data_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_meta_data_id` (`page_meta_data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_row`
--

LOCK TABLES `content_row` WRITE;
/*!40000 ALTER TABLE `content_row` DISABLE KEYS */;
INSERT INTO `content_row` VALUES (128,1,17),(129,2,17),(187,1,22),(188,2,22),(208,1,8),(209,2,8),(239,1,31),(281,1,35),(295,1,5),(296,2,5),(297,3,5),(298,4,5),(299,5,5),(300,6,5),(312,2,2),(313,2,2),(314,1,4),(315,2,4),(325,2,1),(326,2,1),(327,3,1);
/*!40000 ALTER TABLE `content_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `contact_number` varchar(100) DEFAULT NULL,
  `comments` mediumtext,
  `status` enum('A','H','D') NOT NULL DEFAULT 'H',
  `date_of_enquiry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiry`
--

LOCK TABLES `enquiry` WRITE;
/*!40000 ALTER TABLE `enquiry` DISABLE KEYS */;
INSERT INTO `enquiry` VALUES (9,'asd','asd','asd@qq.com','sad','123213','A','2018-01-07 21:02:58','114.23.241.67'),(8,'chelsea','rATIMA','CHELSEA@TOMAHAWK.CO.NZ','02102400442','HI','D','2017-12-17 22:02:16','114.23.241.67'),(7,'chelsea','ratima','chelsea@tomahawk.co.nz','02102400442','kdsflf','D','2017-12-17 20:00:44','114.23.241.67');
/*!40000 ALTER TABLE `enquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public_token` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `success_message` text,
  `mailchimp_list_id` varchar(255) NOT NULL,
  `terms_and_conditions` text,
  `xml_data` longtext,
  `json_data` text CHARACTER SET utf8 NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  `status` enum('A','H','D') NOT NULL DEFAULT 'H',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (3,'e75e1fe2fa','Form 1','Aenean non imperdiet erat, at iaculis tellus','Proin eget accumsan odio, nec consequat eros. Quisque ultrices hendrerit dui. Pellentesque sed mi at augue accumsan mattis. Curabitur ac neque ligula. Duis consectetur lorem a lorem tincidunt pharetra. Etiam a pretium augue, dignissim volutpat justo. Phasellus vel scelerisque odio, et eleifend massa.','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ornare interdum mauris, id cursus leo cursus eget. Morbi elementum ipsum at lectus suscipit sagittis. Donec aliquam eu metus a maximus. Donec euismod vel justo quis iaculis. Phasellus a pharetra sem. Curabitur blandit mollis dolor nec egestas. Ut ac urna ac nunc consequat commodo nec eu urna. Ut faucibus velit nec orci feugiat, in pharetra ipsum tempor. Vivamus eget venenatis diam. Sed ullamcorper sapien sit amet consequat convallis. Cras lacus lorem, posuere id nisl sed, molestie facilisis odio.</p>\r\n\r\n<p>Proin eget accumsan odio, nec consequat eros. Quisque ultrices hendrerit dui. Pellentesque sed mi at augue accumsan mattis. Curabitur ac neque ligula. Duis consectetur lorem a lorem tincidunt pharetra. Etiam a pretium augue, dignissim volutpat justo. Phasellus vel scelerisque odio, et eleifend massa.</p>\r\n\r\n<p>Etiam ac purus porta erat euismod volutpat. Etiam fringilla sem in mi lobortis mollis. Vivamus mi augue, tristique at tempus eu, facilisis eleifend odio. Vestibulum aliquet, nunc id dapibus auctor, enim neque imperdiet magna, ac mollis justo odio id enim. Vivamus nec dolor lobortis, lacinia massa ut, blandit lorem. Ut nec tristique lectus. Vivamus eget maximus justo, sed interdum lectus. Vestibulum faucibus felis nec ipsum rutrum malesuada. Nullam a lectus at lorem mattis pharetra. Maecenas blandit finibus mauris, sed pretium augue eleifend sed. Fusce tempus sagittis justo, vel malesuada magna.</p>','<form-template>\n	<fields>\n		<field type=\"text\" required=\"true\" label=\"First Name\" description=\"Your first name\" class=\"form-control\" name=\"first-name\" subtype=\"text\"></field>\n		<field type=\"textarea\" label=\"Text Area\" class=\"form-control\" name=\"textarea-1516846628016\"></field>\n		<field type=\"text\" required=\"true\" label=\"Last Name\" description=\"Your last name\" class=\"form-control\" name=\"last-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Email Address\" description=\"Your email address\" class=\"form-control\" name=\"email-address\" subtype=\"text\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Additional Information\" class=\"form-heading\"></field>\n		<field type=\"date\" required=\"true\" label=\"Arrival Date\" class=\"form-control\" name=\"date-1516672514853\"></field>\n		<field type=\"date\" required=\"true\" label=\"Departure Date\" class=\"form-control\" name=\"date-1516672543816\"></field>\n		<field type=\"select\" label=\"Select Tour Extra\" class=\"form-control\" name=\"select-1516672557027\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"checkbox-group\" label=\"Proin eget accumsan odio\" toggle=\"true\" name=\"checkbox-group-1516672812218\">\n			<option label=\"Yes, Proin eget accumsan\" value=\"yes\" selected=\"true\">Yes, Proin eget accumsan</option>\n		</field>\n		<field type=\"textarea\" required=\"true\" label=\"Comments\" class=\"form-control\" name=\"textarea-1516672862845\"></field>\n	</fields>\n</form-template>','[{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"first-name\",\"subtype\":\"text\"},{\"type\":\"textarea\",\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516846628016\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"last-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"email-address\",\"subtype\":\"text\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Additional Information\",\"className\":\"form-heading\"},{\"type\":\"date\",\"required\":true,\"label\":\"Arrival Date\",\"className\":\"form-control\",\"name\":\"date-1516672514853\"},{\"type\":\"date\",\"required\":true,\"label\":\"Departure Date\",\"className\":\"form-control\",\"name\":\"date-1516672543816\"},{\"type\":\"select\",\"label\":\"Select Tour Extra\",\"className\":\"form-control\",\"name\":\"select-1516672557027\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"label\":\"Proin eget accumsan odio\",\"toggle\":true,\"name\":\"checkbox-group-1516672812218\",\"values\":[{\"label\":\"Yes, Proin eget accumsan\",\"value\":\"yes\",\"selected\":true}]},{\"type\":\"textarea\",\"required\":true,\"label\":\"Comments\",\"className\":\"form-control\",\"name\":\"textarea-1516672862845\"}]','2018-01-23 01:43:32','2018-01-25 02:17:14',NULL,'A'),(4,'b4b48fd581','Form 2','Testing Email Subject','Success! Aenean non imperdiet erat, at iaculis tellus','06224f3593','<p>Lorem&nbsp;ipsum&nbsp;dolor sit&nbsp;amet,&nbsp;consectetur&nbsp;adipiscing&nbsp;elit. Maecenas ornare&nbsp;interdum&nbsp;mauris, id&nbsp;cursus&nbsp;leo&nbsp;cursus&nbsp;eget. Morbi elementum&nbsp;ipsum&nbsp;at lectus suscipit sagittis.&nbsp;Donec&nbsp;aliquam eu metus a maximus.&nbsp;Donec&nbsp;euismod vel justo quis iaculis. Phasellus a&nbsp;pharetra&nbsp;sem.&nbsp;Curabitur&nbsp;blandit&nbsp;mollis dolor nec egestas. Ut ac urna ac nunc consequat&nbsp;commodo&nbsp;nec eu urna. Ut&nbsp;faucibus&nbsp;velit&nbsp;nec&nbsp;orci&nbsp;feugiat, in&nbsp;pharetra&nbsp;ipsum&nbsp;tempor. Vivamus eget venenatis diam. Sed&nbsp;ullamcorper&nbsp;sapien&nbsp;sit&nbsp;amet&nbsp;consequat&nbsp;convallis.&nbsp;Cras&nbsp;lacus&nbsp;lorem, posuere id nisl sed, molestie&nbsp;facilisis&nbsp;odio.</p>\r\n\r\n<p>Proin eget accumsan odio, nec consequat eros. Quisque ultrices hendrerit dui. Pellentesque sed mi at&nbsp;augue&nbsp;accumsan&nbsp;mattis.&nbsp;Curabitur&nbsp;ac&nbsp;neque&nbsp;ligula.&nbsp;Duis&nbsp;consectetur&nbsp;lorem a lorem tincidunt&nbsp;pharetra. Etiam a pretium&nbsp;augue, dignissim volutpat justo. Phasellus vel&nbsp;scelerisque&nbsp;odio, et&nbsp;eleifend&nbsp;massa.</p>\r\n\r\n<p>Etiam ac purus&nbsp;porta&nbsp;erat&nbsp;euismod volutpat. Etiam fringilla sem in mi lobortis mollis. Vivamus mi&nbsp;augue, tristique at tempus eu,&nbsp;facilisis&nbsp;eleifend&nbsp;odio.&nbsp;Vestibulum&nbsp;aliquet, nunc id&nbsp;dapibus&nbsp;auctor,&nbsp;enim&nbsp;neque&nbsp;imperdiet magna, ac mollis justo odio id&nbsp;enim. Vivamus nec dolor lobortis, lacinia&nbsp;massa&nbsp;ut,&nbsp;blandit&nbsp;lorem. Ut nec tristique lectus. Vivamus eget maximus justo, sed&nbsp;interdum&nbsp;lectus.&nbsp;Vestibulum&nbsp;faucibus&nbsp;felis nec&nbsp;ipsum&nbsp;rutrum&nbsp;malesuada.&nbsp;Nullam&nbsp;a lectus at lorem&nbsp;mattis&nbsp;pharetra. Maecenas&nbsp;blandit&nbsp;finibus&nbsp;mauris, sed pretium&nbsp;augue&nbsp;eleifend&nbsp;sed.&nbsp;Fusce&nbsp;tempus sagittis justo, vel&nbsp;malesuada&nbsp;magna.</p>','<form-template>\n	<fields>\n		<field type=\"text\" required=\"true\" label=\"First Name\" description=\"Your first name\" class=\"form-control\" name=\"first-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Last Name\" description=\"Your last name\" class=\"form-control\" name=\"last-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Email Address\" description=\"Your email address\" class=\"form-control\" name=\"email-address\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Text Field\" class=\"form-control\" name=\"text-1516928880820\" subtype=\"text\"></field>\n		<field type=\"textarea\" required=\"true\" label=\"Text Area\" class=\"form-control\" name=\"textarea-1516928882300\"></field>\n		<field type=\"select\" required=\"true\" label=\"Select\" class=\"form-control\" name=\"select-1516928883615\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1516928885221\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1517443149838\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" name=\"checkbox-group-1516928896123\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"Option 2\">Option 2</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" toggle=\"true\" name=\"checkbox-group-1517278808535\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"Option 2\">Option 2</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" toggle=\"true\" name=\"checkbox-group-1517443203241\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"Option 2\">Option 2</option>\n		</field>\n		<field type=\"date\" required=\"true\" label=\"Date Field\" class=\"form-control\" name=\"date-1516928897477\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n	</fields>\n</form-template>','[{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"first-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"last-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"email-address\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516928880820\",\"subtype\":\"text\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516928882300\"},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516928883615\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516928885221\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1517443149838\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516928896123\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"toggle\":true,\"name\":\"checkbox-group-1517278808535\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"toggle\":true,\"name\":\"checkbox-group-1517443203241\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516928897477\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"}]','2018-01-26 01:07:35','2018-02-01 00:00:24',NULL,'A'),(5,'02c0f42e02','From 3','','','','','<form-template>\n	<fields>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"first-name\" description=\"Your first name\" subtype=\"text\" label=\"First Name\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"text-1516931085169\" description=\"Your first name\" subtype=\"text\" label=\"First Name\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"last-name\" description=\"Your last name\" subtype=\"text\" label=\"Last Name\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"text-1516931086417\" description=\"Your last name\" subtype=\"text\" label=\"Last Name\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"email-address\" description=\"Your email address\" subtype=\"text\" label=\"Email Address\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"text-1516931087657\" description=\"Your email address\" subtype=\"text\" label=\"Email Address\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"text-1516931054194\" subtype=\"text\" label=\"Text Field\"></field>\n		<field class=\"form-control\" type=\"text\" required=\"true\" name=\"text-1516931089010\" subtype=\"text\" label=\"Text Field\"></field>\n		<field class=\"form-control\" type=\"textarea\" required=\"true\" name=\"textarea-1516931055222\" label=\"Text Area\"></field>\n		<field class=\"form-control\" type=\"textarea\" required=\"true\" name=\"textarea-1516931091290\" label=\"Text Area\"></field>\n		<field class=\"form-control\" type=\"select\" required=\"true\" name=\"select-1516931056513\" label=\"Select\">\n			<option value=\"option-1\" label=\"Option 1\">Option 1</option>\n			<option value=\"option-2\" label=\"Option 2\">Option 2</option>\n			<option value=\"option-3\" label=\"Option 3\">Option 3</option>\n		</field>\n		<field class=\"form-control\" type=\"select\" required=\"true\" name=\"select-1516931093178\" label=\"Select\">\n			<option selected=\"true\" value=\"option-1\" label=\"Option 1\">Option 1</option>\n			<option value=\"option-2\" label=\"Option 2\">Option 2</option>\n			<option value=\"option-3\" label=\"Option 3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" name=\"radio-group-1516931058093\" label=\"Radio Group\">\n			<option value=\"option-1\" label=\"Option 1\">Option 1</option>\n			<option value=\"option-2\" label=\"Option 2\">Option 2</option>\n			<option value=\"option-3\" label=\"Option 3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" name=\"radio-group-1516931095266\" label=\"Radio Group\">\n			<option value=\"option-1\" label=\"Option 1\">Option 1</option>\n			<option value=\"option-2\" label=\"Option 2\">Option 2</option>\n			<option value=\"option-3\" label=\"Option 3\">Option 3</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" name=\"checkbox-group-1516931060528\" label=\"Checkbox Group\">\n			<option selected=\"true\" value=\"option-1\" label=\"Option 1\">Option 1</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" name=\"checkbox-group-1516931099018\" label=\"Checkbox Group\">\n			<option selected=\"true\" value=\"option-1\" label=\"Option 1\">Option 1</option>\n		</field>\n		<field class=\"form-control\" type=\"date\" required=\"true\" name=\"date-1516931063286\" label=\"Date Field\"></field>\n		<field class=\"form-control\" type=\"date\" required=\"true\" name=\"date-1516931100754\" label=\"Date Field\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n	</fields>\n</form-template>','[{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"first-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"text-1516931085169\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"last-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"text-1516931086417\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"email-address\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"text-1516931087657\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516931054194\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516931089010\",\"subtype\":\"text\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516931055222\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516931091290\"},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516931056513\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516931093178\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931058093\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931095266\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516931060528\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516931099018\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516931063286\"},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516931100754\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"}]','2018-01-26 01:43:42','2018-01-26 01:45:12',NULL,'A'),(6,'92e09fd284','Form 4','','','','','<form-template>\n	<fields>\n		<field type=\"text\" required=\"true\" label=\"First Name\" description=\"Your first name\" class=\"form-control\" name=\"first-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Last Name\" description=\"Your last name\" class=\"form-control\" name=\"last-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Email Address\" description=\"Your email address\" class=\"form-control\" name=\"email-address\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Text Field\" class=\"form-control\" name=\"text-1516931235149\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Text Field\" class=\"form-control\" name=\"text-1516931326647\" subtype=\"text\"></field>\n		<field type=\"textarea\" required=\"true\" label=\"Text Area\" class=\"form-control\" name=\"textarea-1516931237932\"></field>\n		<field type=\"textarea\" required=\"true\" label=\"Text Area\" class=\"form-control\" name=\"textarea-1516931322751\"></field>\n		<field type=\"select\" required=\"true\" label=\"Select\" class=\"form-control\" name=\"select-1516931239187\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"select\" required=\"true\" label=\"Select\" class=\"form-control\" name=\"select-1516931314798\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1516931241857\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1516931288637\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" name=\"checkbox-group-1516931244005\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" name=\"checkbox-group-1516931286742\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n		</field>\n		<field type=\"date\" required=\"true\" label=\"Date Field\" class=\"form-control\" name=\"date-1516931247457\"></field>\n		<field type=\"date\" required=\"true\" label=\"Date Field\" class=\"form-control\" name=\"date-1516931278213\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n	</fields>\n</form-template>','[{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"first-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"last-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"email-address\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516931235149\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516931326647\",\"subtype\":\"text\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516931237932\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516931322751\"},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516931239187\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516931314798\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931241857\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931288637\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516931244005\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516931286742\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516931247457\"},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516931278213\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"}]','2018-01-26 01:47:14','2018-01-26 01:49:14',NULL,'A'),(7,'e2d2b5b537','Form 5','','','','','<form-template>\n	<fields>\n		<field type=\"text\" required=\"true\" label=\"First Name\" description=\"Your first name\" class=\"form-control\" name=\"first-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Last Name\" description=\"Your last name\" class=\"form-control\" name=\"last-name\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Email Address\" description=\"Your email address\" class=\"form-control\" name=\"email-address\" subtype=\"text\"></field>\n		<field type=\"text\" required=\"true\" label=\"Text Field\" class=\"form-control\" name=\"text-1516931786434\" subtype=\"text\"></field>\n		<field type=\"textarea\" required=\"true\" label=\"Text Area\" class=\"form-control\" name=\"textarea-1516931788088\"></field>\n		<field type=\"select\" required=\"true\" label=\"Select\" class=\"form-control\" name=\"select-1516931789693\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1516931798345\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"radio-group\" required=\"true\" label=\"Radio Group\" name=\"radio-group-1516931910038\">\n			<option label=\"Option 1\" value=\"option-1\">Option 1</option>\n			<option label=\"Option 2\" value=\"option-2\">Option 2</option>\n			<option label=\"Option 3\" value=\"option-3\">Option 3</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" name=\"checkbox-group-1516931804195\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n		</field>\n		<field type=\"checkbox-group\" required=\"true\" label=\"Checkbox Group\" name=\"checkbox-group-1516932063710\">\n			<option label=\"Option 1\" value=\"option-1\" selected=\"true\">Option 1</option>\n		</field>\n		<field type=\"date\" required=\"true\" label=\"Date Field\" class=\"form-control\" name=\"date-1516931812288\"></field>\n		<field type=\"header\" subtype=\"h2\" label=\"Header\"></field>\n	</fields>\n</form-template>','[{\"type\":\"text\",\"required\":true,\"label\":\"First Name\",\"description\":\"Your first name\",\"className\":\"form-control\",\"name\":\"first-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Last Name\",\"description\":\"Your last name\",\"className\":\"form-control\",\"name\":\"last-name\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Email Address\",\"description\":\"Your email address\",\"className\":\"form-control\",\"name\":\"email-address\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1516931786434\",\"subtype\":\"text\"},{\"type\":\"textarea\",\"required\":true,\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1516931788088\"},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1516931789693\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931798345\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1516931910038\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516931804195\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1516932063710\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true}]},{\"type\":\"date\",\"required\":true,\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1516931812288\"},{\"type\":\"header\",\"subtype\":\"h2\",\"label\":\"Header\"}]','2018-01-26 01:56:18','2018-01-31 23:56:37',NULL,'A'),(8,'ec4817db58','Untitled',NULL,NULL,'',NULL,NULL,'','2018-01-26 02:05:58',NULL,NULL,'H');
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_entry`
--

DROP TABLE IF EXISTS `form_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_entry`
--

LOCK TABLES `form_entry` WRITE;
/*!40000 ALTER TABLE `form_entry` DISABLE KEYS */;
INSERT INTO `form_entry` VALUES (1,'Pinal','Desai','Pinal Desai','pinal.j.desai@gmail.com','114.23.241.67','2018-01-23 02:02:22',3),(2,'Pinal','Desai','Pinal Desai','pinal.j.desai@gmail.com','114.23.241.67','2018-01-23 02:03:59',3),(3,'Alpha','Test','Alpha Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 02:35:03',4),(4,'Alpha','Test','Alpha Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:09:32',4),(5,'Beta','Test','Beta Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:18:37',4),(6,'Charlie','Test','Charlie Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:21:14',4),(7,'Charlie','Test','Charlie Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:28:52',4),(8,'Alpha','Test','Alpha Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:32:16',4),(9,'Alpha','Test','Alpha Test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:32:53',4),(10,'Alpha','test','Alpha test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:37:09',4),(11,'alpha','test','alpha test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:38:36',4),(12,'alpha','test','alpha test','alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:41:25',4),(13,'Alpha','Test','Alpha Test','Alan@tomahawk.co.nz','114.23.241.67','2018-01-30 03:43:47',4),(14,'Urban','test','Urban test','alan@tomahawk.co.nz','114.23.241.67','2018-01-31 21:02:24',4),(15,'urban','test','urban test','alan@tomahawk.co.nz','114.23.241.67','2018-02-01 00:00:58',4);
/*!40000 ALTER TABLE `form_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_entry_data`
--

DROP TABLE IF EXISTS `form_entry_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_entry_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `value` text,
  `form_id` int(11) NOT NULL,
  `form_entry_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_entry_data`
--

LOCK TABLES `form_entry_data` WRITE;
/*!40000 ALTER TABLE `form_entry_data` DISABLE KEYS */;
INSERT INTO `form_entry_data` VALUES (1,'First Name','Pinal',3,1),(2,'Last Name','Desai',3,1),(3,'Email Address','pinal.j.desai@gmail.com',3,1),(4,'Additional Information','',3,1),(5,'Arrival Date','24/01/2018',3,1),(6,'Departure Date','26/01/2018',3,1),(7,'Select Tour Extra','option-2',3,1),(8,'Proin eget accumsan odio','',3,1),(9,'Comments','This is a Test',3,1),(10,'First Name','Pinal',3,2),(11,'Last Name','Desai',3,2),(12,'Email Address','pinal.j.desai@gmail.com',3,2),(13,'Additional Information','',3,2),(14,'Arrival Date','27/01/2018',3,2),(15,'Departure Date','31/01/2018',3,2),(16,'Select Tour Extra','option-3',3,2),(17,'Proin eget accumsan odio','yes',3,2),(18,'Comments','TEST',3,2),(19,'First Name','Alpha',4,3),(20,'Last Name','Test',4,3),(21,'Email Address','alan@tomahawk.co.nz',4,3),(22,'Text Field','test',4,3),(23,'Text Area','test',4,3),(24,'Select','option-1',4,3),(25,'Radio Group','option-1, ',4,3),(26,'Checkbox Group','option-1, ',4,3),(27,'Checkbox Group','option-1, ',4,3),(28,'Date Field','01/03/2018',4,3),(29,'Header','',4,3),(30,'First Name','Alpha',4,4),(31,'Last Name','Test',4,4),(32,'Email Address','alan@tomahawk.co.nz',4,4),(33,'Text Field','Test',4,4),(34,'Text Area','Test',4,4),(35,'Select','option-1',4,4),(36,'Radio Group','option-1, ',4,4),(37,'Checkbox Group','option-1, ',4,4),(38,'Checkbox Group','option-1, ',4,4),(39,'Date Field','01/04/2018',4,4),(40,'Header','',4,4),(41,'First Name','Beta',4,5),(42,'Last Name','Test',4,5),(43,'Email Address','alan@tomahawk.co.nz',4,5),(44,'Text Field','Test',4,5),(45,'Text Area','test',4,5),(46,'Select','option-1',4,5),(47,'Radio Group','option-1, ',4,5),(48,'Checkbox Group','option-1, Option 2, ',4,5),(49,'Checkbox Group','option-1, Option 2, ',4,5),(50,'Date Field','01/03/2018',4,5),(51,'Header','',4,5),(52,'First Name','Charlie',4,6),(53,'Last Name','Test',4,6),(54,'Email Address','alan@tomahawk.co.nz',4,6),(55,'Text Field','test',4,6),(56,'Text Area','test',4,6),(57,'Select','option-1',4,6),(58,'Radio Group','option-1, ',4,6),(59,'Checkbox Group','option-1, Option 2, ',4,6),(60,'Checkbox Group','option-1, Option 2, ',4,6),(61,'Date Field','01/04/2018',4,6),(62,'Header','',4,6),(63,'First Name','Charlie',4,7),(64,'Last Name','Test',4,7),(65,'Email Address','alan@tomahawk.co.nz',4,7),(66,'Text Field','test',4,7),(67,'Text Area','test',4,7),(68,'Select','option-1',4,7),(69,'Radio Group','option-1, ',4,7),(70,'Checkbox Group','option-1, ',4,7),(71,'Checkbox Group','option-1, ',4,7),(72,'Date Field','01/03/2018',4,7),(73,'Header','',4,7),(74,'First Name','Alpha',4,8),(75,'Last Name','Test',4,8),(76,'Email Address','alan@tomahawk.co.nz',4,8),(77,'Text Field','test',4,8),(78,'Text Area','test',4,8),(79,'Select','option-1',4,8),(80,'Radio Group','option-1, ',4,8),(81,'Checkbox Group','option-1, Option 2, ',4,8),(82,'Checkbox Group','option-1, Option 2, ',4,8),(83,'Date Field','01/02/2018',4,8),(84,'Header','',4,8),(85,'First Name','Alpha',4,9),(86,'Last Name','Test',4,9),(87,'Email Address','alan@tomahawk.co.nz',4,9),(88,'Text Field','test',4,9),(89,'Text Area','test',4,9),(90,'Select','option-1',4,9),(91,'Radio Group','option-1, ',4,9),(92,'Checkbox Group','option-1, Option 2, ',4,9),(93,'Checkbox Group','option-1, Option 2, ',4,9),(94,'Date Field','01/02/2018',4,9),(95,'Header','',4,9),(96,'First Name','Alpha',4,10),(97,'Last Name','test',4,10),(98,'Email Address','alan@tomahawk.co.nz',4,10),(99,'Text Field','test',4,10),(100,'Text Area','test',4,10),(101,'Select','option-1',4,10),(102,'Radio Group','option-1, ',4,10),(103,'Checkbox Group','option-1, ',4,10),(104,'Checkbox Group','option-1, Option 2, ',4,10),(105,'Date Field','01/02/2018',4,10),(106,'Header','',4,10),(107,'First Name','alpha',4,11),(108,'Last Name','test',4,11),(109,'Email Address','alan@tomahawk.co.nz',4,11),(110,'Text Field','test',4,11),(111,'Text Area','test',4,11),(112,'Select','option-1',4,11),(113,'Radio Group','option-1, ',4,11),(114,'Checkbox Group','option-1, ',4,11),(115,'Checkbox Group','option-1, Option 2, ',4,11),(116,'Date Field','01/02/2018',4,11),(117,'Header','',4,11),(118,'First Name','alpha',4,12),(119,'Last Name','test',4,12),(120,'Email Address','alan@tomahawk.co.nz',4,12),(121,'Text Field','test',4,12),(122,'Text Area','test',4,12),(123,'Select','option-2',4,12),(124,'Radio Group','option-2, ',4,12),(125,'Checkbox Group','Option 2, ',4,12),(126,'Checkbox Group','option-1, Option 2, ',4,12),(127,'Date Field','01/02/2018',4,12),(128,'Header','',4,12),(129,'First Name','Alpha',4,13),(130,'Last Name','Test',4,13),(131,'Email Address','Alan@tomahawk.co.nz',4,13),(132,'Text Field','Test',4,13),(133,'Text Area','Test',4,13),(134,'Select','option-2',4,13),(135,'Radio Group','option-2, ',4,13),(136,'Checkbox Group','Option 2, ',4,13),(137,'Checkbox Group','Option 2, ',4,13),(138,'Date Field','01/02/2018',4,13),(139,'Header','',4,13),(140,'First Name','Urban',4,14),(141,'Last Name','test',4,14),(142,'Email Address','alan@tomahawk.co.nz',4,14),(143,'Text Field','urban test',4,14),(144,'Text Area','urban test',4,14),(145,'Select','option-1',4,14),(146,'Radio Group','option-1, ',4,14),(147,'Checkbox Group','option-1, ',4,14),(148,'Checkbox Group','option-1, ',4,14),(149,'Date Field','01/03/2018',4,14),(150,'Header','',4,14),(151,'First Name','urban',4,15),(152,'Last Name','test',4,15),(153,'Email Address','alan@tomahawk.co.nz',4,15),(154,'Text Field','urban test',4,15),(155,'Text Area','urban test',4,15),(156,'Select','option-1',4,15),(157,'Radio Group','option-1, ',4,15),(158,'Radio Group','option-1, ',4,15),(159,'Checkbox Group','option-1, ',4,15),(160,'Checkbox Group','option-1, ',4,15),(161,'Checkbox Group','option-1, ',4,15),(162,'Date Field','01/03/2018',4,15),(163,'Header','',4,15);
/*!40000 ALTER TABLE `form_entry_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_field`
--

DROP TABLE IF EXISTS `form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `placeholder` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_required` enum('N','Y') NOT NULL DEFAULT 'N',
  `is_multiple` enum('Y','N') DEFAULT 'N',
  `is_toggle` enum('Y','N') NOT NULL DEFAULT 'N',
  `class` varchar(255) DEFAULT NULL,
  `help_text` varchar(255) DEFAULT NULL,
  `subtype` varchar(255) DEFAULT NULL,
  `options_json` text,
  `rank` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_field`
--

LOCK TABLES `form_field` WRITE;
/*!40000 ALTER TABLE `form_field` DISABLE KEYS */;
INSERT INTO `form_field` VALUES (116,'First Name','first-name',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',1,3),(117,'Text Area','textarea-1516846628016',NULL,NULL,'textarea','N','N','N','form-control',NULL,NULL,'[]',2,3),(118,'Last Name','last-name',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',3,3),(119,'Email Address','email-address',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',4,3),(120,'Additional Information',NULL,NULL,NULL,'header','N','N','N','form-heading',NULL,'h2','[]',5,3),(121,'Arrival Date','date-1516672514853',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',6,3),(122,'Departure Date','date-1516672543816',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',7,3),(123,'Select Tour Extra','select-1516672557027',NULL,NULL,'select','N','N','N','form-control',NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',8,3),(124,'Proin eget accumsan odio','checkbox-group-1516672812218',NULL,NULL,'checkbox-group','N','N','Y',NULL,NULL,NULL,'[{\"label\":\"Yes, Proin eget accumsan\",\"value\":\"yes\"}]',9,3),(125,'Comments','textarea-1516672862845',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',10,3),(146,'First Name','first-name',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',1,5),(147,'First Name','text-1516931085169',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',2,5),(148,'Last Name','last-name',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',3,5),(149,'Last Name','text-1516931086417',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',4,5),(150,'Email Address','email-address',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',5,5),(151,'Email Address','text-1516931087657',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',6,5),(152,'Text Field','text-1516931054194',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',7,5),(153,'Text Field','text-1516931089010',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',8,5),(154,'Text Area','textarea-1516931055222',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',9,5),(155,'Text Area','textarea-1516931091290',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',10,5),(156,'Select','select-1516931056513',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"},{\"value\":\"option-2\",\"label\":\"Option 2\"},{\"value\":\"option-3\",\"label\":\"Option 3\"}]',11,5),(157,'Select','select-1516931093178',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"},{\"value\":\"option-2\",\"label\":\"Option 2\"},{\"value\":\"option-3\",\"label\":\"Option 3\"}]',12,5),(158,'Radio Group','radio-group-1516931058093',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"},{\"value\":\"option-2\",\"label\":\"Option 2\"},{\"value\":\"option-3\",\"label\":\"Option 3\"}]',13,5),(159,'Radio Group','radio-group-1516931095266',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"},{\"value\":\"option-2\",\"label\":\"Option 2\"},{\"value\":\"option-3\",\"label\":\"Option 3\"}]',14,5),(160,'Checkbox Group','checkbox-group-1516931060528',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"}]',15,5),(161,'Checkbox Group','checkbox-group-1516931099018',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"value\":\"option-1\",\"label\":\"Option 1\"}]',16,5),(162,'Date Field','date-1516931063286',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',17,5),(163,'Date Field','date-1516931100754',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',18,5),(164,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',19,5),(165,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',20,5),(166,'First Name','first-name',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',1,6),(167,'Last Name','last-name',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',2,6),(168,'Email Address','email-address',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',3,6),(169,'Text Field','text-1516931235149',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',4,6),(170,'Text Field','text-1516931326647',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',5,6),(171,'Text Area','textarea-1516931237932',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',6,6),(172,'Text Area','textarea-1516931322751',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',7,6),(173,'Select','select-1516931239187',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',8,6),(174,'Select','select-1516931314798',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',9,6),(175,'Radio Group','radio-group-1516931241857',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',10,6),(176,'Radio Group','radio-group-1516931288637',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',11,6),(177,'Checkbox Group','checkbox-group-1516931244005',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"}]',12,6),(178,'Checkbox Group','checkbox-group-1516931286742',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"}]',13,6),(179,'Date Field','date-1516931247457',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',14,6),(180,'Date Field','date-1516931278213',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',15,6),(181,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',16,6),(182,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',17,6),(299,'First Name','first-name',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',1,7),(300,'Last Name','last-name',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',2,7),(301,'Email Address','email-address',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',3,7),(302,'Text Field','text-1516931786434',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',4,7),(303,'Text Area','textarea-1516931788088',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',5,7),(304,'Select','select-1516931789693',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',6,7),(305,'Radio Group','radio-group-1516931798345',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',7,7),(306,'Radio Group','radio-group-1516931910038',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',8,7),(307,'Checkbox Group','checkbox-group-1516931804195',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"}]',9,7),(308,'Checkbox Group','checkbox-group-1516932063710',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"}]',10,7),(309,'Date Field','date-1516931812288',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',11,7),(310,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',12,7),(323,'First Name','first-name',NULL,NULL,'text','Y','N','N','form-control','Your first name','text','[]',1,4),(324,'Last Name','last-name',NULL,NULL,'text','Y','N','N','form-control','Your last name','text','[]',2,4),(325,'Email Address','email-address',NULL,NULL,'text','Y','N','N','form-control','Your email address','text','[]',3,4),(326,'Text Field','text-1516928880820',NULL,NULL,'text','Y','N','N','form-control',NULL,'text','[]',4,4),(327,'Text Area','textarea-1516928882300',NULL,NULL,'textarea','Y','N','N','form-control',NULL,NULL,'[]',5,4),(328,'Select','select-1516928883615',NULL,NULL,'select','Y','N','N','form-control',NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',6,4),(329,'Radio Group','radio-group-1516928885221',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',7,4),(330,'Radio Group','radio-group-1517443149838',NULL,NULL,'radio-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]',8,4),(331,'Checkbox Group','checkbox-group-1516928896123',NULL,NULL,'checkbox-group','Y','N','N',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]',9,4),(332,'Checkbox Group','checkbox-group-1517278808535',NULL,NULL,'checkbox-group','Y','N','Y',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]',10,4),(333,'Checkbox Group','checkbox-group-1517443203241',NULL,NULL,'checkbox-group','Y','N','Y',NULL,NULL,NULL,'[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"Option 2\"}]',11,4),(334,'Date Field','date-1516928897477',NULL,NULL,'date','Y','N','N','form-control',NULL,NULL,'[]',12,4),(335,'Header',NULL,NULL,NULL,'header','N','N','N',NULL,NULL,'h2','[]',13,4);
/*!40000 ALTER TABLE `form_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_importantpages`
--

DROP TABLE IF EXISTS `general_importantpages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_importantpages` (
  `imppage_id` int(11) NOT NULL AUTO_INCREMENT,
  `imppage_name` varchar(150) NOT NULL,
  `page_id` int(11) NOT NULL,
  `imppage_showincms` enum('N','Y') NOT NULL DEFAULT 'Y',
  `is_mobile` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`imppage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_importantpages`
--

LOCK TABLES `general_importantpages` WRITE;
/*!40000 ALTER TABLE `general_importantpages` DISABLE KEYS */;
INSERT INTO `general_importantpages` VALUES (1,'Home',1,'N',0),(2,'404',11,'Y',0),(3,'Testimonial',7,'Y',0),(4,'Contact',8,'Y',0),(5,'Accommodation',2,'Y',0),(6,'Bookings',6,'Y',0),(7,'Gallery',12,'Y',0),(8,'blog',15,'Y',0),(9,'Compendium',23,'Y',0);
/*!40000 ALTER TABLE `general_importantpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_pages`
--

DROP TABLE IF EXISTS `general_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for pages',
  `access_level` enum('P','L') NOT NULL DEFAULT 'P' COMMENT 'P = Public, L = Private',
  `meta_cache` tinyint(1) NOT NULL DEFAULT '1',
  `slideshow_type` enum('C','D') NOT NULL DEFAULT 'D',
  `parent_id` int(11) DEFAULT '0',
  `template_id` int(11) DEFAULT NULL,
  `page_meta_data_id` int(11) NOT NULL,
  `publish_on_set_time` enum('Y','N') NOT NULL DEFAULT 'N',
  `publish_on` datetime DEFAULT NULL,
  `hide_on` datetime DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_parent` (`parent_id`),
  KEY `page_meta_data_id` (`page_meta_data_id`),
  KEY `template_id` (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_pages`
--

LOCK TABLES `general_pages` WRITE;
/*!40000 ALTER TABLE `general_pages` DISABLE KEYS */;
INSERT INTO `general_pages` VALUES (1,'P',1,'D',0,1,1,'N','2017-12-06 23:54:50','2017-12-06 23:54:50',0),(2,'P',1,'D',0,1,2,'N','2017-12-30 16:01:29','2017-12-30 16:25:51',0),(3,'P',1,'D',0,1,3,'N',NULL,NULL,NULL),(4,'P',1,'D',0,1,4,'N','2017-12-06 23:51:30','2017-12-06 23:51:30',0),(5,'P',1,'D',0,1,5,'N','2017-12-06 03:22:36','2017-12-06 03:22:36',0),(6,'P',1,'D',0,1,6,'N',NULL,NULL,NULL),(7,'P',1,'D',5,1,7,'N','2017-12-17 21:51:41','2017-12-17 21:51:41',NULL),(8,'P',1,'D',0,1,8,'N','2017-12-05 01:10:49','2017-12-05 01:10:49',NULL),(9,'P',1,'D',0,1,9,'N','2018-01-26 01:45:21','2018-01-26 01:45:21',7),(10,'P',1,'D',0,1,10,'N','2018-01-26 01:10:57','2018-01-26 01:10:57',4),(11,'P',1,'D',0,1,11,'N',NULL,NULL,NULL),(12,'P',1,'D',0,1,14,'N',NULL,NULL,NULL),(13,'P',1,'D',0,NULL,15,'N',NULL,NULL,NULL),(14,'P',1,'D',0,NULL,16,'N',NULL,NULL,NULL),(15,'P',1,'D',5,1,18,'N','2017-12-17 21:51:21','2017-12-17 21:51:21',NULL),(16,'P',1,'D',0,1,22,'N','2017-12-06 23:50:16','2017-12-06 23:50:16',NULL),(17,'P',1,'D',0,1,24,'N',NULL,NULL,NULL),(18,'P',1,'D',0,1,30,'N','2017-12-07 01:24:33','2017-12-07 01:24:33',NULL),(19,'P',1,'D',5,1,31,'N','2017-12-17 21:13:55','2017-12-17 21:13:55',NULL),(20,'P',1,'D',0,1,35,'N','2017-12-17 21:59:57','2017-12-17 21:59:57',NULL),(21,'P',1,'D',0,1,38,'N','2018-01-22 21:57:55','2018-01-22 21:57:55',0),(22,'P',1,'D',0,NULL,39,'N',NULL,NULL,NULL),(23,'P',1,'D',0,2,40,'N','2018-02-15 01:20:33','2018-02-15 01:20:33',0);
/*!40000 ALTER TABLE `general_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL COMMENT 'Company/Business/Website name	',
  `start_year` int(4) DEFAULT NULL,
  `email_address` mediumtext COMMENT 'Email Address',
  `phone_number` varchar(100) DEFAULT NULL,
  `address` mediumtext,
  `booking_url` varchar(255) DEFAULT NULL,
  `js_code_head_close` mediumtext,
  `js_code_body_open` mediumtext,
  `js_code_body_close` mediumtext,
  `adwords_code` mediumtext,
  `mailchimp_api_key` varchar(100) DEFAULT NULL,
  `mailchimp_list_id` varchar(50) DEFAULT NULL,
  `resbook_id` varchar(100) NOT NULL,
  `map_latitude` float(10,6) DEFAULT NULL,
  `map_longitude` float(10,6) DEFAULT NULL,
  `map_address` mediumtext,
  `map_styles` longtext,
  `map_heading` varchar(255) DEFAULT NULL,
  `map_description` mediumtext,
  `map_zoom_level` smallint(6) NOT NULL,
  `map_marker_latitude` float(10,6) NOT NULL,
  `map_marker_longitude` float(10,6) NOT NULL,
  `slideshow_speed` int(11) DEFAULT '3000',
  `set_sitemapupdated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `set_sitemapstatus` char(1) DEFAULT NULL,
  `homepage_slideshow_caption` varchar(255) DEFAULT NULL,
  `tripadvisor_widget_code` mediumtext,
  `color_palette_id` smallint(5) DEFAULT NULL,
  `company_logo_path` varchar(255) DEFAULT NULL,
  `webfont_headings` varchar(100) DEFAULT NULL,
  `webfont_text` varchar(100) DEFAULT NULL,
  `booking_engine_url` varchar(100) DEFAULT NULL,
  `mailchimp_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_settings`
--

LOCK TABLES `general_settings` WRITE;
/*!40000 ALTER TABLE `general_settings` DISABLE KEYS */;
INSERT INTO `general_settings` VALUES (1,'Urban Escape Resort',0,'ian@tomahawk.co.nz;alan@tomahawk.co.nz','+1 100 123 4567','17 Constellation Drive\r\nAuckland','','','','','','6577a17dd0a66458981c0b4126a86b45-us15','06224f3593','1144',-36.746696,174.736298,'17 Constellation Dr, Rosedale, Auckland 0632, New Zealand','[{\"featureType\":\"administrative\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#a7a7a7\"}]},{\"featureType\":\"administrative\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"visibility\":\"on\"},{\"color\":\"#737373\"}]},{\"featureType\":\"landscape\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"visibility\":\"on\"},{\"color\":\"#efefef\"}]},{\"featureType\":\"poi\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"visibility\":\"on\"},{\"color\":\"#dadada\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#696969\"}]},{\"featureType\":\"road\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#ffffff\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"visibility\":\"on\"},{\"color\":\"#b3b3b3\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#ffffff\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#d6d6d6\"}]},{\"featureType\":\"road.local\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"visibility\":\"on\"},{\"color\":\"#ffffff\"},{\"weight\":1.8}]},{\"featureType\":\"road.local\",\"elementType\":\"geometry.stroke\",\"stylers\":[{\"color\":\"#d7d7d7\"}]},{\"featureType\":\"transit\",\"elementType\":\"all\",\"stylers\":[{\"color\":\"#808080\"},{\"visibility\":\"off\"}]},{\"featureType\":\"water\",\"elementType\":\"geometry.fill\",\"stylers\":[{\"color\":\"#d3d3d3\"}]}]','','',13,-36.746696,174.736298,1,'2018-02-02 01:49:43','I','','<div id=\"TA_selfserveprop452\" class=\"TA_selfserveprop\">\r\n<ul id=\"qUFEsQADPa\" class=\"TA_links hUYXyJei\">\r\n<li id=\"w52drAvt\" class=\"g9yvErBj\">\r\n<a target=\"_blank\" href=\"https://www.tripadvisor.co.nz/\"><img src=\"https://www.tripadvisor.co.nz/img/cdsi/img2/branding/150_logo-11900-2.png\" alt=\"TripAdvisor\"/></a>\r\n</li>\r\n</ul>\r\n</div>\r\n<script src=\"https://www.jscache.com/wejs?wtype=selfserveprop&uniq=452&locationId=6925660&lang=en_NZ&rating=true&nreviews=5&writereviewlink=true&popIdx=true&iswide=false&border=true&display_version=2\"></script>',3,'/library/logo.png','Merriweather','Merriweather','http://www.test.com','pinal@tomahawk.co.nz');
/*!40000 ALTER TABLE `general_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installed_modules`
--

DROP TABLE IF EXISTS `installed_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `installed_modules` (
  `id` int(11) NOT NULL,
  `number` int(100) DEFAULT NULL,
  `label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` longtext CHARACTER SET latin1,
  `type` enum('C','O','A') CHARACTER SET latin1 NOT NULL DEFAULT 'C',
  `status` enum('A','D','H') CHARACTER SET latin1 DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installed_modules`
--

LOCK TABLES `installed_modules` WRITE;
/*!40000 ALTER TABLE `installed_modules` DISABLE KEYS */;
INSERT INTO `installed_modules` VALUES (0,1,'Site Map','This is your main navigation for your website. You can have a maximum of 7 main menu links and any number of sub-menu links.','C','A'),(1,2,'General Content Pages','This is the main module you use to edit content on each page of your website.','C','A'),(2,3,'Quicklinks','These are automatically formatted image links to other pages on your website. You simply select a list of pages you want to link to and the CMS does the rest.','C','A'),(3,4,'Location Map','Your location page will include a Google map pinpointing your location.','C','A'),(4,5,'Slideshows','This module allows you to add any number of images to a gallery that can then be used as a slideshow on any of your website\'s pages.','C','A'),(5,6,'Photo Gallery','As many photo galleries can be created as you wish. These are then displayed on your main gallery page or an individual gallery can be included on any selected page.','C','A'),(6,7,'Accommodation or Activity Module - depending on Website type','This module allows you to easily setup your accommodation options and have them automatically displayed on your accommodation page','C','A'),(7,8,'Contact Page Enquiry Form','An enquiry form will sit on your contact page where visitors can send you messages by completing the form.','C','A'),(8,9,'File Manager','Using the file manager you can upload any type of document including photos, word documents, PDF file, etc. This allows you to create links on your site to these documents.','C','A'),(9,10,'Booking Button - Main navigation CTA to ResBook booking page or external link','Whether you\'re using ResBook or any other booking engine, your website will have a main booking call-to-action on every page of your website.','C','A'),(10,11,'Booking Calendar Widget - ResBook only','If you\'re using ResBook, this widget will sit on all pages of your site just below the hero slideshow.','C','A'),(11,12,'Social Media icon footer links','This module allows you to add links to the listed social media platforms and will display icons in the footer of your website.','C','A'),(12,13,'Partner logos - limited to 3 and displayed in the footer','This feature allows you to add up to 3 selected logos that will appear in your website. Contact us if you need to add more.','C','A'),(13,14,'Footer Links','When creating your website\'s site map you can specify which pages you want to have as links in the footer section of your site.','C','A'),(14,15,'Copyright Notice','The website will automatically insert a copyright notice into the footer of your website.','C','A'),(15,16,'Redirects Module','This module allows you to easily migrate from and older website to your new website by adding redirects from the old website pages to their equivalent page on your new site.','C','A'),(16,17,'Enquiries Module','This module provides access to all enquiries made through your contact page form.','C','A'),(17,18,'Sitemap Generator','This module allows you to create a site map XML file for submission to Google.','C','A'),(18,19,'Reviews','This module allows you to add as many customer reviews as you want. A randomly displayed review is displayed in your footer section.','O','A'),(19,20,'Mailchimp','','O','A');
/*!40000 ALTER TABLE `installed_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_pages`
--

DROP TABLE IF EXISTS `module_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_pages` (
  `modpages_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `modpages_rank` int(4) DEFAULT NULL,
  `mod_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`modpages_id`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_pages`
--

LOCK TABLES `module_pages` WRITE;
/*!40000 ALTER TABLE `module_pages` DISABLE KEYS */;
INSERT INTO `module_pages` VALUES (18,1,3,4),(7,7,2,4),(133,8,2,2),(163,1,4,3),(126,12,2,9),(159,4,3,6),(143,15,1,10),(132,16,1,3),(155,5,1,3),(152,21,1,12);
/*!40000 ALTER TABLE `module_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_templates`
--

DROP TABLE IF EXISTS `module_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_templates` (
  `tmplmod_id` int(11) NOT NULL AUTO_INCREMENT,
  `tmpl_id` int(11) NOT NULL,
  `mod_id` int(11) NOT NULL,
  `tmplmod_rank` int(11) NOT NULL,
  PRIMARY KEY (`tmplmod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_templates`
--

LOCK TABLES `module_templates` WRITE;
/*!40000 ALTER TABLE `module_templates` DISABLE KEYS */;
INSERT INTO `module_templates` VALUES (1,1,1,20),(2,1,5,8),(3,1,4,2),(4,1,7,7),(6,1,8,6),(7,1,11,10),(8,2,13,2);
/*!40000 ALTER TABLE `module_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for include',
  `mod_name` varchar(255) DEFAULT NULL COMMENT 'Include name',
  `mod_path` varchar(255) DEFAULT NULL COMMENT 'Include URL/file path (exclude the extension)',
  `mod_showincms` enum('N','Y') NOT NULL DEFAULT 'Y',
  `mod_mobile` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Slideshow','slideshow','N',NULL),(2,'Contact','contact','Y',NULL),(3,'Quicklinks','quicklinks','Y',NULL),(5,'Testimonial','testimonial','N',NULL),(7,'Gallery Carousel','gallery_carousel','N',NULL),(6,'Map','map','Y',NULL),(4,'Accommodation','accommodation','N',NULL),(8,'Bookings','bookings','N',NULL),(9,'Gallery','gallery','Y',NULL),(10,'Blog','blog','Y',NULL),(11,'Form','form','N',NULL),(12,'Payments','payments','Y',NULL),(13,'Compendium','compendium','N',NULL);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_has_quicklink`
--

DROP TABLE IF EXISTS `page_has_quicklink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_has_quicklink` (
  `page_id` int(11) NOT NULL,
  `quicklink_page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_has_quicklink`
--

LOCK TABLES `page_has_quicklink` WRITE;
/*!40000 ALTER TABLE `page_has_quicklink` DISABLE KEYS */;
INSERT INTO `page_has_quicklink` VALUES (16,4),(16,5),(5,15),(5,7),(1,2),(1,16),(1,4);
/*!40000 ALTER TABLE `page_has_quicklink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_meta_data`
--

DROP TABLE IF EXISTS `page_meta_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_meta_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `menu_label` varchar(255) DEFAULT NULL,
  `footer_menu` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `sub_heading` varchar(255) DEFAULT NULL,
  `quicklink_heading` varchar(255) DEFAULT NULL,
  `quicklink_menu_label` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `full_url` varchar(255) DEFAULT NULL,
  `introduction` mediumtext,
  `short_description` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `photo` varchar(255) DEFAULT NULL,
  `thumb_photo` varchar(255) DEFAULT NULL,
  `photo_caption` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `meta_description` mediumtext,
  `og_title` varchar(255) DEFAULT NULL,
  `og_meta_description` mediumtext,
  `og_image` varchar(255) DEFAULT NULL,
  `time_based_publishing` enum('N','Y') NOT NULL DEFAULT 'N',
  `publish_on` datetime DEFAULT NULL,
  `hide_on` datetime DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('A','H','D') DEFAULT 'H',
  `rank` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `slideshow_id` int(11) DEFAULT NULL,
  `page_meta_index_id` int(11) DEFAULT '1',
  `page_js_code_head_close` mediumtext,
  `page_js_code_body_open` mediumtext,
  `page_js_code_body_close` mediumtext,
  `quicklink_photo` varchar(255) DEFAULT NULL,
  `quicklink_thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bsh_query_1` (`status`,`menu_label`,`heading`,`title`,`sub_heading`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_meta_data`
--

LOCK TABLES `page_meta_data` WRITE;
/*!40000 ALTER TABLE `page_meta_data` DISABLE KEYS */;
INSERT INTO `page_meta_data` VALUES (1,'Home','Home','Home','City Living at its Finest','','','','home','/','test','',NULL,'/library/apartment-1851201_1920.jpg','/uploads/2018/02/img-5a84e1ff0e4b1.jpg','','','','','','','N',NULL,NULL,1,'A',1,'2016-03-17 11:10:30','2018-02-15 01:27:27',NULL,1,3,0,1,1,'','','','',NULL),(2,'Accommodation','Accommodation','','Accommodation Options at Urban Boutique Hotel','','Suites','Discover more','accommodation','/accommodation','test','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam',NULL,'/library/pexels-photo-276700.jpg','/uploads/2018/02/img-5a727c2dc76e5.jpg','','','','','','','N',NULL,NULL,0,'A',2,'2017-06-12 23:21:07','2018-02-01 02:32:14',NULL,1,3,0,10,1,'','','','/library/hotel-951598_1920.jpg','/uploads/2017/11/img-5a1dfa365ca05.jpg'),(4,'Our Location','Our Location','','Central City Location','','Location','Discover more','location','/location','test','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam',NULL,'/library/pexels-photo-323775.jpg','/uploads/2018/02/img-5a727c3de0561.jpg','','','','','','','N',NULL,NULL,0,'A',4,'2017-06-12 23:22:20','2018-02-01 02:32:31',NULL,1,3,0,20,1,'','','','/library/restaurant-building-urban-architecture-78086.jpg','/uploads/2017/11/img-5a1dfa83971bd.jpg'),(5,'About','About','','About Us','','About us','Discover more','about-us','/about-us','','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non',NULL,'/library/pexels-photo-276554.jpg','/uploads/2018/01/img-5a713c54dc8b3.jpg','','','','','','','N',NULL,NULL,0,'A',6,'2017-06-12 23:22:47','2018-01-31 03:47:34',NULL,1,3,0,21,1,'','','','/library/pexels-photo-276651.jpg','/uploads/2017/12/img-5a28759eb9159.jpg'),(6,'Reservations','','','Reservations','','','','reservations','/reservations','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',8,'2017-06-12 23:22:58','2017-11-16 02:06:31',NULL,1,3,0,0,1,'','','','',NULL),(7,'Reviews','Reviews','','What our customers say','','Reviews','Reviews','reviews','/about-us/reviews','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',2,'2017-06-12 23:24:39','2017-12-17 21:55:04',NULL,1,3,0,0,1,'','','','/library/apartment-1851201_1920.jpg','/uploads/2017/12/img-5a36e6fd44f78.jpg'),(8,'Contact','Contact','','Our Contact Details','','','','contact','/contact','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',7,'2017-06-12 23:25:27','2017-12-06 23:59:28',NULL,1,3,0,0,1,'','','','',NULL),(9,'Privacy Policy','','Privacy Policy','Privacy Policy','','','','privacy-policy','/privacy-policy','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',10,'2017-06-12 23:26:02','2018-01-31 23:55:00',NULL,1,3,0,0,1,'','','','',NULL),(10,'Terms & Conditions','','Terms & Conditions','Terms & Conditions','','','','terms-conditions','/terms-conditions','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',9,'2017-06-12 23:26:39','2018-01-26 01:11:03',NULL,1,3,0,0,1,'','','','',NULL),(11,'404 Error page','','','404 Error page','','','','404-error-page','/404-error-page','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',11,'2017-06-12 23:27:19','2017-11-15 21:58:33',NULL,1,3,0,0,1,'','','','',NULL),(12,'The Studio','the studio',NULL,'The Studio',NULL,NULL,NULL,'the-studio','/accommodation/the-studio','','This is a paragraph of text about acommodation options. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet.',NULL,'/library/bedroom-1822410_1920.jpg','/uploads/2017/11/img-5a2070ec017a3.jpg',NULL,'','','','','','N',NULL,NULL,0,'A',1,'2017-06-14 23:01:09','2018-02-18 22:18:42',NULL,1,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(13,'The Loft','The Loft',NULL,'The Loft',NULL,NULL,NULL,'the-loft','/accommodation/the-loft','','This is a paragraph of text about the lodge\'s facilities. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet.',NULL,'/library/hotel-951598_1920.jpg','/uploads/2018/01/img-5a713c3fd63b4.jpg',NULL,'','','','','','N',NULL,NULL,0,'A',2,'2017-06-15 02:54:40','2018-02-15 01:38:39',NULL,1,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(14,'Gallery','Gallery','','Urban Boutique Hotel Photo Gallery','','','','gallery','/gallery','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',5,'2017-06-18 23:55:47','2017-12-04 02:51:04',NULL,1,3,0,0,1,'','','','','/uploads/2017/11/img-5a1df94282440.jpg'),(18,'Blog','Blog','','Blog','','Blog','Blog','blog','/about-us/blog','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',1,'2017-11-10 03:18:39','2017-12-17 21:54:58',NULL,3,3,0,0,1,'','','','/library/apartment-1851201_1920.jpg','/uploads/2017/12/img-5a36e6eb0f8d0.jpg'),(19,'Test Blog Category','Test Blog Category',NULL,'Test Blog Category',NULL,NULL,NULL,'test-category','/category/test-category',NULL,NULL,NULL,'',NULL,NULL,'','','','','','N',NULL,NULL,0,'A',NULL,'2017-11-10 03:25:40','2017-11-15 20:39:34',NULL,3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(20,'Test Blog Post',NULL,NULL,'Test Blog Post',NULL,NULL,NULL,'testblogpost','/post/testblogpost',NULL,'123','<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.</p>\r\n\r\n<p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>\r\n\r\n<p>Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante, mattis eget, gravida vitae, ultricies ac, leo. Integer leo pede, ornare a, lacinia eu, vulputate vel, nisl.</p>','/library/restaurant-building-urban-architecture-78086.jpg','/uploads/2018/01/img-5a713c5d2acff.jpg',NULL,'','','','','','N',NULL,NULL,0,'A',NULL,'2017-11-10 03:26:26','2018-01-31 03:47:42',NULL,3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(22,'Service','Service','','Service','','Service','Discover more','service','/service','','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mollis dapibus arcu, nec consectetur urna imperdiet a. Quisque quis sagittis libero, a pulvinar justo. Aliquam',NULL,'','','','','','','','','N',NULL,NULL,0,'A',3,'2017-11-15 03:51:08','2017-12-06 23:56:08',NULL,3,3,0,0,1,'','','','/library/pexels-photo-276554.jpg','/uploads/2017/11/img-5a1dfa6177250.jpg'),(25,'test post2',NULL,NULL,'test post2',NULL,NULL,NULL,'testpost2','/post/testpost2',NULL,'test','','/library/pexels-photo-271816.jpg','/uploads/2018/02/img-5a727d3285e7a.jpg',NULL,'','','','','','N',NULL,NULL,0,'A',NULL,'2017-11-26 23:12:34','2018-02-01 02:36:34',NULL,3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(31,'test','test','','test','','','','test','/about-us/test','test','',NULL,'','','','','','','','','N',NULL,NULL,0,'D',12,'2017-12-17 21:13:55','2017-12-17 21:15:53','2017-12-17 21:16:04',3,3,0,0,1,'','','','',NULL),(32,'test','test',NULL,'',NULL,NULL,NULL,'2017-12-17-212627','/accommodation/2017-12-17-212627','','',NULL,'',NULL,NULL,'','','','','','N',NULL,NULL,0,'D',NULL,'2017-12-17 21:26:27','2017-12-17 21:26:45','2017-12-17 21:27:11',3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(33,'test','test',NULL,'test',NULL,NULL,NULL,'2017-12-17-212745','/category/2017-12-17-212745',NULL,NULL,NULL,'',NULL,NULL,'','','','','','N',NULL,NULL,0,'A',NULL,'2017-12-17 21:27:45','2017-12-17 21:28:02',NULL,3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(34,'testtest',NULL,NULL,'testtest',NULL,NULL,NULL,'2017-12-17-212822','/post/2017-12-17-212822',NULL,'testtest','<p>testtest</p>','','',NULL,'','','','','','N',NULL,NULL,0,'D',NULL,'2017-12-17 21:28:22','2017-12-17 21:30:02','2018-01-08 00:15:45',3,4,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(35,'test','test','','test','','','','test','/test','test','',NULL,'','','','','','','','','N',NULL,NULL,0,'D',0,'2017-12-17 21:59:57','2017-12-17 22:00:36','2017-12-17 22:01:24',3,3,0,0,1,'','','','',NULL),(36,'TEST','TEST',NULL,'TEST',NULL,NULL,NULL,'2017-12-17-220325','/accommodation/2017-12-17-220325','TEST','',NULL,'',NULL,NULL,'','','','','','N',NULL,NULL,0,'D',NULL,'2017-12-17 22:03:25','2017-12-17 22:03:40','2017-12-17 22:04:28',3,3,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(37,'Untitled category',NULL,NULL,NULL,NULL,NULL,NULL,'2017-12-17 22:04:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N',NULL,NULL,0,'H',NULL,'2017-12-17 22:04:49','2017-12-17 22:04:49',NULL,3,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(38,'Payments','','','Payments','','','','payments','/payments','','',NULL,'','','','Payments','','','','','N',NULL,NULL,0,'A',0,'2018-01-22 21:57:55','2018-01-22 21:58:13',NULL,3,3,0,0,1,'','','','',NULL),(39,'Untitled',NULL,NULL,NULL,NULL,NULL,NULL,'2018-02-15 01:13:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N',NULL,NULL,0,'H',0,'2018-02-15 01:13:46','2018-02-15 01:13:46',NULL,3,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(40,'Compendium','','','Compendium','','','','compendium','/compendium','','',NULL,'','','','','','','','','N',NULL,NULL,0,'A',12,'2018-02-15 01:20:33','2018-02-15 01:27:33',NULL,3,3,0,0,1,'','','','',NULL);
/*!40000 ALTER TABLE `page_meta_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_meta_index`
--

DROP TABLE IF EXISTS `page_meta_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_meta_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_meta_index`
--

LOCK TABLES `page_meta_index` WRITE;
/*!40000 ALTER TABLE `page_meta_index` DISABLE KEYS */;
INSERT INTO `page_meta_index` VALUES (1,'Index and Follow (Default)','all','Use this if you want to let search engines do their normal job.'),(2,'Do not Index or Follow','none','This is for sections of a site that shouldn\'t be indexed and shouldn\'t have links followed.'),(3,'Follow, but do not Index','noindex, follow','Search engine robots can follow any links on this page but will not include this page.'),(4,'Index but do not Follow','index, nofollow','Search engine robots should include this page but not follow any links on this page.'),(5,'Do not archive','noarchive','Useful if the content changes frequently: headlines, auctions, etc. The search engine still archives the information, but won\'t show it in the results.');
/*!40000 ALTER TABLE `page_meta_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_logos`
--

DROP TABLE IF EXISTS `partner_logos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_logos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_label` varchar(10) DEFAULT NULL,
  `url_label` varchar(100) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_active` enum('N','Y') DEFAULT 'Y',
  `rank` int(11) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_logos`
--

LOCK TABLES `partner_logos` WRITE;
/*!40000 ALTER TABLE `partner_logos` DISABLE KEYS */;
INSERT INTO `partner_logos` VALUES (1,'Logo1','Url1','/library/urban-p1.png','http://test.com','Y',1,'Partner logo 1'),(2,'Logo2','Url2','/library/urban-p2.png','http://test.com','Y',2,'Partner logo 2'),(3,'Logo3','Url3','/library/urban-p3.png','http://test.com','Y',3,'Partner logo 3');
/*!40000 ALTER TABLE `partner_logos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_path` varchar(255) DEFAULT NULL COMMENT 'URL to the slide-image relative to the public_html folder (recommended). ',
  `thumb_path` varchar(255) DEFAULT NULL,
  `caption_heading` varchar(255) DEFAULT NULL,
  `caption` longtext,
  `alt_text` varchar(255) DEFAULT NULL,
  `button_label` varchar(30) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `width` smallint(6) NOT NULL,
  `height` smallint(6) NOT NULL,
  `type` enum('N','P') NOT NULL DEFAULT 'N',
  `rank` int(11) DEFAULT NULL COMMENT 'Heirarchy/Order for the slides (lower is greater)',
  `photo_group_id` int(11) DEFAULT NULL COMMENT 'Foreign Key to the slideshow group for this slide',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `is_group` (`photo_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=433 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (420,'/library/pexels-photo-280209.jpg','/uploads/2017/12/img-5a25b02d71114.jpg',NULL,'','',NULL,NULL,2398,1599,'N',0,19,''),(400,'/library/pexels-photo-271624.jpg','/uploads/2017/12/img-5a25ac5c98c01.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,18,''),(401,'/library/apartment-1851201_1920.jpg','/uploads/2017/12/img-5a25ac5d6799d.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,18,''),(402,'/library/architecture-563614_1920.jpg','/uploads/2017/12/img-5a25ac5d881d6.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,18,''),(403,'/library/bedroom-1822410_1920.jpg','/uploads/2017/12/img-5a25ac5da0524.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,18,''),(404,'/library/hotel-951598_1920.jpg','/uploads/2017/12/img-5a25ac5dba74f.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,18,''),(419,'/library/restaurant-building-urban-architecture-78086.jpg','/uploads/2017/12/img-5a25b02cab79a.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,19,''),(398,'/library/kitchen-2400367_1920.jpg','/uploads/2017/12/img-5a25abdc18295.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,17,''),(394,'/library/living-room-2155376_1920.jpg','/uploads/2017/12/img-5a25abdba3314.jpg',NULL,'','',NULL,NULL,1500,1000,'N',1,17,''),(397,'/library/bedroom-1822410_1920.jpg','/uploads/2017/12/img-5a25abdbf2391.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,17,''),(396,'/library/architecture-563614_1920.jpg','/uploads/2017/12/img-5a25abdbda0aa.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,17,''),(376,'/library/pexels-photo-276700.jpg',NULL,'','Superior Quality Accommodation','',NULL,NULL,1500,1000,'N',0,10,NULL),(395,'/library/terrace-2199640_1920.jpg','/uploads/2017/12/img-5a25abdbbf25e.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,17,''),(377,'/library/bedroom-1822410_1920.jpg',NULL,'','Self-contained Studio Living','',NULL,NULL,1500,1000,'N',0,15,NULL),(427,'/library/pexels-photo-453201.jpg',NULL,'','Central City Boutique Hotel','',NULL,NULL,5725,3512,'N',0,1,NULL),(425,'/library/kitchen-2400367_1920.jpg','/uploads/2017/12/img-5a25d25ee010e.jpg',NULL,'5','',NULL,NULL,1920,1279,'N',5,16,''),(422,'/library/architecture-563614_1920.jpg','/uploads/2017/12/img-5a25d25e914af.jpg',NULL,'2','',NULL,NULL,1920,1104,'N',2,16,''),(423,'/library/bedroom-1822410_1920.jpg','/uploads/2017/12/img-5a25d25eaa50f.jpg',NULL,'3','',NULL,NULL,1920,1273,'N',3,16,''),(424,'/library/hotel-951598_1920.jpg','/uploads/2017/12/img-5a25d25ec54c5.jpg',NULL,'4','',NULL,NULL,1920,1281,'N',4,16,''),(421,'/library/apartment-1851201_1920.jpg','/uploads/2017/12/img-5a25d25e743a3.jpg',NULL,'1','',NULL,NULL,1920,1275,'N',1,16,''),(417,'/library/pexels-photo-276651.jpg','/uploads/2017/12/img-5a25b02bd61a9.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,19,''),(418,'/library/terrace-2199640_1920.jpg','/uploads/2017/12/img-5a25b02c911c5.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,19,''),(416,'/library/apartment-1851201_1920.jpg','/uploads/2017/12/img-5a25b02bb9417.jpg',NULL,'','',NULL,NULL,1500,1000,'N',0,19,''),(426,'/library/terrace-2199640_1920.jpg','/uploads/2017/12/img-5a25d25f07e9f.jpg',NULL,'','',NULL,NULL,1920,1280,'N',0,16,''),(428,'/library/terrace-2199640_1920.jpg',NULL,'','Central City Boutique Hotel','',NULL,NULL,1920,1280,'N',0,1,NULL),(429,'/library/restaurant-building-urban-architecture-78086.jpg',NULL,'','In the Heart of the City','',NULL,NULL,5174,2910,'N',0,20,NULL),(430,'/library/pexels-photo-271816.jpg',NULL,'','In the Heart of the City','',NULL,NULL,1920,1080,'N',0,21,NULL);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_group`
--

DROP TABLE IF EXISTS `photo_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for the slideshow/gallery group',
  `name` varchar(255) NOT NULL,
  `menu_label` varchar(255) DEFAULT NULL,
  `type` enum('C','G','S') NOT NULL DEFAULT 'S' COMMENT 'C - Carousel, G - Gallery, S - Slideshow(Default)',
  `show_in_cms` enum('N','Y') NOT NULL DEFAULT 'Y',
  `show_on_gallery_page` enum('N','Y') NOT NULL DEFAULT 'N',
  `rank` int(11) NOT NULL DEFAULT '0',
  `Auto_rotate` enum('N','Y') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_group`
--

LOCK TABLES `photo_group` WRITE;
/*!40000 ALTER TABLE `photo_group` DISABLE KEYS */;
INSERT INTO `photo_group` VALUES (1,'Home Page Slideshow',NULL,'S','Y','N',0,NULL),(18,'food & beverage','food & beverage','G','Y','Y',3,NULL),(17,'Facilities','Facilities','G','Y','Y',2,NULL),(16,'Accommodation','Accommodation','G','Y','Y',1,NULL),(15,'The Studio',NULL,'S','Y','N',0,NULL),(10,'Accommodation sildeshow',NULL,'S','Y','N',0,NULL),(19,'location','location','G','Y','Y',4,NULL),(20,'location',NULL,'S','Y','N',0,NULL),(21,'About us',NULL,'S','Y','N',0,NULL);
/*!40000 ALTER TABLE `photo_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_account`
--

DROP TABLE IF EXISTS `pmt_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `user` varchar(255) NOT NULL,
  `api_key` text NOT NULL,
  `logo_path` varchar(150) DEFAULT NULL,
  `is_live` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'N - No, Y - Yes',
  `has_cc` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT 'N - No, Y - Yes',
  `type` enum('dps','paypal') NOT NULL DEFAULT 'dps',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_account`
--

LOCK TABLES `pmt_account` WRITE;
/*!40000 ALTER TABLE `pmt_account` DISABLE KEYS */;
INSERT INTO `pmt_account` VALUES (1,'DPS','Tomahawk_Dev','9d11e64e5f26792355ac0e16739a2bbc3d1818a14e4f165c2e307b0b8b117aa0','/graphics/dps-logo.png','N','Y','dps'),(2,'PayPal','ameyaaklekar-facilitator@gmail.com','67gxI27ABjGCqyQ7Z8rv-QP6zbvFvuHPfrsAUa4Y3Z9S63P1nbw5iFfjUUK','/graphics/paypal-logo.png','N','N','paypal'),(3,'DPS','','','/graphics/dps-logo.png','Y','Y','dps'),(4,'PayPal','','','/graphics/paypal-logo.png','Y','N','paypal');
/*!40000 ALTER TABLE `pmt_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_account_has_pmt_credit_card`
--

DROP TABLE IF EXISTS `pmt_account_has_pmt_credit_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_account_has_pmt_credit_card` (
  `pmt_account_id` int(11) NOT NULL,
  `pmt_credit_card_id` int(11) NOT NULL,
  PRIMARY KEY (`pmt_account_id`,`pmt_credit_card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_account_has_pmt_credit_card`
--

LOCK TABLES `pmt_account_has_pmt_credit_card` WRITE;
/*!40000 ALTER TABLE `pmt_account_has_pmt_credit_card` DISABLE KEYS */;
INSERT INTO `pmt_account_has_pmt_credit_card` VALUES (1,1),(1,2),(3,1),(3,2);
/*!40000 ALTER TABLE `pmt_account_has_pmt_credit_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_credit_card`
--

DROP TABLE IF EXISTS `pmt_credit_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_credit_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_credit_card`
--

LOCK TABLES `pmt_credit_card` WRITE;
/*!40000 ALTER TABLE `pmt_credit_card` DISABLE KEYS */;
INSERT INTO `pmt_credit_card` VALUES (1,'Visa','/graphics/credit-cards/visa.png'),(2,'MasterCard','/graphics/credit-cards/master-card.png'),(3,'American Express','/graphics/credit-cards/amex.png'),(4,'Diners Club','/graphics/credit-cards/diners.png');
/*!40000 ALTER TABLE `pmt_credit_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_history_status`
--

DROP TABLE IF EXISTS `pmt_history_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_history_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_name` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_history_status`
--

LOCK TABLES `pmt_history_status` WRITE;
/*!40000 ALTER TABLE `pmt_history_status` DISABLE KEYS */;
INSERT INTO `pmt_history_status` VALUES (1,'New','The request was created.'),(2,'Viewed','The request has been viewed by the client.'),(3,'Success','The client paid the request amount through'),(4,'Notify Admin Success','A notification email was sent successfully to you, informing you that a payment was made.'),(5,'Notify Client Success','A notification email was sent successfully to the client, regarding their payment transaction.\n'),(6,'Declined','Client payment attempt was unsuccessful.'),(7,'Sent','The request was sent successfully to the client.'),(8,'Notify Admin Fail','A notification email was sent successfully to you, informing you that a payment was declined.');
/*!40000 ALTER TABLE `pmt_history_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_message`
--

DROP TABLE IF EXISTS `pmt_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(60) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_name` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_message`
--

LOCK TABLES `pmt_message` WRITE;
/*!40000 ALTER TABLE `pmt_message` DISABLE KEYS */;
INSERT INTO `pmt_message` VALUES (1,'New','A newly created request.'),(2,'Viewed by client.','The request has been viewed by the client.'),(3,'Accepted by merchant','Payment Accepted. Your request has been processed through Direct Payment Solutions, and payment was accepted.'),(4,'Declined by merchant','Payment Declined. The request has been processed through Direct Payment Solutions, but the payment was declined. Please try again.'),(5,'Cancelled by client','The client cancelled the request.'),(6,'Deleted','The request has been deleted.'),(7,'Sent','Your request was sent successfully.');
/*!40000 ALTER TABLE `pmt_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_payer`
--

DROP TABLE IF EXISTS `pmt_payer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_payer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_payer`
--

LOCK TABLES `pmt_payer` WRITE;
/*!40000 ALTER TABLE `pmt_payer` DISABLE KEYS */;
INSERT INTO `pmt_payer` VALUES (56,'Q','K','Q K','ian@tomahawk.co.nz');
/*!40000 ALTER TABLE `pmt_payer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_request`
--

DROP TABLE IF EXISTS `pmt_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public_token` varchar(15) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('A','C','D','N','P') DEFAULT 'N' COMMENT 'A - Approved, C - Canceled, D - Declined, N - New, P - Pending',
  `cms_status` enum('A','D') NOT NULL DEFAULT 'A' COMMENT 'A - Active, D - Deleted',
  `reference` varchar(100) DEFAULT NULL,
  `request_url` varchar(255) DEFAULT NULL,
  `email_sent` enum('N','Y') NOT NULL DEFAULT 'N',
  `email_subject` varchar(150) DEFAULT NULL,
  `email_content` text,
  `comments` text,
  `created_on` datetime DEFAULT NULL,
  `approved_on` datetime DEFAULT NULL,
  `declined_on` datetime DEFAULT NULL,
  `pmt_payer_id` int(11) NOT NULL,
  `email_template_id` int(11) NOT NULL,
  `payment_type` enum('F','P') NOT NULL DEFAULT 'F',
  `pmt_transaction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pmt_request_pmt_transaction_idx` (`pmt_transaction_id`),
  KEY `fk_pmt_payer1_idx` (`pmt_payer_id`),
  KEY `email_template_id` (`email_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_request`
--

LOCK TABLES `pmt_request` WRITE;
/*!40000 ALTER TABLE `pmt_request` DISABLE KEYS */;
INSERT INTO `pmt_request` VALUES (43,'die46ljsbua0cfa',1.00,'P','A','TEST','https://urban.netzone.nz/payments/?pid=die46ljsbua0cfa','N','Payment Details','<p>Dear Q K,</p>\r\n\r\n<p>&nbsp;NZ$1</p>\r\n\r\n<p><a href=\"https://urban.netzone.nz/payments/?pid=die46ljsbua0cfa\" target=\"_blank\">https://urban.netzone.nz/payments/?pid=die46ljsbua0cfa</a></p>',NULL,'2018-01-22 21:58:53',NULL,NULL,56,4,'F',56);
/*!40000 ALTER TABLE `pmt_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_request_history`
--

DROP TABLE IF EXISTS `pmt_request_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_request_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `label` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `pmt_request_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pmt_request_id` (`pmt_request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_request_history`
--

LOCK TABLES `pmt_request_history` WRITE;
/*!40000 ALTER TABLE `pmt_request_history` DISABLE KEYS */;
INSERT INTO `pmt_request_history` VALUES (251,'2018-01-22 21:58:53','NEW','The request was created.',43),(252,'2018-01-22 21:58:53','SENT','The request was sent successfully to the client.',43),(253,'2018-01-22 21:59:20','VIEWED','The request has been viewed by the client.',43),(254,'2018-01-26 00:39:26','VIEWED','The request has been viewed by the client.',43);
/*!40000 ALTER TABLE `pmt_request_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_settings`
--

DROP TABLE IF EXISTS `pmt_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encryption_key` varchar(40) NOT NULL,
  `notification_email_address` varchar(255) DEFAULT NULL,
  `terms_and_conditions` text,
  `success_message` text,
  `fail_message` text,
  `success_email_body` text,
  `fail_email_body` text,
  `processed_message` text,
  `payment_type` enum('F','P') NOT NULL DEFAULT 'F' COMMENT 'F: Full payment. P: pre-auth payment',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_settings`
--

LOCK TABLES `pmt_settings` WRITE;
/*!40000 ALTER TABLE `pmt_settings` DISABLE KEYS */;
INSERT INTO `pmt_settings` VALUES (1,'aafd03ccdce3520545c5f1c5599f6e60','ian@tomahawk.co.nz','<p><strong>Payment &ndash; </strong>A deposit of 25% of the total cost of your booking plus full payment of the itinerary planning fee is required once your bookings have been confirmed. The balance is then payable 42 days prior to the first day of your New Zealand itinerary. If a booking is made within 42 days of the first day of your New Zealand itinerary, full payment is required at the time of booking confirmation.</p>\r\n\r\n<p>Payments can either be made by credit card via the secure server on our web site or by direct crediting our bank account. Please be aware that for if you wish to make your payment by either Visa or MasterCard a 1.5% credit card fee will be applicable. If you would prefer to make your payment by American Express a 2.5% credit card fee will be applicable.</p>\r\n\r\n<p>Alternatively, you can choose to pay by direct credit into our bank account. We will absorb the cost of the deposit into our bank account; however any applicable fees charged by your bank will be your responsibility.</p>\r\n\r\n<p><strong>Cancellations Charges &ndash; </strong>If you have to cancel all, or part of your holiday for any reason, the following cancellation fees are applicable. For cancellation more than 30 days prior to your arrival in New Zealand: 25% (deposit amount); 8-30 days prior to your arrival: 40%; 7 days or less: 100%.<br />\r\nImportant note - Experience New Zealand Travel recommends that you obtain personal travel insurance to cover any cancellation of part or all of your holiday.</p>\r\n\r\n<p><strong>Amendment Fee:</strong> An amendment fee of NZ$20 per amendment will apply when a confirmed booking is changed.</p>\r\n\r\n<p><strong>ENZTL Responsibilities </strong>- ENZTL operate the experiencenz.com web site as agents for the owner/operators identified in the web site. Whilst we have visited (and do visit on a regular basis) all of the properties on the web site, we are not responsible for the individual properties. We are not liable for any loss or damage caused by any failure or improper performance by any of the owner/operators. However, in the event that a owner/operator cannot provide you with contracted accommodation, we will use our best endeavours to provide you with alternative accommodation, but otherwise we shall have no liability to you.</p>','<p><span style=\"font-size: 26px;\"><strong>Payment Success!</strong></span></p>\r\n\r\n<p>Your payment request was processed successfully. A confirmation email has been sent to <u>{email_address}</u></p>\r\n\r\n<p>Thank you for your booking.</p>','<p><span style=\"font-size: 26px;\"><strong>Payment Failed</strong></span></p>\r\n\r\n<p>Unfortunately, your payment was not processed.<br />\r\nThe response from your bank was <strong>{response_text}</strong>.</p>\r\n\r\n<p>Please check your email as you&#39;ll be emailed a new link to try again.</p>','<p><strong>Dear&nbsp;{full_name},</strong></p>\r\n\r\n<p>Thank you for making payment for our request on&nbsp;{request_date}.</p>\r\n\r\n<p>The amount of {currency_symbol}{amount} was successfully transferred to our bank account.</p>\r\n\r\n<p><strong>Date requested:</strong>&nbsp;{request_date}<br />\r\n<strong>Requested by:</strong>&nbsp;{from_name}<br />\r\n<strong>Amount:</strong>&nbsp;{currency_symbol}{amount}<br />\r\n<strong>Payment date:</strong>&nbsp;{payment_date}</p>\r\n\r\n<p><strong>Payment SUCCESSFUL</strong></p>\r\n\r\n<p>Please keep this email for your records.</p>\r\n\r\n<p>If you have any further queries, please contact us.</p>\r\n\r\n<p>Kind regards,<br />\r\n{from_name}</p>','<p><strong>Dear&nbsp;{full_name},</strong></p>\r\n\r\n<p>Thank you for visiting our payment page and trying to make payment. Unfortunately the payment was declined.</p>\r\n\r\n<p>Amount of {currency_symbol}{amount} &nbsp;is still withstanding.</p>\r\n\r\n<p><strong>Date requested:</strong>&nbsp;{request_date}<br />\r\n<strong>Requested by:</strong>&nbsp;{from_name}<br />\r\n<strong>Amount:</strong>&nbsp;{currency_symbol}{amount}<br />\r\n<strong>Payment date:</strong>&nbsp;{payment_date}</p>\r\n\r\n<p><strong>Payment FAILED</strong></p>\r\n\r\n<p>To re-process payment, please visit this link:</p>\r\n\r\n<p><a href=\"{payment_url}\">{payment_url}</a></p>\r\n\r\n<p>If you have any issues with payment, please contact us.</p>\r\n\r\n<p>Kind regards,<br />\r\n{from_name}</p>','<p><span style=\"font-size: 26px;\"><strong>Payment Transaction Already Processed</strong></span></p>\r\n\r\n<p>The payment request you tried to process has already been processed.</p>\r\n\r\n<p>You&#39;re seeing this page because the transaction request you tried to process has previously been completed successfully or canceled.&nbsp;</p>','P');
/*!40000 ALTER TABLE `pmt_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_template`
--

DROP TABLE IF EXISTS `pmt_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_email_address` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text,
  `logo_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_template`
--

LOCK TABLES `pmt_template` WRITE;
/*!40000 ALTER TABLE `pmt_template` DISABLE KEYS */;
INSERT INTO `pmt_template` VALUES (1,'Template 4','','','','','<p>Dear {first_name} {last_name},</p>\r\n\r\n<p>{payment_link}</p>\r\n\r\n<p>&nbsp;</p>','/graphics/logo-sm.png'),(2,'Template 3','','','','','<p>Dear {full_name},</p>\r\n\r\n<p><br />\r\nNZ${payment_amount}&nbsp;&nbsp;</p>\r\n\r\n<p><br />\r\n{payment_link}</p>\r\n\r\n<p>&nbsp;</p>','/graphics/logo-sm.png'),(3,'Template 2','','','','Payment link','<p>Dear {first_name} {last_name},</p>\r\n\r\n<p>{payment_link}</p>\r\n\r\n<p>&nbsp;</p>','/graphics/logo-drivingnz.png'),(4,'Template 1','','','','Payment Details','<p>Dear {full_name},</p>\r\n\r\n<p>&nbsp;NZ${payment_amount}</p>\r\n\r\n<p>{payment_link}</p>','/graphics/logo-drivingnz.png');
/*!40000 ALTER TABLE `pmt_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_template_tag`
--

DROP TABLE IF EXISTS `pmt_template_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_template_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_template_tag`
--

LOCK TABLES `pmt_template_tag` WRITE;
/*!40000 ALTER TABLE `pmt_template_tag` DISABLE KEYS */;
INSERT INTO `pmt_template_tag` VALUES (1,'First Name','first_name','Recipient\'s first name.'),(2,'Last Name','last_name','Recipient\'s last name.'),(3,'Full Name','full_name','Recipient\'s full name.'),(4,'Payment Amount','payment_amount','Amount of the payment request.'),(5,'Payment_Link','payment_link','Link to the payment page.'),(6,'Currency Symbol','currency_symbol','Currency Symbol displayed before any amount');
/*!40000 ALTER TABLE `pmt_template_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pmt_transaction`
--

DROP TABLE IF EXISTS `pmt_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmt_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount_settlement` decimal(10,2) DEFAULT '0.00',
  `auth_code` varchar(250) DEFAULT NULL,
  `cc_name` varchar(250) DEFAULT NULL,
  `cc_holder_name` varchar(250) DEFAULT NULL,
  `cc_number` varchar(200) DEFAULT NULL,
  `cc_date_expire` varchar(100) DEFAULT NULL,
  `dps_billing_id` varchar(20) DEFAULT NULL,
  `dps_ref` varchar(200) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `data1` varchar(250) DEFAULT NULL,
  `paypal_payer_id` varchar(50) DEFAULT NULL,
  `paypal_payer_status` varchar(50) DEFAULT NULL,
  `currency_settlement` varchar(100) DEFAULT 'NZD',
  `client_ip` varchar(150) DEFAULT NULL,
  `txn_id` varchar(50) DEFAULT NULL,
  `currency_input` varchar(100) DEFAULT NULL,
  `merchant_ref` varchar(255) DEFAULT NULL,
  `response_text` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `response_url` mediumtext NOT NULL,
  `date_processsed` datetime DEFAULT NULL,
  `pmt_account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pmt_transaction`
--

LOCK TABLES `pmt_transaction` WRITE;
/*!40000 ALTER TABLE `pmt_transaction` DISABLE KEYS */;
INSERT INTO `pmt_transaction` VALUES (56,1.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,'NZD',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,0);
/*!40000 ALTER TABLE `pmt_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redirect`
--

DROP TABLE IF EXISTS `redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_url` longtext NOT NULL,
  `new_url` longtext NOT NULL,
  `status_code` int(11) NOT NULL,
  `status` enum('A','H','D') NOT NULL DEFAULT 'H',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redirect`
--

LOCK TABLES `redirect` WRITE;
/*!40000 ALTER TABLE `redirect` DISABLE KEYS */;
INSERT INTO `redirect` VALUES (1,'http://www.maramavineyard.com/vineyard','http://www.maramavineyard.com/gallery',301,'D');
/*!40000 ALTER TABLE `redirect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `icon_path` varchar(255) DEFAULT NULL,
  `second_icon_path` varchar(255) DEFAULT NULL,
  `icon_alt` varchar(255) DEFAULT NULL,
  `widget_blob` mediumtext,
  `placement` enum('L','R') DEFAULT 'L',
  `use_icon` enum('0','1') DEFAULT '0',
  `icon_cls` varchar(255) DEFAULT NULL,
  `element_class` varchar(100) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `has_widget` enum('0','1') DEFAULT '0',
  `is_external` enum('0','1') DEFAULT '0',
  `is_active` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (1,'Facebook','https://www.facebook.com/TomahawkTourism','Join us on Facebook','/themes/global/graphics/social-icons/icon-facebook.png',NULL,'Join us on Facebook',NULL,'L','1','fa fa-facebook',NULL,1,'0','1','1'),(2,'Instagram','https://www.instagram.com/?hl=en','Follow us on Instagram','/themes/global/graphics/social-icons/icon-instagram.png',NULL,'Follow us on Instagram',NULL,'L','1','fa fa-instagram',NULL,2,'0','1','1'),(3,'Twitter','https://twitter.com/?lang=en','Follow us on Twitter','/themes/global/graphics/social-icons/icon-twitter.png',NULL,'Follow us on Twitter',NULL,'L','1','fa fa-twitter',NULL,4,'0','1','1'),(4,'Youtube','https://www.youtube.com','Join us on Youtube','/themes/global/graphics/social-icons/icon-youtube.png',NULL,'Join us on Youtube',NULL,'L','1','fa fa-youtube',NULL,3,'0','1','1'),(5,'Google+','https://plus.google.com/discover','Join us on Google+','/themes/global/graphics/social-icons/icon-googleplus.png',NULL,'Join us on Google+',NULL,'L','1','fa fa-google-plus',NULL,5,'0','1','1'),(6,'Pinterest','https://www.pinterest.nz/','Join us on Pinterest','/themes/global/graphics/social-icons/icon-pinterest.png',NULL,'Join us on Pinterest',NULL,'L','1','fa fa-pinterest-p',NULL,6,'0','1','1');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates_normal`
--

DROP TABLE IF EXISTS `templates_normal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates_normal` (
  `tmpl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for template',
  `tmpl_name` varchar(100) DEFAULT NULL COMMENT 'Template name',
  `tmpl_path` varchar(100) DEFAULT NULL COMMENT 'Template URL (i.e. ''default'', ''shop'', ''googlemap'' etc). It is recommended that you leave the extension up to the application/code.',
  `tmpl_previewimg` varchar(100) DEFAULT NULL,
  `tmpl_nummoduletags` int(11) NOT NULL DEFAULT '0',
  `tmpl_showincms` varchar(1) NOT NULL DEFAULT 'Y',
  `tmpl_mobile` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`tmpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates_normal`
--

LOCK TABLES `templates_normal` WRITE;
/*!40000 ALTER TABLE `templates_normal` DISABLE KEYS */;
INSERT INTO `templates_normal` VALUES (1,'Default','index.html',NULL,0,'Y',NULL),(2,'Compendium','compendium.html',NULL,0,'Y',NULL);
/*!40000 ALTER TABLE `templates_normal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonial`
--

DROP TABLE IF EXISTS `testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key for the testimonial',
  `person` varchar(100) DEFAULT NULL COMMENT 'Who represents this testimonial',
  `company` varchar(100) NOT NULL,
  `detail` longtext COMMENT 'The testimonial itself',
  `status` enum('A','D','H') DEFAULT 'H' COMMENT 'Boolean for whether or not the current testimonial should be displayed. (0 = off, 1=on)',
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial`
--

LOCK TABLES `testimonial` WRITE;
/*!40000 ALTER TABLE `testimonial` DISABLE KEYS */;
INSERT INTO `testimonial` VALUES (10,'The Snow Family','','We absolutely loved every minute of our stay at Urban Boutique Hotel and\r\nlook forward to our return vacation next year!','A',1),(11,'The Rain Family','','We absolutely loved every minute of our stay at Urban Boutique Hotel and look forward to our return vacation next year!','A',0),(12,'Test person 3','','Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.','D',0),(13,'test','','test','D',0);
/*!40000 ALTER TABLE `testimonial` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-19 11:25:56
