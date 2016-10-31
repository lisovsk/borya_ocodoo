<?php


if($lg=="ok") {

echo '<legend>Auftrag ausschreiben</legend>';
$DO_TITEL="Auftrag ausschreiben";

$titel=htmlspecialchars(stripslashes(ucfirst($_POST[titel])));
$kat=htmlspecialchars(stripslashes($_POST[kat]));
$plz=htmlspecialchars(stripslashes($_POST[plz]));
$ort=htmlspecialchars(stripslashes(ucfirst($_POST[ort])));
$land=htmlspecialchars(stripslashes($_POST[land]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));
$tage_ende=htmlspecialchars(stripslashes($_POST[tage_ende]));

if($_POST[o]=="k") {

if($titel=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Überschrift" ausfüllen.</div>';
elseif(strlen($titel)>50) echo '<div class="alert alert-danger"><b>Ups!</b> Die Überschrift ist zu lang. Bitte maximal 50 Zeichen.</div>';
elseif($_FILES['foto1']['name']=="" && $_FILES['foto2']['name']=="" && $_FILES['foto3']['name']=="") echo '<div class="alert alert-danger"><b>Ups!</b> Fügen Sie bitte mindestens 1 Foto hinzu.</div>';
elseif($ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Ort angeben.</div>';
elseif(!is_numeric($plz) || strlen($plz)>5 || $plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Beschreibung" ausfüllen.</div>';
else { $noform="ok";

$datum_ende = time() + ( $tage_ende * 86400 );

mysqli_query($db,"INSERT INTO ".$dbx."_auftraege (user,titel,kat,plz,ort,land,cont,datum,datum_ende,status) VALUES ('".$usrd[id]."','".addslashes($titel)."','".$kat."','".addslashes($plz)."','".addslashes($ort)."','".$land."','".addslashes($cont)."','".time()."','".$datum_ende."','ok')");
$uid=mysqli_insert_id($db);



$ph1=array('%vorname%','%nachname%','%auftragtitel%','%auftragurl%','%email%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$titel,genURL('auftrag',$uid,urlseotext($titel)),$coredata[email],$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/auftraginseriert.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Ihr Auftrag bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


if($_FILES['foto1']['name']!="") {
  uploadImage('foto1','fotos/'.$uid.'_1','615','240');
}
if($_FILES['foto2']['name']!="") {
  uploadImage('foto2','fotos/'.$uid.'_2','615','240');
}
if($_FILES['foto3']['name']!="") {
  uploadImage('foto3','fotos/'.$uid.'_3','615','240');
}


echo '<div class="alert alert-success"><b>Super!</b> Ihr Auftrag wurde erfolgreich ausgeschrieben.</div>';

echo '<div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;border:1px solid #ccc;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('auftrag',$uid,urlseotext($titel)).'">';
if(file_exists("fotos/".$uid."_1_t.jpg")==1) echo '<img src="fotos/'.$uid.'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$uid."_1_t.png")==1) echo '<img src="fotos/'.$uid.'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('auftrag',$uid,urlseotext($titel)).'"><b>'.$titel.'</a></b></div>
<div style="padding:5px;padding-bottom:1px;">'.$plz.' '.$ort.'</div></div>

</div>';

echo '</td></tr></table></div>';






}
}

if($noform!="ok") {



echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"><input type=hidden name=d value=eintragen><input type=hidden name=o value=k>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label"><img src=images/info_checkliste.png></label><div class="col-lg-8 col-sm-9">
<span class="help-block">
<b>Auftrag ausschreiben und bestes Angebot auswählen:</b><br><br>
<img src=images/ico_check.png width=16 height=16 align=absmiddle> Schreiben Sie Ihren Auftrag jetzt bei '.$coredata[titel].' aus.<br>
<img src=images/ico_check.png width=16 height=16 align=absmiddle> Erhalten Sie unverbindlich Angebote von Dienstleistern und Handwerkern in Ihrer Nähe.<br>
<img src=images/ico_check.png width=16 height=16 align=absmiddle> Inserieren und die Auftragsvergabe sind für Sie als Auftraggeber komplett kostenlos.</span>
</div></div><br>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Passende Überschrift</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$titel.'" class=form-control placeholder="z.B. Parket verlegen, Wordpress-Blog aufsetzen usw.">
</div></div>

<div class=form-group>
<label for=kat class="col-lg-4 col-sm-3 control-label">Kategorie</label><div class="col-lg-8 col-sm-9">
<select id="kat" name=kat class=form-control style="width:100%;max-width:350px;">';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'">'.$fetchArt[kat].'</option>';
}

if($strasse!="") $ff_strasse=$strasse; else $ff_strasse=$usrd[strasse];
if($plz!="") $ff_plz=$plz; else $ff_plz=$usrd[plz];
if($ort!="") $ff_ort=$ort; else $ff_ort=$usrd[ort];

echo '</select>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">&nbsp;</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wo muss der Auftrag erledigt werden?</span>
</div></div>


<div class=form-group>
<label for=plz class="col-lg-4 col-sm-3 control-label">PLZ</label><div class="col-lg-8 col-sm-9">
<input type=text id=plz name=plz style="width:100px" value="'.$ff_plz.'" class=form-control>
</div></div>

<div class=form-group>
<label for=ort class="col-lg-4 col-sm-3 control-label">Ort</label><div class="col-lg-8 col-sm-9">
<input type=text id=ort name=ort style="width:100%;max-width:350px;" value="'.$ff_ort.'" class=form-control>
</div></div>

<div class=form-group>
<label for="land" class="col-lg-4 col-sm-3 control-label">Land</label><div class="col-lg-8 col-sm-9"><div class=input-group><span class=input-group-addon><img src=images/flaggen/de.gif width=18 height=12 align=absmiddle name=flag></span><select style="width:100%;max-width:306px;" onchange="document.images[\'flag\'].src = \'images/flaggen/\'+document.getElementById(\'land\').value+\'.gif\';" id=land name=land class=form-control>
<option value=de>Deutschland
<option value=at>Österreich
<option value=ch>Schweiz
<option value=li>Liechtenstein
<option value="">---
<option value=au>Australien
<option value=be>Belgien
<option value=dk>Dänemark
<option value=fi>Finnland
<option value=fr>Frankreich
<option value=gr>Griechenland
<option value=gb>Grossbritannien
<option value=it>Italien
<option value=ca>Kanada
<option value=lu>Luxemburg
<option value=nz>Neuseeland
<option value=nl>Niederlande
<option value=no>Norwegen
<option value=pl>Polen
<option value=pt>Portugal
<option value=se>Schweden
<option value=sk>Slowakei
<option value=es>Spanien
<option value=tr>Türkei
<option value=us>USA
<option value="">---
<option value="">Sonstiges Land
</select></div>
</div></div>

<br>


<div class=form-group>
<label for=tage_ende class="col-lg-4 col-sm-3 control-label">Angebotsphase</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wie lange soll der Auftrag ausgeschrieben werden, bevor Sie ein Angebot auswählen?<br>Je länger, desto eher erhalten Sie passende Angebote.</span>
<div class=input-group style=width:130px;>
<select id=tage_ende name=tage_ende class=form-control>
<option>3 Tage
<option>5 Tage
<option>7 Tage
<option>10 Tage
<option selected>14 Tage
<option>21 Tage
<option>30 Tage
<option>60 Tage
<option>90 Tage
</select>
</div>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Beschreiben Sie den zu erledigenden Auftrag möglichst genau:</span>
<textarea name=cont class=form-control style="width:100%;height:150px;">'.$cont.'</textarea>
</div></div>


<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Foto(s)</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Laden Sie bis zu 3 Fotos hoch, mindestens jedoch eines:</span>
<div><input type=file name=foto1></div>
<div id=wenigerfotos><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerfotos\');$.toggle(\'#mehrfotos\');">Weiteres Foto</a></div>
<div id=mehrfotos style=display:none>
<div><input type=file name=foto2></div>
<div id=wenigerfotos2><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerfotos2\');$.toggle(\'#mehrfotos2\');">Weiteres Foto</a></div>
<div id=mehrfotos2 style=display:none>
<div><input type=file name=foto3></div>
</div>
</div>
<script type=text/javascript>
$.toggle = function(query) { $(query).toggle("slow"); }
</script>

</div></div>


<br>

<div class=form-group>
<label for="a_submit" class="col-lg-4 col-sm-3 control-label"></label><div class="col-lg-8 col-sm-9">
<input type=submit value=Weiter class="btn btn-default">
</div></div>

</form>';
}




}
else {
include("inc/login.inc.php");
}

?>