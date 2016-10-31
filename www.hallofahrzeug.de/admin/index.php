<?php

// error_reporting(E_ALL ^ E_NOTICE);
ini_set("memory_limit","80M");
include("../config.inc.php");

mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db($dbdata);

$d=$_GET['d']; if($d=="") $d=$_POST['d'];
$d=addslashes(htmlspecialchars($d));
$s=$_GET['s']; if($s=="") $s=$_POST['s'];
$s=addslashes(htmlspecialchars($s));
$u=$_GET['u']; if($u=="") $u=$_POST['u'];
$u=addslashes(htmlspecialchars($u));
$o=$_GET['o']; if($o=="") $o=$_POST['o'];
$o=addslashes(htmlspecialchars($o));
$i=$_GET['i']; if($i=="") $i=$_POST['i'];
$i=addslashes(htmlspecialchars($i));
$t=$_GET['t']; if($t=="") $t=$_POST['t'];
$t=addslashes(htmlspecialchars($t));
$p=$_GET['p']; if($p=="") $p=$_POST['p'];
$p=addslashes(htmlspecialchars($p));

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html><head><?php

echo '<title>'.$coredata['titel'].' &middot; Admin Panel</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">';

?><link rel=stylesheet href=css/ui.tabs.css type=text/css media="print, projection, screen">
</head><body><center><div style=width:800px;padding:10px;margin-top:20px;text-align:left;><img src=../images/ico_adminpanel.png width=48 height=48 align=absmiddle style="margin-top:-10px;"> <span style="color:#999;font-weight:bold;font-size:20px;">Admin Panel</span><br>
<div style="width:100%;padding:8px;background-color:#eee;margin-top:10px;">
<img src=../images/ico_euro.png width=16 height=16 align=absmiddle> <a href=index.php>Übersicht</a> &nbsp;&nbsp;&nbsp;
<img src=../images/ico_starten.png width=16 height=16 align=absmiddle> <a href=index.php?d=user>Benutzer bearbeiten</a> &nbsp;&nbsp;&nbsp;
<img src=../images/ico_konto.png width=16 height=16 align=absmiddle> <a href=index.php?d=auszahlungen>Auszahlungen</a> &nbsp;&nbsp;&nbsp;
<img src=../images/ico_verified.png width=16 height=16 align=absmiddle> <a href=index.php?d=verifizierung>Verifizierungen</a>
</div><div style="padding:8px;margin-top:10px;"><?php


$edit=$_GET[edit];
if($edit=="") $edit=$_POST[edit];






if($d=="auszahlungen") {
echo "<img src=../images/ico_konto.png width=16 height=16 align=absmiddle> <b>Auszahlungen</b><br><br>";


if($o=="done") {

mysql_query("UPDATE ".$dbx."_auszahlung SET status='ok' WHERE id='".$_POST[auszahlung]."'");
echo "<img src=../images/ico_ok.png width=16 height=16 align=absmiddle> Auszahlung als ausgezahlt markiert.<br><br>";

}

elseif($o=="k") {

$getprojekt=mysql_query("SELECT * FROM ".$dbx."_auszahlung WHERE id='".$_POST[auszahlung]."'");
$projekt=mysql_fetch_array($getprojekt);
$getprojektuser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$projekt[user]."'");
$projektuser=mysql_fetch_array($getprojektuser);

if($coredata['user']=="user") $urlUsername=$projektuser[user]; else $urlUsername=$projektuser[id];

echo '<table class="table">


<tr><td>Auszahlung beantragt am:</td><td>'.date("d.n.Y, H:i",$projekt[datum]).' Uhr</td></tr>
<tr><td>Benutzer:</td><td><img src="../images/ico_user_'.$projektuser[geschlecht].'.png" width=16 height=16 align=absmiddle> <a href="../index.php?d=user&s='.$urlUsername.'">'.$projektuser[user].'</a></td></tr>
<tr><td>Name und Wohnort:</td><td>'.$projektuser[vorname].' '.$projektuser[nachname].', '.$projektuser[plz].' '.$projektuser[ort].'</td></tr>
<tr><td>E-Mail:</td><td><img src="../images/menu_nachricht.png" width=16 height=16 align=absmiddle> <a href="mailto:'.$projektuser[email].'">'.$projektuser[email].'</a></td></tr>

<tr><td><b>Betrag:</b></td><td><b>'.number_format($projekt[betrag],2).' '.$coredata['waehrung'].'</b></td></tr>

<tr><td>Bevorzugte Auszahlungsart:</td><td>'.ucfirst($projektuser[auszahlungsart]).'</td></tr>
<tr><td valign=top>Bankverbindung:</td><td>
Name der Bank: '.$projektuser[bank_name].'<br>
Bankleitzahl: '.$projektuser[bank_blz].'<br>
Kontoinhaber: '.$projektuser[bank_inhaber].'<br>
Kontonummer: '.$projektuser[bank_konto].'
</td></tr>
<tr><td>PayPal:</td><td>'; if($projektuser[paypal]!="") echo $projektuser[paypal]; else echo 'nicht angegeben'; echo '</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>

<form action=index.php method=post><input type=hidden name=d value=auszahlungen><input type=hidden name=auszahlung value='.$projekt[id].'><input type=hidden name=o value=done><input type=submit value="Auszahlung als gesendet markieren" class="btn btn-default"></form>';


}
else {
echo 'Beantragte Auszahlungen:<br><br><form action=index.php method=post><input type=hidden name=d value=auszahlungen><input type=hidden name=o value=k><select name=auszahlung>';
$getop=mysql_query("SELECT * FROM ".$dbx."_auszahlung WHERE status='' ORDER BY datum DESC");
while($op=mysql_fetch_array($getop)) {
$getprojektuser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$op[user]."'");
$projektuser=mysql_fetch_array($getprojektuser);
echo '<option value='.$op[id].'>'.$projektuser[vorname].' '.$projektuser[nachname].': '.number_format($op[betrag],2).'</option>';
}
echo '</select><br><br><input type=submit value=Weiter class="btn btn-default"></form>';
}

}






