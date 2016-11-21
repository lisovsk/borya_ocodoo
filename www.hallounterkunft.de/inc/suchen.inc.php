
<script src="javascript/jquery-scrollto.js"></script>
<?php
echo'
<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
<div class="search-nav-mobile">
    <a  class="search-nav-mobile__item search-nav-mobile__results js-search-nav-mobile__results" style="display:none;">Ergebnisse</a>
    <a  class="search-nav-mobile__item search-nav-mobile__map js-search-nav-mobile__map"'; if($_GET[view]=="map") {echo 'style="display:none;"';} echo '>Karte</a>
    <a  class="search-nav-mobile__item search-nav-mobile__filter js-search-nav-mobile__filter"'; if($_GET[view]=="items") {echo 'style="display:none;"';} echo '>Filter</a>
</div>';

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
echo '<legend>'.$pageTitel.'</legend>';
$DO_TITEL=$pageTitel;




echo '<div class="row">';
echo '<div class="col-lg-4 col-sm-5 saerch">

<form action="index.php" method="get" class="form-horizontal js-get-param"><input type="hidden" name="d" value="suchen">

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_marker.png width=16 height=16 align=absmiddle></span>
<input type="text" name="ort" class="form-control" placeholder="Wo soll es hingehen?" style="font-size:18px;font-weight:bold;" value="'.$ortName.'">
</div>
</div>';

include("components/php/date-picker.php");

echo '<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_umkreis.png width=16 height=16 align=absmiddle></span>
<div class="form-control">
und im Umkreis von <select name=umkreis value="">
<option value=0'; if($ortdis==0) echo ' selected'; echo '>0
<option value=5'; if($ortdis==5 || $ortdis=="") echo ' selected'; echo '>5
<option value=10'; if($ortdis==10) echo ' selected'; echo '>10
<option value=25'; if($ortdis==25) echo ' selected'; echo '>25
<option value=50'; if($ortdis==50) echo ' selected'; echo '>50
</select> km
</div>
</div>
</div>

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_unterkunft.png width=16 height=16 align=absmiddle></span>
<select value="" name="art" class="form-control" style="padding-left:8px;">
<option value="">Alle Unterkunftsarten</option>';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($art==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[art].'</option>';
}

echo '</select>
</div>
</div>

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_users.png width=16 height=16 align=absmiddle></span>
<select name="anzgaeste" class="form-control" style="padding-left:8px;">
<option value=1'; if($anzgaeste==1) echo ' selected'; echo '>1 Gast</option>
<option value=2'; if($anzgaeste==2 || $anzgaeste=="") echo ' selected'; echo '>2 Gäste</option>
<option value=3'; if($anzgaeste==3) echo ' selected'; echo '>3 Gäste</option>
<option value=4'; if($anzgaeste==4) echo ' selected'; echo '>4 Gäste</option>
<option value=5'; if($anzgaeste==5) echo ' selected'; echo '>5 Gäste</option>
<option value=6'; if($anzgaeste==6) echo ' selected'; echo '>6 Gäste</option>
<option value=7'; if($anzgaeste==7) echo ' selected'; echo '>7 Gäste</option>
<option value=8'; if($anzgaeste==8) echo ' selected'; echo '>8 Gäste</option>
<option value=9'; if($anzgaeste==9) echo ' selected'; echo '>9 Gäste</option>
<option value=10'; if($anzgaeste==10) echo ' selected'; echo '>10 Gäste</option>
<option value=11'; if($anzgaeste==11) echo ' selected'; echo '>11 Gäste</option>
<option value=12'; if($anzgaeste==12) echo ' selected'; echo '>12 Gäste</option>
<option value=13'; if($anzgaeste==13) echo ' selected'; echo '>13 Gäste</option>
<option value=14'; if($anzgaeste==14) echo ' selected'; echo '>14 Gäste</option>
<option value=15'; if($anzgaeste==15) echo ' selected'; echo '>15+ Gäste</option>
</select>
</div>
</div>






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
        }
    });
    $( "#groessebereich" ).val( $( "#slider-groesse" ).slider( "values", 0 ) + " bis " + $( "#slider-groesse" ).slider( "values", 1 ) + " m2" );
});
</script>

