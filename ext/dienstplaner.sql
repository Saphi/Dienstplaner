-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 18. Dezember 2011 um 18:21
-- Server Version: 5.0.41
-- PHP-Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `dienstplaner`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `hilfe`
-- 

DROP TABLE IF EXISTS `hilfe`;
CREATE TABLE `hilfe` (
  `seite` varchar(20) collate latin1_general_ci NOT NULL,
  `sub` varchar(20) collate latin1_general_ci NOT NULL,
  `text` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`seite`,`sub`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `hilfe`
-- 

INSERT INTO `hilfe` VALUES ('mitarbeiter', 'uebersicht', 'Hier sehen Sie eine &Uuml;bersicht mit allen registrierten Benutzern.<br/><br/>\r\n\r\ngr&uuml;n = aktiviert<br/> \r\nrot = deaktiviert<br/><br/>\r\n                      \r\nSie haben die M&ouml;glichkeit Benutzer durch Klick auf den farbigen Button zu aktivieren/deaktivieren. Des Weiteren können Sie Mitarbeiter l&ouml;schen, sofern Sie Administrationsrechte besitzen.<br/>\r\nDamit sich ein Benutzer anmelden/einloggen kann, muss er aktiviert sein.');
INSERT INTO `hilfe` VALUES ('mitarbeiter', 'neu', 'Hier können Sie einen neuen Benutzer (Mitarbeiter) erstellen.<br/><br/>\r\n\r\nBitte füllen Sie alle durch * gekennzeichneten Pflichtfelder vollständig aus.');
INSERT INTO `hilfe` VALUES ('mitarbeiter', 'details', 'Hier können Sie die gespeicherten Informationen zu jedem registrierten Benutzer (Mitarbeiter) einsehen.<br/><br/>\r\n\r\nWählen Sie den gewünschten Mitarbeiter aus.');
INSERT INTO `hilfe` VALUES ('mitarbeiter', 'bearbeiten', 'Hier können Sie die gespeicherten Daten zu jedem Benutzer (Mitarbeiter) bearbeiten.<br/><br/>\r\n\r\nWählen Sie den Mitarbeiter aus, den Sie bearbeiten möchten.\r\n<br/><br/>\r\n\r\nBitte füllen Sie alle durch * gekennzeichneten Pflichtfelder vollständig aus.');
INSERT INTO `hilfe` VALUES ('mitarbeiter', 'urlaub', 'Hier haben Sie die Möglichkeit den einzelnen Mitarbeitern Urlaubszeiten zuzuteilen bzw. gespeicherte Daten zu löschen oder zu bearbeiten.<br/><br/>\r\n\r\nWählen Sie einen Benutzer (Mitarbeiter) aus und geben die entsprechenden Daten ein.');
INSERT INTO `hilfe` VALUES ('kalender', 'uebersicht', 'Hier sehen Sie eine Kalenderübersicht. Sie können den gewünschten Monat auswählen.<br/>\r\nFür jeden Tag sind die entsprechenden Schichten und die jeweilige Belegung ersichtlich<br/><br/>\r\n\r\nrot = noch kein Mitarbeiter eingeteilt<br/>\r\ngelb = noch nicht genügend Mitarbeiter eingeteilt<br/>\r\ngrün = voll belegt<br/>\r\n<br/>\r\n\r\nDurch Klick auf eine Schicht gelangen Sie in die Detailansicht dieser Schicht (nur Admin) in der Sie dieser Schicht die gewünschten Mitarbeiter zuteilen können.');
INSERT INTO `hilfe` VALUES ('kalender', 'detail', 'Hier sehen Sie welche Mitarbeiter dieser Schicht an diesem Datum zugeteilt sind.<br/><br/>\r\n\r\nWenn Sie Adminrechte besitzen haben Sie die Möglichkeit die Belegung zu bearbeiten.<br/>\r\nSie können eingeteilte Mitarbeiter entfernen, oder neue hinzufügen.<br/>\r\nDabei kann die gespeicherte Maximalbelegung nicht überschritten werden.');
INSERT INTO `hilfe` VALUES ('dienstplan', 'uebersicht', 'Hier können Sie neue Dienstpläne erstellen oder archivierte Pläne einsehen.<br/><br/>\r\n\r\nZum Erstellen geben Sie ein Anfangs- und Enddatum an und wählen aus, ob der Plan für alle Mitarbeiter, oder nur für Sie selbst erstellt werden soll.');
INSERT INTO `hilfe` VALUES ('konfig', 'uebersicht', 'Hier sehen Sie eine Übersicht von allen gespeicherten Schichten.<br/><br/>\r\n\r\nSie haben die Möglichkeit einzelne Schichten zu löschen.');
INSERT INTO `hilfe` VALUES ('konfig', 'arbeitstage', 'Hier wählen Sie die Arbeitstage aus.<br/>\r\nDanach haben Sie die Möglichkeit für jeden Tag und jede Schicht die notwendige Belegung anzugeben.<br/><br/>\r\n\r\nUm diese Einstellung vornehmen zu können, muss mindestens eine Schicht angelegt sein.');
INSERT INTO `hilfe` VALUES ('konfig', 'neu', 'Hier können Sie neue Schichten anlegen.<br/><br/>\r\n\r\nFüllen Sie bitte alle Felder vollständig aus.<br/>\r\nZur Übersichtlichkeit wird jeder Schicht eine Farbe zugeordnet.');
INSERT INTO `hilfe` VALUES ('konfig', 'bearbeiten', 'Hier können Sie gespeicherte Schichten bearbeiten.<br/>\r\nWählen Sie die gewünschte Schicht aus.<br/><br/>\r\nFüllen Sie bitte alle Felder vollständig aus.');
INSERT INTO `hilfe` VALUES ('konfig', 'belegung', 'Hier werden für die einzelnen Schichten und Tage die benötige Anzahl an Mitarbeitern angegeben.<br/><br/>\r\n\r\nFür die korrekte Berechnung des Dienstplanes muss jeder Schicht an jedem Tag eine Belegung gegeben sein.');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `kalender_schicht`
-- 

DROP TABLE IF EXISTS `kalender_schicht`;
CREATE TABLE `kalender_schicht` (
  `ksid` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `termin` date NOT NULL,
  PRIMARY KEY  (`ksid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- 
-- Daten für Tabelle `kalender_schicht`
-- 

INSERT INTO `kalender_schicht` VALUES (10, 5, '2011-05-09');
INSERT INTO `kalender_schicht` VALUES (9, 5, '2011-05-10');
INSERT INTO `kalender_schicht` VALUES (8, 1, '2011-05-10');
INSERT INTO `kalender_schicht` VALUES (12, 1, '2011-05-08');
INSERT INTO `kalender_schicht` VALUES (11, 6, '2011-05-09');
INSERT INTO `kalender_schicht` VALUES (7, 1, '2011-05-10');
INSERT INTO `kalender_schicht` VALUES (13, 6, '2011-05-08');
INSERT INTO `kalender_schicht` VALUES (14, 3, '2011-05-09');
INSERT INTO `kalender_schicht` VALUES (15, 1, '2011-05-11');
INSERT INTO `kalender_schicht` VALUES (16, 5, '2011-05-11');
INSERT INTO `kalender_schicht` VALUES (17, 1, '2011-05-13');
INSERT INTO `kalender_schicht` VALUES (18, 5, '2011-05-13');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `ma_info`
-- 

DROP TABLE IF EXISTS `ma_info`;
CREATE TABLE `ma_info` (
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
CREATE TABLE `mitarbeiter` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=831 ;

-- 
-- Daten für Tabelle `mitarbeiter`
-- 

INSERT INTO `mitarbeiter` VALUES (1, 'Schiller', 'Martin', '', ' ', 'admin@dienstplaner.de', 0, 0, 0, 20, 1, '', '21232f297a57a5a743894a0e4a801fc3', 1);
INSERT INTO `mitarbeiter` VALUES (2, 'Müller', 'Bert', '', '', 'bert@mueller.de', 8, 40, 200, 24, 0, '', 'c382ca6fa6a685f5b38d5324ec0526a0', 1);
INSERT INTO `mitarbeiter` VALUES (819, 'Meier', 'Susanne', '', '', 'susi@meier.com', 8, 40, 200, 24, 0, '', '7a3bbfa99f014f41f2a4b368391c092c', 1);
INSERT INTO `mitarbeiter` VALUES (821, 'Fischer', 'Lutz', '', '', 'lutz@fischer.com', 8, 40, 200, 24, 0, '', '0a8e3638e3c0deb4e5e49c72286a5b83', 0);
INSERT INTO `mitarbeiter` VALUES (828, 'Weiler', 'Emily', '', '', 'emily@weiler.de', 0, 0, 0, 24, 0, '', '9e3ba813c8a21b92135e71a60ae10d6e', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht`
-- 

DROP TABLE IF EXISTS `schicht`;
CREATE TABLE `schicht` (
  `sid` int(11) NOT NULL auto_increment,
  `bez` varchar(40) collate latin1_general_ci default NULL,
  `kbez` varchar(10) collate latin1_general_ci default NULL,
  `ab` time default NULL,
  `bis` time default NULL,
  `color` char(6) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

-- 
-- Daten für Tabelle `schicht`
-- 

INSERT INTO `schicht` VALUES (3, 'Frühschicht', 'FS', '06:00:00', '14:00:00', 'ffb2fe');
INSERT INTO `schicht` VALUES (5, 'Tagschicht', 'TS', '14:00:00', '22:00:00', 'bbeab2');
INSERT INTO `schicht` VALUES (6, 'Nachtschicht', 'NS', '22:00:00', '06:00:00', 'b4b2e0');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht_ma`
-- 

DROP TABLE IF EXISTS `schicht_ma`;
CREATE TABLE `schicht_ma` (
  `tid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `ma` int(11) default NULL,
  PRIMARY KEY  (`tid`,`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `schicht_ma`
-- 

INSERT INTO `schicht_ma` VALUES (1, 3, 3);
INSERT INTO `schicht_ma` VALUES (1, 5, 4);
INSERT INTO `schicht_ma` VALUES (1, 6, 4);
INSERT INTO `schicht_ma` VALUES (2, 3, 3);
INSERT INTO `schicht_ma` VALUES (2, 5, 3);
INSERT INTO `schicht_ma` VALUES (2, 6, 3);
INSERT INTO `schicht_ma` VALUES (3, 3, 3);
INSERT INTO `schicht_ma` VALUES (3, 5, 4);
INSERT INTO `schicht_ma` VALUES (3, 6, 4);
INSERT INTO `schicht_ma` VALUES (4, 3, 3);
INSERT INTO `schicht_ma` VALUES (4, 5, 2);
INSERT INTO `schicht_ma` VALUES (4, 6, 6);
INSERT INTO `schicht_ma` VALUES (5, 3, 2);
INSERT INTO `schicht_ma` VALUES (5, 5, 2);
INSERT INTO `schicht_ma` VALUES (5, 6, 2);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `schicht_mitarbeiter`
-- 

DROP TABLE IF EXISTS `schicht_mitarbeiter`;
CREATE TABLE `schicht_mitarbeiter` (
  `smid` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `termin` date NOT NULL,
  PRIMARY KEY  (`smid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=184 ;

-- 
-- Daten für Tabelle `schicht_mitarbeiter`
-- 

INSERT INTO `schicht_mitarbeiter` VALUES (1, 3, 1, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` VALUES (2, 3, 2, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` VALUES (14, 5, 821, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` VALUES (13, 5, 819, '2011-05-02');
INSERT INTO `schicht_mitarbeiter` VALUES (5, 3, 1, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` VALUES (6, 3, 2, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` VALUES (7, 3, 1, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` VALUES (8, 3, 2, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` VALUES (9, 3, 1, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` VALUES (10, 3, 2, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` VALUES (11, 3, 1, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` VALUES (12, 3, 2, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` VALUES (116, 5, 819, '2011-11-02');
INSERT INTO `schicht_mitarbeiter` VALUES (16, 5, 819, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` VALUES (17, 5, 821, '2011-05-03');
INSERT INTO `schicht_mitarbeiter` VALUES (115, 5, 2, '2011-11-02');
INSERT INTO `schicht_mitarbeiter` VALUES (19, 5, 819, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` VALUES (20, 5, 821, '2011-05-04');
INSERT INTO `schicht_mitarbeiter` VALUES (114, 5, 1, '2011-11-02');
INSERT INTO `schicht_mitarbeiter` VALUES (22, 5, 819, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` VALUES (23, 5, 821, '2011-05-05');
INSERT INTO `schicht_mitarbeiter` VALUES (95, 3, 819, '2011-11-07');
INSERT INTO `schicht_mitarbeiter` VALUES (25, 5, 819, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` VALUES (26, 5, 821, '2011-05-06');
INSERT INTO `schicht_mitarbeiter` VALUES (94, 3, 1, '2011-11-07');
INSERT INTO `schicht_mitarbeiter` VALUES (167, 6, 819, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (166, 6, 821, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (165, 6, 2, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (164, 6, 1, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (145, 6, 828, '2011-12-09');
INSERT INTO `schicht_mitarbeiter` VALUES (92, 5, 1, '2011-10-18');
INSERT INTO `schicht_mitarbeiter` VALUES (144, 6, 821, '2011-12-09');
INSERT INTO `schicht_mitarbeiter` VALUES (91, 5, 819, '2011-10-03');
INSERT INTO `schicht_mitarbeiter` VALUES (147, 3, 1, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (37, 3, 821, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` VALUES (142, 6, 2, '2011-12-09');
INSERT INTO `schicht_mitarbeiter` VALUES (39, 3, 821, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` VALUES (65, 3, 2, '2011-10-03');
INSERT INTO `schicht_mitarbeiter` VALUES (41, 3, 821, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` VALUES (64, 3, 1, '2011-10-03');
INSERT INTO `schicht_mitarbeiter` VALUES (43, 5, 1, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` VALUES (44, 5, 819, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` VALUES (45, 5, 821, '2011-05-09');
INSERT INTO `schicht_mitarbeiter` VALUES (46, 5, 1, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` VALUES (47, 5, 821, '2011-05-10');
INSERT INTO `schicht_mitarbeiter` VALUES (90, 5, 821, '2011-10-03');
INSERT INTO `schicht_mitarbeiter` VALUES (49, 5, 2, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` VALUES (50, 5, 819, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` VALUES (51, 5, 821, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` VALUES (52, 5, 2, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` VALUES (53, 5, 821, '2011-05-12');
INSERT INTO `schicht_mitarbeiter` VALUES (141, 6, 1, '2011-12-09');
INSERT INTO `schicht_mitarbeiter` VALUES (55, 5, 2, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` VALUES (56, 5, 821, '2011-05-13');
INSERT INTO `schicht_mitarbeiter` VALUES (146, 3, 2, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (60, 6, 1, '2011-05-11');
INSERT INTO `schicht_mitarbeiter` VALUES (89, 5, 2, '2011-10-03');
INSERT INTO `schicht_mitarbeiter` VALUES (182, 5, 1, '2011-12-07');
INSERT INTO `schicht_mitarbeiter` VALUES (170, 5, 1, '2011-12-06');
INSERT INTO `schicht_mitarbeiter` VALUES (171, 5, 2, '2011-12-06');
INSERT INTO `schicht_mitarbeiter` VALUES (173, 3, 1, '2011-12-08');
INSERT INTO `schicht_mitarbeiter` VALUES (174, 3, 2, '2011-12-08');
INSERT INTO `schicht_mitarbeiter` VALUES (175, 5, 828, '2011-12-08');
INSERT INTO `schicht_mitarbeiter` VALUES (177, 6, 1, '2011-12-08');
INSERT INTO `schicht_mitarbeiter` VALUES (178, 6, 821, '2011-12-08');
INSERT INTO `schicht_mitarbeiter` VALUES (179, 6, 819, '2011-12-05');
INSERT INTO `schicht_mitarbeiter` VALUES (180, 5, 819, '2011-12-05');
INSERT INTO `schicht_mitarbeiter` VALUES (181, 3, 1, '2011-12-05');
INSERT INTO `schicht_mitarbeiter` VALUES (183, 5, 2, '2011-12-07');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `status`
-- 

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
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
CREATE TABLE `statusquo` (
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
CREATE TABLE `stosszeiten` (
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
CREATE TABLE `tag` (
  `tid` int(11) NOT NULL,
  `name` varchar(20) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Daten für Tabelle `tag`
-- 

INSERT INTO `tag` VALUES (1, 'Montag');
INSERT INTO `tag` VALUES (2, 'Dienstag');
INSERT INTO `tag` VALUES (3, 'Mittwoch');
INSERT INTO `tag` VALUES (4, 'Donnerstag');
INSERT INTO `tag` VALUES (5, 'Freitag');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `urlaub`
-- 

DROP TABLE IF EXISTS `urlaub`;
CREATE TABLE `urlaub` (
  `uid` int(11) NOT NULL auto_increment,
  `mid` int(11) default NULL,
  `ab` date default NULL,
  `bis` date default NULL,
  `tage` int(11) default NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=43 ;

-- 
-- Daten für Tabelle `urlaub`
-- 

INSERT INTO `urlaub` VALUES (18, 1, '2011-09-21', '2011-09-23', 3);
INSERT INTO `urlaub` VALUES (23, 1, '2011-10-21', '2011-10-23', 3);
INSERT INTO `urlaub` VALUES (30, 1, '2011-11-22', '2011-11-25', 4);
INSERT INTO `urlaub` VALUES (28, 828, '2011-10-24', '2011-10-28', 5);
INSERT INTO `urlaub` VALUES (29, 828, '2011-12-27', '2011-12-30', 4);
INSERT INTO `urlaub` VALUES (42, 830, '2011-12-26', '2011-12-30', 0);