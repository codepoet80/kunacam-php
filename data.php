<?php
include("config.php");

function get_data($url, $config){
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
$url = "https://server.kunasystems.com/api/v1/user/cameras/";
header('Content-type: application/json');
echo get_data($url, $config);
?>
