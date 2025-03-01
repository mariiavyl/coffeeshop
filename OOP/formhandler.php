<?php
include 'product.php';

if(isset($_POST['price']) && !empty($_POST['price'])){
    $price = $_POST['price'];
    $name = $_POST['name'];
    $manufacturer = $_POST['manufacturer'];
    $description = $_POST['description'];


$product = new Product($name, $manufacturer, $price, $description);

echo "<table border = '1'>
<tr>
<th>Name</th> 
<th>Manufacturer</th> 
<th>Price</th> 
<th>Price including tax (25.5%)</th> 
<th>Description</th> 
</tr>

<tr>
    <td>" . $product->get_name() . "</td>
    <td>" . $product->get_manufacturer() . "</td>
    <td>" . $product->get_price() . " €</td>
    <td>" . $product->price_modifier(25) . " €</td>
    <td>" . $product->get_description() . "</td>
    </tr>
    </table>";
} else {
    echo "Price is an important value!";
}

?>
