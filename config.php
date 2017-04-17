<?php
require_once('csvConvert.php');
require('libraries/Property.php');
include('helpers/mapHelper.php');

//$list =  csv_to_array('files/tax.csv', ',');
$list = file_get_contents('files/list.json');

//$list = arrayToProperty($list);
$list = json_decode($list);
$zipcodes = getUniqueZipCodes($list);
$types = getTypes($list);
