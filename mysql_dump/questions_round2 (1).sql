-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 11, 2013 at 11:26 PM
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
(7, 'e', 1, 30, 5, 10, 10, 30, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nint main(){<br/>\r\n    int a = 10;<br/>\r\n    switch(a){<br/>\r\n        case ''1'':<br/>\r\n            printf("Get\\n");<br/>\r\n            break;<br/>\r\n        case ''2'':<br/>\r\n            printf("One\\n");<br/>\r\n            break;<br/>\r\n        defa1ut:<br/>\r\n            printf("Fourth\\n");<br/>\r\n    }<br/>\r\n    printf("Done!\\n");<br/>\r\n    return 0;<br/>\r\n}<br/>', '<br/>Done!<br/><br/>\r\nExplanation:<br/><br/>\r\ndefa1ut is NOT a keyword in C, thus, there will be no output from the switch statement and will print "Done!". The defau1t acts as a label for the still existing goto command.'),
(10, 'e', 1, 30, 5, 10, 10, 30, 'What will this code snippet print?<br/><br/>\r\n    printf("%s", "Item1" "Item2" "Item3" "Item4");<br/>', '<br/>Item1Item2Item3Item4<br/><br/>\r\nExplanation:<br/><br/>\r\nA string can be stated in a separated manner. For example, "Ghost" == "Gh""ost". Literal strings adjacent to each other results in its concatenation.'),
(2, 'a', 1.5, 50, 5, 10, 10, 45, 'What is the output of the following code?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\n#define L 50-5<br/><br/>\r\nvoid main(){<br/>\r\n    int money=10;<br/>\r\n    switch(money*3){<br/>\r\n        case L:<br/>\r\n            printf("Willian");<br/>\r\n            break;<br/>\r\n        case L*2:<br/>\r\n            printf("Warren");<br/>\r\n            break;<br/>\r\n        case L*3:<br/>\r\n            printf("Carlos");<br/>\r\n            break;<br/>\r\n        default:<br/>\r\n            printf("Lawrence");<br/>\r\n        case L*4:<br/>\r\n            printf("Inqvar");<br/>\r\n            break;<br/>\r\n    }<br/>  \r\n}<br/>', '<br/>Inqvar<br/><br/>\r\nExplanation:<br/><br/>\r\nL is defined as 50-5 and it remains that way. When 50-5 is substituted to each L in the case statements, it still follows the PEMDAS rule, therefore on the 4th case statement, L*4 = 50-5*4 = 30. And also, the default statement would only be called after all the case statements be checked.'),
(5, 'a', 1.5, 50, 5, 10, 10, 45, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/>\r\nvoid main(){<br/>\r\n    int a = 0, b = 0;<br/>\r\n    a = 8, 4, a++;<br/>\r\n    b = a++, b++, 5;<br/>\r\n    printf("%d\\n", a+b);<br/>\r\n}<br/>', '<br/>20<br/><br/>\r\nExplanation:<br/><br/>\r\nEach line of code (or statement) in c could be put into one line given that they are separated by comma (,).<br/>\r\n  For example:<br/>\r\n  a = 2;<br/>\r\n  a+=b<br/>\r\n  printf("%d\\n", a);<br/>\r\n  The code above could be stated like this:<br/>\r\n  a = 2, a+=b, printf("%d\\n", a);<br/>'),
(8, 'a', 1.5, 50, 5, 10, 10, 45, 'What is the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nint main(){<br/>\r\n    printf("%o", ((8+4)<<2));<br/>\r\n    return 0;<br/>\r\n}<br/>', '<br/>80<br/><br/>\r\nExplanation:<br/><br/>\r\n(8+4) will be first evaluated giving 12. The bitwise operator  <<  shifts the binary representation of 12 two  steps to the left giving 110 000. The result will be converted to octal since the  format in the printf function is in octal.'),
(3, 'd', 2, 70, 5, 10, 10, 60, 'What would be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nvoid main(){<br/>\r\n    switch(*("ABCD"+2)){<br/>\r\n        case ''A'':<br/>\r\n            printf("CMSC11"+1);<br/>\r\n            break;<br/>\r\n        case ''B'':<br/>\r\n            printf("CMSC21"+2);<br/>\r\n            break;<br/>\r\n        case ''C'':<br/>\r\n            printf("CMSC123"+3);<br/>\r\n            break;<br/>\r\n        case ''D'':<br/>\r\n            printf("CMSC142"+4);<br/>\r\n    }<br/>\r\n}<br/>', '<br/>C123<br/><br/>\r\nExplanation: <br/><br/>\r\nAnything enclosed in double quotes (") is considered as a string. A string stands as a pointer to itself, therefore adding an integer would shift its current address. "ABCD" + 2 would now point to the substring CD and the value would be C since the * signifies to the position it points to, the index 0.'),
(6, 'd', 2, 70, 5, 10, 10, 60, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nvoid main(){<br/>\r\n    printf("%d/%d\\n", printf("%c","SHINGEKI"[4]), 4);<br/>\r\n}<br/>', '<br/>G1/4<br/><br/>\r\nExplanation: <br/><br/>\r\nAnything enclosed in double quotes is a string and each character could be accessed via indexing. Also, a printf statement returns the length of the string that it prints.'),
(9, 'd', 2, 70, 5, 10, 10, 60, 'What will be the output of the program?<br/><br/>\r\n#include&lt;stdio.h&gt;<br/><br/>\r\nvoid main(){<br/>\r\n    static char *s[] = {"black", "white", "pink", "violet"};<br/>\r\n    char **ptr[] = {s+3, s+2, s+1, s}, ***p;<br/>\r\n    p = ptr;<br/>\r\n    ++p;<br/>\r\n    printf("%s", **p+1);<br/>\r\n}<br/>', '<br/>ink<br/><br/>\r\nExplanation:<br/><br/>\r\ns = { black, white, pink, violet};<br/>\r\n  ptr will point to the array containing violet, pink, white and black respectively since the first argument will be considered. p points to ptr. Pre-incrementing p points to the 2nd element which is pink. In the function printf, the substring from the 2nd element is being printed'),
(11, 'a', 1.5, 50, 5, 10, 10, 30, 'this is the body', 'this is the answer'),
(12, 'd', 2, 70, 5, 10, 10, 30, 'this is the body', 'this is the answer');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
