<?php

if($lg=="ok") {

$DO_TITEL="Meine Aufträge";
echo '<legend>Meine Aufträge</legend>';




echo '<ul class="nav nav-tabs">
<li class="active"><a href="#auftraege" data-toggle="tab"><img src="images/ico_auftrag.png" width=16 height=16 align=absmiddle border=0> Ausgeschrieben</a></li>
<li><a href="#erhalten" data-toggle="tab"><img src="images/ico_auftrag_check.png" width=16 height=16 align=absmiddle border=0> Zuschlag erhalten</a></li>
</ul><br>

<div class="tab-content">';


echo '<div class="tab-pane fade in active" id="auftraege" style="margin-bottom:30px;">';

$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE user='".$usrd[id]."' ORDER BY datum DESC LIMIT 0,50");
$ukcounter=mysqli_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Bisher keine Aufträge ausgeschrieben.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Auftrag'; else echo $ukcounter.' Aufträge'; echo '</div></td></tr></thead>';

while($auftrag=mysqli_fetch_assoc($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-2 col-sm-3 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;" class="bigroundcorners"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">';

if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-8 col-sm-6 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">'.$auftrag[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_assoc($getArten)) {
if($auftrag[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo ' &middot; <a href="'.genUrl('suchen',urlencode($auftrag[ort])).'">'.$auftrag[ort].'</a></div>
<div style="padding-bottom:5px;color:#888;">';
if($auftrag[datum_ende]<time()) echo '<font color=#ed9035>beendet</font>';
else echo '<font color=#49d000>aktuell</font>';
echo '</div>

</div>
</div></td></tr>';
}

echo '</table>';

}

echo '</div>











<div class="tab-pane fade" id="erhalten" style="margin-bottom:30px;">';

$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE anbieter='".$usrd[id]."' ORDER BY datum DESC LIMIT 0,50");
$ukcounter=mysqli_num_rows($getuk);

if($ukcounter==0) echo '<div class="alert alert-danger">Bisher keine Aufträge erhalten.</div>';
else {

echo '<table class="table table-hover"><thead><tr><td colspan=3><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;">'; if($ukcounter==1) echo 'Ein Auftrag'; else echo $ukcounter.' Aufträge'; echo '</div></td></tr></thead>';

while($auftrag=mysqli_fetch_assoc($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-2 col-sm-3 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;" class="bigroundcorners"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">';

if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-8 col-sm-6 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">'.$auftrag[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_assoc($getArten)) {
if($auftrag[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo ' &middot; <a href="'.genUrl('suchen',urlencode($auftrag[ort])).'">'.$auftrag[ort].'</a></div>
<div style="padding-bottom:5px;color:#888;">';
echo '<img src=images/ico_check.png width=16 height=16 align=absmiddle> <font color=#49d000>Zuschlag erhalten</font>';
echo '</div>

</div>
</div></td></tr>';
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