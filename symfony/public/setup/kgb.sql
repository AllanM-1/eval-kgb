-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : sendeuromtkgb.mysql.db
-- Généré le :  Dim 25 avr. 2021 à 17:01
-- Version du serveur :  5.6.50-log
-- Version de PHP :  7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sendeuromtkgb`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrator`
--

INSERT INTO `administrator` (`id`, `email`, `roles`, `password`, `name`, `firstname`, `created`) VALUES
(1, 'allan.melignon@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$RDNBSmpuNjRQa1JEYUNUSQ$VNy84YEiIphV9PXQKpiZ1vfRsLX9vr2AaYxqPt436ow', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `affected_to`
--

CREATE TABLE `affected_to` (
  `mission_id` int(11) NOT NULL,
  `affected_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `affected_to`
--

INSERT INTO `affected_to` (`mission_id`, `affected_id`) VALUES
(2, 1),
(3, 1),
(15, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(2, 2),
(3, 2),
(4, 2),
(15, 2),
(1, 3),
(2, 3),
(4, 3),
(15, 3),
(15, 4),
(8, 5),
(15, 5),
(33, 5),
(34, 5),
(35, 5),
(36, 5),
(8, 6),
(15, 6),
(15, 7),
(5, 10),
(15, 11),
(5, 12);

-- --------------------------------------------------------

--
-- Structure de la table `hideout`
--

CREATE TABLE `hideout` (
  `id_hideout` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hideout`
--

INSERT INTO `hideout` (`id_hideout`, `code`, `address`, `postcode`, `city`, `country`, `type`) VALUES
(1, 'WH', '1600 Pennsylvania Avenue', '20500', 'Washington, DC', 'US', 11),
(2, 'KREM', 'Rue Troitskaya', '103132', 'Moscow', 'RU', 13),
(3, 'SYDN', '456 Kent Street', '2000', 'Sydney', 'AU', 4),
(4, 'CATH', '16 Place de la Cathédrale', '67000', 'Strasbourg', 'FR', 5),
(5, 'LOT', 'Lotharpfad', '72270', 'Baiersbronn', 'DE', 10),
(7, 'BOE', 'Bolivar 1', '1000', 'Buenos Aires', 'AR', 14);

-- --------------------------------------------------------

--
-- Structure de la table `hideout_type`
--

CREATE TABLE `hideout_type` (
  `id_hideout_type` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hideout_type`
--

INSERT INTO `hideout_type` (`id_hideout_type`, `name`) VALUES
(1, 'Ancienne maison'),
(2, 'Maison de campagne'),
(3, 'Appartement en centre ville'),
(4, 'Maison bord de mer'),
(5, 'Château'),
(9, 'Bunker'),
(10, 'Nature'),
(11, 'Résidence'),
(12, 'Consulat'),
(13, 'Forteresse'),
(14, 'Hôtel');

-- --------------------------------------------------------

--
-- Structure de la table `hide_in`
--

CREATE TABLE `hide_in` (
  `id_mission` int(11) NOT NULL,
  `id_hideout` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `hide_in`
--

INSERT INTO `hide_in` (`id_mission`, `id_hideout`) VALUES
(2, 1),
(4, 1),
(5, 2),
(1, 3),
(2, 3),
(15, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(3, 5),
(8, 7);

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id_mission` int(11) NOT NULL,
  `spec` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` mediumtext,
  `code` varchar(20) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` enum('inpreparation','inprogress','completed','failed') DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id_mission`, `spec`, `title`, `description`, `code`, `country`, `type`, `status`, `start`, `end`) VALUES
(1, 5, 'La mission initiale', '<div>Votre mission si vous l\'acceptez...</div>', 'INIT', 'AU', 1, 'completed', '2021-03-05 00:00:00', '2021-03-19 00:00:00'),
(2, 5, 'Ma mission', '<div>The mission of the year</div>', 'YEAR-19', 'DE', 2, 'inprogress', '2021-03-11 00:00:00', '2021-03-27 00:00:00'),
(3, 3, 'La mega mission', '<div>La mega mission</div>', 'BIERE', 'DE', 1, 'inpreparation', '2021-03-05 00:00:00', '2021-03-19 00:00:00'),
(4, 8, 'Attaque Maison blanche', '<div>Votre mission sera de franchir la frontière mexicaine en passant par dessus le mur pour vous rendre dans le bureau ovale. Vous devrez ensuite couper les durites de frein de la limousine du président garée à côté de son bunker au sous sol.</div>', 'WALL', 'US', 2, 'inpreparation', '2021-03-05 00:00:00', '2021-03-19 00:00:00'),
(5, 1, 'Affaire personnelle', '<div>Alexei veut ma place au Kremlin et moi je ne veux pas aller à la retraite. Merci de faire le nécessaire<br><br>Cordialement Vlad</div>', 'DICTA', 'RU', 3, 'inpreparation', '2020-11-14 00:00:00', '2021-03-27 00:00:00'),
(8, 10, 'Anti-puces', '<div>Le bon déroulement de cette mission nous permettra de ne pas injecter des puces sous la peau :D</div>', 'CHIP', 'AR', 1, 'failed', '2021-03-05 00:00:00', '2021-03-19 00:00:00'),
(15, 3, 'Grosse mission', '<div>Ici c\'est un peu n\'importe quoi car tout le monde s\'entretuera</div>', 'BIG', 'FR', 1, 'completed', '2020-07-14 00:00:00', '2021-08-13 00:00:00'),
(33, 3, 'Exemple vide 1', '<div>Exemple mon montrer qu\'une pagination a été faite</div>', 'EX1', 'FR', 2, 'inprogress', '2021-04-06 00:00:00', '2021-04-07 00:00:00'),
(34, 3, 'Exemple vide 1', '<div>&nbsp;Exemple mon montrer qu\'une pagination a été faite&nbsp;</div>', 'EX2', 'FR', 3, 'completed', '2021-04-07 00:00:00', '2021-04-09 00:00:00'),
(35, 5, 'Exemple vide 3', '<div>&nbsp;Exemple mon montrer qu\'une pagination a été faite&nbsp;</div>', 'EX3', 'FR', 3, 'inprogress', '2021-04-06 00:00:00', '2021-04-07 00:00:00'),
(36, 1, 'Exemple vide 4', '<div>&nbsp;Exemple mon montrer qu\'une pagination a été faite&nbsp;</div>', 'EX4', 'FR', 3, 'inprogress', '2021-04-25 00:00:00', '2021-04-26 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `mission_type`
--

CREATE TABLE `mission_type` (
  `id_mission_type` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mission_type`
--

INSERT INTO `mission_type` (`id_mission_type`, `name`) VALUES
(1, 'Surveillance'),
(2, 'Infiltration'),
(3, 'Elimination');

-- --------------------------------------------------------

--
-- Structure de la table `speciality`
--

CREATE TABLE `speciality` (
  `id_spec` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `speciality`
--

INSERT INTO `speciality` (`id_spec`, `name`) VALUES
(1, 'Elimination par empoisonnement'),
(3, 'Strangulation'),
(4, 'Mort subite'),
(5, 'Elimination par étouffement'),
(6, 'Mort par chatouilles'),
(7, 'Immolation'),
(8, 'Sabotage de véhicules'),
(9, 'Gadget'),
(10, 'Armes à feu');

-- --------------------------------------------------------

--
-- Structure de la table `specialized_in`
--

CREATE TABLE `specialized_in` (
  `agent_id` int(11) NOT NULL,
  `in_speciality_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `specialized_in`
--

INSERT INTO `specialized_in` (`agent_id`, `in_speciality_id`) VALUES
(1, 1),
(12, 1),
(1, 3),
(1, 4),
(1, 5),
(3, 5),
(3, 6),
(1, 8),
(3, 8),
(7, 8),
(6, 9),
(6, 10);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `type` enum('agent','target','contact') NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `born` datetime DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `nationality` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `type`, `nom`, `prenom`, `born`, `code`, `nationality`) VALUES
(1, 'agent', 'POUTINE', 'Vladimir', '1982-10-07 00:00:00', 'VLA', 'RU'),
(2, 'target', 'TRUMP', 'Donald', '1946-12-14 00:00:00', 'TRU', 'US'),
(3, 'agent', 'MELIGNON', 'Allan', '1992-08-28 00:00:00', 'AM', 'FR'),
(4, 'contact', 'DUPONT', 'François', '1988-12-05 00:00:00', 'DUP', 'FR'),
(5, 'target', 'GATES', 'Bill', '1955-10-28 00:00:00', 'BILL', 'US'),
(6, 'agent', 'Bond', 'James', '1968-04-13 00:00:00', '007', 'GB'),
(7, 'agent', 'MUSK', 'Elon', '1971-06-28 00:00:00', 'S3XY', 'ZA'),
(10, 'target', 'NAVALNY', 'Alexei', '1976-05-04 00:00:00', 'NOVI', 'RU'),
(11, 'target', 'ZUCKERBERG', 'Mark', '1984-05-14 00:00:00', 'FB', 'US'),
(12, 'agent', 'ERISTOFF', 'Vodka', '1977-08-14 00:00:00', 'CULSEC', 'PL');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_58DF0651E7927C74` (`email`);

--
-- Index pour la table `affected_to`
--
ALTER TABLE `affected_to`
  ADD PRIMARY KEY (`mission_id`,`affected_id`),
  ADD KEY `IDX_AF93F2A2C72D4736` (`affected_id`);

--
-- Index pour la table `hideout`
--
ALTER TABLE `hideout`
  ADD PRIMARY KEY (`id_hideout`),
  ADD KEY `hideouts_type_idx` (`type`);

--
-- Index pour la table `hideout_type`
--
ALTER TABLE `hideout_type`
  ADD PRIMARY KEY (`id_hideout_type`);

--
-- Index pour la table `hide_in`
--
ALTER TABLE `hide_in`
  ADD PRIMARY KEY (`id_mission`,`id_hideout`),
  ADD KEY `IDX_1351A0EEF2B24829` (`id_hideout`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id_mission`),
  ADD KEY `type_idx` (`type`),
  ADD KEY `mission_spec_idx` (`spec`);

--
-- Index pour la table `mission_type`
--
ALTER TABLE `mission_type`
  ADD PRIMARY KEY (`id_mission_type`);

--
-- Index pour la table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id_spec`);

--
-- Index pour la table `specialized_in`
--
ALTER TABLE `specialized_in`
  ADD PRIMARY KEY (`agent_id`,`in_speciality_id`),
  ADD KEY `IDX_4DFC3D91E27DA4A4` (`in_speciality_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `hideout`
--
ALTER TABLE `hideout`
  MODIFY `id_hideout` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `hideout_type`
--
ALTER TABLE `hideout_type`
  MODIFY `id_hideout_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `id_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `mission_type`
--
ALTER TABLE `mission_type`
  MODIFY `id_mission_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `id_spec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
