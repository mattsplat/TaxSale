<?php
/**
* @link http://gist.github.com/385876
*/
include('libraries/geocode.php');


$sort_options= array('minimum' => 'compareMinimum', 'zipcode' => 'compareZip', 'type'=> 'compareImprovement') ;

// geet csv file and convert to array
function csv_to_array($filename, $delimiter)
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 8000, $delimiter)) !== FALSE)
        {
            if(!$header){
                $header = $row;
              }
            else{
              if(count($header) != count($row)){
                echo "<br> header count == ".count($header) ."<br>";
                var_dump($header);
                echo "<br> row count == ".count($row) ."<br>";
                var_dump($row);
              }
              $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }
    return $data;
}
// convert array to Prorperty objects Property($id, $address, $city, $zipcode, $price, $type)
//old csv function
function oldarrayToProperty($list){
    $properties = [];

    foreach($list as $item){
        $property = new Property(
            $item['Action Number'],
            $item['Address'],
            removeZipcode($item['City, State, Zip']) , //city state
            extractZipcode($item['City, State, Zip']),  //zipcode
            preg_replace('/([^0-9\.])/', '' , $item['Minumum Bid Amount']),
            $item['Improvements']
        );

        $properties[]= $property;
    }
    return $properties;
}
// new function
function arrayToProperty($list){
    $properties= [];
    foreach($list as $item){
        if($item["COA #"] != null){

            $property = new Property(
                $item["COA #"], //id
                $item["Address"], //address
                $item["Legal Description"], //city
                null, //zip
                $item["Taxes Owed for Sale 337"], //price
                $item["Code"] //type
            );
            // get parcel ID
            if(isset($item['Parcel / Reference '])){
              $parcel = explode( '/' ,$item['Parcel / Reference ']); //parcel
              $property->parcelID = $parcel[0];
            }
            /// need to fix reg ex for addresses
            $property->address = str_replace( ')', '', str_replace('(Approx .Add. ', '', $property->address) );// address
            $property->address = preg_replace('/[ & ].[0-9]{2,6}/', '', $property->address);
            $property->address = preg_replace('/[,]/', '', $property->address);

            preg_match('/(Kansas City)|(Bonner Springs)|(Edwardsville)/', $property->city, $matches);// city
            if(isset($matches[0])){
                $property->city = $matches[0];
            }
            else{
                $property->city = 'Kansas City';
            }
            preg_match('/([$][0-9,]{1,8}[.][0-9]{2})/', $property->price , $matches);// price
            if(isset($matches[0])){
                $property->price = $matches[0];
                $property->price = preg_replace('/([^0-9\.])/', '' , $property->price);
            }
            $property->type =  preg_replace('/[\( \)]/', '', $property->type);// type

            //$property = getGeocode($property);

            displayProperty($property);
            $properties[] = $property;
        }
    }
    displayProperty($property);
    return $properties;
}
// get and set geocode iinfo
function getGeocode($property){
    $geocode = lookup($property->address.'+'.$property->city);// geocode
    $property->zipcode = $geocode['zipcode'];
    $property->lat = $geocode['latitude'];
    $property->lng = $geocode['longitude'];
    return $property;
}

// display for testing
function displayProperty($property){
  echo "id = $property->id  <br>
        address = $property->address <br>
        city = $property->city <br>
        zipcode = $property->zipcode <br>
        price = $property->price <br>
        type = $property->type <br>
        lat = $property->lat<br>
        long = $property->lng <br>
        <hr>
        ";
}

//write to json
function writeJson($jsonlist, $file){
    $jsonlist =  json_encode($jsonlist);
    $fp = fopen($file, 'w');
    fwrite($fp, $jsonlist);
    fclose($fp);
}


// remove zipcode from city state array
function removeZipcode($address){
    return preg_replace('/\d{5}(-\d{4})?\b/', '' , $address) ;
}


function getUniqueZipcodes($list){
    $zipcodes = [];
    foreach($list as $item){
        if($item->zipcode != null) {
        $zipcodes[] =$item->zipcode;
        }
    }
    $zipcodes =  array_unique($zipcodes);
    sort($zipcodes);
    return $zipcodes;
}

//get only the zipcode from city state array
function extractZipcode($address){
    if( preg_match('/\d{5}(-\d{4})?\b/', $address, $matches) ){
    return $matches[0];
    }

}


function listByZipcode($list){

    $sortedByZip = [];
    $zipcodes = getUniqueZipcodes($list);
    foreach($list as $item){
        foreach($zipcodes as $zip){
            if($item->zipcode == $zip){
                $sortedByZip[] = $item;
            }
        }
    }
    // foreach($zipcodes as $zip){
    //     foreach($list as $item){
    //         if($item->zipcode == $zip){
    //             $sortedByZip[] = $item;
    //         }
    //     }
    // }
    return $sortedByZip;
}

