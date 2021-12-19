<?php
/*
Player Generated From https://demo.kodi.al/My_Tools/Players_Tools/Player_Builder/JW_Player/
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
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
<link rel="icon" href="https://kodi.al/panel.ico"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="JW Player Code Builder" />
<meta name="author" content="Olsion Bakiaj - Endrit Pano" />
<meta property="og:site_name" content="JW Player Code Builder">
<meta property="og:locale" content="en_US">
<meta name="msapplication-TileColor" content="#0F0">
<meta name="theme-color" content="#0F0">
<meta name="msapplication-navbutton-color" content="#0F0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#0F0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<!-- Include CDN Player --/>
<script src="https://content.jwplatform.com/libraries/Jq6HIbgz.js"></script>
<!-- Include CDN Player -->
<script type="text/javascript" src="https://content.jwplatform.com/libraries/Jq6HIbgz.js"></script>

<style type="text/css">
#player{position:absolute;width:100%!important;height:100%!important;}
</style>
<!-- EXTRA CSS -->
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
<!-- EXTRA CSS -->
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
<!-- Player Configuration Reference --/>
https://developer.jwplayer.com/jwplayer/docs/jw8-player-configuration-reference
<!-- Player Configuration Reference -->
<!-- Include Player DIV id [Default player] -->
<div id="player"></div>
<script>
<!-- Include Player Instance [Default player] -->
jwplayer("player").setup({
playlist: [
    {
    image: "https://png.kodi.al/tv/albdroid/logo_bar.png",
    sources: [ 
    {
		file:"<?php echo $stream ?>",
	}, 
    ] 
    }
	],
/* LOGO POSITIONS
top-right
bottom-left
bottom-right
bottom-left
*/
logo: {
    file: "https://png.kodi.al/tv/albdroid/logo_bar.png",
    position: "top-right"
},

skin: {
    name: "netflix",
// TO LOAD COLORS FROM CSS SKINS CLOSE THE 3 LINES IN EXTRA CONTROLS COLOR
// EXTRA CONTROLS COLOR
    active: "#0F0",
    inactive: "#0F0",
    background: "transparent"
// EXTRA CONTROLS COLOR
},

/* STRETCHING OPTIONS
RESOLUTION
stretching = object-fit
none =none
exactfit = fill
fill = cover
uniform	= contain*
*/
    //stretching: "uniform",
    stretching: "uniform",
    controls: true,
    displaytitle: true,
    fullscreen: "true",
    height: "100%",
    width: "100%",
    fallback: false,
    repeat: true,
    autostart: false, 
    //primary: "flash",
    primary: "html5",
    aspectratio: "16:9",
    renderCaptionsNatively: false,
    abouttext: "Albdroid",
    aboutlink: "http://albdroid.al/",
    mute: false
});
</script>

<?php }else{ ?>
<!-- ANDROID PLAYER -->
<!-- Include Player DIV id [Default player] -->
<div id="player"></div>
<script>

<!-- Include Player Instance [Default player] -->
jwplayer("player").setup({
<!--  YOU CAN SET DIFFERENT SOURCE FOR ANDROID DEVICES HERE  -->
playlist: [
    {
    image: "https://png.kodi.al/tv/albdroid/logo_bar.png",
    sources: [ 
    {
		file: "<?php echo $stream ?>",
	}, 
    ] 
    }
	],
/* LOGO POSITIONS
top-right
bottom-left
bottom-right
bottom-left
*/
logo: {
    file: "https://png.kodi.al/tv/albdroid/logo_bar.png",
    position: "top-right"
},

skin: {
    name: "netflix",
// TO LOAD COLORS FROM CSS SKINS CLOSE THE 3 LINES IN EXTRA CONTROLS COLOR
// EXTRA CONTROLS COLOR
    active: "#0F0",
    inactive: "#0F0",
    background: "transparent"
// EXTRA CONTROLS COLOR
},

/* STRETCHING OPTIONS
RESOLUTION
stretching = object-fit
none =none
exactfit = fill
fill = cover
uniform	= contain*
*/
    //stretching: "uniform",
    stretching: "uniform",
    controls: true,
    displaytitle: true,
    fullscreen: "true",
    height: "100%",
    width: "100%",
    fallback: false,
    repeat: true,
    autostart: false, 
    //primary: "flash",
    primary: "html5",
    aspectratio: "16:9",
    renderCaptionsNatively: false,
    abouttext: "Albdroid",
    aboutlink: "http://albdroid.al/",
    mute: false
});
</script>
<?php } ?>
</body>
</html>