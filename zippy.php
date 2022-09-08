<?php

/* [Fungsi] */
include 'functions.php';

/* [Random Server] */
$server = [2000,2100,2101,2102,2103];
$item = $server[array_rand($server)];
$password_salt = 'Jona Ganteng';

header('Access-Control-Allow-Origin: *');

if(!empty($_GET['zp'])) {
  $url = json_decode(decrypt($_GET['zp'], $password_salt))->url;
  $json = file_get_contents('https://node' . $item . '.herokuapp.com/zippy?url=' . $url);
  $decode = json_decode($json);
  $extension = end(explode('.', $decode->title));
  if($extension === 'mp4') {
    /*ini_set("max_execution_time", 0);
    $stream = new VideoStream($decode->url);
    $stream->start();*/
    echo file_get_contents($decode->url);
  } else {
    echo 'Extension not mp4';
  }
} else {
  header("HTTP/1.1 403 Forbidden" );
  exit;
}
