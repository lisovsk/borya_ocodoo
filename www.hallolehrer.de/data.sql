CREATE TABLE `hallolehrer_auszahlung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `hallolehrer_bewertungen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `als` varchar(10) NOT NULL,
  `kurs` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `bewerter` bigint(20) NOT NULL,
  `cont` varchar(250) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `bewertung` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `hallolehrer_kats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kat` varchar(30) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `cont` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

INSERT INTO `hallolehrer_kats` (`id`, `kat`, `icon`, `cont`) VALUES 
(1, 'Computer & Technik', 'kat_computer', 'Machen Sie den Computeralltag zum Sonntagsspaziergang.'),
(2, 'Handwerk & Kreativität', 'kat_kreativ', 'Alles rund ums Basteln, Heimwerken und Kreativsein.'),
(4, 'Sprachen', 'kat_sprachen', 'Eine neue Sprache lernen oder bestehende Kenntnisse vertiefen.'),
(5, 'Essen & Trinken', 'kat_essen', 'Wie braut man Bier? Und wie stellt man Frühlingsrollen her?'),
(6, 'Gesundheit & Beauty', 'kat_beauty', 'Gesundheit positiv beeinflussen. Typgerecht schminken und stylen.'),
(7, 'Sport & Bewegung', 'kat_sport', 'Sport ist Mord? Jetzt Spass bekommen und fit bleiben.'),
(8, 'Musik & Tanz', 'kat_musik', 'Möchten Sie ein Instrument lernen oder einen Tanzkurs besuchen?'),
(9, 'Business & Finanzen', 'kat_business', 'Firma gründen, selbständig werden und Finanzen im Griff behalten.'),
(10, 'Schulfächer', 'kat_schule', 'Schwierigkeiten in der Schule oder im Studium? Hier gibt es Nachhilfe.');

CREATE TABLE `hallolehrer_konto` (
  `payprovider` varchar(50) NOT NULL,
  `payid` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `buchung` varchar(50) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `kurs` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE `hallolehrer_kurse` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `kat` bigint(20) NOT NULL,
  `titel` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cont` text COLLATE utf8_unicode_ci NOT NULL,
  `kosten` bigint(20) NOT NULL,
  `standort` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `plz` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `ort` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `land` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `datum` bigint(20) NOT NULL,
  `dauer` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `kurstag1_von` bigint(20) NOT NULL,
  `kurstag1_bis` bigint(20) NOT NULL,
  `kurstag2_von` bigint(20) NOT NULL,
  `kurstag2_bis` bigint(20) NOT NULL,
  `kurstag3_von` bigint(20) NOT NULL,
  `kurstag3_bis` bigint(20) NOT NULL,
  `kurstag4_von` bigint(20) NOT NULL,
  `kurstag4_bis` bigint(20) NOT NULL,
  `kurstag5_von` bigint(20) NOT NULL,
  `kurstag5_bis` bigint(20) NOT NULL,
  `level` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `teilnehmer` bigint(20) NOT NULL,
  `teilnehmer_ab` int(11) NOT NULL,
  `teilnehmer_bis` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `hallolehrer_nachrichten` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `empf` bigint(20) NOT NULL,
  `abs` bigint(20) NOT NULL,
  `betr` varchar(50) NOT NULL,
  `cont` mediumtext NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `delempf` varchar(2) NOT NULL,
  `delabs` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE `hallolehrer_teilnehmer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurs` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `datum` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `hallolehrer_user` (
  `user` varchar(25) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pass` varchar(20) NOT NULL,
  `firma` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `plz` int(5) NOT NULL,
  `ort` varchar(50) NOT NULL,
  `land` varchar(2) NOT NULL,
  `email` varchar(50) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `geschlecht` varchar(1) NOT NULL,
  `online` bigint(20) NOT NULL,
  `ueber` mediumtext NOT NULL,
  `rechte` varchar(3) NOT NULL,
  `verifizierung` varchar(3) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `newsletter` varchar(10) NOT NULL,
  `guthaben` float NOT NULL,
  `flatrate` bigint(20) NOT NULL,
  `auszahlungsart` varchar(25) NOT NULL,
  `paypal` varchar(50) NOT NULL,
  `bank_blz` varchar(50) NOT NULL,
  `bank_inhaber` varchar(50) NOT NULL,
  `bank_konto` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bewertung` float NOT NULL,
  `anz_bewertungen` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE `hallolehrer_user_facebook` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) NOT NULL DEFAULT '0',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;