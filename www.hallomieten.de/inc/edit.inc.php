<legend>Gegenstand bearbeiten</legend><?php

$DO_TITEL="Gegenstand bearbeiten";

$edit=htmlspecialchars(stripslashes($_GET[edit]));
if(!$edit) $edit=htmlspecialchars(stripslashes($_POST[edit]));
$del=htmlspecialchars(stripslashes($_GET[del]));
if(!$del) $del=htmlspecialchars(stripslashes($_POST[del]));
$nvfb=htmlspecialchars(stripslashes($_GET[nvfb]));
if(!$nvfb) $nvfb=htmlspecialchars(stripslashes($_POST[nvfb]));

$getgegenstand = mysql_query("SELECT * FROM ".$dbx."_gegenstand WHERE id='".$edit."' OR id='".$del."' OR id='".$nvfb."'");
$gegenstand = mysql_fetch_array($getgegenstand);

if($usrd[id]==$gegenstand[user] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") {











if($nvfb!="") {
if($_POST[o]=="k") {

$datumvon = explode(".",$_POST[datumvon]);
$datumbis = explode(".",$_POST[datumbis]);
$datumvon_timestamp = mktime(11,0,0,$datumvon[1],$datumvon[0],$datumvon[2]);
$datumbis_timestamp = mktime(11,0,0,$datumbis[1],$datumbis[0],$datumbis[2]);

mysql_query("INSERT INTO ".$dbx."_mieten (user,art,gegenstand,von,bis,datum) VALUES ('".$usrd[id]."','nv','".$gegenstand[id]."','".$datumvon_timestamp."','".$datumbis_timestamp."','".time()."')");

echo '<div class="alert alert-success"><b>Okay!</b> Die Nichtverfügbarkeit wurde erfolgreich gespeichert.</div>';

}
else {

?><script>
$(document).ready(function() {
  $(function() {
    $("#datumvon").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+5M +27D",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
$(document).ready(function() {
  $(function() {
    $("#datumbis").datepicker({
      dateFormat: "dd.mm.yy",
      firstDay: 1,
      minDate: 1,
      maxDate: "+6M",
      showButtonPanel: false,
      dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
      monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
        'Juni', 'Juli', 'August', 'September', 'Oktober',  'November', 'Dezember'],
      showAnim: 'puff'
    });
  });
});
</script><?php

$dateMorgen = date("d.m.Y",time()+86400);
$dateDreiTage = date("d.m.Y",time()+345600);

echo 'Wann ist der Gegenstand nicht verfügbar?<br><br>
<form action=index.php method=post class="form-inline"><input type=hidden name=d value=edit><input type=hidden name=nvfb value='.$gegenstand[id].'><input type=hidden name=o value=k>
<input type="text" name="datumvon" id="datumvon" value="'.$dateMorgen.'" style="width:110px;" class="form-control">
bis
<input type="text" name="datumbis" id="datumbis" value="'.$dateDreiTage.'" style="width:110px;" class="form-control">
<input type=submit value="Speichern" class="btn btn-default"></form>';

}
}



else {


















$titel=htmlspecialchars(stripslashes(ucfirst($_POST[titel])));
$kat=htmlspecialchars(stripslashes($_POST[kat]));
$strasse=htmlspecialchars(stripslashes(ucfirst($_POST[strasse])));
$plz=htmlspecialchars(stripslashes($_POST[plz]));
$ort=htmlspecialchars(stripslashes(ucfirst($_POST[ort])));
$land=htmlspecialchars(stripslashes($_POST[land]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));
$regeln=htmlspecialchars(stripslashes($_POST[regeln]));
$preis_tag=htmlspecialchars(stripslashes($_POST[preis_tag]));

if($edit!="" && $_POST[o]=="k") {

if($titel=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Überschrift" ausfüllen.</div>';
elseif(strlen($titel)>50) echo '<div class="alert alert-danger"><b>Ups!</b> Die Überschrift ist zu lang. Bitte maximal 50 Zeichen.</div>';
elseif($preis_tag=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Preis pro Tag angeben.</div>';
elseif(!preg_match("/^[0-9]+$/s",$preis_tag)) echo '<div class="alert alert-danger"><b>Ups!</b> Der angegebene Preis pro Tag ist keine gültige Zahl.</div>';
elseif($strasse=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Strasse" ausfüllen.</div>';
elseif($ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Ort angeben.</div>';
elseif(!is_numeric($plz) || strlen($plz)>5 || $plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Beschreibung" ausfüllen.</div>';
else { $noform="ok";




mysql_query("UPDATE ".$dbx."_gegenstand SET user='".$usrd[id]."', titel='".addslashes($titel)."', kat='".$kat."', strasse='".addslashes($strasse)."', plz='".addslashes($plz)."', ort='".addslashes($ort)."', land='".$land."', preis_tag='".addslashes($preis_tag)."', cont='".addslashes($cont)."' WHERE id='".$edit."'");
$uid=$edit;


if($_FILES['foto1']['name']!="") {
  uploadImage('foto1','fotos/'.$uid.'_1','615','240');
}
if($_FILES['foto2']['name']!="") {
  uploadImage('foto2','fotos/'.$uid.'_2','615','240');
}
if($_FILES['foto3']['name']!="") {
  uploadImage('foto3','fotos/'.$uid.'_3','615','240');
}


echo '<div class="alert alert-success"><b>Hat geklappt!</b> Die Änderungen wurden gespeichert.</div>';

echo '<div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;border:1px solid #ccc;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('unterkunft',$uid,urlseotext($titel)).'">';
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

if($del!="" && $o=="k") {
mysql_query("UPDATE ".$dbx."_gegenstand SET status='del' WHERE id='".$del."'");
echo '<div class="alert alert-success"><b>Okay!</b> Ihr Gegenstand wurde erfolgreich gelöscht.</div>';
}
elseif($del!="") echo 'Möchten Sie den Gegenstand wirklich löschen?<br><br><form action=index.php method=get><input type=hidden name=d value=edit><input type=hidden name=del value='.$del.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';
elseif($edit!="" && $noform!="ok") {



echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal"><input type=hidden name=d value=edit><input type=hidden name=edit value='.$edit.'><input type=hidden name=o value=k>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Passende Überschrift</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$gegenstand[titel].'" class=form-control placeholder="z.B. Moderne Ferienwohnung direkt am See">
</div></div>

<div class=form-group>
<label for=kat class="col-lg-4 col-sm-3 control-label">Kategorie</label><div class="col-lg-8 col-sm-9">
<select id="kat" name=kat class=form-control style="width:100%;max-width:350px;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($gegenstand[kat]==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[kat].'</option>';
}

echo '</select>
</div></div>

<div class=form-group>
<label for=strasse class="col-lg-4 col-sm-3 control-label">Strasse</label><div class="col-lg-8 col-sm-9">
<input type=text id=strasse name=strasse style="width:100%;max-width:350px;" value="'.$gegenstand[strasse].'" class=form-control>
</div></div>

<div class=form-group>
<label for=plz class="col-lg-4 col-sm-3 control-label">PLZ</label><div class="col-lg-8 col-sm-9">
<input type=text id=plz name=plz style="width:100px" value="'.$gegenstand[plz].'" class=form-control>
</div></div>

<div class=form-group>
<label for=ort class="col-lg-4 col-sm-3 control-label">Ort</label><div class="col-lg-8 col-sm-9">
<input type=text id=ort name=ort style="width:100%;max-width:350px;" value="'.$gegenstand[ort].'" class=form-control>
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
<label for=preis_nacht class="col-lg-4 col-sm-3 control-label">Preis pro Nacht</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wählen Sie einen Preis, der für Mieter attraktiv und leicht zu vergleichen ist.<br>(Vom Betrag werden vor der Auszahlung <b>'.$coredata['gebuehr'].'% Gebühr</b> abgezogen).</span>
<div class=input-group style=width:130px;>
<input type=text id=preis_tag name=preis_tag value="'.$gegenstand[preis_tag].'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Ein paar Details zum Gegenstand, den Mietbedingungen und ggf. über Sie als Vermieter:</span>
<textarea name=cont class=form-control style="width:100%;height:150px;">'.$gegenstand[cont].'</textarea>
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
<input type=submit value=Speichern class="btn btn-default">
</div></div>

</form>';
}

}


}
else echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben keine Berechtigung für diese Aktion.</div>';

?>