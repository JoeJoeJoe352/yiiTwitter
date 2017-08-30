-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Aug 30. 16:40
-- Kiszolgáló verziója: 10.1.25-MariaDB
-- PHP verzió: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `yiitwitter`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tweet`
--

CREATE TABLE `tweet` (
  `tweetid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` varchar(160) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `tweet`
--

INSERT INTO `tweet` (`tweetid`, `userid`, `text`, `date`, `visits`) VALUES
(2, 1, 'almaalmaalmaalmaalmaalmaalmaalma', '2017-08-28 09:18:25', 23),
(3, 1, 'ez már remélem jó lesz mint timestamp. mehhhh', '0000-00-00 00:00:00', 1),
(4, 1, 'Gyerünk dátum haver, meg tudod te csinálni', '2017-08-24 12:07:01', 0),
(5, 1, 'asdasdasdasdasdasdasdasd', '2017-08-29 10:40:53', 5),
(6, 2, 'na, hátha jó az userid2', '2017-08-29 10:42:07', 14),
(8, 4, 'ProbaProba', '2017-08-30 14:36:34', 1),
(9, 4, 'ProbaProbaProba', '2017-08-30 14:36:40', 1),
(10, 4, 'ProbaProbaProbaProba', '2017-08-30 14:36:48', 1),
(11, 4, 'ProbaProbaProbaProba', '2017-08-30 14:37:04', 1),
(12, 4, 'ProbaProbaProbaProbaProba', '2017-08-30 14:37:11', 1),
(13, 4, 'ProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:17', 1),
(14, 4, 'ProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:23', 1),
(15, 4, 'ProbaProbaProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:29', 1),
(16, 4, 'ProbaProbaProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:38', 1),
(17, 4, 'ProbaProbaProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:44', 1),
(18, 4, 'ProbaProbaProbaProbaProbaProbaProbaProbaProbaProba', '2017-08-30 14:37:50', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`userid`, `name`, `email`, `pass`) VALUES
(1, 'asdasd', 'asd@asd.com', 'asdasd'),
(2, 'Alma12', 'a@b.com', 'alma12'),
(4, 'Proba1', 'proba@proba.com', 'Proba1');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`tweetid`),
  ADD KEY `userid` (`userid`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `tweet`
--
ALTER TABLE `tweet`
  MODIFY `tweetid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
