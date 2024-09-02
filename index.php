<?php
include("config.php");
$url = "https://server.kunasystems.com/api/v1/user/cameras/";

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$base_url = explode("index.php", $base_url)[0];
$base_url = explode("?", $base_url)[0];
$base_url = rtrim($base_url, '/') . '/';
$data_url = $base_url . "data.php";
$image_url = $base_url . "image.php?id=";

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
$data = get_data($url, $config);
if (!isset($data))
    die("Could not get data from service!");
$data_obj = json_decode($data);
if (!isset($data_obj))
    die("Could not parse JSON: " . json_last_error_msg());
if (isset($data_obj->detail)) {
    echo("Server error: " . $data_obj->detail);
    echo("<br>");
    echo("<a href='set-config.php'>Update Auth Cookies</a>");
} else {
?>
<html>
    <head>
        <title>Kuna Cameras</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png" />
        <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-touch-icon-152x152.png" />
        <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon-180x180.png" />
        <script>
            var rate = <?php echo $config['refresh'];?>;
            function imgReady(id) {
                console.log(id + " is ready!");
                var spinner = document.getElementById("spinner-" + id);
                spinner.style.display = "none";
                setTimeout (
                    function(id) {
                        console.log("timeout fired for " + id);
                        var cam = document.getElementById("cam-" + id);
                        var spinner = document.getElementById("spinner-" + id);
                        var d=new Date();
                        cam.src = cam.title + "&time=" + d.getTime();
                        spinner.style.display = "inline";
                    }, rate, id
                )
            }
        </script>
    </head>
    <body>
        <h1><img src="icon.png"><br>Kuna Cameras</h1>
        <div class="row">
        <?php
        foreach($data_obj->results as $camera) {
            $this_img = $image_url . $camera->serial_number;
        ?>
            <div class="column">
                <p align="center">
                    <span class="camera-name"><?php echo $camera->name; ?></span><br>
                    <img class="camera" id="cam-<?php echo $camera->serial_number ?>" onload="imgReady('<?php echo $camera->serial_number ?>');" title="<?php echo $this_img; ?>" src="<?php echo $this_img; ?>">
                    <img class="spinner" id="spinner-<?php echo $camera->serial_number ?>" src="spinner.gif">
                </p>

            </div>
        <?php
        }
        ?>
        </div>
    </body>
</html>
<?php
}
?>
