<?php
  $raw_post_data = file_get_contents('php://input');
  $raw_post_array = explode('&', $raw_post_data);
  $myPost = array();
  foreach ($raw_post_array as $keyval)
  {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
         $myPost[$keyval[0]] = urldecode($keyval[1]);
  }
  $req = 'cmd=_notify-validate';
  if(function_exists('get_magic_quotes_gpc'))
  {
       $get_magic_quotes_exits = true;
  }
  foreach ($myPost as $key => $value)
  {
       if($get_magic_quotes_exits == true && get_magic_quotes_gpc() == 1)
       {
            $value = urlencode(stripslashes($value));
       }
       else
       {
            $value = urlencode($value);
       }
       $req .= "&$key=$value";
  }

$ch = curl_init();
if($coredata['paypalsandbox']=="on") $ppurl='https://www.sandbox.paypal.com/cgi-bin/webscr';
echo $ppurl='https://www.paypal.com/cgi-bin/webscr';
curl_setopt($ch, CURLOPT_URL, $ppurl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.paypal.com'));
// In wamp like environment where the root authority certificate doesn't comes in the bundle, you need
// to download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below.
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
$res = curl_exec($ch);
curl_close($ch);

$item_name = $_POST['item_name'];

$user_number1 = explode("-",$_POST['item_number']);
$user_number = $user_number1[2];

$payment_status = $_POST['payment_status'];
$get_payment_amount = explode(".",$_POST['mc_gross']);
$payment_amount = $get_payment_amount[0];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$datum = time();

include("../config.inc.php");
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdata);

$getuser=mysqli_query($db,"SELECT * FROM ".$dbx."_user WHERE id='".$user_number."'");
$user=mysqli_fetch_array($getuser);



if($user_number1[0]=="flatrate" && $user[id]!="" && $user_number!="" && $payer_email!="" && $receiver_email==$coredata['paypalemail'] && $payment_status=="Completed") {

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','pp','".$txn_id."','flatrate','".$payment_amount."','".time()."','ok')");

if($user_number1[1]=="1") $dauer = 30 * 86400;
elseif($user_number1[1]=="2") $dauer = 90 * 86400;
elseif($user_number1[1]=="3") $dauer = 365 * 86400;
$flatratebis = time() + $dauer;

mysqli_query($db,"UPDATE ".$dbx."_user SET flatrate='".$flatratebis."' WHERE id='".$user[id]."'");

}



elseif($user[id]!="" && $user_number!="" && $payer_email!="" && $receiver_email==$coredata['paypalemail'] && $coredata['minbetrag']<=$payment_amount && $payment_status=="Completed") {

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','pp','".$txn_id."','einzahlung','".$payment_amount."','".time()."','ok')");

$neuguthaben=$user[guthaben]+$payment_amount;
mysqli_query($db,"UPDATE ".$dbx."_user SET guthaben='".$neuguthaben."' WHERE id='".$user[id]."'");

$ph1=array('%vorname%','%nachname%','%betrag%','%titel%','%url%');
$ph2=array($user[vorname],$user[nachname],$payment_amount,$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/einzahlungbestaetigung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($user[email],"Konto-Einzahlung bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


} else {

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,payprovider,payid,buchung,betrag,datum,status) VALUES ('".$user[id]."','pp','".$txn_id."','einzahlung','".$payment_amount."','".time()."','')");

}





?>