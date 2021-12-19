<?php
/*
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

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo "#EXTM3U\n";
echo "#EXTINF:-1,".trim($title)."\n";
echo $stream;
?>