elseif($d=="verifizierung") {
echo "<img src=../images/ico_verified.png width=16 height=16 align=absmiddle> <b>Verifizierungen</b><br><br>";


if($o=="done") {

mysql_query("UPDATE ".$dbx."_user SET verifizierung='ok' WHERE id='".$_POST[verifizierung]."'");
echo "<img src=../images/ico_ok.png width=16 height=16 align=absmiddle> Benutzer als verifiziert markiert.<br><br>";

}

elseif($o=="k") {

$getprojektuser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$_POST[verifizierung]."'");
$projektuser=mysql_fetch_array($getprojektuser);

if($coredata['user']=="user") $urlUsername=$projektuser[user]; else $urlUsername=$projektuser[id];

echo '<table class="table">


<tr><td>Benutzer:</td><td><img src="../images/ico_user_'.$projektuser[geschlecht].'.png" width=16 height=16 align=absmiddle> <a href="../index.php?d=user&s='.$urlUsername.'">'.$projektuser[user].'</a></td></tr>
<tr><td>Name:</td><td>'.$projektuser[vorname].' '.$projektuser[nachname].'</td></tr>
<tr><td>Wohnort:</td><td>'.$projektuser[plz].' '.$projektuser[ort].'</td></tr>
</table><br><br>

Hochgeladene Ausweiskopie:<br><a href="';

if(file_exists("../fotos/vc_".$projektuser[id]."_t.jpg")==1) echo '../fotos/vc_'.$projektuser[id].'_b.jpg" target=_blank><img src="../fotos/vc_'.$projektuser[id].'_t.jpg" border=0>';
elseif(file_exists("../fotos/vc_".$projektuser[id]."_t.png")==1) echo '../fotos/vc_'.$projektuser[id].'_b.png" target=_blank><img src="../fotos/vc_'.$projektuser[id].'_t.png" border=0>';

echo '</a><br><br>

<form action=index.php method=post><input type=hidden name=d value=verifizierung><input type=hidden name=verifizierung value='.$projektuser[id].'><input type=hidden name=o value=done><input type=submit value="Benutzer als verifiziert markieren" class="btn btn-default"></form>';


}
else {
echo 'Beantragte Verifizierungen:<br><br><form action=index.php method=post><input type=hidden name=d value=verifizierung><input type=hidden name=o value=k><select name=verifizierung>';
$getop=mysql_query("SELECT * FROM ".$dbx."_user WHERE verifizierung='wt' ORDER BY datum DESC");
while($op=mysql_fetch_array($getop)) {
echo '<option value='.$op[id].'>'.ucfirst($op[user]).' ('.$op[vorname].' '.$op[nachname].')</option>';
}
echo '</select><br><br><input type=submit value=Weiter class="btn btn-default"></form>';
}

}





















