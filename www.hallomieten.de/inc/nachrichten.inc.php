<?php

$DO_TITEL="Postfach";

if($lg=="ok") {
echo '<legend>Postfach</legend>';

$send=htmlspecialchars(stripslashes(strtolower($_GET[send])));
if($send=="") if(!$s) $s="posteingang";
if($s=="senden" && $u!="") $send=$u;



echo '<ul class="nav nav-tabs">
  <li'; if($s=="posteingang") echo ' class=active'; echo '><a  href="'.genURL('nachrichten','posteingang').'"><img src="images/ico_posteingang.png" width=16 height=16 align=absmiddle border=0> Posteingang</a></li>
  <li'; if($s=="postausgang") echo ' class=active'; echo '><a href="'.genURL('nachrichten','postausgang').'"><img src="images/ico_postausgang.png" width=16 height=16 align=absmiddle border=0> Postausgang</a></li>
</ul>';




if($s=="posteingang" || $s=="postausgang") {


if($s=="posteingang") $getmsgs = mysql_query("SELECT * FROM ".$dbx."_nachrichten WHERE empf='".$usrd[id]."' AND delempf NOT LIKE 'ok' ORDER BY datum DESC");
elseif($s=="postausgang") $getmsgs = mysql_query("SELECT * FROM ".$dbx."_nachrichten WHERE abs='".$usrd[id]."' AND delabs NOT LIKE 'ok'ORDER BY datum DESC");


if(mysql_num_rows($getmsgs)==0) echo '<br><div class="alert alert-danger"><b>Ups!</b> Keine Nachrichten gefunden.</div>';
else { echo '<table class="table table-hover"><thead><tr><td><div class="visible-sm">Nachrichten:</div><div class="row hidden-sm"><div class="col-lg-3 col-sm-3">'; if($s=="posteingang") echo "Absender"; else echo "Empfänger"; echo '</div><div class="col-lg-5 col-sm-5">Nachricht</div><div class="col-lg-3 col-sm-3">Datum</div></div></td></tr></thead><tbody>'; $endtable='</tbody></table>'; }

while($msgs=mysql_fetch_array($getmsgs)) {

if($s=="posteingang") $getabsuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$msgs[abs]."'");
elseif($s=="postausgang") $getabsuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$msgs[empf]."'");
$absuser = mysql_fetch_array($getabsuser);

echo '<tr><td><div class=row><div class="col-lg-3 col-sm-3"><img src="images/ico_user_'.$absuser[geschlecht].'.png" width=16 height=16 align=absmiddle> <b>'; if($coredata[user]=="user") echo ucfirst($absuser[user]); else echo ucfirst($absuser[vorname]).' '.ucfirst($absuser[nachname]); echo '</b></div><div class="col-lg-5 col-sm-5">';

if($msgs[status]!="ok") echo '<img src=images/ico_nachricht_unread.png width=16 height=16 align=absmiddle><b>';
else echo '<img src=images/ico_nachricht_read.png width=16 height=16 align=absmiddle>';

echo ' <a href="index.php?d=nachrichten&s=lesen&u='.$msgs[id].'">'.$msgs[betr];

echo '</a></b></div><div class="col-lg-3 col-sm-3">'.date("d.n.Y, H:i",$msgs[datum]).'</div>';

echo '<div class="col-lg-1 col-sm-1"><a href=index.php?d=nachrichten&s=del&u='.$msgs[id].'><img src=images/ico_delete.png width=16 height=16 border=0></a></div></td>';

echo '</tr>';

}

echo $endtable;

}






elseif($s=="del" && $u!="") {

echo '<br>';

if($o=="k") {

mysql_query("UPDATE ".$dbx."_nachrichten SET delempf='ok' WHERE id='".$u."' AND empf='".$usrd[id]."'");
mysql_query("UPDATE ".$dbx."_nachrichten SET delabs='ok' WHERE id='".$u."' AND abs='".$usrd[id]."'");
echo '<div class="alert alert-success"><b>Erledigt!</b> Nachricht erfolgreich gelöscht.</div>';

}

else echo 'Die Nachricht wirklich löschen?<br><br><form action=index.php method=get><input type=hidden name=d value=nachrichten><input type=hidden name=s value=del><input type=hidden name=u value='.$u.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';

}









