<!--[if lt IE 7]>
<div class="alert alert-warning"><b>Sie verwenden einen veralteten Browser!</b> Wir empfehlen, die <a href="http://browsehappy.com/" target="_blank">neueste Version Ihres Browsers</a> zu installieren.</div>
<![endif]-->



<div class="row hidden-sm">
<div class="col-lg-12" style="margin-bottom:20px;">
<table border=0 cellspacing=0 cellpadding=0 align=center><tr>

<td valign=bottom><img src=images/intro_left.png width=180></td><td width=310 valign=top><div style="margin-top:10px;border:2px solid #dcdcdc;padding:10px;background-color:#f5f6f5;" class=bigroundcorners>

<span style="font-weight:bold;font-size:20px;">Ungenutztes vermieten</span><br><br>
Viele Gegenstände werden nur selten gebraucht und liegen die meisten Zeit ungenutzt herum.<br><br>
Vermieten Sie ungenutzte Gegenstände und verdienen Sie etwas Geld.<br><br>
<img src="images/ico_starten.png" width=16 height=16 align=absmiddle border=0> <a href="<?php echo genURL('vermieten'); ?>">Gegenstand anbieten</a>

</div></td>



<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>


<td width=310 valign=top><div style="margin-top:10px;border:2px solid #dcdcdc;padding:10px;background-color:#f5f6f5;" class=bigroundcorners>

<span style="font-weight:bold;font-size:20px;">Ausleihen statt kaufen</span><br><br>
Warum kaufen, wenn Sie einen Gegenstand nur einmal oder selten brauchen?<br><br>
Mieten Sie diesen privat von anderen und sparen Sie dabei!<br><br>
<img src="images/ico_suchen.png" width=16 height=16 align=absmiddle border=0> <a href="<?php echo genURL('suchen'); ?>">Gegenstände durchstöbern</a>

</div></td><td valign=bottom><img src=images/intro_right.png width=180></td>

</tr></table>
</div>
</div><br>




<div class="row visible-sm">
<div class="col-lg-12">

<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class=smallroundcorners><b>Ungenutzte Sachen vermieten</b></div><br>

<div>
Viele Gegenstände werden nur selten gebraucht und liegen die meisten Zeit ungenutzt herum.<br><br>
Vermieten Sie ungenutzte Gegenstände und verdienen Sie etwas Geld.<br><br>
<img src="images/ico_starten.png" width=16 height=16 align=absmiddle border=0> <a href="<?php echo genURL('vermieten'); ?>">Gegenstand anbieten</a></div><br><br>

<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class=smallroundcorners><b>Ausleihen statt teuer kaufen</b></div><br>

<div>
Warum kaufen, wenn Sie einen Gegenstand nur einmal oder selten brauchen?<br><br>
Mieten Sie diesen privat von anderen und sparen Sie dabei!<br><br>
<img src="images/ico_suchen.png" width=16 height=16 align=absmiddle border=0> <a href="<?php echo genURL('suchen'); ?>">Gegenstände durchstöbern</a></div><br><br>

</div>
</div>











<div class="row">

<div class="col-lg-8 col-sm-7" style="margin-bottom:20px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Gegenstand finden</b></div><div style="padding:5px;">

<form action="index.php" method="get" class="form-horizontal"><input type="hidden" name="d" value="suchen">

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

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
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
$getCities=mysql_query("SELECT ort FROM ".$dbx."_geodata WHERE land='DE' OR land='AT' OR land='CH' ORDER BY einwohner DESC LIMIT 0,17");
while($fetchCity=mysql_fetch_array($getCities)) $topcities .= '<a href="'.genUrl('suchen',urlencode($fetchCity[ort])).'">'.$fetchCity[ort].'</a>, ';
echo substr($topcities, 0, -2);

?></div>

</div></div>

<div class="col-lg-4 col-sm-5" style="margin-bottom:30px;">
<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class="smallroundcorners"><b>Kategorien</b></div><div style="padding:5px;">
<?php
$getKats=mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY kat");
while($fetchKats=mysql_fetch_array($getKats)) $topkats .= '<a href="'.genUrl('kat',$fetchKats[id]).'">'.str_replace(" ","&nbsp;",$fetchKats[kat]).'</a> | ';
echo substr($topkats, 0, -2);
?>
</div></div>

</div>






















<div class="row">
<div class="col-lg-12">
<?php


$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE status='ok' ORDER BY datum DESC LIMIT 0,10");
$gegenstandcounter=mysql_num_rows($getgegenstand);

if($gegenstandcounter==0) echo '';
else {


echo '<div style="padding:5px;background-color:#eee;margin-bottom:-15px;" class=smallroundcorners><b>Neueste Gegenstände</b></div><ul id="flexiselNeu">';
while($gegenstand=mysql_fetch_array($getgegenstand)) {

echo '<li><div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3 width=100%><tr><td valign=top width=100><div style="overflow:hidden;height:100px;width:100px;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'">';
if(file_exists("fotos/".$gegenstand[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$gegenstand[id].'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$gegenstand[id]."_1_t.png")==1) echo '<img src="fotos/'.$gegenstand[id].'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'"><b>'.$gegenstand[titel].'</b></a></div>

<div style="padding-right:5px;;">';

$getprofil=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$gegenstand[user]."'");
$profil=mysql_fetch_array($getprofil);

echo '<a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'">';

if(file_exists("avatar/".$profil[id]."_t.jpg")==1) echo '<img src="avatar/'.$profil[id].'_t.jpg?'.(time()-1300000000).'"';
elseif(file_exists("avatar/".$profil[id]."_t.png")==1) echo '<img src="avatar/'.$profil[id].'_t.png?'.(time()-1300000000).'"';
else echo '<img src="avatar/user.gif"';
echo ' width=44 height=44 style="border:1px solid #ccc;margin-right:7px;" id="profilfoto" class="img-circle hidden-sm" align=left valign=absmiddle></a>';

echo '
<div style="padding-top:2px;padding-bottom:1px;">in <a href="'.genUrl('suchen',urlencode($gegenstand[ort])).'">'.$gegenstand[ort].'</a></div>
<div><b>'.$gegenstand[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> pro Tag</div>
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