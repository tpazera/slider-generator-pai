-- MySQL dump 10.16  Distrib 10.3.9-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pai
-- ------------------------------------------------------
-- Server version	10.3.9-MariaDB-1:10.3.9+maria~bionic

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
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id_block` int(11) NOT NULL AUTO_INCREMENT,
  `width` int(11) DEFAULT 100,
  `height` int(11) DEFAULT 100,
  `color` varchar(30) DEFAULT '#ffffff',
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z_index` int(11) DEFAULT NULL,
  `id_slide` int(11) NOT NULL,
  PRIMARY KEY (`id_block`),
  UNIQUE KEY `blocks_id_block_uindex` (`id_block`),
  KEY `blocks_slides_id_slide_fk` (`id_slide`),
  CONSTRAINT `blocks_slides_id_slide_fk` FOREIGN KEY (`id_slide`) REFERENCES `slides` (`id_slide`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `roles_id_role_uindex` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin'),(2,'user');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliders` (
  `id_slider` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `height` int(11) DEFAULT 500,
  `speed` int(11) NOT NULL DEFAULT 3000,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_slider`),
  UNIQUE KEY `sliders_id_slider_uindex` (`id_slider`),
  KEY `sliders_users_id_fk` (`id_user`),
  CONSTRAINT `sliders_users_id_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slides` (
  `id_slide` int(11) NOT NULL AUTO_INCREMENT,
  `background_color` varchar(30) DEFAULT '#E97C5F',
  `background_image` varchar(30) DEFAULT NULL,
  `background_size` varchar(30) DEFAULT NULL,
  `id_slider` int(11) NOT NULL,
  PRIMARY KEY (`id_slide`),
  UNIQUE KEY `slides_id_slide_uindex` (`id_slide`),
  KEY `slides_sliders_id_slider_fk` (`id_slider`),
  CONSTRAINT `slides_sliders_id_slider_fk` FOREIGN KEY (`id_slider`) REFERENCES `sliders` (`id_slider`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slides`
--

LOCK TABLES `slides` WRITE;
/*!40000 ALTER TABLE `slides` DISABLE KEYS */;
/*!40000 ALTER TABLE `slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `textblocks`
--

DROP TABLE IF EXISTS `textblocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `textblocks` (
  `id_text` int(11) NOT NULL AUTO_INCREMENT,
  `text` longtext DEFAULT 'Hello world!',
  `z_index` int(11) NOT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `id_slide` int(11) NOT NULL,
  PRIMARY KEY (`id_text`),
  UNIQUE KEY `textblocks_id_text_uindex` (`id_text`),
  KEY `textblocks_slides_id_slide_fk` (`id_slide`),
  CONSTRAINT `textblocks_slides_id_slide_fk` FOREIGN KEY (`id_slide`) REFERENCES `slides` (`id_slide`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `textblocks`
--

LOCK TABLES `textblocks` WRITE;
/*!40000 ALTER TABLE `textblocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `textblocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id_uindex` (`id`),
  UNIQUE KEY `users_email_uindex` (`email`),
  KEY `users_roles_id_role_fk` (`id_role`),
  CONSTRAINT `users_roles_id_role_fk` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Tomasz','Pazera','tomasz@pazera.pl','49aa66843380c377e93b198b966eb699',1),(2,'Adam','Nowak','adam@nowak.pl','49aa66843380c377e93b198b966eb699',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-28 16:12:48
