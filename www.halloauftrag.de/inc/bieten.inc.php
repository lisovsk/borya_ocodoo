<?php

if($lg=="ok") {

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE id='".$s."' AND status='ok'");
$auftrag = mysqli_fetch_array($getauftrag);

$betrag=trim(htmlspecialchars(stripslashes($_POST[betrag])));

if($auftrag[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Eintrag konnte nicht gefunden werden.</div>';
else {

$DO_TITEL='Angebot abgeben';
echo '<legend>Angebot abgeben</legend>';


$getAngebote = mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE user='".$usrd[id]."' AND auftrag='".$auftrag[id]."'");
$anzAngebote = mysqli_num_rows($getAngebote);

if($usrd[guthaben]<$coredata['gebuehr'] && $usrd[flatrate]<time()) {
echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben nicht genügend Guthaben.</div><div>Die Abgabe eines Angebots kostet jeweils <b>'.number_format($coredata['gebuehr'],2,",",".").' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b>, möglich ist auch eine Flatrate zum monatlichen Pauschalpreis.<br>Bitte laden Sie <a href="'.genURL('konto').'">hier Ihr Konto</a> auf oder buchen Sie eine <a href="'.genURL('konto').'">Flatrate</a>.</div>';
}
elseif($anzAngebote!=0) echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben für diesen Auftrag bereits ein Angebot abgegeben.</div>';
elseif($auftrag[datum_ende]<time()) echo '<div class="alert alert-danger"><b>Ups!</b> Die Angebotsphase für diesen Auftrag ist bereits abgelaufen.</div>';
elseif($auftrag[user]==$usrd[id]) echo '<div class="alert alert-danger"><b>Ups!</b> Sie können nicht auf Ihren eigenen Auftrag bieten.</div>';
elseif($o=="k" && is_numeric($betrag) && $betrag>0 && $betrag<99999) {

mysqli_query($db,"INSERT INTO ".$dbx."_angebote (auftrag,user,betrag,datum) VALUES ('".$auftrag[id]."','".$usrd[id]."','".$betrag."','".time()."')");

$neuguthaben=$usrd[guthaben]-$coredata['gebuehr'];
mysqli_query($db,"UPDATE ".$dbx."_user SET guthaben='".$neuguthaben."' WHERE id='".$usrd[id]."'");

echo '<div class="alert alert-success"><b>Super!</b> Ihr Angebot wurde erfolgreich abgegeben.</div>';

}
else {

echo '<div><table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td valign=top width=60><div style="overflow:hidden;height:60px;width:60px;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:60px;width:60px;" class=bigroundcorners><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">';
if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.jpg" width=60 height=60 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.png" width=60 height=60 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=60 height=60 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding-left:5px;"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'"><b>'.$auftrag[titel].'</b></a></div>
';

echo '<div style="padding-left:5px;">
<div style="padding-top:2px;padding-bottom:1px;"><img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('suchen',urlencode($auftrag[ort])).'">'.$auftrag[ort].'</a></div>
</div>';

echo '</td></tr></table></div><br>';

if($usrd[flatrate]<time()) echo 'Die Abgabe des Angebots kostet <b>'.number_format($coredata['gebuehr'],2,",",".").' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> und wird automatisch Ihrem <a href="'.genURL('konto').'">Guthabenkonto</a> abgebucht.<br><br>';

if($betrag!="") echo '<div class="alert alert-danger"><b>Ups!</b> Der Betrag ist nicht gültig.</div>';

echo '<form action=index.php method=post class=form-horizontal><input type=hidden name=d value=bieten><input type=hidden name=s value='.$auftrag[id].'><input type=hidden name=o value=k>

<b>Ihr Angebot:</b> <input type=text id=betrag name=betrag value="'.$betrag.'" style="width:80px;"><b><big>,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</big></b><br><br>

<input type=submit value="Angebot senden" class="btn btn-default">





</form>';



}

}

}
else {
include("inc/login.inc.php");
}

?>