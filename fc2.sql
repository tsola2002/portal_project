

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(140) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(180) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `zipcode` varchar(30) NOT NULL,
  `userpic` varchar(150) NOT NULL DEFAULT 'no-pic.png',
  `city` varchar(45) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  `access` varchar(150) DEFAULT '0',
  `last_active` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` int(11) NOT NULL,
  `name` varchar(140) DEFAULT NULL,
  `client_id` varchar(140) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `zipcode` varchar(30) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  `website` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `core`
--

CREATE TABLE IF NOT EXISTS `core` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` char(10) NOT NULL DEFAULT '0',
  `domain` varchar(65) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `tax` varchar(5) DEFAULT '0',
  `currency` varchar(20) DEFAULT NULL,
  `autobackup` int(11) DEFAULT NULL,
  `cronjob` int(11) DEFAULT NULL,
  `last_cronjob` int(11) DEFAULT NULL,
  `last_autobackup` int(11) DEFAULT NULL,
  `invoice_terms` mediumtext,
  `company_reference` int(6) DEFAULT NULL,
  `project_reference` int(6) DEFAULT NULL,
  `invoice_reference` int(6) DEFAULT NULL,
  `ticket_reference` int(10) DEFAULT NULL,
  `subscription_reference` int(6) DEFAULT NULL,
  `date_format` varchar(20) DEFAULT NULL,
  `date_time_format` varchar(20) DEFAULT NULL,
  `invoice_mail_subject` varchar(150) DEFAULT NULL,
  `pw_reset_mail_subject` varchar(150) DEFAULT NULL,
  `pw_reset_link_mail_subject` varchar(150) DEFAULT NULL,
  `credentials_mail_subject` varchar(150) DEFAULT NULL,
  `notification_mail_subject` varchar(150) DEFAULT NULL,
  `language` varchar(150) DEFAULT NULL,
  `invoice_address` varchar(200) DEFAULT NULL,
  `invoice_city` varchar(200) DEFAULT NULL,
  `invoice_contact` varchar(200) DEFAULT NULL,
  `invoice_tel` varchar(50) DEFAULT NULL,
  `subscription_mail_subject` varchar(250) DEFAULT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `template` varchar(200) DEFAULT 'default',
  `paypal` varchar(5) DEFAULT '1',
  `paypal_currency` varchar(200) DEFAULT 'EUR',
  `paypal_account` varchar(200) DEFAULT 'luxsys@luxsys-apps.com',
  `invoice_logo` varchar(150) DEFAULT 'assets/blackline/img/invoice_logo.png',
  `pc` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `core`
--

INSERT INTO `core` (`id`, `version`, `domain`, `email`, `company`, `tax`, `currency`, `autobackup`, `cronjob`, `last_cronjob`, `last_autobackup`, `invoice_terms`, `company_reference`, `project_reference`, `invoice_reference`, `ticket_reference`, `subscription_reference`, `date_format`, `date_time_format`, `invoice_mail_subject`, `pw_reset_mail_subject`, `pw_reset_link_mail_subject`, `credentials_mail_subject`, `notification_mail_subject`, `language`, `invoice_address`, `invoice_city`, `invoice_contact`, `invoice_tel`, `subscription_mail_subject`, `logo`, `template`, `paypal`, `paypal_currency`, `paypal_account`, `invoice_logo`, `pc`) VALUES
(1, '2.0.4', 'http://www.yoursite.com/FC/', 'youremail@mail.com', 'your business', '0', '£', 1, 1, 0, 0, 'Thank you for your business. We do expect payment within {due_date}, so please process this invoice within that time.', 41001, 51001, 31001, 10000, 61001, 'Y/m/d', 'H:i', 'New Invoice', 'Password Reset', 'Password Reset', 'Login Details', 'Notification', 'english', 'address', 'city', 'name', '123456789', 'New Subscription', 'files/media/sooi_logo.jpg', 'blackline', '0', 'GBP', '', 'assets/blackline/img/invoice_logo.png', '535ea320-fe8f-40a4-b5dd-844f42ab22b7');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `issue_date` varchar(20) DEFAULT NULL,
  `due_date` varchar(20) DEFAULT NULL,
  `sent_date` varchar(20) DEFAULT NULL,
  `paid_date` varchar(20) DEFAULT NULL,
  `terms` mediumtext,
  `discount` varchar(50) DEFAULT '0',
  `subscription_id` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_has_items`
--

CREATE TABLE IF NOT EXISTS `invoice_has_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` char(11) DEFAULT NULL,
  `description` mediumtext,
  `value` float DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `inactive` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT '0',
  `media_id` int(11) DEFAULT '0',
  `from` varchar(120) DEFAULT NULL,
  `text` text,
  `datetime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT '0',
  `link` varchar(250) DEFAULT '0',
  `type` varchar(250) DEFAULT '0',
  `icon` varchar(150) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `link`, `type`, `icon`, `sort`) VALUES
