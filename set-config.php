<?php
include("config.php");
$changed = false;
$use_csfrtoken = $config["csfrtoken"];
if (isset($_GET["csfrtoken"]) && $_GET["csfrtoken"] != $use_csfrtoken) {
   $use_csfrtoken = $_GET["csfrtoken"];
   $changed = true;
}
$use_sessionid = $config["sessionid"];
if (isset($_GET["sessionid"]) && $_GET["sessionid"] != $use_sessionid) {
   $use_sessionid = $_GET["sessionid"];
   $changed = true;
}
if ($changed) {
   $f = fopen("config.php","rt");
   $content = fread($f, filesize("config.php"));
   @fclose($f);
   $content = str_replace($config['csfrtoken'], $use_csfrtoken, $content);
   $content = str_replace($config['sessionid'], $use_sessionid, $content);
   file_put_contents("config.php", $content);
}
?>
<html>
    <head>
        <title>Kuna - Update Auth</title>
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <h1>Update Auth Config</h1>
        <li>Login at: <a href="https://server.kunasystems.com/account/profile/" target="_blank">https://server.kunasystems.com/account/profile/</a></li>
        <li>Get cookies from a request header like: <a href="https://server.kunasystems.com/api/v1/user" target="_blank">https://server.kunasystems.com/api/v1/user</a></li>
        <p>Paste the auth headers and save...</p>
        <form action="set-config.php">
        csfrtoken: <input type="text" name="csfrtoken" value="<?php echo $use_csfrtoken; ?>" style="width: 300px"><br/>
        sessionid: <input type="text" name="sessionid" value="<?php echo $use_sessionid; ?>" style="width: 300px"><br/>
        <br/>
        <input type="submit" value="Save Changes">
        </form>
        <p><a href="./">home</a></p>
    </body>
</html>
