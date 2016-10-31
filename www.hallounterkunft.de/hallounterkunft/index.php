<?php

// error_reporting(E_ALL ^ E_NOTICE);
ini_set("memory_limit","80M");
date_default_timezone_set("Europe/Berlin");
include_once("class/core.class.php");

ob_start();

?><!DOCTYPE html>

<html lang="de" xml:lang="de">
<head><?php

echo '<title>%%TITEL%%</title>
<base href="http://'.$coredata['url'].'/">
<link href="'.genURL($d,$s,$u,$u2,$u3,$u4).'" rel="canonical">
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="favicon.ico" rel="icon" type="image/x-icon">
<link href="template/style.css" rel="stylesheet" type="text/css">
<link href="template/jquery.ui.css" rel="stylesheet" type="text/css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">
';

include("template/meta.inc.php");
include("javascript/javascript.inc.php");

?>
</head>
<body>

<div id="wloader" style="display:block;position:absolute;top:50%;left:50%;margin-left:-64px;margin-top:-8px;background-color:#fff;padding:10px;"><img src="images/loading.gif"></div><center><div id="main" style="visibility:hidden;"><?php

include("template/header.inc.php");
include("template/menubar.inc.php");

echo '

<div id="cont">

';

if(!$d || $d=="logout") $d="startseite";
if(file_exists("inc/".$d.".inc.php")==1) {
include("inc/".$d.".inc.php");
}
else echo '<legend>Error 404</legend><div class="alert alert-danger"><b>Ups!</b> Die Seite konnte leider nicht gefunden werden.</div>';

echo '</div>';

include("template/footer.inc.php");

?>

</div>
</body>
</html><?php

$ob_output = ob_get_contents();
ob_end_clean();
if($DO_TITEL!="") $ob_output = str_replace("%%TITEL%%",$DO_TITEL." - ".$coredata['titel']." &middot; ".$coredata['subtitel'],$ob_output);
else $ob_output = str_replace("%%TITEL%%",$coredata['titel']." &middot; ".$coredata['subtitel'],$ob_output);
echo $ob_output;

?>