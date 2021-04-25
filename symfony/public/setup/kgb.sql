-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 24 avr. 2021 à 15:52
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kgb`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_58DF0651E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrator`
--

INSERT INTO `administrator` (`id`, `email`, `roles`, `password`, `name`, `firstname`, `created`) VALUES
(1, 'allan.melignon@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$RDNBSmpuNjRQa1JEYUNUSQ$VNy84YEiIphV9PXQKpiZ1vfRsLX9vr2AaYxqPt436ow', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `affected_to`
--

DROP TABLE IF EXISTS `affected_to`;
CREATE TABLE IF NOT EXISTS `affected_to` (
  `mission_id` int(11) NOT NULL,
  `affected_id` int(11) NOT NULL,
  PRIMARY KEY (`mission_id`,`affected_id`),
  KEY `IDX_AF93F2A2C72D4736` (`affected_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `affected_to`
--

INSERT INTO `affected_to` (`mission_id`, `affected_id`) VALUES
(2, 1),
(27, 1),
(2, 2),
(32, 2),
(1, 3),
(2, 3),
(27, 3),
(32, 3),
(32, 4);

-- --------------------------------------------------------

--
-- Structure de la table `hideout`
--

DROP TABLE IF EXISTS `hideout`;
CREATE TABLE IF NOT EXISTS `hideout` (
  `id_hideout` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hideout`),
  KEY `hideouts_type_idx` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hideout`
--

INSERT INTO `hideout` (`id_hideout`, `code`, `address`, `postcode`, `city`, `country`, `type`) VALUES
(1, 'WH', '1 rue de Trump', '56484', 'Washington', 'US', 2),
(2, 'KREM', '1 rue du Kremelin', NULL, NULL, 'RU', 5),
(3, 'KREM', '1 rue du Kremelin', '99000', 'Sydney', 'AU', 4),
(4, 'TEST', 'RUE DU TEST', '67000', 'STRASBOURG', 'FR', NULL),
(5, 'FN', '1 rue romantique', '77000', 'Achern', 'DE', 10),
(6, NULL, 'test', NULL, NULL, NULL, NULL),
(7, 'FN', 'test', '77000', 'Achern', 'AR', 3);

-- --------------------------------------------------------

--
-- Structure de la table `hideout_type`
--

DROP TABLE IF EXISTS `hideout_type`;
CREATE TABLE IF NOT EXISTS `hideout_type` (
  `id_hideout_type` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_hideout_type`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hideout_type`
--

INSERT INTO `hideout_type` (`id_hideout_type`, `name`) VALUES
(1, 'Ancienne maison'),
(2, 'Maison 1'),
(3, 'Maison 2'),
(4, 'Maison 3'),
(5, 'Château'),
(9, 'test'),
(10, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `hide_in`
--

DROP TABLE IF EXISTS `hide_in`;
CREATE TABLE IF NOT EXISTS `hide_in` (
  `id_mission` int(11) NOT NULL,
  `id_hideout` int(11) NOT NULL,
  PRIMARY KEY (`id_mission`,`id_hideout`),
  KEY `IDX_1351A0EEF2B24829` (`id_hideout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hide_in`
--

INSERT INTO `hide_in` (`id_mission`, `id_hideout`) VALUES
(2, 1),
(1, 3),
(2, 3),
(32, 4),
(27, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

DROP TABLE IF EXISTS `mission`;
CREATE TABLE IF NOT EXISTS `mission` (
  `id_mission` int(11) NOT NULL AUTO_INCREMENT,
  `spec` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` mediumtext,
  `code` varchar(20) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` enum('inpreparation','inprogress','completed','failed') DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id_mission`),
  KEY `type_idx` (`type`),
  KEY `mission_spec_idx` (`spec`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id_mission`, `spec`, `title`, `description`, `code`, `country`, `type`, `status`, `start`, `end`) VALUES
(1, 5, 'Ma mission ccccc', '<div>La <strong>mega </strong>mission ccccc</div>', 'RAINBOW-X', 'AU', 1, 'completed', '2021-03-05 00:00:00', '2021-03-19 00:00:00'),
(2, 5, 'Ma mission', '<div>The mission of the year</div>', 'YEAR-19', 'DE', 2, 'inprogress', '2021-03-11 00:00:00', '2021-03-27 00:00:00'),
(3, 3, 'Ma mission 2', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(4, 3, 'Attaque Maison blanche', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(5, 3, 'Ma mission 4', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(6, 3, 'Ma mission 5', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inprogress', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(7, 3, 'Président Maison blanche', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(8, 3, 'Ma mission 7', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(10, 3, 'Ma mission 9', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(11, 3, 'Ma mission 10', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(12, 3, 'Ma mission 11', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'failed', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(13, 3, 'Ma mission 12', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'completed', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(14, 3, 'Ma mission 13', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(15, 3, 'Ma mission 14', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(16, 3, 'Ma mission 15', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(17, 3, 'Ma mission 16', 'La mega mission', 'RAINBOW-X', 'FR', 1, 'inpreparation', '2021-03-05 20:55:33', '2021-03-19 20:55:37'),
(21, 4, 'Test', 'aaaaa', 'AA', 'AF', 1, 'inpreparation', '2016-01-01 00:00:00', '2016-03-01 01:00:00'),
(22, 4, 'First mission add', 'bbb', 'BB', 'ES', 1, 'inprogress', '2016-01-01 00:00:00', '2022-08-08 04:05:00'),
(23, 4, 'First mission add bbbb', 'bbb', 'BB', 'ES', 1, 'inprogress', '2016-01-01 00:00:00', '2022-08-08 04:05:00'),
(24, 4, 'First mission add bbbb', 'bbb', 'BB', 'ES', 1, 'inprogress', '2016-01-01 00:00:00', '2022-08-08 04:05:00'),
(25, 4, 'zzzz', 'zzzz', 'zz', 'AF', 1, 'inpreparation', '2021-03-10 00:00:00', '2021-04-22 00:00:00'),
(26, 4, 'UU', 'uuu', 'UU', 'AF', 1, 'inpreparation', '2019-01-01 10:00:00', '2023-09-11 21:00:00'),
(27, 6, 'Add test', '<div>Test d\'ajout des form</div>', 'ADDT', 'ES', 3, 'inpreparation', '2021-04-16 00:00:00', '2021-04-19 00:00:00'),
(32, 6, 'Test assert', '<div>Mon test de mission</div>', 'TESTMIS', 'FR', 1, 'inpreparation', '2021-04-18 00:00:00', '2021-04-22 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `mission_type`
--

DROP TABLE IF EXISTS `mission_type`;
CREATE TABLE IF NOT EXISTS `mission_type` (
  `id_mission_type` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_mission_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mission_type`
--

INSERT INTO `mission_type` (`id_mission_type`, `name`) VALUES
(1, 'Surveillance test'),
(2, 'Infiltration'),
(3, 'Elimination');

-- --------------------------------------------------------

--
-- Structure de la table `speciality`
--

DROP TABLE IF EXISTS `speciality`;
CREATE TABLE IF NOT EXISTS `speciality` (
  `id_spec` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_spec`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `speciality`
--

INSERT INTO `speciality` (`id_spec`, `name`) VALUES
(1, 'Elimination par empoisonnement'),
(3, 'Strangulation'),
(4, 'Mort subite'),
(5, 'Elimination par étouffement'),
(6, 'Mort par chatouilles');

-- --------------------------------------------------------

--
-- Structure de la table `specialized_in`
--

DROP TABLE IF EXISTS `specialized_in`;
CREATE TABLE IF NOT EXISTS `specialized_in` (
  `agent_id` int(11) NOT NULL,
  `in_speciality_id` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`in_speciality_id`),
  KEY `IDX_4DFC3D91E27DA4A4` (`in_speciality_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `specialized_in`
--

INSERT INTO `specialized_in` (`agent_id`, `in_speciality_id`) VALUES
(1, 1),
(5, 1),
(9, 1),
(10, 3),
(1, 5),
(2, 5),
(3, 5),
(8, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('agent','target','contact') NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `born` datetime DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `nationality` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `type`, `nom`, `prenom`, `born`, `code`, `nationality`) VALUES
(1, 'contact', 'POUTINE test', 'Vladimir', '1950-10-20 00:00:00', 'XXX', 'RU'),
(2, 'target', 'TRUMP', 'Donald', '1960-05-11 00:00:00', 'YYY', 'US'),
(3, 'agent', 'MELIGNON', 'Allan', '1992-08-28 00:00:00', '007', 'FR'),
(4, 'contact', 'DUPONT', 'François', '2016-01-01 00:00:00', 'XX', 'FR'),
(5, 'agent', 'GATES', 'Bill', '2000-01-01 00:00:00', 'BILL', 'US'),
(6, 'contact', 'zzz', 'zzz', '2016-01-02 00:00:00', 'zz', NULL),
(7, 'contact', 'zzz', 'zzz', '2016-01-02 00:00:00', 'zz', NULL),
(8, 'agent', '111', '111', '2016-01-01 00:01:00', '11', NULL),
(9, 'contact', 'Add', 'Test', '2000-03-01 00:00:00', 'ADD', NULL),
(10, 'target', 'aaa', 'aaa', '1992-08-28 00:00:00', 'aaaa', 'BE');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affected_to`
--
ALTER TABLE `affected_to`
  ADD CONSTRAINT `for_the_mission` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id_mission`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `for_the_user` FOREIGN KEY (`affected_id`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `hideout`
--
ALTER TABLE `hideout`
  ADD CONSTRAINT `hideouts_type` FOREIGN KEY (`type`) REFERENCES `hideout_type` (`id_hideout_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `hide_in`
--
ALTER TABLE `hide_in`
  ADD CONSTRAINT `hideout_id` FOREIGN KEY (`id_hideout`) REFERENCES `hideout` (`id_hideout`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mission_id` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id_mission`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_spec` FOREIGN KEY (`spec`) REFERENCES `speciality` (`id_spec`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mission_type` FOREIGN KEY (`type`) REFERENCES `mission_type` (`id_mission_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `specialized_in`
--
ALTER TABLE `specialized_in`
  ADD CONSTRAINT `agent_id` FOREIGN KEY (`agent_id`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `speciality_in_id` FOREIGN KEY (`in_speciality_id`) REFERENCES `speciality` (`id_spec`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
