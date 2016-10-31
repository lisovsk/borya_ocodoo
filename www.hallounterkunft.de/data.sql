CREATE TABLE `hallounterkunft_auszahlung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_bewertungen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `als` varchar(10) NOT NULL,
  `unterkunft` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `bewerter` bigint(20) NOT NULL,
  `cont` varchar(250) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `bewertung` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_data_art` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `art` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `hallounterkunft_data_art` (`id`, `art`) VALUES 
(1, 'Gemeinschaftszimmer'),
(2, 'Privatzimmer'),
(3, 'Wohnung'),
(4, 'Haus / Villa'),
(5, 'Wohnwagen'),
(6, 'Camping hinterm Haus'),
(7, 'Scheune');

CREATE TABLE `hallounterkunft_data_ausstattung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ausstattung` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `hallounterkunft_data_ausstattung` (`id`, `ausstattung`) VALUES 
(1, 'WLAN'),
(2, 'Internet'),
(3, 'Geschirrspüler'),
(4, 'Telefon'),
(5, 'Waschmaschine'),
(6, 'Klimaanlage'),
(7, 'Küche'),
(8, 'Dusche/Badewanne'),
(9, 'Whirlpool'),
(10, 'Schwimmbad'),
(11, 'Kinderfreundlich'),
(12, 'Babybett'),
(13, 'Parkplatz'),
(14, 'Aufzug'),
(15, 'Garten'),
(16, 'Balkon/Terasse'),
(17, 'Barrierefrei'),
(18, 'Rauchen erlaubt'),
(19, 'Haustiere erlaubt'),
(20, 'Kühlschrank'),
(21, 'Heizung'),
(22, 'Frühstück'),
(23, 'Kamin'),
(24, 'Panoramablick');

CREATE TABLE `hallounterkunft_konto` (
  `payprovider` varchar(50) NOT NULL,
  `payid` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `buchung` varchar(50) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `unterkunft` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_mieten` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unterkunft` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `gastgeber` bigint(20) NOT NULL,
  `von` bigint(20) NOT NULL,
  `bis` bigint(20) NOT NULL,
  `anzgaeste` int(11) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `art` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_nachrichten` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `empf` bigint(20) NOT NULL,
  `abs` bigint(20) NOT NULL,
  `betr` varchar(50) NOT NULL,
  `cont` text NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `delempf` varchar(2) NOT NULL,
  `delabs` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_unterkunft` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `art` int(11) NOT NULL,
  `strasse` varchar(35) NOT NULL,
  `plz` varchar(5) NOT NULL,
  `ort` varchar(25) NOT NULL,
  `land` varchar(2) NOT NULL,
  `preis_nacht` float NOT NULL,
  `anz_schlafzimmer` int(11) NOT NULL,
  `anz_badezimmer` int(11) NOT NULL,
  `art_badezimmer` varchar(10) NOT NULL,
  `max_gaeste` int(11) NOT NULL,
  `groesse` float NOT NULL,
  `cont` text NOT NULL,
  `regeln` text NOT NULL,
  `ausstattung` text NOT NULL,
  `status` varchar(3) NOT NULL,
  `datum` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_user` (
  `user` varchar(25) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pass` varchar(20) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `plz` varchar(5) NOT NULL,
  `ort` varchar(50) NOT NULL,
  `land` varchar(2) NOT NULL,
  `email` varchar(50) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `geschlecht` varchar(1) NOT NULL,
  `online` bigint(20) NOT NULL,
  `ueber` text NOT NULL,
  `rechte` varchar(3) NOT NULL,
  `verifizierung` varchar(3) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `newsletter` varchar(10) NOT NULL,
  `guthaben` float NOT NULL,
  `auszahlungsart` varchar(25) NOT NULL,
  `paypal` varchar(50) NOT NULL,
  `bank_blz` varchar(50) NOT NULL,
  `bank_inhaber` varchar(50) NOT NULL,
  `bank_konto` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bewertung` float NOT NULL,
  `anz_bewertungen` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallounterkunft_user_facebook` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) NOT NULL DEFAULT '0',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);