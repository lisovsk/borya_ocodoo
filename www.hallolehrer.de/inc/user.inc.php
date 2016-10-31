<?php

$DO_TITEL="Benutzerprofil";

if($coredata['user']=="user" && $s=="" && $lg=="ok") $s=$usrd[user];
elseif($s=="" && $lg=="ok") $s=$usrd[id];

$getprofil=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE user='".$s."' OR id='".$s."'");
$profil=mysqli_fetch_assoc($getprofil);

if($lg!="ok" && $s=="") {
include("inc/login.inc.php");
}
elseif($s=="" || $profil[id]=="") echo '<legend>Benutzerprofil</legend><div class="alert alert-danger"><b>Ups!</b> Der User konnte nicht gefunden werden.</div>';
else {

if($coredata['user']=="user") { echo '<legend>'.ucfirst($profil[user]).'</legend>'; $DO_TITEL.=" von ".ucfirst($profil[user]); }
else { echo '<legend>'.$profil[vorname].' '.$profil[nachname].'</legend>'; $DO_TITEL.=" von ".$profil[vorname]." ".$profil[nachname]; }




echo '<ul class="nav nav-tabs">
<li class="active"><a href="#infos" data-toggle="tab"><img src="images/ico_hilfe.png" width=16 height=16 align=absmiddle border=0> Infos</a></li>
<li><a href="#kurse" data-toggle="tab"><img src="images/ico_kurse.png" width=16 height=16 align=absmiddle border=0> Kurse</a></li>
<li><a href="#bewertungen" data-toggle="tab"><img src="images/ico_stern.png" width=16 height=16 align=absmiddle border=0> Bewertungen</a></li>
</ul><br>';




echo '<div class="tab-content">

<div class="tab-pane fade in active" id="infos" style="margin-bottom:30px;">

<div class="row show-grid">

<style>
@media all and (min-width: 768px) {
#profilfoto{margin-top:-100px;}
}
</style>
<div class="col-lg-4 col-sm-4 col-push-8';

if(file_exists("avatar/".$profil[id]."_t.jpg")==1) echo '"><img src="avatar/'.$profil[id].'_t.jpg?'.(time()-1300000000).'"';
elseif(file_exists("avatar/".$profil[id]."_t.png")==1) echo '"><img src="avatar/'.$profil[id].'_t.png?'.(time()-1300000000).'"';
else echo ' hidden-sm"><img src="avatar/user.gif"';
echo ' width=100% style="border:1px solid #ccc;margin-bottom:30px;" id="profilfoto" class="img-circle">';


echo '</div><div class="col-lg-4 col-sm-4 col-pull-4" style="margin-bottom:30px;">';

echo '<table class="table">

<tr><td style="border-top:0 !important;">Zuletzt&nbsp;online</td><td style="border-top:0 !important;">'.calcTimeDiv($profil[online]).'</td></tr>
<tr><td>Wohnort</td><td><img src=images/flaggen/'.$profil[land].'.gif width=18 height=12 align=absmiddle> <a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$profil[plz].'+'.$profil[ort].'" target=_blank>'.$profil[ort].'</a></td></tr>
';

if($profil[verifizierung]=="ok") echo '<tr><td align=right><img src=images/ico_verified.png width=43 height=40></td><td><b>Verifiziert</b><br>Identität überprüft</td></tr>';

echo '</table>';

echo '</div><div class="col-lg-4 col-sm-4 col-pull-4" style="margin-bottom:30px;">';

echo '<table class="table">

<tr><td style="border-top:0 !important;">Mitglied seit</td><td style="border-top:0 !important;">'.date("d.m.Y",$profil[datum]).'</td></tr>';

$bewertung=round($profil[bewertung]*2)/2;

echo '<tr><td>Bewertung:</td><td>';

if($bewertung>0.9) echo '<img src=images/staron.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>1.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>1.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>2.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>2.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>3.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>3.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>4.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>4.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';

echo ' ('.$profil[anz_bewertungen].')</td></tr>

<tr><td colspan=2><img src=images/ico_nachricht.png width=16 height=16 align=absmiddle> <a href="'.genURL('nachrichten','senden',$profil[id]).'">Nachricht senden</a></td></tr>

</table>';

echo '</div>
</div>

</div>





<div class="tab-pane fade" id="kurse" style="margin-bottom:30px;">';


$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE user='".$profil[id]."' AND (standort NOT LIKE 'vorort' OR (kurstag1_von > ".time()." AND standort='vorort')) ORDER BY datum DESC");
$ukcounter=mysqli_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Derzeit keine Kursangebote.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Kursangebot'; else echo $ukcounter.' Kursangebote'; echo '</div></td></tr></thead>';

while($kurs=mysqli_fetch_assoc($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-2 col-sm-3 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;" class="bigroundcorners"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'">';

if(file_exists("fotos/".$kurs[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$kurs[id]."_1_t.png")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-8 col-sm-6 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'">'.$kurs[titel].'</a></div>

<div style="padding-top:2px;padding-bottom:1px;">';
if($kurs[standort]=="vorort") echo '<img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('kurs',urlencode($kurs[ort])).'">'.$kurs[ort].'</a>';
elseif($kurs[standort]=="skype") echo '<img src=images/ico_skype.png width=16 height=16 align=absmiddle> via Skype';
elseif($kurs[standort]=="hangouts") echo '<img src=images/ico_hangouts.png width=16 height=16 align=absmiddle> via Google Hangouts';
elseif($kurs[standort]=="telefon") echo '<img src=images/ico_telefon.png width=16 height=16 align=absmiddle> via Telefon';
echo '
</div>
<div><img src=images/ico_users.png width=16 height=16 align=absmiddle> '.$kurs[teilnehmer].' Teilnehmer bisher</div>

</div>
</div></td></tr>';
}

echo '</table>';

}

echo '</div>








<div class="tab-pane fade" id="bewertungen" style="margin-bottom:30px;">';


if($profil[anz_bewertungen]==0) echo '<div class="alert alert-danger">Noch keine Bewertungen erhalten.</div>';
else {

echo '<b>Gesamtbewertung:</b> ';

if($bewertung>0.9) echo '<img src=images/staron.png width=16 height=16>';
else echo 'keine bisher';
if($bewertung>1.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>1.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>2.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>2.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>3.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>3.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($bewertung>4.9) echo '<img src=images/staron.png width=16 height=16>';
elseif($bewertung>4.1) echo '<img src=images/starhalf.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';

echo '<br><br>';

$getBewertungen = mysqli_query($db,"SELECT * FROM ".$dbx."_bewertungen where user='".$profil[id]."' AND status='ok' ORDER BY datum DESC");

echo '<table class="table">';
while($fetchBewertung=mysqli_fetch_assoc($getBewertungen)) {

$getbuser=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$fetchBewertung[bewerter]."'");
$buser = mysqli_fetch_assoc($getbuser);

if($coredata['user']=="user") $urlUsername=$buser[user]; else $urlUsername=$buser[id];

echo '<tr><td width=100><img src="avatar/';
if(file_exists("avatar/".$buser[id]."_t.jpg")==1) echo $buser[id].'_t.jpg"';
elseif(file_exists("avatar/".$buser[id]."_t.png")==1) echo $buser[id].'_t.png"';
else echo 'user.gif"';
echo ' width=100 class="img-rounded"></td>';

echo '<td><div style="margin-bottom:5px;"><img src=images/ico_user_'.$buser[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">';
if($coredata['user']=="user") echo ucfirst($buser[user]);
else echo $buser[vorname].' '.$buser[nachname];
echo '</a> bewertete am '.date("j.n.Y",$fetchBewertung[datum]).' als ';
if($fetchBewertung[als]=="gast") echo 'Gast'; else echo 'Gastgeber';
echo ': ';

if($fetchBewertung[bewertung]>0.9) echo '<img src=images/staron.png width=16 height=16>';
else echo 'keine bisher';
if($fetchBewertung[bewertung]>1.9) echo '<img src=images/staron.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($fetchBewertung[bewertung]>2.9) echo '<img src=images/staron.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($fetchBewertung[bewertung]>3.9) echo '<img src=images/staron.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';
if($fetchBewertung[bewertung]>4.9) echo '<img src=images/staron.png width=16 height=16>';
else echo '<img src=images/staroff.png width=16 height=16>';

echo '</div>
<div style="border-top:0px solid #ccc;padding:5px;padding-left:0px;height:75px;overflow:auto;">'.$fetchBewertung[cont].'</div>
';


}
echo '</table>';

}

echo '</div>


</div>';


}

?>