elseif($d=="user") {
echo "<img src=../images/ico_starten.png width=16 height=16 align=absmiddle> <b>Benutzer bearbeiten</b><br><br>";

if($_GET[del]!="") {

if($_GET[o]=="k") {
$del=$_GET[del];

mysql_query("DELETE FROM ".$dbx."_user WHERE id='".$del."'");
mysql_query("DELETE FROM ".$dbx."_mieten WHERE user='".$del."'");
mysql_query("DELETE FROM ".$dbx."_nachrichten WHERE abs='".$del."' OR empf='".$del."'");

echo '<img src=../images/ico_ok.png width=16 height=16 align=absmiddle> Benutzer gelöscht.';

}
else echo 'User wirklich löschen?<br><br><img src=../images/ico_delete.png width=16 height=16 align=absmiddle> <a href=index.php?d=user&del='.$_GET[del].'&o=k><b>JA, jetzt löschen</b></a>';


}



elseif($edit!="") {


$getuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$edit."'");
$user=mysql_fetch_array($getuser);


if($user[id]=="") echo "Benutzer nicht gefunden.";
elseif($_POST[o]=="k") {


$uu_vorname=htmlspecialchars(stripslashes($_POST[uu_vorname]));
$uu_nachname=htmlspecialchars(stripslashes($_POST[uu_nachname]));
$uu_plz=htmlspecialchars(stripslashes($_POST[uu_plz]));
$uu_ort=htmlspecialchars(stripslashes($_POST[uu_ort]));
$uu_email=htmlspecialchars(stripslashes($_POST[uu_email]));
$uu_rechte=htmlspecialchars(stripslashes($_POST[uu_rechte]));
$uu_verifizierung=htmlspecialchars(stripslashes($_POST[uu_verifizierung]));

mysql_query("UPDATE ".$dbx."_user SET vorname='".addslashes($uu_vorname)."', nachname='".addslashes($uu_nachname)."', plz='".addslashes($uu_plz)."', ort='".addslashes($uu_ort)."', email='".addslashes($uu_email)."', rechte='".addslashes($uu_rechte)."', verifizierung='".addslashes($uu_verifizierung)."' WHERE id='".$user[id]."'");

echo '<img src=../images/ico_ok.png width=16 height=16 align=absmiddle> Änderungen gespeichert.';


}
else {

echo '<form action=index.php method=post><input type=hidden name=d value=user><input type=hidden name=edit value='.$user[id].'><input type=hidden name=o value=k><input type=hidden name=usrid value='.$user[id].'><table border=0 cellspacing=0 cellpadding=5>
<tr><td>Vorname:</td><td><input type=text name=uu_vorname style=width:300px value="'.$user[vorname].'"></td></tr>
<tr><td>Nachname:</td><td><input type=text name=uu_nachname style=width:300px value="'.$user[nachname].'"></td></tr>
<tr><td>PLZ / Ort:</td><td><input type=text name=uu_plz style=width:80px value="'.$user[plz].'"> <input type=text name=uu_ort style=width:210px value="'.$user[ort].'"></td></tr>
<tr><td>E-Mail:</td><td><input type=text name=uu_email style=width:300px value="'.$user[email].'"></td></tr>
<tr><td><br>Rechte:</td><td><br><select name=uu_rechte style=width:300px><option value="">Normaler User<option value=adm'; if($user[rechte]=="adm") echo ' selected'; echo '>Admin<option value=mod'; if($user[rechte]=="mod") echo ' selected'; echo '>Moderator</select></td></tr>
<tr><td>Verifizierung:</td><td><select name=uu_verifizierung style=width:300px><option value="">Nein<option value="ok"'; if($user[verifizierung]=="ok") echo ' selected'; echo '>Ja</select></td></tr>
<tr><td>&nbsp;</td><td><input type=submit value=Speichern class="btn btn-default"></td></tr>
</table></form><br><br>
<img src=../images/ico_delete.png width=16 height=16 align=absmiddle> <a href=index.php?d=user&del='.$user[id].'>Benutzer löschen</a>';

}}
else {

echo '<form action=index.php method=post><input type=hidden name=d value=user>Vor- und/oder Nachname:<br><input type=text name=uu_name style=width:300px> <input type=submit value=Suchen class="btn btn-default"></form><br><br>';


if($_POST[uu_name]!="") {

echo '<hr noshade size=1 color=#aaaaaa><br>';

$uu_name_split = explode(" ",$_POST[uu_name]);
if($_POST[uu_name]=="%") $getuser = mysql_query("SELECT * FROM ".$dbx."_user");
else $getuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE vorname='".$uu_name_split[0]."' OR vorname='".$uu_name_split[1]."' OR nachname='".$uu_name_split[0]."' OR nachname='".$uu_name_split[1]."'");
if(mysql_num_rows($getuser)==0) echo "<i>Keine passenden Benutzer gefunden.</i>";
else {
while($users=mysql_fetch_array($getuser)) {

echo '<a href=index.php?d=user&edit='.$users[id].'>';
if(file_exists("../avatar/".$users[id]."_t.jpg")==1) echo '<img src="../avatar/'.$users[id].'_t.jpg?'.(time()-1300000000).'" width=50 height=50 border=0 align=absmiddle>';
elseif(file_exists("../avatar/".$users[id]."_t.png")==1) echo '<img src="../avatar/'.$users[id].'_t.png?'.(time()-1300000000).'" width=50 height=50 border=0 align=absmiddle>';
else echo '<img src="../avatar/user.gif" width=50 height=50 border=0 align=absmiddle>';

echo '</a> <a href=index.php?d=user&edit='.$users[id].'><b>'.ucfirst($users[user]).'</b></a> ('.ucfirst($users[vorname]).' '.ucfirst($users[nachname]).')<br><br>';

}

}
}
}


}













