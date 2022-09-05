<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include 'functions.php';
$password = 'Jona Ganteng';
header('Access-Control-Allow-Origin: *');

if(!empty($_GET['path'])) {
    $url = 'https://www.mediafire.com' . json_decode(decrypt($_GET['path'], $password))->path;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE,true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $output = curl_exec($ch);
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($output);
    libxml_clear_errors();
    $hrefValue = $doc->getElementById('downloadButton')->getAttribute("href"); 
    curl_close($ch); 

    ini_set("max_execution_time", 0);
    $stream = new VideoStream($hrefValue);
    $stream->start();
} else {
    header("HTTP/1.1 403 Forbidden" );
    exit;
}