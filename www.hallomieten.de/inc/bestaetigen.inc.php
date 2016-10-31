<?php

if($lg=="ok") {

echo '<legend>Mietanfrage bestätigen</legend>';

$getanfrage = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE id='".$s."' AND art='ma'");
$anfrage = mysql_fetch_array($getanfrage);

$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE id='".$anfrage[gegenstand]."' AND status='ok' AND user='".$usrd[id]."'");
$gegenstand = mysql_fetch_array($getgegenstand);

$getmieter=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$anfrage[user]."'");
$mieter = mysql_fetch_array($getmieter);

if($anfrage[id]=="" || $gegenstand[id]=="" || $mieter[id]=="" || time()>$anfrage[datum]+45000) echo '<div class="alert alert-danger"><b>Ups!</b> Die Mietanfrage ist nicht mehr verfügbar.</div><div>Das kann mehrere Ursachen haben:<ul>
<li>Sie haben die Mietanfrage bereits bestätigt oder abgelehnt.
<li>Der Mieter hat die Anfrage abgebrochen.
<li>Die Anfrage ist älter als 12 Stunden und wurde automatisch abgebrochen.
<li>Der User wurde gesperrt und seine Mietanfragen gelöscht.
</ul>';
else {

$mietdauer = ($anfrage[bis] - $anfrage[von]) / 86400;
$mietdauer = round($mietdauer,0)+1;

$mietpreis_total=$gegenstand[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$anfrage[von]).' bis '.date("j.n.Y",$anfrage[bis]);

$mietpreis_gebuehr=($mietpreis_total/100)*$coredata['gebuehr'];

$vermieter_gutschrift=$mietpreis_total-$mietpreis_gebuehr;
$vermieter_gutschrift=number_format($vermieter_gutschrift,2);


if($o=="ablehnen") {


$guthabenneu=$mieter[guthaben]+$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$mieter[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,gegenstand,status) VALUES ('".$mieter[id]."','rueckerstattung','".$mietpreis_total."','".time()."','".$gegenstand[id]."','ok')");

mysql_query("DELETE FROM ".$dbx."_mieten WHERE id='".$anfrage[id]."'");

echo '<div class="alert alert-success"><b>Okay!</b> Die Mietanfrage wurde erfolgreich abgelehnt.</div>';

}
elseif($o=="k") {

mysql_query("UPDATE ".$dbx."_mieten SET art='mt' WHERE id='".$anfrage[id]."'");

mysql_query("INSERT INTO ".$dbx."_bewertungen (als, gegenstand, user, bewerter, datum) VALUES ('vermieter', '".$gegenstand[id]."', '".$usrd[id]."', '".$mieter[id]."', '".time()."')");
mysql_query("INSERT INTO ".$dbx."_bewertungen (als, gegenstand, user, bewerter, datum) VALUES ('mieter', '".$gegenstand[id]."', '".$mieter[id]."', '".$usrd[id]."', '".time()."')");

$guthabenneu=$usrd[guthaben]+$vermieter_gutschrift;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,gegenstand,status) VALUES ('".$usrd[id]."','vermietung','".$vermieter_gutschrift."','".time()."','".$gegenstand[id]."','ok')");

$ph1=array('%vorname%','%nachname%','%vermieterdetails%','%gegenstandtitel%','%gegenstandadresse%','%mietdauer%','%mietzeitraum%','%anzgaeste%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($mieter[vorname],$mieter[nachname],$usrd[vorname].' '.$usrd[nachname].'
'.$usrd[plz].' '.$usrd[ort].'

'.$usrd[email],$gegenstand[titel],$gegenstand[strasse].', '.$gegenstand[ort],$mietdauer,$mietzeitraum,$anfrage[anzgaeste],$gegenstand[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_mieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($mieter[email],"Mietanfrage bestätigt: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

$ph1=array('%vorname%','%nachname%','%mieterdetails%','%gegenstandtitel%','%gegenstandadresse%','%mietdauer%','%mietzeitraum%','%anzgaeste%','%preistag%','%preistotal%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$mieter[vorname].' '.$mieter[nachname].'
'.$mieter[plz].' '.$mieter[ort].'

'.$mieter[email],$gegenstand[titel],$gegenstand[strasse].', '.$gegenstand[ort],$mietdauer,$mietzeitraum,$anfrage[anzgaeste],$gegenstand[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_vermieter.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Mietanfrage bestätigt: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Vielen Dank!</b> Die Miete ist nun bestätigt.</div><div>Sie erhalten in Kürze eine E-Mail mit den weiteren Details und den Kontaktdaten des Mieters.</div>';

} else {

echo '<form action=index.php method=post><input type=hidden name=d value=bestaetigen><input type=hidden name=s value='.$anfrage[id].'><input type=hidden name=o value=k>
<table class="table table-striped" style="width:100%;max-width:500px">

<tr><td><b>Gegenstand:</b></td><td><a href="'.genURL('gegenstand',$gegenstand[id]).'">'.$gegenstand[titel].'</a></td></tr>
<tr><td><b>Kategorie:</b></td><td>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($gegenstand[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo '</td></tr>
<tr><td><b>Ort:</b></td><td><img src=images/flaggen/'.$gegenstand[land].'.gif width=18 height=12 align=absmiddle> '.$gegenstand[ort].'</td></tr>
<tr><td><b>Anzahl Tage:</b></td><td>'.$mietdauer.'</td></tr>
<tr><td><b>Zeitraum:</b></td><td>'.$mietzeitraum.'</td></tr>
<tr><td><b>Preis:</b></td><td>'.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$gegenstand[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' pro Tag)</td></tr>
<tr><td><b>'.$coredata[titel].'-Gebühr:</b></td><td>'.number_format($mietpreis_gebuehr,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$coredata[gebuehr].'%)</td></tr>
<tr><td><b>Auszahlungsbetrag:</b></td><td><b>'.number_format($vermieter_gutschrift,2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></td></tr>

<tr><td colspan=2><input type=submit value="Mietanfrage bestätigen" style="width:100%;" class="btn btn-large btn-success"><br><br><a href="index.php?d=bestaetigen&s='.$anfrage[id].'&o=ablehnen" style="width:100%;" class="btn btn-danger">Mietanfrage ablehnen</a></td></tr>

</table></form>';

}


}


}
else {
include("inc/login.inc.php");
}

?>