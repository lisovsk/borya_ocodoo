<legend>Passwort vergessen</legend><?php

$DO_TITEL="Passwort vergessen";

if($_POST[o]=="k") {

$pw_email=htmlspecialchars(stripslashes($_POST[pw_email]));
$getpwdata = mysql_query("SELECT * FROM ".$dbx."_user WHERE email='".$pw_email."'");
$pwdata = mysql_fetch_array($getpwdata);
if($pwdata[id]=="") echo genMsg('images/ico_error.png','E-Mail-Adresse ungültig.');
else {
srand(date("s")); while($i<8) { $a_pass.=chr((rand()%26)+97); $i++; }

mysql_query("UPDATE ".$dbx."_user SET pass='".$a_pass."' WHERE id='".$pwdata[id]."'");

$ph1=array('%vorname%','%nachname%','%user%','%pass%','%titel%','%url%');
$ph2=array($pwdata[vorname],$pwdata[nachname],$pwdata[user],$a_pass,$coredata[titel],$coredata[url]);
$mailtext = file_get_contents('template/texte/passwortvergessen.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);

mail($pwdata[email],'Passwort vergessen',$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");
echo '<div class="alert alert-success"><b>Hilfe ist unterwegs!</b> Sie erhalten in Kürze eine E-Mail mit einem neuen Passwort.</div>';

}
}

else {
echo 'Sie haben Ihr Passwort vergessen?<br>Kein Problem. Einfach hier Ihre E-Mail angeben und es wird Ihnen geholfen:';

echo '<br><br><form action=index.php method=post class="form-inline"><input type=hidden name=d value=passwort><input type=hidden name=o value=k><input type=text name=pw_email style=width:200px value="'.$pw_email.'" class="form-control" placeholder="E-Mail">
<input type=submit value="Weiter" class="btn btn-default"></form>';

}

?>