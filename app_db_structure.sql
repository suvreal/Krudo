-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Sob 07. led 2023, 22:20
-- Verze serveru: 8.0.1-dmr
-- Verze PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `krudo`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `tableKrudoSettings`
--

CREATE TABLE `tableKrudoSettings` (
  `ID` int(11) NOT NULL,
  `Code` varchar(128) NOT NULL,
  `Value` text NOT NULL,
  `Note` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `tableProducts`
--

CREATE TABLE `tableProducts` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `ShortDescription` varchar(255) NOT NULL,
  `DiscountPrice` double NOT NULL,
  `Price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `tableUsers`
--

CREATE TABLE `tableUsers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(128) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateCreated` date NOT NULL,
  `UserType` enum('implicit','created') NOT NULL,
  `Active` tinyint(3) NOT NULL,
  `IDUserRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `tableKrudoSettings`
--
ALTER TABLE `tableKrudoSettings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `tableProducts`
--
ALTER TABLE `tableProducts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexy pro tabulku `tableUsers`
--
ALTER TABLE `tableUsers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDUserRole` (`IDUserRole`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `tableKrudoSettings`
--
ALTER TABLE `tableKrudoSettings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `tableProducts`
--
ALTER TABLE `tableProducts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `tableUsers`
--
ALTER TABLE `tableUsers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
