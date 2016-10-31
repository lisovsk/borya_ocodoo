<!--[if lt IE 7]>
<div class="alert alert-warning"><b>Sie verwenden einen veralteten Browser!</b> Wir empfehlen, die <a href="http://browsehappy.com/" target="_blank">neueste Version Ihres Browsers</a> zu installieren.</div>
<![endif]-->



<div class="row hidden-sm">
<div style="position:relative;height:220px;margin-bottom:20px;">
<div class="col-lg-12 col-sm-12" style="height:220px;overflow:hidden;position:absolute;">
<img src=images/intro_startseite.jpg width=100%>
</div>
<div style="position:absolute;padding:7px;margin-top:100px;margin-left:50px;background-color:#666cbb;color:#fff;font-size:21px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">Der Online-Treffpunkt für Menschen,</div>
<div style="position:absolute;padding:7px;margin-top:138px;margin-left:70px;background-color:#f7d049;font-size:18px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">die ihr Wissen erweitern und weitergeben möchten</div>
</div>
</div>


<div class="row"><?php

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY kat");
$ac=0;
while($fetchArt = mysqli_fetch_array($getArten)) {
$ac++;

echo '<div class="col-lg-4 col-sm-4" style="margin-bottom:20px;"><table border=0 cellspacing=0 cellpadding=5><tr>
<td width=64><a href="'.genURL('kat',$fetchArt[id],urlseotext($fetchArt[kat])).'"><img src=images/'.$fetchArt[icon].'.png width=64 height=64 border=0></a></td>
<td><div><b><a href="'.genURL('kat',$fetchArt[id],urlseotext($fetchArt[kat])).'">'.$fetchArt[kat].'</a></b></div><div class="small" style="margin-top:5px;"><a href="'.genURL('kat',$fetchArt[id],urlseotext($fetchArt[kat])).'" style="text-decoration:none;color:#333;">'.$fetchArt[cont].'</a></div></td>
</tr></table></div>';

if($ac==3) {
echo '</div><div class="row">';
$ac=0;
}

}

?></div><br>





<div class="row">

<div class="col-lg-8 col-sm-7" style="margin-bottom:20px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Kursangebot durchsuchen</b></div><div style="padding:5px;">

<form action="index.php" method="get" class="form-horizontal" accept-charset="UTF-8"><input type="hidden" name="d" value="kurse">

<div class="row">

<div class="col-lg-5 col-sm-12" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_suchen.png width=16 height=16 align=absmiddle></span>
<input type="text" name="qq" class="form-control" placeholder="Stichwort" style="font-size:18px;font-weight:bold;">
</div>
</div>



<div class="col-lg-5 col-sm-12" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_tags.png width=16 height=16 align=absmiddle></span>
<select name="kat" class="form-control">
<option value="">Alle Kategorien</option>
<?php

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'">'.$fetchArt[kat].'</option>';
}

?>
</select>
</div>
</div>


<div class="col-lg-2 col-sm-4" style="margin-bottom:10px;">
<input type=submit value=Suchen class="btn btn-default" style=width:100%>
</div>

</form>

</div>
<?php

$topcities = '<div style="margin-top:10px;">Kurse finden in: ';
$getCities = mysqli_query($db,"SELECT ort FROM ".$dbx."_geodata WHERE land='DE' OR land='AT' OR land='CH' ORDER BY einwohner DESC LIMIT 0,17");
while($fetchCity=mysqli_fetch_assoc($getCities)) $topcities .= '<a href="'.genUrl('kurse',urlencode($fetchCity[ort])).'">'.$fetchCity[ort].'</a>, ';
echo substr($topcities, 0, -2);

?></div>

</div></div>

<div class="col-lg-4 col-sm-5" style="margin-bottom:30px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Eigene Kurse anbieten</b></div><div style="padding:5px;">

Werden Sie Coach und teilen Sie Wissen, welches Sie sich in der Freizeit oder beim Job angeeignet haben.<br><br>
<img src=images/menu_neu.png width=16 height=16 align=absmiddle> <a href="<?php echo genURL('coachwerden'); ?>">Jetzt Coach werden</a>

</div></div>

</div>






















<div class="row">
<div class="col-lg-12">
<?php


$getkurse = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE standort NOT LIKE 'vorort' OR (kurstag1_von > ".time()." AND standort='vorort') ORDER BY datum DESC LIMIT 0,10");
$kursecounter=mysqli_num_rows($getkurse);

if($kursecounter==0) echo '';
else {


echo '<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class=smallroundcorners><b>Neueste Kurse</b></div><ul id="flexiselNeu">';
while($kurs=mysqli_fetch_array($getkurse)) {

echo '<li><div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td valign=top width=100><div style="overflow:hidden;height:100px;width:100px;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'">';
if(file_exists("fotos/".$kurs[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$kurs[id]."_1_t.png")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'"><b>'.$kurs[titel].'</b></a></div>
';

echo '<div style="padding-left:5px;">
<div style="padding-top:2px;padding-bottom:1px;">';
if($kurs[standort]=="vorort") echo '<img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('kurs',urlencode($kurs[ort])).'">'.$kurs[ort].'</a>';
elseif($kurs[standort]=="skype") echo '<img src=images/ico_skype.png width=16 height=16 align=absmiddle> via Skype';
elseif($kurs[standort]=="hangouts") echo '<img src=images/ico_hangouts.png width=16 height=16 align=absmiddle> via Google Hangouts';
elseif($kurs[standort]=="telefon") echo '<img src=images/ico_telefon.png width=16 height=16 align=absmiddle> via Telefon';
echo '
</div>
<div><img src=images/ico_users.png width=16 height=16 align=absmiddle> '.$kurs[teilnehmer].' Teilnehmer bisher</div>
</div>';

echo '</td></tr></table></div></li>';
}
echo '</ul><br clear=all>
<script type="text/javascript">
$(window).load(function() {
$("#flexiselNeu").flexisel({
visibleItems: 2,
animationSpeed: 1300,
autoPlay: true,
autoPlaySpeed: 3000,
pauseOnHover: true,
enableResponsiveBreakpoints: true,
responsiveBreakpoints: {
portrait: {
	changePoint:480,
	visibleItems: 1
},
landscape: {
	changePoint:640,
	visibleItems: 1
},
tablet: {
	changePoint:768,
	visibleItems: 1
}
}
});
});
</script>
</div></div>';

}
?>













<?php

// Folgenden Code entfernen, falls die Datei cron.php via Cronjob ausgeführt wird:
$cronmode="no";
include("cron.php");
// Ende Code

?>