//get list sort by zipcode then return sorted list

function compareZip($a, $b){
    $aZip = (int)$a->zipcode;
    $bZip = (int)$b->zipcode;
    if($aZip == $bZip ){
        return 0;
    }
    if($aZip < $bZip ){
        return -1;
    }
    else{
        return 1;
    }
}

// sort by minimum

function compareMinimum($a, $b){
    $aMin = $a->price;
    $bMin = $b->price;

    if($aMin == $bMin){
        return 0;
    }
    return ($aMin < $bMin) ? -1 : 1;
}

// sort by type of Improvement

function compareImprovement($a, $b){
    $aImp = $a->type;
    $bImp = $b->type;
    if($aImp == $bImp){
        return 0;
    }
    return ($aImp < $bImp) ? -1 : 1;

}


//sort all
function sortList($list, $option){

    usort($list, $option);
    return $list;
}

// get number per zipcode
function totalPerZipcode($list){
    $zipcodes_unique = getUniqueZipcodes($list);
    $ziptotals = [];
    foreach($list as $item){
        foreach( $zipcodes_unique as $zip){
            if($item->zipcode == $zip){
                if(!isset($ziptotals[$zip])){
                    $ziptotals[$zip] = 0;
                }
                $ziptotals[$zip] += 1;
            }
        }
    }
    return $ziptotals;
}

// get all types
function getTypes($list){
    $types= [];
    foreach($list as $item){
        $types[] = $item->type;
    }
    $types = array_unique($types);
    return $types;
}

// get number per type
function totalByType($list){
    $type_total= [];
    foreach($list as $item){
        if(!isset($type_total[$item->type])){
            $type_total[$item->type] = 0;
        }
        $type_total[$item->type]++;
    }
   return ($type_total);
}

// get median
function getAverage($list){
    return round(allMinimumTotal($list)/count($list), 2);
}
//get total minimum bid
function allMinimumTotal($list){
    $total = 0;
    foreach($list as $item){
        $total += $item->price;
    }
    return round($total,2);
}
//get highest
function getHighest($list){
    $high = 0;
    foreach($list as $item){
        $value = getMin($item);
        if($value > $high){
            $high = $value;
        }
    }
    return $high;
}
//get lowest
function getLowest($list){
    $low = 1000000000;
    foreach($list as $item){
        $value = $item->price;
        if($value < $low){
            $low = $value;
        }
    }
    return $low;
}
//get minimumBids into 10k groups
function getSortedTotals($list){
    $totals = array('under 1000'=> 0,'1001 to 2500' => 0,'2501 to 5000' => 0,'5001 to 10000' =>0,'10001 to 20000' => 0,'20001 to 30000' => 0, 'over 30000' => 0);
    foreach($list as $item){
        $price = $item->price;
        switch($price){
            case ($price < 1000):
                $totals['under 1000']++;
                break;
            case ($price < 2501):
                $totals['1001 to 2500']++;
                break;
            case ($price < 5001):
                $totals['2501 to 5000']++;
                break;
            case ($price < 10001):
                $totals['5001 to 10000']++;
                break;
            case($price < 20001):
                $totals['10001 to 20000']++;
                break;
            case($price < 30001):
                $totals['20001 to 30000']++;
                break;
            case($price > 30000):
                $totals['over 30000']++;
                break;
        }
    }
    return $totals;
}

//format currency output
function toMoney($val,$symbol='$',$r=2)
{
    $n = (int)$val;
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r);
    $j = (($j = count($i)) > 3) ? $j % 3 : 0;

   return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

}

// format Minimum value to int
function getMin($item){
    return  $item->price;
}

// Match Zipcode
function matchZipcode($list, $zip){
    $matches = [];
    foreach($list as $item){
        if($item->zipcode == $zip){
            $matches[] = $item;
        }
    }
    return $matches;
}

// Match Type
function matchType($list, $type){
    $matches = [];
    foreach($list as $item){
        if($item->type == $type){
            $matches[] = $item;
        }
    }
    return $matches;
}

// Match Id
function matchID($list, $id){
    foreach($list as $item){
        if($id == $item->id){
            return $item;
        }
    }
}

//get Icon
function getIcon($property){
    $icons = array('V' => 'fa-tree', 'I' => 'fa-home', 'C/I' => 'fa-building-o');
    foreach($icons as $type => $icon){
        if($property->type == $type){
            return $icon;
        }
    }
    return 'fa-building'; //default
}
?>
