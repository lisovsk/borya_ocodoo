CREATE TABLE `halloauftrag_angebote` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `auftrag` bigint(20) NOT NULL,
 `user` bigint(20) NOT NULL,
 `cont` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
 `betrag` bigint(20) NOT NULL,
 `datum` bigint(20) NOT NULL,
 `gewaehlt` int(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `halloauftrag_auftraege` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `user` bigint(20) NOT NULL,
 `titel` varchar(50) NOT NULL,
 `kat` int(11) NOT NULL,
 `plz` varchar(5) NOT NULL,
 `ort` varchar(25) NOT NULL,
 `land` varchar(2) NOT NULL,
 `cont` mediumtext NOT NULL,
 `status` varchar(3) NOT NULL,
 `datum` bigint(20) NOT NULL,
 `datum_ende` bigint(20) NOT NULL,
 `angebot` bigint(20) NOT NULL,
 `anbieter` bigint(20) NOT NULL,
 `endmail` int(1) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE `halloauftrag_auszahlung` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `user` bigint(20) NOT NULL,
 `betrag` float NOT NULL,
 `datum` bigint(20) NOT NULL,
 `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `halloauftrag_bewertungen` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `als` varchar(10) NOT NULL,
 `auftrag` bigint(20) NOT NULL,
 `user` bigint(20) NOT NULL,
 `bewerter` bigint(20) NOT NULL,
 `cont` varchar(250) NOT NULL,
 `datum` bigint(20) NOT NULL,
 `status` varchar(2) NOT NULL,
 `bewertung` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `halloauftrag_kats` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `kat` varchar(30) NOT NULL,
 `subof` bigint(20) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `halloauftrag_kats` (`id`, `kat`, `subof`) VALUES 
(1, 'Maler und Gipser', 0),
(2, 'Garten und Landschaft', 0),
(3, 'Abbruch und Entsorgung', 0),
(4, 'Dacharbeiten', 0),
(5, 'Boden und Fliesen', 0),
(6, 'Fenster, Türen und Glas', 0),
(7, 'Maurer, Beton, Fugen', 0),
(8, 'Elektrik', 0),
(9, 'Heizung, Klima und Sanitär', 0),
(10, 'Events und Gastronomie', 0),
(11, 'Metallbau und -verarbeitung', 0),
(12, 'Umzug und Transport', 0),
(13, 'Reinigung und Gebäudeservice', 0),
(14, 'Design und Druck', 0),
(15, 'Planung und Beratung', 0),
(16, 'Innenausbau, Schreiner', 0),
(17, 'Internet, Netzwerke, Telefon', 0),
(18, 'Fahrzeugreparatur und -service', 0),
(19, 'Schädlingsbekämpfung', 0);


CREATE TABLE `halloauftrag_konto` (
`payprovider` varchar(50) NOT NULL,
 `payid` varchar(50) NOT NULL,
 `status` varchar(10) NOT NULL,
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `user` bigint(20) NOT NULL,
 `buchung` varchar(50) NOT NULL,
 `betrag` float NOT NULL,
 `datum` bigint(20) NOT NULL,
 `auftrag` bigint(20) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `halloauftrag_nachrichten` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `halloauftrag_user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `halloauftrag_user_facebook` (
`id` bigint(20) NOT NULL AUTO_INCREMENT,
 `facebook_id` bigint(20) NOT NULL DEFAULT '0',
 `userid` bigint(20) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

