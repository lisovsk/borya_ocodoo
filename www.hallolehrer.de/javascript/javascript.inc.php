
<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery.ui.js" type="text/javascript"></script>
<script src="javascript/jquery.raty.min.js" type="text/javascript"></script>
<script src="javascript/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="javascript/jquery.bxSlider.min.js" type="text/javascript"></script>
<script src="javascript/galleria-1.2.9.min.js" type="text/javascript"></script>
<script src="javascript/jquery.flexisel.js" type="text/javascript"></script>
<script src="javascript/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$(window).load( function() {
document.getElementById('wloader').style.display='none';
document.getElementById('main').style.visibility='visible';
});
});
</script>
<script type="text/javascript">
jQuery.cookie = function (key, value, options) {
if (arguments.length > 1 && (value === null || typeof value !== "object")) {
options = jQuery.extend({}, options);
if (value === null) {
options.expires = -1;
}
if (typeof options.expires === 'number') {
var days = options.expires, t = options.expires = new Date();
t.setDate(t.getDate() + days);
}
return (document.cookie = [
encodeURIComponent(key), '=',
options.raw ? String(value) : encodeURIComponent(String(value)),
options.expires ? '; expires=' + options.expires.toUTCString() : '',
options.path ? '; path=' + options.path : '',
options.domain ? '; domain=' + options.domain : '',
options.secure ? '; secure' : ''
].join(''));
}
options = value || {};
var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
</script>
