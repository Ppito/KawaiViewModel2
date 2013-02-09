-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 05 Février 2013 à 21:24
-- Version du serveur: 5.1.66-0+squeeze1
-- Version de PHP: 5.3.3-7+squeeze14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kvm2`
--
CREATE DATABASE `kvm2` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `kvm2`;

-- --------------------------------------------------------

--
-- Structure de la table `group_`
--

CREATE TABLE IF NOT EXISTS `group_` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_description` text COLLATE utf8_unicode_ci,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `group_`
--

INSERT INTO `group_` (`group_id`, `group_name`, `group_description`, `is_deleted`) VALUES
(1, 'administrators', 'Administrators', 0),
(2, 'members', 'Members', 0);

-- --------------------------------------------------------

--
-- Structure de la table `group__right`
--

CREATE TABLE IF NOT EXISTS `group__right` (
  `group_id` int(10) unsigned NOT NULL,
  `right_id` int(10) unsigned NOT NULL,
  `group__right_value` enum('allow','deny') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'deny',
  KEY `group_id` (`group_id`),
  KEY `right_id` (`right_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `group__right`
--

INSERT INTO `group__right` (`group_id`, `right_id`, `group__right_value`) VALUES
(1, 1, 'allow'),
(1, 2, 'allow'),
(1, 3, 'allow'),
(1, 4, 'allow'),
(1, 5, 'allow'),
(1, 6, 'allow'),
(1, 7, 'allow'),
(1, 8, 'allow'),
(1, 9, 'allow'),
(1, 10, 'allow'),
(1, 11, 'allow'),
(1, 12, 'allow'),
(1, 13, 'allow'),
(2, 1, 'deny');

-- --------------------------------------------------------

--
-- Structure de la table `right_`
--

CREATE TABLE IF NOT EXISTS `right_` (
  `right_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `right_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `right_description` text COLLATE utf8_unicode_ci,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`right_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Contenu de la table `right_`
--

INSERT INTO `right_` (`right_id`, `right_name`, `right_description`, `is_deleted`) VALUES
(1, 'admin_view', 'Can view reserved module admin', 0),
(2, 'user_create', 'Create a new user', 0),
(3, 'user_edit', 'Edit any user', 0),
(4, 'user_delete', 'Remove any user', 0),
(5, 'user_view', 'View any user', 0),
(6, 'group_create', 'Create a new group', 0),
(7, 'group_edit', 'Edit any group', 0),
(8, 'group_delete', 'Remove any group', 0),
(9, 'group_view', 'View any group', 0),
(10, 'right_create', 'Create a new right', 0),
(11, 'right_edit', 'Edit any right', 0),
(12, 'right_delete', 'Remove any right', 0),
(13, 'right_view', 'View any right', 0);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `user_id` int(10) unsigned NOT NULL,
  `session_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_start_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_birthday` date NOT NULL,
  `user_sexe` tinyint(1) NOT NULL,
  `user_mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_password_nonce` int(32) NOT NULL,
  `user_password_md5` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `user_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_last_name`, `user_first_name`, `user_birthday`, `user_sexe`, `user_mail`, `user_phone`, `user_password_nonce`, `user_password_md5`, `is_deleted`, `user_creation`) VALUES
(1, 'kvm2', 'Kvm2', 'Kvm2', '1970-01-01', 0, 'Kvm2@Kvm2', '0123456789', 57646, MD5('57646kvm2'), 0, NOW());
-- --------------------------------------------------------

--
-- Structure de la table `user__group`
--

CREATE TABLE IF NOT EXISTS `user__group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user__group`
--

INSERT INTO `user__group` (`user_id`, `group_id`) VALUES
(1, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `group__right`
--
ALTER TABLE `group__right`
  ADD CONSTRAINT `group__right_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `group_` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group__right_ibfk_5` FOREIGN KEY (`right_id`) REFERENCES `right_` (`right_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user__group`
--
ALTER TABLE `user__group`
  ADD CONSTRAINT `user__group_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user__group_ibfk_8` FOREIGN KEY (`group_id`) REFERENCES `group_` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
