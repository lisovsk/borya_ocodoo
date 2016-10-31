<?php


if($lg=="ok") {

echo '<legend>Gegenstand anbieten</legend>';
$DO_TITEL="Gegenstand anbieten";

$titel=htmlspecialchars(stripslashes(ucfirst($_POST[titel])));
$kat=htmlspecialchars(stripslashes($_POST[kat]));
$strasse=htmlspecialchars(stripslashes(ucfirst($_POST[strasse])));
$plz=htmlspecialchars(stripslashes($_POST[plz]));
$ort=htmlspecialchars(stripslashes(ucfirst($_POST[ort])));
$land=htmlspecialchars(stripslashes($_POST[land]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));
$preis_tag=htmlspecialchars(stripslashes($_POST[preis_tag]));
$kaution=htmlspecialchars(stripslashes($_POST[kaution]));
$mindauer=htmlspecialchars(stripslashes($_POST[mindauer]));

if($_POST[o]=="k") {

if($titel=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Überschrift" ausfüllen.</div>';
elseif(strlen($titel)>50) echo '<div class="alert alert-danger"><b>Ups!</b> Die Überschrift ist zu lang. Bitte maximal 50 Zeichen.</div>';
elseif($_FILES['foto1']['name']=="" && $_FILES['foto2']['name']=="" && $_FILES['foto3']['name']=="") echo '<div class="alert alert-danger"><b>Ups!</b> Fügen Sie bitte mindestens 1 Foto hinzu.</div>';
elseif($preis_tag=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Preis pro Tag angeben.</div>';
elseif(!preg_match("/^[0-9]+$/s",$preis_tag)) echo '<div class="alert alert-danger"><b>Ups!</b> Der angegebene Preis pro Tag ist keine gültige Zahl.</div>';
elseif($strasse=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Strasse" ausfüllen.</div>';
elseif($ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Ort angeben.</div>';
elseif(!is_numeric($plz) || strlen($plz)>5 || $plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Beschreibung" ausfüllen.</div>';
else { $noform="ok";



mysql_query("INSERT INTO ".$dbx."_gegenstand (user,titel,kat,strasse,plz,ort,land,preis_tag,mindauer,kaution,cont,datum,status) VALUES ('".$usrd[id]."','".addslashes($titel)."','".$kat."','".addslashes($strasse)."','".addslashes($plz)."','".addslashes($ort)."','".$land."','".addslashes($preis_tag)."','".addslashes($mindauer)."','".addslashes($kaution)."','".addslashes($cont)."','".time()."','ok')");
$uid=mysql_insert_id();



$ph1=array('%vorname%','%nachname%','%gegenstandtitel%','%gegenstandurl%','%email%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$titel,genURL('gegenstand',$uid,urlseotext($titel)),$coredata[email],$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/gegenstandinseriert.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Ihr Gegenstand bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


if($_FILES['foto1']['name']!="") {
  uploadImage('foto1','fotos/'.$uid.'_1','615','240');
}
if($_FILES['foto2']['name']!="") {
  uploadImage('foto2','fotos/'.$uid.'_2','615','240');
}
if($_FILES['foto3']['name']!="") {
  uploadImage('foto3','fotos/'.$uid.'_3','615','240');
}


echo '<div class="alert alert-success"><b>Super!</b> Ihr Gegenstand wurde erfolgreich inseriert.</div>';

echo '<div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;border:1px solid #ccc;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('gegenstand',$uid,urlseotext($titel)).'">';
if(file_exists("fotos/".$uid."_1_t.jpg")==1) echo '<img src="fotos/'.$uid.'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$uid."_1_t.png")==1) echo '<img src="fotos/'.$uid.'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('gegenstand',$uid,urlseotext($titel)).'"><b>'.$titel.'</a></b></div>
<div style="padding:5px;padding-bottom:1px;">'.$plz.' '.$ort.'</div>
<div style="padding:5px;padding-top:1px;"><b>'.$preis_tag.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> pro Tag</div>

</div>';

echo '</td></tr></table></div>';






}
}

if($noform!="ok") {


echo '<div>Inserieren Sie Ihren Gegenstand bei '.$coredata[titel].' und verdienen Sie einfach und regelmäßig Geld dazu. Das Inserieren ist komplett kostenlos, erst bei erfolgreichen Vermietungen wird eine Gebühr von '.$coredata['gebuehr'].'% vom Gesamtpreis abgezogen.</div><br><br>';


echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal"><input type=hidden name=d value=vermieten><input type=hidden name=o value=k>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Passende Überschrift</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$titel.'" class=form-control placeholder="z.B. Borhammer, Nähmaschine usw.">
</div></div>

<div class=form-group>
<label for=kat class="col-lg-4 col-sm-3 control-label">Kategorie</label><div class="col-lg-8 col-sm-9">
<select id="kat" name=kat class=form-control style="width:100%;max-width:350px;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
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
<span class="help-block">Wo befindet sich der Gegenstand?</span>
</div></div>

<div class=form-group>
<label for=strasse class="col-lg-4 col-sm-3 control-label">Strasse</label><div class="col-lg-8 col-sm-9">
<input type=text id=strasse name=strasse style="width:100%;max-width:350px;" value="'.$ff_strasse.'" class=form-control>
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
<label for=preis_tag class="col-lg-4 col-sm-3 control-label">Preis pro Tag</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wählen Sie einen Preis, der für Mieter attraktiv und leicht zu vergleichen ist.<br>(Vom Betrag werden vor der Auszahlung <b>'.$coredata['gebuehr'].'% Gebühr</b> abgezogen).</span>
<div class=input-group style=width:130px;>
<input type=text id=preis_tag name=preis_tag value="'.$preis_tag.'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<div class=form-group>
<label for=kaution class="col-lg-4 col-sm-3 control-label">Kaution</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Muss der Mieter während der Miete eine Kaution hinterlegen?</span>
<div class=input-group style=width:130px;>
<input type=text id=kaution name=kaution value="'.$kaution.'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<div class=form-group>
<label for=mindauer class="col-lg-4 col-sm-3 control-label">Mindestmietdauer</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Kann der Gegenstand auch nur einen Tag gemietet werden oder müssen es mehrere Tage sein?</span>
<div class=input-group style=width:130px;>
<select id=mindauer name=mindauer class=form-control>
<option>1 Tag
<option>2 Tage
<option>3 Tage
<option>4 Tage
<option>5 Tage
<option>6 Tage
<option>7 Tage
<option>8 Tage
<option>9 Tage
<option>10 Tage
<option>11 Tage
<option>12 Tage
<option>13 Tage
<option>14 Tage
<option>21 Tage
<option>30 Tage
<option>60 Tage
</select>
</div>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Ein paar Details zum Gegenstand, den Mietbedingungen und ggf. über Sie als Vermieter:</span>
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