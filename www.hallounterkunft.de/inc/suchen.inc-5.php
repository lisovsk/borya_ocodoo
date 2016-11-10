<?php



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
echo '<div class="col-lg-4 col-sm-5">

<form action="index.php" method="get" class="form-horizontal js-get-param"><input type="hidden" name="d" value="suchen">

<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_marker.png width=16 height=16 align=absmiddle></span>
<input type="text" name="ort" class="form-control" placeholder="Wo soll es hingehen?" style="font-size:18px;font-weight:bold;" value="'.$ortName.'">
</div>
</div>

<div style="margin-bottom:10px;">
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
</div>

</form>






</div>
<div class="js-ajax-data">
<div class="col-lg-8 col-sm-7">';

echo '
<ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li role="presentation" class="active presentation-custom"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Listenansicht</a></li>
    <li role="presentation" class="presentation-custom js-map-inicialize"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Kartenansicht</a></li>
</ul>
<div class="tab-content" id="myTabContent"> 
    <div class="tab-pane fade active in" role="tabpanel" id="home" aria-labelledby="home-tab">';
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
// var changeStrGet = debounce(, 250);
function changeStrGet (targetElem) {
    var name = $(targetElem).attr("name"),
    regExpRep = new RegExp(name + "=" + "[^&]*"),
    value = $(targetElem).val() || $(targetElem).attr("value");
    strGet = strGet.replace(regExpRep, name + "=" + value);
    console.log(strGet);
    getAjaxData("inc/inc-suchen/search-response.inc.php", strGet, '.js-ajax-data');
}
function getAjaxData(file, strGet, setAjaxDataSelec) {
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
            if (req.readyState != 4) return;
            var responseText = String(req.responseText);
            $(setAjaxDataSelec).html(responseText);
        };
    req.open("GET", file + strGet, true);
    req.send(null);
}
    var strGet = "";
    var input = $(".js-get-param [name], [name=order]").filter( ':input' );
    input.each(function( index ) {
        var name = $( this ).attr("name");
        var value = $( this ).val();
        strGet += name + "=" + value + "&";
    });
    strGet = "?" + strGet.substring(0, strGet.length - 1);
    strGet = strGet + "&seite=0"
    console.log(strGet);
    
    input.on("change", input, function (e) {
        var target = e.target;
        changeStrGet (target);
    });
   $("body").on("mouseup", function (e) {
    // var div = $(".js-mouseup");
        // if (!div.is(e.target) && div.has(e.target).length === 0) {
            var index = $(".ui-state-active").index(".ui-slider-handle");
            if(index !== -1)
                changeStrGet( "#" + $(".slider-handle-c").eq(index).attr("id") );
        // }
   });
   $("body").on("click", function (event) {
        var target = event.target;
        var strG = $(target).attr("data-pag");
        if (strG) {
            // strG = strG + "&" + $(".small").attr("name") + "=" + $(".small").val();
            changeStrGet(target);
        }
   });
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };
    function once(fn, context) { 
        var result;

        return function() { 
            if(fn) {
                result = fn.apply(context || this, arguments);
                fn = null;
            }

            return result;
        };
    }
</script>
<script>
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
</script>


