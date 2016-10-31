<?php

$betrag=$_POST[betrag]/100;
$user_number1 = explode("-",$_POST['usernumber']);
$user_number = $user_number1[2];
$txn=$_POST[txn];
$datum=time();

include("../config.inc.php");
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdata);

$getuser=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$user_number."'");
$user=mysqli_fetch_array($getuser);

if($user_number1[0]=="flatrate" && $user[id]!="" && $coredata['minbetrag']<=$betrag) {

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','su','".$txn."','flatrate','".$betrag."','".time()."','ok')");

if($user_number1[1]=="1") $dauer = 30 * 86400;
elseif($user_number1[1]=="2") $dauer = 90 * 86400;
elseif($user_number1[1]=="3") $dauer = 365 * 86400;
$flatratebis = time() + $dauer;

mysqli_query($db,"UPDATE ".$dbx."_user SET flatrate='".$flatratebis."' WHERE id='".$user[id]."'");

}

elseif($user[id]!="" && $coredata['minbetrag']<=$betrag) {

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','su','".$txn."','einzahlung','".$betrag."','".time()."','ok')");

$neuguthaben=$user[guthaben]+$betrag;
mysqli_query($db,"UPDATE ".$dbx."_user SET guthaben='".$neuguthaben."' WHERE id='".$user[id]."'");

$ph1=array('%vorname%','%nachname%','%betrag%','%titel%','%url%');
$ph2=array($user[vorname],$user[nachname],$betrag,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/einzahlungbestaetigung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($user[email],"Konto-Einzahlung bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

}

else {
mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','su','".$txn."','einzahlung','".$betrag."','".time()."','')");
}

?>