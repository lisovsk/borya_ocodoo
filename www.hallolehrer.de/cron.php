<?php

if($cronmode!="no") {
include_once("class/core.class.php");
include("config.inc.php");
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdata);
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

$getkurse = mysqli_query($db,"SELECT * FROM ".$dbx."_kurse WHERE kurstag1_von > ".time()." ORDER BY datum DESC LIMIT 0,100");

while($kurse=mysqli_fetch_assoc($getkurse)) {
$xmlsitemap.='
<url>
        <loc>'.genURL('auftrag',$kurse[id],urlseotext($kurse[titel])).'</loc>
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