<div style="margin-bottom:10px;margin-left:9px;margin-right:8px;">
<label for="preisbereich" style="width:120px;">Preis pro Nacht:</label>
<input type="text" id="preisbereich" style="width:150px;border: 0; color: #f6931f; font-weight: bold; text-align:right;">
<input type="hidden" class="slider-handle-c" id="preismin" name="preismin" value='.$preismin.'>
<input type="hidden" class="slider-handle-c" id="preismax" name="preismax" value='.$preismax.'>
<div id="slider-preis"></div>
</div>

<div style="margin-bottom:10px;margin-left:9px;margin-right:8px;">
<label for="schlafbereich" style="width:120px;">Schlafzimmer:</label>
<input type="text" id="schlafbereich" style="width:150px;border: 0; color: #f6931f; font-weight: bold; text-align:right;">
<input type="hidden" class="slider-handle-c" id="schlafzimmermin" name="schlafzimmermin" value='.$schlafzimmermin.'>
<input type="hidden" class="slider-handle-c" id="schlafzimmermax" name="schlafzimmermax" value='.$schlafzimmermax.'>
<div id="slider-schlafzimmer"></div>
</div>

<div style="margin-bottom:10px;margin-left:9px;margin-right:8px;">
<label for="badezimmerbereich" style="width:120px;">Badezimmer:</label>
<input type="text" id="badezimmerbereich" style="width:150px;border: 0; color: #f6931f; font-weight: bold; text-align:right;">
<input type="hidden" class="slider-handle-c" id="badezimmermin" name="badezimmermin" value='.$badezimmermin.'>
<input type="hidden" class="slider-handle-c" id="badezimmermax" name="badezimmermax" value='.$badezimmermax.'>
<div id="slider-badezimmer"></div>
</div>

<div style="margin-bottom:20px;margin-left:9px;margin-right:8px;">
<label for="groessebereich" style="width:120px;">Fläche:</label>
<input type="text" id="groessebereich" style="width:150px;border: 0; color: #f6931f; font-weight: bold; text-align:right;">
<input type="hidden" class="slider-handle-c" id="groessemin" name="groessemin" value='.$groessemin.'>
<input type="hidden" class="slider-handle-c" id="groessemax" name="groessemax" value='.$groessemax.'>
<div id="slider-groesse"></div>
</div>
<div style="margin-bottom:30px;">
<input type="button"   value="Suchen" class="btn btn-default js-button-search button-search" style="width:100%">
</div>
<div style="margin-bottom:30px;">
<button type="button" class="btn btn-default js-button-search button-search" style="width:100%; background: #fff; color:#3a3c3c; font-weight: bold; outline: none;">Abbrechen</button>
</div>



<div style="margin-bottom:30px;">
</div>

</form>






