<?php


//// MySQL-Zugangsdaten

$dbserver = "localhost";   // Datenbank-Server
$dbuser = "";   // Benutzername (f�r die MySQL-Datenbank)
$dbpass = "";   // Passwort (f�r die MySQL-Datenbank)
$dbdata = "";   // Name der Datenbank
$dbx="hallofahrzeug";   // Tabellen-Prefix


//// Grundeinstellungen

$coredata['titel'] = "HalloFahrzeug.de";   // Titel der Webseite
$coredata['subtitel'] = "Privates Carsharing";   // Untertitel der Webseite
$coredata['email'] = "";   // E-Mail Adresse
$coredata['url'] = "www.hallofahrzeug.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")
$coredata['anfrageablauf'] = "12";   // Zeit in Stunden, innerhalb welcher eine Buchungsanfrage best�tigt werden muss

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
$coredata['paypalemail'] = "";   // PayPal-eMail-Adresse
$coredata['paypalsandbox'] = "on";   // F�r Testzwecke: PayPal-Betrieb in der Sandbox ("on" oder "off")


//// Sofort�berweisung.de

$coredata['sofortueberweisung'] = "ja";   // Zahlungen via Sofort�berweisung.de annehmen ("ja" oder "nein")
$coredata['sofortueberweisunguser'] = "";   // Sofort�berweisung.de User-ID
$coredata['sofortueberweisungprojekt'] = "";   // Sofort�berweisung.de Projekt-ID
$coredata['sofortueberweisungapikey'] = "";   // Sofort�berweisung.de API-Key



?>