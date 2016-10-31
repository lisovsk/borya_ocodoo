<?php

error_reporting(E_ALL ^ E_NOTICE);

include("config.inc.php");

function genURL($td,$td2='',$td3='',$td4='',$td5='',$td6='') {
global $coredata;
$url = $coredata['url'];
if($coredata['modrw']=="ja") {
  if($td!="") $url .= "/".$td;
  if($td2!="") $url .= "/".$td2;
  if($td3!="") $url .= "/".$td3;
  if($td4!="") $url .= "/".$td4;
  if($td5!="") $url .= "/".$td5;
  if($td6!="") $url .= "/".$td6;
}
else {
  if($td!="") $url .= "/?d=".$td;
  if($td2!="") $url .= "&s=".$td2;
  if($td3!="") $url .= "&u=".$td3;
  if($td4!="") $url .= "&u2=".$td4;
  if($td5!="") $url .= "&u3=".$td5;
  if($td6!="") $url .= "&u4=".$td6;
}
return 'http://'.$url;
}


function genMsg($ico,$msg) {
return '<center><div style="border-radius:10px;-moz-border-radius:10px;background-color:#ededed;padding:15px;text-align:left;"><img src='.$ico.' width=16 height=16 style=margin-right:10px; align=absmiddle>'.$msg.'</div></center>';
}


    function moveWithoutStructure($source, $target)
    {
        if(substr($source,-1)!="/")
            $source .= "/";
        if(substr($target,-1)!="/")
            $target .= "/";
        if (!is_dir($source))
            return false;
        $ordner = dir($source);
        while ($datei=$ordner->read()){
            if ($datei != '.' AND $datei != '..' ){
                $Entry = $source.$datei;
                if (is_dir($Entry)){
                    moveWithoutStructure($Entry, $target);
                    rmdir($Entry);
                }
                elseif($source != $target){
                    copy($Entry, $target.$datei);
                    unlink($Entry);
                }
            }
        }
        $ordner->close();
        return true;
    }

    function readDirectory($pfad)
    {
        if(substr($pfad,-1)!="/")
            $pfad .= "/";
        if(!is_dir($pfad))
            return false;
        $filesArr = array();
        $ordner = dir($pfad);
        while($datei = $ordner->read()) {
            if($datei != "." AND $datei != "..") {
                if(is_file($pfad.$datei))
                    $filesArr[] = $datei;
            }
        }
        $ordner->close();
        return $filesArr;
    }



function urlseotext($txt) {
$txt = str_replace("&","",$txt);
$txt = str_replace("   "," ",$txt);
$txt = str_replace("  "," ",$txt);
$txt = str_replace(" ","XABSTANDX",$txt);
$txt = utf8_decode($txt);
$txt = str_replace("ü","ue",$txt);
$txt = str_replace("ö","oe",$txt);
$txt = str_replace("ä","ae",$txt);
$txt = str_replace("Ü","Ue",$txt);
$txt = str_replace("Ö","Oe",$txt);
$txt = str_replace("Ä","Ae",$txt);
$txt = str_replace("ß","ss",$txt);
$txt = preg_replace('/[^0-9A-Za-z]/', '', $txt);
$txt = str_replace("XABSTANDX","-",$txt);
$txt = urlencode($txt);
return $txt;
}


function countrycode($cc) {
$cc=strtolower($cc);
if($cc=="de") $c="Deutschland";
elseif($cc=="at") $c="Österreich";
elseif($cc=="au") $c="Australien";
elseif($cc=="be") $c="Belgien";
elseif($cc=="ca") $c="Kanada";
elseif($cc=="ch") $c="Schweiz";
elseif($cc=="dk") $c="Dänemark";
elseif($cc=="es") $c="Spanien";
elseif($cc=="fi") $c="Finnland";
elseif($cc=="fr") $c="Frankreich";
elseif($cc=="gb") $c="Grossbritannien";
elseif($cc=="gr") $c="Griechenland";
elseif($cc=="it") $c="Italien";
elseif($cc=="li") $c="Liechtenstein";
elseif($cc=="lu") $c="Luxemburg";
elseif($cc=="nl") $c="Niederlande";
elseif($cc=="no") $c="Norwegen";
elseif($cc=="nz") $c="Neuseeland";
elseif($cc=="pl") $c="Polen";
elseif($cc=="pt") $c="Portugal";
elseif($cc=="se") $c="Schweden";
elseif($cc=="sk") $c="Slowakei";
elseif($cc=="tr") $c="Türkei";
elseif($cc=="us") $c="USA";
return $c;
}


