-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 19, 2023 alle 13:31
-- Versione del server: 10.4.24-MariaDB
-- Versione PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp_azienda`
--
CREATE DATABASE IF NOT EXISTS `erp_azienda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `erp_azienda`;

-- --------------------------------------------------------

--
-- Struttura della tabella `cart`
--

CREATE TABLE `cart` (
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `ShopID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `customers`
--

CREATE TABLE `customers` (
  `Name` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `PhoneNumber` char(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL,
  `password` varchar(255) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `customers`
--

INSERT INTO `customers` (`Name`, `Surname`, `Address`, `PhoneNumber`, `email`, `token`, `is_active`, `password`, `ID`) VALUES
('Mario', 'Rossi', 'Via Roma 1', '1234567890', '', '', '0', '', 1),
('Giuseppe', 'Verdi', 'Via Garibaldi 2', '0987654321', '', '', '0', '', 2),
('Maria', 'Bianchi', 'Via Dante 3', '5554443333', '', '', '0', '', 3),
('Antonio', 'Neri', 'Via Milano 4', '7778889999', '', '', '0', '', 4),
('Laura', 'Verde', 'Via Torino 5', '1112223333', '', '', '0', '', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `employee`
--

CREATE TABLE `employee` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `employee`
--

INSERT INTO `employee` (`ID`, `email`, `password`) VALUES
(1, 'Mario', 'Rossi'),
(2, 'Luca', 'Bianchi'),
(3, 'Giovanni', 'Verdi'),
(4, 'Paola', 'Neri'),
(5, 'Sara', 'Marrone'),
(8, 'emailDipendente@dipendente.it', '$2y$10$BHdX/GCIcITtPq4GCsnDX.jgx0tGX3/ZZLgHMO8ojT80di91h7G4K');

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Data` date DEFAULT NULL,
  `ShopID` int(11) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `orders`
--

INSERT INTO `orders` (`ID`, `CustomerID`, `ProductID`, `Quantity`, `Data`, `ShopID`, `Address`) VALUES
(20, 0, 5, 4, '2023-04-14', 5, 'Via pfedfsd'),
(21, 0, 2, 2, '2023-04-14', 5, 'Via pfedfsd'),
(22, 0, 5, 2, '2023-04-14', 5, 'Via pfedfsd'),
(23, 29, 1, 8, '2023-04-14', 1, 'via delle vie'),
(24, 29, 6, 3, '2023-04-14', 5, 'via delle vie'),
(25, 30, 2, 3, '2023-04-19', 5, 'via delle vie'),
(26, 30, 4, 3, '2023-04-19', 4, 'via della mucca');

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `LightHard` enum('light','hard') DEFAULT NULL,
  `Drug` enum('cannabis','lsd','funghetti','cocaina','ecstasy','codeina') DEFAULT NULL,
  `Price` decimal(7,2) NOT NULL,
  `AvailableQuantity` int(11) NOT NULL,
  `ShopID` int(11) DEFAULT NULL,
  `imagepath` varchar(255) DEFAULT NULL,
  `ProductName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`ID`, `LightHard`, `Drug`, `Price`, `AvailableQuantity`, `ShopID`, `imagepath`, `ProductName`) VALUES
(1, 'light', 'cannabis', '30.00', 22, 1, 'img/amnesia.png', 'amnesia haze'),
(2, 'light', 'lsd', '50.00', 30, 5, 'img/bart.jpg', 'bart'),
(3, 'light', 'funghetti', '50.00', 15, 3, 'img/funghetti.jpg', 'funghetti'),
(4, 'light', 'cocaina', '50.00', 120, 4, 'img/ECUADOR.jpg', 'ECUADOR'),
(5, 'hard', 'ecstasy', '40.00', 52, 5, 'img/viola.jpg', 'purple'),
(6, 'hard', 'codeina', '100.00', 30, 5, 'img/codeina.jpg', 'codeina');

-- --------------------------------------------------------

--
-- Struttura della tabella `shop`
--

CREATE TABLE `shop` (
  `ID` int(11) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `MaxNumProducts` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `shop`
--

INSERT INTO `shop` (`ID`, `Address`, `MaxNumProducts`, `EmployeeID`) VALUES
(1, 'Via Roma, 10 - Milano', 400, 1),
(2, 'Corso Vittorio Emanuele, 20 - Roma', 150, 2),
(3, 'Via Garibaldi, 30 - Torino', 200, 3),
(4, 'Via Dante, 40 - Firenze', 120, 4),
(5, 'Piazza del Popolo, 50 - Napoli', 180, 5);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `customers`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