</div>
<div class="js-ajax-data">
<div class="col-lg-8 col-sm-7">';


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

    echo '
    <div class="row" style="padding: 0 15px;;"><div class="" style="font-weight:bold; float: left; padding-right: 10px;" id="centerdiv">'; if($ukcounter==1) echo 'Eine Unterkunft'; else echo $ukcounter.' Unterkünfte'; echo ' gefunden</div><div class="" style="text-align:left ; padding-left: 0; float: left;" id="centerdiv"><form action=index.php method=get><input type=hidden name=d value="suchen"><input type=hidden name=ort value="'.$ort.'"><input type=hidden name=umkreis value="'.$umkreis.'"><input type=hidden name=art value="'.$art.'"><input type=hidden name=anzgaeste value="'.$anzgaeste.'"><input type=hidden name=preismin value="'.$preismin.'"><input type=hidden name=preismax value="'.$preismax.'"><input type=hidden name=badezimmermin value="'.$badezimmermin.'"><input type=hidden name=badezimmermax value="'.$badezimmermax.'"><input type=hidden name=schlafzimmermin value="'.$schlafzimmermin.'"><input type=hidden name=schlafzimmermax value="'.$schlafzimmermax.'"><input type=hidden name=groessemin value="'.$groessemin.'"><input type=hidden name=groessemax value="'.$groessemax.'"><select name=order class="small">

        <option value=datum>Neueste Unterkünfte zuerst
        <option value=preis'; if($order=="preis") echo ' selected'; echo '>Niedrigster Preis zuerst
        <option value=groesse'; if($order=="groesse") echo ' selected'; echo '>Grösste Fläche zuerst

        </select></form></div><ul style="float: right; margin-bottom: 15px" class="nav nav-tabs nav-tabs-custom" id="myTabs" role="tablist">
        <li role="presentation" class="active presentation-custom"><a href="#home" name="view" value="items" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Listenansicht</a></li>
        <li role="presentation" class="presentation-custom js-map-inicialize"><a href="#profile" name="view" value="map" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Kartenansicht</a></li>
    </ul></div>
    <div class="tab-content js-tab-content" id="myTabContent"> 
        <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">';



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
    </style></td></tr></thead>';

    while($unterkunft=mysql_fetch_array($getuk)) {
    echo '<tr><td><div class="row"><div class="col-lg-3 col-sm-4 col-6" style="margin-right:-15px;"><div style="max-width:260px;max-height:100px;overflow:hidden;box-shadow: 2px 2px 2px #ddd;" class="bigroundcorners"><a href="'.genURL('unterkunft',$unterkunft[id],urlseotext($unterkunft[titel])).'">';

    if(file_exists("fotos/".$unterkunft[id]."_1_t.jpg")==1) echo '<img src="fotos/'.$unterkunft[id].'_1_t.jpg" border=0 style="width:100%;">';
    elseif(file_exists("fotos/".$unterkunft[id]."_1_t.png")==1) echo '<img src="fotos/'.$unterkunft[id].'_1_t.png" border=0 style="width:100%;">';

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

    $dataForMap = array();
    $getuk = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE status='ok'".$sql." LIMIT ".$sza.",10000");
    while($unterkunft=mysql_fetch_array($getuk)) {
        $getgastgeber=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$unterkunft[user]."'");
        $gastgeber = mysql_fetch_array($getgastgeber);

        $apartment =  array("url"=>genURL('unterkunft',$unterkunft[id],urlseotext($unterkunft[titel])));

        if(file_exists("fotos/".$unterkunft[id]."_1_t.jpg")==1) $apartment["srcApartment"] = 'fotos/'.$unterkunft[id].'_1_t.jpg';
        elseif(file_exists("fotos/".$unterkunft[id]."_1_t.png")==1) $apartment["srcApartment"] =  'fotos/'.$unterkunft[id].'_1_t.png';
        else $apartment["srcApartment"] = 'fotos/leer.gif';
        $apartment["title"] = $unterkunft[titel];
       
        $strFetchArt = "";
        $getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
        while($fetchArt = mysql_fetch_array($getArten)) {
        if($unterkunft[art]==$fetchArt[id]) $strFetchArt = $strFetchArt." ".$fetchArt[art];
        }
        $apartment["strFetchArt"] = $strFetchArt;
        $apartment["ortUrl"] = genUrl('suchen',urlencode($unterkunft[ort]));
        $apartment["ortName"] = $unterkunft[ort];
        $price = $unterkunft[preis_nacht].',00 ';
        if($coredata['waehrung']=="EUR") $price = $price.'&euro;'; else $price = $price.$coredata['waehrung'];
        $apartment["price"] = $price;
        $apartment["duration"] = "pro Nacht";
        $apartment["strasse"] = $unterkunft[strasse];

        if($coredata['user']=="user") $urlUsername=$gastgeber[user]; else $urlUsername=$gastgeber[id];
        $apartment["userUrl"] = genURL('user',$urlUsername);

        if($coredata['user']=="user") $apartment["userName"] = ucfirst($gastgeber[user]);
        else $apartment["userName"] = $gastgeber[vorname].' '.$gastgeber[nachname];

        $strAvtar = "avatar/";
        if(file_exists("avatar/".$unterkunft[user]."_t.jpg")==1) $strAvtar = $strAvtar.$unterkunft[user].'_t.jpg';
        elseif(file_exists("avatar/".$unterkunft[user]."_t.png")==1) $strAvtar = $strAvtar.$unterkunft[user].'_t.png';
        else $strAvtar = $strAvtar.'user.gif';
        $apartment["userAvtar"] = $strAvtar;

        $userReiting = "";
        if($bewertung>0.9) $userReiting = $userReiting.'<img src=images/staron.png width=16 height=16>';
        else $userReiting = $userReiting.'<img src=images/staroff.png width=16 height=16>';
        if($bewertung>1.9) $userReiting = $userReiting.'<img src=images/staron.png width=16 height=16>';
        elseif($bewertung>1.1) $userReiting = $userReiting.'<img src=images/starhalf.png width=16 height=16>';
        else $userReiting = $userReiting.'<img src=images/staroff.png width=16 height=16>';
        if($bewertung>2.9) $userReiting = $userReiting.'<img src=images/staron.png width=16 height=16>';
        elseif($bewertung>2.1) $userReiting = $userReiting.'<img src=images/starhalf.png width=16 height=16>';
        else $userReiting = $userReiting.'<img src=images/staroff.png width=16 height=16>';
        if($bewertung>3.9) $userReiting = $userReiting.'<img src=images/staron.png width=16 height=16>';
        elseif($bewertung>3.1) $userReiting = $userReiting.'<img src=images/starhalf.png width=16 height=16>';
        else $userReiting = $userReiting.'<img src=images/staroff.png width=16 height=16>';
        if($bewertung>4.9) $userReiting = $userReiting.'<img src=images/staron.png width=16 height=16>';
        elseif($bewertung>4.1) $userReiting = $userReiting.'<img src=images/starhalf.png width=16 height=16>';
        else $userReiting = $userReiting.'<img src=images/staroff.png width=16 height=16>';
        $apartment["userReiting"] = $userReiting;

        $apartment["latitude"] = $unterkunft[latitude];
        $apartment["longitude"] = $unterkunft[longitude];

        array_push($dataForMap, $apartment);
    }
    $dataForMapJSON = json_encode($dataForMap);
    echo '</table>';





