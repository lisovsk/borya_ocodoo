<?php


if($lg=="ok") {

echo '<legend>Kurs anbieten</legend>';
$DO_TITEL="Kurs anbieten";

$titel=htmlspecialchars(stripslashes(ucfirst($_POST[titel])));
$kat=htmlspecialchars(stripslashes($_POST[kat]));
$standort=htmlspecialchars(stripslashes($_POST[standort]));
$plz=htmlspecialchars(stripslashes($_POST[plz]));
$ort=htmlspecialchars(stripslashes(ucfirst($_POST[ort])));
$land=htmlspecialchars(stripslashes($_POST[land]));
$cont=htmlspecialchars(stripslashes($_POST[cont]));
$kosten=htmlspecialchars(stripslashes($_POST[kosten]));
$level=htmlspecialchars(stripslashes($_POST[level]));
$dauer=htmlspecialchars(stripslashes($_POST[dauer]));
$kurstag1_datum=htmlspecialchars(stripslashes($_POST[kurstag1_datum]));
$kurstag2_datum=htmlspecialchars(stripslashes($_POST[kurstag2_datum]));
$kurstag3_datum=htmlspecialchars(stripslashes($_POST[kurstag3_datum]));
$kurstag4_datum=htmlspecialchars(stripslashes($_POST[kurstag4_datum]));
$kurstag5_datum=htmlspecialchars(stripslashes($_POST[kurstag5_datum]));
$uhrzeit_von=htmlspecialchars(stripslashes($_POST[uhrzeit_von]));
$uhrzeit_bis=htmlspecialchars(stripslashes($_POST[uhrzeit_bis]));
$teilnehmer_ab=htmlspecialchars(stripslashes($_POST[teilnehmer_ab]));
$teilnehmer_bis=htmlspecialchars(stripslashes($_POST[teilnehmer_bis]));

if($_POST[o]=="k") {

if($standort=="vorort") {

$uhrmacher_von = explode("-",$uhrzeit_von);
$uhrmacher_bis = explode("-",$uhrzeit_bis);

$kurstag1_array = explode(".",$kurstag1_datum);
$kurstag2_array = explode(".",$kurstag2_datum);
$kurstag3_array = explode(".",$kurstag3_datum);
$kurstag4_array = explode(".",$kurstag4_datum);
$kurstag5_array = explode(".",$kurstag5_datum);
$kurstag1_von = @mktime($uhrmacher_von[0], $uhrmacher_von[1], 0, $kurstag1_array[1], $kurstag1_array[0], $kurstag1_array[2]);
$kurstag1_bis = @mktime($uhrmacher_bis[0], $uhrmacher_bis[1], 0, $kurstag1_array[1], $kurstag1_array[0], $kurstag1_array[2]);
if($kurstag2_datum!="") $kurstag2_von = @mktime($uhrmacher_von[0], $uhrmacher_von[1], 0, $kurstag2_array[1], $kurstag2_array[0], $kurstag2_array[2]);
if($kurstag2_datum!="") $kurstag2_bis = @mktime($uhrmacher_bis[0], $uhrmacher_bis[1], 0, $kurstag2_array[1], $kurstag2_array[0], $kurstag2_array[2]);
if($kurstag3_datum!="") $kurstag3_von = @mktime($uhrmacher_von[0], $uhrmacher_von[1], 0, $kurstag3_array[1], $kurstag3_array[0], $kurstag3_array[2]);
if($kurstag3_datum!="") $kurstag3_bis = @mktime($uhrmacher_bis[0], $uhrmacher_bis[1], 0, $kurstag3_array[1], $kurstag3_array[0], $kurstag3_array[2]);
if($kurstag4_datum!="") $kurstag4_von = @mktime($uhrmacher_von[0], $uhrmacher_von[1], 0, $kurstag4_array[1], $kurstag4_array[0], $kurstag4_array[2]);
if($kurstag4_datum!="") $kurstag4_bis = @mktime($uhrmacher_bis[0], $uhrmacher_bis[1], 0, $kurstag4_array[1], $kurstag4_array[0], $kurstag4_array[2]);
if($kurstag5_datum!="") $kurstag5_von = @mktime($uhrmacher_von[0], $uhrmacher_von[1], 0, $kurstag5_array[1], $kurstag5_array[0], $kurstag5_array[2]);
if($kurstag5_datum!="") $kurstag5_bis = @mktime($uhrmacher_bis[0], $uhrmacher_bis[1], 0, $kurstag5_array[1], $kurstag5_array[0], $kurstag5_array[2]);

$kursdauer = ($kurstag1_bis-$kurstag1_von) / 3600;

}
else {

}

if($titel=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Titel" ausfüllen.</div>';
elseif($standort=="vorort" && ($kurstag1_datum=="" || $kurstag1_von<time())) echo '<div class="alert alert-danger"><b>Ups!</b> Das angegebene Kursdatum ist ungültig.</div>';
elseif($standort=="vorort" && ($kurstag1_von>$kurstag1_bis)) echo '<div class="alert alert-danger"><b>Ups!</b> Bitte Datum und Uhrzeit überprüfen, der Kurs kann nicht nach Ende beginnen.</div>';
elseif($standort=="vorort" && ($kursdauer<1)) echo '<div class="alert alert-danger"><b>Ups!</b> Der Kurs muss mindestens eine Stunde dauern.</div>';
elseif(strlen($titel)>50) echo '<div class="alert alert-danger"><b>Ups!</b> Der Titel ist zu lang. Bitte maximal 50 Zeichen.</div>';
elseif($_FILES['foto1']['name']=="" && $_FILES['foto2']['name']=="" && $_FILES['foto3']['name']=="") echo '<div class="alert alert-danger"><b>Ups!</b> Fügen Sie bitte mindestens 1 Foto hinzu.</div>';
elseif($standort=="vorort" && ($ort=="")) echo '<div class="alert alert-danger"><b>Ups!</b> Bitte den Ort angeben.</div>';
elseif($standort=="vorort" && (!is_numeric($plz) || strlen($plz)>5 || $plz=="")) echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine gültige Postleitzahl angeben.</div>';
elseif($standort=="vorort" && ($teilnehmer_ab>$teilnehmer_bis)) echo '<div class="alert alert-danger"><b>Ups!</b> Da stimmt was mit der Teilnehmeranzahl nicht.</div>';
elseif(!is_numeric($kosten) || $kosten<1 || $kosten>9999 || $plz=="") echo '<div class="alert alert-danger"><b>Ups!</b> Die angegebenen Kurskosten sind ungültig.</div>';
elseif($standort!="vorort" && $dauer=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte die Dauer des Kurses angeben.</div>';
elseif($cont=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte das Feld "Beschreibung" ausfüllen.</div>';
else { $noform="ok";



mysqli_query($db,"INSERT INTO ".$dbx."_kurse (user,titel,kat,plz,ort,land,standort,cont,kosten,dauer,kurstag1_von,kurstag1_bis,kurstag2_von,kurstag2_bis,kurstag3_von,kurstag3_bis,kurstag4_von,kurstag4_bis,kurstag5_von,kurstag5_bis,level,teilnehmer_ab,teilnehmer_bis,datum) VALUES ('".$usrd[id]."','".addslashes($titel)."','".$kat."','".addslashes($plz)."','".addslashes($ort)."','".$land."','".addslashes($standort)."','".addslashes($cont)."','".addslashes($kosten)."','".addslashes($dauer)."','".$kurstag1_von."','".$kurstag1_bis."','".$kurstag2_von."','".$kurstag2_bis."','".$kurstag3_von."','".$kurstag3_bis."','".$kurstag4_von."','".$kurstag4_bis."','".$kurstag5_von."','".$kurstag5_bis."','".addslashes($level)."','".addslashes($teilnehmer_ab)."','".addslashes($teilnehmer_bis)."','".time()."')");
$uid=mysqli_insert_id($db);



$ph1=array('%vorname%','%nachname%','%kurstitel%','%kursurl%','%email%','%titel%','%url%');
$ph2=array($usrd[vorname],$usrd[nachname],$titel,genURL('kurs',$uid,urlseotext($titel)),$coredata[email],$coredata[titel],"http://".$coredata[url]);
$mailtext = file_get_contents('template/texte/kursinseriert.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($usrd[email],"Ihr Kursangebot bei ".$coredata[titel],$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");


if($_FILES['foto1']['name']!="") {
  uploadImage('foto1','fotos/'.$uid.'_1','615','240');
}
if($_FILES['foto2']['name']!="") {
  uploadImage('foto2','fotos/'.$uid.'_2','615','240');
}
if($_FILES['foto3']['name']!="") {
  uploadImage('foto3','fotos/'.$uid.'_3','615','240');
}


echo '<div class="alert alert-success"><b>Super!</b> Ihr Kursangebot wurde erfolgreich eingetragen.</div>';

echo '<div style="margin-left:15px;padding:20px;"><table border=0 cellspacing=0 cellpadding=3><tr><td valign=top><div style="overflow:hidden;height:100px;width:100px;border:1px solid #ccc;box-shadow: 2px 2px 2px #ddd;" class=bigroundcorners><div style="overflow:hidden;height:100px;width:100px;" class=bigroundcorners><a href="'.genURL('kurs',$uid,urlseotext($titel)).'">';
if(file_exists("fotos/".$uid."_1_t.jpg")==1) echo '<img src="fotos/'.$uid.'_1_t.jpg" width=100 height=100 border=0 class=bigroundcorners>';
elseif(file_exists("fotos/".$uid."_1_t.png")==1) echo '<img src="fotos/'.$uid.'_1_t.png" width=100 height=100 border=0 class=bigroundcorners>';
else echo '<img src="fotos/leer.gif" width=100 height=100 border=0 class=bigroundcorners>';
echo '</a>';

echo '</div></div></td><td>

<div style="padding:5px;"><a href="'.genURL('kurs',$uid,urlseotext($titel)).'"><b>'.$titel.'</a></b></div>
<div style="padding:5px;padding-bottom:1px;">'.$plz.' '.$ort.'</div></div>

</div>';

echo '</td></tr></table></div>';






}
}

if($noform!="ok") {



echo '<form action=index.php method=post enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"><input type=hidden name=d value=anbieten><input type=hidden name=o value=k>

<div class=form-group>
<label for=titel class="col-lg-4 col-sm-3 control-label">Titel des Kurses</label><div class="col-lg-8 col-sm-9">
<input type=text id=titel name=titel style="width:100%;max-width:450px;" value="'.$titel.'" class=form-control placeholder="z.B. Anfängerkurs Billard, Tango-Tanzkurs usw.">
</div></div>

<div class=form-group>
<label for=kat class="col-lg-4 col-sm-3 control-label">Kategorie</label><div class="col-lg-8 col-sm-9">
<select id="kat" name=kat class=form-control style="width:100%;max-width:350px;">';

$getArten = mysqli_query($db,"SELECT * FROM ".$dbx."_kats ORDER BY id");
while($fetchArt = mysqli_fetch_array($getArten)) {
echo '<option value="'.$fetchArt[id].'"'; if($kat==$fetchArt[id]) echo ' selected'; echo '>'.$fetchArt[kat].'</option>';
}

if($strasse!="") $ff_strasse=$strasse; else $ff_strasse=$usrd[strasse];
if($plz!="") $ff_plz=$plz; else $ff_plz=$usrd[plz];
if($ort!="") $ff_ort=$ort; else $ff_ort=$usrd[ort];

echo '</select>
</div></div>

<br>


<div class=form-group>
<label for=standort class="col-lg-4 col-sm-3 control-label">&nbsp;</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wo findet der Kurs statt?</span>
<div class=input-group><span class=input-group-addon><img src=images/ico_vorort.png width=16 height=16 align=absmiddle name=standorticon></span><select style="width:100%;max-width:200px;" onchange="document.images[\'standorticon\'].src = \'images/ico_\'+document.getElementById(\'standort\').value+\'.png\';" id=standort name=standort class="form-control">
<option value=vorort>Vor Ort
<option value=skype>Skype
<option value=hangouts>Google Hangouts
<option value=telefon>Telefon

</select></div>
</div></div>
<script>
$(\'select#standort\').change(function(){
if($(this).val() == \'vorort\'){
    $(\'div#ortangaben\').show();
    $(\'div#datumangaben\').show();
    $(\'div#dauerangaben\').hide();
} else {
    $(\'div#ortangaben\').hide();
    $(\'div#datumangaben\').hide();
    $(\'div#dauerangaben\').show();
}
});

</script>
<div id=ortangaben'; if($standort!='' && $standort!='vorort') echo ' style="display:none"'; echo '>

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

</div>


<div class=form-group>
<label for=tage_ende class="col-lg-4 col-sm-3 control-label">Kosten</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Gesamtkosten für die Kursteilnahme inkl. Lern- und sonstigem Material.<br>(Vom Betrag werden vor der Auszahlung <b>'.$coredata['gebuehr'].'% Gebühr</b> abgezogen).</span>
<div class=input-group style=width:130px;>
<input type=text id=kosten name=kosten value="'.$kosten.'" class=form-control>
<span class="input-group-addon">,00 '; if($coredata['waehrung']=="EUR") echo '&euro;'; else echo $coredata['waehrung']; echo '</span>
</div>
</div></div>

<br>

<div class=form-group>
<label for=cont class="col-lg-4 col-sm-3 control-label">Beschreibung</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Beschreiben Sie Inhalt, Durchführung und Ziel des Kurses möglichst genau:</span>
<textarea name=cont class=form-control style="width:100%;height:150px;">'.$cont.'</textarea>
</div></div>

<br>

<div class=form-group>
<label for=art class="col-lg-4 col-sm-3 control-label">Level</label><div class="col-lg-8 col-sm-9">
<span class="help-block">An welche Zielgruppe richtet sich der Kurs?</span>
<select id="level" name=level class=form-control style="width:100%;max-width:250px;">
<option value="anf">Anfänger</option>
<option value="ftg"'; if($level=="ftg") echo ' selected'; echo '>Fortgeschritten</option>
<option value="prf"'; if($level=="prf") echo ' selected'; echo '>Profi</option>
</select>
</div></div>


<br>';


echo '<div id=datumangaben'; if($standort!='' && $standort!='vorort') echo ' style="display:none"'; echo '>

<div class=form-group>
<label for=datum class="col-lg-4 col-sm-3 control-label">Datum</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wann findet der Kurs statt?<br>Der Kurs kann auch über mehrere Tage verteilt werden (max. 5).</span>

<div><div class="input-group date" id="kurstag1_datum" data-date-format="dd.mm.yyyy" style="width:100%;max-width:150px;"> <input class="form-control" type="text" name="kurstag1_datum" value="'.$kurstag1_datum.'"> <span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></i></span></div></div>
<div id=wenigerdaten><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerdaten\');$.toggle(\'#mehrdaten\');">Weiterer Kurstag</a></div>

<div id=mehrdaten style=display:none>
<div><div class="input-group date" id="kurstag2_datum" data-date-format="dd.mm.yyyy" style="width:100%;max-width:150px;"> <input class="form-control" type="text" name="kurstag2_datum" value="'.$kurstag2_datum.'"> <span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></i></span></div></div>
<div id=wenigerdaten2><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerdaten2\');$.toggle(\'#mehrdaten2\');">Weiterer Kurstag</a></div>

<div id=mehrdaten2 style=display:none>
<div><div class="input-group date" id="kurstag3_datum" data-date-format="dd.mm.yyyy" style="width:100%;max-width:150px;"> <input class="form-control" type="text" name="kurstag3_datum" value="'.$kurstag3_datum.'"> <span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></i></span></div></div>
<div id=wenigerdaten3><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerdaten3\');$.toggle(\'#mehrdaten3\');">Weiterer Kurstag</a></div>

<div id=mehrdaten3 style=display:none>
<div><div class="input-group date" id="kurstag4_datum" data-date-format="dd.mm.yyyy" style="width:100%;max-width:150px;"> <input class="form-control" type="text" name="kurstag4_datum" value="'.$kurstag4_datum.'"> <span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></i></span></div></div>
<div id=wenigerdaten4><img src=images/ico_add.png width=16 height=16 align=absmiddle> <a href=javascript:void(0); onclick="$.toggle(\'#wenigerdaten4\');$.toggle(\'#mehrdaten4\');">Weiterer Kurstag</a></div>

<div id=mehrdaten4 style=display:none>
<div><div class="input-group date" id="kurstag5_datum" data-date-format="dd.mm.yyyy" style="width:100%;max-width:150px;"> <input class="form-control" type="text" name="kurstag5_datum" value="'.$kurstag5_datum.'"> <span class="input-group-addon"><img src=images/ico_datum.png width=16 height=16></i></span></div></div>

</div>

</div>

</div>

</div>

<script type=text/javascript>
$(".input-group.date").datepicker({ autoclose: true, todayHighlight: true });
$.toggle = function(query) { $(query).toggle("slow"); }
</script>

</div></div>

<div class=form-group>
<label for=uhrzeit_von class="col-lg-4 col-sm-3 control-label">Zeit</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Um welche Uhrzeit beginnt der Kurs?</span>
<div class=input-group style=width:150px;>
<select id="uhrzeit_von" name="uhrzeit_von" class=form-control>';

for ($uhrmacher=6; $uhrmacher<=23; $uhrmacher++) {
  echo '<option value="'.$uhrmacher.'-00"'; if($uhrzeit_von==$uhrmacher."-00") echo ' selected'; echo '>'.$uhrmacher.':00</option>';
  echo '<option value="'.$uhrmacher.'-15"'; if($uhrzeit_von==$uhrmacher."-15") echo ' selected'; echo '>'.$uhrmacher.':15</option>';
  echo '<option value="'.$uhrmacher.'-30"'; if($uhrzeit_von==$uhrmacher."-30" || ($uhrzeit_von=="" && $uhrmacher==17)) echo ' selected'; echo '>'.$uhrmacher.':30</option>';
  echo '<option value="'.$uhrmacher.'-45"'; if($uhrzeit_von==$uhrmacher."-45") echo ' selected'; echo '>'.$uhrmacher.':45</option>';
}

echo '<option value="24-00"'; if($uhrzeit_bis=="24-00") echo ' selected'; echo '>24:00</option></select>
<span class="input-group-addon">Uhr</span>
</div>
</div></div>

<div class=form-group>
<label for=uhrzeit_bis class="col-lg-4 col-sm-3 control-label">&nbsp;</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Um welche Uhrzeit endet der Kurs?</span>
<div class=input-group style=width:150px;>
<select id="uhrzeit_bis" name="uhrzeit_bis" class=form-control>';

for ($uhrmacher=6; $uhrmacher<=23; $uhrmacher++) {
  echo '<option value="'.$uhrmacher.'-00"'; if($uhrzeit_bis==$uhrmacher."-00") echo ' selected'; echo '>'.$uhrmacher.':00</option>';
  echo '<option value="'.$uhrmacher.'-15"'; if($uhrzeit_bis==$uhrmacher."-15") echo ' selected'; echo '>'.$uhrmacher.':15</option>';
  echo '<option value="'.$uhrmacher.'-30"'; if($uhrzeit_bis==$uhrmacher."-30" || ($uhrzeit_bis=="" && $uhrmacher==19)) echo ' selected'; echo '>'.$uhrmacher.':30</option>';
  echo '<option value="'.$uhrmacher.'-45"'; if($uhrzeit_bis==$uhrmacher."-45") echo ' selected'; echo '>'.$uhrmacher.':45</option>';
}

echo '<option value="24-00"'; if($uhrzeit_bis=="24-00") echo ' selected'; echo '>24:00</option></select>
<span class="input-group-addon">Uhr</span>
</div>
</div></div>

<br>

<div class=form-group>
<label for=teilnehmer_ab class="col-lg-4 col-sm-3 control-label">Anzahl Teilnehmer</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wieviele Teilnehmer sind mindestens erforderlich, damit der Kurs stattfindet?</span>
<select id="teilnehmer_ab" name=teilnehmer_ab class=form-control style="width:100%;max-width:100px;">
<option>1</option>
<option'; if($teilnehmer_ab=="2" || $teilnehmer_ab=="") echo ' selected'; echo '>2</option>
<option'; if($teilnehmer_ab=="3") echo ' selected'; echo '>3</option>
<option'; if($teilnehmer_ab=="4") echo ' selected'; echo '>4</option>
<option'; if($teilnehmer_ab=="5") echo ' selected'; echo '>5</option>
</select>
</div></div>

<div class=form-group>
<label for=teilnehmer_bis class="col-lg-4 col-sm-3 control-label">&nbsp;</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wieviele Teilnehmer können sich maximal anmelden?</span>
<select id="teilnehmer_bis" name=teilnehmer_bis class=form-control style="width:100%;max-width:100px;">
<option>1</option>
<option'; if($teilnehmer_bis=="2") echo ' selected'; echo '>2</option>
<option'; if($teilnehmer_bis=="3") echo ' selected'; echo '>3</option>
<option'; if($teilnehmer_bis=="4") echo ' selected'; echo '>4</option>
<option'; if($teilnehmer_bis=="5" || $teilnehmer_bis=="") echo ' selected'; echo '>5</option>
<option'; if($teilnehmer_bis=="6") echo ' selected'; echo '>6</option>
<option'; if($teilnehmer_bis=="7") echo ' selected'; echo '>7</option>
<option'; if($teilnehmer_bis=="8") echo ' selected'; echo '>8</option>
<option'; if($teilnehmer_bis=="9") echo ' selected'; echo '>9</option>
<option'; if($teilnehmer_bis=="10") echo ' selected'; echo '>10</option>
<option'; if($teilnehmer_bis=="11") echo ' selected'; echo '>11</option>
<option'; if($teilnehmer_bis=="12") echo ' selected'; echo '>12</option>
<option'; if($teilnehmer_bis=="13") echo ' selected'; echo '>13</option>
<option'; if($teilnehmer_bis=="14") echo ' selected'; echo '>14</option>
<option'; if($teilnehmer_bis=="15") echo ' selected'; echo '>15</option>
<option'; if($teilnehmer_bis=="16") echo ' selected'; echo '>16</option>
<option'; if($teilnehmer_bis=="17") echo ' selected'; echo '>17</option>
<option'; if($teilnehmer_bis=="18") echo ' selected'; echo '>18</option>
<option'; if($teilnehmer_bis=="19") echo ' selected'; echo '>19</option>
<option'; if($teilnehmer_bis=="20") echo ' selected'; echo '>20</option>
</select>
</div></div>

<br>

</div>


<div id=dauerangaben'; if($standort=='' || $standort=='vorort') echo ' style="display:none"'; echo '>

<div class=form-group>
<label for=dauer class="col-lg-4 col-sm-3 control-label">Dauer des Kurses</label><div class="col-lg-8 col-sm-9">
<span class="help-block">Wie lange dauert der Kurs?</span>
<select id="dauer" name=dauer class=form-control style="width:100%;max-width:200px;">
<option'; if($dauer=="0.5") echo ' selected'; echo ' value="0.5">30 Minuten</option>
<option'; if($dauer=="1" || $dauer=="") echo ' selected'; echo ' value="1">1 Stunde</option>
<option'; if($dauer=="1.5") echo ' selected'; echo ' value="1.5">1.5 Stunden</option>
<option'; if($dauer=="2") echo ' selected'; echo ' value="2">2 Stunden</option>
<option'; if($dauer=="2.5") echo ' selected'; echo ' value="2.5">2.5 Stunden</option>
<option'; if($dauer=="3") echo ' selected'; echo ' value="3">3 Stunden</option>
<option'; if($dauer=="3.5") echo ' selected'; echo ' value="3.5">3.5 Stunden</option>
<option'; if($dauer=="4") echo ' selected'; echo ' value="4">4 Stunden</option>
</select>
</div></div>

<br>

</div>

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