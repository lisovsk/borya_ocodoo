<?php

if($lg=="ok") {

$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE id='".$s."' AND status='ok'");
$gegenstand = mysql_fetch_array($getgegenstand);

echo '<legend>Mietanfrage: '.$gegenstand[titel].'</legend>';

$datumvon = explode(".",$_POST[datumvon]);
$datumbis = explode(".",$_POST[datumbis]);
$datumvon_timestamp = mktime(11,0,0,$datumvon[1],$datumvon[0],$datumvon[2]);
$datumbis_timestamp = mktime(11,0,0,$datumbis[1],$datumbis[0],$datumbis[2]);
$mietdauer = ($datumbis_timestamp - $datumvon_timestamp) / 86400;
$mietdauer = round($mietdauer,0)+1;

for ($i=$datumvon_timestamp; $i<($datumbis_timestamp+86400); $i=$i+86400) {
$ddsql.=" OR (von < ".($i+10000)." AND bis > ".($i-10000).")";
}

$getcheckdd=mysql_query("SELECT * FROM ".$dbx."_mieten WHERE gegenstand='".$gegenstand[id]."' AND (art='x'".$ddsql.")");
$checkdd=mysql_fetch_array($getcheckdd);









?><script>
$(document).ready(function() {
  $(function() {
    $("#datumvon").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+5M +27D",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
$(document).ready(function() {
  $(function() {
    $("#datumbis").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+6M",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
</script><?php

$neueDatumwahl .= '<div>Möchten Sie es mit einem anderen Zeitraum versuchen?</div><br><div style="width:100%;max-width:400px;">';

$dateMorgen = date("d.m.Y",time()+86400);
$dateDreiTage = date("d.m.Y",time()+345600);

$neueDatumwahl .= '<div style="margin-bottom:30px;"><form action=index.php method=post><input type=hidden name=d value=mieten><input type=hidden name=s value='.$gegenstand[id].'>

<div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<div class="col-5" style="padding:0px !important;"><b>Von:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></span><input type="text" name="datumvon" id="datumvon" value="'.$dateMorgen.'" class=form-control></div></div>

</div><div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<div class="col-5" style="padding:0px !important;"><b>Bis:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></span><input type="text" name="datumbis" id="datumbis" value="'.$dateDreiTage.'" class=form-control></div></div>

</div><div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<div class="col-5" style="padding:0px !important;"><b>Gäste:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_users.png width=16 height=16></span><select name="anzgaeste" id="anzgaeste" class=form-control>
<option>1
<option selected>2
<option>3
<option>4
<option>5
<option>6
<option>7
<option>8
<option>9
<option>10
<option>11
<option>12
<option>13
<option>14
<option>15+
</select></div></div>
</div>

<div style="padding-top:5px;"><input type=submit value="Jetzt buchen!" style="width:100%;" class="btn btn-large btn-warning"></div>

</form></div>';













if($gegenstand[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Der Gegenstand wird nicht mehr angeboten.</div>';
elseif($checkdd[id]!="") echo '<div class="alert alert-danger"><b>Ups!</b> Der Gegenstand ist im gewählten Zeitraum leider nicht verfügbar.</div>'.$neueDatumwahl;
elseif($mietdauer<1 || $mietdauer>190) echo '<div class="alert alert-danger"><b>Ups!</b> Das sind ungültige Datumsangaben.</div>'.$neueDatumwahl;
elseif($datumvon[0]=="" || $datumvon[1]=="" || $datumvon[2]=="" || $datumbis[0]=="" || $datumbis[1]=="" || $datumbis[2]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Das ist ein ungültiges Datum.</div>'.$neueDatumwahl;
elseif($datumvon_timestamp<(time()-10000)) echo '<div class="alert alert-danger"><b>Ups!</b> Das ist ein ungültiges Datum.</div>'.$neueDatumwahl;
elseif($datumbis_timestamp>(time()+15100000)) echo '<div class="alert alert-danger"><b>Ups!</b> Das ist ein ungültiges Datum.</div>'.$neueDatumwahl;
elseif($datumbis_timestamp<$datumvon_timestamp) echo '<div class="alert alert-danger"><b>Ups!</b> Das ist ein ungültiges Datum.</div>'.$neueDatumwahl;
elseif($usrd[id]==$gegenstand[user]) echo '<div class="alert alert-danger"><b>Ups!</b> Sie können nicht Ihren eigenen Gegenstand buchen.</div>';
else {

$getvermieter=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$gegenstand[user]."'");
$vermieter = mysql_fetch_array($getvermieter);
if($coredata['user']=="user") $urlUsername=$vermieter[user]; else $urlUsername=$vermieter[id];

$mietpreis_total=$gegenstand[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$datumvon_timestamp).' bis '.date("j.n.Y",$datumbis_timestamp);



if($usrd[guthaben]<$mietpreis_total) {
echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben nicht genügend Guthaben.</div><div>Wir versuchen das Mieten und Vermieten über '.$coredata[titel].' für Mieter und Vermieter möglichst unkompliziert und sicher abzuwickeln. Aus diesem Grund ist die Bezahlung direkt bei der Mietanfrage fällig. Falls die Miete nicht zustande kommt, kann der Betrag wieder voll ausgezahlt oder für das Mieten eines anderen Gegenstandes verwendet werden. Weitere Infos zum Ablauf: <a href="'.genURL('faq').'">Häufige Fragen</a><br><br>Die angefragten '.$mietdauer.' Tage Miete dieses Gegenstandes kosten '.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '.<br><br>Bitte laden Sie <a href="'.genURL('konto').'">hier Ihr Konto</a> auf und starten Sie die Mietanfrage erneut.</div>';
}

elseif($o=="k") {

mysql_query("INSERT INTO ".$dbx."_mieten (user,vermieter,art,gegenstand,von,bis,datum) VALUES ('".$usrd[id]."','".$gegenstand[user]."','ma','".$gegenstand[id]."','".$datumvon_timestamp."','".$datumbis_timestamp."','".time()."')");
$anfrageid=mysql_insert_id();

$guthabenneu=$usrd[guthaben]-$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,gegenstand,status) VALUES ('".$usrd[id]."','miete','-".$mietpreis_total."','".time()."','".$gegenstand[id]."','ok')");

$ph1=array('%vorname%','%nachname%','%gegenstandtitel%','%gegenstandadresse%','%besurl%','%mietdauer%','%mietzeitraum%','%preisntag%','%preistotal%','%titel%','%url%');
$ph2=array($vermieter[vorname],$vermieter[nachname],$gegenstand[titel],$gegenstand[strasse].', '.$gegenstand[ort],genURL('bestaetigen',$anfrageid),$mietdauer,$mietzeitraum,$gegenstand[preis_tag],$mietpreis_total,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/mietanfrage.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($vermieter[email],"Mietanfrage: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Vielen Dank!</b> Ihre Mietanfrage wurde an den Vermieter weitergeleitet.</div><div>Sie erhalten ein E-Mail, sobald der Vermieter Ihre Anfrage bestätigt hat.</div>';

} else {

echo '<div>Mit folgendem Button senden Sie die Mietanfrage an den Vermieter. Nach Bestätigung erhalten Sie und der Vermieter die gegenseitigen Kontaktdaten. Sollte die Mietanfrage nicht innerhalb von 12 Stunden bestätigt werden, wird diese automatisch gelöscht und Sie erhalten den vollen Betrag erstattet.</div><br>
<form action=index.php method=post><input type=hidden name=d value=mieten><input type=hidden name=s value='.$gegenstand[id].'><input type=hidden name=datumvon value="'.date("d.m.Y",$datumvon_timestamp).'"><input type=hidden name=datumbis value="'.date("d.m.Y",$datumbis_timestamp).'"><input type=hidden name=anzgaeste value='.$anzgaeste.'><input type=hidden name=o value=k>
<table class="table table-striped" style="width:100%;max-width:500px">

<tr><td><b>Gegenstand:</b></td><td><a href="'.genURL('gegenstand',$gegenstand[id]).'">'.$gegenstand[titel].'</a></td></tr>
<tr><td><b>Kategorie:</b></td><td>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($gegenstand[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo '</td></tr>
<tr><td><b>Ort:</b></td><td><img src=images/flaggen/'.$gegenstand[land].'.gif width=18 height=12 align=absmiddle> '.$gegenstand[ort].'</td></tr>
<tr><td><b>Vermieter:</b></td><td><img src=images/ico_user_'.$vermieter[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($vermieter[user]);
else echo $vermieter[vorname].' '.$vermieter[nachname];
echo '</a></td></tr>
<tr><td><b>Anzahl Tage:</b></td><td>'.$mietdauer.'</td></tr>
<tr><td><b>Zeitraum:</b></td><td>'.$mietzeitraum.'</td></tr>
<tr><td><b>Preis pro Tag:</b></td><td>'.$gegenstand[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</td></tr>
<tr><td><b>Preis total:</b></td><td><b>'.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></td></tr>
<tr><td colspan=2><input type=submit value="Mietanfrage senden" style="width:100%;" class="btn btn-large btn-warning"></td></tr>

</table></form>';

}






}

}
else {
include("inc/login.inc.php");
}

?>