function pageLink($i,$stat="link") {

$dp=$i+1; global $coredata; global $d; global $ort; global $umkreis; global $art; global $anzgaeste; global $preismin; global $preismax; global $schlafzimmermax; global $schlafzimmermin; global $badezimmermax; global $badezimmermin; global $groessemin; global $groessemax;
if($stat=="link") return "<li><a onclick='return false' name='seite'  value=$i; data-pag=\""."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$i."\" href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$i."\">".$dp."</a></li>";
elseif($stat=="current") {return "<li class=active><a onclick='return false' href=\"#\">".$dp."</a></li>";}
else return "<li class=disabled><a onclick='return false' href=\"#\">".$dp."</a></li>";
}
$curretPrev = $seite - 1;
$curretNext = $seite + 1;
echo '<div style="margin-top:-20px;width:100%;height:1;border-top:1px solid #ddd;"></div><div style="text-align:center;"><ul class="pagination">';
if($seite>0) echo "<li><a onclick='return false' name='seite'  value=$curretPrev; data-pag=\""."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$curretPrev."\" href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$curretPrev."\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";
else echo "<li class=disabled><a onclick='return false'  href=\"#\"><img src=images/ico_back.png width=16 height=16 align=absmiddle border=0> Zur&uuml;ck</a></li>";

if($seite>2) echo pageLink('0');
if($seite>3) echo "<li class=disabled><a onclick='return false' href=\"#\">...</a></li>";
for($i=$seite-2; $i<$seite+3; $i++) {
if($i>-1 && $i<$ans) {
if($i==$seite) {echo pageLink($i,'current');}
else echo pageLink($i);
}}
if($ans>$seite+4) echo "<li class=disabled><a onclick='return false' href=\"#\">...</a></li>";
if($ans>$seite+3) echo pageLink($ans-1);

if($aaanz>$dsanz) echo "<li><a onclick='return false' name='seite'  value=$curretNext; data-pag=\""."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$curretNext."\" href=\"http://".$coredata[url]."?d=".$d."&ort=".$ort."&umkreis=".$umkreis."&art=".$art."&anzgaeste=".$anzgaeste."&preismin=".$preismin."&preismax=".$preismax."&schlafzimmermax=".$schlafzimmermax."&schlafzimmermin=".$schlafzimmermin."&badezimmermax=".$badezimmermax."&badezimmermin=".$badezimmermin."&groessemin=".$groessemin."&groessemax=".$groessemax."&seite=".$curretNext."\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
else echo "<li class=disabled><a onclick='return false' href=\"#\">Weiter <img src=images/ico_next.png width=16 height=16 align=absmiddle border=0></a></li>";
echo "</ul></div>";



    }
echo '</div> 
    <div class="tab-pane fade" role="tabpanel" id="profile" aria-labelledby="profile-tab"><div id="map_can"></div></div>
</div>';




















echo '</div>';

echo '</div>';
?>
<script>
    var view = <? if($_GET[view]) echo '"'.$_GET[view].'"'; else echo "undefined";?>;
    var dataForMapJSON = <?if($dataForMapJSON) echo $dataForMapJSON; else echo "{}";?>;
    console.log(dataForMapJSON);
</script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyDGXA6JxQnZULY0mJoM9QlF7hfhg48vMws"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script src="components/js/suchen.js"></script>
<link rel="stylesheet" href="components/css/suchen.css">