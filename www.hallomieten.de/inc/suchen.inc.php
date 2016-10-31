<?php



$kat=htmlspecialchars(stripslashes($_POST[kat]));
if(!$kat) $kat=htmlspecialchars(stripslashes($_GET[kat]));
$qq=htmlspecialchars(stripslashes($_POST[qq]));
if(!$qq) $qq=htmlspecialchars(stripslashes($_GET[qq]));

if($kat!="") $sql .= " AND kat = '".$kat."'";

if($qq!="") $sql .= " AND (titel LIKE '%".$qq."%' OR cont LIKE '%".$qq."%')";

$preismin=htmlspecialchars(stripslashes($_POST[preismin]));
$preismax=htmlspecialchars(stripslashes($_POST[preismax]));
if(!$preismin) $preismin=htmlspecialchars(stripslashes($_GET[preismin]));
if(!$preismax) $preismax=htmlspecialchars(stripslashes($_GET[preismax]));
if($preismin=="" || $preismin<5) $preismin=5;
if($preismax=="" || $preismax>500) $preismax=500;

$sql .= " AND preis_tag >= ".$preismin." AND preis_tag <= ".$preismax."";

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
$pres = mysql_query("SELECT ort, land, laenge_WGS84, breite_WGS84 FROM ".$dbx."_geodata WHERE ort = '".$ort."' ORDER BY einwohner DESC");
$dt = mysql_fetch_array($pres); if($dt[laenge_WGS84]!="") $koo[] = $dt[laenge_WGS84].";".$dt[breite_WGS84];
if($dt[ort]=="") { $ortunbekannt="ja"; $ortName = ucfirst($ort); }
else $ortName = $dt[ort];
$oc++; }
$koo = @array_unique($koo); $oc=0; while($koo[$oc]!="") {
$nr = explode(";",$koo[$oc]); $phi = $nr[0]; $theta = $nr[1];
$mcres = mysql_query("SELECT ort FROM ".$dbx."_geodata WHERE SQRT(POW(".$phi."-laenge_WGS84,2)*6400 + POW(".$theta."-breite_WGS84,2)*12100) < ".$ortdis." ORDER BY einwohner DESC");
while($dtt = mysql_fetch_array($mcres)) { if($dtt[ort]!="") { $sc=0; $pzu = explode(",",$dtt[ort]);
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

if($order=="preis") $sql .= " ORDER BY preis_tag";
elseif($order=="groesse") $sql .= " ORDER BY groesse DESC";
else $sql .= " ORDER BY datum DESC";






$pageTitel = 'Gegenstände';
if($ortName!="") $pageTitel .= ' in '.$ortName;
else $pageTitel .= ' suchen';
if($dt[land]!="DE" && $dt[land]!="") $pageTitel .= ', '.countrycode($dt[land]);
echo '<legend>'.$pageTitel.'</legend>';
$DO_TITEL=$pageTitel;




echo '<div class="row">';
echo '<div class="col-lg-4 col-sm-5">

<form action="index.php" method="get" class="form-horizontal"><input type="hidden" name="d" value="suchen">



<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_suchen.png width=16 height=16 align=absmiddle></span>
<input type="text" name="qq" class="form-control" placeholder="Volltextsuche" value="'.$qq.'">
</div>
</div>

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_tags.png width=16 height=16 align=absmiddle></span>
<select name="kat" class="form-control" style="padding-left:8px;">
<option value="">Alle Kategorien</option>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
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





<script>
'; if($coredata['waehrung']=="EUR") $waehrung = '€'; else $waehrung = $coredata['waehrung']; echo '
$(function() {
    $( "#slider-preis" ).slider({
        range: true,
        min: 5,
        max: 500,
        step: 5,
        values: [ '.$preismin.', '.$preismax.' ],
        slide: function( event, ui ) {
            $( "#preismin" ).val( ui.values[ 0 ]);
            $( "#preismax" ).val( ui.values[ 1 ]);
            $( "#preisbereich" ).val( ui.values[ 0 ] + " '.$waehrung.' bis " + ui.values[ 1 ] + " '.$waehrung.'" );
        }
    });
    $( "#preismin" ).val($( "#slider-preis" ).slider( "values", 0 ));
    $( "#preismax" ).val($( "#slider-preis" ).slider( "values", 1 ) );
    $( "#preisbereich" ).val( $( "#slider-preis" ).slider( "values", 0 ) + " '.$waehrung.' bis " + $( "#slider-preis" ).slider( "values", 1 ) + " '.$waehrung.'" );
});
</script>

<div style="margin-bottom:10px;margin-left:9px;margin-right:8px;">
<label for="preisbereich" style="width:120px;">Mietpreis pro Tag:</label>
<input type="text" id="preisbereich" style="width:150px;border: 0; color: #f6931f; font-weight: bold; text-align:right;">
<input type="hidden" id="preismin" name="preismin" value='.$preismin.'>
<input type="hidden" id="preismax" name="preismax" value='.$preismax.'>
<div id="slider-preis"></div>
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

$getukcounter = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE status='ok'".$sql);
$ukcounter=mysql_num_rows($getukcounter);
$getuk = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE status='ok'".$sql." LIMIT ".$sza.",".$limiter);

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
$altOrte = mysql_query("SELECT ort,land FROM ".$dbx."_geodata WHERE ort LIKE '".$ort."%' OR ort LIKE '".$exOrt1[0]."%' OR ort LIKE '".$exOrt2[0]."%' ORDER BY einwohner DESC LIMIT 0,10");
if(mysql_num_rows($altOrte)>3) {
echo '<div style="padding:15px;margin-top:-20px;">Meinten Sie vielleicht einen der folgenden Orte?';
while($fetchAltOrte=mysql_fetch_array($altOrte)) {
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('suchen',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
else {
$altOrte = mysql_query("SELECT ort,land FROM ".$dbx."_geodata WHERE ort LIKE '".$ort."%' OR ort LIKE '".$exOrt1[0]."%' OR ort LIKE '".$exOrt2[0]."%' OR ort LIKE '".$ort[0].$ort[1].$ort[2]."%' ORDER BY einwohner DESC LIMIT 0,10");
if(mysql_num_rows($altOrte)!=0) {
echo '<div style="padding:15px;margin-top:-20px;">Meinten Sie vielleicht einen der folgenden Orte?';
while($fetchAltOrte=mysql_fetch_array($altOrte)) {
echo '<div style="padding-top:4px;"><img src=images/flaggen/'.strtolower($fetchAltOrte[land]).'.gif width=18 height=12 align=absmiddle> <a href="'.genUrl('suchen',urlencode($fetchAltOrte[ort])).'">'.$fetchAltOrte[ort].'</a></div>';
}
}
}
echo '</div>';
}





elseif($ukcounter==0) echo '<div class="alert alert-danger"><b>Ups!</b> Leider keine passenden Gegenstände gefunden.</div>';
else {
echo '<table class="table table-hover"><thead><tr><td colspan=3><style>
@media all and (max-width: 480px) {
#centerdiv{text-align:center !important;}
}
</style><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;" id="centerdiv">'; if($ukcounter==1) echo 'Ein Gegenstand'; else echo $ukcounter.' Gegenstände'; echo ' gefunden</div><div class="col-lg-6 col-sm-6" style="text-align:right;" id="centerdiv"><form action=index.php method=get><input type=hidden name=d value="suchen"><input type=hidden name=ort value="'.$ort.'"><input type=hidden name=umkreis value="'.$umkreis.'"><input type=hidden name=kat value="'.$kat.'"><input type=hidden name=qq value="'.$qq.'"><input type=hidden name=preismin value="'.$preismin.'"><input type=hidden name=preismax value="'.$preismax.'"><select name=order class=small onChange="this.form.submit()">

<option value=beliebt>Beliebte Gegenstände zuerst
<option value=datum'; if($order=="datum") echo ' selected'; echo '>Neueste Gegenstände zuerst
<option value=preis'; if($order=="preis") echo ' selected'; echo '>Niedrigster Preis zuerst

</select></form></div></td></tr></thead>';

while($gegenstand=mysql_fetch_array($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-3 col-sm-4 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;box-shadow: 2px 2px 2px #ddd;" class="bigroundcorners"><a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'">';

if(file_exists("fotos/".$gegenstand[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$gegenstand[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("fotos/".$gegenstand[id]."_1_t.png")==1) echo '<img src="fotos/'.$gegenstand[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-7 col-sm-5 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'">'.$gegenstand[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($gegenstand[kat]==$fetchArt[id]) echo $fetchArt[kat];
}

echo ' &middot; <a href="'.genUrl('suchen',urlencode($gegenstand[ort])).'">'.$gegenstand[ort].'</a></div>

<div style="padding-bottom:5px;">';

$getprofil=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$gegenstand[user]."'");
$profil=mysql_fetch_array($getprofil);

if($coredata['user']=="user") $urlUsername=$profil[user]; else $urlUsername=$profil[id];
echo '<a href="'.genURL('user',$urlUsername).'">';

if(file_exists("avatar/".$profil[id]."_t.jpg")==1) echo '<img src="avatar/'.$profil[id].'_t.jpg?'.(time()-1300000000).'"';
elseif(file_exists("avatar/".$profil[id]."_t.png")==1) echo '<img src="avatar/'.$profil[id].'_t.png?'.(time()-1300000000).'"';
else echo '<img src="avatar/user.gif"';
echo ' width=44 height=44 style="border:1px solid #ccc;margin-right:7px;" id="profilfoto" class="img-circle hidden-sm" align=left valign=absmiddle></a>';

echo '<a href="'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'" style="text-decoration:none;color:#333;">'.textKuerzen(strip_tags($gegenstand[cont]),50).'</a></div>
<div style="padding-bottom:5px;color:#888;">

</div>

</div>

<style>
#preisdiv{margin-left:15px;text-align:right;}
@media all and (max-width: 480px) {
#preisdiv{text-align:center;}
}
</style>
<div class="col-lg-2 col-sm-3 col-12" id="preisdiv">

<span style="font-weight:bold;font-size:20px;letter-spacing:-1px;">'.$gegenstand[preis_tag].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span><br>pro Tag

</div></div></td></tr>';
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