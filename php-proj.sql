-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 sep. 2023 à 18:58
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php-proj`
--

-- --------------------------------------------------------

--
-- Structure de la table `belongs_to`
--

DROP TABLE IF EXISTS `belongs_to`;
CREATE TABLE IF NOT EXISTS `belongs_to` (
  `POST_ID` int NOT NULL,
  `TOPIC_ID` int NOT NULL,
  PRIMARY KEY (`POST_ID`,`TOPIC_ID`),
  KEY `FK2_BELONGS_TO` (`TOPIC_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `COMMENT_ID` int NOT NULL,
  `CONTENT` varchar(500) NOT NULL,
  `DATE_POSTED` date NOT NULL,
  `POST_ID` int NOT NULL,
  `USER_ID` varchar(25) NOT NULL,
  PRIMARY KEY (`COMMENT_ID`),
  KEY `FK1_COMMENT` (`POST_ID`),
  KEY `FK2_COMMENT` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `POST_ID` int NOT NULL,
  `USER_ID` varchar(25) NOT NULL,
  `DATE_FAV` date NOT NULL,
  PRIMARY KEY (`POST_ID`,`USER_ID`),
  KEY `FK2_FAVORITES` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE IF NOT EXISTS `follows` (
  `UN_FOLLOWER` varchar(25) NOT NULL,
  `UN_FOLLOWED` varchar(25) NOT NULL,
  `SINCE_WHEN` date NOT NULL,
  PRIMARY KEY (`UN_FOLLOWER`,`UN_FOLLOWED`),
  KEY `FK2_FOLLOWS` (`UN_FOLLOWED`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `POST_ID` int NOT NULL,
  `USER_ID` varchar(25) NOT NULL,
  `DATE_LIKE` date NOT NULL,
  PRIMARY KEY (`POST_ID`,`USER_ID`),
  KEY `FK2_LIKES` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `ID` int NOT NULL,
  `TITLE` varchar(100) DEFAULT NULL,
  `CONTENT` varchar(1000) DEFAULT NULL,
  `USER_ID` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `DATE_POSTED` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK1_POST` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `ID` int NOT NULL,
  `NAME` varchar(25) NOT NULL,
  `INFO` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `USERNAME` varchar(25) NOT NULL,
  `USER_PWD` varchar(50) NOT NULL,
  `IS_ACTIVATED` tinyint(1) NOT NULL,
  `IS_ADMIN` tinyint(1) NOT NULL,
  `USER_CREATED` date NOT NULL,
  `USER_BIO` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `belongs_to`
--
ALTER TABLE `belongs_to`
  ADD CONSTRAINT `FK1_BELONGS_TO` FOREIGN KEY (`POST_ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `FK2_BELONGS_TO` FOREIGN KEY (`TOPIC_ID`) REFERENCES `topic` (`ID`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK1_COMMENT` FOREIGN KEY (`POST_ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `FK2_COMMENT` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USERNAME`);

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `FK1_FAVORITES` FOREIGN KEY (`POST_ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `FK2_FAVORITES` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USERNAME`);

--
-- Contraintes pour la table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `FK1_FOLLOWS` FOREIGN KEY (`UN_FOLLOWER`) REFERENCES `user` (`USERNAME`),
  ADD CONSTRAINT `FK2_FOLLOWS` FOREIGN KEY (`UN_FOLLOWED`) REFERENCES `user` (`USERNAME`);

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK1_LIKES` FOREIGN KEY (`POST_ID`) REFERENCES `post` (`ID`),
  ADD CONSTRAINT `FK2_LIKES` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USERNAME`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK1_POST` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`USERNAME`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