(1, 'Dashboard', 'dashboard', 'main', 'icon-th', 1),
(2, 'Messages', 'messages', 'main', 'icon-inbox', 2),
(3, 'Projects', 'projects', 'main', 'icon-briefcase', 3),
(4, 'Clients', 'clients', 'main', 'icon-user', 4),
(5, 'Invoices', 'invoices', 'main', 'icon-list-alt', 5),
(6, 'Items', 'items', 'main', 'icon-file', 7),
(7, 'Quotations', 'quotations', 'main', 'icon-list-alt', 8),
(8, 'Subscriptions', 'subscriptions', 'main', 'icon-calendar', 6),
(9, 'Settings', 'settings', 'main', 'icon-cog', 20),
(10, 'QuickAccess', 'quickaccess', 'widget', NULL, 50),
(11, 'User Online', 'useronline', 'widget', NULL, 51),
(12, 'Projects', 'cprojects', 'client', 'icon-briefcase', 2),
(13, 'Invoices', 'cinvoices', 'client', 'icon-list-alt', 3),
(14, 'Messages', 'cmessages', 'client', 'icon-inbox', 1),
(15, 'Subscriptions', 'csubscriptions', 'client', 'icon-calendar', 4);

-- --------------------------------------------------------

--
-- Table structure for table `privatemessages`
--

CREATE TABLE IF NOT EXISTS `privatemessages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(150) NOT NULL,
  `sender` varchar(250) NOT NULL,
  `recipient` varchar(250) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `time` varchar(100) NOT NULL,
  `conversation` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` int(11) DEFAULT NULL,
  `name` varchar(65) DEFAULT NULL,
  `description` text,
  `start` varchar(20) DEFAULT NULL,
  `end` varchar(20) DEFAULT NULL,
  `progress` decimal(3,0) DEFAULT NULL,
  `phases` varchar(150) DEFAULT NULL,
  `tracking` int(11) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `datetime` int(11) DEFAULT NULL,
  `sticky` enum('1','0') DEFAULT '0',
  `category` varchar(150) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `progress_calc` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_projects_clients1` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_files`
--

CREATE TABLE IF NOT EXISTS `project_has_files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `client_id` int(10) DEFAULT '0',
  `type` varchar(80) DEFAULT '0',
  `name` varchar(120) DEFAULT '0',
  `filename` varchar(150) DEFAULT '0',
  `savename` varchar(200) DEFAULT '0',
  `description` text,
  `phase` varchar(100) DEFAULT '0',
  `date` varchar(50) DEFAULT '0',
  `download_counter` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=300 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_tasks`
--

CREATE TABLE IF NOT EXISTS `project_has_tasks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) DEFAULT '0',
  `name` varchar(250) DEFAULT '0',
  `user_id` int(10) DEFAULT '0',
  `status` varchar(50) DEFAULT '0',
  `public` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_has_workers`
--

CREATE TABLE IF NOT EXISTS `project_has_workers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `pw_reset`
--

CREATE TABLE IF NOT EXISTS `pw_reset` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) DEFAULT '0',
  `timestamp` varchar(250) DEFAULT '0',
  `token` varchar(250) DEFAULT '0',
  `user` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q1` varchar(50) DEFAULT NULL,
  `q2` varchar(50) DEFAULT NULL,
  `q3` varchar(50) DEFAULT NULL,
  `q4` varchar(150) DEFAULT NULL,
  `q5` text,
  `q6` varchar(50) DEFAULT NULL,
  `company` varchar(150) DEFAULT '-',
  `fullname` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `zip` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `comment` text,
  `date` varchar(50) DEFAULT NULL,
  `status` varchar(150) DEFAULT '0',
  `user_id` int(50) DEFAULT '0',
  `replied` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `reference` varchar(50) DEFAULT NULL,
  `company_id` int(10) DEFAULT '0',
  `status` varchar(50) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `issue_date` varchar(20) DEFAULT NULL,
  `end_date` varchar(20) DEFAULT NULL,
  `frequency` varchar(20) DEFAULT NULL,
  `next_payment` varchar(20) DEFAULT NULL,
  `terms` mediumtext,
  `discount` varchar(50) DEFAULT '0',
  `subscribed` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_has_items`
--

CREATE TABLE IF NOT EXISTS `subscription_has_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` char(11) DEFAULT NULL,
  `description` mediumtext,
  `value` float DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `firstname` varchar(120) DEFAULT NULL,
  `lastname` varchar(120) DEFAULT NULL,
  `hashed_password` varchar(128) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `status` enum('active','inactive','deleted') DEFAULT NULL,
  `admin` enum('0','1') DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `userpic` varchar(250) DEFAULT 'no-pic.png',
  `title` varchar(150) NOT NULL,
  `access` varchar(150) NOT NULL DEFAULT '1,2',
  `last_active` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `hashed_password`, `email`, `status`, `admin`, `created`, `userpic`, `title`, `access`, `last_active`, `last_login`) VALUES
(9, 'admin', 'admin', 'dev', '34081480e8bbc2ab6ed3f12d2ee69c238885ff32892176e71af3d4daaaab20298e7a77318af1a46ee5bd3431df67b28461bf310a333f6801fc189f31333fce38', 'youremail@mail.com', 'active', '1', '2013-03-22 22:13:03', 'no-pic.png', 'dev', '1,2,3,4,5,8,6,7,9,10,11', '1363990674', '1363990605');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
