<?php
$book = function ($data) {
    $book = new Book();
    $book->setName($data->name);
    $book->setWeight($data->weight);
    $book->setPrice($data->price);
    $book->setSku($data->sku);

    return $book;
};

$furniture = function ($data) {
    $furniture = new Furniture();
    $furniture->setName($data->name);
    $furniture->setHeight($data->height);
    $furniture->setLength($data->length);
    $furniture->setWidth($data->width);
    $furniture->setPrice($data->price);
    $furniture->setSku($data->sku);

    return $furniture;
};

$dvd = function ($data) {
    $dvd = new DVD();
    $dvd->setName($data->name);
    $dvd->setSize($data->size);
    $dvd->setPrice($data->price);
    $dvd->setSku($data->sku);

    return $dvd;
};
/**
 * based on command design pattern
 * store product type with appropriate product method
 * (product method): used to initialize a product with user data
 */
$commands = ["DVD" => $dvd, "BOOK" => $book, "FURNITURE" => $furniture];