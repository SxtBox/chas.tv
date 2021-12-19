<?php
/*
Player Generated From https://demo.kodi.al/My_Tools/Players_Tools/Player_Builder/Clappr_Player/
Channels https://chas.tv/
USE ?url=TV NAME
EXAMPLE ?url=kultura-online - ?url=tnt-online ETC....
user_agent Duhet iPhone
*/

$get_url = isset($_GET["url"]) && !empty($_GET["url"]) ? $_GET["url"] : "zvezda-online";

function get_data($url) {
    $ch = curl_init();
    $timeout = 2;
    $referenca = ($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "iPhone");
    curl_setopt($ch, CURLOPT_REFERER, $referenca);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$link = get_data("https://chas.tv/channel/" . $get_url);
/*
STREAM URL
https://s20585.chas.tv:8082/chas/rossiyak.stream/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTIvMTkvMjAyMSA2OjAyOjQ1IFBNJmhhc2hfdmFsdWU9WE5qdFgyOGloVTJSbm9ERC9tYWV2Zz09JnZhbGlkbWludXRlcz0yMDA=
*/

// HD STREAMS
preg_match_all('/streamSource = "(.*?\S)"/',$link,$matches, PREG_PATTERN_ORDER);

// SD STREAMS
//preg_match_all('/streamSourceHQ = "(.*?\S)"/',$link,$matches, PREG_PATTERN_ORDER);
$stream_m3u = $matches[1][0];

preg_match_all('/var signature = "(.*?.*?.*)"/',$link,$signature_matches, PREG_PATTERN_ORDER);
$signature = $signature_matches[1][0];
$stream = $stream_m3u.$signature;
//echo $stream;

// GET TITLES
preg_match_all('/alt.*\n.*title="(.*?.*?.*)"/',$link,$title_matches, PREG_PATTERN_ORDER);
$title = $title_matches[1][0];
//echo $title;
//echo $stream;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $title ?></title>
<link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
<link rel="icon" href="https://kodi.al/panel.ico"/>
<style type="text/css">
body,td,th {
	color: #0F0;
}
body {
	background-color: #000;
}
a:link {
	color: #0FC;
}
a:visited {
	color: #3F6;
}
a:hover {
	color: #09F;
}
a:active {
	color: #009;
}
</style>
<!-- Include CDN Player -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@clappr/player@latest/dist/clappr.min.js"></script>
</head>
<body>
<?php
// AUTOMATIC PLAYER SWITCHING FOR ANDROID DEVICES
$ipod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iphone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = stripos(strtolower($_SERVER['HTTP_USER_AGENT']),"android");
if(($ipod != true) &&( $iphone != true)&&( $ipad != true)&&( $android != true)){
?>
<!-- DESKTOP PLAYER -->
<div id="player"></div>
<script>
var player = new Clappr.Player({
source: "<?php echo $stream ?>",
poster: "https://png.kodi.al/tv/albdroid/logo_bar.png",
watermark: "https://png.kodi.al/tv/albdroid/logo_bar.png",
position: "top-right",
watermarkLink: "http://albdroid.al",
scale: "exactfit",
<!-- Include Player parentId [Default player] -->
parentId: "#player",
playInline: true,
autoPlay: false,
// autoPlay: true,
// mimeType: 'audio/mpeg',
mediacontrol: {seekbar: "#0F0", buttons: "#0F0"},
width: '100%',
height: '100%'
});
</script>
<?php }else{ ?>
<!-- ANDROID PLAYER -->
<div id="player"></div>
<script>
var player = new Clappr.Player({
<!--  YOU CAN SET DIFFERENT SOURCE FOR ANDROID DEVICES HERE  -->
source: "<?php echo $stream ?>",
poster: "https://png.kodi.al/tv/albdroid/black.png",
watermark: "https://png.kodi.al/tv/albdroid/smart_x254.png",
position: "top-right",
watermarkLink: "http://albdroid.al",
scale: "exactfit",
<!-- Include Player parentId [Default player] -->
parentId: "#player",
playInline: true,
autoPlay: false,
// autoPlay: true,
mediacontrol: {seekbar: "#0F0", buttons: "#0F0"},
width: '100%',
height: '100%'
});
</script>
<?php } ?>
</body>
</html>