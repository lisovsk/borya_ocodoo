<?php

if($lg=="ok") {

$getkurs = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE id='".$s."'");
$kurs = mysqli_fetch_array($getkurs);

echo '<legend>Kurs buchen: '.$kurs[titel].'</legend>';

$getcheckdd=mysqli_query($db,"SELECT * FROM ".$dbx."_teilnehmer WHERE kurs='".$kurs[id]."' AND user='".$usrd[id]."'");
$checkdd=mysqli_fetch_array($getcheckdd);

if($kurs[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Der Kurs wird nicht mehr angeboten.</div>';
elseif($checkdd[id]!="" && $kurs[standort]=="vorort") echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben diesen Kurs bereits gebucht.</div>';
elseif($usrd[id]==$kurs[user]) echo '<div class="alert alert-danger"><b>Ups!</b> Sie können nicht Ihren eigenen Kurs buchen.</div>';
else {

$getlehrer=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$kurs[user]."'");
$lehrer = mysqli_fetch_array($getlehrer);
if($coredata['user']=="user") $urlUsername=$lehrer[user]; else $urlUsername=$lehrer[id];

if($usrd[guthaben]<$kurs[kosten]) {
echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben nicht genügend Guthaben.</div><div>Wir versuchen das Anbieten und Buchen von Kursen über '.$coredata[titel].' für Coaches und Teilnehmer möglichst unkompliziert und sicher abzuwickeln. Aus diesem Grund ist die Bezahlung direkt bei der Buchung fällig. Falls der Kurs nicht zustande kommt, wird der Betrag wieder voll ausgezahlt oder kann für die Buchung eines anderen Kurses verwendet werden.<br><br>Weitere Infos zum Ablauf: <a href="'.genURL('faq').'">Häufige Fragen</a><br><br>Bitte laden Sie <a href="'.genURL('konto').'">hier Ihr Konto</a> auf und starten Sie die Buchung erneut.</div>';
}

elseif($o=="k") {

mysqli_query($db,"INSERT INTO ".$dbx."_teilnehmer (user,kurs,datum) VALUES ('".$usrd[id]."','".$kurs[id]."','".time()."')");
$anfrageid=mysqli_insert_id($db);

$teilnehmerneu = $kurs[teilnehmer]+1;
mysqli_query($db,"UPDATE ".$dbx."_kurse SET teilnehmer='".$teilnehmerneu."' WHERE id='".$kurs[id]."'");

$guthabenneu=$usrd[guthaben]-$kurs[kosten];
mysqli_query($db,"UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$usrd[id]."'");
mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,kurs,status) VALUES ('".$usrd[id]."','kurs','-".$kurs[kosten]."','".time()."','".$kurs[id]."','ok')");

$cguthabenneu=$lehrer[guthaben]+$kurs[kosten];
mysqli_query($db,"UPDATE ".$dbx."_user SET guthaben='".$cguthabenneu."' WHERE id='".$lehrer[id]."'");
mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,kurs,status) VALUES ('".$usrd[id]."','coach','".$kurs[kosten]."','".time()."','".$kurs[id]."','ok')");

mysqli_query($db,"INSERT INTO ".$dbx."_bewertungen (als, kurs, user, bewerter, datum) VALUES ('teilnehmer', '".$kurs[id]."', '".$usrd[id]."', '".$lehrer[id]."', '".time()."')");
mysqli_query($db,"INSERT INTO ".$dbx."_bewertungen (als, kurs, user, bewerter, datum) VALUES ('coach', '".$kurs[id]."', '".$lehrer[id]."', '".$usrd[id]."', '".time()."')");

$ph1=array('%vorname%','%nachname%','%kurstitel%','%coachdetails%','%kursurl%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$kurs[titel],$lehrer[vorname].' '.$lehrer[nachname].'
'.$lehrer[plz].' '.$lehrer[ort].'
'.$lehrer[email],genURL('kurs',$kurs[id]),$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_teilnehmer.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Kurs gebucht: ".$kurs[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

$ph1=array('%vorname%','%nachname%','%kurstitel%','%teilnehmerdetails%','%kursurl%','%titel%','%url%');
$ph2=array($lehrer[vorname],$lehrer[nachname],$kurs[titel],$usrd[vorname].' '.$usrd[nachname].'
'.$usrd[plz].' '.$usrd[ort].'
'.$usrd[email],genURL('kurs',$kurs[id]),$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/buchung_ok_coach.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($lehrer[email],"Kurs gebucht: ".$kurs[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


echo '<div class="alert alert-success"><b>Vielen Dank!</b> Kurs erfolgreich gebucht.</div><div>Sie erhalten eine E-Mail mit den weiteren Details.</div>';

} else {

echo '<div>Danke, dass Sie den folgenden Kurs buchen möchten. Bitte überprüfen Sie nochmal die Daten und schliessen Sie die Buchung mit Klick auf den unteren Button ab.</div><br>
<form action=index.php method=post><input type=hidden name=d value=buchen><input type=hidden name=s value='.$kurs[id].'><input type=hidden name=o value=k>
<table class="table table-striped" style="width:100%;max-width:500px">

<tr><td><b>Kurs:</b></td><td><a href="'.genURL('kurs',$kurs[id]).'">'.$kurs[titel].'</a></td></tr>
<tr><td><b>Kategorie:</b></td><td>';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
if($kurs[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo '</td></tr>
<tr><td><b>Ort:</b></td><td><img src=images/flaggen/'.$kurs[land].'.gif width=18 height=12 align=absmiddle> '.$kurs[ort].'</td></tr>
<tr><td><b>Coach:</b></td><td><img src=images/ico_user_'.$lehrer[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($lehrer[user]);
else echo $lehrer[vorname].' '.$lehrer[nachname];
echo '</a></td></tr>';

if($kurs[standort]=="vorort") {
echo '<tr><td><b>Datum:</b></td><td>';

echo '<img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag1_von])).', '.date("j.",$kurs[kurstag1_von]).' '.nr2monat(date("n",$kurs[kurstag1_von])).' '.date("Y (H:i",$kurs[kurstag1_von]).' bis '.date("H:i",$kurs[kurstag1_bis]).' Uhr)';

if($kurs[kurstag2_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag2_von])).', '.date("j.",$kurs[kurstag2_von]).' '.nr2monat(date("n",$kurs[kurstag2_von])).' '.date("Y (H:i",$kurs[kurstag2_von]).' bis '.date("H:i",$kurs[kurstag2_bis]).' Uhr)';

if($kurs[kurstag3_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag3_von])).', '.date("j.",$kurs[kurstag3_von]).' '.nr2monat(date("n",$kurs[kurstag3_von])).' '.date("Y (H:i",$kurs[kurstag3_von]).' bis '.date("H:i",$kurs[kurstag3_bis]).' Uhr)';

if($kurs[kurstag4_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag4_von])).', '.date("j.",$kurs[kurstag4_von]).' '.nr2monat(date("n",$kurs[kurstag4_von])).' '.date("Y (H:i",$kurs[kurstag4_von]).' bis '.date("H:i",$kurs[kurstag4_bis]).' Uhr)';

if($kurs[kurstag5_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag5_von])).', '.date("j.",$kurs[kurstag5_von]).' '.nr2monat(date("n",$kurs[kurstag5_von])).' '.date("Y (H:i",$kurs[kurstag5_von]).' bis '.date("H:i",$kurs[kurstag5_bis]).' Uhr)';

echo '</td></tr>';
}
else {
echo '<tr><td><b>Dauer:</b></td><td>';

if($kurs[dauer]=="0.5") echo '30 Minuten';
elseif($kurs[dauer]=="1") echo '1 Stunde';
else echo $kurs[dauer].' Stunden';

echo '</td></tr>';
}

echo '
<tr><td><b>Kosten total:</b></td><td><b>'.$kurs[kosten].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></td></tr>
<tr><td colspan=2><input type=submit value="Kurs kostenpflichtig buchen" style="width:100%;" class="btn btn-large btn-warning"></td></tr>

</table></form>';

}

}

}
else {
include("inc/login.inc.php");
}

?>