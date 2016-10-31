<?php


if($_POST[eingeloggt]=="ok") {
echo '<script type="text/javascript"><!--
setTimeout("self.location.href=\'index.php\'",1000);
//--></script><br>'.genMsg('images/ico_ok.png','Erfolgreich eingeloggt.');
}

elseif($coredata[url]!="") {
echo "<iframe src=inc/facebook.inc.php frameborder=0 width=500 height=250 marginwidth=0 marginheight=0 scrolling=no></iframe>";
}

else {


include("../config.inc.php");
mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db($dbdata);

require("../class/facebook.php");

$facebook = new Facebook(array(
  'appId'  => $coredata['facebookappid'],
  'secret' => $coredata['facebooksecretkey'],
  'cookie' => true,
));



$xfbuser = $facebook->getUser();
if ($xfbuser) {
    try {
        $userdata = $facebook->api('/me');
    } catch (FacebookApiException $e) {
        error_log($e);
        echo $e->getMessage();

        $xfbuser = null;
    }
}
else {
    $loginUrl = $facebook->getLoginUrl($params = array('scope' => 'email,user_birthday'));
    echo "<span style=\"font-family: 'Lucida Grande', 'Lucida Sans', 'Trebuchet MS', Helvetica, Arial, sans-serif; font-size: 13px; color: #656565;\"><b>Sie haben ein Facebook-Konto?</b><br>Loggen Sie sich ohne Formularausfüllen direkt mit Ihrem Facebook-Konto ein:<br><br><a href=\"".$loginUrl."\" target=_top><img src=../images/fbconnect.png border=0></a>";
}

if(!empty($userdata)) {


$profilbild = "http://graph.facebook.com/".$userdata['id']."/picture?type=large";
$facebook_id = $userdata['id'];
$vorname = mysql_real_escape_string(utf8_decode($userdata['first_name']));
$nachname = mysql_real_escape_string(utf8_decode($userdata['last_name']));
$email = $userdata['email'];
$geschlecht = $userdata['gender'];
$geburtsdatum = $userdata['birthday'];
$ort = mysql_real_escape_string(utf8_decode($userdata['location']['name']));

$getuudd=mysql_query("SELECT * FROM ".$dbx."_user WHERE email='".$email."'");
$uudd=mysql_fetch_array($getuudd);
$getffdd=mysql_query("SELECT * FROM ".$dbx."_user_facebook WHERE facebook_id='".$facebook_id."'");
$ffdd=mysql_fetch_array($getffdd);

$usrip=$_SERVER['REMOTE_ADDR'];


if($ffdd[id]!="") $einloggen = $ffdd[userid];
elseif($uudd[id]!="") $einloggen = $uudd[id];
else {

$gbsplit = explode("/",$geburtsdatum);
$a_monat=$gbsplit[0];
$a_tag=$gbsplit[1];
$a_jahr=$gbsplit[2];

if($geschlecht=="male") $a_geschlecht="m"; else $a_geschlecht="w";

$username=str_replace("ä","ae",str_replace("ö","oe",str_replace("ü","ue",strtolower($vorname))));
$username=preg_replace("/[^a-zA-Z0-9]/","",$username);
$getuna=mysql_query("SELECT * FROM ".$dbx."_user WHERE user='".$username."'");
$una=mysql_fetch_array($getuna);
if($una[id]=="") $a_user=$username;
else {
$a=1; while($a < 9999) { $a++;
$getuna=mysql_query("SELECT * FROM ".$dbx."_user WHERE user='".$username.$a."'");
$una=mysql_fetch_array($getuna);
if($una[id]=="") { $a_user=$username.$a; break; }
}
}

$ortsplit = explode(", ",$ort);
$a_ort=$ortsplit[0];
$land=$ortsplit[1];
if($land=="Germany") $a_land="de";
if($land=="Switzerland") $a_land="ch";
if($land=="Austria") $a_land="at";

srand(date("s")); while($i<8) { $a_pass.=chr((rand()%26)+97); $i++; }
$a_geburtsdatum=mktime(0,0,0,$a_monat,$a_tag,$a_jahr);

$ph1=array('%vorname%','%nachname%','%benutzerpasswort%','%titel%','%url%');
$ph2=array($vorname,$nachname,$a_pass,$coredata[titel],$coredata[url]);
$mailtext = file_get_contents('../template/texte/anmeldebestaetigung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($email,"Willkommen bei ".$coredata['titel'],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

mysql_query("INSERT INTO ".$dbx."_user (user,pass,vorname,nachname,land,plz,ort,email,datum,online,geschlecht,ip) VALUES ('".addslashes($a_user)."','".$a_pass."','".addslashes($vorname)."','".addslashes($nachname)."','".addslashes($a_land)."','".$a_plz."','".addslashes($a_ort)."','".addslashes($email)."','".time()."','".time()."','".addslashes($a_geschlecht)."','".$usrip."')");

$einloggen = mysql_insert_id();

mysql_query("INSERT INTO ".$dbx."_user_facebook (facebook_id,userid) VALUES ('".$facebook_id."','".$einloggen."')");

$usrd[id]=$einloggen;
if($profilbild!="") {
$bildholen= file_get_contents($profilbild);
if($bildholen!="") {
$savefile = fopen("../avatar/".$usrd[id]."_b.jpg", "w");
fwrite($savefile, $bildholen);
fclose($savefile);
chmod ("../avatar/".$usrd[id]."_b.jpg", 0777);
$groesse=getimagesize("../avatar/".$usrd[id]."_b.jpg");
$breite=$groesse[0]; $hoehe=$groesse[1]; $typ=$groesse[2];

$image1 = imagecreatetruecolor(300,300);
$weiss = ImageColorAllocate($image1,255,255,255);
ImageFilledRectangle($image1, 0,0, 300, 300, $weiss);

$image = @imagecreatefromjpeg("../avatar/".$usrd[id]."_b.jpg");

if($breite<$hoehe) {
$minibreite=$breite*300/$hoehe; $minihoehe=300;
$bbbr3 = 300 - $minibreite; $bbbr2 = $bbbr3 / 2; $bbbr1 = explode(".",$bbbr2); $bbbr = $bbbr1[0]; $abbr = 1;
}
else {
$minihoehe=$hoehe*300/$breite; $minibreite=300;
$abbr3 = 300 - $minihoehe; $abbr2 = $abbr3 / 2; $abbr1 = explode(".",$abbr2); $abbr = $abbr1[0]; $bbbr = 1;
}
@imagecopyresampled($image1,$image,$bbbr,$abbr,0,0,$minibreite,$minihoehe,$breite,$hoehe);

@imagejpeg($image1,"../avatar/".$usrd[id]."_m.jpg",80);

@ImageDestroy($image1);

$image1 = imagecreatetruecolor(300,300);
$weiss = ImageColorAllocate($image1,255,255,255);
ImageFilledRectangle($image1, 0,0, 300, 300, $weiss);

$image = @imagecreatefromjpeg("../avatar/".$usrd[id]."_b.jpg");

if($breite<$hoehe) {
$minibreite=$breite*300/$hoehe; $minihoehe=300;
$bbbr3 = 300 - $minibreite; $bbbr2 = $bbbr3 / 2; $bbbr1 = explode(".",$bbbr2); $bbbr = $bbbr1[0]; $abbr = 1;
}
else {
$minihoehe=$hoehe*300/$breite; $minibreite=300;
$abbr3 = 300 - $minihoehe; $abbr2 = $abbr3 / 2; $abbr1 = explode(".",$abbr2); $abbr = $abbr1[0]; $bbbr = 1;
}
@imagecopyresampled($image1,$image,$bbbr,$abbr,0,0,$minibreite,$minihoehe,$breite,$hoehe);

@imagejpeg($image1,"../avatar/".$usrd[id]."_t.jpg",80);

@ImageDestroy($image1);

$size=getimagesize("../avatar/".$usrd[id]."_b.jpg"); $breite=$size[0]; $hoehe=$size[1];  $typ=$size[2];
if($breite>500) {
$neueBreite=500;
$neueHoehe=intval($hoehe*$neueBreite/$breite);
$image1 = imagecreatetruecolor($neueBreite,$neueHoehe);
$weiss = ImageColorAllocate($image1,255,255,255);
ImageFilledRectangle($image1, 0,0, $neueBreite, $neueHoehe, $weiss);

$image = @imagecreatefromjpeg("../avatar/".$usrd[id]."_b.jpg");

imagecopyresampled($image1,$image,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);

@imagejpeg($image1,"../avatar/".$usrd[id]."_b.jpg",80);

ImageDestroy($image1);
}}}

}}










if($einloggen!="") {

$getuudd=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$einloggen."'");
$uudd=mysql_fetch_array($getuudd);

echo "<form action=../index.php method=post name=fblg target=_top><input type=hidden name=d value=facebook><input type=hidden name=eingeloggt value=ok><input type=hidden name=usermail value=\"".$uudd[email]."\"><input type=hidden name=pass value=\"".$uudd[pass]."\"></form><script type=text/javascript language=javascript><!--
document.fblg.submit();
--></script>";

}





}

?>