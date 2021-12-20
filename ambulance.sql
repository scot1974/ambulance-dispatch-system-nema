-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2019 at 05:27 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ambulance`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambulance`
--

CREATE TABLE IF NOT EXISTS `ambulance` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ambulance`
--

INSERT INTO `ambulance` (`id`, `name`, `location`, `description`, `created_at`, `status`) VALUES
(1, 'A1', 'Bolari', 'sdafsdfdsf', '2019-03-22 15:35:50', 1),
(4, 'A2', 'Federal Lowcost', 'dfasdfdsfdfsg', '2019-03-23 07:37:41', 1),
(5, 'A3', 'bolari', 'dgfagsasgfdasgsfd', '2019-03-24 13:44:26', 1),
(6, 'A4', 'pantami', 'sngiujsdhiosedgesgfdgdfdgfd', '2019-03-24 13:45:57', 1),
(7, 'A5', 'maitama', 'dsfuigvhbdusivjkbdjovh bndijskgdf', '2019-04-02 07:50:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE IF NOT EXISTS `emergency` (
  `id` int(11) NOT NULL,
  `dispatcher_id` int(11) NOT NULL,
  `ambulance_id` varchar(20) NOT NULL,
  `caller_name` varchar(150) NOT NULL,
  `caller_phone` varchar(12) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `emg_type` varchar(150) NOT NULL,
  `injured` int(11) NOT NULL,
  `amb_required` int(11) NOT NULL,
  `address` text NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`id`, `dispatcher_id`, `ambulance_id`, `caller_name`, `caller_phone`, `relationship`, `emg_type`, `injured`, `amb_required`, `address`, `notes`, `status`, `created_at`) VALUES
(1, 1, '4', 'Mike Steve', '08067764455', 'self', 'Fire', 3, 2, 'federal lowcost', '-1 Burnt Person\r\n-Two survivors', 1, '2019-03-23 20:09:10'),
(2, 1, '5', 'James Scort', '08045543223', 'self', 'Building fall', 4, 1, 'Bolari', '- Injdkbduhsvkbdijkvbfd\r\n- jdbvdijsvkbnfdjkndfjivknfd', 2, '2019-03-24 06:00:29'),
(3, 1, '6,1', 'Test Test', '08088888333', 'other', 'Knee Test', 3, 3, 'jalingo', 'asbdfdsigdsbuivkfdsgvfd', 1, '2019-03-24 19:28:42'),
(4, 4, '7,1', 'Mike Steve', '08067764455', 'self', 'Building fall', 3, 2, 'maitama', 'wjkdfgbuydisjfkgbuwdosifhwiodslk', 1, '2019-04-02 07:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `name`, `active`) VALUES
(1, 'John Doe', 1),
(2, 'Mark Smith', 1),
(3, 'Test Test', 1),
(4, 'Dispatcher John Doe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `usergroup` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profileid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `password`, `usergroup`, `created_at`, `profileid`) VALUES
(1, 'admin', '97ece0fcf2255215495adaa8e1c6891627d69261', 123, '2019-03-21 18:08:52', 0),
(2, 'johndoe', '97ece0fcf2255215495adaa8e1c6891627d69261', 321, '2019-03-22 20:21:58', 1),
(3, 'marksmith', '97ece0fcf2255215495adaa8e1c6891627d69261', 321, '2019-03-22 20:23:48', 2),
(4, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 321, '2019-03-22 20:33:01', 3),
(5, 'dispatcher', '97ece0fcf2255215495adaa8e1c6891627d69261', 321, '2019-04-02 07:51:22', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambulance`
--
ALTER TABLE `ambulance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `emergency`
--
ALTER TABLE `emergency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambulance`
--
ALTER TABLE `ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `emergency`
--
ALTER TABLE `emergency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
