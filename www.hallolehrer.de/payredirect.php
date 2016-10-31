<?php

error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');
include_once("class/core.class.php");

$betrag=$_POST[betrag];
$flatrate=$_POST[flatrate];
$userkonto=$_POST[userkonto];
$psp=$_POST[psp];

if($flatrate!="") {

if($flatrate=="1") $frbetrag = $coredata['flatrate1'];
elseif($flatrate=="2") $frbetrag = $coredata['flatrate2'];
elseif($flatrate=="3") $frbetrag = $coredata['flatrate3'];

}




if($usrd[id]=="" || ($betrag=="" && $flatrate=="") || $userkonto=="" || $psp=="") {
echo "Error: Ungültige Variablen.";
exit();
}


elseif($psp=="su" && $betrag!="") {

echo '<form action="https://www.sofortueberweisung.de/payment/start" name=payform method="post">
<input name="amount" type="hidden" value="'.$betrag.'.00">
<input name="currency_id" type="hidden" value="'.$coredata['waehrung'].'">
<input name="reason_1" type="hidden" value="Konto aufladen">
<input name="user_variable_0" type="hidden" value="'.$userkonto.'">
<input name="user_id" type="hidden" value="'.$coredata['sofortueberweisunguser'].'">
<input name="project_id" type="hidden" value="'.$coredata['sofortueberweisungprojekt'].'">
</form><script type=text/javascript language=javascript><!--
document.payform.submit();
--></script>';

}



elseif($psp=="pp" && $betrag!="") {

echo '<form action="'; if($coredata['paypalsandbox']=="on") echo 'https://www.sandbox.paypal.com/cgi-bin/webscr'; echo 'https://www.paypal.com/cgi-bin/webscr'; echo'" name=payform method=post>
<input type=hidden name=cmd value=_xclick>
<input type=hidden name=business value='.$coredata['paypalemail'].'>
<input type=hidden name=item_name value="'.$coredata['titel'].': Konto aufladen">
<input type=hidden name=item_number value="'.$userkonto.'">
<input type=hidden name=amount value='.$betrag.'>
<input type=hidden name=currency_code value='.$coredata['waehrung'].'>
<input type=hidden name=notify_url value="http://'.$coredata['url'].'/paylistener/paypal.php">
<input type=hidden name=return value="http://'.$coredata['url'].'/?d=konto&s=aufladen&u=danke">
<input type=hidden name=no_shipping value="1">
<input type=hidden name=rm value="1">
<input type=hidden name=lc value="de">
</form><script type=text/javascript language=javascript><!--
document.payform.submit();
--></script>';

}


elseif($psp=="su" && $flatrate!="") {

echo '<form action="https://www.sofortueberweisung.de/payment/start" name=payform method="post">
<input name="amount" type="hidden" value="'.$frbetrag.'.00">
<input name="currency_id" type="hidden" value="'.$coredata['waehrung'].'">
<input name="reason_1" type="hidden" value="Flatrate buchen">
<input name="user_variable_0" type="hidden" value="flatrate-'.$flatrate.'-'.$userkonto.'">
<input name="user_id" type="hidden" value="'.$coredata['sofortueberweisunguser'].'">
<input name="project_id" type="hidden" value="'.$coredata['sofortueberweisungprojekt'].'">
</form><script type=text/javascript language=javascript><!--
document.payform.submit();
--></script>';

}



elseif($psp=="pp" && $flatrate!="") {

echo '<form action="'; if($coredata['paypalsandbox']=="on") echo 'https://www.sandbox.paypal.com/cgi-bin/webscr'; echo 'https://www.paypal.com/cgi-bin/webscr'; echo'" name=payform method=post>
<input type=hidden name=cmd value=_xclick>
<input type=hidden name=business value='.$coredata['paypalemail'].'>
<input type=hidden name=item_name value="'.$coredata['titel'].': Flatrate buchen">
<input type=hidden name=item_number value="flarate-'.$flatrate.'-'.$userkonto.'">
<input type=hidden name=amount value='.$frbetrag.'>
<input type=hidden name=currency_code value='.$coredata['waehrung'].'>
<input type=hidden name=notify_url value="http://'.$coredata['url'].'/paylistener/paypal.php">
<input type=hidden name=return value="http://'.$coredata['url'].'/?d=konto&s=aufladen&u=danke">
<input type=hidden name=no_shipping value="1">
<input type=hidden name=rm value="1">
<input type=hidden name=lc value="de">
</form><script type=text/javascript language=javascript><!--
document.payform.submit();
--></script>';

}


?><div id=wloader style="display:block;position:absolute;top:50%;left:50%;margin-left:-64px;margin-top:-8px;background-color:#fff;padding:10px;"><img src=images/loading.gif></div>