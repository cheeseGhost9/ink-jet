-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 13, 2023 alle 22:42
-- Versione del server: 10.4.24-MariaDB
-- Versione PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inkjet`
--
CREATE DATABASE IF NOT EXISTS `inkjet` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `inkjet`;

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `id_commento` int(11) NOT NULL,
  `testo_commento` varchar(512) DEFAULT NULL,
  `data_commento` date NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_pubblicazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`id_commento`, `testo_commento`, `data_commento`, `id_utente`, `id_pubblicazione`) VALUES
(1, 'che bello', '2023-01-19', 3, 1),
(2, 'meraviglia', '2023-01-19', 3, 2),
(3, 'LOL', '2023-01-19', 2, 1),
(4, 'XD', '2023-01-19', 1, 5),
(5, 'GTFO', '2023-01-19', 3, 4),
(9, 'ahahah', '2023-02-11', 3, 1),
(10, 'ciao', '2023-02-11', 3, 21),
(11, 'dsaad', '2023-02-13', 4, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `follow`
--

CREATE TABLE `follow` (
  `id_utente` int(11) NOT NULL,
  `id_utente_seguito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `follow`
--

INSERT INTO `follow` (`id_utente`, `id_utente_seguito`) VALUES
(2, 1),
(3, 1),
(3, 4),
(4, 1),
(4, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `id_notifica` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `testo_notifica` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `pubblicazione`
--

CREATE TABLE `pubblicazione` (
  `id_pubblicazione` int(11) NOT NULL,
  `testo_pubblicazione` varchar(1024) DEFAULT NULL,
  `img_pubblicazione` varchar(100) DEFAULT NULL,
  `data_pubblicazione` date NOT NULL,
  `id_utente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `pubblicazione`
--

INSERT INTO `pubblicazione` (`id_pubblicazione`, `testo_pubblicazione`, `img_pubblicazione`, `data_pubblicazione`, `id_utente`) VALUES
(1, 'ciao', NULL, '2023-01-19', 1),
(2, 'hello', NULL, '2023-01-18', 1),
(3, 'privit', NULL, '2023-01-02', 1),
(4, 'buonasera', NULL, '2022-10-12', 2),
(5, 'good evening', NULL, '2022-12-13', 2),
(7, 'eeeeeeeeeeeeeeeee', 'Immagine WhatsApp 2022-11-30 ore 23.42.20_2.jpg', '2023-01-21', 4),
(17, 'aaa', NULL, '2023-01-23', 4),
(21, 'dasad', '', '2023-01-24', 4),
(22, 'Dddsss', '', '2023-01-24', 4),
(26, 'fff', 'default_pfp_2.jpg', '2023-01-26', 4),
(27, 'ckjhgcghvlhv', NULL, '2023-01-26', 4),
(28, 'i7g7o8', NULL, '2023-01-26', 4),
(29, 'yg', NULL, '2023-01-26', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id_utente` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL,
  `data_nascita` date NOT NULL,
  `nome_utente` varchar(32) NOT NULL,
  `img_utente` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id_utente`, `email`, `password`, `data_nascita`, `nome_utente`, `img_utente`) VALUES
(1, 'a@a.a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', '2000-01-01', 'aaa', 'Schema ER_6.jpg'),
(2, 'd@d.d', '18ac3e7343f016890c510e93f935261169d9e3f565436429830faf0934f4f8e4', '2000-01-01', 'ddd', 'default_pfp.jpg'),
(3, 'g@g.g', 'cd0aa9856147b6c5b4ff2b7dfee5da20aa38253099ef1b4a64aced233c9afe29', '2000-01-01', 'ggg', 'i58e1t37fkr91.png'),
(4, 'c@c.c', '2e7d2c03a9507ae265ecf5b5356885a53393a2029d241394997265a1a25aefc6', '1998-01-01', 'cia', 'Schema ER_6.jpg'),
(7, 'q@q.q', '8e35c2cd3bf6641bdb0e2050b76932cbb2e6034a0ddacc1d9bea82a6ba57f7cf', '0000-00-00', 'q', '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`id_commento`),
  ADD KEY `fk_commento_utente_idx` (`id_utente`),
  ADD KEY `fk_commento_pubblicazione_idx` (`id_pubblicazione`);

--
-- Indici per le tabelle `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_utente`,`id_utente_seguito`),
  ADD KEY `fk_follow_utente_idx` (`id_utente`),
  ADD KEY `fk_follow_utente_seguito_idx` (`id_utente_seguito`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`id_notifica`),
  ADD KEY `fk_notifica_utente_idx` (`id_utente`);

--
-- Indici per le tabelle `pubblicazione`
--
ALTER TABLE `pubblicazione`
  ADD PRIMARY KEY (`id_pubblicazione`),
  ADD KEY `fk_pubblicazione_utente_idx` (`id_utente`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id_commento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `id_notifica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `pubblicazione`
--
ALTER TABLE `pubblicazione`
  MODIFY `id_pubblicazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `fk_commento_pubblicazione` FOREIGN KEY (`id_pubblicazione`) REFERENCES `pubblicazione` (`id_pubblicazione`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_commento_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `fk_follow_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_follow_utente_seguito` FOREIGN KEY (`id_utente_seguito`) REFERENCES `utente` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `fk_notifica_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `pubblicazione`
--
ALTER TABLE `pubblicazione`
  ADD CONSTRAINT `fk_pubblicazione_utente` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id_utente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
