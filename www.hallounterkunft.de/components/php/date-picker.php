<?
echo '<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />';


$dateMorgen = date("d.m.Y",time()+86400);
$dateDreiTage = date("d.m.Y",time()+345600);
echo '
<script>
	$(function() {
	    var today = moment(); 
	    $(\'input[name="daterange"]\').daterangepicker({
		    "startDate": "'.$dateMorgen.'",
		    "endDate": "'.$dateDreiTage.'",
		    "minDate": "'.$dateMorgen.'",
		    "maxDate": moment(today).add(1, "year"),
		    "locale": {
		      format: "DD.MM.YYYY"
		    }
		});
	});
</script>
';

echo'<div style="margin-bottom:10px;">
<div class=input-group><span class=input-group-addon><img src=images/ico_datum.png width=16 height=16 align=absmiddle></span>
<input style="font-weight: bold;" type="text" name="daterange" value="'.$dateMorgen. ' - ' .$dateDreiTage.'" class="form-control js-daterange" />
</div>
</div>';

echo '<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>';