<?php
include("config.php");

if (isset($_GET["id"]))
	$camid = $_GET["id"];
else
	die("No camera id specified, use ?id= in the query string");

function get_image($url, $config){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: csrftoken=" . $config['csfrtoken'] . "; sessionid=" . $config['sessionid']));

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
$img = 'https://server.kunasystems.com/api/v1/cameras/' . $camid . '/thumbnail/';
header('Content-type: image/jpeg');
echo get_image($img, $config);
?>