function nr2wochentag($nr) {
$nr = str_replace("0","Sonntag",$nr);
$nr = str_replace("1","Montag",$nr);
$nr = str_replace("2","Dienstag",$nr);
$nr = str_replace("3","Mittwoch",$nr);
$nr = str_replace("4","Donnerstag",$nr);
$nr = str_replace("5","Freitag",$nr);
$nr = str_replace("6","Samstag",$nr);
$nr = str_replace("7","Sonntag",$nr);
return $nr;
}

function nr2wochentagShort($nr) {
$nr = str_replace("0","So",$nr);
$nr = str_replace("1","Mo",$nr);
$nr = str_replace("2","Di",$nr);
$nr = str_replace("3","Mi",$nr);
$nr = str_replace("4","Do",$nr);
$nr = str_replace("5","Fr",$nr);
$nr = str_replace("6","Sa",$nr);
$nr = str_replace("7","So",$nr);
return $nr;
}

function nr2monat($nr) {
$nr = str_replace("10","Oktober",$nr);
$nr = str_replace("11","November",$nr);
$nr = str_replace("12","Dezember",$nr);
$nr = str_replace("1","Januar",$nr);
$nr = str_replace("2","Februar",$nr);
$nr = str_replace("3","März",$nr);
$nr = str_replace("4","April",$nr);
$nr = str_replace("5","Mai",$nr);
$nr = str_replace("6","Juni",$nr);
$nr = str_replace("7","Juli",$nr);
$nr = str_replace("8","August",$nr);
$nr = str_replace("9","September",$nr);
return $nr;
}



function calcTimeDiv($time) {

  $time_difference = time() - $time ;
  $seconds = $time_difference ;
  $minutes = round($time_difference / 60 );
  $hours = round($time_difference / 3600 );
  $days = round($time_difference / 86400 );
  $weeks = round($time_difference / 604800 );
  $months = round($time_difference / 2419200 );
  $years = round($time_difference / 29030400 );

  if($seconds <= 60) {
    return "gerade eben";
  }
  else if($minutes <=60) {
    if($minutes==1) return "vor einer Minute";
    else return "vor $minutes Minuten";
  }
  else if($hours <=24) {
    if($hours==1) return "vor einer Stunde";
    else return "vor $hours Stunden";
  }
  else if($days <= 7) {
    if($days==1) return "vor einem Tag";
    else return "vor $days Tagen";
  }
  else if($weeks <= 4) {
    if($weeks==1)  return "vor einer Woche";
    else return "vor $weeks Wochen";
  }
  else if($months <=12) {
    if($months==1) return "vor einem Monat";
    else return "vor $months Monaten";
  }
  else {
    if($years==1) return "vor einem Jahr";
    else return "vor $years Jahren";
  }
}







function calcCountdown($time) {

  $time_difference = $time - time() ;
  $seconds = $time_difference ;
  $minutes = round($time_difference / 60 );
  $hours = round($time_difference / 3600 );
  $days = round($time_difference / 86400 );
  $weeks = round($time_difference / 604800 );
  $months = round($time_difference / 2419200 );
  $years = round($time_difference / 29030400 );

  if($seconds <= 60) {
    return "noch wenige Sekunden";
  }
  else if($minutes <=60) {
    if($minutes==1) return "noch eine Minute";
    else return "noch $minutes Minuten";
  }
  else if($hours <=24) {
    if($hours==1) return "noch eine Stunde";
    else return "noch $hours Stunden";
  }
  else if($days <= 7) {
    if($days==1) return "noch einen Tag";
    else return "noch $days Tage";
  }
  else if($weeks <= 4) {
    if($weeks==1)  return "noch eine Woche";
    else return "noch $weeks Wochen";
  }
  else if($months <=12) {
    if($months==1) return "noch einen Monat";
    else return "noch $months Monate";
  }
  else {
    if($years==1) return "noch ein Jahr";
    else return "noch $years Jahre";
  }
}



function textKuerzen($string, $limit, $break=".", $pad="...") {

  if(strlen($string) <= $limit)
  return $string;

  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }
  return $string;
}



function secure_cont($cont) {
$cont=mysql_real_escape_string($cont);
$cont=strip_tags($cont);
$cont=htmlspecialchars($cont);
return $cont;
}





