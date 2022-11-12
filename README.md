# kunacam-php

![App Icon](icon.png)

A simple web app for viewing images from your Kuna cameras. Images update automatically, based on an interval you configure, and whenever Kuna decides to update on their end. Note that this web app can't log you into Kuna -- you'll have to do that, then share the cookies with the app. Instructions below.

## Requirements

+ php
+ php-curl

## Setup

With thanks to [https://github.com/loghound/kuna-camera-api](https://github.com/loghound/kuna-camera-api)

Copy the file `config-example.php` to `config.php`

Visit [https://server.kunasystems.com/api/v1/user/cameras/](https://server.kunasystems.com/api/v1/user/cameras/) in your favorite browser and observe the error. If you'd like, turn on Developer tools and view the Request headers.

Open a new tab in the same browser, visit [https://server.kunasystems.com/account/profile/](https://server.kunasystems.com/account/profile/) and sign in.

Now return to the original tab with `/cameras/` at the end of the URL. Turn on Developer tools and observe the Cookie header.

From the Cookie header of a signed in browser, extract the values for the Cookies: `csfrtoken` and `sessionid`. Paste these values into the config.php as indicated.