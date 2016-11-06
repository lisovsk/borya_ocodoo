<?
include("core.class.inc.php");

mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db($dbdata);


$art=htmlspecialchars(stripslashes($_POST[art]));
if(!$art) $art=htmlspecialchars(stripslashes($_GET[art]));

if($art!="") $sql .= " AND art = '".$art."'";

$anzgaeste=htmlspecialchars(stripslashes($_POST[anzgaeste]));
if(!$anzgaeste) $anzgaeste=htmlspecialchars(stripslashes($_GET[anzgaeste]));

if($anzgaeste!="") $sql .= " AND max_gaeste >= ".$anzgaeste."";

$preismin=htmlspecialchars(stripslashes($_POST[preismin]));
$preismax=htmlspecialchars(stripslashes($_POST[preismax]));
if(!$preismin) $preismin=htmlspecialchars(stripslashes($_GET[preismin]));
if(!$preismax) $preismax=htmlspecialchars(stripslashes($_GET[preismax]));
if($preismin=="" || $preismin<5) $preismin=5;
if($preismax=="" || $preismax>500) $preismax=500;

$sql .= " AND preis_nacht >= ".$preismin." AND preis_nacht <= ".$preismax."";

$schlafzimmermin=htmlspecialchars(stripslashes($_POST[schlafzimmermin]));
$schlafzimmermax=htmlspecialchars(stripslashes($_POST[schlafzimmermax]));
if(!$schlafzimmermin) $schlafzimmermin=htmlspecialchars(stripslashes($_GET[schlafzimmermin]));
if(!$schlafzimmermax) $schlafzimmermax=htmlspecialchars(stripslashes($_GET[schlafzimmermax]));
if($schlafzimmermin=="" || $schlafzimmermin<1) $schlafzimmermin=1;
if($schlafzimmermax=="" || $schlafzimmermax>10) $schlafzimmermax=10;

$sql .= " AND anz_schlafzimmer >= ".$schlafzimmermin." AND anz_schlafzimmer <= ".$schlafzimmermax."";

$badezimmermin=htmlspecialchars(stripslashes($_POST[badezimmermin]));
$badezimmermax=htmlspecialchars(stripslashes($_POST[badezimmermax]));
if(!$badezimmermin) $badezimmermin=htmlspecialchars(stripslashes($_GET[badezimmermin]));
if(!$badezimmermax) $badezimmermax=htmlspecialchars(stripslashes($_GET[badezimmermax]));
if($badezimmermin=="" || $badezimmermin<1) $badezimmermin=1;
if($badezimmermax=="" || $badezimmermax>10) $badezimmermax=10;

$sql .= " AND anz_badezimmer >= ".$badezimmermin." AND anz_badezimmer <= ".$badezimmermax."";

$groessemin=htmlspecialchars(stripslashes($_POST[groessemin]));
$groessemax=htmlspecialchars(stripslashes($_POST[groessemax]));
if(!$groessemin) $groessemin=htmlspecialchars(stripslashes($_GET[groessemin]));
if(!$groessemax) $groessemax=htmlspecialchars(stripslashes($_GET[groessemax]));
if($groessemin=="" || $groessemin<0) $groessemin=0;
if($groessemax=="" || $groessemax>200) $groessemax=200;

$sql .= " AND groesse >= ".$groessemin." AND groesse <= ".$groessemax."";

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

if($order=="preis") $sql .= " ORDER BY preis_nacht";
elseif($order=="groesse") $sql .= " ORDER BY groesse DESC";
else $sql .= " ORDER BY datum DESC";






$pageTitel = 'Unterkünfte';
if($ortName!="") $pageTitel .= ' in '.$ortName;
else $pageTitel .= ' suchen';
if($dt[land]!="DE" && $dt[land]!="") $pageTitel .= ', '.countrycode($dt[land]);
$DO_TITEL=$pageTitel;




