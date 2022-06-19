<?php
// alert error
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

header("Content-Type: application/xml;  charset=utf-8");
// inlcude libraries
require_once("libraries/fsrouter.php");

include("includes/config.php");
include("includes/functions.php");
include("includes/defines.php");

include("libraries/database/pdo.php");
$db = new FS_PDO();

include("libraries/sitemap/sitemap.php");

$sitemap = new SITEMAP();
$header = '<?xml version="1.0" encoding="UTF-8"?>';
echo $header;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
<?
    echo $sitemap->GetFeed();
?>
</urlset>