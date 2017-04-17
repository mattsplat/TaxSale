<?php
require_once('csvConvert.php');
require('libraries/Property.php');


$filename = 'list.json';
$json = file_get_contents($filename);
//echo $json;
$list = json_decode($json);
$total = count($list);
$cnt = 1;
set_time_limit(300);
foreach($list as $item){
    $item->price = preg_replace('/([^0-9\.])/', '' , $item->price);
    $item->address = preg_replace('/[ & ]+[0-9]{3,6}/', '', $item->address);
    if($item->lat == null){
    $item = getGeocode($item);
    sleep(0.5);
    echo "$cnt of $total <br>";
   }

    $cnt++;
    // if($cnt > 10 ){
    //     break;
    // }

}
writeFile($list, 'list.json');


function writeFile($item, $file){
    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($item) );
    fclose($fp);
}
