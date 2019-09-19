-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2016 at 07:55 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dhaka_restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_data`
--

CREATE TABLE IF NOT EXISTS `additional_data` (
  `ADD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(50) NOT NULL,
  `TITLE` varchar(100) NOT NULL,
  `URL` varchar(300) NOT NULL,
  `DETAILS` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`ADD_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `additional_data`
--

INSERT INTO `additional_data` (`ADD_ID`, `TYPE`, `TITLE`, `URL`, `DETAILS`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 'notice', 'BCS (Tax) Academy is the apex training institution', 'http://bcstax.xom', 'This is a description', 1, '2016-05-20', 1, '2016-06-11', -7),
(3, 'notice', 'Taxes Department of National Board of Revenue in Bangladesh', '#', 'This is a information', 1, '2016-05-20', 0, '0000-00-00', 7),
(4, 'notice', 'This is photoshop version of Lorem Ipsum. Proin gravida nibh vel velit', '#', 'This is a data', 1, '2016-05-20', 0, '0000-00-00', 7),
(5, 'links', 'Bangabhaban', 'http://www.bangabhaban.gov.bd/index.php', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(6, 'links', 'Cabinet Division', 'http://www.cabinet.gov.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(7, 'links', 'The Prime Ministers Office', 'http://www.pmo.gov.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(8, 'links', 'Ministry of Finance', 'http://www.mof.gov.bd/en/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(9, 'links', 'National Board of Revenue', 'http://www.nbr.gov.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(10, 'links', 'Ministry of Commerce', 'http://www.mincom.gov.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(11, 'links', 'Ministry of Foreign Affairs', 'http://www.mofa.gov.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(12, 'links', 'Ministry of Public Administration', 'http://www.mopa.gov.bd/en', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(13, 'links', 'BPATC', 'http://www.bpatc.org.bd/', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(14, 'events', 'Event One', '#', '', 1, '2016-05-20', 1, '2016-05-20', 7),
(15, 'events', 'Event Two', '#', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(16, 'events', 'Event Three', '#', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(17, 'events', 'Event Four', '#', '', 1, '2016-05-20', 0, '0000-00-00', 7),
(19, 'contact', 'Contact Us', '', '47 Bir Uttam Samsul Alam Sarak,\nDhaka 1000-1200,\nBangladesh', 1, '2016-05-25', 1, '2016-05-26', 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(50) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CATEGORY_ID`, `CATEGORY_NAME`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(8, 'Gallery', 1, '2016-05-04', 4, 2016, 7),
(9, 'Downloads', 1, '2016-05-04', 0, 0, 7),
(10, 'Videos', 1, '2016-05-20', 0, 0, 7),
(11, 'Page', 1, '2016-05-23', 0, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `contact_data`
--

CREATE TABLE IF NOT EXISTS `contact_data` (
  `CONTACT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(150) NOT NULL,
  `EMAIL` varchar(150) NOT NULL,
  `SUBJECT` varchar(250) NOT NULL,
  `MESSAGE` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`CONTACT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `FILE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_ID` int(11) NOT NULL,
  `SUB_CAT_ID` int(11) NOT NULL,
  `FILE_CAPTION` varchar(200) NOT NULL,
  `FILE_LINK` varchar(200) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`FILE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FILE_ID`, `CAT_ID`, `SUB_CAT_ID`, `FILE_CAPTION`, `FILE_LINK`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(9, 9, 8, 'Aplication For Admission Form', '8.pdf', 1, '2016-07-20', 0, '0000-00-00', 7),
(10, 9, 10, 'registration card-correction form', 'registration-card-correction-form.pdf', 1, '2016-07-20', 0, '0000-00-00', 7),
(11, 9, 10, 'Hostel Admission Form', 'hostel_adm_form.pdf', 1, '2016-07-20', 0, '0000-00-00', 7),
(12, 9, 10, 'School membership Application Form', 'MbrApp.pdf', 1, '2016-07-20', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE IF NOT EXISTS `foods` (
  `FOOD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_CATEGORY_ID` int(11) NOT NULL,
  `FOOD_NAME` varchar(150) NOT NULL,
  `PRICE` varchar(20) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`FOOD_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`FOOD_ID`, `MENU_CATEGORY_ID`, `FOOD_NAME`, `PRICE`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 1, 'Chicken Wonton', '200', 1, '2016-09-06', 1, '2016-09-06', 7),
(2, 1, 'Prawn Wonton', '250', 1, '2016-09-06', 1, '2016-09-06', 7),
(3, 1, 'Spring:Roll', '230', 1, '2016-09-06', 0, '0000-00-00', 7),
(4, 1, 'C Don Strike', '230', 1, '2016-09-06', 0, '0000-00-00', 7),
(5, 2, 'Chicken Salad', '230', 1, '2016-09-06', 0, '0000-00-00', 7),
(6, 2, 'Prawn Salad', '250', 1, '2016-09-06', 0, '0000-00-00', 7),
(7, 2, 'Mixed Salad', '280', 1, '2016-09-06', 0, '0000-00-00', 7),
(8, 3, 'Chicken Corn Soup', '190', 1, '2016-09-06', 0, '0000-00-00', 7),
(9, 3, 'S.P Corn Soup', '240', 1, '2016-09-06', 0, '0000-00-00', 7),
(10, 3, 'Thai Soup', '240', 1, '2016-09-06', 0, '0000-00-00', 7),
(11, 4, 'Chi Chowmein', '220', 1, '2016-09-06', 0, '0000-00-00', 7),
(12, 4, 'Prawn-Chowmein', '260', 1, '2016-09-06', 0, '0000-00-00', 7),
(13, 4, 'Beef Chowmein', '160', 1, '2016-09-06', 0, '0000-00-00', 7),
(14, 1, 'Frens Fry', '80', 1, '2016-09-06', 0, '0000-00-00', 7),
(15, 1, 'C. Bal', '260', 1, '2016-09-06', 0, '0000-00-00', 7),
(16, 1, 'Chicken Fry', '310', 1, '2016-09-06', 0, '0000-00-00', 7),
(17, 4, 'Vag.Chowmein', '180', 1, '2016-09-06', 0, '0000-00-00', 7),
(18, 2, 'C. Cashnut', '260', 1, '2016-09-06', 0, '0000-00-00', 7),
(19, 2, 'Vag.Chowmein', '180', 1, '2016-09-06', 0, '0000-00-00', 7),
(20, 3, 'Vagetable Clear Soup', '180', 1, '2016-09-06', 0, '0000-00-00', 7),
(21, 3, 'Chicken Vag.Soup', '180', 1, '2016-09-06', 0, '0000-00-00', 7),
(22, 2, 'C.Cashnut', '260', 1, '2016-09-06', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `IMAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_ID` int(11) NOT NULL,
  `SUB_CAT_ID` int(11) NOT NULL,
  `IMAGE_CAPTION` varchar(200) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `PRICE` varchar(100) NOT NULL,
  `IMAGE_LINK` varchar(200) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`IMAGE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`IMAGE_ID`, `CAT_ID`, `SUB_CAT_ID`, `IMAGE_CAPTION`, `DESCRIPTION`, `PRICE`, `IMAGE_LINK`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 8, 1, 'Baila', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '200', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(3, 8, 1, 'Elish Mach', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '120', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(4, 8, 1, 'Chingri Mach', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '120', '7.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(5, 8, 1, 'Chicken masala', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '260', '3.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(6, 8, 1, 'Goru vuna', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '100', '8.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(7, 8, 6, 'Apple Juice', '', '50', '3.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(8, 8, 6, 'Carrot Juice', '', '50', '6.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(9, 8, 6, 'Strawberry Juice', '', '120', '6.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(10, 8, 6, 'Tametu juice', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '120', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(11, 8, 2, 'Chicken shashlik', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '200', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(12, 8, 2, 'Vegetarian Egg Rolls', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '180', '2.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(13, 8, 2, 'Egg Roll King', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '180', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(14, 8, 2, 'Fried Won Ton', '', '180', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(15, 8, 2, 'Shrimp Lo Mein', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '180', '1.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(16, 8, 3, 'Reshmi Kabab', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '250', '2.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(17, 8, 3, 'Chicken Tikka(breast)', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '300', '1.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(18, 8, 3, 'Chicken Boti', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '400', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(19, 8, 3, 'Lahori Fish $9.99', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '350', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(20, 8, 3, 'Chapli Kabab', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '350', '3.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(21, 8, 4, 'Baconator', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '150', '1.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(22, 8, 4, 'Veggie Guacamole Sub', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '200', '6.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(23, 8, 4, 'pizza', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '200', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(24, 8, 4, 'pizza hut menu', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '250', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(25, 8, 4, 'Arby''s: Beef ''n Cheddar', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '300', '2.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(26, 8, 5, 'Coconut Tart', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '180', '3.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(27, 8, 5, 'cake', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '450', '1.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(28, 8, 5, 'cake', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '500', '2.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(29, 8, 5, 'Caterpillar', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '300', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(30, 8, 5, 'Assorted Glazed Donuts', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere nulla aliquid praesentium dolorem commodi illo.', '250', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `menu_category`
--

CREATE TABLE IF NOT EXISTS `menu_category` (
  `MENU_CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(150) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`MENU_CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `menu_category`
--

INSERT INTO `menu_category` (`MENU_CATEGORY_ID`, `NAME`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 'APPERIZERS', 1, '2016-09-06', 1, '2016-09-06', 7),
(2, 'Salads', 1, '2016-09-06', 0, '0000-00-00', 7),
(3, 'Soups', 1, '2016-09-06', 0, '0000-00-00', 7),
(4, 'Chowmein', 1, '2016-09-06', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8 NOT NULL,
  `msg` longtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `name`, `msg`) VALUES
(1, 'shawkat ali', ' উচ্চ মাধ্যমিক, স্নাতক সম্মান ও স্নাতকোত্তর পর্যায়ে বিদ্যালাভের সুষ্ঠু পরিবেশ এখানে রচিত হয়েছে বহু মানুষের ত্যাগে, শ্রমে ও মেধায়। ঢাকা সিটি কলেজের আদর্শ নবীনবিদ্যার্থীদের মানবতা বোধের মন্ত্রে উজ্জীবিত করাসংস্কারমুক্ত স্বাধীন চিন্তার সৎ, সাহসী ও সচেতন প্রজন্ম গড়ে তোলা। বোর্ড ও বিশ্ববিদ্যালয়ের মেধা তালিকায় প্রথম সারিতে স্থান পেলেই যে মানুষ মানুষ হয় না তার প্রমাণ আমরা প্রতিনিয়ত পাচ্ছি। তাই দেশ ও দশের কল্যাণব্রতে স্নিগ্ধ মানব সন্তান আমাদের আজ একান্তভাবে কাম্য। তারাই গড়বে আমাদের কাঙ্খিত সোনার বাংলাদেশ। শিক্ষা আজ পণ্যে রূপান্তরিত হয়েছে। অনেক প্রতিষ্ঠান ডিগ্রি বিক্রি করে মুনাফা লুটে চলেছে। বাজার অর্থনীতি ও বিশ্বায়নের যুগে শিক্ষা প্রতিষ্ঠানের আদর্শে অনড় থেকে নানা প্রতিযোগিতার মধ্য দিয়ে আমরা নিজের ভিত মজবুত রাখবো; এ অঙ্গীকারে আমরা অবিচল। ডিগ্রি লাভের সুযোগ করে দেয়া নয় শুধু, শিক্ষার্থীদের শারীরিক ও মানসিক স্বাস্থ্য পরিচর্যার এক উৎকৃষ্ট কেন্দ্র এই ঢাকা সিটি কলেজ সব সময় নতুন সূর্যের দিকে অগ্রসরমাণ থাকবেএই আমার বিশ্বাস। ');

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE IF NOT EXISTS `noticeboard` (
  `NOTICE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOTICE_TITLE` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `NOTICE_DETAILS` text COLLATE utf8_unicode_ci NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`NOTICE_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `noticeboard`
--

INSERT INTO `noticeboard` (`NOTICE_ID`, `NOTICE_TITLE`, `NOTICE_DETAILS`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 'result', 'Hsc result 2016', 1, '2016-06-04', 1, '2016-06-04', 7),
(5, 'SSC Result', 'SSC result published Tomorrow', 1, '2016-07-14', 0, '0000-00-00', 7),
(4, 'Admission result', 'Admission result published.', 1, '2016-07-14', 1, '2016-07-14', 7),
(6, 'Second Term Exam', 'Second Term exam will held as 06-08-2016', 1, '2016-07-14', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `PAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUB_SUB_CATEGORY_ID` int(11) NOT NULL,
  `PAGE_TITLE` varchar(500) NOT NULL,
  `PAGE_DETAILS` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`PAGE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`PAGE_ID`, `SUB_SUB_CATEGORY_ID`, `PAGE_TITLE`, `PAGE_DETAILS`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 2, 'About Academy', '<P>BCS (Tax) Academy is the apex training institution for the officers and staff of the Taxes Department of National Board of Revenue in Bangladesh. It has been set up with tremendous vision and foresight of expectation.</p>\n\n<p>It performs the critical and overarching goal of developing, enhancing, monitoring and modeling the human capital fortunes of the nation interest by upgrading human capital and functioning as a best think–tank in tax policy and administration. The Academic import proficiency in core competence areas, disseminates knowledge and information about the best practices regarding tax issues and provides an international perspective, high quality professional capabilities and cultural sensitivities to officers.</p>\n\n<p>Besides training, high quality career planning, profiling and continued developments of the Direct Taxes Academy’s responsibility. </p>\n\n<p>Without human resources development and without required logistic facilities the growth of revenue collection will not be possible to maintain.</p>\n\n<p>The officer and staffs working at Taxes Department have no scope of proper and sufficient training, working, seminar and higher education on the respective fields. On the other hand, lack of sufficient logistics in the major crisis of the department.</p>\n', 1, '2016-05-25', 1, '2016-05-31', 7);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `PERMISSION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERMISSION_NAME` varchar(100) NOT NULL COMMENT 'example: create order, edit PI, Create User etc',
  `DETAILS` varchar(250) DEFAULT NULL,
  `GROUP_NAME` varchar(200) DEFAULT NULL,
  `MENU_NAME` varchar(50) NOT NULL,
  `ROUTE_NAME` varchar(100) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | -5=Taking out | -6=Renewed/Replaced | -7=Inactive',
  PRIMARY KEY (`PERMISSION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`PERMISSION_ID`, `PERMISSION_NAME`, `DETAILS`, `GROUP_NAME`, `MENU_NAME`, `ROUTE_NAME`, `PARENT_ID`, `STATUS`) VALUES
(5, 'create_category', NULL, 'category', 'create_category', 'create_category', 0, 1),
(6, 'manage_category', NULL, 'category', 'manage_category', 'manage_category', 0, 1),
(7, 'create_sub_category', NULL, 'category', 'create_sub_category', 'create_sub_category', 0, 1),
(8, 'manage_sub_category', NULL, 'category', 'manage_sub_category', 'manage_sub_category', 0, 1),
(11, 'create_slider', NULL, 'slider', 'add_slider', 'create_slider', 0, 1),
(12, 'manage_slider', NULL, 'slider', 'manage_slider', 'manage_slider', 0, 1),
(15, 'add_images', NULL, 'gallery', 'add_images', 'add_images', 0, 1),
(16, 'manage_gallery', NULL, 'gallery', 'manage_gallery', 'manage_gallery', 0, 1),
(19, 'add_downloads', NULL, 'downloads', 'add_downloads', 'add_downloads', 0, 1),
(20, 'manage_downloads', NULL, 'downloads', 'manage_downloads', 'manage_downloads', 0, 1),
(21, 'add_additional_data', NULL, 'additional', 'add_additional_data', 'add_additional_data', 0, 1),
(22, 'manage_additional_data', NULL, 'additional', 'manage_additional_data', 'manage_additional_data', 0, 1),
(25, 'add_person', NULL, 'persons', 'add_person', 'add_person', 0, 1),
(26, 'manage_person', NULL, 'persons', 'manage_person', 'manage_person', 0, 1),
(27, 'create_sub_sub_category', NULL, 'category', 'create_sub_sub_category', 'create_sub_sub_category', 0, 1),
(28, 'manage_sub_sub_category', NULL, 'category', 'manage_sub_sub_category', 'manage_sub_sub_category', 0, 1),
(29, 'create_page', NULL, 'pages', 'create_page', 'create_page', 0, 1),
(30, 'manage_pages', NULL, 'pages', 'manage_pages', 'manage_pages', 0, 1),
(31, 'manage_user_data', NULL, 'additional', 'manage_user_data', 'manage_user_data', 0, 1),
(74, 'create_user', NULL, 'user', 'create_user', 'create_user', 0, 1),
(75, 'manage_user', NULL, 'user', 'manage_user', 'manage_user', 0, 1),
(76, 'create_role', NULL, 'user', 'create_role', 'create_role', 0, 1),
(77, 'manage_role', NULL, 'user', 'manage_role', 'manage_role', 0, 1),
(78, 'create_menu_category', NULL, 'menu', 'create_menu_category', 'create_menu_category', 0, 1),
(79, 'manage_menu_category', NULL, 'menu', 'manage_menu_category', 'manage_menu_category', 0, 1),
(80, 'create_menu', NULL, 'menu', 'create_menu', 'create_menu', 0, 1),
(81, 'manage_menu', NULL, 'menu', 'manage_menu', 'manage_menu', 0, 1),
(82, 'view_reservation_info', NULL, 'customer_message', 'view_reservation_info', 'view_reservation_info', 0, 1),
(83, 'view_contact_info', NULL, 'customer_message', 'view_contact_info', 'view_contact_info', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `PERSON_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PERSON_TYPE` varchar(50) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `IMAGES` varchar(200) NOT NULL,
  `DETAILS` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`PERSON_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`PERSON_ID`, `PERSON_TYPE`, `NAME`, `IMAGES`, `DETAILS`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 'chairman', 'Chairman Name goes here', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s.', 1, '2016-05-21', 1, '2016-05-22', 7),
(2, 'dg', 'D.G Name goes here', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s.', 1, '2016-05-21', 1, '2016-05-22', 7);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_data`
--

CREATE TABLE IF NOT EXISTS `reservation_data` (
  `RESERVATION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FULL_NAME` varchar(70) NOT NULL,
  `PHONE_1` varchar(18) NOT NULL,
  `OR_DATE` date NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `HOW_MANY` varchar(100) NOT NULL,
  `PHONE_2` varchar(18) NOT NULL,
  `MESSAGE` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`RESERVATION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(100) NOT NULL,
  `DETAILS` varchar(255) DEFAULT NULL,
  `PERMISSION_NAME` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` datetime NOT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL,
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`ROLE_ID`, `ROLE_NAME`, `DETAILS`, `PERMISSION_NAME`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 'Super Admin', NULL, '', 0, '2015-10-03 17:01:53', 1, '2016-06-21 02:51:14', 7),
(2, 'Additional USer', NULL, 'add_additional_data,manage_additional_data,manage_user_data', 1, '2016-06-21 02:46:46', 1, '2016-06-21 02:51:12', 7),
(3, 'Website Controller', NULL, 'add_additional_data,add_downloads,add_images,add_person,create_category,create_page,create_slider,create_sub_category,create_sub_sub_category,manage_additional_data,manage_category,manage_downloads,manage_gallery,manage_pages,manage_person,manage_slider,manage_sub_category,manage_sub_sub_category,manage_user_data', 1, '2016-06-22 05:58:22', NULL, NULL, 7),
(4, 'Student', NULL, 'my_book_request,my_issues_and_returns,my_notifications,send_book_request,view_library_books,view_attendance,view_class_routine,view_mark_sheet,view_notice,view_payment,view_subjects,view_teachers', 1, '2016-07-12 05:07:39', 1, '2016-07-28 05:30:28', 7),
(5, 'Teacher', NULL, 'daily_attendance,manage_attendance,create_class_routine,manage_class_routine,insert_marks,manage_marks,attendance_report,class_wise_marksheet,section_wise_marksheet,student_marksheet,send_sms,manage_assign_subject,manage_assign_teacher,manage_teacher', 1, '2016-07-13 05:11:11', NULL, NULL, 7),
(6, 'Parents', NULL, 'view_attendance_parents,view_class_routine_parents,view_mark_sheet_parents,view_notice_parents,view_payment_parents,view_subjects_parents,view_teachers_parents', 1, '2016-07-13 06:16:23', 1, '2016-07-13 06:51:14', 7),
(7, 'Admin', NULL, 'daily_attendance,manage_attendance,upload_csv_file,create_board,manage_board,create_testimonial,create_transfer_certificate,student_mark_sheet,student_report_card,create_class,create_class_routine,create_section,manage_class,manage_class_routine,manage_section,add_additional_data,add_downloads,add_images,add_person,create_category,create_page,create_slider,create_sub_category,create_sub_sub_category,manage_additional_data,manage_category,manage_downloads,manage_gallery,manage_pages,manage_person,manage_slider,manage_sub_category,manage_sub_sub_category,manage_user_data,create_exam,create_grade,insert_marks,manage_exam_list,manage_grade,manage_marks,add_house,admit_student_to_hostel,assign_house_teacher,manage_checkin,manage_hostel_student,manage_house,manage_house_teacher,student_checkin,add_book,Add_library_member,book_issue,create_book_category,create_writer,general_settings,manage_book,manage_book_category,manage_book_request,manage_issue_and_return,manage_library_member,manage_notification,manage_settings,manage_writer,send_notification,create_parent,manage_parent,create_payment,create_payment_category,manage_payment,manage_payment_category,attendance_report,average_marksheet,class_wise_marksheet,payment_report,section_wise_marksheet,student_marksheet,create_designation,create_notice,create_subject,manage_designation,manage_notice,manage_subject,send_sms,create_staff,manage_staff,add_student_info,admit_student,manage_student_admission,manage_student_info,assign_subject,assign_teacher,create_teacher,manage_assign_subject,manage_assign_teacher,manage_teacher,create_parents,create_role,create_student,create_teacher,create_user,manage_role,manage_user', 1, '2016-07-14 05:24:24', 1, '2016-08-14 08:02:23', 7);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `SLIDER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SLIDER_NAME` varchar(50) NOT NULL,
  `SLIDER_LINK` varchar(200) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SLIDER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`SLIDER_ID`, `SLIDER_NAME`, `SLIDER_LINK`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 'slider 1', '1.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(2, 'slider 2', '2.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(3, 'slider 3', '3.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(4, 'slider 4', '4.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(5, 'slider 5', '5.jpg', 1, '2016-09-06', 0, '0000-00-00', 7),
(6, 'slider 6', '6.jpg', 1, '2016-09-06', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_category` (
  `SUB_CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_ID` int(11) NOT NULL,
  `SUB_CATEGORY_NAME` varchar(50) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SUB_CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`SUB_CATEGORY_ID`, `CAT_ID`, `SUB_CATEGORY_NAME`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 8, 'Bangla', 1, '2016-07-24', 1, '2016-09-05', 7),
(2, 8, 'Chinese', 1, '2016-07-24', 1, '2016-09-05', 7),
(3, 8, 'Barbecue', 1, '2016-07-24', 1, '2016-09-05', 7),
(4, 8, 'Fast Food', 1, '2016-09-05', 0, '0000-00-00', 7),
(5, 8, 'Sweet Bakery', 1, '2016-09-05', 0, '0000-00-00', 7),
(6, 8, 'Juice Bar', 1, '2016-09-05', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_sub_category` (
  `SUB_SUB_CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SUB_CATEGORY_ID` int(11) NOT NULL,
  `SUB_SUB_CATEGORY_NAME` varchar(50) NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`SUB_SUB_CATEGORY_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sub_sub_category`
--

INSERT INTO `sub_sub_category` (`SUB_SUB_CATEGORY_ID`, `SUB_CATEGORY_ID`, `SUB_SUB_CATEGORY_NAME`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 15, 'Academy', 1, '2016-05-23', 0, '0000-00-00', 7),
(3, 15, 'Mission &amp; Vision', 1, '2016-05-23', 0, '0000-00-00', 7),
(4, 15, 'Our Values', 1, '2016-05-23', 0, '0000-00-00', 7),
(5, 16, 'Training One', 1, '2016-05-23', 0, '0000-00-00', 7),
(6, 16, 'Training Two', 1, '2016-05-23', 0, '0000-00-00', 7),
(9, 15, 'Faculty Members', 1, '2016-05-26', 0, '0000-00-00', 7),
(10, 15, 'Citizen Charter', 1, '2016-05-26', 0, '0000-00-00', 7),
(11, 20, 'Course 01', 1, '2016-05-31', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_ID` int(11) DEFAULT NULL,
  `COMPANY_ID` int(11) DEFAULT NULL,
  `STUDENT_ID` int(11) NOT NULL,
  `TEACHER_ID` int(11) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_EMAIL` varchar(50) NOT NULL,
  `USER_PHONE` varchar(50) NOT NULL,
  `USER_TYPE` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(50) NOT NULL,
  `USER_PASSWORD_HISTORY` varchar(250) DEFAULT NULL,
  `CREATED_BY` int(11) DEFAULT NULL,
  `CREATED_DATE` datetime DEFAULT NULL,
  `UPDATED_BY` int(11) DEFAULT NULL,
  `UPDATED_DATE` datetime DEFAULT NULL,
  `STATUS` tinyint(4) NOT NULL COMMENT '1=active | -1=inactive',
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `ROLE_ID`, `COMPANY_ID`, `STUDENT_ID`, `TEACHER_ID`, `PARENT_ID`, `USER_NAME`, `USER_EMAIL`, `USER_PHONE`, `USER_TYPE`, `USER_PASSWORD`, `USER_PASSWORD_HISTORY`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 0, 0, 0, 0, 0, 'Admin', 'admin@base4.com', '', 'admin', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', NULL, 1, '2015-09-16 11:12:13', 1, '2016-08-03 02:17:08', 9),
(4, 3, NULL, 0, 0, 0, 'mh', 'developer.mh.me@gmail.com', '+8801722432578', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', 'Ki6tIkfo7hfTTVmvPsu-ZWwv-qSZKw2i5OPaErEWAF0%2C', 1, '2016-06-22 05:58:45', NULL, '2016-06-22 05:59:23', 7),
(5, 2, NULL, 1, 0, 0, 'Eric Abidal', 'abidal@hotmail.com', '+8801919228690', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', NULL, 1, '2016-07-12 05:04:58', NULL, NULL, 6),
(6, 4, NULL, 2, 0, 0, 'Nayim Khondokar', 'student@base4.com', '+8801733180725', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', 'Ki6tIkfo7hfTTVmvPsu-ZWwv-qSZKw2i5OPaErEWAF0%2C', 1, '2016-07-12 05:08:02', NULL, '2016-07-12 05:09:24', 7),
(7, 5, NULL, 0, 1, 0, 'Bijoy Kumar Roy', 'teacher@base4.com', '01727743522', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', 'MHOmrGVmfGwS1B-CO3YWyY6JwBHx_trqYr4m7pBMVPQ%2C', 1, '2016-07-13 05:11:27', NULL, '2016-07-13 05:14:32', 7),
(8, 6, NULL, 2, 0, 2, 'Cristiano Coman', 'parents@base4.com', '01744724905', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', 'MHOmrGVmfGwS1B-CO3YWyY6JwBHx_trqYr4m7pBMVPQ%2C', 1, '2016-07-13 06:17:31', NULL, '2016-07-13 06:20:27', 7),
(9, 7, NULL, 0, 0, 0, 'Admin', 'admin@base4bd.com', '', 'admin', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', NULL, 1, '2016-07-11 00:00:00', 9, '2016-08-13 06:02:46', 7),
(10, 4, NULL, 9, 0, 0, 'Adnan Sami', 'adnansami@gmail.com', '019864588', '', 'AvPzL4oU37R9-2KTQOqYgMLWTcsCmFG3U8jLemJx4V8', NULL, 1, '2016-07-28 06:37:51', NULL, NULL, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `MOBILE` varchar(50) NOT NULL,
  `SUBJECT` varchar(150) NOT NULL,
  `MESSAGE` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`ID`, `NAME`, `EMAIL`, `MOBILE`, `SUBJECT`, `MESSAGE`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(2, 'Abul Kasem', 'abulkasem@gmail.com', '017485458', 'Exam', 'Hello', 0, '2016-07-14', 0, '0000-00-00', 7),
(3, 'Rayhan', 'rayhan@gmail.com', '0', 'test', 'Hi, Dear', 0, '2016-08-16', 0, '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `VIDEO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CAT_ID` int(11) NOT NULL,
  `SUB_CAT_ID` int(11) NOT NULL,
  `CAPTION` varchar(200) NOT NULL,
  `EMBED_CODE` text NOT NULL,
  `DETAILS` text NOT NULL,
  `CREATED_BY` int(11) NOT NULL,
  `CREATED_DATE` date NOT NULL,
  `UPDATED_BY` int(11) NOT NULL,
  `UPDATED_DATE` date NOT NULL,
  `STATUS` int(11) NOT NULL,
  PRIMARY KEY (`VIDEO_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`VIDEO_ID`, `CAT_ID`, `SUB_CAT_ID`, `CAPTION`, `EMBED_CODE`, `DETAILS`, `CREATED_BY`, `CREATED_DATE`, `UPDATED_BY`, `UPDATED_DATE`, `STATUS`) VALUES
(1, 10, 14, 'BCS Tax Video', 'https://www.youtube.com/embed/qwrpf3duu5E', 'my video', 1, '2016-05-20', 1, '2016-05-26', 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
