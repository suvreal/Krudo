-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Stř 11. led 2023, 04:14
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

--
-- Vypisuji data pro tabulku `tableProducts`
--

INSERT INTO `tableProducts` (`ID`, `Title`, `Description`, `ShortDescription`, `DiscountPrice`, `Price`) VALUES
(18, 'A mug', 'mug extra with cool color', 'super, ultra mug', 650, 500),
(19, 'A table', 'all sort of usages besides the things', 'table for things', 150, 100),
(20, 'A shelf', 'elf on a shelf might be also called shelf-l-fish-ness', 'there might be also an elf', 99, 66),
(28, 'Autíčko', 'asdsadadasdsa', 'asdasdasda', 850, 700),
(29, 'Car', 'carrot', 'red car', 25000, 19999),
(30, 'Keyboard', 'Key & key of boards', 'Boards of keys', 500, 321),
(32, 'Entirely new product edited', 'long desc', 'short desc', 156, 159);

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
  `Active` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `tableUsers`
--

INSERT INTO `tableUsers` (`ID`, `Name`, `Email`, `Phone`, `Password`, `DateCreated`, `UserType`, `Active`) VALUES
(2, 'Test Admin User', 'admin@krudo.cz', '987987987', '$2y$12$8SIwGU4nRB8HZn40oe4c1Ow2kx3IM9HlZ7vBbDR8RadLWXJzZrDMS', '2023-01-08', 'created', 0);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `tableProducts`
--
ALTER TABLE `tableProducts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Price` (`Price`);

--
-- Indexy pro tabulku `tableUsers`
--
ALTER TABLE `tableUsers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Email` (`Email`),
  ADD KEY `Phone` (`Phone`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `tableProducts`
--
ALTER TABLE `tableProducts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pro tabulku `tableUsers`
--
ALTER TABLE `tableUsers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
