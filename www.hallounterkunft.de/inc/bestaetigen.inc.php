<?php

if($lg=="ok") {

echo '<legend>Buchungsanfrage best�tigen</legend>';

$getanfrage = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE id='".$s."' AND art='ma'");
$anfrage = mysql_fetch_array($getanfrage);

$getunterkunft = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE id='".$anfrage[unterkunft]."' AND status='ok' AND user='".$usrd[id]."'");
$unterkunft = mysql_fetch_array($getunterkunft);

$getmieter=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$anfrage[user]."'");
$mieter = mysql_fetch_array($getmieter);

$bestime = $coredata['anfrageablauf'] * 3750;

if($anfrage[id]=="" || $unterkunft[id]=="" || $mieter[id]=="" || time()>$anfrage[datum]+$bestime) echo '<div class="alert alert-danger"><b>Ups!</b> Die Buchungsanfrage ist nicht mehr verf�gbar.</div><div>Das kann mehrere Ursachen haben:<ul>
<li>Sie haben die Buchungsanfrage bereits best�tigt oder abgelehnt.
<li>Der Mieter hat die Anfrage abgebrochen.
<li>Sie sind nicht als Vermieter eingeloggt.
<li>Die Anfrage ist �lter als 12 Stunden und wurde automatisch abgebrochen.
<li>Der User wurde gesperrt und seine Buchungsanfragen gel�scht.
</ul>';
else {

$mietdauer = ($anfrage[bis] - $anfrage[von]) / 86400;
$mietdauer = round($mietdauer,0);

$mietpreis_total=$unterkunft[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$anfrage[von]).' bis '.date("j.n.Y",$anfrage[bis]);

$mietpreis_gebuehr=($mietpreis_total/100)*$coredata['gebuehr'];

$vermieter_gutschrift=$mietpreis_total-$mietpreis_gebuehr;
$vermieter_gutschrift=number_format($vermieter_gutschrift,2);


if($o=="ablehnen") {

$guthabenneu=$mieter[guthaben]+$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$mieter[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,unterkunft,status) VALUES ('".$mieter[id]."','rueckerstattung','".$mietpreis_total."','".time()."','".$unterkunft[id]."','ok')");

mysql_query("DELETE FROM ".$dbx."_mieten WHERE id='".$anfrage[id]."'");

echo '<div class="alert alert-success"><b>Okay!</b> Die Buchungsanfrage wurde erfolgreich abgelehnt.</div>';

}
elseif($o=="k") {

mysql_query("UPDATE ".$dbx."_mieten SET art='mt' WHERE id='".$anfrage[id]."'");

mysql_query("INSERT INTO ".$dbx."_bewertungen (als, unterkunft, user, bewerter, datum) VALUES ('vermieter', '".$unterkunft[id]."', '".$usrd[id]."', '".$mieter[id]."', '".time()."')");
mysql_query("INSERT INTO ".$dbx."_bewertungen (als, unterkunft, user, bewerter, datum) VALUES ('mieter', '".$unterkunft[id]."', '".$mieter[id]."', '".$usrd[id]."', '".time()."')");

$guthabenneu=$usrd[guthaben]+$vermieter_gutschrift;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,unterkunft,status) VALUES ('".$usrd[id]."','vermietung','".$vermieter_gutschrift."','".time()."','".$unterkunft[id]."','ok')");

$ph1=array('%vorname%','%nachname%','%vermieterdetails%','%unterkunfttitel%','%unterkunftadresse%','%mietdauer%','%mietzeitraum%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($mieter[vorname],$mieter[nachname],$usrd[vorname].' '.$usrd[nachname].'
'.$usrd[plz].' '.$usrd[ort].'

'.$usrd[email],$unterkunft[titel],$unterkunft[strasse].', '.$unterkunft[ort],$mietdauer,$mietzeitraum,$unterkunft[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_mieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($mieter[email],"Buchungsanfrage best�tigt: ".$unterkunft[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

$ph1=array('%vorname%','%nachname%','%mieterdetails%','%unterkunfttitel%','%unterkunftadresse%','%mietdauer%','%mietzeitraum%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$mieter[vorname].' '.$mieter[nachname].'
'.$mieter[plz].' '.$mieter[ort].'

'.$mieter[email],$unterkunft[titel],$unterkunft[strasse].', '.$unterkunft[ort],$mietdauer,$mietzeitraum,$unterkunft[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_vermieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Buchungsanfrage best�tigt: ".$unterkunft[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Vielen Dank!</b> Die Buchung ist nun best�tigt.</div><div>Sie erhalten in K�rze eine E-Mail mit den weiteren Details und den Kontaktdaten des Mieters.</div>';

} else {

if($coredata['user']=="user") $urlUsername=$mieter[user]; else $urlUsername=$mieter[id];

echo '<form action=index.php method=post><input type=hidden name=d value=bestaetigen><input type=hidden name=s value='.$anfrage[id].'><input type=hidden name=o value=k>
<table class="table table-striped" style="width:100%;max-width:500px">

<tr><td><b>Mieter:</b></td><td><img src=images/ico_user_'.$mieter[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($mieter[user]);
else echo $mieter[vorname].' '.$mieter[nachname];
echo '</a></td></tr>
<tr><td><b>Verifiziert:</b></td><td>';
if($mieter['verifizierung']=="ok") echo '<img src=images/ico_verified.png width=16 height=16 align=absmiddle> Ja, Identit�t �berpr�ft';
else echo 'Nein';
echo '</td></tr>
<tr><td><b>Unterkunft:</b></td><td><a href="'.genURL('unterkunft',$unterkunft[id]).'">'.$unterkunft[titel].'</a></td></tr>
<tr><td><b>Unterkunftsart:</b></td><td>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($unterkunft[art]==$fetchArt[id]) echo $fetchArt[art];
}

echo '</td></tr>
<tr><td><b>Ort der Unterkunft:</b></td><td><img src=images/flaggen/'.$unterkunft[land].'.gif width=18 height=12 align=absmiddle> '.$unterkunft[ort].'</td></tr>
<tr><td><b>Anzahl N�chte:</b></td><td>'.$mietdauer.'</td></tr>
<tr><td><b>Zeitraum:</b></td><td>'.$mietzeitraum.'</td></tr>
<tr><td><b>Preis:</b></td><td>'.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$unterkunft[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' pro Tag)</td></tr>
<tr><td><b>'.$coredata[titel].'-Geb�hr:</b></td><td>'.number_format($mietpreis_gebuehr,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$coredata[gebuehr].'%)</td></tr>
<tr><td><b>Auszahlungsbetrag:</b></td><td><b>'.number_format($vermieter_gutschrift,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></td></tr>

<tr><td colspan=2><input type=submit value="Buchungsanfrage best�tigen" style="width:100%;" class="btn btn-large btn-success"><br><br><a href="index.php?d=bestaetigen&s='.$anfrage[id].'&o=ablehnen" style="width:100%;" class="btn btn-danger">Buchungsanfrage ablehnen</a></td></tr>

</table></form>';

}

}

}
else {
include("inc/login.inc.php");
}

?>