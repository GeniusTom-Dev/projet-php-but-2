-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-echo.alwaysdata.net
-- Generation Time: Oct 02, 2023 at 10:55 AM
-- Server version: 10.6.14-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `echo_bd_test`
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USERNAME`, `USER_EMAIL`, `USER_PWD`, `IS_ACTIVATED`, `IS_ADMIN`, `USER_CREATED`, `USER_LAST_CONNECTION`, `USER_PROFIL_PIC`, `USER_BIO`) VALUES
('admin', 'admin@fr', 'mdp', 1, 1, '2023-10-01', '2023-10-01', NULL, NULL),
('bebert', 'bebert@gmail.com', 'mdp', 1, 0, '2022-05-05', '2023-06-28', 'path_to_image1', 'Bio de bebert'),
('benoit', 'benoit.123@laposte.fr', 'mdp', 1, 0, '2023-09-28', '2023-09-28', NULL, NULL),
('martin', 'martin@gmail.com', 'mdp', 1, 0, '2023-08-08', '2023-09-28', 'path_to_image2', 'Bio de martin'),
('martine', 'martine@gmail.com', 'mdp', 1, 0, '2023-08-15', '2023-10-01', NULL, 'Bio de martine');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
