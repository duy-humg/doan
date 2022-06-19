<?php
//https://console.developers.google.com/project/793789377424/apiui/credential
// create project -> Credentials -> Create OAuth
// Chú ý dấu cách
// robocon@
set_include_path(PATH_BASE."libraries/google-api-php/" . PATH_SEPARATOR . get_include_path());
require_once 'Google/Client.php';
$client_id = '1076435412219-fmur45teld407e00shpa0ru164hbm1kq.apps.googleusercontent.com';
$client_secret = 'LChF2KDVQbF-OEraFYcsbkKl';
$redirect_uri = URL_ROOT.'oauth2callback';
