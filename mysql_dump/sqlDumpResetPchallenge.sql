-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2013 at 10:04 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pchallenge`
--
CREATE DATABASE IF NOT EXISTS `pchallenge` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pchallenge`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `uname` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `scope` enum('all','encoder','mod','mc') DEFAULT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`uname`, `password`, `scope`) VALUES
('admin', '7cd99475e3a278c8584641484ddd6aeb', 'all'),
('eco', 'e434dd9c7f573fb03924e0c4d3d44d45', 'encoder'),
('encoder', 'e7d77a94ff18fa23e9fc89e710ff2660', 'encoder'),
('ninz', '84410e60ebe48d90ee0caa7df6179e08', 'encoder'),
('ninz2', 'c9449408bb95f549503fa92de5550a4c', 'mod');

-- --------------------------------------------------------

--
-- Table structure for table `answered_round1`
--

CREATE TABLE IF NOT EXISTS `answered_round1` (
  `q_number` int(10) DEFAULT NULL,
  `team_id` varchar(32) DEFAULT NULL,
  `is_fast_round` tinyint(1) DEFAULT NULL,
  `answered_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answered_round2`
--

CREATE TABLE IF NOT EXISTS `answered_round2` (
  `q_number` int(10) NOT NULL,
  `team_id` varchar(32) NOT NULL,
  `bet` int(10) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `badge_in_effect` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_config`
--

CREATE TABLE IF NOT EXISTS `app_config` (
  `app_state` enum('round_1','round_1m','round_2','paused','pre','stopped') DEFAULT NULL,
  `current_question_round2` int(11) DEFAULT NULL,
  `r2_state` enum('preparation','init','preview','badge','bet','show_question','timer','show_answer','scores') DEFAULT NULL,
  `round1_question_count` int(11) DEFAULT NULL,
  `badge_count` int(11) DEFAULT NULL,
  `round1_timer` int(11) DEFAULT NULL,
  `round2_question_count` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_config`
--

INSERT INTO `app_config` (`app_state`, `current_question_round2`, `r2_state`, `round1_question_count`, `badge_count`, `round1_timer`, `round2_question_count`) VALUES
('round_1', 1, 'show_question', 49, 5, 45, 20);

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
('COL', 'Collectibles', 5, 'UPDATE answered_round2, (SELECT sum(bet/2) AS sumOfBet FROM answered_round2 WHERE NOT (team_id = ''team-id'') AND is_correct = 0 AND badge_in_effect = ''COL'') t SET bet = t.sumOfBet WHERE team_id = ''team-id'' AND badge_in_effect = ''COL''', NULL, NULL),
('LUC', 'Lucky *Star', 5, 'UPDATE answered_round2 SET bet = bet/2 WHERE team_id = ''team-id'' AND is_correct = 0 AND badge_in_effect = ''LUC''', NULL, NULL),
('OOP', 'Oops, Added It Again', 5, 'UPDATE answered_round2 SET bet = 1.5*bet WHERE team_id = ''team-id'' AND is_correct = 1 AND badge_in_effect = ''OOP''', NULL, NULL),
('SEG', 'Segmentation Difficult', 5, 'UPDATE answered_round2 SET bet = 2*bet WHERE team_id = ''team-id'' AND badge_in_effect = ''SEG'' AND is_correct = 1;', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `evnt` text,
  `priority` int(10) DEFAULT NULL,
  `date_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions_badge`
--

CREATE TABLE IF NOT EXISTS `questions_badge` (
  `q_number` int(11) NOT NULL,
  `badge_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions_badge`
--

INSERT INTO `questions_badge` (`q_number`, `badge_type`) VALUES
(37, 'ABS'),
(38, 'ABS'),
(39, 'ABS'),
(41, 'ABS'),
(42, 'ABS'),
(1, 'COL'),
(2, 'COL'),
(3, 'COL'),
(4, 'COL'),
(5, 'COL'),
(6, 'COL'),
(8, 'COL'),
(9, 'COL'),
(10, 'COL'),
(11, 'COL'),
(12, 'COL'),
(13, 'COL'),
(14, 'COL'),
(15, 'COL'),
(17, 'COL'),
(19, 'COL'),
(20, 'COL'),
(22, 'COL'),
(23, 'COL'),
(24, 'COL'),
(25, 'COL'),
(27, 'COL'),
(28, 'COL'),
(29, 'COL'),
(30, 'COL'),
(32, 'COL'),
(36, 'COL'),
(37, 'COL'),
(38, 'COL'),
(39, 'COL'),
(40, 'COL'),
(41, 'COL'),
(42, 'COL'),
(43, 'COL'),
(44, 'COL'),
(46, 'COL'),
(48, 'COL'),
(3, 'LUC'),
(7, 'LUC'),
(13, 'LUC'),
(24, 'LUC'),
(27, 'LUC'),
(35, 'LUC'),
(44, 'LUC'),
(48, 'LUC'),
(5, 'OOP'),
(7, 'OOP'),
(14, 'OOP'),
(15, 'OOP'),
(24, 'OOP'),
(31, 'OOP'),
(33, 'OOP'),
(3, 'SEG'),
(6, 'SEG'),
(9, 'SEG'),
(12, 'SEG'),
(15, 'SEG'),
(18, 'SEG'),
(21, 'SEG'),
(24, 'SEG'),
(27, 'SEG'),
(30, 'SEG'),
(33, 'SEG'),
(36, 'SEG'),
(39, 'SEG'),
(42, 'SEG'),
(45, 'SEG'),
(48, 'SEG');

-- --------------------------------------------------------

--
-- Table structure for table `questions_round1`
--

CREATE TABLE IF NOT EXISTS `questions_round1` (
  `q_number` int(11) NOT NULL,
  `q_diff` varchar(4) DEFAULT NULL,
  `q_type` varchar(5) DEFAULT NULL,
  `q_multiplier` double DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions_round1`
--

INSERT INTO `questions_round1` (`q_number`, `q_diff`, `q_type`, `q_multiplier`, `points`) VALUES
(1, 'e', '#d', 1, 30),
(2, 'a', 'pr', 1, 50),
(3, 'd', 'pa', 1, 70),
(4, 'e', 're', 1, 30),
(5, 'a', '#d', 1, 50),
(6, 'd', 're', 1, 70),
(7, 'e', NULL, 1, 30),
(8, 'a', 'pa', 1, 50),
(9, 'd', 'pr', 1, 70),
(10, 'e', '#d', 1, 30),
(11, 'a', '#d', 1, 50),
(12, 'd', 'pa', 1, 70),
(13, 'e', 're', 1, 30),
(14, 'a', 're', 1, 50),
(15, 'd', 'pr', 1, 70),
(16, 'e', NULL, 1, 30),
(17, 'a', 'pr', 1, 50),
(18, 'd', NULL, 1, 70),
(19, 'e', '#d', 1, 30),
(20, 'a', 'pa', 1, 50),
(21, 'd', NULL, 1, 70),
(22, 'e', 'pa', 1, 30),
(23, 'a', 're', 1, 50),
(24, 'd', '#d', 1, 70),
(25, 'e', 'pr', 1, 30),
(26, 'a', NULL, 1, 50),
(27, 'd', '#d', 1, 70),
(28, 'e', 'pr', 1, 30),
(29, 'a', 'pa', 1, 50),
(30, 'd', 're', 1, 70),
(31, 'e', NULL, 1, 30),
(32, 'a', 're', 1, 50),
(33, 'd', NULL, 1, 70),
(34, 'e', 'pa', 1, 30),
(35, 'a', NULL, 1, 50),
(36, 'd', 'pr', 1, 70),
(37, 'e', 'so', 1, 30),
(38, 'a', 'so', 1, 50),
(39, 'd', 'so', 1, 70),
(40, 'e', 'pa', 1, 30),
(41, 'a', NULL, 1, 50),
(42, 'd', NULL, 1, 70),
(43, 'e', 'pr', 1, 30),
(44, 'a', '#d', 1, 50),
(45, 'd', NULL, 1, 70),
(46, 'e', 'pr', 1, 30),
(47, 'a', NULL, 1, 50),
(48, 'd', '#d', 1, 70),
(0, 'd', NULL, 1, 70),
(49, 'e', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions_round2`
--

CREATE TABLE IF NOT EXISTS `questions_round2` (
  `q_number` int(11) DEFAULT NULL,
  `q_type` enum('e','a','d') DEFAULT NULL,
  `multiplier` float DEFAULT NULL,
  `points` int(10) DEFAULT NULL,
  `prev_timer` int(10) DEFAULT NULL,
  `badge_timer` int(10) DEFAULT NULL,
  `bet_timer` int(10) DEFAULT NULL,
  `q_timer` int(10) DEFAULT NULL,
  `body` text,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions_round2`
--

INSERT INTO `questions_round2` (`q_number`, `q_type`, `multiplier`, `points`, `prev_timer`, `badge_timer`, `bet_timer`, `q_timer`, `body`, `answer`) VALUES
(1, 'e', 1, 30, 5, 10, 10, 30, 'What would function(2574) return?<br/><br/>\r\nint function(int n){<br/>\r\n    int s, d;<br/>\r\n    if(n!=0){<br/>\r\n        d = n;<br/>\r\n        n = n/10;<br/>\r\n        s = d+function(n);<br/>\r\n    }<br/>\r\n    else return 0;<br/>\r\n    return s;<br/>\r\n}<br/>', '<br/>\r\n18\r\n<br/>\r\n<br/>\r\nExplanation:<br/><br/>\r\nfunction stores each digit onto d and recursively add all the digits together'),
(4, 'e', 1, 30, 5, 10, 10, 30, 'Given an array of size 6 named array with elements 20, 15, 15, 10, 30, and 35,<br/> how many times would the printf execute?<br/><br/>\r\nfor(i = 0; i < 6; i++){<br/>\r\n    a = 0;<br/>\r\n    for(j = 0; j < 6; j++){<br/>\r\n        array[i] + array[j] == 50?a?1:printf("Fifty\\n"), a=1:1;<br/>\r\n    }<br/>\r\n}<br/>', '<br/>5<br/><br/>\r\nExplanation:<br/><br/>\r\nThis code prints "Fifty" when it detects that the current element in the array can be paired with another element in the same array given that it the sum of the two is 50.'),
(7, 'e', 1, 30, 5, 10, 10, 30, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n<br/>\r\nint main(){<br/>\r\n    int a = 10;<br/>\r\n    switch(a){<br/>\r\n        case ''1'':<br/>\r\n            printf("Get\\n");<br/>\r\n            break;<br/>\r\n        case ''2'':<br/>\r\n            printf("One\\n");<br/>\r\n            break;<br/>\r\n        defa1ut:<br/>\r\n            printf("Fourth\\n");<br/>\r\n    }<br/>\r\n    printf("Done!\\n");<br/>\r\n    return 0;<br/>\r\n}<br/>', '<br/>Done!<br/><br/>\r\nExplanation:<br/><br/>\r\ndefa1ut is NOT a keyword in C, thus, there will be no output from the switch statement and will print "Done!". The defau1t acts as a label for the still existing goto command.'),
(10, 'e', 1, 30, 5, 10, 10, 30, 'What will this code snippet print?<br/><br/>\r\n    printf("%s", "Item1" "Item2" "Item3" "Item4");<br/>', '<br/>Item1Item2Item3Item4<br/><br/>\r\nExplanation:<br/><br/>\r\nA string can be stated in a separated manner. For example, "Ghost" == "Gh""ost". Literal strings adjacent to each other results in its concatenation.'),
(2, 'a', 1.5, 50, 5, 10, 10, 45, 'What is the output of the following code?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n#define L 50-5<br/><br/>\r\nvoid main(){<br/>\r\n    int money=10;<br/>\r\n    switch(money*3){<br/>\r\n        case L:<br/>\r\n            printf("Willian");<br/>\r\n            break;<br/>\r\n        case L*2:<br/>\r\n            printf("Warren");<br/>\r\n            break;<br/>\r\n        case L*3:<br/>\r\n            printf("Carlos");<br/>\r\n            break;<br/>\r\n        default:<br/>\r\n            printf("Lawrence");<br/>\r\n        case L*4:<br/>\r\n            printf("Inqvar");<br/>\r\n            break;<br/>\r\n    }<br/>  \r\n}<br/>', '<br/>Inqvar<br/><br/>\r\nExplanation:<br/><br/>\r\nL is defined as 50-5 and it remains that way. When 50-5 is substituted to each L in the case statements, it still follows the PEMDAS rule, therefore on the 4th case statement, L*4 = 50-5*4 = 30. And also, the default statement would only be called after all the case statements be checked.'),
(5, 'a', 1.5, 50, 5, 10, 10, 45, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\nvoid main(){<br/>\r\n    int a = 0, b = 0;<br/>\r\n    a = 8, 4, a++;<br/>\r\n    b = a++, b++, 5;<br/>\r\n    printf("%d\\n", a+b);<br/>\r\n}<br/>', '<br/>20<br/><br/>\r\nExplanation:<br/><br/>\r\nEach line of code (or statement) in c could be put into one line given that they are separated by comma (,).<br/>\r\n  For example:<br/>\r\n  a = 2;<br/>\r\n  a+=b<br/>\r\n  printf("%d\\n", a);<br/>\r\n  The code above could be stated like this:<br/>\r\n  a = 2, a+=b, printf("%d\\n", a);<br/>'),
(8, 'a', 1.5, 50, 5, 10, 10, 45, 'What is the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n<br/>\r\nint main(){<br/>\r\n    printf("%o", ((8+4)<<2));<br/>\r\n    return 0;<br/>\r\n}<br/>', '<br/>80<br/><br/>\r\nExplanation:<br/><br/>\r\n(8+4) will be first evaluated giving 12. The bitwise operator  <<  shifts the binary representation of 12 two  steps to the left giving 110 000. The result will be converted to octal since the  format in the printf function is in octal.'),
(3, 'd', 2, 70, 5, 10, 10, 60, 'What would be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nvoid main(){<br/>\r\n    switch(*("ABCD"+2)){<br/>\r\n        case ''A'':<br/>\r\n            printf("CMSC11"+1);<br/>\r\n            break;<br/>\r\n        case ''B'':<br/>\r\n            printf("CMSC21"+2);<br/>\r\n            break;<br/>\r\n        case ''C'':<br/>\r\n            printf("CMSC123"+3);<br/>\r\n            break;<br/>\r\n        case ''D'':<br/>\r\n            printf("CMSC142"+4);<br/>\r\n    }<br/>\r\n}<br/>', '<br/>C123<br/><br/>\r\nExplanation: <br/><br/>\r\nAnything enclosed in double quotes (") is considered as a string. A string stands as a pointer to itself, therefore adding an integer would shift its current address. "ABCD" + 2 would now point to the substring CD and the value would be C since the * signifies to the position it points to, the index 0.'),
(6, 'd', 2, 70, 5, 10, 10, 60, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n<br/>\r\nvoid main(){<br/>\r\n    printf("%d/%d\\n", printf("%c","SHINGEKI"[4]), 4);<br/>\r\n}<br/>', '<br/>G1/4<br/><br/>\r\nExplanation: <br/><br/>\r\nAnything enclosed in double quotes is a string and each character could be accessed via indexing. Also, a printf statement returns the length of the string that it prints.'),
(9, 'd', 2, 70, 5, 10, 10, 60, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n<br/>\r\nvoid main(){<br/>\r\n    static char *s[] = {"black", "white", "pink", "violet"};<br/>\r\n    char **ptr[] = {s+3, s+2, s+1, s}, ***p;<br/>\r\n    p = ptr;<br/>\r\n    ++p;<br/>\r\n    printf("%s", **p+1);<br/>\r\n}<br/>', '<br/>ink<br/><br/>\r\nExplanation:<br/><br/>\r\ns = { black, white, pink, violet};<br/>\r\n  ptr will point to the array containing violet, pink, white and black respectively since the first argument will be considered. p points to ptr. Pre-incrementing p points to the 2nd element which is pink. In the function printf, the substring from the 2nd element is being printed'),
(11, 'a', 1.5, 50, 5, 10, 10, 50, 'What is the output of the code? <br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\n\r\nint main(){<br/>\r\n    printf("%d%d\\n", 0 || 2 && 0, printf("asdf"));\r\n<br/>\r\n \r\n}', 'asdf04<br/><br/>\r\nA boolean expression returns 1 if true and 0 if false. 0 || 2 && 0 is false therefore it returns 0. Then, the inner printf executes and returns 4, the length of the string it prints.'),
(12, 'd', 2, 70, 5, 10, 10, 30, 'this is the body', 'this is the answer');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `team_no` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` varchar(32) NOT NULL,
  `team_name` longtext NOT NULL,
  `team_members` longtext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact` longtext NOT NULL,
  PRIMARY KEY (`team_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
