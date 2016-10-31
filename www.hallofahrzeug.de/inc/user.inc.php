<?php

$DO_TITEL="Benutzerprofil";

if($coredata['user']=="user" && $s=="" && $lg=="ok") $s=$usrd[user];
elseif($s=="" && $lg=="ok") $s=$usrd[id];

$getprofil=mysql_query("SELECT * FROM ".$dbx."_user WHERE user='".$s."' OR id='".$s."'");
$profil=mysql_fetch_array($getprofil);

if($lg!="ok" && $s=="") {
include("inc/login.inc.php");
}
elseif($s=="" || $profil[id]=="") echo '<legend>Benutzerprofil</legend><div class="alert alert-danger"><b>Ups!</b> Der User konnte nicht gefunden werden.</div>';
else {

if($coredata['user']=="user") { echo '<legend>'.ucfirst($profil[user]).'</legend>'; $DO_TITEL.=" von ".ucfirst($profil[user]); }
else { echo '<legend>'.$profil[vorname].' '.$profil[nachname].'</legend>'; $DO_TITEL.=" von ".$profil[vorname]." ".$profil[nachname]; }




echo '<ul class="nav nav-tabs">
<li class="active"><a href="#infos" data-toggle="tab"><img src="images/ico_hilfe.png" width=16 height=16 align=absmiddle border=0> Infos</a></li>
<li><a href="#fahrzeuge" data-toggle="tab"><img src="images/ico_auto.png" width=16 height=16 align=absmiddle border=0> Fahrzeuge</a></li>
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
<tr><td>Wohnort</td><td><img src=images/flaggen/'.$profil[land].'.gif width=18 height=12 align=absmiddle> <a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$fahrzeug[plz].'+'.$profil[ort].'" target=_blank>'.$profil[ort].'</a></td></tr>
<tr><td>Geschlecht</td><td>'; if($profil[geschlecht]=="m") echo 'männlich'; else echo 'weiblich'; echo '</td></tr>
';

if($profil[verifizierung]=="ok") echo '<tr><td align=right><img src=images/ico_verified.png width=43 height=40></td><td><b>Verifiziert</b><br>Identität überprüft</td></tr>';

echo '</table>
</div><div class="col-lg-4 col-sm-4 col-pull-4" style="margin-bottom:30px;">';

echo '<table class="table">

<tr><td style="border-top:0 !important;">Mitglied seit</td><td style="border-top:0 !important;">'.date("d.m.Y",$profil[datum]).'</td></tr>
';

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







echo '</div>';
echo '</div>

</div>





<div class="tab-pane fade" id="fahrzeuge" style="margin-bottom:30px;">';


$getuk = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE user='".$profil[id]."'");
$ukcounter=mysql_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Noch keine Fahrzeuge inseriert.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Fahrzeug'; else echo $ukcounter.' Fahrzeuge'; echo '</div></td></tr></thead>';

while($fahrzeug=mysql_fetch_array($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-2 col-sm-3 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;" class="bigroundcorners"><a href="'.genURL('fahrzeug',$fahrzeug[id],urlseotext($fahrzeug[titel])).'">';

if(file_exists("fotos/".$fahrzeug[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$fahrzeug[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$fahrzeug[id]."_1_t.png")==1) echo '<img src="fotos/'.$fahrzeug[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-8 col-sm-6 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('fahrzeug',$fahrzeug[id],urlseotext($fahrzeug[titel])).'">'.$fahrzeug[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($fahrzeug[art]==$fetchArt[id]) echo $fetchArt[art];
}

echo ' in <a href="'.genUrl('suchen',urlencode($fahrzeug[ort])).'">'.$fahrzeug[ort].'</a></div>
<div style="padding-bottom:5px;color:#888;">

</div>

</div>

<style>
#preisdiv{margin-left:15px;text-align:right;}
@media all and (max-width: 480px) {
#preisdiv{text-align:center;}
}
</style>
<div class="col-lg-2 col-sm-3 col-12" id="preisdiv">

<span style="font-weight:bold;font-size:22px;letter-spacing:-1px;">'.$fahrzeug[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span><br>pro Tag

</div></div></td></tr>';
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

$getBewertungen = mysql_query("SELECT * FROM ".$dbx."_bewertungen where user='".$profil[id]."' AND status='ok' ORDER BY datum DESC");

echo '<table class="table">';
while($fetchBewertung=mysql_fetch_array($getBewertungen)) {

$getbuser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$fetchBewertung[bewerter]."'");
$buser = mysql_fetch_array($getbuser);

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