echo '
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
            // changeStrGet( $( "#preismin" ) );
            // changeStrGet( $( "#preismax" ) );
        }
    });
    $( "#preismin" ).val($( "#slider-preis" ).slider( "values", 0 ));
    $( "#preismax" ).val($( "#slider-preis" ).slider( "values", 1 ) );
    $( "#preisbereich" ).val( $( "#slider-preis" ).slider( "values", 0 ) + " '.$waehrung.' bis " + $( "#slider-preis" ).slider( "values", 1 ) + " '.$waehrung.'" );
});
$(function() {

    $( "#slider-schlafzimmer" ).slider({
        range: true,
        min: 1,
        max: 10,
        values: [ '.$schlafzimmermin.', '.$schlafzimmermax.' ],
        slide: function( event, ui ) {
            $( "#schlafzimmermin" ).val( ui.values[ 0 ]);
            $( "#schlafzimmermax" ).val( ui.values[ 1 ]);
            $( "#schlafbereich" ).val( ui.values[ 0 ] + " bis " + ui.values[ 1 ] );
            // changeStrGet( $( "#schlafzimmermin" ) );
            // changeStrGet( $( "#schlafzimmermax" ) );
        }
    });
    $( "#schlafbereich" ).val( $( "#slider-schlafzimmer" ).slider( "values", 0 ) + " bis " + $( "#slider-schlafzimmer" ).slider( "values", 1 ) );
});
$(function() {

    $( "#slider-badezimmer" ).slider({
        range: true,
        min: 1,
        max: 10,
        values: [ '.$badezimmermin.', '.$badezimmermax.' ],
        slide: function( event, ui ) {
            $( "#badezimmermin" ).val( ui.values[ 0 ]);
            $( "#badezimmermax" ).val( ui.values[ 1 ]);
            $( "#badezimmerbereich" ).val( ui.values[ 0 ] + " bis " + ui.values[ 1 ] );
            // changeStrGet( $( "#badezimmermin" ) );
            // changeStrGet( $( "#badezimmermax" ) );
        }
    });
    $( "#badezimmerbereich" ).val( $( "#slider-badezimmer" ).slider( "values", 0 ) + " bis " + $( "#slider-badezimmer" ).slider( "values", 1 ) );
});
$(function() {

    $( "#slider-groesse" ).slider({
        range: true,
        min: 0,
        max: 200,
        step: 10,
        values: [ '.$groessemin.', '.$groessemax.' ],
        slide: function( event, ui ) {
            $( "#groessemin" ).val( ui.values[ 0 ]);
            $( "#groessemax" ).val( ui.values[ 1 ]);
            $( "#groessebereich" ).val( ui.values[ 0 ] + " bis " + ui.values[ 1 ] + " m2" );
            // changeStrGet( $( "#groessemin" ) );
            // changeStrGet( $( "#groessemax" ) );
        }
    });
    $( "#groessebereich" ).val( $( "#slider-groesse" ).slider( "values", 0 ) + " bis " + $( "#slider-groesse" ).slider( "values", 1 ) + " m2" );
});
</script>
<div class="col-lg-8 col-sm-7 js-mouseup">';
$limiter=8;
$seite=$_GET[seite];
if(!$seite || $seite==0) $sza=0;
else $sza = $seite * $limiter;
$acc=0;
$getukcounter = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE status='ok'".$sql);
$ukcounter=mysql_num_rows($getukcounter);
$getuk = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE status='ok'".$sql." LIMIT ".$sza.",".$limiter);

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





elseif($ukcounter==0) echo '<div class="alert alert-danger"><b>Ups!</b> Leider keine passende Unterkunft gefunden.</div>';
else {
echo '<table class="table table-hover"><thead><tr><td colspan=3><style>
@media all and (max-width: 480px) {
#centerdiv{text-align:center !important;}
}
</style><div class="row"><div class="col-lg-6 col-sm-6" style="font-weight:bold;" id="centerdiv">'; if($ukcounter==1) echo 'Eine Unterkunft'; else echo $ukcounter.' Unterkünfte'; echo ' gefunden</div><div class="col-lg-6 col-sm-6" style="text-align:right;" id="centerdiv"><form action=index.php method=get><input type=hidden name=d value="suchen"><input type=hidden name=ort value="'.$ort.'"><input type=hidden name=umkreis value="'.$umkreis.'"><input type=hidden name=art value="'.$art.'"><input type=hidden name=anzgaeste value="'.$anzgaeste.'"><input type=hidden name=preismin value="'.$preismin.'"><input type=hidden name=preismax value="'.$preismax.'"><input type=hidden name=badezimmermin value="'.$badezimmermin.'"><input type=hidden name=badezimmermax value="'.$badezimmermax.'"><input type=hidden name=schlafzimmermin value="'.$schlafzimmermin.'"><input type=hidden name=schlafzimmermax value="'.$schlafzimmermax.'"><input type=hidden name=groessemin value="'.$groessemin.'"><input type=hidden name=groessemax value="'.$groessemax.'"><select name=order class=small>

<option value=datum>Neueste Unterkünfte zuerst
<option value=preis'; if($order=="preis") echo ' selected'; echo '>Niedrigster Preis zuerst
<option value=groesse'; if($order=="groesse") echo ' selected'; echo '>Grösste Fläche zuerst

</select></form></div></td></tr></thead>';

while($unterkunft=mysql_fetch_array($getuk)) {
echo '<tr><td><div class="row"><div class="col-lg-3 col-sm-4 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;box-shadow: 2px 2px 2px #ddd;" class="bigroundcorners"><a href="'.genURL('unterkunft',$unterkunft[id],urlseotext($unterkunft[titel])).'">';

if(file_exists("../../fotos/".$unterkunft[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$unterkunft[id].'_1_t.jpg" border=0 style="width:100%;">';
elseif(file_exists("../../fotos/".$unterkunft[id]."_1_t.png")==1) echo '<img src="fotos/'.$unterkunft[id].'_1_t.png" border=0 style="width:100%;">';

else echo '<img src="fotos/leer.gif" border=0 style="width:100%;">';
echo '</a></div></div><div class="col-lg-7 col-sm-5 col-6">

<style>
#titeldiv{padding-bottom:5px;font-size:18px;font-weight:bold;line-height:22px;}
@media all and (max-width: 480px) {
#titeldiv{font-size:14px;}
}
</style>
<div id="titeldiv"><a href="'.genURL('unterkunft',$unterkunft[id],urlseotext($unterkunft[titel])).'">'.$unterkunft[titel].'</a></div>

<div style="padding-bottom:5px;color:#888;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
if($unterkunft[art]==$fetchArt[id]) echo $fetchArt[art];
}

echo ' &middot; <a href="'.genUrl('suchen',urlencode($unterkunft[ort])).'">'.$unterkunft[ort].'</a></div>
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

<span style="font-weight:bold;font-size:20px;letter-spacing:-1px;">'.$unterkunft[preis_nacht].',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span><br>pro Nacht

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
if($seite>0) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$i."\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";
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

if($aaanz>$dsanz) echo "<li><a href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$i."\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
else echo "<li class=disabled><a href=\"#\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
echo "</ul></div>";



}