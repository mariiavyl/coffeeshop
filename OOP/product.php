<?php
class Product {
    private $name;
    private $manufacturer;
    private $price;
    private $description;


public function __construct($name, $manufacturer, $price, $description) {
    $this->name = $name;
    $this->manufacturer = $manufacturer;
    $this->price = floatval($price);
    $this->description = $description;
}
    
   public function get_name() {
    return $this->name;
    }
    
   public function get_manufacturer() {
    return $this->manufacturer;
    }
    
    public function get_price() {
    return $this->price;
    }

   public function get_description() {
    return $this->description;
    }

   public function price_modifier($feePercent) {
        $fee = $this->price * (floatval($feePercent)/100);
        return $fee + $this->price;
   }
}
?>

