<?php

class DVD extends Product
{
    private $size;

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    function getType()
    {
        return "DVD";
    }

    function create(): bool
    {
        $query = 'INSERT INTO ' . $this->getTableName() . ' SET sku = :sku, name = :name, price = :price, type= :type, size = :size;';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $successful = $stmt->execute([
            ":sku" => $this->getSku(),
            ":name" => $this->getName(),
            ":price" => $this->getPrice(),
            ":type" => $this->getType(),
            ":size" => $this->getSize()
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
        $from_parent["size"] = $this->getSize();
        return $from_parent;
    }
}