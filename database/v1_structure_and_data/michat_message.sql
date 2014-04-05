-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: michat
-- ------------------------------------------------------
-- Server version	5.5.24-log

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
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `m_id` int(18) NOT NULL AUTO_INCREMENT COMMENT 'WhatsApp sends and receives daily more than 30Billions of messages. ',
  `m_contents` varchar(127) NOT NULL,
  `m_time_stamp` datetime NOT NULL,
  `m_source_user_id` int(11) NOT NULL,
  `m_source_target_id` int(11) NOT NULL,
  `m_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`m_id`),
  KEY `m_FK_source_idx` (`m_source_user_id`),
  KEY `m_FK_target_idx` (`m_source_target_id`),
  CONSTRAINT `m_FK_source` FOREIGN KEY (`m_source_user_id`) REFERENCES `user` (`u_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `m_FK_target` FOREIGN KEY (`m_source_target_id`) REFERENCES `user` (`u_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,'Hi!','2014-03-14 19:08:00',1,2,0),(2,'How are you','2014-03-14 19:08:00',2,1,0),(3,'Goodbye','2014-03-14 19:08:00',1,2,0),(4,'From 1 to 3','2014-03-15 08:45:00',1,3,0),(5,'From 3 to 1','2014-03-15 08:45:00',3,1,0),(6,'From 2 to 3','2014-03-15 08:45:00',2,3,0);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-15 11:55:55