function uploadImage($dateiquelle,$dateiziel,$maxbreite='500',$thumbnailsize='100',$facebook='nein') {
@unlink($dateiziel."_b.jpg");
@unlink($dateiziel."_t.jpg");
@unlink($dateiziel."_b.png");
@unlink($dateiziel."_t.png");



if($facebook=="ja") {

$bildholen= file_get_contents($dateiquelle);
$savefile = fopen($dateiziel."_b.jpg", "w");
fwrite($savefile, $bildholen);
fclose($savefile);

chmod ($dateiziel."_b.jpg", 0777);
$groesse=getimagesize($dateiziel."_b.jpg");
$breite=$groesse[0]; $hoehe=$groesse[1]; $typ=$groesse[2];
$inpbild="jpg";

}
else {

$bimi = $_FILES[$dateiquelle]['type'];
$bisi = $_FILES[$dateiquelle]['size'];
list($width, $height, $type, $attr) = @getimagesize($_FILES[$dateiquelle]['tmp_name']);

if(preg_match("/image\/(gif|x-png|png)/",$bimi)) $inpbild = "png"; else $inpbild = "jpg";

move_uploaded_file($_FILES[$dateiquelle]['tmp_name'], $dateiziel."_b.".$inpbild);
chmod ($dateiziel."_b.".$inpbild, 0777);
$groesse=getimagesize($dateiziel."_b.".$inpbild);
$breite=$groesse[0]; $hoehe=$groesse[1]; $typ=$groesse[2];

}



$image1 = imagecreatetruecolor($thumbnailsize,$thumbnailsize);
$weiss = ImageColorAllocate($image1,255,255,255);
ImageFilledRectangle($image1, 0,0, $thumbnailsize, $thumbnailsize, $weiss);
switch ($typ) {
case 1: $image = imagecreatefromgif($dateiziel."_b.png"); break;
case 2: $image = imagecreatefromjpeg($dateiziel."_b.jpg"); break;
case 3: $image = imagecreatefrompng($dateiziel."_b.png"); break;
}

$b_ratio = ($thumbnailsize / $breite);
$h_ratio = ($thumbnailsize / $hoehe);

if($breite > $hoehe) {
  $crop_w = round($breite * $h_ratio);
  $crop_h = $thumbnailsize;
  $src_x = ceil( ( $breite - $hoehe ) / 2 );
  $src_y = 0;
} elseif($breite < $hoehe) {
  $crop_h = round($hoehe * $b_ratio);
  $crop_w = $thumbnailsize;
  $src_x = 0;
  $src_y = ceil( ( $hoehe - $breite ) / 2 );
} else {
  $crop_w = $thumbnailsize;
  $crop_h = $thumbnailsize;
  $src_x = 0;
  $src_y = 0;
}

imagecopyresampled($image1,$image,0,0,$src_x,$src_y,$crop_w,$crop_h,$breite,$hoehe);
switch ($typ) {
case 1: imagepng($image1,$dateiziel."_t.png"); break;
case 2: imagejpeg($image1,$dateiziel."_t.jpg",50); break;
case 3: imagepng($image1,$dateiziel."_t.png"); break;
}
ImageDestroy($image1);

$size=getimagesize($dateiziel."_b.".$inpbild); $breite=$size[0]; $hoehe=$size[1];  $typ=$size[2];
if($breite>$maxbreite) {
$neueBreite=$maxbreite;
$neueHoehe=intval($hoehe*$neueBreite/$breite);
$image1 = imagecreatetruecolor($neueBreite,$neueHoehe);
$weiss = ImageColorAllocate($image1,255,255,255);
ImageFilledRectangle($image1, 0,0, $neueBreite, $neueHoehe, $weiss);
switch ($typ) {
case 1: $image = imagecreatefromgif($dateiziel."_b.png"); break;
case 2: $image = imagecreatefromjpeg($dateiziel."_b.jpg"); break;
case 3: $image = imagecreatefrompng($dateiziel."_b.png"); break;
}
imagecopyresampled($image1,$image,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
switch ($typ) {
case 1: imagepng($image1,$dateiziel."_b.png"); break;
case 2: imagejpeg($image1,$dateiziel."_b.jpg",50); break;
case 3: imagepng($image1,$dateiziel."_b.png"); break;
}
ImageDestroy($image1);
}
}







function forum_wrap($str, $i) {
$j = $i;
while ($i < strlen($str)) {
if (strpos($str, ' ', $i-$j+1) > $i+$j || strpos($str, ' ', $i-$j+1) === false) {
$str = substr($str, 0, $i) . '#x%x#' . substr($str, $i);
}
$i += $j;
}
$str=str_replace("\r","",$str);
$str=str_replace("\n\n\n","\n\n",$str);
$str=str_replace("\n\n\n","\n\n",$str);
$str=str_replace("\n\n\n","\n\n",$str);
$str=str_replace("\n\n\n","\n\n",$str);
$str=str_replace("\n\n\n","\n\n",$str);
$str=str_replace("\n","<br>",$str);
$str=str_replace(":-D","<img src=images/35.png width=16 height=16 align=absmiddle>",$str);
$str=str_replace(":-)","<img src=images/36.png width=16 height=16 align=absmiddle>",$str);
$str=str_replace(":-|","<img src=images/37.png width=16 height=16 align=absmiddle>",$str);
$str=str_replace(":-(","<img src=images/38.png width=16 height=16 align=absmiddle>",$str);
$str=str_replace(":-o","<img src=images/39.png width=16 height=16 align=absmiddle>",$str);
$str=str_replace(":-p","<img src=images/40.png width=16 height=16 align=absmiddle>",$str);
$str=stripslashes($str);
$s_patter[]='"(( |^)((ftp|http|https){1}://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)"i';
$r_patter[]='<a href="\1" target=_blank>\\1</a>';
$s_patter[]='"( |^)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)"i';
$r_patter[]='\\1<a href="http://\2" target="_blank">\\2</a>';
$s_patter[]='"([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})"i';
$r_patter[]='<a href="mailto:\1">\\1</a>';
$str=preg_replace($s_patter,$r_patter,$str);

$str3=explode("<a",$str);
$count = count($str3);
for($i=0; $i < $count; $i++) {
if($str3[$i][0]==" " && $str3[$i][1]=="h" && $str3[$i][2]=="r" && $str3[$i][3]=="e" && $str3[$i][4]=="f") {
$str2=explode("</a>",$str3[$i]);
$str1.="<a".str_replace("#x%x#","",$str2[0])."</a>".$str2[1];
} else $str1.=$str3[$i];
}


return str_replace("#x%x#"," ",$str1);
}




$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdata);

