<?php


class Book extends Product
{
    private $weight;


    public function getWeight()
    {
        return $this->weight;
    }


    public function setWeight($weight)
    {
        $this->weight = Sanitizer::sanitize($weight);
    }


    function getType()
    {
        return "BOOK";
    }

    function create(): bool
    {
        $query = 'INSERT INTO ' . $this->getTableName() . ' SET sku = :sku, name = :name, price = :price, type= :type, weight = :weight';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        $successful = $stmt->execute([
            ":sku" => $this->getSku(),
            ":name" => $this->getName(),
            ":price" => $this->getPrice(),
            ":type" => $this->getType(),
            ":weight" => $this->getWeight()
        ]);

        // Execute query
        if ($successful) {
            return true;
        }
        return false;
    }

    public function toArray(): array
    {
        $from_parent = parent::toArray();
        $from_parent["weight"] = $this->getWeight();
        return $from_parent;
    }
}