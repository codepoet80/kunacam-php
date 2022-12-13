<?php
include("config.php");
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$base_url = explode("index.php", $base_url)[0];
$base_url = explode("?", $base_url)[0];
$base_url = rtrim($base_url, '/') . '/';
$data_url = $base_url . "data.php";
$image_url = $base_url . "image.php?id=";

$file_handle = fopen($data_url, "r");
if (!isset($file_handle))
        die("could not load data from " . $data_url);
$data = "";
while(!feof($file_handle)) {
    $data .= fgets($file_handle);
}
fclose($file_handle);
if ($data != "")
    $data_obj = json_decode($data);
    if (!isset($data_obj)) {
        die("Could not parse JSON: " . json_last_error_msg());
    }
    if (isset($data_obj->detail)) {
        echo("Server error: " . $data_obj->detail);
        echo("<br>");
        echo("<a href='set-config.php'>Update Auth Cookies</a>");
    }
else {
?>
<html>
    <head>
        <title>Kuna Cameras</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
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