<style>
    .presentation-custom {
        border: 1px solid #ddd;
    }
    .nav-tabs>li.presentation-custom.active>a, .nav-tabs>li.presentation-custom.active>a:hover {
        border: none;
        background: #eee;
    }
    .nav-tabs>li.presentation-custom>a {
        border: 0;
        border-radius: 0;
        margin-right: 0;
    }
    .presentation-custom:first-child {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        border-right: none;
    }
    .presentation-custom:last-child {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }
    .nav>li.presentation-custom>a {
        padding: 5px 15px;
    }
    /*start custom-google*/
        [src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png"] {
          display: none !important;
        }
        .map-mark__markers {
          width: 55px;
          height: 35px;
          margin: auto;
          background: #ff6600;
          border-radius: 5px;
          text-align: center;
          vertical-align: 55px;
          line-height: 35px;
        }
        .map-mark__markers_active {
            box-sizing: border-box;
            margin-top: -55px;
            width: 400px;
            height: 130px;
            background: white;
            padding: 15px;
          position:relative;
        }
        .map-mark__triangl {
          width: 0;
          margin: auto;
          margin-top: -1px;
          border: 10px solid transparent;
          border-top: 10px solid #ff6600; 
        }
        .map-mark__triangl_active {
            border: 20px solid transparent;
            border-top: 20px solid white; 
        }
        .map-mark__price {
          font-size: 14px;
          font-weight: 600;
          color: white;
          word-spacing: -1px;
        }
        .map-mark__img {
          width: 100%;
          height: 100%;
          border-radius: 15px;
        }
        .map-mark__wr-img {
          width: 130px;
          height: 100px;
          margin-right: 15px;
          display:inline-block;
          float:left;
        }

    .map-mark__title {
      line-height: 25px;
      text-align:left;
      color: #427db5;
    }
    .map-mark__user-img {
      border-radius: 50%;
      width:45px;
      height: 45px;
      margin-right: 5px;
    }
    .map-mark__user-text {
      line-height: 19px;
      color:#9d9b9c;
      text-align: left;
    }
    .map-mark__city, .map-mark__user-name {
      color:#427db5;
    }
    .map-mark__price_active {
      color: #353535;
      position: absolute;
      bottom: 15px;
      right: 15px;
    }
     .map-mark__user-img {
      float:left;
    }
        .map-mark__container {
        }
        .gm-style > div > div:first-child {
          z-index: 10000 !important;
        }
        div#map_can {
              width: 600px;
              height: 400px;
        }
    /*end custom-google*/
</style>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyDGXA6JxQnZULY0mJoM9QlF7hfhg48vMws"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script>
    //start custom-google*/
    $(document).ready(function () {
        var initMapOnce = once(initializeMap);
        $(".js-map-inicialize").click(function () {
            setTimeout(function () {
                initMapOnce();
            }, 250);
        });
        var dataForMapJSON = <?echo $dataForMapJSON;?>;
        console.log(dataForMapJSON);

           function initializeMap () {
            var mapCan = document.getElementById("map_can");
            var options = {
                'zoom':15,
                'mapTypeId': google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(mapCan, options);
            var geocoder = new google.maps.Geocoder();
            var mapCordsLoc = [];
            function codeAddress(location, price){
                 geocoder.geocode( { 'address': location}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                        console.log(price);
                        mapCordsLoc.push(results[0].geometry.location);
                         var marker = new MarkerWithLabel({
                           position: results[0].geometry.location,
                           map: map,
                           draggable: false,
                           raiseOnDrag: false,
                           labelContent: '<div class="map-mark__container"><div><div class="map-mark__markers"><span class="map-mark__price">' + price + '</span></div><div class="map-mark__triangl"></div></div><div><div class="map-mark__markers map-mark__markers_active"><div class="map-mark__wr-img"><img src="http://www.sunhome.ru/UsersGallery/Cards/prazdnik_den_zemli_kartinka.jpg" alt="" class="map-mark__img" /></div><div class="map-mark__wr-data"><div class="map-mark__title">sdssdsd</div><div class="map-mark__wr-user"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQpyJMXrMR3f5XRtfz37TUOmfNf_GwzPllZuoZSprHO8cb9V8q7YNIxe_oD" alt="" class="map-mark__user-img" /><div class="map-mark__user-text">sdsdsd <span class="map-mark__city">Ddsdasd</span> sdsdd dfdfdfdf <span class="map-mark__user-name">sdsd</span></div></div></div><span class="map-mark__price map-mark__price_active">' + price + '</span></div><div class="map-mark__triangl map-mark__triangl_active"></div></div></div>',
                           labelAnchor: new google.maps.Point(200, 40),
                           labelClass: "labels", // the CSS class for the label 
                           labelInBackground: false
                         });
                     } else {  
                        console.log('Geocode was not successful for the following reason: ' + status)}; 
                 });
             }
             for (var i = 0; i < dataForMapJSON.length; i++) {
                var address = dataForMapJSON[i].strasse + ", " + dataForMapJSON[i].ortName;
                var price = dataForMapJSON[i].price;
                codeAddress(address, price);
             }

             
             setTimeout(function () {
                var latlngbounds = new google.maps.LatLngBounds();
                for ( var i=0; i<mapCordsLoc.length; i++ ){
                     latlngbounds.extend(mapCordsLoc[i]);
                }
                map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));
             }, 1000);

           }
    });
    //end custom-google*/
</script>