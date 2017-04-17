<?php
//match zipcode to csv file to get gps coords
function getZipcodeCoords($zip, $filename, $delimiter)
{
    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = $row;
            else
                
                $data = array_combine($header, $row);
                foreach($data as $value){
                    if($value == $zip){
                        return $data;
                    }
                }
                
        }
        fclose($handle);
    }
    return $data;
}

// create array of coords for properties that match zip code 
function makeMapList($list, $zip){
    
    $list = matchZipcode($list, $zip);
    foreach($list as $item){
        if($item != null){
            $mapitem["lat"] = $item->lat;
            $mapitem["lng"] = $item->lng;
            $mapitem["price"] = $item->price;
            $mapitem["address"] = $item->address;
            $mapitem["zip"]  = $item->zipcode; 
            $mapitem['type'] = $item->type;
            $mapitem['id'] = $item->id;        
            $maplist[] = $mapitem;
        }
        else{
            echo $item->address.' Not Found <br>';
        }
    }
    return $maplist;
}