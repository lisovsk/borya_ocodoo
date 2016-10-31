<?php

$betrag=$_POST[betrag]/100;
$user_number=$_POST[usernumber];
$txn=$_POST[txn];
$datum=time();

include("../config.inc.php");
mysql_connect("$dbserver","$dbuser","$dbpass");
mysql_select_db($dbdata);

$getuser=mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$user_number."'");
$user=mysql_fetch_array($getuser);

if($user[id]!="" && $coredata['minbetrag']<=$betrag) {

mysql_query("INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','su','".$txn."','einzahlung','".$betrag."','".time()."','ok')");

$neuguthaben=$user[guthabe]+$betrag;
mysql_query("UPDATE ".$dbx."_user SET guthaben='".$neuguthaben."' WHERE id='".$user[id]."'");

$ph1=array('%vorname%','%nachname%','%betrag%','%titel%','%url%');
$ph2=array($user[vorname],$user[nachname],$betrag,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/einzahlungbestaetigung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($user[email],"Konto-Einzahlung bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

}

else {
mysql_query("INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','su','".$txn."','einzahlung','".$betrag."','".time()."','')");
}

?>