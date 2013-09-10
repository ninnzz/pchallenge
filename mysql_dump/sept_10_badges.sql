-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2013 at 10:41 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pchallenge`
--

-- --------------------------------------------------------

--
-- Table structure for table `badge`
--

CREATE TABLE IF NOT EXISTS `badge` (
  `id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `count` int(11) NOT NULL,
  `query` text NOT NULL,
  `owner` varchar(32) DEFAULT NULL,
  `timestamp` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `badge`
--

INSERT INTO `badge` (`id`, `name`, `count`, `query`, `owner`, `timestamp`) VALUES
('ABS', 'abSORTion', 5, '', NULL, NULL),
('COL', 'Collectibles', 5, 'UPDATE answered_round2, (SELECT sum(bet/2) AS sumOfBet FROM answered_round2 WHERE NOT (team_id = ''team-id'') AND is_correct = 0 AND badge_in_effect = ''COL'') t SET bet = t.sumOfBet WHERE team_id = ''team-id'' AND badge_in_effect = ''COL''', 'b443db5b092a02c6787d60ae0bf19ad8', NULL),
('LUC', 'Lucky *Star', 5, 'UPDATE answered_round2 SET bet = bet/2 WHERE team_id = ''team-id'' AND is_correct = 0 AND badge_in_effect = ''LUC''', 'b443db5b092a02c6787d60ae0bf19ad8', NULL),
('OOP', 'Oops, Added It Again', 5, 'UPDATE answered_round2 SET bet = 1.5*bet WHERE team_id = ''team-id'' AND is_correct = 1 AND badge_in_effect = ''OOP''', 'b443db5b092a02c6787d60ae0bf19ad8', NULL),
('SEG', 'Segmentation Difficult', 5, 'UPDATE answered_round2 SET bet = 2*bet WHERE team_id = ''team-id'' AND badge_in_effect = ''SEG'' AND is_correct = 1;', 'b443db5b092a02c6787d60ae0bf19ad8', 1378733624);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
