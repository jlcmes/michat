/*CREATE DATABASE  IF NOT EXISTS `michat` /*!40100 DEFAULT CHARACTER SET latin1 */;
/*USE `michat`;*/
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
-- Table structure for table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendship` (
  `f_id` int(15) NOT NULL AUTO_INCREMENT,
  `f_source_user_id` int(11) NOT NULL,
  `f_target_user_id` int(11) NOT NULL,
  `f_accepted` tinyint(1) DEFAULT '1',
  `f_mutual` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`f_id`),
  KEY `f_FK_sourceUser_idx` (`f_source_user_id`),
  KEY `f_FK_targetUser_idx` (`f_target_user_id`),
  CONSTRAINT `f_FK_sourceUser` FOREIGN KEY (`f_source_user_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `f_FK_targetUser` FOREIGN KEY (`f_target_user_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendship`
--

LOCK TABLES `friendship` WRITE;
/*!40000 ALTER TABLE `friendship` DISABLE KEYS */;
INSERT INTO `friendship` VALUES (1,1,2,1,1),(2,3,1,0,0);
/*!40000 ALTER TABLE `friendship` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` VALUES (1,'Hi!','2014-03-14 18:38:00',1,2,0),(2,'How are you?','2014-03-14 19:08:00',2,1,0),(3,'Goodbye','2014-03-14 19:30:00',1,2,0),(4,'From 1 to 3','2014-03-15 09:00:00',1,3,0),(5,'From 3 to 1','2014-03-15 08:45:00',3,1,0),(6,'From 2 to 3','2014-03-15 08:30:00',2,3,0),(7,'From 4 to 1','2014-03-16 00:07:00',4,1,0),(8,'from 1 to 4 again','2014-03-16 00:17:00',1,4,0),(9,'From 4 to 1 (Hello!)','2014-03-16 00:20:00',4,1,0),(10,'From admin to user4: Hi Dude!','2014-03-16 11:00:35',5,4,0),(11,'From admin to user4 2','2014-03-16 12:12:00',5,2,0),(12,'Hi user1 from admin','2014-03-16 12:39:18',5,1,0),(13,'From admin to user1 again HELLO!','2014-03-16 12:40:07',5,1,0),(14,'From 1 to 2 !!!!HI!!!!','2014-03-16 12:42:16',1,2,0),(15,'From 1 to 2 HI!!!','2014-03-16 12:45:54',1,2,0),(16,'From 1 to 2 !!!HI AGAIN!!!','2014-03-16 12:46:55',1,2,0),(17,'from 1 to 2: Hi dude! what are you doing?','2014-03-16 12:50:56',1,2,0),(18,'From 1 to 2 Hi Dude! Are you tired?','2014-03-16 12:51:00',1,2,0),(19,'from 1 to user2 a bit tired?','2014-03-16 12:54:17',1,2,0),(20,'From 1 to 2 again not? a little bit?','2014-03-16 12:54:58',1,2,0),(21,'Hi user 3!','2014-03-16 13:01:12',1,3,0),(22,'How are you?','2014-03-16 13:01:25',1,3,0),(23,'Fine?','2014-03-16 13:01:37',1,3,0),(24,'I will go to eat something','2014-03-16 13:01:53',1,3,0),(25,'I like programming, don\'t you?','2014-03-16 13:02:08',1,3,0),(26,'See you soon my friend','2014-03-16 13:02:21',1,3,0),(27,'From 3 to 1 Hi again user 1','2014-03-16 13:17:36',3,1,0),(28,'Hi again ','2014-03-16 13:17:46',3,1,0),(29,'Hi! one more time','2014-03-16 13:17:58',3,1,0),(30,'one more time...','2014-03-16 13:18:37',3,1,0),(31,'Hi!','2014-03-16 13:18:51',3,1,0),(32,'Hi user1, im admin','2014-03-16 15:59:25',5,1,0),(33,'how are you?','2014-03-16 15:59:41',5,1,0),(34,'Fine?','2014-03-16 15:59:47',5,1,0),(35,'hi from user1','2014-03-16 16:21:16',1,2,0),(36,'what are you doing?','2014-03-16 16:21:45',1,2,0),(37,'programming?','2014-03-16 16:21:59',1,2,0),(38,'again?','2014-03-16 16:22:10',1,2,0),(39,'and again?','2014-03-16 16:24:17',1,2,0),(40,'one more time?','2014-03-16 16:32:14',1,2,0),(41,'again dude?','2014-03-16 16:40:29',1,2,0),(42,'again?','2014-03-16 16:40:39',1,2,0),(43,'again?','2014-03-16 16:41:31',1,2,0),(44,'one more time?','2014-03-16 16:42:33',1,2,0),(45,'hi?','2014-03-16 16:43:57',1,2,0),(46,'hello?','2014-03-16 16:44:50',1,2,0),(47,'hi?','2014-03-16 16:45:46',1,2,0),(48,'hi!','2014-03-16 18:54:31',2,1,0),(49,'Hi again!','2014-03-16 19:33:30',5,1,0),(50,'Bonjour!','2014-03-16 20:57:32',5,3,0),(51,'Hi my friend!','2014-03-16 21:21:34',5,1,0),(52,'What are you doing?','2014-03-16 21:21:45',5,1,0),(53,'Please, reply me','2014-03-16 21:21:57',5,1,0),(54,'Hello?','2014-03-16 21:22:07',5,1,0),(55,'Hi!','2014-03-16 21:22:33',5,1,0),(56,'hi?','2014-03-16 21:23:12',5,1,0),(57,'ey?!','2014-03-16 21:23:25',5,1,0),(58,'hi?','2014-03-16 21:24:14',5,1,0),(59,'Hello?','2014-03-16 21:24:22',5,1,0),(60,'Hi!','2014-03-16 22:15:58',5,1,0),(61,'Hi again','2014-03-16 22:24:30',5,1,0),(62,'Hi one more time','2014-03-16 22:26:52',5,1,0),(63,'Hi! Its already working?','2014-03-16 22:28:46',3,1,0),(64,'Please reply me...','2014-03-16 22:30:08',3,1,0),(65,'I think this needs to scroll down when entering the conversation','2014-03-16 22:31:32',1,3,0),(66,'Thanks dude, I will improve that','2014-03-16 22:32:07',3,1,0),(67,'Testing from desktop','2014-03-16 22:38:40',1,3,0),(68,'and here from android','2014-03-16 22:39:37',3,1,0),(69,'hello again!','2014-03-16 22:39:53',1,3,0),(70,'hello!','2014-03-16 22:40:17',1,3,0),(71,'hello','2014-03-16 22:40:41',3,1,0),(72,'it\'s working!','2014-03-16 22:41:26',1,3,0);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(127) NOT NULL,
  `u_password` varchar(256) NOT NULL,
  `u_last_seen` datetime DEFAULT NULL,
  `u_connected` tinyint(1) DEFAULT '0',
  `u_public_profile` tinyint(1) DEFAULT '1' COMMENT 'To store if the user will can be contacted by unknown people.',
  `u_public_key` varchar(8) DEFAULT NULL COMMENT 'Created to store the future public key of the user.',
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_userName_UNIQUE` (`u_username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user1','202cb962ac59075b964b07152d234b70','2014-03-14 18:38:00',0,0,''),(2,'user2','202cb962ac59075b964b07152d234b70','2014-03-14 18:38:00',0,0,''),(3,'user3','202cb962ac59075b964b07152d234b70','2014-03-14 19:08:00',0,0,''),(4,'user4','202cb962ac59075b964b07152d234b70','2014-03-15 00:22:00',0,0,''),(5,'admin','202cb962ac59075b964b07152d234b70','2014-03-15 20:40:00',0,0,'');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-16 23:30:37
