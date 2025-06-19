/*
Created: 08/05/2025
Modified: 12/06/2025
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table Uporabnik

CREATE TABLE `Uporabnik`
(
  `id_uporabnik` Int NOT NULL AUTO_INCREMENT,
  `ime` Varchar(20) NOT NULL,
  `priimek` Varchar(30) NOT NULL,
  `email` Varchar(60) NOT NULL,
  `geslo` Char(200) NOT NULL,
  `telefon` Varbinary(20) NOT NULL,
  `datum_reg` Datetime NOT NULL,
  `id_obvestila` Int,
  PRIMARY KEY (`id_uporabnik`)
)
;

CREATE INDEX `IX_Relationship19` ON `Uporabnik` (`id_obvestila`)
;

-- Table Vozila

CREATE TABLE `Vozila`
(
  `id_vozila` Int NOT NULL AUTO_INCREMENT,
  `znamka` Char(20) NOT NULL,
  `model` Varchar(20) NOT NULL,
  `registracija` Varchar(20) NOT NULL,
  `st_sedezev` Int NOT NULL,
  `barva` Varchar(20),
  PRIMARY KEY (`id_vozila`)
)
;

-- Table Prevoz

CREATE TABLE `Prevoz`
(
  `id_prevoz` Int NOT NULL AUTO_INCREMENT,
  `zacetek` Varchar(100) NOT NULL,
  `cilj` Varchar(100) NOT NULL,
  `datum` Date NOT NULL,
  `ura` Time(0) NOT NULL,
  `cena` Decimal(10,0) NOT NULL,
  `opis` Text,
  `id_vozila` Int,
  `id_voznik` Int,
  PRIMARY KEY (`id_prevoz`)
)
;

CREATE INDEX `IX_Relationship18` ON `Prevoz` (`id_vozila`)
;

CREATE INDEX `IX_Relationship22` ON `Prevoz` (`id_voznik`)
;

-- Table Rezervacija

CREATE TABLE `Rezervacija`
(
  `id_rezervacija` Int NOT NULL AUTO_INCREMENT,
  `datum` Datetime(0) NOT NULL,
  `status` Int NOT NULL,
  `id_uporabnik` Int,
  `id_prevoz` Int,
  `id_placila` Int,
  PRIMARY KEY (`id_rezervacija`)
)
;

CREATE INDEX `IX_Relationship10` ON `Rezervacija` (`id_uporabnik`)
;

CREATE INDEX `IX_Relationship13` ON `Rezervacija` (`id_prevoz`)
;

CREATE INDEX `IX_Relationship15` ON `Rezervacija` (`id_placila`)
;

-- Table Placila

CREATE TABLE `Placila`
(
  `id_placila` Int NOT NULL AUTO_INCREMENT,
  `znesek` Int NOT NULL,
  `status` Int NOT NULL,
  `dat_placila` Datetime NOT NULL,
  `nacin_placila` Int NOT NULL,
  PRIMARY KEY (`id_placila`)
)
;


-- Table Ocene Voznika

CREATE TABLE `Ocene Voznika`
(
  `id_ocena` Int NOT NULL AUTO_INCREMENT,
  `ocena` Int(5),
  `komentar` Text,
  `dat_ocene` Datetime,
  `id_uporabnik` Int,
  `id_voznik` Int,
  PRIMARY KEY (`id_ocena`)
)
;

CREATE INDEX `IX_Relationship11` ON `Ocene Voznika` (`id_uporabnik`)
;

CREATE INDEX `IX_Relationship12` ON `Ocene Voznika` (`id_voznik`)
;

-- Table Obvestila

CREATE TABLE `Obvestila`
(
  `id_obvestila` Int NOT NULL AUTO_INCREMENT,
  `vsebina` Text,
  `dat_objave` Datetime NOT NULL,
  PRIMARY KEY (`id_obvestila`)
)
;

-- Table Voznik

CREATE TABLE `Voznik`
(
  `id_voznik` Int NOT NULL AUTO_INCREMENT,
  `ime` Char(20) NOT NULL,
  `priimek` Char(20) NOT NULL,
  `telefon` Char(20) NOT NULL,
  `email` Char(20) NOT NULL,
  `opis` Char(20),
  PRIMARY KEY (`id_voznik`)
)
;


-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `Rezervacija` ADD CONSTRAINT `Relationship10` FOREIGN KEY (`id_uporabnik`) REFERENCES `Uporabnik` (`id_uporabnik`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Ocene Voznika` ADD CONSTRAINT `Relationship11` FOREIGN KEY (`id_uporabnik`) REFERENCES `Uporabnik` (`id_uporabnik`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Ocene Voznika` ADD CONSTRAINT `Relationship12` FOREIGN KEY (`id_voznik`) REFERENCES `Voznik` (`id_voznik`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Rezervacija` ADD CONSTRAINT `Relationship13` FOREIGN KEY (`id_prevoz`) REFERENCES `Prevoz` (`id_prevoz`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Rezervacija` ADD CONSTRAINT `Relationship15` FOREIGN KEY (`id_placila`) REFERENCES `Placila` (`id_placila`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Prevoz` ADD CONSTRAINT `Relationship18` FOREIGN KEY (`id_vozila`) REFERENCES `Vozila` (`id_vozila`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Uporabnik` ADD CONSTRAINT `Relationship19` FOREIGN KEY (`id_obvestila`) REFERENCES `Obvestila` (`id_obvestila`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Prevoz` ADD CONSTRAINT `Relationship22` FOREIGN KEY (`id_voznik`) REFERENCES `Voznik` (`id_voznik`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

