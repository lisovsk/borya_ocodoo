<?php

if($lg=="ok") {

$DO_TITEL="Meine Kurse";
echo '<legend>Meine Kurse</legend>';




echo '<ul class="nav nav-tabs">
<li class="active"><a href="#meine" data-toggle="tab"><img src="images/menu_suchen.png" width=16 height=16 align=absmiddle border=0> Als Coach</a></li>
<li><a href="#gebucht" data-toggle="tab"><img src="images/menu_warenkorb.png" width=16 height=16 align=absmiddle border=0> Gebuchte Kurse</a></li>
</ul><br>

<div class="tab-content">';


echo '<div class="tab-pane fade in active" id="meine" style="margin-bottom:30px;">';

$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE user='".$usrd[id]."' ORDER BY datum DESC LIMIT 0,50");
$ukcounter=mysqli_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Sie bieten derzeit keine Kurse an.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Kurs'; else echo $ukcounter.' Kurse'; echo '</div></td></tr></thead>';

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

<div style="padding-bottom:5px;color:#888;"><div style="padding-top:2px;padding-bottom:1px;">';
if($kurs[standort]=="vorort") echo '<img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('kurs',urlencode($kurs[ort])).'">'.$kurs[ort].'</a>';
elseif($kurs[standort]=="skype") echo '<img src=images/ico_skype.png width=16 height=16 align=absmiddle> via Skype';
elseif($kurs[standort]=="hangouts") echo '<img src=images/ico_hangouts.png width=16 height=16 align=absmiddle> via Google Hangouts';
elseif($kurs[standort]=="telefon") echo '<img src=images/ico_telefon.png width=16 height=16 align=absmiddle> via Telefon';
echo '
</div></div>

</div>
</div></td></tr>';
}

echo '</table>';

}

echo '</div>











<div class="tab-pane fade" id="gebucht" style="margin-bottom:30px;">';

$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_teilnehmer WHERE user='".$usrd[id]."' ORDER BY datum DESC LIMIT 0,50");
$ukcounter=mysqli_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Bisher keine Kurse gebucht oder daran teilgenommen.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Kurs'; else echo $ukcounter.' Kurse'; echo '</div></td></tr></thead>';

while($teilnahme=mysqli_fetch_assoc($getuk)) {

$getkurs = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE id='".$teilnahme[kurs]."'");
$kurs=mysqli_fetch_assoc($getkurs);

if($kurs[id]=="") echo '';
else {

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

<div style="padding-bottom:5px;color:#888;"><div style="padding-top:2px;padding-bottom:1px;">';
if($kurs[standort]=="vorort") echo '<img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('kurs',urlencode($kurs[ort])).'">'.$kurs[ort].'</a>';
elseif($kurs[standort]=="skype") echo '<img src=images/ico_skype.png width=16 height=16 align=absmiddle> via Skype';
elseif($kurs[standort]=="hangouts") echo '<img src=images/ico_hangouts.png width=16 height=16 align=absmiddle> via Google Hangouts';
elseif($kurs[standort]=="telefon") echo '<img src=images/ico_telefon.png width=16 height=16 align=absmiddle> via Telefon';
echo '
</div></div>

</div>
</div></td></tr>';
}

}

echo '</table>';

}

echo '</div>

</div>';




}
else {
include("inc/login.inc.php");
}

?>