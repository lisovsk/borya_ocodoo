<?php

$getkurs = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE id='".$s."'");
$kurs = mysqli_fetch_array($getkurs);

if($kurs[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Eintrag konnte nicht gefunden werden.</div>';
else {

$getlehrer=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$kurs[user]."'");
$lehrer = mysqli_fetch_array($getlehrer);

$DO_TITEL=$kurs[titel];
echo '<legend>'.$kurs[titel].'</legend>';


if($kurs[user]==$usrd[id] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") echo '<div style="margin-top:-10px;margin-bottom:20px;">
<img src="images/ico_write.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&edit='.$kurs[id].'">Bearbeiten</a>&nbsp;
<img src="images/ico_delete.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&del='.$kurs[id].'">Löschen</a>
</div>';



echo '<div class="row">
<div class="col-lg-8 col-sm-8">';



if(file_exists("fotos/".$kurs[id]."_1_t.jpg")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_1_b.jpg"><img src="fotos/'.$kurs[id].'_1_t.jpg"></a>';
elseif(file_exists("fotos/".$kurs[id]."_1_t.png")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_1_b.png"><img src="fotos/'.$kurs[id].'_1_t.png"></a>';
if(file_exists("fotos/".$kurs[id]."_2_t.jpg")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_2_b.jpg"><img src="fotos/'.$kurs[id].'_2_t.jpg"></a>';
elseif(file_exists("fotos/".$kurs[id]."_2_t.png")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_2_b.png"><img src="fotos/'.$kurs[id].'_2_t.png"></a>';
if(file_exists("fotos/".$kurs[id]."_3_t.jpg")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_3_b.jpg"><img src="fotos/'.$kurs[id].'_3_t.jpg"></a>';
elseif(file_exists("fotos/".$kurs[id]."_3_t.png")==1) $afotos .= '<a href="fotos/'.$kurs[id].'_3_b.png"><img src="fotos/'.$kurs[id].'_3_t.png"></a>';


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
<div style="margin-bottom:30px;padding:5px;">
<?php echo forum_wrap($kurs[cont],100); ?>
</div>
<?php



echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Level</b></div>
<div style="margin-bottom:30px;padding:5px;">';
if($kurs[level]=="anf") echo 'Anfänger';
elseif($kurs[level]=="ftg") echo 'Fortgeschritten';
elseif($kurs[level]=="prf") echo 'Profi';

echo '</div>';







if($kurs[standort]=="vorort") {
echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Datum</b></div>
<div style="margin-bottom:30px;padding:5px;">';

echo '<img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag1_von])).', '.date("j.",$kurs[kurstag1_von]).' '.nr2monat(date("n",$kurs[kurstag1_von])).' '.date("Y (H:i",$kurs[kurstag1_von]).' bis '.date("H:i",$kurs[kurstag1_bis]).' Uhr)';

if($kurs[kurstag2_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag2_von])).', '.date("j.",$kurs[kurstag2_von]).' '.nr2monat(date("n",$kurs[kurstag2_von])).' '.date("Y (H:i",$kurs[kurstag2_von]).' bis '.date("H:i",$kurs[kurstag2_bis]).' Uhr)';

if($kurs[kurstag3_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag3_von])).', '.date("j.",$kurs[kurstag3_von]).' '.nr2monat(date("n",$kurs[kurstag3_von])).' '.date("Y (H:i",$kurs[kurstag3_von]).' bis '.date("H:i",$kurs[kurstag3_bis]).' Uhr)';

if($kurs[kurstag4_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag4_von])).', '.date("j.",$kurs[kurstag4_von]).' '.nr2monat(date("n",$kurs[kurstag4_von])).' '.date("Y (H:i",$kurs[kurstag4_von]).' bis '.date("H:i",$kurs[kurstag4_bis]).' Uhr)';

if($kurs[kurstag5_von]!="0") echo '<br><img src=images/ico_datum.png width=16 height=16 align=absmiddle> '.nr2wochentag(date("w",$kurs[kurstag5_von])).', '.date("j.",$kurs[kurstag5_von]).' '.nr2monat(date("n",$kurs[kurstag5_von])).' '.date("Y (H:i",$kurs[kurstag5_von]).' bis '.date("H:i",$kurs[kurstag5_bis]).' Uhr)';

echo '</div>';
}

else {
echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Dauer</b></div>
<div style="margin-bottom:30px;padding:5px;">';

if($kurs[dauer]=="0.5") echo '30 Minuten';
elseif($kurs[dauer]=="1") echo '1 Stunde';
else echo $kurs[dauer].' Stunden';

echo '</div>';
}










echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Teilnehmer</b></div>
<div style="margin-bottom:30px;padding:5px;">';

echo $kurs[teilnehmer].' Teilnehmer bisher';

if($kurs[standort]=="vorort") {
echo '<br><br>Kurs findet ab '.$kurs[teilnehmer_ab].' Teilnehmern statt.<br>Maximal '.$kurs[teilnehmer_bis].' Teilnehmer';
}

echo '</div>






</div><div class="col-lg-4 col-sm-4">';



echo '<div style="margin-bottom:35px;"><form action=index.php method=post><input type=hidden name=d value=buchen><input type=hidden name=s value='.$kurs[id].'>

<div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px">

<div class="col-5" style="padding-top:7px !important;"><b>Kosten:</b></div>
<div class="col-7 smallroundcorners" style="padding:0px !important;margin-top:-4px;background-color:#e5e5e5;"><center><span style="font-weight:bold;font-size:30px;letter-spacing:-1px;">'.$kurs[kosten].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span></center></div>

</div>

<div style="padding-top:5px;"><input type=submit value="Jetzt Kurs buchen!" style="width:100%;background-color:#09b0e8;color:white;" class="btn btn-large"></div>

</form></div>';






if($coredata['user']=="user") $urlUsername=$lehrer[user]; else $urlUsername=$lehrer[id];

echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Coach dieses Kurses</b></div>

<div style="margin-bottom:30px;">
<div style="margin-bottom:5px;"><a href="'.genURL('user',$urlUsername).'"><img src="avatar/';
if(file_exists("avatar/".$lehrer[id]."_t.jpg")==1) echo $lehrer[id].'_t.jpg';
elseif(file_exists("avatar/".$lehrer[id]."_t.png")==1) echo $lehrer[id].'_t.png';
else echo 'user.gif';
echo '" class="img-rounded" style="width:100%;" border=0></a></div>
<div style="margin:5px;" class=lead><img src=images/ico_user_'.$lehrer[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'"><b>';
if($coredata['user']=="user") echo ucfirst($lehrer[user]);
else echo $lehrer[vorname].' '.$lehrer[nachname];
echo '</b></a></div>
<table class="table">';

if($lehrer[verifizierung]=="ok") echo '<tr><td><img src=images/ico_verified.png width=16 height=16 align=absmiddle> <b>Verifiziert</b></td><td>(Identität überprüft)</td></tr>';

echo '
<tr><td>';

$bewertung=round($lehrer[bewertung]*2)/2;

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

if($lehrer[anz_bewertungen]==0) echo 'keine Bewertungen';
elseif($lehrer[anz_bewertungen]==1) echo '<a href="'.genURL('user',$urlUsername).'">1 Bewertung</a>';
else echo '<a href="'.genURL('user',$urlUsername).'">'.$lehrer[anz_bewertungen].' Bewertungen</a>';

echo ')</td></tr>
<tr><td>Wohnort:</td><td><img src=images/flaggen/'.$lehrer[land].'.gif width=18 height=12 align=absmiddle> '.$lehrer[ort].'</td></tr>
<tr><td colspan=2><img src=images/ico_faq2.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">Mehr über den Coach</a></td></tr>
<tr><td colspan=2><img src=images/ico_nachricht.png width=16 height=16 align=absmiddle> <a href="'.genURL('nachrichten','senden',$lehrer[id]).'">Nachricht senden</a></td></tr>

</table>
</div>';




if($kurs[standort]=="vorort") {
echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Standort</b></div>
<div style="margin-bottom:30px;">

<div style="margin-bottom:5px;"><a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$kurs[plz].'+'.$kurs[ort].'" target=_blank><img src="http://maps.googleapis.com/maps/api/staticmap?center='.urlseotext($kurs[plz]).'+'.urlseotext($kurs[ort]).'&zoom=10&size=300x280&sensor=false&markers=icon:http://'.$coredata[url].'/images/map_marker.png%7C'.urlseotext($kurs[plz]).'+'.urlseotext($kurs[ort]).'" class="img-rounded" style="width:100%;" border=0></a></div>
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img src=images/ico_map.png width=16 height=16 align=absmiddle> <a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$kurs[plz].'+'.$kurs[ort].'" target=_blank>Bei Google Maps anzeigen</a></td></tr>
<tr><td colspan=2 class=lead>'.$kurs[plz].' '.$kurs[ort].'</td></tr>

</table>
</div>';
}
else {
echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Kursdurchführung</b></div>
<div style="margin-bottom:30px;">
<table class="table">
<tr><td colspan=2 style="border-top:0 !important;">';

if($kurs[standort]=="skype") echo '<img src=images/ico_skype.png width=20 height=20 align=absmiddle> Via Skype';
elseif($kurs[standort]=="hangouts") echo '<img src=images/ico_hangouts.png width=20 height=20 align=absmiddle> Via Google Hangouts';
elseif($kurs[standort]=="telefon") echo '<img src=images/ico_telefon.png width=20 height=20 align=absmiddle> Via Telefon';

echo '</td></tr><tr><td colspan=2>
<img src=images/space.gif width=4 height=16 align=absmiddle><img src=images/ico_check.png width=16 height=16 align=absmiddle> Ortsunabhängig<br>
<img src=images/space.gif width=4 height=16 align=absmiddle><img src=images/ico_check.png width=16 height=16 align=absmiddle> Zeitpunkt individuell vereinbar</td></tr>
</table>
</div>';
}






echo '<div style="padding:5px;background-color:#eee;margin-bottom:1px;" class=smallroundcorners><b>Kurs weiterempfehlen</b></div>

<div style="margin-bottom:30px;">
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img width=20 height=20 align=absmiddle src=images/ico_facebook.png> <a href="http://www.facebook.com/sharer.php?u='.urlencode(genURL('kurs',$kurs[id])).'&t='.urlencode(utf8_encode($kurs[titel])).'" target=_blank>Bei Facebook teilen</a></td></tr>

<tr><td colspan=2><img width=20 height=20 align=absmiddle src=images/ico_twitter.png> <a href="https://twitter.com/intent/tweet?text='.urlencode(utf8_encode($kurs[titel].' - '.genURL('kurs',$kurs[id]))).'" target=_blank>Bei Twitter posten</a></td></tr>

<tr><td colspan=2><img width=20 height=20 align=absmiddle src=images/ico_googleplus.png> <a href="https://plus.google.com/share?url='.rawurlencode(genURL('kurs',$kurs[id])).'" target=_blank>Bei Google+ teilen</a></td></tr>

<tr><td colspan=2><img width=20 height=20 align=absmiddle src=images/ico_mail.png> <a href="mailto:?subject=Kurs bei '.$coredata[titel].'&body='.$kurs[titel].'%0A'.genURL('kurs',$kurs[id]).'">Per E-Mail weiterleiten</a></td></tr>

</table>
</div>';






echo '</div>';

}

?>