<?php

$DO_TITEL="Einstellungen";

if($lg=="ok") {

echo '<legend>Einstellungen</legend>';

$a_ueber=forum_wrap(htmlspecialchars(stripslashes($_POST[a_ueber])),500);
$a_vorname=htmlspecialchars(stripslashes(ucfirst($_POST[a_vorname])));
$a_nachname=htmlspecialchars(stripslashes(ucfirst($_POST[a_nachname])));
$a_plz=htmlspecialchars(stripslashes($_POST[a_plz]));
$a_land=$_POST[a_land];
$a_ort=htmlspecialchars(stripslashes(ucfirst($_POST[a_ort])));
$a_geschlecht=$_POST[a_geschlecht];

$a_email=htmlspecialchars(stripslashes($_POST[a_email]));
$a_pass1=htmlspecialchars(stripslashes($_POST[a_pass1]));
$a_pass2=htmlspecialchars(stripslashes($_POST[a_pass2]));
$a_newsletter=htmlspecialchars(stripslashes($_POST[a_newsletter]));

if($_POST[o]=="k") {

if($a_newsletter=="ja") $a_newsletter=""; else $a_newsletter="nein";

$usrip=$_SERVER['REMOTE_ADDR'];

if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $a_email)) echo '<div class="alert alert-danger"><b>Ups!</b> Die angegebene E-Mail-Adresse ist ungültig.</div>';
elseif($getb[email]==$a_email) echo '<div class="alert alert-danger"><b>Ups!</b> Die angegebene E-Mail-Adresse ist ungültig.</div>';
elseif($a_pass1!="" && $a_pass1!=$a_pass2) echo '<div class="alert alert-danger"><b>Ups!</b> Neues Passwort und Wiederholung nicht identisch.</div>';
elseif(!is_numeric($a_plz) || strlen($a_plz)>5 || $a_plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($a_vorname=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Vorname" ausfüllen.</div>';
elseif($a_nachname=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Nachname" ausfüllen.</div>';
elseif($a_ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Ort" ausfüllen.</div>';
else { $noform="ok";

mysql_query("UPDATE ".$dbx."_user SET email='".addslashes($a_email)."', newsletter='".addslashes($a_newsletter)."', ip='".$usrip."' WHERE id='".$usrd[id]."'");
if($a_pass1!="" && $a_pass1==$a_pass2) mysql_query("UPDATE ".$dbx."_user SET pass='".addslashes($a_pass1)."', ip='".$usrip."' WHERE id='".$usrd[id]."'");

if($_FILES['p_avatar']['name']!="") {
  uploadImage('p_avatar','avatar/'.$usrd[id],'500','300');
}

$usrip=$_SERVER['REMOTE_ADDR'];

mysql_query("UPDATE ".$dbx."_user SET vorname='".addslashes($a_vorname)."', nachname='".addslashes($a_nachname)."', land='".addslashes($a_land)."', plz='".$a_plz."', ort='".addslashes($a_ort)."', geschlecht='".$a_geschlecht."', ip='".$usrip."' WHERE id='".$usrd[id]."'");

echo '<div class="alert alert-success"><b>Super!</b> Änderungen erfolgreich gespeichert.</div>';

}

}

if($noform!="ok") {

echo "<form action=index.php method=post enctype=multipart/form-data class=form-horizontal><input type=hidden name=d value=einstellungen><input type=hidden name=o value=k><table border=0 cellspacing=0 cellpadding=5>

<div class=form-group>
<label for=a_email class=\"col-lg-4 col-sm-4 control-label\">E-Mail</label><div class=\"col-lg-8 col-sm-8\">
<input type=text id=a_email name=a_email style=width:100%;max-width:350px; value=\"".$usrd[email]."\" class=form-control>
</div></div>

<div class=form-group>
<label for=a_newsletter class=\"col-lg-4 col-sm-4 control-label\"></label><div class=\"col-lg-8 col-sm-8\">
<input type=checkbox name=a_newsletter value=ja"; if($usrd[newsletter]!="nein") echo " checked"; echo "> Ja, ich möchte den Newsletter erhalten.
</div></div>

<br>

<div class=form-group>
<label for=a_pass1 class=\"col-lg-4 col-sm-4 control-label\">Neues Passwort</label><div class=\"col-lg-8 col-sm-8\">
<input type=password id=a_pass1 name=a_pass1 style=width:100%;max-width:300px; class=form-control>
</div></div>

<div class=form-group>
<label for=a_pass2 class=\"col-lg-4 col-sm-4 control-label\">Neues Passwort wiederholen</label><div class=\"col-lg-8 col-sm-8\">
<input type=password id=a_pass2 name=a_pass2 style=width:100%;max-width:300px; class=form-control>
</div></div>

<br>

<div class=form-group>
<label for=p_avatar class=\"col-lg-4 col-sm-4 control-label\">Profilfoto</label><div class=\"col-lg-8 col-sm-8\">
<input type=file name=p_avatar>
</div></div>

<br>

<div class=form-group>
<label for=a_ort class=\"col-lg-4 col-sm-4 control-label\">Geschlecht</label><div class=\"col-lg-8 col-sm-8\">
<img src=images/ico_user_w.png width=16 height=16 align=absmiddle><input type=radio name=a_geschlecht value=w id=w"; if($usrd[geschlecht]=="w") echo " checked"; echo "><label for=w>weiblich</label><br><img src=images/ico_user_m.png width=16 height=16 align=absmiddle><input type=radio name=a_geschlecht value=m id=m"; if($usrd[geschlecht]=="m") echo " checked"; echo "><label for=m>männlich</label>
</div></div>

<div class=form-group>
<label for=a_vorname class=\"col-lg-4 col-sm-4 control-label\">Vorname</label><div class=\"col-lg-8 col-sm-8\">
<input type=text id=a_vorname name=a_vorname style=width:100%;max-width:350px; value=\"".$usrd[vorname]."\" class=form-control>
</div></div>

<div class=form-group>
<label for=a_nachname class=\"col-lg-4 col-sm-4 control-label\">Nachname</label><div class=\"col-lg-8 col-sm-8\">
<input type=text id=a_nachname name=a_nachname style=width:100%;max-width:350px; value=\"".$usrd[nachname]."\" class=form-control>
</div></div>

<div class=form-group>
<label for=a_plz class=\"col-lg-4 col-sm-4 control-label\">PLZ</label><div class=\"col-lg-8 col-sm-8\">
<input type=text id=a_plz name=a_plz style=width:100px value=\"".$usrd[plz]."\" class=form-control>
</div></div>

<div class=form-group>
<label for=a_ort class=\"col-lg-4 col-sm-4 control-label\">Ort</label><div class=\"col-lg-8 col-sm-8\">
<input type=text id=a_ort name=a_ort style=width:100%;max-width:350px; value=\"".$usrd[ort]."\" class=form-control>
</div></div>

<div class=form-group>
<label for=\"a_land\" class=\"col-lg-4 col-sm-4 control-label\">Land</label><div class=\"col-lg-8 col-sm-8\"><div class=input-group><span class=input-group-addon><img src=images/flaggen/de.gif width=18 height=12 align=absmiddle name=flag></span><select style=width:100%;max-width:306px; onchange=\"document.images['flag'].src = 'images/flaggen/'+document.getElementById('land').value+'.gif';\" id=land name=a_land class=form-control>
<option value=de"; if($usrd[land]=="de") echo " selected"; echo ">Deutschland
<option value=at"; if($usrd[land]=="at") echo " selected"; echo ">Österreich
<option value=ch"; if($usrd[land]=="ch") echo " selected"; echo ">Schweiz
<option value=li"; if($usrd[land]=="li") echo " selected"; echo ">Liechtenstein
<option value=\"\">---
<option value=au"; if($usrd[land]=="au") echo " selected"; echo ">Australien
<option value=be"; if($usrd[land]=="be") echo " selected"; echo ">Belgien
<option value=dk"; if($usrd[land]=="dk") echo " selected"; echo ">Dänemark
<option value=fi"; if($usrd[land]=="fi") echo " selected"; echo ">Finnland
<option value=fr"; if($usrd[land]=="fr") echo " selected"; echo ">Frankreich
<option value=gr"; if($usrd[land]=="gr") echo " selected"; echo ">Griechenland
<option value=gb"; if($usrd[land]=="gb") echo " selected"; echo ">Grossbritannien
<option value=it"; if($usrd[land]=="it") echo " selected"; echo ">Italien
<option value=ca"; if($usrd[land]=="ca") echo " selected"; echo ">Kanada
<option value=lu"; if($usrd[land]=="lu") echo " selected"; echo ">Luxemburg
<option value=nz"; if($usrd[land]=="nz") echo " selected"; echo ">Neuseeland
<option value=nl"; if($usrd[land]=="nl") echo " selected"; echo ">Niederlande
<option value=no"; if($usrd[land]=="no") echo " selected"; echo ">Norwegen
<option value=pl"; if($usrd[land]=="pl") echo " selected"; echo ">Polen
<option value=pt"; if($usrd[land]=="pt") echo " selected"; echo ">Portugal
<option value=se"; if($usrd[land]=="se") echo " selected"; echo ">Schweden
<option value=sk"; if($usrd[land]=="sk") echo " selected"; echo ">Slowakei
<option value=es"; if($usrd[land]=="es") echo " selected"; echo ">Spanien
<option value=tr"; if($usrd[land]=="tr") echo " selected"; echo ">Türkei
<option value=us"; if($usrd[land]=="us") echo " selected"; echo ">USA
<option value=\"\">---
<option value=\"\""; if($usrd[land]=="") echo " selected"; echo ">Sonstiges Land
</select></div>
</div></div>

<br>

<div class=form-group>
<label for=\"a_submit\" class=\"col-lg-4 col-sm-4 control-label\"></label><div class=\"col-lg-8 col-sm-8\">
<input type=submit value=Speichern class=\"btn btn-default\">
</div></div>

</form>";

?><script type="text/javascript">

$('.usr').alphanumeric();
$('.plz').numeric();
$('.cap').alpha();

</script><?php

}


}
else {
include("inc/login.inc.php");
}

?>