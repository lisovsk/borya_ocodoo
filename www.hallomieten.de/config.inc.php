<?php


//// MySQL-Zugangsdaten

$dbserver = "localhost";   // Datenbank-Server
$dbuser = "";   // Benutzername (für die MySQL-Datenbank)
$dbpass = "";   // Passwort (für die MySQL-Datenbank)
$dbdata = "";   // Name der Datenbank
$dbx="hallomieten";   // Tabellen-Prefix


//// Grundeinstellungen

$coredata['titel'] = "HalloMieten.de";   // Titel der Webseite
$coredata['subtitel'] = "Ausleihen statt kaufen";   // Untertitel der Webseite
$coredata['email'] = "post@patrickbrunner.com";   // E-Mail Adresse
$coredata['url'] = "www.hallomieten.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")

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
$coredata['paypalemail'] = "paypal@patrickbrunner.com";   // PayPal-eMail-Adresse
$coredata['paypalsandbox'] = "on";   // Für Testzwecke: PayPal-Betrieb in der Sandbox ("on" oder "off")


//// Sofortüberweisung.de

$coredata['sofortueberweisung'] = "ja";   // Zahlungen via Sofortüberweisung.de annehmen ("ja" oder "nein")
$coredata['sofortueberweisunguser'] = "";   // Sofortüberweisung.de User-ID
$coredata['sofortueberweisungprojekt'] = "";   // Sofortüberweisung.de Projekt-ID
$coredata['sofortueberweisungapikey'] = "";   // Sofortüberweisung.de API-Key



?>