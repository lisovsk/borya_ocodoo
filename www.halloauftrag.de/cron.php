<?php

if($cronmode!="no") {
include_once("class/core.class.php");
include("config.inc.php");
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdata);
}




$getBeendete = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE endmail='0' AND datum_ende < ".time()." AND status='ok'");
while($beendet=mysqli_fetch_array($getBeendete)) {

mysqli_query($db,"UPDATE ".$dbx."_auftraege SET endmail='1' WHERE id='".$beendet[id]."'");

$getAngebote = mysqli_query($db,"SELECT * FROM ".$dbx."_angebote WHERE auftrag='".$beendet[id]."'");
$anzAngebote = mysqli_num_rows($getAngebote);

$getauftraggeber=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$beendet[user]."'");
$auftraggeber = mysqli_fetch_array($getauftraggeber);

$auftragurl=genURL('auftrag',$beendet[id]);
$auswahlurl=genURL('auswahl',$beendet[id]);

$ph1=array('%vorname%','%nachname%','%auftragtitel%','%auftragurl%','%auswahlurl%','%titel%','%url%');
$ph2=array($auftraggeber[vorname],$auftraggeber[nachname],$auftrag[titel],$auftragurl,$coredata[titel],"http://".$coredata[url]);
if($anzAngebote==0) $mailtext = file_get_contents('template/texte/auftragbeendet_erfolglos.txt', true);
else $mailtext = file_get_contents('template/texte/auftragbeendet_auswahl.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($auftraggeber[email],"Angebotsphase beendet: ".$gegenstand[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

}




$xmlsitemap.='<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
        <loc>'.genURL('').'</loc>
        <priority>1.0</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('suchen').'</loc>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('vermieten').'</loc>
        <priority>0.5</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('faq').'</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('anmelden').'</loc>
        <priority>0.5</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('impressum').'</loc>
        <priority>0.5</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>
<url>
        <loc>'.genURL('nutzungsbedingungen').'</loc>
        <priority>0.5</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>';

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE status='ok' ORDER BY datum DESC LIMIT 0,100");

while($auftrag=mysqli_fetch_assoc($getauftrag)) {
$xmlsitemap.='
<url>
        <loc>'.genURL('auftrag',$auftrag[id],urlseotext($auftrag[titel])).'</loc>
        <priority>0.9</priority>
        <changefreq>weekly</changefreq>
        <lastmod>'.date("Y-m-d").'</lastmod>
</url>';
}

$xmlsitemap.='
</urlset>';

$dateihandle = fopen("sitemap.xml","w");
fwrite($dateihandle, $xmlsitemap);

?>