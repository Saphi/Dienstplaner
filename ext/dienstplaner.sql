-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 23. Mai 2011 um 20:09
-- Server Version: 5.0.41
-- PHP-Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `dienstplaner`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kalender_schicht`
-- 

DROP TABLE IF EXISTS `kalender_schicht`;
CREATE TABLE IF NOT EXISTS `kalender_schicht` (
  `ksid` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `termin` date NOT NULL,
  PRIMARY KEY  (`ksid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- 
-- Daten für Tabelle `kalender_schicht`
-- 

INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (10, 5, '2011-05-09');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (9, 5, '2011-05-10');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (8, 1, '2011-05-10');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (12, 1, '2011-05-08');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (11, 6, '2011-05-09');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (7, 1, '2011-05-10');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (13, 6, '2011-05-08');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (14, 3, '2011-05-09');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (15, 1, '2011-05-11');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (16, 5, '2011-05-11');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (17, 1, '2011-05-13');
INSERT INTO `kalender_schicht` (`ksid`, `sid`, `termin`) VALUES (18, 5, '2011-05-13');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ma_info`
-- 

DROP TABLE IF EXISTS `ma_info`;
CREATE TABLE IF NOT EXISTS `ma_info` (
  `iid` int(11) NOT NULL auto_increment,
  `mid` int(11) default NULL,
  `tid` int(11) default NULL,
  `ab` date default NULL,
  `bis` date default NULL,
  PRIMARY KEY  (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `ma_info`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `mitarbeiter`
-- 

DROP TABLE IF EXISTS `mitarbeiter`;
CREATE TABLE IF NOT EXISTS `mitarbeiter` (
  `mid` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `vname` varchar(50) collate latin1_general_ci NOT NULL,
  `adresse` varchar(100) collate latin1_general_ci default NULL,
  `tel` varchar(20) collate latin1_general_ci default NULL,
  `email` varchar(30) collate latin1_general_ci default NULL,
  `max_h_d` int(11) default NULL,
  `max_h_w` int(11) default NULL,
  `max_h_m` int(11) default NULL,
  `max_u` int(11) default NULL,
  `recht` int(11) NOT NULL,
  `angemeldet` varchar(60) collate latin1_general_ci NOT NULL,
  `pw` varchar(255) collate latin1_general_ci NOT NULL,
  `aktiv` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=824 ;

-- 
-- Daten für Tabelle `mitarbeiter`
-- 

INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (1, 'Schiller', 'Martin', ' ', ' ', 'admin@dienstplaner.de', 8, 40, 200, 24, 1, '', '21232f297a57a5a743894a0e4a801fc3', 1);
INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (2, 'Müller', 'Bert', '', '', 'bert@mueller.de', 8, 40, 200, 24, 0, '', '17b304f4ec6a910e2c6fe833d3b00b9d', 1);
INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (819, 'Meier', 'Susanne', '', '', 'susi@meier.com', 8, 40, 200, 24, 0, '', '7a3bbfa99f014f41f2a4b368391c092c', 1);
INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (821, 'Fischer', 'Lutz', '', '', 'lutz@fischer.com', 8, 40, 200, 24, 0, '', '0a8e3638e3c0deb4e5e49c72286a5b83', 1);
INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (822, 'Brunner', 'Falk', '', '', 'falk@brunner.de', 8, 40, 200, 24, 0, '', 'fa3b8367e3d38d8118bd91e91087152c', 1);
INSERT INTO `mitarbeiter` (`mid`, `name`, `vname`, `adresse`, `tel`, `email`, `max_h_d`, `max_h_w`, `max_h_m`, `max_u`, `recht`, `angemeldet`, `pw`, `aktiv`) VALUES (823, 'Weiler', 'Emily', '', '', 'emily@weiler.com', 8, 40, 200, 24, 0, '', '9e3ba813c8a21b92135e71a60ae10d6e', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht`
-- 

