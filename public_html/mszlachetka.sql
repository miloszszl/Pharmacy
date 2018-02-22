/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mszlachetka

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-02-14 00:07:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `archiwumuzytkownicy`
-- ----------------------------
DROP TABLE IF EXISTS `archiwumuzytkownicy`;
CREATE TABLE `archiwumuzytkownicy` (
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
-- Records of archiwumuzytkownicy
-- ----------------------------
INSERT INTO `archiwumuzytkownicy` VALUES ('16', 'dsadasd', 'dsacvxcxvxc', 'sadsa', 'eqweqw', 'mi@dsad.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('14', 'rewrwere', 'qweqw', 'dsfdsfs', 'dsfds', 'sadsad@ppl.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('13', 'ewrwer', 'ewfsdf', 'dfsdsfs', 'dsfdsfds', 'milo@int.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('12', 'eqweqr', 'dsfsdfsdf', 'dsadasd', 'daweqeqw', 'fdsdsfs@in.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('11', 'sadasdasd', 'sadasdsadas', 'sadasd', 'sadsada', 'wqe@interia.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('10', 'dsfdsfsdgbvc', 'bcvbcv', 'fdgfdg', 'dsfdsfs', 'sad@id.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('9', 'bvcvcbcfd', 'gfdfdgdf', 'gfdgfh', 'fdgfdgc', '2345223@dsadsa.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('8', 'dasdacx', 'vcxvxcv', 'wweq', 'eqwdas', 'm@int.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('7', null, null, 'sdadsa', null, null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'Agnieszka', 'Drzewo', 'agdrzewo', 'haslo324', 'agnieszka-33@gmail.com', '2', 'Stara', '11', null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'Miłosz', 'Szlachetka', 'mszlachetka', 'haslo123', 'miloszszl@miloszsz.pl', '1', 'Skośna', '222', null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('45', 'mi', 'asd', 'mi1', 'b2ce4735977d5870aa88', 'msad@wqe.pl', '8', '12', '1', null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('42', 'milosz', 'szlaaa', 'milosz11', 'be441dba423dc0b79da6', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('33', 'milosz', 'szlaaa', 'milosz10', '8c20dece51c78278e19a', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('32', 'milosz', 'szlaaa', 'milosz9', 'b68eaee75bfaf703f514', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('30', 'milosz', 'szlaaa', 'milosz8', '473c615e3862eb60da81', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('28', 'milosz', 'szlaaa', 'milosz7', 'fa9275155f7775a9e963', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('25', 'milosz', 'szlaaa', 'mi6', 'ff12bbd8c907af067070', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('24', 'milosz', 'szlaaa', 'milosz4', 'ff12bbd8c907af067070', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('23', 'milosz', 'szlaaa', 'milosz3', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('22', null, null, 'milosz2', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('20', null, null, 'milosz1', '207023ccb44feb4d7dad', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('18', null, null, 'milosz', '1a7fcdd5a9fd43352326', null, null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('17', 'qweqwe', 'dsadas', 'sadsad', 'sadsad', 'mil@in.pl', null, null, null, null, 'd', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'sada', 'dada', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'sada', 'dada', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'sadasd', 'dada', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'sadasd', 'dada', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('3', 'sdd', 'dsd', '\\\\', '9769eea5a15855f64ec6', 'misasd@dsada.pl', '2', 'fdfddf', '0', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('3', 'sdd', 'dsd', '\\\\', 'e3a67db601c0c9b7c819', 'misasd@dsada.pl', '2', 'fdfddf', '0', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'ssdfv', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '1', 'sad', '0', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '1', 'sad', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'sad', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'sad', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'sad', '25', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczx', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'sad', '25', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczxs', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'sad', '25', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczxs', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', 'asdasd', '25', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczxs', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', '312321', '25', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('2', 'sadczxs', 'sadczx', 'milosz', 'd1dd7e5484419896f05b', 'miloszszl@sdada.asdsa', '2', '312321', '25', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('4', 'asdasd', 'sada', '\\\\\\\\\\', '56f86375011caf02ee4f', 'dasdasf@sad.sa', '3', '12da', '12', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('4', 'asdasd', 'asdasd', '\\\\\\\\\\\\\\\\\\\\', '56f86375011caf02ee4f', 'dasdasf@sad.sa', '3', '12da', '12', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', 'sadasd', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', '&lt;noscript&gt;', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', '&lt;noscript&gt;', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', '&lt;noscript&gt;', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', '&lt;noscript&gt;', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('1', '&lt;noscript&gt;', 'dadad', 'admin', '30db58c61d9ea3ceeb49', 'sad@das.asd', '3', 'scsd', '0', '2', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('4', 'asdasd', 'asdasd', '\\\\\\\\\\', '56f86375011caf02ee4f', 'dasdasf@sad.sa', '3', '12da', '12', '1', 'u', null);
INSERT INTO `archiwumuzytkownicy` VALUES ('4', 'asdasd', 'asdasd', '\\\\\\\\\\', '56f86375011caf02ee4f', 'dasdasf@sad.sa', '4', '12da', '12', '1', 'u', null);

-- ----------------------------
-- Table structure for `atrybuty`
-- ----------------------------
DROP TABLE IF EXISTS `atrybuty`;
CREATE TABLE `atrybuty` (
  `idAtrybutu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idNazwaAtrybutu` int(10) unsigned NOT NULL,
  `wartosc` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idAtrybutu`),
  KEY `fk_idNazwaAtrybutu` (`idNazwaAtrybutu`),
  CONSTRAINT `fk_idNazwaAtrybutu` FOREIGN KEY (`idNazwaAtrybutu`) REFERENCES `nazwyatrybotow` (`idNazwaAtrybutu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of atrybuty
-- ----------------------------

-- ----------------------------
-- Table structure for `blokady`
-- ----------------------------
DROP TABLE IF EXISTS `blokady`;
CREATE TABLE `blokady` (
  `idBlokady` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_polish_ci DEFAULT 'NULL',
  `dataBlokady` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idBlokady`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of blokady
-- ----------------------------

-- ----------------------------
-- Table structure for `dostawcy`
-- ----------------------------
DROP TABLE IF EXISTS `dostawcy`;
CREATE TABLE `dostawcy` (
  `idDostawcy` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `cena` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idDostawcy`),
  UNIQUE KEY `nazwa` (`nazwa`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of dostawcy
-- ----------------------------
INSERT INTO `dostawcy` VALUES ('1', 'DPD', '15.00');
INSERT INTO `dostawcy` VALUES ('2', 'DHL', '12.00');
INSERT INTO `dostawcy` VALUES ('3', 'Poczta Polska', '11.99');
INSERT INTO `dostawcy` VALUES ('4', 'Inpost', '13.50');
INSERT INTO `dostawcy` VALUES ('5', 'ASD', '12.00');
INSERT INTO `dostawcy` VALUES ('16', 'ASDASD', '12.01');

-- ----------------------------
-- Table structure for `historialogowan`
-- ----------------------------
DROP TABLE IF EXISTS `historialogowan`;
CREATE TABLE `historialogowan` (
  `login` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `dataZCzasem` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `czyZalogowanoPomyslnie` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of historialogowan
-- ----------------------------
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 05:52:45', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 05:53:35', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 07:26:14', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 09:06:11', '1');
INSERT INTO `historialogowan` VALUES ('\\\\', '2017-02-13 09:22:27', '1');
INSERT INTO `historialogowan` VALUES ('\\\\', '2017-02-13 09:24:54', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 09:45:46', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 10:00:02', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 10:42:57', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 11:09:39', '0');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 11:09:43', '0');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 11:09:47', '0');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 11:09:50', '0');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 11:09:53', '0');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 15:00:02', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 15:00:08', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 17:24:13', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 18:31:32', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 18:51:11', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 18:54:39', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 19:29:55', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 19:30:07', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 19:30:32', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 19:31:39', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 19:46:12', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 20:53:41', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 22:40:39', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 22:41:18', '1');
INSERT INTO `historialogowan` VALUES ('\\\\\\\\\\', '2017-02-13 22:56:18', '1');
INSERT INTO `historialogowan` VALUES ('admin', '2017-02-13 22:56:27', '1');
INSERT INTO `historialogowan` VALUES ('milosz', '2017-02-13 23:01:02', '1');

-- ----------------------------
-- Table structure for `kategorie`
-- ----------------------------
DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE `kategorie` (
  `idKategorii` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idKategorii`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of kategorie
-- ----------------------------
INSERT INTO `kategorie` VALUES ('1', 'Witaminy');
INSERT INTO `kategorie` VALUES ('2', 'Leki przeciwbólowe');
INSERT INTO `kategorie` VALUES ('3', 'Leki przeciwzapalne');
INSERT INTO `kategorie` VALUES ('4', 'Odchudzjące');
INSERT INTO `kategorie` VALUES ('5', 'Kosmetyki');
INSERT INTO `kategorie` VALUES ('6', 'Antybiotyki');
INSERT INTO `kategorie` VALUES ('7', 'Antyalergiczne');

-- ----------------------------
-- Table structure for `komentarze`
-- ----------------------------
DROP TABLE IF EXISTS `komentarze`;
CREATE TABLE `komentarze` (
  `idKomentarza` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idUzytkownika` int(10) unsigned NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idKomentarza`),
  KEY `idProduktu` (`idProduktu`),
  KEY `Komentarze_idUzytkownika` (`idUzytkownika`),
  CONSTRAINT `Komentarze_ibfk_1` FOREIGN KEY (`idProduktu`) REFERENCES `produkty` (`idProduktu`),
  CONSTRAINT `Komentarze_idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`idUzytkownika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of komentarze
-- ----------------------------

-- ----------------------------
-- Table structure for `marki`
-- ----------------------------
DROP TABLE IF EXISTS `marki`;
CREATE TABLE `marki` (
  `idMarki` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idMarki`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of marki
-- ----------------------------
INSERT INTO `marki` VALUES ('1', 'Bayer');
INSERT INTO `marki` VALUES ('2', 'USP Zdrowie');
INSERT INTO `marki` VALUES ('3', 'Polpharma');
INSERT INTO `marki` VALUES ('4', 'GlaxoSmithKline1');
INSERT INTO `marki` VALUES ('5', 'Johnson & Johnson');
INSERT INTO `marki` VALUES ('6', 'fdg degdf d fdf gdf');

-- ----------------------------
-- Table structure for `miasta`
-- ----------------------------
DROP TABLE IF EXISTS `miasta`;
CREATE TABLE `miasta` (
  `idMiasta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`idMiasta`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of miasta
-- ----------------------------
INSERT INTO `miasta` VALUES ('1', 'Kraków');
INSERT INTO `miasta` VALUES ('2', 'Warszawa');
INSERT INTO `miasta` VALUES ('3', 'Gdańsk');
INSERT INTO `miasta` VALUES ('4', 'Poznań');
INSERT INTO `miasta` VALUES ('5', 'Toruń');
INSERT INTO `miasta` VALUES ('6', 'Rzeszów');
INSERT INTO `miasta` VALUES ('7', 'Wrocław');
INSERT INTO `miasta` VALUES ('8', 'Radom');

-- ----------------------------
-- Table structure for `nazwyatrybotow`
-- ----------------------------
DROP TABLE IF EXISTS `nazwyatrybotow`;
CREATE TABLE `nazwyatrybotow` (
  `idNazwaAtrybutu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idNazwaAtrybutu`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of nazwyatrybotow
-- ----------------------------
INSERT INTO `nazwyatrybotow` VALUES ('1', 'Postać');
INSERT INTO `nazwyatrybotow` VALUES ('2', 'Waga');
INSERT INTO `nazwyatrybotow` VALUES ('3', 'Substancja czynna');
INSERT INTO `nazwyatrybotow` VALUES ('4', 'Opakowanie');
INSERT INTO `nazwyatrybotow` VALUES ('5', 'Zawartość_substancji');

-- ----------------------------
-- Table structure for `oceny`
-- ----------------------------
DROP TABLE IF EXISTS `oceny`;
CREATE TABLE `oceny` (
  `idOceny` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idUzytkownika` int(10) unsigned DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wartosc` decimal(3,1) unsigned NOT NULL,
  PRIMARY KEY (`idOceny`),
  KEY `Oceny_ibfk_1` (`idProduktu`),
  KEY `Oceny_idUzytkownika` (`idUzytkownika`),
  CONSTRAINT `Oceny_ibfk_1` FOREIGN KEY (`idProduktu`) REFERENCES `produkty` (`idProduktu`) ON DELETE CASCADE,
  CONSTRAINT `Oceny_idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`idUzytkownika`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of oceny
-- ----------------------------
INSERT INTO `oceny` VALUES ('1', '2', '1', '2017-02-13 20:36:21', '5.0');
INSERT INTO `oceny` VALUES ('2', '3', '1', '2017-02-13 20:44:26', '1.0');
INSERT INTO `oceny` VALUES ('3', '11', '1', '2017-02-13 21:16:14', '9.0');

-- ----------------------------
-- Table structure for `pratr`
-- ----------------------------
DROP TABLE IF EXISTS `pratr`;
CREATE TABLE `pratr` (
  `idProduktu` int(10) unsigned NOT NULL,
  `idAtrybutu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idProduktu`,`idAtrybutu`),
  KEY `fk_idAtrybutu` (`idAtrybutu`),
  CONSTRAINT `fk_idAtrybutu` FOREIGN KEY (`idAtrybutu`) REFERENCES `atrybuty` (`idAtrybutu`),
  CONSTRAINT `fk_idProduktu` FOREIGN KEY (`idProduktu`) REFERENCES `produkty` (`idProduktu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of pratr
-- ----------------------------

-- ----------------------------
-- Table structure for `produkty`
-- ----------------------------
DROP TABLE IF EXISTS `produkty`;
CREATE TABLE `produkty` (
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
  CONSTRAINT `fk_idKategorii` FOREIGN KEY (`idKategorii`) REFERENCES `kategorie` (`idKategorii`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_idMarki` FOREIGN KEY (`idMarki`) REFERENCES `marki` (`idMarki`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of produkty
-- ----------------------------
INSERT INTO `produkty` VALUES ('1', 'Rutinoscorbin', 'cxxvgxgfd3', '722', '1', '4', '15.00', null);
INSERT INTO `produkty` VALUES ('2', 'Polopiryna S', '', '179', '3', '3', '12.78', '5.00');
INSERT INTO `produkty` VALUES ('3', 'czxc', 'sdfdf', '141', '2', '2', '123.00', '1.00');
INSERT INTO `produkty` VALUES ('4', 'dsaasd', 'fddfdf', '113328', '2', '3', '32.00', null);
INSERT INTO `produkty` VALUES ('5', 'bdfhfg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '3424', '1', '1', '233.00', null);
INSERT INTO `produkty` VALUES ('6', 'saddaczxcz', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '213', '1', '1', '121.33', null);
INSERT INTO `produkty` VALUES ('7', 'wqefss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '1223', '1', '4', '1211.00', null);
INSERT INTO `produkty` VALUES ('8', 'wdvxcv asd a', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '21324', '1', '1', '12.50', null);
INSERT INTO `produkty` VALUES ('9', 'sfsvc sd fds', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\n\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '2342', '1', '3', '123.00', null);
INSERT INTO `produkty` VALUES ('10', 'sadvxc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '21', '1', '3', '23.00', null);
INSERT INTO `produkty` VALUES ('11', '123fsz', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '1204', '1', '2', '123.00', '9.00');
INSERT INTO `produkty` VALUES ('12', 'sadgfhg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '3242', '1', '3', '123.00', null);
INSERT INTO `produkty` VALUES ('13', 'jhggh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '54', '3', '4', '6.00', null);
INSERT INTO `produkty` VALUES ('14', 's565fgh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '67', '1', '3', '123.00', null);
INSERT INTO `produkty` VALUES ('15', 'jhggh76', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '54', '3', '4', '56.00', null);
INSERT INTO `produkty` VALUES ('16', 'wqef456ss', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '1230', '1', '4', '1211.00', null);
INSERT INTO `produkty` VALUES ('17', 'wde  sf d a', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '2124', '1', '1', '1350.00', null);
INSERT INTO `produkty` VALUES ('18', 'sfsvc swefds', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '233', '1', '3', '99.00', null);
INSERT INTO `produkty` VALUES ('19', 'sad2vxc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '21', '1', '3', '23.00', null);
INSERT INTO `produkty` VALUES ('20', '1 as 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '1222', '1', '2', '123.00', null);
INSERT INTO `produkty` VALUES ('21', '1fgbn', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '1233', '1', '2', '133.00', null);
INSERT INTO `produkty` VALUES ('22', 's232fv', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '3242', '1', '3', '1210.00', null);
INSERT INTO `produkty` VALUES ('23', 'jhg23gh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '54', '3', '4', '633.00', null);
INSERT INTO `produkty` VALUES ('24', 's32f5fgh', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '611', '1', '3', '1223.00', null);
INSERT INTO `produkty` VALUES ('25', 'jhg43', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '54', '3', '4', '56.00', null);
INSERT INTO `produkty` VALUES ('26', 'sf sdswefds', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '233', '1', '3', '99.00', null);
INSERT INTO `produkty` VALUES ('27', 'sad2 32vxc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut erat risus, dictum a faucibus ac, convallis ut risus. Morbi commodo consectetur mi sed suscipit. Aenean lobortis, magna sed eleifend congue, nunc elit molestie dolor, id vestibulum metus purus quis orci. Vivamus lorem arcu, porta eget blandit ut, euismod id libero. In efficitur nunc sit amet elit convallis venenatis ut ac libero. Morbi ac convallis diam. Aliquam tortor purus, tristique a elit eget, interdum lobortis risus.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Mauris nec nisi bibendum, hendrerit lectus commodo, venenatis felis. Phasellus dolor sem, lacinia et egestas ac, euismod et leo. Duis condimentum blandit pellentesque. Suspendisse sit amet lorem placerat, lobortis quam vel, tristique justo. Suspendisse laoreet malesuada mi vitae sodales. In faucibus nec est eget elementum. Sed id orci risus. Mauris consectetur ullamcorper dolor, sed posuere libero elementum et. Phasellus suscipit erat ut porttitor tristique. Mauris quis quam sed ex vestibulum pulvinar.', '214', '1', '3', '233.40', null);

-- ----------------------------
-- Table structure for `produktyzamowienia`
-- ----------------------------
DROP TABLE IF EXISTS `produktyzamowienia`;
CREATE TABLE `produktyzamowienia` (
  `idPrZam` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProduktu` int(10) unsigned NOT NULL,
  `idZamowienia` int(10) unsigned NOT NULL,
  `ilosc` int(3) unsigned NOT NULL DEFAULT '1',
  `cenaZamowieniowa` decimal(6,2) unsigned NOT NULL,
  PRIMARY KEY (`idPrZam`),
  KEY `ProduktyZamowienia_ibfk_1` (`idZamowienia`),
  KEY `ProduktyZamowienia_ibfk_2` (`idProduktu`),
  CONSTRAINT `ProduktyZamowienia_ibfk_1` FOREIGN KEY (`idZamowienia`) REFERENCES `zamowienia` (`idZamowienia`) ON DELETE CASCADE,
  CONSTRAINT `ProduktyZamowienia_ibfk_2` FOREIGN KEY (`idProduktu`) REFERENCES `produkty` (`idProduktu`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of produktyzamowienia
-- ----------------------------
INSERT INTO `produktyzamowienia` VALUES ('1', '3', '1', '7', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('2', '1', '2', '4', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('3', '3', '3', '1', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('5', '1', '1', '1', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('6', '1', '4', '6', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('8', '2', '1', '3', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('9', '2', '6', '5', '0.00');
INSERT INTO `produktyzamowienia` VALUES ('16', '3', '7', '3', '123.00');
INSERT INTO `produktyzamowienia` VALUES ('18', '2', '7', '6', '12.30');
INSERT INTO `produktyzamowienia` VALUES ('19', '1', '7', '33', '12.00');
INSERT INTO `produktyzamowienia` VALUES ('20', '4', '7', '1', '32.00');
INSERT INTO `produktyzamowienia` VALUES ('21', '1', '7', '5', '15.00');
INSERT INTO `produktyzamowienia` VALUES ('22', '1', '8', '2', '15.00');
INSERT INTO `produktyzamowienia` VALUES ('23', '3', '8', '9', '123.00');
INSERT INTO `produktyzamowienia` VALUES ('25', '2', '8', '8', '12.30');
INSERT INTO `produktyzamowienia` VALUES ('26', '2', '8', '1', '12.78');
INSERT INTO `produktyzamowienia` VALUES ('27', '4', '8', '7', '32.00');
INSERT INTO `produktyzamowienia` VALUES ('28', '3', '9', '53', '123.00');
INSERT INTO `produktyzamowienia` VALUES ('29', '16', '9', '1', '1211.00');
INSERT INTO `produktyzamowienia` VALUES ('31', '11', '9', '19', '123.00');

-- ----------------------------
-- Table structure for `sesja`
-- ----------------------------
DROP TABLE IF EXISTS `sesja`;
CREATE TABLE `sesja` (
  `idSesji` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUzytkownika` int(10) unsigned NOT NULL,
  `id` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `ip` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `web` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `czas` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`idSesji`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of sesja
-- ----------------------------
INSERT INTO `sesja` VALUES ('14', '1', '03175c39fc9fbab446e0e9871ed03a19c1a29c0c5face901b576e53556aa61f3b2b7bdbf7e2baba9', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '2017-02-13 22:56:27', 'wLvvoe8ooOjnfQxycbKw');

-- ----------------------------
-- Table structure for `statusyzamowien`
-- ----------------------------
DROP TABLE IF EXISTS `statusyzamowien`;
CREATE TABLE `statusyzamowien` (
  `idStatusuZamowienia` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nazwaStatusuZamowienia` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`idStatusuZamowienia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of statusyzamowien
-- ----------------------------
INSERT INTO `statusyzamowien` VALUES ('1', 'w realizacji');
INSERT INTO `statusyzamowien` VALUES ('2', 'zrealizowano');
INSERT INTO `statusyzamowien` VALUES ('3', 'anulowano');

-- ----------------------------
-- Table structure for `typykont`
-- ----------------------------
DROP TABLE IF EXISTS `typykont`;
CREATE TABLE `typykont` (
  `idTypuKonta` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `typKonta` varchar(20) COLLATE utf8_polish_ci DEFAULT '',
  PRIMARY KEY (`idTypuKonta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of typykont
-- ----------------------------
INSERT INTO `typykont` VALUES ('1', 'użytkownik');
INSERT INTO `typykont` VALUES ('2', 'administrator');

-- ----------------------------
-- Table structure for `uzytkownicy`
-- ----------------------------
DROP TABLE IF EXISTS `uzytkownicy`;
CREATE TABLE `uzytkownicy` (
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
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `mail` (`mail`),
  KEY `idTypuKonta` (`idTypuKonta`),
  KEY `Uzytkownicy_ibfk_1` (`idMiasta`),
  CONSTRAINT `Uzytkownicy_ibfk_1` FOREIGN KEY (`idMiasta`) REFERENCES `miasta` (`idMiasta`) ON DELETE SET NULL,
  CONSTRAINT `idTypuKonta` FOREIGN KEY (`idTypuKonta`) REFERENCES `typykont` (`idTypuKonta`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of uzytkownicy
-- ----------------------------
INSERT INTO `uzytkownicy` VALUES ('1', '&lt;noscript&gt;', '\\\\\\\\\\', 'admin', '30db58c61d9ea3ceeb4950c98224b14a173ec3b9', 'sad@das.asd', '123123123', '3', 'scsd', 'sfd', '2', '1828308360');
INSERT INTO `uzytkownicy` VALUES ('2', 'sadczxs', 'sadczsds', 'milosz', 'd1dd7e5484419896f05b81f92a96e6c377bc611a', 'miloszszl@sdada.asdsa', '123123122', '2', '312321', '25 a sd', '1', '1521420553');
INSERT INTO `uzytkownicy` VALUES ('3', 'sdd', 'dsd', '\\\\', 'bc554346d3d1ee3714d2cd74c241d95b5e391215', 'misasd@dsada.pl', '123123123', '2', 'fdfddf', 'dfd', '1', '1007889683');
INSERT INTO `uzytkownicy` VALUES ('4', 'asdasd', 'asdasd', '\\\\\\\\\\', '56f86375011caf02ee4f59fcca277029a6b067a8', 'dasdasf@sad.sa', '123123123', '1', '12da', '12dsa', '1', '1699290669');
INSERT INTO `uzytkownicy` VALUES ('7', 'asdasd', 'dsada', 'aaaaa', '89ec388bc20e7373b2409836dc5576d3d558cd09', 'asdasd@daads.pl', '123123123', '1', 'sdaz', 'sadsa', '1', '1147810025');
INSERT INTO `uzytkownicy` VALUES ('11', 'dasdad', 'sadas', 'gfdfgdfg', '34352866d26f61a86b59f5e67fefe23595a92772', 'sasdadsa@asd.pl', '123123123', '2', 'dsaads', 'dsa', '1', '2029109264');

-- ----------------------------
-- Table structure for `zamowienia`
-- ----------------------------
DROP TABLE IF EXISTS `zamowienia`;
CREATE TABLE `zamowienia` (
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
  CONSTRAINT `idDostawcy` FOREIGN KEY (`idDostawcy`) REFERENCES `dostawcy` (`idDostawcy`),
  CONSTRAINT `idStatusuZamownienia` FOREIGN KEY (`idStatusuZamowienia`) REFERENCES `statusyzamowien` (`idStatusuZamowienia`),
  CONSTRAINT `idUzytkownika` FOREIGN KEY (`idUzytkownika`) REFERENCES `uzytkownicy` (`idUzytkownika`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of zamowienia
-- ----------------------------
INSERT INTO `zamowienia` VALUES ('1', '1', '2017-02-13 10:45:15', null, 'sdsd', '3', '3');
INSERT INTO `zamowienia` VALUES ('2', '3', '2017-02-13 09:33:24', null, '', '1', '3');
INSERT INTO `zamowienia` VALUES ('3', '3', null, null, null, null, null);
INSERT INTO `zamowienia` VALUES ('4', '2', '2017-02-13 10:01:21', null, '', '3', '1');
INSERT INTO `zamowienia` VALUES ('6', '1', '2017-02-13 15:56:38', null, '', '1', '3');
INSERT INTO `zamowienia` VALUES ('7', '2', '2017-02-13 19:30:41', null, '', '1', '3');
INSERT INTO `zamowienia` VALUES ('8', '1', '2017-02-13 20:37:50', null, '', '1', '3');
INSERT INTO `zamowienia` VALUES ('9', '1', null, null, null, null, null);

-- ----------------------------
-- Table structure for `zdjecia`
-- ----------------------------
DROP TABLE IF EXISTS `zdjecia`;
CREATE TABLE `zdjecia` (
  `idZdjecia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` mediumtext COLLATE utf8_polish_ci NOT NULL,
  `idProduktu` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idZdjecia`),
  KEY `fk_idProduktu` (`idProduktu`) USING BTREE,
  CONSTRAINT `idProduktu_fk` FOREIGN KEY (`idProduktu`) REFERENCES `produkty` (`idProduktu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- ----------------------------
-- Records of zdjecia
-- ----------------------------
INSERT INTO `zdjecia` VALUES ('1', 'products_images/m3.jpg', '3');
INSERT INTO `zdjecia` VALUES ('10', '', '2');
INSERT INTO `zdjecia` VALUES ('11', '', '4');
INSERT INTO `zdjecia` VALUES ('12', 'products_images/m1.JPG', '5');
INSERT INTO `zdjecia` VALUES ('13', 'products_images/m2.jpg', '6');
INSERT INTO `zdjecia` VALUES ('14', 'products_images/m3.jpg', '7');
INSERT INTO `zdjecia` VALUES ('15', 'products_images/m1.JPG', '8');
INSERT INTO `zdjecia` VALUES ('16', 'products_images/m2.jpg', '9');
INSERT INTO `zdjecia` VALUES ('17', 'products_images/m1.JPG', '10');
INSERT INTO `zdjecia` VALUES ('18', 'products_images/tablets.png', '11');
INSERT INTO `zdjecia` VALUES ('19', 'products_images/m1.JPG', '12');
INSERT INTO `zdjecia` VALUES ('20', 'products_images/m2.jpg', '13');
INSERT INTO `zdjecia` VALUES ('25', 'products_images/m2.jpg', '1');

-- ----------------------------
-- View structure for `front_page_view`
-- ----------------------------
DROP VIEW IF EXISTS `front_page_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `front_page_view` AS select `zdjecia`.`link` AS `link`,`produkty`.`nazwa` AS `nazwa`,`produkty`.`idProduktu` AS `idProduktu`,`produkty`.`ilosc` AS `ilosc`,`produkty`.`cena` AS `cena` from (`produkty` left join `zdjecia` on((`zdjecia`.`idProduktu` = `produkty`.`idProduktu`))) where (`produkty`.`ilosc` > 0) order by rand() limit 6 ;

-- ----------------------------
-- View structure for `v_order_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_order_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_order_info` AS select `z`.`idZamowienia` AS `Id_zamowienia`,concat(`m`.`nazwa`,' ',`u`.`nazwaUlicy`,' ',`u`.`numerDomu`) AS `Adres`,`u`.`login` AS `Login`,`z`.`dataZamowienia` AS `Data_zamowienia`,`d`.`nazwa` AS `Nazwa_dostawcy`,`d`.`cena` AS `Cena_dostawcy`,`sz`.`nazwaStatusuZamowienia` AS `Status_zamowienia`,(sum((`p`.`cena` * `pz`.`ilosc`)) + `d`.`cena`) AS `Kosz_całkowity` from ((((((`uzytkownicy` `u` join `miasta` `m` on((`m`.`idMiasta` = `u`.`idMiasta`))) join `zamowienia` `z` on((`z`.`idUzytkownika` = `u`.`idUzytkownika`))) join `dostawcy` `d` on((`d`.`idDostawcy` = `z`.`idDostawcy`))) join `statusyzamowien` `sz` on((`sz`.`idStatusuZamowienia` = `z`.`idStatusuZamowienia`))) join `produktyzamowienia` `pz` on((`pz`.`idZamowienia` = `z`.`idZamowienia`))) join `produkty` `p` on((`p`.`idProduktu` = `pz`.`idProduktu`))) where (`z`.`dataZamowienia` is not null) group by `z`.`idZamowienia`,concat(`m`.`nazwa`,' ',`u`.`nazwaUlicy`,' ',`u`.`numerDomu`),`u`.`login`,`z`.`dataZamowienia`,`d`.`nazwa`,`d`.`cena`,`sz`.`nazwaStatusuZamowienia` ;

-- ----------------------------
-- View structure for `v_product_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_product_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_product_info` AS select `p`.`nazwa` AS `Nazwa_produktu`,`p`.`ilosc` AS `Ilość`,`p`.`cena` AS `Cena_produktu`,`p`.`ocena` AS `Średnia_ocen`,`p`.`opis` AS `Opis`,`m`.`nazwa` AS `Marka`,`k`.`nazwa` AS `Kategoria` from ((`produkty` `p` join `marki` `m` on((`p`.`idMarki` = `m`.`idMarki`))) join `kategorie` `k` on((`k`.`idKategorii` = `p`.`idKategorii`))) ;

-- ----------------------------
-- View structure for `v_user_info`
-- ----------------------------
DROP VIEW IF EXISTS `v_user_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `v_user_info` AS select `u`.`idUzytkownika` AS `idUzytkownika`,`u`.`imie` AS `imie`,`u`.`nazwisko` AS `nazwisko`,`u`.`login` AS `login`,`u`.`haslo` AS `haslo`,`u`.`mail` AS `mail`,`u`.`telefon` AS `telefon`,`m`.`nazwa` AS `miasto`,`u`.`nazwaUlicy` AS `nazwaUlicy`,`u`.`numerDomu` AS `numerDomu`,`tk`.`typKonta` AS `typKonta` from ((`uzytkownicy` `u` join `miasta` `m` on((`m`.`idMiasta` = `u`.`idMiasta`))) join `typykont` `tk` on((`tk`.`idTypuKonta` = `u`.`idTypuKonta`))) ;

-- ----------------------------
-- Procedure structure for `change_pass`
-- ----------------------------
DROP PROCEDURE IF EXISTS `change_pass`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `change_pass`(IN `idUser` INT(10) UNSIGNED, IN `newPass` VARCHAR(42))
    SQL SECURITY INVOKER
BEGIN
	UPDATE Uzytkownicy SET haslo=newPass
	WHERE idUzytkownika=idUser;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `insert_delivery`
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_delivery`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_delivery`(IN `nazwa_d` varchar(50),IN `cena_d` decimal(5,2))
BEGIN
	declare exit handler for sqlstate '23000'
begin
	signal sqlstate '45000' set message_text="Taki dostawca już istnieje !", mysql_errno='1001';
end;

INSERT INTO Dostawcy (nazwa, cena) VALUES (nazwa_d,cena_d);

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `take_user_id`
-- ----------------------------
DROP PROCEDURE IF EXISTS `take_user_id`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `take_user_id`(IN `ids` VARCHAR(200))
    SQL SECURITY INVOKER
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
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_grade`(`u_id` INT(10) UNSIGNED, `rate_val` DECIMAL(3,1), `product_id` INT(10) UNSIGNED) RETURNS int(1)
    SQL SECURITY INVOKER
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
CREATE DEFINER=`root`@`localhost` FUNCTION `levenshtein`(`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
DECLARE s1_char CHAR;
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
CREATE DEFINER=`root`@`localhost` FUNCTION `update_grade`(`u_id` INT(10) UNSIGNED, `rate_val` DECIMAL(3,1), `product_id` INT(10) UNSIGNED) RETURNS int(1)
    SQL SECURITY INVOKER
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
CREATE DEFINER=`root`@`localhost` EVENT `ArchiwumClearEvent` ON SCHEDULE EVERY 1 WEEK STARTS '2016-10-24 14:00:15' ON COMPLETION PRESERVE ENABLE DO delete from ArchiwumUzytkownicy where datediff(now(),`data`)>730
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `BlokadyClearEvent`
-- ----------------------------
DROP EVENT IF EXISTS `BlokadyClearEvent`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `BlokadyClearEvent` ON SCHEDULE EVERY 60 SECOND STARTS '2016-12-29 16:29:20' ON COMPLETION PRESERVE ENABLE DO delete from Blokady where TIME_TO_SEC(TIMEDIFF(now(),`dataBlokady`))>=300
;;
DELIMITER ;

-- ----------------------------
-- Event structure for `HistoriaLogowanClearEvent`
-- ----------------------------
DROP EVENT IF EXISTS `HistoriaLogowanClearEvent`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `HistoriaLogowanClearEvent` ON SCHEDULE EVERY 1 WEEK STARTS '2016-12-29 16:53:53' ON COMPLETION PRESERVE ENABLE DO delete from HistoriaLogowan where datediff(now(),`dataZCzasem`)>365
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `loginTrigger`;
DELIMITER ;;
CREATE TRIGGER `loginTrigger` BEFORE INSERT ON `blokady` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then
set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `del_zam`;
DELIMITER ;;
CREATE TRIGGER `del_zam` AFTER DELETE ON `produktyzamowienia` FOR EACH ROW BEGIN
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
CREATE TRIGGER `ArchiwumUzytkownicy_Login_Insert` BEFORE INSERT ON `uzytkownicy` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then

set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Login_Update`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Login_Update` BEFORE UPDATE ON `uzytkownicy` FOR EACH ROW begin
if(lower(NEW.login)<>NEW.login) then
set NEW.login=lower(login);
end if;

end
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Update`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Update` AFTER UPDATE ON `uzytkownicy` FOR EACH ROW insert into
ArchiwumUzytkownicy(idUzytkownika,imie,nazwisko,login,haslo,mail,idMiasta,nazwaUlicy,numerDomu,idTypuKonta,akcja) 
values
(old.idUzytkownika,old.imie,old.nazwisko,old.login,old.haslo,old.mail,old.idMiasta,old.nazwaUlicy,
old.numerDomu,old.idTypuKonta,'u')
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `ArchiwumUzytkownicy_Delete`;
DELIMITER ;;
CREATE TRIGGER `ArchiwumUzytkownicy_Delete` AFTER DELETE ON `uzytkownicy` FOR EACH ROW insert into
ArchiwumUzytkownicy(idUzytkownika,imie,nazwisko,login,haslo,mail,idMiasta,nazwaUlicy,numerDomu,idTypuKonta,akcja) 
values
(old.idUzytkownika,old.imie,old.nazwisko,old.login,old.haslo,old.mail,old.idMiasta,old.nazwaUlicy,
old.numerDomu,old.idTypuKonta,'d')
;;
DELIMITER ;
