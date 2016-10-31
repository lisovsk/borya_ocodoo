<?php



$kat=htmlspecialchars(stripslashes($_POST[kat]));
if(!$kat) $kat=htmlspecialchars(stripslashes($_GET[kat]));
$qq=htmlspecialchars(stripslashes($_POST[qq]));
if(!$qq) $qq=htmlspecialchars(stripslashes($_GET[qq]));

if($kat!="") $sql .= " AND kat = '".$kat."'";

if($qq!="") $sql .= " AND (titel LIKE '%".$qq."%' OR cont LIKE '%".$qq."%')";

$ort=htmlspecialchars(stripslashes($_POST[ort]));
if(!$ort) $ort=htmlspecialchars(stripslashes($_GET[ort]));
if($s!="") $ort = urldecode($s);

$ortdis=htmlspecialchars(stripslashes($_POST[umkreis]));
if(!$ortdis) $ortdis=htmlspecialchars(stripslashes($_GET[umkreis]));
if($ortdis=="") $ortdis="5";

if($ort!="") {

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

if($order=="ende") $sql .= " ORDER BY datum_ende";
else $sql .= " ORDER BY datum DESC";






$pageTitel = 'Aufträge';
if($ortName!="") $pageTitel .= ' in '.$ortName;
else $pageTitel .= ' suchen';
if($dt[land]!="DE" && $dt[land]!="") $pageTitel .= ', '.countrycode($dt[land]);
echo '<legend>'.$pageTitel.'</legend>';
$DO_TITEL=$pageTitel;




echo '<div class="row">';
echo '<div class="col-lg-4 col-sm-5">

<form action="index.php" method="get" class="form-horizontal" accept-charset="UTF-8"><input type="hidden" name="d" value="suchen">



<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_suchen.png width=16 height=16 align=absmiddle></span>
<input type="text" name="qq" class="form-control" placeholder="Volltextsuche" value="'.$qq.'">
</div>
</div>

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

$getukcounter = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE datum_ende > ".time()." AND status='ok'".$sql);
$ukcounter=mysqli_num_rows($getukcounter);
$getuk = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE datum_ende > ".time()." AND status='ok'".$sql." LIMIT ".$sza.",".$limiter);

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
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('suchen',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
else {
$altOrte = mysqli_query($db,"SELECT ort,land FROM ".$dbx."_geodata WHERE ort LIKE '".$ort."%' OR ort LIKE '".$exOrt1[0]."%' OR ort LIKE '".$exOrt2[0]."%' OR ort LIKE '".$ort[0].$ort[1].$ort[2]."%' ORDER BY einwohner DESC LIMIT 0,10");
if(mysqli_num_rows($altOrte)!=0) {
echo '<div style="padding:15px;margin-top:-20px;">Meinten Sie vielleicht einen der folgenden Orte?';
while($fetchAltOrte=mysqli_fetch_array($altOrte)) {
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('suchen',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
}
echo '</div>';
}





elseif($ukcounter==0) echo '<div class="alert alert-danger"><b>Ups!</b> Leider keine passenden Aufträge gefunden.</div>';
else {
echo '<table class="table table-hover"><thead><tr><td colspan=3><style>
@media all and (max-width: 480px) {
#centerdiv{text-align:center !important;}
}
</style><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;" id="centerdiv">'; if($ukcounter==1) echo 'Ein Auftrag'; else echo $ukcounter.' Aufträge'; echo ' gefunden</div><div class="col-lg-6 col-sm-6" style="text-align:right;" id="centerdiv"><form action=index.php method=get><input type=hidden name=d value="suchen"><input type=hidden name=ort value="'.$ort.'"><input type=hidden name=umkreis value="'.$umkreis.'"><input type=hidden name=kat value="'.$kat.'"><input type=hidden name=qq value="'.$qq.'"><select name=order class=small onChange="this.form.submit()">

<option value=beliebt>Beliebte Aufträge zuerst
<option value=datum'; if($order=="datum") echo ' selected'; echo '>Neueste Aufträge zuerst
<option value=ende'; if($order=="ende") echo ' selected'; echo '>Bald endende Aufträge zuerst

</select></form></div></td></tr></thead>';

while($auftrag=mysqli_fetch_array($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-3 col-sm-4 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;box-shadow: 2px 2px 2px #ddd;" class="bigroundcorners"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">';

if(file_exists("fotos/".$auftrag[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$auftrag[id]."_1_t.png")==1) echo '<img src="fotos/'.$auftrag[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-9 col-sm-8 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'">'.$auftrag[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
if($auftrag[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

$getAngebote = mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE auftrag='".$auftrag[id]."'");
$anzAngebote = mysqli_num_rows($getAngebote);

echo ' &middot; <img src=images/ico_marker.png width=16 height=16 align=absmiddle><a href="'.genUrl('suchen',urlencode($auftrag[ort])).'">'.$auftrag[ort].'</a></div>

<div style="padding-bottom:5px;color:#888;"><img src=images/ico_countdown.png width=16 height=16 align=absmiddle> '.calcCountdown($auftrag[datum_ende]).', '.$anzAngebote.' Angebot'; if($anzAngebote!=1) echo 'e'; echo ' bisher</div>

<div style="padding-bottom:5px;">';

$getprofil=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$auftrag[user]."'");
$profil=mysqli_fetch_array($getprofil);

echo '<a href="'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'" style="text-decoration:none;color:#333;">'.textKuerzen(strip_tags($auftrag[cont]),50).'</a></div>
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
$dp=$i+1; global $coredata; global $d; global $ort; global $umkreis; global $art; global $anzgaeste; global $preismin; global $preismax; global $schlafzimmermax; global $schlafzimmermin; global $badezimmermax; global $badezimmermin; global $groessemin; global $groessemax;
if($stat=="link") return "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$i."\">".$dp."</a></li>";
elseif($stat=="current") return "<li class=active><a href=\"#\">".$dp."</a></li>";
else return "<li class=disabled><a href=\"#\">".$dp."</a></li>";
}

echo '<div style="margin-top:-20px;width:100%;height:1;border-top:1px solid #ddd;"></div><div style="text-align:center;"><ul class="pagination">';
if($seite>0) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$prev."\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";
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

if($aaanz>$dsanz) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$next."\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
else echo "<li class=disabled><a href=\"#\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
echo "</ul></div>";



}
















echo '</div>';

?>