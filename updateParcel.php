<?php
require_once('config.php');


$filename = 'files/results2.json';
$json = file_get_contents($filename);
//echo $json;
$oldlist = json_decode($json);

$filename = 'files/list.json';
$json = file_get_contents($filename);
//echo $json;
$list = json_decode($json);
$idvalues= [];
$templist = [];
foreach($list as $item){
  if($item->zipcode < 10000){
      $item->zipcode = null;
  }
  foreach($oldlist as $olditem){
    if($item->id ==  $olditem->id ){
      if((int)$item->zipcode < 10000 || (int)$item->zipcode > 99999 ){
        echo " Changing $item->address $item->zipcode to $olditem->zipcode <br>";
        $item->zipcode = $olditem->zipcode;
      }
      if($olditem->parcel == null){
        echo " Changing $item->parcelID to $olditem->parcel <br>";
        $item->parcelID = $olditem->parcel;
      }
    }

  }
  if(!in_array($item->id, $idvalues))  {
    $idvalues[] = $item->id;
    $templist[] = $item;
  }
  else{
    echo "ID: $item->id is already in array ";
    //unset($item);
  }
}
$list = $templist;

var_dump($list);


writeFile($list, 'files/list.json');

 function writeFile($item, $file){
     $fp = fopen($file, 'w');
     fwrite($fp, json_encode($item) );
     fclose($fp);
 }
