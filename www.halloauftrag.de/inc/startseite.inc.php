<!--[if lt IE 7]>
<div class="alert alert-warning"><b>Sie verwenden einen veralteten Browser!</b> Wir empfehlen, die <a href="http://browsehappy.com/" target="_blank">neueste Version Ihres Browsers</a> zu installieren.</div>
<![endif]-->



<div class="row hidden-sm">
<div style="position:relative;height:200px;margin-bottom:20px;">
<div class="col-lg-12 col-sm-12" style="height:200px;overflow:hidden;position:absolute;">
<img src=images/intro_startseite.jpg width=100%>
</div>
<div style="position:absolute;padding:7px;margin-top:80px;margin-left:50px;background-color:#df9e00;color:#fff;font-size:25px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">Auftrag zu vergeben?</div>
<div style="position:absolute;padding:7px;margin-top:122px;margin-left:130px;background-color:#ffdc87;font-size:20px;opacity:0.85;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=85);">Einfach und schnell mehrere Offerten einholen</div>
</div>
</div>


<div class="row">

<div class="col-lg-4 col-sm-4" style="margin-bottom:20px;"><table border=0 cellspacing=0 cellpadding=5><tr>
<td width=80><img src=images/intro_verifiziert.png width=80 height=80></td>
<td><div><b>Überprüfte Benutzer</b></div><div class="small" style="margin-top:5px;">Benutzer können sich verifizieren lassen. Für Ihre Sicherheit.</div></td>
</tr></table></div>

<div class="col-lg-4 col-sm-4" style="margin-bottom:20px;"><table border=0 cellspacing=0 cellpadding=5><tr>
<td width=80><img src=images/intro_bewertungen.png width=80 height=80></td>
<td><div><b>Bewertungen</b></div><div class="small" style="margin-top:5px;">Sehen Sie Bewertungen von bisherigen Geschäftspartnern.</div></td>
</tr></table></div>

<div class="col-lg-4 col-sm-4" style="margin-bottom:20px;"><table border=0 cellspacing=0 cellpadding=5><tr>
<td width=80><img src=images/intro_preis.png width=80 height=80></td>
<td><div><b>Kompetitive Angebote</b></div><div class="small" style="margin-top:5px;">Durch die Ausschreibung macht jeder sein bestes Angebot.</div></td>
</tr></table></div>

</div>





<div class="row">

<div class="col-lg-8 col-sm-7" style="margin-bottom:20px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Aufträge finden</b></div><div style="padding:5px;">

<form action="index.php" method="get" class="form-horizontal" accept-charset="UTF-8"><input type="hidden" name="d" value="suchen">

<div class="row">

<div class="col-lg-5 col-sm-12" style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_suchen.png width=16 height=16 align=absmiddle></span>
<input type="text" name="qq" class="form-control" placeholder="Was suchen Sie?" style="font-size:18px;font-weight:bold;">
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

$topcities = '<div style="margin-top:10px;">Top-Städte: ';
$getCities = mysqli_query($db,"SELECT ort FROM ".$dbx."_geodata WHERE land='DE' OR land='AT' OR land='CH' ORDER BY einwohner DESC LIMIT 0,17");
while($fetchCity=mysqli_fetch_assoc($getCities)) $topcities .= '<a href="'.genUrl('suchen',urlencode($fetchCity[ort])).'">'.$fetchCity[ort].'</a>, ';
echo substr($topcities, 0, -2);

?></div>

</div></div>

<div class="col-lg-4 col-sm-5" style="margin-bottom:30px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Auftrag ausschreiben</b></div><div style="padding:5px;">

Finden Sie den Handwerker oder Dienstleister für Ihr Projekt:<br><br><a href="<?php echo genURL('eintragen'); ?>">Jetzt Auftrag ausschreiben</a> und das beste Angebot auswählen.

</div></div>

</div>






















<div class="row">
<div class="col-lg-12">
<?php


$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE datum_ende>".time()." AND status='ok' ORDER BY datum DESC LIMIT 0,10");
$auftragcounter=mysqli_num_rows($getauftrag);

if($auftragcounter==0) echo '';
else {


echo '<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class=smallroundcorners><b>Neueste Aufträge</b></div><ul id="flexiselNeu">';
while($auftrag=mysqli_fetch_array($getauftrag)) {

echo '<li><div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td valign=top width=100><div style="overflow:hidden;height:100px;width:100px;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">';
if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'"><b>'.$auftrag[titel].'</b></a></div>
';

echo '<div style="padding-left:5px;">
<div style="padding-top:2px;padding-bottom:1px;"><img src=images/ico_marker.png width=16 height=16 align=absmiddle> in <a href="'.genUrl('suchen',urlencode($auftrag[ort])).'">'.$auftrag[ort].'</a></div>
<div><img src=images/ico_countdown.png width=16 height=16 align=absmiddle> '.calcCountdown($auftrag[datum_ende]).'</div>
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