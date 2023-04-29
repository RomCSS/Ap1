-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 29 avr. 2023 à 18:56
-- Version du serveur :  8.0.23
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ap1`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

CREATE TABLE `demande` (
  `iddemande` int NOT NULL,
  `idetat` int NOT NULL DEFAULT '1',
  `idpriorite` int NOT NULL,
  `assignement` varchar(50) NOT NULL,
  `iduser` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`iddemande`, `idetat`, `idpriorite`, `assignement`, `iduser`) VALUES
(3, 3, 3, 'Manger', 3),
(4, 3, 3, 'Dire Bonjour', 3),
(5, 2, 3, 'Manger du sucre', 8),
(6, 1, 3, 'détruire le monde', 3),
(7, 1, 3, 'détruire le monde', 3),
(8, 3, 1, 'Manger du pain', 3),
(9, 1, 3, 'Acheter un donuts sucré au sucre', 3),
(10, 1, 3, 'Apprendre le php', 3),
(11, 1, 3, 'Licencier Orelzo', 1),
(13, 3, 1, 'Acheter du sel ', 8);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `demande_view`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `demande_view` (
`iddemande` int
,`idetat` int
,`iduser` int
,`personne_en_charge` varchar(50)
,`assignement` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `idetat` int NOT NULL,
  `etat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`idetat`, `etat`) VALUES
(1, 'Non assigne'),
(2, 'En cour de realisation'),
(3, 'En attente'),
(4, 'Terminer');

-- --------------------------------------------------------

--
-- Structure de la table `priorite`
--

CREATE TABLE `priorite` (
  `idpriorite` int NOT NULL,
  `priorite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `priorite`
--

INSERT INTO `priorite` (`idpriorite`, `priorite`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `idrole` int NOT NULL,
  `typerole` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`idrole`, `typerole`) VALUES
(1, 'Responsable'),
(2, 'Utilisateur'),
(3, 'Employe');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iduser` int NOT NULL,
  `idrole` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iduser`, `idrole`, `login`, `password`) VALUES
(1, 1, 'Zyzz', '1234'),
(2, 3, 'Orelzo', '12345'),
(3, 2, 'JeanCyril', '123456'),
(4, 3, 'sébastien', '5555'),
(5, 3, 'RoM1', '62175'),
(6, 3, 'Plot', 'vlc'),
(7, 3, 'Bernard', '0000'),
(8, 2, ' ZKR', 'zkr5');

-- --------------------------------------------------------

--
-- Structure de la vue `demande_view`
--
DROP TABLE IF EXISTS `demande_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `demande_view`  AS SELECT `d`.`iddemande` AS `iddemande`, `d`.`idetat` AS `idetat`, `d`.`iduser` AS `iduser`, `u`.`login` AS `personne_en_charge`, `d`.`assignement` AS `assignement` FROM (`demande` `d` left join `user` `u` on(((`d`.`iduser` = `u`.`iduser`) and (`u`.`idrole` = 3)))) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demande`
--
ALTER TABLE `demande`
  ADD PRIMARY KEY (`iddemande`),
  ADD KEY `idetat` (`idetat`),
  ADD KEY `idpriorite` (`idpriorite`),
  ADD KEY `iduser` (`iduser`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`idetat`);

--
-- Index pour la table `priorite`
--
ALTER TABLE `priorite`
  ADD PRIMARY KEY (`idpriorite`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idrole`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD KEY `idrole` (`idrole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demande`
--
ALTER TABLE `demande`
  MODIFY `iddemande` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `idetat` FOREIGN KEY (`idetat`) REFERENCES `etat` (`idetat`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `idpriorite` FOREIGN KEY (`idpriorite`) REFERENCES `priorite` (`idpriorite`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `iduser` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `idrole` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
