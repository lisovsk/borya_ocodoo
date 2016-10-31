<?php

$getunterkunft = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE id='".$s."' AND status='ok'");
$unterkunft = mysql_fetch_array($getunterkunft);

if($unterkunft[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Eintrag konnte nicht gefunden werden.</div>';
else {

$getgastgeber=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$unterkunft[user]."'");
$gastgeber = mysql_fetch_array($getgastgeber);

$DO_TITEL=$unterkunft[titel];
echo '<legend>'.$unterkunft[titel].'</legend>';


if($usrd[id]==$unterkunft[user] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") echo '<div style="margin-top:-10px;margin-bottom:20px;">
<img src="images/ico_write.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&edit='.$unterkunft[id].'">Bearbeiten</a>&nbsp;
<img src="images/ico_delete.png" width=16 height=16 align=absmiddle> <a href="index.php?d=edit&del='.$unterkunft[id].'">Löschen</a>&nbsp;
<img width=16 height=16 align=absmiddle src=images/ico_uhr.png> <a href="index.php?d=edit&nvfb='.$unterkunft[id].'">Nichtverfügbarkeit eintragen</a>
</div>';



echo '<div class="row">
<div class="col-lg-8 col-sm-8">';



if(file_exists("fotos/".$unterkunft[id]."_1_t.jpg")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_1_b.jpg"><img src="fotos/'.$unterkunft[id].'_1_t.jpg"></a>';
elseif(file_exists("fotos/".$unterkunft[id]."_1_t.png")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_1_b.png"><img src="fotos/'.$unterkunft[id].'_1_t.png"></a>';
if(file_exists("fotos/".$unterkunft[id]."_2_t.jpg")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_2_b.jpg"><img src="fotos/'.$unterkunft[id].'_2_t.jpg"></a>';
elseif(file_exists("fotos/".$unterkunft[id]."_2_t.png")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_2_b.png"><img src="fotos/'.$unterkunft[id].'_2_t.png"></a>';
if(file_exists("fotos/".$unterkunft[id]."_3_t.jpg")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_3_b.jpg"><img src="fotos/'.$unterkunft[id].'_3_t.jpg"></a>';
elseif(file_exists("fotos/".$unterkunft[id]."_3_t.png")==1) $afotos .= '<a href="fotos/'.$unterkunft[id].'_3_b.png"><img src="fotos/'.$unterkunft[id].'_3_t.png"></a>';


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






?><ul class="nav nav-tabs">
<li class="active"><a href="#beschreibung" data-toggle="tab"><img src=images/ico_beschreibung.png width=16 height=16 align=absmiddle border=0> Beschreibung</a></li>
<li><a href="#ausstattung" data-toggle="tab"><img src=images/ico_ausstattung.png width=16 height=16 align=absmiddle border=0> Ausstattung</a></li>
<li><a href="#regeln" data-toggle="tab"><img src=images/ico_regeln.png width=16 height=16 align=absmiddle border=0> Hausregeln</a></li>
</ul>
<div class="tab-content">

<div class="tab-pane fade in active" id="beschreibung" style="margin-bottom:30px;">
<div style="padding:5px;max-height:200px;overflow:auto;margin-bottom:40px;"><?php

echo '<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;border-bottom:1px dotted #bbb;">'.$unterkunft[cont].'</div>
<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;border-bottom:1px dotted #bbb;">Art der Unterkunft: ';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($unterkunft[art]==$fetchArt[id]) echo $fetchArt[art];
}

echo '</div>
<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;border-bottom:1px dotted #bbb;">Fläche: '.ucfirst($unterkunft[groesse]).' m2</div>
<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;border-bottom:1px dotted #bbb;">'.ucfirst($unterkunft[anz_schlafzimmer]).' Schlafzimmer</div>
<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;border-bottom:1px dotted #bbb;">'.ucfirst($unterkunft[anz_badezimmer]).' Badezimmer ('.ucfirst($unterkunft[art_badezimmer]).')</div>
<div class=row style="margin:0px !important;padding-bottom:3px;padding-top:3px;">Maximale Anzahl Gäste: '.ucfirst($unterkunft[max_gaeste]).'</div><br><br>';

?></div>
</div>

<div class="tab-pane fade" id="ausstattung" style="margin-bottom:30px;">
<div style="margin-bottom:40px;">
<div class=row><?php

$getAusstattung = mysql_query("SELECT * FROM ".$dbx."_data_ausstattung ORDER BY id");
while($fetchAusstattung = mysql_fetch_array($getAusstattung)) {
if(strpos($unterkunft[ausstattung],"|".$fetchAusstattung[id]."|")!==false) echo '<div class="col-lg-4 col-sm-6" style="margin-top:10px;"><img src=images/ico_check.png width=16 height=16 align=absmiddle> '.$fetchAusstattung[ausstattung].'</div>';
}

?></div>
</div>
</div>

<div class="tab-pane fade" id="regeln" style="margin-bottom:30px;">
<div style="padding:5px;max-height:200px;overflow:auto;margin-bottom:40px;"><?php
if($unterkunft[regeln]=="") echo '<i>keine Hausregeln hinterlegt.</i>';
else echo $unterkunft[regeln];
?></div>
</div>

</div><?php



echo '<div style="padding:5px;background-color:#eee;" class=smallroundcorners><b>Verfügbarkeit</b></div>';


$getmieten=mysql_query("SELECT * FROM ".$dbx."_mieten WHERE unterkunft='".$unterkunft[id]."'");
while($mieten=mysql_fetch_array($getmieten)) {
for ($ts=$mieten[von]; $ts<$mieten[bis]+1; $ts=$ts+86400) {
${date('j-n-Y',$ts)}=$mieten[art];
}
}

$monat_jetzt = date('n');
$monat_next1 = $monat_jetzt+1;
$monat_next2 = $monat_jetzt+2;
$monat_next3 = $monat_jetzt+3;
$monat_next4 = $monat_jetzt+4;
$monat_next5 = $monat_jetzt+5;
$jahr_jetzt = date('Y');
if($monat_next1 > 12) { $monat_next1=$monat_next1-12; $jahr_next1 = date('Y')+1; } else $jahr_next1 = date('Y');
if($monat_next2 > 12) { $monat_next2=$monat_next2-12; $jahr_next2 = date('Y')+1; } else $jahr_next2 = date('Y');
if($monat_next3 > 12) { $monat_next3=$monat_next3-12; $jahr_next3 = date('Y')+1; } else $jahr_next3 = date('Y');
if($monat_next4 > 12) { $monat_next4=$monat_next4-12; $jahr_next4 = date('Y')+1; } else $jahr_next4 = date('Y');
if($monat_next5 > 12) { $monat_next5=$monat_next5-12; $jahr_next5 = date('Y')+1; } else $jahr_next5 = date('Y');

$monat_jetzt_tage = date('t');
$monat_next1_tage = date('t',mktime(0, 0, 0, $monat_next1, 5, $jahr_next1));
$monat_next2_tage = date('t',mktime(0, 0, 0, $monat_next2, 5, $jahr_next2));
$monat_next3_tage = date('t',mktime(0, 0, 0, $monat_next3, 5, $jahr_next3));
$monat_next4_tage = date('t',mktime(0, 0, 0, $monat_next4, 5, $jahr_next4));
$monat_next5_tage = date('t',mktime(0, 0, 0, $monat_next5, 5, $jahr_next5));

$tr_jetzt .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_jetzt).'&nbsp;'.$jahr_jetzt.'</div></td></tr><tr>';
for ($i=1; $i<($monat_jetzt_tage+1); $i++) {
$tr_jetzt .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(date('j')>$i) $tr_jetzt .= '#ededed';
   elseif(${$i.'-'.$monat_jetzt.'-'.$jahr_jetzt}=='mt') $tr_jetzt .= '#ff0000';
   elseif(${$i.'-'.$monat_jetzt.'-'.$jahr_jetzt}=='ma') $tr_jetzt .= '#ff8a00';
   elseif(${$i.'-'.$monat_jetzt.'-'.$jahr_jetzt}=='nv') $tr_jetzt .= '#a9a9a9';
   else $tr_jetzt .= '#1adc00';
$tr_jetzt .= ';">'.$i.'</div></td>';
if($i==16) $tr_jetzt .= '</tr><tr>';
}
$tr_jetzt .= '</tr>';

$tr_next1 .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-top:5px;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_next1).'&nbsp;'.$jahr_next1.'</div></td></tr><tr>';
for ($i=1; $i<($monat_next1_tage+1); $i++) {
$tr_next1 .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(${$i.'-'.$monat_next1.'-'.$jahr_next1}=='mt') $tr_next1 .= '#ff0000';
   elseif(${$i.'-'.$monat_next1.'-'.$jahr_next1}=='ma') $tr_next1 .= '#ff8a00';
   elseif(${$i.'-'.$monat_next1.'-'.$jahr_next1}=='nv') $tr_next1 .= '#a9a9a9';
   else $tr_next1 .= '#1adc00';
$tr_next1 .= ';">'.$i.'</div></td>';
if($i==16) $tr_next1 .= '</tr><tr>';
}
$tr_next1 .= '</tr>';

$tr_next2 .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-top:5px;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_next2).'&nbsp;'.$jahr_next2.'</div></td></tr><tr>';
for ($i=1; $i<($monat_next2_tage+1); $i++) {
$tr_next2 .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(${$i.'-'.$monat_next2.'-'.$jahr_next2}=='mt') $tr_next2 .= '#ff0000';
   elseif(${$i.'-'.$monat_next2.'-'.$jahr_next2}=='ma') $tr_next2 .= '#ff8a00';
   elseif(${$i.'-'.$monat_next2.'-'.$jahr_next2}=='nv') $tr_next2 .= '#a9a9a9';
   else $tr_next2 .= '#1adc00';
$tr_next2 .= ';">'.$i.'</div></td>';
if($i==16) $tr_next2 .= '</tr><tr>';
}
$tr_next2 .= '</tr>';

$tr_next3 .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-top:5px;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_next3).'&nbsp;'.$jahr_next3.'</div></td></tr><tr>';
for ($i=1; $i<($monat_next3_tage+1); $i++) {
$tr_next3 .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(${$i.'-'.$monat_next3.'-'.$jahr_next3}=='mt') $tr_next3 .= '#ff0000';
   elseif(${$i.'-'.$monat_next3.'-'.$jahr_next3}=='ma') $tr_next3 .= '#ff8a00';
   elseif(${$i.'-'.$monat_next3.'-'.$jahr_next3}=='nv') $tr_next3 .= '#a9a9a9';
   else $tr_next3 .= '#1adc00';
$tr_next3 .= ';">'.$i.'</div></td>';
if($i==16) $tr_next3 .= '</tr><tr>';
}
$tr_next3 .= '</tr>';

$tr_next4 .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-top:5px;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_next4).'&nbsp;'.$jahr_next4.'</div></td></tr><tr>';
for ($i=1; $i<($monat_next4_tage+1); $i++) {
$tr_next4 .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(${$i.'-'.$monat_next4.'-'.$jahr_next4}=='mt') $tr_next4 .= '#ff0000';
   elseif(${$i.'-'.$monat_next4.'-'.$jahr_next4}=='ma') $tr_next4 .= '#ff8a00';
   elseif(${$i.'-'.$monat_next4.'-'.$jahr_next4}=='nv') $tr_next4 .= '#a9a9a9';
   else $tr_next4 .= '#1adc00';
$tr_next4 .= ';">'.$i.'</div></td>';
if($i==16) $tr_next4 .= '</tr><tr>';
}
$tr_next4 .= '</tr>';

$tr_next5 .= '<tr><td colspan=16><div style="font-size:11px;text-align:center;margin-top:5px;margin-bottom:1px;padding:3px;" class="smallroundcorners">'.nr2monat($monat_next5).'&nbsp;'.$jahr_next5.'</div></td></tr><tr>';
for ($i=1; $i<($monat_next5_tage+1); $i++) {
$tr_next5 .= '<td><div class="tagnr smallroundcorners" style="background-color:';
   if(date('j')<$i) $tr_next5 .= '#ddd';
   elseif(${$i.'-'.$monat_next5.'-'.$jahr_next5}=='mt') $tr_next5 .= '#ff0000';
   elseif(${$i.'-'.$monat_next5.'-'.$jahr_next5}=='ma') $tr_next5 .= '#ff8a00';
   elseif(${$i.'-'.$monat_next5.'-'.$jahr_next5}=='nv') $tr_next5 .= '#a9a9a9';
   else $tr_next5 .= '#1adc00';
$tr_next5 .= ';">'.$i.'</div></td>';
if($i==16) $tr_next5 .= '</tr><tr>';
}
$tr_next5 .= '</tr>';


echo '<div class=row style="margin-bottom:30px;"><div class="col-lg-7 col-lg-7">';
echo '<table cellspacing=0 cellpadding=1>';
echo $tr_jetzt;
echo $tr_next1;
echo $tr_next2;
echo $tr_next3;
echo $tr_next4;
echo $tr_next5;
echo '</table>';
echo '</div><div class="col-lg-5 col-lg-5"><br><br>
Der Kalender ist nicht verbindlich und nur eine Annäherung an die Verfügbarkeit. Buchungsanfragen können vom Gastgeber auch trotz Verfügbarkeit abgelehnt werden.<br><br>
<img src=images/stat_ja.png width=11 height=11 align=absmiddle> Unterkunft verfügbar<br>
<img src=images/stat_nein.png width=11 height=11 align=absmiddle> Unterkunft vermietet<br>
<img src=images/stat_res.png width=11 height=11 align=absmiddle> Offene Buchungsanfrage<br>
<img src=images/stat_neutral.png width=11 height=11 align=absmiddle> Unterkunft nicht verfügbar
</div>';







echo '</div>';
echo '</div>';

























?><script>
$(document).ready(function() {
  $(function() {
    $("#datumvon").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+5M +27D",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
$(document).ready(function() {
  $(function() {
    $("#datumbis").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+6M",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
</script><?php

echo '<div class="col-lg-4 col-sm-4">';


$dateMorgen = date("d.m.Y",time()+86400);
$dateDreiTage = date("d.m.Y",time()+345600);

echo '<div style="margin-bottom:30px;"><form action=index.php method=post><input type=hidden name=d value=mieten><input type=hidden name=s value='.$unterkunft[id].'>

<div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px">

<div class="col-5" style="padding:0px !important;"><b>Preis:</b><br>pro Nacht</i></div>
<div class="col-7 smallroundcorners" style="padding:0px !important;margin-top:-4px;background-color:#c1ecf9;"><center><span style="font-weight:bold;font-size:30px;letter-spacing:-1px;">'.$unterkunft[preis_nacht].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span></center></div>

</div><div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<br><div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Buchungsanfrage</b></div>

<div class="col-5" style="padding:0px !important;margin-top:9px;"><b>Check-In:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></span><input type="text" name="datumvon" id="datumvon" value="'.$dateMorgen.'" class=form-control></div></div>

</div><div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<div class="col-5" style="padding:0px !important;margin-top:9px;"><b>Check-Out:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></span><input type="text" name="datumbis" id="datumbis" value="'.$dateDreiTage.'" class=form-control></div></div>

</div><div class=row style="margin:0px !important;padding-bottom:5px;padding-top:5px;border-bottom:1px dotted #bbb;">

<div class="col-5" style="padding:0px !important;margin-top:9px;"><b>Gäste:</b></div>
<div class="col-7" style="padding:0px !important;"><div class=input-group><span class="input-group-addon"><img src=images/ico_users.png width=16 height=16></span><select name="anzgaeste" id="anzgaeste" class=form-control>
<option>1
<option selected>2
<option>3
<option>4
<option>5
<option>6
<option>7
<option>8
<option>9
<option>10
<option>11
<option>12
<option>13
<option>14
<option>15+
</select></div></div>
</div>

<div style="padding-top:5px;"><input type=submit value="Jetzt buchen!" style="width:100%;background-color:#09b0e8;color:white;" class="btn btn-large"></div>

</form></div>';







echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Lage</b></div>

<div style="margin-bottom:30px;">

<div><a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$unterkunft[strasse].',+'.$unterkunft[plz].'+'.$unterkunft[ort].'" target=_blank><img src="http://maps.googleapis.com/maps/api/staticmap?center='.urlseotext($unterkunft[strasse]).'+'.urlseotext($unterkunft[plz]).'+'.urlseotext($unterkunft[ort]).'&zoom=10&size=300x280&sensor=false&markers=icon:http://'.$coredata[url].'/images/map_marker.png%7C'.urlseotext($unterkunft[strasse]).'+'.urlseotext($unterkunft[plz]).'+'.urlseotext($unterkunft[ort]).'" class="img-rounded" style="width:100%;" border=0></a></div>
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img src=images/ico_map.png width=16 height=16 align=absmiddle> <a href="http://maps.google.de/maps?f=q&source=s_q&hl=de&q='.$unterkunft[strasse].',+'.$unterkunft[plz].'+'.$unterkunft[ort].'" target=_blank>Bei Google Maps anzeigen</a></td></tr>
<tr><td colspan=2 class=lead>'.$unterkunft[strasse].'<br>'.$unterkunft[plz].' '.$unterkunft[ort].'</td></tr>

</table>
</div>';






if($coredata['user']=="user") $urlUsername=$gastgeber[user]; else $urlUsername=$gastgeber[id];

echo '<div style="padding:5px;background-color:#eee;margin-bottom:5px;" class=smallroundcorners><b>Ihr Gastgeber</b></div>

<div style="margin-bottom:30px;">
<div style="margin-bottom:5px;"><a href="'.genURL('user',$urlUsername).'"><img src="avatar/';
if(file_exists("avatar/".$unterkunft[user]."_t.jpg")==1) echo $unterkunft[user].'_t.jpg';
elseif(file_exists("avatar/".$unterkunft[user]."_t.png")==1) echo $unterkunft[user].'_t.png';
else echo 'user.gif';
echo '" class="img-rounded" style="width:100%;" border=0></a></div>
<div style="margin:5px;" class=lead><img src=images/ico_user_'.$gastgeber[geschlecht].'.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'"><b>';
if($coredata['user']=="user") echo ucfirst($gastgeber[user]);
else echo $gastgeber[vorname].' '.$gastgeber[nachname];
echo '</b></a></div>
<table class="table">';

if($gastgeber[verifizierung]=="ok") echo '<tr><td><img src=images/ico_verified.png width=16 height=16 align=absmiddle> <b>Verifiziert</b></td><td>(Identität überprüft)</td></tr>';

echo '
<tr><td>';

$bewertung=round($gastgeber[bewertung]*2)/2;

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

if($gastgeber[anz_bewertungen]==0) echo 'keine Bewertungen';
elseif($gastgeber[anz_bewertungen]==1) echo '<a href="'.genURL('user',$urlUsername).'">1 Bewertung</a>';
else echo '<a href="'.genURL('user',$urlUsername).'">'.$gastgeber[anz_bewertungen].' Bewertungen</a>';

echo ')</td></tr><tr><td>Wohnort:</td><td><img src=images/flaggen/'.$gastgeber[land].'.gif width=18 height=12 align=absmiddle> '.$gastgeber[ort].'</td></tr>
<tr><td colspan=2><img src=images/ico_faq2.png width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">Mehr über den Gastgeber</a></td></tr>
<tr><td colspan=2><img src=images/ico_nachricht.png width=16 height=16 align=absmiddle> <a href="'.genURL('nachrichten','senden',$gastgeber[id]).'">Nachricht senden</a></td></tr>

</table>
</div>';






echo '<div style="padding:5px;background-color:#eee;" class=smallroundcorners><b>Unterkunft weiterempfehlen</b></div>

<div style="margin-bottom:30px;">
<table class="table">

<tr><td colspan=2 style="border-top:0 !important;"><img width=16 height=16 align=absmiddle src=images/ico_facebook.png> <a href="http://www.facebook.com/sharer.php?u='.urlencode(genURL('unterkunft',$unterkunft[id])).'&t='.urlencode(utf8_encode($unterkunft[titel])).'" target=_blank>Bei Facebook teilen</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_twitter.png> <a href="https://twitter.com/intent/tweet?text='.urlencode(utf8_encode($unterkunft[titel].' - '.genURL('unterkunft',$unterkunft[id]))).'" target=_blank>Bei Twitter posten</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_googleplus.png> <a href="https://plus.google.com/share?url='.rawurlencode(genURL('unterkunft',$unterkunft[id])).'" target=_blank>Bei Google+ teilen</a></td></tr>

<tr><td colspan=2><img width=16 height=16 align=absmiddle src=images/ico_nachricht.png> <a href="mailto:?subject=Unterkunft bei '.$coredata[titel].'&body='.$unterkunft[titel].'%0A'.genURL('unterkunft',$unterkunft[id]).'">Per E-Mail weiterleiten</a></td></tr>

</table>
</div>';






echo '</div>';

}

?>