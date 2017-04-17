<?php
require_once('config.php');

$oldarray = array('Action Number',
  'Address', 'Improvements', 'City, State, Zip', 'Minumum Bid Amount');
$newarray = array('Parcel / Reference ',
  'COA #','Legal Description','Address', 'Code','Taxes Owed for Sale 337');
// read csv file create list
$list =  csv_to_array('files/TaxSaleList.csv', ',');
// get list format to determine where to send it
$listcolumns = [];
foreach($list[0] as $column => $value){
  $listcolumns[] = $column;

}
if(compareArray($listcolumns, $oldarray) ){
  $list= arrayToProperty($list);
}
elseif (compareArray($listcolumns, $oldarray)) {
  $list= oldarrayToProperty($list);
}


$filename = 'files/list.json';
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

}
writeFile($list, $filename);

// take array encode as json and write to file
function writeFile($item, $file){
    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($item) );
    fclose($fp);
}

// compare 2 arrays return bool
function compareArray($arr1, $arr2){
  if($len = count($arr1) == count($arr2)){
    for($i = 0; $i < $len; $i++){
      if($arr1[$i] != $arr2[$i]){
        return false;
      }
    }
    return true;
  }
  return false;
}
