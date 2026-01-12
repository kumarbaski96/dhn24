-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 11:32 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `heading`, `description`, `content`, `image`, `publish_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'DHN24 News Channel ', 'About Us – DHN24 News Channel', 'DHN24 News Channel is a dedicated digital news platform committed to delivering accurate, timely, and unbiased news to its viewers and readers across India and beyond. Established with the vision of strengthening democratic values through responsible journalism, DHN24 has steadily grown into a trusted source of information for people who seek truth, clarity, and depth in news reporting.\r\n\r\nIn today’s fast-paced digital era, information travels faster than ever before. DHN24 News Channel understands the responsibility that comes with this speed. Our core mission is to ensure that every piece of news published on our platform is verified, factual, and presented with integrity. We firmly believe that journalism is not merely about breaking news first, but about breaking it right. Accuracy, transparency, and ethical reporting form the foundation of our editorial policy.\r\n\r\nDHN24 covers a wide range of news categories including national and international affairs, politics, education, health, business, technology, sports, entertainment, and social issues. Special emphasis is given to regional and grassroots news that often remains underrepresented in mainstream media. By highlighting local voices and real-life issues, DHN24 aims to bridge the gap between communities and decision-makers, ensuring that important stories reach the right audience.\r\n\r\nOur team consists of experienced journalists, editors, content creators, and technical professionals who work tirelessly around the clock. Each member of the DHN24 team shares a common commitment: to serve the public interest. Our reporters follow strict journalistic standards and are trained to present multiple perspectives on an issue, enabling viewers to form their own informed opinions. Sensationalism, misinformation, and biased narratives have no place in our newsroom.\r\n\r\nDHN24 News Channel also embraces modern technology to enhance the news-consumption experience. Through our digital platform, readers can access news anytime, anywhere. We actively use multimedia tools such as videos, images, live updates, and social media integration to make news more engaging and accessible, especially for younger audiences. At the same time, we remain conscious of our social responsibility and ensure that content is respectful, inclusive, and culturally sensitive.\r\n\r\nAnother important aspect of DHN24 is public engagement. We encourage constructive dialogue, feedback, and participation from our audience. Viewers are not just passive consumers of news; they are active stakeholders in the information ecosystem. DHN24 provides space for public opinions, discussions, and awareness campaigns that contribute positively to society.\r\n\r\nLooking ahead, DHN24 News Channel aims to expand its reach while maintaining the highest standards of journalism. Our goal is to become a benchmark for credible digital news reporting, driven by truth and powered by trust. We aspire to be a voice for the people, a mirror to society, and a platform that upholds the values of free and fair journalism.\r\n\r\nDHN24 is more than just a news channel—it is a commitment to honesty, responsibility, and the relentless pursuit of truth. As we move forward, we remain dedicated to informing, educating, and empowering our audience, because an informed society is the cornerstone of a strong democracy.', '1766076840_g5.jpg', '2023-01-12', 'active', '2025-12-17 13:27:08', '2026-01-05 19:20:54');

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
(1, 'admin', 'baski', 'baski123.kumar@gmail.com', 'Admin@123', 'Admin@123', 'info@info.com', 'http://www.facebook.com/', 'https://twitter.com/', 'http://www.linkedin.com/', '7488162756', '7979031975', 'DHN24, Hirapur,Dhanbad,Near Telipara', 'India', 'Jharkhand', 'Dhanbad', '826001', 1, '0000-00-00 00:00:00', 'info@info.com', 'info@info.com');

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
-- Table structure for table `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `menu_name` varchar(100) DEFAULT NULL,
  `menu_link` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `menu_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `menu_name`, `menu_link`, `icon`, `status`, `menu_order`) VALUES
(1, 0, 'Dashboard', 'dashboard.php', NULL, 1, 1),
(2, 0, 'Admin Management', '#', NULL, 1, 2),
(3, 0, 'Website Management', '#', NULL, 1, 3),
(4, 0, 'News Management', '#', NULL, 1, 4),
(5, 0, 'Logout', 'logout.php', NULL, 1, 10),
(6, 2, 'Admin Details', 'admin_details.php', NULL, 1, 1),
(7, 3, 'About Us', 'manage_about.php', NULL, 1, 1),
(8, 3, 'Services', 'manage_servises.php', NULL, 1, 2),
(9, 3, 'Gallery', 'manage_gallery.php', NULL, 1, 3),
(10, 3, 'Header', 'manage_header.php', NULL, 1, 4),
(11, 3, 'Logo', 'manage_logo.php', NULL, 1, 5),
(12, 3, 'Social Network', 'manage_social_network.php', NULL, 1, 6),
(13, 4, 'Manage News', 'manage_news.php', NULL, 1, 1),
(14, 4, 'News Comments', 'manage_news_comment.php', NULL, 1, 2),
(15, 3, 'Manage contact Message', 'manage_contact_message.php', NULL, 1, 15),
(16, 2, 'Manage Admin Menu', 'manage_admin_menu.php', NULL, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `status`) VALUES
(5, 'sanoj', 'sanoj12.kumar@gmail.com', 'Just like that', 'help me', '2026-01-04 22:01:04', 0),
(6, 'sanoj', 'sanoj12.kumar@gmail.com', 'Just like that', 'help me', '2026-01-04 22:09:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `description`, `image`, `status`) VALUES
(2, 'Digital & Mobile', 'Mobile App & Digital Marketing', 'g8.jpg', 1),
(3, 'Design1', 'UI/UX & Graphic Design1', '17682509471766076840_g5.jpg', 1),
(4, 'Development', 'Software Development', '1768251072g4.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `header_menu`
--

CREATE TABLE `header_menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_link` varchar(150) NOT NULL,
  `menu_order` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `header_menu`
--

INSERT INTO `header_menu` (`id`, `menu_name`, `menu_link`, `menu_order`, `status`, `parent_id`) VALUES
(1, 'Home', 'index.php', 1, 1, 0),
(2, 'About', 'about.php', 2, 1, 0),
(3, 'Services', 'services.php', 3, 1, 0),
(4, 'Contact', 'contact.php', 4, 1, 0),
(5, 'Admin Login', 'login.php', 5, 1, 0),
(10, 'galery', 'galery.php', 8, 1, 0),
(12, 'galery1', 'galery1.php', 9, 1, 10),
(13, 'galery2', 'galery2', 10, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `text_logo` varchar(100) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `logo`, `text_logo`, `link`, `status`) VALUES
(1, 'assets/images/dhn24logo.jpg', 'DHN24', 'index.php', 1);

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
(34, 'लेखन एक कला है और ये कला किसी भी भाषा में क्यों न हो विचार और लफ्ज़ो का सटीक इस्तमाल महत्व रखता है।', '2026-01-07 16:21:38', 'लेखन एक कला है और ये कला किसी भी भाषा में क्यों न हो विचार और लफ्ज़ो का सटीक इस्तमाल महत्व रखता है। अगर आप इस कला को समझते हैं, तो आप भी कंटेंट राइटर बन सकते हैं। डिजिटल युग के साथ-साथ कंटेंट्स राइटर्स की मांग भी बढ़ रही है, क्योंकि आज के समय में इंटरनेट मार्केटिंग के माध्यम से ही लोग अपने व्यापार और अपनी कला का ऑनलाइन प्रमोशन करते हैं। यह सब करने के लिए आपका लिखा हुआ कंटेंट बहुत महत्वपूर्ण भूमिका निभाता है। जिसको निभाता है एक कंटेंट राइटर।\r\n\r\nजैसा कि हमने बात की के लेखन की कला किसी भी भाषा में हो लेकिन शब्दों का इस्तमाल सही जगह पर होना आवश्यक है जिसमें और भी कई फैक्टर्स आ जाते हैं। तो इस ब्लॉग में मूलतः हम हिंदी भाषी लेखन की बात करेंगे। तो अगर आप एक हिंदी कंटेंट राइटर बनना चाहतें है तो ये ब्लॉग आपके लिए है। हमारा यह ब्लॉग आपके सपनों को पूरा करने में अवश्य मददगार साबित होगा।', '1767728435_g5.jpg', 'https://www.youtube.com/watch?v=tT3gUj6cq2U', 1),
(36, 'Google इनपुट उपकरण को ऑनलाइन आज़माएं', '2026-01-12 20:03:25', 'Google इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएंGoogle इनपुट उपकरण को ऑनलाइन आज़माएं', '1767729411_4.jpg', 'https://www.youtube.com/watch?v=MnTURHlzNyg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `news_comments`
--

CREATE TABLE `news_comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_comments`
--

INSERT INTO `news_comments` (`id`, `news_id`, `name`, `comment`, `created_at`) VALUES
(7, 36, 'Baski Kumar Saw', 'hello', '2026-01-07 16:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `news_reactions`
--

CREATE TABLE `news_reactions` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `reaction` enum('like','dislike') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news_reactions`
--

