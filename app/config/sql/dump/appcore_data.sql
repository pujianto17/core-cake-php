-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 31, 2010 at 04:09 PM
-- Server version: 5.1.31
-- PHP Version: 5.2.6-3ubuntu4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appcore`
--

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 60),
(2, 1, NULL, NULL, 'ChangePasswords', 2, 5),
(3, 2, NULL, NULL, 'index', 3, 4),
(4, 1, NULL, NULL, 'Groups', 6, 13),
(5, 4, NULL, NULL, 'index', 7, 8),
(6, 4, NULL, NULL, 'add', 9, 10),
(7, 4, NULL, NULL, 'edit', 11, 12),
(8, 1, NULL, NULL, 'GroupsMenus', 14, 19),
(9, 8, NULL, NULL, 'index', 15, 16),
(10, 8, NULL, NULL, 'edit', 17, 18),
(11, 1, NULL, NULL, 'Home', 20, 23),
(12, 11, NULL, NULL, 'index', 21, 22),
(13, 1, NULL, NULL, 'Menus', 24, 37),
(14, 13, NULL, NULL, 'index', 25, 26),
(15, 13, NULL, NULL, 'add', 27, 28),
(16, 13, NULL, NULL, 'edit', 29, 30),
(17, 13, NULL, NULL, 'movedown', 31, 32),
(18, 13, NULL, NULL, 'moveup', 33, 34),
(19, 13, NULL, NULL, 'show_menus', 35, 36),
(20, 1, NULL, NULL, 'Modules', 38, 43),
(21, 20, NULL, NULL, 'index', 39, 40),
(22, 20, NULL, NULL, 'generate', 41, 42),
(23, 1, NULL, NULL, 'Users', 44, 59),
(24, 23, NULL, NULL, 'login', 45, 46),
(25, 23, NULL, NULL, 'logout', 47, 48),
(26, 23, NULL, NULL, 'mypassword', 49, 50),
(27, 23, NULL, NULL, 'changeMypassword', 51, 52),
(28, 23, NULL, NULL, 'index', 53, 54),
(29, 23, NULL, NULL, 'add', 55, 56),
(30, 23, NULL, NULL, 'edit', 57, 58);

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, 'Administrator', 1, 4),
(2, 1, 'User', 1, 'admin', 2, 3);

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1');

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Administrator', '2010-08-31 15:47:43', '2010-08-31 15:47:43');

--
-- Dumping data for table `groups_menus`
--


--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `name`, `url`, `enable`, `lft`, `rght`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, NULL, 'System And Utility', '/', 1, 1, 14, '2010-08-31 15:54:49', 0, '2010-08-31 15:54:49', 0),
(2, 1, 'Group Management', '/Groups', 1, 2, 3, '2010-08-31 15:56:43', 0, '2010-08-31 15:56:43', 0),
(3, 1, 'User Management', '/Users', 1, 4, 5, '2010-08-31 15:57:39', 0, '2010-08-31 15:57:39', 0),
(4, 1, 'Menu Management', '/Menus', 1, 6, 7, '2010-08-31 15:57:53', 0, '2010-08-31 15:57:53', 0),
(5, 1, 'Access Menu Management', '/GroupsMenus', 1, 8, 9, '2010-08-31 15:58:26', 0, '2010-08-31 15:58:26', 0),
(6, 1, 'Module Management', '/Modules', 1, 10, 11, '2010-08-31 15:58:43', 0, '2010-08-31 15:58:43', 0),
(7, 1, 'Change Password', '/ChangePasswords', 1, 12, 13, '2010-08-31 15:59:01', 0, '2010-08-31 15:59:01', 0);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `realname`, `password`, `email`, `group_id`, `active`, `passwordchangecode`, `created`, `modified`) VALUES
(1, 'admin', 'Administrator', 'a145921c3d358597863353829d331136591db5f0', 'admin@admin.com', 1, 1, NULL, '2010-08-31 15:48:16', '2010-08-31 15:48:16');
