<?php


//// MySQL-Zugangsdaten

// $dbserver = "localhost";   // Datenbank-Server
// $dbuser = "";   // Benutzername (für die MySQL-Datenbank)
// $dbpass = "";   // Passwort (für die MySQL-Datenbank)
// $dbdata = "";   // Name der Datenbank
// $dbx="hallounterkunft";   // Tabellen-Prefix

$dbserver = "127.0.0.1:3306";   // Datenbank-Server
$dbuser = "mysql";   // Benutzername (für die MySQL-Datenbank)
$dbpass = "mysql";   // Passwort (für die MySQL-Datenbank)
$dbdata = "hallounterkunft2";   // Name der Datenbank
$dbx="hallounterkunft";   // Tabellen-Prefix (im Normalfall nicht ändern)


//// Grundeinstellungen

$coredata['titel'] = "HalloUnterkunft.de";   // Titel der Webseite
$coredata['subtitel'] = "Private Unterkünfte";   // Untertitel der Webseite
$coredata['email'] = "";   // E-Mail Adresse
$coredata['url'] = "borya-ocodoo/www.hallounterkunft.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")
$coredata['anfrageablauf'] = "12";   // Zeit in Stunden, innerhalb welcher eine Buchungsanfrage bestätigt werden muss

//// Facebook App (Erstellen unter https://developers.facebook.com/apps)

$coredata['facebookappid'] = "";   // Facebook App-ID
$coredata['facebooksecretkey'] = "";   // Facebook App-Gehemincode


//// Zahlungseinstellungen

$coredata['waehrung'] = "EUR";   // Dreistelliger Währungcode nach ISO 4217 (z.B. EUR, CHF oder USD)
$coredata['gebuehr'] = "15";   // Gebühr in Prozent, welche dem Vermieter berechnet wird
$coredata['minbetrag'] = "10";   // Mindestbetrag für eine Kontoaufladung
$coredata['maxbetrag'] = "1000";   // Maximalbetrag für eine Kontoaufladung
$coredata['betragschritte'] = "10";   // Schritte zwischen den auswählbaren Beträgen
$coredata['minauszahlung'] = "20";   // Mindestbetrag für eine Auszahlung


//// PayPal

$coredata['paypal'] = "ja";   // Zahlungen via PayPal annehmen ("ja" oder "nein")
$coredata['paypalemail'] = "";   // PayPal-eMail-Adresse
$coredata['paypalsandbox'] = "on";   // Für Testzwecke: PayPal-Betrieb in der Sandbox ("on" oder "off")


//// Sofortüberweisung.de

$coredata['sofortueberweisung'] = "ja";   // Zahlungen via Sofortüberweisung.de annehmen ("ja" oder "nein")
$coredata['sofortueberweisunguser'] = "";   // Sofortüberweisung.de User-ID
$coredata['sofortueberweisungprojekt'] = "";   // Sofortüberweisung.de Projekt-ID
$coredata['sofortueberweisungapikey'] = "";   // Sofortüberweisung.de API-Key



?>