<?php
Class Property{
    public $id;
    public $address;
    public $city;
    public $zipcode;
    public $price;
    public $type;
    public $lat = 0; //latitude
    public $lng = 0; //longitude
    public $parcelID;

    function __construct($id, $address, $city, $zipcode, $price, $type){
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->price = $price;
        $this->type = $type;
    }

}