<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');


include_once "../../includes/autoload.php";


// Instantiate product object can be any product
$product = new DVD();
$pt = new ProductType();
$result = null;
if (isset($_GET['sku'])) {
    $given_sku = $_GET['sku'];
    $product->setSku($given_sku);
    $result = $product->readSingle();
} else {
    // Product read query
    $result = $product->read();
}

// Get row count
$num = $result->rowCount();
// Check if any products
if ($num > 0 ) { //and isset($commands)
    // Category array
    $cat_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

        $my_row = (object)$row;
        $cat_item = $pt->getByType($my_row->type,$my_row);
        
        // Push to "data"
        $cat_arr['data'][] = $cat_item->toArray();
    }

    // Turn to JSON & output
    echo json_encode($cat_arr);

} else {
    // No Products
    echo json_encode(
        array('data' => array())
    );
}


