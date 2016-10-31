<legend>Fahrzeug bearbeiten</legend><?php

$DO_TITEL="Fahrzeug bearbeiten";

$edit=htmlspecialchars(stripslashes($_GET[edit]));
if(!$edit) $edit=htmlspecialchars(stripslashes($_POST[edit]));
$del=htmlspecialchars(stripslashes($_GET[del]));
if(!$del) $del=htmlspecialchars(stripslashes($_POST[del]));
$nvfb=htmlspecialchars(stripslashes($_GET[nvfb]));
if(!$nvfb) $nvfb=htmlspecialchars(stripslashes($_POST[nvfb]));

$getfahrzeug = mysql_query("SELECT * FROM ".$dbx."_fahrzeug WHERE id='".$edit."' OR id='".$del."' OR id='".$nvfb."'");
$fahrzeug = mysql_fetch_array($getfahrzeug);

if($usrd[id]==$fahrzeug[user] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") {


if($nvfb!="") {
if($_POST[o]=="k") {

$datumvon = explode(".",$_POST[datumvon]);
$datumbis = explode(".",$_POST[datumbis]);
$datumvon_timestamp = mktime(11,0,0,$datumvon[1],$datumvon[0],$datumvon[2]);
$datumbis_timestamp = mktime(11,0,0,$datumbis[1],$datumbis[0],$datumbis[2]);

mysql_query("INSERT INTO ".$dbx."_mieten (user,art,fahrzeug,von,bis,datum) VALUES ('".$usrd[id]."','nv','".$fahrzeug[id]."','".$datumvon_timestamp."','".$datumbis_timestamp."','".time()."')");

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

echo 'Wann ist das Fahrzeug nicht verfügbar?<br><br>
<form action=index.php method=post class="form-inline"><input type=hidden name=d value=edit><input type=hidden name=nvfb value='.$fahrzeug[id].'><input type=hidden name=o value=k>
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
$preis_tag=htmlspecialchars(stripslashes($_POST[preis_tag]));
$marke=htmlspecialchars(stripslashes($_POST[marke]));
$modell=htmlspecialchars(stripslashes($_POST[modell]));
$tueren=htmlspecialchars(stripslashes($_POST[tueren]));
$sitze=htmlspecialchars(stripslashes($_POST[sitze]));
$kmstand=htmlspecialchars(stripslashes($_POST[kmstand]));
$getriebe=htmlspecialchars(stripslashes($_POST[getriebe]));
$jahrgang=htmlspecialchars(stripslashes($_POST[jahrgang]));
$inklkm=htmlspecialchars(stripslashes($_POST[inklkm]));
$zusatzkm=htmlspecialchars(stripslashes($_POST[zusatzkm]));

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

mysql_query("UPDATE ".$dbx."_fahrzeug SET user='".$usrd[id]."', titel='".addslashes($titel)."', art='".$art."', strasse='".addslashes($strasse)."', plz='".addslashes($plz)."', ort='".addslashes($ort)."', land='".$land."', preis_tag='".addslashes($preis_tag)."', marke='".$marke."', modell='".$modell."', tueren='".$tueren."', sitze='".$sitze."', getriebe='".$getriebe."', kmstand='".$kmstand."', jahrgang='".addslashes($jahrgang)."', inklkm='".addslashes($inklkm)."', zusatzkm='".addslashes($zusatzkm)."', cont='".addslashes($cont)."', regeln='".addslashes($regeln)."' WHERE id='".$edit."'");
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

echo '<div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;border:1px solid #ccc;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('fahrzeug',$uid,urlseotext($titel)).'">';
if(file_exists("fotos/".$uid."_1_t.jpg")==1) echo '<img src="fotos/'.$uid.'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$uid."_1_t.png")==1) echo '<img src="fotos/'.$uid.'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('fahrzeug',$uid,urlseotext($titel)).'"><b>'.$titel.'</a></b></div>
<div style="padding:5px;padding-bottom:1px;">'.$plz.' '.$ort.'</div>
<div style="padding:5px;padding-top:1px;"><b>'.$preis_tag.',00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</b> pro Tag</div>

</div>';

echo '</td></tr></table></div>';

}
}

if($del!="" && $o=="k") {
mysql_query("UPDATE ".$dbx."_fahrzeug SET status='del' WHERE id='".$del."'");
echo '<div class="alert alert-success"><b>Okay!</b> Ihr Fahrzeug wurde erfolgreich gelöscht.</div>';
}
elseif($del!="") echo 'Möchten Sie das Fahrzeug wirklich löschen?<br><br><form action=index.php method=get><input type=hidden name=d value=edit><input type=hidden name=del value='.$del.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';
elseif($edit!="" && $noform!="ok") {

echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal"><input type=hidden name=d value=edit><input type=hidden name=edit value='.$edit.'><input type=hidden name=o value=k>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Passende Überschrift</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$fahrzeug[titel].'" class=form-control placeholder="z.B. Moderne Ferienwohnung direkt am See">
</div></div>

<div class=form-group>
<label for=art class="col-lg-4 col-sm-3 control-label">Art des Fahrzeuges</label><div class="col-lg-8 col-sm-9">
<select id="art" name=art class=form-control style="width:100%;max-width:350px;">';

$getArten = mysql_query("SELECT * FROM ".$dbx."_data_art ORDER BY id");
while($fetchArt = mysql_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($fahrzeug[art]==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[art].'</option>';
}

echo '</select>
</div></div>

<div class=form-group>
<label for=strasse class="col-lg-4 col-sm-3 control-label">Strasse</label><div class="col-lg-8 col-sm-9">
<input type=text id=strasse name=strasse style="width:100%;max-width:350px;" value="'.$fahrzeug[strasse].'" class=form-control>
</div></div>

<div class=form-group>
<label for=plz class="col-lg-4 col-sm-3 control-label">PLZ</label><div class="col-lg-8 col-sm-9">
<input type=text id=plz name=plz style="width:100px" value="'.$fahrzeug[plz].'" class=form-control>
</div></div>

<div class=form-group>
<label for=ort class="col-lg-4 col-sm-3 control-label">Ort</label><div class="col-lg-8 col-sm-9">
<input type=text id=ort name=ort style="width:100%;max-width:350px;" value="'.$fahrzeug[ort].'" class=form-control>
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
<input type=text id=preis_tag name=preis_tag value="'.$fahrzeug[preis_tag].'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<br>



<div class=form-group>
<label for=inklkm class="col-lg-4 col-sm-3 control-label">Inklusiv-Kilometer</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wieviele Kilometer sind pro Miettag inklusive?</span>
<select id=inklkm name=inklkm class=form-control style=width:200px>
<option>'.$fahrzeug[inklkm].'
<option value=0>Unbeschränkt
<option>50
<option>100
<option>200
<option>300
<option>400
<option>500
</select>
</div></div>

<div class=form-group>
<label for=zusatzkm class="col-lg-4 col-sm-3 control-label">Zusätzl. Kilometer</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Falls die Inklusiv-Kilometer aufgebraucht sind, wieviel kostet jeder zusätzliche Kilometer?</span>
<div class=input-group style=width:100px>
<select id=zusatzkm name=zusatzkm class=form-control style=width:100px>
<option>'.$fahrzeug[zusatzkm].'
<option value=0>keine</option>
<option value=5>0,05</option>
<option value=10>0,10</option>
<option value=15>0,15</option>
<option value=20>0,20</option>
<option value=25>0,25</option>
<option value=30>0,30</option>
<option value=35>0,35</option>
<option value=40>0,40</option>
<option value=45>0,45</option>
<option value=50>0,50</option>
<option value=75>0,75</option>
<option value=100>1,00</option>
<option value=125>1,25</option>
<option value=150>1,50</option>
<option value=200>2,00</option>
</select>
<span class="input-group-addon">'; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>





<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Ein paar Details zum Fahrzeug, Ausstattung und über Sie als Gastgeber:</span>
<textarea name=cont class=form-control style="width:100%;height:150px;">'.$fahrzeug[cont].'</textarea>
</div></div>

<div class=form-group>
<label for=regeln class="col-lg-4 col-sm-3 control-label">Regeln</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Verlangen Sie eine Kaution? Muss bestimmte Zeiten eingehalten werden? Oder müssen Ihre Mieter sonstige Bedingungen erfüllen?</span>
<textarea name=regeln class=form-control style=width:100%;height:150px;>'.$fahrzeug[regeln].'</textarea>
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
<label for=marke class="col-lg-4 col-sm-3 control-label">Marke</label><div class="col-lg-8 col-sm-9">
<input type=text id=marke name=marke style="width:100%;max-width:350px;" value="'.$fahrzeug[marke].'" class=form-control placeholder="z.B. Volkswagen">
</div></div>

<div class=form-group>
<label for=modell class="col-lg-4 col-sm-3 control-label">Modell</label><div class="col-lg-8 col-sm-9">
<input type=text id=modell name=modell style="width:100%;max-width:350px;" value="'.$fahrzeug[modell].'" class=form-control placeholder="z.B. Polo">
</div></div>

<div class=form-group>
<label for=jahrgang class="col-lg-4 col-sm-3 control-label">Fahrzeug-Jahrgang</label><div class="col-lg-8 col-sm-9">
<input type=text id=jahrgang name=jahrgang style="width:100px" value="'.$fahrzeug[jahrgang].'" class=form-control placeholder="z.B. 2007">
</div></div>

<div class=form-group>
<label for=tueren class="col-lg-4 col-sm-3 control-label">Anzahl Türen</label><div class="col-lg-8 col-sm-9">
<select id=tueren name=tueren class=form-control style=width:80px>
<option>'.$fahrzeug[tueren].'
<option>0
<option>1
<option>2
<option>3
<option>4
<option selected>5
<option>6
</select>
</div></div>

<div class=form-group>
<label for=sitze class="col-lg-4 col-sm-3 control-label">Anzahl Sitzplätze</label><div class="col-lg-8 col-sm-9">
<select id=sitze name=sitze class=form-control style=width:80px>
<option>'.$fahrzeug[sitze].'
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
</select>
</div></div>

<div class=form-group>
<label for=getriebe class="col-lg-4 col-sm-3 control-label">Getriebe</label><div class="col-lg-8 col-sm-9">
<select id=getriebe name=getriebe class=form-control style=width:200px>
<option value=handschaltung>Handschaltung</option>
<option value=automatik'; if($fahrzeug[sitze]=="automatik") echo ' selected'; echo '>Automatik</option>
<option value=sonstiges'; if($fahrzeug[sitze]=="sonstiges") echo ' selected'; echo '>Sonstiges</option>
</select>
</div></div>


<div class=form-group>
<label for=kmstand class="col-lg-4 col-sm-3 control-label">Kilometerstand</label><div class="col-lg-8 col-sm-9">
<div class=input-group style=width:200px>
<select id=kmstand name=kmstand class=form-control style=width:200px>
<option value=0>Keine Angabe</option>
<option value=50000'; if($fahrzeug[kmstand]=="50000") echo ' selected'; echo '>Unter 50.000</option>
<option value=100000'; if($fahrzeug[kmstand]=="100000") echo ' selected'; echo '>50.000 bis 100.000</option>
<option value=150000'; if($fahrzeug[kmstand]=="150000") echo ' selected'; echo '>100.001 bis 150.000</option>
<option value=200000'; if($fahrzeug[kmstand]=="200000") echo ' selected'; echo '>150.001 bis 200.000</option>
<option value=200001'; if($fahrzeug[kmstand]=="200001") echo ' selected'; echo '>Über 200.001</option>
</select>
<span class="input-group-addon">km</span>
</div>
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