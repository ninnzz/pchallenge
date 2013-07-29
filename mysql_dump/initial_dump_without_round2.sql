-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pchallenge
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.13.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `uname` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `scope` enum('all','encoder','mod','mc') DEFAULT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','7cd99475e3a278c8584641484ddd6aeb','all'),('encoder','e7d77a94ff18fa23e9fc89e710ff2660','encoder'),('ninz','84410e60ebe48d90ee0caa7df6179e08','encoder'),('ninz2','c9449408bb95f549503fa92de5550a4c','mod');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answered_round1`
--

DROP TABLE IF EXISTS `answered_round1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answered_round1` (
  `q_number` int(11) NOT NULL,
  `team_id` varchar(32) NOT NULL,
  `is_fast_round` tinyint(1) DEFAULT NULL,
  `answered_time` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answered_round1`
--

LOCK TABLES `answered_round1` WRITE;
/*!40000 ALTER TABLE `answered_round1` DISABLE KEYS */;
/*!40000 ALTER TABLE `answered_round1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_config`
--

DROP TABLE IF EXISTS `app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_config` (
  `app_state` enum('round_1','round_1m','round_2','paused','pre','stopped') DEFAULT NULL,
  `current_question_round2` int(11) DEFAULT NULL,
  `r2_state` enum('init','preview','badge','bet','show_question','timer','show_answer','scores') DEFAULT NULL,
  `round1_question_count` int(11) DEFAULT NULL,
  `badge_count` int(11) DEFAULT NULL,
  `round1_timer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_config`
--

LOCK TABLES `app_config` WRITE;
/*!40000 ALTER TABLE `app_config` DISABLE KEYS */;
INSERT INTO `app_config` VALUES ('pre',0,'init',50,4,45);
/*!40000 ALTER TABLE `app_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_round1`
--

DROP TABLE IF EXISTS `questions_round1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_round1` (
  `q_number` int(11) NOT NULL,
  `q_type` varchar(4) DEFAULT NULL,
  `q_multiplier` double DEFAULT NULL,
  `badge_type` varchar(4) DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_round1`
--

LOCK TABLES `questions_round1` WRITE;
/*!40000 ALTER TABLE `questions_round1` DISABLE KEYS */;
INSERT INTO `questions_round1` VALUES (1,'e',1,'',0),(2,'e',1,'',0),(3,'e',1,'',0),(4,'e',1,'',0),(5,'e',1,'',0),(6,'e',1,'',0),(7,'e',1,'',0),(8,'e',1,'',0),(9,'e',1,'',0),(10,'e',1,'',0),(11,'e',1,'',0),(12,'e',1,'',0),(13,'e',1,'',0),(14,'d',4,'a',20),(15,'e',1,'',0),(16,'e',1,'',0),(17,'e',1,'',0),(18,'e',1,'',0),(19,'e',1,'',0),(20,'e',1,'',0),(21,'e',1,'',0),(22,'e',1,'',0),(23,'e',1,'',0),(24,'e',1,'',0),(25,'e',1,'',0),(26,'e',1,'',0),(27,'e',1,'',0),(28,'e',1,'',0),(29,'e',1,'',0),(30,'e',1,'',0),(31,'e',1,'',0),(32,'e',1,'',0),(33,'e',1,'',0),(34,'e',1,'',0),(35,'e',1,'',0),(36,'e',1,'',0),(37,'e',1,'',0),(38,'e',1,'',0),(39,'e',1,'',0),(40,'e',1,'',0),(41,'e',1,'',0),(42,'e',1,'',0),(43,'e',1,'',0),(44,'e',1,'',0),(45,'e',1,'',0),(46,'e',1,'',0),(47,'e',1,'',0),(48,'e',1,'',0),(49,'e',1,'',0),(50,'e',1,'',0);
/*!40000 ALTER TABLE `questions_round1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `team_id` varchar(32) NOT NULL,
  `team_name` longtext,
  `team_members` longtext,
  `date_created` int(10) NOT NULL,
  `contact` longtext,
  `team_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES ('2d5b2b3d2454b24e20ed42c6b6557465','team1','ninz,ninz1',123456,'0912312333',NULL),('2deb000b57bfac9d72c14d4ed967b572','ads','dassdMember1,Member2.....',123456,'1093123',NULL),('3acccbfe643f865e0d7a37c294b42631','ninaa','asdasdMember1,Member2.....',20130628,'091523123',NULL),('7815696ecbf1c96e6894b779456d330e','asd','dasdMember1,Member2.....',20130628,'assd',NULL),('a04ef6765961f9c637c8b7e9f98d1e64','team32','Member1,Member2.....',20130630,'091523213',NULL),('e51d7e07440a0944369a8734b6a56d2c','The team','ninz,ninz2',123456,'019512313',NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-29 19:51:09