elseif($s=="lesen" && $u!="") {

$getmsg = mysql_query("SELECT * FROM ".$dbx."_nachrichten WHERE id='".$u."' AND (empf='".$usrd[id]."' OR abs='".$usrd[id]."')");
$msg=mysql_fetch_array($getmsg);

if($msg[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Unbekannter Fehler.</div>';
else {

$getabsuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$msg[abs]."'");
$absuser = mysql_fetch_array($getabsuser);

mysql_query("UPDATE ".$dbx."_nachrichten SET status='ok' WHERE id='".$msg[id]."'");

echo '<div style="border:1px solid #ddd;padding:5px;border-top:0;">';

echo '<img src=images/ico_write.png width=16 height=16 border=0 align=absmiddle> <a href=index.php?d=nachrichten&send='.$absuser[id].'>Antworten</a> &nbsp;&nbsp;&nbsp;&nbsp; <img src=images/ico_delete.png width=16 height=16 border=0 align=absmiddle> <a href=index.php?d=nachrichten&s=del&u='.$msg[id].'>Löschen</a><br><br>';

echo '<img src=images/ico_nachricht_read.png width=16 height=16 align=absmiddle> <b>'.$msg[betr].'</b><br><br>'.$msg[cont];

echo '</div>';





}
}




elseif($send!="") {

echo '<br>';

$getempfuser = mysql_query("SELECT * FROM ".$dbx."_user WHERE id='".$send."'");
$empfuser = mysql_fetch_array($getempfuser);

if($_POST[o]=="k") {


$a_betreff=htmlspecialchars(stripslashes($_POST[a_betreff]));
$a_nachricht=htmlspecialchars(stripslashes($_POST[a_nachricht]));


if($empfuser[id]=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte einen Empfänger wählen.</div>';
elseif($a_betreff=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte einen Betreff wählen.</div>';
elseif($a_nachricht=="") echo '<div class="alert alert-danger"><b>Ups!</b> Bitte eine Nachricht schreiben.</div>';
else { $noform="ok";

mysql_query("INSERT INTO ".$dbx."_nachrichten (empf,abs,betr,cont,datum) VALUES ('".$empfuser[id]."','".$usrd[id]."','".$a_betreff."','".$a_nachricht."','".time()."')");

$ph1=array('%vorname%','%nachname%','%readlink%','%titel%','%weburl%');
$ph2=array($empfuser[vorname],$empfuser[nachname],'http://'.$coredata[url].'?d=nachrichten&s=lesen&u='.mysql_insert_id(),$coredata[titel],$coredata[url]);
$mailtext = file_get_contents('template/texte/neuenachricht.txt', true);
$mailtext  = str_replace($ph1,$ph2,$mailtext);
mail($empfuser[email],"Neue Nachricht",$mailtext,"From: ".$coredata[titel]." <".$coredata[email].">");

echo '<div class="alert alert-success"><b>Erfolgreich gesendet!</b> Die Nachricht ist unterwegs.</div>';

}}

if($noform!="ok") {

echo '<form action=index.php method=post class=form-horizontal><input type=hidden name=d value=nachrichten><input type=hidden name=s value=senden><input type=hidden name=u value="'.$empfuser[id].'"><input type=hidden name=o value=k>

<div class=form-group>
<label class="col-lg-5 col-sm-4 control-label">Empfänger</label>
<label class="col-lg-7 col-sm-8 control-label" style="text-align:left;"><img src="images/ico_user_'.$empfuser[geschlecht].'.png" width=16 height=16 align=absmiddle> '.ucfirst($empfuser[vorname]).' '.ucfirst($empfuser[nachname]).'</label>
</div>

<div class=form-group>
<label for=a_betreff class="col-lg-5 col-sm-4 control-label">Betreff</label><div class="col-lg-7 col-sm-8">
<input type=text id=a_betreff name=a_betreff style=width:280px value="'.$a_betreff.'" class=form-control>
</div></div>

<div class=form-group>
<label for=a_nachricht class="col-lg-5 col-sm-4 control-label">Nachricht</label><div class="col-lg-7 col-sm-8">
<textarea name=a_nachricht style=width:280px;height:150px class=form-control>'.$a_nachricht.'</textarea>
</div></div>

<div class=form-group>
<label class="col-lg-5 col-sm-4 control-label"></label><div class="col-lg-7 col-sm-8">
<input type=submit value="Nachricht senden" class="btn btn-default">
</div></div>

</form>';

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