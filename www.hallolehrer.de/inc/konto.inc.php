<?php

if($lg=="ok") {

echo '<legend>Mein Guthaben</legend>';
$DO_TITEL="Mein Guthaben";

echo '<div class="row">
<div class="col-lg-8 col-sm-7">';



if($s=="danke") {
echo genMsg('images/ico_ok.png','Danke für die Zahlung.').'<br><br>Es kann einige Minuten dauern, bis der Betrag auf Ihrem Konto gutgeschrieben wurde.';
}



elseif($s=="auszahlung") {
echo '<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class=smallroundcorners><b>Auszahlung beantragen</b></div>';

$aart=htmlspecialchars(stripslashes($_POST[aart]));
$paypal=htmlspecialchars(stripslashes($_POST[paypal]));
$bank_name=htmlspecialchars(stripslashes($_POST[bank_name]));
$bank_inhaber=htmlspecialchars(stripslashes($_POST[bank_inhaber]));
$bank_konto=htmlspecialchars(stripslashes($_POST[bank_konto]));
$bank_blz=htmlspecialchars(stripslashes($_POST[bank_blz]));

if($usrd[guthaben]<$coredata[minauszahlung]) echo genMsg('images/ico_error.png','Der Mindestbetrag für eine Auszahlung beträgt '.number_format($coredata[minauszahlung],2).' '.$coredata['waehrung'].'.');

elseif($aart!="") {

mysqli_query($db,"UPDATE ".$dbx."_user SET auszahlungsart='".addslashes($aart)."', paypal='".addslashes($paypal)."', bank_name='".addslashes($bank_name)."', bank_konto='".addslashes($bank_konto)."', bank_blz='".addslashes($bank_blz)."', bank_inhaber='".addslashes($bank_inhaber)."', guthaben='0' WHERE id='".$usrd[id]."'");

mysqli_query($db,"INSERT INTO ".$dbx."_auszahlung (user,betrag,datum) VALUES ('".$usrd[id]."','".$usrd[guthaben]."','".time()."')");

mysqli_query($db,"INSERT INTO ".$dbx."_konto (user,buchung,betrag,datum,status) VALUES ('".$usrd[id]."','auszahlung','-".$usrd[guthaben]."','".time()."','ok')");

$ph1=array('%vorname%','%nachname%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/adminauszahlung.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($coredata[email],"[".$coredata[titel]."] Auszahlung beantragt",$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Vielen Dank!</b> Die Auszahlung wird schnellstmöglich vorgenommen.</div>';

}

else {

echo '<form action=index.php method=post class=form-horizontal><input type=hidden name=d value=konto><input type=hidden name=s value=auszahlung>

<div class=form-group>
<label class="col-lg-4 col-sm-4 control-label">Empfänger</label>
<label class="col-lg-8 col-sm-8 control-label" style="text-align:left;"><big><b>'.number_format($usrd[guthaben],2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></big></label>
</div>

<div class=form-group>
<label for=aart class="col-lg-4 col-sm-4 control-label">Auszahlungsart</label><div class="col-lg-8 col-sm-8">
<input type=radio name=aart value=paypal checked> PayPal<br><input type=radio name=aart value=bank> Banküberweisung
</div></div>

<br>

<div class=form-group>
<label for=paypal class="col-lg-4 col-sm-4 control-label">PayPal (E-Mail)</label><div class="col-lg-8 col-sm-8">
<input type=text id=paypal name=paypal style=width:280px value="'.$usrd[paypal].'" class=form-control>
</div></div>

<div class=form-group>
<label for=paypal class="col-lg-4 col-sm-4 control-label"><i>oder:</i></label></div>

<div class=form-group>
<label for=bank_konto class="col-lg-4 col-sm-4 control-label">Kontonummer</label><div class="col-lg-8 col-sm-8">
<input type=text id=bank_konto name=bank_konto style=width:280px value="'.$usrd[bank_konto].'" class=form-control>
</div></div>

<div class=form-group>
<label for=bank_inhaber class="col-lg-4 col-sm-4 control-label">Kontoinhaber</label><div class="col-lg-8 col-sm-8">
<input type=text id=bank_inhaber name=bank_inhaber style=width:280px value="'.$usrd[bank_inhaber].'" class=form-control>
</div></div>

<div class=form-group>
<label for=bank_name class="col-lg-4 col-sm-4 control-label">Name der Bank</label><div class="col-lg-8 col-sm-8">
<input type=text id=bank_name name=bank_name style=width:280px value="'.$usrd[bank_name].'" class=form-control>
</div></div>

<div class=form-group>
<label for=bank_blz class="col-lg-4 col-sm-4 control-label">Bankleitzahl (BLZ)</label><div class="col-lg-8 col-sm-8">
<input type=text id=bank_blz name=bank_blz style=width:280px value="'.$usrd[bank_blz].'" class=form-control>
</div></div>

<div class=form-group>
<label class="col-lg-4 col-sm-4 control-label"></label><div class="col-lg-8 col-sm-8">
<input type=submit value="Weiter" class="btn btn-default">
</div></div>

</form>';

}

echo '<br><br>';

}
else {

echo '<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class=smallroundcorners><b>Letzte Buchungen</b></div>
<div style="padding:5px;margin-bottom:20px;">';

$getbuchungen=mysqli_query($db,"SELECT * FROM ".$dbx."_konto WHERE user='".$usrd[id]."' AND status='ok' ORDER BY datum DESC LIMIT 0,20");
if(mysqli_num_rows($getbuchungen)==0) echo '<i>Bisher keine Kontobewegungen.</i>';
else {

while($buchung=mysqli_fetch_assoc($getbuchungen)) {
echo '<div class="row" style="border-bottom:1px solid #ccc;padding-top:5px;padding-bottom:5px;">
<div class="col-lg-3 col-sm-4">'.date("d.m.Y, H:i",$buchung[datum]).'</div>
<div class="col-lg-7 col-sm-5 col-8">';

if($buchung[buchung]=="einzahlung" && $buchung[payprovider]=="pp") echo 'Einzahlung via PayPal';
elseif($buchung[buchung]=="einzahlung" && $buchung[payprovider]=="su") echo 'Einzahlung via Sofortüberweisung';
elseif($buchung[buchung]=="einzahlung") echo 'Einzahlung';
elseif($buchung[buchung]=="auszahlung") echo 'Auszahlung';
elseif($buchung[buchung]=="gutschein") echo 'Gutschein';
elseif($buchung[buchung]=="start") echo 'Startguthaben (Willkommen bei '.$coredata[titel].')';
elseif($buchung[buchung]=="coach") echo 'Buchung Ihres <a href="'.genURL('kurs',$buchung[kurs]).'">Kurses</a>';
elseif($buchung[buchung]=="kurs") echo '<a href="'.genURL('kurs',$buchung[kurs]).'">Kurs</a> gebucht';
else echo '<i>Unbekannte Buchung</i>';

echo '</div>
<div class="col-lg-2 col-sm-3 col-4" style="text-align:right;"><font color="'; if($buchung[betrag]<0) echo 'red'; else echo 'darkgreen'; echo '"><b>'.number_format($buchung[betrag],2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b></font></div></div>';
}

}

echo '</div>';

}





echo '</div>

<div class="col-lg-4 col-sm-5">

<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class=smallroundcorners><b>Aktueller Kontostand</b></div>
<div style="padding:5px;font-size:28px;font-weight:bold;margin-bottom:20px;">
'.number_format($usrd[guthaben],2,',','.').' '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '
</div>

<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class=smallroundcorners><b>Guthaben aufladen</b></div>
<div style="padding:5px;margin-bottom:20px;">
<form action=payredirect.php method=post><input type=hidden name=userkonto value='.$usrd[id].'><input type=hidden name=psp value="">Betrag aufladen: <select name=betrag style=width:80px>';

$s=$coredata['minbetrag'];
while($s<($coredata['maxbetrag']+1)) { echo "<option"; if($s==20) echo " selected"; echo " value=".$s.">".$s.",00"; $s=$s+$coredata['betragschritte']; }

echo '</select> <b><big>'; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</big></b><br><br>Zahlung ausführen mit:<br>';
if($coredata['paypal']=="ja") echo '<input type=image src=images/logo_paypal.png width=83 height=28 alt="PayPal" name=psp value=pp style="padding:2px;border:1px solid #ccc;margin-right:5px;" onclick="this.form.psp.value=\'pp\';this.form.submit()" class=smallroundcorners>';
if($coredata['sofortueberweisung']=="ja") echo '<input type=image src=images/logo_sofortueberweisung.png width=83 height=28 alt="Sofortüberweisung" name=psp value=ue style="padding:2px;border:1px solid #ccc;" onclick="this.form.psp.value=\'su\';this.form.submit()" class=smallroundcorners>';

echo '</form>
</div>';



echo '

<div style="padding:5px;background-color:#eee;margin-bottom:10px;" class=smallroundcorners><b>Auszahlung</b></div>
<div style="padding:5px;margin-bottom:20px;">
<img src=images/ico_payout.png width=16 height=16 align=absmiddle> <a href="'.genURL('konto','auszahlung').'">Betrag auszahlen lassen</a>
</div>

</div>
</div>';








}
else {
include("inc/login.inc.php");
}

?>