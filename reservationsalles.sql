-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Dic 16, 2021 alle 05:35
-- Versione del server: 5.7.31
-- Versione PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; 
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservationsalles`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=343807 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(343794, 'first test', 'first test', '2021-12-14 12:00:00', '2021-12-14 13:00:00', 2),
(343795, 'second update test', 'second update test', '2021-12-15 12:00:00', '2021-12-15 13:00:00', 2),
(343796, 'title test addreserve', 'addreserveraddreserveraddreserver', '2021-12-11 15:00:00', '2021-12-11 16:00:00', 2),
(343797, 'test from another user', 'test from another usertest from another user', '2021-12-16 11:00:00', '2021-12-16 12:00:00', 3),
(343798, 'titletitle', 'description', '2021-12-13 17:00:00', '2021-12-13 18:00:00', 3),
(343799, 'check for reserve', 'check for reserve', '2021-11-29 08:00:00', '2021-11-29 09:00:00', 2),
(343800, 'check for reserve 2', 'check for reserve 2', '2021-12-01 19:00:00', '2021-12-01 20:00:00', 2),
(343802, 'test 30', 'test 30', '2021-12-30 08:00:00', '2021-12-30 09:00:00', 2),
(343806, 'first test new user', 'first test new userfirst test new userfirst test new user', '2021-12-16 09:00:00', '2021-12-16 10:00:00', 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `sent`
--

DROP TABLE IF EXISTS `sent`;
CREATE TABLE IF NOT EXISTS `sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(500) NOT NULL,
  `user1` varchar(60) NOT NULL,
  `user2` varchar(60) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sent`
--

INSERT INTO `sent` (`id`, `text`, `user1`, `user2`, `date`, `title`) VALUES
(2, 'test', '3', '2', '2021-12-12 14:16:27', 'test'),
(7, 'description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description ', '2', '1', '2021-12-13 06:17:06', 'title'),
(6, 'description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description description      \r\n', '3', '2', '2021-12-12 14:39:28', 'test'),
(8, 'heres my messageheres my messageheres my messageheres my messageheres my messageheres my message', '2', '1', '2021-12-13 07:13:26', 'test to admin'),
(9, 'test message', '2', '3', '2021-12-13 18:13:06', 'title'),
(10, 'writethemessage', '6', '2', '2021-12-15 13:58:55', 'naminami');

-- --------------------------------------------------------

--
-- Struttura della tabella `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'nami', '$2y$10$kpnpzHSTWVFSdK.GGb5adeTHir7JocALUqJvko0Q0jTj654ZL/l3e'),
(3, 'billy', '$2y$10$eNZCjmYyU74osPddKZfEr.AMIoj5kQWEyBgjkQaPdCSM/7LZG59bu'),
(8, 'gidi3', '$2y$10$LgXT.5eGYkBEMtRiNfKiTeQr6UpYwtuVN4StxqMxXUEHo.KV.Pnne');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