INSERT INTO `news_reactions` (`id`, `news_id`, `ip_address`, `reaction`) VALUES
(3, 36, '::1', 'like'),
(4, 34, '::1', 'like');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(150) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_slug` varchar(255) DEFAULT NULL,
  `page_image` varchar(255) DEFAULT NULL,
  `page_description` text DEFAULT NULL,
  `page_content` longtext DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `page_title`, `page_slug`, `page_image`, `page_description`, `page_content`, `status`, `created_at`) VALUES
(1, 'hello.php', 'hello', 'hello-php', '1.jpg', 'tis is for hello', 'my data ', 'active', '2026-01-11 07:34:31'),
(4, 'hello.php', 'hello', 'hello-php-1', '2.jpg', 'hello from baski', 'this is my data', 'active', '2026-01-11 07:38:11'),
(5, NULL, 'my data', 'my-data', '2.jpg', 'hello ', 'data', 'active', '2026-01-11 08:06:22'),
(6, NULL, 'gallery', 'gallery', '1.jpg', 'This is my gallery', 'here i will edit my photo', 'active', '2026-01-12 20:11:24');

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
(7, 'baski', 'baski12.kumar@gmail.com', '7488162756', 'admin@123', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `social_network`
--

CREATE TABLE `social_network` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_network`
--

INSERT INTO `social_network` (`id`, `name`, `url`, `icon`, `status`) VALUES
(1, 'facebook', 'https://facebook.com/yourpage1', 'fa-facebook', 1),
(2, 'youtube', 'https://youtube.com/@yourchannel1', 'fa-youtube', 1),
(3, 'instagram', 'https://instagram.com/yourpage', 'fa-instagram', 1),
(6, 'whatsapp', 'https://web.whatsapp.com/', 'fa-whatsapp', 1);

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
-- Indexes for table `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_menu`
--
ALTER TABLE `header_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_comments`
--
ALTER TABLE `news_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_reactions`
--
ALTER TABLE `news_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reaction` (`news_id`,`ip_address`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_slug` (`page_slug`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uname` (`uname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `social_network`
--
ALTER TABLE `social_network`
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
-- AUTO_INCREMENT for table `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `header_menu`
--
ALTER TABLE `header_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `news_comments`
--
ALTER TABLE `news_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news_reactions`
--
ALTER TABLE `news_reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
