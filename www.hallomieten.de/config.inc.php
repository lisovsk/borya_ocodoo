<?php


//// MySQL-Zugangsdaten

// $dbserver = "localhost";   // Datenbank-Server
// $dbuser = "";   // Benutzername (f�r die MySQL-Datenbank)
// $dbpass = "";   // Passwort (f�r die MySQL-Datenbank)
// $dbdata = "";   // Name der Datenbank
// $dbx="hallomieten";   // Tabellen-Prefix

$dbserver = "127.0.0.1:3306";   // Datenbank-Server
$dbuser = "mysql";   // Benutzername (f�r die MySQL-Datenbank)
$dbpass = "mysql";   // Passwort (f�r die MySQL-Datenbank)
$dbdata = "hallomieten";   // Name der Datenbank
$dbx="hallogegenstand";   // Tabellen-Prefix (im Normalfall nicht �ndern)


//// Grundeinstellungen

$coredata['titel'] = "HalloMieten.de";   // Titel der Webseite
$coredata['subtitel'] = "Ausleihen statt kaufen";   // Untertitel der Webseite
$coredata['email'] = "post@patrickbrunner.com";   // E-Mail Adresse
$coredata['url'] = "borya-ocodoo/www.hallomieten.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")

//// Facebook App (Erstellen unter https://developers.facebook.com/apps)

$coredata['facebookappid'] = "";   // Facebook App-ID
$coredata['facebooksecretkey'] = "";   // Facebook App-Gehemincode


//// Zahlungseinstellungen

$coredata['waehrung'] = "EUR";   // Dreistelliger W�hrungcode nach ISO 4217 (z.B. EUR, CHF oder USD)
$coredata['gebuehr'] = "15";   // Geb�hr in Prozent, welche dem Vermieter berechnet wird
$coredata['minbetrag'] = "10";   // Mindestbetrag f�r eine Kontoaufladung
$coredata['maxbetrag'] = "1000";   // Maximalbetrag f�r eine Kontoaufladung
$coredata['betragschritte'] = "10";   // Schritte zwischen den ausw�hlbaren Betr�gen
$coredata['minauszahlung'] = "20";   // Mindestbetrag f�r eine Auszahlung


//// PayPal

$coredata['paypal'] = "ja";   // Zahlungen via PayPal annehmen ("ja" oder "nein")
$coredata['paypalemail'] = "paypal@patrickbrunner.com";   // PayPal-eMail-Adresse
$coredata['paypalsandbox'] = "on";   // F�r Testzwecke: PayPal-Betrieb in der Sandbox ("on" oder "off")


//// Sofort�berweisung.de

$coredata['sofortueberweisung'] = "ja";   // Zahlungen via Sofort�berweisung.de annehmen ("ja" oder "nein")
$coredata['sofortueberweisunguser'] = "";   // Sofort�berweisung.de User-ID
$coredata['sofortueberweisungprojekt'] = "";   // Sofort�berweisung.de Projekt-ID
$coredata['sofortueberweisungapikey'] = "";   // Sofort�berweisung.de API-Key



?>