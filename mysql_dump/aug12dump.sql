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
INSERT INTO `answered_round1` VALUES (0,'74b87337454200d4d33f80c4663dc5e5',0,20130809),(0,'65ba841e01d6db7733e90a5b7f9e6f80',0,20130809),(2,'74b87337454200d4d33f80c4663dc5e5',0,1376069756),(5,'74b87337454200d4d33f80c4663dc5e5',0,1376070431),(6,'74b87337454200d4d33f80c4663dc5e5',0,1376070431),(8,'74b87337454200d4d33f80c4663dc5e5',0,1376070432),(10,'74b87337454200d4d33f80c4663dc5e5',0,1376070433),(1,'74b87337454200d4d33f80c4663dc5e5',0,1376070445),(3,'74b87337454200d4d33f80c4663dc5e5',0,1376070447),(1,'65ba841e01d6db7733e90a5b7f9e6f80',0,1376070448),(21,'65ba841e01d6db7733e90a5b7f9e6f80',0,1376070449),(39,'65ba841e01d6db7733e90a5b7f9e6f80',0,1376070449);
/*!40000 ALTER TABLE `answered_round1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answered_round2`
--

DROP TABLE IF EXISTS `answered_round2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answered_round2` (
  `q_number` int(10) DEFAULT NULL,
  `team_id` varchar(32) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `bet` int(10) DEFAULT NULL,
  `badge_in_effect` varchar(4) DEFAULT NULL,
  `question_points` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answered_round2`
--

LOCK TABLES `answered_round2` WRITE;
/*!40000 ALTER TABLE `answered_round2` DISABLE KEYS */;
/*!40000 ALTER TABLE `answered_round2` ENABLE KEYS */;
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
INSERT INTO `app_config` VALUES ('pre',0,'init',40,5,45,13);
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
INSERT INTO `events` VALUES ('Team ads answered question number2(e) worth 0pts',1,1375502316),('Team ads answered question number28(e) worth 0pts',1,1375502319),('Team ads answered question number49(e) worth 0pts',1,1375502320),('Team ads answered question number51(e) worth 0pts',1,1375502321),('Team asd answered question number43(e) worth 0pts',1,1375504592),('Team asd answered question number45(e) worth 0pts',1,1375504594),('Team asd answered question number47(e) worth 0pts',1,1375504595),('Team ads answered question number53(e) worth 7pts',1,1375564133),('Team ads answered question number46(e) worth 1pts',1,1375587408),('Team ads answered question number10(e) worth 1pts',1,1375587409),('Team ads answered question number9(e) worth 1pts',1,1375587409),('Team ads answered question number8(e) worth 1pts',1,1375587410),('Team ads answered question number44(e) worth 1pts',1,1375587411),('Team ads answered question number29(e) worth 1pts',1,1375587411),('Team ads answered question number14(e) worth 1pts',1,1375587412),('Team ads answered question number18(e) worth 1pts',1,1375587414),('Team ads answered question number36(e) worth 1pts',1,1375587415),('Team ads answered question number35(e) worth 1pts',1,1375587418),('Team ads answered question number34(e) worth 1pts',1,1375587419),('Team ads answered question number32(e) worth 1pts',1,1375587421),('Team ads answered question number30(e) worth 1pts',1,1375587422),('Team ads answered question number48(e) worth 1pts',1,1375587423),('Team ads answered question number47(e) worth 1pts',1,1375587424),('Team ads answered question number25(e) worth 1pts',1,1375587426),('Team ads answered question number25(e) worth 1pts',1,1375587427),('Team ads answered question number25(e) worth 1pts',1,1375587427),('Team ads answered question number25(e) worth 1pts',1,1375587427),('Team ads answered question number25(e) worth 1pts',1,1375587428),('Team ads answered question number25(e) worth 1pts',1,1375587429),('Team ads answered question number7(e) worth 1pts',1,1375587430),('Team ninaa answered question number27(e) worth 0pts',1,1375605723),('Team ninaa answered question number46(e) worth 0pts',1,1375605724),('Team ninaa answered question number29(e) worth 0pts',1,1375605724),('Team ninaa answered question number48(e) worth 0pts',1,1375605726),('Team ninaa answered question number49(e) worth 0pts',1,1375605726),('Team ninaa answered question number31(e) worth 0pts',1,1375605726),('Team ninaa answered question number13(e) worth 0pts',1,1375605727),('Team ninaa answered question number33(e) worth 0pts',1,1375605728),('Team ninaa answered question number34(e) worth 0pts',1,1375605728),('Team ninaa answered question number24(e) worth 0pts',1,1375605729),('Team ninaa answered question number7(e) worth 0pts',1,1375605737),('Team ninaa answered question number43(e) worth 0pts',1,1375605742),('Team ninaa answered question number2(e) worth 0pts',1,1375605743),('Team ninaa answered question number4(e) worth 0pts',1,1375605744),('Team The team answered question number45(e) worth 0pts',1,1375605774),('Team The team answered question number28(e) worth 0pts',1,1375605775),('Team The team answered question number45(e) worth 0pts',1,1375605776),('Team The team answered question number46(e) worth 0pts',1,1375605777),('Team The team answered question number47(e) worth 0pts',1,1375605777),('Team The team answered question number8(e) worth 0pts',1,1375606336),('Team The team answered question number7(e) worth 0pts',1,1375606337),('Team The team answered question number5(e) worth 0pts',1,1375606337),('Team The team answered question number23(e) worth 0pts',1,1375606338),('Team The team answered question number41(e) worth 0pts',1,1375606338),('Team The team answered question number33(e) worth 0pts',1,1375606339),('Team asd answered question number42(e) worth 0pts',1,1376029198),('Team asd answered question number6(e) worth 0pts',1,1376029199),('Team asd answered question number31(e) worth 0pts',1,1376029200),('Team asd answered question number34(e) worth 0pts',1,1376029201),('Team asd answered question number38(e) worth 0pts',1,1376029202),('Team Team1 to..! answered question number38(e) worth 0pts',1,1376069396),('Team Team1 to..! answered question number21(e) worth 0pts',1,1376069397),('Team aaaa answered question number24(e) worth 0pts',1,1376069738),('Team aaaa answered question number1(e) worth 10pts',1,1376069754),('Team aaaa answered question number2(e) worth 0pts',1,1376069756),('Team aaaa answered question number3(d) worth 30pts',1,1376070047),('Team aaaa answered question number5(e) worth 0pts',1,1376070431),('Team aaaa answered question number6(e) worth 0pts',1,1376070431),('Team aaaa answered question number8(e) worth 0pts',1,1376070432),('Team aaaa answered question number10(e) worth 0pts',1,1376070433),('Team bbbb answered question number3(d) worth 30pts',1,1376070437),('Team aaaa answered question number1(e) worth 10pts',1,1376070445),('Team aaaa answered question number3(d) worth 30pts',1,1376070447),('Team bbbb answered question number1(e) worth 10pts',1,1376070448),('Team bbbb answered question number21(e) worth 0pts',1,1376070449),('Team bbbb answered question number39(e) worth 0pts',1,1376070449);
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
INSERT INTO `questions_round1` VALUES (0,'e',1,'',0),(1,'e',1,'m',10),(2,'e',1,'',0),(3,'d',1,'a',30),(4,'e',1,'',0),(5,'e',1,'',0),(6,'e',1,'',0),(7,'e',1,'',0),(8,'e',1,'',0),(9,'e',1,'',0),(10,'e',1,'',0),(11,'e',1,'',0),(12,'e',1,'',0),(13,'e',1,'',0),(14,'e',1,'',0),(15,'e',1,'',0),(16,'e',1,'',0),(17,'e',1,'',0),(18,'e',1,'',0),(19,'e',1,'',0),(20,'e',1,'',0),(21,'e',1,'',0),(22,'e',1,'',0),(23,'e',1,'',0),(24,'e',1,'',0),(25,'e',1,'',0),(26,'e',1,'',0),(27,'e',1,'',0),(28,'e',1,'',0),(29,'e',1,'',0),(30,'e',1,'',0),(31,'e',1,'',0),(32,'e',1,'',0),(33,'e',1,'',0),(34,'e',1,'',0),(35,'e',1,'',0),(36,'e',1,'',0),(37,'e',1,'',0),(38,'e',1,'',0),(39,'e',1,'',0),(40,'e',1,'',0);
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
  `answer` text,
  `multiplier` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_round2`
--

LOCK TABLES `questions_round2` WRITE;
/*!40000 ALTER TABLE `questions_round2` DISABLE KEYS */;
INSERT INTO `questions_round2` VALUES (4,'easy',213,321,321,12,123,'123','123',123),(14,'easy',20,5,5,18,17,'What is the most beautiful team ever..??','Noneasdasdasd',1);
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
INSERT INTO `teams` VALUES ('65ba841e01d6db7733e90a5b7f9e6f80','bbbb','bbb1,bbbb2',20130809,'12312312',2),('74b87337454200d4d33f80c4663dc5e5','aaaa','aaaa,aaa',20130809,'0192312',1);
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

-- Dump completed on 2013-08-12 21:39:51
