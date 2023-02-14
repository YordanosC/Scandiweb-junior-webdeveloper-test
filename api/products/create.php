<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../includes/autoload.php';
include_once '../../config/Database.php';
include_once  '../../config/command.php';


$data = json_decode(file_get_contents("php://input"));

// Instantiate product object can be any product for check the existence
$prod = new DVD();
$result = null;

if(isset($commands)){
    $product = $commands[$data->type]($data);

    // check sku uniqueness
    $given_sku = $data->sku;
    $prod->setSku($given_sku);
    $result = $prod->readSingle();

    //Create Product
    if($result->rowCount() == 0){
        if($product->create()){
            echo json_encode(
                array('message' => 'product Created successfully')
            );
        }else{
            http_response_code(400);
            echo json_encode(
                array('message' => 'product Not Created')
            );
        }
    } else{
        echo json_encode(
            array('message' => 'product not created b/c SkU is exist')
        );
    }
}
else {
    echo "Not set";
}