<?php



$kat=htmlspecialchars(stripslashes($_POST[kat]));
if(!$kat) $kat=htmlspecialchars(stripslashes($_GET[kat]));
$qq=htmlspecialchars(stripslashes($_POST[qq]));
if(!$qq) $qq=htmlspecialchars(stripslashes($_GET[qq]));
$virtuell=htmlspecialchars(stripslashes($_POST[virtuell]));
if(!$virtuell) $virtuell=htmlspecialchars(stripslashes($_GET[virtuell]));

if($kat!="") {
$getKat = mysqli_query($db,"SELECT * FROM ".$dbx."_kats WHERE id='".$kat."'");
$katData = mysqli_fetch_array($getKat);
if($katData[id]!="") {
$sql .= " AND kat = '".$kat."'";
$pageTitel = $katData[kat].' ';
$katIcon = '<img src="images/'.$katData[icon].'.png" width=40 height=40 align=absmiddle style="margin-bottom:-7px;margin-top:-9px;"> ';
}
}

if($qq!="") $sql .= " AND (titel LIKE '%".$qq."%' OR cont LIKE '%".$qq."%')";
if($virtuell=="ok") $sql .= " AND (standort NOT LIKE 'vorort')";

$ort=htmlspecialchars(stripslashes($_POST[ort]));
if(!$ort) $ort=htmlspecialchars(stripslashes($_GET[ort]));
if($s!="") $ort = urldecode($s);

$ortdis=htmlspecialchars(stripslashes($_POST[umkreis]));
if(!$ortdis) $ortdis=htmlspecialchars(stripslashes($_GET[umkreis]));
if($ortdis=="") $ortdis="5";

if($ort!="" && $ort!="0") {

function cb($m) { return str_replace (" ", "::", $m[0]); }
$ort = preg_replace_callback('/"(.*?)"/i', "cb", $ort);
$ort = str_replace("st. ","sankt ",$ort);
$ort = str_replace("st.","sankt ",$ort);
$ort = str_replace("\"","",$ort);
$ort = str_replace("\\","",$ort);
$ort = str_replace("+","",$ort);
$ort = str_replace("*","",$ort);
$ort = str_replace(","," ",$ort);
$ort = str_replace(".",". ",$ort);
$ort = str_replace(".  ","..",$ort);
$ort = str_replace(". ","..",$ort);
$ort = str_replace(" AND "," ",$ort);
$ort = str_replace(" OR "," ",$ort);
$ortabf = explode(" ",$ort); $sql .= " AND (";
if($ortdis!="" && $ortdis!=0 && $ortdis<101) {
$oc=0; while($ortabf[$oc]!="") { $ortabf[$oc] = str_replace("..",". ",$ortabf[$oc]);
$ortabf[$oc] = str_replace("::"," ",$ortabf[$oc]);
$pres = mysqli_query($db,"SELECT ort, land, laenge_WGS84, breite_WGS84 FROM ".$dbx."_geodata WHERE ort = '".$ort."' ORDER BY einwohner DESC");
$dt = mysqli_fetch_array($pres); if($dt[laenge_WGS84]!="") $koo[] = $dt[laenge_WGS84].";".$dt[breite_WGS84];
if($dt[ort]=="") { $ortunbekannt="ja"; $ortName = ucfirst($ort); }
else $ortName = $dt[ort];
$oc++; }
$koo = @array_unique($koo); $oc=0; while($koo[$oc]!="") {
$nr = explode(";",$koo[$oc]); $phi = $nr[0]; $theta = $nr[1];
$mcres = mysqli_query($db,"SELECT ort FROM ".$dbx."_geodata WHERE SQRT(POW(".$phi."-laenge_WGS84,2)*6400 + POW(".$theta."-breite_WGS84,2)*12100) < ".$ortdis." ORDER BY einwohner DESC");
while($dtt = mysqli_fetch_array($mcres)) { if($dtt[ort]!="") { $sc=0; $pzu = explode(",",$dtt[ort]);
while($epz = $pzu[$sc]) { $orts[] = $epz; $sc++; }}}
$oc++; }}
$oc=0; while($orts[$oc]!="") {
$umkreisorte.=$orts[$oc].'||';
$sql .= "ort='".$orts[$oc]."' OR "; $oc++; }
$sql .= "ort = '".$ort."'";
$sql .= ")";

}


