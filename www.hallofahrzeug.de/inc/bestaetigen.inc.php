<?php

if($lg=="ok") {

echo '<legend>Buchungsanfrage bestätigen</legend>';

$getanfrage = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE id='".$s."' AND art='ma'");
$anfrage = mysql_fetch_array($getanfrage);

$getfahrzeug = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE id='".$anfrage[fahrzeug]."' AND status='ok' AND user='".$usrd[id]."'");
$fahrzeug = mysql_fetch_array($getfahrzeug);

$getmieter=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$anfrage[user]."'");
$mieter = mysql_fetch_array($getmieter);

$bestime = $coredata['anfrageablauf'] * 3750;

if($anfrage[id]=="" || $fahrzeug[id]=="" || $mieter[id]=="" || time()>$anfrage[datum]+$bestime) echo '<div class="alert alert-danger"><b>Ups!</b> Die Buchungsanfrage ist nicht mehr verfügbar.</div><div>Das kann mehrere Ursachen haben:<ul>
<li>Sie haben die Buchungsanfrage bereits bestätigt oder abgelehnt.
<li>Der Mieter hat die Anfrage abgebrochen.
<li>Sie sind nicht als Vermieter eingeloggt.
<li>Die Anfrage ist älter als 12 Stunden und wurde automatisch abgebrochen.
<li>Der User wurde gesperrt und seine Buchungsanfragen gelöscht.
</ul>';
else {

$mietdauer = ($anfrage[bis] - $anfrage[von]) / 86400;
$mietdauer = round($mietdauer,0)+1;

$mietpreis_total=$fahrzeug[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$anfrage[von]).' bis '.date("j.n.Y",$anfrage[bis]);

$mietpreis_gebuehr=($mietpreis_total/100)*$coredata['gebuehr'];

$vermieter_gutschrift=$mietpreis_total-$mietpreis_gebuehr;
$vermieter_gutschrift=number_format($vermieter_gutschrift,2);


if($o=="ablehnen") {

$guthabenneu=$mieter[guthaben]+$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$mieter[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,fahrzeug,status) VALUES ('".$mieter[id]."','rueckerstattung','".$mietpreis_total."','".time()."','".$fahrzeug[id]."','ok')");

mysql_query("DELETE FROM ".$dbx."_mieten WHERE id='".$anfrage[id]."'");

echo '<div class="alert alert-success"><b>Okay!</b> Die Buchungsanfrage wurde erfolgreich abgelehnt.</div>';

}
elseif($o=="k") {

mysql_query("UPDATE ".$dbx."_mieten SET art='mt' WHERE id='".$anfrage[id]."'");

mysql_query("INSERT INTO ".$dbx."_bewertungen (als, fahrzeug, user, bewerter, datum) VALUES ('vermieter', '".$fahrzeug[id]."', '".$usrd[id]."', '".$mieter[id]."', '".time()."')");
mysql_query("INSERT INTO ".$dbx."_bewertungen (als, fahrzeug, user, bewerter, datum) VALUES ('mieter', '".$fahrzeug[id]."', '".$mieter[id]."', '".$usrd[id]."', '".time()."')");

$guthabenneu=$usrd[guthaben]+$vermieter_gutschrift;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,fahrzeug,status) VALUES ('".$usrd[id]."','vermietung','".$vermieter_gutschrift."','".time()."','".$fahrzeug[id]."','ok')");

$ph1=array('%vorname%','%nachname%','%vermieterdetails%','%fahrzeugtitel%','%fahrzeugadresse%','%mietdauer%','%mietzeitraum%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($mieter[vorname],$mieter[nachname],$usrd[vorname].' '.$usrd[nachname].'
'.$usrd[plz].' '.$usrd[ort].'

'.$usrd[email],$fahrzeug[titel],$fahrzeug[strasse].', '.$fahrzeug[ort],$mietdauer,$mietzeitraum,$fahrzeug[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_mieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($mieter[email],"Buchungsanfrage bestätigt: ".$fahrzeug[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

$ph1=array('%vorname%','%nachname%','%mieterdetails%','%fahrzeugtitel%','%fahrzeugadresse%','%mietdauer%','%mietzeitraum%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$mieter[vorname].' '.$mieter[nachname].'
'.$mieter[plz].' '.$mieter[ort].'

'.$mieter[email],$fahrzeug[titel],$fahrzeug[strasse].', '.$fahrzeug[ort],$mietdauer,$mietzeitraum,$fahrzeug[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_vermieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Buchungsanfrage bestätigt: ".$fahrzeug[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Vielen Dank!</b> Die Buchung ist nun bestätigt.</div><div>Sie erhalten in Kürze eine E-Mail mit den weiteren Details und den Kontaktdaten des Mieters.<br><br><img src=images/ico_mietvertrag.png width=16 height=16 align=absmiddle> <a href=mietvertrag.pdf>Mietvertrag (PDF) herunterladen und ausdrucken</a></div>';

} else {

if($coredata['user']=="user") $urlUsername=$mieter[user]; else $urlUsername=$mieter[id];

echo '<form action=index.php method=post><input type=hidden name=d value=bestaetigen><input type=hidden name=s value='.$anfrage[id].'><input type=hidden name=o value=k>
<table class="table table-striped" style="width:100%;max-width:500px">

<tr><td><b>Mieter:</b></td><td><img src=images/ico_user_'.$mieter[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($mieter[user]);
else echo $mieter[vorname].' '.$mieter[nachname];
echo '</a></td></tr>
<tr><td><b>Verifiziert:</b></td><td>';
if($mieter['verifizierung']=="ok") echo '<img src=images/ico_verified.png width=16 height=16 align=absmiddle> Ja, Identität überprüft';
else echo 'Nein';
echo '</td></tr>
<tr><td><b>Fahrzeug:</b></td><td><a href="'.genURL('fahrzeug',$fahrzeug[id]).'">'.$fahrzeug[titel].'</a></td></tr>
<tr><td><b>Fahrzeugart:</b></td><td>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($fahrzeug[art]==$fetchArt[id]) echo $fetchArt[art];
}

echo '</td></tr>
<tr><td><b>Ort des Fahrzeuges:</b></td><td><img src=images/flaggen/'.$fahrzeug[land].'.gif width=18 height=12 align=absmiddle> '.$fahrzeug[ort].'</td></tr>
<tr><td><b>Anzahl Tage:</b></td><td>'.$mietdauer.'</td></tr>
<tr><td><b>Zeitraum:</b></td><td>'.$mietzeitraum.'</td></tr>
<tr><td><b>Preis:</b></td><td>'.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$fahrzeug[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' pro Tag)</td></tr>
<tr><td><b>'.$coredata[titel].'-Gebühr:</b></td><td>'.number_format($mietpreis_gebuehr,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$coredata[gebuehr].'%)</td></tr>
<tr><td><b>Auszahlungsbetrag:</b></td><td><b>'.number_format($vermieter_gutschrift,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></td></tr>

<tr><td colspan=2><input type=submit value="Buchungsanfrage bestätigen" style="width:100%;" class="btn btn-large btn-success"><br><br><a href="index.php?d=bestaetigen&s='.$anfrage[id].'&o=ablehnen" style="width:100%;" class="btn btn-danger">Buchungsanfrage ablehnen</a></td></tr>

</table></form>';

}

}

}
else {
include("inc/login.inc.php");
}

?>