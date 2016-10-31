<?php

$DO_TITEL="Verifizierung";

if($lg=="ok") {


echo '<legend>Verifizierung</legend>';

if($usrd[verifizierung]=="ok") echo '<div class="alert alert-success"><b>Super!</b> Ihr Konto wurde erfolgreich verifiziert.</div>';
elseif($usrd[verifizierung]=="wt") echo '<div class="alert alert-danger"><b>Bitte warten!</b> Ihre Ausweiskopie wird derzeit überprüft.</div>';
else {
if($_POST[o]=="k") {


if($_FILES['p_ausweis']['name']=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine Datei auswählen.</div>';
else { $noform="ok";

if($_FILES['p_ausweis']['name']!="") {
  uploadImage('p_ausweis','fotos/vc_'.$usrd[id],'1000','600');
}


mysql_query("UPDATE ".$dbx."_user SET verifizierung='wt' WHERE id='".$usrd[id]."'");

$ph1=array('%vorname%','%nachname%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/adminausweiskopie.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($coredata[email],"[".$coredata[titel]."] Verifizierung beantragt",$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Super!</b> Die Ausweiskopie wurde hochgeladen und wird schnellstmöglich überprüft.</div>';


}

}

if($noform!="ok") {

echo "<img src=images/intro_ausweiskopie.png align=right class=img-responsive>Stärken Sie das Vertrauen, indem Sie Ihr ".$coredata[titel]."-Konto verifizieren lassen. Durch den \"Verifiziert\"-Badge In Ihrem Profil erhalten Sie als Vermieter mehr Buchungen und als Mieter erhöhen Sie die Chancen, dass Ihre Buchungsanfragen von den Vermietern akzeptiert werden.<br><br><b>Und das funktioniert ganz einfach:</b><br><br>Als Identifikationsnachweis muss ein Personalausweis oder ein ähnliches Identifikationsdokument vorgewiesen werden. Dazu müssen Sie den Ausweis zuerst scannen oder digital fotografieren. Die Bilddatei des Ausweises muss dabei in guter Auflösung bereitgestellt werden, so dass alle wichtigen Daten gut lesbar sind. Das Dokument wird selbstverständlich vertraulich behandelt und nicht veröffentlicht, sondern lediglich von einem Administrator überprüft.<br><br>Die Ausweiskopie können Sie hier hochladen:<br><br><br>


<form action=index.php method=post enctype=multipart/form-data class=form-horizontal><input type=hidden name=d value=verifizierung><input type=hidden name=o value=k><table border=0 cellspacing=0 cellpadding=5>

<div class=form-group>
<label for=p_avatar class=\"col-lg-4 col-sm-4 control-label\">Ausweiskopie</label><div class=\"col-lg-8 col-sm-8\">
<input type=file name=p_ausweis>
</div></div>

<div class=form-group>
<label for=\"a_submit\" class=\"col-lg-4 col-sm-4 control-label\"></label><div class=\"col-lg-8 col-sm-8\">
<input type=submit value=Weiter class=\"btn btn-default\">
</div></div>

</form>";

?><script type="text/javascript">

$('.usr').alphanumeric();
$('.plz').numeric();
$('.cap').alpha();

</script><?php


}














}

}
else {
include("inc/login.inc.php");
}

?>