-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2014 at 04:51 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `usermonkey`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL,
  `password` varchar(129) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `userType` varchar(15) NOT NULL,
  `dateCreated` date NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `verified` (`verified`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `salt`, `email`, `userType`, `dateCreated`, `verified`) VALUES
(71, 'alicia93', '5b0ce74ba61d459fd68891a528a7e28b752d2293fa9ce25c17484115cf092bbd9b670f431dbb2766dbd32c56c3cecf756f85d2de2899d3e8908e983d9eb6edc7', 'YlMClpXFlnxsrmKTBXkhhdtssMXNCJU7', 'alicia2727@hotmail.co.uk', 'standard', '2014-06-16', 1),
(72, 'henry', 'c18e96e8cf99e59c003e5af07c47e9f45414138a11df3d34ab6303af66ebc09f3cd6136eff1035e52f782fa3207a92ba8c6ea783c8153317b9c27ee722deed0f', 'FztUTZ8z4dQXL0Wy6xhkEzcMxiyQjqG1', 'hen89@hotmail.com', 'standard', '2014-06-20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_information`
--

CREATE TABLE IF NOT EXISTS `user_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `value` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`id`, `user_id`, `type`, `value`, `description`) VALUES
(1, 71, 'previous employer', 'University of Oxford', 'Worked as a software engineer programming in Java on an Oxford University research project, that analysed malaria data and used algorithms to  predict when an resistance to a vaccination may occur. Involved writing scalable programs capable of dealing with hundreds of thousands of patient records. Full-time for 3 months. 2013'),
(2, 71, 'school', 'St Johns Community School ', 'A Levels in computing, physics, and economics and AS levels in maths and photography.'),
(3, 71, 'current-employer', 'UTC Swindon', 'I currently work part time for Swindon University as head of their web team. It is my responsibility to maintain their website, ensuring that it is fully accessible and up to date.');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip` varchar(11) NOT NULL,
  `time` int(11) NOT NULL,
  `success` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `ip`, `time`, `success`) VALUES
(1, 66, '0', 1402393212, 1),
(2, 66, '0', 1402393214, 1),
(3, 61, '::1', 1402393350, 1),
(4, 0, '::1', 1402393420, 0),
(5, 0, '::1', 1402394807, 0),
(6, 0, '::1', 1402394813, 0),
(7, 61, '::1', 1402394849, 0),
(8, 0, '::1', 1402394859, 0),
(9, 61, '::1', 1402394870, 0),
(10, 61, '::1', 1402394886, 1),
(11, 61, '::1', 1402476677, 1),
(12, 0, '::1', 1402476695, 0),
(13, 0, '::1', 1402476707, 0),
(14, 67, '::1', 1402476737, 1),
(15, 67, '::1', 1402476841, 1),
(16, 67, '::1', 1402476857, 1),
(17, 67, '::1', 1402476876, 1),
(18, 68, '::1', 1402478128, 1),
(19, 61, '::1', 1402488471, 1),
(20, 61, '::1', 1402580709, 0),
(21, 61, '::1', 1402580719, 0),
(22, 61, '::1', 1402580728, 0),
(23, 67, '::1', 1402580743, 1),
(24, 67, '::1', 1402580783, 0),
(25, 67, '::1', 1402580790, 0),
(26, 67, '::1', 1402580798, 0),
(27, 69, '::1', 1402581440, 1),
(28, 69, '::1', 1402581516, 0),
(29, 0, '::1', 1402596272, 0),
(30, 61, '::1', 1402596283, 1),
(31, 61, '::1', 1402597023, 1),
(32, 61, '::1', 1402643088, 0),
(33, 61, '::1', 1402643098, 0),
(34, 61, '::1', 1402643108, 1),
(35, 61, '::1', 1402643207, 1),
(36, 67, '::1', 1402646691, 0),
(37, 68, '::1', 1402646720, 1),
(38, 68, '::1', 1402647930, 1),
(39, 0, '::1', 1402648177, 0),
(40, 0, '::1', 1402648590, 0),
(41, 70, '::1', 1402648615, 1),
(42, 0, '::1', 1402908608, 0),
(43, 0, '::1', 1402908624, 0),
(44, 0, '::1', 1402908637, 0),
(45, 71, '::1', 1402910364, 1),
(46, 71, '::1', 1402915199, 1),
(47, 0, '::1', 1403282398, 0),
(48, 72, '::1', 1403282427, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_socialmedia`
--

CREATE TABLE IF NOT EXISTS `user_socialmedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service` varchar(30) NOT NULL,
  `url` varchar(249) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `user_socialmedia`
--

INSERT INTO `user_socialmedia` (`id`, `user_id`, `service`, `url`) VALUES
(10, 61, 'googleplus', 'https://plus.google.com/115877233289242058609/posts'),
(11, 61, 'dribble', 'https://dribbble.com/AndrewArnott'),
(12, 61, 'tumblr', 'http://andrew.tumblr.com/'),
(13, 71, 'facebook', 'http://fb.com/liss.sykes'),
(14, 71, 'linkedin', 'http://uk.linkedin.com/in/aliciasykes'),
(15, 71, 'googleplus', 'https://plus.google.com/+AliciaSykes'),
(16, 71, 'github', 'https://github.com/Lissy93'),
(17, 71, 'blogger', 'http://lissy93.blogspot.com'),
(18, 71, 'twitter', 'https://twitter.com/Lissy_Sykes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