if (mysqli_connect_errno()) {
printf("Verbindung zur Datenbank fehlgeschlagen: %s\n", mysqli_connect_error());
exit();
}

mysqli_query($db,"SET CHARACTER SET 'utf8'");
mysqli_query($db,"SET NAMES 'utf8'");

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

$seite=$_GET['seite']; if($seite=="") $seite=$_POST['seite'];
$seite=addslashes(htmlspecialchars($seite));

$rando=$_GET['rando']; if($rando=="") $rando=$_POST['rando'];

$se=explode("_",$s); $s=$se[0];
$ue=explode("_",$u); $u=$ue[0];

// session_save_path("__TEMP__");
session_name("cls"); session_start();



if($_SESSION['usermail']!="") $usermail=strtolower($_SESSION['usermail']);
if($_SESSION['pass']!="") $pass=strtolower($_SESSION['pass']);
if($_COOKIE['usermail']!="") $usermail=strtolower($_COOKIE['usermail']);
if($_COOKIE['pass']!="") $pass=strtolower($_COOKIE['pass']);
if($_POST['usermail']!="") $usermail=strtolower($_POST['usermail']);
if($_POST['pass']!="") $pass=strtolower($_POST['pass']);
if($_POST[ck]!="") {
setcookie("usermail", $usermail, time()+2592000);
setcookie("pass", $pass, time()+2592000);
}

if($usermail!="" && $pass!="" && $d!="logout") {
$mdc = mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE email = '".addslashes($usermail)."' AND pass = '".addslashes($pass)."'");
$usrd = mysqli_fetch_assoc($mdc);
if($usrd['id']!="") {
$_SESSION['usermail'] = $usermail; $_SESSION['pass'] = $pass;
$lg="ok";


mysqli_query($db,"UPDATE ".$dbx."_user SET online='".time()."' WHERE id='".$usrd['id']."'");
} else { session_unset(); $lg=""; setcookie("usermail", "", time()-7200); setcookie("pass", "", time()-7200); }
} else { session_unset(); $lg=""; setcookie("usermail", "", time()-7200); setcookie("pass", "", time()-7200); }


header("Content-Type: text/html; charset=iso-8859-1");


?>