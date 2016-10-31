<?php

if($cronmode!="no") {
include_once("class/core.class.php");
include("config.inc.php");
mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db($dbdata);
}

$timeplus12 = time()-45000;
$getoldma=mysql_query("SELECT * FROM ".$dbx."_mieten WHERE art='ma' AND datum < ".$timeplus12."");

while($oldma=mysql_fetch_array($getoldma)) {

$getmieter=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$oldma[user]."'");
$mieter = mysql_fetch_array($getmieter);

$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE id='".$oldma[gegenstand]."'");
$gegenstand = mysql_fetch_array($getgegenstand);

$mietdauer = ($oldma[bis] - $oldma[von]) / 86400;
$mietdauer = round($mietdauer,0);
$mietpreis_total=$gegenstand[preis_tag]*$mietdauer;

$guthabenneu=$mieter[guthaben]+$mietpreis_total;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$guthabenneu."' WHERE id='".$mieter[id]."'");
mysql_query("INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,gegenstand,status) VALUES ('".$mieter[id]."','rueckerstattung','".$mietpreis_total."','".time()."','".$gegenstand[id]."','ok')");

mysql_query("DELETE FROM ".$dbx."_mieten WHERE id='".$oldma[id]."'");

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

$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE status='ok' ORDER BY datum DESC");

while($gegenstand=mysql_fetch_array($getgegenstand)) {
$xmlsitemap.='
<url>
        <loc>'.genURL('gegenstand',$gegenstand[id],urlseotext($gegenstand[titel])).'</loc>
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