DROP TABLE IF EXISTS `schicht`;
CREATE TABLE IF NOT EXISTS `schicht` (
  `sid` int(11) NOT NULL auto_increment,
  `bez` varchar(40) collate latin1_general_ci default NULL,
  `kbez` varchar(10) collate latin1_general_ci default NULL,
  `ab` time default NULL,
  `bis` time default NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

-- 
-- Daten für Tabelle `schicht`
-- 

INSERT INTO `schicht` (`sid`, `bez`, `kbez`, `ab`, `bis`) VALUES (3, 'Frühschicht', 'F', '06:00:00', '14:00:00');
INSERT INTO `schicht` (`sid`, `bez`, `kbez`, `ab`, `bis`) VALUES (5, 'Tagschicht', 'T', '14:00:00', '22:00:00');
INSERT INTO `schicht` (`sid`, `bez`, `kbez`, `ab`, `bis`) VALUES (6, 'Nachtschicht', 'N', '22:00:00', '06:00:00');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht_ma`
-- 

DROP TABLE IF EXISTS `schicht_ma`;
CREATE TABLE IF NOT EXISTS `schicht_ma` (
  `tid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `ma` int(11) default NULL,
  PRIMARY KEY  (`tid`,`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `schicht_ma`
-- 

INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (1, 3, 2);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (1, 5, 3);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (1, 6, 1);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (2, 3, 2);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (2, 5, 3);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (2, 6, 1);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (3, 3, 2);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (3, 5, 3);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (3, 6, 1);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (4, 3, 2);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (4, 5, 3);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (4, 6, 1);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (5, 3, 2);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (5, 5, 3);
INSERT INTO `schicht_ma` (`tid`, `sid`, `ma`) VALUES (5, 6, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht_mitarbeiter`
-- 

DROP TABLE IF EXISTS `schicht_mitarbeiter`;
CREATE TABLE IF NOT EXISTS `schicht_mitarbeiter` (
  `smid` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `termin` date NOT NULL,
  PRIMARY KEY  (`smid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- 
-- Daten für Tabelle `schicht_mitarbeiter`
-- 

INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (1, 3, 1, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (2, 3, 2, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (14, 5, 821, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (13, 5, 819, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (5, 3, 1, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (6, 3, 2, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (7, 3, 1, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (8, 3, 2, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (9, 3, 1, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (10, 3, 2, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (11, 3, 1, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (12, 3, 2, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (15, 5, 822, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (16, 5, 819, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (17, 5, 821, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (18, 5, 822, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (19, 5, 819, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (20, 5, 821, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (21, 5, 822, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (22, 5, 819, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (23, 5, 821, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (24, 5, 822, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (25, 5, 819, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (26, 5, 821, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (27, 5, 822, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (28, 6, 823, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (29, 6, 823, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (30, 6, 823, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (31, 6, 823, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (32, 6, 823, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (33, 3, 822, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (34, 3, 823, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (35, 3, 822, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (36, 3, 823, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (37, 3, 821, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (38, 3, 823, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (39, 3, 821, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (40, 3, 822, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (41, 3, 821, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (42, 3, 822, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (43, 5, 1, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (44, 5, 819, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (45, 5, 821, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (46, 5, 1, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (47, 5, 821, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (48, 6, 822, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (49, 5, 2, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (50, 5, 819, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (51, 5, 821, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (52, 5, 2, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (53, 5, 821, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (54, 5, 823, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (55, 5, 2, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (56, 5, 821, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (57, 5, 823, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (60, 6, 1, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` (`smid`, `sid`, `mid`, `termin`) VALUES (59, 6, 822, '2011-05-13');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `status`
-- 

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `statusID` int(11) NOT NULL,
  `bez` varchar(30) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`statusID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `status`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `statusquo`
-- 

DROP TABLE IF EXISTS `statusquo`;
CREATE TABLE IF NOT EXISTS `statusquo` (
  `sqid` int(11) NOT NULL auto_increment,
  `mid` int(11) default NULL,
  `aktuell_h_d` int(11) NOT NULL,
  `aktuell_h_w` int(11) NOT NULL,
  `aktuell_h_m` int(11) NOT NULL,
  `aktuell_u` int(11) NOT NULL,
  `statusID` int(11) NOT NULL,
  PRIMARY KEY  (`sqid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `statusquo`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `stosszeiten`
-- 

DROP TABLE IF EXISTS `stosszeiten`;
CREATE TABLE IF NOT EXISTS `stosszeiten` (
  `stid` int(11) NOT NULL auto_increment,
  `tid` int(11) default NULL,
  `datum` date default NULL,
  `ab` date default NULL,
  `bis` date default NULL,
  `plus_ma` int(11) default NULL,
  PRIMARY KEY  (`stid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `stosszeiten`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `tag`
-- 

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `tid` int(11) NOT NULL,
  `name` varchar(20) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `tag`
-- 

INSERT INTO `tag` (`tid`, `name`) VALUES (1, 'Montag');
INSERT INTO `tag` (`tid`, `name`) VALUES (2, 'Dienstag');
INSERT INTO `tag` (`tid`, `name`) VALUES (3, 'Mittwoch');
INSERT INTO `tag` (`tid`, `name`) VALUES (4, 'Donnerstag');
INSERT INTO `tag` (`tid`, `name`) VALUES (5, 'Freitag');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `urlaub`
-- 

DROP TABLE IF EXISTS `urlaub`;
CREATE TABLE IF NOT EXISTS `urlaub` (
  `uid` int(11) NOT NULL auto_increment,
  `mid` int(11) default NULL,
  `ab` date default NULL,
  `bis` date default NULL,
  `tage` int(11) default NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

-- 
-- Daten für Tabelle `urlaub`
-- 

INSERT INTO `urlaub` (`uid`, `mid`, `ab`, `bis`, `tage`) VALUES (2, 1, '2011-05-23', '2011-05-27', 5);