else {
echo "<img src=../images/ico_euro.png width=16 height=16 align=absmiddle> <b>Übersicht</b><br><br>";


$getanzuser = mysql_query("SELECT * FROM ".$dbx."_user");
$anzuser = mysql_num_rows($getanzuser);
$getakuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE online > ".(time()-172800)."");
$akuser = mysql_num_rows($getakuser);
$getneuuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE datum > ".(time()-172800)."");
$neuuser = mysql_num_rows($getneuuser);

$getanzausz2 = mysql_query("SELECT * FROM ".$dbx."_auszahlung WHERE status=''");
$anzausz=0;
while($getanzausz = mysql_fetch_array($getanzausz2)) {
$auszbetrag = $auszbetrag+$getanzausz[betrag];
$anzausz = $anzausz+1;
}

$getanzveri = mysql_query("SELECT * FROM ".$dbx."_user WHERE verifizierung='wt'");
$anzveri = mysql_num_rows($getanzveri);


echo '<table border=0 cellspacing=0 cellpadding=5>

<tr><td>Angemeldete Benutzer:</td><td style="background-color:#eee;border-bottom:1px solid #aaa;text-align:center;">'.$anzuser.'</td></tr>
<tr><td>Aktiv (letzte 48 Stunden):</td><td style="background-color:#eee;border-bottom:1px solid #aaa;text-align:center;">'.$akuser.'</td></tr>
<tr><td>Neuanmeldungen (letzte 48 Stunden):</td><td style="background-color:#eee;text-align:center;">'.$neuuser.'</td></tr>
<tr><td colspan=2><img src=../images/ico_starten.png width=16 height=16 align=absmiddle> <a href=index.php?d=user>Benutzer bearbeiten</a></td></tr>

<tr><td colspan=2>&nbsp;</td></tr>

<tr><td>Offene Auszahlungsanträge:</td><td style="background-color:#eee;border-bottom:1px solid #aaa;text-align:center;">'.$anzausz.'</td></tr>
<tr><td>Gesamtbetrag:</td><td style="background-color:#eee;text-align:center;">'.number_format($auszbetrag,2).' '.$coredata['waehrung'].'</td></tr>
<tr><td colspan=2><img src=../images/ico_konto.png width=16 height=16 align=absmiddle> <a href=index.php?d=auszahlungen>Auszahlungen bearbeiten</a></td></tr>

<tr><td colspan=2>&nbsp;</td></tr>

<tr><td>Offene Verifizierungsanträge:</td><td style="background-color:#eee;text-align:center;">'.$anzveri.'</td></tr>
<tr><td colspan=2><img src=../images/ico_euro.png width=16 height=16 align=absmiddle> <a href=index.php?d=verifizierung>Verifizierungen bearbeiten</a></td></tr>

</table>';


}












?></div></div></center></body></html>