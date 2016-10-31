<?php

if($lg=="ok") {

echo '<legend>Bewertungen</legend>';

$bid=htmlspecialchars(stripslashes($_POST[bid]));
$bewertung=htmlspecialchars(stripslashes($_POST[bewertung]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));

$getBewertungen = mysqli_query($db,"SELECT * FROM ".$dbx."_bewertungen WHERE bewerter='".$usrd[id]."' AND status='' ORDER BY datum DESC");
if(mysqli_num_rows($getBewertungen)==0) echo '<div class="alert alert-danger">Es sind keine Bewertungen offen.</div>';
elseif($bid!="") {

$getBid = mysqli_query($db,"SELECT * FROM ".$dbx."_bewertungen WHERE id='".$bid."'");
$fetchBid = mysqli_fetch_array($getBid);

$getbuser=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$fetchBid[user]."'");
$buser = mysqli_fetch_array($getbuser);

$getBids = mysqli_query($db,"SELECT * FROM ".$dbx."_bewertungen WHERE user='".$buser[id]."' AND status='ok'");
$bids = mysqli_num_rows($getBids);
$neubids = $bids + 1;

if($bids==0) $calcBewertung = $bewertung;
else $calcBewertung = (($buser[bewertung] / $bids) + $bewertung) / $neubids;

if($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte einen Bewertungskommentar angeben.</div>';
elseif($fetchBid[status]=="" && $fetchBid[bewerter]==$usrd[id]) {

mysqli_query($db,"UPDATE ".$dbx."_bewertungen SET bewertung='".$bewertung."', cont='".addslashes($cont)."', status='ok', datum='".time()."' WHERE id='".$fetchBid[id]."'");
mysqli_query($db,"UPDATE ".$dbx."_user SET bewertung='".$calcBewertung."', anz_bewertungen='".$neubids."' WHERE id='".$fetchBid[user]."'");

echo '<div class="alert alert-success"><b>Danke!</b> Bewertung gespeichert.</div>';

}



}
else {

while($fetchBewertung=mysqli_fetch_array($getBewertungen)) {

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE id='".$fetchBewertung[auftrag]."'");
$auftrag = mysqli_fetch_array($getauftrag);

$getbuser=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$fetchBewertung[user]."'");
$buser = mysqli_fetch_array($getbuser);

if($buser[id]!="" && $auftrag[status]=="ok") {

if($coredata['user']=="user") $urlUsername=$buser[user]; else $urlUsername=$buser[id];

echo '<form action=index.php method=post class=form-horizontal accept-charset="UTF-8"><input type=hidden name=d value=bewertung><input type=hidden name=bid value="'.$fetchBewertung[id].'">

<table class="table table-striped" style="width:100%;max-width:500px">

<thead><tr><td colspan=2><b>Bewertung für <img src=images/ico_user_'.$buser[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($buser[user]);
else echo $buser[vorname].' '.$buser[nachname];
echo '</a></b></td></tr></thead>

<tr><td>Auftrag:</td><td><a href="'.genURL('auftrag',$auftrag[id]).'">'.$auftrag[titel].'</a></td></tr>

<tr><td>Bewertung:</td><td><select name=bewertung>
<option value=1>1 Stern (Sehr schlecht)</option>
<option value=2>2 Sterne (Schlecht)</option>
<option value=3>3 Sterne (Mittelmässig)</option>
<option value=4 selected>4 Sterne (Gut)</option>
<option value=5>5 Sterne (Perfekt)</option>
</select></td></tr>

<tr><td>Kommentar:</td><td><textarea name=cont class=form-control style="height:70px"></textarea></td></tr>

<tr><td>&nbsp;</td><td><input type=submit value="Bewertung abgeben" class="btn btn-default"></td></tr>

</table>

</form>';



}
}
}




}
else {
include("inc/login.inc.php");
}

?>