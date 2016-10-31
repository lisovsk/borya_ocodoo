<?php

if($lg=="ok") {

echo '<legend>Meine Buchungen</legend>';
$DO_TITEL="Meine Buchungen";

$abbrechen=htmlspecialchars(stripslashes($_GET[abbrechen]));
if(!$abbrechen) $abbrechen=htmlspecialchars(stripslashes($_POST[abbrechen]));

if($abbrechen!="" && $o!="k") {
echo 'Solange der Vermieter Ihre Buchungsanfrage noch nicht bestätigt hat, können Sie diese jederzeit abbrechen (nach 12 Stunden ohne Bestätigung wird diese automatisch abgebrochen). Sie erhalten dann den bezahlten Betrag wieder zurückerstattet.<br><br>Möchten Sie die Buchung wirklich abrechen?<br><br><form action=index.php method=get><input type=hidden name=d value=buchungen><input type=hidden name=abbrechen value='.$abbrechen.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';
} else {

if($abbrechen!="" && $o=="k") {

$getBuchung = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE id='".$abbrechen."' AND art='ma' AND user='".$usrd[id]."'");
$delBuchung = mysql_fetch_array($getBuchung);
if($delBuchung[id]!="") {

$getfahrzeug = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE id='".$delBuchung[fahrzeug]."'");
$fahrzeug = mysql_fetch_array($getfahrzeug);

$mietdauer = ($delBuchung[bis] - $delBuchung[von]) / 86400;
$mietdauer = round($mietdauer,0)+1;
$mietpreis_total=$fahrzeug[preis_tag]*$mietdauer;
$guthabenneu=$usrd[guthaben]+$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,fahrzeug,status) VALUES ('".$usrd[id]."','rueckerstattung','".$mietpreis_total."','".time()."','".$fahrzeug[id]."','ok')");
mysql_query("DELETE FROM ".$dbx."_mieten WHERE id='".$delBuchung[id]."'");
echo '<div class="alert alert-success"><b>Okay!</b> Die Buchungsanfrage wurde erfolgreich abgebrochen.</div>';

}
else echo '<div class="alert alert-danger"><b>Ups!</b> Abbrechen der Buchung nicht möglich.</div>';

}


echo '<ul class="nav nav-tabs">
<li class="active"><a href="#mieter" data-toggle="tab">Getätigte Buchungen</a></li>
<li><a href="#vermieter" data-toggle="tab">Erhaltene Buchungen</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade in active" id="mieter" style="padding:15px;margin-bottom:30px;">';

$getBuchungen = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE (art='ma' OR art='mt') AND user='".$usrd[id]."' ORDER BY datum DESC");
if(mysql_num_rows($getBuchungen)==0) echo '<br><div class="alert alert-danger">Sie haben noch keine Buchungen getätigt.</div>';
else {
while($buchung=mysql_fetch_array($getBuchungen)) {

$getguser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$buchung[vermieter]."'");
$guser = mysql_fetch_array($getguser);

$getfahrzeug = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE id='".$buchung[fahrzeug]."'");
$fahrzeug = mysql_fetch_array($getfahrzeug);

$mietdauer = ($buchung[bis] - $buchung[von]) / 86400;
$mietdauer = round($mietdauer,0)+1;
$mietpreis_total=$fahrzeug[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$buchung[von]).' bis '.date("j.n.Y",$buchung[bis]);

if($coredata['user']=="user") $urlUsername=$guser[user]; else $urlUsername=$guser[id];

echo '<div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;padding-bottom:15px;"><div class="col-lg-8 col-sm-7">
<b><big><a href="'.genURL('fahrzeug',$fahrzeug[id]).'">'.$fahrzeug[titel].'</a></big></b><br><br>
<img src=images/ico_map.png width=16 height=16 align=absmiddle> '.$fahrzeug[plz].' '.$fahrzeug[ort].'<br>
<img src=images/ico_user_'.$guser[geschlecht].'.png width=16 height=16 align=absmiddle> Vermieter: <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($guser[user]);
else echo $guser[vorname].' '.$guser[nachname];
echo '</a><br>
<img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.$mietzeitraum.' ('.$mietdauer.' Tage)<br>
<img src=images/ico_konto.png width=16 height=16 align=absmiddle> '.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$fahrzeug[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' pro Tag)<br><br>
<img src=images/ico_mietvertrag.png width=16 height=16 align=absmiddle> <a href=mietvertrag.pdf>Mietvertrag (PDF) herunterladen und ausdrucken</a>
</div>
<div class="col-lg-4 col-sm-5">';

if($buchung[art]=="ma") echo '<img src=images/ico_wait.png width=16 height=16 align=absmiddle> <font color=#e53b29><i>noch nicht bestätigt</i></font><br><img src=images/ico_delete.png width=16 height=16 align=absmiddle> <a href="index.php?d=buchungen&abbrechen='.$buchung[id].'">Buchung abbrechen</a>';
elseif($buchung[art]=="mt") echo '<img src=images/ico_check.png width=16 height=16 align=absmiddle> <font color=#5aba04><i>bestätigt</i></font><br><img src=images/ico_stern.png width=16 height=16 align=absmiddle> <a href="'.genURL('bewertung').'">Bewertung abgeben</a>';

echo '</div></div>';

}
}


