-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 28 dec 2012 om 14:45
-- Serverversie: 5.5.25
-- PHP-versie: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `lifeingent`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Admins`
--

CREATE TABLE `Admins` (
  `adm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adm_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adm_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adm_password` char(128) COLLATE utf8_unicode_ci NOT NULL,
  `adm_givenname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adm_familyname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adm_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adm_active` tinyint(1) NOT NULL DEFAULT '1',
  `adm_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `Admins`
--

INSERT INTO `Admins` (`adm_id`, `adm_timestamp`, `adm_username`, `adm_password`, `adm_givenname`, `adm_familyname`, `adm_email`, `adm_active`, `adm_deleted`) VALUES
(1, '2012-12-26 15:24:00', 'admin', '31cd68e4a0414167d00606b60e9b846db95f39eab4ea98d5a532ce1cd8824925', 'Admi', 'Strator', 'admini.strator@arteveldehs.be', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
