<?php

header('Access-Control-Allow-Origin: *');

/* [Fungsi] */
include 'functions.php';
require "vendor/autoload.php";
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

/* [variables] */
$password_salt = 'Jona Ganteng';

if(!empty($_GET['zp'])) {
  /*$parse = parse_url($_GET['url']);
  $host  = $parse['host'];
  $get_id = explode('/',$parse['path'])[2];
  $create_fakeDL = 'https://' . $host . '/d/' . $get_id . '/123/jancox';
  $html =  file_get_contents($create_fakeDL);*/

  /* [Buat Dom] */
  $url = urldecode(json_decode(decrypt($_GET['zp'], $password_salt))->url);
  $html = file_get_contents($url);
  $dom = new Dom;
  $dom->setOptions(
    (new Options())
    ->setRemoveScripts(false)
  );
  $dom->loadStr($html);

  // [Cari Script]
  $scripts = $dom->find('script');
  $array_script;
  $find = "Math.pow";
  foreach ($scripts as $script) {
    if(strpos($script->text, $find) !== false) {
      $array_script = $script;
    }
  }

  // [Cari title]
  $metas = $dom->find('meta');
  $title;
  foreach ($metas as $meta) {
    if($meta->getAttribute('property') !== false) {
      if($meta->getAttribute('property') === 'og:title') {
        $title = $meta->getAttribute('content');
      }
    }
  }

  // [settingan menyesuaikan logika zippyshare, mungkin sewaktu" bisa berubah]
  $text = $array_script->text;
  $regex = '/var a =(.*); document.getElementById\(\'dlbutton\'\).omg(.*)/s';
  $get_id = preg_replace($regex,'$1', $text);
  $substring = substr('asdasd',0 , 3);
  $length = strlen($substring);
  $id_pow = pow($get_id, 3) + $length;

  // [setelah menemukan hasil dari pow, buat link DL]
  $parse = parse_url($_GET['url']);
  $host  = $parse['host'];
  $get_id = explode('/',$parse['path'])[2];
  $link_DL = 'https://'.$host.'/d/'.$get_id.'/'.$id_pow.'/'.rawurlencode(trim($title));

  // [Buat Link Streaming]
  ini_set("max_execution_time", 0);
  $stream = new VideoStream($decode->url);
  $stream->start();
} else {
  header("HTTP/1.1 403 Forbidden" );
  exit;
}
