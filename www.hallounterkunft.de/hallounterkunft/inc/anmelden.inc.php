<?php

$DO_TITEL="Anmelden";

require_once('class/captcha.class.php');
if (empty($_GET['session_code'])) $session_code = md5(round(rand(0,40000)));
else $session_code=$_GET['session_code'];
$my_captcha = new captcha( $session_code, '__TEMP__/' );
if($_POST[o]=="k" && $my_captcha->verify($_POST['password'])) $cok="ok";

$a_user=htmlspecialchars(stripslashes(strtolower($_POST[a_user])));
$a_email=htmlspecialchars(stripslashes($_POST[a_email]));
$a_vorname=htmlspecialchars(stripslashes(ucfirst($_POST[a_vorname])));
$a_nachname=htmlspecialchars(stripslashes(ucfirst($_POST[a_nachname])));
$a_plz=htmlspecialchars(stripslashes($_POST[a_plz]));
$a_land=$_POST[a_land];
$a_ort=htmlspecialchars(stripslashes(ucfirst($_POST[a_ort])));
$a_geschlecht=$_POST[a_geschlecht];
$a_agb=$_POST[a_agb];

if($_POST[o]=="k") {

echo '<legend>Anmelden</legend>';

$getbb=mysql_query("SELECT user,email FROM ".$dbx."_user WHERE user='".$a_user."' OR email='".$a_email."'"); $getb=mysql_fetch_array($getbb);

if($a_user=="" && $coredata[user]=="user") echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben keinen Benutzernamen gewählt.</div>';
elseif(!preg_match("/^[a-zA-Z0-9]+$/s",$a_user && $coredata[user]=="user")) echo '<div class="alert alert-danger"><b>Ups!</b> Der Benutzername darf nur aus Buchstaben und Zahlen bestehen.</div>';
elseif(strlen($a_user)>25 && $coredata[user]=="user") echo '<div class="alert alert-danger"><b>Ups!</b> Der Benutzername ist zu lang.</div>';
elseif($getb[user]==$a_user && $coredata[user]=="user") echo '<div class="alert alert-danger"><b>Ups!</b> Der gewünschte Benutzername ist leider bereits vergeben.</div>';
elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $a_email)) echo '<div class="alert alert-danger"><b>Ups!</b> Die angegebene E-Mail-Adresse ist ungültig.</div>';
elseif($cok!="ok") echo '<div class="alert alert-danger"><b>Ups!</b> Der Captcha-Code (Spam-Schutz) wurde nicht korrekt abgetippt.</div>';
elseif(preg_match('~[^a-zA-Z0-9]~', $a_user)) echo '<div class="alert alert-danger"><b>Ups!</b> Der Benutzername darf nur aus Buchstaben und/oder Zahlen bestehen.</div>';
elseif($getb[email]==$a_email) echo '<div class="alert alert-danger"><b>Ups!</b> Unter dieser E-Mail-Adresse besteht bereits ein Account. <a href=index.php?d=passwort>Passwort vergessen?</a></div>';
elseif(!is_numeric($a_plz) || strlen($a_plz)>5 || $a_plz=="") '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($a_vorname=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Vorname" ausfüllen.</div>';
elseif($a_nachname=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Nachname" ausfüllen.</div>';
elseif($a_ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Ort" ausfüllen.</div>';
elseif($a_agb!="ja") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte die Nutzungsbedingungen lesen und akzeptieren.</div>';
else { $noform="ok";

srand(date("s")); while($i<8) { $a_pass.=chr((rand()%26)+97); $i++; }

$ph1=array('%vorname%','%nachname%','%benutzername%','%benutzerpasswort%','%titel%','%url%');
$ph2=array($a_vorname,$a_nachname,$a_user,$a_pass,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/anmeldebestaetigung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($a_email,"Willkommen bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");



$usrip=$_SERVER['REMOTE_ADDR'];

mysql_query("INSERT INTO ".$dbx."_user (user,pass,vorname,nachname,land,plz,ort,email,datum,online,geschlecht,ip) VALUES ('".addslashes($a_user)."','".$a_pass."','".addslashes($a_vorname)."','".addslashes($a_nachname)."','".addslashes($a_land)."','".$a_plz."','".addslashes($a_ort)."','".addslashes($a_email)."','".time()."','".time()."','".$a_geschlecht."','".$usrip."')");

$nuid=mysql_insert_id();


echo '<div class="alert alert-success"><b>Willkommen!</b> Vielen Dank für Ihre Anmeldung.</div>In wenigen Augenblicken erhalten Sie eine Anmeldebestätigung per E-Mail, in welcher sich auch die Zugangsdaten befinden.';

}}


if($noform!="ok") {
$pic_url = $my_captcha->get_pic( 4 );
echo "

<legend>Login mit Facebook</legend>
<div class=row><div class=\"col-lg-12 col-sm-12\"><iframe src=inc/facebook.inc.php frameborder=0 width=100% height=130 marginwidth=0 marginheight=0 scrolling=no></iframe></div></div>


<legend>Anmelden</legend>

<form action=index.php?session_code=".$session_code." method=post class=form-horizontal><input type=hidden name=d value=anmelden><input type=hidden name=o value=k>";

if($coredata[user]=="user")echo "<div class=form-group>
<label for=a_user class=\"col-lg-5 col-sm-4 control-label\">Gewünschter Benutzername</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_user name=a_user style=width:100%;max-width:350px; maxlength=15 value=\"".$a_user."\" class=form-control>
</div></div>";

echo "<div class=form-group>
<label for=a_email class=\"col-lg-5 col-sm-4 control-label\">E-Mail Adresse</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_email name=a_email style=width:100%;max-width:350px; value=\"".$a_email."\" class=form-control>
</div></div>

<br>
<div class=form-group>
<label for=a_geschlecht class=\"col-lg-5 col-sm-4 control-label\"></label><div class=\"col-lg-7 col-sm-8\">
<img src=images/ico_user_w.png width=16 height=16 valign=absmiddle>&nbsp;<input type=radio name=a_geschlecht checked value=w id=w>&nbsp;<label for=w>Frau</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/ico_user_m.png width=16 height=16 valign=absmiddle>&nbsp;<input type=radio name=a_geschlecht value=m id=m>&nbsp;<label for=m>Herr</label>
</div></div>

<div class=form-group>
<label for=a_vorname class=\"col-lg-5 col-sm-4 control-label\">Vorname</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_vorname name=a_vorname style=width:100%;max-width:350px; value=\"".$a_vorname."\" class=form-control>
</div></div>

<div class=form-group>
<label for=a_nachname class=\"col-lg-5 col-sm-4 control-label\">Nachname</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_nachname name=a_nachname style=width:100%;max-width:350px; value=\"".$a_nachname."\" class=form-control>
</div></div>

<div class=form-group>
<label for=\"a_plz\" class=\"col-lg-5 col-sm-4 control-label\">PLZ</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_plz name=a_plz style=width:100px value=\"".$a_plz."\" class=form-control>
</div></div>

<div class=form-group>
<label for=\"a_ort\" class=\"col-lg-5 col-sm-4 control-label\">Ort</label><div class=\"col-lg-7 col-sm-8\">
<input type=text id=a_ort name=a_ort style=width:100%;max-width:350px; value=\"".$a_ort."\" class=form-control>
</div></div>

<div class=form-group>
<label for=\"a_land\" class=\"col-lg-5 col-sm-4 control-label\">Land</label><div class=\"col-lg-7 col-sm-8\"><div class=input-group><span class=input-group-addon><img src=images/flaggen/de.gif width=18 height=12 align=absmiddle name=flag></span><select style=width:100%;max-width:306px; onchange=\"document.images['flag'].src = 'images/flaggen/'+document.getElementById('land').value+'.gif';\" id=land name=a_land class=form-control>
<option value=de>Deutschland
<option value=at>Österreich
<option value=ch>Schweiz
<option value=li>Liechtenstein
<option value=\"\">---
<option value=au>Australien
<option value=be>Belgien
<option value=dk>Dänemark
<option value=fi>Finnland
<option value=fr>Frankreich
<option value=gr>Griechenland
<option value=gb>Grossbritannien
<option value=it>Italien
<option value=ca>Kanada
<option value=lu>Luxemburg
<option value=nz>Neuseeland
<option value=nl>Niederlande
<option value=no>Norwegen
<option value=pl>Polen
<option value=pt>Portugal
<option value=se>Schweden
<option value=sk>Slowakei
<option value=es>Spanien
<option value=tr>Türkei
<option value=us>USA
<option value=\"\">---
<option value=\"\">Sonstiges Land
</select></div>
</div></div>

<br>

<div class=form-group>
<label for=\"captcha\" class=\"col-lg-5 col-sm-4 control-label\"><img src=\"class/captcha.class.php?ci=1&img=".$pic_url."\"></label><div class=\"col-lg-7 col-sm-8\">
<span class=help-block><b>Bitte nebenstehende Buchstaben abtippen:</b></span>
<input type=text name=password maxlength=4 style=width:100px class=form-control>
</div></div>

<div class=form-group>
<label for=\"a_agb\" class=\"col-lg-5 col-sm-4 control-label\"></label><div class=\"col-lg-7 col-sm-8\">
<input type=checkbox name=a_agb value=ja> Ich akzeptiere die <a data-toggle=modal href=\"#agb\" target=_blank>Nutzungsbedingungen</a>.
</div></div>

<br>

<div class=form-group>
<label for=\"a_submit\" class=\"col-lg-5 col-sm-4 control-label\"></label><div class=\"col-lg-7 col-sm-8\">
<input type=submit value=Anmelden class=\"btn btn-default\">
</div></div>

</form>";

?><div class="modal" id="agb">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Nutzungsbedingungen</h4>
</div>
<div class="modal-body">
<?php
$nohd="ja";
include("inc/nutzungsbedingungen.inc.php");
?>
</div>
</div>
</div>
</div><?php

}

?>