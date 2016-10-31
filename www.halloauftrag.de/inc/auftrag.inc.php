<?php

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE id='".$s."' AND status='ok'");
$auftrag = mysqli_fetch_array($getauftrag);

if($auftrag[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Eintrag konnte nicht gefunden werden.</div>';
else {

$getauftraggeber=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$auftrag[user]."'");
$auftraggeber = mysqli_fetch_array($getauftraggeber);

$DO_TITEL=$auftrag[titel];
echo '<legend>'.$auftrag[titel].'</legend>';


if($usrd[rechte]=="adm" || $usrd[rechte]=="mod") echo '<div style="margin-top:-10px;margin-bottom:20px;">
<img src="images/ico_write.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&edit='.$auftrag[id].'">Bearbeiten</a>&nbsp;
<img src="images/ico_delete.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&del='.$auftrag[id].'">Löschen</a>
</div>';



echo '<div class="row">
<div class="col-lg-8 col-sm-8">';



if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_1_b.jpg"><img src="fotos/'.$auftrag[id].'_1_t.jpg"></a>';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_1_b.png"><img src="fotos/'.$auftrag[id].'_1_t.png"></a>';
if(file_exists("fotos/".$auftrag[id]."_2_t.jpg")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_2_b.jpg"><img src="fotos/'.$auftrag[id].'_2_t.jpg"></a>';
elseif(file_exists("fotos/".$auftrag[id]."_2_t.png")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_2_b.png"><img src="fotos/'.$auftrag[id].'_2_t.png"></a>';
if(file_exists("fotos/".$auftrag[id]."_3_t.jpg")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_3_b.jpg"><img src="fotos/'.$auftrag[id].'_3_t.jpg"></a>';
elseif(file_exists("fotos/".$auftrag[id]."_3_t.png")==1) $afotos .= '<a href="fotos/'.$auftrag[id].'_3_b.png"><img src="fotos/'.$auftrag[id].'_3_t.png"></a>';


if($afotos!="") echo '<style>
#galleria{height:480px;background-color:#eee;}
@media all and (max-width: 480px) {
#galleria{height:250px;}
}
</style>
<div id="galleria" class=smallroundcorners>'.$afotos.'</div>
<script>
Galleria.loadTheme(\'javascript/galleria.classic.min.js\');
Galleria.run(\'#galleria\', {
    autoplay: 3000,
    transition: \'fadeslide\'
});
</script><br>';






?>
<div style="padding:5px;"><?php echo forum_wrap($auftrag[cont],100); ?><br><br><br></div>
<?php




echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Angebote</b></div><div style="padding:5px;">';

$getAngebote = mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE auftrag='".$auftrag[id]."' ORDER BY gewaehlt DESC, datum DESC");
$anzAngebote = mysqli_num_rows($getAngebote);

if($auftrag[datum_ende] < time() && $anzAngebote!=0 && $usrd[id]==$auftrag[user] && $anzAngebote!=0 && $auftrag[angebot]=="0") echo '<div class="alert alert-info">Die Angebotsphase ist beendet. &nbsp; <img src=images/ico_support.png width=16 height=16 align=absmiddle><a href="'.genURL('auswahl',$auftrag[id]).'">Jetzt Angebot auswählen.</a></div>';
elseif($auftrag[datum_ende] < time() && $auftrag[angebot]=="0") echo '<div class="alert alert-info">Die Angebotsphase ist beendet.</div>';
elseif($auftrag[datum_ende] > time()) echo '<div class="alert alert-info">Haben Sie Interesse, diesen Auftrag auszufüren? &nbsp; <img src=images/ico_starten.png width=16 height=16 align=absmiddle><a href="'.genURL('bieten',$auftrag[id]).'">Jetzt Angebot abgeben.</a></div>';

if($anzAngebote==0) echo '<div class="alert alert-danger">Bisher noch keine Angebote abgegeben.</div>';
else {
echo '<table class="table"><thead><tr><th>Anbieter</th><th>Datum</th><th>Angebot</th></tr></thead><tbody>';

while($angebot = mysqli_fetch_array($getAngebote)) {
$getbieter=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$angebot[user]."'");
$bieter = mysqli_fetch_array($getbieter);
if($coredata['user']=="user") $urlUsername=$bieter[user]; else $urlUsername=$bieter[id];

echo '<tr'; if($auftrag[angebot]==$angebot[id]) echo ' bgcolor=#c2ffa0'; echo '><td><img src=images/ico_user_'.$bieter[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'"><b>';
if($coredata['user']=="user") echo ucfirst($bieter[user]);
else echo $bieter[vorname].' '.$bieter[nachname];
echo '</b></a></td><td>'.date("j.n.Y, H:i",$angebot[datum]).' Uhr</td><td>'; if($auftrag[angebot]!="0" && $auftrag[angebot]!=$angebot[id]) echo '<s>'; echo $angebot[betrag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; if($auftrag[angebot]==$angebot[id]) echo ' <img src=images/ico_check.png width=16 height=16 align=absmiddle>'; echo '</s></td></tr>';



}

echo '</tbody></table>';
}

echo '</div></div>';














echo '<div class="col-lg-4 col-sm-4">';





echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Standort</b></div>

<div style="margin-bottom:30px;">

<div style="margin-bottom:5px;"><a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$auftrag[plz].'+'.$auftrag[ort].'" target=_blank><img src="http://maps.googleapis.com/maps/api/staticmap?center='.urlseotext($auftrag[plz]).'+'.urlseotext($auftrag[ort]).'&zoom=10&size=300x280&sensor=false&markers=icon:http://'.$coredata[url].'/images/map_marker.png%7C'.urlseotext($auftrag[plz]).'+'.urlseotext($auftrag[ort]).'" class="img-rounded" style="width:100%;" border=0></a></div>
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img src=images/ico_map.png width=16 height=16 align=absmiddle> <a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$auftrag[plz].'+'.$auftrag[ort].'" target=_blank>Bei Google Maps anzeigen</a></td></tr>
<tr><td colspan=2 class=lead>'.$auftrag[plz].' '.$auftrag[ort].'</td></tr>

</table>
</div>';






if($coredata['user']=="user") $urlUsername=$auftraggeber[user]; else $urlUsername=$auftraggeber[id];

echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Auftraggeber</b></div>

<div style="margin-bottom:30px;">
<div style="margin-bottom:5px;"><a href="'.genURL('user',$urlUsername).'"><img src="avatar/';
if(file_exists("avatar/".$auftrag[user]."_t.jpg")==1) echo $auftrag[user].'_t.jpg';
elseif(file_exists("avatar/".$auftrag[user]."_t.png")==1) echo $auftrag[user].'_t.png';
else echo 'user.gif';
echo '" class="img-rounded" style="width:100%;" border=0></a></div>
<div style="margin:5px;" class=lead><img src=images/ico_user_'.$auftraggeber[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'"><b>';
if($coredata['user']=="user") echo ucfirst($auftraggeber[user]);
else echo $auftraggeber[vorname].' '.$auftraggeber[nachname];
echo '</b></a></div>
<table class="table">';

if($auftraggeber[verifizierung]=="ok") echo '<tr><td><img src=images/ico_verified.png width=16 height=16 align=absmiddle> <b>Verifiziert</b></td><td>(Identität überprüft)</td></tr>';

echo '
<tr><td>';

$bewertung=round($auftraggeber[bewertung]*2)/2;

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

echo '</td><td>(';

if($auftraggeber[anz_bewertungen]==0) echo 'keine Bewertungen';
elseif($auftraggeber[anz_bewertungen]==1) echo '<a href="'.genURL('user',$urlUsername).'">1 Bewertung</a>';
else echo '<a href="'.genURL('user',$urlUsername).'">'.$auftraggeber[anz_bewertungen].' Bewertungen</a>';

echo ')</td></tr>
<tr><td>Wohnort:</td><td><img src=images/flaggen/'.$auftraggeber[land].'.gif width=18 height=12 align=absmiddle> '.$auftraggeber[ort].'</td></tr>
<tr><td colspan=2><img src=images/ico_faq2.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">Mehr über den Auftraggeber</a></td></tr>
<tr><td colspan=2><img src=images/ico_nachricht.png width=16 height=16 align=absmiddle> <a href="'.genURL('nachrichten','senden',$auftraggeber[id]).'">Nachricht senden</a></td></tr>

</table>
</div>';






echo '<div style="padding:5px;background-color:#eee;margin-bottom:1px;" class=smallroundcorners><b>Auftrag weiterempfehlen</b></div>

<div style="margin-bottom:30px;">
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img width=16 height=16 align=absmiddle src=images/ico_facebook.png> <a href="http://www.facebook.com/sharer.php?u='.urlencode(genURL('auftrag',$auftrag[id])).'&t='.urlencode(utf8_encode($auftrag[titel])).'" target=_blank>Bei Facebook teilen</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_twitter.png> <a href="https://twitter.com/intent/tweet?text='.urlencode(utf8_encode($auftrag[titel].' - '.genURL('auftrag',$auftrag[id]))).'" target=_blank>Bei Twitter posten</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_googleplus.png> <a href="https://plus.google.com/share?url='.rawurlencode(genURL('auftrag',$auftrag[id])).'" target=_blank>Bei Google+ teilen</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_nachricht.png> <a href="mailto:?subject=Auftrag bei '.$coredata[titel].'&body='.$auftrag[titel].'%0A'.genURL('auftrag',$auftrag[id]).'">Per E-Mail weiterleiten</a></td></tr>

</table>
</div>';






echo '</div>';

}

?>