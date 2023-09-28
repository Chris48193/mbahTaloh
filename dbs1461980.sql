-- phpMyAdmin SQL Dump
-- version 4.9.9
-- https://www.phpmyadmin.net/
--
-- Host: db5001771209.hosting-data.io
-- Erstellungszeit: 10. Feb 2022 um 03:17
-- Server-Version: 5.7.36-log
-- PHP-Version: 7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dbs1461980`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `achat`
--

CREATE TABLE `achat` (
  `annee` bigint(20) NOT NULL DEFAULT '0',
  `Id_achat` int(11) NOT NULL,
  `Id_acheteur` int(11) DEFAULT NULL,
  `Article` text,
  `Magasin` text,
  `Prix_unitaire` float DEFAULT '0',
  `Nombre` float DEFAULT '0',
  `Montant` float DEFAULT '0',
  `Remarque` mediumtext,
  `Date_achat` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `achat_avec_facture`
--

CREATE TABLE `achat_avec_facture` (
  `Id_achat` int(11) NOT NULL,
  `montant_total` float DEFAULT NULL,
  `Id_acheteur` int(11) DEFAULT NULL,
  `Session_` bigint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `actifs`
--

CREATE TABLE `actifs` (
  `annee` bigint(20) NOT NULL DEFAULT '0',
  `Id_actif` int(11) NOT NULL,
  `Id_responsable` int(11) DEFAULT NULL,
  `Quantite` decimal(10,0) DEFAULT NULL,
  `Article` mediumtext,
  `Lieu` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `commentaires`
--

CREATE TABLE `commentaires` (
  `Id_comment` int(11) NOT NULL,
  `Commentaire` longtext NOT NULL,
  `Id_pub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inventaire`
--

CREATE TABLE `inventaire` (
  `annee` int(11) NOT NULL DEFAULT '0',
  `Id_inventaire` int(11) NOT NULL,
  `Id_responsable` int(11) DEFAULT NULL,
  `Quantite` decimal(11,0) DEFAULT NULL,
  `Article` mediumtext,
  `Lieu` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `membre`
--

CREATE TABLE `membre` (
  `Id_membre` int(11) NOT NULL,
  `Nom` text,
  `Prenom` text,
  `Hashe` text NOT NULL,
  `Sel` text NOT NULL,
  `Telephone` text,
  `Email` text,
  `Date_de_naissance` date DEFAULT NULL,
  `Adresse` text,
  `Ville` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `participer`
--

CREATE TABLE `participer` (
  `Id_participation` int(11) NOT NULL,
  `Id_session` int(11) NOT NULL,
  `Id_member` int(11) NOT NULL,
  `Prefinancement` double NOT NULL DEFAULT '0',
  `Motif` text,
  `Est_contribuable` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `publication`
--

CREATE TABLE `publication` (
  `Id_publication` int(11) NOT NULL,
  `Content` longtext,
  `date_publication` timestamp NULL DEFAULT NULL,
  `Id_publicateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session_reunion`
--

CREATE TABLE `session_reunion` (
  `annee` int(11) NOT NULL,
  `Arrivee` date DEFAULT NULL,
  `Debut_location_standard` date DEFAULT NULL,
  `Fin_location` date DEFAULT NULL,
  `Nmbr_de_nuit` int(11) DEFAULT NULL,
  `Nmbr_de_participants` int(11) DEFAULT NULL,
  `Nmbr_de_contribuables` int(11) DEFAULT NULL,
  `Contribution_par_personne` double DEFAULT NULL,
  `Montant_achat` double DEFAULT NULL,
  `Montant_achat_et_dons` double DEFAULT NULL,
  `Montant_location` double DEFAULT NULL,
  `Depenses_totales` double DEFAULT NULL,
  `Id_session` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`Id_achat`);

--
-- Indizes für die Tabelle `achat_avec_facture`
--
ALTER TABLE `achat_avec_facture`
  ADD PRIMARY KEY (`Id_achat`);

--
-- Indizes für die Tabelle `actifs`
--
ALTER TABLE `actifs`
  ADD PRIMARY KEY (`Id_actif`);

--
-- Indizes für die Tabelle `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`Id_comment`);

--
-- Indizes für die Tabelle `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`Id_inventaire`);

--
-- Indizes für die Tabelle `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`Id_membre`);

--
-- Indizes für die Tabelle `participer`
--
ALTER TABLE `participer`
  ADD PRIMARY KEY (`Id_participation`);

--
-- Indizes für die Tabelle `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`Id_publication`);

--
-- Indizes für die Tabelle `session_reunion`
--
ALTER TABLE `session_reunion`
  ADD PRIMARY KEY (`Id_session`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `achat`
--
ALTER TABLE `achat`
  MODIFY `Id_achat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `achat_avec_facture`
--
ALTER TABLE `achat_avec_facture`
  MODIFY `Id_achat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `actifs`
--
ALTER TABLE `actifs`
  MODIFY `Id_actif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `Id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `Id_inventaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `membre`
--
ALTER TABLE `membre`
  MODIFY `Id_membre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `participer`
--
ALTER TABLE `participer`
  MODIFY `Id_participation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `publication`
--
ALTER TABLE `publication`
  MODIFY `Id_publication` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `session_reunion`
--
ALTER TABLE `session_reunion`
  MODIFY `Id_session` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
