<?php
error_reporting(E_ALL ^ E_NOTICE);
if($_GET[ci]=="1") {
$tmp_dir_path= '../__TEMP__/';
$captcha_expires_after = 420;
header("Expires: Mon, 01 Jul 1990 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT"); 
header("Pragma: no-cache"); 
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
header("Content-Type: image/jpeg", true);
if (!empty( $_GET['img'] ) )
$img = $_GET['img'];
else {
echo 'Kein Bild übergeben via &img=...';
exit;
}
if (!$fh = fopen( $tmp_dir_path.'cap_'.$img.'.jpg', 'rb')) { echo 'Kann Bilddatei nicht öffnen.'; }
else { fpassthru( $fh ); fclose( $fh ); }
$tmp_dir = dir( $tmp_dir_path );
while( $entry = $tmp_dir->read()) {
if ( is_file( $tmp_dir_path . $entry ) ){
if ( mktime() - filemtime( $tmp_dir_path . $entry ) > $captcha_expires_after ) {
unlink( $tmp_dir_path . $entry );
}}}
}
else {
class captcha {
var $session_key = null;
var $temp_dir    = null;
var $width       = 160;
var $height      = 65;
var $jpg_quality = 80;
function captcha( $session_key, $temp_dir ){
$this->session_key = $session_key;
$this->temp_dir    = $temp_dir;
}
function _generate_image( $location, $char_seq ){
$num_chars = strlen($char_seq);
$img = imagecreatetruecolor( $this->width, $this->height );
imagealphablending($img, 1);
$weiss = ImageColorAllocate($img,255,255,255);
ImageFilledRectangle($img, 0,0, $this->width, $this->height, $weiss);
$start_x = round($this->width / $num_chars);
$max_font_size = $start_x-5;
$start_x = round(0.5*$start_x);
$max_x_ofs = round($max_font_size*0.9);
for ($i=0;$i<=$num_chars;$i++){
$r = round( rand( 10, 127 ) );
$g = round( rand( 10, 127 ) );
$b = round( rand( 10, 127 ) );
$y_pos = ($this->height/2)+round( rand( 5, 20 ) );
$fontsize = round( rand( 18, $max_font_size) );
$color = imagecolorallocate( $img, $r, $g, $b);
$presign = 0;
$angle = rand( 2, 20 );
if ($presign==true) $angle = -1*$angle;
ImageTTFText( $img, $fontsize, $angle, $start_x+$i*$max_x_ofs, $y_pos, $color, dirname(__file__).'/../ttf/AYearWithoutRain.ttf', substr($char_seq,$i,1) );
}
imagejpeg( $img, $location, $this->jpg_quality );
flush();
imagedestroy( $img );
return true;
}
function get_pic( $num_chars=8 ){
$alphabet = array(
'A','B','C','D','E','F','G','H','I','J','K','L','M',
'N','O','P','Q','R','S','T','U','W','X','Y','Z');
$max = sizeof( $alphabet );
$captcha_str = '';
for ($i=1;$i<=$num_chars;$i++) // from 1..$num_chars
{
$chosen = rand( 1, $max );
$captcha_str .= $alphabet[$chosen-1];
}
if ( $this->_generate_image( $this->temp_dir.'/'.'cap_'.md5( strtolower( $captcha_str )).'.jpg' , $captcha_str ) )
{
$fh = fopen( $this->temp_dir.'/'.'cap_'.$this->session_key.'.txt', "w" );
fputs( $fh, md5( strtolower( $captcha_str ) ) );
return( md5( strtolower( $captcha_str ) ) );
}
else
{
return false;
}}
function verify( $char_seq ){
$fh = fopen( $this->temp_dir.'/'.'cap_'.$this->session_key.'.txt', "r" );
$hash = fgets( $fh );
if (md5(strtolower($char_seq)) == $hash)
return true;
else
return false;
}}
}
?>