-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 07:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhn24`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `heading`, `description`, `content`, `image`, `publish_date`, `status`, `created_at`) VALUES
(1, 'Ask us about design, Digital marketing, Being small we can go into details.', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.', 'Nulla mollis dapibus nunc, ut rhoncus turpis sodales quis. Integer sit amet mattis quam.', '1766076840_g5.jpg', '2023-01-12', 'active', '2025-12-17 13:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `off_password` varchar(100) NOT NULL,
  `alt_email` varchar(200) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `linked_in` varchar(255) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `add_date` datetime NOT NULL,
  `contactus` varchar(100) NOT NULL,
  `feedback` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `admin_name`, `email`, `password`, `off_password`, `alt_email`, `facebook`, `twitter`, `linked_in`, `mobile_no`, `phone_no`, `address`, `country`, `state`, `city`, `zip`, `status`, `add_date`, `contactus`, `feedback`) VALUES
(1, 'admin', 'DHN24', 'dhanbad24news@gmail.com', 'eb0a191797624dd3a48fa681d3061212', 'eb0a191797624dd3a48fa681d3061212', 'info@info.com', 'http://www.facebook.com/', 'https://twitter.com/', 'http://www.linkedin.com/', '9334733888', '7979031975', 'Eweb Bazar karmik nagar near DPs Dhanbad Jharkhandpin -826004 house no-13', 'India', 'Jharkhand', 'Dhanbad', '826001', 1, '0000-00-00 00:00:00', 'info@info.com', 'info@info.com');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`) VALUES
(1, 'admin', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `header_menu`
--

CREATE TABLE `header_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '1 for ecours & 0 for normal menu',
  `editable` int(11) NOT NULL DEFAULT 1 COMMENT '0 for not editable & 1 for editable',
  `precedence` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0 for blocked & 1 for unblocked'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `header_menu`
--

INSERT INTO `header_menu` (`id`, `name`, `link`, `type`, `editable`, `precedence`, `status`) VALUES
(1, 'Home', 'index', 0, 1, 1, 1),
(2, 'About', 'about', 0, 1, 2, 1),
(3, 'Gallery', 'gallery', 0, 1, 3, 1),
(4, 'Contact', 'contact', 0, 1, 4, 1),
(5, 'Reservation', 'reservation', 0, 1, 5, 0),
(6, 'Contacts', 'contact', 0, 1, 6, 0),
(7, 'Charting', '', 0, 1, 7, 0),
(8, 'Videos', '', 0, 1, 8, 0),
(9, 'Photos', '', 0, 1, 9, 0),
(10, 'Ask Questions', '', 0, 1, 10, 0),
(11, 'Blog', '', 0, 1, 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `news_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `content` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `heading`, `news_date`, `content`, `img`, `video`, `status`) VALUES
(4, '1 लेखन एक कला है और ये कला किसी भी भाषा में क्यों न हो विचार और लफ्ज़ो का सटीक इस्तमाल महत्व रखता है।', '2025-12-15 20:24:36', 'लेखन एक कला है और ये कला किसी भी भाषा में क्यों न हो विचार और लफ्ज़ो का सटीक इस्तमाल महत्व रखता है। अगर आप इस कला को समझते हैं, तो आप भी कंटेंट राइटर बन सकते हैं। डिजिटल युग के साथ-साथ कंटेंट्स राइटर्स की मांग भी बढ़ रही है, क्योंकि आज के समय में इंटरनेट मार्केटिंग के माध्यम से ही लोग अपने व्यापार और अपनी कला का ऑनलाइन प्रमोशन करते हैं। यह सब करने के लिए आपका लिखा हुआ कंटेंट बहुत महत्वपूर्ण भूमिका निभाता है। जिसको निभाता है एक कंटेंट राइटर।\n\nजैसा कि हमने बात की के लेखन की कला किसी भी भाषा में हो लेकिन शब्दों का इस्तमाल सही जगह पर होना आवश्यक है जिसमें और भी कई फैक्टर्स आ जाते हैं। तो इस ब्लॉग में मूलतः हम हिंदी भाषी लेखन की बात करेंगे। तो अगर आप एक हिंदी कंटेंट राइटर बनना चाहतें है तो ये ब्लॉग आपके लिए है। हमारा यह ब्लॉग आपके सपनों को पूरा करने में अवश्य मददगार साबित होगा।', '1765753699_Photo.PNG', 'https://www.youtube.com/watch?v=tT3gUj6cq2U', 1),
(5, 'Google इनपुट उपकरण को ऑनलाइन आज़माएं', '2025-12-15 20:26:49', 'Google इनपुट उपकरण आपके द्वारा चुनी गई भाषा में वेब पर कहीं भी लिखना आसान बनाता है. और जानें\r\n\r\nइसे आज़माने के लिए, नीचे अपनी भाषा और इनपुट उपकरण चुनें और लिखना आरंभ करें.', '1765826113_2.jpg', 'https://www.youtube.com/watch?v=9UNIK5wIKBU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `short_desc` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `service_list` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `short_desc`, `image`, `icon`, `service_list`, `status`) VALUES
(2, 'Digital & Mobile', 'Consectetur adipisicing elit, sed do eiusmod tempor', 'g8.jpg', 'fa-cog', 'Web Design,UI/UX Design,Identity Branding,Photography', 1),
(3, 'Design1', 'Consectetur adipisicing elit, sed do eiusmod tempor', 'g6.jpg', 'fa-cube', 'Web Design,UI/UX Design,Identity Branding,Photography', 1),
(4, 'Development', 'Consectetur adipisicing elit, sed do eiusmod tempor', 'g7.jpg', 'fa-diamond', 'Web Design,UI/UX Design,Identity Branding,Photography', 1);

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(10) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `confpass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `uname`, `email`, `mobile`, `pass`, `confpass`) VALUES
(0, 'baski', 'baski12.kumar@gmail.com', '7488162156', 'Sanoj@1992', 'Sanoj@1992');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_menu`
--
ALTER TABLE `header_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
