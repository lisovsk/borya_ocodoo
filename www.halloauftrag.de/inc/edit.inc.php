<legend>Auftrag bearbeiten</legend><?php

$DO_TITEL="Auftrag bearbeiten";

$edit=htmlspecialchars(stripslashes($_GET[edit]));
if(!$edit) $edit=htmlspecialchars(stripslashes($_POST[edit]));
$del=htmlspecialchars(stripslashes($_GET[del]));
if(!$del) $del=htmlspecialchars(stripslashes($_POST[del]));

$getauftrag = mysqli_query($db,"SELECT * FROM ".$dbx."_auftraege WHERE id='".$edit."' OR id='".$del."' OR id='".$nvfb."'");
$auftrag = mysqli_fetch_array($getauftrag);

if($usrd[id]==$auftrag[user] || $usrd[rechte]=="adm" || $usrd[rechte]=="mod") {


























if($del!="" && $o=="k") {
mysqli_query($db,"DELETE FROM ".$dbx."_auftraege WHERE id='".$del."'");
echo '<div class="alert alert-success"><b>Okay!</b> Auftrag wurde erfolgreich gel�scht.</div>';
}
elseif($del!="") echo 'M�chten Sie den Auftrag wirklich l�schen?<br><br><form action=index.php method=get><input type=hidden name=d value=edit><input type=hidden name=del value='.$del.'><input type=hidden name=o value=k><input type=submit value="Ja" class="btn btn-default"></form>';




}
else echo '<div class="alert alert-danger"><b>Ups!</b> Sie haben keine Berechtigung f�r diese Aktion.</div>';

?>