$order=htmlspecialchars(stripslashes($_POST[order]));
if(!$order) $order=htmlspecialchars(stripslashes($_GET[order]));

if($order=="start") $sql .= " ORDER BY kurstag1_von";
elseif($order=="datum") $sql .= " ORDER BY datum DESC";
else $sql .= " ORDER BY teilnehmer DESC, datum DESC";






if($pageTitel=="") $pageTitel = 'Kursangebote';
if($ortName!="") $pageTitel .= ' in '.$ortName;
if($dt[land]!="DE" && $dt[land]!="") $pageTitel .= ', '.countrycode($dt[land]);
echo '<legend>'.$katIcon.$pageTitel.'</legend>';
$DO_TITEL=$pageTitel;




echo '<div class="row">';
echo '<div class="col-lg-4 col-sm-5">

<form action="index.php" method="get" class="form-horizontal" accept-charset="UTF-8"><input type="hidden" name="d" value="kurse">

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_tags.png width=16 height=16 align=absmiddle></span>
<select name="kat" class="form-control" style="padding-left:8px;">
<option value="">Alle Kategorien</option>';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($kat==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[kat].'</option>';
}

echo '</select>
</div>
</div>

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_suchen.png width=16 height=16 align=absmiddle></span>
<input type="text" name="qq" class="form-control" placeholder="Volltextsuche" value="'.$qq.'">
</div>
</div>

<br>


<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_marker.png width=16 height=16 align=absmiddle></span>
<input type="text" name="ort" class="form-control" placeholder="Ort" value="'.$ortName.'">
</div>
</div>

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_umkreis.png width=16 height=16 align=absmiddle></span>
<div class="form-control">
und im Umkreis von <select name=umkreis>
<option'; if($ortdis==0) echo ' selected'; echo '>0
<option'; if($ortdis==5 || $ortdis=="") echo ' selected'; echo '>5
<option'; if($ortdis==10) echo ' selected'; echo '>10
<option'; if($ortdis==25) echo ' selected'; echo '>25
<option'; if($ortdis==50) echo ' selected'; echo '>50
</select> km
</div>
</div>
</div>



<div style="margin-bottom:5px;">
&nbsp; <input type="checkbox" name="virtuell" value="ok"'; if($virtuell=="ok") echo ' checked'; echo '>
Nur &nbsp;<img src=images/ico_skype.png width=14 height=14 align=absmiddle> Skype &nbsp;<img src=images/ico_hangouts.png width=14 height=14 align=absmiddle> Hangouts &nbsp;<img src=images/ico_telefon.png width=14 height=14 align=absmiddle> Telefon
</div>


<br>



<div style="margin-bottom:30px;">
<input type=submit value=Suchen class="btn btn-default" style=width:100%>
</div>

</form>






</div>
<div class="col-lg-8 col-sm-7">';



$limiter=8;
$seite=$_GET[seite];
if(!$seite || $seite==0) $sza=0;
else $sza = $seite * $limiter;
$acc=0;

$getukcounter = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE (standort NOT LIKE 'vorort' OR (kurstag1_von > ".time()." AND standort='vorort'))".$sql);
$ukcounter=mysqli_num_rows($getukcounter);
$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE (standort NOT LIKE 'vorort' OR (kurstag1_von > ".time()." AND standort='vorort'))".$sql." LIMIT ".$sza.",".$limiter);

$aaanz=$ukcounter;
$ap1=$sza+1;
$dsanz=$ap1+$limiter;
if($aaanz<$dsanz) $dsanz=$aaanz;
$ans=ceil($aaanz/$limiter);
$aks=$seite+1;
$next=$seite+1;
$prev=$seite-1;





