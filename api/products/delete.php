<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once  "../../includes/autoload.php";
include_once "../../config/Database.php";

$data = json_decode(file_get_contents("php://input"));

// Instantiate product object can be any product
$product = new DVD();

foreach ($data->skus as $skus) {
    $product->setSku($skus);
    if (!$product->delete()) {
        json_encode(
            array('message' => 'Failed deleting ' . $skus)
        );
        exit();
    }
}

echo json_encode(
    array('message' => 'Data successfully deleted!')
);