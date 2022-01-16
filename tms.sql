-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2022 at 06:19 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2020-05-11 11:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(100) DEFAULT NULL,
  `ToDate` varchar(100) DEFAULT NULL,
  `Comment` mediumtext DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `CancelledBy` varchar(5) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`BookingId`, `PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `RegDate`, `status`, `CancelledBy`, `UpdationDate`) VALUES
(1, 1, 'test@gmail.com', '2020-07-11', '2020-07-18', 'I want this package.', '2020-07-08 06:38:36', 2, 'u', '2020-07-08 06:53:45'),
(2, 2, 'test@gmail.com', '2020-07-10', '2020-07-13', 'There is some discount', '2020-07-08 06:43:25', 1, NULL, '2020-07-08 06:52:44'),
(3, 4, 'abir@gmail.com', '2020-07-11', '2020-07-15', 'When I get conformation', '2020-07-08 06:44:39', 2, 'a', '2020-07-08 06:49:55'),
(4, 7, 'dennis@gmail.com', '2021-12-07', '2021-12-13', 'iuytfg', '2021-12-30 12:59:15', 1, NULL, '2021-12-30 13:00:59'),
(5, 2, 'kevin28@gmail.com', '2022-01-04', '2022-01-11', 'dc', '2022-01-03 15:19:25', 1, NULL, '2022-01-03 15:21:50'),
(6, 14, 'kevin28@gmail.com', '2022-01-04', '2022-01-25', 'fd', '2022-01-06 07:07:42', 0, NULL, NULL),
(7, 10, 'kevin28@gmail.com', '2022-01-07', '2022-01-07', 'gtf', '2022-01-06 08:44:15', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`id`, `FullName`, `EmailId`, `MobileNumber`, `Subject`, `Description`, `PostingDate`, `Status`) VALUES
(1, 'Jone Paaire', 'jone@gmail.com', '4646464646', 'Enquiry for Manali Trip', 'Kindly provide me more offer.', '2020-07-08 06:30:32', 1),
(2, 'Kishan Twaerea', 'kishan@gmail.com', '6797947987', 'Enquiry', 'Any Offer for North Trip', '2020-07-08 06:31:38', NULL),
(3, 'Jacaob', 'Jai@gmail.com', '1646689721', 'Any offer for North', 'Any Offer for north', '2020-07-08 06:32:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblissues`
--

