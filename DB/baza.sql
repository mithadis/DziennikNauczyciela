-- Definicje tabel
DROP DATABASE IF EXISTS dn;
CREATE DATABASE dn;
USE dn;

CREATE TABLE `opiekunowie` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `login` VARCHAR(24) NOT NULL,
  `haslo` VARCHAR(32) NOT NULL,
  `nazwisko` VARCHAR(24) NOT NULL,
  `imie` VARCHAR(24) NOT NULL,
  `email` VARCHAR(100),
  `telefon` VARCHAR(24),
  PRIMARY KEY (`id`),
  UNIQUE KEY `opiekunowie_login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nauczyciele` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `login` VARCHAR(24) NOT NULL,
  `haslo` VARCHAR(32) NOT NULL,
  `nazwisko` VARCHAR(24) NOT NULL,
  `imie` VARCHAR(24) NOT NULL,
  `email` VARCHAR(100),
  `telefon` VARCHAR(24),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nauczyciele_login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `uczniowie` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `nazwisko` VARCHAR(24) NOT NULL,
  imie VARCHAR(24) NOT NULL,
  `data_ur` DATE NOT NULL,
  `dod_info` TINYTEXT,
  `id_klasy` INT UNSIGNED,
  `id_opiekuna` INT UNSIGNED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `uwagi` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `tytul` ENUM('pochwala', 'nagana', 'inne') NOT NULL,
  `komentarz` VARCHAR(100) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL,
  `id_nauczyciela` INT UNSIGNED,
  `id_ucznia` INT UNSIGNED NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `klasy` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `rok` TINYINT NOT NULL,
  `grupa` CHAR(1) NOT NULL,
  `id_wychowawcy` INT UNSIGNED,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `obecnosci` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `status` ENUM('obecny', 'spozniony', 'nieobecny') NOT NULL,
  `uspr` BOOL NOT NULL,
  `data` DATE NOT NULL,
  `id_godziny` INT UNSIGNED NOT NULL,
  `id_ucznia` INT UNSIGNED NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zastepstwa` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `data` DATE NOT NULL,
  `id_godziny` INT UNSIGNED NOT NULL,
  `id_nauczyciela` INT UNSIGNED NOT NULL,
  `id_klasy` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `kursy` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `przedmiot` VARCHAR(24) NOT NULL,
  `obowiazkowy` BOOL NOT NULL,
  `id_przedmiotu` INT UNSIGNED NOT NULL,
  `id_nauczyciela` INT UNSIGNED,
  `id_klasy` INT UNSIGNED NOT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `oceny` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `ocena` TINYINT NOT NULL,
  `waga` TINYINT NOT NULL DEFAULT 1,
  `timestamp` TIMESTAMP NOT NULL,
  `id_kursu` INT UNSIGNED NOT NULL,
  `id_ucznia` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `terminy` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `dzien_tyg` TINYINT NOT NULL,
  `miejsce` VARCHAR(16),
  `id_godziny` INT UNSIGNED NOT NULL,
  `id_kursu` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `godziny` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `godzina` TINYINT NOT NULL,
  `od` TIME NOT NULL,
  `do` TIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `godziny_godzina` (`godzina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- klucze obce dla tabel


ALTER TABLE `uczniowie`
  ADD CONSTRAINT `uczniowie_klasa` FOREIGN KEY `fk_uczniowie_klasa` (`id_klasy`) REFERENCES `klasy` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `uczniowie_opiekun` FOREIGN KEY `fk_uczniowie_opiekun` (`id_opiekuna`) REFERENCES `opiekunowie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `uwagi`
  ADD CONSTRAINT `uwagi_uczen` FOREIGN KEY `fk_uwagi_uczen` (`id_ucznia`) REFERENCES `uczniowie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `uwagi_nauczyciel` FOREIGN KEY `fk_uwagi_nauczyciel` (`id_nauczyciela`) REFERENCES `nauczyciele` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
  
ALTER TABLE `klasy`
  ADD CONSTRAINT `klasy_nauczyciel` FOREIGN KEY `fk_klasy_nauczyciel` (`id_wychowawcy`) REFERENCES `nauczyciele` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `obecnosci`
  ADD CONSTRAINT `obecnosci_godzina` FOREIGN KEY `fk_obecnosci_godzina` (`id_godziny`) REFERENCES `godziny` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `obecnosci_uczen` FOREIGN KEY `fk_obecnosci_uczen` (`id_ucznia`) REFERENCES `uczniowie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `zastepstwa`
  ADD CONSTRAINT `zastepstwa_godzina` FOREIGN KEY `fk_zastepstwa_godzina` (`id_godziny`) REFERENCES `godziny` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `zastepstwa_nauczyciel` FOREIGN KEY `fk_zastepstwa_nauczyciel` (`id_nauczyciela`) REFERENCES `nauczyciele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zastepstwa_klasa` FOREIGN KEY `fk_zastepstwa_klasa` (`id_klasy`) REFERENCES `klasy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `kursy` 
  ADD CONSTRAINT `kursy_nauczyciel` FOREIGN KEY `fk_kursy_nauczyciel` (`id_nauczyciela`) REFERENCES `nauczyciele` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `kursy_klasa` FOREIGN KEY `fk_kursy_klasa` (`id_klasy`) REFERENCES `klasy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `oceny`
  ADD CONSTRAINT `oceny_kurs` FOREIGN KEY `fk_oceny_kurs` (`id_kursu`) REFERENCES `kursy` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `oceny_uczen` FOREIGN KEY `fk_oceny_uczen` (`id_ucznia`) REFERENCES `uczniowie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `terminy`
  ADD CONSTRAINT `terminy_kurs` FOREIGN KEY `fk_terminy_kurs` (`id_kursu`) REFERENCES `kursy` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `terminy_godzina` FOREIGN KEY `fk_terminy_godzina` (`id_godziny`) REFERENCES `godziny` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
