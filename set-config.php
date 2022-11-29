<?php
include("config.php");
if (isset($_GET["csfrtoken"]))
    echo "set csfrtoken to: " . $_GET["csfrtoken"] . " NOT IMPLEMENTED! <br>";
if (isset($_GET["sessionid"]))
    echo "set sessionid to: " . $_GET["sessionid"] . " NOT IMPLEMENTED! <br>";
//TODO: save config changes to config file somehow
?>
<html>
    <head>
        <title>Set Auth Config</title>
    </head>
    <body>
        <h1>Update Auth Config</h1>
        <li>Login at: <a href="https://server.kunasystems.com/account/profile/">https://server.kunasystems.com/account/profile/</a></li>
        <li>Get cookies from a request header like: <a href="https://server.kunasystems.com/api/v1/user">https://server.kunasystems.com/api/v1/user</a></li>
        <p>Paste the auth headers and submit...</p>
        <form action="set-config.php">
        csfrtoken: <input type="text" name="csfrtoken" value="<?php echo $config['csfrtoken']; ?>"><br/>
        sessionid: <input type="text" name="sessionid" value="<?php echo $config['sessionid']; ?>"><br/>
        <br/>
        <input type="submit">
        </form>
    </body>
</html>