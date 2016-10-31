

<?php

echo '<div class="row" id="header">

<style>
#hdlogo{text-align:left;}
@media all and (max-width: 480px) {
#hdlogo{text-align:center;margin-bottom:10px;}
}
</style>

<div class="col-lg-8 col-sm-6" id="hdlogo">
<a href="'.genURL('').'"><img src="images/logo.png" border=0 alt="%%TITEL%%" class="img-responsive"></a>
</div>

<style>
#hdnav{text-align:right;margin-top:15px;}
@media all and (max-width: 480px) {
#hdnav{text-align:center;margin-bottom:10px;}
}
</style>

<div class="col-lg-4 col-sm-6" id="hdnav">';

if($lg=="ok") {
if($coredata['user']=="user") $urlUsername=$usrd[user]; else $urlUsername=$usrd[id];
echo '<img src="images/ico_user_'.$usrd[geschlecht].'.png" width=16 height=16 align=absmiddle> <a href="'.genURL('user',$urlUsername).'">'; if($coredata['user']=="user") echo ucfirst($usrd[user]); else echo $usrd[vorname].' '.$usrd[nachname]; echo '</a> &nbsp; <img src=images/ico_logout.png width=16 height=16 align=absmiddle> <a href="'.genURL('logout').'">Ausloggen</a>';
}

else echo '<img src=images/ico_anmelden.png width=16 height=16 align=absmiddle> <a href="'.genURL('anmelden').'">Anmelden</a> &nbsp; <img src=images/ico_login.png width=16 height=16 align=absmiddle> <a href="'.genURL('login').'">Login</a>';

echo '</div>

</div>';

?>