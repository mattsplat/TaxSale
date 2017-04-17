<?php
require_once('config.php');




$total = count($list);
$newcsv = "files/TaxSaleList.csv";
$newlist = csv_to_array($newcsv, ',');

// var_dump($newlist);
$keeplist = [];
foreach($list as $item){
   foreach($newlist as $newitem){
        //$parcel = explode( '/' , $newitem['Parcel / Reference ']); //parcel
        // if($parcel[0] == $item->parcel ){
        //     $keeplist[] = $item;
        // }
        $id = $newitem['Action Number'];
        if($id == $item->id ){
            $keeplist[] = $item;
        }
   }
}

//find duplicates

writeFile($keeplist, 'files/results.json');
echo file_get_contents('results.json');

function writeFile($item, $file){
    $fp = fopen($file, 'w');
    fwrite($fp, json_encode($item) );
    fclose($fp);
}
