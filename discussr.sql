-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2018 at 12:14 AM
-- Server version: 10.1.29-MariaDB-6
-- PHP Version: 7.2.4-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discussr`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussr_categories`
--

CREATE TABLE `discussr_categories` (
  `sqlid` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `agelimit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussr_categories`
--

INSERT INTO `discussr_categories` (`sqlid`, `parent`, `name`, `agelimit`) VALUES
(2, NULL, 'Anime', 16);

-- --------------------------------------------------------

--
-- Table structure for table `discussr_posts`
--

CREATE TABLE `discussr_posts` (
  `sqlid` int(11) NOT NULL,
  `thread` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createTime` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussr_posts`
--

INSERT INTO `discussr_posts` (`sqlid`, `thread`, `createdBy`, `createTime`, `content`, `rating`) VALUES
(1, 1, 2, 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec libero arcu, fringilla sed suscipit at, efficitur in turpis. Duis iaculis tempus magna a blandit. In hac habitasse platea dictumst. Duis ut interdum lorem, eu interdum purus. Sed pulvinar ex sit amet metus porta, id eleifend massa dapibus. Integer fermentum tortor a tellus pellentesque, eu cursus elit rhoncus. Donec iaculis lorem sed nunc aliquam pellentesque. Pellentesque erat tellus, sollicitudin eget consectetur a, sollicitudin ut nisl. Morbi sed est vitae erat suscipit viverra ac sit amet sem. Pellentesque eget leo suscipit, dapibus metus nec, viverra massa. Integer tempor consectetur auctor.\r\n\r\nMaecenas cursus dignissim lacus vitae maximus. In consequat, sapien et egestas sollicitudin, mauris arcu semper turpis, vitae tincidunt mi metus non risus. Nullam sit amet pretium enim. Aliquam vitae neque laoreet augue pretium sagittis a non enim. Donec vitae mattis sem. Nullam venenatis mauris id ex mattis lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lacinia mauris nibh. Aenean auctor mi quis justo facilisis, sed porttitor purus ultrices. Duis auctor nulla ac sem elementum, non fermentum tortor posuere. Nunc fermentum ac risus et interdum.\r\n\r\nPellentesque sodales eros a ipsum laoreet, at cursus velit fringilla. Nulla et justo id augue laoreet rhoncus sit amet sed nisl. Donec malesuada dolor nec mauris vulputate feugiat. Nullam auctor odio nec nulla dapibus aliquam. Cras bibendum lorem nunc, ac volutpat nisi dapibus sit amet. Vivamus mollis ex sit amet elit congue, in suscipit ante dictum. Ut id nisi dictum, blandit massa at, bibendum turpis. Vestibulum cursus vulputate dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus at dapibus magna.', 1),
(2, 1, 2, 0, 'Teine vastus threadile', 2);

-- --------------------------------------------------------

--
-- Table structure for table `discussr_threads`
--

CREATE TABLE `discussr_threads` (
  `sqlid` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `name` text NOT NULL,
  `content` mediumtext NOT NULL,
  `rating` int(11) NOT NULL,
  `createTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussr_threads`
--

INSERT INTO `discussr_threads` (`sqlid`, `createdBy`, `categorie`, `name`, `content`, `rating`, `createTime`) VALUES
(1, 2, 1, 'Cool new anime series', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec libero arcu, fringilla sed suscipit at, efficitur in turpis. Duis iaculis tempus magna a blandit. In hac habitasse platea dictumst. Duis ut interdum lorem, eu interdum purus. Sed pulvinar ex sit amet metus porta, id eleifend massa dapibus. Integer fermentum tortor a tellus pellentesque, eu cursus elit rhoncus. Donec iaculis lorem sed nunc aliquam pellentesque. Pellentesque erat tellus, sollicitudin eget consectetur a, sollicitudin ut nisl. Morbi sed est vitae erat suscipit viverra ac sit amet sem. Pellentesque eget leo suscipit, dapibus metus nec, viverra massa. Integer tempor consectetur auctor.\r\n\r\nMaecenas cursus dignissim lacus vitae maximus. In consequat, sapien et egestas sollicitudin, mauris arcu semper turpis, vitae tincidunt mi metus non risus. Nullam sit amet pretium enim. Aliquam vitae neque laoreet augue pretium sagittis a non enim. Donec vitae mattis sem. Nullam venenatis mauris id ex mattis lacinia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lacinia mauris nibh. Aenean auctor mi quis justo facilisis, sed porttitor purus ultrices. Duis auctor nulla ac sem elementum, non fermentum tortor posuere. Nunc fermentum ac risus et interdum.\r\n\r\nPellentesque sodales eros a ipsum laoreet, at cursus velit fringilla. Nulla et justo id augue laoreet rhoncus sit amet sed nisl. Donec malesuada dolor nec mauris vulputate feugiat. Nullam auctor odio nec nulla dapibus aliquam. Cras bibendum lorem nunc, ac volutpat nisi dapibus sit amet. Vivamus mollis ex sit amet elit congue, in suscipit ante dictum. Ut id nisi dictum, blandit massa at, bibendum turpis. Vestibulum cursus vulputate dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus at dapibus magna.\r\n\r\nDonec accumsan metus magna, ac dapibus nibh tempor et. Fusce ultricies magna ac semper mollis. Cras luctus dui quis quam sollicitudin, in tempus quam laoreet. Aenean viverra quis turpis eu fringilla. Aenean ut elementum eros. Maecenas semper mattis efficitur. Integer eu sagittis orci. Donec ac volutpat massa. Integer ac risus id nisl feugiat gravida. Donec accumsan euismod neque, a aliquet nisi egestas eu. Morbi posuere lacus quis nunc molestie aliquet non quis eros. Suspendisse potenti.\r\n\r\nAenean porta mollis sem, in euismod nunc dictum nec. Ut in tristique diam. Suspendisse fermentum, dolor ut luctus aliquet, nisi dui volutpat massa, vitae euismod sem ipsum at ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec faucibus justo felis, id accumsan eros dapibus ac. Duis nec neque a justo auctor iaculis. Quisque lobortis congue mi, eu congue nisl maximus eget. Integer ac maximus nunc, ac commodo arcu. In volutpat nibh sit amet ligula convallis scelerisque. Pellentesque sollicitudin sollicitudin scelerisque. Vestibulum accumsan, nibh sed interdum sollicitudin, lectus purus volutpat tortor, a eleifend lacus est quis metus. Nullam non vehicula mi, sit amet eleifend eros. Quisque ut convallis metus. ', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `discussr_users`
--

CREATE TABLE `discussr_users` (
  `sqlid` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(127) NOT NULL,
  `joindate` int(11) NOT NULL,
  `sitelanguage` varchar(4) NOT NULL,
  `gender` int(11) NOT NULL,
  `avatar` varchar(511) NOT NULL DEFAULT 'https://cdn.thk.ammon.ee/images/default-avatar.png',
  `role` int(11) NOT NULL,
  `description` varchar(511) NOT NULL,
  `motto` varchar(255) NOT NULL,
  `homepage` varchar(255) NOT NULL,
  `nationality` varchar(63) NOT NULL,
  `timezone` varchar(31) NOT NULL,
  `categoriesFollowing` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussr_users`
--

INSERT INTO `discussr_users` (`sqlid`, `username`, `password`, `email`, `joindate`, `sitelanguage`, `gender`, `avatar`, `role`, `description`, `motto`, `homepage`, `nationality`, `timezone`, `categoriesFollowing`) VALUES
(2, 'marxt12372', '031d2f72f11f3e0e505642328d6296bf55dca251125a8718fbaadac2a92e69e6', 'mart@ammon.ee', 1526491850, 'en', 1, 'http://www.gravatar.com/avatar/ef6848e47019af378ee4848f4baada26?s=200', 4, '', 'I want my car to whisper performance, not scream it.', 'https://ammon.ee', 'Tallinn', '', '2,3'),
(3, 'Kasutaja', '0802fe893a02f2ad4609f82f841a9c2a3610a6fc0b1c35d50a848307ce9f8a4c', 'kasutaja@gmail.com', 1527330111, 'en', 0, 'https://cdn.thk.ammon.ee/images/default-avatar.png', 0, '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussr_categories`
--
ALTER TABLE `discussr_categories`
  ADD PRIMARY KEY (`sqlid`);

--
-- Indexes for table `discussr_posts`
--
ALTER TABLE `discussr_posts`
  ADD PRIMARY KEY (`sqlid`);

--
-- Indexes for table `discussr_threads`
--
ALTER TABLE `discussr_threads`
  ADD PRIMARY KEY (`sqlid`);

--
-- Indexes for table `discussr_users`
--
ALTER TABLE `discussr_users`
  ADD PRIMARY KEY (`sqlid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussr_categories`
--
ALTER TABLE `discussr_categories`
  MODIFY `sqlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discussr_posts`
--
ALTER TABLE `discussr_posts`
  MODIFY `sqlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discussr_threads`
--
ALTER TABLE `discussr_threads`
  MODIFY `sqlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discussr_users`
--
ALTER TABLE `discussr_users`
  MODIFY `sqlid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
