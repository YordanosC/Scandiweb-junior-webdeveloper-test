<?php
class ProductType {
    public function getType($type,$data) {
        switch ($type){
            case "DVD":
                $dvd = new DVD();
                $dvd->setName($data->name);
                $dvd->setSize($data->size);
                $dvd->setPrice($data->price);
                $dvd->setSku($data->sku);                
                return $dvd;
                break;
            case "BOOK";
                $book = new Book();
                $book->setName($data->name);
                $book->setWeight($data->weight);
                $book->setPrice($data->price);
                $book->setSku($data->sku);                
                return $book;
                break;
            case "FURNITURE";
                $furniture = new Furniture();
                $furniture->setName($data->name);
                $furniture->setHeight($data->height);
                $furniture->setLength($data->length);
                $furniture->setWidth($data->width);
                $furniture->setPrice($data->price);
                $furniture->setSku($data->sku);                
                return $furniture;
                break;
            default:
                # code...
                break;
        }
    }
}

