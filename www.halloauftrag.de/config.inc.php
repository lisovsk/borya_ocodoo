<?php


//// MySQL-Zugangsdaten

$dbserver = "127.0.0.1:3306";   // Datenbank-Server
$dbuser = "mysql";   // Benutzername (für die MySQL-Datenbank)
$dbpass = "mysql";   // Passwort (für die MySQL-Datenbank)
$dbdata = "halloauftrag";   // Name der Datenbank
$dbx="halloauftrag";   // Tabellen-Prefix (im Normalfall nicht ändern)


//// Grundeinstellungen

$coredata['titel'] = "HalloAuftrag";   // Titel der Webseite
$coredata['subtitel'] = "Gute Arbeit. Guter Preis.";   // Untertitel der Webseite
$coredata['email'] = "";   // E-Mail Adresse
$coredata['url'] = "www.halloauftrag.de";   // URL zur Webseite (wichtig: kein "/" am Schluss und ohne "http://")
$coredata['modrw'] = "ja";   // Suchmaschinenoptimierte URLs
$coredata['user'] = "user";   // Benutzername ("user") oder realer Vor-/Nachname ("real")

//// Facebook App (Erstellen unter https://developers.facebook.com/apps)

$coredata['facebookappid'] = "";   // Facebook App-ID
$coredata['facebooksecretkey'] = "";   // Facebook App-Gehemincode


//// Zahlungseinstellungen

$coredata['waehrung'] = "EUR";   // Dreistelliger Währungcode nach ISO 4217 (z.B. EUR, CHF oder USD)
$coredata['gebuehr'] = "0.60";   // Gebühr pro abgegebenem Angebot
$coredata['flatrate1'] = "29";   // Gebühr für unbeschränkte Angebotsabgabe (Flatrate) für 30 Tage
$coredata['flatrate2'] = "79";   // Gebühr für unbeschränkte Angebotsabgabe (Flatrate) für 90 Tage
$coredata['flatrate3'] = "249";   // Gebühr für unbeschränkte Angebotsabgabe (Flatrate) für 1 Jahr
$coredata['minbetrag'] = "10";   // Mindestbetrag für eine Kontoaufladung
$coredata['maxbetrag'] = "2000";   // Maximalbetrag für eine Kontoaufladung
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