<?php

if($lg=="ok") {

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE id='".$s."' AND status='ok'");
$auftrag = mysqli_fetch_array($getauftrag);

$gangebot=trim(htmlspecialchars(stripslashes($_POST[gangebot])));

if($auftrag[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Eintrag konnte nicht gefunden werden.</div>';
else {

$DO_TITEL='Angebot auswählen';
echo '<legend>Angebot auswählen</legend>';

$getAngebote = mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE auftrag='".$auftrag[id]."'");
$anzAngebote = mysqli_num_rows($getAngebote);

if($auftrag[user] != $usrd[id]) echo '<div class="alert alert-danger"><b>Ups!</b> Sie sind nicht als Auftragsgeber eingeloggt.</div>';
elseif($auftrag[datum_ende]>time()) echo '<div class="alert alert-danger"><b>Ups!</b> Die Angebotsphase für diesen Auftrag ist noch nicht beendet.</div>';
elseif($anzAngebote==0) echo '<div class="alert alert-danger"><b>Ups!</b> Leider wurden keine Angebote abgegeben.</div>';
elseif($auftrag[angebot]!="0" && $auftrag[angebot]!="") echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben diesen Auftrag bereits vergeben.</div>';
elseif($gangebot!="") {

$getangebot=mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE id='".$gangebot."'");
$dasangebot = mysqli_fetch_array($getangebot);

$getanbieter=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$dasangebot[user]."'");
$anbieter = mysqli_fetch_array($getanbieter);

mysqli_query($db,"INSERT INTO ".$dbx."_bewertungen (als, auftrag, user, bewerter, datum) VALUES ('auftraggeber', '".$auftrag[id]."', '".$usrd[id]."', '".$anbieter[id]."', '".time()."')");
mysqli_query($db,"INSERT INTO ".$dbx."_bewertungen (als, auftrag, user, bewerter, datum) VALUES ('auftragnehmer', '".$auftrag[id]."', '".$anbieter[id]."', '".$usrd[id]."', '".time()."')");

mysqli_query($db,"UPDATE ".$dbx."_auftraege SET angebot='".$dasangebot[id]."', anbieter='".$anbieter[id]."' WHERE id='".$auftrag[id]."'");
mysqli_query($db,"UPDATE ".$dbx."_angebote SET gewaehlt='1' WHERE id='".$dasangebot[id]."'");



$auftragurl=genURL('auftrag',$auftrag[id]);



$ph1=array('%vorname%','%nachname%','%auftraggeberdetails%','%auftragtitel%','%auftragurl%','%titel%','%url%');
$ph2=array($anbieter[vorname],$anbieter[nachname],$usrd[vorname].' '.$usrd[nachname].'
'.$usrd[plz].' '.$usrd[ort].'

'.$usrd[email],$auftrag[titel],$auftragurl,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/auftrag_ok_auftragnehmer.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($anbieter[email],"Glückwunsch! Sie haben einen Auftrag erhalten: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


$ph1=array('%vorname%','%nachname%','%auftragnehmerdetails%','%auftragtitel%','%auftragurl%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$anbieter[vorname].' '.$anbieter[nachname].'
'.$anbieter[plz].' '.$anbieter[ort].'

'.$anbieter[email],$auftrag[titel],$auftragurl,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/auftrag_ok_auftraggeber.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Auftrag vergeben: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


echo '<div class="alert alert-success"><b>Super!</b> Ihr Auftrag wurde erfolgreich vergeben.</div><br>Bitte kontaktieren Sie den Auftragnehmer für weitere Details:<br><br>';
if($anbieter[firma]!="") echo $anbieter[firma].'<br>';
echo $anbieter[vorname].' '.$anbieter[nachname].'<br>'.$anbieter[plz].' '.$anbieter[ort].'<br><br>';
echo '<a href="mailto:'.$anbieter[email].'">'.$anbieter[email].'</a>';









}
else {




echo 'Welchem Anbieter möchten Sie den Auftrag vergeben?<br><br><div style="margin:10px"><div class="row hidden-sm">
<div class="col-md-3 col-lg-3" style="padding:5px;">Anbieter</div>
<div class="col-md-3 col-lg-3" style="padding:5px;">Datum</div>
<div class="col-md-3 col-lg-3" style="padding:5px;">Angebot</div>
</div>';

while($angebot = mysqli_fetch_array($getAngebote)) {
$getbieter=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$angebot[user]."'");
$bieter = mysqli_fetch_array($getbieter);
if($coredata['user']=="user") $urlUsername=$bieter[user]; else $urlUsername=$bieter[id];

echo '<div class="row" style="border-top:1px solid #ccc;">
<div class="col-md-3 col-lg-3" style="padding:5px;"><img src=images/ico_user_'.$bieter[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'"><b>';
if($coredata['user']=="user") echo ucfirst($bieter[user]);
else echo $bieter[vorname].' '.$bieter[nachname];
echo '</b></a></div>
<div class="col-md-3 col-lg-3" style="padding:5px;">'.date("j.n.Y, H:i",$angebot[datum]).' Uhr</div>
<div class="col-md-3 col-lg-3" style="padding:5px;"><b><big>'.$angebot[betrag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</big></b></div>
<div class="col-md-3 col-lg-3" style="padding:5px;"><form action=index.php method=post class=form-horizontal><input type=hidden name=d value=auswahl><input type=hidden name=s value='.$auftrag[id].'><input type=hidden name=gangebot value='.$angebot[id].'><input type=submit value="Auswählen" class="btn btn-default"></form></div>
</div>';

}
echo '</div>';



}

}

}
else {
include("inc/login.inc.php");
}

?>