<?php

// require_once('csvConvert.php');
// require('libraries/Property.php');

// $list =  csv_to_array('files/TaxSaleList.csv', ',');
// $parcel = explode('/', $list[1]['Parcel / Reference ']);
// print_r($parcel[0]);
// $filename = 'test.json';
// $jsonlist = file_get_contents($filename);
// $jsonlist = json_decode($jsonlist);
// foreach($jsonlist as $item){
//     foreach($list as $csvitem){
//         if($item->id == $csvitem["COA #"]){
//             echo "<br>".$item->id." == ".$csvitem['COA #'];
//             $parcel = explode( '/' ,$csvitem['Parcel / Reference ']);
//             $item->parcelID = $parcel[0];
//             echo "<br>ParcelID =  $item->parcelID " ;
//         }
//     }
// }
// writeJson($jsonlist, 'test.json');


$csv = file_get_contents('http://mattsplat.net/projects/taxsale/files/tax.csv');


//$csv = csv_to_array("\n", $contents);
$rows = array_map('str_getcsv', explode("\n", $csv) );
$header = array_shift($rows);
$csv = array();
foreach ($rows as $row) {
   if(count($header) == count($row)){
    $csv[] = array_combine($header, $row);
   }
}
var_dump($csv);
//var_dump($csv);
// function csv_to_array($filename, $delimiter)
// {    

//     $header = NULL;
//     $data = array();
//     if (($handle = ($filename)) !== FALSE)
//     {
//         while (($row = str_getcsv($handle, 1000, $delimiter)) !== FALSE)
//         {
//             if(!$header)
//                 $header = $row;
//             else
//                 $data[] = array_combine($header, $row);
//         }
//         fclose($handle);
//     }
//     return $data;
// }