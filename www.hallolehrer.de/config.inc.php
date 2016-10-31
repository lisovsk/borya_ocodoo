<?php


//// MySQL-Zugangsdaten

// $dbserver = "localhost";   // Datenbank-Server
// $dbuser = "";   // Benutzername (für die MySQL-Datenbank)
// $dbpass = "";   // Passwort (für die MySQL-Datenbank)
// $dbdata = "";   // Name der Datenbank
// $dbx="hallolehrer";   // Tabellen-Prefix (im Normalfall nicht ändern)

$dbserver = "127.0.0.1:3306";   // Datenbank-Server
$dbuser = "mysql";   // Benutzername (für die MySQL-Datenbank)
$dbpass = "mysql";   // Passwort (für die MySQL-Datenbank)
$dbdata = "hallolehrer";   // Name der Datenbank
$dbx="hallolehrer";   // Tabellen-Prefix (im Normalfall nicht ändern)


//// Grundeinstellungen

$coredata['titel'] = "HalloLehrer";   // Titel der Webseite
$coredata['subtitel'] = "Marktplatz für Lernkurse";   // Untertitel der Webseite
$coredata['email'] = "post@patrickbrunner.com";   // E-Mail Adresse
$coredata['url'] = "borya-ocodoo/www.hallolehrer.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")

//// Facebook App (Erstellen unter https://developers.facebook.com/apps)

$coredata['facebookappid'] = "";   // Facebook App-ID
$coredata['facebooksecretkey'] = "";   // Facebook App-Gehemincode


//// Zahlungseinstellungen

$coredata['waehrung'] = "EUR";   // Dreistelliger Währungcode nach ISO 4217 (z.B. EUR, CHF oder USD)
$coredata['gebuehr'] = "15";   // Gebühr in Prozent, welche den Kurskosten abgezogen werden
$coredata['minbetrag'] = "10";   // Mindestbetrag für eine Kontoaufladung
$coredata['maxbetrag'] = "1000";   // Maximalbetrag für eine Kontoaufladung
$coredata['betragschritte'] = "10";   // Schritte zwischen den auswählbaren Beträgen
$coredata['minauszahlung'] = "20";   // Mindestbetrag für eine Auszahlung


//// PayPal

$coredata['paypal'] = "ja";   // Zahlungen via PayPal annehmen ("ja" oder "nein")
$coredata['paypalemail'] = "paypal@patrickbrunner.com";   // PayPal-eMail-Adresse
$coredata['paypalsandbox'] = "off";   // Für Testzwecke: PayPal-Betrieb in der Sandbox ("on" oder "off")


//// Sofortüberweisung.de

$coredata['sofortueberweisung'] = "ja";   // Zahlungen via Sofortüberweisung.de annehmen ("ja" oder "nein")
$coredata['sofortueberweisunguser'] = "";   // Sofortüberweisung.de User-ID
$coredata['sofortueberweisungprojekt'] = "";   // Sofortüberweisung.de Projekt-ID
$coredata['sofortueberweisungapikey'] = "";   // Sofortüberweisung.de API-Key



?>