CREATE TABLE `tblissues` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `Issue` varchar(100) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminremarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblissues`
--

INSERT INTO `tblissues` (`id`, `UserEmail`, `Issue`, `Description`, `PostingDate`, `AdminRemark`, `AdminremarkDate`) VALUES
(1, NULL, NULL, NULL, '2020-07-08 06:33:20', NULL, NULL),
(2, NULL, NULL, NULL, '2020-07-08 06:33:56', NULL, NULL),
(3, NULL, NULL, NULL, '2020-07-08 06:34:20', NULL, NULL),
(4, NULL, NULL, NULL, '2020-07-08 06:34:38', NULL, NULL),
(5, NULL, NULL, NULL, '2020-07-08 06:35:06', NULL, NULL),
(6, 'test@gmail.com', 'Booking Issues', 'I am not able to book package', '2020-07-08 06:36:03', 'Ok, We will fix the issue asap', '2020-07-08 06:55:22'),
(7, 'test@gmail.com', 'Refund', 'I want my refund', '2020-07-08 06:56:29', NULL, NULL),
(8, NULL, NULL, NULL, '2021-12-30 12:57:07', NULL, NULL),
(9, NULL, NULL, NULL, '2021-12-30 12:58:04', NULL, NULL),
(10, NULL, NULL, NULL, '2022-01-03 15:17:29', NULL, NULL),
(11, 'kevin28@gmail.com', 'Refund', 'fdfdfdf', '2022-01-03 15:20:11', 'vdvvvvd', '2022-01-03 15:21:13'),
(12, 'kevin28@gmail.com', 'Cancellation', 'xcxc', '2022-01-03 15:20:30', 'mbbnb', '2022-01-03 15:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `type`, `detail`) VALUES
(1, 'terms', '																																								<p align=\"justify\"><font size=\"2\"><strong><font color=\"#990000\">(1) ACCEPTANCE OF TERMS</font><br><br></strong><br></font></p>\r\n										\r\n										\r\n										\r\n										'),
(2, 'privacy', ''),
(3, 'aboutus', '																														<div><span style=\"color: rgb(0, 0, 0); font-family: Georgia; font-size: 15px; text-align: justify; font-weight: bold;\">Welcome to baringo county .a home of tourists&nbsp;</span></div><div><br></div>\r\n										\r\n										'),
(11, 'contact', '										<div style=\"text-align: justify;\"><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">dominic kiprop 0728566617</span></div>\r\n										');

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `PackageDetails` mediumtext DEFAULT NULL,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) VALUES
(2, 'baringo  lake- springs', 'Family Package', 'baringo county ', 3000, 'Free Wi-fi, free guide ', 'lake baringo -this is among the largest lake in kenya where many people do visit every year', 'do.jfif', '2020-07-08 05:37:40', '2022-01-06 07:02:40'),
(3, 'lake bogoria ', 'Couple Package', 'baringo county ', 5000, 'Free Pickup and drop facility, Free Wi-fi , Free professional guide', 'hot springs ', 'do.jfif', '2020-07-08 05:41:07', '2022-01-06 06:38:15'),
(10, 'lake Baringo flamingos ', 'er', 'Lake in west central kenya .it is situated 3200 feet above the see level in great rift valley ,east ', 12344, 'f', 'Lake bodoria - is a sparking jewel a pink fringed emerald that holds the single greatest population of flamingos  on the planet .\r\n\r\n\r\n g\r\n\r\n\r\n\r\n', 'caption.jpg', '2022-01-03 16:14:52', '2022-01-05 18:35:10'),
(11, 'Cheploch gorge  resort -', 'family/couple package', 'baringo county -', 1000, 'free wifi ', 'cheploch gorge is  one of the magnificient fronts on river kerio in baringo county kabarnet iten road .the gorge is know for high diving .the divers plunge into the 70 metre deep crocodile infested . tourism both local and international do visits the sides for a vacation ', 'domin.jfif', '2022-01-05 18:42:44', '2022-01-06 06:34:11'),
(12, 'Kabarnet  specialist museums', 'family/couple package', 'baringo county -kabarnet specialist museums is located in kabarnet town ,baringo district in rift va', 1000, 'free accomadations for one day ', 'kabarnet specialist museums exhibits various attractions sites which incude \r\n1. agricultural tools \r\n2.cultural tools and materials  -weapons ,clothing,jewellery \r\n3.', 'provided-by-museums-of[1].jpg', '2022-01-06 05:00:55', NULL),
(13, 'baringo wildlife reserve', 'family/couple package', 'baringo', 15000, 'Elephans, girrafe ,zebraz, wild beasts,', 'The climate of the region is generally hot and dry, and away from the lakeshore, the surrounding countryside appears quite barren. The imposing cliffs are home to the Rock Hyrax which is the closest living relative of Elephants but a delicacy to the Verreaux’s Eagle\r\n', 'OIP.jfif', '2022-01-06 06:48:11', NULL),
(14, 'kerio  valley land scape - paragliding ', 'family/couple package', 'kabarnet- baringo county', 7500, 'paragliding ', 'kerio Valley tourist attraction site is between the Tugen Hills in Eldoret and the Elgeyo escarpment in Kenya. Eldoret town in Kenya is approximately 6 hours drive from Nairobi city. The Kerio Valley is located at an altitude of at least 1000m above sea level. Kerio Valley in Kenya is approximately 80 km wide and 10 km wide at its broadest.', 'paragliding-at-the-kerio - Copy.jpg', '2022-01-06 06:54:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `EmailId` varchar(70) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `MobileNumber`, `EmailId`, `Password`, `RegDate`, `UpdationDate`) VALUES
(1, 'Manju Srivatav', '4456464654', 'manju@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-07-08 06:33:20', NULL),
(2, 'Kishan', '9871987979', 'kishan@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-07-08 06:33:56', NULL),
(3, 'Salvi Chandra', '1398756416', 'salvi@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-07-08 06:34:20', NULL),
(4, 'Abir', '4789756456', 'abir@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-07-08 06:34:38', NULL),
(5, 'Test', '1987894654', 'anuj@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2020-07-08 06:35:06', '2021-05-11 04:37:41'),
(8, 'dominic kiprop', '0728566617', 'amos@gmail.com', '81c7581e45ebb212980031ae3c8b9188', '2021-12-30 12:57:06', NULL),
(9, 'kiprop', '0712345634', 'dennis@gmail.com', '2639c860f3d00fed7ea9065d06c6169d', '2021-12-30 12:58:03', NULL),
(10, 'kevin', '0718405814', 'kevin28@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2022-01-03 15:17:28', NULL),
(11, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2022-01-03 15:20:10', NULL),
(12, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2022-01-03 15:20:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissues`
--
ALTER TABLE `tblissues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `EmailId_2` (`EmailId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblissues`
--
ALTER TABLE `tblissues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
