CREATE TABLE `hallofahrzeug_auszahlung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallofahrzeug_bewertungen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `als` varchar(10) NOT NULL,
  `fahrzeug` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `bewerter` bigint(20) NOT NULL,
  `cont` varchar(250) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `bewertung` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallofahrzeug_data_art` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `art` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `hallofahrzeug_data_art` (`id`, `art`) VALUES 
(1, 'Kleinwagen'),
(2, 'Cabrio'),
(3, 'Kombi'),
(4, 'Transporter'),
(5, 'Wohnmobil'),
(6, 'Anhänger'),
(7, 'Motorrad');

CREATE TABLE `hallofahrzeug_konto` (
  `payprovider` varchar(50) NOT NULL,
  `payid` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `buchung` varchar(50) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `fahrzeug` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallofahrzeug_mieten` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fahrzeug` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `vermieter` bigint(20) NOT NULL,
  `von` bigint(20) NOT NULL,
  `bis` bigint(20) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `art` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallofahrzeug_nachrichten` (
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

CREATE TABLE `hallofahrzeug_fahrzeug` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `art` int(11) NOT NULL,
  `strasse` varchar(35) NOT NULL,
  `plz` varchar(5) NOT NULL,
  `ort` varchar(25) NOT NULL,
  `land` varchar(2) NOT NULL,
  `preis_tag` float NOT NULL,
  `marke` varchar(25) NOT NULL,
  `modell` varchar(25) NOT NULL,
  `tueren` int(11) NOT NULL,
  `sitze` int(11) NOT NULL,
  `kmstand` varchar(15) NOT NULL,
  `jahrgang` int(11) NOT NULL,
  `getriebe` varchar(15) NOT NULL,
  `cont` text NOT NULL,
  `regeln` text NOT NULL,
  `inklkm` float NOT NULL,
  `zusatzkm` float NOT NULL,
  `status` varchar(3) NOT NULL,
  `datum` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallofahrzeug_user` (
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

CREATE TABLE `hallofahrzeug_user_facebook` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) NOT NULL DEFAULT '0',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);