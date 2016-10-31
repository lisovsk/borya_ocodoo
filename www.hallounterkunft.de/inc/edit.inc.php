<legend>Unterkunft bearbeiten</legend><?php

$DO_TITEL="Unterkunft bearbeiten";

$edit=htmlspecialchars(stripslashes($_GET[edit]));
if(!$edit) $edit=htmlspecialchars(stripslashes($_POST[edit]));
$del=htmlspecialchars(stripslashes($_GET[del]));
if(!$del) $del=htmlspecialchars(stripslashes($_POST[del]));
$nvfb=htmlspecialchars(stripslashes($_GET[nvfb]));
if(!$nvfb) $nvfb=htmlspecialchars(stripslashes($_POST[nvfb]));

$getunterkunft = mysql_query("SELECT * FROM ".$dbx."_unterkunft WHERE id='".$edit."' OR id='".$del."' OR id='".$nvfb."'");
$unterkunft = mysql_fetch_array($getunterkunft);

if($usrd[id]==$unterkunft[user] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") {


if($nvfb!="") {
if($_POST[o]=="k") {

$datumvon = explode(".",$_POST[datumvon]);
$datumbis = explode(".",$_POST[datumbis]);
$datumvon_timestamp = mktime(11,0,0,$datumvon[1],$datumvon[0],$datumvon[2]);
$datumbis_timestamp = mktime(11,0,0,$datumbis[1],$datumbis[0],$datumbis[2]);

mysql_query("INSERT INTO ".$dbx."_mieten (user,art,unterkunft,von,bis,datum) VALUES ('".$usrd[id]."','nv','".$unterkunft[id]."','".$datumvon_timestamp."','".$datumbis_timestamp."','".time()."')");

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

echo 'Wann ist die Unterkunft nicht verfügbar?<br><br>
<form action=index.php method=post class="form-inline"><input type=hidden name=d value=edit><input type=hidden name=nvfb value='.$unterkunft[id].'><input type=hidden name=o value=k>
<input type="text" name="datumvon" id="datumvon" value="'.$dateMorgen.'" style="width:110px;" class="form-control">
bis
<input type="text" name="datumbis" id="datumbis" value="'.$dateDreiTage.'" style="width:110px;" class="form-control">
<input type=submit value="Speichern" class="btn btn-default"></form>';

}
}

else {



$titel=htmlspecialchars(stripslashes(ucfirst($_POST[titel])));
$art=htmlspecialchars(stripslashes($_POST[art]));
$strasse=htmlspecialchars(stripslashes(ucfirst($_POST[strasse])));
$plz=htmlspecialchars(stripslashes($_POST[plz]));
$ort=htmlspecialchars(stripslashes(ucfirst($_POST[ort])));
$land=htmlspecialchars(stripslashes($_POST[land]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));
$regeln=htmlspecialchars(stripslashes($_POST[regeln]));
$preis_nacht=htmlspecialchars(stripslashes($_POST[preis_nacht]));
$getAusstattung=$_POST[ausstattung];
$groesse=htmlspecialchars(stripslashes($_POST[groesse]));
$max_gaeste=htmlspecialchars(stripslashes($_POST[max_gaeste]));
$anz_schlafzimmer=htmlspecialchars(stripslashes($_POST[anz_schlafzimmer]));
$anz_badezimmer=htmlspecialchars(stripslashes($_POST[anz_badezimmer]));
$art_badezimmer=htmlspecialchars(stripslashes($_POST[art_badezimmer]));

if($edit!="" && $_POST[o]=="k") {

if($titel=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Überschrift" ausfüllen.</div>';
elseif(strlen($titel)>50) echo '<div class="alert alert-danger"><b>Ups!</b> Die Überschrift ist zu lang. Bitte maximal 50 Zeichen.</div>';
elseif($preis_nacht=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Preis pro Nacht angeben.</div>';
elseif(!preg_match("/^[0-9]+$/s",$preis_nacht)) echo '<div class="alert alert-danger"><b>Ups!</b> Der angegebene Preis pro Nacht ist keine gültige Zahl.</div>';
elseif($strasse=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Strasse" ausfüllen.</div>';
elseif($ort=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Ort angeben.</div>';
elseif(!is_numeric($plz) || strlen($plz)>5 || $plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Beschreibung" ausfüllen.</div>';
elseif(!is_numeric($groesse) || strlen($groesse)>4 || $groesse=="") echo '<div class="alert alert-danger"><b>Ups!</b> Die angegebene Fläche ist keine gültige Zahl.</div>';
else { $noform="ok";

foreach($getAusstattung as $fetchAusstattung)
$ausstattung .= "|".$fetchAusstattung."|";

mysql_query("UPDATE ".$dbx."_unterkunft SET user='".$usrd[id]."', titel='".addslashes($titel)."', art='".$art."', strasse='".addslashes($strasse)."', plz='".addslashes($plz)."', ort='".addslashes($ort)."', land='".$land."', preis_nacht='".addslashes($preis_nacht)."', anz_schlafzimmer='".$anz_schlafzimmer."', anz_badezimmer='".$anz_badezimmer."', max_gaeste='".$max_gaeste."', groesse='".addslashes($groesse)."', cont='".addslashes($cont)."', regeln='".addslashes($regeln)."', ausstattung='".$ausstattung."' WHERE id='".$edit."'");
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

<div style="padding:5px;"><a href="'.genURL('unterkunft',$uid,urlseotext($titel)).'"><b>'.$titel.'</a></b></div>
<div style="padding:5px;padding-bottom:1px;">'.$plz.' '.$ort.'</div>
<div style="padding:5px;padding-top:1px;"><b>'.$preis_nacht.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> pro Nacht</div>

</div>';

echo '</td></tr></table></div>';

}
}

if($del!="" && $o=="k") {
mysql_query("UPDATE ".$dbx."_unterkunft SET status='del' WHERE id='".$del."'");
echo '<div class="alert alert-success"><b>Okay!</b> Ihre Unterkunft wurde erfolgreich gelöscht.</div>';
}
elseif($del!="") echo 'Möchten Sie die Unterkunft wirklich löschen?<br><br><form action=index.php method=get><input type=hidden name=d value=edit><input type=hidden name=del value='.$del.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';
elseif($edit!="" && $noform!="ok") {

echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal"><input type=hidden name=d value=edit><input type=hidden name=edit value='.$edit.'><input type=hidden name=o value=k>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Passende Überschrift</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$unterkunft[titel].'" class=form-control placeholder="z.B. Moderne Ferienwohnung direkt am See">
</div></div>

<div class=form-group>
<label for=art class="col-lg-4 col-sm-3 control-label">Art der Unterkunft</label><div class="col-lg-8 col-sm-9">
<select id="art" name=art class=form-control style="width:100%;max-width:350px;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($unterkunft[art]==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[art].'</option>';
}

echo '</select>
</div></div>

<div class=form-group>
<label for=strasse class="col-lg-4 col-sm-3 control-label">Strasse</label><div class="col-lg-8 col-sm-9">
<input type=text id=strasse name=strasse style="width:100%;max-width:350px;" value="'.$unterkunft[strasse].'" class=form-control>
</div></div>

<div class=form-group>
<label for=plz class="col-lg-4 col-sm-3 control-label">PLZ</label><div class="col-lg-8 col-sm-9">
<input type=text id=plz name=plz style="width:100px" value="'.$unterkunft[plz].'" class=form-control>
</div></div>

<div class=form-group>
<label for=ort class="col-lg-4 col-sm-3 control-label">Ort</label><div class="col-lg-8 col-sm-9">
<input type=text id=ort name=ort style="width:100%;max-width:350px;" value="'.$unterkunft[ort].'" class=form-control>
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
<span class="help-block">Wählen Sie einen Preis, der für Gäste attraktiv und leicht zu vergleichen ist.<br>(Vom Betrag werden vor der Auszahlung <b>'.$coredata['gebuehr'].'% Gebühr</b> abgezogen).</span>
<div class=input-group style=width:130px;>
<input type=text id=preis_nacht name=preis_nacht value="'.$unterkunft[preis_nacht].'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Ein paar Details zur Unterkunft, Umgebung und über Sie als Gastgeber:</span>
<textarea name=cont class=form-control style="width:100%;height:150px;">'.$unterkunft[cont].'</textarea>
</div></div>

<div class=form-group>
<label for=regeln class="col-lg-4 col-sm-3 control-label">Hausregeln</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Verlangen Sie eine Kaution? Muss eine Nachtruhe eingehalten werden? Oder müssen Ihre Gäste sonstige Bedingungen erfüllen?</span>
<textarea name=regeln class=form-control style=width:100%;height:150px;>'.$unterkunft[regeln].'</textarea>
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
<label for=ausstattung class="col-lg-4 col-sm-3 control-label">Ausstattung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Was bietet die Unterkunft alles?</span>
<div class="row">';

$getausstattung=mysql_query("SELECT * FROM ".$dbx."_data_ausstattung ORDER BY id");
while($ausstattung=mysql_fetch_array($getausstattung)) {
echo '<div class="col-lg-4 col-sm-6"><label for="a'.$ausstattung[id].'"><input id="a'.$ausstattung[id].'" type=checkbox name=ausstattung[] value="'.$ausstattung[id].'"'; if(strpos($unterkunft[ausstattung],"|".$ausstattung[id]."|")!==false) echo ' checked'; echo '> '.$ausstattung[ausstattung].'</label></div>';
}

echo '</div>
</div></div>

<br>

<div class=form-group>
<label for=groesse class="col-lg-4 col-sm-3 control-label">Fläche</label><div class="col-lg-8 col-sm-9">
<div class=input-group style=width:120px>
<input type=text id=groesse name=groesse value="'.$unterkunft[groesse].'" class=form-control>
<span class="input-group-addon">m2</span>
</div>
</div></div>

<div class=form-group>
<label for=max_gaeste class="col-lg-4 col-sm-3 control-label">Maximale Anzahl Gäste</label><div class="col-lg-8 col-sm-9">
<select id=max_gaeste name=max_gaeste class=form-control style=width:80px>
<option>'.$unterkunft[max_gaeste].'
<option>1
<option>2
<option>3
<option>4
<option>5
<option>6
<option>7
<option>8
<option>9
<option>10
<option>11
<option>12
<option>13
<option>14
<option>15
<option>16
<option>17
<option>18
<option>19
<option>20
</select>
</div></div>

<div class=form-group>
<label for=anz_schlafzimmer class="col-lg-4 col-sm-3 control-label">Anzahl Schlafzimmer</label><div class="col-lg-8 col-sm-9">
<select id=anz_schlafzimmer name=anz_schlafzimmer class=form-control style=width:80px>
<option>'.$unterkunft[anz_schlafzimmer].'
<option>1
<option>2
<option>3
<option>4
<option>5
<option>6
<option>7
<option>8
<option>9
<option>10
</select>
</div></div>

<div class=form-group>
<label for=anz_badezimmer class="col-lg-4 col-sm-3 control-label">Anzahl Badezimmer</label><div class="col-lg-8 col-sm-9">
<select id=anz_badezimmer name=anz_badezimmer class=form-control style=width:80px>
<option>'.$unterkunft[anz_badezimmer].'
<option>1
<option>2
<option>3
<option>4
<option>5
<option>6
<option>7
<option>8
<option>9
<option>10
</select>
</div></div>

<div class=form-group>
<label for=art_badezimmer class="col-lg-4 col-sm-3 control-label">Art des Badezimmers</label><div class="col-lg-8 col-sm-9">
<select id=art_badezimmer name=art_badezimmer class=form-control style=width:200px>
<option value=privat>Privat</option>
<option value=geteilt'; if($unterkunft[anz_badezimmer]=="geteilt") echo ' selected'; echo '>Geteilt</option>
</select>
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