if($ortunbekannt=="ja" && $ukcounter==0) {
echo '<div class="alert alert-danger"><b>Ups!</b> Der Ort "'.ucfirst($ort).'" ist uns unbekannt.</div>';
$exOrt1 = explode(' ',$ort);
$exOrt2 = explode('-',$ort);
$altOrte = mysqli_query($db,"SELECT ort,land FROM ".$dbx."_geodata WHERE ort LIKE '".$ort."%' OR ort LIKE '".$exOrt1[0]."%' OR ort LIKE '".$exOrt2[0]."%' ORDER BY einwohner DESC LIMIT 0,10");
if(mysqli_num_rows($altOrte)>3) {
echo '<div style="padding:15px;margin-top:-20px;">Meinten Sie vielleicht einen der folgenden Orte?';
while($fetchAltOrte=mysqli_fetch_array($altOrte)) {
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('kurse',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
else {
$altOrte = mysqli_query($db,"SELECT ort,land FROM ".$dbx."_geodata WHERE ort LIKE '".$ort."%' OR ort LIKE '".$exOrt1[0]."%' OR ort LIKE '".$exOrt2[0]."%' OR ort LIKE '".$ort[0].$ort[1].$ort[2]."%' ORDER BY einwohner DESC LIMIT 0,10");
if(mysqli_num_rows($altOrte)!=0) {
echo '<div style="padding:15px;margin-top:-20px;">Meinten Sie vielleicht einen der folgenden Orte?';
while($fetchAltOrte=mysqli_fetch_array($altOrte)) {
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('kurse',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
}
echo '</div>';
}





elseif($ukcounter==0) echo '<div class="alert alert-danger"><b>Ups!</b> Leider keine passenden Kurse gefunden.</div>';
else {
echo '<table class="table table-hover"><thead><tr><td colspan=3><style>
@media all and (max-width: 480px) {
#centerdiv{text-align:center !important;}
}
</style><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;" id="centerdiv">'; if($ukcounter==1) echo 'Ein Kursangebot'; else echo $ukcounter.' Kursangebote'; echo ' gefunden</div><div class="col-lg-6 col-sm-6" style="text-align:right;" id="centerdiv"><form action=index.php method=get><input type=hidden name=d value="kurse"><input type=hidden name=ort value="'.$ort.'"><input type=hidden name=umkreis value="'.$umkreis.'"><input type=hidden name=kat value="'.$kat.'"><input type=hidden name=qq value="'.$qq.'"><input type=hidden name=virtuell value="'.$virtuell.'"><select name=order class=small onChange="this.form.submit()">

<option value=beliebt>Beliebte Kurse zuerst
<option value=datum'; if($order=="datum") echo ' selected'; echo '>Neu angebotene Kurse zuerst
<option value=start'; if($order=="start") echo ' selected'; echo '>Bald startende Kurse zuerst

</select></form></div></td></tr></thead>';

while($kurs=mysqli_fetch_array($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-3 col-sm-4 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;box-shadow: 2px 2px 2px #ddd;" class="bigroundcorners"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'">';

if(file_exists("fotos/".$kurs[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$kurs[id]."_1_t.png")==1) echo '<img src="fotos/'.$kurs[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-9 col-sm-8 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'">'.$kurs[titel].'</a></div>';

// $kursdauer = (($kurs[kurstag1_bis]-$kurs[kurstag1_von]) + ($kurs[kurstag2_bis]-$kurs[kurstag2_von]) + ($kurs[kurstag3_bis]-$kurs[kurstag3_von]) + ($kurs[kurstag4_bis]-$kurs[kurstag4_von]) + ($kurs[kurstag5_bis]-$kurs[kurstag5_von])) / 3600;

$kursdauer = ($kurs[kurstag1_bis]-$kurs[kurstag1_von]) / 3600;

$kurstage=1;
if($kurs[kurstag2_bis]!="0") $kurstage++;
if($kurs[kurstag3_bis]!="0") $kurstage++;
if($kurs[kurstag4_bis]!="0") $kurstage++;
if($kurs[kurstag5_bis]!="0") $kurstage++;

echo '
<div style="padding-bottom:2px;color:#888;">'.number_format($kurs[kosten],2).' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo ' &middot; '.$kurs[teilnehmer].' Teilnehmer bisher</div>

<div style="padding-bottom:5px;color:#888;">';

if($kurs[standort]=="vorort") {
if($kurstage>1) echo 'Ab '; else echo 'Am '; echo date("j. ",$kurs[kurstag1_von]).nr2monat(date("n",$kurs[kurstag1_von]));
echo ' in <img src=images/ico_marker2.png width=16 height=16 align=absmiddle><a href="'.genUrl('kurse',urlencode($kurs[ort])).'">'.$kurs[ort].'</a> &middot; '; if($kurstage>1) echo $kurstage.' Kurstage à '; echo str_replace(",0", "", number_format($kursdauer,1,",","")).' Stunden';
}
else {
if($kurs[standort]=="skype") echo 'Via <img src=images/ico_skype.png width=20 height=20 align=absmiddle> Skype &middot; ';
elseif($kurs[standort]=="hangouts") echo 'Via <img src=images/ico_hangouts.png width=20 height=20 align=absmiddle> Google Hangouts &middot; ';
elseif($kurs[standort]=="telefon") echo 'Via <img src=images/ico_telefon.png width=20 height=20 align=absmiddle> Telefon &middot; ';
if($kurs[dauer]=="0.5") echo '30 Minuten';
elseif($kurs[dauer]=="1") echo '1 Stunde';
else echo $kurs[dauer].' Stunden';
}

echo '</div>

<div style="padding-bottom:5px;"><a href="'.genURL('kurs',$kurs[id],urlseotext($kurs[titel])).'" style="text-decoration:none;color:#333;">'.textKuerzen(strip_tags($kurs[cont]),50).'</a></div></div>
<div style="padding-bottom:5px;color:#888;">

</div>

</div>

<style>
#preisdiv{margin-left:15px;text-align:right;}
@media all and (max-width: 480px) {
#preisdiv{text-align:center;}
}
</style>
</div></td></tr>';
}

echo '</table>';






function pageLink($i,$stat="link") {
$dp=$i+1; global $coredata; global $d; global $ort; global $umkreis; global $kat; global $virtuell; global $qq;
if($stat=="link") return "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&kat=".$kat."&qq=".$qq."&virtuell=".$virtuell."&seite=".$i."\">".$dp."</a></li>";
elseif($stat=="current") return "<li class=active><a href=\"#\">".$dp."</a></li>";
else return "<li class=disabled><a href=\"#\">".$dp."</a></li>";
}

echo '<div style="margin-top:-20px;width:100%;height:1;border-top:1px solid #ddd;"></div><div style="text-align:center;"><ul class="pagination">';
if($seite>0) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&kat=".$kat."&qq=".$qq."&virtuell=".$virtuell."&seite=".$prev."\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";
else echo "<li class=disabled><a href=\"#\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";

if($seite>2) echo pageLink('0');
if($seite>3) echo "<li class=disabled><a href=\"#\">...</a></li>";
for($i=$seite-2; $i<$seite+3; $i++) {
if($i>-1 && $i<$ans) {
if($i==$seite) echo pageLink($i,'current');
else echo pageLink($i);
}}
if($ans>$seite+4) echo "<li class=disabled><a href=\"#\">...</a></li>";
if($ans>$seite+3) echo pageLink($ans-1);

if($aaanz>$dsanz) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&kat=".$kat."&qq=".$qq."&virtuell=".$virtuell."&seite=".$next."\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
else echo "<li class=disabled><a href=\"#\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
echo "</ul></div>";



}
















echo '</div>';

?>