echo '</div><div class="tab-pane fade" id="vermieter" style="padding:15px;margin-bottom:30px;">';


$getBuchungen = mysql_query("SELECT * FROM ".$dbx."_mieten WHERE vermieter='".$usrd[id]."' ORDER BY datum DESC");
if(mysql_num_rows($getBuchungen)==0) echo '<br><div class="alert alert-danger">Sie haben noch keine Buchungen erhalten.</div>';
else {
while($buchung=mysql_fetch_array($getBuchungen)) {

$getguser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$buchung[user]."'");
$guser = mysql_fetch_array($getguser);

$getfahrzeug = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE id='".$buchung[fahrzeug]."'");
$fahrzeug = mysql_fetch_array($getfahrzeug);

$mietdauer = ($buchung[bis] - $buchung[von]) / 86400;
$mietdauer = round($mietdauer,0)+1;
$mietpreis_total=$fahrzeug[preis_tag]*$mietdauer;
$mietzeitraum=date("j.n.Y",$buchung[von]).' bis '.date("j.n.Y",$buchung[bis]);

if($coredata['user']=="user") $urlUsername=$guser[user]; else $urlUsername=$guser[id];

echo '<div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;padding-bottom:15px;"><div class="col-lg-8 col-sm-7">
<b><big><a href="'.genURL('fahrzeug',$fahrzeug[id]).'">'.$fahrzeug[titel].'</a></big></b><br><br>
<img src=images/ico_map.png width=16 height=16 align=absmiddle> '.$fahrzeug[plz].' '.$fahrzeug[ort].'<br>
<img src=images/ico_user_'.$guser[geschlecht].'.png width=16 height=16 align=absmiddle> Mieter: <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($guser[user]);
else echo $guser[vorname].' '.$guser[nachname];
echo '</a><br>
<img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.$mietzeitraum.' ('.$mietdauer.' Tage)<br>
<img src=images/ico_konto.png width=16 height=16 align=absmiddle> '.$mietpreis_total.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' ('.$fahrzeug[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' pro Tag)<br><br>
<img src=images/ico_mietvertrag.png width=16 height=16 align=absmiddle> <a href=mietvertrag.pdf>Mietvertrag (PDF) herunterladen und ausdrucken</a>
</div>
<div class="col-lg-4 col-sm-5">';

if($buchung[art]=="ma") echo '<img src=images/ico_wait.png width=16 height=16 align=absmiddle> <font color=#e53b29><i>noch nicht bestätigt</i></font><br><img src=images/ico_bearbeiten.png width=16 height=16 align=absmiddle> <a href="'.genURL('bestaetigen',$buchung[id]).'">Jetzt bestätigen</a>';
elseif($buchung[art]=="mt") echo '<img src=images/ico_check.png width=16 height=16 align=absmiddle> <font color=#5aba04><i>bestätigt</i></font><br><img src=images/ico_stern.png width=16 height=16 align=absmiddle> <a href="'.genURL('bewertung').'">Bewertung abgeben</a>';

echo '</div></div>';

}
}

echo '</div>';

}

}
else {
include("inc/login.inc.php");
}

?>