<!--[if lt IE 7]>
<div class="alert alert-warning"><b>Sie nutzen einen veralteten Browser!</b> Wir empfehlen, die <a href="http://browsehappy.com/" target="_blank">aktuelle Version Ihres Browsers</a> zu installieren.</div>
<![endif]-->

<div class="row hidden-sm">
<div style="position:relative;height:200px;margin-bottom:20px;">
<div class="col-lg-12 col-sm-12" style="height:200px;overflow:hidden;position:absolute;">
<img src=images/intro_startseite.jpg width=100%>
</div>
<div style="position:absolute;padding:7px;margin-top:80px;margin-left:50px;background-color:#009fd4;color:#fff;font-size:25px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">Private Unterkünfte:</div>
<div style="position:absolute;padding:7px;margin-top:122px;margin-left:130px;background-color:#a4e8ff;font-size:20px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">Die Alternative zum Hotel.</div>
</div>
</div>

<div class="row">

<div class="col-lg-8 col-sm-7" style="margin-bottom:30px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners visible-sm"><b>Unterkunft finden</b></div><div style="padding:5px;">

<form action="index.php" method="get" class="form-horizontal"><input type="hidden" name="d" value="suchen">

<div class="row">

<div class="col-12" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_marker.png width=16 height=16 align=absmiddle></span>
<input type="text" name="ort" class="form-control" placeholder="Wo geht es hin?" style="font-size:18px;font-weight:bold;">
</div>
</div>

</div><div class="row">

<div class="col-lg-6 col-sm-12" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_unterkunft.png width=16 height=16 align=absmiddle></span>
<select name="art" class="form-control">
<option value="">Alle Unterkunftsarten</option>
<?php

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'">'.$fetchArt[art].'</option>';
}

?>
</select>
</div>
</div>

<div class="col-lg-4 col-sm-8" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_users.png width=16 height=16 align=absmiddle></span>
<select name="anzgaeste" class="form-control">
<option value=1>1 Gast</option>
<option value=2 selected>2 Gäste</option>
<option value=3>3 Gäste</option>
<option value=4>4 Gäste</option>
<option value=5>5 Gäste</option>
<option value=6>6 Gäste</option>
<option value=7>7 Gäste</option>
<option value=8>8 Gäste</option>
<option value=9>9 Gäste</option>
<option value=10>10 Gäste</option>
<option value=11>11 Gäste</option>
<option value=12>12 Gäste</option>
<option value=13>13 Gäste</option>
<option value=14>14 Gäste</option>
<option value=15>15+ Gäste</option>
</select>
</div>
</div>

<div class="col-lg-2 col-sm-4" style="margin-bottom:10px;">
<input type=submit value=Suchen class="btn btn-default" style=width:100%>
</div>

</form>

</div>
<?php

$topcities = '<div style="margin-top:10px;">Top-Städte: ';
$getCities=mysql_query("SELECT ort FROM ".$dbx."_geodata WHERE land='DE' OR land='AT' OR land='CH' ORDER BY einwohner DESC LIMIT 0,17");
while($fetchCity=mysql_fetch_array($getCities)) $topcities .= '<a href="'.genUrl('suchen',urlencode($fetchCity[ort])).'">'.$fetchCity[ort].'</a>, ';
echo substr($topcities, 0, -2);

?></div>

</div></div>

<div class="col-lg-4 col-sm-5" style="margin-bottom:30px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Unterkunft vermieten</b></div><div style="padding:5px;">
Freies Gästezimmer, Apartment, Ferienwohnung oder Haus? Verdienen Sie mit ungenutztem Wohnraum Geld:<br><br>
<a href="<?php echo genURL('vermieten'); ?>"><img src="images/ico_starten.png" width=16 height=16 align=absmiddle border=0> Jetzt Unterkunft inserieren</a>
</div></div>

</div>

<div class="row">
<div class="col-lg-12">
<?php

$getartikel = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE status='ok' ORDER BY datum DESC LIMIT 0,10");
$artikelcounter=mysql_num_rows($getartikel);

if($artikelcounter==0) echo '';
else {

echo '<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class="smallroundcorners"><b>Aktuelle Unterkünfte</b></div><ul id="flexiselNeu">';
while($artikel=mysql_fetch_array($getartikel)) {

echo '<li><div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('unterkunft',$artikel[id],urlseotext($artikel[titel])).'">';
if(file_exists("fotos/".$artikel[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$artikel[id].'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$artikel[id]."_1_t.png")==1) echo '<img src="fotos/'.$artikel[id].'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('unterkunft',$artikel[id],urlseotext($artikel[titel])).'"><b>'.$artikel[titel].'</b></a></div>
<div style="padding:5px;padding-bottom:1px;"><img src=images/flaggen/'.$artikel[land].'.gif width=18 height=12 align=absmiddle> '.$artikel[ort].'</div>
<div style="padding:5px;padding-top:1px;"><b>'.$artikel[preis_nacht].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> pro Nacht</div>
';

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



// Folgenden Code entfernen, falls die Datei cron.php via Cronjob ausgeführt wird:
$cronmode="no";
include("cron.php");
// Ende Code


?>