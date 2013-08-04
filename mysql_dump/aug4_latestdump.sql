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
INSERT INTO `admin` VALUES ('admin','7cd99475e3a278c8584641484ddd6aeb','all'),('eco','e434dd9c7f573fb03924e0c4d3d44d45','encoder'),('encoder','e7d77a94ff18fa23e9fc89e710ff2660','encoder'),('ninz','84410e60ebe48d90ee0caa7df6179e08','encoder'),('ninz2','c9449408bb95f549503fa92de5550a4c','mod');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answered_round1`
--

DROP TABLE IF EXISTS `answered_round1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answered_round1` (
  `q_number` int(10) DEFAULT NULL,
  `team_id` varchar(32) DEFAULT NULL,
  `is_fast_round` tinyint(1) DEFAULT NULL,
  `answered_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answered_round1`
--

LOCK TABLES `answered_round1` WRITE;
/*!40000 ALTER TABLE `answered_round1` DISABLE KEYS */;
INSERT INTO `answered_round1` VALUES (40,'3acccbfe643f865e0d7a37c294b42631',0,1375456305),(42,'3acccbfe643f865e0d7a37c294b42631',0,1375456307),(5,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456623),(14,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456625),(48,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456626),(42,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456627),(44,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456631),(38,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456632),(39,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456633),(28,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456634),(49,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456636),(34,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456637),(12,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456639),(7,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375456640),(38,'e51d7e07440a0944369a8734b6a56d2c',0,1375456643),(37,'2deb000b57bfac9d72c14d4ed967b572',0,1375456651),(39,'2deb000b57bfac9d72c14d4ed967b572',0,1375456652),(41,'2deb000b57bfac9d72c14d4ed967b572',0,1375456653),(40,'2deb000b57bfac9d72c14d4ed967b572',0,1375456654),(22,'2deb000b57bfac9d72c14d4ed967b572',0,1375456654),(42,'2deb000b57bfac9d72c14d4ed967b572',0,1375456655),(3,'a04ef6765961f9c637c8b7e9f98d1e64',0,1375474806),(2,'2d5b2b3d2454b24e20ed42c6b6557465',0,1375501760),(40,'7815696ecbf1c96e6894b779456d330e',0,1375502147),(28,'2deb000b57bfac9d72c14d4ed967b572',0,1375502319),(49,'2deb000b57bfac9d72c14d4ed967b572',0,1375502320),(51,'2deb000b57bfac9d72c14d4ed967b572',0,1375502321),(43,'7815696ecbf1c96e6894b779456d330e',0,1375504592),(45,'7815696ecbf1c96e6894b779456d330e',0,1375504594),(47,'7815696ecbf1c96e6894b779456d330e',0,1375504595),(53,'2deb000b57bfac9d72c14d4ed967b572',1,1375564133);
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
  `round1_timer` int(11) DEFAULT NULL,
  `round2_question_count` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_config`
--

LOCK TABLES `app_config` WRITE;
/*!40000 ALTER TABLE `app_config` DISABLE KEYS */;
INSERT INTO `app_config` VALUES ('round_1',0,'init',53,5,45,20);
/*!40000 ALTER TABLE `app_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `evnt` text,
  `priority` int(10) DEFAULT NULL,
  `date_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES ('Team ads answered question number2(e) worth 0pts',1,1375502316),('Team ads answered question number28(e) worth 0pts',1,1375502319),('Team ads answered question number49(e) worth 0pts',1,1375502320),('Team ads answered question number51(e) worth 0pts',1,1375502321),('Team asd answered question number43(e) worth 0pts',1,1375504592),('Team asd answered question number45(e) worth 0pts',1,1375504594),('Team asd answered question number47(e) worth 0pts',1,1375504595),('Team ads answered question number53(e) worth 7pts',1,1375564133);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
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
INSERT INTO `questions_round1` VALUES (1,'e',1,'',1),(2,'e',1,'',1),(3,'e',1,'',1),(4,'e',1,'',1),(5,'e',1,'',1),(6,'e',1,'',1),(7,'e',1,'',1),(8,'e',1,'',1),(9,'e',1,'',1),(10,'e',1,'',1),(11,'e',1,'',1),(12,'e',1,'',1),(13,'e',1,'',1),(14,'e',1,'',1),(15,'e',1,'',1),(16,'e',1,'',1),(17,'e',1,'',1),(18,'e',1,'m',1),(19,'e',1,'',1),(20,'e',1,'',1),(21,'e',1,'',1),(22,'e',1,'',1),(23,'e',1,'',1),(24,'e',1,'',1),(25,'e',1,'',1),(26,'e',1,'',1),(27,'e',1,'',1),(28,'e',1,'',1),(29,'e',1,'',1),(30,'e',1,'',1),(31,'e',1,'',1),(32,'e',1,'',1),(33,'e',1,'',1),(34,'e',1,'',1),(35,'e',1,'',1),(36,'e',1,'',1),(37,'e',1,'',1),(38,'a',1,'',1),(39,'e',1,'',1),(40,'e',1,'',1),(41,'e',1,'',1),(42,'e',1,'',1),(43,'e',1,'',1),(44,'e',1,'',1),(45,'e',1,'',1),(46,'e',1,'',1),(47,'e',1,'',1),(48,'e',1,'',1),(49,'e',1,'',1),(50,'e',1,'',1),(51,'e',1,'',1),(52,'e',1,'',1),(53,'e',1,'',1);
/*!40000 ALTER TABLE `questions_round1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_round2`
--

DROP TABLE IF EXISTS `questions_round2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_round2` (
  `q_number` int(11) DEFAULT NULL,
  `q_type` enum('easy','average','difficult') DEFAULT NULL,
  `points` int(10) DEFAULT NULL,
  `prev_timer` int(10) DEFAULT NULL,
  `badge_timer` int(10) DEFAULT NULL,
  `bet_timer` int(10) DEFAULT NULL,
  `q_timer` int(10) DEFAULT NULL,
  `body` text,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_round2`
--

LOCK TABLES `questions_round2` WRITE;
/*!40000 ALTER TABLE `questions_round2` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions_round2` ENABLE KEYS */;
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

-- Dump completed on 2013-08-04 10:06:55
