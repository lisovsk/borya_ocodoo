CREATE TABLE `hallogegenstand_auszahlung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_bewertungen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `als` varchar(10) NOT NULL,
  `gegenstand` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `bewerter` bigint(20) NOT NULL,
  `cont` varchar(250) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `status` varchar(2) NOT NULL,
  `bewertung` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_konto` (
  `payprovider` varchar(50) NOT NULL,
  `payid` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `buchung` varchar(50) NOT NULL,
  `betrag` float NOT NULL,
  `datum` bigint(20) NOT NULL,
  `gegenstand` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_mieten` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gegenstand` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `vermieter` bigint(20) NOT NULL,
  `von` bigint(20) NOT NULL,
  `bis` bigint(20) NOT NULL,
  `datum` bigint(20) NOT NULL,
  `art` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_nachrichten` (
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

CREATE TABLE `hallogegenstand_gegenstand` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `kat` int(11) NOT NULL,
  `mindauer` int(11) NOT NULL,
  `strasse` varchar(35) NOT NULL,
  `plz` varchar(5) NOT NULL,
  `ort` varchar(25) NOT NULL,
  `land` varchar(2) NOT NULL,
  `preis_tag` float NOT NULL,
  `kaution` float NOT NULL,
  `cont` text NOT NULL,
  `status` varchar(3) NOT NULL,
  `datum` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_user` (
  `user` varchar(25) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pass` varchar(20) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `plz` int(5) NOT NULL,
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

CREATE TABLE `hallogegenstand_user_facebook` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) NOT NULL DEFAULT '0',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `hallogegenstand_kats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kat` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `subof` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `hallogegenstand_kats` (`id`, `kat`, `subof`) VALUES 
(1, 'Auto & Motorrad', 0),
(2, 'Sport & Freizeit', 0),
(3, 'Mode & Kostüme', 0),
(4, 'Party, Messe & Events', 0),
(5, 'Küche & Haushalt', 0),
(6, 'Foto & Video', 0),
(7, 'Heimwerken', 0),
(8, 'Computer & Elektronik', 0),
(9, 'Räume & Locations', 0),
(10, 'Garten & Baustelle', 0);