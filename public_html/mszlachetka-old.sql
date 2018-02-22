/*
Navicat MySQL Data Transfer

Source Server         : projekt
Source Server Version : 50552
Source Host           : 149.156.136.151:3306
Source Database       : mszlachetka

Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2017-02-13 04:11:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ArchiwumUzytkownicy`
-- ----------------------------
DROP TABLE IF EXISTS `ArchiwumUzytkownicy`;
CREATE TABLE `ArchiwumUzytkownicy` (
  `idUzytkownika` int(10) unsigned DEFAULT NULL,
  `imie` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `login` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `haslo` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `idMiasta` int(10) unsigned DEFAULT NULL,
  `nazwaUlicy` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `numerDomu` int(10) DEFAULT NULL,
  `idTypuKonta` int(3) unsigned DEFAULT NULL,
  `akcja` char(1) COLLATE utf8_polish_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci
/*!50100 PARTITION BY HASH (year(`data`))
(PARTITION p0 ENGINE = InnoDB,
 PARTITION p1 ENGINE = InnoDB,
 PARTITION p2 ENGINE = InnoDB,
 PARTITION p3 ENGINE = InnoDB,
 PARTITION p4 ENGINE = InnoDB) */;

-- ----------------------------
-- Records of ArchiwumUzytkownicy
-- ----------------------------
INSERT INTO `ArchiwumUzytkownicy` VALUES ('16', 'dsadasd', 'dsacvxcxvxc', 'sadsa', 'eqweqw', 'mi@dsad.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('14', 'rewrwere', 'qweqw', 'dsfdsfs', 'dsfds', 'sadsad@ppl.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('13', 'ewrwer', 'ewfsdf', 'dfsdsfs', 'dsfdsfds', 'milo@int.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('12', 'eqweqr', 'dsfsdfsdf', 'dsadasd', 'daweqeqw', 'fdsdsfs@in.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('11', 'sadasdasd', 'sadasdsadas', 'sadasd', 'sadsada', 'wqe@interia.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('10', 'dsfdsfsdgbvc', 'bcvbcv', 'fdgfdg', 'dsfdsfs', 'sad@id.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('9', 'bvcvcbcfd', 'gfdfdgdf', 'gfdgfh', 'fdgfdgc', '2345223@dsadsa.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('8', 'dasdacx', 'vcxvxcv', 'wweq', 'eqwdas', 'm@int.pl', null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('7', null, null, 'sdadsa', null, null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('2', 'Agnieszka', 'Drzewo', 'agdrzewo', 'haslo324', 'agnieszka-33@gmail.com', '2', 'Stara', '11', null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('1', 'Miłosz', 'Szlachetka', 'mszlachetka', 'haslo123', 'miloszszl@miloszsz.pl', '1', 'Skośna', '222', null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('45', 'mi', 'asd', 'mi1', 'b2ce4735977d5870aa88', 'msad@wqe.pl', '8', '12', '1', null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('42', 'milosz', 'szlaaa', 'milosz11', 'be441dba423dc0b79da6', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('33', 'milosz', 'szlaaa', 'milosz10', '8c20dece51c78278e19a', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('32', 'milosz', 'szlaaa', 'milosz9', 'b68eaee75bfaf703f514', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('30', 'milosz', 'szlaaa', 'milosz8', '473c615e3862eb60da81', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('28', 'milosz', 'szlaaa', 'milosz7', 'fa9275155f7775a9e963', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('25', 'milosz', 'szlaaa', 'mi6', 'ff12bbd8c907af067070', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('24', 'milosz', 'szlaaa', 'milosz4', 'ff12bbd8c907af067070', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('23', 'milosz', 'szlaaa', 'milosz3', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('22', null, null, 'milosz2', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('20', null, null, 'milosz1', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('18', null, null, 'milosz', '1a7fcdd5a9fd43352326', null, null, null, null, null, 'd', null);
INSERT INTO `ArchiwumUzytkownicy` VALUES ('17', 'qweqwe', 'dsadas', 'sadsad', 'sadsad', 'mil@in.pl', null, null, null, null, 'd', null);

-- ----------------------------
-- Table structure for `ATRYBUTY`
-- ----------------------------
DROP TABLE IF EXISTS `ATRYBUTY`;
CREATE TABLE `ATRYBUTY` (
  `idAtrybutu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idNazwaAtrybutu` int(10) unsigned NOT NULL,
  `wartosc` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idAtrybutu`),
  KEY `fk_idNazwaAtrybutu` (`idNazwaAtrybutu`),
  CONSTRAINT `fk_idNazwaAtrybutu` FOREIGN KEY (`idNazwaAtrybutu`) REFERENCES `NAZWYATRYBOTOW` (`idNazwaAtrybutu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of ATRYBUTY
-- ----------------------------

-- ----------------------------
-- Table structure for `Blokady`
-- ----------------------------
DROP TABLE IF EXISTS `Blokady`;
CREATE TABLE `Blokady` (
  `idBlokady` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_polish_ci DEFAULT 'NULL',
  `dataBlokady` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idBlokady`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Blokady
-- ----------------------------

-- ----------------------------
-- Table structure for `Dostawcy`
-- ----------------------------
DROP TABLE IF EXISTS `Dostawcy`;
CREATE TABLE `Dostawcy` (
  `idDostawcy` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `cena` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idDostawcy`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Dostawcy
-- ----------------------------
INSERT INTO `Dostawcy` VALUES ('1', 'DPD', '15.00');
INSERT INTO `Dostawcy` VALUES ('2', 'DHL', '12.00');
INSERT INTO `Dostawcy` VALUES ('3', 'Poczta Polska', '11.99');
INSERT INTO `Dostawcy` VALUES ('4', 'Inpost', '13.50');

-- ----------------------------
-- Table structure for `HistoriaLogowan`
-- ----------------------------
DROP TABLE IF EXISTS `HistoriaLogowan`;
CREATE TABLE `HistoriaLogowan` (
  `login` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `dataZCzasem` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `czyZalogowanoPomyslnie` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of HistoriaLogowan
-- ----------------------------

-- ----------------------------
-- Table structure for `Kategorie`
-- ----------------------------
DROP TABLE IF EXISTS `Kategorie`;
CREATE TABLE `Kategorie` (
  `idKategorii` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idKategorii`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Kategorie
-- ----------------------------
INSERT INTO `Kategorie` VALUES ('1', 'Witaminy');
INSERT INTO `Kategorie` VALUES ('2', 'Leki przeciwbólowe');
INSERT INTO `Kategorie` VALUES ('3', 'Leki przeciwzapalne');
INSERT INTO `Kategorie` VALUES ('4', 'Odchudzjące');
INSERT INTO `Kategorie` VALUES ('5', 'Kosmetyki');
INSERT INTO `Kategorie` VALUES ('6', 'Antybiotyki');
INSERT INTO `Kategorie` VALUES ('7', 'Antyalergiczne');

-- ----------------------------
-- Table structure for `Komentarze`
-- ----------------------------
DROP TABLE IF EXISTS `Komentarze`;
CREATE TABLE `Komentarze` (
  `idKomentarza` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idUzytkownika` int(10) unsigned NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idKomentarza`),
  KEY `idProduktu` (`idProduktu`),
  KEY `Komentarze_idUzytkownika` (`idUzytkownika`),
  CONSTRAINT `Komentarze_idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `Uzytkownicy` (`idUzytkownika`),
  CONSTRAINT `Komentarze_ibfk_1` FOREIGN KEY (`idProduktu`) REFERENCES `Produkty` (`idProduktu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Komentarze
-- ----------------------------

-- ----------------------------
-- Table structure for `Marki`
-- ----------------------------
DROP TABLE IF EXISTS `Marki`;
CREATE TABLE `Marki` (
  `idMarki` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idMarki`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of Marki
-- ----------------------------
INSERT INTO `Marki` VALUES ('1', 'Bayer');
INSERT INTO `Marki` VALUES ('2', 'USP Zdrowie');
INSERT INTO `Marki` VALUES ('3', 'Polpharma');
INSERT INTO `Marki` VALUES ('4', 'GlaxoSmithKline');
INSERT INTO `Marki` VALUES ('5', 'Johnson & Johnson');

-- ----------------------------
-- Table structure for `Miasta`
-- ----------------------------
DROP TABLE IF EXISTS `Miasta`;
CREATE TABLE `Miasta` (
  `idMiasta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`idMiasta`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Miasta
-- ----------------------------
INSERT INTO `Miasta` VALUES ('1', 'Kraków');
INSERT INTO `Miasta` VALUES ('2', 'Warszawa');
INSERT INTO `Miasta` VALUES ('3', 'Gdańsk');
INSERT INTO `Miasta` VALUES ('4', 'Poznań');
INSERT INTO `Miasta` VALUES ('5', 'Toruń');
INSERT INTO `Miasta` VALUES ('6', 'Rzeszów');
INSERT INTO `Miasta` VALUES ('7', 'Wrocław');
INSERT INTO `Miasta` VALUES ('8', 'Radom');

-- ----------------------------
-- Table structure for `NAZWYATRYBOTOW`
-- ----------------------------
DROP TABLE IF EXISTS `NAZWYATRYBOTOW`;
CREATE TABLE `NAZWYATRYBOTOW` (
  `idNazwaAtrybutu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idNazwaAtrybutu`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of NAZWYATRYBOTOW
-- ----------------------------
INSERT INTO `NAZWYATRYBOTOW` VALUES ('1', 'Postać');
INSERT INTO `NAZWYATRYBOTOW` VALUES ('2', 'Waga');
INSERT INTO `NAZWYATRYBOTOW` VALUES ('3', 'Substancja czynna');
INSERT INTO `NAZWYATRYBOTOW` VALUES ('4', 'Opakowanie');
INSERT INTO `NAZWYATRYBOTOW` VALUES ('5', 'Zawartość_substancji');

-- ----------------------------
-- Table structure for `Oceny`
-- ----------------------------
DROP TABLE IF EXISTS `Oceny`;
CREATE TABLE `Oceny` (
  `idOceny` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idUzytkownika` int(10) unsigned DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wartosc` decimal(3,1) unsigned NOT NULL,
  PRIMARY KEY (`idOceny`),
  KEY `Oceny_ibfk_1` (`idProduktu`),
  KEY `Oceny_idUzytkownika` (`idUzytkownika`),
  CONSTRAINT `Oceny_idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `Uzytkownicy` (`idUzytkownika`) ON DELETE CASCADE,
  CONSTRAINT `Oceny_ibfk_1` FOREIGN KEY (`idProduktu`) REFERENCES `Produkty` (`idProduktu`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Oceny
-- ----------------------------

-- ----------------------------
-- Table structure for `PRATR`
-- ----------------------------
DROP TABLE IF EXISTS `PRATR`;
CREATE TABLE `PRATR` (
  `idProduktu` int(10) unsigned NOT NULL,
  `idAtrybutu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idProduktu`,`idAtrybutu`),
  KEY `fk_idAtrybutu` (`idAtrybutu`),
  CONSTRAINT `fk_idAtrybutu` FOREIGN KEY (`idAtrybutu`) REFERENCES `ATRYBUTY` (`idAtrybutu`),
  CONSTRAINT `fk_idProduktu` FOREIGN KEY (`idProduktu`) REFERENCES `Produkty` (`idProduktu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of PRATR
-- ----------------------------

-- ----------------------------
-- Table structure for `Produkty`
-- ----------------------------
DROP TABLE IF EXISTS `Produkty`;
CREATE TABLE `Produkty` (
  `idProduktu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `opis` text COLLATE utf8_polish_ci,
  `ilosc` int(6) unsigned NOT NULL,
  `idKategorii` int(10) unsigned DEFAULT NULL,
  `idMarki` int(10) unsigned DEFAULT NULL,
  `cena` decimal(6,2) unsigned NOT NULL,
  `ocena` decimal(4,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`idProduktu`),
  KEY `fk_idMarki` (`idMarki`),
  KEY `fk_idKategorii` (`idKategorii`),
  CONSTRAINT `fk_idKategorii` FOREIGN KEY (`idKategorii`) REFERENCES `Kategorie` (`idKategorii`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_idMarki` FOREIGN KEY (`idMarki`) REFERENCES `Marki` (`idMarki`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Produkty
-- ----------------------------
INSERT INTO `Produkty` VALUES ('1', 'Rutinoscorbin', null, '100', '1', '4', '10.50', null);
INSERT INTO `Produkty` VALUES ('2', 'Polopiryna S', null, '200', '3', '3', '12.30', null);

-- ----------------------------
-- Table structure for `ProduktyZamowienia`
-- ----------------------------
DROP TABLE IF EXISTS `ProduktyZamowienia`;
CREATE TABLE `ProduktyZamowienia` (
  `idPrZam` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idZamowienia` int(10) unsigned NOT NULL,
  `ilosc` int(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`idPrZam`),
  KEY `ProduktyZamowienia_ibfk_1` (`idZamowienia`),
  KEY `ProduktyZamowienia_ibfk_2` (`idProduktu`),
  CONSTRAINT `ProduktyZamowienia_ibfk_2` FOREIGN KEY (`idProduktu`) REFERENCES `Produkty` (`idProduktu`) ON DELETE CASCADE,
  CONSTRAINT `ProduktyZamowienia_ibfk_1` FOREIGN KEY (`idZamowienia`) REFERENCES `Zamowienia` (`idZamowienia`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of ProduktyZamowienia
-- ----------------------------

-- ----------------------------
-- Table structure for `Sesja`
-- ----------------------------
DROP TABLE IF EXISTS `Sesja`;
CREATE TABLE `Sesja` (
  `idSesji` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUzytkownika` int(10) unsigned NOT NULL,
  `id` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `ip` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `web` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `czas` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`idSesji`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Sesja
-- ----------------------------

-- ----------------------------
-- Table structure for `StatusyZamowien`
-- ----------------------------
DROP TABLE IF EXISTS `StatusyZamowien`;
CREATE TABLE `StatusyZamowien` (
  `idStatusuZamowienia` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nazwaStatusuZamowienia` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idStatusuZamowienia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of StatusyZamowien
-- ----------------------------
INSERT INTO `StatusyZamowien` VALUES ('1', 'w realizacji');
INSERT INTO `StatusyZamowien` VALUES ('2', 'zrealizowano');
INSERT INTO `StatusyZamowien` VALUES ('3', 'anulowano');

-- ----------------------------
-- Table structure for `TypyKont`
-- ----------------------------
DROP TABLE IF EXISTS `TypyKont`;
CREATE TABLE `TypyKont` (
  `idTypuKonta` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `typKonta` varchar(20) COLLATE utf8_polish_ci DEFAULT '',
  PRIMARY KEY (`idTypuKonta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of TypyKont
-- ----------------------------
INSERT INTO `TypyKont` VALUES ('1', 'użytkownik');
INSERT INTO `TypyKont` VALUES ('2', 'administrator');

-- ----------------------------
-- Table structure for `Uzytkownicy`
-- ----------------------------
DROP TABLE IF EXISTS `Uzytkownicy`;
CREATE TABLE `Uzytkownicy` (
  `idUzytkownika` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imie` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `login` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `haslo` varchar(40) COLLATE utf8_polish_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `telefon` varchar(12) COLLATE utf8_polish_ci DEFAULT NULL,
  `idMiasta` int(10) unsigned DEFAULT NULL,
  `nazwaUlicy` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `numerDomu` varchar(10) COLLATE utf8_polish_ci DEFAULT NULL,
  `idTypuKonta` int(3) unsigned DEFAULT NULL,
  `sol` varchar(10) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`idUzytkownika`),
  UNIQUE KEY `UniqueLoginConstrain` (`login`),
  KEY `idTypuKonta` (`idTypuKonta`),
  KEY `Uzytkownicy_ibfk_1` (`idMiasta`),
  CONSTRAINT `Uzytkownicy_ibfk_1` FOREIGN KEY (`idMiasta`) REFERENCES `Miasta` (`idMiasta`) ON DELETE SET NULL,
  CONSTRAINT `idTypuKonta` FOREIGN KEY (`idTypuKonta`) REFERENCES `TypyKont` (`idTypuKonta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Uzytkownicy
-- ----------------------------

-- ----------------------------
-- Table structure for `Zamowienia`
-- ----------------------------
DROP TABLE IF EXISTS `Zamowienia`;
CREATE TABLE `Zamowienia` (
  `idZamowienia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUzytkownika` int(10) unsigned NOT NULL,
  `dataZamowienia` timestamp NULL DEFAULT NULL,
  `dataRealizacjiZam` timestamp NULL DEFAULT NULL,
  `uwaga` text COLLATE utf8_polish_ci,
  `idDostawcy` int(10) unsigned DEFAULT NULL,
  `idStatusuZamowienia` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`idZamowienia`),
  KEY `idDostawcy` (`idDostawcy`),
  KEY `idUzytkownika` (`idUzytkownika`),
  KEY `idStatusuZamownienia` (`idStatusuZamowienia`),
  CONSTRAINT `idDostawcy` FOREIGN KEY (`idDostawcy`) REFERENCES `Dostawcy` (`idDostawcy`),
  CONSTRAINT `idStatusuZamownienia` FOREIGN KEY (`idStatusuZamowienia`) REFERENCES `StatusyZamowien` (`idStatusuZamowienia`),
  CONSTRAINT `idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `Uzytkownicy` (`idUzytkownika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Zamowienia
-- ----------------------------

-- ----------------------------
-- Table structure for `Zdjecia`
-- ----------------------------
DROP TABLE IF EXISTS `Zdjecia`;
CREATE TABLE `Zdjecia` (
  `idZdjecia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `idProduktu` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idZdjecia`),
  KEY `fk_idProduktu` (`idProduktu`) USING BTREE,
  CONSTRAINT `idProduktu_fk` FOREIGN KEY (`idProduktu`) REFERENCES `Produkty` (`idProduktu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of Zdjecia
-- ----------------------------

-- ----------------------------
-- View structure for `front_page_view`
-- ----------------------------
DROP VIEW IF EXISTS `front_page_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`mszlachetka`@`%` SQL SECURITY DEFINER VIEW `front_page_view` AS select `Zdjecia`.`link` AS `link`,`Produkty`.`nazwa` AS `nazwa`,`Produkty`.`idProduktu` AS `idProduktu`,`Produkty`.`ilosc` AS `ilosc`,`Produkty`.`cena` AS `cena` from (`Produkty` left join `Zdjecia` on((`Zdjecia`.`idProduktu` = `Produkty`.`idProduktu`))) where (`Produkty`.`ilosc` > 0) order by rand() limit 6 ;

-- ----------------------------
-- View structure for `v_order_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_order_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`mszlachetka`@`%` SQL SECURITY DEFINER VIEW `v_order_info` AS select `z`.`idZamowienia` AS `Id_zamowienia`,concat(`m`.`nazwa`,' ',`u`.`nazwaUlicy`,' ',`u`.`numerDomu`) AS `Adres`,`u`.`login` AS `Login`,`z`.`dataZamowienia` AS `Data_zamowienia`,`d`.`nazwa` AS `Nazwa_dostawcy`,`d`.`cena` AS `Cena_dostawcy`,`sz`.`nazwaStatusuZamowienia` AS `Status_zamowienia`,(sum((`p`.`cena` * `pz`.`ilosc`)) + `d`.`cena`) AS `Kosz_całkowity` from ((((((`Uzytkownicy` `u` join `Miasta` `m` on((`m`.`idMiasta` = `u`.`idMiasta`))) join `Zamowienia` `z` on((`z`.`idUzytkownika` = `u`.`idUzytkownika`))) join `Dostawcy` `d` on((`d`.`idDostawcy` = `z`.`idDostawcy`))) join `StatusyZamowien` `sz` on((`sz`.`idStatusuZamowienia` = `z`.`idStatusuZamowienia`))) join `ProduktyZamowienia` `pz` on((`pz`.`idZamowienia` = `z`.`idZamowienia`))) join `Produkty` `p` on((`p`.`idProduktu` = `pz`.`idProduktu`))) where (`z`.`dataZamowienia` is not null) group by `z`.`idZamowienia`,concat(`m`.`nazwa`,' ',`u`.`nazwaUlicy`,' ',`u`.`numerDomu`),`u`.`login`,`z`.`dataZamowienia`,`d`.`nazwa`,`d`.`cena`,`sz`.`nazwaStatusuZamowienia` ;

-- ----------------------------
-- View structure for `v_product_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_product_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`mszlachetka`@`%` SQL SECURITY DEFINER VIEW `v_product_info` AS select `p`.`nazwa` AS `Nazwa_produktu`,`p`.`ilosc` AS `Ilość`,`p`.`cena` AS `Cena_produktu`,`p`.`ocena` AS `Średnia_ocen`,`p`.`opis` AS `Opis`,`m`.`nazwa` AS `Marka`,`k`.`nazwa` AS `Kategoria` from ((`Produkty` `p` join `Marki` `m` on((`p`.`idMarki` = `m`.`idMarki`))) join `Kategorie` `k` on((`k`.`idKategorii` = `p`.`idKategorii`))) ;

-- ----------------------------
-- View structure for `v_user_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_user_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`mszlachetka`@`%` SQL SECURITY DEFINER VIEW `v_user_info` AS select `u`.`idUzytkownika` AS `idUzytkownika`,`u`.`imie` AS `imie`,`u`.`nazwisko` AS `nazwisko`,`u`.`login` AS `login`,`u`.`haslo` AS `haslo`,`u`.`mail` AS `mail`,`u`.`telefon` AS `telefon`,`m`.`nazwa` AS `miasto`,`u`.`nazwaUlicy` AS `nazwaUlicy`,`u`.`numerDomu` AS `numerDomu`,`tk`.`typKonta` AS `typKonta` from ((`Uzytkownicy` `u` join `Miasta` `m` on((`m`.`idMiasta` = `u`.`idMiasta`))) join `TypyKont` `tk` on((`tk`.`idTypuKonta` = `u`.`idTypuKonta`))) ;

-- ----------------------------
-- Procedure structure for `change_pass`
-- ----------------------------
DROP PROCEDURE IF EXISTS `change_pass`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` PROCEDURE `change_pass`(IN `idUser` int(10) unsigned,IN `newPass` varchar(42))
BEGIN
	UPDATE Uzytkownicy SET haslo=newPass
	WHERE idUzytkownika=idUser;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `take_user_id`
-- ----------------------------
DROP PROCEDURE IF EXISTS `take_user_id`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` PROCEDURE `take_user_id`(IN `ids` varchar(200))
BEGIN
SELECT idUzytkownika FROM Sesja WHERE id=ids;

END
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `insert_grade`
-- ----------------------------
DROP FUNCTION IF EXISTS `insert_grade`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` FUNCTION `insert_grade`(`u_id` int(10) unsigned,`rate_val` decimal(3,1), `product_id` int(10) unsigned) RETURNS int(1)
BEGIN
	DECLARE EXIT HANDLER FOR SQLSTATE '12345'
		return 0;

	IF(rate_val<1 OR rate_val>10) THEN
		SIGNAL SQLSTATE '12345' SET MESSAGE_TEXT = 'An error occurred';
	ELSE
		INSERT INTO Oceny (idProduktu,idUzytkownika,wartosc) 
		VALUES (product_id,u_id,rate_val);
		return 1;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `levenshtein`
-- ----------------------------
DROP FUNCTION IF EXISTS `levenshtein`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` FUNCTION `levenshtein`( s1 VARCHAR(255), s2 VARCHAR(255) ) RETURNS int(11)
    DETERMINISTIC
BEGIN
DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
-- max strlen=255
DECLARE cv0, cv1 VARBINARY(256);
SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
IF s1 = s2 THEN
RETURN 0;
ELSEIF s1_len = 0 THEN
RETURN s2_len;
ELSEIF s2_len = 0 THEN
RETURN s1_len;
ELSE
WHILE j <= s2_len DO
SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
END WHILE;
WHILE i <= s1_len DO
SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
WHILE j <= s2_len DO
SET c = c + 1;
IF s1_char = SUBSTRING(s2, j, 1) THEN
SET cost = 0; ELSE SET cost = 1;
END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
IF c > c_temp THEN SET c = c_temp; END IF;
SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
IF c > c_temp THEN
SET c = c_temp;
END IF;
SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
END WHILE;
SET cv1 = cv0, i = i + 1;
END WHILE;
END IF;
RETURN c;
END
;;
DELIMITER ;

-- ----------------------------
-- Function structure for `update_grade`
-- ----------------------------
DROP FUNCTION IF EXISTS `update_grade`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` FUNCTION `update_grade`(`u_id` int(10) unsigned,`rate_val` decimal(3,1), `product_id` int(10) unsigned) RETURNS int(1)
BEGIN
	DECLARE EXIT HANDLER FOR SQLSTATE '12345'
		return 0;

	IF(rate_val<1 OR rate_val>10) THEN
		SIGNAL SQLSTATE '12345' SET MESSAGE_TEXT = 'An error occurred';
	ELSE
		UPDATE Oceny SET wartosc=rate_val 
		WHERE idProduktu=product_id AND idUzytkownika=u_id;
		return 1;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `ArchiwumClearEvent`
-- ----------------------------
DROP EVENT IF EXISTS `ArchiwumClearEvent`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` EVENT `ArchiwumClearEvent` ON SCHEDULE EVERY 1 WEEK STARTS '2016-10-24 14:00:15' ON COMPLETION PRESERVE ENABLE DO delete from ArchiwumUzytkownicy where datediff(now(),`data`)>730
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `BlokadyClearEvent`
-- ----------------------------
DROP EVENT IF EXISTS `BlokadyClearEvent`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` EVENT `BlokadyClearEvent` ON SCHEDULE EVERY 60 SECOND STARTS '2016-12-29 16:29:20' ON COMPLETION PRESERVE ENABLE DO delete from Blokady where TIME_TO_SEC(TIMEDIFF(now(),`dataBlokady`))>=300
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `HistoriaLogowanClearEvent`
-- ----------------------------
DROP EVENT IF EXISTS `HistoriaLogowanClearEvent`;
DELIMITER ;;
CREATE DEFINER=`mszlachetka`@`%` EVENT `HistoriaLogowanClearEvent` ON SCHEDULE EVERY 1 WEEK STARTS '2016-12-29 16:53:53' ON COMPLETION PRESERVE ENABLE DO delete from HistoriaLogowan where datediff(now(),`dataZCzasem`)>365
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `loginTrigger`;
DELIMITER ;;
CREATE TRIGGER `loginTrigger` BEFORE INSERT ON `Blokady` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then
set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `del_zam`;
DELIMITER ;;
CREATE TRIGGER `del_zam` AFTER DELETE ON `ProduktyZamowienia` FOR EACH ROW BEGIN
  DECLARE x INT;
	SET x=(SELECT count(*) FROM ProduktyZamowienia pz  WHERE pz.idZamowienia=old.idZamowienia);
  
	if(x=0) THEN
		DELETE FROM Zamowienia WHERE idZamowienia=old.idZamowienia;
	END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Login_Insert`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Login_Insert` BEFORE INSERT ON `Uzytkownicy` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then
set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Login_Update`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Login_Update` BEFORE UPDATE ON `Uzytkownicy` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then
set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Update`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Update` AFTER UPDATE ON `Uzytkownicy` FOR EACH ROW insert into
ArchiwumUzytkownicy(idUzytkownika,imie,nazwisko,login,haslo,mail,idMiasta,nazwaUlicy,numerDomu,idTypuKonta,akcja) 
values
(old.idUzytkownika,old.imie,old.nazwisko,old.login,old.haslo,old.mail,old.idMiasta,old.nazwaUlicy,
old.numerDomu,old.idTypuKonta,'u')
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Delete`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Delete` AFTER DELETE ON `Uzytkownicy` FOR EACH ROW insert into
ArchiwumUzytkownicy(idUzytkownika,imie,nazwisko,login,haslo,mail,idMiasta,nazwaUlicy,numerDomu,idTypuKonta,akcja) 
values
(old.idUzytkownika,old.imie,old.nazwisko,old.login,old.haslo,old.mail,old.idMiasta,old.nazwaUlicy,
old.numerDomu,old.idTypuKonta,'d')
;;
DELIMITER ;
