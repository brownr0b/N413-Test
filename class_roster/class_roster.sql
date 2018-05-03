-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2018 at 02:44 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `n413_class_roster`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_roster`
--

CREATE TABLE `class_roster` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `photo` varchar(512) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_roster`
--

INSERT INTO `class_roster` (`id`, `first_name`, `last_name`, `photo`) VALUES
(1, 'Merveil', 'Alisa', 'https://iu.instructure.com/images/thumbnails/58308704/H7e3u908HxksA8r7ixCOHLNMozH3bfmMcrQZJALc'),
(2, 'Brian', 'Brown', 'https://iu.instructure.com/images/thumbnails/75664948/u9JFzgHALclw3yGx64PXtFYaDero62kVgp0gxNrh'),
(3, 'Levi', 'Conklin', 'https://iu.instructure.com/images/thumbnails/58636699/tMZQ1BVly78BxLSgy3h9PTmVqdWtdj9xFW3XBPCL'),
(4, 'Ashley', 'Conrad', 'https://iu.instructure.com/images/thumbnails/74379364/SSi8jWA85yxq8WagXMAbyqhOwSnAR3sLdg4H6cuL'),
(5, 'Alexandra', 'Gentry', 'https://iu.instructure.com/images/thumbnails/59976833/wfs4mOuXWiuzJAhlT9t8NZRYEigJNMgCjrWUB9Jh'),
(6, 'Derrick', 'Otte', 'https://iu.instructure.com/images/thumbnails/72154789/dx4YUBr7e5ntzkSQ3NF48RHhrdx84AegwTUJ228I'),
(7, 'Haley', 'Rios', 'images/haley.jpg'),
(8, 'Logan', 'Sotelo', 'https://iu.instructure.com/images/thumbnails/54189096/Lrk4WZfE6HH8l70W45UW8T8H58iwH2YgYPkOojay'),
(9, 'Robert', 'Brown', 'https://iu.instructure.com/images/thumbnails/66184800/7adLffdgGXxXcmx74c0M1CYG7W8IPtgM0GvucOHP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_roster`
--
ALTER TABLE `class_roster`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_roster`
--
ALTER TABLE `class_roster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
