-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 13 Décembre 2014 à 13:59
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `feedback`
--

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id_mess` int(11) NOT NULL AUTO_INCREMENT,
  `num_user` varchar(10) NOT NULL DEFAULT '',
  `num_question` int(11) DEFAULT NULL,
  `num_reponse` varchar(10) DEFAULT NULL,
  `date_recu` datetime DEFAULT NULL,
  PRIMARY KEY (`id_mess`,`num_user`),
  KEY `num_user` (`num_user`),
  KEY `num_question` (`num_question`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id_mess`, `num_user`, `num_question`, `num_reponse`, `date_recu`) VALUES
(3, '0646763234', 1, 'B', '2014-12-13 13:56:52');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id_quest` int(11) NOT NULL AUTO_INCREMENT,
  `num_quest` int(11) NOT NULL,
  `type_quest` varchar(200) DEFAULT NULL,
  `enonce` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_quest`),
  UNIQUE KEY `num_quest` (`num_quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`id_quest`, `num_quest`, `type_quest`, `enonce`) VALUES
(1, 1, 'qcm', 'sujet q1'),
(2, 2, 'qcm', 'sujet q2');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
  `num_question` int(11) NOT NULL,
  `num_rep` varchar(10) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_question`,`num_rep`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`num_question`, `num_rep`, `description`, `point`) VALUES
(1, 'A', 'reponseA', 0),
(1, 'B', 'reponseB', 0),
(2, 'A', 'repA', 0),
(2, 'B', 'repB', 0),
(2, 'C', 'repC', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `num_tel` varchar(10) NOT NULL,
  PRIMARY KEY (`num_tel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`num_tel`) VALUES
('0646763234');

--
-- Structure de la table `messagebrute`
--

CREATE TABLE IF NOT EXISTS `messagebrute` (
  `num_recu` varchar(10) NOT NULL,
  `corps_mess` varchar(200),
  `date_entree` datetime,
  PRIMARY KEY (`num_recu`,`corps_mess`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `messagebrute`
--

INSERT INTO `messagebrute` VALUES ('0646763234','1AB',NOW());

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`num_user`) REFERENCES `user` (`num_tel`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`num_question`) REFERENCES `question` (`num_quest`);

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`num_question`) REFERENCES `question` (`num_quest`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
