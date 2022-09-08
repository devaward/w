<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* [Fungsi] */
include 'functions.php';

/* [Random Server] */
$server = [2000,2100,2101,2102,2103];
$item = $server[array_rand($server)];
$password_salt = 'Jona Ganteng';

header('Access-Control-Allow-Origin: *');

if(!empty($_GET['zp'])) {
  $url = json_decode(decrypt($_GET['zp'], $password))->url;
  $json = file_get_contents('https://node' . $item . '/zippy?url=' . $url);
  echo $json;
} else {
  header("HTTP/1.1 403 Forbidden" );
  exit;
}
