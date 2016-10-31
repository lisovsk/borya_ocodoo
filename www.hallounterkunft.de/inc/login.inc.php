<?php

$DO_TITEL="Login";

echo '<legend>Login</legend>';

if($lg!="ok") {
?>
<form action="index.php" method="post" class="form-inline"><input type=hidden name=d value="<?php echo $d; ?>"><input type=hidden name=u value="<?php echo $u; ?>"><input type=hidden name=s value="<?php echo $s; ?>"><input type=hidden name=projekt value="<?php echo $projekt; ?>"><input type=hidden name=betrag value="<?php echo $betrag; ?>">
<input type=text name=usermail class="form-control" placeholder="E-Mail" style=width:160px>
<input type=password name=pass class="form-control" placeholder="Passwort" style=width:160px>

<input type=submit value="Login" class="btn btn-default">
<label>&nbsp; <input type=checkbox name=ck value=ok checked> Eingeloggt bleiben</label>
</form><br><br>

<img src="images/ico_anmelden.png" width=16 height=16 align=absmiddle> <a href="index.php?d=anmelden">Anmelden</a> &nbsp; <img src=images/ico_hilfe.png width=16 height=16 align=absmiddle> <a href=index.php?d=passwort>Passwort vergessen?</a><br><br><br>

<legend>Login mit Facebook</legend>
<div class=row><div class="col-lg-12 col-sm-12"><iframe src=inc/facebook.inc.php frameborder=0 width=100% height=130 marginwidth=0 marginheight=0 scrolling=no></iframe></div></div>

<?php
}
elseif($d=="login") echo '<script type="text/javascript"><!--
setTimeout("self.location.href=\'index.php\'",1000);
//--></script><br><div class="alert alert-success"><b>Erfolgreich eingeloggt!</b> Sie werden auf die Startseite weitergeleitet.</div>';

?>