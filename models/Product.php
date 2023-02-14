<?php
abstract class Product
{
    // Product Properties
    protected $sku;

    protected $name;

    protected $price;

    // Database Conn
    protected $conn;

    public function __construct()
    {
        $instance = Database::getInstance();
        $this->conn = $instance->getConnection();
    }

    abstract function getType();

    abstract function create(): bool;

    public function getTableName(): string
    {
        return "Products";
    }

    public function getPrimaryKey(): string
    {
        return "sku";
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = Sanitizer::sanitize($sku);
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = Sanitizer::sanitize($name);
    }

    public function getPrice()
    {
        return $this->price;
    }


    public function setPrice($price)
    {
        $this->price = Sanitizer::sanitize($price);
    }

    public function toArray(): array
    {
        return [
            "sku" => $this->getSku(),
            "name" => $this->getName(),
            "price" => $this->getPrice(),
            "type" => $this->getType(),
        ];
    }

    /**
     * read all products from DB
     * @return false
     */
    public function read()
    {
        $query = 'SELECT * from ' . $this->getTableName();

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }


    /**
     * read all products from DB
     * @return false|PDOStatement
     */
    public function readSingle()
    {
        $query = 'SELECT * from ' . $this->getTableName() . ' WHERE ' . $this->getPrimaryKey() . ' = :sku';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':sku', $this->sku);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
    /**
     * delete a product by sku
     * @return bool
     */
    public function delete(): bool
    {
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE ' . $this->getPrimaryKey() . ' = :sku';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':sku', $this->sku);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}